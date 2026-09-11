<?php 
require('checksession.php'); 
require('../inc/function.php');

// Ensure database schema has source_form and ip_address columns
if (function_exists('ensure_enquiry_table_schema')) {
    ensure_enquiry_table_schema($conn);
}

// 1. Handle CSV / Excel Export
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    $filter_status = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';
    $filter_source = isset($_GET['source']) ? mysqli_real_escape_string($conn, $_GET['source']) : '';

    $where_clauses = [];
    if ($filter_status !== '') {
        $where_clauses[] = "`status`='$filter_status'";
    }
    if ($filter_source !== '') {
        $where_clauses[] = "`source_form` LIKE '%$filter_source%'";
    }

    $where_sql = !empty($where_clauses) ? 'WHERE ' . implode(' AND ', $where_clauses) : '';
    $exp_query = mysqli_query($conn, "SELECT * FROM `tbl_enquiry` $where_sql ORDER BY `id` DESC");
    
    $filename = "stridewel_enquiries_export_" . date('Y-m-d_H-i') . ".csv";
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);
    
    $output = fopen('php://output', 'w');
    // Output UTF-8 BOM for seamless Microsoft Excel compatibility
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // CSV Header Line
    fputcsv($output, [
        'Enquiry ID',
        'Date Submitted',
        'Origin Form Source',
        'Customer Full Name',
        'Phone / WhatsApp',
        'Email Address',
        'Product / Interest',
        'Customer Message / Specifications',
        'Current Status',
        'IP Address',
        'Admin Follow-up Notes'
    ]);
    
    if ($exp_query) {
        while ($row = mysqli_fetch_assoc($exp_query)) {
            $custName = $row['full_name'] ?? $row['name'] ?? 'Website Visitor';
            $custPhone = $row['phone'] ?? '';
            $custEmail = $row['email'] ?? '';
            $custMsg = $row['message'] ?? '';
            $sourceForm = !empty($row['source_form']) ? $row['source_form'] : 'Website Form';
            $prodInterest = $row['product_interest'] ?? $row['product_name'] ?? '';
            $statusLabel = ucwords(str_replace('_', ' ', $row['status'] ?? 'pending'));

            fputcsv($output, [
                '#' . $row['id'],
                date('Y-m-d H:i:s', strtotime($row['created_at'])),
                $sourceForm,
                $custName,
                $custPhone,
                $custEmail,
                $prodInterest,
                $custMsg,
                $statusLabel,
                $row['ip_address'] ?? '',
                $row['notes'] ?? ''
            ]);
        }
    }
    fclose($output);
    exit;
}

$msg = "";
$error = "";

// 2. Handle Status & Notes Change
if (isset($_POST['update_status']) && isset($_POST['enquiry_id'])) {
    $eid = (int)$_POST['enquiry_id'];
    $new_status = mysqli_real_escape_string($conn, strtolower(trim($_POST['status'])));
    $notes = mysqli_real_escape_string($conn, trim($_POST['notes'] ?? ''));
    
    // Ensure status is one of the enum values
    $allowed_statuses = ['pending', 'in_discussion', 'quoted', 'closed'];
    if (!in_array($new_status, $allowed_statuses)) {
        $new_status = 'pending';
    }

    $up_q = mysqli_query($conn, "UPDATE `tbl_enquiry` SET `status`='$new_status', `notes`='$notes' WHERE `id`=$eid");
    if ($up_q) {
        $msg = "Enquiry #$eid details and status updated successfully.";
    } else {
        $error = "Failed to update enquiry. Database error.";
    }
}

// 3. Handle Delete
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM `tbl_enquiry` WHERE `id`=$del_id");
    $msg = "Enquiry #$del_id has been removed permanently.";
}

// 4. Filters & Search Parameters
$filter_status = isset($_GET['status']) ? mysqli_real_escape_string($conn, strtolower(trim($_GET['status']))) : '';
$filter_source = isset($_GET['source']) ? mysqli_real_escape_string($conn, trim($_GET['source'])) : '';

$where_clauses = [];
if ($filter_status !== '') {
    $where_clauses[] = "`status`='$filter_status'";
}
if ($filter_source !== '') {
    $where_clauses[] = "`source_form` LIKE '%$filter_source%'";
}

$where_sql = !empty($where_clauses) ? 'WHERE ' . implode(' AND ', $where_clauses) : '';
$enquiries = mysqli_query($conn, "SELECT * FROM `tbl_enquiry` $where_sql ORDER BY `id` DESC");

// 5. Aggregate Analytics Counts
$cnt_all = 0;
$cnt_pending = 0;
$cnt_discussion = 0;
$cnt_quoted = 0;
$cnt_closed = 0;
$cnt_contact_form = 0;
$cnt_popup_modal = 0;
$cnt_product_quote = 0;

if ($conn) {
    if ($res = mysqli_query($conn, "SELECT count(*) as c FROM `tbl_enquiry`")) {
        $cnt_all = mysqli_fetch_assoc($res)['c'] ?? 0;
    }
    if ($res = mysqli_query($conn, "SELECT count(*) as c FROM `tbl_enquiry` WHERE `status`='pending'")) {
        $cnt_pending = mysqli_fetch_assoc($res)['c'] ?? 0;
    }
    if ($res = mysqli_query($conn, "SELECT count(*) as c FROM `tbl_enquiry` WHERE `status`='in_discussion'")) {
        $cnt_discussion = mysqli_fetch_assoc($res)['c'] ?? 0;
    }
    if ($res = mysqli_query($conn, "SELECT count(*) as c FROM `tbl_enquiry` WHERE `status`='quoted'")) {
        $cnt_quoted = mysqli_fetch_assoc($res)['c'] ?? 0;
    }
    if ($res = mysqli_query($conn, "SELECT count(*) as c FROM `tbl_enquiry` WHERE `status`='closed'")) {
        $cnt_closed = mysqli_fetch_assoc($res)['c'] ?? 0;
    }
    // Form sources counts
    if ($res = mysqli_query($conn, "SELECT count(*) as c FROM `tbl_enquiry` WHERE `source_form` LIKE '%Contact%'")) {
        $cnt_contact_form = mysqli_fetch_assoc($res)['c'] ?? 0;
    }
    if ($res = mysqli_query($conn, "SELECT count(*) as c FROM `tbl_enquiry` WHERE `source_form` LIKE '%Popup%' OR `source_form` LIKE '%Quick Quote%'")) {
        $cnt_popup_modal = mysqli_fetch_assoc($res)['c'] ?? 0;
    }
    if ($res = mysqli_query($conn, "SELECT count(*) as c FROM `tbl_enquiry` WHERE `source_form` LIKE '%Product%'")) {
        $cnt_product_quote = mysqli_fetch_assoc($res)['c'] ?? 0;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require('includes/head.php'); ?>
<style>
/* Custom Enquiries CRM Styling */
.badge-source-contact {
    background-color: #103755 !important;
    color: #ffffff !important;
    font-size: 11px;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.badge-source-popup {
    background-color: #ed1c24 !important;
    color: #ffffff !important;
    font-size: 11px;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.badge-source-product {
    background-color: #0284c7 !important;
    color: #ffffff !important;
    font-size: 11px;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.badge-source-other {
    background-color: #64748b !important;
    color: #ffffff !important;
    font-size: 11px;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.kpi-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 16px 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.03);
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.06);
}
.kpi-number {
    font-size: 26px;
    font-weight: 800;
    line-height: 1;
    color: #0f172a;
}
.kpi-label {
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
    margin-top: 4px;
}
.kpi-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}
.export-dropdown-btn {
    background: #ffffff;
    border: 1.5px solid #103755;
    color: #103755;
    font-weight: 700;
    padding: 8px 16px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    transition: all 0.2s ease;
}
.export-dropdown-btn:hover {
    background: #103755;
    color: #ffffff;
}
</style>
<body>
	<div id="page-container" class="page-sidebar-fixed page-header-fixed show">
		<?php require('includes/header.php'); ?>
		<?php require('includes/left.php'); ?>
		
		<div id="content" class="content">
			<!-- Header Title & Export Actions -->
			<div class="d-flex flex-wrap align-items-center justify-content-between mb-4 pb-2 border-bottom">
				<div>
					<ol class="breadcrumb mb-1">
						<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
						<li class="breadcrumb-item active">Inquiry &amp; RFQ Management</li>
					</ol>
					<h1 class="page-header mb-0">
						<i class="fa-solid fa-inbox text-danger me-2"></i> Website Enquiries &amp; Lead Manager
					</h1>
					<p class="text-muted small mb-0 mt-1">
						Live incoming quotation inquiries, minimal forms, and origin form tracker with Excel / CSV exports.
					</p>
				</div>
				<div class="d-flex align-items-center gap-2 mt-3 mt-md-0">
					<!-- Downloadable CSV / Excel Export -->
					<?php 
					$exp_url = "manage-enquiries.php?export=csv";
					if ($filter_status !== '') $exp_url .= "&status=" . urlencode($filter_status);
					if ($filter_source !== '') $exp_url .= "&source=" . urlencode($filter_source);
					?>
					<a href="<?= $exp_url ?>" class="btn btn-success fw-bold px-3 shadow-sm" title="Download Excel / CSV File">
						<i class="fa-solid fa-file-excel me-1"></i> Download CSV / Excel
					</a>
				</div>
			</div>

			<!-- System Alerts -->
			<?php if ($msg != ""): ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<i class="fa-solid fa-circle-check me-2"></i> <?= $msg ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<?php if ($error != ""): ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<i class="fa-solid fa-triangle-exclamation me-2"></i> <?= $error ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<!-- Top Metrics KPI Cards -->
			<div class="row g-3 mb-4">
				<div class="col-xl-3 col-sm-6">
					<div class="kpi-card">
						<div>
							<div class="kpi-number"><?= $cnt_all ?></div>
							<div class="kpi-label">Total Inquiries</div>
						</div>
						<div class="kpi-icon" style="background: rgba(16, 55, 85, 0.1); color: #103755;">
							<i class="fa-solid fa-folder-open"></i>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-sm-6">
					<div class="kpi-card">
						<div>
							<div class="kpi-number text-danger"><?= $cnt_pending ?></div>
							<div class="kpi-label">Pending Review</div>
						</div>
						<div class="kpi-icon" style="background: rgba(237, 28, 36, 0.1); color: #ed1c24;">
							<i class="fa-solid fa-bell"></i>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-sm-6">
					<div class="kpi-card">
						<div>
							<div class="kpi-number text-primary"><?= $cnt_contact_form ?></div>
							<div class="kpi-label">Contact Us Form</div>
						</div>
						<div class="kpi-icon" style="background: rgba(2, 132, 199, 0.1); color: #0284c7;">
							<i class="fa-solid fa-envelope-open-text"></i>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-sm-6">
					<div class="kpi-card">
						<div>
							<div class="kpi-number text-success"><?= $cnt_popup_modal + $cnt_product_quote ?></div>
							<div class="kpi-label">Quote Popups &amp; Catalog</div>
						</div>
						<div class="kpi-icon" style="background: rgba(34, 197, 94, 0.1); color: #22c55e;">
							<i class="fa-solid fa-bolt"></i>
						</div>
					</div>
				</div>
			</div>

			<!-- Filter Bar: Status Tabs & Form Origin Dropdown -->
			<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
				<div class="btn-group shadow-sm">
					<a href="manage-enquiries.php<?= $filter_source ? '?source='.urlencode($filter_source) : '' ?>" class="btn btn-outline-secondary <?= ($filter_status == '') ? 'active' : '' ?>">
						All (<?= $cnt_all ?>)
					</a>
					<a href="manage-enquiries.php?status=pending<?= $filter_source ? '&source='.urlencode($filter_source) : '' ?>" class="btn btn-outline-secondary <?= ($filter_status == 'pending') ? 'active' : '' ?>">
						<i class="fa-solid fa-clock text-warning me-1"></i> Pending (<?= $cnt_pending ?>)
					</a>
					<a href="manage-enquiries.php?status=in_discussion<?= $filter_source ? '&source='.urlencode($filter_source) : '' ?>" class="btn btn-outline-secondary <?= ($filter_status == 'in_discussion') ? 'active' : '' ?>">
						<i class="fa-solid fa-comments text-primary me-1"></i> In Discussion (<?= $cnt_discussion ?>)
					</a>
					<a href="manage-enquiries.php?status=quoted<?= $filter_source ? '&source='.urlencode($filter_source) : '' ?>" class="btn btn-outline-secondary <?= ($filter_status == 'quoted') ? 'active' : '' ?>">
						<i class="fa-solid fa-file-invoice text-success me-1"></i> Quoted (<?= $cnt_quoted ?>)
					</a>
					<a href="manage-enquiries.php?status=closed<?= $filter_source ? '&source='.urlencode($filter_source) : '' ?>" class="btn btn-outline-secondary <?= ($filter_status == 'closed') ? 'active' : '' ?>">
						Closed (<?= $cnt_closed ?>)
					</a>
				</div>

				<div class="d-flex align-items-center gap-2 flex-grow-1 justify-content-md-end">
					<!-- Source Filter -->
					<select class="form-select w-auto" onchange="location = this.value;">
						<option value="manage-enquiries.php<?= $filter_status ? '?status='.urlencode($filter_status) : '' ?>" <?= empty($filter_source) ? 'selected' : '' ?>>All Form Sources</option>
						<option value="manage-enquiries.php?source=Contact<?= $filter_status ? '&status='.urlencode($filter_status) : '' ?>" <?= ($filter_source == 'Contact') ? 'selected' : '' ?>>Contact Us Form</option>
						<option value="manage-enquiries.php?source=Popup<?= $filter_status ? '&status='.urlencode($filter_status) : '' ?>" <?= ($filter_source == 'Popup') ? 'selected' : '' ?>>Quote Popup Modal</option>
						<option value="manage-enquiries.php?source=Product<?= $filter_status ? '&status='.urlencode($filter_status) : '' ?>" <?= ($filter_source == 'Product') ? 'selected' : '' ?>>Product Specific Quotes</option>
					</select>

					<!-- Live Search Box -->
					<div style="position: relative; min-width: 260px;">
						<input type="text" id="leadSearchInput" class="form-control" placeholder="Quick search name, phone, email...">
					</div>
				</div>
			</div>

			<!-- Enquiries Table Panel -->
			<div class="panel panel-inverse shadow-sm" style="border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;">
				<div class="panel-body p-0">
					<div class="table-responsive">
						<table class="table table-hover table-striped align-middle mb-0" id="leadsTable">
							<thead style="background: #103755; color: #ffffff;">
								<tr>
									<th style="width: 70px;">ID</th>
									<th style="width: 180px;">Origin Form Source</th>
									<th>Customer Contact</th>
									<th>Message / Details</th>
									<th style="width: 140px;">Date &amp; Time</th>
									<th style="width: 110px;">Status</th>
									<th style="width: 160px;" class="text-end">Quick Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php if ($enquiries && mysqli_num_rows($enquiries) > 0): ?>
									<?php while ($row = mysqli_fetch_assoc($enquiries)): ?>
										<?php 
										$clientName = $row['full_name'] ?? $row['name'] ?? 'Website Visitor';
										$clientPhone = $row['phone'] ?? '';
										$clientEmail = $row['email'] ?? '';
										$productName = $row['product_interest'] ?? $row['product_name'] ?? '';
										$sourceForm = !empty($row['source_form']) ? $row['source_form'] : 'Website Form';
										$status = strtolower($row['status'] ?? 'pending');
										
										// Clean phone for WhatsApp and tel links
										$clean_phone = preg_replace('/[^0-9]/', '', $clientPhone);
										if (strlen($clean_phone) === 10) {
											$wa_phone = '91' . $clean_phone;
										} else {
											$wa_phone = $clean_phone;
										}
										$wa_greeting = urlencode("Hello " . $clientName . ", thank you for contacting Stridewel International regarding your inquiry.");
										$mail_subject = urlencode("Stridewel International Price Quotation (#" . $row['id'] . ")");

										// Badge styling based on form source
										$badgeClass = 'badge-source-other';
										$badgeIcon = 'fa-globe';
										if (stripos($sourceForm, 'Contact') !== false) {
											$badgeClass = 'badge-source-contact';
											$badgeIcon = 'fa-envelope-open-text';
										} elseif (stripos($sourceForm, 'Popup') !== false || stripos($sourceForm, 'Quick') !== false) {
											$badgeClass = 'badge-source-popup';
											$badgeIcon = 'fa-bolt';
										} elseif (stripos($sourceForm, 'Product') !== false) {
											$badgeClass = 'badge-source-product';
											$badgeIcon = 'fa-box-open';
										}
										?>
										<tr class="lead-row">
											<td class="fw-bold text-muted">#<?= $row['id'] ?></td>
											<td>
												<span class="<?= $badgeClass ?>">
													<i class="fa-solid <?= $badgeIcon ?> me-1"></i>
													<?= htmlspecialchars($sourceForm) ?>
												</span>
												<?php if (!empty($productName)): ?>
													<div class="small fw-semibold text-danger mt-1">
														<i class="fa-solid fa-tag me-1"></i><?= htmlspecialchars($productName) ?>
													</div>
												<?php endif; ?>
											</td>
											<td>
												<div class="fw-bold text-dark fs-6"><?= htmlspecialchars($clientName) ?></div>
												<div class="small mt-1 d-flex flex-column gap-1">
													<?php if (!empty($clientPhone)): ?>
													<a href="tel:<?= htmlspecialchars($clean_phone) ?>" class="text-decoration-none text-dark fw-semibold" title="Call Number">
														<i class="fa-solid fa-phone text-muted me-1"></i><?= htmlspecialchars($clientPhone) ?>
													</a>
													<?php endif; ?>
													<?php if (!empty($clientEmail)): ?>
													<a href="mailto:<?= htmlspecialchars($clientEmail) ?>" class="text-decoration-none text-muted" title="Send Email">
														<i class="fa-solid fa-envelope text-danger me-1"></i><?= htmlspecialchars($clientEmail) ?>
													</a>
													<?php endif; ?>
												</div>
											</td>
											<td>
												<div class="text-dark" style="max-width: 320px; font-size: 13px; line-height: 1.4;">
													<?= nl2br(htmlspecialchars(mb_strimwidth($row['message'] ?? 'No message text.', 0, 160, '...'))) ?>
												</div>
												<?php if (!empty($row['notes'])): ?>
													<div class="small text-muted fst-italic mt-1 bg-light p-1 rounded border">
														<strong>Note:</strong> <?= htmlspecialchars(mb_strimwidth($row['notes'], 0, 80, '...')) ?>
													</div>
												<?php endif; ?>
											</td>
											<td class="small text-muted">
												<div class="fw-semibold text-dark"><?= date('d M Y', strtotime($row['created_at'])) ?></div>
												<div style="font-size: 11px;"><?= date('h:i A', strtotime($row['created_at'])) ?></div>
											</td>
											<td>
												<?php
												$statusBadge = 'bg-warning text-dark';
												if ($status == 'quoted') $statusBadge = 'bg-success text-white';
												elseif ($status == 'in_discussion') $statusBadge = 'bg-primary text-white';
												elseif ($status == 'closed') $statusBadge = 'bg-secondary text-white';
												?>
												<span class="badge <?= $statusBadge ?> px-2 py-1" style="font-size: 11px; text-transform: uppercase;">
													<?= htmlspecialchars(str_replace('_', ' ', $status)) ?>
												</span>
											</td>
											<td class="text-end">
												<div class="d-inline-flex align-items-center gap-1">
													<?php if (!empty($wa_phone)): ?>
														<a href="https://wa.me/<?= $wa_phone ?>?text=<?= $wa_greeting ?>" target="_blank" class="btn btn-sm btn-success px-2 py-1" title="Open WhatsApp Chat">
															<i class="fa-brands fa-whatsapp"></i>
														</a>
													<?php endif; ?>

													<button type="button" class="btn btn-sm btn-primary px-2 py-1" data-bs-toggle="modal" data-bs-target="#inquiryModal<?= $row['id'] ?>" title="View Full Details &amp; Follow Up">
														<i class="fa-solid fa-eye"></i>
													</button>

													<a href="manage-enquiries.php?delete=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger px-2 py-1" onClick="return confirm('Permanently delete enquiry #<?= $row['id'] ?>?');" title="Delete">
														<i class="fa-solid fa-trash"></i>
													</a>
												</div>
											</td>
										</tr>

										<!-- View & Update Modal for this Enquiry -->
										<div class="modal fade" id="inquiryModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $row['id'] ?>" aria-hidden="true">
											<div class="modal-dialog modal-lg modal-dialog-centered">
												<div class="modal-content">
													<form method="POST" action="manage-enquiries.php">
														<input type="hidden" name="enquiry_id" value="<?= $row['id'] ?>">
														<div class="modal-header" style="background: #103755; color: #ffffff;">
															<div>
																<h5 class="modal-title fw-bold mb-0 text-white" id="modalLabel<?= $row['id'] ?>">
																	Enquiry #<?= $row['id'] ?> &bull; <?= htmlspecialchars($clientName) ?>
																</h5>
																<span class="badge bg-danger text-white mt-1">
																	Source: <?= htmlspecialchars($sourceForm) ?>
																</span>
															</div>
															<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														<div class="modal-body p-4">
															<div class="row g-3 mb-4 p-3 bg-light rounded border">
																<div class="col-md-6">
																	<label class="form-label text-muted small fw-bold mb-1">ORIGIN FORM</label>
																	<div>
																		<span class="<?= $badgeClass ?>">
																			<i class="fa-solid <?= $badgeIcon ?> me-1"></i>
																			<?= htmlspecialchars($sourceForm) ?>
																		</span>
																	</div>
																</div>
																<div class="col-md-6">
																	<label class="form-label text-muted small fw-bold mb-1">SUBMITTED ON</label>
																	<div class="fw-semibold text-dark">
																		<?= date('d M Y, h:i A (T)', strtotime($row['created_at'])) ?>
																	</div>
																</div>
																<div class="col-md-6">
																	<label class="form-label text-muted small fw-bold mb-1">PHONE / WHATSAPP</label>
																	<div>
																		<?php if (!empty($clean_phone)): ?>
																			<a href="https://wa.me/<?= $wa_phone ?>?text=<?= $wa_greeting ?>" target="_blank" class="fw-bold text-success me-2">
																				<i class="fa-brands fa-whatsapp"></i> <?= htmlspecialchars($clientPhone) ?>
																			</a>
																			<a href="tel:<?= $clean_phone ?>" class="btn btn-xs btn-outline-secondary py-0">Call</a>
																		<?php else: ?>
																			<span class="text-dark fw-semibold">N/A</span>
																		<?php endif; ?>
																	</div>
																</div>
																<div class="col-md-6">
																	<label class="form-label text-muted small fw-bold mb-1">EMAIL ADDRESS</label>
																	<div>
																		<?php if (!empty($clientEmail)): ?>
																			<a href="mailto:<?= htmlspecialchars($clientEmail) ?>?subject=<?= $mail_subject ?>" class="fw-semibold text-danger">
																				<i class="fa-solid fa-envelope me-1"></i><?= htmlspecialchars($clientEmail) ?>
																			</a>
																		<?php else: ?>
																			<span class="text-dark">N/A</span>
																		<?php endif; ?>
																	</div>
																</div>
																<?php if (!empty($productName)): ?>
																<div class="col-12">
																	<label class="form-label text-muted small fw-bold mb-1">PRODUCT SPECIFIED</label>
																	<div class="fw-bold text-danger fs-6"><?= htmlspecialchars($productName) ?></div>
																</div>
																<?php endif; ?>
																<?php if (!empty($row['ip_address'])): ?>
																<div class="col-12">
																	<small class="text-muted">Client IP Address: <?= htmlspecialchars($row['ip_address']) ?></small>
																</div>
																<?php endif; ?>
															</div>

															<!-- Customer Message -->
															<div class="mb-4">
																<label class="form-label text-muted small fw-bold">CUSTOMER MESSAGE / REQUIREMENTS</label>
																<div class="p-3 bg-white rounded border text-dark fs-6" style="white-space: pre-wrap; word-break: break-word;">
																	<?= nl2br(htmlspecialchars($row['message'] ?? 'No extra message provided.')) ?>
																</div>
															</div>

															<hr>

															<!-- Status & Trade Follow-up Notes -->
															<div class="row g-3">
																<div class="col-md-6">
																	<label class="form-label fw-bold">Update Lead Status</label>
																	<select name="status" class="form-select">
																		<option value="pending" <?= ($status == 'pending') ? 'selected' : '' ?>>Pending (New Lead)</option>
																		<option value="in_discussion" <?= ($status == 'in_discussion') ? 'selected' : '' ?>>In Discussion</option>
																		<option value="quoted" <?= ($status == 'quoted') ? 'selected' : '' ?>>Quotation Sent</option>
																		<option value="closed" <?= ($status == 'closed') ? 'selected' : '' ?>>Closed / Fulfilled</option>
																	</select>
																</div>

																<div class="col-md-12">
																	<label class="form-label fw-bold">Internal Follow-up Notes / Remarks</label>
																	<textarea name="notes" class="form-control no-ckeditor" rows="3" placeholder="Add quotation details, tender numbers, pricing per unit, or internal follow-up notes..."><?= htmlspecialchars($row['notes'] ?? '') ?></textarea>
																</div>
															</div>
														</div>
														<div class="modal-footer bg-light d-flex justify-content-between">
															<div>
																<?php if (!empty($wa_phone)): ?>
																	<a href="https://wa.me/<?= $wa_phone ?>?text=<?= $wa_greeting ?>" target="_blank" class="btn btn-success btn-sm">
																		<i class="fa-brands fa-whatsapp me-1"></i> WhatsApp
																	</a>
																<?php endif; ?>
																<?php if (!empty($clientEmail)): ?>
																	<a href="mailto:<?= htmlspecialchars($clientEmail) ?>" class="btn btn-outline-danger btn-sm">
																		<i class="fa-solid fa-envelope me-1"></i> Email
																	</a>
																<?php endif; ?>
															</div>
															<div>
																<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
																<button type="submit" name="update_status" class="btn btn-danger btn-sm px-3">Save Changes</button>
															</div>
														</div>
													</form>
												</div>
											</div>
										</div>
									<?php endwhile; ?>
								<?php else: ?>
									<tr>
										<td colspan="7" class="text-center py-5 text-muted">
											<i class="fa-solid fa-inbox fa-3x mb-3 d-block text-muted"></i>
											No enquiries found matching criteria.
										</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
		
		<?php require('includes/footer.php'); ?>
	</div>

	<!-- Instant Search Filter -->
	<script>
	document.addEventListener("DOMContentLoaded", function() {
		const searchInput = document.getElementById('leadSearchInput');
		if (searchInput) {
			searchInput.addEventListener('keyup', function() {
				const query = this.value.toLowerCase().trim();
				const rows = document.querySelectorAll('.lead-row');
				rows.forEach(row => {
					const text = row.innerText.toLowerCase();
					if (text.includes(query)) {
						row.style.display = '';
					} else {
						row.style.display = 'none';
					}
				});
			});
		}
	});
	</script>
</body>
</html>
