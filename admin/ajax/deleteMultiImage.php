<?php
require('../../inc/function.php');

$id = $_REQUEST['id'];
$index = $_REQUEST['index'];

$bdata = mysqli_query($conn, "SELECT * FROM `tbl_package` where `p_id`='$id'");
$brec = mysqli_fetch_array($bdata);

$images = explode(',', $brec['p_b2_image']);

unset($images[$index]);

$new_images = implode(',', $images);

mysqli_query($conn, "UPDATE `tbl_package` SET `p_b2_image`='$new_images' WHERE `p_id`='$id'");
?>
