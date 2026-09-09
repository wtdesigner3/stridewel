<?php
require('../../inc/function.php');
$b=$_REQUEST['bid'];

$banner=mysqli_query($conn,"select * from tbl_award where id='$b'");
$bannerData=mysqli_fetch_assoc($banner);
@unlink("../../uploads/award/".$bannerData["image"]); 

$data=mysqli_query($conn,"DELETE FROM `tbl_award` WHERE `id`='$b'");
if($data==true)
{
	$_SESSION['warning']="Award Deleted successfully";
	header("location:../manage-award.php");
}
?>