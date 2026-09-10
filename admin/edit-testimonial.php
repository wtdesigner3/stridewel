<?php
require('checksession.php');
include '../inc/function.php'; 

$b = (int)($_REQUEST['id'] ?? $_REQUEST['cid'] ?? $_REQUEST['bid'] ?? 0);
$bdata = mysqli_query($conn, "SELECT * FROM `tbl_testimonial` where `tt_id`='$b'");
$brec = mysqli_fetch_array($bdata);
if (!$brec && isset($b)) {
    $bdata = mysqli_query($conn, "SELECT * FROM `tbl_testimonial` ORDER BY `tt_id` DESC LIMIT 1");
    $brec = mysqli_fetch_array($bdata);
    if ($brec) $b = (int)$brec['tt_id'];
}
if(isset($_POST['update']))
{
  $name = mysqli_real_escape_string($conn,$_POST['name']); 
  $location = mysqli_real_escape_string($conn,$_POST['location']); 
  $description = mysqli_real_escape_string($conn,$_POST['description']); 
  $status = mysqli_real_escape_string($conn,$_POST['status']); 
  $sort = mysqli_real_escape_string($conn,$_POST['sort']); 
  $old = mysqli_real_escape_string($conn,$_POST['oldimg']);  
  $alt = mysqli_real_escape_string($conn,$_POST['alt']); 
  $bimage=$_FILES['bimage']['name'];
  if($bimage!="")
  {
   $bimage=time()."_".$bimage;
   @unlink("../uploads/testimonial/".$old); 
   move_uploaded_file($_FILES["bimage"]["tmp_name"], "../uploads/testimonial/".$bimage);

  }
   else
  {
	 $bimage=$brec['tt_image'];
  }
  
   $query=mysqli_query($conn,"UPDATE `tbl_testimonial` SET `tt_image`='$bimage',`tt_alt`='$alt',`tt_name`='$name', `tt_location`='$location', `tt_sort`='$sort', `tt_detail`='$description', `tt_status`='$status' WHERE `tt_id`='$b'");
      if($query==true)
      {
        $_SESSION['success']="Testimonial Updated successfully";
		    header("refresh:3;url=manage-testimonial.php");	
      }
      else 
      {
		      $_SESSION['error']="Something went wrong";
      }
  } 
  ?>
<!DOCTYPE html>
<html lang="en">
<?php require("includes/head.php"); ?>
<body>
	
	
	<!-- begin #page-container -->
	<?php require("includes/header.php"); ?>
	<!-- end #header -->	
	<!-- begin #sidebar -->
	<?php require("includes/left.php"); ?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">Testimonial Management</a></li>
				<li class="breadcrumb-item active">Edit Testimonial</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header"><a href="javascript:;" onClick="javascript:history.go(-1)" class="btn btn-l btn-icon btn-circle btn-primary" data-click="panel-remove"><i class="fa fa-arrow-left"></i></a> Edit Testimonial</h1>
			<!-- end page-header -->
			<!-- begin row -->
			<div class="row">
				<!-- begin col-10 -->
				<div class="col-lg-12">
					<!-- begin panel -->
					<div class="panel panel-inverse">
						<!-- begin panel-heading -->
						<div class="panel-heading">
							<div class="panel-heading-btn">
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
							</div>
							<h4 class="panel-title">Edit Testimonial</h4>
						</div>
						<!-- end panel-heading -->
						
						<!-- begin panel-body -->
						<div class="panel-body">
							<form role="form" method="POST"  enctype="multipart/form-data">
              <div class="box-body">
             
  				<div class="row">
					  <div class="col-sm-6">
						<div class="form-group">
							<label for="heading">Name</label>
							<input type="text"  name="name" class="form-control" id="heading" value="<?= $brec['tt_name']; ?>">
						</div>
					  </div>
					  <div class="col-sm-6">
					 	 <div class="form-group">
							<label for="bannerlink">Designation</label>
							<input type="text"  name="location"  value="<?= $brec['tt_location']; ?>" class="form-control" id="bannerlink">
						</div>
					  </div>
				  </div>

                
                <div class="form-group">
                  <label>Description</label>
                    <textarea  name="description" class="textarea form-control" id="editor1"><?= $brec['tt_detail']; ?></textarea>
                </div>

                <div class="row">
                <div class="col-sm-6">
				<div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <input type="file" name="bimage" class="form-control" id="exampleInputFile">
                  <input type="hidden" name="oldimg"  value="<?= $brec['tt_image']; ?>">
                   <p class="help-block">Image dimension must be 106 X 106 & must be jpg format</p>
                   <img src="../uploads/testimonial/<?= $brec['tt_image']; ?>" style="width:10%;">
                </div>
                </div>
                 <div class="col-sm-6">
			 	 <div class="form-group">
					<label for="bannerlink">Alt</label>
					<input type="text"  name="alt"  value="<?= $brec['tt_alt']; ?>" class="form-control">
				</div>
				</div>
				</div>
				 <div class="form-group">
                  <label for="bannerlink">Position</label>
                  <input type="number"  name="sort"  value="<?= $brec['tt_sort']; ?>" class="form-control" id="bannerlink">
                </div>
                <div class="form-group">
                <input type="radio" value="1" id="optionsRadios3" name="status" <?php if($brec['tt_status']=='1'){ echo 'checked';}?>>
                <label for="optionsRadios3">Active</label>
                <input type="radio" value="0" id="optionsRadios4" name="status" <?php if($brec['tt_status']=='0'){ echo 'checked';}?>>
                <label for="optionsRadios4">Inactive</label>
                </div>


              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="update" class="btn btn-primary">Click Here To Update</button>
                <button type="reset" name="reset" class="btn btn-danger">Reset</button>
              
              </div>
            </form>
						</div>
						<!-- end panel-body -->
					</div>
					<!-- end panel -->
				</div>
				<!-- end col-10 -->
			</div>
			<!-- end row -->
		</div>
		<!-- end #content -->
		
		
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
	
<?php require("includes/footer.php"); ?>
	
	
<script>
$(document).ready(function() {
	App.init();
CKEDITOR.replace('editor1', {
    filebrowserUploadUrl: 'assets/ckeditor/samples/get_imagelink.php',
});
CKEDITOR.replace('editor2', {
    filebrowserUploadUrl: 'assets/ckeditor/samples/get_imagelink.php',
});
});
</script>
<!------------------------>

<!------------------------------>    
    
<script>
function myFunction() {
  var x = document.getElementById("myDIV");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
</script>

</body>
</html>
