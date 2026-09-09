<?php
require('../../inc/function.php');
$b=$_REQUEST['cid'];
$data=mysqli_query($conn,"DELETE FROM `tbl_discount` WHERE `dis_id`='$b'");
if($data==true)
{
	header("location:../manage-discount.php");
}
?>