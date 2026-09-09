<?php
require('../../inc/function.php');
$b=$_REQUEST['bid'];

$banner=mysqli_query($conn,"select * from tbl_case_study where b_id='$b'");
$bannerData=mysqli_fetch_assoc($banner);
// @unlink("../../uploads/blogs/".$bannerData["b_image"]); 

$data=mysqli_query($conn,"DELETE FROM `tbl_case_study` WHERE `b_id`='$b'");
if($data==true)
{
	$_SESSION['warning']="Deleted successfully";
	header("location:../manage-case-study.php");
}
?>