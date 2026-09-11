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

// Set Application Default Timezone to Indian Standard Time (IST, UTC+5:30)
date_default_timezone_set('Asia/Kolkata');

// 3. Environment & Database Credentials
if (file_exists(__DIR__ . '/config.production.php')) {
    require_once __DIR__ . '/config.production.php';
} else {
    // Default Local Development Credentials
    defined('DB_HOST') or define('DB_HOST', 'localhost');
    defined('DB_USER') or define('DB_USER', 'root');
    defined('DB_PASS') or define('DB_PASS', '');
    defined('DB_NAME') or define('DB_NAME', 'stridewel_db');
    defined('DB_PORT') or define('DB_PORT', 3306);
}

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
    $temp_conn = @mysqli_init();
    if ($temp_conn) {
        @mysqli_options($temp_conn, MYSQLI_OPT_CONNECT_TIMEOUT, 3);
        $connected = @mysqli_real_connect($temp_conn, DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        if ($connected && !mysqli_connect_errno()) {
            @mysqli_set_charset($temp_conn, "utf8mb4");
            @mysqli_query($temp_conn, "SET time_zone = '+05:30'");
            $conn = $temp_conn;
        } else {
            @mysqli_close($temp_conn);
            $conn = null;
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
    if ($pdo) {
        @$pdo->exec("SET time_zone = '+05:30'");
    }
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
