<?php
require('checksession.php');
require('../inc/function.php');

$msg = "";
$error = "";

// Handle Contact Page Updates
if (isset($_POST['update_contact_page'])) {
    $phone1 = clean_input($_POST['primary_phone'] ?? $_POST['con_phone1'] ?? '');
    $phone2 = clean_input($_POST['secondary_phone'] ?? $_POST['con_phone2'] ?? '');
    $email1 = clean_input($_POST['primary_email'] ?? $_POST['con_email1'] ?? '');
    $email2 = clean_input($_POST['secondary_email'] ?? $_POST['con_email2'] ?? '');
    $whatsapp = clean_input($_POST['whatsapp_number'] ?? $_POST['con_whatsaap'] ?? '');
    $address = clean_input(strip_tags($_POST['office_address'] ?? $_POST['con_address'] ?? ''));
    $map = clean_input($_POST['google_map_iframe'] ?? $_POST['con_map'] ?? '');
    $hours = clean_input($_POST['working_hours'] ?? 'Mon – Sat: 09:30 – 18:30 IST');

    global $conn;
    $phone1_esc = mysqli_real_escape_string($conn, $phone1);
    $phone2_esc = mysqli_real_escape_string($conn, $phone2);
    $email1_esc = mysqli_real_escape_string($conn, $email1);
    $email2_esc = mysqli_real_escape_string($conn, $email2);
    $whatsapp_esc = mysqli_real_escape_string($conn, $whatsapp);
    $address_esc = mysqli_real_escape_string($conn, $address);
    $map_esc = mysqli_real_escape_string($conn, $map);
    $hours_esc = mysqli_real_escape_string($conn, $hours);

    $upd = mysqli_query($conn, "UPDATE `tbl_contact` SET 
        `con_phone1` = '$phone1_esc', `primary_phone` = '$phone1_esc',
        `con_phone2` = '$phone2_esc', `secondary_phone` = '$phone2_esc',
        `con_email1` = '$email1_esc', `primary_email` = '$email1_esc',
        `con_email2` = '$email2_esc', `secondary_email` = '$email2_esc',
        `con_whatsaap` = '$whatsapp_esc', `whatsapp_number` = '$whatsapp_esc',
        `con_address` = '$address_esc', `office_address` = '$address_esc',
        `con_map` = '$map_esc', `google_map_iframe` = '$map_esc',
        `working_hours` = '$hours_esc'
        WHERE `con_id` = 1");

    if ($upd) {
        $msg = "Contact details, phone numbers, and address updated successfully!";
    } else {
        $error = "Failed to update contact settings: " . mysqli_error($conn);
    }
}

// Fetch Current Contact Record
$contact = get_contact_info();
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
                        <li class="breadcrumb-item active">Contact &amp; Location Settings</li>
                    </ol>
                    <h1 class="page-header mb-0">
                        <i class="fa-solid fa-headset text-danger me-2"></i> Contact &amp; Location Desk
                    </h1>
                </div>
                <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                    <a href="../contact.php" target="_blank" class="btn btn-outline-danger btn-sm px-3">
                        <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Live Contact Page
                    </a>
                </div>
            </div>

            <!-- Alerts -->
            <?php if (!empty($msg)): ?>
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="fa-solid fa-circle-check fs-4 me-3 text-success"></i>
                    <div><strong>Success!</strong> <?= htmlspecialchars($msg) ?></div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="fa-solid fa-triangle-exclamation fs-4 me-3 text-danger"></i>
                    <div><strong>Error!</strong> <?= htmlspecialchars($error) ?></div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row g-4">
                <!-- Left Column: Form -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-3 mb-4">
                        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-sliders text-danger me-2"></i> Official Contact Desk Information</h5>
                            <span class="badge bg-success-subtle text-success border border-success-subtle">Live Synchronized</span>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST">
                                <h6 class="fw-bold mb-3 text-muted text-uppercase" style="font-size: 11px; letter-spacing: 1px;">Phone &amp; Communication Lines</h6>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Primary Helpline Phone <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fa-solid fa-phone text-muted"></i></span>
                                            <input type="text" name="primary_phone" class="form-control" value="<?= htmlspecialchars($contact['primary_phone'] ?? $contact['con_phone1'] ?? '+91 98100 46037') ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Secondary Line / Telephone</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fa-solid fa-phone-volume text-muted"></i></span>
                                            <input type="text" name="secondary_phone" class="form-control" value="<?= htmlspecialchars($contact['secondary_phone'] ?? $contact['con_phone2'] ?? '+91 98100 46038') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Primary Inquiries Email <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fa-solid fa-envelope text-muted"></i></span>
                                            <input type="email" name="primary_email" class="form-control" value="<?= htmlspecialchars($contact['primary_email'] ?? $contact['con_email1'] ?? 'stridewel@gmail.com') ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Secondary / Sales Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fa-solid fa-at text-muted"></i></span>
                                            <input type="email" name="secondary_email" class="form-control" value="<?= htmlspecialchars($contact['secondary_email'] ?? $contact['con_email2'] ?? 'sales@stridewel.com') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">WhatsApp Hotline Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fa-brands fa-whatsapp text-success"></i></span>
                                            <input type="text" name="whatsapp_number" class="form-control" value="<?= htmlspecialchars($contact['whatsapp_number'] ?? $contact['con_whatsaap'] ?? '+91 98100 46037') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Working Hours</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fa-solid fa-clock text-muted"></i></span>
                                            <input type="text" name="working_hours" class="form-control" value="<?= htmlspecialchars($contact['working_hours'] ?? 'Mon – Sat: 09:30 – 18:30 IST') ?>">
                                        </div>
                                    </div>
                                </div>

                                <h6 class="fw-bold mb-3 text-muted text-uppercase" style="font-size: 11px; letter-spacing: 1px;">Office Address &amp; Maps</h6>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Corporate Office &amp; Facility Address</label>
                                    <textarea name="office_address" class="form-control" rows="3"><?= htmlspecialchars($contact['office_address'] ?? $contact['con_address'] ?? '26-A, 2nd Floor, DLF Industrial Area, Moti Nagar, New Delhi-110015, India') ?></textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Google Map Embed URL / iframe</label>
                                    <textarea name="google_map_iframe" class="form-control" rows="3"><?= htmlspecialchars($contact['google_map_iframe'] ?? $contact['con_map'] ?? '') ?></textarea>
                                </div>

                                <button type="submit" name="update_contact_page" class="btn btn-danger px-4 py-2 fw-bold">
                                    <i class="fa-solid fa-floppy-disk me-2"></i> Save Contact Settings
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Live Card Preview -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-light">
                        <h6 class="fw-bold mb-3"><i class="fa-solid fa-eye me-2 text-danger"></i> Live Preview Card</h6>
                        <div class="p-3 bg-white rounded border">
                            <h6 class="fw-bold text-dark mb-1">Stridewel International</h6>
                            <p class="small text-muted mb-2"><?= htmlspecialchars($contact['office_address'] ?? '') ?></p>
                            <hr class="my-2">
                            <div class="small mb-1"><i class="fa-solid fa-phone text-danger me-2"></i><?= htmlspecialchars($contact['primary_phone'] ?? '') ?></div>
                            <div class="small mb-1"><i class="fa-solid fa-envelope text-danger me-2"></i><?= htmlspecialchars($contact['primary_email'] ?? '') ?></div>
                            <div class="small"><i class="fa-solid fa-clock text-danger me-2"></i><?= htmlspecialchars($contact['working_hours'] ?? '') ?></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php require('includes/footer.php'); ?>
    </div>
</body>
</html>
