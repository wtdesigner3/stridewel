<?php
require('../../inc/function.php');
$b=$_REQUEST['bid'];

$banner=mysqli_query($conn,"select * from tbl_testimonial where tt_id='$b'");
$bannerData=mysqli_fetch_assoc($banner);
@unlink("../../uploads/testimonial/".$bannerData["tt_image"]); 


$data=mysqli_query($conn,"DELETE FROM `tbl_testimonial` WHERE `tt_id`='$b'");
if($data==true)
{
	$_SESSION['warning']="Testimonial Deleted successfully";
	header("location:../manage-testimonial.php");
}
?>