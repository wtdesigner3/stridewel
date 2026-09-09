<?php
require('checksession.php'); 
include '../inc/function.php';     

$b=$_REQUEST['bid'];
$bdata=mysqli_query($conn,"SELECT * FROM `tbl_service_category` where `id`='$b'");
$brec=mysqli_fetch_array($bdata);
if(isset($_POST['update']))
{

  $bread_heading = mysqli_real_escape_string($conn,$_POST['bread_heading']); 
  $name = mysqli_real_escape_string($conn,$_POST['name']); 
  $producturl = mysqli_real_escape_string($conn, $_POST['url']);
  $purl = str_replace(array('\'', '"', ' ', ',', ';', '.', '!', '@', '(', ')', '(', '#', '^', '*', ',', '/', '&', '_', '$', '--', '-', '<', '>', '%','=',':','?','[',']','~','+','`','{','}','|'), '-', $producturl);
  $prourl = strtolower($purl);
  $metatag = mysqli_real_escape_string($conn,$_POST['metatag']);  
  $keyword = mysqli_real_escape_string($conn,$_POST['keyword']); 
  $metadesc = mysqli_real_escape_string($conn,$_POST['metadescription']);  
  $headtag = mysqli_real_escape_string($conn,$_POST['headtag']);  
  $desc = mysqli_real_escape_string($conn,$_POST['description']);  
  $position = mysqli_real_escape_string($conn,$_POST['position']);  
  $status = mysqli_real_escape_string($conn,$_POST['status']); 
	$faq_question = json_encode($_POST['faq_question']); 
	$faq_answer = json_encode($_POST['faq_answer']);   
  $oldbimg = mysqli_real_escape_string($conn,$_POST['oldbimg']);
  $oldbmainimg = mysqli_real_escape_string($conn,$_POST['oldbmainimg']);

    $broadimage=$_FILES['broadimage']['name'];
    if($broadimage!='')
    {
      $broadimage=time()."_".$broadimage;      
      @unlink("../uploads/service/".$oldbimg); 
      move_uploaded_file($_FILES["broadimage"]["tmp_name"], "../uploads/service/".$broadimage);

    }
    else{
      $broadimage=$oldbimg;
    }
   
    $main_image=$_FILES['main_image']['name']; 
    if($main_image!='')
    {
      $main_image=time()."_".$main_image;      
      @unlink("../uploads/service/".$oldbmainimg); 
      move_uploaded_file($_FILES["main_image"]["tmp_name"], "../uploads/service/".$main_image);

    }
    else{
      $main_image=$oldbmainimg;
    }
    
      $query=mysqli_query($conn,"UPDATE `tbl_service_category` SET `broadimage`='$broadimage',`main_image`='$main_image',`bread_heading`='$bread_heading',`description`='$desc',`name`='$name',`url`='$prourl',`metatag`='$metatag', `metakeyword`='$keyword', `metadesc`='$metadesc', `sort`='$position', `status`='$status', `faq_question`='$faq_question', `faq_answer`='$faq_answer', `headtag`='$headtag' WHERE `id`='$b'");
  
      if($query==true)
        {
    $_SESSION['success']="Service updated successfully";
    header("refresh:3;url=manage-service-category.php");    
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
				<li class="breadcrumb-item"><a href="javascript:;">Service Management</a></li>
				<li class="breadcrumb-item active">Edit Service </li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header"><a href="javascript:;" onClick="javascript:history.go(-1)" class="btn btn-l btn-icon btn-circle btn-primary" data-click="panel-remove"><i class="fa fa-arrow-left"></i></a> Manage Service </h1>
		
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
							<h4 class="panel-title">Edit Service</h4>
						</div>
						<!-- end panel-heading -->
						
						<!-- begin panel-body -->
						<div class="panel-body">
							<form role="form" method="POST"  enctype="multipart/form-data">
              <div class="box-body">
             
               <div class="row">
                   
                <div class="col-lg-6">
                    <div class="form-group">
                      <label for="heading">Service Name</label>
                      <input type="text"  name="name" class="form-control" id="heading" value="<?= $brec['name']; ?>">
                    </div>
                </div>
                
                <div class="col-lg-6">
                 <div class="form-group">
                    <label for="heading">Service URL<code>Same as Service name & avoid Special Characters</code></label>
                    <input type="text" name="url" class="form-control" value="<?= $brec['url']; ?>" id="url" placeholder="Enter Service Url" required>
                </div>
                </div>
                
                   
                <div class="col-lg-4">
                    <div class="form-group">
                      <label for="heading">Service Bread Heading</label>
                      <input type="text"  name="bread_heading" class="form-control" value="<?= $brec['bread_heading']; ?>">
                    </div>
                </div>               
                
              
                <div class="col-lg-4">
                     <div class="form-group">
                      <label for="bannerlink">Main Image File</label>
                      <input type="file"  name="main_image"  class="form-control" id="bannerlink">
                      <input type="hidden" name="oldbmainimg"  value="<?= $brec['main_image']; ?>">
                      <p class="help-block">Image dimension must be 1920 X 336 & must be jpg format</p>
                      <?php
                      if($brec['main_image']>0){
                      ?>
                      <img src="../uploads/service/<?= $brec['main_image']; ?>" width="30%" >
                    <?php
                      }
                    ?>
                    </div>
                </div>                
              
                <div class="col-lg-4">
                     <div class="form-group">
                      <label for="bannerlink">Breadcrumb Image File</label>
                      <input type="file"  name="broadimage"  class="form-control" id="bannerlink">
                      <input type="hidden" name="oldbimg"  value="<?= $brec['broadimage']; ?>">
                      <p class="help-block">Image dimension must be 1920 X 336 & must be jpg format</p>
                      <?php
                      if($brec['broadimage']>0){
                      ?>
                      <img src="../uploads/service/<?= $brec['broadimage']; ?>" width="30%" >
                    <?php
                      }
                    ?>
                    </div>
                </div>
                
				<div class="col-lg-12">
                    <div class="form-group">
                      <label for="heading">Service Description</label>
                      <textarea  name="description" class="form-control" id="editor1" placeholder="Enter Description" required><?= $brec['description']; ?></textarea>
                    </div>
                </div>
                
<div class="col-lg-12 mt-4">
    <h5>FAQs</h5>

    <div id="faq-wrapper">

        <?php
        $faq_answer = json_decode($brec['faq_answer']);
        $faq_question = json_decode($brec['faq_question']);
        if (!empty($faq_answer)) { ?>
            <?php foreach ($faq_answer as $index => $faq) { ?>
                <div class="faq-item border p-3 mb-3">
                    <div class="form-group">
                        <label>FAQ Question</label>
                        <input type="text" name="faq_question[]" 
                               class="form-control"
                               value="<?= htmlspecialchars($faq_question[$index]); ?>" 
                               >
                    </div>

                    <div class="form-group">
                        <label>FAQ Answer</label>
                        <textarea name="faq_answer[]" class="form-control" rows="3" ><?= htmlspecialchars($faq_answer[$index]); ?></textarea>
                    </div>

                    <button type="button" class="btn btn-danger btn-sm remove-faq">
                        Remove
                    </button>
                </div>
            <?php } ?>
        <?php } else { ?>
            <!-- If no FAQ exists -->
            <div class="faq-item border p-3 mb-3">
                <div class="form-group">
                    <label>FAQ Question</label>
                    <input type="text" name="faq_question[]" class="form-control" >
                </div>

                <div class="form-group">
                    <label>FAQ Answer</label>
                    <textarea name="faq_answer[]" class="form-control" rows="3" ></textarea>
                </div>
            </div>
        <?php } ?>

    </div>

    <button type="button" class="btn btn-primary btn-sm" onclick="addFaq()">
        + Add FAQ
    </button>
</div>
                

           
                <div class="col-lg-6">
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
                  <input type="text" name="metatag" id="metatag" value="<?= $brec['metatag']; ?>" class="form-control" >
                 </div>
                 
                  <div class="form-group">
                  <label for="keyword">Meta Keyword</label>
                  <textarea name="keyword" id="keyword" class="form-control" ><?= $brec['metakeyword']; ?></textarea>
                 </div>
                 
                 <div class="form-group">
                  <label for="metadescription">Meta Description</label>
                  <textarea name="metadescription" id="metadescription"  class="form-control" ><?= $brec['metadesc']; ?></textarea>
                 </div>
                 
                 <div class="form-group">
                  <label for="metadescription">Head Tag Detail</label>
                  <textarea name="headtag" id="headtag" rows="5"  class="form-control" ><?= $brec['headtag']; ?></textarea>
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
function addFaq() {
    const wrapper = document.getElementById('faq-wrapper');

    const html = `
        <div class="faq-item border p-3 mb-3">
            <div class="form-group">
                <label>FAQ Question</label>
                <input type="text" name="faq_question[]" class="form-control" >
            </div>

            <div class="form-group">
                <label>FAQ Answer</label>
                <textarea name="faq_answer[]" class="form-control" rows="3" ></textarea>
            </div>

            <button type="button" class="btn btn-danger btn-sm remove-faq">
                Remove
            </button>
        </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', html);
}

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-faq')) {
        e.target.closest('.faq-item').remove();
    }
});
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

</body>
</html>
