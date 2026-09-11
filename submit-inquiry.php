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
    // Ensure table has required columns
    if (function_exists('ensure_enquiry_table_schema')) {
        ensure_enquiry_table_schema($conn);
    }

    try {
        // Check if extended tracking columns exist in tbl_enquiry
        $has_source_col = false;
        $has_ip_col = false;
        $q_src = @mysqli_query($conn, "SHOW COLUMNS FROM `tbl_enquiry` LIKE 'source_form'");
        if ($q_src && mysqli_num_rows($q_src) > 0) {
            $has_source_col = true;
        }
        $q_ip = @mysqli_query($conn, "SHOW COLUMNS FROM `tbl_enquiry` LIKE 'ip_address'");
        if ($q_ip && mysqli_num_rows($q_ip) > 0) {
            $has_ip_col = true;
        }

        $now_ist = date('Y-m-d H:i:s');

        // Primary Attempt: Insert with source_form and ip_address if available
        if ($has_source_col && $has_ip_col) {
            $stmt = $conn->prepare("INSERT INTO `tbl_enquiry` (`full_name`, `email`, `phone`, `company_name`, `product_interest`, `message`, `source_form`, `ip_address`, `status`, `created_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?)");
            if ($stmt) {
                $stmt->bind_param("sssssssss", $fullName, $email, $phone, $companyName, $productInterest, $message, $sourceForm, $ipAddress, $now_ist);
                $inserted = $stmt->execute();
                if ($inserted) {
                    $lead_id = intval($stmt->insert_id);
                }
                $stmt->close();
            }
        }

        // Fallback Attempt: Insert using base standard schema if columns are not present or primary failed
        if (!$inserted) {
            $annotated_message = "[Origin: " . $sourceForm . "] [IP: " . $ipAddress . "]\n\n" . $message;
            $stmt = $conn->prepare("INSERT INTO `tbl_enquiry` (`full_name`, `email`, `phone`, `company_name`, `product_interest`, `message`, `status`, `created_at`) VALUES (?, ?, ?, ?, ?, ?, 'pending', ?)");
            if ($stmt) {
                $stmt->bind_param("sssssss", $fullName, $email, $phone, $companyName, $productInterest, $annotated_message, $now_ist);
                $inserted = $stmt->execute();
                if ($inserted) {
                    $lead_id = intval($stmt->insert_id);
                }
                $stmt->close();
            }
        }
    } catch (Exception $e) {
        error_log("Enquiry database insert exception: " . $e->getMessage());
    }
}

// 4. Dispatch Email Alert to Website Owner
$mail_sent = false;
if (function_exists('send_enquiry_notification_email')) {
    $mail_sent = send_enquiry_notification_email([
        'name' => $fullName,
        'full_name' => $fullName,
        'phone' => $phone,
        'email' => $email,
        'message' => $message,
        'source_form' => $sourceForm,
        'product_interest' => $productInterest,
        'company_name' => $companyName,
        'ip_address' => $ipAddress,
        'lead_id' => $lead_id
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
    'lead_id' => $lead_id,
    'mail_sent' => $mail_sent
]);
exit;
