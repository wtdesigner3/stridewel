<?php
/**
 * Stridewel International - Inquiries & RFQ Lead Processor
 * Receives minimal form submissions (Name, Number, Email, Message)
 * Records lead in database with form origin source and dispatches instant email to website owner.
 */

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/function.php';

// Set JSON header for AJAX endpoints
header('Content-Type: application/json; charset=UTF-8');

// Ensure request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method. Only POST requests are accepted.'
    ]);
    exit;
}

// 1. Sanitize & Normalize Inputs
$fullName = clean_input($_POST['name'] ?? $_POST['full_name'] ?? '');
$phone    = clean_input($_POST['phone'] ?? $_POST['number'] ?? '');
$email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$message  = clean_input($_POST['message'] ?? $_POST['comments'] ?? '');

// Contextual details
$sourceForm      = clean_input($_POST['source_form'] ?? $_POST['source_page'] ?? 'Website Inquiry Form');
$productInterest = clean_input($_POST['product_interest'] ?? $_POST['product_name'] ?? '');
$companyName     = clean_input($_POST['organization'] ?? $_POST['company'] ?? '');
$ipAddress       = clean_input($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');

// 2. Validate Required 4 Fields
if (empty($fullName) || empty($phone) || empty($email) || empty($message)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Please fill in all 4 required fields: Name, Phone / WhatsApp Number, Email, and Message.'
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Please enter a valid email address.'
    ]);
    exit;
}

// 3. Database Insertion into tbl_enquiry using prepared statement
global $conn;
$inserted = false;
$lead_id = 0;

if ($conn && $conn instanceof mysqli) {
    try {
        $stmt = $conn->prepare("INSERT INTO `tbl_enquiry` (`full_name`, `email`, `phone`, `company_name`, `product_interest`, `message`, `source_form`, `ip_address`, `status`, `created_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())");
        if ($stmt) {
            $stmt->bind_param("ssssssss", $fullName, $email, $phone, $companyName, $productInterest, $message, $sourceForm, $ipAddress);
            $inserted = $stmt->execute();
            $lead_id = $stmt->insert_id;
            $stmt->close();
        }
    } catch (Exception $e) {
        error_log("Enquiry database insert exception: " . $e->getMessage());
    }
}

// 4. Dispatch Email Alert to Website Owner
if (function_exists('send_enquiry_notification_email')) {
    send_enquiry_notification_email([
        'full_name' => $fullName,
        'phone' => $phone,
        'email' => $email,
        'message' => $message,
        'source_form' => $sourceForm,
        'product_interest' => $productInterest,
        'ip_address' => $ipAddress
    ]);
}

// 5. If non-AJAX form with redirect requested
if (!empty($_POST['redirect_back'])) {
    header("Location: " . $_POST['redirect_back'] . "?inquiry_status=success");
    exit;
}

// 6. Return Clean Success JSON Response
echo json_encode([
    'status' => 'success',
    'message' => 'Thank you! Your inquiry has been received. Our technical sales team will contact you shortly.',
    'lead_id' => $lead_id
]);
exit;
