<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// Handle Individual Pillar Edit from Modal
if (isset($_POST['edit_pillar'])) {
    $idx = (int)($_POST['pillar_index'] ?? 0);

    if ($idx >= 1 && $idx <= 3) {
        $t = mysqli_real_escape_string($conn, trim($_POST['pillar_title']));
        $d = mysqli_real_escape_string($conn, trim($_POST['pillar_desc']));

        // Fetch current image
        $cur_q = mysqli_query($conn, "SELECT `pillar{$idx}_image` FROM `tbl_home_content` WHERE `id`=1");
        $cur = mysqli_fetch_assoc($cur_q);
        $img = $cur["pillar{$idx}_image"] ?? '';

        // Check if remove image is checked
        if (isset($_POST['remove_image']) && $_POST['remove_image'] == '1') {
            if (!empty($img) && file_exists("../../" . $img)) {
                @unlink("../../" . $img);
            }
            $img = '';
        }

        // Check for new uploaded file
        if (!empty($_FILES['pillar_image']['name']) && $_FILES['pillar_image']['error'] == 0) {
            $ext = strtolower(pathinfo($_FILES['pillar_image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif'];
            if (in_array($ext, $allowed)) {
                $upload_dir = "../../uploads/home/";
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                $new_filename = "pillar_" . $idx . "_" . time() . "_" . rand(100, 999) . "." . $ext;
                if (move_uploaded_file($_FILES['pillar_image']['tmp_name'], $upload_dir . $new_filename)) {
                    if (!empty($img) && file_exists("../../" . $img) && $img !== ("uploads/home/" . $new_filename)) {
                        @unlink("../../" . $img);
                    }
                    $img = "uploads/home/" . $new_filename;
                }
            } else {
                $error = "Invalid image format. Please upload SVG, PNG, JPG, or WEBP.";
            }
        }

        if (empty($error)) {
            $upd = mysqli_query($conn, "UPDATE `tbl_home_content` SET 
                `pillar{$idx}_title`='$t',
                `pillar{$idx}_desc`='$d',
                `pillar{$idx}_image`='$img'
                WHERE `id`=1");

            if ($upd) {
                $msg = "Export Pillar Block #$idx updated successfully!";
            } else {
                $error = "Failed to update Pillar Block #$idx: " . mysqli_error($conn);
            }
        }
    } else {
        $error = "Invalid pillar index selected.";
    }
}

// Fetch Latest Record
$home = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `tbl_home_content` WHERE `id`=1"));

$pillar_configs = [
    1 => [
        'name' => 'Block 1',
        'badge' => 'badge-antara-secondary',
        'default_title' => 'Direct Origin Procurement',
        'default_icon' => 'fa-solid fa-seedling',
        'border_color' => '#C5A059'
    ],
    2 => [
        'name' => 'Block 2',
        'badge' => 'badge-antara-secondary',
        'default_title' => 'Strict Quality Assurance',
        'default_icon' => 'fa-solid fa-microscope',
        'border_color' => '#C5A059'
    ],
    3 => [
        'name' => 'Block 3',
        'badge' => 'badge-antara-secondary',
        'default_title' => 'Export Packaging & Logistics',
        'default_icon' => 'fa-solid fa-box-archive',
        'border_color' => '#C5A059'
    ],
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
                        Export Pillars Strip CMS (3 Blocks)
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 13.5px;">
                        Manage the 3 core visual blocks and icon graphics displayed in the highlights strip below the hero carousel (<span class="fw-bold text-success">3 active blocks</span>)
                    </p>
                </div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="manage-home-hero.php">Home Page CMS</a></li>
                    <li class="breadcrumb-item active">Export Pillars (3 Blocks)</li>
                </ol>
            </div>

            <!-- Quick Sub-Menu Switcher Pills -->
            <div class="cms-subnav-strip">
                <a href="manage-home-hero.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-images"></i> Hero Carousel Banners
                </a>
                <a href="manage-home-pillars.php" class="cms-subnav-pill active">
                    <i class="fa-solid fa-shapes"></i> Export Pillars (3 Blocks)
                </a>
                <a href="manage-home-intro.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-file-lines"></i> Corporate Story Intro
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

            <!-- Table CRUD Card Container -->
            <div class="table-crud-card">
                <!-- Top Header: Search Box & Overview Summary -->
                <div class="table-crud-header">
                    <div class="d-flex flex-wrap align-items-center gap-3 flex-grow-1">
                        <!-- Search Box -->
                        <div class="table-crud-search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="pillarSearchInput" class="form-control" placeholder="Search strategic pillars...">
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-light text-dark border px-3 py-2" style="font-size: 12.5px; font-weight: 600;">
                            <i class="fa-solid fa-shield-halved text-success me-1"></i> 4 Homepage Strategic Pillars
                        </span>
                    </div>
                </div>

                <!-- Strategic Pillars Data Table -->
                <div class="table-responsive">
                    <table class="table table-crud-table" id="pillarsTable">
                        <thead>
                            <tr>
                                <th style="width: 100px; text-align: center;">PILLAR #</th>
                                <th style="width: 100px; text-align: center;">ICON / GRAPHIC</th>
                                <th style="width: 32%;">PILLAR TITLE</th>
                                <th style="width: 38%;">DESCRIPTION TEXT</th>
                                <th style="width: 140px; text-align: center;">GRAPHIC TYPE</th>
                                <th style="width: 90px; text-align: center;">ACTION</th>
                            </tr>
                        </thead>
                        <tbody id="pillarsTableBody">
                            <?php foreach ($pillar_configs as $idx => $cfg): 
                                $p_title = $home["pillar{$idx}_title"] ?? '';
                                $p_desc = $home["pillar{$idx}_desc"] ?? '';
                                $p_icon = $home["pillar{$idx}_icon"] ?? $cfg['default_icon'];
                                $p_img = $home["pillar{$idx}_image"] ?? '';
                                $has_img = !empty($p_img) && file_exists("../../" . $p_img);
                                $default_svg = 'assets/img/icons/pillar-' . $idx . '-' . ($idx == 1 ? 'origin' : ($idx == 2 ? 'quality' : ($idx == 3 ? 'logistics' : 'support'))) . '.svg';
                            ?>
                            <tr class="pillar-row">
                                <!-- Pillar Index Badge -->
                                <td style="text-align: center;">
                                    <span class="badge badge-antara-secondary">
                                        <?= $cfg['name'] ?>
                                    </span>
                                </td>

                                <!-- Visual Icon / Graphic Preview -->
                                <td style="text-align: center;">
                                    <div class="table-icon-thumb mx-auto">
                                        <?php if ($has_img): ?>
                                             <img src="../../<?= htmlspecialchars($p_img) ?>" alt="Pillar <?= $idx ?>">
                                        <?php elseif (file_exists("../../" . $default_svg)): ?>
                                             <img src="../../<?= htmlspecialchars($default_svg) ?>" alt="Pillar <?= $idx ?>">
                                        <?php else: ?>
                                             <i class="<?= htmlspecialchars($p_icon ?: $cfg['default_icon']) ?> text-warning" style="font-size: 20px;"></i>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <!-- Title -->
                                <td>
                                    <div class="fw-bold text-dark" style="font-size: 14.5px; line-height: 1.35;">
                                        <?= htmlspecialchars($p_title ?: $cfg['default_title']) ?>
                                    </div>
                                    <div class="text-muted small mt-0.5">Homepage Overview Pillar</div>
                                </td>

                                <!-- Description Snippet -->
                                <td>
                                    <div class="table-desc-text" style="font-size: 13px; color: #526058; line-height: 1.5;" title="<?= htmlspecialchars($p_desc) ?>">
                                        <?= !empty($p_desc) ? htmlspecialchars($p_desc) : '<span class="text-muted">—</span>' ?>
                                    </div>
                                </td>

                                <!-- Visual Type Status Badge -->
                                <td style="text-align: center;">
                                    <?php if ($has_img): ?>
                                        <span class="badge badge-antara-primary">
                                            <i class="fa-solid fa-cloud-arrow-up text-success me-1"></i> Custom Upload
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-antara-secondary">
                                            <i class="fa-solid fa-sparkles text-warning me-1"></i> Default Graphic
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <!-- Action Edit Button -->
                                <td style="text-align: center;">
                                    <button type="button" class="btn-action-square btn-action-edit" data-bs-toggle="modal" data-bs-target="#editPillarModal<?= $idx ?>" title="Edit Strategic Pillar #<?= $idx ?>">
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

    <!-- Edit Pillar Modals -->
    <?php foreach ($pillar_configs as $idx => $cfg): 
        $p_title = $home["pillar{$idx}_title"] ?? '';
        $p_desc = $home["pillar{$idx}_desc"] ?? '';
        $p_icon = $home["pillar{$idx}_icon"] ?? $cfg['default_icon'];
        $p_img = $home["pillar{$idx}_image"] ?? '';
        $has_img = !empty($p_img) && file_exists("../../" . $p_img);
    ?>
    <div class="modal fade" id="editPillarModal<?= $idx ?>" tabindex="-1" aria-labelledby="editPillarModalLabel<?= $idx ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #123023 0%, #1B4533 100%);">
                    <h5 class="modal-title fw-bold" id="editPillarModalLabel<?= $idx ?>" style="color: #FFFFFF !important;">
                        <i class="fa-solid fa-pen-to-square text-warning me-2"></i> Edit <?= $cfg['name'] ?> Strategic Value
                    </h5>
                    <button type="button" class="modal-close-btn" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="pillar_index" value="<?= $idx ?>">
                    
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <!-- Pillar Title -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark mb-1">
                                    Pillar Title
                                </label>
                                <input type="text" name="pillar_title" class="form-control" value="<?= htmlspecialchars($p_title) ?>" placeholder="e.g. Direct Origin Sourcing (Leave blank to hide)">
                                <small class="text-muted"><strong>Tip:</strong> If both title and description are left blank, this pillar card will be hidden on the frontend.</small>
                            </div>

                            <!-- Dedicated Image / SVG Icon Upload Field -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark mb-1">
                                    <i class="fa-solid fa-cloud-arrow-up text-primary me-1"></i> Upload Pillar Icon / Graphic Image
                                </label>
                                <input type="file" name="pillar_image" class="form-control" accept="image/*,.svg">
                                <small class="text-muted mt-1.5 d-block">
                                    Upload an icon graphic (SVG, PNG, WEBP, or JPG). Transparent background recommended (e.g. 64x64px or 128x128px).
                                </small>
                            </div>

                            <!-- If Image exists, show removal switch card -->
                            <?php if ($has_img): ?>
                            <div class="col-12">
                                <div class="p-3 bg-light rounded-3 border d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="modal-preview-box">
                                            <img src="../../<?= htmlspecialchars($p_img) ?>" alt="Pillar Image">
                                        </div>
                                        <div>
                                            <span class="badge bg-success mb-1">Active Custom Graphic</span>
                                            <div class="text-muted small text-truncate" style="max-width: 280px;"><?= htmlspecialchars(basename($p_img)) ?></div>
                                        </div>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="remove_image" value="1" id="modalRemoveImg<?= $idx ?>">
                                        <label class="form-check-label text-danger fw-semibold small" for="modalRemoveImg<?= $idx ?>">
                                            <i class="fa-solid fa-trash-can me-1"></i> Remove Image (Use Default Icon)
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Description Text -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark mb-1">
                                    Description Paragraph
                                </label>
                                <textarea name="pillar_desc" class="form-control no-ckeditor" rows="4" placeholder="Brief 1-2 sentence description explaining this value pillar to international buyers..."><?= htmlspecialchars($p_desc) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer py-3 px-4 bg-light border-top d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary px-4 py-2 rounded-pill fw-semibold" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" name="edit_pillar" class="btn btn-antara-gold px-4 py-2 rounded-pill fw-bold shadow-sm d-flex align-items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Save Pillar Changes
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

            // Client-side search filtering
            $('#pillarSearchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#pillarsTableBody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
</body>
</html>
