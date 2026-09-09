<?php
require('checksession.php');
require('../inc/function.php');

$bdata = mysqli_query($conn, "SELECT * FROM `tbl_banner_single`");
$brec = mysqli_fetch_array($bdata);
if (isset($_POST['update'])) {
	$title = mysqli_real_escape_string($conn, $_POST['title']);
	$subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
	$desc = mysqli_real_escape_string($conn, $_POST['desc']);
	$url = mysqli_real_escape_string($conn, $_POST['url']);
	$old1 = mysqli_real_escape_string($conn, $_POST['oldimg1']);
    $bimage1 = $_FILES['bimage1']['name'];
      if($bimage1!=''){
          $bimage1 = time() . "_" . $bimage1;
          @unlink("../uploads/banner/" . $old1);
          move_uploaded_file($_FILES["bimage1"]["tmp_name"], "../uploads/banner/" . $bimage1);
      } else {
        $bimage1 = $brec['image1'];
      }
      
    $old2 = mysqli_real_escape_string($conn, $_POST['oldimg2']);
    $bimage2 = $_FILES['bimage2']['name'];
      if($bimage2!=''){
          $bimage2 = time() . "_" . $bimage2;
          @unlink("../uploads/banner/" . $old2);
          move_uploaded_file($_FILES["bimage2"]["tmp_name"], "../uploads/banner/" . $bimage2);
      } else {
        $bimage2 = $brec['image2'];
      }
    
    $old3 = mysqli_real_escape_string($conn, $_POST['oldimg3']);
    $bimage3 = $_FILES['bimage3']['name'];
      if($bimage3!=''){
          $bimage3 = time() . "_" . $bimage3;
          @unlink("../uploads/banner/" . $old3);
          move_uploaded_file($_FILES["bimage3"]["tmp_name"], "../uploads/banner/" . $bimage3);
      } else {
        $bimage3 = $brec['image3'];
      }  

	$query = mysqli_query($conn, "UPDATE `tbl_banner_single` SET `title`='$title',`subtitle`='$subtitle',`desc`='$desc',`url`='$url',`image1`='$bimage1',`image2`='$bimage2',`image3`='$bimage3'");
	if ($query == true) {
		$_SESSION['success'] = "Updated Successfully";
		header("refresh:3;url=manage-banner-single.php");
	} else {
		$_SESSION['error'] = "Something went wrong. Please try again";
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
			<li class="breadcrumb-item"><a href="javascript:;">Home Extra Management</a></li>
			<li class="breadcrumb-item active">Edit Home Extra</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><a href="javascript:;" onClick="javascript:history.go(-1)" class="btn btn-l btn-icon btn-circle btn-primary" data-click="panel-remove"><i class="fa fa-arrow-left"></i></a> Manage Home Extra</h1>
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
						<h4 class="panel-title"> Edit Home Extra</h4>
					</div>
					<!-- begin panel-body -->
					<div class="panel-body">
						<form role="form" method="POST" enctype="multipart/form-data">
							<div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
        								<div class="form-group">
        									<label for="banner"> Enter Title</label>
        									<input type="text" name="title" class="form-control" id="" value="<?= $brec['title']; ?>">
        								</div>
							     	</div>
    								<div class="col-md-6">
        								<div class="form-group">
        									<label for="banner"> Enter Sub Title</label>
        									<input type="text" name="subtitle" class="form-control" id="" value="<?= $brec['subtitle']; ?>">
        								</div>
    								</div>
    								<div class="col-md-12">
        								<div class="form-group">
        									<label for="banner"> Enter URL</label>
        									<input type="text" name="url" class="form-control" id="" value="<?= $brec['url']; ?>">
        								</div>
    								</div>
    								<div class="col-md-12">
        								<div class="form-group">
        									<label for="banner"> Enter Desc</label>
        									<textarea name="desc" class="form-control" id="editor1"><?= $brec['desc']; ?></textarea>
        								</div>
    								</div>
    								<div class="col-md-4">
    								<div class="form-group">
                                      <label for="exampleInputFile">File input</label>
                                      <input type="file" name="bimage1" class="form-control" id="exampleInputFile">
                                      <input type="hidden" name="oldimg1" value="<?= $brec['image1']; ?>">
                                      <p class="help-block">Image dimension must be 900 X 600 px & must be jpg format</p>
                                      <img src="../uploads/banner/<?= $brec['image1']; ?>" style="width:20%;">
                                    </div>
    								</div>
    								<div class="col-md-4">
    								  <div class="form-group">
                                      <label for="exampleInputFile">File input</label>
                                      <input type="file" name="bimage2" class="form-control" id="exampleInputFile">
                                      <input type="hidden" name="oldimg2" value="<?= $brec['image2']; ?>">
                                      <p class="help-block">Image dimension must be 900 X 600 px & must be jpg format</p>
                                      <img src="../uploads/banner/<?= $brec['image2']; ?>" style="width:20%;">
                                    </div>  
    								</div>
								    <div class="col-md-4">
								      <div class="form-group">
                                      <label for="exampleInputFile">File input</label>
                                      <input type="file" name="bimage3" class="form-control" id="exampleInputFile">
                                      <input type="hidden" name="oldimg3" value="<?= $brec['image3']; ?>">
                                      <p class="help-block">Image dimension must be 900 X 600 px & must be jpg format</p>
                                      <img src="../uploads/banner/<?= $brec['image3']; ?>" style="width:20%;">
                                    </div> 
								    </div>
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
			initSample();
			CKEDITOR.replace('editor1', {
				filebrowserUploadUrl: 'assets/ckeditor/samples/get_imagelink.php',
			});
			CKEDITOR.replace('editor2', {
				filebrowserUploadUrl: 'assets/ckeditor/samples/get_imagelink.php',
			});
				CKEDITOR.replace('editor3', {
				filebrowserUploadUrl: 'assets/ckeditor/samples/get_imagelink.php',
			});
				CKEDITOR.replace('editor4', {
				filebrowserUploadUrl: 'assets/ckeditor/samples/get_imagelink.php',
			});
			CKEDITOR.replace('editor5', {
				filebrowserUploadUrl: 'assets/ckeditor/samples/get_imagelink.php',
			});
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