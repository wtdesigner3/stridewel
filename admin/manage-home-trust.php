<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// 1. Handle Status Toggle
if (isset($_GET['toggle_status']) && isset($_GET['id'])) {
    $tid = (int)$_GET['id'];
    $cur = (int)$_GET['toggle_status'];
    $new_st = ($cur == 1) ? 0 : 1;
    mysqli_query($conn, "UPDATE `tbl_home_trust` SET `status`=$new_st WHERE `id`=$tid");
    header("Location: manage-home-trust.php?msg=" . urlencode("Status updated successfully"));
    exit;
}

// 2. Handle Delete
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM `tbl_home_trust` WHERE `id`=$del_id");
    header("Location: manage-home-trust.php?msg=" . urlencode("Trust bar item deleted successfully"));
    exit;
}

// 3. Handle Add New Item
if (isset($_POST['add_trust_item'])) {
    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $subtitle = mysqli_real_escape_string($conn, trim($_POST['subtitle']));
    $icon = mysqli_real_escape_string($conn, trim($_POST['icon']));
    $sort = (int)($_POST['sort_order'] ?? 0);
    $status = isset($_POST['status']) ? 1 : 0;

    if (!empty($title)) {
        $ins = mysqli_query($conn, "INSERT INTO `tbl_home_trust` (`title`, `subtitle`, `icon`, `sort_order`, `status`) VALUES ('$title', '$subtitle', '$icon', $sort, $status)");
        if ($ins) {
            $msg = "Trust item '$title' added successfully!";
        } else {
            $error = "Failed to add item: " . mysqli_error($conn);
        }
    } else {
        $error = "Title is required.";
    }
}

// 4. Handle Edit Item
if (isset($_POST['edit_trust_item'])) {
    $eid = (int)$_POST['item_id'];
    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $subtitle = mysqli_real_escape_string($conn, trim($_POST['subtitle']));
    $icon = mysqli_real_escape_string($conn, trim($_POST['icon']));
    $sort = (int)($_POST['sort_order'] ?? 0);
    $status = isset($_POST['status']) ? 1 : 0;

    if (!empty($title)) {
        $upd = mysqli_query($conn, "UPDATE `tbl_home_trust` SET `title`='$title', `subtitle`='$subtitle', `icon`='$icon', `sort_order`=$sort, `status`=$status WHERE `id`=$eid");
        if ($upd) {
            $msg = "Trust item '$title' updated successfully!";
        } else {
            $error = "Failed to update item: " . mysqli_error($conn);
        }
    } else {
        $error = "Title is required.";
    }
}

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}

// Fetch all trust items
$items = [];
$q = mysqli_query($conn, "SELECT * FROM `tbl_home_trust` ORDER BY `sort_order` ASC, `id` ASC");
if ($q) {
    while ($row = mysqli_fetch_assoc($q)) {
        $items[] = $row;
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
                        ISO 9001:2015 Quality Trust Bar
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 13.5px;">
                        Manage the 4 dark quality assurance highlights displayed directly beneath the homepage hero slider.
                    </p>
                </div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="manage-home-hero.php">Home Page CMS</a></li>
                    <li class="breadcrumb-item active">Quality Trust Bar</li>
                </ol>
            </div>

            <!-- Quick Sub-Menu Switcher Pills -->
            <div class="cms-subnav-strip mb-4">
                <a href="manage-home-hero.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-images"></i> Hero Banner
                </a>
                <a href="manage-home-trust.php" class="cms-subnav-pill active">
                    <i class="fa-solid fa-shield-halved"></i> Quality Trust Bar
                </a>
                <a href="manage-about-story.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-building"></i> Company Overview
                </a>
                <a href="manage-categories.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-boxes-stacked"></i> Categories
                </a>
                <a href="manage-home-why.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-award"></i> Why Choose Stridewel
                </a>
                <a href="manage-home-pipeline.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-industry"></i> Manufacturing Pipeline
                </a>
                <a href="manage-faq.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-circle-question"></i> FAQs
                </a>
                <a href="manage-testimonial.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-comments"></i> Testimonials
                </a>
                <a href="../index.php" target="_blank" class="cms-subnav-pill cms-subnav-preview">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Live Homepage
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

            <!-- Live Dark Bar Visual Preview Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: #091724 !important; color: #ffffff !important;">
                <div class="card-body p-4" style="background: #091724 !important;">
                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2" style="border-color: rgba(255,255,255,0.12) !important;">
                        <span style="font-size: 11px; font-weight: 800; letter-spacing: 1px; color: #ff333a !important; text-transform: uppercase;">
                            <i class="fa-solid fa-eye me-1"></i> Live Frontend Trust Bar Preview
                        </span>
                        <span style="color: #94a3b8 !important; font-size: 12px;">Full-width dark ribbon under hero</span>
                    </div>
                    <div class="row g-3">
                        <?php foreach ($items as $it): if ($it['status'] != 1) continue; ?>
                        <div class="col-lg-3 col-md-6">
                            <div class="d-flex align-items-center gap-3 p-2.5 rounded-3" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);">
                                <div style="color: #ff333a !important; font-size: 26px; min-width: 34px; text-align: center;">
                                    <i class="bi <?= htmlspecialchars($it['icon'] ?? 'bi-patch-check-fill') ?>"></i>
                                </div>
                                <div style="line-height: 1.35;">
                                    <div style="font-weight: 700; font-size: 13.5px; color: #ffffff !important;"><?= htmlspecialchars($it['title']) ?></div>
                                    <div style="font-size: 12px; color: #cbd5e1 !important;"><?= htmlspecialchars($it['subtitle']) ?></div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Main Management Card -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h5 class="mb-0 fw-bold" style="color: #103755;">
                        <i class="fa-solid fa-shield-halved text-danger me-2"></i> Quality Trust Bar Items (<?= count($items) ?>)
                    </h5>
                    <button type="button" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold shadow-sm" data-toggle="modal" data-target="#addTrustModal" data-bs-toggle="modal" data-bs-target="#addTrustModal">
                        <i class="fa-solid fa-plus me-1"></i> Add New Trust Item
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                                <tr>
                                    <th class="ps-4" style="width: 70px;">Order</th>
                                    <th style="width: 80px;">Icon</th>
                                    <th>Primary Title</th>
                                    <th>Secondary Description</th>
                                    <th style="width: 120px;">Status</th>
                                    <th class="text-end pe-4" style="width: 140px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($items)): ?>
                                    <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <span class="badge bg-light text-dark border px-2 py-1 fw-bold"><?= $item['sort_order'] ?></span>
                                        </td>
                                        <td>
                                            <div class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: #091724; color: #ed1c24; font-size: 20px;">
                                                <i class="bi <?= htmlspecialchars($item['icon']) ?>"></i>
                                            </div>
                                        </td>
                                        <td>
                                            <strong class="text-dark" style="font-size: 14.5px;"><?= htmlspecialchars($item['title']) ?></strong>
                                        </td>
                                        <td>
                                            <span class="text-muted" style="font-size: 13.5px;"><?= htmlspecialchars($item['subtitle']) ?></span>
                                        </td>
                                        <td>
                                            <?php if ($item['status'] == 1): ?>
                                                <a href="manage-home-trust.php?toggle_status=1&id=<?= $item['id'] ?>" class="badge bg-success-subtle text-success border border-success-subtle text-decoration-none px-2.5 py-1.5 rounded-pill fw-bold" title="Click to Deactivate">
                                                    <i class="fa-solid fa-circle-check me-1"></i> Active
                                                </a>
                                            <?php else: ?>
                                                <a href="manage-home-trust.php?toggle_status=0&id=<?= $item['id'] ?>" class="badge bg-secondary-subtle text-secondary border border-secondary-subtle text-decoration-none px-2.5 py-1.5 rounded-pill fw-bold" title="Click to Activate">
                                                    <i class="fa-solid fa-circle-xmark me-1"></i> Hidden
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-outline-primary btn-sm rounded-2 me-1 edit-btn" 
                                                    data-toggle="modal"
                                                    data-target="#editTrustModal"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editTrustModal"
                                                    data-id="<?= $item['id'] ?>"
                                                    data-title="<?= htmlspecialchars($item['title']) ?>"
                                                    data-subtitle="<?= htmlspecialchars($item['subtitle']) ?>"
                                                    data-icon="<?= htmlspecialchars($item['icon']) ?>"
                                                    data-sort="<?= $item['sort_order'] ?>"
                                                    data-status="<?= $item['status'] ?>"
                                                    title="Edit Item">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <a href="manage-home-trust.php?delete=<?= $item['id'] ?>" class="btn btn-outline-danger btn-sm rounded-2" onclick="return confirm('Are you sure you want to delete this trust bar item?');" title="Delete Item">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-circle-info fs-3 d-block mb-2"></i>
                                            No trust items found. Click "Add New Trust Item" to create one.
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

    <!-- Add Item Modal -->
    <div class="modal fade" id="addTrustModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form method="POST" action="manage-home-trust.php">
                    <div class="modal-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="modal-title fw-bold" style="color: #103755;">
                            <i class="fa-solid fa-plus-circle text-danger me-2"></i> Add Trust Bar Item
                        </h5>
                        <button type="button" class="close btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="background: none; border: none; font-size: 24px; line-height: 1; cursor: pointer;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4 bg-white">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">Primary Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required placeholder="e.g. ISO 9001:2015 Certified">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">Subtitle / Facility Location</label>
                            <input type="text" name="subtitle" class="form-control" placeholder="e.g. QMS Certified Facility in New Delhi">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">Bootstrap Icon Class</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-patch-check-fill"></i></span>
                                <input type="text" name="icon" class="form-control" value="bi-patch-check-fill" placeholder="e.g. bi-shield-check, bi-box-seam, bi-globe2">
                            </div>
                            <small class="text-muted">Icons: <code>bi-patch-check-fill</code>, <code>bi-shield-check</code>, <code>bi-box-seam</code>, <code>bi-globe2</code>, <code>bi-award-fill</code></small>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label fw-bold text-dark mb-1">Display Order</label>
                                <input type="number" name="sort_order" class="form-control" value="0">
                            </div>
                            <div class="col-6 d-flex align-items-end">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="status" id="addStatus" value="1" checked>
                                    <label class="form-check-label fw-bold" for="addStatus">Active Status</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light py-3 px-4 border-top">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-dismiss="modal" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_trust_item" class="btn btn-danger rounded-pill px-4 fw-bold">Save Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Item Modal -->
    <div class="modal fade" id="editTrustModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form method="POST" action="manage-home-trust.php">
                    <input type="hidden" name="item_id" id="editItemId">
                    <div class="modal-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="modal-title fw-bold" style="color: #103755;">
                            <i class="fa-solid fa-pen-to-square text-primary me-2"></i> Edit Trust Bar Item
                        </h5>
                        <button type="button" class="close btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="background: none; border: none; font-size: 24px; line-height: 1; cursor: pointer;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4 bg-white">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">Primary Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="editTitle" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">Subtitle / Facility Location</label>
                            <input type="text" name="subtitle" id="editSubtitle" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">Bootstrap Icon Class</label>
                            <input type="text" name="icon" id="editIcon" class="form-control">
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label fw-bold text-dark mb-1">Display Order</label>
                                <input type="number" name="sort_order" id="editSort" class="form-control">
                            </div>
                            <div class="col-6 d-flex align-items-end">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="status" id="editStatus" value="1">
                                    <label class="form-check-label fw-bold" for="editStatus">Active Status</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light py-3 px-4 border-top">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-dismiss="modal" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="edit_trust_item" class="btn btn-primary rounded-pill px-4 fw-bold">Update Item</button>
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
                App.init();
            }

            $(document).on('click', '.edit-btn', function(e) {
                e.preventDefault();
                var id = $(this).attr('data-id') || $(this).data('id');
                var title = $(this).attr('data-title') || $(this).data('title');
                var subtitle = $(this).attr('data-subtitle') || $(this).data('subtitle');
                var icon = $(this).attr('data-icon') || $(this).data('icon');
                var sort = $(this).attr('data-sort') || $(this).data('sort');
                var status = $(this).attr('data-status') || $(this).data('status');

                $('#editItemId').val(id);
                $('#editTitle').val(title);
                $('#editSubtitle').val(subtitle);
                $('#editIcon').val(icon);
                $('#editSort').val(sort);
                $('#editStatus').prop('checked', status == 1 || status == '1');

                if (typeof $.fn.modal !== 'undefined') {
                    $('#editTrustModal').modal('show');
                } else if (typeof bootstrap !== 'undefined' && typeof bootstrap.Modal !== 'undefined') {
                    var m = bootstrap.Modal.getInstance(document.getElementById('editTrustModal')) || new bootstrap.Modal(document.getElementById('editTrustModal'));
                    m.show();
                } else {
                    $('#editTrustModal').show().addClass('show');
                }
            });
        });
    </script>
</body>
</html>
