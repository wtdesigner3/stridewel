<?php
require('../../inc/function.php');
$b=$_REQUEST['bid'];

$banner=mysqli_query($conn,"select * from tbl_gallery where id='$b'");
$bannerData=mysqli_fetch_assoc($banner);
@unlink("../../uploads/gallery/".$bannerData["image"]); 


$data=mysqli_query($conn,"DELETE FROM `tbl_gallery` WHERE `id`='$b'");
if($data==true)
{
	$_SESSION['warning']="Gallery Deleted successfully";
	header("location:../manage-gallery.php");
}
?>