<?php
require('../../inc/function.php');
$pro=$_REQUEST['id'];
$data=mysqli_query($conn,"DELETE FROM `tbl_orders` WHERE `id`='$pro'");
if($data==true)
{
	$_SESSION['error']="Order Deleted successfully";
header("Location: " . $_SERVER['HTTP_REFERER']);
}
?>