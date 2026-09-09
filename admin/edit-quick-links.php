<?php
require('checksession.php');
include '../inc/function.php';

$b = $_REQUEST['bid'];
$bdata = mysqli_query($conn, "SELECT * FROM `tbl_quick_links` where `id`='$b'");
$brec = mysqli_fetch_array($bdata);
if (isset($_POST['update'])) {

    $title = mysqli_real_escape_string($conn,$_POST['title']);
    $prourls = mysqli_real_escape_string($conn,$_POST['prourl']);
	$prourrl = str_replace(array( '\'', '"', ' ', ',' , ';', '*', ',', '/', '&', '_', '$', '--', '-', '<', '>','(',')','.','?','{','}','[',']','|','~','`',':'), '-', $prourls);
	$prourl = strtolower($prourrl);
    $description = mysqli_real_escape_string($conn,$_POST['description']);
	$position = mysqli_real_escape_string($conn,$_POST['position']);
	$status = mysqli_real_escape_string($conn,$_POST['status']); 
	
	$metatag = mysqli_real_escape_string($conn,$_POST['metatag']);
	$keyword = mysqli_real_escape_string($conn,$_POST['keyword']);
	$metadesc = mysqli_real_escape_string($conn,$_POST['metadescription']); 
	$old = mysqli_real_escape_string($conn,$_POST['oldimg']); 

	$bimage=$_FILES['bimage']['name'];
	if($bimage!="")
	{
		$bimage=time()."_".$bimage;
		@unlink("../uploads/breadcrumb/".$old); 
		move_uploaded_file($_FILES["bimage"]["tmp_name"], "../uploads/breadcrumb/".$bimage);
	}
	else
	{
		$bimage = $brec['brd_image'];
	}

	$query = mysqli_query($conn, "UPDATE `tbl_quick_links` SET `brd_image`='$bimage', `title`='$title', `url`='$prourl',`description`='$description',`meta_title`='$metatag',`meta_keyword`='$keyword',`meta_desc`='$metadesc',`sort`='$position',`status`='$status' WHERE `id`='$b'");
	if ($query == true) {
		$_SESSION['success'] = "Updated Successfully";
		header("refresh:3;url=manage-quick-links.php");
	} else {
		$_SESSION['error'] = "Something went wrong. Please try again";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require("includes/head.php"); ?>

<body>
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade show"><span class="spinner"></span></div>
	<!-- begin #page-container -->
	<div id="page-container" class="fade in page-sidebar-fixed page-header-fixed">
		<!-- begin #page-container -->
		<?php require("includes/header.php"); ?>
		<!-- begin #sidebar -->
		<?php require("includes/left.php"); ?>
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="javascript:;"> Quick Links Management</a></li>
				<li class="breadcrumb-item active">Edit Quick Links</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header"><a href="javascript:;" onClick="javascript:history.go(-1)" class="btn btn-l btn-icon btn-circle btn-primary" data-click="panel-remove"><i class="fa fa-arrow-left"></i></a> Manage Quick Links</h1>
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
							<h4 class="panel-title"> Edit Quick Links</h4>
						</div>
						<!-- begin panel-body -->
						<div class="panel-body">
							<form role="form" method="POST" enctype="multipart/form-data">
								<div class="box-body">

									<div class="form-group">
                                      <label for="bannerlink"> Enter Title</label>
                                      <input type="text" name="title" class="form-control" id="name" value="<?= $brec['title']; ?>" >
                                    </div>
                    
                                    <div class="form-group">
                                        <label for="heading">Enter URL<code>Same as title & avoid Special Characters</code></label>
                                        <input type="text"  name="prourl" class="form-control" id="url" placeholder="Enter Url" value="<?= $brec['url']; ?>">
                                    </div>

									<div class="form-group">
                                      <label for="bannerlink"> Description</label>
                                      <textarea name="description" id="editor1"  class="form-control"><?= $brec['description']; ?></textarea>
                                    </div>

									<div class="form-group d-none">
										<label for="exampleInputFile">File input</label>
										<input type="file" name="bimage" class="form-control" id="exampleInputFile">
										<input type="hidden" name="oldimg"  value="<?= $brec['brd_image']; ?>">
										<p class="help-block">Image dimension must be 1920 × 300 px & must be jpg format</p>
										<?php if(!empty($brec['brd_image'])){ ?>
											<img src="../uploads/breadcrumb/<?= $brec['brd_image']; ?>" style="width:30%;">
										<?php } ?>
									</div>

									<div class="form-group">
										<label for="exampleInputPassword1">Position</label>
										<input type="number" name="position" class="form-control" id="exampleInputPassword1" value="<?= $brec['sort']; ?>">
									</div>
									
									<div id="myDIV" style="display:none;border: 1px solid #000; padding: 9px;"> 
                                        <div class="form-group">
                                          <label for="metatag">Meta Title</label>
                                          <input type="text" name="metatag" id="metatag" placeholder="Meta Title" class="form-control" value="<?= $brec['meta_title']; ?>">
                                        </div>
                                        
                                          <div class="form-group">
                                          <label for="keyword">Meta Keyword</label>
                                          <textarea name="keyword" id="keyword" placeholder="Meta Keyword" class="form-control" ><?= $brec['meta_keyword']; ?></textarea>
                                        </div>
                                        
                                        <div class="form-group">
                                          <label for="metadescription">Meta Description</label>
                                          <textarea name="metadescription" id="metadescription" placeholder="Meta Description" class="form-control" ><?= $brec['meta_desc']; ?></textarea>
                                        </div>
                                    </div><br>

									<div class="form-group">
										<input type="radio" value="1" id="optionsRadios3" name="status" <?php if ($brec['status'] == '1') { echo 'checked'; } ?>>
										<label for="optionsRadios3">Active</label>

										<input type="radio" value="0" id="optionsRadios4" name="status" <?php if ($brec['status'] == '0') { echo 'checked'; } ?>>
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
		initSample();
	CKEDITOR.replace('editor1', {
		filebrowserUploadUrl: 'assets/ckeditor/samples/get_imagelink.php',
	});
	CKEDITOR.replace('editor2', {
		filebrowserUploadUrl: 'assets/ckeditor/samples/get_imagelink.php',
	});
	});
</script>
<script>
    window.onload = function() {
    var src = document.getElementById("name"),
        dst = document.getElementById("url");
    src.addEventListener('input', function() {
        dst.value = src.value;
    });
  }

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