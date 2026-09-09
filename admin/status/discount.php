<?php
$qs=$_REQUEST['id'];
include('../../inc/function.php');
$data=mysqli_query($conn,"select * from `tbl_discount` where `dis_id`='$qs'");
$rec=mysqli_fetch_array($data);
if($rec['dis_status']==0)
{
	mysqli_query($conn,"UPDATE `tbl_discount` SET `dis_status`='1' where `dis_id`='$qs'");
}
else
{
	mysqli_query($conn,"UPDATE `tbl_discount` SET `dis_status`='0' where `dis_id`='$qs'");
}
header("location:../manage-discount.php")
?>
