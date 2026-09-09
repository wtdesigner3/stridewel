<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// Handle Capabilities Section Update (CKEditor & Image)
if (isset($_POST['update_capabilities'])) {
    $cur_q = mysqli_query($conn, "SELECT `capabilities_image` FROM `tbl_about` WHERE `id`=1");
    $cur = mysqli_fetch_assoc($cur_q);
    $img = $cur['capabilities_image'] ?? 'assets/img/commodities/shipping-logistics-port.jpg';

    if (!empty($_FILES['capabilities_image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['capabilities_image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'avif', 'svg'];
        if (in_array($ext, $allowed)) {
            $upload_dir = "../../uploads/about/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            $new_name = "about_cap_" . time() . "." . $ext;
            if (move_uploaded_file($_FILES['capabilities_image']['tmp_name'], $upload_dir . $new_name)) {
                $img = "uploads/about/" . $new_name;
            }
        } else {
            $error = "Invalid image format. Allowed: JPG, PNG, WEBP, AVIF, SVG.";
        }
    }

    $subheading = mysqli_real_escape_string($conn, trim($_POST['capabilities_subheading']));
    $heading = mysqli_real_escape_string($conn, trim($_POST['capabilities_heading']));
    $badge_title = mysqli_real_escape_string($conn, trim($_POST['capabilities_badge_title']));
    $content = mysqli_real_escape_string($conn, trim($_POST['capabilities_content']));
    $btn1_text = mysqli_real_escape_string($conn, trim($_POST['capabilities_btn1_text']));
    $btn1_link = mysqli_real_escape_string($conn, trim($_POST['capabilities_btn1_link']));
    $btn2_text = mysqli_real_escape_string($conn, trim($_POST['capabilities_btn2_text']));
    $btn2_link = mysqli_real_escape_string($conn, trim($_POST['capabilities_btn2_link']));

    if (empty($error)) {
        $upd = mysqli_query($conn, "UPDATE `tbl_about` SET 
            `capabilities_subheading`='$subheading',
            `capabilities_heading`='$heading',
            `capabilities_badge_title`='$badge_title',
            `capabilities_content`='$content',
            `capabilities_image`='$img',
            `capabilities_btn1_text`='$btn1_text',
            `capabilities_btn1_link`='$btn1_link',
            `capabilities_btn2_text`='$btn2_text',
            `capabilities_btn2_link`='$btn2_link'
            WHERE `id`=1");

        if ($upd) {
            $msg = "Supply Capabilities section updated successfully!";
        } else {
            $error = "Failed to update capabilities: " . mysqli_error($conn);
        }
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
                        Supply Capabilities Management
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 13.5px;">
                        Manage the comprehensive supply capabilities overview, rich-text narrative with CKEditor, CTA action buttons, and featured logistics photo.
                    </p>
                </div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="manage-about-story.php">About Us CMS</a></li>
                    <li class="breadcrumb-item active">Supply Capabilities</li>
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
                <a href="manage-about-capabilities.php" class="cms-subnav-pill active">
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

            <form method="POST" enctype="multipart/form-data">
                <div class="row g-4">
                    <!-- Left Form Column -->
                    <div class="col-lg-8">
                        <!-- Headings Card -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                            <div class="card-header bg-white py-3 px-4 border-bottom">
                                <h5 class="mb-0 fw-bold" style="color: #123023;">
                                    <i class="fa-solid fa-pen-nib text-warning me-2"></i> Section Headlines &amp; Badge
                                </h5>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-dark mb-1">Subtitle Badge</label>
                                        <input type="text" name="capabilities_subheading" class="form-control" value="<?= htmlspecialchars($about['capabilities_subheading'] ?? '') ?>" placeholder="e.g. Comprehensive Supply Capability (Leave blank to hide)">
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label fw-bold text-dark mb-1">Main Section Heading</label>
                                        <input type="text" name="capabilities_heading" class="form-control" value="<?= htmlspecialchars($about['capabilities_heading'] ?? '') ?>" placeholder="e.g. From Indian Cultivation Belts to Commercial Kitchens (Leave blank to hide)">
                                    </div>
                                </div>

                                <div class="mb-1">
                                    <label class="form-label fw-bold text-dark mb-1">Accent Badge / Tag Title</label>
                                    <input type="text" name="capabilities_badge_title" class="form-control" value="<?= htmlspecialchars($about['capabilities_badge_title'] ?? '') ?>" placeholder="e.g. Direct Agro-Commodity & HORECA Logistics">
                                    <small class="text-muted">Optional badge tag or capability highlight label.</small>
                                </div>
                            </div>
                        </div>

                        <!-- CKEditor Rich Narrative Card -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                            <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                                <h5 class="mb-0 fw-bold" style="color: #123023;">
                                    <i class="fa-solid fa-align-left text-primary me-2"></i> Capability Description &amp; Feature Points
                                </h5>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25" style="font-size: 11px;">
                                    <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Full CKEditor 5 Super-Build
                                </span>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <textarea name="capabilities_content" id="editor_capabilities" class="form-control ckeditor" rows="12"><?= htmlspecialchars($about['capabilities_content'] ?? '') ?></textarea>
                                <small class="text-muted mt-2 d-block">
                                    Format lists, bold highlights, checkmarks, and rich text descriptions explaining your dual capability (Bulk Export + Foodservice Supply).
                                </small>
                            </div>
                        </div>

                        <!-- Action Buttons Management Card -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                            <div class="card-header bg-white py-3 px-4 border-bottom">
                                <h5 class="mb-0 fw-bold" style="color: #123023;">
                                    <i class="fa-solid fa-link text-info me-2"></i> Section Action Buttons
                                </h5>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <div class="p-3 bg-light rounded-3 border">
                                            <h6 class="fw-bold text-dark mb-2" style="font-size: 13.5px;">
                                                <i class="fa-solid fa-circle-arrow-right text-success me-1"></i> Primary Button (Solid)
                                            </h6>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold text-dark mb-1">Button Text</label>
                                                <input type="text" name="capabilities_btn1_text" class="form-control form-control-sm" value="<?= htmlspecialchars($about['capabilities_btn1_text'] ?? '') ?>" placeholder="e.g. Browse Export Products (Leave blank to hide)">
                                            </div>
                                            <div>
                                                <label class="form-label small fw-bold text-dark mb-1">Button Link URL</label>
                                                <input type="text" name="capabilities_btn1_link" class="form-control form-control-sm" value="<?= htmlspecialchars($about['capabilities_btn1_link'] ?? '') ?>" placeholder="e.g. product-arabica.php">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 bg-light rounded-3 border">
                                            <h6 class="fw-bold text-dark mb-2" style="font-size: 13.5px;">
                                                <i class="fa-regular fa-circle-arrow-right text-primary me-1"></i> Secondary Button (Outline)
                                            </h6>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold text-dark mb-1">Button Text</label>
                                                <input type="text" name="capabilities_btn2_text" class="form-control form-control-sm" value="<?= htmlspecialchars($about['capabilities_btn2_text'] ?? '') ?>" placeholder="e.g. View HORECA Products (Leave blank to hide)">
                                            </div>
                                            <div>
                                                <label class="form-label small fw-bold text-dark mb-1">Button Link URL</label>
                                                <input type="text" name="capabilities_btn2_link" class="form-control form-control-sm" value="<?= htmlspecialchars($about['capabilities_btn2_link'] ?? '') ?>" placeholder="e.g. supply-coffee.php">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Image & Save Button -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                            <div class="card-header bg-white py-3 px-4 border-bottom">
                                <h5 class="mb-0 fw-bold" style="color: #123023;">
                                    <i class="fa-solid fa-image text-success me-2"></i> Featured Section Image
                                </h5>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <?php if (!empty($about['capabilities_image'])): ?>
                                    <div class="mb-3 text-center p-2 border rounded-3 bg-light">
                                        <img src="../../<?= htmlspecialchars($about['capabilities_image']) ?>" alt="Capabilities Image" style="max-height: 220px; width: 100%; object-fit: cover; border-radius: 8px;">
                                    </div>
                                <?php endif; ?>
                                <label class="form-label fw-bold text-dark mb-1">Replace Section Image</label>
                                <input type="file" name="capabilities_image" class="form-control mb-2" accept="image/*">
                                <small class="text-muted d-block" style="font-size: 12px; line-height: 1.4;">
                                    Recommended: High-resolution landscape photo (approx. 800x600px, JPG or WEBP).
                                </small>
                            </div>
                        </div>

                        <button type="submit" name="update_capabilities" class="btn btn-warning btn-lg w-100 fw-bold shadow-sm py-3 rounded-pill d-flex align-items-center justify-content-center gap-2" style="background: linear-gradient(135deg, #C5A059 0%, #D4AF37 100%); border: none; color: #123023;">
                            <i class="fa-solid fa-floppy-disk"></i> Save Capabilities Section
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
    <script src="assets/plugins/ckeditor/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            App.init();

            if (typeof CKEDITOR !== 'undefined' && document.getElementById('editor_capabilities')) {
                CKEDITOR.replace('editor_capabilities', {
                    height: 280,
                    removeButtons: 'About,Flash,Smiley,PageBreak',
                    toolbarGroups: [
                        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
                        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
                        { name: 'links' },
                        { name: 'insert' },
                        { name: 'styles' },
                        { name: 'colors' },
                        { name: 'tools' }
                    ]
                });
            }
        });
    </script>
</body>
</html>
