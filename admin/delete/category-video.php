<?php
require('../../inc/function.php');
$b=$_REQUEST['cid'];
$pid=$_REQUEST['pid'];
$banner=mysqli_query($conn,"select * from tbl_category_video where id_glry='$b'");
$bannerData=mysqli_fetch_assoc($banner);
@unlink("../../uploads/products/".$bannerData["glry_image"]); 

$data=mysqli_query($conn,"DELETE FROM `tbl_category_video` WHERE `id_glry`='$b'");
if($data==true)
{
	$_SESSION['warning']="Video Deleted successfully";
	header("location:../manage-category-video.php?pid=$pid");
}
?>