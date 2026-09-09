<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require('checksession.php'); 
require '../inc/function.php';     

$b=$_REQUEST['cid'];
$pid=$_REQUEST['pid'];
$bdata=mysqli_query($conn,"SELECT * FROM `tbl_category_video` where `id_glry`='$b'");
$brec=mysqli_fetch_array($bdata);
if(isset($_POST['update']))
{
  $link = mysqli_real_escape_string($conn,$_POST['link']); 
  $position = mysqli_real_escape_string($conn,$_POST['position']);
        $alt = mysqli_real_escape_string($conn,$_POST['alt']);
  $status = mysqli_real_escape_string($conn,$_POST['status']);
  $old = mysqli_real_escape_string($conn,$_POST['oldimg']);
  	$metatag = mysqli_real_escape_string($conn, $_POST['metatag']);
	$keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
	$metadesc = mysqli_real_escape_string($conn, $_POST['metadescription']);

    $bimage=$_FILES['bimage']['name'];
    if($bimage!='')
    {
      $bimage=time()."_".$bimage;
      @unlink("../uploads/products/".$old); 
      move_uploaded_file($_FILES["bimage"]["tmp_name"], "../uploads/products/".$bimage);
    }
    else
    {
        $bimage=$old;
    }
  

    $query=mysqli_query($conn,"UPDATE `tbl_category_video` SET `glry_link`='$link',`glry_image`='$bimage',`alt`='$alt',`glry_status`='$status',`glry_sort`='$position' WHERE `id_glry`='$b'");
    if($query==true)
    {
        $_SESSION['success']="Video Updated successfully";
        header("refresh:3;url=manage-category-video.php?pid=$pid");		
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
	<!-- end #header -->	
	<!-- begin #sidebar -->
	<?php require("includes/left.php"); ?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="javascript:;">Video Management</a></li>
				<li class="breadcrumb-item active">Edit Video</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
				<h1 class="page-header"><a href="javascript:;" onClick="javascript:history.go(-1)" class="btn btn-l btn-icon btn-circle btn-primary" data-click="panel-remove"><i class="fa fa-arrow-left"></i></a>Manage Video<small>...</small></h1>
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
							<h4 class="panel-title">Edit Video</h4>
						</div>
						<!-- end panel-heading -->
						
						<!-- begin panel-body -->
						<div class="panel-body">
							<form role="form" method="POST"  enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                      <label class="control-label">Video URL<span class="vd_red">*</span></label>
                            <input type="text" name="link" class="form-control" value="<?= $brec['glry_link']; ?>" placeholder="Ex: https://youtu.be/D6QCGtYwoLg?si=VJtu6tYVUyVI7BYa">
                    </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="bannerlink">Image File</label>
                            <input type="file"  name="bimage"  class="form-control" id="bannerlink">
                            <input type="hidden" name="oldimg"  value="<?= $brec['glry_image']; ?>">
                            <p class="help-block">Image dimension must be 565 X 420 & must be jpg format</p>
                            <img src="../uploads/products/<?= $brec['glry_image']; ?>" width="200px" height="150px">
                        </div>
                    </div>
                     <div class="col-sm-6">
                <div class="form-group">
                    <label for="heading">Alt</label>
                      <input type="text" name="alt" class="form-control" value="<?= $brec['alt']; ?>" placeholder="Enter Image Alt Here!">
                </div>
                </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Sort Number</label>
                            <input type="number" name="position" class="form-control" id="exampleInputPassword1" value="<?= $brec['glry_sort']; ?>">
                        </div>
                    </div>
                </div>
                	<div id="myDIV" style="display:none;border: 1px solid #000; padding: 9px;">
									<div class="form-group">
										<label for="metatag">Meta Title</label>
										<input type="text" name="metatag" id="metatag" placeholder="Meta Title" class="form-control" value="">
									</div>

									<div class="form-group">
										<label for="keyword">Meta Keyword</label>
										<textarea name="keyword" id="keyword" placeholder="Meta Keyword" class="form-control"></textarea>
									</div>

									<div class="form-group">
										<label for="metadescription">Meta Description</label>
										<textarea name="metadescription" id="metadescription" placeholder="Meta Description" class="form-control"></textarea>
									</div>
								</div><br>
                <div class="form-group">
                <input type="radio" value="1" id="optionsRadios3" name="status" <?php if($brec['glry_status']=='1'){ echo 'checked';}?>>
                <label for="optionsRadios3">Active</label>
                <input type="radio" value="0" id="optionsRadios4" name="status" <?php if($brec['glry_status']=='0'){ echo 'checked';}?>>
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
			CKEDITOR.replace( 'editor1' );
		});
	</script>
<!------------------------>
<script>
function test(t)
{
  var obj=new XMLHttpRequest();
  obj.open("GET","ajax/category.php?data="+t,true);
  obj.send();
  obj.onreadystatechange= function(){
    if(obj.readyState==4)
    {
      document.getElementById("sub").innerHTML=obj.responseText;
    }
  }
}
</script>
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
<script>
  function myGetlink() {
	var x = document.getElementById("myIMG");
	if (x.style.display === "block") {
	  x.style.display = "none";
	} else {
	  x.style.display = "block";
	}
  }
  </script>

</body>
</html>
