<?php
require('../../inc/function.php');
$qs=$_GET['data'];
?>
<label for="heading">Sub Category</label>
<select name="subcategory" class="form-control" >
<?php
echo '<option value="">Select Sub Category</option>';
      $abc=mysqli_query($conn,"SELECT * FROM `tbl_subcategory` WHERE `category_id`='$qs' AND is_page='Submenu' AND `status`='1' ");
	  while($atc=mysqli_fetch_array($abc))
	   {
	 ?>	
		<option value="<?= $atc['name']; ?>"><?= $atc['name'];?></option>
	<?php
    }
?>
</select>