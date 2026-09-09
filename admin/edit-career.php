<?php
require('checksession.php');
require('../inc/function.php');

$b = $_REQUEST['bid'];
$bdata = mysqli_query($conn, "SELECT * FROM `tbl_career` where `id`='$b'");
$brec = mysqli_fetch_array($bdata);
if (isset($_POST['update'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $sort = mysqli_real_escape_string($conn, $_POST['sort']);

    $query = mysqli_query($conn, "UPDATE `tbl_career` SET `job_title`='$title',`job_desc`='$desc',`status`='$status',`sort`='$sort' WHERE `id`='$b'");
    if ($query == true) {
        $_SESSION['success'] = "Updated Successfully";
        header("refresh:3;url=manage-career.php");
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
                <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home"></i></a></li>
                <li class="breadcrumb-item active">Edit Career</li>
            </ol>
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header"><a href="javascript:;" onClick="javascript:history.go(-1)"
                    class="btn btn-l btn-icon btn-circle btn-primary" data-click="panel-remove"><i
                        class="fa fa-arrow-left"></i></a> Manage Career </h1>
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
                            <h4 class="panel-title"> Edit Career</h4>
                        </div>
                        <!-- begin panel-body -->
                        <div class="panel-body">
                            <form role="form" method="POST" enctype="multipart/form-data">
                                <div class="box-body">

                                    <div class="form-group">
                                        <label for="bannerlink"> Job Title</label>
                                        <input type="text" name="title" class="form-control"
                                            value="<?= $brec['job_title']; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="bannerlink">Job Description</label>
                                        <textarea name="desc" placeholder="Enter  Description" rows="5"
                                            class="form-control"><?= $brec['job_desc'] ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="bannerlink"> Job Sort</label>
                                        <input type="text" name="sort" class="form-control"
                                            value="<?= $brec['sort']; ?>">
                                    </div>

                                    <div class="form-group">
                                        <input type="radio" value="1" id="optionsRadios3" name="status" <?php if ($brec['status'] == '1') {
                                            echo 'checked';
                                        } ?>>
                                        <label for="optionsRadios3">Active</label>

                                        <input type="radio" value="0" id="optionsRadios4" name="status" <?php if ($brec['status'] == '0') {
                                            echo 'checked';
                                        } ?>>
                                        <label for="optionsRadios4">Inactive</label>
                                    </div>

                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <button type="submit" name="update" class="btn btn-primary">Click To Update
                                        Data</button>
                                    <!-- <button type="reset" name="reset" class="btn btn-danger">Reset</button> -->
                                    <button type="button" onclick="myFunction()" class="btn btn-warning">Seo
                                        tools</button>
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
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade"
            data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
    </div>
    <!-- end page container -->

    <?php require("includes/footer.php"); ?>


    <script>
        $(document).ready(function () {
            App.init();
            initSample();
            CKEDITOR.replace('editor1', {
                filebrowserUploadUrl: 'assets/ckeditor/samples/get_imagelink.php',
            });
        });
    </script>
    <script>
        window.onload = function () {
            var src = document.getElementById("name"),
                dst = document.getElementById("url");
            src.addEventListener('input', function () {
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