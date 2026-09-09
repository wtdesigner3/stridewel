<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// Handle Corporate Intro Update (with CKEditor)
if (isset($_POST['update_about_intro'])) {
    $cur_q = mysqli_query($conn, "SELECT `about_image` FROM `tbl_home_content` WHERE `id`=1");
    $cur = mysqli_fetch_assoc($cur_q);
    $img = $cur['about_image'] ?? 'assets/img/about/about-thumb.jpg';

    if (!empty($_FILES['about_image']['name'])) {
        $ext = pathinfo($_FILES['about_image']['name'], PATHINFO_EXTENSION);
        $new_name = "home_about_" . time() . "." . $ext;
        if (move_uploaded_file($_FILES['about_image']['tmp_name'], "../../uploads/home/" . $new_name)) {
            $img = "uploads/home/" . $new_name;
        }
    }

    $subheading = mysqli_real_escape_string($conn, trim($_POST['about_subheading']));
    $heading = mysqli_real_escape_string($conn, trim($_POST['about_heading']));
    $content = mysqli_real_escape_string($conn, trim($_POST['about_content']));
    $badge_title = mysqli_real_escape_string($conn, trim($_POST['about_badge_title'] ?? 'Sourcing & Trading Desk'));
    $badge_exp = mysqli_real_escape_string($conn, trim($_POST['about_badge_exp']));
    $stat_vol = mysqli_real_escape_string($conn, trim($_POST['about_stat_vol']));
    $stat_ports = mysqli_real_escape_string($conn, trim($_POST['about_stat_ports']));

    $upd = mysqli_query($conn, "UPDATE `tbl_home_content` SET 
        `about_subheading`='$subheading',
        `about_heading`='$heading',
        `about_content`='$content',
        `about_badge_title`='$badge_title',
        `about_badge_exp`='$badge_exp',
        `about_stat_vol`='$stat_vol',
        `about_stat_ports`='$stat_ports',
        `about_image`='$img'
        WHERE `id`=1");

    if ($upd) {
        $msg = "Homepage corporate overview & CKEditor rich text updated successfully!";
    } else {
        $error = "Failed to update corporate intro: " . mysqli_error($conn);
    }
}

// Fetch Latest Record
$home = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `tbl_home_content` WHERE `id`=1"));
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
                    <h1 class="page-header mb-1">
                        <i class="fa-solid fa-file-lines text-warning me-2"></i> Homepage Corporate Intro Section
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 13px;">Manage the corporate heritage overview section with rich-text formatted story using CKEditor, key points, experience badge, and estate image.</p>
                </div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="manage-home-hero.php">Home Page CMS</a></li>
                    <li class="breadcrumb-item active">Corporate Intro</li>
                </ol>
            </div>

            <!-- Quick Sub-Menu Switcher Pills -->
            <div class="cms-subnav-strip">
                <a href="manage-home-hero.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-images"></i> Hero Carousel Banners
                </a>
                <a href="manage-home-intro.php" class="cms-subnav-pill active">
                    <i class="fa-solid fa-file-lines"></i> Corporate Story Intro
                </a>
                <a href="manage-home-pillars.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-gem"></i> Why Choose Us Pillars
                </a>
                <a href="manage-home-terroir.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-mountain"></i> Origin Terroir Belts
                </a>
                <a href="../../index.php" target="_blank" class="cms-subnav-pill cms-subnav-preview">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Preview Live Homepage
                </a>
            </div>

            <!-- Alerts -->
            <?php if (!empty($msg)): ?>
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="fa-solid fa-circle-check fs-4 me-3 text-success"></i>
                    <div><strong>Success!</strong> <?= htmlspecialchars($msg) ?></div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="fa-solid fa-triangle-exclamation fs-4 me-3 text-danger"></i>
                    <div><strong>Error!</strong> <?= htmlspecialchars($error) ?></div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="row g-4">
                    <!-- Left Form Column -->
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-3 mb-4">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h5 class="mb-0 fw-bold" style="color: #123023;">
                                    <i class="fa-solid fa-pen-nib text-warning me-2"></i> Corporate Story & Headlines
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Subtitle Badge</label>
                                        <input type="text" name="about_subheading" class="form-control" value="<?= htmlspecialchars($home['about_subheading'] ?? '') ?>" placeholder="e.g. AUTHENTIC INDIAN COMMODITIES (Leave blank to hide)">
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label fw-bold">Section Main Heading</label>
                                        <input type="text" name="about_heading" class="form-control" value="<?= htmlspecialchars($home['about_heading'] ?? '') ?>" placeholder="e.g. Direct-Origin Agricultural Commodities & Global Foodservice Supply (Leave blank to hide)">
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label fw-bold d-flex align-items-center justify-content-between">
                                        <span>Corporate Description & Origin Story (Rich Text CKEditor)</span>
                                        <span class="badge" style="background: rgba(197, 160, 89, 0.15); color: #C5A059; border: 1px solid rgba(197, 160, 89, 0.3); font-size: 11px;"><i class="fa-solid fa-wand-magic-sparkles me-1"></i> CKEditor 5 Super-Build Enabled</span>
                                    </label>
                                    <textarea name="about_content" id="editor_home_about" class="form-control ckeditor" rows="12"><?= htmlspecialchars($home['about_content'] ?? '') ?></textarea>
                                    <small class="text-muted">Use bold, links, lists, and formatted paragraphs. Content is rendered dynamically on the homepage.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Image & Metrics -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-3 mb-4">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h5 class="mb-0 fw-bold" style="color: #123023;">
                                    <i class="fa-solid fa-image text-success me-2"></i> Section Featured Image
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <?php if (!empty($home['about_image'])): ?>
                                    <div class="mb-3 text-center p-2 border rounded bg-light">
                                        <img src="../../<?= htmlspecialchars($home['about_image']) ?>" alt="Intro Image" style="max-height: 200px; width: 100%; object-fit: cover; border-radius: 6px;">
                                    </div>
                                <?php endif; ?>
                                <label class="form-label fw-bold">Replace Featured Image</label>
                                <input type="file" name="about_image" class="form-control mb-2" accept="image/*">
                                <small class="text-muted d-block">Recommended size: 800x650px high quality PNG or JPG.</small>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-3 mb-4">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h5 class="mb-0 fw-bold" style="color: #123023;">
                                    <i class="fa-solid fa-award text-warning me-2"></i> Trade Metrics & Badges
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Floating Badge Title</label>
                                    <input type="text" name="about_badge_title" class="form-control" value="<?= htmlspecialchars($home['about_badge_title'] ?? 'Sourcing & Trading Desk') ?>" placeholder="e.g. Sourcing & Trading Desk">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Experience Floating Badge Text</label>
                                    <input type="text" name="about_badge_exp" class="form-control" value="<?= htmlspecialchars($home['about_badge_exp'] ?? '15+ Years Origin Experience') ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Annual Volume Metric</label>
                                    <input type="text" name="about_stat_vol" class="form-control" value="<?= htmlspecialchars($home['about_stat_vol'] ?? '12,000+ MT') ?>" placeholder="e.g. 12,000+ MT">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Destination Seaports Metric</label>
                                    <input type="text" name="about_stat_ports" class="form-control" value="<?= htmlspecialchars($home['about_stat_ports'] ?? '24+ Global Ports') ?>" placeholder="e.g. 24+ Global Ports">
                                </div>
                            </div>
                        </div>

                        <button type="submit" name="update_about_intro" class="btn btn-warning btn-lg w-100 fw-bold shadow-sm py-3">
                            <i class="fa-solid fa-floppy-disk me-2"></i> Save Corporate Intro
                        </button>
                    </div>
                </div>
            </form>
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
        });
    </script>
</body>
</html>
