<?php
$qs=$_REQUEST['id'];
require('../../inc/function.php');
$data=mysqli_query($conn,"select * from `tbl_breadcrumb` where `brd_id`='$qs'");
$rec=mysqli_fetch_array($data);
if($rec['brd_status']==0)
{
	mysqli_query($conn,"UPDATE `tbl_breadcrumb` SET `brd_status`='1' where `brd_id`='$qs'");
}
else
{
	mysqli_query($conn,"UPDATE `tbl_breadcrumb` SET `brd_status`='0' where `brd_id`='$qs'");
}
//header("location:../view_product.php")
?>