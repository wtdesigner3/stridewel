<?php
require('../../inc/function.php');
$b=$_REQUEST['bid'];
$data=mysqli_query($conn,"DELETE FROM `tbl_contacts` WHERE `id`='$b'");
if($data==true)
{
	$_SESSION['warning']="Contact Deleted successfully";
	header("location:../manage-contacts.php");
}
?>