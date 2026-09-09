<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require('checksession.php');
include '../inc/function.php';

if (isset($_POST['submit'])) {
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$producturl = mysqli_real_escape_string($conn, $_POST['url']);
	$purl = str_replace(array('\'', '"', ' ', ',', ';', '.', '!', '@', '(', ')', '(', '#', '^', '*', ',', '/', '&', '_', '$', '--', '-', '<', '>', '%', '=', ':', '?', '[', ']', '~', '+', '`', '{', '}', '|'), '-', $producturl);
	$prourl = strtolower($purl);
	$location = mysqli_real_escape_string($conn, $_POST['location']);
	$heading = mysqli_real_escape_string($conn, $_POST['heading']);
	$subheading = mysqli_real_escape_string($conn, $_POST['subheading']);
	$description = mysqli_real_escape_string($conn, $_POST['description']);
	$short_description = mysqli_real_escape_string($conn, $_POST['short_description']);
	$status = mysqli_real_escape_string($conn, $_POST['status']);
	$sort = mysqli_real_escape_string($conn, $_POST['sort']);
	$alt = mysqli_real_escape_string($conn, $_POST['alt']);
	$whatsapp = mysqli_real_escape_string($conn, $_POST['whatsapp']);
	$gmail = mysqli_real_escape_string($conn, $_POST['gmail']);
	$facebook = mysqli_real_escape_string($conn, $_POST['facebook']);
	$twitter = mysqli_real_escape_string($conn, $_POST['twitter']);
	$google = mysqli_real_escape_string($conn, $_POST['google']);
	$insta = mysqli_real_escape_string($conn, $_POST['insta']);
	$metatag = mysqli_real_escape_string($conn, $_POST['metatag']);
	$keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
	$metadesc = mysqli_real_escape_string($conn, $_POST['metadescription']);
	$bimages = $_FILES['bimage']['name'];
	if ($bimages != "") {
		$bimage = time() . "_" . $bimages;
		move_uploaded_file($_FILES["bimage"]["tmp_name"], "../uploads/team/" . $bimage);
	} else {
		$bimage = "";
	}


	$query = mysqli_query($conn, "INSERT INTO `tbl_teams` (`tt_whatsapp`,`tt_gmail`,`tt_facebook`,`tt_twitter`,`tt_google`,`tt_insta`,`tt_name`,`tt_url`, `tt_location`,`tt_short_detail`,`heading`,`subheading`, `tt_detail`, `tt_sort`, `tt_status`,`tt_image`,`tt_alt`,`title`, `keyword`, `metadesc`) VALUES ('$whatsapp','$gmail','$facebook','$twitter','$google','$insta','$name','$prourl', '$location','$short_description', '$heading','$subheading','$description', '$sort', '$status','$bimage','$alt','$metatag','$keyword','$metadesc')");
	if ($query == true) {
		$_SESSION['success'] = "Team inserted successfully";
		header("refresh:3;url=manage-team.php");
	} else {
		// Message for unsuccessfull insertion
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
	<!-- end #header -->
	<!-- begin #sidebar -->
	<?php require("includes/left.php"); ?>

	<!-- begin #content -->
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
			<li class="breadcrumb-item"><a href="javascript:;">Team Management</a></li>
			<li class="breadcrumb-item active">Add Team</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><a href="javascript:;" onClick="javascript:history.go(-1)"
				class="btn btn-l btn-icon btn-circle btn-primary" data-click="panel-remove"><i
					class="fa fa-arrow-left"></i></a> Add Team</h1>
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
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
								data-click="panel-expand"><i class="fa fa-expand"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success"
								data-click="panel-reload"><i class="fa fa-redo"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning"
								data-click="panel-collapse"><i class="fa fa-minus"></i></a>
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger"
								data-click="panel-remove"><i class="fa fa-times"></i></a>
						</div>
						<h4 class="panel-title">Add Team</h4>
					</div>
					<!-- end panel-heading -->

					<!-- begin panel-body -->
					<div class="panel-body">
						<form role="form" method="POST" enctype="multipart/form-data">
							<div class="box-body">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="heading">Name</label>
											<input type="text" name="name" class="form-control" id="heading"
												placeholder="Enter Name" required>
										</div>
									</div>
									<div class="col-sm-6 d-none">
										<div class="form-group">
											<label for="heading">URL</label>
											<input type="text" name="url" class="form-control" id="url"
												placeholder="Enter URL">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="bannerlink">Designation</label>
											<input type="text" name="location" placeholder="Enter Designation"
												class="form-control" id="bannerlink">
										</div>
									</div>
								</div>

								<div class="form-group d-none">
									<label>Short Description</label>
									<textarea name="short_description" id="editor2"
										placeholder="Enter Short Description" class="form-control" rows="3"></textarea>
								</div>
								<div class="row">
									<div class="col-sm-6 d-none">
										<div class="form-group">
											<label for="heading">Heading</label>
											<input type="text" name="heading" class="form-control"
												placeholder="Enter Heading">
										</div>
									</div>
									<div class="col-sm-12 d-none">
										<div class="form-group">
											<label for="heading">Heading</label>
											<input type="text" name="subheading" class="form-control"
												placeholder="Enter Heading">
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label>Description</label>
											<textarea name="description" id="editor1" placeholder="Enter Description"
												class="form-control" rows="3"></textarea>
										</div>
									</div>
								</div>
								<div class="row d-none">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="bannerlink">Phone No.</label>
											<input type="text" name="whatsapp" class="form-control" id="bannerlink"
												placeholder="Enter Phone No.">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="bannerlink">Gmail ID</label>
											<input type="text" name="gmail" class="form-control" id="bannerlink"
												placeholder="Enter Gmail ID">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="heading">Facebook Link</label>
											<input type="text" name="facebook" class="form-control"
												placeholder="Enter Facebook Link">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="heading">Twitter Link</label>
											<input type="text" name="twitter" class="form-control"
												placeholder="Enter Twitter Link">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="bannerlink">Instagram Link</label>
											<input type="text" name="insta" class="form-control" id="bannerlink"
												placeholder="Enter Instagram Link">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="bannerlink">Pinterest</label>
											<input type="text" name="google" class="form-control" id="bannerlink"
												placeholder="Enter Pinterest Link">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="exampleInputFile">File input</label>
											<input type="file" name="bimage" class="form-control" id="exampleInputFile">
											<p class="help-block">Image dimension must be 380 × 454 px & must be jpg
												format</p>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="heading">Alt</label>
											<input type="text" name="alt" class="form-control" placeholder="Enter Alt">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="bannerlink">Position</label>
									<input type="number" name="sort" placeholder="1-10" class="form-control"
										id="bannerlink">

								</div>

								<div class="form-group">
									<input type="radio" value="1" id="optionsRadios3" name="status" checked>
									<label for="optionsRadios3">Active</label>
									<input type="radio" value="0" id="optionsRadios4" name="status">
									<label for="optionsRadios4">Inactive</label>
								</div>

								<div id="dvPassport"
									style="display:none; border: 1px solid #242a30;padding: 10px;background: #fdfbef;">
									<div class="form-group">
										<label for="metatag">Meta Title</label>
										<input type="text" name="metatag" id="metatag" placeholder="Meta Title"
											class="form-control">
									</div>

									<div class="form-group">
										<label for="keyword">Meta Keyword</label>
										<textarea name="keyword" id="keyword" placeholder="Meta Keyword"
											class="form-control"></textarea>
									</div>

									<div class="form-group">
										<label for="metadescription">Meta Description</label>
										<textarea name="metadescription" id="metadescription"
											placeholder="Meta Description" class="form-control"></textarea>
									</div>
								</div> <br />

							</div>
							<!-- /.box-body -->

							<div class="box-footer">
								<button type="submit" name="submit" class="btn btn-primary">Click Here To
									Submit</button>
								<button type="reset" name="reset" class="btn btn-danger">Reset</button>
								<input id="btnPassport" type="button" class="btn btn-warning" value="Use Seo tools"
									name="btnPassport" />
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
	<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i
			class="fa fa-angle-up"></i></a>
	<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->

	<?php require("includes/footer.php"); ?>

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
	<script>
		window.onload = function () {
			var src = document.getElementById("heading"),
				dst = document.getElementById("url");
			src.addEventListener('input', function () {
				dst.value = src.value;
			});
		}

	</script>
	<script>
		$(document).ready(function () {
			App.init();
			initSample();
			CKEDITOR.replace('editor1', {
				filebrowserUploadUrl: 'assets/ckeditor/samples/get_imagelink.php',
			});
			CKEDITOR.replace('editor2', {
				filebrowserUploadUrl: 'assets/ckeditor/samples/get_imagelink.php',
			});
		});
	</script>
	<script type="text/javascript">
		$(function () {
			$("#btnPassport").click(function () {
				if ($(this).val() == "Use Seo tools") {
					$("#dvPassport").show();
					$(this).val("Close Seo tools");
				} else {
					$("#dvPassport").hide();
					$(this).val("Use Seo tools");
				}
			});
		});
	</script>
</body>

</html>