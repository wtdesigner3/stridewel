<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    @session_start();
}
if (!isset($_SESSION['admin_ses']) || $_SESSION['admin_ses'] !== "hvrs@#p9w84r" . session_id()) {
    echo json_encode(['success' => false, 'error' => 'Session expired or not authorized. Please log in again.']);
    exit;
}

require_once('../../inc/function.php');

$table = $_POST['table'] ?? $_GET['table'] ?? '';
$id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
$status = isset($_POST['status']) ? (int)$_POST['status'] : (isset($_GET['status']) ? (int)$_GET['status'] : null);
$field = $_POST['field'] ?? $_GET['field'] ?? 'status';

if (!$id || $status === null) {
    echo json_encode(['success' => false, 'error' => 'Invalid parameters provided.']);
    exit;
}

// Whitelist table and field mappings
$allowed_tables = [
    'tbl_hero_slides'   => ['pk' => 'id', 'fields' => ['status']],
    'tbl_product'       => ['pk' => 'id', 'fields' => ['status', 'is_featured']],
    'tbl_testimonial'   => ['pk' => 'tt_id', 'fields' => ['tt_status', 'status']],
    'tbl_category'      => ['pk' => 'id', 'fields' => ['status']],
    'tbl_blogs'         => ['pk' => 'b_id', 'fields' => ['b_status', 'status']],
    'tbl_faq'           => ['pk' => 'id', 'fields' => ['status', 'sort_order']],
    'tbl_home_why'      => ['pk' => 'id', 'fields' => ['status']],
    'tbl_home_pipeline' => ['pk' => 'id', 'fields' => ['status']],
    'tbl_home_trust'    => ['pk' => 'id', 'fields' => ['status']],
    'tbl_timeline'      => ['pk' => 'id', 'fields' => ['status']],
    'tbl_career'        => ['pk' => 'id', 'fields' => ['status']],
    'tbl_team'          => ['pk' => 'id', 'fields' => ['status']],
    'tbl_client'        => ['pk' => 'id', 'fields' => ['status']],
    'tbl_news'          => ['pk' => 'id', 'fields' => ['status']],
    'tbl_gallery'       => ['pk' => 'id', 'fields' => ['status']],
    'tbl_award'         => ['pk' => 'id', 'fields' => ['status']],
    'tbl_banner'        => ['pk' => 'id', 'fields' => ['status']],
    'tbl_faq_categories' => ['pk' => 'id', 'fields' => ['status']],
    'tbl_blog_categories' => ['pk' => 'id', 'fields' => ['status']]
];

if (!array_key_exists($table, $allowed_tables)) {
    echo json_encode(['success' => false, 'error' => 'Table not allowed: ' . htmlspecialchars($table)]);
    exit;
}

$config = $allowed_tables[$table];
$pk = $config['pk'];

if ($table === 'tbl_testimonial' && $field === 'status') {
    $field = 'tt_status';
} elseif ($table === 'tbl_blogs' && $field === 'status') {
    $field = 'b_status';
}

if (!in_array($field, $config['fields'])) {
    echo json_encode(['success' => false, 'error' => 'Field not allowed: ' . htmlspecialchars($field)]);
    exit;
}

$new_status = ($status == 1) ? 1 : 0;

if (!empty($conn)) {
    $safe_table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);
    $safe_field = preg_replace('/[^a-zA-Z0-9_]/', '', $field);
    $safe_pk    = preg_replace('/[^a-zA-Z0-9_]/', '', $pk);

    $update = mysqli_query($conn, "UPDATE `$safe_table` SET `$safe_field` = $new_status WHERE `$safe_pk` = $id");
    if ($update) {
        $status_label = ($new_status == 1) ? 'Active' : 'Inactive';
        if ($field === 'is_featured') {
            $status_label = ($new_status == 1) ? 'Featured' : 'Standard';
        }
        echo json_encode([
            'success'      => true,
            'table'        => $table,
            'id'           => $id,
            'field'        => $field,
            'new_status'   => $new_status,
            'status_label' => $status_label,
            'message'      => "Item #$id status set to $status_label."
        ]);
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => 'Database update error: ' . mysqli_error($conn)]);
        exit;
    }
}

echo json_encode([
    'success'      => false,
    'error'        => 'Database connection unavailable.'
]);
exit;
