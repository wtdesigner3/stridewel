<?php
require('../../inc/function.php');
$b=$_REQUEST['cid'];
$pid=$_REQUEST['pid'];
$banner=mysqli_query($conn,"select * from tbl_client_video where id_glry='$b'");
$bannerData=mysqli_fetch_assoc($banner);
@unlink("../../uploads/products/".$bannerData["glry_image"]); 

$data=mysqli_query($conn,"DELETE FROM `tbl_client_video` WHERE `id_glry`='$b'");
if($data==true)
{
	$_SESSION['warning']="Video Deleted successfully";
	header("location:../manage-client-video.php?pid=$pid");
}
?>