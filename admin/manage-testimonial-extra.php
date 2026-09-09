<?php
require('checksession.php');
require('../inc/function.php');

$bdata = mysqli_query($conn, "SELECT * FROM `tbl_testimonial_text`");
$brec = mysqli_fetch_array($bdata);
if (isset($_POST['update'])) {
	$title = mysqli_real_escape_string($conn, $_POST['title']);
	$alt = mysqli_real_escape_string($conn, $_POST['alt']);
	$old2 = mysqli_real_escape_string($conn, $_POST['oldimg2']);

	$bimage2 = $_FILES['bimage2']['name'];
	if ($bimage2 != "") {
		$bimage2 = time() . "_" . $bimage2;
		@unlink("../uploads/testimonial/" . $old2);
		move_uploaded_file($_FILES["bimage2"]["tmp_name"], "../uploads/testimonial/" . $bimage2);
	} else {
		$bimage2 = $brec['ab_image'];
	}

	$query = mysqli_query($conn, "UPDATE `tbl_testimonial_text` SET `ab_alt`='$alt',`ab_title`='$title',`ab_image`='$bimage2'");
	if ($query == true) {
		$_SESSION['success'] = "Testimonial Extra Updated Successfully";
		header("refresh:3;url=manage-testimonial-extra.php");
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
			<li class="breadcrumb-item"><a href="javascript:;">Testimonial Extra Management</a></li>
			<li class="breadcrumb-item active">Edit Testimonial Extra</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><a href="javascript:;" onClick="javascript:history.go(-1)" class="btn btn-l btn-icon btn-circle btn-primary" data-click="panel-remove"><i class="fa fa-arrow-left"></i></a> Manage Testimonial Extra</h1>
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
						<h4 class="panel-title"> Edit Testimonial Extra</h4>
					</div>
					<!-- begin panel-body -->
					<div class="panel-body">
						<form role="form" method="POST" enctype="multipart/form-data">
							<div class="box-body">

								<div class="form-group">
									<label for="banner"> Enter Title</label>
									<input type="text" name="title" class="form-control" id="" value="<?= $brec['ab_title']; ?>">
								</div>

							
                                 <div class="row">
                                   <div class="col-6">
								<div class="form-group">
									<label for="exampleInputFile">Image File</label>
									<input type="file" name="bimage2" class="form-control" id="exampleInputFile">
									<input type="hidden" name="oldimg2" value="<?= $brec['ab_image']; ?>">
									<p class="help-block">Image dimension must be 900 X 600 & must be jpg format</p>
									<img src="../uploads/testimonial/<?= $brec['ab_image']; ?>" style="width:30%;">
								</div>
								</div>
								 <div class="col-6">
								    <div class="form-group">
									<label for="banner"> Enter Alt</label>
									<input type="text" name="alt" class="form-control" id="" value="<?= $brec['ab_alt']; ?>">
								</div>
								</div>
								</div>
							</div>
							<!-- /.box-body -->

							<div class="box-footer">
								<button type="submit" name="update" class="btn btn-primary">Click Here To Update</button>
								<button type="reset" name="reset" class="btn btn-danger">Reset</button>
								<!--<button type="button" onclick="myFunction()" class="btn btn-warning">Seo tools</button>-->
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