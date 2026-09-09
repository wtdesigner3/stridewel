<?php
require('../../inc/function.php');
$b=$_REQUEST['bid'];

$banner=mysqli_query($conn,"select * from tbl_service_category where id='$b'");
$bannerData=mysqli_fetch_assoc($banner);
// @unlink("../../uploads/products/".$bannerData["image"]); 
// @unlink("../../uploads/products/".$bannerData["image2"]); 
// @unlink("../../uploads/products/".$bannerData["image3"]);
// @unlink("../../uploads/products/".$bannerData["broadimage"]);

$data=mysqli_query($conn,"DELETE FROM `tbl_service_category` WHERE `id`='$b'");
if($data==true)
{
	$_SESSION['warning']="Service Category Deleted successfully";
	header("location:../manage-service-category.php");
}
?>