<?php
require('../../inc/function.php');
$qs=$_GET['data'];
?>
<label for="heading">Sub-Sub SubCategory</label>
<select name="subsubsubcategory" class="form-control" >
<?php
echo '<option value="">Select Sub-Sub SubCategory</option>';
      $abc=mysqli_query($conn,"SELECT * FROM `tbl_subsubsubcategory` WHERE `subsubcategory_id`='$qs' AND `sssc_status`='1' ");
	  while($atc=mysqli_fetch_array($abc))
	   {
	 ?>	
		<option value="<?= $atc['sssc_id']; ?>"><?= $atc['sssc_name'];?></option>
	<?php
    }
?>
</select>