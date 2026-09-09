<?php
require('checksession.php');
include '../inc/function.php'; 

$b=$_REQUEST['cid'];
$bdata=mysqli_query($conn,"SELECT * FROM `tbl_teams` where `tt_id`='$b'");
$brec=mysqli_fetch_array($bdata);
if(isset($_POST['update']))
{
  $name = mysqli_real_escape_string($conn,$_POST['name']); 
   $producturl = mysqli_real_escape_string($conn, $_POST['url']);
  $purl = str_replace(array('\'', '"', ' ', ',', ';', '.', '!', '@', '(', ')', '(', '#', '^', '*', ',', '/', '&', '_', '$', '--', '-', '<', '>', '%','=',':','?','[',']','~','+','`','{','}','|'), '-', $producturl);
  $prourl = strtolower($purl);
  $location = mysqli_real_escape_string($conn,$_POST['location']); 
  	$heading = mysqli_real_escape_string($conn,$_POST['heading']);
		$subheading = mysqli_real_escape_string($conn,$_POST['subheading']);
  $description = mysqli_real_escape_string($conn,$_POST['description']); 
  	$short_description = mysqli_real_escape_string($conn,$_POST['short_description']);
  $status = mysqli_real_escape_string($conn,$_POST['status']); 
  $sort = mysqli_real_escape_string($conn,$_POST['sort']); 
  $old = mysqli_real_escape_string($conn,$_POST['oldimg']);  
  $alt = mysqli_real_escape_string($conn,$_POST['alt']); 
  $whatsapp = mysqli_real_escape_string($conn,$_POST['whatsapp']);
  $gmail = mysqli_real_escape_string($conn,$_POST['gmail']);
  $facebook = mysqli_real_escape_string($conn,$_POST['facebook']);
  $twitter = mysqli_real_escape_string($conn,$_POST['twitter']);
  $google = mysqli_real_escape_string($conn,$_POST['google']);
  $insta = mysqli_real_escape_string($conn,$_POST['insta']);
    $metatag = mysqli_real_escape_string($conn,$_POST['metatag']);  
  $keyword = mysqli_real_escape_string($conn,$_POST['keyword']); 
  $metadesc = mysqli_real_escape_string($conn,$_POST['metadescription']);  
  $bimage=$_FILES['bimage']['name'];
  if($bimage!="")
  {
   $bimage=time()."_".$bimage;
   @unlink("../uploads/team/".$old); 
   move_uploaded_file($_FILES["bimage"]["tmp_name"], "../uploads/team/".$bimage);

  }
   else
  {
	 $bimage=$brec['tt_image'];
  }
  
   $query=mysqli_query($conn,"UPDATE `tbl_teams` SET `tt_whatsapp`='$whatsapp',`tt_gmail`='$gmail',`tt_facebook`='$facebook',`tt_twitter`='$twitter',`tt_google`='$google',`tt_insta`='$insta',`tt_image`='$bimage',`tt_url`='$prourl',`tt_alt`='$alt',`tt_name`='$name', `tt_location`='$location', `tt_sort`='$sort',`tt_short_detail`='$short_description',`heading`='$heading',`subheading`='$subheading', `tt_detail`='$description', `tt_status`='$status',`title`='$metatag', `keyword`='$keyword', `metadesc`='$metadesc' WHERE `tt_id`='$b'");
      if($query==true)
      {
        $_SESSION['success']="Team Updated successfully";
		    header("refresh:3;url=manage-team.php");	
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
				<li class="breadcrumb-item"><a href="javascript:;">Team Management</a></li>
				<li class="breadcrumb-item active">Edit Team</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header"><a href="javascript:;" onClick="javascript:history.go(-1)" class="btn btn-l btn-icon btn-circle btn-primary" data-click="panel-remove"><i class="fa fa-arrow-left"></i></a> Edit Team</h1>
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
							<h4 class="panel-title">Edit Team</h4>
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

					  <div class="col-sm-6 d-none">
						<div class="form-group">
							<label for="heading">URL</label>
							<input type="text"  name="url" class="form-control" id="url" value="<?= $brec['tt_url']; ?>">
						</div>
					  </div>

					  <div class="col-sm-6">
					 	 <div class="form-group">
							<label for="bannerlink">Designation</label>
							<input type="text"  name="location"  value="<?= $brec['tt_location']; ?>" class="form-control" id="bannerlink">
						</div>
					  </div>
					  
				  </div>

                <div class="form-group d-none">
                  <label>Short Description</label>
                    <textarea  name="short_description" class="form-control"  id="editor2"><?= $brec['tt_short_detail']; ?></textarea>
                </div>
                <div class="row">
             	  <div class="col-sm-6 d-none">
						<div class="form-group">
							<label for="heading">Heading</label>
							<input type="text"  name="heading" class="form-control" value="<?= $brec['heading']; ?>">
						</div>
				  </div>
				  <div class="col-sm-12 d-none">
						<div class="form-group ">
							<label for="heading">Heading</label>
							<input type="text"  name="subheading" class="form-control" value="<?= $brec['subheading']; ?>">
						</div>
					  </div>
				    <div class="col-sm-12">
				        <div class="form-group">
                          <label>Description</label>
                            <textarea  name="description" class="form-control"  id="editor1"><?= $brec['tt_detail']; ?></textarea>
                        </div>
				    </div>
				</div>
                
                  <div class="row d-none">
                      <div class="col-sm-4">
					 	 <div class="form-group">
							<label for="bannerlink">Phone No.</label>
							<input type="text"  name="whatsapp"  value="<?= $brec['tt_whatsapp']; ?>" class="form-control" id="bannerlink">
						</div>
					  </div>
					  <div class="col-sm-4">
					 	 <div class="form-group">
							<label for="bannerlink">Gmail ID</label>
							<input type="text"  name="gmail"  value="<?= $brec['tt_gmail']; ?>" class="form-control" id="bannerlink">
						</div>
					  </div>
					  <div class="col-sm-4">
						<div class="form-group">
							<label for="heading">Facebook link</label>
							<input type="text"  name="facebook" class="form-control" value="<?= $brec['tt_facebook']; ?>">
						</div>
					  </div>
					  <div class="col-sm-4">
						<div class="form-group">
							<label for="heading">Twitter link</label>
							<input type="text"  name="twitter" class="form-control" value="<?= $brec['tt_twitter']; ?>">
						</div>
					  </div>
					  <div class="col-sm-4">
					 	 <div class="form-group">
							<label for="bannerlink">Instagram Link</label>
							<input type="text"  name="insta"  value="<?= $brec['tt_insta']; ?>" class="form-control" id="bannerlink">
						</div>
					  </div>
					   <div class="col-sm-4">
					 	 <div class="form-group">
							<label for="bannerlink">Pinterest</label>
							<input type="text"  name="google"  value="<?= $brec['tt_google']; ?>" class="form-control" id="bannerlink">
						</div>
					  </div>
				  </div>
                <div class="form-group">
                  <label for="bannerlink">Position</label>
                  <input type="number"  name="sort"  value="<?= $brec['tt_sort']; ?>" class="form-control" id="bannerlink">
                </div>
                <div class="row">
                <div class="col-sm-6">
				<div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <input type="file" name="bimage" class="form-control" id="exampleInputFile">
                  <input type="hidden" name="oldimg"  value="<?= $brec['tt_image']; ?>">
                   <p class="help-block">Image dimension must be 380 × 454 px & must be jpg format</p>
                   <img src="../uploads/team/<?= $brec['tt_image']; ?>" style="width:10%;">
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
                <input type="radio" value="1" id="optionsRadios3" name="status" <?php if($brec['tt_status']=='1'){ echo 'checked';}?>>
                <label for="optionsRadios3">Active</label>
                <input type="radio" value="0" id="optionsRadios4" name="status" <?php if($brec['tt_status']=='0'){ echo 'checked';}?>>
                <label for="optionsRadios4">Inactive</label>
                </div>


                <div id="dvPassport" style="display:none; border: 1px solid #242a30;padding: 10px;background: #fdfbef;"> 
                 <div class="form-group">
                  <label for="metatag">Meta Title</label>
                  <input type="text" name="metatag" id="metatag" value="<?= $brec['title']; ?>" class="form-control" >
                 </div>
                 
                  <div class="form-group">
                  <label for="keyword">Meta Keyword</label>
                  <textarea name="keyword" id="keyword" class="form-control" ><?= $brec['keyword']; ?></textarea>
                 </div>
                 
                 <div class="form-group">
                  <label for="metadescription">Meta Description</label>
                  <textarea name="metadescription" id="metadescription"  class="form-control" ><?= $brec['metadesc']; ?></textarea>
                 </div>
                </div><br>
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="update" class="btn btn-primary">Click Here To Update</button>
                <button type="reset" name="reset" class="btn btn-danger">Reset</button>
              <input id="btnPassport" type="button" class="btn btn-warning" value="Use Seo tools" name="btnPassport" /> 
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
<!------------------------>

<!------------------------------>    
    <script>
    window.onload = function() {
    var src = document.getElementById("heading"),
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
