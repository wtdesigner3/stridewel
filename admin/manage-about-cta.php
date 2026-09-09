<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// Handle CTA Section Update
if (isset($_POST['update_cta'])) {
    $cur_q = mysqli_query($conn, "SELECT `cta_bg_image` FROM `tbl_about` WHERE `id`=1");
    $cur = mysqli_fetch_assoc($cur_q);
    $bg_img = $cur['cta_bg_image'] ?? 'assets/img/commodities/shipping-logistics-port.jpg';

    // Handle background image upload
    if (!empty($_FILES['cta_bg_image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['cta_bg_image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
        if (in_array($ext, $allowed)) {
            $upload_dir = "../../uploads/about/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            $new_name = "about_cta_bg_" . time() . "." . $ext;
            if (move_uploaded_file($_FILES['cta_bg_image']['tmp_name'], $upload_dir . $new_name)) {
                $bg_img = "uploads/about/" . $new_name;
            }
        } else {
            $error = "Invalid image format. Allowed: JPG, PNG, WEBP, AVIF.";
        }
    }

    $subheading = mysqli_real_escape_string($conn, trim($_POST['cta_subheading']));
    $heading = mysqli_real_escape_string($conn, trim($_POST['cta_heading']));
    $desc = mysqli_real_escape_string($conn, trim($_POST['cta_desc']));
    $btn_text = mysqli_real_escape_string($conn, trim($_POST['cta_btn_text']));
    $btn_link = mysqli_real_escape_string($conn, trim($_POST['cta_btn_link']));
    $btn_action = mysqli_real_escape_string($conn, trim($_POST['cta_btn_action'] ?? 'link'));

    if (empty($error)) {
        $upd = mysqli_query($conn, "UPDATE `tbl_about` SET 
            `cta_subheading`='$subheading',
            `cta_heading`='$heading',
            `cta_desc`='$desc',
            `cta_btn_text`='$btn_text',
            `cta_btn_link`='$btn_link',
            `cta_btn_action`='$btn_action',
            `cta_bg_image`='$bg_img'
            WHERE `id`=1");

        if ($upd) {
            $msg = "Call-To-Action (CTA) banner updated successfully!";
        } else {
            $error = "Failed to update CTA banner: " . mysqli_error($conn);
        }
    }
}

// Fetch Latest Record
$about = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `tbl_about` WHERE `id`=1"));
$cta_bg = !empty($about['cta_bg_image']) && file_exists("../../" . $about['cta_bg_image']) ? ("../../" . $about['cta_bg_image']) : "../../assets/img/commodities/shipping-logistics-port.jpg";
?>
<!DOCTYPE html>
<html lang="en">
<?php require('includes/head.php'); ?>
<style>
.admin-cta-preview-box {
    background: linear-gradient(135deg, rgba(18, 43, 34, 0.92) 0%, rgba(22, 58, 44, 0.86) 50%, rgba(45, 30, 23, 0.92) 100%), url('<?= htmlspecialchars($cta_bg) ?>') center/cover no-repeat;
    color: #FFFFFF;
    padding: 60px 30px;
    border-radius: 18px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 16px 40px rgba(18, 43, 34, 0.25);
    border: 1px solid rgba(197, 160, 89, 0.35);
    text-align: center;
}
.admin-cta-preview-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #C5A059;
    color: #123023;
    font-weight: 700;
    padding: 12px 28px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 15px;
    box-shadow: 0 4px 15px rgba(197, 160, 89, 0.35);
}
</style>
<body>
    <div id="page-container" class="page-sidebar-fixed page-header-fixed show">
        <?php require('includes/header.php'); ?>
        <?php require('includes/left.php'); ?>
        
        <div id="content" class="content">
            <!-- Header Title Bar & Breadcrumbs -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <div>
                    <h1 class="page-header mb-1" style="font-size: 24px; font-weight: 800; color: #123023;">
                        Call-To-Action (CTA) Banner Management
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 13.5px;">
                        Manage the bottom conversion banner displayed on the About Us page, including headline, description, button destination, and background maritime photo.
                    </p>
                </div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="manage-about-story.php">About Us CMS</a></li>
                    <li class="breadcrumb-item active">CTA Banner</li>
                </ol>
            </div>

            <!-- Quick Sub-Menu Switcher Pills -->
            <div class="cms-subnav-strip">
                <a href="manage-about-story.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-landmark"></i> Heritage &amp; Story
                </a>
                <a href="manage-about-mission.php" class="cms-subnav-pill">
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
                <a href="manage-about-cta.php" class="cms-subnav-pill active">
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

            <!-- Live Frontend Visual Preview Banner -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold" style="color: #123023; font-size: 15px;">
                        <i class="fa-solid fa-eye text-primary me-2"></i> Live Frontend Visual Preview
                    </h5>
                    <span class="badge bg-light text-muted border px-2.5 py-1">About Us Page Footer Banner</span>
                </div>
                <div class="card-body p-4 bg-light">
                    <div class="admin-cta-preview-box">
                        <?php if (!empty(trim($about['cta_subheading'] ?? ''))): ?>
                            <span class="badge bg-warning text-dark px-3 py-1.5 text-uppercase fw-bold mb-3" style="letter-spacing: 1px; font-size: 11.5px;">
                                <?= htmlspecialchars($about['cta_subheading']) ?>
                            </span>
                        <?php endif; ?>
                        <?php if (!empty(trim($about['cta_heading'] ?? ''))): ?>
                            <h2 class="text-white mb-3" style="font-size: 32px; font-weight: 700; line-height: 1.3; max-width: 780px; margin: 0 auto 14px;">
                                <?= htmlspecialchars($about['cta_heading']) ?>
                            </h2>
                        <?php else: ?>
                            <div class="text-white text-opacity-50 fst-italic mb-2">[CTA Heading blank - hidden on frontend]</div>
                        <?php endif; ?>
                        <?php if (!empty(trim($about['cta_desc'] ?? ''))): ?>
                            <p class="text-white text-opacity-75 mb-4" style="font-size: 15.5px; max-width: 660px; margin: 0 auto 24px; line-height: 1.6;">
                                <?= htmlspecialchars($about['cta_desc']) ?>
                            </p>
                        <?php endif; ?>
                        <?php if (!empty(trim($about['cta_btn_text'] ?? ''))): ?>
                            <div>
                                <span class="admin-cta-preview-btn">
                                    <?= htmlspecialchars($about['cta_btn_text']) ?>
                                    <i class="fa-solid fa-arrow-right ms-1"></i>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Configuration Form -->
            <form method="POST" enctype="multipart/form-data">
                <div class="row g-4">
                    <!-- Left Form Column -->
                    <div class="col-lg-8">
                        <!-- Headline & Content Card -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                            <div class="card-header bg-white py-3 px-4 border-bottom">
                                <h5 class="mb-0 fw-bold" style="color: #123023;">
                                    <i class="fa-solid fa-pen-nib text-warning me-2"></i> Banner Headlines &amp; Messaging
                                </h5>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark mb-1">Badge Tag / Subtitle (Optional)</label>
                                    <input type="text" name="cta_subheading" class="form-control" value="<?= htmlspecialchars($about['cta_subheading'] ?? '') ?>" placeholder="e.g. Commercial Trade Desk (Leave blank to hide badge)">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark mb-1">
                                        Main Call-To-Action Heading
                                    </label>
                                    <input type="text" name="cta_heading" class="form-control form-control-lg fw-bold" value="<?= htmlspecialchars($about['cta_heading'] ?? '') ?>" placeholder="e.g. Looking to Partner with a Dependable Indian Sourcing Company? (Leave blank to hide)" style="font-size: 18px;">
                                    <small class="text-muted">Leave blank to suppress the heading on the frontend.</small>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label fw-bold text-dark mb-1">
                                        Subtext Description Paragraph
                                    </label>
                                    <textarea name="cta_desc" class="form-control" rows="3" placeholder="Engaging message inviting buyers to send specifications, volume requirements, or schedule a call... (Leave blank to hide)"><?= htmlspecialchars($about['cta_desc'] ?? '') ?></textarea>
                                    <small class="text-muted">Leave blank to suppress the description on the frontend.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Button Action Configuration Card -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                            <div class="card-header bg-white py-3 px-4 border-bottom">
                                <h5 class="mb-0 fw-bold" style="color: #123023;">
                                    <i class="fa-solid fa-arrow-pointer text-primary me-2"></i> Action Button Settings
                                </h5>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark mb-1">
                                            Button Text
                                        </label>
                                        <input type="text" name="cta_btn_text" class="form-control" value="<?= htmlspecialchars($about['cta_btn_text'] ?? '') ?>" placeholder="e.g. Connect with Trade Desk (Leave blank to hide button)">
                                        <small class="text-muted">Leave blank to hide the CTA button on the frontend.</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark mb-1">
                                            Destination Link URL
                                        </label>
                                        <input type="text" name="cta_btn_link" class="form-control" value="<?= htmlspecialchars($about['cta_btn_link'] ?? '') ?>" placeholder="e.g. contact.php">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark mb-1">Button Click Action</label>
                                        <select name="cta_btn_action" class="form-select">
                                            <option value="link" <?= (($about['cta_btn_action'] ?? 'link') === 'link') ? 'selected' : '' ?>>Direct Page Link (Navigate to URL e.g. contact.php)</option>
                                            <option value="modal" <?= (($about['cta_btn_action'] ?? 'link') === 'modal') ? 'selected' : '' ?>>Open Quick B2B Enquiry Modal (Popup Form)</option>
                                        </select>
                                        <small class="text-muted">Choose whether clicking this button directs the user to your contact desk page or triggers an instant popup enquiry modal.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Form Column: Background Image & Save -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                            <div class="card-header bg-white py-3 px-4 border-bottom">
                                <h5 class="mb-0 fw-bold" style="color: #123023;">
                                    <i class="fa-solid fa-image text-success me-2"></i> Background Banner Image
                                </h5>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <div class="mb-3 text-center p-2 border rounded-3 bg-light">
                                    <img src="<?= htmlspecialchars($cta_bg) ?>" alt="CTA Background" style="max-height: 180px; width: 100%; object-fit: cover; border-radius: 8px;">
                                </div>
                                <label class="form-label fw-bold text-dark mb-1">Upload New Background Image</label>
                                <input type="file" name="cta_bg_image" class="form-control mb-2" accept="image/*">
                                <small class="text-muted d-block" style="font-size: 12px; line-height: 1.4;">
                                    Recommended: High-resolution maritime port, estate plantation, or logistics photo (approx. 1400x500px, JPG or WEBP).
                                </small>
                            </div>
                        </div>

                        <button type="submit" name="update_cta" class="btn btn-warning btn-lg w-100 fw-bold shadow-sm py-3 rounded-pill d-flex align-items-center justify-content-center gap-2" style="background: linear-gradient(135deg, #C5A059 0%, #D4AF37 100%); border: none; color: #123023;">
                            <i class="fa-solid fa-floppy-disk"></i> Save CTA Banner Changes
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
