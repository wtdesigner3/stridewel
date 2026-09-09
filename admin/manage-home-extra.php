<?php
require('checksession.php');
require('../inc/function.php');

$bdata = mysqli_query($conn, "SELECT * FROM `tbl_home_extra`");
$brec = mysqli_fetch_array($bdata);
if (isset($_POST['update'])) {
	$ach_text = mysqli_real_escape_string($conn, $_POST['ach_text']);
	$service_title = mysqli_real_escape_string($conn, $_POST['service_title']);
	$service_subtitle = mysqli_real_escape_string($conn, $_POST['service_subtitle']);
	$client_title = mysqli_real_escape_string($conn, $_POST['client_title']);
	$project_title = mysqli_real_escape_string($conn, $_POST['project_title']);
	$project_subtitle = mysqli_real_escape_string($conn, $_POST['project_subtitle']);
	$work_title = mysqli_real_escape_string($conn, $_POST['work_title']);
	$work_subtitle = mysqli_real_escape_string($conn, $_POST['work_subtitle']);
	$testimonial_title = mysqli_real_escape_string($conn, $_POST['testimonial_title']);
	$testimonial_subititle = mysqli_real_escape_string($conn, $_POST['testimonial_subititle']);
	$contact_title = mysqli_real_escape_string($conn, $_POST['contact_title']);
	$contact_subtitle = mysqli_real_escape_string($conn, $_POST['contact_subtitle']);
	$contact_content = mysqli_real_escape_string($conn, $_POST['contact_content']);
	$servicefaq_title = mysqli_real_escape_string($conn, $_POST['servicefaq_title']);
	$servicefaq_subtitle = mysqli_real_escape_string($conn, $_POST['servicefaq_subtitle']);

   $query = mysqli_query($conn, "UPDATE `tbl_home_extra` SET `ach_text`='$ach_text',`service_title`='$service_title',`service_subtitle`='$service_subtitle',`client_title`='$client_title',`project_title`='$project_title',`project_subtitle`='$project_subtitle',`work_title`='$work_title',`work_subtitle`='$work_subtitle',`testimonial_title`='$testimonial_title',`testimonial_subititle`='$testimonial_subititle',`contact_title`='$contact_title',`contact_subtitle`='$contact_subtitle',`contact_content`='$contact_content',`servicefaq_title`='$servicefaq_title',`servicefaq_subtitle`='$servicefaq_subtitle'");

	if ($query == true) {
		$_SESSION['success'] = "Updated Successfully";
		header("refresh:3;url=manage-home-extra.php");
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
        									<label for="banner"> Enter Achievement Title</label>
        									<input type="text" name="ach_text" class="form-control" id="" value="<?= $brec['ach_text']; ?>">
        								</div>
							     	</div>
    								<div class="col-md-6">
        								<div class="form-group">
        									<label for="banner"> Enter Service Title</label>
        									<input type="text" name="service_title" class="form-control" id="" value="<?= $brec['service_title']; ?>">
        								</div>
    								</div>
    								<div class="col-md-6">
        								<div class="form-group">
        									<label for="banner"> Enter Service SubTitle</label>
        									<input type="text" name="service_subtitle" class="form-control" id="" value="<?= $brec['service_subtitle']; ?>">
        								</div>
    								</div>
    								<div class="col-md-6">
        								<div class="form-group">
        									<label for="banner"> Enter Client Title</label>
        									<input type="text" name="client_title" class="form-control" id="" value="<?= $brec['client_title']; ?>">
        								</div>
    								</div>
    								<div class="col-md-6">
        								<div class="form-group">
        									<label for="banner"> Enter Project Title</label>
        									<input type="text" name="project_title" class="form-control" id="" value="<?= $brec['project_title']; ?>">
        								</div>
    								</div>
    								<div class="col-md-6">
        								<div class="form-group">
        									<label for="banner"> Enter Project Sub Title</label>
        									<input type="text" name="project_subtitle" class="form-control" id="" value="<?= $brec['project_subtitle']; ?>">
        								</div>
    						     	</div>
    								<div class="col-md-6">
        								<div class="form-group">
        									<label for="banner"> Enter Work Title</label>
        									<input type="text" name="work_title" class="form-control" id="" value="<?= $brec['work_title']; ?>">
        								</div>
    								</div>
    								<div class="col-md-6">
        								<div class="form-group">
        									<label for="banner"> Enter Work Sub Title</label>
        									<input type="text" name="work_subtitle" class="form-control" value="<?= $brec['work_subtitle']; ?>">
        								</div>
    						     	</div>
    								<div class="col-md-6">
        								<div class="form-group">
        									<label for="banner"> Enter Testimonial Title</label>
        									<input type="text" name="testimonial_title" class="form-control" id="" value="<?= $brec['testimonial_title']; ?>">
        								</div>
    								</div>
    								<div class="col-md-6">
        								<div class="form-group">
        									<label for="banner"> Enter Testimonial Sub Title</label>
        									<input type="text" name="testimonial_subititle" class="form-control" value="<?= $brec['testimonial_subititle']; ?>">
        								</div>
    						     	</div>
    								<div class="col-md-6">
        								<div class="form-group">
        									<label for="banner"> Enter Contact Title</label>
        									<input type="text" name="contact_title" class="form-control" id="" value="<?= $brec['contact_title']; ?>">
        								</div>
    								</div>
    								<div class="col-md-6">
        								<div class="form-group">
        									<label for="banner"> Enter Contact Sub Title</label>
        									<input type="text" name="contact_subtitle" class="form-control" value="<?= $brec['contact_subtitle']; ?>">
        								</div>
    						     	</div>
    								<div class="col-md-6">
        								<div class="form-group">
        									<label for="banner"> Enter Contact Content</label>
        									<input type="text" name="contact_content" class="form-control" value="<?= $brec['contact_content']; ?>">
        								</div>
    						     	</div>
    								<div class="col-md-6">
        								<div class="form-group">
        									<label for="banner"> Enter Service Faq Title</label>
        									<input type="text" name="servicefaq_title" class="form-control" value="<?= $brec['servicefaq_title']; ?>">
        								</div>
    						     	</div>
    								<div class="col-md-6">
        								<div class="form-group">
        									<label for="banner"> Enter Service Faq Subtitle</label>
        									<input type="text" name="servicefaq_subtitle" class="form-control" value="<?= $brec['servicefaq_subtitle']; ?>">
        								</div>
    						     	</div>
    								
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