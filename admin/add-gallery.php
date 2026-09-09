<?php

require('checksession.php'); 
require '../inc/function.php';     

if(isset($_POST['update']))
{ 
  $name = mysqli_real_escape_string($conn,$_POST['name']); 
  $project_id = mysqli_real_escape_string($conn,$_POST['project_id']); 
  $position = mysqli_real_escape_string($conn,$_POST['position']);
  $status = mysqli_real_escape_string($conn,$_POST['status']);

    $bimage=$_FILES['bimage']['name'];
    if($bimage!='')
    {
      $bimage=time()."_".$bimage;
      move_uploaded_file($_FILES["bimage"]["tmp_name"], "../uploads/gallery/".$bimage);
    }
    else
    {
        $bimage='';
    }

// change this query to insert query
    $query=mysqli_query($conn,"INSERT INTO `tbl_gallery` (`project_id`, `image`, `status`, `sort`) VALUES ('$project_id', '$bimage', '$status', '$position')");
    if($query==true)
    {
        $_SESSION['success']="Gallery Added successfully";
        header("refresh:3;url=manage-gallery.php");		
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
				<li class="breadcrumb-item"><a href="javascript:;">Gallery Management</a></li>
				<li class="breadcrumb-item active">Add Gallery</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
				<h1 class="page-header"><a href="javascript:;" onClick="javascript:history.go(-1)" class="btn btn-l btn-icon btn-circle btn-primary" data-click="panel-remove"><i class="fa fa-arrow-left"></i></a>Manage Gallery<small>...</small></h1>
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
							<h4 class="panel-title">Add Gallery</h4>
						</div>
						<!-- end panel-heading -->
						
						<!-- begin panel-body -->
						<div class="panel-body">
							<form role="form" method="POST"  enctype="multipart/form-data">
                <div class="box-body">
                   
                <div class="form-group d-none">
                    <label for="exampleInputPassword1">Name</label>
                    <input type="text" name="name" class="form-control" id="exampleInputPassword1" value="<?= $brec['name']; ?>">
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Project</label>
                    <select name="project_id" class="form-control">
                        <option value="">Select Project</option>
                        <?php
                        $projectdata=mysqli_query($conn,"SELECT * FROM `tbl_service` where `status`='1'");
                        while($projectrec=mysqli_fetch_array($projectdata))
                        {
                        ?>
                        <option value="<?= $projectrec['id']; ?>"><?= $projectrec['name']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="bannerlink">Image File</label>
                            <input type="file"  name="bimage"  class="form-control" id="bannerlink">                         
                            <p class="help-block">Image dimension must be 410 × 460 px & must be jpg format</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Sort Number</label>
                            <input type="number" name="position" class="form-control" id="exampleInputPassword1" value="<?= $brec['sort']; ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                <input type="radio" value="1" id="optionsRadios3" name="status" >
                <label for="optionsRadios3">Active</label>
                <input type="radio" value="0" id="optionsRadios4" name="status" >
                <label for="optionsRadios4">Inactive</label>
                </div>
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="update" class="btn btn-primary">Click Here To Update</button>
                <!-- <button type="reset" name="reset" class="btn btn-danger">Reset</button> -->
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
