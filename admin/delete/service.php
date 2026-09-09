<?php
require('../../inc/function.php');
$b=$_REQUEST['bid'];

$banner=mysqli_query($conn,"select * from tbl_service where id='$b'");
$bannerData=mysqli_fetch_assoc($banner);
@unlink("../../uploads/product/".$bannerData["image"]); 
@unlink("../../uploads/product/".$bannerData["broadimage"]); 
// @unlink("../../uploads/products/".$bannerData["image3"]);
// @unlink("../../uploads/products/".$bannerData["broadimage"]);

$data=mysqli_query($conn,"DELETE FROM `tbl_service` WHERE `id`='$b'");
if($data==true)
{
	$_SESSION['warning']="Product Deleted successfully";
	header("location:../manage-service.php");
}
?>