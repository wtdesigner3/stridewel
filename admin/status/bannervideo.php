<?php
$qs=$_REQUEST['id'];
require('../../inc/function.php');
$data=mysqli_query($conn,"select * from `tbl_banner_video` where `sc_id`='$qs'");
$rec=mysqli_fetch_array($data);
if($rec['sc_status']==0)
{
	mysqli_query($conn,"UPDATE `tbl_banner_video` SET `sc_status`='1' where `sc_id`='$qs'");
}
else
{
	mysqli_query($conn,"UPDATE `tbl_banner_video` SET `sc_status`='0' where `sc_id`='$qs'");
}
//header("location:../view_product.php")
?>