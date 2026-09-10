<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// Handle CTA Section Update
if (isset($_POST['update_cta'])) {
    $cur_q = mysqli_query($conn, "SELECT `cta_bg_image` FROM `tbl_about` WHERE `id`=1");
    $cur = mysqli_fetch_assoc($cur_q);
    $bg_img = $cur['cta_bg_image'] ?? 'assets/images/banners/banner_institutional_supply.jpg';

    // Handle background image upload
    if (!empty($_FILES['cta_bg_image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['cta_bg_image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
        if (in_array($ext, $allowed)) {
            $upload_dir = "../uploads/about/";
            if (!is_dir($upload_dir)) {
                @mkdir($upload_dir, 0777, true);
            }
            $new_name = "about_cta_bg_" . time() . "." . $ext;
            if (move_uploaded_file($_FILES['cta_bg_image']['tmp_name'], $upload_dir . $new_name)) {
                $bg_img = "uploads/about/" . $new_name;
            }
        } else {
            $error = "Invalid image format. Allowed: JPG, PNG, WEBP, AVIF.";
        }
    }

    $badge = mysqli_real_escape_string($conn, trim(strip_tags($_POST['cta_badge'] ?? '')));
    $heading = mysqli_real_escape_string($conn, trim(strip_tags($_POST['cta_heading'] ?? '', '<span><strong><em><i>')));
    $desc = mysqli_real_escape_string($conn, trim(strip_tags($_POST['cta_desc'] ?? '')));
    $btn_text = mysqli_real_escape_string($conn, trim(strip_tags($_POST['cta_btn_text'] ?? '')));
    $btn_link = mysqli_real_escape_string($conn, trim(strip_tags($_POST['cta_btn_link'] ?? '')));

    if (empty($error)) {
        $upd = mysqli_query($conn, "UPDATE `tbl_about` SET 
            `cta_badge`='$badge',
            `cta_heading`='$heading',
            `cta_desc`='$desc',
            `cta_btn_text`='$btn_text',
            `cta_btn_link`='$btn_link',
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
$cta_bg = !empty($about['cta_bg_image']) ? $about['cta_bg_image'] : "assets/images/banners/banner_institutional_supply.jpg";
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
                        Call-To-Action (CTA) Banner Management
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 13.5px;">
                        Manage the institutional inquiry callout banner displayed across the About Us and Contact pages.
                    </p>
                </div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="manage-about-story.php">About Us CMS</a></li>
                    <li class="breadcrumb-item active">CTA Banner</li>
                </ol>
            </div>

            <!-- Quick Sub-Menu Switcher Pills -->
            <div class="cms-subnav-strip mb-4">
                <a href="manage-about-story.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-landmark"></i> Heritage &amp; Story
                </a>
                <a href="manage-about-timeline.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-clock-rotate-left"></i> Milestones &amp; Heritage
                </a>
                <a href="manage-about-mission.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-bullseye"></i> Mission, Vision &amp; Policy
                </a>
                <a href="manage-about-stats.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-chart-line"></i> Verified Statistics
                </a>
                <a href="manage-about-industries.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-boxes-packing"></i> Institutional Supply Partners
                </a>
                <a href="manage-about-cta.php" class="cms-subnav-pill active">
                    <i class="fa-solid fa-bullhorn"></i> CTA Banner
                </a>
                <a href="../about.php" target="_blank" class="cms-subnav-pill cms-subnav-preview">
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
                    <h5 class="mb-0 fw-bold" style="color: #103755; font-size: 15px;">
                        <i class="fa-solid fa-eye text-danger me-2"></i> Live Frontend Visual Preview
                    </h5>
                    <span class="badge bg-light text-muted border px-2.5 py-1">Institutional Action Callout</span>
                </div>
                <div class="card-body p-4 bg-light">
                    <div style="background: linear-gradient(135deg, rgba(16, 55, 85, 0.95) 0%, rgba(12, 35, 54, 0.92) 100%), url('../<?= htmlspecialchars($cta_bg) ?>') center/cover no-repeat; color: #FFFFFF; padding: 45px 30px; border-radius: 14px; text-align: center;">
                        <?php if (!empty($about['cta_badge'])): ?>
                            <div style="display: inline-block; background: rgba(237, 28, 36, 0.22); border: 1px solid rgba(237, 28, 36, 0.5); color: #ff6b6b; font-size: 11px; font-weight: 800; padding: 5px 14px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 14px;">
                                <i class="fa-solid fa-certificate me-1"></i> <?= htmlspecialchars($about['cta_badge']) ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($about['cta_heading'])): ?>
                        <h3 class="text-white mb-2" style="font-size: 26px; font-weight: 800;">
                            <?= htmlspecialchars($about['cta_heading']) ?>
                        </h3>
                        <?php endif; ?>
                        <?php if (!empty($about['cta_desc'])): ?>
                        <p class="text-white text-opacity-75 mb-4" style="font-size: 14.5px; max-width: 680px; margin: 0 auto 20px;">
                            <?= nl2br(htmlspecialchars($about['cta_desc'])) ?>
                        </p>
                        <?php endif; ?>
                        <?php if (!empty($about['cta_btn_text'])): ?>
                        <div>
                            <span class="btn btn-danger fw-bold px-4 py-2" style="border-radius: 8px;">
                                <?= htmlspecialchars($about['cta_btn_text']) ?> <i class="fa-solid fa-arrow-right ms-1"></i>
                            </span>
                        </div>
                        <?php endif; ?>
                        <?php if (empty($about['cta_heading']) && empty($about['cta_desc']) && empty($about['cta_btn_text'])): ?>
                        <p class="text-white-50 fst-italic mb-0">[All main fields are blank - CTA banner will be hidden on frontend]</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Configuration Form -->
            <form method="POST" enctype="multipart/form-data">
                <div class="row g-4">
                    <!-- Left Form Column -->
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                            <div class="card-header bg-white py-3 px-4 border-bottom">
                                <h5 class="mb-0 fw-bold" style="color: #103755;">
                                    <i class="fa-solid fa-pen-nib text-danger me-2"></i> Banner Headlines &amp; Messaging
                                </h5>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark mb-1">
                                        Badge Highlight Tagline (Optional)
                                    </label>
                                    <input type="text" name="cta_badge" class="form-control" value="<?= htmlspecialchars($about['cta_badge'] ?? '') ?>" placeholder="e.g. DIRECT MANUFACTURER SUPPLY">
                                    <small class="text-muted d-block mt-1">Small badge pill displayed above the heading. Leave blank to hide.</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark mb-1">
                                        Main Call-To-Action Heading
                                    </label>
                                    <input type="text" name="cta_heading" class="form-control form-control-lg fw-bold" value="<?= htmlspecialchars($about['cta_heading'] ?? '') ?>" placeholder="e.g. Inquire for Institutional Supply or Custom Tenders">
                                    <small class="text-muted d-block mt-1">Leave blank to hide heading.</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark mb-1">
                                        Subtext Description Paragraph
                                    </label>
                                    <textarea name="cta_desc" class="form-control" rows="3" placeholder="Description or guidance for procurement teams..."><?= htmlspecialchars($about['cta_desc'] ?? '') ?></textarea>
                                    <small class="text-muted d-block mt-1">Leave blank to hide description.</small>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark mb-1">
                                            Button Text
                                        </label>
                                        <input type="text" name="cta_btn_text" class="form-control" value="<?= htmlspecialchars($about['cta_btn_text'] ?? 'Request Price Quote') ?>" placeholder="e.g. Request Price Quote">
                                        <small class="text-muted d-block mt-1">Leave blank to hide button.</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark mb-1">
                                            Destination Link URL
                                        </label>
                                        <input type="text" name="cta_btn_link" class="form-control" value="<?= htmlspecialchars($about['cta_btn_link'] ?? 'contact') ?>" placeholder="e.g. contact or #quoteModal">
                                        <small class="text-muted d-block mt-1">Use <code>#quoteModal</code> for the instant quote modal popup, or any page URL (e.g. <code>contact</code>).</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Form Column: Background Image & Save -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                            <div class="card-header bg-white py-3 px-4 border-bottom">
                                <h5 class="mb-0 fw-bold" style="color: #103755;">
                                    <i class="fa-solid fa-image text-success me-2"></i> Background Banner Image
                                </h5>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <div class="mb-3 text-center p-2 border rounded-3 bg-light">
                                    <img src="../<?= htmlspecialchars($cta_bg) ?>" alt="CTA Background" style="max-height: 180px; width: 100%; object-fit: cover; border-radius: 8px;" onerror="this.src='../assets/images/banners/banner_institutional_supply.jpg'">
                                </div>
                                <label class="form-label fw-bold text-dark mb-1">Upload New Background Image</label>
                                <input type="file" name="cta_bg_image" class="form-control mb-2" accept="image/*">
                                <small class="text-muted d-block" style="font-size: 12px; line-height: 1.4;">
                                    Recommended: High-resolution factory or logistics photo (approx. 1400x500px, JPG or WEBP).
                                </small>
                            </div>
                        </div>

                        <button type="submit" name="update_cta" class="btn btn-danger btn-lg w-100 fw-bold shadow-sm py-3 rounded-pill d-flex align-items-center justify-content-center gap-2">
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
