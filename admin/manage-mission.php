<?php
require('checksession.php');
require('../inc/function.php');

$bdata = mysqli_query($conn, "SELECT * FROM `tbl_why_choose`");
$brec = mysqli_fetch_array($bdata);
if (isset($_POST['update'])) {
	$main_heading = mysqli_real_escape_string($conn, $_POST['main_heading']);
	$main_subheading = mysqli_real_escape_string($conn, $_POST['main_subheading']);
	$main_content = mysqli_real_escape_string($conn, $_POST['main_content']);
	$content1 = mysqli_real_escape_string($conn,$_POST['content1']);
	$content2 = mysqli_real_escape_string($conn,$_POST['content2']);
	$content3 = mysqli_real_escape_string($conn,$_POST['content3']);
	$content4 = mysqli_real_escape_string($conn,$_POST['content4']);
	$heading1 = mysqli_real_escape_string($conn, $_POST['heading1']);
	$heading2 = mysqli_real_escape_string($conn, $_POST['heading2']);
	$heading3 = mysqli_real_escape_string($conn, $_POST['heading3']);
	$heading4 = mysqli_real_escape_string($conn, $_POST['heading4']);
    $oldicon1 = mysqli_real_escape_string($conn,$_POST['oldicon1']);
    $oldicon2 = mysqli_real_escape_string($conn,$_POST['oldicon2']);
    $oldicon3 = mysqli_real_escape_string($conn,$_POST['oldicon3']);
    $oldicon4 = mysqli_real_escape_string($conn,$_POST['oldicon4']);
    $oldimage1 = mysqli_real_escape_string($conn,$_POST['oldimage1']);

    $image1 = $_FILES['image1']['name'];
	if ($image1 != "") {
		$image1 = time() . "_" . $image1;
		@unlink("../uploads/why_choose/" . $oldimage1);
		move_uploaded_file($_FILES["image1"]["tmp_name"], "../uploads/why_choose/" . $image1);
	} else {
		$image1 = $oldimage1;
	} 
	
    $image2 = $_FILES['image2']['name'];
	if ($image2 != "") {
		$image2 = time() . "_" . $image2;
		@unlink("../uploads/why_choose/" . $oldicon1);
		move_uploaded_file($_FILES["image2"]["tmp_name"], "../uploads/why_choose/" . $image2);
	} else {
		$image2 = $oldicon1;
	} 
	
    $image3 = $_FILES['image3']['name'];
	if ($image3 != "") {
		$image3 = time() . "_" . $image3;
		@unlink("../uploads/why_choose/" . $oldicon2);
		move_uploaded_file($_FILES["image3"]["tmp_name"], "../uploads/why_choose/" . $image3);
	} else {
		$image3 = $oldicon2;
	} 
	
    $image4 = $_FILES['image4']['name'];
	if ($image4 != "") {
		$image4 = time() . "_" . $image4;
		@unlink("../uploads/why_choose/" . $oldicon3);
		move_uploaded_file($_FILES["image4"]["tmp_name"], "../uploads/why_choose/" . $image4);
	} else {
		$image4 = $oldicon3;
	} 
	
    $image5 = $_FILES['image5']['name'];
	if ($image5 != "") {
		$image5 = time() . "_" . $image5;
		@unlink("../uploads/why_choose/" . $oldicon4);
		move_uploaded_file($_FILES["image5"]["tmp_name"], "../uploads/why_choose/" . $image5);
	} else {
		$image5 = $oldicon4;
	} 
	
//     $image3 = $_FILES['image3']['name'];
// 	if ($image3 != "") {
// 		$image3 = time() . "_" . $image3;
// 		@unlink("../uploads/mission/" . $oldimage3);
// 		move_uploaded_file($_FILES["image3"]["tmp_name"], "../uploads/mission/" . $image3);
// 	} else {
// 		$image3 = $brec['image3'];
// 	} 


	$query = mysqli_query($conn, "UPDATE `tbl_why_choose` SET `main_image`='$image1',`icon1`='$image2',`icon2`='$image3',`icon3`='$image4',`icon4`='$image5',`heading1`='$heading1',`heading2`='$heading2',`heading3`='$heading3',`heading4`='$heading4',`content1`='$content1',`content2`='$content2',`content3`='$content3',`content4`='$content4',`main_heading`='$main_heading',`main_subheading`='$main_subheading',`main_content`='$main_content'"); 
	if ($query == true) {
		$_SESSION['success'] = "Updated Successfully";
		header("refresh:3;url=manage-mission.php");
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
			<li class="breadcrumb-item"><a href="javascript:;">Why Choose Management</a></li>
			<li class="breadcrumb-item active">Edit Why Choose</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><a href="javascript:;" onClick="javascript:history.go(-1)" class="btn btn-l btn-icon btn-circle btn-primary" data-click="panel-remove"><i class="fa fa-arrow-left"></i></a> Manage Why Choose</h1>
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
						<h4 class="panel-title"> Edit Why Choose</h4>
					</div>
					<!-- begin panel-body -->
					<div class="panel-body">
						<form role="form" method="POST" enctype="multipart/form-data">
							<div class="box-body">
							    <div class="row">
							        
								<div class="form-group col-4">
									<label for="banner">Enter Main Heading</label>
									<input type="text" class="form-control" value="<?= $brec['main_heading'] ?>" name="main_heading" placeholder="Main Heading" >
								</div>
							        
								<div class="form-group col-4">
									<label for="banner">Enter Main SubHeading</label>
									<input type="text" class="form-control" value="<?= $brec['main_subheading'] ?>" name="main_subheading" placeholder="Main SubHeading" >
								</div>
								
								<div class="form-group col-4">
									<label for="banner">Enter Main Content</label>
									<textarea name="main_content" id="" class="form-control" rows="3"><?= $brec['main_content']; ?></textarea>
								</div>
								
								</div>
						
								<div class="row">
								    
                                <div class="col-4">
                                    <div class="form-group">
    									<label for="exampleInputFile">Main Image</label>
    									<input type="file" name="image1" class="form-control" id="exampleInputFile">
    									<input type="hidden" name="oldimage1" value="<?= $brec['main_image']; ?>">
    									<p class="help-block">Image dimension must be 570 × 569 px & must be jpg format</p>
    									<img src="../uploads/why_choose/<?= $brec['main_image']; ?>" style="width:30%; height:100px" class="bg-dark">
    								</div>
								</div>
								
                                <div class="col-4">
                                    <div class="form-group">
    									<label for="exampleInputFile">Icon 1</label>
    									<input type="file" name="image2" class="form-control" id="exampleInputFile">
    									<input type="hidden" name="oldicon1" value="<?= $brec['icon1']; ?>">
    									<p class="help-block">Image dimension must be 570 × 569 px & must be jpg format</p>
    									<img src="../uploads/why_choose/<?= $brec['icon1']; ?>" style="width:30%; height:100px" class="bg-dark">
    								</div>
								</div>
								
                                <div class="col-4">
                                    <div class="form-group">
    									<label for="exampleInputFile">Icon 2</label>
    									<input type="file" name="image3" class="form-control" id="exampleInputFile">
    									<input type="hidden" name="oldicon2" value="<?= $brec['icon2']; ?>">
    									<p class="help-block">Image dimension must be 570 × 569 px & must be jpg format</p>
    									<img src="../uploads/why_choose/<?= $brec['icon2']; ?>" style="width:30%; height:100px" class="bg-dark">
    								</div>
								</div>
								
                                <div class="col-4">
                                    <div class="form-group">
    									<label for="exampleInputFile">Icon 3</label>
    									<input type="file" name="image4" class="form-control" id="exampleInputFile">
    									<input type="hidden" name="oldicon3" value="<?= $brec['icon3']; ?>">
    									<p class="help-block">Image dimension must be 570 × 569 px & must be jpg format</p>
    									<img src="../uploads/why_choose/<?= $brec['icon3']; ?>" style="width:30%; height:100px" class="bg-dark">
    								</div>
								</div>
								
                                <div class="col-4">
                                    <div class="form-group">
    									<label for="exampleInputFile">Icon 4</label>
    									<input type="file" name="image5" class="form-control" id="exampleInputFile">
    									<input type="hidden" name="oldicon4" value="<?= $brec['icon4']; ?>">
    									<p class="help-block">Image dimension must be 570 × 569 px & must be jpg format</p>
    									<img src="../uploads/why_choose/<?= $brec['icon4']; ?>" style="width:30%; height:100px" class="bg-dark">
    								</div>
								</div>
				
								</div>
								
								<div class="row">
								    
								<div class="form-group col-3">
									<label for="banner">Enter Icon Heading 1</label>
									<input type="text" class="form-control" value="<?= $brec['heading1'] ?>" name="heading1" placeholder="Heading 1" >
								</div>
								    
								<div class="form-group col-3">
									<label for="banner">Enter Icon Heading 2</label>
									<input type="text" class="form-control" value="<?= $brec['heading2'] ?>" name="heading2" placeholder="Heading 2" >
								</div>
								    
								<div class="form-group col-3">
									<label for="banner">Enter Icon Heading 3</label>
									<input type="text" class="form-control" value="<?= $brec['heading3'] ?>" name="heading3" placeholder="Heading 3" >
								</div>
								    
								<div class="form-group col-3">
									<label for="banner">Enter Icon Heading 4</label>
									<input type="text" class="form-control" value="<?= $brec['heading4'] ?>" name="heading4" placeholder="Heading 4" >
								</div>
								
								</div>
								<div class="row">
								    
								<div class="form-group col-3">
									<label for="banner">Enter Icon Content 1</label>
									<textarea class="form-control" name="content1" placeholder="Content 1" ><?= $brec['content1'] ?></textarea>
								</div>
								    
								<div class="form-group col-3">
									<label for="banner">Enter Icon Content 2</label>
									<textarea class="form-control" name="content2" placeholder="Content 2" ><?= $brec['content2'] ?></textarea>
								</div>
								    
								<div class="form-group col-3">
									<label for="banner">Enter Icon Content 3</label>
									<textarea class="form-control" name="content3" placeholder="Content 3" ><?= $brec['content3'] ?></textarea>
								</div>
								    
								<div class="form-group col-3">
									<label for="banner">Enter Icon Content 4</label>
									<textarea class="form-control" name="content4" placeholder="Content 4" ><?= $brec['content4'] ?></textarea>
								</div>
								
								</div>

							</div>
							<!-- /.box-body -->

							<div class="box-footer">
								<button type="submit" name="update" class="btn btn-primary">Click Here To Update</button>
								<!--<button type="reset" name="reset" class="btn btn-danger">Reset</button>-->
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