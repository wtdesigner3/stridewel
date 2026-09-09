<?php
require('../../inc/function.php');
$pro=$_REQUEST['product'];
$data=mysqli_query($conn,"DELETE FROM `tbl_product` WHERE `id`='$pro'");
if($data==true)
{
	$_SESSION['error']="Product Deleted successfully";
	header("location:../manage-product.php");
}
?>