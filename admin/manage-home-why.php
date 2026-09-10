<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// 1. Handle Section Meta Update
if (isset($_POST['update_meta'])) {
    $badge = mysqli_real_escape_string($conn, trim($_POST['badge']));
    $heading = mysqli_real_escape_string($conn, trim($_POST['heading']));
    $description = mysqli_real_escape_string($conn, trim(strip_tags($_POST['description'] ?? '')));
    $cta_text = mysqli_real_escape_string($conn, trim($_POST['cta_text']));
    $cta_link = mysqli_real_escape_string($conn, trim($_POST['cta_link']));
    $pdf_text = mysqli_real_escape_string($conn, trim($_POST['pdf_text']));
    $pdf_link = mysqli_real_escape_string($conn, trim($_POST['pdf_link']));

    $upd = mysqli_query($conn, "UPDATE `tbl_home_why_meta` SET 
        `badge`='$badge',
        `subheading`='$badge',
        `heading`='$heading',
        `description`='$description',
        `cta_text`='$cta_text',
        `cta_link`='$cta_link',
        `btn_text`='$cta_text',
        `btn_link`='$cta_link',
        `pdf_text`='$pdf_text',
        `pdf_link`='$pdf_link'
        WHERE `id`=1");

    if ($upd) {
        $msg = "Section header & buttons updated successfully!";
    } else {
        $error = "Failed to update header: " . mysqli_error($conn);
    }
}

// 2. Handle Status Toggle
if (isset($_GET['toggle_status']) && isset($_GET['id'])) {
    $wid = (int)$_GET['id'];
    $cur = (int)$_GET['toggle_status'];
    $new_st = ($cur == 1) ? 0 : 1;
    mysqli_query($conn, "UPDATE `tbl_home_why` SET `status`=$new_st WHERE `id`=$wid");
    header("Location: manage-home-why.php?msg=" . urlencode("Status updated successfully"));
    exit;
}

// 3. Handle Delete
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM `tbl_home_why` WHERE `id`=$del_id");
    header("Location: manage-home-why.php?msg=" . urlencode("Why Choose card deleted successfully"));
    exit;
}

// 4. Handle Add Card
if (isset($_POST['add_why_card'])) {
    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $desc = mysqli_real_escape_string($conn, trim(strip_tags($_POST['description'] ?? '')));
    $icon = mysqli_real_escape_string($conn, trim($_POST['icon']));
    $sort = (int)($_POST['sort_order'] ?? 0);
    $status = isset($_POST['status']) ? 1 : 0;

    if (!empty($title)) {
        $ins = mysqli_query($conn, "INSERT INTO `tbl_home_why` (`title`, `description`, `icon`, `sort_order`, `status`) VALUES ('$title', '$desc', '$icon', $sort, $status)");
        if ($ins) {
            $msg = "Card '$title' added successfully!";
        } else {
            $error = "Failed to add card: " . mysqli_error($conn);
        }
    } else {
        $error = "Card title is required.";
    }
}

// 5. Handle Edit Card
if (isset($_POST['edit_why_card'])) {
    $cid = (int)$_POST['card_id'];
    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $desc = mysqli_real_escape_string($conn, trim(strip_tags($_POST['description'] ?? '')));
    $icon = mysqli_real_escape_string($conn, trim($_POST['icon']));
    $sort = (int)($_POST['sort_order'] ?? 0);
    $status = isset($_POST['status']) ? 1 : 0;

    if (!empty($title)) {
        $upd = mysqli_query($conn, "UPDATE `tbl_home_why` SET `title`='$title', `description`='$desc', `icon`='$icon', `sort_order`=$sort, `status`=$status WHERE `id`=$cid");
        if ($upd) {
            $msg = "Card '$title' updated successfully!";
        } else {
            $error = "Failed to update card: " . mysqli_error($conn);
        }
    } else {
        $error = "Card title is required.";
    }
}

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}

// Fetch Section Meta
$meta = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `tbl_home_why_meta` WHERE `id`=1 LIMIT 1"));
if (!$meta) {
    $meta = [
        'badge' => 'Engineered For Bovine Breeding Precision',
        'heading' => 'Why Choose Stridewel International',
        'description' => 'Four decades of engineering mastery, ISO 9001:2015 certified in-house manufacturing, and exclusive partnership with global leaders like Dr. N. Burdizzo (Italy) and Minitube Germany.',
        'cta_text' => 'Explore All Product Categories',
        'cta_link' => 'products',
        'pdf_text' => 'Download Complete PDF Catalog',
        'pdf_link' => 'assets/STRIDEWEL (2).pdf'
    ];
}

// Fetch Cards
$cards = [];
$cq = mysqli_query($conn, "SELECT * FROM `tbl_home_why` ORDER BY `sort_order` ASC, `id` ASC");
if ($cq) {
    while ($row = mysqli_fetch_assoc($cq)) {
        $cards[] = $row;
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
                        Why Choose Stridewel Management
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 13.5px;">
                        Manage the section badge, headline, value propositions, and 6 value cards on the homepage.
                    </p>
                </div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="manage-home-hero.php">Home Page CMS</a></li>
                    <li class="breadcrumb-item active">Why Choose Stridewel</li>
                </ol>
            </div>

            <!-- Quick Sub-Menu Switcher Pills -->
            <div class="cms-subnav-strip mb-4">
                <a href="manage-home-hero.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-images"></i> Hero Banner
                </a>
                <a href="manage-home-trust.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-shield-halved"></i> Quality Trust Bar
                </a>
                <a href="manage-about-story.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-building"></i> Company Overview
                </a>
                <a href="manage-categories.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-boxes-stacked"></i> Categories
                </a>
                <a href="manage-home-why.php" class="cms-subnav-pill active">
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

            <div class="row g-4">
                <!-- Left: Section Meta & Buttons Form -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                        <div class="card-header bg-white py-3 px-4 border-bottom">
                            <h5 class="mb-0 fw-bold" style="color: #103755;">
                                <i class="fa-solid fa-heading text-danger me-2"></i> Section Header &amp; Action Buttons
                            </h5>
                        </div>
                        <div class="card-body p-4 bg-white">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark mb-1">Top Pill Badge</label>
                                    <input type="text" name="badge" class="form-control" value="<?= htmlspecialchars(!empty($meta['badge']) ? $meta['badge'] : ($meta['subheading'] ?? '')) ?>" placeholder="e.g. Engineered For Bovine Breeding Precision">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark mb-1">Section Main Heading</label>
                                    <input type="text" name="heading" class="form-control" value="<?= htmlspecialchars($meta['heading']) ?>" placeholder="e.g. Why Choose Stridewel International">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark mb-1">Introductory Subtitle / Narrative</label>
                                    <textarea name="description" class="form-control no-ckeditor" rows="3"><?= htmlspecialchars(strip_tags($meta['description'])) ?></textarea>
                                </div>
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label fw-bold text-dark mb-1">Primary CTA Button</label>
                                        <input type="text" name="cta_text" class="form-control form-control-sm" value="<?= htmlspecialchars($meta['cta_text'] ?? 'Explore All Product Categories') ?>">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-bold text-dark mb-1">CTA URL Link</label>
                                        <input type="text" name="cta_link" class="form-control form-control-sm" value="<?= htmlspecialchars($meta['cta_link'] ?? 'products') ?>">
                                    </div>
                                </div>
                                <div class="row g-2 mb-4">
                                    <div class="col-6">
                                        <label class="form-label fw-bold text-dark mb-1">PDF Catalog Button</label>
                                        <input type="text" name="pdf_text" class="form-control form-control-sm" value="<?= htmlspecialchars($meta['pdf_text'] ?? 'Download Complete PDF Catalog') ?>">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-bold text-dark mb-1">PDF Link Path</label>
                                        <input type="text" name="pdf_link" class="form-control form-control-sm" value="<?= htmlspecialchars($meta['pdf_link'] ?? 'assets/STRIDEWEL (2).pdf') ?>">
                                    </div>
                                </div>
                                <button type="submit" name="update_meta" class="btn btn-danger w-100 fw-bold py-2.5 rounded-pill shadow-sm">
                                    <i class="fa-solid fa-floppy-disk me-1"></i> Update Section Header
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right: 6 Feature Cards CRUD -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <h5 class="mb-0 fw-bold" style="color: #103755;">
                                <i class="fa-solid fa-grid-2 text-danger me-2"></i> Value Proposition Cards (<?= count($cards) ?>)
                            </h5>
                            <button type="button" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold shadow-sm" data-toggle="modal" data-target="#addWhyModal" data-bs-toggle="modal" data-bs-target="#addWhyModal">
                                <i class="fa-solid fa-plus me-1"></i> Add New Card
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light text-muted" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                                        <tr>
                                            <th class="ps-4" style="width: 60px;">#</th>
                                            <th style="width: 70px;">Icon</th>
                                            <th>Card Content</th>
                                            <th style="width: 100px;">Status</th>
                                            <th class="text-end pe-4" style="width: 120px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($cards)): ?>
                                            <?php foreach ($cards as $c): ?>
                                            <tr>
                                                <td class="ps-4">
                                                    <span class="badge bg-light text-dark border px-2 py-1 fw-bold"><?= $c['sort_order'] ?></span>
                                                </td>
                                                <td>
                                                    <div class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 38px; height: 38px; background: rgba(237,28,36,0.1); color: #ed1c24; font-size: 18px;">
                                                        <i class="bi <?= htmlspecialchars($c['icon']) ?>"></i>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="fw-bold text-dark" style="font-size: 14px;"><?= htmlspecialchars($c['title']) ?></div>
                                                    <small class="text-muted" style="font-size: 12px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?= htmlspecialchars($c['description']) ?></small>
                                                </td>
                                                <td>
                                                    <?php if ($c['status'] == 1): ?>
                                                        <a href="manage-home-why.php?toggle_status=1&id=<?= $c['id'] ?>" class="badge bg-success-subtle text-success border border-success-subtle text-decoration-none px-2 py-1 rounded-pill fw-bold" title="Click to Deactivate">
                                                            Active
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="manage-home-why.php?toggle_status=0&id=<?= $c['id'] ?>" class="badge bg-secondary-subtle text-secondary border border-secondary-subtle text-decoration-none px-2 py-1 rounded-pill fw-bold" title="Click to Activate">
                                                            Hidden
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <div class="btn-group btn-group-sm">
                                                        <button type="button" class="btn btn-outline-primary btn-sm rounded-2 me-1 edit-card-btn"
                                                            onclick="openEditWhyCard(this)"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editWhyModal"
                                                            data-id="<?= $c['id'] ?>"
                                                            data-title="<?= htmlspecialchars($c['title']) ?>"
                                                            data-desc="<?= htmlspecialchars($c['description']) ?>"
                                                            data-icon="<?= htmlspecialchars($c['icon']) ?>"
                                                            data-sort="<?= $c['sort_order'] ?>"
                                                            data-status="<?= $c['status'] ?>"
                                                            title="Edit Card">
                                                            <i class="fa-solid fa-pen-to-square" style="pointer-events: none;"></i>
                                                        </button>
                                                        <a href="manage-home-why.php?delete=<?= $c['id'] ?>" class="btn btn-outline-danger btn-sm rounded-2" onclick="return confirm('Delete this value proposition card?');" title="Delete Card">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center py-5 text-muted">
                                                    No cards found. Click "Add New Card" to create one.
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

    <!-- Add Card Modal -->
    <div class="modal fade" id="addWhyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form method="POST">
                    <div class="modal-header bg-white py-3 px-4 border-bottom">
                        <h5 class="modal-title fw-bold" style="color: #103755;">
                            <i class="fa-solid fa-plus-circle text-danger me-2"></i> Add Value Proposition Card
                        </h5>
                        <button type="button" class="btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 bg-white">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">Card Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required placeholder="e.g. ISO 9001:2015 Certified Plant">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">Card Description</label>
                            <textarea name="description" class="form-control no-ckeditor" rows="3" placeholder="Detailed explanation of this core advantage..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">Bootstrap Icon Class</label>
                            <input type="text" name="icon" class="form-control" value="bi-award-fill" placeholder="e.g. bi-award-fill, bi-shield-shaded, bi-building-gear, bi-snow, bi-lightbulb-fill">
                            <small class="text-muted">Supports any Bootstrap 5 Icon (e.g. <code>bi-award-fill</code>, <code>bi-shield-shaded</code>, <code>bi-globe-americas</code>)</small>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label fw-bold text-dark mb-1">Display Order</label>
                                <input type="number" name="sort_order" class="form-control" value="0">
                            </div>
                            <div class="col-6 d-flex align-items-end">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="status" id="addStatus" checked>
                                    <label class="form-check-label fw-bold" for="addStatus">Active Status</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light py-3 px-4 border-top">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_why_card" class="btn btn-danger rounded-pill px-4 fw-bold">Save Card</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Card Modal -->
    <div class="modal fade" id="editWhyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form method="POST">
                    <input type="hidden" name="card_id" id="editCardId">
                    <div class="modal-header bg-white py-3 px-4 border-bottom">
                        <h5 class="modal-title fw-bold" style="color: #103755;">
                            <i class="fa-solid fa-pen-to-square text-primary me-2"></i> Edit Value Proposition Card
                        </h5>
                        <button type="button" class="btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 bg-white">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">Card Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="editCardTitle" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">Card Description</label>
                            <textarea name="description" id="editCardDesc" class="form-control no-ckeditor" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1">Bootstrap Icon Class</label>
                            <input type="text" name="icon" id="editCardIcon" class="form-control">
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label fw-bold text-dark mb-1">Display Order</label>
                                <input type="number" name="sort_order" id="editCardSort" class="form-control">
                            </div>
                            <div class="col-6 d-flex align-items-end">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="status" id="editCardStatus">
                                    <label class="form-check-label fw-bold" for="editCardStatus">Active Status</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light py-3 px-4 border-top">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="edit_why_card" class="btn btn-primary rounded-pill px-4 fw-bold">Update Card</button>
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
        // Global handler to populate Why Choose card modal immediately on click or event
        function openEditWhyCard(btn) {
            if (!btn) return;
            var id = btn.getAttribute('data-id') || '';
            var title = btn.getAttribute('data-title') || '';
            var desc = btn.getAttribute('data-desc') || '';
            var icon = btn.getAttribute('data-icon') || '';
            var sort = btn.getAttribute('data-sort') || '0';
            var status = btn.getAttribute('data-status');

            var idEl = document.getElementById('editCardId');
            var titleEl = document.getElementById('editCardTitle');
            var descEl = document.getElementById('editCardDesc');
            var iconEl = document.getElementById('editCardIcon');
            var sortEl = document.getElementById('editCardSort');
            var statusEl = document.getElementById('editCardStatus');

            if (idEl) idEl.value = id;
            if (titleEl) titleEl.value = title;
            if (descEl) descEl.value = desc;
            if (iconEl) iconEl.value = icon;
            if (sortEl) sortEl.value = sort;
            if (statusEl) statusEl.checked = (status === '1' || status == 1);
        }

        // Prevent jQuery UI sortable crash in apps.min.js
        if (typeof jQuery !== 'undefined' && !jQuery.fn.sortable) {
            jQuery.fn.sortable = function() { return this; };
        }

        $(document).ready(function() {
            if (typeof App !== 'undefined' && typeof App.init === 'function') {
                try { App.init(); } catch(e) { console.warn('App.init:', e); }
            }

            var editWhyModal = document.getElementById('editWhyModal');
            if (editWhyModal) {
                editWhyModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget || document.querySelector('.edit-card-btn:focus') || document.activeElement;
                    openEditWhyCard(button);
                });
            }

            $(document).on('click', '.edit-card-btn', function(e) {
                openEditWhyCard(this);
            });
        });
    </script>
</body>
</html>
