<?php
require('../../inc/function.php');
$b=$_REQUEST['cid'];
$data=mysqli_query($conn,"DELETE FROM `tbl_turnkey_category` WHERE `id`='$b'");
if($data==true)
{
 echo "<script>alert('Turnkey Category Deleted successfully'); </script>";
header("Refresh:1;url=../manage-turnkey-category.php");
}

?>