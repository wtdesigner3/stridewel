<?php
require('../../inc/function.php');
$b=$_REQUEST['cid'];
$subsub=mysqli_query($conn,"select * from tbl_blogs where b_category='$b'");
if(mysqli_num_rows($subsub)>0)
{
    echo "<script>alert('Please First Delete All Blogs Related To This Category.');window.location.href='../manage-blogcategory.php';</script>";
}
else
{
    $catdata=mysqli_query($conn,"DELETE FROM `tbl_blogcategory` WHERE `id`='$b'");
    if($catdata==true)
    {
        echo "<script>alert('Category Deleted successfully');window.location.href='../manage-blogcategory.php';</script>";
    }
}

?>