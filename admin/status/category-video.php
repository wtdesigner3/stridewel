<?php
$qs=$_REQUEST['id'];
require('../../inc/function.php');
$data=mysqli_query($conn,"select * from `tbl_category_video` where `id_glry`='$qs'");
$rec=mysqli_fetch_array($data);
if($rec['glry_status']==0)
{
	mysqli_query($conn,"UPDATE `tbl_category_video` SET `glry_status`='1' where `id_glry`='$qs'");
}
else
{
	mysqli_query($conn,"UPDATE `tbl_category_video` SET `glry_status`='0' where `id_glry`='$qs'");
}
//header("location:../view_product.php")
?>