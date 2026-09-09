<?php 
require('checksession.php'); 
require('../inc/function.php');

$msg = "";
$error = "";

// 1. Handle Status Toggle via GET
if (isset($_GET['toggle_status']) && isset($_GET['id'])) {
    $bid = (int)$_GET['id'];
    $new_st = ((int)$_GET['toggle_status'] == 1) ? 0 : 1;
    mysqli_query($conn, "UPDATE `tbl_blogs` SET `b_status`=$new_st WHERE `b_id`=$bid");
    $msg = "Article status updated.";
}

// 2. Handle Delete
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM `tbl_blogs` WHERE `b_id`=$del_id");
    $msg = "Article removed successfully.";
}

// 3. Handle Batch Actions
if (isset($_POST['batch_action']) && !empty($_POST['selected_ids'])) {
    $action = $_POST['batch_action'];
    $ids = array_map('intval', $_POST['selected_ids']);
    $id_list = implode(',', $ids);

    if ($action === 'activate') {
        mysqli_query($conn, "UPDATE `tbl_blogs` SET `b_status`=1 WHERE `b_id` IN ($id_list)");
        $msg = count($ids) . " article(s) published successfully.";
    } elseif ($action === 'deactivate') {
        mysqli_query($conn, "UPDATE `tbl_blogs` SET `b_status`=0 WHERE `b_id` IN ($id_list)");
        $msg = count($ids) . " article(s) moved to drafts.";
    } elseif ($action === 'delete') {
        mysqli_query($conn, "DELETE FROM `tbl_blogs` WHERE `b_id` IN ($id_list)");
        $msg = count($ids) . " article(s) deleted permanently.";
    }
}

// 4. Filter by Category
$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, trim($_GET['category'])) : '';
$where = "";
if ($category != '') {
    $where = "WHERE `b_category`='$category'";
}

$blogs = mysqli_query($conn, "SELECT * FROM `tbl_blogs` $where ORDER BY `b_sort` ASC, `b_date` DESC, `b_id` DESC");

// Fetch counts
$cnt_all = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as c FROM `tbl_blogs`"))['c'];
$categories_q = mysqli_query($conn, "SELECT `b_category`, count(*) as count FROM `tbl_blogs` WHERE `b_category` IS NOT NULL AND `b_category` != '' GROUP BY `b_category`");
$categories = [];
while ($cat_row = mysqli_fetch_assoc($categories_q)) {
    $categories[] = $cat_row;
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
			<!-- Header Title & Add Action -->
			<div class="d-flex flex-wrap align-items-center justify-content-between mb-3 pb-2 border-bottom">
				<div>
					<ol class="breadcrumb mb-1">
						<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
						<li class="breadcrumb-item active">Articles & Insights Desk</li>
					</ol>
					<h1 class="page-header mb-0">
						<i class="fa-solid fa-newspaper text-warning me-2"></i> Articles &amp; Market Insights Desk
					</h1>
				</div>
				<div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
					<a href="add-blogs.php" class="btn btn-warning fw-bold shadow-sm px-3">
						<i class="fa-solid fa-plus-circle me-1"></i> Add New Article
					</a>
					<a href="../../blog.php" target="_blank" class="btn btn-outline-success btn-sm px-3">
						<i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Live Blog
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

			<!-- Category Filter Tabs & Live Search -->
			<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
				<div class="cms-subnav-strip mb-0">
					<a href="manage-blogs.php" class="cms-subnav-pill <?= ($category == '') ? 'active' : '' ?>">
						All Articles (<?= $cnt_all ?>)
					</a>
					<?php foreach ($categories as $cat): ?>
						<a href="manage-blogs.php?category=<?= urlencode($cat['b_category']) ?>" class="cms-subnav-pill <?= ($category == $cat['b_category']) ? 'active' : '' ?>">
							<?= htmlspecialchars($cat['b_category']) ?> (<?= $cat['count'] ?>)
						</a>
					<?php endforeach; ?>
				</div>

				<div class="search-filter-box">
					<i class="fa-solid fa-magnifying-glass"></i>
					<input type="text" id="articleSearchInput" class="form-control" placeholder="Search title, category, author...">
				</div>
			</div>

			<!-- Articles Table Panel -->
			<div class="table-crud-card">
				<form method="POST" id="articleBatchForm">
					<div class="table-responsive">
						<table class="table table-crud-table" id="articlesTable">
							<thead>
								<tr>
									<th style="width: 48px; text-align: center;">
										<input type="checkbox" id="selectAllArticles" class="crud-checkbox" title="Select All">
									</th>
									<th style="width: 70px;">IMAGE</th>
									<th>ARTICLE TITLE &amp; SLUG</th>
									<th>CATEGORY</th>
									<th>AUTHOR &amp; PUBLISHED</th>
									<th>SUMMARY / EXCERPT</th>
									<th style="width: 90px; text-align: center;">STATUS</th>
									<th style="width: 140px; text-align: end;">ACTIONS</th>
								</tr>
							</thead>
							<tbody id="articlesTableBody">
								<?php if (mysqli_num_rows($blogs) > 0): ?>
									<?php while ($b = mysqli_fetch_assoc($blogs)): ?>
										<?php 
										$img_src = !empty($b['b_image']) ? (strpos($b['b_image'], 'assets/') === 0 ? '../../' . $b['b_image'] : '../../uploads/blogs/' . $b['b_image']) : '../../assets/img/inner-page/news/01.jpg';
										?>
										<tr class="article-row" 
										    data-id="<?= $b['b_id'] ?>"
										    data-title="<?= strtolower(htmlspecialchars($b['b_title'])) ?>"
										    data-slug="<?= strtolower(htmlspecialchars($b['b_url'])) ?>"
										    data-category="<?= strtolower(htmlspecialchars($b['b_category'] ?? '')) ?>"
										    data-author="<?= strtolower(htmlspecialchars($b['author'] ?? '')) ?>"
										    data-status="<?= (int)$b['b_status'] ?>">
											<!-- Checkbox -->
											<td style="text-align: center;">
												<input type="checkbox" name="selected_ids[]" value="<?= $b['b_id'] ?>" class="crud-checkbox row-select-cb">
											</td>

											<!-- Image -->
											<td>
												<div class="table-thumb-box">
													<img src="<?= htmlspecialchars($img_src) ?>" alt="" onerror="this.src='../../assets/img/inner-page/news/01.jpg'">
												</div>
											</td>

											<!-- Name & Slug -->
											<td>
												<div class="fw-bold text-dark fs-6"><?= htmlspecialchars($b['b_title']) ?></div>
												<small class="text-muted"><i class="fa-solid fa-link me-1"></i><?= htmlspecialchars($b['b_url']) ?></small>
											</td>

											<!-- Category -->
											<td>
												<span class="division-badge division-export">
													<?= htmlspecialchars($b['b_category'] ?? 'Insights') ?>
												</span>
											</td>

											<!-- Author & Date -->
											<td>
												<div class="fw-semibold text-dark small"><?= htmlspecialchars($b['author'] ?? 'Antara Desk') ?></div>
												<small class="text-muted"><i class="fa-regular fa-calendar me-1"></i><?= !empty($b['b_date']) ? date('M d, Y', strtotime($b['b_date'])) : '—' ?></small>
											</td>

											<!-- Summary -->
											<td>
												<small class="text-muted text-truncate d-block" style="max-width: 260px;" title="<?= htmlspecialchars($b['b_short_desc'] ?? '') ?>">
													<?= htmlspecialchars($b['b_short_desc'] ?? 'No excerpt summary provided.') ?>
												</small>
											</td>

											<!-- Status Toggle Switch -->
											<td style="text-align: center;">
												<label class="status-switch-wrapper switch-emerald" title="Click to toggle published status">
													<input type="checkbox" 
													       class="status-toggle-switch" 
													       data-id="<?= $b['b_id'] ?>" 
													       data-table="tbl_blogs" 
													       data-field="b_status" 
													       <?= $b['b_status'] == 1 ? 'checked' : '' ?>>
													<span class="status-switch-slider"></span>
												</label>
											</td>

											<!-- Actions -->
											<td style="text-align: end;">
												<div class="d-inline-flex gap-1">
													<a href="../../blog-detail.php?url=<?= urlencode($b['b_url']) ?>" target="_blank" class="btn-action-square btn-action-view" title="Open on Live Site">
														<i class="fa-solid fa-arrow-up-right-from-square"></i>
													</a>
													<a href="edit-blogs.php?id=<?= $b['b_id'] ?>" class="btn-action-square btn-action-edit" title="Edit Article">
														<i class="fa-solid fa-pen"></i>
													</a>
													<a href="manage-blogs.php?delete=<?= $b['b_id'] ?><?= ($category != '') ? '&category='.urlencode($category) : '' ?>" class="btn-action-square btn-action-delete" onClick="return confirm('Are you sure you want to delete this article?');" title="Delete Article">
														<i class="fa-solid fa-trash"></i>
													</a>
												</div>
											</td>
										</tr>
									<?php endwhile; ?>
								<?php else: ?>
									<tr>
										<td colspan="8" class="text-center py-5 text-muted">
											<i class="fa-solid fa-newspaper fa-3x mb-3 d-block text-muted"></i>
											No articles found matching criteria.
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
								<i class="fa-solid fa-check me-1"></i> Publish
							</button>
							<button type="submit" name="batch_action" value="deactivate" class="btn btn-batch-deactivate">
								<i class="fa-solid fa-ban me-1"></i> Move to Drafts
							</button>
							<button type="submit" name="batch_action" value="delete" class="btn btn-batch-delete" onclick="return confirm('Are you sure you want to delete all selected articles?');">
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
		const searchInput = document.getElementById('articleSearchInput');
		const selectAll = document.getElementById('selectAllArticles');
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
				const totalVisible = document.querySelectorAll('.article-row:not([style*="display: none"]) .row-select-cb').length;
				const checkedVisible = document.querySelectorAll('.article-row:not([style*="display: none"]) .row-select-cb:checked').length;
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
				const rows = document.querySelectorAll('.article-row');
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
				const tableName = currentSw.getAttribute('data-table');
				const fieldName = currentSw.getAttribute('data-field') || 'b_status';
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
						if (toastMessage) toastMessage.textContent = data.message || `Article #${itemId} updated.`;
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
