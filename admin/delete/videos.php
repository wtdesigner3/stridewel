<?php
require('../../inc/function.php');
$b=$_REQUEST['bid'];
$pid = $_GET['pid'];
$banner=mysqli_query($conn,"select * from tbl_videos where b_id='$b'");
$bannerData=mysqli_fetch_assoc($banner);
@unlink("../../uploads/videosimage/".$bannerData["b_image"]); 

$data=mysqli_query($conn,"DELETE FROM `tbl_videos` WHERE `b_id`='$b'");
if($data==true)
{
	$_SESSION['warning']="Video Deleted successfully";
	header("location:../manage-videos.php?pid=$pid");
}
?>