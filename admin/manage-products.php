<?php 
require('checksession.php'); 
require('../inc/function.php');

$msg = "";
$error = "";

// 1. Handle Status Toggle
if (isset($_GET['toggle_status']) && isset($_GET['id'])) {
    $pid = (int)$_GET['id'];
    $new_st = ((int)$_GET['toggle_status'] == 1) ? 0 : 1;
    if ($conn) {
        mysqli_query($conn, "UPDATE `tbl_product` SET `status`=$new_st WHERE `id`=$pid");
    }
    $msg = "Product status updated.";
}

// 2. Handle Featured Toggle
if (isset($_GET['toggle_featured']) && isset($_GET['id'])) {
    $pid = (int)$_GET['id'];
    $new_ft = ((int)$_GET['toggle_featured'] == 1) ? 0 : 1;
    if ($conn) {
        mysqli_query($conn, "UPDATE `tbl_product` SET `is_featured`=$new_ft WHERE `id`=$pid");
    }
    $msg = "Featured showcase status updated.";
}

// 3. Handle Delete
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    if ($conn) {
        mysqli_query($conn, "DELETE FROM `tbl_product` WHERE `id`=$del_id");
    }
    $msg = "Product removed from catalog.";
}

// 4. Handle Batch Actions
if (isset($_POST['batch_action']) && !empty($_POST['selected_ids'])) {
    $action = $_POST['batch_action'];
    $ids = array_map('intval', $_POST['selected_ids']);
    $id_list = implode(',', $ids);

    if ($conn && !empty($id_list)) {
        if ($action === 'activate') {
            mysqli_query($conn, "UPDATE `tbl_product` SET `status`=1 WHERE `id` IN ($id_list)");
            $msg = count($ids) . " products activated successfully.";
        } elseif ($action === 'deactivate') {
            mysqli_query($conn, "UPDATE `tbl_product` SET `status`=0 WHERE `id` IN ($id_list)");
            $msg = count($ids) . " products deactivated successfully.";
        } elseif ($action === 'delete') {
            mysqli_query($conn, "DELETE FROM `tbl_product` WHERE `id` IN ($id_list)");
            $msg = count($ids) . " products removed from catalog.";
        }
    }
}

// 5. Filter by Category
$cat_filter = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;
$all_categories = get_all_categories(false);
$products_list = get_all_products(0, $cat_filter, false);

$total_count = count(get_all_products(0, 0, false));
?>
<!DOCTYPE html>
<html lang="en">
<?php require('includes/head.php'); ?>
<body>
	<div id="page-container" class="page-sidebar-fixed page-header-fixed show">
		<?php require('includes/header.php'); ?>
		<?php require('includes/left.php'); ?>
		
		<div id="content" class="content">
			<!-- Header Title & Add Action -->
			<div class="d-flex flex-wrap align-items-center justify-content-between mb-3 pb-2 border-bottom">
				<div>
					<ol class="breadcrumb mb-1">
						<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
						<li class="breadcrumb-item active">Product Catalog</li>
					</ol>
					<h1 class="page-header mb-0">
						<i class="fa-solid fa-boxes-stacked text-warning me-2"></i> Veterinary &amp; A.I. Product Catalog
					</h1>
				</div>
				<div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
					<a href="add-product.php" class="btn btn-warning fw-bold shadow-sm px-3">
						<i class="fa-solid fa-plus-circle me-1"></i> Add New Product
					</a>
					<a href="../shop.php" target="_blank" class="btn btn-outline-success btn-sm px-3">
						<i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Live Shop
					</a>
				</div>
			</div>

			<?php if ($msg != ""): ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<i class="fa-solid fa-circle-check me-2"></i> <?= htmlspecialchars($msg) ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<!-- Category Filter Tabs & Live Search -->
			<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
				<div class="cms-subnav-strip mb-0">
					<a href="manage-products.php" class="cms-subnav-pill <?= ($cat_filter == 0) ? 'active' : '' ?>">
						All Items (<?= $total_count ?>)
					</a>
					<?php foreach ($all_categories as $cat): ?>
						<a href="manage-products.php?cat=<?= $cat['id'] ?>" class="cms-subnav-pill <?= ($cat_filter == $cat['id']) ? 'active' : '' ?>">
							<?= htmlspecialchars($cat['name']) ?>
						</a>
					<?php endforeach; ?>
				</div>

				<div class="search-filter-box">
					<i class="fa-solid fa-magnifying-glass"></i>
					<input type="text" id="productSearchInput" class="form-control" placeholder="Search SKU, name, material...">
				</div>
			</div>

			<!-- Products Table Panel -->
			<div class="table-crud-card">
				<form method="POST" id="productBatchForm">
					<div class="table-responsive">
						<table class="table table-crud-table" id="productsTable">
							<thead>
								<tr>
									<th style="width: 48px; text-align: center;">
										<input type="checkbox" id="selectAllProducts" class="crud-checkbox" title="Select All">
									</th>
									<th style="width: 70px;">IMAGE</th>
									<th>SKU &amp; PRODUCT NAME</th>
									<th>CATEGORY</th>
									<th>SPECIFICATIONS &amp; MATERIAL</th>
									<th>PACKAGING &amp; COMPLIANCE</th>
									<th style="width: 90px; text-align: center;">FEATURED</th>
									<th style="width: 90px; text-align: center;">STATUS</th>
									<th style="width: 140px; text-align: end;">ACTIONS</th>
								</tr>
							</thead>
							<tbody id="productsTableBody">
								<?php if (!empty($products_list)): ?>
									<?php foreach ($products_list as $p): ?>
										<tr class="product-row" 
										    data-id="<?= $p['id'] ?>"
										    data-name="<?= strtolower(htmlspecialchars($p['name'])) ?>"
										    data-code="<?= strtolower(htmlspecialchars($p['code'])) ?>"
										    data-slug="<?= strtolower(htmlspecialchars($p['slug'])) ?>"
										    data-status="<?= (int)$p['status'] ?>"
										    data-featured="<?= (int)($p['is_featured'] ?? 0) ?>">
											<!-- Checkbox -->
											<td style="text-align: center;">
												<input type="checkbox" name="selected_ids[]" value="<?= $p['id'] ?>" class="crud-checkbox row-select-cb">
											</td>

											<!-- Image -->
											<td>
												<div class="table-thumb-box">
													<img src="../<?= htmlspecialchars($p['image']) ?>" alt="" onerror="this.src='../assets/prodcuts-images/AI-01.png'">
												</div>
											</td>

											<!-- Name & SKU -->
											<td>
												<div class="d-flex align-items-center gap-2">
													<span class="badge bg-dark text-warning border fw-bold" style="font-size: 11px;"><?= htmlspecialchars($p['code']) ?></span>
													<div class="fw-bold text-dark fs-6"><?= htmlspecialchars($p['name']) ?></div>
												</div>
												<small class="text-muted"><i class="fa-solid fa-link me-1"></i><?= htmlspecialchars($p['slug']) ?></small>
											</td>

											<!-- Category -->
											<td>
												<?php 
												$cat_name = 'General';
												foreach ($all_categories as $c) {
													if ($c['id'] == $p['category_id']) {
														$cat_name = $c['name'];
														break;
													}
												}
												?>
												<span class="badge bg-light text-dark border">
													<?= htmlspecialchars($cat_name) ?>
												</span>
											</td>

											<!-- Specs & Material -->
											<td>
												<div class="fw-semibold text-dark small"><?= htmlspecialchars($p['material'] ?? 'Stainless Steel') ?></div>
												<small class="text-muted text-truncate d-block" style="max-width: 250px;">
													<?= htmlspecialchars($p['compatibility'] ?? 'Universal') ?>
												</small>
											</td>

											<!-- Packaging & Standards -->
											<td>
												<div class="small fw-semibold text-dark"><?= htmlspecialchars($p['packaging'] ?? 'Standard Box') ?></div>
												<small class="badge bg-light text-muted border"><?= htmlspecialchars($p['compliance'] ?? 'ISO 9001:2015') ?></small>
											</td>

											<!-- Featured Toggle Switch -->
											<td style="text-align: center;">
												<label class="status-switch-wrapper switch-gold" title="Click to toggle featured status">
													<input type="checkbox" 
													       class="status-toggle-switch" 
													       data-id="<?= $p['id'] ?>" 
													       data-table="tbl_product" 
													       data-field="is_featured" 
													       <?= (!empty($p['is_featured']) && $p['is_featured'] == 1) ? 'checked' : '' ?>>
													<span class="status-switch-slider"></span>
												</label>
											</td>

											<!-- Status Toggle Switch -->
											<td style="text-align: center;">
												<label class="status-switch-wrapper switch-emerald" title="Click to toggle active status">
													<input type="checkbox" 
													       class="status-toggle-switch" 
													       data-id="<?= $p['id'] ?>" 
													       data-table="tbl_product" 
													       data-field="status" 
													       <?= ($p['status'] == 1) ? 'checked' : '' ?>>
													<span class="status-switch-slider"></span>
												</label>
											</td>

											<!-- Actions -->
											<td style="text-align: end;">
												<div class="d-inline-flex gap-1">
													<a href="../shop-details.php?id=<?= urlencode($p['code']) ?>" target="_blank" class="btn-action-square btn-action-view" title="Open on Live Site">
														<i class="fa-solid fa-arrow-up-right-from-square"></i>
													</a>
													<a href="edit-product.php?id=<?= $p['id'] ?>" class="btn-action-square btn-action-edit" title="Edit Product">
														<i class="fa-solid fa-pen"></i>
													</a>
													<a href="manage-products.php?delete=<?= $p['id'] ?><?= ($cat_filter > 0) ? '&cat='.$cat_filter : '' ?>" class="btn-action-square btn-action-delete" onClick="return confirm('Are you sure you want to delete this product?');" title="Delete Product">
														<i class="fa-solid fa-trash"></i>
													</a>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php else: ?>
									<tr>
										<td colspan="9" class="text-center py-5 text-muted">
											<i class="fa-solid fa-boxes-stacked fa-3x mb-3 d-block text-muted"></i>
											No products found matching criteria.
										</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>

					<!-- Floating Batch Actions Toolbar -->
					<div class="batch-actions-floating-bar" id="batchActionBar">
						<span class="batch-selected-badge" id="selectedCountBadge">0 selected</span>
						<div class="d-flex align-items-center gap-2">
							<button type="submit" name="batch_action" value="activate" class="btn btn-batch-activate">
								<i class="fa-solid fa-check me-1"></i> Activate
							</button>
							<button type="submit" name="batch_action" value="deactivate" class="btn btn-batch-deactivate">
								<i class="fa-solid fa-ban me-1"></i> Deactivate
							</button>
							<button type="submit" name="batch_action" value="delete" class="btn btn-batch-delete" onclick="return confirm('Are you sure you want to delete all selected products?');">
								<i class="fa-solid fa-trash me-1"></i> Delete
							</button>
						</div>
					</div>
				</form>
			</div>

		</div>
		<?php require('includes/footer.php'); ?>
	</div>

	<!-- Toast Container for AJAX toggles -->
	<div class="crud-toast-container">
		<div id="crudToast" class="crud-toast" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="toast-body">
				<i id="crudToastIcon" class="fa-solid fa-circle-check text-success fs-5"></i>
				<span id="crudToastMessage">Status updated</span>
			</div>
			<button type="button" class="toast-close-btn" onclick="document.getElementById('crudToast').classList.remove('show');" aria-label="Close">&times;</button>
		</div>
	</div>

	<!-- Instant Search, Multi-select, and AJAX Toggle Script -->
	<script>
	document.addEventListener("DOMContentLoaded", function() {
		const searchInput = document.getElementById('productSearchInput');
		const selectAll = document.getElementById('selectAllProducts');
		const rowCheckboxes = document.querySelectorAll('.row-select-cb');
		const batchBar = document.getElementById('batchActionBar');
		const countBadge = document.getElementById('selectedCountBadge');
		const toastEl = document.getElementById('crudToast');
		const toastMessage = document.getElementById('crudToastMessage');
		const toastIcon = document.getElementById('crudToastIcon');
		const toast = toastEl ? new bootstrap.Toast(toastEl, { delay: 3000 }) : null;

		function updateBatchBar() {
			const checkedBoxes = document.querySelectorAll('.row-select-cb:checked');
			const count = checkedBoxes.length;
			if (count > 0) {
				countBadge.textContent = count + ' selected';
				batchBar.classList.add('show');
			} else {
				batchBar.classList.remove('show');
			}

			rowCheckboxes.forEach(cb => {
				const tr = cb.closest('tr');
				if (tr) {
					if (cb.checked) tr.classList.add('row-selected');
					else tr.classList.remove('row-selected');
				}
			});

			if (selectAll) {
				selectAll.checked = (count === rowCheckboxes.length && rowCheckboxes.length > 0);
			}
		}

		if (selectAll) {
			selectAll.addEventListener('change', function() {
				const isChecked = this.checked;
				rowCheckboxes.forEach(cb => {
					const row = cb.closest('tr');
					if (row && row.style.display !== 'none') {
						cb.checked = isChecked;
					}
				});
				updateBatchBar();
			});
		}

		rowCheckboxes.forEach(cb => {
			cb.addEventListener('change', updateBatchBar);
		});

		// Instant Search
		if (searchInput) {
			searchInput.addEventListener('keyup', function() {
				const query = this.value.toLowerCase().trim();
				const rows = document.querySelectorAll('.product-row');
				rows.forEach(row => {
					const text = row.innerText.toLowerCase();
					if (text.includes(query)) {
						row.style.display = '';
					} else {
						row.style.display = 'none';
						const cb = row.querySelector('.row-select-cb');
						if (cb) cb.checked = false;
					}
				});
				updateBatchBar();
			});
		}

		// AJAX Status & Featured Toggles
		const statusSwitches = document.querySelectorAll('.status-toggle-switch');
		statusSwitches.forEach(sw => {
			sw.addEventListener('change', function() {
				const currentSw = this;
				const itemId = currentSw.getAttribute('data-id');
				const tableName = currentSw.getAttribute('data-table');
				const fieldName = currentSw.getAttribute('data-field') || 'status';
				const newStatus = currentSw.checked ? 1 : 0;
				const row = currentSw.closest('tr');

				const formData = new FormData();
				formData.append('table', tableName);
				formData.append('id', itemId);
				formData.append('status', newStatus);
				formData.append('field', fieldName);

				fetch('ajax/toggle-status.php', {
					method: 'POST',
					body: formData
				})
				.then(res => res.json())
				.then(data => {
					if (data.success) {
						toastMessage.textContent = data.message || `Product #${itemId} updated.`;
						toastIcon.className = 'fa-solid fa-circle-check text-success fs-5';
						if (toast) toast.show();
						if (row) row.setAttribute('data-' + fieldName, newStatus);
					} else {
						currentSw.checked = !newStatus;
						toastMessage.textContent = data.error || 'Failed to update.';
						toastIcon.className = 'fa-solid fa-circle-xmark text-danger fs-5';
						if (toast) toast.show();
					}
				})
				.catch(err => {
					currentSw.checked = !newStatus;
					toastMessage.textContent = 'Network error while updating.';
					toastIcon.className = 'fa-solid fa-triangle-exclamation text-warning fs-5';
					if (toast) toast.show();
				});
			});
		});
	});
	</script>
</body>
</html>
