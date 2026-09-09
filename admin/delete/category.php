<?php
require('../../inc/function.php');
$b=$_REQUEST['cid'];
	$subcat=mysqli_query($conn,"select * from tbl_subcategory where category_id='$b'");
	if(mysqli_num_rows($subcat)>0)
	{
		 echo "<script>alert('Please Delete Subcategory To  Delete This Category'); </script>";
		header("Refresh:1;url=../manage-category.php");
	}
	else
	{
		$data=mysqli_query($conn,"DELETE FROM `tbl_category` WHERE `id`='$b'");
		if($data==true)
		{
			 echo "<script>alert('Category Deleted successfully'); </script>";
			header("Refresh:1;url=../manage-category.php");
		}
}

?>