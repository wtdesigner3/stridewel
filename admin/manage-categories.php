<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// Ensure upload directory exists
$upload_dir = "../uploads/categories/";
if (!is_dir($upload_dir)) {
    @mkdir($upload_dir, 0777, true);
}

// 1. Handle Single Status Toggle (GET fallback)
if (isset($_GET['toggle_status']) && isset($_GET['id'])) {
    $cid = (int)$_GET['id'];
    $cur = (int)$_GET['toggle_status'];
    $new_st = ($cur == 1) ? 0 : 1;
    mysqli_query($conn, "UPDATE `tbl_category` SET `status`=$new_st WHERE `id`=$cid");
    header("Location: manage-categories.php?msg=Category+status+updated");
    exit;
}

// 2. Handle Single Delete
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    $get_img = mysqli_query($conn, "SELECT `image` FROM `tbl_category` WHERE `id`=$del_id");
    if ($img_row = mysqli_fetch_assoc($get_img)) {
        if (!empty($img_row['image']) && strpos($img_row['image'], 'uploads/categories/') !== false) {
            $file_to_del = "../" . $img_row['image'];
            if (file_exists($file_to_del)) {
                @unlink($file_to_del);
            }
        }
    }
    mysqli_query($conn, "DELETE FROM `tbl_category` WHERE `id`=$del_id");
    header("Location: manage-categories.php?msg=Category+deleted+successfully");
    exit;
}

// 3. Handle Batch Actions
if (isset($_POST['batch_action']) && !empty($_POST['selected_ids'])) {
    $action = $_POST['batch_action'];
    $ids = array_map('intval', $_POST['selected_ids']);
    $id_list = implode(',', $ids);

    if ($action === 'activate') {
        mysqli_query($conn, "UPDATE `tbl_category` SET `status`=1 WHERE `id` IN ($id_list)");
        $msg = count($ids) . " categories activated successfully.";
    } elseif ($action === 'deactivate') {
        mysqli_query($conn, "UPDATE `tbl_category` SET `status`=0 WHERE `id` IN ($id_list)");
        $msg = count($ids) . " categories deactivated successfully.";
    } elseif ($action === 'delete') {
        $img_q = mysqli_query($conn, "SELECT `image` FROM `tbl_category` WHERE `id` IN ($id_list)");
        while ($img_row = mysqli_fetch_assoc($img_q)) {
            if (!empty($img_row['image']) && strpos($img_row['image'], 'uploads/categories/') !== false) {
                $file_to_del = "../" . $img_row['image'];
                if (file_exists($file_to_del)) {
                    @unlink($file_to_del);
                }
            }
        }
        mysqli_query($conn, "DELETE FROM `tbl_category` WHERE `id` IN ($id_list)");
        $msg = count($ids) . " categories deleted successfully.";
    }
}

// 4. Handle Add Category
if (isset($_POST['add_category'])) {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $slug = mysqli_real_escape_string($conn, trim($_POST['slug']));
    if (empty($slug)) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    }
    $division = mysqli_real_escape_string($conn, $_POST['division'] ?? 'veterinary');
    $title = mysqli_real_escape_string($conn, trim(strip_tags($_POST['title'] ?? '')));
    $desc = mysqli_real_escape_string($conn, trim(strip_tags($_POST['desc'] ?? '')));
    $sort = (int)($_POST['sort'] ?? 0);
    $status = isset($_POST['status']) ? 1 : 0;

    $image_path = 'assets/img/commodities/hero-export-banner.jpg';
    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
        if (in_array($ext, $allowed)) {
            $new_name = "cat_" . time() . "_" . rand(1000, 9999) . "." . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_name)) {
                $image_path = "uploads/categories/" . $new_name;
            }
        }
    }

    $ins = mysqli_query($conn, "INSERT INTO `tbl_category` 
        (`name`, `slug`, `division`, `title`, `desc`, `image`, `sort`, `status`) 
        VALUES ('$name', '$slug', '$division', '$title', '$desc', '$image_path', $sort, $status)");

    if ($ins) {
        $msg = "New product category added successfully!";
    } else {
        $error = "Failed to add category: " . mysqli_error($conn);
    }
}

// 5. Handle Edit Category
if (isset($_POST['edit_category'])) {
    $eid = (int)$_POST['category_id'];
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $slug = mysqli_real_escape_string($conn, trim($_POST['slug']));
    $division = mysqli_real_escape_string($conn, $_POST['division'] ?? 'veterinary');
    $title = mysqli_real_escape_string($conn, trim(strip_tags($_POST['title'] ?? '')));
    $desc = mysqli_real_escape_string($conn, trim(strip_tags($_POST['desc'] ?? '')));
    $sort = (int)($_POST['sort'] ?? 0);
    $status = isset($_POST['status']) ? 1 : 0;

    $cur_img_q = mysqli_query($conn, "SELECT `image` FROM `tbl_category` WHERE `id`=$eid");
    $cur_img = mysqli_fetch_assoc($cur_img_q)['image'] ?? 'assets/img/commodities/hero-export-banner.jpg';
    $image_path = $cur_img;

    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
        if (in_array($ext, $allowed)) {
            $new_name = "cat_" . time() . "_" . rand(1000, 9999) . "." . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_name)) {
                $image_path = "uploads/categories/" . $new_name;
            }
        }
    }

    $upd = mysqli_query($conn, "UPDATE `tbl_category` SET 
        `name`='$name', `slug`='$slug', `division`='$division',
        `title`='$title', `desc`='$desc', `image`='$image_path',
        `sort`=$sort, `status`=$status
        WHERE `id`=$eid");

    if ($upd) {
        $msg = "Category updated successfully!";
    } else {
        $error = "Failed to update category: " . mysqli_error($conn);
    }
}

if (isset($_GET['msg'])) {
    $msg = htmlspecialchars($_GET['msg']);
}

// Fetch categories
$cats_q = mysqli_query($conn, "SELECT * FROM `tbl_category` ORDER BY `sort` ASC, `id` DESC");
$categories = [];
$total_cats = 0;
$active_cats = 0;

if ($cats_q) {
    while ($row = mysqli_fetch_assoc($cats_q)) {
        $categories[] = $row;
        $total_cats++;
        if ($row['status'] == 1) {
            $active_cats++;
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
            <!-- Header Title Bar & Breadcrumbs matching reference design -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <div>
                    <h1 class="page-header mb-1" style="font-size: 24px; font-weight: 800; color: #103755;">
                        Product Categories
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 13.5px;">
                        Manage your categories (<span class="fw-bold text-success" id="activeCatsCount"><?= $active_cats ?> active</span> of <?= $total_cats ?> total)
                    </p>
                </div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php"><i class="fa-solid fa-house me-1"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="manage-products.php">Products</a></li>
                    <li class="breadcrumb-item active">Categories</li>
                </ol>
            </div>

            <!-- Alerts -->
            <?php if (!empty($msg)): ?>
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4 shadow-sm" role="alert">
                    <i class="fa-solid fa-circle-check fs-4 me-3 text-success"></i>
                    <div><strong>Success:</strong> <?= htmlspecialchars($msg) ?></div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4 shadow-sm" role="alert">
                    <i class="fa-solid fa-triangle-exclamation fs-4 me-3 text-danger"></i>
                    <div><strong>Error:</strong> <?= htmlspecialchars($error) ?></div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Table CRUD Card Container (matches user reference image) -->
            <div class="table-crud-card">
                <!-- Header Controls: Search, Sort Dropdown & Add Category Button -->
                <div class="table-crud-header">
                    <div class="d-flex flex-wrap align-items-center gap-3 flex-grow-1">
                        <!-- Search Box -->
                        <div class="table-crud-search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="catSearchInput" class="form-control" placeholder="Search...">
                        </div>

                        <!-- Sort Dropdown -->
                        <div class="table-crud-sort">
                            <select id="catSortSelect" class="form-select no-select2">
                                <option value="latest">Latest First</option>
                                <option value="sort_asc">Sort Order (Low to High)</option>
                                <option value="active_first">Active First</option>
                                <option value="name_asc">Name (A-Z)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Add Category Button -->
                    <div>
                        <button type="button" class="btn btn-primary px-4 py-2 rounded-pill fw-bold shadow-sm d-flex align-items-center gap-2" style="background: #2563EB; border-color: #2563EB;" data-toggle="modal" data-target="#addCatModal" data-bs-toggle="modal" data-bs-target="#addCatModal">
                            <i class="fa-solid fa-plus"></i> Add Category
                        </button>
                    </div>
                </div>

                <!-- Form wrapping Table for Multi-select Batch Actions -->
                <form method="POST" id="catBatchForm">
                    <div class="table-responsive">
                        <table class="table table-crud-table" id="categoriesTable">
                            <thead>
                                <tr>
                                    <th style="width: 48px; text-align: center;">
                                        <input type="checkbox" id="selectAllCats" class="crud-checkbox" title="Select All">
                                    </th>
                                    <th style="width: 70px; text-align: center;">IMAGE</th>
                                    <th style="width: 36%;">CATEGORY & SLUG</th>
                                    <th style="width: 32%;">DESCRIPTION</th>
                                    <th style="width: 65px; text-align: center;">SORT</th>
                                    <th style="width: 78px; text-align: center;">STATUS</th>
                                    <th style="width: 90px; text-align: center;">ACTION</th>
                                </tr>
                            </thead>
                            <tbody id="catsTableBody">
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $cat): ?>
                                        <tr class="cat-row <?= $cat['status'] == 1 ? '' : 'row-inactive' ?>"
                                            id="catRow<?= $cat['id'] ?>"
                                            data-id="<?= $cat['id'] ?>"
                                            data-sort="<?= (int)$cat['sort'] ?>"
                                            data-status="<?= (int)$cat['status'] ?>"
                                            data-name="<?= strtolower(htmlspecialchars($cat['name'])) ?>"
                                            data-slug="<?= strtolower(htmlspecialchars($cat['slug'])) ?>"
                                            data-desc="<?= strtolower(htmlspecialchars($cat['desc'])) ?>">

                                            <!-- Checkbox -->
                                            <td style="text-align: center;">
                                                <input type="checkbox" name="selected_ids[]" value="<?= $cat['id'] ?>" class="crud-checkbox row-select-cb">
                                            </td>

                                            <!-- Thumbnail Image -->
                                            <td style="text-align: center;">
                                                <div class="table-thumb-box mx-auto">
                                                    <img src="../<?= htmlspecialchars($cat['image']) ?>" alt="Category Image" onerror="this.src='assets/img/commodities/hero-export-banner.jpg'">
                                                </div>
                                            </td>

                                            <!-- Category Name & Slug -->
                                            <td>
                                                <div class="fw-bold text-dark cat-name-display" style="font-size: 14px; line-height: 1.35;">
                                                    <?= htmlspecialchars($cat['name']) ?>
                                                </div>
                                                <div class="text-muted small mt-1">
                                                    <?= htmlspecialchars($cat['slug']) ?>
                                                    <?php if (!empty($cat['division'])): ?>
                                                        <span class="badge <?= ($cat['division'] === 'veterinary' ? 'bg-primary' : ($cat['division'] === 'export' ? 'bg-success' : 'bg-info')) ?> ms-1" style="font-size: 10px; text-transform: uppercase;">
                                                            <?= htmlspecialchars($cat['division']) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>

                                            <!-- Description snippet -->
                                            <td>
                                                <div class="table-desc-text" title="<?= htmlspecialchars($cat['desc']) ?>">
                                                    <?= !empty($cat['desc']) ? htmlspecialchars($cat['desc']) : '<span class="text-muted">—</span>' ?>
                                                </div>
                                            </td>

                                            <!-- Sort order -->
                                            <td style="text-align: center;">
                                                <span class="table-sort-badge">
                                                    <?= (int)$cat['sort'] ?>
                                                </span>
                                            </td>

                                            <!-- Status Toggle Switch & Explicit Badge -->
                                            <td style="text-align: center;">
                                                <div class="d-flex flex-column align-items-center gap-1">
                                                    <label class="status-switch-wrapper mb-0" title="Click to toggle active status">
                                                        <input type="checkbox" 
                                                               class="status-toggle-switch" 
                                                               data-id="<?= $cat['id'] ?>"
                                                               data-name="<?= htmlspecialchars($cat['name']) ?>"
                                                               data-table="tbl_category"
                                                               data-field="status"
                                                               <?= $cat['status'] == 1 ? 'checked' : '' ?>>
                                                        <span class="status-switch-slider"></span>
                                                    </label>
                                                    <span class="cat-status-badge badge <?= $cat['status'] == 1 ? 'bg-success text-white' : 'bg-secondary text-white' ?>">
                                                        <?= $cat['status'] == 1 ? 'Active' : 'Inactive' ?>
                                                    </span>
                                                </div>
                                            </td>

                                            <!-- Action Buttons (Edit pencil & Delete trash) -->
                                            <td style="text-align: center;">
                                                <div class="d-inline-flex gap-1 justify-content-center">
                                                    <button type="button" class="btn-action-square btn-action-edit" data-toggle="modal" data-target="#editCatModal<?= $cat['id'] ?>" data-bs-toggle="modal" data-bs-target="#editCatModal<?= $cat['id'] ?>" title="Edit Category">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </button>
                                                    <a href="manage-categories.php?delete=<?= $cat['id'] ?>" class="btn-action-square btn-action-delete" onclick="return confirm('Are you sure you want to delete this category?');" title="Delete Category">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-folder-open fa-3x mb-3 d-block text-secondary opacity-50"></i>
                                            <h5>No Product Categories Found</h5>
                                            <p class="mb-3">Click "+ Add Category" above to create your first category.</p>
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
                            <button type="submit" name="batch_action" value="delete" class="btn btn-batch-delete" onclick="return confirm('Are you sure you want to delete all selected categories?');">
                                <i class="fa-solid fa-trash me-1"></i> Delete
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Toast Notification Container for AJAX toggles -->
    <div class="crud-toast-container">
        <div id="crudToast" class="crud-toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
                <i id="crudToastIcon" class="fa-solid fa-circle-check text-success fs-5"></i>
                <span id="crudToastMessage">Status updated</span>
            </div>
            <button type="button" class="toast-close-btn" onclick="document.getElementById('crudToast').classList.remove('show');" aria-label="Close">&times;</button>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCatModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #103755 0%, #1B4533 100%);">
                    <h5 class="modal-title fw-bold" style="color: #FFFFFF !important;">
                        <i class="fa-solid fa-plus-circle text-warning me-2"></i> Add New Product Category
                    </h5>
                    <button type="button" class="modal-close-btn" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold text-dark">Category Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Bulk Green Coffee Beans" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Division</label>
                                <select name="division" class="form-select no-select2">
                                    <option value="veterinary" selected>Veterinary & A.I. Equipment</option>
                                    <option value="export">Export Division</option>
                                    <option value="horeca">HORECA & Café</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-dark">Slug (URL identifier)</label>
                                <input type="text" name="slug" class="form-control" placeholder="auto-generated from name if left blank">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-dark">Meta Title / Subtitle</label>
                                <input type="text" name="title" class="form-control" placeholder="e.g. Export-Grade Single Origin Plantation Crops">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-dark">Description</label>
                                <textarea name="desc" class="form-control no-ckeditor" rows="3" placeholder="Category highlights and commodity description..."></textarea>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-bold text-dark">Category Image</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Sort Order</label>
                                <input type="number" name="sort" class="form-control" value="<?= $total_cats + 1 ?>" min="0">
                            </div>
                            <div class="col-12 mt-1">
                                <div class="modal-toggle-card">
                                    <label class="status-switch-wrapper switch-emerald mb-0" style="flex-shrink: 0;">
                                        <input type="checkbox" name="status" id="addCatStatus" checked>
                                        <span class="status-switch-slider"></span>
                                    </label>
                                    <label class="form-check-label" for="addCatStatus">
                                        Active Category
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light px-4 py-3">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_category" class="btn btn-antara-gold rounded-pill px-4 fw-bold">
                            <i class="fa-solid fa-cloud-arrow-up me-1"></i> Save Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Category Modals -->
    <?php if (!empty($categories)): ?>
        <?php foreach ($categories as $cat): ?>
            <div class="modal fade" id="editCatModal<?= $cat['id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #103755 0%, #1B4533 100%);">
                            <h5 class="modal-title fw-bold" style="color: #FFFFFF !important;">
                                <i class="fa-solid fa-pen-to-square text-warning me-2"></i> Edit Category #<?= $cat['id'] ?>
                            </h5>
                            <button type="button" class="modal-close-btn" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="category_id" value="<?= $cat['id'] ?>">
                            <div class="modal-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label class="form-label fw-bold text-dark">Category Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($cat['name']) ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-dark">Division</label>
                                        <select name="division" class="form-select no-select2">
                                            <option value="veterinary" <?= ($cat['division'] === 'veterinary') ? 'selected' : '' ?>>Veterinary & A.I. Equipment</option>
                                            <option value="export" <?= ($cat['division'] === 'export') ? 'selected' : '' ?>>Export Division</option>
                                            <option value="horeca" <?= ($cat['division'] === 'horeca') ? 'selected' : '' ?>>HORECA & Café</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold text-dark">Slug</label>
                                        <input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($cat['slug']) ?>">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold text-dark">Meta Title / Subtitle</label>
                                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($cat['title']) ?>">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold text-dark">Description</label>
                                        <textarea name="desc" class="form-control no-ckeditor" rows="3"><?= htmlspecialchars($cat['desc']) ?></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold text-dark">Current Image</label>
                                        <div class="mb-2 p-2 border rounded bg-light d-flex align-items-center gap-3">
                                            <img src="../<?= htmlspecialchars($cat['image']) ?>" alt="Current Image" onerror="this.src='assets/img/commodities/hero-export-banner.jpg'" style="height: 60px; width: 60px; object-fit: cover; border-radius: 8px;">
                                            <div>
                                                <div class="small fw-bold text-dark"><?= htmlspecialchars(basename($cat['image'])) ?></div>
                                                <small class="text-muted">Select a new file below to replace this image.</small>
                                            </div>
                                        </div>
                                        <input type="file" name="image" class="form-control" accept="image/*">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark">Sort Order</label>
                                        <input type="number" name="sort" class="form-control" value="<?= (int)$cat['sort'] ?>" min="0">
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center">
                                        <div class="modal-toggle-card w-100" style="margin-top: 24px;">
                                            <label class="status-switch-wrapper switch-emerald mb-0" style="flex-shrink: 0;">
                                                <input type="checkbox" name="status" id="editCatStatus<?= $cat['id'] ?>" <?= $cat['status'] == 1 ? 'checked' : '' ?>>
                                                <span class="status-switch-slider"></span>
                                            </label>
                                            <label class="form-check-label" for="editCatStatus<?= $cat['id'] ?>">
                                                Active Category
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer bg-light px-4 py-3">
                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" name="edit_category" class="btn btn-antara-gold rounded-pill px-4 fw-bold">
                                    <i class="fa-solid fa-check me-1"></i> Update Category
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php require('includes/footer.php'); ?>

    <!-- Table CRUD Operations Script for Categories -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAllCats');
        const rowCheckboxes = document.querySelectorAll('.row-select-cb');
        const batchBar = document.getElementById('batchActionBar');
        const countBadge = document.getElementById('selectedCountBadge');
        const searchInput = document.getElementById('catSearchInput');
        const sortSelect = document.getElementById('catSortSelect');
        const tableBody = document.getElementById('catsTableBody');
        const toastEl = document.getElementById('crudToast');
        const toastMessage = document.getElementById('crudToastMessage');
        const toastIcon = document.getElementById('crudToastIcon');
        const toast = (toastEl && typeof bootstrap !== 'undefined' && bootstrap.Toast) ? new bootstrap.Toast(toastEl, { delay: 3000 }) : null;

        function showToast(message, isSuccess = true) {
            if (toastMessage) toastMessage.textContent = message;
            if (toastIcon) {
                toastIcon.className = isSuccess ? 'fa-solid fa-circle-check text-success fs-5' : 'fa-solid fa-circle-xmark text-danger fs-5';
            }
            if (toastEl) {
                toastEl.classList.add('show');
                clearTimeout(window._crudToastTimer);
                window._crudToastTimer = setTimeout(() => {
                    toastEl.classList.remove('show');
                }, 3500);
            }
            if (toast && typeof toast.show === 'function') {
                try { toast.show(); } catch(e){}
            }
        }

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

        // Search Filter
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();
                const rows = document.querySelectorAll('.cat-row');
                rows.forEach(row => {
                    const name = row.getAttribute('data-name') || '';
                    const slug = row.getAttribute('data-slug') || '';
                    const desc = row.getAttribute('data-desc') || '';
                    if (query === '' || name.includes(query) || slug.includes(query) || desc.includes(query)) {
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

        // Sort Filter
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                const sortType = this.value;
                const rows = Array.from(document.querySelectorAll('.cat-row'));

                rows.sort((a, b) => {
                    const sortA = parseInt(a.getAttribute('data-sort')) || 0;
                    const sortB = parseInt(b.getAttribute('data-sort')) || 0;
                    const idA = parseInt(a.getAttribute('data-id')) || 0;
                    const idB = parseInt(b.getAttribute('data-id')) || 0;
                    const statusA = parseInt(a.getAttribute('data-status')) || 0;
                    const statusB = parseInt(b.getAttribute('data-status')) || 0;
                    const nameA = (a.getAttribute('data-name') || '').toLowerCase();
                    const nameB = (b.getAttribute('data-name') || '').toLowerCase();

                    if (sortType === 'latest') return idB - idA;
                    if (sortType === 'sort_asc') return sortA - sortB;
                    if (sortType === 'active_first') return statusB - statusA;
                    if (sortType === 'name_asc') return nameA.localeCompare(nameB);
                    return 0;
                });

                rows.forEach(row => tableBody.appendChild(row));
            });
        }

        // AJAX Status Toggle
        const statusSwitches = document.querySelectorAll('.status-toggle-switch');
        statusSwitches.forEach(sw => {
            sw.addEventListener('change', function() {
                const currentSw = this;
                const itemId = currentSw.getAttribute('data-id');
                const catName = currentSw.getAttribute('data-name') || ('Category #' + itemId);
                const tableName = currentSw.getAttribute('data-table');
                const fieldName = currentSw.getAttribute('data-field') || 'status';
                const newStatus = currentSw.checked ? 1 : 0;
                const row = currentSw.closest('tr');
                const badgeEl = row ? row.querySelector('.cat-status-badge') : null;

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
                        const statusText = newStatus === 1 ? 'Active' : 'Inactive';
                        const toastMsg = `"${catName}" is now ${statusText}.`;
                        if (typeof window.showAdminToast === 'function') {
                            window.showAdminToast(toastMsg, newStatus === 1);
                        } else {
                            showToast(toastMsg, true);
                        }

                        if (row) {
                            row.setAttribute('data-status', newStatus);
                            if (newStatus === 1) {
                                row.classList.remove('row-inactive');
                            } else {
                                row.classList.add('row-inactive');
                            }
                        }

                        if (badgeEl) {
                            badgeEl.textContent = statusText;
                            if (newStatus === 1) {
                                badgeEl.className = 'cat-status-badge badge bg-success text-white';
                            } else {
                                badgeEl.className = 'cat-status-badge badge bg-secondary text-white';
                            }
                        }

                        let activeCount = document.querySelectorAll('.status-toggle-switch:checked').length;
                        const activeCountEl = document.getElementById('activeCatsCount');
                        if (activeCountEl) {
                            activeCountEl.textContent = activeCount + ' active';
                        }
                    } else {
                        currentSw.checked = !newStatus;
                        const errText = data.error || 'Failed to update status.';
                        if (typeof window.showAdminToast === 'function') {
                            window.showAdminToast(errText, false);
                        } else {
                            showToast(errText, false);
                        }
                    }
                })
                .catch(err => {
                    currentSw.checked = !newStatus;
                    const errText = 'Network error while updating status.';
                    if (typeof window.showAdminToast === 'function') {
                        window.showAdminToast(errText, false);
                    } else {
                        showToast(errText, false);
                    }
                });
            });
        });
    });
    </script>
</body>
</html>
