<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// Handle Floating Widgets Settings Update
if (isset($_POST['update_widgets'])) {
    $call_status   = isset($_POST['widget_call_status']) ? intval($_POST['widget_call_status']) : 0;
    $call_phone    = mysqli_real_escape_string($conn, trim($_POST['widget_call_phone'] ?? ''));
    $call_pos      = mysqli_real_escape_string($conn, trim($_POST['widget_call_position'] ?? 'left'));
    $call_tooltip  = mysqli_real_escape_string($conn, trim($_POST['widget_call_tooltip'] ?? 'Call Us'));

    $wa_status     = isset($_POST['widget_wa_status']) ? intval($_POST['widget_wa_status']) : 0;
    $wa_number     = mysqli_real_escape_string($conn, trim($_POST['widget_wa_number'] ?? ''));
    $wa_pos        = mysqli_real_escape_string($conn, trim($_POST['widget_wa_position'] ?? 'right'));
    $wa_msg        = mysqli_real_escape_string($conn, trim($_POST['widget_wa_message'] ?? ''));
    $wa_tooltip    = mysqli_real_escape_string($conn, trim($_POST['widget_wa_tooltip'] ?? 'Chat on WhatsApp'));

    $upd = mysqli_query($conn, "UPDATE `tbl_contact` SET 
        `widget_call_status`='$call_status',
        `widget_call_phone`='$call_phone',
        `widget_call_position`='$call_pos',
        `widget_call_tooltip`='$call_tooltip',
        `widget_wa_status`='$wa_status',
        `widget_wa_number`='$wa_number',
        `widget_wa_position`='$wa_pos',
        `widget_wa_message`='$wa_msg',
        `widget_wa_tooltip`='$wa_tooltip'
        WHERE `con_id`=1");

    if ($upd) {
        $msg = "Floating action widgets updated successfully!";
    } else {
        $error = "Failed to update widgets: " . mysqli_error($conn);
    }
}

// Fetch Current Record
$contact = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `tbl_contact` WHERE `con_id`=1"));

$call_active = ($contact['widget_call_status'] ?? 1) && !empty($contact['widget_call_phone'] ?? $contact['con_phone1'] ?? '');
$wa_active   = ($contact['widget_wa_status'] ?? 1) && !empty($contact['widget_wa_number'] ?? $contact['con_whatsaap'] ?? '');
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
                        <li class="breadcrumb-item"><a href="manage-settings-branding.php">Settings</a></li>
                        <li class="breadcrumb-item active">Floating Action Widgets</li>
                    </ol>
                    <h1 class="page-header mb-0" style="font-size: 24px; font-weight: 800; color: #123023;">
                        <i class="fa-solid fa-phone-volume text-warning me-2"></i> Floating Action Widgets CMS
                    </h1>
                </div>
                <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                    <a href="../../index.php" target="_blank" class="btn btn-outline-success btn-sm px-3">
                        <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Live Website
                    </a>
                </div>
            </div>

            <!-- Modern Sub-Menu Switcher Pills -->
            <div class="cms-subnav-strip mb-4">
                <a href="manage-settings-branding.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-palette"></i> Brand Logos & Favicon
                </a>
                <a href="manage-settings-seo.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-magnifying-glass-chart"></i> Global SEO & Footers
                </a>
                <a href="manage-settings-social.php" class="cms-subnav-pill">
                    <i class="fa-solid fa-share-nodes"></i> Social Media Handles
                </a>
                <a href="manage-settings-widgets.php" class="cms-subnav-pill active">
                    <i class="fa-solid fa-phone-volume"></i> Floating Action Widgets
                </a>
                <div class="ms-auto">
                    <a href="../../index.php" target="_blank" class="cms-subnav-pill cms-subnav-preview">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Preview Live
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

            <!-- Live Floating Status Visual Banner -->
            <div class="card border-0 shadow-sm rounded-3 mb-4 overflow-hidden" style="background: linear-gradient(135deg, #123023 0%, #1E4D38 100%);">
                <div class="card-body p-4 text-white">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center bg-white bg-opacity-10 text-warning" style="width: 48px; height: 48px; font-size: 20px;">
                                <i class="fa-solid fa-mobile-screen"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold text-white">Live Floating Widget Configuration</h5>
                                <p class="text-white text-opacity-75 small mb-0">Both widgets render as icon-only circular buttons pinned to the bottom screen corners.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center gap-2 bg-black bg-opacity-25 px-3 py-2 rounded-pill border border-white border-opacity-10">
                                <span class="badge rounded-circle p-1 <?= $call_active ? 'bg-success' : 'bg-secondary' ?>"></span>
                                <span class="small fw-semibold">Left: Call (<?= $call_active ? 'Active' : 'Hidden' ?>)</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 bg-black bg-opacity-25 px-3 py-2 rounded-pill border border-white border-opacity-10">
                                <span class="badge rounded-circle p-1 <?= $wa_active ? 'bg-success' : 'bg-secondary' ?>"></span>
                                <span class="small fw-semibold">Right: WhatsApp (<?= $wa_active ? 'Active' : 'Hidden' ?>)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuration Form -->
            <form method="POST" action="">
                <div class="row g-4">
                    <!-- Left Column: Direct Call Widget Card -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-3 h-100 d-flex flex-column">
                            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background: rgba(18, 48, 35, 0.1); color: #123023;">
                                        <i class="fa-solid fa-phone-volume fs-5"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 fw-bold" style="color: #123023;">Direct Call Widget</h5>
                                        <small class="text-muted">Floating one-tap dialing button</small>
                                    </div>
                                </div>
                                <span class="badge <?= ($contact['widget_call_status'] ?? 1) ? 'bg-success' : 'bg-secondary' ?> px-3 py-2 rounded-pill">
                                    <?= ($contact['widget_call_status'] ?? 1) ? 'Active' : 'Disabled' ?>
                                </span>
                            </div>
                            <div class="card-body p-4 d-flex flex-column justify-content-between flex-grow-1">
                                <div>
                                    <!-- Enable / Disable Toggle -->
                                    <div class="mb-4 p-3 rounded-3" style="background: #F8FAF9; border: 1px solid #E2E8E5;">
                                        <div class="form-check form-switch d-flex align-items-center justify-content-between ps-0">
                                            <label class="form-check-label fw-bold mb-0 text-dark" for="widget_call_status">
                                                Enable Floating Call Button
                                            </label>
                                            <input class="form-check-input ms-auto" type="checkbox" role="switch" id="widget_call_status" name="widget_call_status" value="1" <?= ($contact['widget_call_status'] ?? 1) ? 'checked' : '' ?> style="cursor: pointer; transform: scale(1.2);">
                                        </div>
                                        <small class="text-muted d-block mt-1">If disabled or phone number is empty, the button is hidden on live pages.</small>
                                    </div>

                                    <!-- Phone Number -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-dark">Dialing Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-phone"></i></span>
                                            <input type="text" name="widget_call_phone" class="form-control" value="<?= htmlspecialchars($contact['widget_call_phone'] ?? $contact['con_phone1'] ?? '') ?>" placeholder="+91 98765 43210">
                                        </div>
                                        <small class="text-muted">Leave blank to hide the Call button entirely.</small>
                                    </div>

                                    <!-- Screen Position -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-dark">Screen Corner Position</label>
                                        <select name="widget_call_position" class="form-select">
                                            <option value="left" <?= (($contact['widget_call_position'] ?? 'left') == 'left') ? 'selected' : '' ?>>Bottom Left (Default / Recommended)</option>
                                            <option value="right" <?= (($contact['widget_call_position'] ?? '') == 'right') ? 'selected' : '' ?>>Bottom Right</option>
                                        </select>
                                    </div>

                                    <!-- Hover Tooltip Text -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-dark">Button Tooltip Text</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-comment-dots"></i></span>
                                            <input type="text" name="widget_call_tooltip" class="form-control" value="<?= htmlspecialchars($contact['widget_call_tooltip'] ?? 'Call Us') ?>" placeholder="Call Us">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: WhatsApp Widget Card -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-3 h-100 d-flex flex-column">
                            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background: rgba(37, 211, 102, 0.15); color: #25D366;">
                                        <i class="fa-brands fa-whatsapp fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 fw-bold" style="color: #123023;">WhatsApp Action Widget</h5>
                                        <small class="text-muted">Floating instant chat button</small>
                                    </div>
                                </div>
                                <span class="badge <?= ($contact['widget_wa_status'] ?? 1) ? 'bg-success' : 'bg-secondary' ?> px-3 py-2 rounded-pill">
                                    <?= ($contact['widget_wa_status'] ?? 1) ? 'Active' : 'Disabled' ?>
                                </span>
                            </div>
                            <div class="card-body p-4 d-flex flex-column justify-content-between flex-grow-1">
                                <div>
                                    <!-- Enable / Disable Toggle -->
                                    <div class="mb-4 p-3 rounded-3" style="background: #F8FAF9; border: 1px solid #E2E8E5;">
                                        <div class="form-check form-switch d-flex align-items-center justify-content-between ps-0">
                                            <label class="form-check-label fw-bold mb-0 text-dark" for="widget_wa_status">
                                                Enable Floating WhatsApp Button
                                            </label>
                                            <input class="form-check-input ms-auto" type="checkbox" role="switch" id="widget_wa_status" name="widget_wa_status" value="1" <?= ($contact['widget_wa_status'] ?? 1) ? 'checked' : '' ?> style="cursor: pointer; transform: scale(1.2);">
                                        </div>
                                        <small class="text-muted d-block mt-1">If disabled or WhatsApp number is empty, the button is hidden on live pages.</small>
                                    </div>

                                    <!-- WhatsApp Number -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-dark">WhatsApp Target Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-success"><i class="fa-brands fa-whatsapp"></i></span>
                                            <input type="text" name="widget_wa_number" class="form-control" value="<?= htmlspecialchars($contact['widget_wa_number'] ?? $contact['con_whatsaap'] ?? '') ?>" placeholder="+919876543210">
                                        </div>
                                        <small class="text-muted">Include country code without symbols e.g. +919876543210. Leave blank to hide.</small>
                                    </div>

                                    <!-- Screen Position -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-dark">Screen Corner Position</label>
                                        <select name="widget_wa_position" class="form-select">
                                            <option value="right" <?= (($contact['widget_wa_position'] ?? 'right') == 'right') ? 'selected' : '' ?>>Bottom Right (Default / Recommended)</option>
                                            <option value="left" <?= (($contact['widget_wa_position'] ?? '') == 'left') ? 'selected' : '' ?>>Bottom Left</option>
                                        </select>
                                    </div>

                                    <!-- Pre-filled Message Text -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-dark">Pre-filled Chat Message</label>
                                        <input type="text" name="widget_wa_message" class="form-control" value="<?= htmlspecialchars($contact['widget_wa_message'] ?? 'Hello Antara Globale, I am interested in commodity sourcing & trade inquiries.') ?>" placeholder="Hello Antara Globale, I am interested in commodity sourcing & trade inquiries.">
                                    </div>

                                    <!-- Hover Tooltip Text -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-dark">Button Tooltip Text</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-comment-dots"></i></span>
                                            <input type="text" name="widget_wa_tooltip" class="form-control" value="<?= htmlspecialchars($contact['widget_wa_tooltip'] ?? 'Chat on WhatsApp') ?>" placeholder="Chat on WhatsApp">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button Row (Consistent with all other admin pages) -->
                    <div class="col-12 text-end mt-4">
                        <button type="submit" name="update_widgets" class="btn btn-warning btn-lg px-5 fw-bold shadow-sm">
                            <i class="fa-solid fa-floppy-disk me-2"></i> Save Widget Configuration
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
