<?php
require('../../inc/function.php');
$b=$_REQUEST['bid'];

$banner=mysqli_query($conn,"select * from tbl_visa_counter where vt_id='$b'");
$bannerData=mysqli_fetch_assoc($banner);
@unlink("../../uploads/counter/".$bannerData["vt_image"]); 

$data=mysqli_query($conn,"DELETE FROM `tbl_visa_counter` WHERE `vt_id`='$b'");
if($data==true)
{
	$_SESSION['warning']="Counter Deleted successfully";
	header("location:../manage-visa-counter.php");
}
?>