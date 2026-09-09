<?php
require('../../inc/function.php');
$b=$_REQUEST['bid'];
$banner=mysqli_query($conn,"select * from tbl_blog_tags where id='$b'");
$bannerData=mysqli_fetch_assoc($banner);
$idd = $bannerData['b_id'];

$data=mysqli_query($conn,"DELETE FROM `tbl_blog_tags` WHERE `id`='$b'");
if($data==true)
{
    echo "<script>alert('Blog Tags Deleted successfully'); </script>";
	header("location:../manage-blog-tags.php");
}
?>