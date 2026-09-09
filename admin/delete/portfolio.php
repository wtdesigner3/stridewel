<?php
require('../../inc/function.php');
$b=$_REQUEST['bid'];
$pid = $_GET['pid'];
$banner=mysqli_query($conn,"select * from tbl_portfolio where b_id='$b'");
$bannerData=mysqli_fetch_assoc($banner);
@unlink("../../uploads/portfolioimage/".$bannerData["b_image"]); 

$data=mysqli_query($conn,"DELETE FROM `tbl_portfolio` WHERE `b_id`='$b'");
if($data==true)
{
	$_SESSION['warning']="Video Deleted successfully";
	header("location:../manage-portfolio.php?pid=$pid");
}
?>