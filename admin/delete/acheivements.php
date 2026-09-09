<?php
require('../../inc/function.php');
$b=$_REQUEST['bid'];

$data=mysqli_query($conn,"DELETE FROM `tbl_acheivements` WHERE `id`='$b'");
if($data==true)
{
	$_SESSION['warning']="Acheivements Deleted successfully";
	header("location:../manage-acheivements.php");
}
?>