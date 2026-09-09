<?php
require('../../inc/function.php');
$b=$_REQUEST['cid'];
$pid = $_GET['pid'];
$subsub=mysqli_query($conn,"select * from tbl_videos where b_category='$b'");
if(mysqli_num_rows($subsub)>0)
{
    echo "<script>alert('Please First Delete All Videos Related To This Category.');window.location.href='../manage-videos-category.php?pid=$pid';</script>";
}
else
{
    $catdata=mysqli_query($conn,"DELETE FROM `tbl_videos_category` WHERE `id`='$b'");
    if($catdata==true)
    {
        echo "<script>alert('Category Deleted successfully');window.location.href='../manage-videos-category.php?pid=$pid';</script>";
    }
}

?>