<?php 
require('checksession.php'); 
require('../inc/function.php');

$msg = "";
$error = "";

// 1. Handle Status Toggle
if (isset($_GET['toggle_status']) && isset($_GET['id'])) {
    $fid = (int)$_GET['id'];
    $new_st = ((int)$_GET['toggle_status'] == 1) ? 0 : 1;
    if ($conn) {
        mysqli_query($conn, "UPDATE `tbl_faq` SET `status`=$new_st WHERE `id`=$fid");
    }
    $msg = "FAQ status updated.";
}

// 2. Handle Delete
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    if ($conn) {
        mysqli_query($conn, "DELETE FROM `tbl_faq` WHERE `id`=$del_id");
    }
    $msg = "FAQ removed successfully.";
}

// 3. Handle Batch Actions
if (isset($_POST['batch_action']) && !empty($_POST['selected_ids'])) {
    $action = $_POST['batch_action'];
    $ids = array_map('intval', $_POST['selected_ids']);
    $id_list = implode(',', $ids);

    if ($conn && !empty($id_list)) {
        if ($action === 'activate') {
            mysqli_query($conn, "UPDATE `tbl_faq` SET `status`=1 WHERE `id` IN ($id_list)");
            $msg = count($ids) . " FAQs activated successfully.";
        } elseif ($action === 'deactivate') {
            mysqli_query($conn, "UPDATE `tbl_faq` SET `status`=0 WHERE `id` IN ($id_list)");
            $msg = count($ids) . " FAQs deactivated.";
        } elseif ($action === 'delete') {
            mysqli_query($conn, "DELETE FROM `tbl_faq` WHERE `id` IN ($id_list)");
            $msg = count($ids) . " FAQs deleted.";
        }
    }
}

// Fetch category counts & all FAQs directly from database
$category_filter = trim($_GET['category'] ?? '');
$where = "1=1";
if (!empty($category_filter)) {
    $where .= " AND `category`='" . mysqli_real_escape_string($conn, $category_filter) . "'";
}

$cnt_all = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as c FROM `tbl_faq`"))['c'] ?? 0;
$categories_q = mysqli_query($conn, "SELECT `category`, count(*) as count FROM `tbl_faq` WHERE `category` IS NOT NULL AND `category` != '' GROUP BY `category`");
$categories = [];
if ($categories_q) {
    while ($cat_row = mysqli_fetch_assoc($categories_q)) {
        $categories[] = $cat_row;
    }
}

$faqs_q = mysqli_query($conn, "SELECT * FROM `tbl_faq` WHERE $where ORDER BY `sort_order` ASC, `id` ASC");
$faqs_list = [];
if ($faqs_q) {
    while ($r = mysqli_fetch_assoc($faqs_q)) {
        $faqs_list[] = $r;
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
			<!-- Header Bar -->
			<div class="d-flex flex-wrap align-items-center justify-content-between mb-3 pb-2 border-bottom">
				<div>
					<ol class="breadcrumb mb-1">
						<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
						<li class="breadcrumb-item active">FAQ Management</li>
					</ol>
					<h1 class="page-header mb-0">
						<i class="fa-solid fa-circle-question text-warning me-2"></i> FAQ Knowledgebase Management
					</h1>
				</div>
				<div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
					<a href="add-faq.php" class="btn btn-warning fw-bold shadow-sm px-3">
						<i class="fa-solid fa-plus-circle me-1"></i> Add New FAQ
					</a>
					<a href="../faq.php" target="_blank" class="btn btn-outline-success btn-sm px-3">
						<i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Live FAQ Page
					</a>
				</div>
			</div>

			<!-- Quick Sub-Menu Navigation -->
			<div class="cms-subnav-strip mb-4">
				<a href="manage-faq.php" class="cms-subnav-pill active">
					<i class="fa-solid fa-circle-question"></i> All FAQ Questions
				</a>
				<a href="add-faq.php" class="cms-subnav-pill">
					<i class="fa-solid fa-circle-plus"></i> Add Question
				</a>
				<a href="manage-faq-categories.php" class="cms-subnav-pill">
					<i class="fa-solid fa-folder-tree"></i> FAQ Categories
				</a>
				<a href="../faq.php" target="_blank" class="cms-subnav-pill cms-subnav-preview">
					<i class="fa-solid fa-arrow-up-right-from-square"></i> Preview Live FAQ Page
				</a>
			</div>

			<?php if ($msg != ""): ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<i class="fa-solid fa-circle-check me-2"></i> <?= htmlspecialchars($msg) ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<?php if ($error != ""): ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<i class="fa-solid fa-triangle-exclamation me-2"></i> <?= htmlspecialchars($error) ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<!-- Category Filter Tabs & Live Search -->
			<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
				<div class="cms-subnav-strip mb-0">
					<a href="manage-faq.php" class="cms-subnav-pill <?= ($category_filter == '') ? 'active' : '' ?>">
						All FAQs (<?= $cnt_all ?>)
					</a>
					<?php foreach ($categories as $cat): ?>
						<a href="manage-faq.php?category=<?= urlencode($cat['category']) ?>" class="cms-subnav-pill <?= ($category_filter == $cat['category']) ? 'active' : '' ?>">
							<?= htmlspecialchars($cat['category']) ?> (<?= $cat['count'] ?>)
						</a>
					<?php endforeach; ?>
				</div>

				<div class="search-filter-box">
					<i class="fa-solid fa-magnifying-glass"></i>
					<input type="text" id="faqSearchInput" class="form-control" placeholder="Search question, answer, category...">
				</div>
			</div>

			<!-- FAQ Table Card -->
			<div class="table-crud-card">
				<form method="POST" id="faqBatchForm">
					<div class="table-responsive">
						<table class="table table-crud-table" id="faqsTable">
							<thead>
								<tr>
									<th style="width: 48px; text-align: center;">
										<input type="checkbox" id="selectAllFaqs" class="crud-checkbox" title="Select All">
									</th>
									<th style="width: 140px;">CATEGORY</th>
									<th>QUESTION &amp; ANSWER PREVIEW</th>
									<th style="width: 80px; text-align: center;">SORT</th>
									<th style="width: 90px; text-align: center;">STATUS</th>
									<th style="width: 120px; text-align: end;">ACTIONS</th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($faqs_list)): ?>
									<?php foreach ($faqs_list as $f): ?>
										<tr class="faq-row" data-id="<?= $f['id'] ?>" data-status="<?= (int)($f['status'] ?? 1) ?>">
											<td style="text-align: center;">
												<input type="checkbox" name="selected_ids[]" value="<?= $f['id'] ?>" class="crud-checkbox row-select-cb">
											</td>
											<td>
												<span class="badge bg-light text-dark border fw-bold"><?= htmlspecialchars($f['category'] ?? 'General') ?></span>
											</td>
											<td>
												<div class="fw-bold text-dark fs-6 mb-1 faq-question-text"><?= htmlspecialchars($f['question']) ?></div>
												<small class="text-muted text-truncate d-block faq-answer-text" style="max-width: 500px;">
													<?= htmlspecialchars(strip_tags($f['answer'])) ?>
												</small>
											</td>
											<td style="text-align: center;">
												<span class="table-sort-badge"><?= (int)($f['sort_order'] ?? 0) ?></span>
											</td>
											<td style="text-align: center;">
												<label class="status-switch-wrapper switch-emerald" title="Click to toggle active status">
													<input type="checkbox" 
													       class="status-toggle-switch" 
													       data-id="<?= $f['id'] ?>" 
													       data-table="tbl_faq" 
													       data-field="status" 
													       <?= ((int)($f['status'] ?? 1) === 1) ? 'checked' : '' ?>>
													<span class="status-switch-slider"></span>
												</label>
											</td>
											<td style="text-align: end;">
												<div class="d-inline-flex gap-1">
													<a href="edit-faq.php?id=<?= $f['id'] ?>" class="btn-action-square btn-action-edit" title="Edit FAQ">
														<i class="fa-solid fa-pen"></i>
													</a>
													<a href="manage-faq.php?delete=<?= $f['id'] ?>" class="btn-action-square btn-action-delete" onClick="return confirm('Are you sure you want to delete this FAQ?');" title="Delete FAQ">
														<i class="fa-solid fa-trash"></i>
													</a>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php else: ?>
									<tr>
										<td colspan="6" class="text-center py-5 text-muted">
											<i class="fa-solid fa-circle-question fa-3x mb-3 d-block text-muted"></i>
											No FAQs found. Click "Add New FAQ" to create your first question.
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
							<button type="submit" name="batch_action" value="delete" class="btn btn-batch-delete" onclick="return confirm('Are you sure you want to delete all selected FAQs?');">
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
		const searchInput = document.getElementById('faqSearchInput');
		const selectAll = document.getElementById('selectAllFaqs');
		const rowCheckboxes = document.querySelectorAll('.row-select-cb');
		const batchBar = document.getElementById('batchActionBar');
		const countBadge = document.getElementById('selectedCountBadge');
		const toastEl = document.getElementById('crudToast');
		const toastMessage = document.getElementById('crudToastMessage');
		const toastIcon = document.getElementById('crudToastIcon');
		const toast = toastEl ? new bootstrap.Toast(toastEl, { delay: 3000 }) : null;

		// Multi-select & Batch Bar update
		function updateBatchBar() {
			const checkedBoxes = document.querySelectorAll('.row-select-cb:checked');
			const count = checkedBoxes.length;
			if (count > 0) {
				if (countBadge) countBadge.textContent = count + ' selected';
				if (batchBar) batchBar.classList.add('show');
			} else {
				if (batchBar) batchBar.classList.remove('show');
			}

			rowCheckboxes.forEach(cb => {
				const tr = cb.closest('tr');
				if (tr) {
					if (cb.checked) tr.classList.add('row-selected');
					else tr.classList.remove('row-selected');
				}
			});

			if (selectAll) {
				const totalVisible = document.querySelectorAll('.faq-row:not([style*="display: none"]) .row-select-cb').length;
				const checkedVisible = document.querySelectorAll('.faq-row:not([style*="display: none"]) .row-select-cb:checked').length;
				selectAll.checked = (totalVisible > 0 && totalVisible === checkedVisible);
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
				const rows = document.querySelectorAll('.faq-row');
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

		// AJAX Status Switch Logic
		const statusSwitches = document.querySelectorAll('.status-toggle-switch');
		statusSwitches.forEach(sw => {
			sw.addEventListener('change', function() {
				const currentSw = this;
				const itemId = currentSw.getAttribute('data-id');
				const tableName = currentSw.getAttribute('data-table') || 'tbl_faq';
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
						if (toastMessage) toastMessage.textContent = data.message || `FAQ #${itemId} status updated.`;
						if (toastIcon) toastIcon.className = 'fa-solid fa-circle-check text-success fs-5';
						if (toast) toast.show();
						if (row) row.setAttribute('data-status', newStatus);
					} else {
						currentSw.checked = !newStatus;
						if (toastMessage) toastMessage.textContent = data.error || 'Failed to update.';
						if (toastIcon) toastIcon.className = 'fa-solid fa-circle-xmark text-danger fs-5';
						if (toast) toast.show();
					}
				})
				.catch(err => {
					currentSw.checked = !newStatus;
					if (toastMessage) toastMessage.textContent = 'Network error while updating.';
					if (toastIcon) toastIcon.className = 'fa-solid fa-circle-xmark text-danger fs-5';
					if (toast) toast.show();
				});
			});
		});
	});
	</script>
</body>
</html>
