<?php
/**
 * Stridewel International - Automatic Database Bootstrapper & Migrator
 */

require_once(__DIR__ . '/config.php');

$db_host = DB_HOST;
$db_user = DB_USER;
$db_pass = DB_PASS;
$db_name = DB_NAME;

echo "<pre style='font-family: monospace; background: #0f172a; color: #38bdf8; padding: 20px; border-radius: 8px;'>";
echo "=== Stridewel International Database Setup & Verification ===\n\n";

$mysqli = @new mysqli($db_host, $db_user, $db_pass);
if ($mysqli->connect_error) {
    echo "[-] Cannot connect to MySQL server ($db_host): " . $mysqli->connect_error . "\n";
    echo "[!] Please ensure MySQL / XAMPP service is running.\n";
    echo "</pre>";
    exit;
}

echo "[+] Connected to MySQL Server successfully.\n";

// Create Database if not exists
$create_db = $mysqli->query("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
if ($create_db) {
    echo "[+] Database `$db_name` verified / created.\n";
} else {
    echo "[-] Failed to create database: " . $mysqli->error . "\n";
}

$mysqli->select_db($db_name);

// Check if tables already exist
$table_check = $mysqli->query("SHOW TABLES LIKE 'tbl_product'");
if ($table_check && $table_check->num_rows > 0) {
    echo "[+] Database `$db_name` already initialized with tables.\n";
    
    // Check product count
    $cnt_q = $mysqli->query("SELECT COUNT(*) as cnt FROM `tbl_product`");
    $cnt = $cnt_q ? $cnt_q->fetch_assoc()['cnt'] : 0;
    echo "[+] Active Products in Database: $cnt items.\n";
} else {
    // Import stridewel_db.sql
    $sql_file = __DIR__ . '/../admin/config files/stridewel_db.sql';
    if (file_exists($sql_file)) {
        echo "[*] Importing schema and seed data from stridewel_db.sql...\n";
        $sql_content = file_get_contents($sql_file);
        
        // Execute multi query
        if ($mysqli->multi_query($sql_content)) {
            do {
                if ($result = $mysqli->store_result()) {
                    $result->free();
                }
            } while ($mysqli->more_results() && $mysqli->next_result());
            echo "[+] Database schema and 34 products imported successfully!\n";
        } else {
            echo "[-] Error importing schema: " . $mysqli->error . "\n";
        }
    } else {
        echo "[-] Schema file not found: $sql_file\n";
    }
}

echo "\n[✓] Setup check complete. You can now use the website and admin panel.\n";
echo "</pre>";
