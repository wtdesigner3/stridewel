<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// Handle Form Submission
if (isset($_POST['update_choose_section'])) {
    $subheading   = mysqli_real_escape_string($conn, trim($_POST['choose_subheading'] ?? ''));
    $heading      = mysqli_real_escape_string($conn, trim($_POST['choose_heading'] ?? ''));
    $desc         = mysqli_real_escape_string($conn, trim($_POST['choose_desc'] ?? ''));
    $badge_title  = mysqli_real_escape_string($conn, trim($_POST['choose_badge_title'] ?? ''));
    $badge_desc   = mysqli_real_escape_string($conn, trim($_POST['choose_badge_desc'] ?? ''));
    $btn1_text    = mysqli_real_escape_string($conn, trim($_POST['choose_btn1_text'] ?? ''));
    $btn1_link    = mysqli_real_escape_string($conn, trim($_POST['choose_btn1_link'] ?? ''));
    $btn2_text    = mysqli_real_escape_string($conn, trim($_POST['choose_btn2_text'] ?? ''));
    $btn2_link    = mysqli_real_escape_string($conn, trim($_POST['choose_btn2_link'] ?? ''));

    // Fetch current row for images
    $cur = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `tbl_home_content` WHERE `id`=1"));
    $choose_image = $cur['choose_image'] ?? '';

    // Main showcase image removal
    if (isset($_POST['remove_choose_image']) && $_POST['remove_choose_image'] == '1') {
        if (!empty($choose_image) && file_exists("../../" . $choose_image)) {
            @unlink("../../" . $choose_image);
        }
        $choose_image = '';
    }

    // Main showcase image upload
    if (!empty($_FILES['choose_image']['name']) && $_FILES['choose_image']['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES['choose_image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
        if (in_array($ext, $allowed)) {
            $upload_dir = "../../uploads/home/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            $filename = "choose_showcase_" . time() . "_" . rand(100, 999) . "." . $ext;
            if (move_uploaded_file($_FILES['choose_image']['tmp_name'], $upload_dir . $filename)) {
                if (!empty($choose_image) && file_exists("../../" . $choose_image)) {
                    @unlink("../../" . $choose_image);
                }
                $choose_image = "uploads/home/" . $filename;
            }
        } else {
            $error = "Invalid format for showcase image. Allowed: JPG, PNG, WEBP, SVG.";
        }
    }

    // Process 4 advantage cards
    $card_sql_parts = [];
    for ($i = 1; $i <= 4; $i++) {
        $c_title = mysqli_real_escape_string($conn, trim($_POST["choose_card{$i}_title"] ?? ''));
        $c_desc  = mysqli_real_escape_string($conn, trim($_POST["choose_card{$i}_desc"] ?? ''));
        $c_icon  = $cur["choose_card{$i}_icon"] ?? '';

        // Card icon remove
        if (isset($_POST["remove_card{$i}_icon"]) && $_POST["remove_card{$i}_icon"] == '1') {
            if (!empty($c_icon) && file_exists("../../" . $c_icon) && !str_contains($c_icon, 'assets/img/icons/')) {
                @unlink("../../" . $c_icon);
            }
            $c_icon = '';
        }

        // Card icon upload
        if (!empty($_FILES["choose_card{$i}_icon"]['name']) && $_FILES["choose_card{$i}_icon"]['error'] == 0) {
            $ext = strtolower(pathinfo($_FILES["choose_card{$i}_icon"]['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
            if (in_array($ext, $allowed)) {
                $upload_dir = "../../uploads/home/";
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                $filename = "choose_card_{$i}_" . time() . "_" . rand(100, 999) . "." . $ext;
                if (move_uploaded_file($_FILES["choose_card{$i}_icon"]['tmp_name'], $upload_dir . $filename)) {
                    if (!empty($c_icon) && file_exists("../../" . $c_icon) && !str_contains($c_icon, 'assets/img/icons/')) {
                        @unlink("../../" . $c_icon);
                    }
                    $c_icon = "uploads/home/" . $filename;
                }
            }
        }

        $card_sql_parts[] = "`choose_card{$i}_title`='$c_title'";
        $card_sql_parts[] = "`choose_card{$i}_desc`='$c_desc'";
        $card_sql_parts[] = "`choose_card{$i}_icon`='$c_icon'";
    }

    if (empty($error)) {
        $card_updates = implode(', ', $card_sql_parts);
        $upd = mysqli_query($conn, "UPDATE `tbl_home_content` SET 
            `choose_subheading`='$subheading',
            `choose_heading`='$heading',
            `choose_desc`='$desc',
            `choose_image`='$choose_image',
            `choose_badge_title`='$badge_title',
            `choose_badge_desc`='$badge_desc',
            `choose_btn1_text`='$btn1_text',
            `choose_btn1_link`='$btn1_link',
            `choose_btn2_text`='$btn2_text',
            `choose_btn2_link`='$btn2_link',
            $card_updates
            WHERE `id`=1");

        if ($upd) {
            $msg = "Buyer Advantages & 'Why Choose Us' section updated successfully!";
        } else {
            $error = "Failed to update section: " . mysqli_error($conn);
        }
    }
}

// Fetch Latest Record
$home = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `tbl_home_content` WHERE `id`=1"));

$default_icons = [
    1 => 'assets/img/icons/pillar-1-origin.svg',
    2 => 'assets/img/icons/pillar-2-quality.svg',
    3 => 'assets/img/icons/pillar-3-logistics.svg',
    4 => 'assets/img/icons/pillar-4-support.svg',
];
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
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3 pb-2 border-bottom">
                <div>
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="manage-home-hero.php">Home Page CMS</a></li>
                        <li class="breadcrumb-item active">Buyer Advantages &amp; Why Choose Us</li>
                    </ol>
                    <h1 class="page-header mb-0" style="font-size: 22px; font-weight: 800; color: #123023;">
                        <i class="fa-solid fa-award text-warning me-2"></i> Why International Buyers Choose Antara Globale CMS
                    </h1>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="../../index.php" target="_blank" class="btn btn-outline-success btn-sm px-3">
                        <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Preview Live Homepage
                    </a>
                </div>
            </div>

            <!-- Quick Sub-Menu Switcher Pills -->
            <div class="cms-subnav-strip mb-4">
                <a href="manage-home-hero.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-images"></i> Hero Banners
                </a>
                <a href="manage-home-pillars.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-shapes"></i> Export Pillars (3 Blocks)
                </a>
                <a href="manage-home-intro.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-file-lines"></i> Corporate Story Intro
                </a>
                <a href="manage-home-terroir.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-mountain"></i> Origin Terroir Belts
                </a>
                <a href="manage-home-choose.php" class="cms-subnav-pill active">
                    <i class="fa-solid fa-award"></i> Why Choose Us (Advantages)
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

            <form method="POST" enctype="multipart/form-data">
                <div class="row g-4">
                    <!-- Left Column: Settings & Cards -->
                    <div class="col-lg-8">
                        
                        <!-- Panel 1: Section Header & Lead Texts -->
                        <div class="card border-0 shadow-sm rounded-3 mb-4">
                            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                                <h5 class="mb-0 fw-bold" style="color: #123023;">
                                    <i class="fa-solid fa-heading text-success me-2"></i> Section Heading &amp; Narrative
                                </h5>
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Live Synchronized</span>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Subtitle / Eyebrow Tag</label>
                                    <input type="text" name="choose_subheading" class="form-control" value="<?= htmlspecialchars($home['choose_subheading'] ?? '') ?>" placeholder="e.g. EXPORT ADVANTAGES">
                                    <small class="text-muted">Appears in gold small caps above the main title.</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Main Section Title</label>
                                    <input type="text" name="choose_heading" class="form-control" value="<?= htmlspecialchars($home['choose_heading'] ?? '') ?>" placeholder="e.g. Why International Buyers Choose Antara Globale">
                                </div>

                                <div class="mb-0">
                                    <label class="form-label fw-bold">Lead Paragraph / Narrative</label>
                                    <textarea name="choose_desc" class="form-control no-ckeditor" data-no-ckeditor="true" rows="3" placeholder="An export-first methodology designed for international contract structures..."><?= htmlspecialchars($home['choose_desc'] ?? '') ?></textarea>
                                    <small class="text-muted">Context text displayed directly below the title.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Panel 2: 4 Advantage Value Cards -->
                        <div class="card border-0 shadow-sm rounded-3 mb-4">
                            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                                <h5 class="mb-0 fw-bold" style="color: #123023;">
                                    <i class="fa-solid fa-layer-group text-primary me-2"></i> 4 Buyer Advantage Cards
                                </h5>
                                <small class="text-muted">(Leave title &amp; description blank to hide any individual card)</small>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <?php for ($i = 1; $i <= 4; $i++): 
                                        $c_title = $home["choose_card{$i}_title"] ?? '';
                                        $c_desc  = $home["choose_card{$i}_desc"] ?? '';
                                        $c_icon  = $home["choose_card{$i}_icon"] ?? '';
                                        $has_custom_icon = !empty($c_icon) && file_exists("../../" . $c_icon);
                                        $fallback_icon = $default_icons[$i] ?? 'assets/img/icons/pillar-1-origin.svg';
                                    ?>
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded-3 bg-light h-100 d-flex flex-column">
                                            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                                <span class="badge bg-dark text-white fw-bold px-2 py-1">Card #<?= $i ?></span>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="small text-muted">Preview:</span>
                                                    <div class="d-inline-flex align-items-center justify-content-center bg-white rounded p-1 border shadow-xs" style="width: 40px; height: 40px; overflow: hidden;">
                                                        <?php if ($has_custom_icon): ?>
                                                            <img src="../../<?= htmlspecialchars($c_icon) ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;" alt="Card Image">
                                                        <?php elseif (file_exists("../../" . $fallback_icon)): ?>
                                                            <img src="../../<?= htmlspecialchars($fallback_icon) ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;" alt="Default Image">
                                                        <?php else: ?>
                                                            <i class="fa-solid fa-image text-muted"></i>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold small text-muted text-uppercase mb-1">Title</label>
                                                <input type="text" name="choose_card<?= $i ?>_title" class="form-control form-control-sm" value="<?= htmlspecialchars($c_title) ?>" placeholder="Card #<?= $i ?> Title">
                                            </div>

                                            <div class="mb-3 flex-grow-1">
                                                <label class="form-label fw-bold small text-muted text-uppercase mb-1">Description</label>
                                                <textarea name="choose_card<?= $i ?>_desc" class="form-control form-control-sm no-ckeditor" data-no-ckeditor="true" rows="4" placeholder="Brief advantage narrative..."><?= htmlspecialchars($c_desc) ?></textarea>
                                            </div>

                                            <div class="mt-auto pt-2 border-top">
                                                <label class="form-label fw-bold small text-muted text-uppercase mb-1">
                                                    <i class="fa-solid fa-image text-primary me-1"></i> Upload Card Image
                                                </label>
                                                <input type="file" name="choose_card<?= $i ?>_icon" class="form-control form-control-sm" accept="image/*,.svg">
                                                <small class="text-muted d-block mt-1" style="font-size: 11.5px;">Upload PNG, JPG, WEBP, or SVG image (transparent recommended).</small>
                                                <?php if ($has_custom_icon): ?>
                                                    <div class="form-check mt-1">
                                                        <input class="form-check-input" type="checkbox" name="remove_card<?= $i ?>_icon" value="1" id="rem_card_<?= $i ?>">
                                                        <label class="form-check-label small text-danger" for="rem_card_<?= $i ?>">
                                                            Remove custom image
                                                        </label>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Panel 3: Call to Action Buttons -->
                        <div class="card border-0 shadow-sm rounded-3 mb-4">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h5 class="mb-0 fw-bold" style="color: #123023;">
                                    <i class="fa-solid fa-link text-warning me-2"></i> Action Buttons
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Primary Button Text</label>
                                        <input type="text" name="choose_btn1_text" class="form-control" value="<?= htmlspecialchars($home['choose_btn1_text'] ?? 'Request Specifications & Quote') ?>" placeholder="e.g. Request Specifications & Quote">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Primary Button Target / Link</label>
                                        <input type="text" name="choose_btn1_link" class="form-control" value="<?= htmlspecialchars($home['choose_btn1_link'] ?? '#b2bEnquiryModal') ?>" placeholder="e.g. #b2bEnquiryModal or contact.php">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Secondary Button Text</label>
                                        <input type="text" name="choose_btn2_text" class="form-control" value="<?= htmlspecialchars($home['choose_btn2_text'] ?? 'About Company') ?>" placeholder="e.g. About Company">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Secondary Button Link</label>
                                        <input type="text" name="choose_btn2_link" class="form-control" value="<?= htmlspecialchars($home['choose_btn2_link'] ?? 'about.php') ?>" placeholder="e.g. about.php">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Left Showcase Media & Floating Badge -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-3 mb-4">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h5 class="mb-0 fw-bold" style="color: #123023;">
                                    <i class="fa-solid fa-image text-info me-2"></i> Left Showcase Image
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <?php 
                                $showcase_img = $home['choose_image'] ?? '';
                                $has_showcase = !empty($showcase_img) && file_exists("../../" . $showcase_img);
                                ?>
                                <div class="mb-3 text-center">
                                    <?php if ($has_showcase): ?>
                                        <img src="../../<?= htmlspecialchars($showcase_img) ?>" alt="Showcase Preview" class="img-fluid rounded-3 border shadow-sm" style="max-height: 220px; object-fit: cover; width: 100%;">
                                    <?php elseif (!empty($showcase_img) && file_exists("../../" . $showcase_img)): ?>
                                        <img src="../../<?= htmlspecialchars($showcase_img) ?>" alt="Showcase Preview" class="img-fluid rounded-3 border shadow-sm" style="max-height: 220px; object-fit: cover; width: 100%;">
                                    <?php else: ?>
                                        <div class="p-4 bg-light rounded text-center border text-muted">
                                            <i class="fa-solid fa-image fa-2x mb-2 d-block text-secondary"></i>
                                            No image uploaded
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Upload New Showcase Photo</label>
                                    <input type="file" name="choose_image" class="form-control" accept="image/*">
                                    <small class="text-muted">High-resolution estate or container seaport imagery recommended (approx. 800x800px).</small>
                                </div>

                                <?php if ($has_showcase): ?>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="remove_choose_image" value="1" id="rem_showcase">
                                        <label class="form-check-label text-danger small" for="rem_showcase">
                                            Remove showcase image (renders text full-width)
                                        </label>
                                    </div>
                                <?php endif; ?>

                                <hr class="my-4">

                                <h6 class="fw-bold mb-3" style="color: #123023;">
                                    <i class="fa-solid fa-shield-check text-success me-1"></i> Floating Trust Badge
                                </h6>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-muted text-uppercase mb-1">Badge Title</label>
                                    <input type="text" name="choose_badge_title" class="form-control form-control-sm" value="<?= htmlspecialchars($home['choose_badge_title'] ?? '') ?>" placeholder="e.g. 100% Export Grade">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-muted text-uppercase mb-1">Badge Subtext</label>
                                    <input type="text" name="choose_badge_desc" class="form-control form-control-sm" value="<?= htmlspecialchars($home['choose_badge_desc'] ?? '') ?>" placeholder="e.g. Direct Farmgate to Seaport">
                                </div>
                                <small class="text-muted">Appears floating at the bottom of the showcase photograph.</small>
                            </div>
                        </div>

                        <!-- Sticky Save Button -->
                        <div class="card border-0 shadow-sm rounded-3">
                            <div class="card-body p-3">
                                <button type="submit" name="update_choose_section" class="btn btn-warning w-100 py-2 fw-bold shadow-sm">
                                    <i class="fa-solid fa-floppy-disk me-1"></i> Save Advantages Section
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div>
        
        <?php require('includes/footer.php'); ?>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('textarea.no-ckeditor, textarea[data-no-ckeditor="true"]').forEach(function(el) {
            el.dataset.ckeditorInitialized = 'true';
            el.dataset.noCkeditor = 'true';
            if (window.ckeditor5Instances && window.ckeditor5Instances[el.id]) {
                try {
                    window.ckeditor5Instances[el.id].destroy();
                    delete window.ckeditor5Instances[el.id];
                } catch(e) {}
            }
        });
    });
    </script>
</body>
</html>
