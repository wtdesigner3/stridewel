<?php 
require('checksession.php'); 
require('../inc/function.php');

// 1. Handle CSV Export
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    $filter_status = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';
    $where_exp = "";
    if ($filter_status != '') {
        $where_exp = "WHERE `status`='$filter_status'";
    }
    $exp_query = mysqli_query($conn, "SELECT * FROM `tbl_enquiry` $where_exp ORDER BY `id` DESC");
    
    $filename = "stridewel_leads_export_" . date('Y-m-d_H-i') . ".csv";
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);
    
    $output = fopen('php://output', 'w');
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
    
    fputcsv($output, ['Lead ID', 'Full Name', 'Organization', 'Email', 'Phone', 'Product / Category Interest', 'Inquiry Type', 'Message', 'Status', 'Internal Notes', 'Date Submitted']);
    
    if ($exp_query) {
        while ($row = mysqli_fetch_assoc($exp_query)) {
            fputcsv($output, [
                $row['id'],
                $row['name'] ?? $row['full_name'] ?? '',
                $row['organization'] ?? $row['company_name'] ?? '',
                $row['email'],
                $row['phone'],
                $row['product_name'] ?? $row['product_interest'] ?? '',
                $row['inquiry_type'] ?? 'Quote Request',
                $row['message'],
                ucwords(str_replace('_', ' ', $row['status'])),
                $row['notes'] ?? '',
                $row['created_at']
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
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes'] ?? '');
    $up_q = mysqli_query($conn, "UPDATE `tbl_enquiry` SET `status`='$new_status', `notes`='$notes' WHERE `id`=$eid");
    if ($up_q) {
        $msg = "Inquiry #$eid updated successfully.";
    } else {
        $error = "Failed to update inquiry status.";
    }
}

// 3. Handle Quick Inline Status Update via GET
if (isset($_GET['quick_status']) && isset($_GET['id'])) {
    $qid = (int)$_GET['id'];
    $qst = mysqli_real_escape_string($conn, $_GET['quick_status']);
    mysqli_query($conn, "UPDATE `tbl_enquiry` SET `status`='$qst' WHERE `id`=$qid");
    $msg = "Status for Inquiry #$qid changed to " . str_replace('_', ' ', $qst) . ".";
}

// 4. Handle Delete
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM `tbl_enquiry` WHERE `id`=$del_id");
    $msg = "Inquiry deleted successfully.";
}

// Filter by Status
$filter = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';

$where = "";
if ($filter != '') {
    $where = "WHERE `status`='$filter'";
}

$enquiries = mysqli_query($conn, "SELECT * FROM `tbl_enquiry` $where ORDER BY `id` DESC");

// Fetch counts for tabs
$cnt_all = 0;
$cnt_pending = 0;
$cnt_discussion = 0;
$cnt_quoted = 0;
$cnt_closed = 0;

if ($res = mysqli_query($conn, "SELECT count(*) as c FROM `tbl_enquiry`")) {
    $cnt_all = mysqli_fetch_assoc($res)['c'] ?? 0;
}
if ($res = mysqli_query($conn, "SELECT count(*) as c FROM `tbl_enquiry` WHERE `status`='Pending' OR `status`='pending' OR `status`='New'")) {
    $cnt_pending = mysqli_fetch_assoc($res)['c'] ?? 0;
}
if ($res = mysqli_query($conn, "SELECT count(*) as c FROM `tbl_enquiry` WHERE `status`='in_discussion' OR `status`='In Discussion'")) {
    $cnt_discussion = mysqli_fetch_assoc($res)['c'] ?? 0;
}
if ($res = mysqli_query($conn, "SELECT count(*) as c FROM `tbl_enquiry` WHERE `status`='quoted' OR `status`='Quoted'")) {
    $cnt_quoted = mysqli_fetch_assoc($res)['c'] ?? 0;
}
if ($res = mysqli_query($conn, "SELECT count(*) as c FROM `tbl_enquiry` WHERE `status`='closed' OR `status`='Closed'")) {
    $cnt_closed = mysqli_fetch_assoc($res)['c'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require('includes/head.php'); ?>
<body>
	<div id="page-container" class="page-sidebar-fixed page-header-fixed show">
		<?php require('includes/header.php'); ?>
		<?php require('includes/left.php'); ?>
		
		<div id="content" class="content">
			<!-- Header Title & Export Actions -->
			<div class="d-flex flex-wrap align-items-center justify-content-between mb-3 pb-2 border-bottom">
				<div>
					<ol class="breadcrumb mb-1">
						<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
						<li class="breadcrumb-item active">Quotation Leads &amp; Inquiries</li>
					</ol>
					<h1 class="page-header mb-0">
						<i class="fa-solid fa-address-book text-danger me-2"></i> Inquiries &amp; Quotation Requests
					</h1>
				</div>
				<div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
					<a href="manage-enquiries.php?export=csv<?= ($filter != '') ? '&status='.$filter : '' ?>" class="btn btn-danger fw-bold shadow-sm px-3">
						<i class="fa-solid fa-file-csv me-1"></i> Export to CSV
					</a>
				</div>
			</div>

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

			<!-- Top Controls: Status Tabs & Live Search Box -->
			<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
				<div class="btn-group shadow-sm">
					<a href="manage-enquiries.php" class="btn btn-outline-secondary <?= ($filter == '') ? 'active' : '' ?>">
						All Leads (<?= $cnt_all ?>)
					</a>
					<a href="manage-enquiries.php?status=Pending" class="btn btn-outline-secondary <?= ($filter == 'Pending' || $filter == 'pending' || $filter == 'New') ? 'active' : '' ?>">
						<i class="fa-solid fa-clock text-warning me-1"></i> Pending (<?= $cnt_pending ?>)
					</a>
					<a href="manage-enquiries.php?status=in_discussion" class="btn btn-outline-secondary <?= ($filter == 'in_discussion') ? 'active' : '' ?>">
						<i class="fa-solid fa-comments text-primary me-1"></i> In Discussion (<?= $cnt_discussion ?>)
					</a>
					<a href="manage-enquiries.php?status=quoted" class="btn btn-outline-secondary <?= ($filter == 'quoted') ? 'active' : '' ?>">
						<i class="fa-solid fa-file-invoice text-success me-1"></i> Quoted (<?= $cnt_quoted ?>)
					</a>
					<a href="manage-enquiries.php?status=closed" class="btn btn-outline-secondary <?= ($filter == 'closed') ? 'active' : '' ?>">
						Closed (<?= $cnt_closed ?>)
					</a>
				</div>

				<div style="position: relative; min-width: 280px;">
					<input type="text" id="leadSearchInput" class="form-control" placeholder="Search client, organization, product, phone...">
				</div>
			</div>

			<!-- Inquiries Table Panel -->
			<div class="panel panel-inverse">
				<div class="panel-body p-0">
					<div class="table-responsive">
						<table class="table table-hover table-striped mb-0" id="leadsTable">
							<thead class="table-dark">
								<tr>
									<th>ID</th>
									<th>Client &amp; Organization</th>
									<th>Product Interest</th>
									<th>Inquiry Type</th>
									<th>Date</th>
									<th>Status</th>
									<th class="text-end">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php if ($enquiries && mysqli_num_rows($enquiries) > 0): ?>
									<?php while ($row = mysqli_fetch_assoc($enquiries)): ?>
										<?php 
										$clientName = $row['name'] ?? $row['full_name'] ?? 'Inquirer';
										$clientOrg = $row['organization'] ?? $row['company_name'] ?? '';
										$productName = $row['product_name'] ?? $row['product_interest'] ?? 'General';
										$inquiryType = $row['inquiry_type'] ?? 'Price Quote';
										$clean_phone = preg_replace('/[^0-9]/', '', $row['phone']);
										$wa_greeting = urlencode("Hello " . $clientName . ($clientOrg ? " ($clientOrg)" : "") . ", thank you for contacting Stridewel International regarding " . $productName . ". We are pleased to provide you with direct manufacturer pricing.");
										$mail_subject = urlencode("Stridewel International Price Quotation - " . $productName . " (#" . $row['id'] . ")");
										$mail_body = urlencode("Dear " . $clientName . ",\n\nThank you for reaching out to Stridewel International.\n\nWe have received your requirement for " . $productName . ".\n\nOur technical sales desk is preparing your direct factory quotation.\n\nBest regards,\nStridewel International Sales Team");
										?>
										<tr class="lead-row">
											<td class="fw-bold">#<?= $row['id'] ?></td>
											<td>
												<div class="fw-bold text-dark"><?= htmlspecialchars($clientName) ?></div>
												<?php if (!empty($clientOrg)): ?>
												<div class="small text-muted"><i class="fa-solid fa-building me-1"></i><?= htmlspecialchars($clientOrg) ?></div>
												<?php endif; ?>
												<div class="small mt-1 d-flex flex-wrap gap-2">
													<a href="mailto:<?= htmlspecialchars($row['email']) ?>?subject=<?= $mail_subject ?>&body=<?= $mail_body ?>" class="text-decoration-none text-muted" title="Send Email">
														<i class="fa-solid fa-envelope text-danger me-1"></i><?= htmlspecialchars($row['email']) ?>
													</a>
													<?php if (!empty($row['phone'])): ?>
													<span class="text-muted">&bull;</span>
													<a href="tel:<?= htmlspecialchars($row['phone']) ?>" class="text-decoration-none text-muted" title="Call">
														<i class="fa-solid fa-phone text-muted me-1"></i><?= htmlspecialchars($row['phone']) ?>
													</a>
													<?php endif; ?>
												</div>
											</td>
											<td>
												<div class="fw-semibold text-dark"><?= htmlspecialchars($productName) ?></div>
												<?php if (!empty($row['message'])): ?>
												<div class="small text-muted text-truncate" style="max-width: 260px;" title="<?= htmlspecialchars($row['message']) ?>">
													<?= htmlspecialchars($row['message']) ?>
												</div>
												<?php endif; ?>
											</td>
											<td><span class="badge bg-light text-dark border"><?= htmlspecialchars($inquiryType) ?></span></td>
											<td class="small text-muted"><?= date('M d, Y H:i', strtotime($row['created_at'])) ?></td>
											<td>
												<span class="badge bg-<?= ($row['status'] == 'closed' || $row['status'] == 'Closed') ? 'secondary' : (($row['status'] == 'quoted' || $row['status'] == 'Quoted') ? 'success' : 'warning text-dark') ?>">
													<?= htmlspecialchars($row['status']) ?>
												</span>
											</td>
											<td class="text-end">
												<div class="d-inline-flex align-items-center gap-1">
													<?php if (!empty($clean_phone)): ?>
														<a href="https://wa.me/<?= $clean_phone ?>?text=<?= $wa_greeting ?>" target="_blank" class="btn btn-xs btn-success" title="WhatsApp Client">
															<i class="fa-brands fa-whatsapp"></i> Chat
														</a>
													<?php endif; ?>

													<button type="button" class="btn btn-xs btn-primary" data-bs-toggle="modal" data-bs-target="#inquiryModal<?= $row['id'] ?>" title="View / Update Inquiry">
														<i class="fa-solid fa-pen-to-square"></i>
													</button>

													<a href="manage-enquiries.php?delete=<?= $row['id'] ?>" class="btn btn-xs btn-outline-danger" onClick="return confirm('Permanently delete this inquiry?');" title="Delete">
														<i class="fa-solid fa-trash"></i>
													</a>
												</div>
											</td>
										</tr>

										<!-- Action Modal for this Inquiry -->
										<div class="modal fade" id="inquiryModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<form method="POST" action="manage-enquiries.php">
														<input type="hidden" name="enquiry_id" value="<?= $row['id'] ?>">
														<div class="modal-header bg-light">
															<div>
																<h5 class="modal-title fw-bold mb-0">Inquiry #<?= $row['id'] ?> &bull; <?= htmlspecialchars($clientName) ?></h5>
																<small class="text-muted"><?= htmlspecialchars($clientOrg) ?> &bull; <?= htmlspecialchars($productName) ?></small>
															</div>
															<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														<div class="modal-body p-4">
															<div class="row g-3 mb-4 p-3 bg-light rounded border">
																<div class="col-md-6">
																	<label class="form-label text-muted small fw-bold mb-1">CLIENT EMAIL</label>
																	<div>
																		<a href="mailto:<?= htmlspecialchars($row['email']) ?>" class="fw-semibold text-dark">
																			<i class="fa-solid fa-envelope text-danger me-1"></i><?= htmlspecialchars($row['email']) ?>
																		</a>
																	</div>
																</div>
																<div class="col-md-6">
																	<label class="form-label text-muted small fw-bold mb-1">PHONE / WHATSAPP</label>
																	<div>
																		<?php if (!empty($clean_phone)): ?>
																			<a href="https://wa.me/<?= $clean_phone ?>?text=<?= $wa_greeting ?>" target="_blank" class="fw-bold text-success">
																				<i class="fa-brands fa-whatsapp"></i> <?= htmlspecialchars($row['phone']) ?> (Open WhatsApp)
																			</a>
																		<?php else: ?>
																			<span class="text-dark fw-semibold"><?= htmlspecialchars($row['phone'] ?? 'N/A') ?></span>
																		<?php endif; ?>
																	</div>
																</div>
																<div class="col-md-6">
																	<label class="form-label text-muted small fw-bold mb-1">ORGANIZATION</label>
																	<div class="fw-semibold text-dark"><?= htmlspecialchars($clientOrg ?: 'Individual / Clinic') ?></div>
																</div>
																<div class="col-md-6">
																	<label class="form-label text-muted small fw-bold mb-1">PRODUCT / TENDER INTEREST</label>
																	<div class="fw-semibold text-dark"><?= htmlspecialchars($productName) ?></div>
																</div>
															</div>

															<!-- Client Note / Message -->
															<div class="mb-4">
																<label class="form-label text-muted small fw-bold">SPECIFICATIONS &amp; MESSAGE</label>
																<div class="p-3 bg-white rounded border text-dark">
																	<?= nl2br(htmlspecialchars($row['message'] ?? 'No extra message specified.')) ?>
																</div>
															</div>

															<hr>

															<!-- Status & Trade Follow-up Notes -->
															<div class="row g-3">
																<div class="col-md-6">
																	<label class="form-label fw-bold">Update Lead Status</label>
																	<select name="status" class="form-select">
																		<option value="Pending" <?= ($row['status'] == 'Pending' || $row['status'] == 'pending' || $row['status'] == 'New') ? 'selected' : '' ?>>Pending (New Lead)</option>
																		<option value="in_discussion" <?= ($row['status'] == 'in_discussion' || $row['status'] == 'In Discussion') ? 'selected' : '' ?>>In Discussion</option>
																		<option value="quoted" <?= ($row['status'] == 'quoted' || $row['status'] == 'Quoted') ? 'selected' : '' ?>>Quotation Sent</option>
																		<option value="closed" <?= ($row['status'] == 'closed' || $row['status'] == 'Closed') ? 'selected' : '' ?>>Closed / Fulfilled</option>
																	</select>
																</div>

																<div class="col-md-12">
																	<label class="form-label fw-bold">Internal Follow-up Notes / Remarks</label>
																	<textarea name="notes" class="form-control" rows="3" placeholder="Add quotation details, tender numbers, pricing per unit, or follow-up logs..."><?= htmlspecialchars($row['notes'] ?? '') ?></textarea>
																</div>
															</div>
														</div>
														<div class="modal-footer bg-light">
															<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
															<button type="submit" name="update_status" class="btn btn-danger">Save Changes</button>
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
											No inquiries found matching criteria.
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
