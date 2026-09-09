<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";
$upload_dir = "../../uploads/about/";

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Handle Mission Update
if (isset($_POST['edit_mission'])) {
    $heading = mysqli_real_escape_string($conn, trim($_POST['mission_heading']));
    $content = mysqli_real_escape_string($conn, trim($_POST['mission_content']));

    $cur_q = mysqli_query($conn, "SELECT `mission_image` FROM `tbl_about` WHERE `id`=1");
    $cur = mysqli_fetch_assoc($cur_q);
    $img = $cur['mission_image'] ?? '';

    // If remove image checkbox is checked
    if (isset($_POST['remove_mission_image']) && $_POST['remove_mission_image'] == '1') {
        if (!empty($img) && file_exists("../../" . $img)) {
            @unlink("../../" . $img);
        }
        $img = '';
    }

    // If new image is uploaded
    if (!empty($_FILES['mission_image']['name']) && $_FILES['mission_image']['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES['mission_image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'avif', 'svg'];
        if (in_array($ext, $allowed)) {
            $new_name = "mission_" . time() . "_" . rand(100, 999) . "." . $ext;
            if (move_uploaded_file($_FILES['mission_image']['tmp_name'], $upload_dir . $new_name)) {
                if (!empty($img) && file_exists("../../" . $img) && $img !== ("uploads/about/" . $new_name)) {
                    @unlink("../../" . $img);
                }
                $img = "uploads/about/" . $new_name;
            }
        } else {
            $error = "Invalid file format for Mission image. Allowed: JPG, PNG, WEBP, SVG.";
        }
    }

    if (empty($error)) {
        $upd = mysqli_query($conn, "UPDATE `tbl_about` SET 
            `mission_heading`='$heading',
            `mission_content`='$content',
            `mission_image`='$img'
            WHERE `id`=1");

        if ($upd) {
            $msg = "Strategic Mission updated successfully!";
        } else {
            $error = "Failed to update mission: " . mysqli_error($conn);
        }
    }
}

// Handle Vision Update
if (isset($_POST['edit_vision'])) {
    $heading = mysqli_real_escape_string($conn, trim($_POST['vision_heading']));
    $content = mysqli_real_escape_string($conn, trim($_POST['vision_content']));

    $cur_q = mysqli_query($conn, "SELECT `vision_image` FROM `tbl_about` WHERE `id`=1");
    $cur = mysqli_fetch_assoc($cur_q);
    $img = $cur['vision_image'] ?? '';

    // If remove image checkbox is checked
    if (isset($_POST['remove_vision_image']) && $_POST['remove_vision_image'] == '1') {
        if (!empty($img) && file_exists("../../" . $img)) {
            @unlink("../../" . $img);
        }
        $img = '';
    }

    // If new image is uploaded
    if (!empty($_FILES['vision_image']['name']) && $_FILES['vision_image']['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES['vision_image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'avif', 'svg'];
        if (in_array($ext, $allowed)) {
            $new_name = "vision_" . time() . "_" . rand(100, 999) . "." . $ext;
            if (move_uploaded_file($_FILES['vision_image']['tmp_name'], $upload_dir . $new_name)) {
                if (!empty($img) && file_exists("../../" . $img) && $img !== ("uploads/about/" . $new_name)) {
                    @unlink("../../" . $img);
                }
                $img = "uploads/about/" . $new_name;
            }
        } else {
            $error = "Invalid file format for Vision image. Allowed: JPG, PNG, WEBP, SVG.";
        }
    }

    if (empty($error)) {
        $upd = mysqli_query($conn, "UPDATE `tbl_about` SET 
            `vision_heading`='$heading',
            `vision_content`='$content',
            `vision_image`='$img'
            WHERE `id`=1");

        if ($upd) {
            $msg = "Global Vision updated successfully!";
        } else {
            $error = "Failed to update vision: " . mysqli_error($conn);
        }
    }
}

// Fetch Latest Record
$about = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `tbl_about` WHERE `id`=1"));

$mission_img_exists = !empty($about['mission_image']) && file_exists("../../" . $about['mission_image']);
$vision_img_exists = !empty($about['vision_image']) && file_exists("../../" . $about['vision_image']);
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
                        Strategic Mission &amp; Global Vision
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 13.5px;">
                        Manage the foundational mission statement, global vision, rich narratives, and showcase photos for the About Us page.
                    </p>
                </div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="manage-about-story.php">About Us CMS</a></li>
                    <li class="breadcrumb-item active">Mission &amp; Vision</li>
                </ol>
            </div>

            <!-- Quick Sub-Menu Switcher Pills -->
            <div class="cms-subnav-strip">
                <a href="manage-about-story.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-landmark"></i> Heritage &amp; Story
                </a>
                <a href="manage-about-mission.php" class="cms-subnav-pill active">
                    <i class="fa-solid fa-bullseye"></i> Mission &amp; Vision
                </a>
                <a href="manage-about-industries.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-boxes-packing"></i> Industries We Serve
                </a>
                <a href="manage-about-capabilities.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-truck-ramp-box"></i> Supply Capabilities
                </a>
                <a href="manage-about-stats.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-chart-line"></i> Verified Statistics
                </a>
                <a href="manage-about-cta.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-bullhorn"></i> CTA Banner
                </a>
                <a href="../../about.php" target="_blank" class="cms-subnav-pill cms-subnav-preview">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Preview Live About Page
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
                <div class="table-crud-header">
                    <div class="d-flex flex-wrap align-items-center gap-3 flex-grow-1">
                        <div class="table-crud-search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="directiveSearchInput" class="form-control" placeholder="Search directives...">
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-light text-dark border px-3 py-2" style="font-size: 12.5px; font-weight: 600;">
                            <i class="fa-solid fa-compass text-warning me-1"></i> 2 Strategic Directives Configured
                        </span>
                    </div>
                </div>

                <!-- Strategic Directives Table -->
                <div class="table-responsive">
                    <table class="table table-crud-table" id="directivesTable">
                        <thead>
                            <tr>
                                <th style="width: 110px; text-align: center;">DIRECTIVE</th>
                                <th style="width: 90px; text-align: center;">IMAGE / ICON</th>
                                <th style="width: 28%;">HEADING &amp; TITLE</th>
                                <th style="width: 38%;">STATEMENT / NARRATIVE</th>
                                <th style="width: 140px; text-align: center;">ASSET TYPE</th>
                                <th style="width: 80px; text-align: center;">ACTION</th>
                            </tr>
                        </thead>
                        <tbody id="directivesTableBody">
                            <!-- Row 1: Strategic Mission -->
                            <tr class="directive-row">
                                <td style="text-align: center;">
                                    <span class="badge badge-antara-solid-primary px-2.5 py-1.5" style="font-size: 11.5px; font-weight: 700;">
                                        <i class="fa-solid fa-bullseye me-1"></i> Mission
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <div class="table-icon-thumb mx-auto">
                                        <?php if ($mission_img_exists): ?>
                                            <img src="../../<?= htmlspecialchars($about['mission_image']) ?>" alt="Mission Image">
                                        <?php elseif (file_exists("../../assets/img/icons/mission-target.svg")): ?>
                                            <img src="../../assets/img/icons/mission-target.svg" alt="Mission">
                                        <?php else: ?>
                                            <i class="fa-solid fa-bullseye text-success" style="font-size: 20px;"></i>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark" style="font-size: 14.5px; line-height: 1.35;">
                                        <?= htmlspecialchars($about['mission_heading'] ?? 'Our Strategic Mission') ?>
                                    </div>
                                    <div class="text-muted small mt-0.5">Primary Mission Statement</div>
                                </td>
                                <td>
                                    <div class="table-desc-text" style="font-size: 13px; color: #526058; line-height: 1.5;">
                                        <?= strip_tags($about['mission_content'] ?? '') ?>
                                    </div>
                                </td>
                                <td style="text-align: center;">
                                    <?php if ($mission_img_exists): ?>
                                        <span class="badge badge-antara-primary">
                                            <i class="fa-solid fa-cloud-arrow-up text-success me-1"></i> Custom Image
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-antara-secondary">
                                            <i class="fa-solid fa-sparkles text-warning me-1"></i> Default Graphic
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: center;">
                                    <button type="button" class="btn-action-square btn-action-edit" data-bs-toggle="modal" data-bs-target="#editMissionModal" title="Edit Strategic Mission">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Row 2: Global Vision -->
                            <tr class="directive-row">
                                <td style="text-align: center;">
                                    <span class="badge badge-antara-solid-secondary px-2.5 py-1.5" style="font-size: 11.5px; font-weight: 700;">
                                        <i class="fa-solid fa-compass me-1"></i> Vision
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <div class="table-icon-thumb mx-auto">
                                        <?php if ($vision_img_exists): ?>
                                            <img src="../../<?= htmlspecialchars($about['vision_image']) ?>" alt="Vision Image">
                                        <?php elseif (file_exists("../../assets/img/icons/vision-compass.svg")): ?>
                                            <img src="../../assets/img/icons/vision-compass.svg" alt="Vision">
                                        <?php else: ?>
                                            <i class="fa-solid fa-compass text-warning" style="font-size: 20px;"></i>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark" style="font-size: 14.5px; line-height: 1.35;">
                                        <?= htmlspecialchars($about['vision_heading'] ?? 'Our Global Vision') ?>
                                    </div>
                                    <div class="text-muted small mt-0.5">Long-Term Corporate Vision</div>
                                </td>
                                <td>
                                    <div class="table-desc-text" style="font-size: 13px; color: #526058; line-height: 1.5;">
                                        <?= strip_tags($about['vision_content'] ?? '') ?>
                                    </div>
                                </td>
                                <td style="text-align: center;">
                                    <?php if ($vision_img_exists): ?>
                                        <span class="badge badge-antara-primary">
                                            <i class="fa-solid fa-cloud-arrow-up text-success me-1"></i> Custom Image
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-antara-secondary">
                                            <i class="fa-solid fa-sparkles text-warning me-1"></i> Default Icon
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: center;">
                                    <button type="button" class="btn-action-square btn-action-edit" data-bs-toggle="modal" data-bs-target="#editVisionModal" title="Edit Global Vision">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Mission Modal -->
    <div class="modal fade" id="editMissionModal" tabindex="-1" aria-labelledby="editMissionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #123023 0%, #1B4533 100%);">
                    <h5 class="modal-title fw-bold" id="editMissionModalLabel" style="color: #FFFFFF !important;">
                        <i class="fa-solid fa-bullseye text-warning me-2"></i> Edit Strategic Mission
                    </h5>
                    <button type="button" class="modal-close-btn" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <!-- Mission Heading -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark mb-1">
                                    Mission Heading
                                </label>
                                <input type="text" name="mission_heading" class="form-control" value="<?= htmlspecialchars($about['mission_heading'] ?? '') ?>" placeholder="e.g. Our Strategic Mission (Leave blank to hide)">
                            </div>

                            <!-- Mission Image Upload -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark mb-1">
                                    <i class="fa-solid fa-image text-primary me-1"></i> Mission Card Showcase Photo
                                </label>
                                
                                <?php if ($mission_img_exists): ?>
                                    <div class="p-3 mb-2 bg-light rounded-3 border d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="modal-preview-box">
                                                <img src="../../<?= htmlspecialchars($about['mission_image']) ?>" alt="Mission Image">
                                            </div>
                                            <div>
                                                <span class="badge bg-success mb-1">Active Mission Photo</span>
                                                <div class="text-muted small text-truncate" style="max-width: 250px;"><?= htmlspecialchars(basename($about['mission_image'])) ?></div>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="remove_mission_image" value="1" id="removeMissionImg">
                                            <label class="form-check-label text-danger fw-semibold small" for="removeMissionImg">
                                                <i class="fa-solid fa-trash-can me-1"></i> Remove Image (Use Icon)
                                            </label>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <input type="file" name="mission_image" class="form-control" accept="image/*,.svg">
                                <small class="text-muted mt-1.5 d-block">Recommended size: 600x380px high quality PNG, JPG, or WEBP.</small>
                            </div>

                            <!-- Mission Rich Text Content -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark mb-1">
                                    Mission Statement Narrative (CKEditor)
                                </label>
                                <textarea name="mission_content" id="editor_mission" class="form-control ckeditor" rows="5"><?= htmlspecialchars($about['mission_content'] ?? '') ?></textarea>
                                <small class="text-muted"><strong>Tip:</strong> If both heading and statement narrative are left blank, the Mission card will be hidden on the frontend.</small>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer py-3 px-4 bg-light border-top d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary px-4 py-2 rounded-pill fw-semibold" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="edit_mission" class="btn btn-antara-gold px-4 py-2 rounded-pill fw-bold shadow-sm d-flex align-items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Save Mission
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Vision Modal -->
    <div class="modal fade" id="editVisionModal" tabindex="-1" aria-labelledby="editVisionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #123023 0%, #1B4533 100%);">
                    <h5 class="modal-title fw-bold" id="editVisionModalLabel" style="color: #FFFFFF !important;">
                        <i class="fa-solid fa-compass text-warning me-2"></i> Edit Global Vision
                    </h5>
                    <button type="button" class="modal-close-btn" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <!-- Vision Heading -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark mb-1">
                                    Vision Heading
                                </label>
                                <input type="text" name="vision_heading" class="form-control" value="<?= htmlspecialchars($about['vision_heading'] ?? '') ?>" placeholder="e.g. Our Global Vision (Leave blank to hide)">
                            </div>

                            <!-- Vision Image Upload -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark mb-1">
                                    <i class="fa-solid fa-image text-primary me-1"></i> Vision Card Showcase Photo
                                </label>
                                
                                <?php if ($vision_img_exists): ?>
                                    <div class="p-3 mb-2 bg-light rounded-3 border d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="modal-preview-box">
                                                <img src="../../<?= htmlspecialchars($about['vision_image']) ?>" alt="Vision Image">
                                            </div>
                                            <div>
                                                <span class="badge bg-success mb-1">Active Vision Photo</span>
                                                <div class="text-muted small text-truncate" style="max-width: 250px;"><?= htmlspecialchars(basename($about['vision_image'])) ?></div>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="remove_vision_image" value="1" id="removeVisionImg">
                                            <label class="form-check-label text-danger fw-semibold small" for="removeVisionImg">
                                                <i class="fa-solid fa-trash-can me-1"></i> Remove Image (Use Icon)
                                            </label>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <input type="file" name="vision_image" class="form-control" accept="image/*,.svg">
                                <small class="text-muted mt-1.5 d-block">Recommended size: 600x380px high quality PNG, JPG, or WEBP.</small>
                            </div>

                            <!-- Vision Rich Text Content -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark mb-1">
                                    Vision Statement Narrative (CKEditor)
                                </label>
                                <textarea name="vision_content" id="editor_vision" class="form-control ckeditor" rows="5"><?= htmlspecialchars($about['vision_content'] ?? '') ?></textarea>
                                <small class="text-muted"><strong>Tip:</strong> If both heading and statement narrative are left blank, the Vision card will be hidden on the frontend.</small>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer py-3 px-4 bg-light border-top d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary px-4 py-2 rounded-pill fw-semibold" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="edit_vision" class="btn btn-antara-gold px-4 py-2 rounded-pill fw-bold shadow-sm d-flex align-items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Save Vision
                        </button>
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
            App.init();
            if (window.initAdminCKEditor) {
                window.initAdminCKEditor();
            }

            // Client-side search filtering
            $('#directiveSearchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#directivesTableBody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
</body>
</html>
