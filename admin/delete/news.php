<?php
require('../../inc/function.php');
$b=$_REQUEST['bid'];

$banner=mysqli_query($conn,"select * from tbl_news where id='$b'");
$bannerData=mysqli_fetch_assoc($banner);
@unlink("../../uploads/news/".$bannerData["image"]); 

$data=mysqli_query($conn,"DELETE FROM `tbl_news` WHERE `id`='$b'");
if($data==true)
{
	$_SESSION['warning']="Deleted successfully";
	header("location:../manage-news.php");
}
?>