<?php

require('checksession.php');
require('../inc/function.php');

if (isset($_POST['submit'])) {

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $sort = mysqli_real_escape_string($conn, $_POST['sort']);

    $query = mysqli_query($conn, "INSERT INTO `tbl_career`(`job_title`, `job_desc`, `status`,`sort`) VALUES ('$title','$desc','$status','$sort')");
    if ($query == true) {
        $_SESSION['success'] = "Added successfully";
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
                <li class="breadcrumb-item active">Add Career</li>
            </ol>
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header"><a href="javascript:;" onClick="javascript:history.go(-1)"
                    class="btn btn-l btn-icon btn-circle btn-primary" data-click="panel-remove"><i
                        class="fa fa-arrow-left"></i></a> Manage Career</h1>
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
                            <h4 class="panel-title">Add Career</h4>
                        </div>
                        <!-- begin panel-body -->
                        <div class="panel-body">
                            <form role="form" method="POST" enctype="multipart/form-data">
                                <div class="box-body">

                                    <div class="form-group">
                                        <label for="title"> Job Title</label>
                                        <input type="text" name="title" class="form-control"
                                            placeholder="Enter  Job Title">
                                    </div>

                                    <div class="form-group">
                                        <label for="heading">Job Description</label>
                                        <textarea name="desc" class="form-control" rows="5"
                                            placeholder="Enter Job Description" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="title"> Job Sort</label>
                                        <input type="text" name="sort" class="form-control"
                                            placeholder="Enter  Job Sort">
                                    </div>

                                    <div class="form-group">
                                        <input type="radio" value="1" id="optionsRadios3" name="status" checked>
                                        <label for="optionsRadios3">Active</label>
                                        <input type="radio" value="0" id="optionsRadios4" name="status">
                                        <label for="optionsRadios4">Inactive</label>
                                    </div>

                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <button type="submit" name="submit" class="btn btn-primary">Click To Submit
                                        Data</button>
                                    <!-- <button type="reset" name="reset" class="btn btn-danger">Reset</button> -->
                                    <button type="button" onclick="myFunction()" class="btn btn-warning">Seo
                                        tools</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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