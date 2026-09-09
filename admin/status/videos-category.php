<?php
$qs=$_REQUEST['id'];
include('../../inc/function.php');
$data=mysqli_query($conn,"select * from `tbl_videos_category` where `id`='$qs'");
$rec=mysqli_fetch_array($data);
if($rec['status']==0)
{
	mysqli_query($conn,"UPDATE `tbl_videos_category` SET `status`='1' where `id`='$qs'");
	mysqli_query($conn,"UPDATE `tbl_videos` SET `b_status`='1' where `b_category`='$qs'");
}
else
{
	mysqli_query($conn,"UPDATE `tbl_videos_category` SET `status`='0' where `id`='$qs'");
	mysqli_query($conn,"UPDATE `tbl_videos` SET `b_status`='0' where `b_category`='$qs'");
}
//header("location:../view_product.php")
?>

