<?php
require('../../inc/function.php');
$b=$_REQUEST['bid'];
$data=mysqli_query($conn,"DELETE FROM `tbl_size` WHERE `id`='$b'");
if($data==true)
{
	$_SESSION['error']="Data Deleted successfully";
	header("location:../manage-size.php");
}
?>