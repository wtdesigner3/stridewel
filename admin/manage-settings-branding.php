<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// Handle Branding & Logos Update
if (isset($_POST['update_branding'])) {
    $pro_title = mysqli_real_escape_string($conn, trim($_POST['pro_title']));
    
    // Fetch existing logos
    $cur_prof_q = mysqli_query($conn, "SELECT `pro_logo`, `pro_dark_logo`, `pro_favicon` FROM `tbl_profile` WHERE `pro_id`=1");
    $cur_prof = mysqli_fetch_assoc($cur_prof_q);
    $logo = $cur_prof['pro_logo'] ?? 'assets/img/logo/antara-logo-white.svg';
    $dark_logo = $cur_prof['pro_dark_logo'] ?? 'assets/img/logo/antara-logo-dark.svg';
    $favicon = $cur_prof['pro_favicon'] ?? 'assets/img/logo/favicon.png';

    $upload_dir = "../uploads/logo/";
    if (!is_dir($upload_dir)) {
        @mkdir($upload_dir, 0777, true);
    }

    // Handle White Logo Upload
    if (!empty($_FILES['pro_logo']['name'])) {
        $ext = pathinfo($_FILES['pro_logo']['name'], PATHINFO_EXTENSION);
        $new_name = "logo_white_" . time() . "." . $ext;
        if (move_uploaded_file($_FILES['pro_logo']['tmp_name'], $upload_dir . $new_name)) {
            $logo = "uploads/logo/" . $new_name;
        }
    }

    // Handle Dark Logo Upload
    if (!empty($_FILES['pro_dark_logo']['name'])) {
        $ext = pathinfo($_FILES['pro_dark_logo']['name'], PATHINFO_EXTENSION);
        $new_name = "logo_dark_" . time() . "." . $ext;
        if (move_uploaded_file($_FILES['pro_dark_logo']['tmp_name'], $upload_dir . $new_name)) {
            $dark_logo = "uploads/logo/" . $new_name;
        }
    }

    // Handle Favicon Upload
    if (!empty($_FILES['pro_favicon']['name'])) {
        $ext = pathinfo($_FILES['pro_favicon']['name'], PATHINFO_EXTENSION);
        $new_name = "favicon_" . time() . "." . $ext;
        if (move_uploaded_file($_FILES['pro_favicon']['tmp_name'], $upload_dir . $new_name)) {
            $favicon = "uploads/logo/" . $new_name;
        }
    }

    $upd = mysqli_query($conn, "UPDATE `tbl_profile` SET 
        `pro_title`='$pro_title',
        `pro_logo`='$logo',
        `pro_dark_logo`='$dark_logo',
        `pro_favicon`='$favicon'
        WHERE `pro_id`=1");

    if ($upd) {
        $msg = "Website branding, logos, and favicon updated successfully!";
    } else {
        $error = "Failed to update branding settings: " . mysqli_error($conn);
    }
}

// Fetch Current Records
$profile = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `tbl_profile` WHERE `pro_id`=1"));
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
                        <li class="breadcrumb-item"><a href="manage-settings-branding.php">Settings</a></li>
                        <li class="breadcrumb-item active">Branding & Logos</li>
                    </ol>
                    <h1 class="page-header mb-0">
                        <i class="fa-solid fa-palette text-warning me-2"></i> Website Branding & Logo Assets
                    </h1>
                </div>
                <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                    <a href="../index.php" target="_blank" class="btn btn-outline-success btn-sm px-3">
                        <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Live Website
                    </a>
                </div>
            </div>

            <!-- Modern Sub-Menu Switcher Pills -->
            <div class="cms-subnav-strip mb-3">
                <a href="manage-settings-branding.php" class="cms-subnav-pill active">
                    <i class="fa-solid fa-palette"></i> Brand Logos & Favicon
                </a>
                <a href="manage-settings-seo.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-magnifying-glass-chart"></i> Global SEO & Footers
                </a>
                <a href="manage-settings-social.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-share-nodes"></i> Social Media Handles
                </a>
                <a href="manage-settings-widgets.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-phone-volume"></i> Floating Action Widgets
                </a>
                <div class="ms-auto">
                    <a href="../index.php" target="_blank" class="cms-subnav-pill cms-subnav-preview">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Preview Live
                    </a>
                </div>
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
                    <div class="col-lg-12">
                        <div class="card border-0 shadow-sm rounded-3 mb-4">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h5 class="mb-0 fw-bold" style="color: #103755;">
                                    <i class="fa-solid fa-heading text-warning me-2"></i> Website Title & Brand Name
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-2">
                                    <label class="form-label fw-bold">Site Title (Used in browser tabs & SEO headers)</label>
                                    <input type="text" name="pro_title" class="form-control form-control-lg" value="<?= htmlspecialchars($profile['pro_title'] ?? '') ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- White Logo -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h6 class="mb-0 fw-bold" style="color: #103755;">
                                    <i class="fa-solid fa-sun text-warning me-2"></i> Primary White Logo
                                </h6>
                            </div>
                            <div class="card-body p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <p class="small text-muted mb-3">Rendered over transparent hero headers and dark green footer columns.</p>
                                    <div class="p-4 rounded-3 text-center mb-3" style="background: #103755; border: 1px solid rgba(255,255,255,0.1);">
                                        <?php if (!empty($profile['pro_logo'])): ?>
                                            <img src="../<?= htmlspecialchars($profile['pro_logo']) ?>" alt="White Logo Preview" style="max-height: 48px; max-width: 100%;">
                                        <?php else: ?>
                                            <span class="text-white-50">No Logo Uploaded</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label fw-bold small">Upload New White Logo</label>
                                    <input type="file" name="pro_logo" class="form-control" accept="image/*,.svg">
                                    <small class="text-muted">Accepts SVG, PNG with transparency.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dark Logo -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h6 class="mb-0 fw-bold" style="color: #103755;">
                                    <i class="fa-solid fa-moon text-primary me-2"></i> Sticky & Inner Dark Logo
                                </h6>
                            </div>
                            <div class="card-body p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <p class="small text-muted mb-3">Rendered over solid white sticky header and inner pages (About, Contact, Products).</p>
                                    <div class="p-4 rounded-3 text-center mb-3 bg-light border">
                                        <?php if (!empty($profile['pro_dark_logo'])): ?>
                                            <img src="../<?= htmlspecialchars($profile['pro_dark_logo']) ?>" alt="Dark Logo Preview" style="max-height: 48px; max-width: 100%;">
                                        <?php else: ?>
                                            <span class="text-muted">No Dark Logo Uploaded</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label fw-bold small">Upload New Dark Logo</label>
                                    <input type="file" name="pro_dark_logo" class="form-control" accept="image/*,.svg">
                                    <small class="text-muted">Accepts SVG, PNG with transparency.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Favicon -->
                    <div class="col-lg-4 col-md-12">
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h6 class="mb-0 fw-bold" style="color: #103755;">
                                    <i class="fa-solid fa-globe text-success me-2"></i> Website Favicon
                                </h6>
                            </div>
                            <div class="card-body p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <p class="small text-muted mb-3">Displayed in web browser tabs, bookmarks, and mobile shortcut icons.</p>
                                    <div class="p-4 rounded-3 text-center mb-3 bg-light border d-flex align-items-center justify-content-center gap-3">
                                        <?php if (!empty($profile['pro_favicon'])): ?>
                                            <img src="../<?= htmlspecialchars($profile['pro_favicon']) ?>" alt="Favicon Preview" style="width: 38px; height: 38px; object-fit: contain;">
                                            <span class="small text-muted">Tab Icon (32x32)</span>
                                        <?php else: ?>
                                            <span class="text-muted">No Favicon Uploaded</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label fw-bold small">Upload New Favicon</label>
                                    <input type="file" name="pro_favicon" class="form-control" accept="image/*,.ico,.png">
                                    <small class="text-muted">Square 32x32 or 64x64 PNG or ICO.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" name="update_branding" class="btn btn-warning btn-lg px-5 fw-bold shadow-sm">
                            <i class="fa-solid fa-floppy-disk me-2"></i> Save Branding Assets
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
        });
    </script>
</body>
</html>
