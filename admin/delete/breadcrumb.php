<?php
require('../../inc/function.php');
$b=$_REQUEST['bid'];
$data=mysqli_query($conn,"DELETE FROM `tbl_breadcrumb` WHERE `brd_id`='$b'");
if($data==true)
{
	$_SESSION['warning']="Breadcrumb Deleted successfully";
	header("location:../manage-breadcrumb.php");
}
?>