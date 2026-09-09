<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";
$upload_dir = "../../uploads/home/";

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// 1. Handle Single Terroir Belt Delete
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    $img_q = mysqli_query($conn, "SELECT `image` FROM `tbl_terroir_belts` WHERE `id`=$del_id");
    if ($img_row = mysqli_fetch_assoc($img_q)) {
        if (!empty($img_row['image']) && strpos($img_row['image'], 'uploads/home/') !== false) {
            $file_to_del = "../../" . $img_row['image'];
            if (file_exists($file_to_del)) {
                @unlink($file_to_del);
            }
        }
    }
    $del = mysqli_query($conn, "DELETE FROM `tbl_terroir_belts` WHERE `id`=$del_id");
    if ($del) {
        $msg = "Terroir belt deleted successfully.";
    } else {
        $error = "Failed to delete terroir belt: " . mysqli_error($conn);
    }
}

// 2. Handle Batch Actions (Activate, Deactivate, Delete)
if (isset($_POST['batch_action']) && !empty($_POST['selected_ids'])) {
    $action = $_POST['batch_action'];
    $ids = array_map('intval', $_POST['selected_ids']);
    $id_list = implode(',', $ids);

    if ($action === 'activate') {
        mysqli_query($conn, "UPDATE `tbl_terroir_belts` SET `status`=1 WHERE `id` IN ($id_list)");
        $msg = count($ids) . " terroir belts activated successfully.";
    } elseif ($action === 'deactivate') {
        mysqli_query($conn, "UPDATE `tbl_terroir_belts` SET `status`=0 WHERE `id` IN ($id_list)");
        $msg = count($ids) . " terroir belts deactivated successfully.";
    } elseif ($action === 'delete') {
        $img_q = mysqli_query($conn, "SELECT `image` FROM `tbl_terroir_belts` WHERE `id` IN ($id_list)");
        while ($img_row = mysqli_fetch_assoc($img_q)) {
            if (!empty($img_row['image']) && strpos($img_row['image'], 'uploads/home/') !== false) {
                $file_to_del = "../../" . $img_row['image'];
                if (file_exists($file_to_del)) {
                    @unlink($file_to_del);
                }
            }
        }
        mysqli_query($conn, "DELETE FROM `tbl_terroir_belts` WHERE `id` IN ($id_list)");
        $msg = count($ids) . " terroir belts deleted successfully.";
    }
}

// 3. Handle Section Heading Update
if (isset($_POST['update_section_heading'])) {
    $t_h = mysqli_real_escape_string($conn, trim($_POST['terroir_heading']));
    $t_d = mysqli_real_escape_string($conn, trim($_POST['terroir_desc']));

    $upd = mysqli_query($conn, "UPDATE `tbl_home_content` SET 
        `terroir_heading`='$t_h',
        `terroir_desc`='$t_d'
        WHERE `id`=1");

    if ($upd) {
        $msg = "Terroir section heading & overview updated successfully!";
    } else {
        $error = "Failed to update section heading: " . mysqli_error($conn);
    }
}

// 4. Handle Add Terroir Belt
if (isset($_POST['add_belt'])) {
    $badge = mysqli_real_escape_string($conn, trim($_POST['badge']));
    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $desc = mysqli_real_escape_string($conn, trim($_POST['description']));
    $tags = mysqli_real_escape_string($conn, trim($_POST['tags']));
    $sort = (int)($_POST['sort_order'] ?? 0);
    $status = isset($_POST['status']) ? 1 : 0;
    
    $image_path = 'assets/img/commodities/hero-spices-export.jpg';
    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
        if (in_array($ext, $allowed)) {
            $new_name = "terroir_" . time() . "_" . rand(1000, 9999) . "." . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_name)) {
                $image_path = "uploads/home/" . $new_name;
            }
        }
    }

    $ins = mysqli_query($conn, "INSERT INTO `tbl_terroir_belts` 
        (`badge`, `title`, `description`, `tags`, `image`, `sort_order`, `status`) 
        VALUES ('$badge', '$title', '$desc', '$tags', '$image_path', $sort, $status)");

    if ($ins) {
        $msg = "New terroir belt added successfully!";
    } else {
        $error = "Failed to add terroir belt: " . mysqli_error($conn);
    }
}

// 5. Handle Edit Terroir Belt
if (isset($_POST['edit_belt'])) {
    $eid = (int)$_POST['belt_id'];
    $badge = mysqli_real_escape_string($conn, trim($_POST['badge']));
    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $desc = mysqli_real_escape_string($conn, trim($_POST['description']));
    $tags = mysqli_real_escape_string($conn, trim($_POST['tags']));
    $sort = (int)($_POST['sort_order'] ?? 0);
    $status = isset($_POST['status']) ? 1 : 0;

    $cur_img_q = mysqli_query($conn, "SELECT `image` FROM `tbl_terroir_belts` WHERE `id`=$eid");
    $cur_img = mysqli_fetch_assoc($cur_img_q)['image'] ?? 'assets/img/commodities/hero-spices-export.jpg';
    $image_path = $cur_img;

    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
        if (in_array($ext, $allowed)) {
            $new_name = "terroir_" . time() . "_" . rand(1000, 9999) . "." . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_name)) {
                $image_path = "uploads/home/" . $new_name;
                if (!empty($cur_img) && strpos($cur_img, 'uploads/home/') !== false && file_exists("../../" . $cur_img)) {
                    @unlink("../../" . $cur_img);
                }
            }
        }
    }

    $upd = mysqli_query($conn, "UPDATE `tbl_terroir_belts` SET 
        `badge`='$badge', `title`='$title', `description`='$desc',
        `tags`='$tags', `image`='$image_path', `sort_order`=$sort, `status`=$status
        WHERE `id`=$eid");

    if ($upd) {
        $msg = "Terroir belt #$eid updated successfully!";
    } else {
        $error = "Failed to update terroir belt: " . mysqli_error($conn);
    }
}

// Fetch Section Metadata & Belts List
$home = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `tbl_home_content` WHERE `id`=1"));

$belts_query = mysqli_query($conn, "SELECT * FROM `tbl_terroir_belts` ORDER BY `sort_order` ASC, `id` ASC");
$belts_list = [];
$total_belts = 0;
$active_belts = 0;

if ($belts_query) {
    while ($r = mysqli_fetch_assoc($belts_query)) {
        $belts_list[] = $r;
        $total_belts++;
        if ($r['status'] == 1) {
            $active_belts++;
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
            <!-- Header Title Bar & Breadcrumbs -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <div>
                    <h1 class="page-header mb-1" style="font-size: 24px; font-weight: 800; color: #123023;">
                        Agro-Climatic Sourcing Belts / Terroirs
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 13.5px;">
                        Manage geographic sourcing corridors (<span class="fw-bold text-success" id="activeBeltsCount"><?= $active_belts ?> active</span> of <?= $total_belts ?> total belts)
                    </p>
                </div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="manage-home-hero.php">Home Page CMS</a></li>
                    <li class="breadcrumb-item active">Origin Terroir Belts</li>
                </ol>
            </div>

            <!-- Quick Sub-Menu Switcher Pills -->
            <div class="cms-subnav-strip">
                <a href="manage-home-hero.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-images"></i> Hero Carousel Banners
                </a>
                <a href="manage-home-intro.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-file-lines"></i> Corporate Story Intro
                </a>
                <a href="manage-home-pillars.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-gem"></i> Why Choose Us Pillars
                </a>
                <a href="manage-home-terroir.php" class="cms-subnav-pill active">
                    <i class="fa-solid fa-mountain"></i> Origin Terroir Belts
                </a>
                <a href="../../index.php" target="_blank" class="cms-subnav-pill cms-subnav-preview">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Preview Live Homepage
                </a>
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

            <!-- Top Section Heading & Overview Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold" style="color: #123023;">
                        <i class="fa-solid fa-heading text-warning me-2"></i> Section Heading &amp; Introduction
                    </h5>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHeadingCard">
                        <i class="fa-solid fa-chevron-down me-1"></i> Toggle Heading Settings
                    </button>
                </div>
                <div class="collapse show" id="collapseHeadingCard">
                    <div class="card-body p-4 bg-white">
                        <form method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark mb-1">Section Main Heading <span class="text-danger">*</span></label>
                                    <input type="text" name="terroir_heading" class="form-control" value="<?= htmlspecialchars($home['terroir_heading'] ?? 'Prime Sourcing Belts Across India') ?>" placeholder="e.g. Prime Sourcing Belts Across India" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark mb-1">Section Description Summary</label>
                                    <input type="text" name="terroir_desc" class="form-control" value="<?= htmlspecialchars($home['terroir_desc'] ?? 'Explore celebrated agricultural zones producing our export-grade coffee, teas, and spices with authentic geographic provenance.') ?>" placeholder="Short introductory sentence...">
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" name="update_section_heading" class="btn btn-warning px-4 py-2 rounded-pill fw-bold shadow-sm">
                                        <i class="fa-solid fa-floppy-disk me-1"></i> Save Section Heading
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Table CRUD Card Container (Matching Hero Banner Layout) -->
            <div class="table-crud-card">
                <!-- Top Actions Bar: Search, Sort Dropdown & Add Button -->
                <div class="table-crud-header">
                    <div class="d-flex flex-wrap align-items-center gap-3 flex-grow-1">
                        <!-- Search Box -->
                        <div class="table-crud-search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="beltSearchInput" class="form-control" placeholder="Search belts by title, badge, tags...">
                        </div>

                        <!-- Sort Filter Dropdown -->
                        <div class="table-crud-sort">
                            <select id="beltSortSelect" class="form-select no-select2">
                                <option value="sort_asc">Sort Order (Low to High)</option>
                                <option value="latest">Latest First</option>
                                <option value="active_first">Active First</option>
                                <option value="title_asc">Title (A-Z)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Add New Belt Button -->
                    <div>
                        <button type="button" class="btn btn-antara-gold px-4 py-2 rounded-pill fw-bold shadow-sm d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addBeltModal">
                            <i class="fa-solid fa-plus"></i> Add Terroir Belt
                        </button>
                    </div>
                </div>

                <!-- Form for Batch Actions wrapping the Table -->
                <form method="POST" id="batchActionForm">
                    <div class="table-responsive">
                        <table class="table table-crud-table" id="beltsTable">
                            <thead>
                                <tr>
                                    <th style="width: 48px; text-align: center;">
                                        <input type="checkbox" id="selectAllBelts" class="crud-checkbox" title="Select All">
                                    </th>
                                    <th style="width: 80px; text-align: center;">IMAGE</th>
                                    <th style="width: 32%;">BELT TITLE &amp; REGION</th>
                                    <th style="width: 30%;">SPECIFICATIONS / TAGS</th>
                                    <th style="width: 65px; text-align: center;">SORT</th>
                                    <th style="width: 78px; text-align: center;">STATUS</th>
                                    <th style="width: 90px; text-align: center;">ACTION</th>
                                </tr>
                            </thead>
                            <tbody id="beltsTableBody">
                                <?php if (!empty($belts_list)): ?>
                                    <?php foreach ($belts_list as $b): 
                                        $tags_arr = array_filter(array_map('trim', explode(',', $b['tags'] ?? '')));
                                    ?>
                                        <tr class="belt-row" 
                                            data-id="<?= $b['id'] ?>"
                                            data-sort="<?= (int)$b['sort_order'] ?>"
                                            data-status="<?= (int)$b['status'] ?>"
                                            data-title="<?= strtolower(htmlspecialchars($b['title'])) ?>"
                                            data-badge="<?= strtolower(htmlspecialchars($b['badge'])) ?>"
                                            data-tags="<?= strtolower(htmlspecialchars($b['tags'])) ?>"
                                            data-desc="<?= strtolower(htmlspecialchars($b['description'])) ?>">
                                            
                                            <!-- Checkbox -->
                                            <td style="text-align: center;">
                                                <input type="checkbox" name="selected_ids[]" value="<?= $b['id'] ?>" class="crud-checkbox row-select-cb">
                                            </td>

                                            <!-- Thumbnail Image -->
                                            <td style="text-align: center;">
                                                <div class="table-thumb-box mx-auto">
                                                    <img src="../../<?= htmlspecialchars($b['image']) ?>" alt="Belt Image" onerror="this.src='assets/img/commodities/hero-spices-export.jpg'">
                                                </div>
                                            </td>

                                            <!-- Title & Badge -->
                                            <td>
                                                <div class="fw-bold text-dark" style="font-size: 14px; line-height: 1.35;">
                                                    <?= htmlspecialchars($b['title']) ?>
                                                </div>
                                                <div class="d-flex flex-wrap align-items-center gap-2 mt-1">
                                                    <?php if (!empty($b['badge'])): ?>
                                                        <span class="badge badge-antara-secondary" style="font-size: 11px;">
                                                            <i class="fa-solid fa-map-pin text-warning me-1"></i> <?= htmlspecialchars($b['badge']) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="table-desc-text mt-1" style="font-size: 12px; color: #64748B;" title="<?= htmlspecialchars($b['description']) ?>">
                                                    <?= htmlspecialchars($b['description']) ?>
                                                </div>
                                            </td>

                                            <!-- Tags / Spec Pills -->
                                            <td>
                                                <div class="d-flex flex-wrap gap-1">
                                                    <?php if (!empty($tags_arr)): ?>
                                                        <?php foreach ($tags_arr as $t): ?>
                                                            <span class="badge bg-light text-dark border" style="font-size: 10.5px;">
                                                                <?= htmlspecialchars($t) ?>
                                                            </span>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <span class="text-muted small">—</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>

                                            <!-- Sort order -->
                                            <td style="text-align: center;">
                                                <span class="table-sort-badge">
                                                    <?= (int)$b['sort_order'] ?>
                                                </span>
                                            </td>

                                            <!-- Status Toggle Switch (Universal Capsule Slider) -->
                                            <td style="text-align: center;">
                                                <label class="status-switch-wrapper" title="Click to toggle active status">
                                                    <input type="checkbox" 
                                                           class="status-toggle-switch"
                                                           data-id="<?= $b['id'] ?>"
                                                           data-table="tbl_terroir_belts"
                                                           data-field="status"
                                                           <?= $b['status'] == 1 ? 'checked' : '' ?>>
                                                    <span class="status-switch-slider"></span>
                                                </label>
                                            </td>

                                            <!-- Action Buttons -->
                                            <td style="text-align: center;">
                                                <div class="d-inline-flex gap-1 justify-content-center">
                                                    <button type="button" class="btn-action-square btn-action-edit" data-bs-toggle="modal" data-bs-target="#editBeltModal<?= $b['id'] ?>" title="Edit Terroir Belt">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </button>
                                                    <a href="manage-home-terroir.php?delete=<?= $b['id'] ?>" class="btn-action-square btn-action-delete" onclick="return confirm('Are you sure you want to delete this terroir belt?');" title="Delete Terroir Belt">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr id="noBeltsRow">
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-mountain fa-3x mb-3 d-block text-secondary opacity-50"></i>
                                            <h5>No Terroir Sourcing Belts Found</h5>
                                            <p class="mb-3">Click "+ Add Terroir Belt" above to configure your regional agricultural corridors.</p>
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
                            <button type="submit" name="batch_action" value="delete" class="btn btn-batch-delete" onclick="return confirm('Are you sure you want to delete all selected terroir belts?');">
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

    <!-- Add Terroir Belt Modal -->
    <div class="modal fade" id="addBeltModal" tabindex="-1" aria-labelledby="addBeltModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #123023 0%, #1B4533 100%);">
                    <h5 class="modal-title fw-bold" id="addBeltModalLabel" style="color: #FFFFFF !important;">
                        <i class="fa-solid fa-plus-circle text-warning me-2"></i> Add New Terroir Sourcing Belt
                    </h5>
                    <button type="button" class="modal-close-btn" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold text-dark mb-1">Belt / Corridor Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" placeholder="e.g. Coorg & Chikmagalur Highlands" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark mb-1">Region Badge <span class="text-danger">*</span></label>
                                <input type="text" name="badge" class="form-control" placeholder="e.g. Southern Western Ghats" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-dark mb-1">Specification &amp; Port Tags <small class="text-muted fw-normal">(Comma-separated)</small></label>
                                <input type="text" name="tags" class="form-control" placeholder="e.g. Arabica AA / AB, Robusta AAA, Mangalore Port">
                                <small class="text-muted mt-1 d-block">Separate each tag/spec with a comma. These appear as pills on the card.</small>
                            </div>

                            <div class="col-md-8">
                                <label class="form-label fw-bold text-dark mb-1">Card Background Image <span class="text-danger">*</span></label>
                                <input type="file" name="image" class="form-control" accept="image/*" required>
                                <small class="text-muted mt-1 d-block">Recommended size: 600x420px high quality landscape photo.</small>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark mb-1">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" value="0" min="0">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-dark mb-1">Description Paragraph <span class="text-danger">*</span></label>
                                <textarea name="description" class="form-control no-ckeditor" rows="3" placeholder="Explain the altitude, soil, micro-climate, or commodity traits..." required></textarea>
                            </div>

                            <div class="col-12">
                                <div class="modal-toggle-card">
                                    <div class="modal-toggle-left">
                                        <div class="modal-toggle-icon">
                                            <i class="fa-solid fa-toggle-on"></i>
                                        </div>
                                        <div>
                                            <div class="modal-toggle-title">Active Status</div>
                                            <div class="modal-toggle-desc">Publish this terroir belt directly on the homepage showcase</div>
                                        </div>
                                    </div>
                                    <div class="modal-toggle-right">
                                        <label class="status-switch-wrapper">
                                            <input type="checkbox" name="status" class="status-toggle-switch" value="1" checked>
                                            <span class="status-switch-slider"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer py-3 px-4 bg-light border-top d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary px-4 py-2 rounded-pill fw-semibold" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_belt" class="btn btn-antara-gold px-4 py-2 rounded-pill fw-bold shadow-sm d-flex align-items-center gap-2">
                            <i class="fa-solid fa-plus-circle"></i> Save Terroir Belt
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Terroir Belt Modals -->
    <?php if (!empty($belts_list)): ?>
        <?php foreach ($belts_list as $b): ?>
            <div class="modal fade" id="editBeltModal<?= $b['id'] ?>" tabindex="-1" aria-labelledby="editBeltModalLabel<?= $b['id'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #123023 0%, #1B4533 100%);">
                            <h5 class="modal-title fw-bold" id="editBeltModalLabel<?= $b['id'] ?>" style="color: #FFFFFF !important;">
                                <i class="fa-solid fa-pen-to-square text-warning me-2"></i> Edit Terroir Belt #<?= $b['id'] ?>
                            </h5>
                            <button type="button" class="modal-close-btn" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="belt_id" value="<?= $b['id'] ?>">

                            <div class="modal-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label class="form-label fw-bold text-dark mb-1">Belt / Corridor Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($b['title']) ?>" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-dark mb-1">Region Badge <span class="text-danger">*</span></label>
                                        <input type="text" name="badge" class="form-control" value="<?= htmlspecialchars($b['badge']) ?>" required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark mb-1">Specification &amp; Port Tags <small class="text-muted fw-normal">(Comma-separated)</small></label>
                                        <input type="text" name="tags" class="form-control" value="<?= htmlspecialchars($b['tags']) ?>">
                                        <small class="text-muted mt-1 d-block">Separate each tag/spec with a comma. These appear as pills on the card.</small>
                                    </div>

                                    <div class="col-md-8">
                                        <label class="form-label fw-bold text-dark mb-1">Replace Card Image</label>
                                        <input type="file" name="image" class="form-control mb-2" accept="image/*">
                                        <div class="d-flex align-items-center gap-2 p-2 bg-light rounded border">
                                            <img src="../../<?= htmlspecialchars($b['image']) ?>" alt="Current Image" style="width: 50px; height: 35px; object-fit: cover; border-radius: 4px;" onerror="this.src='assets/img/commodities/hero-spices-export.jpg'">
                                            <span class="text-muted small text-truncate" style="max-width: 300px;"><?= htmlspecialchars($b['image']) ?></span>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-dark mb-1">Sort Order</label>
                                        <input type="number" name="sort_order" class="form-control" value="<?= (int)$b['sort_order'] ?>" min="0">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark mb-1">Description Paragraph <span class="text-danger">*</span></label>
                                        <textarea name="description" class="form-control no-ckeditor" rows="3" required><?= htmlspecialchars($b['description']) ?></textarea>
                                    </div>

                                    <div class="col-12">
                                        <div class="modal-toggle-card">
                                            <div class="modal-toggle-left">
                                                <div class="modal-toggle-icon">
                                                    <i class="fa-solid fa-toggle-on"></i>
                                                </div>
                                                <div>
                                                    <div class="modal-toggle-title">Active Status</div>
                                                    <div class="modal-toggle-desc">Publish this terroir belt directly on the homepage showcase</div>
                                                </div>
                                            </div>
                                            <div class="modal-toggle-right">
                                                <label class="status-switch-wrapper">
                                                    <input type="checkbox" name="status" class="status-toggle-switch" value="1" <?= $b['status'] == 1 ? 'checked' : '' ?>>
                                                    <span class="status-switch-slider"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer py-3 px-4 bg-light border-top d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary px-4 py-2 rounded-pill fw-semibold" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" name="edit_belt" class="btn btn-antara-gold px-4 py-2 rounded-pill fw-bold shadow-sm d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-floppy-disk"></i> Update Terroir Belt
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Scripts -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/js/apps.min.js"></script>
    <script>
        $(document).ready(function() {
            App.init();

            // Client-side instant search filtering
            $('#beltSearchInput').on('keyup', function() {
                var query = $(this).val().toLowerCase().trim();
                $('#beltsTableBody tr.belt-row').each(function() {
                    var title = $(this).data('title') || '';
                    var badge = $(this).data('badge') || '';
                    var tags = $(this).data('tags') || '';
                    var desc = $(this).data('desc') || '';
                    
                    if (title.indexOf(query) !== -1 || badge.indexOf(query) !== -1 || tags.indexOf(query) !== -1 || desc.indexOf(query) !== -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Client-side sort filtering
            $('#beltSortSelect').on('change', function() {
                var mode = $(this).val();
                var rows = $('#beltsTableBody tr.belt-row').get();

                rows.sort(function(a, b) {
                    if (mode === 'sort_asc') {
                        return $(a).data('sort') - $(b).data('sort');
                    } else if (mode === 'latest') {
                        return $(b).data('id') - $(a).data('id');
                    } else if (mode === 'active_first') {
                        return $(b).data('status') - $(a).data('status');
                    } else if (mode === 'title_asc') {
                        return $(a).data('title').localeCompare($(b).data('title'));
                    }
                    return 0;
                });

                $.each(rows, function(idx, item) {
                    $('#beltsTableBody').append(item);
                });
            });

            // Select All Checkbox & Batch Floating Toolbar
            $('#selectAllBelts').on('change', function() {
                $('.row-select-cb').prop('checked', $(this).prop('checked'));
                updateBatchBar();
            });

            $(document).on('change', '.row-select-cb', function() {
                updateBatchBar();
            });

            function updateBatchBar() {
                var count = $('.row-select-cb:checked').length;
                $('#selectedCountBadge').text(count + ' selected');
                if (count > 0) {
                    $('#batchActionBar').addClass('show');
                } else {
                    $('#batchActionBar').removeClass('show');
                }
            }
        });
    </script>
</body>
</html>
