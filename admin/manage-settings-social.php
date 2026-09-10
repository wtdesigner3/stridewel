<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// Handle Social Profiles Update
if (isset($_POST['update_social'])) {
    $linkedin = mysqli_real_escape_string($conn, trim($_POST['con_linkedin']));
    $instagram = mysqli_real_escape_string($conn, trim($_POST['con_instagram']));
    $facebook = mysqli_real_escape_string($conn, trim($_POST['con_facebook']));
    $twitter = mysqli_real_escape_string($conn, trim($_POST['con_twitter']));
    $youtube = mysqli_real_escape_string($conn, trim($_POST['con_youtube']));

    $upd = mysqli_query($conn, "UPDATE `tbl_contact` SET 
        `con_linkedin`='$linkedin',
        `con_instagram`='$instagram',
        `con_facebook`='$facebook',
        `con_twitter`='$twitter',
        `con_youtube`='$youtube'
        WHERE `con_id`=1");

    if ($upd) {
        $msg = "Social media handles updated successfully!";
    } else {
        $error = "Failed to update social profiles: " . mysqli_error($conn);
    }
}

// Fetch Current Contact Record
$contact = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `tbl_contact` WHERE `con_id`=1"));
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
                        <li class="breadcrumb-item active">Social Media Handles</li>
                    </ol>
                    <h1 class="page-header mb-0">
                        <i class="fa-solid fa-share-nodes text-warning me-2"></i> Corporate Social Media Handles
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
                <a href="manage-settings-branding.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-palette"></i> Brand Logos & Favicon
                </a>
                <a href="manage-settings-seo.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-magnifying-glass-chart"></i> Global SEO & Footers
                </a>
                <a href="manage-settings-social.php" class="cms-subnav-pill active">
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

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                            <h5 class="mb-0 fw-bold" style="color: #123023;">
                                <i class="fa-solid fa-link text-warning me-2"></i> Active Social Media URLs
                            </h5>
                            <span class="badge bg-light text-dark border">External Channels</span>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">LinkedIn Corporate Company Page</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-primary"><i class="fa-brands fa-linkedin-in fs-5"></i></span>
                                        <input type="url" name="con_linkedin" class="form-control" value="<?= htmlspecialchars($contact['con_linkedin'] ?? '') ?>" placeholder="https://www.linkedin.com/company/antaraglobale">
                                    </div>
                                    <small class="text-muted">High-priority network for B2B commodity procurement partners.</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Instagram Handle</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-danger"><i class="fa-brands fa-instagram fs-5"></i></span>
                                        <input type="url" name="con_instagram" class="form-control" value="<?= htmlspecialchars($contact['con_instagram'] ?? '') ?>" placeholder="https://www.instagram.com/antaraglobale">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Facebook Business Page</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-primary"><i class="fa-brands fa-facebook-f fs-5"></i></span>
                                        <input type="url" name="con_facebook" class="form-control" value="<?= htmlspecialchars($contact['con_facebook'] ?? '') ?>" placeholder="https://www.facebook.com/antaraglobale">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Twitter / X Corporate Handle</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-dark"><i class="fa-brands fa-twitter fs-5"></i></span>
                                        <input type="url" name="con_twitter" class="form-control" value="<?= htmlspecialchars($contact['con_twitter'] ?? '') ?>" placeholder="https://x.com/antaraglobale">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">YouTube Channel / Corporate Videos</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-danger"><i class="fa-brands fa-youtube fs-5"></i></span>
                                        <input type="url" name="con_youtube" class="form-control" value="<?= htmlspecialchars($contact['con_youtube'] ?? '') ?>" placeholder="https://www.youtube.com/@antaraglobale">
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" name="update_social" class="btn btn-warning btn-lg px-5 fw-bold shadow-sm">
                                        <i class="fa-solid fa-floppy-disk me-2"></i> Save Social Media Handles
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Quick Info -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="mb-0 fw-bold" style="color: #123023;">
                                <i class="fa-solid fa-circle-question text-info me-2"></i> Where These Display
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex align-items-center gap-2 mb-3">
                                    <i class="fa-solid fa-check text-success"></i>
                                    <span class="small">Header Offcanvas Menu (mobile & desktop)</span>
                                </li>
                                <li class="d-flex align-items-center gap-2 mb-3">
                                    <i class="fa-solid fa-check text-success"></i>
                                    <span class="small">Main Corporate Footer (bottom of all pages)</span>
                                </li>
                                <li class="d-flex align-items-center gap-2 mb-3">
                                    <i class="fa-solid fa-check text-success"></i>
                                    <span class="small">Contact Us Page Social Channels Box</span>
                                </li>
                                <li class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-check text-success"></i>
                                    <span class="small">Interactive B2B Quote Email Signatures</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
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
        });
    </script>
</body>
</html>
