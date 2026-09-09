<?php
require('../../inc/function.php');

$dept2 = $_POST["sub_cat"];
$sql2=mysqli_query($conn,"select * from `tbl_category` where `id`='$dept2' and status='1'");
$catego = mysqli_fetch_array($sql2);
$subcat = $catego['id'];

if(!empty($_POST["sub_cat"])) 
{
$query =mysqli_query($conn,"SELECT * FROM `tbl_subcategory` WHERE `category_id` = '$dept2'");
while($row=mysqli_fetch_array($query))  
{
?>
<option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
<?php
}
}
?>
