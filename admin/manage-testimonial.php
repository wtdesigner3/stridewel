<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// Ensure upload directory exists
$upload_dir = __DIR__ . '/../uploads/testimonials/';
if (!is_dir($upload_dir)) {
    @mkdir($upload_dir, 0777, true);
}

// 1. Handle Status Toggle via GET
if (isset($_GET['toggle_id'])) {
    $tid = (int)$_GET['toggle_id'];
    $cur = (int)$_GET['status'];
    $new_status = ($cur == 1) ? 0 : 1;
    mysqli_query($conn, "UPDATE `tbl_testimonial` SET `tt_status`='$new_status' WHERE `tt_id`='$tid'");
    header("Location: manage-testimonial.php?msg=" . urlencode("Review status updated."));
    exit;
}

// 2. Handle Delete Testimonial
if (isset($_GET['del_id'])) {
    $did = (int)$_GET['del_id'];
    mysqli_query($conn, "DELETE FROM `tbl_testimonial` WHERE `tt_id`='$did'");
    header("Location: manage-testimonial.php?msg=" . urlencode("Review removed successfully."));
    exit;
}

// 3. Handle Batch Actions
if (isset($_POST['batch_action']) && !empty($_POST['selected_ids'])) {
    $action = $_POST['batch_action'];
    $ids = array_map('intval', $_POST['selected_ids']);
    $id_list = implode(',', $ids);

    if ($action === 'activate') {
        mysqli_query($conn, "UPDATE `tbl_testimonial` SET `tt_status`=1 WHERE `tt_id` IN ($id_list)");
        $msg = count($ids) . " review(s) activated successfully.";
    } elseif ($action === 'deactivate') {
        mysqli_query($conn, "UPDATE `tbl_testimonial` SET `tt_status`=0 WHERE `tt_id` IN ($id_list)");
        $msg = count($ids) . " review(s) deactivated successfully.";
    } elseif ($action === 'delete') {
        mysqli_query($conn, "DELETE FROM `tbl_testimonial` WHERE `tt_id` IN ($id_list)");
        $msg = count($ids) . " review(s) deleted permanently.";
    }
}

// 4. Handle Add Testimonial
if (isset($_POST['add_testimonial'])) {
    $name = mysqli_real_escape_string($conn, trim($_POST['tt_name'] ?? ''));
    $location = mysqli_real_escape_string($conn, trim($_POST['tt_location'] ?? ''));
    $rating = (int)($_POST['tt_rating'] ?? 5);
    $detail = mysqli_real_escape_string($conn, trim($_POST['tt_detail'] ?? ''));
    $sort = (int)($_POST['tt_sort'] ?? 0);
    $status = isset($_POST['tt_status']) ? 1 : 0;
    $photo = 'assets/img/user-avatar.png';

    if (!empty($_FILES['tt_image']['name']) && $_FILES['tt_image']['error'] == 0) {
        $ext = pathinfo($_FILES['tt_image']['name'], PATHINFO_EXTENSION);
        $new_name = "client_" . time() . "_" . rand(1000, 9999) . "." . $ext;
        if (move_uploaded_file($_FILES['tt_image']['tmp_name'], $upload_dir . $new_name)) {
            $photo = "uploads/testimonials/" . $new_name;
        }
    }

    if (empty($name)) {
        $error = "Please provide client/importer name.";
    } else {
        $ins = mysqli_query($conn, "INSERT INTO `tbl_testimonial` 
            (`tt_name`, `tt_location`, `tt_rating`, `tt_detail`, `tt_image`, `tt_sort`, `tt_status`) 
            VALUES ('$name', '$location', '$rating', '$detail', '$photo', '$sort', '$status')");

        if ($ins) {
            $msg = "New client review added successfully!";
        } else {
            $error = "Failed to add review: " . mysqli_error($conn);
        }
    }
}

// 5. Handle Edit Testimonial
if (isset($_POST['edit_testimonial'])) {
    $eid = (int)$_POST['testimonial_id'];
    $name = mysqli_real_escape_string($conn, trim($_POST['tt_name'] ?? ''));
    $location = mysqli_real_escape_string($conn, trim($_POST['tt_location'] ?? ''));
    $rating = (int)($_POST['tt_rating'] ?? 5);
    $detail = mysqli_real_escape_string($conn, trim($_POST['tt_detail'] ?? ''));
    $sort = (int)($_POST['tt_sort'] ?? 0);
    $status = isset($_POST['tt_status']) ? 1 : 0;

    $cur_photo_q = mysqli_query($conn, "SELECT `tt_image` FROM `tbl_testimonial` WHERE `tt_id`='$eid'");
    $cur_photo = mysqli_fetch_assoc($cur_photo_q)['tt_image'] ?? 'assets/img/user-avatar.png';
    $photo = $cur_photo;

    if (!empty($_FILES['tt_image']['name']) && $_FILES['tt_image']['error'] == 0) {
        $ext = pathinfo($_FILES['tt_image']['name'], PATHINFO_EXTENSION);
        $new_name = "client_" . time() . "_" . rand(1000, 9999) . "." . $ext;
        if (move_uploaded_file($_FILES['tt_image']['tmp_name'], $upload_dir . $new_name)) {
            $photo = "uploads/testimonials/" . $new_name;
        }
    }

    if (empty($name)) {
        $error = "Please provide client/importer name.";
    } else {
        $upd = mysqli_query($conn, "UPDATE `tbl_testimonial` SET 
            `tt_name`='$name', `tt_location`='$location', `tt_rating`='$rating',
            `tt_detail`='$detail', `tt_image`='$photo',
            `tt_sort`='$sort', `tt_status`='$status'
            WHERE `tt_id`='$eid'");

        if ($upd) {
            $msg = "Review updated successfully!";
        } else {
            $error = "Failed to update review: " . mysqli_error($conn);
        }
    }
}

// Check GET msg
if (isset($_GET['msg'])) {
    $msg = htmlspecialchars($_GET['msg']);
}

// Fetch Testimonials
$testimonials = mysqli_query($conn, "SELECT * FROM `tbl_testimonial` ORDER BY `tt_sort` ASC, `tt_id` DESC");
$cnt_all = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as c FROM `tbl_testimonial`"))['c'] ?? 0;
$cnt_active = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as c FROM `tbl_testimonial` WHERE `tt_status`=1"))['c'] ?? 0;
$cnt_disabled = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as c FROM `tbl_testimonial` WHERE `tt_status`=0"))['c'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<?php require('includes/head.php'); ?>
<body>
    <div id="page-container" class="page-sidebar-fixed page-header-fixed show">
        <?php require('includes/header.php'); ?>
        <?php require('includes/left.php'); ?>
        
        <div id="content" class="content">
            <!-- Header Bar -->
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 pb-2 border-bottom">
                <div>
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Client Reviews</li>
                    </ol>
                    <h1 class="page-header mb-0">
                        <i class="fa-solid fa-star text-warning me-2"></i> Client Reviews &amp; Testimonials CMS
                    </h1>
                </div>
                <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                    <button type="button" class="btn btn-warning fw-bold shadow-sm px-3" data-toggle="modal" data-target="#addModal" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fa-solid fa-plus-circle me-1"></i> Add New Testimonial
                    </button>
                    <a href="../index.php" target="_blank" class="btn btn-outline-success btn-sm px-3">
                        <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Live Site
                    </a>
                </div>
            </div>

            <!-- Alerts -->
            <?php if (!empty($msg)): ?>
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4 shadow-sm" role="alert">
                    <i class="fa-solid fa-circle-check fs-4 me-3 text-success"></i>
                    <div><strong>Success!</strong> <?= htmlspecialchars($msg) ?></div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4 shadow-sm" role="alert">
                    <i class="fa-solid fa-triangle-exclamation fs-4 me-3 text-danger"></i>
                    <div><strong>Error!</strong> <?= htmlspecialchars($error) ?></div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Filter Pills & Search Box (Consistent with manage-products and manage-blogs) -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                <div class="cms-subnav-strip mb-0">
                    <a href="javascript:void(0)" class="cms-subnav-pill active filter-tab" data-filter="all">
                        All Endorsements (<?= $cnt_all ?>)
                    </a>
                    <a href="javascript:void(0)" class="cms-subnav-pill filter-tab" data-filter="active">
                        <i class="fa-solid fa-check text-success me-1"></i> Active (<?= $cnt_active ?>)
                    </a>
                    <a href="javascript:void(0)" class="cms-subnav-pill filter-tab" data-filter="disabled">
                        <i class="fa-solid fa-ban text-muted me-1"></i> Disabled (<?= $cnt_disabled ?>)
                    </a>
                </div>

                <div class="search-filter-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="testiSearchInput" class="form-control" placeholder="Search client, role, location, review...">
                </div>
            </div>

            <!-- Table CRUD Card Container -->
            <div class="table-crud-card">
                <form method="POST" id="testiBatchForm">
                    <div class="table-responsive">
                        <table class="table table-crud-table align-middle" id="testiTable">
                            <thead>
                                <tr>
                                    <th style="width: 48px; text-align: center;">
                                        <input type="checkbox" id="selectAllReviews" class="crud-checkbox" title="Select All">
                                    </th>
                                    <th style="width: 60px; text-align: center;">AVATAR</th>
                                    <th style="width: 200px;">CLIENT &amp; IMPORTER</th>
                                    <th style="width: 220px;">ROLE &amp; LOCATION / PORT</th>
                                    <th style="width: 120px;">RATING</th>
                                    <th>REVIEW ENDORSEMENT</th>
                                    <th style="width: 80px; text-align: center;">SORT</th>
                                    <th style="width: 90px; text-align: center;">STATUS</th>
                                    <th style="width: 110px; text-align: end;">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody id="testiTableBody">
                                <?php if (mysqli_num_rows($testimonials) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($testimonials)): ?>
                                        <tr class="testi-row"
                                            data-id="<?= $row['tt_id'] ?>"
                                            data-sort="<?= (int)$row['tt_sort'] ?>"
                                            data-rating="<?= (int)$row['tt_rating'] ?>"
                                            data-status="<?= (int)$row['tt_status'] ?>"
                                            data-name="<?= strtolower(htmlspecialchars($row['tt_name'])) ?>"
                                            data-location="<?= strtolower(htmlspecialchars($row['tt_location'])) ?>"
                                            data-detail="<?= strtolower(htmlspecialchars($row['tt_detail'])) ?>">
                                            
                                            <!-- Checkbox -->
                                            <td style="text-align: center;">
                                                <input type="checkbox" name="selected_ids[]" value="<?= $row['tt_id'] ?>" class="crud-checkbox row-select-cb">
                                            </td>

                                            <!-- Avatar / Photo -->
                                            <td style="text-align: center;">
                                                <?php if (!empty($row['tt_image']) && file_exists('../../' . $row['tt_image'])): ?>
                                                    <div class="table-thumb-box mx-auto" style="width: 40px; height: 40px; border-radius: 50%;">
                                                        <img src="../../<?= htmlspecialchars($row['tt_image']) ?>" alt="Client">
                                                    </div>
                                                <?php else: ?>
                                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-secondary border fw-bold mx-auto" style="width: 40px; height: 40px; font-size: 14px;">
                                                        <?= strtoupper(substr($row['tt_name'], 0, 1)) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>

                                            <!-- Client Name -->
                                            <td>
                                                <div class="fw-bold text-dark fs-6"><?= htmlspecialchars($row['tt_name']) ?></div>
                                                <small class="text-muted"><i class="fa-solid fa-building-user me-1 text-muted"></i>Verified Buyer</small>
                                            </td>

                                            <!-- Role & Location / Port -->
                                            <td>
                                                <div class="text-dark small fw-semibold text-truncate" style="max-width: 210px;" title="<?= htmlspecialchars($row['tt_location']) ?>">
                                                    <i class="fa-solid fa-earth-americas me-1 text-info"></i> <?= htmlspecialchars($row['tt_location']) ?>
                                                </div>
                                            </td>

                                            <!-- Rating Stars -->
                                            <td>
                                                <div class="d-flex align-items-center gap-1 text-warning">
                                                    <?php 
                                                    $r = isset($row['tt_rating']) ? (int)$row['tt_rating'] : 5;
                                                    for ($i = 1; $i <= 5; $i++): 
                                                    ?>
                                                        <i class="fa-<?= ($i <= $r) ? 'solid' : 'regular' ?> fa-star" style="font-size: 11px;"></i>
                                                    <?php endfor; ?>
                                                </div>
                                                <small class="text-muted" style="font-size: 11px;"><?= $r ?>.0 / 5.0 Rating</small>
                                            </td>

                                            <!-- Review Snippet -->
                                            <td>
                                                <div class="text-truncate text-muted small" style="max-width: 320px;" title="<?= htmlspecialchars($row['tt_detail']) ?>">
                                                    &ldquo;<?= htmlspecialchars($row['tt_detail']) ?>&rdquo;
                                                </div>
                                            </td>

                                            <!-- Sort Order -->
                                            <td style="text-align: center;">
                                                <span class="table-sort-badge">
                                                    <?= (int)$row['tt_sort'] ?>
                                                </span>
                                            </td>

                                            <!-- Interactive Status Toggle Switch -->
                                            <td style="text-align: center;">
                                                <label class="status-switch-wrapper switch-emerald" title="Click to toggle active status">
                                                    <input type="checkbox" 
                                                           class="status-toggle-switch" 
                                                           data-id="<?= $row['tt_id'] ?>" 
                                                           data-table="tbl_testimonial" 
                                                           data-field="tt_status" 
                                                           <?= $row['tt_status'] == 1 ? 'checked' : '' ?>>
                                                    <span class="status-switch-slider"></span>
                                                </label>
                                            </td>

                                            <!-- Action Buttons -->
                                            <td style="text-align: end;">
                                                <div class="d-inline-flex gap-1 justify-content-end">
                                                    <button type="button" class="btn-action-square btn-action-edit" data-toggle="modal" data-target="#editModal<?= $row['tt_id'] ?>" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['tt_id'] ?>" title="Edit Review">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </button>
                                                    <a href="manage-testimonial.php?del_id=<?= $row['tt_id'] ?>" onclick="return confirm('Are you sure you want to delete this testimonial?');" class="btn-action-square btn-action-delete" title="Delete Review">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal for this Testimonial -->
                                        <div class="modal fade" id="editModal<?= $row['tt_id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                                    <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #123023 0%, #1B4533 100%);">
                                                        <h5 class="modal-title fw-bold" style="color: #FFFFFF !important;">
                                                            <i class="fa-solid fa-pen-to-square text-warning me-2"></i> Edit Client Review #<?= $row['tt_id'] ?>
                                                        </h5>
                                                        <button type="button" class="modal-close-btn" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="POST" enctype="multipart/form-data">
                                                        <input type="hidden" name="testimonial_id" value="<?= $row['tt_id'] ?>">
                                                        <div class="modal-body p-4">
                                                            <div class="row g-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Client / Importer Name <span class="text-danger">*</span></label>
                                                                    <input type="text" name="tt_name" class="form-control" value="<?= htmlspecialchars($row['tt_name']) ?>" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Role, Company &amp; Location / Port <span class="text-danger">*</span></label>
                                                                    <input type="text" name="tt_location" class="form-control" value="<?= htmlspecialchars($row['tt_location']) ?>" placeholder="e.g. Managing Director, Alpine Roastworks (Hamburg, Germany)" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label fw-bold">Star Rating</label>
                                                                    <select name="tt_rating" class="form-select">
                                                                        <option value="5" <?= ($row['tt_rating'] == 5) ? 'selected' : '' ?>>⭐⭐⭐⭐⭐ (5 Stars - Exceptional)</option>
                                                                        <option value="4" <?= ($row['tt_rating'] == 4) ? 'selected' : '' ?>>⭐⭐⭐⭐ (4 Stars - Highly Satisfied)</option>
                                                                        <option value="3" <?= ($row['tt_rating'] == 3) ? 'selected' : '' ?>>⭐⭐⭐ (3 Stars - Satisfied)</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label fw-bold">Display Sort Order</label>
                                                                    <input type="number" name="tt_sort" class="form-control" value="<?= (int)$row['tt_sort'] ?>">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label fw-bold">Active Status</label>
                                                                    <div class="form-check form-switch mt-2">
                                                                        <input class="form-check-input" type="checkbox" role="switch" id="edit_status_<?= $row['tt_id'] ?>" name="tt_status" value="1" <?= ($row['tt_status'] == 1) ? 'checked' : '' ?> style="cursor: pointer; transform: scale(1.2);">
                                                                        <label class="form-check-label ms-2 fw-semibold" for="edit_status_<?= $row['tt_id'] ?>">Published Live</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label class="form-label fw-bold">Client Photo / Corporate Logo (Optional)</label>
                                                                    <div class="d-flex align-items-center gap-3">
                                                                        <?php if (!empty($row['tt_image']) && file_exists('../../' . $row['tt_image'])): ?>
                                                                            <img src="../../<?= htmlspecialchars($row['tt_image']) ?>" alt="" style="width: 44px; height: 44px; object-fit: cover; border-radius: 50%; border: 1px solid #ddd;">
                                                                        <?php endif; ?>
                                                                        <input type="file" name="tt_image" class="form-control" accept="image/*">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label class="form-label fw-bold">Review Endorsement / Testimonial Text <span class="text-danger">*</span></label>
                                                                    <textarea name="tt_detail" class="form-control no-ckeditor" rows="4" placeholder="Enter the complete endorsement quote from the client..." required><?= htmlspecialchars($row['tt_detail']) ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer bg-light px-4 py-3 d-flex justify-content-between">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" name="edit_testimonial" class="btn btn-warning fw-bold px-4 shadow-sm">
                                                                <i class="fa-solid fa-floppy-disk me-1"></i> Save Changes
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-star fa-3x mb-3 d-block text-muted"></i>
                                            No client testimonials found.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Floating Batch Actions Toolbar -->
                    <div class="batch-actions-floating-bar" id="batchActionBar">
                        <span class="batch-selected-badge" id="selectedCountBadge">0 selected</span>
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" name="batch_action" value="activate" class="btn btn-batch-activate">
                                <i class="fa-solid fa-check me-1"></i> Activate
                            </button>
                            <button type="submit" name="batch_action" value="deactivate" class="btn btn-batch-deactivate">
                                <i class="fa-solid fa-ban me-1"></i> Deactivate
                            </button>
                            <button type="submit" name="batch_action" value="delete" class="btn btn-batch-delete" onclick="return confirm('Are you sure you want to delete all selected reviews?');">
                                <i class="fa-solid fa-trash me-1"></i> Delete
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <?php require('includes/footer.php'); ?>
    </div>

    <!-- Add New Testimonial Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #123023 0%, #1B4533 100%);">
                    <h5 class="modal-title fw-bold" style="color: #FFFFFF !important;">
                        <i class="fa-solid fa-plus-circle text-warning me-2"></i> Add New Client Review / Endorsement
                    </h5>
                    <button type="button" class="modal-close-btn" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="manage-testimonial.php" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Client / Importer Name <span class="text-danger">*</span></label>
                                <input type="text" name="tt_name" class="form-control" placeholder="e.g. Marcus Vance" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Role, Company &amp; Location / Port <span class="text-danger">*</span></label>
                                <input type="text" name="tt_location" class="form-control" placeholder="e.g. Managing Director, Alpine Roastworks (Hamburg, Germany)" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Star Rating</label>
                                <select name="tt_rating" class="form-select">
                                    <option value="5" selected>⭐⭐⭐⭐⭐ (5 Stars - Exceptional)</option>
                                    <option value="4">⭐⭐⭐⭐ (4 Stars - Highly Satisfied)</option>
                                    <option value="3">⭐⭐⭐ (3 Stars - Satisfied)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Display Sort Order</label>
                                <input type="number" name="tt_sort" class="form-control" value="0">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Active Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" role="switch" id="add_status" name="tt_status" value="1" checked style="cursor: pointer; transform: scale(1.2);">
                                    <label class="form-check-label ms-2 fw-semibold" for="add_status">Published Live</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Client Photo / Corporate Logo (Optional)</label>
                                <input type="file" name="tt_image" class="form-control" accept="image/*">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Review Endorsement / Testimonial Text <span class="text-danger">*</span></label>
                                <textarea name="tt_detail" class="form-control no-ckeditor" rows="4" placeholder="Enter the complete endorsement quote from the client..." required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light px-4 py-3 d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_testimonial" class="btn btn-warning fw-bold px-4 shadow-sm">
                            <i class="fa-solid fa-plus-circle me-1"></i> Add Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Toast Container for AJAX toggles -->
    <div class="crud-toast-container">
        <div id="crudToast" class="crud-toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
                <i id="crudToastIcon" class="fa-solid fa-circle-check text-success fs-5"></i>
                <span id="crudToastMessage">Status updated</span>
            </div>
            <button type="button" class="toast-close-btn" onclick="document.getElementById('crudToast').classList.remove('show');" aria-label="Close">&times;</button>
        </div>
    </div>

    <!-- Scripts -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('testiSearchInput');
        const selectAll = document.getElementById('selectAllReviews');
        const rowCheckboxes = document.querySelectorAll('.row-select-cb');
        const batchBar = document.getElementById('batchActionBar');
        const countBadge = document.getElementById('selectedCountBadge');
        const toastEl = document.getElementById('crudToast');
        const toastMessage = document.getElementById('crudToastMessage');
        const toastIcon = document.getElementById('crudToastIcon');
        const toast = (toastEl && typeof bootstrap !== 'undefined' && bootstrap.Toast) ? new bootstrap.Toast(toastEl, { delay: 3000 }) : null;
        const filterTabs = document.querySelectorAll('.filter-tab');

        let currentFilter = 'all';

        // Filter tabs logic
        filterTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                filterTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                currentFilter = this.getAttribute('data-filter');
                applyFilters();
            });
        });

        // Multi-select & Batch Bar update
        function updateBatchBar() {
            const checkedBoxes = document.querySelectorAll('.row-select-cb:checked');
            const count = checkedBoxes.length;
            if (count > 0) {
                if (countBadge) countBadge.textContent = count + ' selected';
                if (batchBar) batchBar.classList.add('show');
            } else {
                if (batchBar) batchBar.classList.remove('show');
            }

            rowCheckboxes.forEach(cb => {
                const tr = cb.closest('tr');
                if (tr) {
                    if (cb.checked) tr.classList.add('row-selected');
                    else tr.classList.remove('row-selected');
                }
            });

            if (selectAll) {
                const totalVisible = document.querySelectorAll('.testi-row:not([style*="display: none"]) .row-select-cb').length;
                const checkedVisible = document.querySelectorAll('.testi-row:not([style*="display: none"]) .row-select-cb:checked').length;
                selectAll.checked = (totalVisible > 0 && totalVisible === checkedVisible);
            }
        }

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                const isChecked = this.checked;
                rowCheckboxes.forEach(cb => {
                    const row = cb.closest('tr');
                    if (row && row.style.display !== 'none') {
                        cb.checked = isChecked;
                    }
                });
                updateBatchBar();
            });
        }

        rowCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateBatchBar);
        });

        // Filter and Search Unified Logic
        function applyFilters() {
            const q = searchInput ? searchInput.value.toLowerCase().trim() : '';
            const rows = document.querySelectorAll('.testi-row');

            rows.forEach(row => {
                const name = row.getAttribute('data-name') || '';
                const loc = row.getAttribute('data-location') || '';
                const detail = row.getAttribute('data-detail') || '';
                const status = row.getAttribute('data-status');

                const matchesSearch = (name.includes(q) || loc.includes(q) || detail.includes(q));
                let matchesStatus = true;
                if (currentFilter === 'active') matchesStatus = (status === '1');
                else if (currentFilter === 'disabled') matchesStatus = (status === '0');

                if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                    const cb = row.querySelector('.row-select-cb');
                    if (cb) cb.checked = false;
                }
            });
            updateBatchBar();
        }

        if (searchInput) {
            searchInput.addEventListener('input', applyFilters);
        }

        // AJAX Status Switch Logic
        const statusSwitches = document.querySelectorAll('.status-toggle-switch');
        statusSwitches.forEach(sw => {
            sw.addEventListener('change', function() {
                const currentSw = this;
                const itemId = currentSw.getAttribute('data-id');
                const tableName = currentSw.getAttribute('data-table');
                const fieldName = currentSw.getAttribute('data-field') || 'tt_status';
                const newStatus = currentSw.checked ? 1 : 0;
                const row = currentSw.closest('tr');

                const formData = new FormData();
                formData.append('table', tableName);
                formData.append('id', itemId);
                formData.append('status', newStatus);
                formData.append('field', fieldName);

                fetch('ajax/toggle-status.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (toastMessage) toastMessage.textContent = data.message || `Review #${itemId} updated.`;
                        if (toastIcon) toastIcon.className = 'fa-solid fa-circle-check text-success fs-5';
                        if (toast) toast.show();
                        if (row) row.setAttribute('data-status', newStatus);
                    } else {
                        currentSw.checked = !newStatus;
                        if (toastMessage) toastMessage.textContent = data.error || 'Failed to update.';
                        if (toastIcon) toastIcon.className = 'fa-solid fa-circle-xmark text-danger fs-5';
                        if (toast) toast.show();
                    }
                })
                .catch(err => {
                    currentSw.checked = !newStatus;
                    if (toastMessage) toastMessage.textContent = 'Network error while updating.';
                    if (toastIcon) toastIcon.className = 'fa-solid fa-circle-xmark text-danger fs-5';
                    if (toast) toast.show();
                });
            });
        });
    });
    </script>
</body>
</html>
