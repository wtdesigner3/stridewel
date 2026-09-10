<?php 
require('checksession.php'); 
require('../inc/function.php');

$msg = "";
$error = "";

// 1. Handle Status Toggle
if (isset($_GET['toggle_status']) && isset($_GET['id'])) {
    $cid = (int)$_GET['id'];
    $new_st = ((int)$_GET['toggle_status'] == 1) ? 0 : 1;
    if ($conn) {
        mysqli_query($conn, "UPDATE `tbl_blog_categories` SET `status`=$new_st WHERE `id`=$cid");
    }
    $msg = "Blog category status updated.";
}

// 2. Handle Delete
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    if ($conn) {
        // Fetch category name before delete
        $cat_q = mysqli_query($conn, "SELECT `name` FROM `tbl_blog_categories` WHERE `id`=$del_id");
        $cat_row = mysqli_fetch_assoc($cat_q);
        if ($cat_row) {
            $cat_name = mysqli_real_escape_string($conn, $cat_row['name']);
            // Count blogs under this category
            $cnt_q = mysqli_query($conn, "SELECT COUNT(*) as c FROM `tbl_blogs` WHERE `b_category`='$cat_name'");
            $cnt = mysqli_fetch_assoc($cnt_q)['c'] ?? 0;
            if ($cnt > 0) {
                $error = "Cannot delete category '$cat_row[name]' because $cnt article(s) are currently assigned to it. Please reassign those articles first.";
            } else {
                mysqli_query($conn, "DELETE FROM `tbl_blog_categories` WHERE `id`=$del_id");
                $msg = "Blog Category '$cat_row[name]' removed successfully.";
            }
        }
    }
}

// 3. Handle Add Category
if (isset($_POST['add_category'])) {
    $name = trim(strip_tags($_POST['name'] ?? ''));
    $sort = (int)($_POST['sort_order'] ?? 0);
    $status = isset($_POST['status']) ? 1 : 0;

    if (!empty($name)) {
        $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $name));
        $slug = trim($slug, '-');
        $name_esc = mysqli_real_escape_string($conn, $name);
        $slug_esc = mysqli_real_escape_string($conn, $slug);

        // Check if name exists
        $chk = mysqli_query($conn, "SELECT `id` FROM `tbl_blog_categories` WHERE `name`='$name_esc'");
        if (mysqli_num_rows($chk) > 0) {
            $error = "A category named '$name' already exists.";
        } else {
            $ins = mysqli_query($conn, "INSERT INTO `tbl_blog_categories` (`name`, `slug`, `sort_order`, `status`) VALUES ('$name_esc', '$slug_esc', $sort, $status)");
            if ($ins) {
                $msg = "Blog Category '$name' added successfully!";
            } else {
                $error = "Failed to add category: " . mysqli_error($conn);
            }
        }
    } else {
        $error = "Category name cannot be empty.";
    }
}

// 4. Handle Edit Category
if (isset($_POST['edit_category'])) {
    $eid = (int)$_POST['category_id'];
    $name = trim(strip_tags($_POST['name'] ?? ''));
    $sort = (int)($_POST['sort_order'] ?? 0);
    $status = isset($_POST['status']) ? 1 : 0;

    if (!empty($name) && $eid > 0) {
        $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $name));
        $slug = trim($slug, '-');
        $name_esc = mysqli_real_escape_string($conn, $name);
        $slug_esc = mysqli_real_escape_string($conn, $slug);

        // Fetch old name to update blogs if name changed
        $old_q = mysqli_query($conn, "SELECT `name` FROM `tbl_blog_categories` WHERE `id`=$eid");
        $old_name = mysqli_fetch_assoc($old_q)['name'] ?? '';

        $upd = mysqli_query($conn, "UPDATE `tbl_blog_categories` SET `name`='$name_esc', `slug`='$slug_esc', `sort_order`=$sort, `status`=$status WHERE `id`=$eid");
        if ($upd) {
            // Update linked blogs if category name changed
            if (!empty($old_name) && $old_name !== $name) {
                $old_esc = mysqli_real_escape_string($conn, $old_name);
                mysqli_query($conn, "UPDATE `tbl_blogs` SET `b_category`='$name_esc' WHERE `b_category`='$old_esc'");
            }
            $msg = "Blog Category '$name' updated successfully!";
        } else {
            $error = "Failed to update category: " . mysqli_error($conn);
        }
    } else {
        $error = "Please provide a valid category name.";
    }
}

// Fetch all categories with count of blogs
$categories = [];
$cq = mysqli_query($conn, "SELECT c.*, (SELECT COUNT(*) FROM `tbl_blogs` b WHERE b.`b_category` = c.`name`) as blog_count FROM `tbl_blog_categories` c ORDER BY c.`sort_order` ASC, c.`id` ASC");
if ($cq) {
    while ($row = mysqli_fetch_assoc($cq)) {
        $categories[] = $row;
    }
}

$total_cats = count($categories);
$active_cats = count(array_filter($categories, fn($c) => $c['status'] == 1));
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
						<li class="breadcrumb-item"><a href="manage-blogs.php">Blog CMS</a></li>
						<li class="breadcrumb-item active">Blog Categories</li>
					</ol>
					<h1 class="page-header mb-0">
						<i class="fa-solid fa-tags text-danger me-2"></i> Blog Category Management
					</h1>
				</div>
				<div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
					<a href="manage-blogs.php" class="btn btn-outline-secondary px-3">
						<i class="fa-solid fa-newspaper me-1"></i> All Articles
					</a>
					<a href="add-blogs.php" class="btn btn-danger fw-bold shadow-sm px-3">
						<i class="fa-solid fa-plus-circle me-1"></i> Add New Article
					</a>
				</div>
			</div>

			<!-- Quick Sub-Menu Navigation -->
			<div class="cms-subnav-strip mb-4">
				<a href="manage-blogs.php" class="cms-subnav-pill">
					<i class="fa-solid fa-newspaper"></i> All Articles
				</a>
				<a href="add-blogs.php" class="cms-subnav-pill">
					<i class="fa-solid fa-circle-plus"></i> Add Article
				</a>
				<a href="manage-blog-categories.php" class="cms-subnav-pill active">
					<i class="fa-solid fa-tags"></i> Blog Categories
				</a>
				<a href="../blog.php" target="_blank" class="cms-subnav-pill cms-subnav-preview">
					<i class="fa-solid fa-arrow-up-right-from-square"></i> Preview Live Blog Page
				</a>
			</div>

			<!-- Alerts -->
			<?php if (!empty($msg)): ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<i class="fa-solid fa-circle-check me-2"></i> <?= htmlspecialchars($msg) ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<?php if (!empty($error)): ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<i class="fa-solid fa-triangle-exclamation me-2"></i> <?= htmlspecialchars($error) ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<!-- Overview Statistics -->
			<div class="row g-3 mb-4">
				<div class="col-md-6 col-lg-3">
					<div class="card border-0 shadow-sm rounded-3 p-3">
						<div class="d-flex align-items-center justify-content-between">
							<div>
								<div class="text-muted small fw-semibold text-uppercase">Total Categories</div>
								<div class="fs-3 fw-bold text-dark"><?= $total_cats ?></div>
							</div>
							<div class="badge bg-danger-subtle text-danger fs-4 p-2 rounded-3">
								<i class="fa-solid fa-tags"></i>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-3">
					<div class="card border-0 shadow-sm rounded-3 p-3">
						<div class="d-flex align-items-center justify-content-between">
							<div>
								<div class="text-muted small fw-semibold text-uppercase">Active Categories</div>
								<div class="fs-3 fw-bold text-success"><?= $active_cats ?></div>
							</div>
							<div class="badge bg-success-subtle text-success fs-4 p-2 rounded-3">
								<i class="fa-solid fa-check"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row g-4">
				<!-- Left Column: Add New Category Form -->
				<div class="col-lg-4">
					<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
						<div class="card-header bg-white py-3 px-4 border-bottom">
							<h5 class="fw-bold mb-0 text-dark">
								<i class="fa-solid fa-plus text-danger me-2"></i> Create Blog Category
							</h5>
						</div>
						<div class="card-body p-4">
							<form method="POST">
								<div class="mb-3">
									<label class="form-label fw-bold text-dark">Category Name <span class="text-danger">*</span></label>
									<input type="text" name="name" class="form-control" placeholder="e.g. Clinical Field Reports" required>
									<small class="text-muted">Used for article filtering and tags across the blog showcase.</small>
								</div>
								<div class="mb-3">
									<label class="form-label fw-bold text-dark">Display Sort Order</label>
									<input type="number" name="sort_order" class="form-control" value="0" placeholder="0">
									<small class="text-muted">Controls sort ordering in category filters.</small>
								</div>
								<div class="form-check form-switch mb-4">
									<input class="form-check-input" type="checkbox" name="status" id="addStatus" checked>
									<label class="form-check-label fw-bold" for="addStatus">Active / Published</label>
								</div>
								<button type="submit" name="add_category" class="btn btn-danger w-100 fw-bold shadow-sm py-2">
									<i class="fa-solid fa-plus-circle me-1"></i> Save Blog Category
								</button>
							</form>
						</div>
					</div>
				</div>

				<!-- Right Column: Categories List Table -->
				<div class="col-lg-8">
					<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
						<div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
							<h5 class="fw-bold mb-0 text-dark">
								<i class="fa-solid fa-list text-primary me-2"></i> Existing Blog Categories (<?= $total_cats ?>)
							</h5>
						</div>
						<div class="card-body p-0">
							<div class="table-responsive">
								<table class="table table-hover align-middle mb-0">
									<thead class="table-light">
										<tr>
											<th style="width: 60px;">#</th>
											<th>Category Name</th>
											<th>Slug</th>
											<th class="text-center" style="width: 120px;">Linked Articles</th>
											<th class="text-center" style="width: 80px;">Sort</th>
											<th class="text-center" style="width: 100px;">Status</th>
											<th class="text-end pe-4" style="width: 120px;">Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php if (!empty($categories)): ?>
											<?php foreach ($categories as $idx => $c): ?>
												<tr>
													<td class="text-muted fw-bold"><?= $idx + 1 ?></td>
													<td>
														<div class="fw-bold text-dark"><?= htmlspecialchars($c['name']) ?></div>
													</td>
													<td>
														<code class="text-muted small"><?= htmlspecialchars($c['slug']) ?></code>
													</td>
													<td class="text-center">
														<span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-1 fw-bold">
															<?= (int)$c['blog_count'] ?> Articles
														</span>
													</td>
													<td class="text-center fw-bold text-secondary">
														<?= (int)$c['sort_order'] ?>
													</td>
													<td class="text-center">
														<?php if ($c['status'] == 1): ?>
															<a href="manage-blog-categories.php?toggle_status=1&id=<?= $c['id'] ?>" class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill text-decoration-none fw-bold" title="Click to Deactivate">
																Active
															</a>
														<?php else: ?>
															<a href="manage-blog-categories.php?toggle_status=0&id=<?= $c['id'] ?>" class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 rounded-pill text-decoration-none fw-bold" title="Click to Activate">
																Inactive
															</a>
														<?php endif; ?>
													</td>
													<td class="text-end pe-4">
														<div class="btn-group btn-group-sm">
															<button type="button" class="btn btn-outline-primary btn-sm rounded-2 me-1 edit-cat-btn"
																data-toggle="modal"
																data-target="#editCatModal"
																data-bs-toggle="modal"
																data-bs-target="#editCatModal"
																data-id="<?= $c['id'] ?>"
																data-name="<?= htmlspecialchars($c['name']) ?>"
																data-sort="<?= (int)$c['sort_order'] ?>"
																data-status="<?= $c['status'] ?>"
																title="Edit Category">
																<i class="fa-solid fa-pen-to-square"></i>
															</button>
															<a href="manage-blog-categories.php?delete=<?= $c['id'] ?>" class="btn btn-outline-danger btn-sm rounded-2" onclick="return confirm('Delete category \'<?= addslashes(htmlspecialchars($c['name'])) ?>\'?');" title="Delete Category">
																<i class="fa-solid fa-trash-can"></i>
															</a>
														</div>
													</td>
												</tr>
											<?php endforeach; ?>
										<?php else: ?>
											<tr>
												<td colspan="7" class="text-center py-5 text-muted">
													No blog categories found. Add your first category using the form on the left.
												</td>
											</tr>
										<?php endif; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		<?php require('includes/footer.php'); ?>
	</div>

	<!-- Edit Category Modal -->
	<div class="modal fade" id="editCatModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
				<form method="POST">
					<input type="hidden" name="category_id" id="editCatId">
					<div class="modal-header bg-white py-3 px-4 border-bottom">
						<h5 class="modal-title fw-bold text-dark">
							<i class="fa-solid fa-pen-to-square text-primary me-2"></i> Edit Blog Category
						</h5>
						<button type="button" class="btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body p-4 bg-white">
						<div class="mb-3">
							<label class="form-label fw-bold text-dark">Category Name <span class="text-danger">*</span></label>
							<input type="text" name="name" id="editCatName" class="form-control" required>
						</div>
						<div class="mb-3">
							<label class="form-label fw-bold text-dark">Display Sort Order</label>
							<input type="number" name="sort_order" id="editCatSort" class="form-control" value="0">
						</div>
						<div class="form-check form-switch mt-2">
							<input class="form-check-input" type="checkbox" name="status" id="editCatStatus">
							<label class="form-check-label fw-bold" for="editCatStatus">Active / Published</label>
						</div>
					</div>
					<div class="modal-footer bg-light py-3 px-4 border-top">
						<button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-dismiss="modal" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" name="edit_category" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Save Changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			if (typeof App !== 'undefined' && typeof App.init === 'function') {
				try { App.init(); } catch(e) { console.warn('App.init:', e); }
			}

			function populateCatModal(btn) {
				if (!btn || !btn.length) return;
				var id = btn.attr('data-id') || btn.data('id');
				var name = btn.attr('data-name') || btn.data('name');
				var sort = btn.attr('data-sort') || btn.data('sort');
				var status = btn.attr('data-status') || btn.data('status');

				$('#editCatId').val(id);
				$('#editCatName').val(name);
				$('#editCatSort').val(sort);
				$('#editCatStatus').prop('checked', status == 1 || status == '1');
			}

			$(document).on('click', '.edit-cat-btn', function(e) {
				var btn = $(this).closest('.edit-cat-btn');
				populateCatModal(btn);
			});

			$('#editCatModal').on('show.bs.modal', function(e) {
				var btn = $(e.relatedTarget);
				if (btn && btn.length) {
					populateCatModal(btn);
				}
			});
		});
	</script>
</body>
</html>
