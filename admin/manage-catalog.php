<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// Handle Catalog Update
if (isset($_POST['update_catalog'])) {
    $cur_q = mysqli_query($conn, "SELECT * FROM `tbl_catalog` WHERE `id`=1");
    $cur = mysqli_fetch_assoc($cur_q);
    $pdf_file = $cur['catalog_pdf'] ?? 'assets/STRIDEWEL (2).pdf';
    $file_size = $cur['file_size'] ?? '4.8 MB';

    // Handle PDF File Upload
    if (!empty($_FILES['catalog_file']['name'])) {
        $ext = strtolower(pathinfo($_FILES['catalog_file']['name'], PATHINFO_EXTENSION));
        if ($ext === 'pdf') {
            $upload_dir = "../uploads/catalog/";
            if (!is_dir($upload_dir)) {
                @mkdir($upload_dir, 0777, true);
            }
            $clean_name = "stridewel_catalog_" . time() . ".pdf";
            $target_file = $upload_dir . $clean_name;

            if (move_uploaded_file($_FILES['catalog_file']['tmp_name'], $target_file)) {
                $pdf_file = "uploads/catalog/" . $clean_name;
                $bytes = filesize($target_file);
                if ($bytes >= 1048576) {
                    $file_size = number_format($bytes / 1048576, 1) . ' MB';
                } elseif ($bytes >= 1024) {
                    $file_size = number_format($bytes / 1024, 0) . ' KB';
                } else {
                    $file_size = $bytes . ' B';
                }
            } else {
                $error = "Failed to upload catalog PDF. Check folder write permissions.";
            }
        } else {
            $error = "Invalid file type. Only PDF documents (.pdf) are allowed.";
        }
    } elseif (!empty($_POST['catalog_pdf_custom'])) {
        $pdf_file = mysqli_real_escape_string($conn, trim($_POST['catalog_pdf_custom']));
    }

    $title = mysqli_real_escape_string($conn, trim(strip_tags($_POST['catalog_title'] ?? '')));
    $subtitle = mysqli_real_escape_string($conn, trim(strip_tags($_POST['catalog_subtitle'] ?? '')));
    $btn_text = mysqli_real_escape_string($conn, trim(strip_tags($_POST['btn_text'] ?? 'Download Full Catalog (PDF)')));
    $version = mysqli_real_escape_string($conn, trim(strip_tags($_POST['version_label'] ?? '2026 Edition (ISO 9001:2015)')));
    $status = isset($_POST['status']) ? 1 : 0;
    $custom_size = mysqli_real_escape_string($conn, trim(strip_tags($_POST['file_size'] ?? '')));
    if (!empty($custom_size)) {
        $file_size = $custom_size;
    }

    if (empty($error)) {
        $upd = mysqli_query($conn, "UPDATE `tbl_catalog` SET 
            `catalog_title`='$title',
            `catalog_subtitle`='$subtitle',
            `catalog_pdf`='$pdf_file',
            `btn_text`='$btn_text',
            `version_label`='$version',
            `file_size`='$file_size',
            `status`='$status'
            WHERE `id`=1");

        // Keep tbl_profile.pro_catalog_pdf in sync
        @mysqli_query($conn, "UPDATE `tbl_profile` SET `pro_catalog_pdf`='$pdf_file' WHERE `pro_id`=1");

        if ($upd) {
            $msg = "Product Catalog settings and download file updated successfully!";
        } else {
            $error = "Database update failed: " . mysqli_error($conn);
        }
    }
}

// Fetch Latest Record
$catalog = get_catalog_info();
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
                        <i class="fa-solid fa-file-pdf text-danger me-2"></i> PDF Catalog Management
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 13.5px;">
                        Manage the downloadable company product catalog PDF, button labels, and sitewide visibility across all pages.
                    </p>
                </div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="manage-products.php">Products Inventory</a></li>
                    <li class="breadcrumb-item active">PDF Catalog Management</li>
                </ol>
            </div>

            <!-- Quick Subnav Pills -->
            <div class="cms-subnav-strip mb-4">
                <a href="manage-products.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-boxes-stacked"></i> All Products
                </a>
                <a href="manage-categories.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-layer-group"></i> Categories
                </a>
                <a href="manage-catalog.php" class="cms-subnav-pill active">
                    <i class="fa-solid fa-file-pdf"></i> Download Catalog CMS
                </a>
                <a href="../shop.php" target="_blank" class="cms-subnav-pill cms-subnav-preview">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Preview Live Shop Catalog
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
                    <div>
                        <?php if ($catalog['status'] == 1): ?>
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1.5 rounded-pill fw-bold">
                                <i class="fa-solid fa-circle-dot me-1"></i> Active Sitewide
                            </span>
                        <?php else: ?>
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-1.5 rounded-pill fw-bold">
                                <i class="fa-solid fa-eye-slash me-1"></i> Hidden Sitewide
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body p-4" style="background: #f8fafc;">
                    <div class="row align-items-center p-4 rounded-4 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0;">
                        <div class="col-lg-8 col-md-12 mb-3 mb-lg-0">
                            <?php if (!empty($catalog['version_label'])): ?>
                                <span class="badge mb-2 px-2.5 py-1" style="background: rgba(237, 28, 36, 0.1); color: #ed1c24; border: 1px solid rgba(237, 28, 36, 0.3); font-weight: 700; font-size: 11.5px; border-radius: 6px;">
                                    <i class="fa-solid fa-certificate me-1"></i> <?= htmlspecialchars($catalog['version_label']) ?>
                                </span>
                            <?php endif; ?>
                            <?php if (!empty($catalog['catalog_title'])): ?>
                                <h3 class="fw-bold mb-1" style="color: #103755; font-size: 20px;">
                                    <?= htmlspecialchars($catalog['catalog_title']) ?>
                                </h3>
                            <?php endif; ?>
                            <?php if (!empty($catalog['catalog_subtitle'])): ?>
                                <p class="text-muted mb-0" style="font-size: 13.5px; max-width: 650px;">
                                    <?= nl2br(htmlspecialchars($catalog['catalog_subtitle'])) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-4 col-md-12 text-lg-end">
                            <?php if (!empty($catalog['btn_text']) && $catalog['status'] == 1): ?>
                                <a href="../<?= htmlspecialchars($catalog['catalog_pdf']) ?>" target="_blank" class="btn btn-danger fw-bold px-4 py-2.5 rounded-3 shadow-sm d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #ed1c24 0%, #c41219 100%); border: none;">
                                    <i class="fa-solid fa-file-pdf fs-5"></i>
                                    <span><?= htmlspecialchars($catalog['btn_text']) ?></span>
                                </a>
                                <?php if (!empty($catalog['file_size'])): ?>
                                    <div class="text-muted mt-1.5" style="font-size: 11.5px;">
                                        <i class="fa-solid fa-hard-drive me-1"></i> File Size: <?= htmlspecialchars($catalog['file_size']) ?>
                                    </div>
                                <?php endif; ?>
                            <?php elseif ($catalog['status'] != 1): ?>
                                <div class="alert alert-warning mb-0 py-2 px-3 d-inline-block text-start" style="font-size: 12.5px;">
                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> <strong>Disabled:</strong> Download button is hidden on frontend.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuration Form -->
            <form method="POST" enctype="multipart/form-data">
                <div class="row g-4">
                    <!-- Left Column: Content Settings -->
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                            <div class="card-header bg-white py-3 px-4 border-bottom">
                                <h5 class="mb-0 fw-bold" style="color: #103755;">
                                    <i class="fa-solid fa-pen-nib text-danger me-2"></i> Catalog Headings &amp; Button Text
                                </h5>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark mb-1">
                                        Catalog Showcase Title
                                    </label>
                                    <input type="text" name="catalog_title" class="form-control form-control-lg fw-bold" value="<?= htmlspecialchars($catalog['catalog_title'] ?? '') ?>" placeholder="e.g. Complete Veterinary & A.I. Equipment Product Catalog">
                                    <small class="text-muted d-block mt-1">Displayed as the main heading in catalog showcase sections. Leave blank to hide.</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark mb-1">
                                        Subtitle / Description
                                    </label>
                                    <textarea name="catalog_subtitle" class="form-control" rows="3" placeholder="Brief overview of what is included in the downloadable catalog..."><?= htmlspecialchars($catalog['catalog_subtitle'] ?? '') ?></textarea>
                                    <small class="text-muted d-block mt-1">Leave blank to hide description.</small>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark mb-1">
                                            Download Button Label
                                        </label>
                                        <input type="text" name="btn_text" class="form-control" value="<?= htmlspecialchars($catalog['btn_text'] ?? 'Download Full Catalog (PDF)') ?>" placeholder="e.g. Download Full Catalog (PDF)">
                                        <small class="text-muted d-block mt-1">Text shown on all download catalog buttons across the website.</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark mb-1">
                                            Edition / Quality Badge Tag
                                        </label>
                                        <input type="text" name="version_label" class="form-control" value="<?= htmlspecialchars($catalog['version_label'] ?? '2026 Edition (ISO 9001:2015)') ?>" placeholder="e.g. 2026 Edition (ISO 9001:2015)">
                                        <small class="text-muted d-block mt-1">Version tag shown next to the catalog. Leave blank to hide.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Current File Information Box -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                            <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                                <h5 class="mb-0 fw-bold" style="color: #103755;">
                                    <i class="fa-solid fa-file-lines text-primary me-2"></i> Current Active Catalog File
                                </h5>
                                <a href="../<?= htmlspecialchars($catalog['catalog_pdf']) ?>" target="_blank" class="btn btn-sm btn-outline-danger fw-bold d-inline-flex align-items-center gap-1.5 rounded-pill px-3">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Open Current PDF
                                </a>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light border">
                                    <div class="p-3 bg-white rounded-3 shadow-sm text-danger text-center" style="width: 54px; height: 54px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa-solid fa-file-pdf fs-2"></i>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <div class="fw-bold text-dark text-truncate" style="font-size: 14.5px;">
                                            <?= htmlspecialchars(basename($catalog['catalog_pdf'])) ?>
                                        </div>
                                        <div class="text-muted" style="font-size: 12.5px;">
                                            Path: <code><?= htmlspecialchars($catalog['catalog_pdf']) ?></code> &bull; Size: <strong><?= htmlspecialchars($catalog['file_size']) ?></strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label class="form-label fw-bold text-dark mb-1">
                                        Custom File Path or External URL (Optional Override)
                                    </label>
                                    <input type="text" name="catalog_pdf_custom" class="form-control" value="<?= htmlspecialchars($catalog['catalog_pdf']) ?>" placeholder="e.g. assets/STRIDEWEL (2).pdf or https://...">
                                    <small class="text-muted d-block mt-1">If you upload a file below, this path will be automatically updated with the new upload.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Upload & Actions -->
                    <div class="col-lg-4">
                        <!-- Upload PDF File -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                            <div class="card-header bg-white py-3 px-4 border-bottom">
                                <h5 class="mb-0 fw-bold" style="color: #103755;">
                                    <i class="fa-solid fa-cloud-arrow-up text-success me-2"></i> Upload New PDF File
                                </h5>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark mb-1">Choose PDF Document</label>
                                    <input type="file" name="catalog_file" class="form-control mb-2" accept=".pdf,application/pdf">
                                    <small class="text-muted d-block" style="font-size: 12px; line-height: 1.4;">
                                        Allowed format: <strong>.PDF only</strong> (Max recommended: 50MB). File will be saved to <code>uploads/catalog/</code>.
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark mb-1">File Size Label</label>
                                    <input type="text" name="file_size" class="form-control" value="<?= htmlspecialchars($catalog['file_size'] ?? '4.8 MB') ?>" placeholder="e.g. 4.8 MB">
                                    <small class="text-muted d-block mt-1" style="font-size: 12px;">Auto-calculated on upload, or customize manually.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Visibility & Status Card -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                            <div class="card-header bg-white py-3 px-4 border-bottom">
                                <h5 class="mb-0 fw-bold" style="color: #103755;">
                                    <i class="fa-solid fa-toggle-on text-danger me-2"></i> Frontend Visibility
                                </h5>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <div class="form-check form-switch d-flex align-items-center gap-3 ps-0 mb-3">
                                    <input class="form-check-input ms-0" type="checkbox" name="status" id="catalogStatusSwitch" value="1" <?= ($catalog['status'] == 1) ? 'checked' : '' ?> style="width: 48px; height: 24px; cursor: pointer;">
                                    <label class="form-check-label fw-bold text-dark mb-0" for="catalogStatusSwitch" style="cursor: pointer;">
                                        Enable Download Buttons Sitewide
                                    </label>
                                </div>
                                <small class="text-muted d-block" style="font-size: 12px; line-height: 1.45;">
                                    When turned OFF, all "Download Catalog" buttons and callouts across the Homepage, About Us, Products Catalog, Product Details, Header, and Footer are cleanly hidden.
                                </small>
                            </div>
                        </div>

                        <!-- Save Submit Button -->
                        <button type="submit" name="update_catalog" class="btn btn-danger btn-lg w-100 fw-bold shadow-sm py-3 rounded-pill d-flex align-items-center justify-content-center gap-2" style="background: linear-gradient(135deg, #ed1c24 0%, #c41219 100%); border: none;">
                            <i class="fa-solid fa-floppy-disk"></i> Save Catalog Settings
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
