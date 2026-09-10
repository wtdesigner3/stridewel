<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// Ensure upload directory exists
$upload_dir = "../uploads/manufacturing/";
if (!is_dir($upload_dir)) {
    @mkdir($upload_dir, 0777, true);
}

// 1. Handle Section Meta & Ribbon Stats Update
if (isset($_POST['update_meta'])) {
    $badge = mysqli_real_escape_string($conn, trim($_POST['badge']));
    $heading = mysqli_real_escape_string($conn, trim($_POST['heading']));
    $desc = mysqli_real_escape_string($conn, trim(strip_tags($_POST['description'] ?? '')));
    $stat_1_val = mysqli_real_escape_string($conn, trim($_POST['stat_1_val']));
    $stat_1_label = mysqli_real_escape_string($conn, trim($_POST['stat_1_label']));
    $stat_2_val = mysqli_real_escape_string($conn, trim($_POST['stat_2_val']));
    $stat_2_label = mysqli_real_escape_string($conn, trim($_POST['stat_2_label']));
    $stat_3_val = mysqli_real_escape_string($conn, trim($_POST['stat_3_val']));
    $stat_3_label = mysqli_real_escape_string($conn, trim($_POST['stat_3_label']));
    $stat_4_val = mysqli_real_escape_string($conn, trim($_POST['stat_4_val']));
    $stat_4_label = mysqli_real_escape_string($conn, trim($_POST['stat_4_label']));
    $bottom_note = mysqli_real_escape_string($conn, trim($_POST['bottom_note']));

    $upd = mysqli_query($conn, "UPDATE `tbl_home_pipeline_meta` SET 
        `badge`='$badge',
        `heading`='$heading',
        `description`='$desc',
        `stat_1_val`='$stat_1_val',
        `stat_1_label`='$stat_1_label',
        `stat_2_val`='$stat_2_val',
        `stat_2_label`='$stat_2_label',
        `stat_3_val`='$stat_3_val',
        `stat_3_label`='$stat_3_label',
        `stat_4_val`='$stat_4_val',
        `stat_4_label`='$stat_4_label',
        `bottom_note`='$bottom_note'
        WHERE `id`=1");

    if ($upd) {
        $msg = "Manufacturing pipeline header & trust stats updated successfully!";
    } else {
        $error = "Failed to update header: " . mysqli_error($conn);
    }
}

// 2. Handle Status Toggle
if (isset($_GET['toggle_status']) && isset($_GET['id'])) {
    $pid = (int)$_GET['id'];
    $cur = (int)$_GET['toggle_status'];
    $new_st = ($cur == 1) ? 0 : 1;
    mysqli_query($conn, "UPDATE `tbl_home_pipeline` SET `status`=$new_st WHERE `id`=$pid");
    header("Location: manage-home-pipeline.php?msg=" . urlencode("Status updated successfully"));
    exit;
}

// 3. Handle Delete Step
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    $get_img = mysqli_query($conn, "SELECT `image` FROM `tbl_home_pipeline` WHERE `id`=$del_id");
    if ($img_row = mysqli_fetch_assoc($get_img)) {
        if (!empty($img_row['image']) && strpos($img_row['image'], 'uploads/manufacturing/') !== false) {
            $f = "../" . $img_row['image'];
            if (file_exists($f)) @unlink($f);
        }
    }
    mysqli_query($conn, "DELETE FROM `tbl_home_pipeline` WHERE `id`=$del_id");
    header("Location: manage-home-pipeline.php?msg=" . urlencode("Manufacturing process step deleted"));
    exit;
}

// 4. Handle Add Process Step
if (isset($_POST['add_step'])) {
    $step_num = mysqli_real_escape_string($conn, trim($_POST['step_num']));
    $phase = mysqli_real_escape_string($conn, trim($_POST['phase_label']));
    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $desc = mysqli_real_escape_string($conn, trim(strip_tags($_POST['description'] ?? '')));
    $pills = mysqli_real_escape_string($conn, trim($_POST['pills']));
    $sort = (int)($_POST['sort_order'] ?? 0);
    $status = isset($_POST['status']) ? 1 : 0;
    $image_path = 'assets/images/manufacturing/mfg_1_ss_machining.jpg';

    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
        if (in_array($ext, $allowed)) {
            $new_name = "mfg_" . time() . "_" . rand(100, 999) . "." . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_name)) {
                $image_path = "uploads/manufacturing/" . $new_name;
            }
        } else {
            $error = "Invalid image file format.";
        }
    }

    if (empty($error) && !empty($title)) {
        $ins = mysqli_query($conn, "INSERT INTO `tbl_home_pipeline` (`step_num`, `phase_label`, `title`, `description`, `pills`, `image`, `sort_order`, `status`) VALUES ('$step_num', '$phase', '$title', '$desc', '$pills', '$image_path', $sort, $status)");
        if ($ins) {
            $msg = "Process step '$title' added successfully!";
        } else {
            $error = "Failed to add step: " . mysqli_error($conn);
        }
    }
}

// 5. Handle Edit Process Step
if (isset($_POST['edit_step'])) {
    $sid = (int)$_POST['step_id'];
    $step_num = mysqli_real_escape_string($conn, trim($_POST['step_num']));
    $phase = mysqli_real_escape_string($conn, trim($_POST['phase_label']));
    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $desc = mysqli_real_escape_string($conn, trim(strip_tags($_POST['description'] ?? '')));
    $pills = mysqli_real_escape_string($conn, trim($_POST['pills']));
    $sort = (int)($_POST['sort_order'] ?? 0);
    $status = isset($_POST['status']) ? 1 : 0;

    $cur_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `image` FROM `tbl_home_pipeline` WHERE `id`=$sid"));
    $image_path = $cur_row['image'] ?? 'assets/images/manufacturing/mfg_1_ss_machining.jpg';

    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
        if (in_array($ext, $allowed)) {
            $new_name = "mfg_" . time() . "_" . rand(100, 999) . "." . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_name)) {
                // remove old file if in uploads
                if (!empty($image_path) && strpos($image_path, 'uploads/manufacturing/') !== false) {
                    $old_f = "../" . $image_path;
                    if (file_exists($old_f)) @unlink($old_f);
                }
                $image_path = "uploads/manufacturing/" . $new_name;
            }
        } else {
            $error = "Invalid image file format.";
        }
    }

    if (empty($error) && !empty($title)) {
        $upd = mysqli_query($conn, "UPDATE `tbl_home_pipeline` SET 
            `step_num`='$step_num',
            `phase_label`='$phase',
            `title`='$title',
            `description`='$desc',
            `pills`='$pills',
            `image`='$image_path',
            `sort_order`=$sort,
            `status`=$status
            WHERE `id`=$sid");

        if ($upd) {
            $msg = "Process step '$title' updated successfully!";
        } else {
            $error = "Failed to update step: " . mysqli_error($conn);
        }
    }
}

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}

// Fetch Section Meta
$meta = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `tbl_home_pipeline_meta` WHERE `id`=1 LIMIT 1"));
if (!$meta) {
    $meta = [
        'badge' => 'Direct Manufacturer & ISO 9001:2015 Certified Facility',
        'heading' => 'Precision Veterinary Manufacturing & Quality Assurance Pipeline',
        'description' => 'From Swiss CNC metal machining to automated cleanroom injection molding, explore how Stridewel delivers certified, zero-defect instruments.',
        'stat_1_val' => 'SS 304/316', 'stat_1_label' => 'Medical-Grade Stainless Steel',
        'stat_2_val' => '100% Virgin', 'stat_2_label' => 'Non-Toxic Polymer Molding',
        'stat_3_val' => 'Optical Micrometer', 'stat_3_label' => 'Precision Calibration & Fitment',
        'stat_4_val' => '48-Hour Dispatch', 'stat_4_label' => 'Direct Factory Wholesale Orders',
        'bottom_note' => 'Need custom OEM branding, custom length A.I. guns, or bulk institutional supply quotes?'
    ];
}

// Fetch Process Steps
$steps = [];
$sq = mysqli_query($conn, "SELECT * FROM `tbl_home_pipeline` ORDER BY `sort_order` ASC, `id` ASC");
if ($sq) {
    while ($row = mysqli_fetch_assoc($sq)) {
        $steps[] = $row;
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
                    <h1 class="page-header mb-1" style="font-size: 24px; font-weight: 800; color: #103755;">
                        Manufacturing Excellence &amp; Quality Pipeline
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 13.5px;">
                        Manage the 4-step manufacturing pipeline cards, ISO certification ribbon stats, and factory process showcase on the homepage.
                    </p>
                </div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="manage-home-hero.php">Home Page CMS</a></li>
                    <li class="breadcrumb-item active">Manufacturing Pipeline</li>
                </ol>
            </div>

            <!-- Quick Sub-Menu Switcher Pills -->
            <div class="cms-subnav-strip mb-4">
                <a href="manage-home-hero.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-images"></i> Hero Banner
                </a>
                <a href="manage-home-trust.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-shield-halved"></i> Quality Trust Bar
                </a>
                <a href="manage-about-story.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-building"></i> Company Overview
                </a>
                <a href="manage-categories.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-boxes-stacked"></i> Categories
                </a>
                <a href="manage-home-why.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-award"></i> Why Choose Stridewel
                </a>
                <a href="manage-home-pipeline.php" class="cms-subnav-pill active">
                    <i class="fa-solid fa-industry"></i> Manufacturing Pipeline
                </a>
                <a href="manage-faq.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-circle-question"></i> FAQs
                </a>
                <a href="manage-testimonial.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-comments"></i> Testimonials
                </a>
                <a href="../index.php" target="_blank" class="cms-subnav-pill cms-subnav-preview">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Live Homepage
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

            <div class="row g-4">
                <!-- Left: Section Meta & 4 Stats Ribbon -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                        <div class="card-header bg-white py-3 px-4 border-bottom">
                            <h5 class="mb-0 fw-bold" style="color: #103755;">
                                <i class="fa-solid fa-gears text-danger me-2"></i> Section Header &amp; Trust Stats Ribbon
                            </h5>
                        </div>
                        <div class="card-body p-4 bg-white">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark mb-1">Top Pill Badge</label>
                                    <input type="text" name="badge" class="form-control" value="<?= htmlspecialchars($meta['badge']) ?>" placeholder="e.g. Direct Manufacturer & ISO 9001:2015 Certified Facility">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark mb-1">Section Main Heading</label>
                                    <input type="text" name="heading" class="form-control" value="<?= htmlspecialchars($meta['heading']) ?>" placeholder="e.g. Precision Veterinary Manufacturing & Quality Assurance Pipeline">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark mb-1">Narrative Description</label>
                                    <textarea name="description" class="form-control no-ckeditor" rows="3"><?= htmlspecialchars(strip_tags($meta['description'])) ?></textarea>
                                </div>

                                <h6 class="fw-bold text-dark mt-4 mb-2 pb-1 border-bottom d-flex align-items-center gap-2" style="font-size: 13.5px;">
                                    <i class="fa-solid fa-certificate text-danger"></i> 4 Trust Stats Ribbon (Top Bar)
                                </h6>
                                <div class="row g-2 mb-2">
                                    <div class="col-5">
                                        <label class="form-label text-muted mb-0" style="font-size: 11px;">Stat 1 Metric</label>
                                        <input type="text" name="stat_1_val" class="form-control form-control-sm" value="<?= htmlspecialchars($meta['stat_1_val'] ?? 'SS 304/316') ?>">
                                    </div>
                                    <div class="col-7">
                                        <label class="form-label text-muted mb-0" style="font-size: 11px;">Stat 1 Label</label>
                                        <input type="text" name="stat_1_label" class="form-control form-control-sm" value="<?= htmlspecialchars($meta['stat_1_label'] ?? 'Medical-Grade Stainless Steel') ?>">
                                    </div>
                                </div>
                                <div class="row g-2 mb-2">
                                    <div class="col-5">
                                        <label class="form-label text-muted mb-0" style="font-size: 11px;">Stat 2 Metric</label>
                                        <input type="text" name="stat_2_val" class="form-control form-control-sm" value="<?= htmlspecialchars($meta['stat_2_val'] ?? '100% Virgin') ?>">
                                    </div>
                                    <div class="col-7">
                                        <label class="form-label text-muted mb-0" style="font-size: 11px;">Stat 2 Label</label>
                                        <input type="text" name="stat_2_label" class="form-control form-control-sm" value="<?= htmlspecialchars($meta['stat_2_label'] ?? 'Non-Toxic Polymer Molding') ?>">
                                    </div>
                                </div>
                                <div class="row g-2 mb-2">
                                    <div class="col-5">
                                        <label class="form-label text-muted mb-0" style="font-size: 11px;">Stat 3 Metric</label>
                                        <input type="text" name="stat_3_val" class="form-control form-control-sm" value="<?= htmlspecialchars($meta['stat_3_val'] ?? 'Optical Micrometer') ?>">
                                    </div>
                                    <div class="col-7">
                                        <label class="form-label text-muted mb-0" style="font-size: 11px;">Stat 3 Label</label>
                                        <input type="text" name="stat_3_label" class="form-control form-control-sm" value="<?= htmlspecialchars($meta['stat_3_label'] ?? 'Precision Calibration & Fitment') ?>">
                                    </div>
                                </div>
                                <div class="row g-2 mb-3">
                                    <div class="col-5">
                                        <label class="form-label text-muted mb-0" style="font-size: 11px;">Stat 4 Metric</label>
                                        <input type="text" name="stat_4_val" class="form-control form-control-sm" value="<?= htmlspecialchars($meta['stat_4_val'] ?? '48-Hour Dispatch') ?>">
                                    </div>
                                    <div class="col-7">
                                        <label class="form-label text-muted mb-0" style="font-size: 11px;">Stat 4 Label</label>
                                        <input type="text" name="stat_4_label" class="form-control form-control-sm" value="<?= htmlspecialchars($meta['stat_4_label'] ?? 'Direct Factory Wholesale Orders') ?>">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark mb-1">Bottom Callout Note</label>
                                    <input type="text" name="bottom_note" class="form-control" value="<?= htmlspecialchars($meta['bottom_note'] ?? 'Need custom OEM branding, custom length A.I. guns, or bulk institutional supply quotes?') ?>">
                                </div>

                                <button type="submit" name="update_meta" class="btn btn-danger w-100 fw-bold py-2.5 rounded-pill shadow-sm">
                                    <i class="fa-solid fa-floppy-disk me-1"></i> Update Header &amp; Stats
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right: 4 Process Step Cards CRUD -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <h5 class="mb-0 fw-bold" style="color: #103755;">
                                <i class="fa-solid fa-diagram-project text-danger me-2"></i> Process Step Cards (<?= count($steps) ?>)
                            </h5>
                            <button type="button" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold shadow-sm" data-toggle="modal" data-target="#addStepModal" data-bs-toggle="modal" data-bs-target="#addStepModal">
                                <i class="fa-solid fa-plus me-1"></i> Add Process Step
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light text-muted" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                                        <tr>
                                            <th class="ps-4" style="width: 60px;">Step</th>
                                            <th style="width: 80px;">Thumbnail</th>
                                            <th>Process Details</th>
                                            <th style="width: 100px;">Status</th>
                                            <th class="text-end pe-4" style="width: 120px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($steps)): ?>
                                            <?php foreach ($steps as $st): ?>
                                            <tr>
                                                <td class="ps-4">
                                                    <span class="badge bg-danger text-white px-2 py-1 fw-bold rounded-pill"><?= htmlspecialchars($st['step_num']) ?></span>
                                                </td>
                                                <td>
                                                    <img src="../<?= htmlspecialchars($st['image']) ?>" alt="Step" class="rounded-3 border object-fit-cover" style="width: 60px; height: 45px;" onerror="this.src='../assets/images/manufacturing/mfg_1_ss_machining.jpg'">
                                                </td>
                                                <td>
                                                    <div class="badge bg-light text-danger border mb-1" style="font-size: 11px;"><?= htmlspecialchars($st['phase_label']) ?></div>
                                                    <div class="fw-bold text-dark" style="font-size: 14px;"><?= htmlspecialchars($st['title']) ?></div>
                                                    <small class="text-muted d-block" style="font-size: 12px; line-height: 1.4;"><?= htmlspecialchars($st['description']) ?></small>
                                                    <?php if (!empty($st['pills'])): ?>
                                                        <div class="mt-1">
                                                            <?php foreach (explode(',', $st['pills']) as $pill): ?>
                                                                <span class="badge bg-secondary-subtle text-secondary px-1.5 py-0.5 rounded" style="font-size: 10px;"><?= trim(htmlspecialchars($pill)) ?></span>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($st['status'] == 1): ?>
                                                        <a href="manage-home-pipeline.php?toggle_status=1&id=<?= $st['id'] ?>" class="badge bg-success-subtle text-success border border-success-subtle text-decoration-none px-2 py-1 rounded-pill fw-bold" title="Click to Deactivate">
                                                            Active
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="manage-home-pipeline.php?toggle_status=0&id=<?= $st['id'] ?>" class="badge bg-secondary-subtle text-secondary border border-secondary-subtle text-decoration-none px-2 py-1 rounded-pill fw-bold" title="Click to Activate">
                                                            Hidden
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <div class="btn-group btn-group-sm">
                                                        <button type="button" class="btn btn-outline-primary btn-sm rounded-2 me-1 edit-step-btn"
                                                            data-toggle="modal"
                                                            data-target="#editStepModal"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editStepModal"
                                                            data-id="<?= $st['id'] ?>"
                                                            data-step="<?= htmlspecialchars($st['step_num']) ?>"
                                                            data-phase="<?= htmlspecialchars($st['phase_label']) ?>"
                                                            data-title="<?= htmlspecialchars($st['title']) ?>"
                                                            data-desc="<?= htmlspecialchars($st['description']) ?>"
                                                            data-pills="<?= htmlspecialchars($st['pills']) ?>"
                                                            data-img="../<?= htmlspecialchars($st['image']) ?>"
                                                            data-sort="<?= $st['sort_order'] ?>"
                                                            data-status="<?= $st['status'] ?>"
                                                            title="Edit Step">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                        <a href="manage-home-pipeline.php?delete=<?= $st['id'] ?>" class="btn btn-outline-danger btn-sm rounded-2" onclick="return confirm('Delete this manufacturing process step?');" title="Delete Step">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center py-5 text-muted">
                                                    No process steps found. Click "Add Process Step" to create one.
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
    </div>

    <!-- Add Step Modal -->
    <div class="modal fade" id="addStepModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-header bg-white py-3 px-4 border-bottom">
                        <h5 class="modal-title fw-bold" style="color: #103755;">
                            <i class="fa-solid fa-plus-circle text-danger me-2"></i> Add Manufacturing Process Step
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4 bg-white">
                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-dark mb-1">Step Number</label>
                                <input type="text" name="step_num" class="form-control" value="05" placeholder="e.g. 01, 02">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-bold text-dark mb-1">Phase / Category Tag</label>
                                <input type="text" name="phase_label" class="form-control" placeholder="e.g. CNC Tooling & Forging">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark mb-1">Step Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" required placeholder="e.g. Precision SS Engineering">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">Description Narrative</label>
                            <textarea name="description" class="form-control no-ckeditor" rows="3" required placeholder="Detailed manufacturing process explanation..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">Highlight Badges / Products (Comma-separated)</label>
                            <input type="text" name="pills" class="form-control" placeholder="e.g. Universal A.I. Guns, Surgical Forceps, SS Trays">
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark mb-1">Step Showcase Image</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-dark mb-1">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" value="0">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="status" id="addStatus" checked>
                                    <label class="form-check-label fw-bold" for="addStatus">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light py-3 px-4 border-top">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_step" class="btn btn-danger rounded-pill px-4 fw-bold">Save Step</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Step Modal -->
    <div class="modal fade" id="editStepModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="step_id" id="editStepId">
                    <div class="modal-header bg-white py-3 px-4 border-bottom">
                        <h5 class="modal-title fw-bold" style="color: #103755;">
                            <i class="fa-solid fa-pen-to-square text-primary me-2"></i> Edit Manufacturing Process Step
                        </h5>
                        <button type="button" class="btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 bg-white">
                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-dark mb-1">Step Number</label>
                                <input type="text" name="step_num" id="editStepNum" class="form-control" required>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-bold text-dark mb-1">Phase / Category Tag</label>
                                <input type="text" name="phase_label" id="editPhaseLabel" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark mb-1">Step Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="editTitle" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">Description Narrative</label>
                            <textarea name="description" id="editDesc" class="form-control no-ckeditor" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">Highlight Badges / Products (Comma-separated)</label>
                            <input type="text" name="pills" id="editPills" class="form-control">
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark mb-1">Replace Image (Optional)</label>
                                <input type="file" name="image" class="form-control mb-2" accept="image/*">
                                <img id="editImagePreview" src="" alt="Current image" class="rounded border object-fit-cover" style="width: 100%; height: 80px;">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-dark mb-1">Sort Order</label>
                                <input type="number" name="sort_order" id="editSort" class="form-control">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="status" id="editStatus">
                                    <label class="form-check-label fw-bold" for="editStatus">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light py-3 px-4 border-top">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="edit_step" class="btn btn-primary rounded-pill px-4 fw-bold">Update Step</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/js/apps.min.js"></script>
    <script>
        $(document).ready(function() {
            if (typeof App !== 'undefined' && typeof App.init === 'function') {
                try { App.init(); } catch(e) { console.warn('App.init:', e); }
            }

            function populateStepModal(btn) {
                if (!btn || !btn.length) return;
                var id = btn.attr('data-id') || btn.data('id');
                var step = btn.attr('data-step') || btn.data('step');
                var phase = btn.attr('data-phase') || btn.data('phase');
                var title = btn.attr('data-title') || btn.data('title');
                var desc = btn.attr('data-desc') || btn.data('desc');
                var pills = btn.attr('data-pills') || btn.data('pills');
                var img = btn.attr('data-img') || btn.data('img');
                var sort = btn.attr('data-sort') || btn.data('sort');
                var status = btn.attr('data-status') || btn.data('status');

                $('#editStepId').val(id);
                $('#editStepNum').val(step);
                $('#editPhaseLabel').val(phase);
                $('#editTitle').val(title);
                $('#editDesc').val(desc);
                $('#editPills').val(pills);
                $('#editImagePreview').attr('src', img);
                $('#editSort').val(sort);
                $('#editStatus').prop('checked', status == 1 || status == '1');
            }

            $(document).on('click', '.edit-step-btn', function(e) {
                var btn = $(this).closest('.edit-step-btn');
                populateStepModal(btn);

                if (typeof $.fn.modal !== 'undefined') {
                    $('#editStepModal').modal('show');
                } else if (typeof bootstrap !== 'undefined' && typeof bootstrap.Modal !== 'undefined') {
                    var modal = bootstrap.Modal.getInstance(document.getElementById('editStepModal')) || new bootstrap.Modal(document.getElementById('editStepModal'));
                    modal.show();
                } else {
                    $('#editStepModal').show().addClass('show');
                }
            });

            $('#editStepModal').on('show.bs.modal', function(e) {
                var btn = $(e.relatedTarget);
                if (btn && btn.length) {
                    populateStepModal(btn);
                }
            });
        });
    </script>
</body>
</html>
