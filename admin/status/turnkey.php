<?php
$qs=$_REQUEST['id'];
include('../../inc/function.php');
$data=mysqli_query($conn,"select * from `tbl_turnkey` where `id`='$qs'");
$rec=mysqli_fetch_array($data);
if($rec['status']==0)
{
	mysqli_query($conn,"UPDATE `tbl_turnkey` SET `status`='1' where `id`='$qs'");
}
else
{
	mysqli_query($conn,"UPDATE `tbl_turnkey` SET `status`='0' where `id`='$qs'");
}
?>

