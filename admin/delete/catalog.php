<?php
require('../../inc/function.php');
$b=$_REQUEST['bid'];

$banner=mysqli_query($conn,"select * from tbl_catalog where id='$b'");
$bannerData=mysqli_fetch_assoc($banner);
@unlink("../../uploads/catalog/".$bannerData["b_image"]); 

$data=mysqli_query($conn,"DELETE FROM `tbl_catalog` WHERE `id`='$b'");
if($data==true)
{
	$_SESSION['warning']="catalog Deleted successfully";
	header("location:../manage-catalog.php");
}
?>