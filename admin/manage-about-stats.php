<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// Handle Metric Stat Edit
if (isset($_POST['edit_stat_metric'])) {
    $stat_idx = (int)($_POST['stat_index'] ?? 0);
    $val = mysqli_real_escape_string($conn, trim($_POST['stat_value']));
    $lbl = mysqli_real_escape_string($conn, trim($_POST['stat_label']));

    $field_map = [
        1 => ['val' => 'stat_volume', 'lbl' => 'stat_volume_label', 'name' => 'Monthly Volume Metric'],
        2 => ['val' => 'stat_ports', 'lbl' => 'stat_ports_label', 'name' => 'Destination Ports Metric'],
        3 => ['val' => 'stat_lots', 'lbl' => 'stat_lots_label', 'name' => 'Batch Traceability Metric'],
        4 => ['val' => 'stat_clients', 'lbl' => 'stat_clients_label', 'name' => 'Commercial Buyers Metric']
    ];

    if (isset($field_map[$stat_idx])) {
        $v_field = $field_map[$stat_idx]['val'];
        $l_field = $field_map[$stat_idx]['lbl'];

        $upd = mysqli_query($conn, "UPDATE `tbl_about` SET `$v_field`='$val', `$l_field`='$lbl' WHERE `id`=1");
        if ($upd) {
            $msg = $field_map[$stat_idx]['name'] . " updated successfully!";
        } else {
            $error = "Failed to update metric: " . mysqli_error($conn);
        }
    }
}

// Fetch Latest Record
$about = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `tbl_about` WHERE `id`=1"));

$stat_metrics = [
    1 => [
        'name' => 'Metric #1',
        'badge' => 'bg-warning text-dark',
        'title' => 'Monthly Volume',
        'value' => $about['stat_volume'] ?? '',
        'label' => $about['stat_volume_label'] ?? '',
        'icon' => 'fa-solid fa-boxes-stacked text-warning'
    ],
    2 => [
        'name' => 'Metric #2',
        'badge' => 'bg-info text-white',
        'title' => 'Global Ports',
        'value' => $about['stat_ports'] ?? '',
        'label' => $about['stat_ports_label'] ?? '',
        'icon' => 'fa-solid fa-anchor text-info'
    ],
    3 => [
        'name' => 'Metric #3',
        'badge' => 'bg-success text-white',
        'title' => 'Batch Traceability',
        'value' => $about['stat_lots'] ?? '',
        'label' => $about['stat_lots_label'] ?? '',
        'icon' => 'fa-solid fa-certificate text-success'
    ],
    4 => [
        'name' => 'Metric #4',
        'badge' => 'bg-danger text-white',
        'title' => 'Commercial Buyers',
        'value' => $about['stat_clients'] ?? '',
        'label' => $about['stat_clients_label'] ?? '',
        'icon' => 'fa-solid fa-users text-danger'
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
                        Verified Statistics Management
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 13.5px;">
                        Manage the 4 key trade volume figures and quantitative metrics displayed in the "Antara Globale in Numbers" section.
                    </p>
                </div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="manage-about-story.php">About Us CMS</a></li>
                    <li class="breadcrumb-item active">Verified Statistics</li>
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
                <a href="manage-about-stats.php" class="cms-subnav-pill active">
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

            <!-- Live Frontend Visual Preview Strip -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold" style="color: #123023; font-size: 15px;">
                        <i class="fa-solid fa-eye text-primary me-2"></i> Live Frontend Display Preview ("Antara Globale in Numbers")
                    </h5>
                    <span class="badge bg-light text-muted border px-2.5 py-1">4 Active Metrics</span>
                </div>
                <div class="card-body p-4 bg-light">
                    <div class="row g-3 text-center">
                        <?php foreach ($stat_metrics as $idx => $m): 
                            $is_m_active = !empty(trim($m['value']));
                        ?>
                        <div class="col-lg-3 col-6">
                            <div class="p-3 bg-white rounded-3 border shadow-sm h-100 <?= !$is_m_active ? 'opacity-50' : '' ?>">
                                <div class="text-muted small mb-1 fw-bold text-uppercase" style="letter-spacing: 0.5px; font-size: 11px;">
                                    <?= htmlspecialchars($m['title']) ?>
                                </div>
                                <?php if ($is_m_active): ?>
                                    <h3 class="fw-bold mb-1" style="font-size: 28px; color: #123023;">
                                        <?= htmlspecialchars($m['value']) ?>
                                    </h3>
                                    <span class="text-muted small" style="font-size: 12.5px;">
                                        <?= htmlspecialchars($m['label']) ?>
                                    </span>
                                <?php else: ?>
                                    <div class="text-danger small fw-semibold my-2">[Empty - Hidden on Frontend]</div>
                                    <span class="text-muted small" style="font-size: 11px;">Card will not render</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Verified Trade Statistics Table CRUD Card -->
            <div class="table-crud-card">
                <div class="table-crud-header">
                    <div class="d-flex flex-wrap align-items-center gap-3 flex-grow-1">
                        <div class="table-crud-search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="statSearchInput" class="form-control" placeholder="Search verified statistics...">
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-light text-dark border px-3 py-2" style="font-size: 12.5px; font-weight: 600;">
                            <i class="fa-solid fa-chart-pie text-success me-1"></i> 4 Quantitative Sourcing Metrics
                        </span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-crud-table" id="statsTable">
                        <thead>
                            <tr>
                                <th style="width: 110px; text-align: center;">METRIC #</th>
                                <th style="width: 80px; text-align: center;">ICON</th>
                                <th style="width: 25%;">QUANTITATIVE VALUE</th>
                                <th style="width: 48%;">METRIC LABEL / DESCRIPTOR</th>
                                <th style="width: 90px; text-align: center;">ACTION</th>
                            </tr>
                        </thead>
                        <tbody id="statsTableBody">
                            <?php foreach ($stat_metrics as $idx => $metric): ?>
                            <tr>
                                <td style="text-align: center;">
                                    <span class="badge <?= $metric['badge'] ?> px-2.5 py-1.5" style="font-size: 11.5px; font-weight: 700;">
                                        <?= $metric['name'] ?>
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <div class="table-thumb-box mx-auto d-flex align-items-center justify-content-center" style="background: rgba(18, 48, 35, 0.05); border: 1px solid rgba(18, 48, 35, 0.12); width: 44px; height: 44px; border-radius: 10px;">
                                        <i class="<?= $metric['icon'] ?>" style="font-size: 19px;"></i>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold" style="font-size: 18px; color: #123023;">
                                        <?= htmlspecialchars($metric['value']) ?>
                                    </div>
                                    <div class="text-muted small"><?= htmlspecialchars($metric['title']) ?></div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark" style="font-size: 14px;">
                                        <?= htmlspecialchars($metric['label']) ?>
                                    </div>
                                    <div class="text-muted small">Frontend About Page Display Text</div>
                                </td>
                                <td style="text-align: center;">
                                    <button type="button" class="btn-action-square btn-action-edit" data-bs-toggle="modal" data-bs-target="#editStatModal_<?= $idx ?>" title="Edit <?= $metric['title'] ?>">
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

    <!-- Edit Stat Modals -->
    <?php foreach ($stat_metrics as $idx => $metric): ?>
    <div class="modal fade" id="editStatModal_<?= $idx ?>" tabindex="-1" aria-labelledby="editStatModalLabel_<?= $idx ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #123023 0%, #1B4533 100%);">
                    <h5 class="modal-title fw-bold" id="editStatModalLabel_<?= $idx ?>" style="color: #FFFFFF !important;">
                        <i class="fa-solid fa-pen-to-square text-warning me-2"></i> Edit <?= $metric['title'] ?>
                    </h5>
                    <button type="button" class="modal-close-btn" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <input type="hidden" name="stat_index" value="<?= $idx ?>">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">
                                Quantitative Metric Value
                            </label>
                            <input type="text" name="stat_value" class="form-control form-control-lg fw-bold" value="<?= htmlspecialchars($metric['value']) ?>" placeholder="e.g. 500+ MT (Leave blank to hide)" style="font-size: 20px; color: #123023;">
                            <small class="text-muted">Display number/metric with symbol (e.g. 500+ MT, 18+, 100%, 120+). <strong>Leave blank to hide this metric card in frontend.</strong></small>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold text-dark mb-1">
                                Metric Label / Description
                            </label>
                            <input type="text" name="stat_label" class="form-control" value="<?= htmlspecialchars($metric['label']) ?>" placeholder="e.g. Monthly Commodity Flow">
                            <small class="text-muted">Descriptive subtitle displayed directly underneath the big metric number.</small>
                        </div>
                    </div>
                    <div class="modal-footer py-3 px-4 bg-light border-top d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary px-4 py-2 rounded-pill fw-semibold" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" name="edit_stat_metric" class="btn btn-antara-gold px-4 py-2 rounded-pill fw-bold shadow-sm d-flex align-items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Save Metric Changes
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
            $('#statSearchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#statsTableBody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
</body>
</html>
