<?php
require('../../inc/function.php');
$b=$_REQUEST['bid'];

$banner=mysqli_query($conn,"select * from tbl_banner where bnr_id='$b'");
$bannerData=mysqli_fetch_assoc($banner);
@unlink("../../uploads/banner/".$bannerData["bnr_image"]); 

$data=mysqli_query($conn,"DELETE FROM `tbl_banner` WHERE `bnr_id`='$b'");
if($data==true)
{
	$_SESSION['warning']="Banner Deleted successfully";
	header("location:../manage-banner.php");
}
?>