<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// Handle Section Header Update
if (isset($_POST['update_industries_header'])) {
    $subheading = mysqli_real_escape_string($conn, trim($_POST['ind_subheading']));
    $heading = mysqli_real_escape_string($conn, trim($_POST['ind_heading']));
    $desc = mysqli_real_escape_string($conn, trim($_POST['ind_desc']));

    $upd = mysqli_query($conn, "UPDATE `tbl_about` SET 
        `ind_subheading`='$subheading',
        `ind_heading`='$heading',
        `ind_desc`='$desc'
        WHERE `id`=1");

    if ($upd) {
        $msg = "Industries section headlines updated successfully!";
    } else {
        $error = "Failed to update headlines: " . mysqli_error($conn);
    }
}

// Handle Individual Sector Edit
if (isset($_POST['edit_sector'])) {
    $sec_idx = (int)($_POST['sector_index'] ?? 0);

    if ($sec_idx === 1 || $sec_idx === 2) {
        $badge = mysqli_real_escape_string($conn, trim($_POST['sector_badge']));
        $title = mysqli_real_escape_string($conn, trim($_POST['sector_title']));
        $desc = mysqli_real_escape_string($conn, trim($_POST['sector_desc']));
        $clients = mysqli_real_escape_string($conn, trim($_POST['sector_clients']));
        $btn_text = mysqli_real_escape_string($conn, trim($_POST['sector_btn_text']));
        $btn_link = mysqli_real_escape_string($conn, trim($_POST['sector_btn_link']));

        // Current icon image
        $cur_q = mysqli_query($conn, "SELECT `ind{$sec_idx}_icon` FROM `tbl_about` WHERE `id`=1");
        $cur = mysqli_fetch_assoc($cur_q);
        $icon = $cur["ind{$sec_idx}_icon"] ?? ('assets/img/icons/industry-' . ($sec_idx == 1 ? 'export' : 'horeca') . '.svg');

        // Check if remove custom icon checked
        if (isset($_POST['remove_icon']) && $_POST['remove_icon'] == '1') {
            if (!empty($icon) && strpos($icon, 'uploads/') !== false && file_exists("../../" . $icon)) {
                @unlink("../../" . $icon);
            }
            $icon = 'assets/img/icons/industry-' . ($sec_idx == 1 ? 'export' : 'horeca') . '.svg';
        }

        // Check for new upload
        if (!empty($_FILES['sector_icon']['name']) && $_FILES['sector_icon']['error'] == 0) {
            $ext = strtolower(pathinfo($_FILES['sector_icon']['name'], PATHINFO_EXTENSION));
            $allowed = ['svg', 'png', 'webp', 'jpg', 'jpeg'];
            if (in_array($ext, $allowed)) {
                $upload_dir = "../../uploads/about/";
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                $new_name = "industry_sec_" . $sec_idx . "_" . time() . "." . $ext;
                if (move_uploaded_file($_FILES['sector_icon']['tmp_name'], $upload_dir . $new_name)) {
                    if (!empty($icon) && strpos($icon, 'uploads/') !== false && file_exists("../../" . $icon)) {
                        @unlink("../../" . $icon);
                    }
                    $icon = "uploads/about/" . $new_name;
                }
            } else {
                $error = "Invalid graphic format. Allowed: SVG, PNG, WEBP, JPG.";
            }
        }

        if (empty($error)) {
            $upd = mysqli_query($conn, "UPDATE `tbl_about` SET 
                `ind{$sec_idx}_badge`='$badge',
                `ind{$sec_idx}_title`='$title',
                `ind{$sec_idx}_desc`='$desc',
                `ind{$sec_idx}_clients`='$clients',
                `ind{$sec_idx}_btn_text`='$btn_text',
                `ind{$sec_idx}_btn_link`='$btn_link',
                `ind{$sec_idx}_icon`='$icon'
                WHERE `id`=1");

            if ($upd) {
                $msg = ($sec_idx == 1 ? "Export Sector" : "HORECA Sector") . " updated successfully!";
            } else {
                $error = "Failed to update sector: " . mysqli_error($conn);
            }
        }
    }
}

// Fetch Latest Record
$about = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `tbl_about` WHERE `id`=1"));

$sectors = [
    1 => [
        'name' => 'Export Sector',
        'badge_color' => 'bg-warning text-dark',
        'badge' => $about['ind1_badge'] ?? '',
        'title' => $about['ind1_title'] ?? '',
        'desc' => $about['ind1_desc'] ?? '',
        'clients' => $about['ind1_clients'] ?? '',
        'btn_text' => $about['ind1_btn_text'] ?? '',
        'btn_link' => $about['ind1_btn_link'] ?? '',
        'icon' => $about['ind1_icon'] ?? '',
        'default_svg' => 'assets/img/icons/industry-export.svg'
    ],
    2 => [
        'name' => 'HORECA Sector',
        'badge_color' => 'bg-primary text-white',
        'badge' => $about['ind2_badge'] ?? '',
        'title' => $about['ind2_title'] ?? '',
        'desc' => $about['ind2_desc'] ?? '',
        'clients' => $about['ind2_clients'] ?? '',
        'btn_text' => $about['ind2_btn_text'] ?? '',
        'btn_link' => $about['ind2_btn_link'] ?? '',
        'icon' => $about['ind2_icon'] ?? '',
        'default_svg' => 'assets/img/icons/industry-horeca.svg'
    ]
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
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <div>
                    <h1 class="page-header mb-1" style="font-size: 24px; font-weight: 800; color: #123023;">
                        Industries We Serve Management
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 13.5px;">
                        Manage the two core industry sectors (International Bulk Export &amp; Commercial HORECA Supply), client targets, icon graphics, and CTA buttons.
                    </p>
                </div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="manage-about-story.php">About Us CMS</a></li>
                    <li class="breadcrumb-item active">Industries We Serve</li>
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
                <a href="manage-about-industries.php" class="cms-subnav-pill active">
                    <i class="fa-solid fa-boxes-packing"></i> Industries We Serve
                </a>
                <a href="manage-about-capabilities.php" class="cms-subnav-pill">
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

            <!-- Section Headlines Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold" style="color: #123023;">
                        <i class="fa-solid fa-pen-nib text-warning me-2"></i> Section Header &amp; Subtitle
                    </h5>
                    <span class="badge bg-light text-muted border px-2.5 py-1">Shared Across About &amp; Home</span>
                </div>
                <div class="card-body p-4 bg-white">
                    <form method="POST">
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark mb-1">Subtitle Badge</label>
                                <input type="text" name="ind_subheading" class="form-control" value="<?= htmlspecialchars($about['ind_subheading'] ?? '') ?>" placeholder="e.g. Industries We Serve (Leave blank to hide)">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-bold text-dark mb-1">Section Main Heading</label>
                                <input type="text" name="ind_heading" class="form-control" value="<?= htmlspecialchars($about['ind_heading'] ?? '') ?>" placeholder="e.g. Tailored Procurement Across Two Core Sectors (Leave blank to hide)">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark mb-1">Introductory Overview Paragraph</label>
                                <textarea name="ind_desc" class="form-control" rows="2" placeholder="Brief section description explaining procurement solutions across both sectors..."><?= htmlspecialchars($about['ind_desc'] ?? '') ?></textarea>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" name="update_industries_header" class="btn btn-antara-gold px-4 py-2 rounded-pill fw-bold shadow-sm">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Save Section Headlines
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Core Sectors Table CRUD Card -->
            <div class="table-crud-card">
                <div class="table-crud-header">
                    <div>
                        <h5 class="mb-0 fw-bold" style="color: #123023; font-size: 16px;">
                            <i class="fa-solid fa-layer-group text-primary me-2"></i> 2 Core Operational Sectors
                        </h5>
                        <small class="text-muted">Export Commodities Division &amp; Hospitality Foodservice Division.</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-light text-dark border px-3 py-2" style="font-size: 12.5px; font-weight: 600;">
                            <i class="fa-solid fa-shield-halved text-success me-1"></i> 2 Active Core Sectors
                        </span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-crud-table">
                        <thead>
                            <tr>
                                <th style="width: 140px; text-align: center;">SECTOR</th>
                                <th style="width: 80px; text-align: center;">ICON</th>
                                <th style="width: 25%;">TITLE &amp; BADGE</th>
                                <th style="width: 32%;">DESCRIPTION OVERVIEW</th>
                                <th style="width: 20%;">WHO WE SUPPLY</th>
                                <th style="width: 90px; text-align: center;">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sectors as $idx => $sec): 
                                $has_custom = !empty($sec['icon']) && strpos($sec['icon'], 'uploads/') !== false && file_exists("../../" . $sec['icon']);
                                $icon_src = $has_custom ? ("../../" . $sec['icon']) : ("../../" . $sec['default_svg']);
                            ?>
                            <tr>
                                <td style="text-align: center;">
                                    <span class="badge <?= $sec['badge_color'] ?> px-2.5 py-1.5" style="font-size: 11.5px; font-weight: 700;">
                                        <?= $sec['name'] ?>
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <div class="table-icon-thumb mx-auto" style="width: 48px; height: 48px; border-radius: 12px; background: rgba(18, 48, 35, 0.05); border: 1px solid rgba(18, 48, 35, 0.12); display: flex; align-items: center; justify-content: center; padding: 6px;">
                                        <img src="<?= htmlspecialchars($icon_src) ?>" alt="<?= htmlspecialchars($sec['name']) ?>" style="width: 34px; height: 34px; object-fit: contain;">
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-0.5 mb-1" style="font-size: 11px;">
                                        <?= htmlspecialchars($sec['badge']) ?>
                                    </span>
                                    <div class="fw-bold text-dark" style="font-size: 15px;">
                                        <?= htmlspecialchars($sec['title']) ?>
                                    </div>
                                    <div class="text-muted small mt-0.5">
                                        <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> <?= htmlspecialchars($sec['btn_text']) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="table-desc-text" style="font-size: 13px; color: #526058;" title="<?= htmlspecialchars($sec['desc']) ?>">
                                        <?= htmlspecialchars($sec['desc']) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        <?php 
                                        $chips = array_map('trim', explode(',', $sec['clients']));
                                        foreach (array_slice($chips, 0, 3) as $c): 
                                            if (!empty($c)): ?>
                                                <span class="badge bg-light text-muted border" style="font-size: 10.5px; font-weight: 500;">
                                                    <i class="fa-solid fa-check text-success me-0.5"></i> <?= htmlspecialchars($c) ?>
                                                </span>
                                        <?php endif; endforeach; ?>
                                        <?php if (count($chips) > 3): ?>
                                            <span class="badge bg-light text-dark border" style="font-size: 10px;">+<?= count($chips) - 3 ?> more</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td style="text-align: center;">
                                    <button type="button" class="btn-action-square btn-action-edit" data-bs-toggle="modal" data-bs-target="#editSectorModal_<?= $idx ?>" title="Edit <?= $sec['name'] ?>">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Sector Modals -->
    <?php foreach ($sectors as $idx => $sec): 
        $has_custom = !empty($sec['icon']) && strpos($sec['icon'], 'uploads/') !== false && file_exists("../../" . $sec['icon']);
        $icon_src = $has_custom ? ("../../" . $sec['icon']) : ("../../" . $sec['default_svg']);
    ?>
    <div class="modal fade" id="editSectorModal_<?= $idx ?>" tabindex="-1" aria-labelledby="editSectorModalLabel_<?= $idx ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #123023 0%, #1B4533 100%);">
                    <h5 class="modal-title fw-bold" id="editSectorModalLabel_<?= $idx ?>" style="color: #FFFFFF !important;">
                        <i class="fa-solid fa-pen-to-square text-warning me-2"></i> Edit <?= $sec['name'] ?> Details
                    </h5>
                    <button type="button" class="modal-close-btn" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="sector_index" value="<?= $idx ?>">
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark mb-1">
                                    Division Badge Tag
                                </label>
                                <input type="text" name="sector_badge" class="form-control" value="<?= htmlspecialchars($sec['badge']) ?>" placeholder="e.g. International Trade Division (Leave blank to hide badge)">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark mb-1">
                                    Sector Title
                                </label>
                                <input type="text" name="sector_title" class="form-control" value="<?= htmlspecialchars($sec['title']) ?>" placeholder="e.g. Export Sector (Leave blank to hide sector card)">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-dark mb-1">
                                    Sector Description
                                </label>
                                <textarea name="sector_desc" class="form-control" rows="3" placeholder="Description of procurement solutions provided to this sector... (Leave blank to hide)"><?= htmlspecialchars($sec['desc']) ?></textarea>
                                <small class="text-muted"><strong>Tip:</strong> If both title and description are left blank, this sector card will be completely suppressed on the frontend.</small>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-dark mb-1">
                                    Target Clients ("Who We Supply" Chips)
                                </label>
                                <input type="text" name="sector_clients" class="form-control" value="<?= htmlspecialchars($sec['clients']) ?>" placeholder="e.g. Importers, Distributors, Wholesalers, Retail Brands">
                                <small class="text-muted">Separate multiple client categories with commas.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark mb-1">Button Text</label>
                                <input type="text" name="sector_btn_text" class="form-control" value="<?= htmlspecialchars($sec['btn_text']) ?>" placeholder="e.g. Explore Export Commodities">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark mb-1">Button Link URL</label>
                                <input type="text" name="sector_btn_link" class="form-control" value="<?= htmlspecialchars($sec['btn_link']) ?>" placeholder="e.g. product-arabica.php">
                            </div>

                            <!-- Icon Upload -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark mb-1">
                                    Sector Icon Graphic (SVG or PNG)
                                </label>
                                <input type="file" name="sector_icon" class="form-control" accept="image/*,.svg">
                                <small class="text-muted mt-1 d-block">Recommended: Transparent Flaticon SVG or PNG (e.g. 64x64px).</small>
                            </div>

                            <?php if ($has_custom): ?>
                            <div class="col-12">
                                <div class="p-3 bg-light rounded-3 border d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width: 44px; height: 44px; border-radius: 8px; background: #FFF; border: 1px solid #DDD; display: flex; align-items: center; justify-content: center; padding: 4px;">
                                            <img src="<?= htmlspecialchars($icon_src) ?>" alt="Icon" style="width: 32px; height: 32px; object-fit: contain;">
                                        </div>
                                        <div>
                                            <span class="badge bg-success mb-1">Active Custom Graphic</span>
                                            <div class="text-muted small"><?= htmlspecialchars(basename($sec['icon'])) ?></div>
                                        </div>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="remove_icon" value="1" id="removeIcon_<?= $idx ?>">
                                        <label class="form-check-label text-danger small fw-bold" for="removeIcon_<?= $idx ?>">
                                            <i class="fa-solid fa-trash-can me-1"></i> Revert to Default SVG
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="modal-footer py-3 px-4 bg-light border-top d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary px-4 py-2 rounded-pill fw-semibold" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" name="edit_sector" class="btn btn-antara-gold px-4 py-2 rounded-pill fw-bold shadow-sm d-flex align-items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Save Sector Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

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
