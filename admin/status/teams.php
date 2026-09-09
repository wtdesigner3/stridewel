<?php
$qs=$_REQUEST['id'];
include('../../inc/function.php');
$data=mysqli_query($conn,"select * from `tbl_teams` where `tt_id`='$qs'");
$rec=mysqli_fetch_array($data);
if($rec['tt_status']==0)
{
	mysqli_query($conn,"UPDATE `tbl_teams` SET `tt_status`='1' where `tt_id`='$qs'");
}
else
{
	mysqli_query($conn,"UPDATE `tbl_teams` SET `tt_status`='0' where `tt_id`='$qs'");
}
//header("location:../view_product.php")
?>

