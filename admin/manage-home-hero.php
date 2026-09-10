<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// Ensure upload directory exists
$upload_dir = "../uploads/home/";
if (!is_dir($upload_dir)) {
    @mkdir($upload_dir, 0777, true);
}

// 1. Handle Single Status Toggle (GET fallback)
if (isset($_GET['toggle_status']) && isset($_GET['id'])) {
    $sid = (int)$_GET['id'];
    $cur = (int)$_GET['toggle_status'];
    $new_st = ($cur == 1) ? 0 : 1;
    mysqli_query($conn, "UPDATE `tbl_hero_slides` SET `status`=$new_st WHERE `id`=$sid");
    header("Location: manage-home-hero.php?msg=Slide+status+updated");
    exit;
}

// 2. Handle Single Delete
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    $get_img = mysqli_query($conn, "SELECT `image` FROM `tbl_hero_slides` WHERE `id`=$del_id");
    if ($img_row = mysqli_fetch_assoc($get_img)) {
        if (!empty($img_row['image']) && strpos($img_row['image'], 'uploads/home/') !== false) {
            $file_to_del = "../" . $img_row['image'];
            if (file_exists($file_to_del)) {
                @unlink($file_to_del);
            }
        }
    }
    mysqli_query($conn, "DELETE FROM `tbl_hero_slides` WHERE `id`=$del_id");
    header("Location: manage-home-hero.php?msg=Slide+deleted+successfully");
    exit;
}

// 3. Handle Batch Actions
if (isset($_POST['batch_action']) && !empty($_POST['selected_ids'])) {
    $action = $_POST['batch_action'];
    $ids = array_map('intval', $_POST['selected_ids']);
    $id_list = implode(',', $ids);

    if ($action === 'activate') {
        mysqli_query($conn, "UPDATE `tbl_hero_slides` SET `status`=1 WHERE `id` IN ($id_list)");
        $msg = count($ids) . " slides activated successfully.";
    } elseif ($action === 'deactivate') {
        mysqli_query($conn, "UPDATE `tbl_hero_slides` SET `status`=0 WHERE `id` IN ($id_list)");
        $msg = count($ids) . " slides deactivated successfully.";
    } elseif ($action === 'delete') {
        // Delete image files if uploaded
        $img_q = mysqli_query($conn, "SELECT `image` FROM `tbl_hero_slides` WHERE `id` IN ($id_list)");
        while ($img_row = mysqli_fetch_assoc($img_q)) {
            if (!empty($img_row['image']) && strpos($img_row['image'], 'uploads/home/') !== false) {
                $file_to_del = "../" . $img_row['image'];
                if (file_exists($file_to_del)) {
                    @unlink($file_to_del);
                }
            }
        }
        mysqli_query($conn, "DELETE FROM `tbl_hero_slides` WHERE `id` IN ($id_list)");
        $msg = count($ids) . " slides deleted successfully.";
    }
}

// 4. Handle Add New Slide
if (isset($_POST['add_slide'])) {
    $badge = mysqli_real_escape_string($conn, trim($_POST['badge_text']));
    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $desc = mysqli_real_escape_string($conn, trim(strip_tags($_POST['description'], '<strong><b><em><i><span>')));
    $btn1_text = mysqli_real_escape_string($conn, trim($_POST['btn1_text']));
    $btn1_link = mysqli_real_escape_string($conn, trim($_POST['btn1_link']));
    $btn2_text = mysqli_real_escape_string($conn, trim($_POST['btn2_text']));
    $btn2_link = mysqli_real_escape_string($conn, trim($_POST['btn2_link']));
    $sort = (int)($_POST['sort_order'] ?? 0);
    $status = isset($_POST['status']) ? 1 : 0;
    
    $image_path = 'assets/img/commodities/hero-export-banner.jpg';
    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
        if (in_array($ext, $allowed)) {
            $new_name = "slide_" . time() . "_" . rand(1000, 9999) . "." . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_name)) {
                $image_path = "uploads/home/" . $new_name;
            }
        }
    }

    $ins = mysqli_query($conn, "INSERT INTO `tbl_hero_slides` 
        (`badge_text`, `title`, `description`, `btn1_text`, `btn1_link`, `btn2_text`, `btn2_link`, `image`, `sort_order`, `status`) 
        VALUES ('$badge', '$title', '$desc', '$btn1_text', '$btn1_link', '$btn2_text', '$btn2_link', '$image_path', $sort, $status)");

    if ($ins) {
        $msg = "New hero slide added successfully!";
    } else {
        $error = "Failed to add slide: " . mysqli_error($conn);
    }
}

// 5. Handle Edit Slide
if (isset($_POST['edit_slide'])) {
    $eid = (int)$_POST['slide_id'];
    $badge = mysqli_real_escape_string($conn, trim($_POST['badge_text']));
    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $desc = mysqli_real_escape_string($conn, trim(strip_tags($_POST['description'], '<strong><b><em><i><span>')));
    $btn1_text = mysqli_real_escape_string($conn, trim($_POST['btn1_text']));
    $btn1_link = mysqli_real_escape_string($conn, trim($_POST['btn1_link']));
    $btn2_text = mysqli_real_escape_string($conn, trim($_POST['btn2_text']));
    $btn2_link = mysqli_real_escape_string($conn, trim($_POST['btn2_link']));
    $sort = (int)($_POST['sort_order'] ?? 0);
    $status = isset($_POST['status']) ? 1 : 0;

    $cur_img_q = mysqli_query($conn, "SELECT `image` FROM `tbl_hero_slides` WHERE `id`=$eid");
    $cur_img = mysqli_fetch_assoc($cur_img_q)['image'] ?? 'assets/img/commodities/hero-export-banner.jpg';
    $image_path = $cur_img;

    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
        if (in_array($ext, $allowed)) {
            $new_name = "slide_" . time() . "_" . rand(1000, 9999) . "." . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_name)) {
                $image_path = "uploads/home/" . $new_name;
            }
        }
    }

    $upd = mysqli_query($conn, "UPDATE `tbl_hero_slides` SET 
        `badge_text`='$badge', `title`='$title', `description`='$desc',
        `btn1_text`='$btn1_text', `btn1_link`='$btn1_link',
        `btn2_text`='$btn2_text', `btn2_link`='$btn2_link',
        `image`='$image_path', `sort_order`=$sort, `status`=$status
        WHERE `id`=$eid");

    if ($upd) {
        $msg = "Slide #$eid updated successfully!";
    } else {
        $error = "Failed to update slide: " . mysqli_error($conn);
    }
}

if (isset($_GET['msg'])) {
    $msg = htmlspecialchars($_GET['msg']);
}

// Fetch all slides
$slides_query = mysqli_query($conn, "SELECT * FROM `tbl_hero_slides` ORDER BY `sort_order` ASC, `id` DESC");
$slides_list = [];
$total_slides = 0;
$active_slides = 0;

if ($slides_query) {
    while ($r = mysqli_fetch_assoc($slides_query)) {
        $slides_list[] = $r;
        $total_slides++;
        if ($r['status'] == 1) {
            $active_slides++;
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
                        Hero Carousel Banners
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 13.5px;">
                        Manage your carousel slides (<span class="fw-bold text-success" id="activeSlidesCount"><?= $active_slides ?> active</span> of <?= $total_slides ?> total)
                    </p>
                </div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="manage-home-hero.php">Home Page CMS</a></li>
                    <li class="breadcrumb-item active">Hero Banners</li>
                </ol>
            </div>

            <!-- Quick Sub-Menu Switcher Pills -->
            <div class="cms-subnav-strip mb-4">
                <a href="manage-home-hero.php" class="cms-subnav-pill active">
                    <i class="fa-solid fa-images"></i> Hero Carousel Banners
                </a>
                <a href="manage-home-trust.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-shield-halved"></i> Quality Trust Bar
                </a>
                <a href="manage-about-story.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-building"></i> Company Overview
                </a>
                <a href="manage-categories.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-boxes-stacked"></i> Product Categories
                </a>
                <a href="manage-home-why.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-award"></i> Why Choose Stridewel
                </a>
                <a href="manage-home-pipeline.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-industry"></i> Manufacturing Pipeline
                </a>
                <a href="manage-faq.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-circle-question"></i> Homepage FAQs
                </a>
                <a href="manage-testimonial.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-comments"></i> Testimonials
                </a>
                <a href="../index.php" target="_blank" class="cms-subnav-pill cms-subnav-preview">
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

            <!-- Table CRUD Card Container -->
            <div class="table-crud-card">
                <!-- Top Actions Bar: Search, Sort Dropdown & Add Button -->
                <div class="table-crud-header">
                    <div class="d-flex flex-wrap align-items-center gap-3 flex-grow-1">
                        <!-- Search Box -->
                        <div class="table-crud-search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="slideSearchInput" class="form-control" placeholder="Search slides by title, badge...">
                        </div>

                        <!-- Sort Filter Dropdown -->
                        <div class="table-crud-sort">
                            <select id="slideSortSelect" class="form-select no-select2">
                                <option value="sort_asc">Sort Order (Low to High)</option>
                                <option value="latest">Latest First</option>
                                <option value="active_first">Active First</option>
                                <option value="title_asc">Title (A-Z)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Add New Slide Button -->
                    <div>
                        <button type="button" class="btn btn-antara-gold px-4 py-2 rounded-pill fw-bold shadow-sm d-flex align-items-center gap-2" data-toggle="modal" data-target="#addSlideModal" data-bs-toggle="modal" data-bs-target="#addSlideModal">
                            <i class="fa-solid fa-plus"></i> Add Slide
                        </button>
                    </div>
                </div>

                <!-- Form for Batch Actions wrapping the Table -->
                <form method="POST" id="batchActionForm">
                    <div class="table-responsive">
                        <table class="table table-crud-table" id="slidesTable">
                            <thead>
                                <tr>
                                    <th style="width: 48px; text-align: center;">
                                        <input type="checkbox" id="selectAllSlides" class="crud-checkbox" title="Select All">
                                    </th>
                                    <th style="width: 70px; text-align: center;">IMAGE</th>
                                    <th style="width: 36%;">SLIDE DETAILS & BADGE</th>
                                    <th style="width: 32%;">DESCRIPTION</th>
                                    <th style="width: 65px; text-align: center;">SORT</th>
                                    <th style="width: 78px; text-align: center;">STATUS</th>
                                    <th style="width: 90px; text-align: center;">ACTION</th>
                                </tr>
                            </thead>
                            <tbody id="slidesTableBody">
                                <?php if (!empty($slides_list)): ?>
                                    <?php foreach ($slides_list as $s): ?>
                                        <tr class="slide-row" 
                                            data-id="<?= $s['id'] ?>"
                                            data-sort="<?= (int)$s['sort_order'] ?>"
                                            data-status="<?= (int)$s['status'] ?>"
                                            data-title="<?= strtolower(htmlspecialchars($s['title'])) ?>"
                                            data-badge="<?= strtolower(htmlspecialchars($s['badge_text'])) ?>"
                                            data-desc="<?= strtolower(htmlspecialchars($s['description'])) ?>">
                                            
                                            <!-- Checkbox -->
                                            <td style="text-align: center;">
                                                <input type="checkbox" name="selected_ids[]" value="<?= $s['id'] ?>" class="crud-checkbox row-select-cb">
                                            </td>

                                            <!-- Thumbnail Image -->
                                            <td style="text-align: center;">
                                                <div class="table-thumb-box mx-auto">
                                                    <img src="../<?= htmlspecialchars($s['image']) ?>" alt="Slide Image" onerror="this.src='../assets/images/slider/slide_banner_1_bovine_ai.jpg'">
                                                </div>
                                            </td>

                                            <!-- Title & Badge -->
                                            <td>
                                                <div class="fw-bold text-dark" style="font-size: 14px; line-height: 1.35;">
                                                    <?= htmlspecialchars($s['title']) ?>
                                                </div>
                                                <div class="d-flex flex-wrap align-items-center gap-2 mt-1">
                                                    <?php if (!empty($s['badge_text'])): ?>
                                                        <span class="badge bg-light text-dark border" style="font-size: 11px;">
                                                            <i class="fa-solid fa-tag text-warning me-1"></i> <?= htmlspecialchars($s['badge_text']) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                    <?php if (!empty($s['btn1_text'])): ?>
                                                        <span class="badge bg-white text-muted border" style="font-size: 10.5px;">
                                                            CTA: <?= htmlspecialchars($s['btn1_text']) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>

                                            <!-- Description snippet with 2-line clamp -->
                                            <td>
                                                <div class="table-desc-text" title="<?= htmlspecialchars($s['description']) ?>">
                                                    <?= !empty($s['description']) ? htmlspecialchars($s['description']) : '<span class="text-muted">—</span>' ?>
                                                </div>
                                            </td>

                                            <!-- Sort order -->
                                            <td style="text-align: center;">
                                                <span class="table-sort-badge">
                                                    <?= (int)$s['sort_order'] ?>
                                                </span>
                                            </td>

                                            <!-- Status Toggle Switch (Universal Capsule Slider) -->
                                            <td style="text-align: center;">
                                                <label class="status-switch-wrapper" title="Click to toggle active status">
                                                    <input type="checkbox" 
                                                           class="status-toggle-switch"
                                                           data-id="<?= $s['id'] ?>"
                                                           data-table="tbl_hero_slides"
                                                           data-field="status"
                                                           <?= $s['status'] == 1 ? 'checked' : '' ?>>
                                                    <span class="status-switch-slider"></span>
                                                </label>
                                            </td>

                                            <!-- Action Buttons -->
                                            <td style="text-align: center;">
                                                <div class="d-inline-flex gap-1 justify-content-center">
                                                    <button type="button" class="btn-action-square btn-action-edit" data-toggle="modal" data-target="#editSlideModal<?= $s['id'] ?>" data-bs-toggle="modal" data-bs-target="#editSlideModal<?= $s['id'] ?>" title="Edit Slide">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </button>
                                                    <a href="manage-home-hero.php?delete=<?= $s['id'] ?>" class="btn-action-square btn-action-delete" onclick="return confirm('Are you sure you want to delete this hero slide?');" title="Delete Slide">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr id="noSlidesRow">
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-images fa-3x mb-3 d-block text-secondary opacity-50"></i>
                                            <h5>No Hero Slides Found</h5>
                                            <p class="mb-3">Click "+ Add Slide" above to create your first dynamic hero banner.</p>
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
                            <button type="submit" name="batch_action" value="delete" class="btn btn-batch-delete" onclick="return confirm('Are you sure you want to delete all selected slides?');">
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

    <!-- Add Slide Modal -->
    <div class="modal fade" id="addSlideModal" tabindex="-1" aria-labelledby="addSlideModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #123023 0%, #1B4533 100%);">
                    <h5 class="modal-title fw-bold" id="addSlideModalLabel" style="color: #FFFFFF !important;">
                        <i class="fa-solid fa-plus-circle text-warning me-2"></i> Add New Hero Carousel Slide
                    </h5>
                    <button type="button" class="modal-close-btn" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-dark">Main Heading / Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" placeholder="e.g. Global Agricultural Commodities & Foodservice Supplies" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold text-dark">Subtitle Badge Text</label>
                                <input type="text" name="badge_text" class="form-control" placeholder="e.g. DIRECT ORIGIN COMMODITY EXPORT & B2B FOODSERVICE SUPPLY">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold text-dark">Description Paragraph</label>
                                <textarea name="description" class="form-control no-ckeditor" rows="3" placeholder="Brief 1-2 sentence description explaining your export/supply capability..."></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Primary Button Label</label>
                                <input type="text" name="btn1_text" class="form-control" value="Explore Export Catalogue" placeholder="e.g. Explore Export Catalogue">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Primary Button Link</label>
                                <input type="text" name="btn1_link" class="form-control" value="products.php?division=export" placeholder="e.g. products.php?division=export">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Secondary Button Label</label>
                                <input type="text" name="btn2_text" class="form-control" value="B2B Trade Desk" placeholder="e.g. B2B Trade Desk">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Secondary Button Link</label>
                                <input type="text" name="btn2_link" class="form-control" value="contact.php" placeholder="e.g. contact.php">
                            </div>

                            <div class="col-md-8">
                                <label class="form-label fw-bold text-dark">Background Banner Image <span class="text-danger">*</span></label>
                                <input type="file" name="image" class="form-control" accept="image/*" required id="addSlideImageInput">
                                <small class="text-muted">Recommended: 1920x850px high-resolution JPG, PNG, or WebP.</small>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" value="<?= $total_slides + 1 ?>" min="0">
                            </div>

                            <div class="col-12 mt-1">
                                <div class="modal-toggle-card">
                                    <label class="status-switch-wrapper switch-emerald mb-0" style="flex-shrink: 0;">
                                        <input type="checkbox" name="status" id="addSlideStatus" checked>
                                        <span class="status-switch-slider"></span>
                                    </label>
                                    <label class="form-check-label" for="addSlideStatus">
                                        Publish Immediately (Active Slide)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light px-4 py-3">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_slide" class="btn btn-antara-gold rounded-pill px-4 fw-bold">
                            <i class="fa-solid fa-cloud-arrow-up me-1"></i> Save Hero Slide
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Slide Modals -->
    <?php if (!empty($slides_list)): ?>
        <?php foreach ($slides_list as $s): ?>
            <div class="modal fade" id="editSlideModal<?= $s['id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #123023 0%, #1B4533 100%);">
                            <h5 class="modal-title fw-bold" style="color: #FFFFFF !important;">
                                <i class="fa-solid fa-pen-to-square text-warning me-2"></i> Edit Hero Slide #<?= $s['id'] ?>
                            </h5>
                            <button type="button" class="modal-close-btn" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="slide_id" value="<?= $s['id'] ?>">
                            <div class="modal-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold text-dark">Main Heading / Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($s['title']) ?>" required>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-bold text-dark">Subtitle Badge Text</label>
                                        <input type="text" name="badge_text" class="form-control" value="<?= htmlspecialchars($s['badge_text']) ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-bold text-dark">Description Paragraph</label>
                                        <textarea name="description" class="form-control no-ckeditor" rows="3"><?= htmlspecialchars(strip_tags($s['description'])) ?></textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark">Primary Button Label</label>
                                        <input type="text" name="btn1_text" class="form-control" value="<?= htmlspecialchars($s['btn1_text']) ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark">Primary Button Link</label>
                                        <input type="text" name="btn1_link" class="form-control" value="<?= htmlspecialchars($s['btn1_link']) ?>">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark">Secondary Button Label</label>
                                        <input type="text" name="btn2_text" class="form-control" value="<?= htmlspecialchars($s['btn2_text']) ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark">Secondary Button Link</label>
                                        <input type="text" name="btn2_link" class="form-control" value="<?= htmlspecialchars($s['btn2_link']) ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-bold text-dark">Current Image Banner</label>
                                        <div class="mb-2 p-2 border rounded bg-light d-flex align-items-center gap-3">
                                            <img src="../<?= htmlspecialchars($s['image']) ?>" alt="Current Banner" style="height: 70px; width: 140px; object-fit: cover; border-radius: 8px;">
                                            <div>
                                                <div class="small fw-bold text-dark"><?= htmlspecialchars(basename($s['image'])) ?></div>
                                                <small class="text-muted">To replace this banner, select a new image file below.</small>
                                            </div>
                                        </div>
                                        <input type="file" name="image" class="form-control" accept="image/*">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark">Sort Order</label>
                                        <input type="number" name="sort_order" class="form-control" value="<?= (int)$s['sort_order'] ?>" min="0">
                                    </div>

                                    <div class="col-md-6 d-flex align-items-center">
                                        <div class="modal-toggle-card w-100" style="margin-top: 24px;">
                                            <label class="status-switch-wrapper switch-emerald mb-0" style="flex-shrink: 0;">
                                                <input type="checkbox" name="status" id="editSlideStatus<?= $s['id'] ?>" <?= $s['status'] == 1 ? 'checked' : '' ?>>
                                                <span class="status-switch-slider"></span>
                                            </label>
                                            <label class="form-check-label" for="editSlideStatus<?= $s['id'] ?>">
                                                Active (Display on Homepage)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer bg-light px-4 py-3">
                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" name="edit_slide" class="btn btn-antara-gold rounded-pill px-4 fw-bold">
                                    <i class="fa-solid fa-check me-1"></i> Update Slide
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php require('includes/footer.php'); ?>

    <!-- Table CRUD Operations Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAllSlides');
        const rowCheckboxes = document.querySelectorAll('.row-select-cb');
        const batchBar = document.getElementById('batchActionBar');
        const countBadge = document.getElementById('selectedCountBadge');
        const searchInput = document.getElementById('slideSearchInput');
        const sortSelect = document.getElementById('slideSortSelect');
        const tableBody = document.getElementById('slidesTableBody');
        const toastEl = document.getElementById('crudToast');
        const toastMessage = document.getElementById('crudToastMessage');
        const toastIcon = document.getElementById('crudToastIcon');
        const toast = (toastEl && typeof bootstrap !== 'undefined' && bootstrap.Toast) ? new bootstrap.Toast(toastEl, { delay: 3000 }) : null;

        // Helper: Update batch action bar state
        function updateBatchBar() {
            const checkedBoxes = document.querySelectorAll('.row-select-cb:checked');
            const count = checkedBoxes.length;
            if (count > 0) {
                countBadge.textContent = count + ' selected';
                batchBar.classList.add('show');
            } else {
                batchBar.classList.remove('show');
            }

            // Update row styling
            rowCheckboxes.forEach(cb => {
                const tr = cb.closest('tr');
                if (tr) {
                    if (cb.checked) {
                        tr.classList.add('row-selected');
                    } else {
                        tr.classList.remove('row-selected');
                    }
                }
            });

            // Sync selectAll state
            if (selectAll) {
                selectAll.checked = (count === rowCheckboxes.length && rowCheckboxes.length > 0);
            }
        }

        // 1. Select All Checkbox
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

        // 2. Individual Checkbox Change
        rowCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateBatchBar);
        });

        // 3. Client-Side Live Search Filter
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();
                const rows = document.querySelectorAll('.slide-row');
                let visibleCount = 0;

                rows.forEach(row => {
                    const title = row.getAttribute('data-title') || '';
                    const badge = row.getAttribute('data-badge') || '';
                    const desc = row.getAttribute('data-desc') || '';

                    if (query === '' || title.includes(query) || badge.includes(query) || desc.includes(query)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                        const cb = row.querySelector('.row-select-cb');
                        if (cb) cb.checked = false;
                    }
                });

                updateBatchBar();
            });
        }

        // 4. Sort Dropdown Filter
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                const sortType = this.value;
                const rows = Array.from(document.querySelectorAll('.slide-row'));

                rows.sort((a, b) => {
                    const sortA = parseInt(a.getAttribute('data-sort')) || 0;
                    const sortB = parseInt(b.getAttribute('data-sort')) || 0;
                    const idA = parseInt(a.getAttribute('data-id')) || 0;
                    const idB = parseInt(b.getAttribute('data-id')) || 0;
                    const statusA = parseInt(a.getAttribute('data-status')) || 0;
                    const statusB = parseInt(b.getAttribute('data-status')) || 0;
                    const titleA = (a.getAttribute('data-title') || '').toLowerCase();
                    const titleB = (b.getAttribute('data-title') || '').toLowerCase();

                    if (sortType === 'sort_asc') {
                        return sortA - sortB;
                    } else if (sortType === 'latest') {
                        return idB - idA;
                    } else if (sortType === 'active_first') {
                        return statusB - statusA;
                    } else if (sortType === 'title_asc') {
                        return titleA.localeCompare(titleB);
                    }
                    return 0;
                });

                rows.forEach(row => tableBody.appendChild(row));
            });
        }

        // 5. Interactive AJAX Status Toggle Switch
        const statusSwitches = document.querySelectorAll('.status-toggle-switch');
        statusSwitches.forEach(sw => {
            sw.addEventListener('change', function() {
                const currentSw = this;
                const itemId = currentSw.getAttribute('data-id');
                const tableName = currentSw.getAttribute('data-table');
                const fieldName = currentSw.getAttribute('data-field') || 'status';
                const newStatus = currentSw.checked ? 1 : 0;
                const row = currentSw.closest('tr');

                // Send AJAX POST to toggle-status.php
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
                        toastMessage.textContent = data.message || `Slide #${itemId} status updated.`;
                        toastIcon.className = 'fa-solid fa-circle-check text-success fs-5';
                        toast.show();

                        if (row) {
                            row.setAttribute('data-status', newStatus);
                        }

                        // Update active count header
                        let activeCount = document.querySelectorAll('.status-toggle-switch:checked').length;
                        const activeCountEl = document.getElementById('activeSlidesCount');
                        if (activeCountEl) {
                            activeCountEl.textContent = activeCount + ' active';
                        }
                    } else {
                        // Revert switch on failure
                        currentSw.checked = !newStatus;
                        toastMessage.textContent = data.error || 'Failed to update status.';
                        toastIcon.className = 'fa-solid fa-circle-xmark text-danger fs-5';
                        toast.show();
                    }
                })
                .catch(err => {
                    currentSw.checked = !newStatus;
                    toastMessage.textContent = 'Network error while updating status.';
                    toastIcon.className = 'fa-solid fa-triangle-exclamation text-warning fs-5';
                    toast.show();
                });
            });
        });
    });
    </script>
</body>
</html>
