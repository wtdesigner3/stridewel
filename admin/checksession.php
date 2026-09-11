<?php
if (session_status() === PHP_SESSION_NONE) {
    @session_start();
}
if (!isset($_SESSION['admin_ses']) || $_SESSION['admin_ses'] !== "hvrs@#p9w84r" . session_id()) {
    header("Location: login.php");
    exit();
}
require_once(__DIR__ . '/../inc/function.php');
if (function_exists('ensure_admin_database_schema')) {
    global $conn;
    ensure_admin_database_schema($conn);
}
?>