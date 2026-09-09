<?php
/**
 * Stridewel International - Core Database & Configuration
 * Supports MySQLi and PDO with automatic environment detection.
 */

// 1. Session Initialization
if (session_status() === PHP_SESSION_NONE) {
    @session_start();
}

// 2. Error Reporting Configuration (Display in Dev, Log in Production)
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
ini_set('display_errors', '0');

// 3. Environment & Database Credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'stridewel_db');
define('DB_PORT', 3306);

// 4. Base Site Constants
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || ($_SERVER['SERVER_PORT'] ?? 80) == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$script_dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$base_path = rtrim(preg_replace('#/(admin|inc|includes|assets).*$#i', '', $script_dir), '/');
$site_url = $protocol . $host . ($base_path ? $base_path . '/' : '/');

define('SITE_URL', $site_url);
define('SITE_NAME', 'Stridewel International');
define('SITE_TAGLINE', 'Veterinary & Artificial Insemination Precision Equipment');
define('ADMIN_URL', SITE_URL . 'admin/');
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('UPLOAD_URL', SITE_URL . 'uploads/');

// 5. Establish MySQLi Connection
@mysqli_report(MYSQLI_REPORT_OFF);
$conn = null;

try {
    $conn = @mysqli_init();
    if ($conn) {
        @mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 3);
        $connected = @mysqli_real_connect($conn, DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        if ($connected) {
            @mysqli_set_charset($conn, "utf8mb4");
        } else {
            // If connection to server works but DB is missing, create it
            $srv_conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, '', DB_PORT);
            if ($srv_conn) {
                @mysqli_query($srv_conn, "CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                @mysqli_close($srv_conn);
                $connected = @mysqli_real_connect($conn, DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
                if ($connected) {
                    @mysqli_set_charset($conn, "utf8mb4");
                }
            }
        }
    }
} catch (Throwable $e) {
    $conn = null;
}

// 6. Establish PDO Connection (for secure prepared queries)
$pdo = null;
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4;port=" . DB_PORT;
    $pdo_options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_SILENT,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_TIMEOUT            => 3,
    ];
    $pdo = @new PDO($dsn, DB_USER, DB_PASS, $pdo_options);
} catch (Throwable $e) {
    // Graceful fallback if database service is starting or migrating
    $pdo = null;
}

// Ensure upload subdirectories exist
$upload_dirs = ['uploads', 'uploads/products', 'uploads/categories', 'uploads/blogs', 'uploads/home', 'uploads/about', 'uploads/logo'];
foreach ($upload_dirs as $udir) {
    $full_path = __DIR__ . '/../' . $udir;
    if (!is_dir($full_path)) {
        @mkdir($full_path, 0777, true);
    }
}
