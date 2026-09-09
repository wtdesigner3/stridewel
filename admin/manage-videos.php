<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

@extract($_REQUEST);
require('checksession.php'); 
require('../inc/function.php');
$pid = $_GET['pid'];
if(isset($_POST['Deactivate']) && $bb!='')
{
  foreach($bb as $act)
  {
	  mysqli_query($conn,"update tbl_videos set b_status='0' where b_id='$act'");
  }
}
if(isset($_POST['Activate']) && $bb!='')
{
  foreach($bb as $act)
  {
	  mysqli_query($conn,"update tbl_videos set b_status='1' where b_id='$act'");
  }
}
if(isset($_POST['Delete']) && $bb!='')
{
  foreach($bb as $act)
  {
	  mysqli_query($conn,"delete from tbl_videos where b_id='$act'");
  }
}		
?>
<!DOCTYPE html>
<html lang="en">
<?php require('includes/head.php'); ?>
<body>
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade show"><span class="spinner"></span></div>
	<!-- begin #page-container -->
	<div id="page-container" class="fade in page-sidebar-fixed page-header-fixed">
		<!-- begin #header -->
		<?php require('includes/header.php'); ?>
		<!-- begin #sidebar -->
		<?php require('includes/left.php'); ?>
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home"></i></a></li>
				<li class="breadcrumb-item active">Benifits</li>
			</ol>
			<!-- begin page-header -->
			<h1 class="page-header"><a href="javascript:;" onClick="javascript:history.go(-1)" class="btn btn-l btn-icon btn-circle btn-primary" data-click="panel-remove"><i class="fa fa-arrow-left"></i></a> Manage Benifits</h1>
			<!-- begin row -->
			<div class="row">
				<!-- begin col-12 -->
				<div class="col-lg-12">
					<!-- begin panel -->
					<div class="panel panel-inverse">
						<!-- begin panel-heading -->
						<div class="panel-heading">
							<div class="panel-heading-btn">
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-refresh"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
							</div>
							<h4 class="panel-title">Manage Benifits</h4>
						</div>
						<!-- end panel-heading -->
                     <form name="myform" method="post" action=""> 
						<!-- begin alert -->
						<div class="alert alert-secondary fade show">
							<button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">&times;</span>
							</button>
							<div class="btn-group btn-group-justified">
                          <a href="add-videos.php?pid=<?=$pid?>" class="btn btn-default active"><i class="fa fa-plus"></i>Add New Benifits</a>
						  <input type="Submit" name="Activate" value="Activate" class="btn btn-info btn-flat"> 
                              <input type="Submit" name="Deactivate" value="Deactivate" class="btn btn-warning btn-flat"> 
                              <input type="Submit" name="Delete" class="btn btn-danger btn-flat" value="Delete" onClick="if(confirm('Are You Sure Want To Delete This Record')){ return true;} else { return false; }">
                            </div>
						</div>
						<!-- end alert -->
						<!-- begin panel-body -->
						<div class="panel-body">
                         <div class="table-responsive">
							<table id="data-table-responsive" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th width="1%">No</th>
                                        <th width="1%">Image</th> 
                                        <th width="1%">Name</th> 
                                        <th width="1%">Status</th>
                                        <th width="1%">Edit</th>
										<th width="1%">Delete</th>
							
										<th width="1%">
											 <input type="checkbox" id="select_all">
                                        </th>
                                      </tr>
								</thead>    
								<tbody>
                                <?php
                                     $cat_count = 0;
                                    $query = "";
                                    $mqry = "SELECT * FROM tbl_videos WHERE `service_id`='$pid'";
                                  
                                    $mqry .= " ORDER BY `b_id` DESC";
                                    
                                    $count = 1;
                                    $fetch = mysqli_query($conn, $mqry);
			                         while($web=mysqli_fetch_array($fetch)) { 
									
			                    ?>
									<tr class="odd gradeX">
										<td width="1%" class="f-s-600 text-inverse"><?= $count; ?></td>
										<td width="1%" class="with-img"><img src="../uploads/videosimage/<?php echo $web['b_image']; ?>" class="img-rounded height-60" /></td>
										<td ><?php echo $web['name']; ?></td>
                      		         	<td>
                                          <div class="switcher">
                                              <input type="checkbox" onClick="updateId('<?php echo $web['b_id']; ?>')" name="switcher_checkbox_1" id="switcher_checkbox_<?php echo $count;?>" <?php if( $web['b_status']=='1'){ echo "checked"; }else {} ?> value="1">
                                              <label for="switcher_checkbox_<?php echo $count;?>"></label>
                                          </div>
                                        </td>
										<td>
                                          <a href="edit-videos.php?bid=<?php echo $web['b_id'];?>&pid=<?=$pid?>" class='label label-sm label-primary' data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i> Edit</a>
                                        </td>
										<td>
                                          <a href="delete/videos.php?bid=<?php echo $web['b_id'];?>&pid=<?=$pid?>" onClick="if(confirm('Are You Sure Want To Delete This Record')){ return true;} else { return false; }" data-toggle="tooltip" title="Delete" class='label label-sm label-danger'><i class="fa fa-trash"></i> Delete</a>
                                         </td>
                                        
										 <td width="1%">
                                          <input type="checkbox" class="checkbox"  value="<?php echo $web['b_id']; ?>" name="bb[]" id="bb[]">
                                        </td>
									</tr>
                                    <?php $count++; }  ?>
								</tbody>
							</table>
                         </div>   
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
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
	<?php require('includes/footer.php'); ?>
	<script>
    $(document).ready(function() {
    App.init();
    TableManageResponsive.init();
    });
    </script>
    <script>
    function updateId(id)
    {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystaquaange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
    {
    //alert(xmlhttp.responseText);
    }
    };
    xmlhttp.open("GET", "status/videos.php?id=" +id, true);
    xmlhttp.send();
    }
    </script>
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
</body>
</html>
