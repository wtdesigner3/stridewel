<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// 1. Handle Section Header Update
if (isset($_POST['update_meta'])) {
    $badge = mysqli_real_escape_string($conn, trim($_POST['badge']));
    $heading = mysqli_real_escape_string($conn, trim($_POST['heading']));
    $description = mysqli_real_escape_string($conn, trim(strip_tags($_POST['description'] ?? '')));

    $upd = mysqli_query($conn, "UPDATE `tbl_timeline_meta` SET 
        `badge`='$badge',
        `heading`='$heading',
        `description`='$description'
        WHERE `id`=1");

    if ($upd) {
        $msg = "Timeline header updated successfully!";
    } else {
        $error = "Failed to update timeline header: " . mysqli_error($conn);
    }
}

// 2. Handle Status Toggle
if (isset($_GET['toggle_status']) && isset($_GET['id'])) {
    $tid = (int)$_GET['id'];
    $cur = (int)$_GET['toggle_status'];
    $new_st = ($cur == 1) ? 0 : 1;
    mysqli_query($conn, "UPDATE `tbl_timeline` SET `status`=$new_st WHERE `id`=$tid");
    header("Location: manage-about-timeline.php?msg=" . urlencode("Status updated successfully"));
    exit;
}

// 3. Handle Delete Milestone
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM `tbl_timeline` WHERE `id`=$del_id");
    header("Location: manage-about-timeline.php?msg=" . urlencode("Timeline milestone deleted"));
    exit;
}

// 4. Handle Add Milestone
if (isset($_POST['add_milestone'])) {
    $year = mysqli_real_escape_string($conn, trim($_POST['year']));
    $year_tag = mysqli_real_escape_string($conn, trim($_POST['year_tag']));
    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $card_tag = mysqli_real_escape_string($conn, trim($_POST['card_tag']));
    $description = mysqli_real_escape_string($conn, trim(strip_tags($_POST['description'] ?? '')));
    $icon = mysqli_real_escape_string($conn, trim($_POST['icon']));
    $sort = (int)($_POST['sort_order'] ?? 0);
    $status = isset($_POST['status']) ? 1 : 0;

    if (!empty($year) && !empty($title)) {
        $ins = mysqli_query($conn, "INSERT INTO `tbl_timeline` (`year`, `year_tag`, `title`, `card_tag`, `description`, `icon`, `sort_order`, `status`) VALUES ('$year', '$year_tag', '$title', '$card_tag', '$description', '$icon', $sort, $status)");
        if ($ins) {
            $msg = "Milestone '$year - $title' added successfully!";
        } else {
            $error = "Failed to add milestone: " . mysqli_error($conn);
        }
    } else {
        $error = "Year and Title are required.";
    }
}

// 5. Handle Edit Milestone
if (isset($_POST['edit_milestone'])) {
    $mid = (int)$_POST['milestone_id'];
    $year = mysqli_real_escape_string($conn, trim($_POST['year']));
    $year_tag = mysqli_real_escape_string($conn, trim($_POST['year_tag']));
    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $card_tag = mysqli_real_escape_string($conn, trim($_POST['card_tag']));
    $description = mysqli_real_escape_string($conn, trim(strip_tags($_POST['description'] ?? '')));
    $icon = mysqli_real_escape_string($conn, trim($_POST['icon']));
    $sort = (int)($_POST['sort_order'] ?? 0);
    $status = isset($_POST['status']) ? 1 : 0;

    if (!empty($year) && !empty($title)) {
        $upd = mysqli_query($conn, "UPDATE `tbl_timeline` SET 
            `year`='$year',
            `year_tag`='$year_tag',
            `title`='$title',
            `card_tag`='$card_tag',
            `description`='$description',
            `icon`='$icon',
            `sort_order`=$sort,
            `status`=$status
            WHERE `id`=$mid");

        if ($upd) {
            $msg = "Milestone '$year - $title' updated successfully!";
        } else {
            $error = "Failed to update milestone: " . mysqli_error($conn);
        }
    } else {
        $error = "Year and Title are required.";
    }
}

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}

// Fetch Section Meta
$meta = null;
$mq = @mysqli_query($conn, "SELECT * FROM `tbl_timeline_meta` WHERE `id`=1 LIMIT 1");
if ($mq && mysqli_num_rows($mq) > 0) {
    $meta = mysqli_fetch_assoc($mq);
}
if (!$meta) {
    $meta = [
        'badge' => 'Milestones & Heritage Journey',
        'heading' => 'Four Decades of <span>Pioneering Animal Husbandry</span> (1982 – Present)',
        'description' => 'Tracing our journey from Dr. N. Burdizzo\'s sole Indian agency to in-house manufacturing, Minitube Germany partnership, and regular veterinary R&D.'
    ];
}

// Fetch Milestones
$milestones = [];
$tq = @mysqli_query($conn, "SELECT * FROM `tbl_timeline` ORDER BY `sort_order` ASC, `id` ASC");
if ($tq && mysqli_num_rows($tq) > 0) {
    while ($row = mysqli_fetch_assoc($tq)) {
        $milestones[] = $row;
    }
}
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
                        Milestones &amp; Heritage Journey (1982 – Present)
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 13.5px;">
                        Manage the chronological timeline, milestone cards, historical accomplishments, and R&amp;D journey on the About Us page.
                    </p>
                </div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="manage-about-story.php">About Us CMS</a></li>
                    <li class="breadcrumb-item active">Milestones &amp; Heritage</li>
                </ol>
            </div>

            <!-- Quick Sub-Menu Switcher Pills -->
            <div class="cms-subnav-strip mb-4">
                <a href="manage-about-story.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-landmark"></i> Heritage &amp; Story
                </a>
                <a href="manage-about-timeline.php" class="cms-subnav-pill active">
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
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Live About Page
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

            <div class="row g-4">
                <!-- Left: Section Meta Form -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                        <div class="card-header bg-white py-3 px-4 border-bottom">
                            <h5 class="mb-0 fw-bold" style="color: #103755;">
                                <i class="fa-solid fa-heading text-danger me-2"></i> Timeline Header &amp; Subtitle
                            </h5>
                        </div>
                        <div class="card-body p-4 bg-white">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark mb-1">Pill Badge</label>
                                    <input type="text" name="badge" class="form-control" value="<?= htmlspecialchars($meta['badge']) ?>" placeholder="e.g. Milestones & Heritage Journey">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark mb-1">Section Main Heading</label>
                                    <input type="text" name="heading" class="form-control" value="<?= htmlspecialchars($meta['heading']) ?>" placeholder="e.g. Four Decades of Pioneering Animal Husbandry">
                                    <small class="text-muted">Use <code>&lt;span&gt;text&lt;/span&gt;</code> for red highlight gradient text.</small>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark mb-1">Introductory Summary</label>
                                    <textarea name="description" class="form-control no-ckeditor" rows="4"><?= htmlspecialchars(strip_tags($meta['description'])) ?></textarea>
                                </div>
                                <button type="submit" name="update_meta" class="btn btn-danger w-100 fw-bold py-2.5 rounded-pill shadow-sm">
                                    <i class="fa-solid fa-floppy-disk me-1"></i> Update Timeline Header
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right: Chronological Milestones Table -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <h5 class="mb-0 fw-bold" style="color: #103755;">
                                <i class="fa-solid fa-clock-rotate-left text-danger me-2"></i> Heritage Milestones (<?= count($milestones) ?>)
                            </h5>
                            <button type="button" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold shadow-sm" data-toggle="modal" data-target="#addMilestoneModal" data-bs-toggle="modal" data-bs-target="#addMilestoneModal">
                                <i class="fa-solid fa-plus me-1"></i> Add Milestone
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light text-muted" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                                        <tr>
                                            <th class="ps-4" style="width: 75px;">Year</th>
                                            <th style="width: 70px;">Icon</th>
                                            <th>Milestone &amp; Event</th>
                                            <th style="width: 100px;">Status</th>
                                            <th class="text-end pe-4" style="width: 120px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($milestones)): ?>
                                            <?php foreach ($milestones as $m): ?>
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="fw-bold text-dark" style="font-size: 15px;"><?= htmlspecialchars($m['year']) ?></div>
                                                    <small class="badge bg-light text-danger border" style="font-size: 10px;"><?= htmlspecialchars($m['year_tag']) ?></small>
                                                </td>
                                                <td>
                                                    <div class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 36px; height: 36px; background: rgba(237,28,36,0.1); color: #ed1c24; font-size: 16px;">
                                                        <i class="bi <?= htmlspecialchars($m['icon'] ?? 'bi-calendar-check') ?>"></i>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        <strong class="text-dark" style="font-size: 14px;"><?= htmlspecialchars($m['title']) ?></strong>
                                                        <span class="badge bg-secondary-subtle text-secondary" style="font-size: 10.5px;"><?= htmlspecialchars($m['card_tag']) ?></span>
                                                    </div>
                                                    <small class="text-muted d-block" style="font-size: 12px; line-height: 1.4;"><?= htmlspecialchars($m['description']) ?></small>
                                                </td>
                                                <td>
                                                    <?php if ($m['status'] == 1): ?>
                                                        <a href="manage-about-timeline.php?toggle_status=1&id=<?= $m['id'] ?>" class="badge bg-success-subtle text-success border border-success-subtle text-decoration-none px-2 py-1 rounded-pill fw-bold" title="Click to Deactivate">
                                                            Active
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="manage-about-timeline.php?toggle_status=0&id=<?= $m['id'] ?>" class="badge bg-secondary-subtle text-secondary border border-secondary-subtle text-decoration-none px-2 py-1 rounded-pill fw-bold" title="Click to Activate">
                                                            Hidden
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <div class="btn-group btn-group-sm">
                                                        <button type="button" class="btn btn-outline-primary btn-sm rounded-2 me-1 edit-milestone-btn"
                                                            data-toggle="modal"
                                                            data-target="#editMilestoneModal"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editMilestoneModal"
                                                            data-id="<?= $m['id'] ?>"
                                                            data-year="<?= htmlspecialchars($m['year']) ?>"
                                                            data-yeartag="<?= htmlspecialchars($m['year_tag']) ?>"
                                                            data-title="<?= htmlspecialchars($m['title']) ?>"
                                                            data-cardtag="<?= htmlspecialchars($m['card_tag']) ?>"
                                                            data-desc="<?= htmlspecialchars($m['description']) ?>"
                                                            data-icon="<?= htmlspecialchars($m['icon'] ?? 'bi-calendar-check') ?>"
                                                            data-sort="<?= $m['sort_order'] ?>"
                                                            data-status="<?= $m['status'] ?>"
                                                            title="Edit Milestone">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                        <a href="manage-about-timeline.php?delete=<?= $m['id'] ?>" class="btn btn-outline-danger btn-sm rounded-2" onclick="return confirm('Delete this milestone entry?');" title="Delete Milestone">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center py-5 text-muted">
                                                    No milestones found. Click "Add Milestone" to create one.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Milestone Modal -->
    <div class="modal fade" id="addMilestoneModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form method="POST">
                    <div class="modal-header bg-white py-3 px-4 border-bottom">
                        <h5 class="modal-title fw-bold" style="color: #103755;">
                            <i class="fa-solid fa-plus-circle text-danger me-2"></i> Add Heritage Milestone
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4 bg-white">
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-bold text-dark mb-1">Year / Timeline Mark <span class="text-danger">*</span></label>
                                <input type="text" name="year" class="form-control" required placeholder="e.g. 1982 or Present">
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold text-dark mb-1">Year Tag / Category</label>
                                <input type="text" name="year_tag" class="form-control" placeholder="e.g. Founding, Sole Agency, Innovation">
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-7">
                                <label class="form-label fw-bold text-dark mb-1">Milestone Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" required placeholder="e.g. Italian Burdizzo Castrators">
                            </div>
                            <div class="col-5">
                                <label class="form-label fw-bold text-dark mb-1">Card Pill Tag</label>
                                <input type="text" name="card_tag" class="form-control" placeholder="e.g. Import Pioneer">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">Milestone Description Narrative</label>
                            <textarea name="description" class="form-control no-ckeditor" rows="3" required placeholder="Historical context, achievements, milestone details..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">Bootstrap Icon Class</label>
                            <input type="text" name="icon" class="form-control" value="bi-calendar-check" placeholder="e.g. bi-calendar-check, bi-award, bi-snow2, bi-gear-wide-connected">
                            <small class="text-muted">Bootstrap 5 icon class (e.g. <code>bi-award</code>, <code>bi-snow2</code>, <code>bi-lightbulb-fill</code>)</small>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label fw-bold text-dark mb-1">Display Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" value="0">
                            </div>
                            <div class="col-6 d-flex align-items-end">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="status" id="addStatus" checked>
                                    <label class="form-check-label fw-bold" for="addStatus">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light py-3 px-4 border-top">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_milestone" class="btn btn-danger rounded-pill px-4 fw-bold">Save Milestone</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Milestone Modal -->
    <div class="modal fade" id="editMilestoneModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form method="POST">
                    <input type="hidden" name="milestone_id" id="editMilestoneId">
                    <div class="modal-header bg-white py-3 px-4 border-bottom">
                        <h5 class="modal-title fw-bold" style="color: #103755;">
                            <i class="fa-solid fa-pen-to-square text-primary me-2"></i> Edit Heritage Milestone
                        </h5>
                        <button type="button" class="btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 bg-white">
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-bold text-dark mb-1">Year / Timeline Mark <span class="text-danger">*</span></label>
                                <input type="text" name="year" id="editYear" class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold text-dark mb-1">Year Tag / Category</label>
                                <input type="text" name="year_tag" id="editYearTag" class="form-control">
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-7">
                                <label class="form-label fw-bold text-dark mb-1">Milestone Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="editTitle" class="form-control" required>
                            </div>
                            <div class="col-5">
                                <label class="form-label fw-bold text-dark mb-1">Card Pill Tag</label>
                                <input type="text" name="card_tag" id="editCardTag" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">Milestone Description Narrative</label>
                            <textarea name="description" id="editDesc" class="form-control no-ckeditor" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">Bootstrap Icon Class</label>
                            <input type="text" name="icon" id="editIcon" class="form-control">
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label fw-bold text-dark mb-1">Display Sort Order</label>
                                <input type="number" name="sort_order" id="editSort" class="form-control">
                            </div>
                            <div class="col-6 d-flex align-items-end">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="status" id="editStatus">
                                    <label class="form-check-label fw-bold" for="editStatus">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light py-3 px-4 border-top">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="edit_milestone" class="btn btn-primary rounded-pill px-4 fw-bold">Update Milestone</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/js/apps.min.js"></script>
    <script>
        $(document).ready(function() {
            if (typeof App !== 'undefined' && typeof App.init === 'function') {
                try { App.init(); } catch(e) { console.warn('App.init:', e); }
            }

            function populateMilestoneModal(btn) {
                if (!btn || !btn.length) return;
                var id = btn.attr('data-id') || btn.data('id');
                var year = btn.attr('data-year') || btn.data('year');
                var yeartag = btn.attr('data-yeartag') || btn.data('yeartag');
                var title = btn.attr('data-title') || btn.data('title');
                var cardtag = btn.attr('data-cardtag') || btn.data('cardtag');
                var desc = btn.attr('data-desc') || btn.data('desc');
                var icon = btn.attr('data-icon') || btn.data('icon');
                var sort = btn.attr('data-sort') || btn.data('sort');
                var status = btn.attr('data-status') || btn.data('status');

                $('#editMilestoneId').val(id);
                $('#editYear').val(year);
                $('#editYearTag').val(yeartag);
                $('#editTitle').val(title);
                $('#editCardTag').val(cardtag);
                $('#editDesc').val(desc);
                $('#editIcon').val(icon);
                $('#editSort').val(sort);
                $('#editStatus').prop('checked', status == 1 || status == '1');
            }

            $(document).on('click', '.edit-milestone-btn', function(e) {
                var btn = $(this).closest('.edit-milestone-btn');
                populateMilestoneModal(btn);

                if (typeof $.fn.modal !== 'undefined') {
                    $('#editMilestoneModal').modal('show');
                } else if (typeof bootstrap !== 'undefined' && typeof bootstrap.Modal !== 'undefined') {
                    var modal = bootstrap.Modal.getInstance(document.getElementById('editMilestoneModal')) || new bootstrap.Modal(document.getElementById('editMilestoneModal'));
                    modal.show();
                } else {
                    $('#editMilestoneModal').show().addClass('show');
                }
            });

            $('#editMilestoneModal').on('show.bs.modal', function(e) {
                var btn = $(e.relatedTarget);
                if (btn && btn.length) {
                    populateMilestoneModal(btn);
                }
            });
        });
    </script>
</body>
</html>
