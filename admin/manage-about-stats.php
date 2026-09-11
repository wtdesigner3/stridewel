<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// Handle Metric Stat Edit
if (isset($_POST['edit_stat_metric'])) {
    $stat_idx = (int)($_POST['stat_index'] ?? 0);
    $val = mysqli_real_escape_string($conn, trim($_POST['stat_val']));
    $suffix = mysqli_real_escape_string($conn, trim($_POST['stat_suffix']));
    $label = mysqli_real_escape_string($conn, trim($_POST['stat_label']));
    $sub = mysqli_real_escape_string($conn, trim($_POST['stat_sub']));

    if ($stat_idx >= 1 && $stat_idx <= 4) {
        $upd = mysqli_query($conn, "UPDATE `tbl_about` SET 
            `stat_{$stat_idx}_val`='$val',
            `stat_{$stat_idx}_suffix`='$suffix',
            `stat_{$stat_idx}_label`='$label',
            `stat_{$stat_idx}_sub`='$sub'
            WHERE `id`=1");

        if ($upd) {
            $msg = "Counter Metric #$stat_idx updated successfully!";
        } else {
            $error = "Failed to update metric: " . mysqli_error($conn);
        }
    }
}

// Fetch Latest Record
$about_q = @mysqli_query($conn, "SELECT * FROM `tbl_about` WHERE `id`=1");
$about = ($about_q && mysqli_num_rows($about_q) > 0) ? mysqli_fetch_assoc($about_q) : [];

$stat_metrics = [
    1 => [
        'name' => 'Counter Metric #1',
        'badge' => 'bg-danger text-white',
        'title' => 'Heritage Years',
        'val' => $about['stat_1_val'] ?? '40',
        'suffix' => $about['stat_1_suffix'] ?? '+',
        'label' => $about['stat_1_label'] ?? 'Years of Industry Heritage',
        'sub' => $about['stat_1_sub'] ?? 'Pioneering A.I. since 1982',
        'icon' => 'fa-solid fa-clock-rotate-left text-danger'
    ],
    2 => [
        'name' => 'Counter Metric #2',
        'badge' => 'bg-primary text-white',
        'title' => 'Universal Guns',
        'val' => $about['stat_2_val'] ?? '100',
        'suffix' => $about['stat_2_suffix'] ?? 'K+',
        'label' => $about['stat_2_label'] ?? 'Universal Guns Supplied',
        'sub' => $about['stat_2_sub'] ?? 'Universal 0.5 & 0.25ml SS',
        'icon' => 'fa-solid fa-bullseye text-primary'
    ],
    3 => [
        'name' => 'Counter Metric #3',
        'badge' => 'bg-success text-white',
        'title' => 'French Sheaths',
        'val' => $about['stat_3_val'] ?? '50',
        'suffix' => $about['stat_3_suffix'] ?? 'M+',
        'label' => $about['stat_3_label'] ?? 'French Sheaths Produced',
        'sub' => $about['stat_3_sub'] ?? 'Cleanroom medical grade',
        'icon' => 'fa-solid fa-shield-halved text-success'
    ],
    4 => [
        'name' => 'Counter Metric #4',
        'badge' => 'bg-info text-white',
        'title' => 'Export Reach',
        'val' => $about['stat_4_val'] ?? '25',
        'suffix' => $about['stat_4_suffix'] ?? '+',
        'label' => $about['stat_4_label'] ?? 'Countries Export Footprint',
        'sub' => $about['stat_4_sub'] ?? 'Asia, Africa & Middle East',
        'icon' => 'fa-solid fa-globe text-info'
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
                    <h1 class="page-header mb-1" style="font-size: 24px; font-weight: 800; color: #103755;">
                        Verified Counter Statistics
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 13.5px;">
                        Manage the 4 key animated counter statistics displayed across the About Us page.
                    </p>
                </div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="manage-about-story.php">About Us CMS</a></li>
                    <li class="breadcrumb-item active">Verified Statistics</li>
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
                <a href="manage-about-stats.php" class="cms-subnav-pill active">
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

            <!-- Live Frontend Visual Preview Strip -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold" style="color: #103755; font-size: 15px;">
                        <i class="fa-solid fa-eye text-danger me-2"></i> Live Frontend Display Preview
                    </h5>
                    <span class="badge bg-light text-muted border px-2.5 py-1">4 Animated Counters</span>
                </div>
                <div class="card-body p-4 bg-light">
                    <div class="row g-3 text-center">
                        <?php foreach ($stat_metrics as $idx => $m): ?>
                        <div class="col-lg-3 col-6">
                            <div class="p-3 bg-white rounded-3 border shadow-sm h-100">
                                <div class="text-muted small mb-1 fw-bold text-uppercase" style="letter-spacing: 0.5px; font-size: 11px;">
                                    <?= htmlspecialchars($m['title']) ?>
                                </div>
                                <h3 class="fw-bold mb-1" style="font-size: 32px; color: #103755;">
                                    <span style="color: #ed1c24;"><?= htmlspecialchars($m['val']) ?></span><?= htmlspecialchars($m['suffix']) ?>
                                </h3>
                                <div class="fw-semibold text-dark" style="font-size: 13.5px;">
                                    <?= htmlspecialchars($m['label']) ?>
                                </div>
                                <div class="text-muted" style="font-size: 12px; margin-top: 4px;">
                                    <?= htmlspecialchars($m['sub']) ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Verified Statistics Table -->
            <div class="table-crud-card">
                <div class="table-crud-header">
                    <div class="d-flex flex-wrap align-items-center gap-3 flex-grow-1">
                        <div class="table-crud-search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="statSearchInput" class="form-control" placeholder="Search statistics...">
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-light text-dark border px-3 py-2" style="font-size: 12.5px; font-weight: 600;">
                            <i class="fa-solid fa-chart-pie text-danger me-1"></i> 4 Quantitative Sourcing Metrics
                        </span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-crud-table" id="statsTable">
                        <thead>
                            <tr>
                                <th style="width: 110px; text-align: center;">METRIC #</th>
                                <th style="width: 70px; text-align: center;">ICON</th>
                                <th style="width: 20%;">VALUE &amp; SUFFIX</th>
                                <th style="width: 35%;">PRIMARY LABEL</th>
                                <th style="width: 25%;">SUB-DESCRIPTOR</th>
                                <th style="width: 80px; text-align: center;">ACTION</th>
                            </tr>
                        </thead>
                        <tbody id="statsTableBody">
                            <?php foreach ($stat_metrics as $idx => $m): ?>
                            <tr>
                                <td style="text-align: center;">
                                    <span class="badge <?= $m['badge'] ?> px-2.5 py-1.5" style="font-size: 11.5px; font-weight: 700;">
                                        #<?= $idx ?>
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <div class="table-thumb-box mx-auto d-flex align-items-center justify-content-center" style="background: #f8fafc; border: 1px solid #e2e8f0; width: 44px; height: 44px; border-radius: 10px;">
                                        <i class="<?= $m['icon'] ?>" style="font-size: 18px;"></i>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold" style="font-size: 19px; color: #103755;">
                                        <?= htmlspecialchars($m['val']) ?><span style="color: #ed1c24;"><?= htmlspecialchars($m['suffix']) ?></span>
                                    </div>
                                    <div class="text-muted small"><?= htmlspecialchars($m['title']) ?></div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark" style="font-size: 14.5px;">
                                        <?= htmlspecialchars($m['label']) ?>
                                    </div>
                                    <div class="text-muted small">Main Heading Displayed on Page</div>
                                </td>
                                <td>
                                    <div class="text-muted" style="font-size: 13px;">
                                        <?= htmlspecialchars($m['sub']) ?>
                                    </div>
                                </td>
                                <td style="text-align: center;">
                                    <button type="button" class="btn-action-square btn-action-edit" data-toggle="modal" data-target="#editStatModal_<?= $idx ?>" data-bs-toggle="modal" data-bs-target="#editStatModal_<?= $idx ?>" title="Edit <?= $m['title'] ?>">
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
    <?php foreach ($stat_metrics as $idx => $m): ?>
    <div class="modal fade" id="editStatModal_<?= $idx ?>" tabindex="-1" aria-labelledby="editStatModalLabel_<?= $idx ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #103755 0%, #1a4d75 100%);">
                    <h5 class="modal-title fw-bold" id="editStatModalLabel_<?= $idx ?>" style="color: #FFFFFF !important;">
                        <i class="<?= $m['icon'] ?> me-2"></i> Edit <?= $m['title'] ?>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <input type="hidden" name="stat_index" value="<?= $idx ?>">
                    <div class="modal-body p-4">
                        <div class="row g-3 mb-3">
                            <div class="col-7">
                                <label class="form-label fw-bold text-dark mb-1">
                                    Counter Number (Target)
                                </label>
                                <input type="number" name="stat_val" class="form-control form-control-lg fw-bold" value="<?= htmlspecialchars($m['val']) ?>" placeholder="e.g. 40" required>
                                <small class="text-muted">Target count for JS running animation.</small>
                            </div>
                            <div class="col-5">
                                <label class="form-label fw-bold text-dark mb-1">
                                    Symbol / Suffix
                                </label>
                                <input type="text" name="stat_suffix" class="form-control form-control-lg fw-bold text-danger" value="<?= htmlspecialchars($m['suffix']) ?>" placeholder="e.g. +, K+, M+">
                                <small class="text-muted">Appended to number.</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">
                                Main Metric Title / Label
                            </label>
                            <input type="text" name="stat_label" class="form-control" value="<?= htmlspecialchars($m['label']) ?>" placeholder="e.g. Years of Industry Heritage" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label fw-bold text-dark mb-1">
                                Subtitle / Supporting Note
                            </label>
                            <input type="text" name="stat_sub" class="form-control" value="<?= htmlspecialchars($m['sub']) ?>" placeholder="e.g. Pioneering A.I. since 1982">
                        </div>
                    </div>
                    <div class="modal-footer py-3 px-4 bg-light border-top d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary px-4 py-2 rounded-pill fw-semibold" data-dismiss="modal" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" name="edit_stat_metric" class="btn btn-danger px-4 py-2 rounded-pill fw-bold shadow-sm d-flex align-items-center gap-2">
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
