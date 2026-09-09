<?php
require('../../inc/function.php');
$b=$_REQUEST['cid'];
$pid = $_GET['pid'];
$subsub=mysqli_query($conn,"select * from tbl_portfolio where b_category='$b'");
if(mysqli_num_rows($subsub)>0)
{
    echo "<script>alert('Please First Delete All Portfolio Related To This Category.');window.location.href='../manage-portfolio-category.php?pid=$pid';</script>";
}
else
{
    $catdata=mysqli_query($conn,"DELETE FROM `tbl_portfolio_category` WHERE `id`='$b'");
    if($catdata==true)
    {
        echo "<script>alert('Category Deleted successfully');window.location.href='../manage-portfolio-category.php?pid=$pid';</script>";
    }
}

?>