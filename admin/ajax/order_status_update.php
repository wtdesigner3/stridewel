<?php
// Include your database connection file
require('../../inc/function.php');

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if status and order_id are set in the POST data
    if (isset($_POST['status']) && isset($_POST['order_id'])) {
        $status = $_POST['status'];
        $order_id = $_POST['order_id'];

        // Update the status in the database
        $sql = "UPDATE tbl_orders SET status = '$status' WHERE id = '$order_id'";
        
        if ($conn->query($sql) === TRUE) {
            // If update is successful, send a success response
            echo json_encode(array('status' => 'success'));
        } else {
            // If update fails, send an error response
            echo json_encode(array('status' => 'error', 'message' => 'Failed to update status'));
        }
    } else {
        // If status or order_id is not set in the POST data, send an error response
        echo json_encode(array('status' => 'error', 'message' => 'Status or order ID is missing'));
    }
} else {
    // If the request is not a POST request, send an error response
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}
?>
