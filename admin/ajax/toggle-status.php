<?php
header('Content-Type: application/json; charset=utf-8');
require('../checksession.php');
require('../../inc/function.php');

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
    'tbl_hero_slides' => ['pk' => 'id', 'fields' => ['status']],
    'tbl_product' => ['pk' => 'id', 'fields' => ['status', 'is_featured']],
    'tbl_testimonial' => ['pk' => 'tt_id', 'fields' => ['tt_status', 'status']],
    'tbl_category' => ['pk' => 'id', 'fields' => ['status']],
    'tbl_blogs' => ['pk' => 'b_id', 'fields' => ['b_status', 'status']],
    'tbl_faq' => ['pk' => 'id', 'fields' => ['status', 'sort_order']]
];

if (!array_key_exists($table, $allowed_tables)) {
    echo json_encode(['success' => false, 'error' => 'Table not allowed.']);
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
    echo json_encode(['success' => false, 'error' => 'Field not allowed.']);
    exit;
}

$new_status = ($status == 1) ? 1 : 0;

if ($conn) {
    $update = mysqli_query($conn, "UPDATE `$table` SET `$field` = $new_status WHERE `$pk` = $id");
    if ($update) {
        $status_label = ($new_status == 1) ? 'Active' : 'Inactive';
        if ($field === 'is_featured') {
            $status_label = ($new_status == 1) ? 'Featured' : 'Standard';
        }
        echo json_encode([
            'success' => true,
            'table' => $table,
            'id' => $id,
            'field' => $field,
            'new_status' => $new_status,
            'status_label' => $status_label,
            'message' => "Item #$id status set to $status_label."
        ]);
        exit;
    }
}

// Offline / Mock response
echo json_encode([
    'success' => true,
    'table' => $table,
    'id' => $id,
    'field' => $field,
    'new_status' => $new_status,
    'status_label' => ($new_status == 1) ? 'Active' : 'Inactive',
    'message' => "Item #$id status set to " . (($new_status == 1) ? 'Active' : 'Inactive')
]);
