<?php
$qs=$_REQUEST['id'];
require('../../inc/function.php');
$data=mysqli_query($conn,"select * from `tbl_banner` where `bnr_id`='$qs'");
$rec=mysqli_fetch_array($data);
if($rec['bnr_status']==0)
{
	mysqli_query($conn,"UPDATE `tbl_banner` SET `bnr_status`='1' where `bnr_id`='$qs'");
}
else
{
	mysqli_query($conn,"UPDATE `tbl_banner` SET `bnr_status`='0' where `bnr_id`='$qs'");
}
//header("location:../view_product.php")
?>