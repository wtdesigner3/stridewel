<?php
require('../../inc/function.php');
$pro=$_REQUEST['turnkey'];
$data=mysqli_query($conn,"DELETE FROM `tbl_turnkey` WHERE `id`='$pro'");
if($data==true)
{
	$_SESSION['error']="Turnkey Deleted successfully";
	header("location:../manage-turnkey.php");
}
?>