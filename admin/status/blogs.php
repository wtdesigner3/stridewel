<?php
$qs=$_REQUEST['id'];
require('../../inc/function.php');
$data=mysqli_query($conn,"select * from `tbl_blogs` where `b_id`='$qs'");
$rec=mysqli_fetch_array($data);
if($rec['b_status']==0)
{
	mysqli_query($conn,"UPDATE `tbl_blogs` SET `b_status`='1' where `b_id`='$qs'");
}
else
{
	mysqli_query($conn,"UPDATE `tbl_blogs` SET `b_status`='0' where `b_id`='$qs'");
}
//header("location:../view_product.php")
?>