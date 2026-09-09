<?php
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/function.php';

// Set JSON headers
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
    exit;
}

$name = clean_input($_POST['name'] ?? '');
$phone = clean_input($_POST['phone'] ?? '');
$email = clean_input($_POST['email'] ?? '');
$organization = clean_input($_POST['organization'] ?? $_POST['company'] ?? '');
$productInterest = clean_input($_POST['product_interest'] ?? $_POST['product_name'] ?? $_POST['subject'] ?? 'General Inquiry');
$message = clean_input($_POST['message'] ?? $_POST['comments'] ?? '');
$inquiryType = clean_input($_POST['inquiry_type'] ?? 'Web Lead');
$sourcePage = clean_input($_POST['source_page'] ?? $_SERVER['HTTP_REFERER'] ?? 'Website Form');
$ipAddress = clean_input($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');

if (empty($name) || empty($phone)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Please provide at least your name and phone number.'
    ]);
    exit;
}

// Insert into tbl_enquiry if DB is connected
global $db;
$inserted = false;

if ($db instanceof PDO) {
    try {
        $stmt = $db->prepare("INSERT INTO tbl_enquiry (name, email, phone, organization, product_name, message, inquiry_type, source_page, ip_address, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'New', NOW())");
        $inserted = $stmt->execute([
            $name,
            $email,
            $phone,
            $organization,
            $productInterest,
            $message,
            $inquiryType,
            $sourcePage,
            $ipAddress
        ]);
    } catch (Exception $e) {
        error_log("Enquiry insert error: " . $e->getMessage());
    }
} elseif (is_object($db) && method_exists($db, 'prepare')) {
    $stmt = $db->prepare("INSERT INTO tbl_enquiry (name, email, phone, organization, product_name, message, inquiry_type, source_page, ip_address, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'New', NOW())");
    if ($stmt) {
        $stmt->bind_param("sssssssss", $name, $email, $phone, $organization, $productInterest, $message, $inquiryType, $sourcePage, $ipAddress);
        $inserted = $stmt->execute();
    }
}

// If redirect is requested (non-AJAX standard form submission)
if (!empty($_POST['redirect_back'])) {
    header("Location: " . $_POST['redirect_back'] . "?inquiry_status=success");
    exit;
}

echo json_encode([
    'status' => 'success',
    'message' => 'Thank you! Your quotation request has been received. Our team will contact you shortly.',
    'lead_id' => $inserted ? (is_object($db) && isset($db->lastInsertId) ? $db->lastInsertId() : ($db->insert_id ?? 1)) : 1
]);
exit;
