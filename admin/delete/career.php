<?php
require('../../inc/function.php');
$b=$_REQUEST['bid'];

$banner=mysqli_query($conn,"select * from tbl_career where id='$b'");
$bannerData=mysqli_fetch_assoc($banner);
// @unlink("../../uploads/blogs/".$bannerData["b_image"]); 

$data=mysqli_query($conn,"DELETE FROM `tbl_career` WHERE `id`='$b'");
if($data==true)
{
	$_SESSION['warning']="Deleted successfully";
	header("location:../manage-career.php");
}
?>