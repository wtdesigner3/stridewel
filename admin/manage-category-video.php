<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
@extract($_REQUEST);
require('checksession.php'); 
include '../inc/function.php'; 
$pid = $_REQUEST['pid'];
$cat=mysqli_fetch_assoc(mysqli_query($conn,"select * from tbl_category where `id`='$pid' order by sort asc "));
	
if(isset($_POST['Dectivate']) && $bb!='')
{
		foreach($bb as $act)
		{
			mysqli_query($conn,"update tbl_category_video set glry_status='0' where id_glry='$act'");
		}
}

		
if(isset($_POST['Activate']) && $bb!='')
{
		foreach($bb as $act)
		{
			mysqli_query($conn,"update tbl_category_video set glry_status='1' where id_glry='$act'");
		}
}
		

if(isset($_POST['Delete']) && $bb!='')
{
		foreach($bb as $act)
		{
			mysqli_query($conn,"delete from tbl_category_video where id_glry='$act'");
		}
}

		$mqry="select * from tbl_category_video where `glry_category`='$pid' order by glry_sort asc ";
		

if(isset($_POST['submit']))
{  
   	$miceid = mysqli_real_escape_string($conn,$_POST['miceid']);
    $link = mysqli_real_escape_string($conn,$_POST['link']);
    $alt = mysqli_real_escape_string($conn,$_POST['alt']);
	$position = mysqli_real_escape_string($conn,$_POST['position']);
	$status = mysqli_real_escape_string($conn,$_POST['status']);
	$metatag = mysqli_real_escape_string($conn, $_POST['metatag']);
	$keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
	$metadesc = mysqli_real_escape_string($conn, $_POST['metadescription']);
	
	$bimages=$_FILES['bimage']['name'];
  if($bimages!='')
  {
      $bimage=time()."_".$bimages;
      move_uploaded_file($_FILES["bimage"]["tmp_name"], "../uploads/products/".$bimage);
  }
  else{
      $bimage='';	
  }

            $query=mysqli_query($conn,"INSERT INTO `tbl_category_video`(`glry_category`,`glry_image`,`glry_link`,`alt`, `glry_status`, `glry_sort`) VALUES ('$miceid','$bimage','$link','$alt','$status','$position')");
            	$_SESSION['success']="Video Inserted successfully";
	
		if($query==true)
		{
		$_SESSION['success']="Video Inserted successfully";
		header("refresh:3;url=manage-category-video.php?pid=$pid");	
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
				<li class="breadcrumb-item"><a href="javascript:;"><?= $cat['name'];?> Video Management</a></li>
				<li class="breadcrumb-item active">Manage <?= $cat['name'];?> Video</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header"><a href="javascript:;" onClick="javascript:history.go(-1)" class="btn btn-l btn-icon btn-circle btn-primary" data-click="panel-remove"><i class="fa fa-arrow-left"></i></a>Manage <?= $cat['name'];?> Video </h1>
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
							<h4 class="panel-title">Manage <?= $cat['name'];?> Video</h4>
						</div>
						
							<div class="panel-body">
							<form role="form" method="POST"  enctype="multipart/form-data">
              <div class="box-body">
                     	<input type="hidden" name="miceid" class="form-control" value="<?= $cat['id']; ?>">
                <div class="form-group">
                    <label for="heading">Video URL</label>
                      <input type="text" name="link" class="form-control" placeholder="Ex: https://youtu.be/D6QCGtYwoLg?si=VJtu6tYVUyVI7BYa">
                </div>
        
                <div class="form-group">
                    <label for="exampleInputPassword1">Sort Number</label>
                    <input type="number" name="position" class="form-control" id="exampleInputPassword1" placeholder="1-10">
                </div>  
                  <div class="row">
                 <div class="col-12">
                 <div class="form-group">
                  <label for="exampleInputPassword1">Image File</label>
                  	<input type="file" name="bimage" class="form-control" id="exampleInputPassword1">
                  <p class="help-block">Image dimension must be 565 X 420 PX & must be jpg format</p>
                </div>
                </div>
                 
                </div>
                <div class="form-group">
                    <label for="heading">Alt</label>
                      <input type="text" name="alt" class="form-control" placeholder="Enter Image Alt Here!">
                </div>
                <div class="form-group">
                <input type="radio" value="1" id="optionsRadios3" name="status" checked>
                <label for="optionsRadios3">Active</label>
                <input type="radio" value="0" id="optionsRadios4" name="status">
                <label for="optionsRadios4">Inactive</label>
                </div>
              
              </div>
              <!-- /.box-body -->
	           <div id="myDIV" style="display:none;border: 1px solid #000; padding: 9px;">
					<div class="form-group">
						<label for="metatag">Meta Title</label>
						<input type="text" name="metatag" id="metatag" placeholder="Meta Title" class="form-control" >
					</div>

					<div class="form-group">
						<label for="keyword">Meta Keyword</label>
						<textarea name="keyword" id="keyword" placeholder="Meta Keyword" class="form-control"></textarea>
					</div>

					<div class="form-group">
						<label for="metadescription">Meta Description</label>
						<textarea name="metadescription" id="metadescription" placeholder="Meta Description" class="form-control"></textarea>
					</div>
				</div><br>
              <div class="box-footer">
                <button type="submit" name="submit" class="btn btn-primary">Click Here To Submit</button>
                <button type="reset" name="reset" class="btn btn-danger">Reset</button>
              </div>
            </form>
						</div>
						<!-- end panel-heading -->
                       <form name="myform" method="post" action=""> 
						<!-- begin alert -->
						<div class="alert alert-secondary fade show">
							<button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">&times;</span>
							</button>
							<div class="btn-group btn-group-justified">
									<input type="Submit" name="Activate" value="Activate" class="btn btn-info btn-flat">
									<input type="Submit" name="Dectivate" value="Deactivate" class="btn btn-warning btn-flat">
									<input type="Submit" name="Delete" class="btn btn-danger btn-flat" value="Delete" onClick="if(confirm('Are You Sure Want To Delete This Record')){ return true;} else { return false; }">
							</div>
						</div>
						<!-- end alert -->
						<!-- begin panel-body -->
						<div class="panel-body">
							<table id="data-table-responsive" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th width="1%">S.No.</th>
										<th width="1%" data-orderable="false">Image</th>
										<th class="text-nowrap">Category</th>
										<th class="text-nowrap">Status</th>
										<th class="text-nowrap">Edit</th>
										<th class="text-nowrap">Delete</th>
                                        <th width="1%">
											 <input type="checkbox" id="select_all">
                                         </th>
									</tr>
								</thead>
								<tbody>
                                <?php $count=1; $fetch=mysqli_query($conn,$mqry);
			                          while($web=mysqli_fetch_array($fetch)) { 
									  
									
			                    ?>
									<tr class="odd gradeX">
										<td width="1%" class="f-s-600 text-inverse"><?php echo $count;?></td>
										<td width="10%" class="with-img"><?php if($web['glry_image']==''){ ?><img src="../uploads/no_img.jpg" class="img-rounded height-50" /><?php }else{ ?><img src="../uploads/products/<?php echo $web['glry_image']; ?>" class="img-rounded height-60" /><?php } ?></td>
                                       

                                        <td><?= $cat['name'];?></td>
												
                                        <td><div class="switcher">
                                              <input type="checkbox" onClick="updateId('<?php echo $web['id_glry']; ?>')" name="switcher_checkbox_1" id="switcher_checkbox_<?php echo $count;?>" <?php if( $web['glry_status']=='1'){ echo "checked"; }else {} ?> value="1">
                                              <label for="switcher_checkbox_<?php echo $count;?>"></label>
                                            </div>
                                        </td>
										
										<td><a href="edit-category-video.php?cid=<?php echo $web['id_glry'];?>&pid=<?php echo $web['glry_category'];?>" class='label label-sm label-primary' title="Edit"><i class="fa fa-edit"></i> Edit</a></td>
										<td><a href="delete/category-video.php?cid=<?php echo $web['id_glry'];?>&pid=<?php echo $web['glry_category'];?>" class='label label-sm label-danger' onClick="if(confirm('Are You Sure Want To Delete This Record')){ return true;} else { return false; }" title="Delete"><i class="fa fa-trash"></i> Delete</a></td>
                                        <td>
                                          <input type="checkbox" class="checkbox" value="<?php echo $web['id_glry']; ?>" name="bb[]" id="bb[]">
                                        </td>
									</tr>
								<?php $count++; }?>	
                                    
								</tbody>
							</table>
						</div>
						<!-- end panel-body -->
                        </form>
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
			TableManageResponsive.init();
		});
	</script>
<!------------------------------>    
 <script>
function updateId(id)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
            //alert(xmlhttp.responseText);
        }
    };
    xmlhttp.open("GET", "status/category-video.php?id=" +id, true);
    xmlhttp.send();
}
</script>
 <!--------------------------------------->  
	<script type="text/javascript">
    $(document).ready(function(){
        $('#select_all').on('click',function(){
            if(this.checked){
                $('.checkbox').each(function(){
                    this.checked = true;
                });
            }else{
                 $('.checkbox').each(function(){
                    this.checked = false;
                });
            }
        });
        
        $('.checkbox').on('click',function(){
            if($('.checkbox:checked').length == $('.checkbox').length){
                $('#select_all').prop('checked',true);
            }else{
                $('#select_all').prop('checked',false);
            }
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
</body>
</html>
