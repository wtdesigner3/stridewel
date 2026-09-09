<?php
$qs=$_REQUEST['id'];
include('../../inc/function.php');
$data=mysqli_query($conn,"select * from `tbl_users` where `id`='$qs'");
$rec=mysqli_fetch_array($data);
if($rec['status']==0)
{
	mysqli_query($conn,"UPDATE `tbl_users` SET `status`='1' where `id`='$qs'");
    header("location:../manage-users.php");
}
else
{
	mysqli_query($conn,"UPDATE `tbl_users` SET `status`='0' where `id`='$qs'");
    header("location:../manage-users.php");
}
?>

