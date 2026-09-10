<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// Handle Story & Heritage Update (CKEditor)
if (isset($_POST['update_story'])) {
    $cur_q = mysqli_query($conn, "SELECT `story_image` FROM `tbl_about` WHERE `id`=1");
    $cur = mysqli_fetch_assoc($cur_q);
    $img = $cur['story_image'] ?? 'assets/images/about/about_stridewel_lab.jpg';

    if (!empty($_FILES['story_image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['story_image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'avif', 'svg'];
        if (in_array($ext, $allowed)) {
            $upload_dir = "../uploads/about/";
            if (!is_dir($upload_dir)) {
                @mkdir($upload_dir, 0777, true);
            }
            $new_name = "about_story_" . time() . "." . $ext;
            if (move_uploaded_file($_FILES['story_image']['tmp_name'], $upload_dir . $new_name)) {
                $img = "uploads/about/" . $new_name;
            }
        }
    }

    $subheading = mysqli_real_escape_string($conn, trim($_POST['story_subheading']));
    $heading = mysqli_real_escape_string($conn, trim($_POST['story_heading']));
    $content = mysqli_real_escape_string($conn, trim($_POST['story_content']));
    $badge_title = mysqli_real_escape_string($conn, trim($_POST['story_badge_title']));
    $badge_subtitle = mysqli_real_escape_string($conn, trim($_POST['story_badge_subtitle']));
    $badge_exp = mysqli_real_escape_string($conn, trim($_POST['story_badge_exp']));

    $upd = mysqli_query($conn, "UPDATE `tbl_about` SET 
        `story_subheading`='$subheading',
        `story_heading`='$heading',
        `story_content`='$content',
        `story_badge_title`='$badge_title',
        `story_badge_subtitle`='$badge_subtitle',
        `story_badge_exp`='$badge_exp',
        `story_image`='$img'
        WHERE `id`=1");

    if ($upd) {
        $msg = "Heritage & Origin corporate story updated successfully!";
    } else {
        $error = "Failed to update story: " . mysqli_error($conn);
    }
}

// Fetch Latest Record
$about = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `tbl_about` WHERE `id`=1"));
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
                        Heritage &amp; Corporate Story
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 13.5px;">
                        Manage the primary company story, origin background narrative with CKEditor, experience badge metrics, and facility photo.
                    </p>
                </div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="manage-about-story.php">About Us CMS</a></li>
                    <li class="breadcrumb-item active">Heritage &amp; Story</li>
                </ol>
            </div>

            <!-- Quick Sub-Menu Switcher Pills -->
            <div class="cms-subnav-strip mb-4">
                <a href="manage-about-story.php" class="cms-subnav-pill active">
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
                                <h5 class="mb-0 fw-bold" style="color: #123023;">
                                    <i class="fa-solid fa-pen-nib text-danger me-2"></i> Heritage Content &amp; Narrative
                                </h5>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-dark mb-1">Subtitle Badge</label>
                                        <input type="text" name="story_subheading" class="form-control" value="<?= htmlspecialchars($about['story_subheading'] ?? '') ?>" placeholder="e.g. Welcome to Stridewel International">
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label fw-bold text-dark mb-1">Main Section Heading</label>
                                        <input type="text" name="story_heading" class="form-control" value="<?= htmlspecialchars($about['story_heading'] ?? '') ?>" placeholder="e.g. Four Decades of Dedicated Veterinary & Breeding Excellence">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark mb-1 d-flex align-items-center justify-content-between">
                                        <span>Corporate Story (Rich Text CKEditor)</span>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25" style="font-size: 11px;"><i class="fa-solid fa-wand-magic-sparkles me-1"></i> Full CKEditor 5 Super-Build</span>
                                    </label>
                                    <textarea name="story_content" id="editor_story" class="form-control ckeditor" rows="10"><?= htmlspecialchars($about['story_content'] ?? '') ?></textarea>
                                    <small class="text-muted mt-1 d-block">Use headings, bold formatting, links, lists, and quotes. Content is rendered dynamically on both Home and About Us pages.</small>
                                </div>

                                <!-- Floating Trust Badge Configuration -->
                                <div class="p-3 bg-light rounded-3 border">
                                    <h6 class="fw-bold mb-3 text-dark d-flex align-items-center gap-2" style="font-size: 14px;">
                                        <i class="fa-solid fa-shield-halved text-danger"></i> Photo Overlay Floating Badge Content
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold text-dark mb-1">Experience Badge (Corner)</label>
                                            <input type="text" name="story_badge_exp" class="form-control" value="<?= htmlspecialchars($about['story_badge_exp'] ?? '40+ Years Heritage') ?>" placeholder="e.g. 40+ Years Heritage">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold text-dark mb-1">Badge Header Title</label>
                                            <input type="text" name="story_badge_title" class="form-control" value="<?= htmlspecialchars($about['story_badge_title'] ?? 'ISO 9001:2015 Manufacturing Plant') ?>" placeholder="e.g. ISO 9001:2015 Manufacturing Plant">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold text-dark mb-1">Badge Subtitle &amp; Address</label>
                                            <input type="text" name="story_badge_subtitle" class="form-control" value="<?= htmlspecialchars($about['story_badge_subtitle'] ?? '26-A, 2nd Floor, DLF Industrial Area, Moti Nagar, New Delhi-110015') ?>" placeholder="e.g. 26-A, DLF Industrial Area, Moti Nagar">
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
                                <h5 class="mb-0 fw-bold" style="color: #123023;">
                                    <i class="fa-solid fa-image text-success me-2"></i> Featured Section Image
                                </h5>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <?php if (!empty($about['story_image'])): ?>
                                    <div class="mb-3 text-center p-2 border rounded-3 bg-light">
                                        <img src="../<?= htmlspecialchars($about['story_image']) ?>" alt="Story Image" style="max-height: 220px; width: 100%; object-fit: cover; border-radius: 8px;" onerror="this.src='../assets/images/about/about_stridewel_lab.jpg'">
                                    </div>
                                <?php endif; ?>
                                <label class="form-label fw-bold text-dark mb-1">Replace Section Image</label>
                                <input type="file" name="story_image" class="form-control mb-2" accept="image/*">
                                <small class="text-muted d-block">Recommended size: 800x650px high quality PNG or JPG.</small>
                            </div>
                        </div>

                        <button type="submit" name="update_story" class="btn btn-danger btn-lg w-100 fw-bold shadow-sm py-3 rounded-pill">
                            <i class="fa-solid fa-floppy-disk me-2"></i> Save Heritage Story
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
