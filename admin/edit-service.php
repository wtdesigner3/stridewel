<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require('checksession.php'); 
include '../inc/function.php';     

$b=$_REQUEST['bid'];
$bdata=mysqli_query($conn,"SELECT * FROM `tbl_service` where `id`='$b'");
$brec=mysqli_fetch_array($bdata);


if(isset($_POST['update']))
{
    $category = mysqli_real_escape_string($conn,$_POST['category_id']); 
    $name = mysqli_real_escape_string($conn,$_POST['name']); 
    $heading = mysqli_real_escape_string($conn,$_POST['heading']); 
    $producturl = mysqli_real_escape_string($conn, $_POST['url']);
    $purl = str_replace(array('\'', '"', ' ', ',', ';', '.', '!', '@', '(', ')', '(', '#', '^', '*', ',', '/', '&', '_', '$', '--', '-', '<', '>', '%','=',':','?','[',']','~','+','`','{','}','|'), '-', $producturl);
    $prourl = strtolower($purl);
  $metatag = mysqli_real_escape_string($conn,$_POST['metatag']);  
  $keyword = mysqli_real_escape_string($conn,$_POST['keyword']); 
  $metadesc = mysqli_real_escape_string($conn,$_POST['metadescription']);
  	$headtag = mysqli_real_escape_string($conn,$_POST['headtag']); 
  $position = mysqli_real_escape_string($conn,$_POST['position']); 
  $short_desc = mysqli_real_escape_string($conn,$_POST['short_desc']);  
  $long_desc = mysqli_real_escape_string($conn,$_POST['description']);  
  $architect = mysqli_real_escape_string($conn,$_POST['architect']);  
  $client = mysqli_real_escape_string($conn,$_POST['client']);  
  $term = mysqli_real_escape_string($conn,$_POST['term']);  
  $date = mysqli_real_escape_string($conn,$_POST['date']);  
  $location = mysqli_real_escape_string($conn,$_POST['location']);  
  $area = mysqli_real_escape_string($conn,$_POST['area']);  
  $status = mysqli_real_escape_string($conn,$_POST['status']); 
  $old = mysqli_real_escape_string($conn,$_POST['oldimg']); 
  $oldbimg = mysqli_real_escape_string($conn,$_POST['oldbimg']);
  $alt = mysqli_real_escape_string($conn,$_POST['alt']); 
  
 
    $bimage=$_FILES['bimage']['name'];
    if($bimage!='')
    {
      $bimage=time()."_".$bimage;      
      @unlink("../uploads/product/".$old); 
      move_uploaded_file($_FILES["bimage"]["tmp_name"], "../uploads/product/".$bimage);

    }
    else{
      $bimage=$old;
    }
    
   
    $broadimage=$_FILES['broadimage']['name'];
    if($broadimage!='')
    {
      $broadimage=time()."_".$broadimage;      
      @unlink("../uploads/product/".$oldbimg); 
      move_uploaded_file($_FILES["broadimage"]["tmp_name"], "../uploads/product/".$broadimage);

    }
    else{
      $broadimage=$oldbimg;
    }
      $query=mysqli_query($conn,"UPDATE `tbl_service` SET `category_id`='$category',`name`='$name',`heading`='$heading',`url`='$prourl',`tag`='$metatag',`keyword`='$keyword',`metadesc`='$metadesc',`broadimage`='$broadimage',`alt`='$alt',`sort`='$position',`image`='$bimage',`long_desc`='$long_desc',`short_desc`='$short_desc',`status`='$status',`architect`='$architect',`client`='$client',`term`='$term',`date`='$date',`area`='$area',`location`='$location',`headtag`='$headtag' WHERE `id`='$b'");
  
      if($query==true)
        {
    $_SESSION['success']="Project updated successfully";
    header("refresh:3;url=manage-service.php");    
        }
        else 
        {
        // Message for unsuccessfull insertion
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
				<li class="breadcrumb-item"><a href="javascript:;">Project Management</a></li>
				<li class="breadcrumb-item active">Edit Project</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header"><a href="javascript:;" onClick="javascript:history.go(-1)" class="btn btn-l btn-icon btn-circle btn-primary" data-click="panel-remove"><i class="fa fa-arrow-left"></i></a> Manage Project</h1>
		
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
							<h4 class="panel-title">Edit Project</h4>
						</div>
						<!-- end panel-heading -->
						
						<!-- begin panel-body -->
						<div class="panel-body">
							<form role="form" method="POST"  enctype="multipart/form-data">
              <div class="box-body">
             
               <div class="row">
                <div class="col-md-12 d-none">
                  <div class="form-group">
                    <label for="heading">Select Product Category</label>
                    <select name="category_id" id="category"  class="form-control"> 
                    
                      <?php
                        $sql1=mysqli_query($conn,"SELECT * FROM `tbl_service_category` WHERE `status`='1'");
                              while($crec_1=mysqli_fetch_array($sql1))
                              {
                              
                              if($crec_1['id']==$brec['category_id'])
                              {
                              echo "<option value='$brecc[id]' selected> $brecc[name]</option>";
                              }
                              else
                              {
                              echo "<option value='$crec_1[id]'>$crec_1[name]</option>";
                              }
                        } ?>  
                    </select>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="heading">Project Name</label>
                    <input type="text"  name="name" class="form-control" id="heading" value="<?= $brec['name']; ?>">
                  </div>
                </div>

                <div class="col-lg-6">
                 <div class="form-group">
                    <label for="heading">Project URL<code>Same as Project name & avoid Special Characters</code></label>
                    <input type="text" name="url" class="form-control" value="<?= $brec['url']; ?>" id="url" placeholder="Enter Project Url" required>
                </div>
                </div>

                <div class="col-lg-12 d-none">
                  <div class="form-group">
                    <label for="heading">Project Tagline</label>
                    <input type="text"  name="tagline" class="form-control" value="<?= $brec['tagline']; ?>">
                  </div>
                </div>

                <div class="col-lg-4">
                  <div class="form-group">
                    <label for="bannerlink">Image File</label>
                    <input type="file"  name="bimage"  class="form-control" id="bannerlink">
                    <input type="hidden" name="oldimg"  value="<?= $brec['image']; ?>">
                    <img src="../uploads/product/<?= $brec['image']; ?>" width="30%" >
                    <p class="help-block">Image dimension must be 668 X 645 px & must be jpg format</p>
                  </div>
                </div>

                <div class="col-lg-4">
                  <div class="form-group">
                  <label for="banner">Alt</label>
                  <input type="text" name="alt" class="form-control" value="<?= $brec['alt']; ?>">
                </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                      <label for="bannerlink">Breadcrumb Image File</label>
                      <input type="file"  name="broadimage"  class="form-control" id="bannerlink">
                      <input type="hidden" name="oldbimg"  value="<?= $brec['broadimage']; ?>">
                      <p class="help-block">Image dimension must be 1920 X 500 & must be jpg format</p>
                      <?php
                      if($brec['broadimage']>0){
                      ?>
                      <img src="../uploads/product/<?= $brec['broadimage']; ?>" width="80%" >
                    <?php
                      }
                    ?>
                    </div>
                </div>

                <div class="col-lg-12 d-none">
                  <div class="form-group">
                    <label for="banner">Heading</label>
                    <input type="text" name="heading" class="form-control" value="<?= $brec['heading']; ?>">
                  </div>
                </div>
   
            
                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Short Description</label>
                    <textarea  name="short_desc" class="form-control" id="editor1" placeholder="Enter text ..." rows="6"><?= $brec['short_desc']; ?></textarea>
                  </div>
                </div>

                <div class="col-lg-12">
                 <div class="form-group">
                  <label>Description</label>
                  <textarea  name="description" class="form-control" id="editor2" placeholder="Enter text ..." rows="6"><?= $brec['long_desc']; ?></textarea>
                </div>
                </div>

                <div class="col-lg-3">
                  <div class="form-group">
                    <label for="banner">Project Architect</label>
                    <input type="text" name="architect" value="<?= $brec['architect']; ?>" class="form-control">
                  </div>
                </div>

                <div class="col-lg-3">
                  <div class="form-group">
                    <label for="banner">Project Client</label>
                    <input type="text" name="client" value="<?= $brec['client']; ?>" class="form-control"  placeholder="Project Client" >
                  </div>
                </div>

                <div class="col-lg-3">
                  <div class="form-group">
                    <label for="banner">Project Term</label>
                    <input type="text" name="term" value="<?= $brec['term']; ?>" class="form-control"  placeholder="Project Term" >
                  </div>
                </div>

                <div class="col-lg-3">
                  <div class="form-group">
                    <label for="banner">Project Date</label>
                    <input type="date" name="date" value="<?= $brec['date']; ?>" class="form-control"  placeholder="Project Date" >
                  </div>
                </div>                

                <div class="col-lg-3">
                  <div class="form-group">
                    <label for="banner">Project Location</label>
                    <input type="text" name="location" value="<?= $brec['location']; ?>" class="form-control"  placeholder="Project Location" >
                </div>                
                  </div>

                <div class="col-lg-3">
                  <div class="form-group">
                    <label for="banner">Project Area</label>
                    <input type="text" name="area" value="<?= $brec['area']; ?>" class="form-control" placeholder="Project Area" >
                </div>                
                  </div>

                <div class="col-lg-12">
                	<div class="form-group">
                    <label for="exampleInputPassword1">Sort Number</label>
                    <input type="number" name="position" class="form-control" id="exampleInputPassword1" value="<?= $brec['sort']; ?>">
                  </div>
                </div>

              </div>
              

                <div class="form-group row m-b-10">
                  <label class="col-md-1 col-form-label">Status :-</label>
                  <div class="col-md-9">
                    <div class="radio radio-css radio-inline">
                      <input type="radio" name="status" id="optionsRadios4" value="1" <?php if($brec['status']=='1'){ echo 'checked';}?>>
                      <label for="optionsRadios4">Active</label>
                    </div>
                    <div class="radio radio-css radio-inline">
                      <input type="radio" name="status" id="optionsRadios3" value="0" <?php if($brec['status']=='0'){ echo 'checked';}?>>
                      <label for="optionsRadios3">Inactive</label>
                    </div>
                  </div>
                </div>
              

                <div id="dvPassport" style="display:none; border: 1px solid #242a30;padding: 10px;background: #fdfbef;"> 
                 <div class="form-group">
                  <label for="metatag">Meta Title</label>
                  <input type="text" name="metatag" id="metatag" value="<?= $brec['tag']; ?>" class="form-control" >
                 </div>
                 
                  <div class="form-group">
                  <label for="keyword">Meta Keyword</label>
                  <textarea name="keyword" id="keyword" class="form-control" ><?= $brec['keyword']; ?></textarea>
                 </div>
                 
                 <div class="form-group">
                  <label for="metadescription">Meta Description</label>
                  <textarea name="metadescription" id="metadescription"  class="form-control" ><?= $brec['metadesc']; ?></textarea>
                 </div>
                 
                 
                  <div class="form-group">
                    <label for="metadescription">Head Tag Detail</label>
                    <textarea name="headtag" rows="5" id="headtag" placeholder="Meta Description" class="form-control" ><?= $brec['headtag']; ?></textarea>
                 </div> 
                 
                </div><br>
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="update" class="btn btn-primary">Click Here To Update</button>
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
	
<script>
$(document).ready(function() {
	App.init();
	initSample();
  defult();
CKEDITOR.replace('editor1', {
    filebrowserUploadUrl: 'assets/ckeditor/samples/get_imagelink.php',
});
CKEDITOR.replace('editor2', {
    filebrowserUploadUrl: 'assets/ckeditor/samples/get_imagelink.php',
});
});
</script>
<!------------------>
<script>
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetBox = $("." + inputValue);
        $(".box").not(targetBox).hide();
        $(targetBox).show();
    });
});

function defult()
{
 
    var inputValue = $('input[type="radio"]:checked').attr("value");
    if(inputValue=="Submenu")
    {
      var targetBox = $("." + inputValue);
      $(".box").not(targetBox).hide();
      $(targetBox).show();
    }
    else{
      var targetBox = $("." + inputValue);
      $(".box").not(targetBox).hide();
      $(targetBox).show();
    }
   
    
}

</script>
<!----Seo tool----->
<!----Seo tool----->  
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
<!----Get Image----->
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
<!----End Get Image----->
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
function addRow() {
    const rowHTML = `
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="weight">Weight</label>
                    <input type="text" name="weight[]" placeholder="Enter Weight" class="form-control">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="weight">Price</label>
                    <input type="text" name="price[]" placeholder="Enter Price" class="form-control">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="weight">Stock</label>
                    <select class="form-control" name="stock[]">
                        <option selected>In stock</option>
                        <option>Out Of stock</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <button type="button" class="btn btn-danger" onclick="remoRow(this)" style="margin-top:25px">Delete</button>
            </div>
        </div>
    `;
    
    const rowsContainer = document.getElementById('rowsContainer');
    rowsContainer.insertAdjacentHTML('beforeend', rowHTML);
}
</script>


<script>
function removeRow(index) {
    var rowElement = document.getElementById('row' + index); // Get the row to be removed
    rowElement.parentNode.removeChild(rowElement); // Remove the row from the DOM
}
</script>


<script>
function remoRow(row) {
    var rowElement = row.parentNode.parentNode; // Get the row to be removed
    rowElement.parentNode.removeChild(rowElement); // Remove the row from the DOM
}
</script>


</body>
</html>
