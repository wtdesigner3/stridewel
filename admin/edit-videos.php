<?php
require('checksession.php'); 
require('../inc/function.php');
$pid = $_GET['pid'];
$b=$_REQUEST['bid'];
$bdata=mysqli_query($conn,"SELECT * FROM `tbl_videos` where `b_id`='$b'");
$brec=mysqli_fetch_array($bdata);
$uploadPath = "../uploads/videosimage/"; 
if(isset($_POST['update']))
{
  $date = mysqli_real_escape_string($conn,$_POST['date']);
  	$tag= mysqli_real_escape_string($conn,$_POST['tag']);
  	$name = mysqli_real_escape_string($conn,$_POST['name']);
  $category = mysqli_real_escape_string($conn,$_POST['category']);
	$title = mysqli_real_escape_string($conn,$_POST['title']);
  $prourls = mysqli_real_escape_string($conn,$_POST['prourl']);
  $prourrl = str_replace(array( '\'', '"', ' ', ',' , ';', '*', ',', '/', '&', '_', '$', '--', '-', '<', '>','.','?' ), '-', $prourls);
  $prourl = strtolower($prourrl);
	$desc = mysqli_real_escape_string($conn,$_POST['desc']);
	    $sort = mysqli_real_escape_string($conn,$_POST['sort']);
	$status = mysqli_real_escape_string($conn,$_POST['status']); 
  $old = mysqli_real_escape_string($conn,$_POST['oldimg']); 
    $old2 = mysqli_real_escape_string($conn,$_POST['oldimgbroad']); 

  $metatag = mysqli_real_escape_string($conn,$_POST['metatag']);
	$keyword = mysqli_real_escape_string($conn,$_POST['keyword']);
	$metadesc = mysqli_real_escape_string($conn,$_POST['metadescription']);
		$alt = mysqli_real_escape_string($conn,$_POST['alt']); 
		$alt2 = mysqli_real_escape_string($conn,$_POST['alt2']); 
  $bimages=$_FILES['bimage']['name'];
  if($bimages!='')
  {
      $bimage=time()."_".$bimages;
      @unlink("../uploads/videosimage/".$old);
      move_uploaded_file($_FILES["bimage"]["tmp_name"], "../uploads/videosimage/".$bimage);
  }
  else{
      $bimage=$old;	
  }
  

   $query=mysqli_query($conn,"UPDATE `tbl_videos` SET `service_id`='$pid',`name`='$name' ,`b_image`='$bimage' ,`b_alt`='$alt' ,`b_category`='$category',`b_title`='$title',`b_sort`='$sort' ,`b_status`='$status',`b_desc`='$desc' WHERE `b_id`='$b'");
  if($query==true)
  {
  $_SESSION['success']="Benifits Updated Successfully";	
  header("refresh:3;url=manage-videos.php?pid=$pid");
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
				<li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home"></i></a></li>
				<li class="breadcrumb-item active">Edit Benifits</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header"><a href="javascript:;" onClick="javascript:history.go(-1)" class="btn btn-l btn-icon btn-circle btn-primary" data-click="panel-remove"><i class="fa fa-arrow-left"></i></a> Manage Benifits </h1>
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
							<h4 class="panel-title"> Edit Benifits</h4>
						</div>
						<!-- begin panel-body -->
						<div class="panel-body">
			<form role="form"  method="POST"  enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group d-none">
                  <label for="title">Category</label>
                  <select name="category" id="category" class="form-control">
                    <option value="">Select Category</option>
                         <?php
               $sql1=mysqli_query($conn,"SELECT * FROM `tbl_videos_category` WHERE `status`='1' and `service_id`='$pid'");
                            while($crec_1=mysqli_fetch_array($sql1))
                            {
                             
                            if($crec_1['id']==$brec['b_category'])
                            {
                            echo "<option value='$crec_1[id]' selected> $crec_1[name]</option>";
                            }
                            else
                            {
                            echo "<option value='$crec_1[id]'>$crec_1[name]</option>";
                            }
                      } ?>  
                  </select>
                </div>
                
                <div class="form-group">
                  <label for="bannerlink">Name</label>
                  <input type="text" name="name" class="form-control" id="name" value="<?= $brec['name']; ?>" >
                </div>
               
                <div class="form-group">
                  <label for="bannerlink">Description</label>
                  <input type="text" name="desc" class="form-control" value="<?= $brec['b_desc']; ?>" >
                </div>
               
               <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputFile">Image</label>
                  <input type="file" name="bimage" class="form-control" >
                  <input type="hidden" name="oldimg"  value="<?= $brec['b_image']; ?>">
                   <p class="help-block">Image dimension must be 512 × 512 px & must be jpg format</p>
                   <img src="../uploads/videosimage/<?= $brec['b_image']; ?>" style="width:20%;">
                </div>
                </div>
                 <div class="col-sm-6">
				 <div class="form-group">
                  <label for="title">Image Alt</label>
                  <input type="text" name="alt" class="form-control" placeholder="Enter Image Alt" value="<?= $brec['b_alt']; ?>">
                </div>
                </div>
                </div>
                
                      <div class="form-group">
                  <label for="exampleInputPassword1">Position</label>
                  <input type="number" name="sort" class="form-control" placeholder="1-10" value="<?= $brec['b_sort']; ?>">
                </div>
                   
                <div id="myDIV" style="display:none;border: 1px solid #000; padding: 9px;"> 
                    <div class="form-group">
                      <label for="metatag">Meta Title</label>
                      <input type="text" name="metatag" id="metatag" placeholder="Meta Title" class="form-control">
                    </div>
                    
                      <div class="form-group">
                      <label for="keyword">Meta Keyword</label>
                      <textarea name="keyword" id="keyword" placeholder="Meta Keyword" class="form-control" ></textarea>
                    </div>
                    
                    <div class="form-group">
                      <label for="metadescription">Meta Description</label>
                      <textarea name="metadescription" id="metadescription" placeholder="Meta Description" class="form-control" ></textarea>
                    </div>
                </div><br>

              
                
                <div class="form-group">
                <input type="radio" value="1" id="optionsRadios3" name="status" <?php if($brec['b_status']=='1'){ echo 'checked';}?>>
                <label for="optionsRadios3">Active</label>
                
                <input type="radio" value="0" id="optionsRadios4" name="status" <?php if($brec['b_status']=='0'){ echo 'checked';}?>>
                <label for="optionsRadios4">Inactive</label>
                </div>
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="update" class="btn btn-primary">Click To Update Data</button>
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
