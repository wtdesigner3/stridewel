<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// Handle Pillar Updates
if (isset($_POST['update_pillar'])) {
    $pillar = $_POST['pillar_type'] ?? '';
    $heading = mysqli_real_escape_string($conn, trim($_POST['heading']));
    $content = mysqli_real_escape_string($conn, trim($_POST['content']));

    if ($pillar === 'mission') {
        $upd = mysqli_query($conn, "UPDATE `tbl_about` SET `mission_heading`='$heading', `mission_content`='$content' WHERE `id`=1");
        $pillar_name = "Strategic Mission";
    } elseif ($pillar === 'vision') {
        $upd = mysqli_query($conn, "UPDATE `tbl_about` SET `vision_heading`='$heading', `vision_content`='$content' WHERE `id`=1");
        $pillar_name = "Global Vision";
    } elseif ($pillar === 'values') {
        $upd = mysqli_query($conn, "UPDATE `tbl_about` SET `values_heading`='$heading', `values_content`='$content' WHERE `id`=1");
        $pillar_name = "Quality Policy";
    } elseif ($pillar === 'rnd') {
        $upd = mysqli_query($conn, "UPDATE `tbl_about` SET `rnd_heading`='$heading', `rnd_content`='$content' WHERE `id`=1");
        $pillar_name = "R&D Innovation";
    } else {
        $upd = false;
        $error = "Invalid pillar specified.";
    }

    if (!empty($upd)) {
        $msg = "$pillar_name updated successfully!";
    } elseif (empty($error)) {
        $error = "Failed to update: " . mysqli_error($conn);
    }
}

// Fetch Latest Record
$about = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `tbl_about` WHERE `id`=1"));

$pillars = [
    'mission' => [
        'name' => 'Our Mission',
        'badge' => 'bg-danger text-white',
        'icon' => 'fa-solid fa-bullseye text-danger',
        'heading' => $about['mission_heading'] ?? 'Our Mission',
        'content' => $about['mission_content'] ?? '',
        'tag' => 'Pillar 1 • Core Directive'
    ],
    'vision' => [
        'name' => 'Our Vision',
        'badge' => 'bg-primary text-white',
        'icon' => 'fa-solid fa-eye text-primary',
        'heading' => $about['vision_heading'] ?? 'Our Vision',
        'content' => $about['vision_content'] ?? '',
        'tag' => 'Pillar 2 • Long-Term Strategy'
    ],
    'values' => [
        'name' => 'Quality Policy',
        'badge' => 'bg-success text-white',
        'icon' => 'fa-solid fa-shield-check text-success',
        'heading' => $about['values_heading'] ?? 'Quality Policy',
        'content' => $about['values_content'] ?? '',
        'tag' => 'Pillar 3 • ISO & Compliance'
    ],
    'rnd' => [
        'name' => 'R&D Innovation',
        'badge' => 'bg-warning text-dark',
        'icon' => 'fa-solid fa-lightbulb text-warning',
        'heading' => $about['rnd_heading'] ?? 'R&D Innovation',
        'content' => $about['rnd_content'] ?? '',
        'tag' => 'Pillar 4 • Continuous R&D'
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
                        Mission, Vision &amp; Quality Philosophy
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 13.5px;">
                        Manage the 4 core Guiding Principles pillars displayed in the About Us page grid.
                    </p>
                </div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="manage-about-story.php">About Us CMS</a></li>
                    <li class="breadcrumb-item active">Mission &amp; Vision</li>
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
                <a href="manage-about-mission.php" class="cms-subnav-pill active">
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

            <!-- Guiding Principles 4 Pillars Table -->
            <div class="table-crud-card">
                <div class="table-crud-header">
                    <div class="d-flex flex-wrap align-items-center gap-3 flex-grow-1">
                        <div class="table-crud-search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="directiveSearchInput" class="form-control" placeholder="Search guiding principles...">
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-light text-dark border px-3 py-2" style="font-size: 12.5px; font-weight: 600;">
                            <i class="fa-solid fa-compass text-danger me-1"></i> 4 Guiding Principles Pillars
                        </span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-crud-table" id="directivesTable">
                        <thead>
                            <tr>
                                <th style="width: 140px; text-align: center;">PILLAR</th>
                                <th style="width: 70px; text-align: center;">ICON</th>
                                <th style="width: 25%;">HEADING &amp; TITLE</th>
                                <th style="width: 50%;">STATEMENT / NARRATIVE</th>
                                <th style="width: 80px; text-align: center;">ACTION</th>
                            </tr>
                        </thead>
                        <tbody id="directivesTableBody">
                            <?php foreach ($pillars as $key => $p): ?>
                            <tr class="directive-row">
                                <td style="text-align: center;">
                                    <span class="badge <?= $p['badge'] ?> px-2.5 py-1.5" style="font-size: 11.5px; font-weight: 700;">
                                        <?= htmlspecialchars($p['name']) ?>
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <div class="table-icon-thumb mx-auto" style="width: 44px; height: 44px; border-radius: 10px; background: #f8fafc; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center;">
                                        <i class="<?= $p['icon'] ?>" style="font-size: 18px;"></i>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark" style="font-size: 15px;">
                                        <?= htmlspecialchars($p['heading']) ?>
                                    </div>
                                    <div class="text-muted small mt-0.5"><?= htmlspecialchars($p['tag']) ?></div>
                                </td>
                                <td>
                                    <div class="table-desc-text" style="font-size: 13.5px; color: #475569; line-height: 1.5;">
                                        <?= htmlspecialchars($p['content']) ?>
                                    </div>
                                </td>
                                <td style="text-align: center;">
                                    <button type="button" class="btn-action-square btn-action-edit" data-toggle="modal" data-target="#editModal_<?= $key ?>" data-bs-toggle="modal" data-bs-target="#editModal_<?= $key ?>" title="Edit <?= htmlspecialchars($p['name']) ?>">
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

    <!-- Edit Modals for all 4 Pillars -->
    <?php foreach ($pillars as $key => $p): ?>
    <div class="modal fade" id="editModal_<?= $key ?>" tabindex="-1" aria-labelledby="editModalLabel_<?= $key ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #103755 0%, #1a4d75 100%);">
                    <h5 class="modal-title fw-bold" id="editModalLabel_<?= $key ?>" style="color: #FFFFFF !important;">
                        <i class="<?= $p['icon'] ?> me-2"></i> Edit <?= htmlspecialchars($p['name']) ?>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <input type="hidden" name="pillar_type" value="<?= $key ?>">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">
                                Pillar Heading Title
                            </label>
                            <input type="text" name="heading" class="form-control form-control-lg fw-bold" value="<?= htmlspecialchars($p['heading']) ?>" placeholder="e.g. <?= htmlspecialchars($p['name']) ?>">
                        </div>

                        <div class="mb-2">
                            <label class="form-label fw-bold text-dark mb-1">
                                Statement Narrative / Description
                            </label>
                            <textarea name="content" class="form-control no-ckeditor" rows="5" placeholder="Enter detailed policy or statement..."><?= htmlspecialchars($p['content']) ?></textarea>
                            <small class="text-muted mt-1 d-block">Displayed dynamically on the About Us page Guiding Principles grid.</small>
                        </div>
                    </div>

                    <div class="modal-footer py-3 px-4 bg-light border-top d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary px-4 py-2 rounded-pill fw-semibold" data-dismiss="modal" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_pillar" class="btn btn-danger px-4 py-2 rounded-pill fw-bold shadow-sm d-flex align-items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Save Changes
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

            // Search filtering
            $('#directiveSearchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#directivesTableBody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
</body>
</html>
