<?php 
require('checksession.php'); 
require('../inc/function.php');

// Fetch CMS Metrics
$total_products = count(get_all_products());
$featured_products = count(get_all_products(0, 0, true));
$total_categories = count(get_all_categories(false));
$total_faqs = count(get_faqs());
$total_blogs = count(get_blogs());
$total_testimonials = count(get_testimonials());

$total_leads = 0;
$pending_leads = 0;
$recent_leads = [];

if ($conn) {
    $q_leads = @mysqli_query($conn, "SELECT count(*) as cnt FROM `tbl_enquiry`");
    $total_leads = $q_leads ? (int)mysqli_fetch_assoc($q_leads)['cnt'] : 2;

    $q_p_leads = @mysqli_query($conn, "SELECT count(*) as cnt FROM `tbl_enquiry` WHERE `status`='pending'");
    $pending_leads = $q_p_leads ? (int)mysqli_fetch_assoc($q_p_leads)['cnt'] : 1;

    $q_rec = @mysqli_query($conn, "SELECT * FROM `tbl_enquiry` ORDER BY `id` DESC LIMIT 5");
    if ($q_rec) {
        while ($r = mysqli_fetch_assoc($q_rec)) {
            $recent_leads[] = $r;
        }
    }
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
			<!-- Header & Status Banner -->
			<div class="d-flex flex-wrap align-items-center justify-content-between mb-3 pb-2 border-bottom">
				<div>
					<ol class="breadcrumb mb-1">
						<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
						<li class="breadcrumb-item active">CMS Overview</li>
					</ol>
					<h1 class="page-header mb-0">
						<i class="fa-solid fa-gauge-high text-warning me-2"></i> Stridewel International CMS Console
					</h1>
				</div>
				<div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
					<a href="../index.php" target="_blank" class="btn btn-warning fw-bold shadow-sm btn-sm px-3">
						<i class="fa-solid fa-globe me-1"></i> Preview Live Website
					</a>
				</div>
			</div>

			<!-- Quick Welcome Banner -->
			<div class="quick-action-banner mb-4">
				<div>
					<div class="d-flex align-items-center gap-2 mb-2">
						<span class="badge bg-warning text-dark px-2 py-1 fw-bold">Dynamic CMS 2.0</span>
						<h3 class="text-white mb-0 fw-bold">Veterinary &amp; AI Precision Content Center</h3>
					</div>
					<p class="mb-0 text-white-50" style="max-width: 720px;">
						Full administrative control over 34+ veterinary products, categories, B2B quote inquiries, hero slides, FAQ knowledgebase, technical articles, and granular SEO metadata.
					</p>
				</div>
				<div class="d-none d-md-flex align-items-center gap-2">
					<a href="manage-enquiries.php" class="btn btn-light fw-bold text-dark px-3 py-2">
						<i class="fa-solid fa-inbox text-warning me-1"></i> RFQ Leads (<?= $pending_leads ?> New)
					</a>
					<a href="add-product.php" class="btn btn-warning fw-bold shadow-sm px-3 py-2 ms-2">
						<i class="fa-solid fa-plus-circle me-1"></i> Add New Product
					</a>
				</div>
			</div>
			
			<!-- CMS KPI Metric Cards Grid -->
			<div class="row g-4 mb-4">
				<div class="col-xl-3 col-md-6">
					<a href="manage-products.php" class="text-decoration-none">
						<div class="kpi-card">
							<div class="kpi-icon emerald">
								<i class="fa-solid fa-boxes-stacked"></i>
							</div>
							<div>
								<div class="kpi-val"><?= $total_products ?></div>
								<div class="kpi-label">Catalog Products (<?= $featured_products ?> Featured)</div>
							</div>
						</div>
					</a>
				</div>

				<div class="col-xl-3 col-md-6">
					<a href="manage-enquiries.php" class="text-decoration-none">
						<div class="kpi-card">
							<div class="kpi-icon gold">
								<i class="fa-solid fa-file-invoice-dollar"></i>
							</div>
							<div>
								<div class="kpi-val text-warning"><?= $total_leads ?></div>
								<div class="kpi-label">B2B Leads (<?= $pending_leads ?> Pending)</div>
							</div>
						</div>
					</a>
				</div>

				<div class="col-xl-3 col-md-6">
					<a href="manage-categories.php" class="text-decoration-none">
						<div class="kpi-card">
							<div class="kpi-icon blue">
								<i class="fa-solid fa-folder-tree"></i>
							</div>
							<div>
								<div class="kpi-val"><?= $total_categories ?></div>
								<div class="kpi-label">Product Categories</div>
							</div>
						</div>
					</a>
				</div>

				<div class="col-xl-3 col-md-6">
					<a href="manage-faq.php" class="text-decoration-none">
						<div class="kpi-card">
							<div class="kpi-icon amber">
								<i class="fa-solid fa-circle-question"></i>
							</div>
							<div>
								<div class="kpi-val"><?= $total_faqs ?></div>
								<div class="kpi-label">FAQ Knowledgebase</div>
							</div>
						</div>
					</a>
				</div>
			</div>

			<!-- Quick Management Actions & Recent Inquiries -->
			<div class="row g-4 mb-4">
				<!-- Left: Recent RFQ Leads -->
				<div class="col-lg-8">
					<div class="panel h-100">
						<div class="panel-heading bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
							<h5 class="mb-0 fw-bold text-dark">
								<i class="fa-solid fa-inbox text-warning me-2"></i> Recent Quote Requests &amp; RFQ Leads
							</h5>
							<a href="manage-enquiries.php" class="btn btn-outline-secondary btn-sm">View All Leads</a>
						</div>
						<div class="panel-body p-0">
							<div class="table-responsive">
								<table class="table table-hover align-middle mb-0">
									<thead class="bg-light">
										<tr>
											<th>Buyer &amp; Company</th>
											<th>Product Interest</th>
											<th>Volume</th>
											<th>Status</th>
											<th class="text-end">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if (!empty($recent_leads)): ?>
											<?php foreach ($recent_leads as $lead): ?>
												<?php 
												$clean_ph = preg_replace('/[^0-9]/', '', $lead['phone'] ?? '');
												$wa_url = "https://wa.me/{$clean_ph}?text=" . urlencode("Hello {$lead['full_name']}, thank you for inquiring with Stridewel International regarding {$lead['product_interest']}.");
												?>
												<tr>
													<td>
														<div class="fw-bold text-dark"><?= htmlspecialchars($lead['full_name']) ?></div>
														<small class="text-muted"><?= htmlspecialchars($lead['company_name'] ?: $lead['country']) ?></small>
													</td>
													<td>
														<span class="badge bg-light text-dark border"><?= htmlspecialchars($lead['product_interest'] ?? 'Catalog Item') ?></span>
													</td>
													<td><small class="text-muted"><?= htmlspecialchars($lead['volume_requirement'] ?? '—') ?></small></td>
													<td>
														<span class="badge <?= ($lead['status'] === 'pending') ? 'bg-warning text-dark' : 'bg-success' ?>">
															<?= ucfirst(str_replace('_', ' ', $lead['status'])) ?>
														</span>
													</td>
													<td class="text-end">
														<?php if (!empty($clean_ph)): ?>
															<a href="<?= $wa_url ?>" target="_blank" class="btn btn-xs btn-outline-success" title="WhatsApp">
																<i class="fa-brands fa-whatsapp"></i>
															</a>
														<?php endif; ?>
														<a href="manage-enquiries.php" class="btn btn-xs btn-outline-primary" title="Details">
															<i class="fa-solid fa-pen-to-square"></i>
														</a>
													</td>
												</tr>
											<?php endforeach; ?>
										<?php else: ?>
											<tr>
												<td colspan="5" class="text-center py-4 text-muted">
													No inquiries received yet. Submit a test quote from the website to test the pipeline!
												</td>
											</tr>
										<?php endif; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<!-- Right: Quick Navigation Tiles -->
				<div class="col-lg-4">
					<div class="panel h-100">
						<div class="panel-heading bg-white py-3 px-4 border-bottom">
							<h5 class="mb-0 fw-bold text-dark">
								<i class="fa-solid fa-bolt text-warning me-2"></i> Fast CMS Shortcuts
							</h5>
						</div>
						<div class="panel-body p-4 d-flex flex-column gap-3">
							<a href="manage-products.php" class="btn btn-outline-dark p-3 text-start d-flex align-items-center justify-content-between rounded-3">
								<div>
									<div class="fw-bold"><i class="fa-solid fa-boxes-stacked text-warning me-2"></i> Catalog Management</div>
									<small class="text-muted">Edit 34 veterinary items, specs &amp; images</small>
								</div>
								<i class="fa-solid fa-chevron-right text-muted"></i>
							</a>

							<a href="manage-faq.php" class="btn btn-outline-dark p-3 text-start d-flex align-items-center justify-content-between rounded-3">
								<div>
									<div class="fw-bold"><i class="fa-solid fa-circle-question text-info me-2"></i> FAQ Knowledgebase</div>
									<small class="text-muted">Manage categorized accordion questions</small>
								</div>
								<i class="fa-solid fa-chevron-right text-muted"></i>
							</a>

							<a href="manage-settings-seo.php" class="btn btn-outline-dark p-3 text-start d-flex align-items-center justify-content-between rounded-3">
								<div>
									<div class="fw-bold"><i class="fa-solid fa-magnifying-glass-chart text-success me-2"></i> Page SEO &amp; Meta Desk</div>
									<small class="text-muted">Custom meta titles, canonicals &amp; OG tags</small>
								</div>
								<i class="fa-solid fa-chevron-right text-muted"></i>
							</a>

							<a href="manage-contact.php" class="btn btn-outline-dark p-3 text-start d-flex align-items-center justify-content-between rounded-3">
								<div>
									<div class="fw-bold"><i class="fa-solid fa-headset text-danger me-2"></i> Contact &amp; Hotline Lines</div>
									<small class="text-muted">Update factory phone, email &amp; Google Map</small>
								</div>
								<i class="fa-solid fa-chevron-right text-muted"></i>
							</a>
						</div>
					</div>
				</div>
			</div>

		</div>
		
		<?php require('includes/footer.php'); ?>
	</div>
</body>
</html>
