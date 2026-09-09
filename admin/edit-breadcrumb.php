<?php
require('checksession.php'); 
require('../inc/function.php'); 

$b=$_REQUEST['bid'];
$bdata=mysqli_query($conn,"SELECT * FROM `tbl_breadcrumb` where `brd_id`='$b'");
$brec=mysqli_fetch_array($bdata);
if(isset($_POST['update']))
{
   $title = mysqli_real_escape_string($conn,$_POST['title']); 
   $sort = mysqli_real_escape_string($conn,$_POST['position']); 
   $status = mysqli_real_escape_string($conn,$_POST['status']); 
     $metatag = mysqli_real_escape_string($conn,$_POST['metatag']);
	$keyword = mysqli_real_escape_string($conn,$_POST['keyword']);
	$metadesc = mysqli_real_escape_string($conn,$_POST['metadescription']);
	$headtag = mysqli_real_escape_string($conn,$_POST['headtag']);
   $old = mysqli_real_escape_string($conn,$_POST['oldimg']); 
   $bimage=$_FILES['bimage']['name'];
   if($bimage!='')
   {
      $bimage=time()."_".$bimage;
      @unlink("../uploads/breadcrumb/".$old); 
      move_uploaded_file($_FILES["bimage"]["tmp_name"], "../uploads/breadcrumb/".$bimage);
   }
     else
   {
	   $bimage=$brec['brd_image'];
   }
   $query=mysqli_query($conn,"UPDATE `tbl_breadcrumb` SET `brd_image`='$bimage',`brd_name`='$title',`brd_sort`='$sort',`brd_status`='$status',`metatag`='$metatag',`metakeyword`='$keyword',`metadesc`='$metadesc',`headtag`='$headtag' WHERE `brd_id`='$b'");
   if($query==true)
      {
	  $_SESSION['success']="Breadcrumb Updated Successfully";	
	  header("refresh:3;url=manage-breadcrumb.php");
      }
      else 
      {
	   $_SESSION['error']="Something went wrong. Please try again";		
      }
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php require("includes/head.php"); ?>
<body>
	<!-- begin #page-container -->
	<?php require("includes/header.php"); ?>
	<!-- begin #sidebar -->
	<?php require("includes/left.php"); ?>
	<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="javascript:;">Home Management</a></li>
				<li class="breadcrumb-item active">Edit Breadcrumb</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header"><a href="javascript:;" onClick="javascript:history.go(-1)" class="btn btn-l btn-icon btn-circle btn-primary" data-click="panel-remove"><i class="fa fa-arrow-left"></i></a> Manage Breadcrumb </h1>
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
							<h4 class="panel-title"> Edit Breadcrumb</h4>
						</div>
						<!-- begin panel-body -->
						<div class="panel-body">
			<form role="form"  method="POST"  enctype="multipart/form-data">
              <div class="box-body">
           
                <div class="form-group">
                    <label for="banner">Breadcrumb Title</label>
                    <input type="text" name="title" class="form-control" id="banner" value="<?= $brec['brd_name']; ?>" >
                </div>
        
                
                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <input type="file" name="bimage" class="form-control" id="exampleInputFile">
                  <input type="hidden" name="oldimg"  value="<?= $brec['brd_image']; ?>">
                   <p class="help-block">Image dimension must be 1920 X 500 & must be jpg format</p>
                   <img src="../uploads/breadcrumb/<?= $brec['brd_image']; ?>" style="width:20%;">
                </div>

                <div class="form-group d-none">
                  <label for="exampleInputPassword1">Breadcrumb position</label>
                  <input type="number" name="position" class="form-control" id="exampleInputPassword1" value="<?= $brec['brd_sort']; ?>">
                </div>
           
                <div id="myDIV" style="display:none;border: 1px solid #000; padding: 9px;"> 
                    <div class="form-group">
                      <label for="metatag">Meta Title</label>
                      <input type="text" name="metatag" id="metatag" placeholder="Meta Title" class="form-control" value="<?= $brec['metatag']; ?>">
                    </div>
                    
                      <div class="form-group">
                      <label for="keyword">Meta Keyword</label>
                      <textarea name="keyword" id="keyword" placeholder="Meta Keyword" class="form-control" ><?= $brec['metakeyword']; ?></textarea>
                    </div>
                    
                    <div class="form-group">
                      <label for="metadescription">Meta Description</label>
                      <textarea name="metadescription" id="metadescription" placeholder="Meta Description" class="form-control" ><?= $brec['metadesc']; ?></textarea>
                    </div>
                    
                    <div class="form-group">
                      <label for="metadescription">Head tag Detail</label>
                      <textarea name="headtag" id="headtag" rows="5" placeholder="Head Tag" class="form-control" ><?= $brec['headtag']; ?></textarea>
                    </div>
                    
                </div><br>
                <div class="form-group">
                <input type="radio" value="1" id="optionsRadios3" name="status" <?php if($brec['brd_status']=='1'){ echo 'checked';}?>>
                <label for="optionsRadios3">Active</label>
                
                <input type="radio" value="0" id="optionsRadios4" name="status" <?php if($brec['brd_status']=='0'){ echo 'checked';}?>>
                <label for="optionsRadios4">Inactive</label>
                </div>
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="update" class="btn btn-primary">Click Here To Update</button>
                <button type="reset" name="reset" class="btn btn-danger">Reset</button>
                  <button type="button" onclick="myFunction()" class="btn btn-warning">Seo tools</button>
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
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
	
<?php require("includes/footer.php"); ?>

    	
	<script>
		$(document).ready(function() {
			App.init();
			TableManageResponsive.init();
		});
	</script>
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
