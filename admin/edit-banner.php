<?php
require('checksession.php');
require('../inc/function.php');
$b = $_REQUEST['bid'];
$bdata = mysqli_query($conn, "SELECT * FROM `tbl_banner` where `bnr_id`='$b'");
$brec = mysqli_fetch_array($bdata);
if (isset($_POST['update'])) {
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
  	$desc = mysqli_real_escape_string($conn, $_POST['desc']);
  $link = mysqli_real_escape_string($conn, $_POST['link']);
  $position = mysqli_real_escape_string($conn, $_POST['position']);
  $status = mysqli_real_escape_string($conn, $_POST['status']);
  $old = mysqli_real_escape_string($conn, $_POST['oldimg']);

  $bimage = $_FILES['bimage']['name'];
  if($bimage!=''){
      $bimage = time() . "_" . $bimage;
      @unlink("../uploads/banner/" . $old);
      move_uploaded_file($_FILES["bimage"]["tmp_name"], "../uploads/banner/" . $bimage);
  } else {
    $bimage = $brec['bnr_image'];
  }

  $query = mysqli_query($conn, "UPDATE `tbl_banner` SET `bnr_title`='$title',`bnr_subtitle`='$subtitle', `bnr_desc`='$desc',`bnr_url`='$link', `bnr_sort`='$position', `bnr_image`='$bimage', `bnr_status`='$status' WHERE `bnr_id`='$b'");
  if ($query == true) {
    $_SESSION['success'] = "Banner Updated Successfully";
    header("refresh:3;url=manage-banner.php");
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
      <li class="breadcrumb-item"><a href="javascript:;">Banner Management</a></li>
      <li class="breadcrumb-item active">Edit Banner</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header"><a href="javascript:;" onClick="javascript:history.go(-1)" class="btn btn-l btn-icon btn-circle btn-primary" data-click="panel-remove"><i class="fa fa-arrow-left"></i></a> Manage Banner </h1>
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
            <h4 class="panel-title"> Edit Banner</h4>
          </div>
          <!-- begin panel-body -->
          <div class="panel-body">
            <form role="form" method="POST" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                  <label for="banner">Banner Title</label>
                  <input type="text" name="title" class="form-control" id="banner" value="<?= $brec['bnr_title']; ?>">
                </div>


                <div class="form-group">
                  <label for="banner">Banner Subtitle</label>
                  <input type="text" name="subtitle" class="form-control" id="banner" value="<?= $brec['bnr_subtitle']; ?>">
                </div>
                
                <div class="form-group d-none">
					<label for="banner">Banner Description</label>
					<textarea type="text" name="desc" class="form-control" id="editor1" ><?= $brec['bnr_desc']; ?></textarea>
				</div>


                <div class="form-group d-none">
                  <label for="bannerlink">Banner Link</label>
                  <input type="text" name="link" class="form-control" id="bannerlink" value="<?= $brec['bnr_url']; ?>">
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">Banner position</label>
                  <input type="number" name="position" class="form-control" id="exampleInputPassword1" value="<?= $brec['bnr_sort']; ?>">
                </div>

                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <input type="file" name="bimage" class="form-control" id="exampleInputFile">
                  <input type="hidden" name="oldimg" value="<?= $brec['bnr_image']; ?>">
                  <p class="help-block">Image dimension must be 900 X 600 px & must be jpg format</p>
                  <img src="../uploads/banner/<?= $brec['bnr_image']; ?>" style="width:20%;">
                </div>
                 

                <div class="form-group">
                  <input type="radio" value="1" id="optionsRadios3" name="status" <?php if ($brec['bnr_status'] == '1') { echo 'checked'; } ?>>
                  <label for="optionsRadios3">Active</label>

                  <input type="radio" value="0" id="optionsRadios4" name="status" <?php if ($brec['bnr_status'] == '0') { echo 'checked'; } ?>>
                  <label for="optionsRadios4">Inactive</label>
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
      });
</script>

</body>

</html>