<?php
require('../../inc/function.php');
$b=$_REQUEST['bid'];

$banner=mysqli_query($conn,"select * from tbl_teams where tt_id='$b'");
$bannerData=mysqli_fetch_assoc($banner);
@unlink("../../uploads/team/".$bannerData["tt_image"]); 


$data=mysqli_query($conn,"DELETE FROM `tbl_teams` WHERE `tt_id`='$b'");
if($data==true)
{
	$_SESSION['warning']="Team Deleted successfully";
	header("location:../manage-team.php");
}
?>