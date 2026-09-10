<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// Handle Footprint Section Update
if (isset($_POST['update_footprint'])) {
    $subheading = mysqli_real_escape_string($conn, trim($_POST['footprint_subheading']));
    $heading = mysqli_real_escape_string($conn, trim($_POST['footprint_heading']));
    $desc = mysqli_real_escape_string($conn, trim($_POST['footprint_desc']));

    $channel_1_title = mysqli_real_escape_string($conn, trim($_POST['channel_1_title'] ?? ''));
    $channel_1_sub = mysqli_real_escape_string($conn, trim($_POST['channel_1_sub'] ?? ''));
    $channel_2_title = mysqli_real_escape_string($conn, trim($_POST['channel_2_title'] ?? ''));
    $channel_2_sub = mysqli_real_escape_string($conn, trim($_POST['channel_2_sub'] ?? ''));
    $channel_3_title = mysqli_real_escape_string($conn, trim($_POST['channel_3_title'] ?? ''));
    $channel_3_sub = mysqli_real_escape_string($conn, trim($_POST['channel_3_sub'] ?? ''));
    $channel_4_title = mysqli_real_escape_string($conn, trim($_POST['channel_4_title'] ?? ''));
    $channel_4_sub = mysqli_real_escape_string($conn, trim($_POST['channel_4_sub'] ?? ''));

    $cur_q = mysqli_query($conn, "SELECT `footprint_image` FROM `tbl_about` WHERE `id`=1");
    $cur = mysqli_fetch_assoc($cur_q);
    $img = $cur['footprint_image'] ?? 'assets/images/banners/banner_institutional_supply.jpg';

    if (!empty($_FILES['footprint_image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['footprint_image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
        if (in_array($ext, $allowed)) {
            $upload_dir = "../uploads/about/";
            if (!is_dir($upload_dir)) {
                @mkdir($upload_dir, 0777, true);
            }
            $new_name = "footprint_" . time() . "." . $ext;
            if (move_uploaded_file($_FILES['footprint_image']['tmp_name'], $upload_dir . $new_name)) {
                $img = "uploads/about/" . $new_name;
            }
        } else {
            $error = "Invalid image format. Allowed: JPG, PNG, WEBP, AVIF.";
        }
    }

    if (empty($error)) {
        $upd = mysqli_query($conn, "UPDATE `tbl_about` SET 
            `footprint_subheading`='$subheading',
            `footprint_heading`='$heading',
            `footprint_desc`='$desc',
            `footprint_image`='$img',
            `channel_1_title`='$channel_1_title',
            `channel_1_sub`='$channel_1_sub',
            `channel_2_title`='$channel_2_title',
            `channel_2_sub`='$channel_2_sub',
            `channel_3_title`='$channel_3_title',
            `channel_3_sub`='$channel_3_sub',
            `channel_4_title`='$channel_4_title',
            `channel_4_sub`='$channel_4_sub'
            WHERE `id`=1");

        if ($upd) {
            $msg = "Institutional Supply Partners & Footprint updated successfully!";
        } else {
            $error = "Failed to update: " . mysqli_error($conn);
        }
    }
}

// Fetch Latest Record
$about = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `tbl_about` WHERE `id`=1"));
$footprint_img = !empty($about['footprint_image']) ? $about['footprint_image'] : 'assets/images/banners/banner_institutional_supply.jpg';
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
                        Institutional Supply Partners &amp; Footprint
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 13.5px;">
                        Manage the Nationwide &amp; Global Footprint section, institutional partners, and logistics showcase on the About Us page.
                    </p>
                </div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="manage-about-story.php">About Us CMS</a></li>
                    <li class="breadcrumb-item active">Institutional Supply</li>
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
                <a href="manage-about-industries.php" class="cms-subnav-pill active">
                    <i class="fa-solid fa-boxes-packing"></i> Institutional Supply Partners
                </a>
                <a href="manage-about-cta.php" class="cms-subnav-pill">
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

            <form method="POST" enctype="multipart/form-data">
                <div class="row g-4">
                    <!-- Left Form Column -->
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                            <div class="card-header bg-white py-3 px-4 border-bottom">
                                <h5 class="mb-0 fw-bold" style="color: #103755;">
                                    <i class="fa-solid fa-earth-americas text-danger me-2"></i> Footprint &amp; Supply Network Messaging
                                </h5>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <div class="row g-3 mb-3">
                                    <div class="col-md-5">
                                        <label class="form-label fw-bold text-dark mb-1">Subtitle Badge</label>
                                        <input type="text" name="footprint_subheading" class="form-control" value="<?= htmlspecialchars($about['footprint_subheading'] ?? 'Nationwide & Global Footprint') ?>" placeholder="e.g. Nationwide & Global Footprint">
                                    </div>
                                    <div class="col-md-7">
                                        <label class="form-label fw-bold text-dark mb-1">Section Main Heading</label>
                                        <input type="text" name="footprint_heading" class="form-control" value="<?= htmlspecialchars($about['footprint_heading'] ?? 'Trusted Partner to Dairy Boards & Veterinary Institutions') ?>" placeholder="e.g. Trusted Partner to Dairy Boards & Veterinary Institutions">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark mb-1">Overview Description Narrative</label>
                                        <textarea name="footprint_desc" class="form-control" rows="3"><?= htmlspecialchars($about['footprint_desc'] ?? '') ?></textarea>
                                    </div>
                                </div>

                                <!-- 4 Institutional Supply Channels Management -->
                                <div class="p-3 bg-light rounded-3 border mt-3">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2" style="font-size: 14px;">
                                            <i class="fa-solid fa-shield-halved text-danger"></i> Active Institutional Channels (4 Pillars Grid)
                                        </h6>
                                        <span class="badge bg-danger-subtle text-danger px-2 py-1" style="font-size: 11px;">Editable 4 Pillars</span>
                                    </div>
                                    <div class="row g-3">
                                        <!-- Pillar 1 -->
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white border rounded-3 shadow-xs">
                                                <div class="d-flex align-items-center gap-2 mb-2 text-danger fw-bold" style="font-size: 13px;">
                                                    <i class="fa-solid fa-check-circle"></i> Pillar 1 (Red Accent)
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label text-muted mb-1" style="font-size: 12px; font-weight: 600;">Title</label>
                                                    <input type="text" name="channel_1_title" class="form-control form-control-sm" value="<?= htmlspecialchars($about['channel_1_title'] ?? 'State Dairy Federations') ?>" placeholder="e.g. State Dairy Federations">
                                                </div>
                                                <div>
                                                    <label class="form-label text-muted mb-1" style="font-size: 12px; font-weight: 600;">Subtitle / Note</label>
                                                    <input type="text" name="channel_1_sub" class="form-control form-control-sm" value="<?= htmlspecialchars($about['channel_1_sub'] ?? 'NDDB, State Cooperative Dairy Boards') ?>" placeholder="e.g. NDDB, State Cooperative Dairy Boards">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pillar 2 -->
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white border rounded-3 shadow-xs">
                                                <div class="d-flex align-items-center gap-2 mb-2 text-primary fw-bold" style="font-size: 13px;">
                                                    <i class="fa-solid fa-check-circle"></i> Pillar 2 (Navy Accent)
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label text-muted mb-1" style="font-size: 12px; font-weight: 600;">Title</label>
                                                    <input type="text" name="channel_2_title" class="form-control form-control-sm" value="<?= htmlspecialchars($about['channel_2_title'] ?? 'Frozen Semen Stations') ?>" placeholder="e.g. Frozen Semen Stations">
                                                </div>
                                                <div>
                                                    <label class="form-label text-muted mb-1" style="font-size: 12px; font-weight: 600;">Subtitle / Note</label>
                                                    <input type="text" name="channel_2_sub" class="form-control form-control-sm" value="<?= htmlspecialchars($about['channel_2_sub'] ?? 'Bull mother farms & cryo banks') ?>" placeholder="e.g. Bull mother farms & cryo banks">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pillar 3 -->
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white border rounded-3 shadow-xs">
                                                <div class="d-flex align-items-center gap-2 mb-2 text-primary fw-bold" style="font-size: 13px;">
                                                    <i class="fa-solid fa-check-circle"></i> Pillar 3 (Navy Accent)
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label text-muted mb-1" style="font-size: 12px; font-weight: 600;">Title</label>
                                                    <input type="text" name="channel_3_title" class="form-control form-control-sm" value="<?= htmlspecialchars($about['channel_3_title'] ?? 'Veterinary Universities') ?>" placeholder="e.g. Veterinary Universities">
                                                </div>
                                                <div>
                                                    <label class="form-label text-muted mb-1" style="font-size: 12px; font-weight: 600;">Subtitle / Note</label>
                                                    <input type="text" name="channel_3_sub" class="form-control form-control-sm" value="<?= htmlspecialchars($about['channel_3_sub'] ?? 'IVRI, GADVASU, TANUVAS & Colleges') ?>" placeholder="e.g. IVRI, GADVASU, TANUVAS & Colleges">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pillar 4 -->
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white border rounded-3 shadow-xs">
                                                <div class="d-flex align-items-center gap-2 mb-2 text-danger fw-bold" style="font-size: 13px;">
                                                    <i class="fa-solid fa-check-circle"></i> Pillar 4 (Red Accent)
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label text-muted mb-1" style="font-size: 12px; font-weight: 600;">Title</label>
                                                    <input type="text" name="channel_4_title" class="form-control form-control-sm" value="<?= htmlspecialchars($about['channel_4_title'] ?? 'International Exports') ?>" placeholder="e.g. International Exports">
                                                </div>
                                                <div>
                                                    <label class="form-label text-muted mb-1" style="font-size: 12px; font-weight: 600;">Subtitle / Note</label>
                                                    <input type="text" name="channel_4_sub" class="form-control form-control-sm" value="<?= htmlspecialchars($about['channel_4_sub'] ?? 'Direct exports to 25+ global countries') ?>" placeholder="e.g. Direct exports to 25+ global countries">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Image Preview & Save -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                            <div class="card-header bg-white py-3 px-4 border-bottom">
                                <h5 class="mb-0 fw-bold" style="color: #103755;">
                                    <i class="fa-solid fa-image text-success me-2"></i> Showcase Logistics Image
                                </h5>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <div class="mb-3 text-center p-2 border rounded-3 bg-light">
                                    <img src="../<?= htmlspecialchars($footprint_img) ?>" alt="Footprint" style="max-height: 200px; width: 100%; object-fit: cover; border-radius: 8px;" onerror="this.src='../assets/images/banners/banner_institutional_supply.jpg'">
                                </div>
                                <label class="form-label fw-bold text-dark mb-1">Replace Image</label>
                                <input type="file" name="footprint_image" class="form-control mb-2" accept="image/*">
                                <small class="text-muted d-block">Recommended size: 900x600px high quality PNG or JPG.</small>
                            </div>
                        </div>

                        <button type="submit" name="update_footprint" class="btn btn-danger btn-lg w-100 fw-bold shadow-sm py-3 rounded-pill d-flex align-items-center justify-content-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Save Footprint Settings
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
