<?php

require('checksession.php'); 
require('../inc/function.php');
$b=$_REQUEST['bid'];
if(isset($_POST['Dectivate']) && $bb!='')
{
  foreach($bb as $act)
  {
	  mysqli_query($conn,"update tbl_visa_applied set va_status='0' where va_id='$act'");
  }
}

if(isset($_POST['Activate']) && $bb!='')
{
  foreach($bb as $act)
  {
	  mysqli_query($conn,"update tbl_visa_applied set va_status='1' where va_id='$act'");
  }
}

if(isset($_POST['Delete']) && $bb!='')
{
  foreach($bb as $act)
  {
	  mysqli_query($conn,"delete from tbl_visa_applied where va_id='$act'");
  }
}
		
$mqry="select * from tbl_visa_applied where `va_id`='$b'";
$mqry.=" order by va_sort asc";
$fetch=mysqli_query($conn,$mqry);
 $web=mysqli_fetch_array($fetch) ;
?>
<!DOCTYPE html>
<html lang="en">
<?php require('includes/head.php'); ?>
<style>
 hr {
            border: none; /* Reset border properties */
            border-top: 2px solid red; /* Set border color and width */
        }
</style>
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
				<li class="breadcrumb-item"><a href="index.php">Home</a></li>
				<li class="breadcrumb-item"><a href="javascript:;"><?= $web['va_fname']; ?> <?= $web['va_lname']; ?> Visa Applied For <?= $web['va_appliedcountry']; ?></a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header"><a href="javascript:;" onClick="javascript:history.go(-1)" class="btn btn-l btn-icon btn-circle btn-primary" data-click="panel-remove"><i class="fa fa-arrow-left"></i></a><?= $web['va_fname']; ?> <?= $web['va_lname']; ?> Visa Applied For <?= $web['va_appliedcountry']; ?></h1>
			<!-- end page-header -->
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
							<h4 class="panel-title"><?= $web['va_fname']; ?> <?= $web['va_lname']; ?> Visa Applied For <?= $web['va_appliedcountry']; ?></h4>
						</div>
						<!-- end panel-heading -->
                     <form name="myform" method="post" action=""> 
						<!-- begin alert -->
					
						<!-- end alert -->
						<!-- begin panel-body -->
						<div class="panel-body">
                         <div class="table-responsive">
							<table id="data-table-responsive" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th width="1%">No</th>
										<th width="1%" data-orderable="false">Image</th>
										<th width="1%">Documents</th>
								     	<th width="1%">Print Document</th>
                                      </tr>
								</thead>
								<tbody>
                                <?php 
								     $count=1; 
									 $fetch=mysqli_query($conn,$mqry);
			                         while($web=mysqli_fetch_array($fetch)) { 
			                    ?>
									<tr class="odd gradeX">
										<td width="1%" class="f-s-600 text-inverse"><?= $count;?></td>
										
										<td width="1%" class="with-img"><?php if($web['va_photo']==''){ ?><img src="../uploads/no.png" class="img-rounded height-40" /><?php }else{ ?><img src="../uploads/visasteps/<?php echo $web['va_photo'];?>" class="img-rounded height-40" /><?php } ?></td>
											<td width="30%" class="f-s-600 text-inverse">Photo</td>
    									    <td width="30%" class="f-s-600 text-inverse"><button  onclick="printAndDownloadImage()"><i class="fa fa-print" style="font-size:15px"></i></button></td>
									
									</tr>
										<div class="modal" id="myModal">
                                            <div class="modal-content">
                                                <span class="close" id="closeModal">&times;</span>
                                                <center><h3 class="panel-title" style="text-decoration:underline"><?= $web['va_fname'] ; ?> <?= $web['va_lname'] ;?></h3></center>
                                                <hr>
                                                <div class="row" style="border:1px solid; border-top:none!important; padding:20px; background: #f2f3f4;">
                                                    <div class="col-md-4"><center>Documents</center></div>
                                                    <div class="col-md-4"><center>Name</center></div>
                                                    <div class="col-md-4"><center>Print Document</center></div>
                                                </div>
                                                
                                                <div class="row" style="border:1px solid;  border-top:none!important; padding:10px; background: #f2f3f4;">
                                                    <div class="col-md-4"><center><img src="../uploads/visasteps/<?= $web['va_photo']; ?>" id="sog" style="width:15%;"></center></div>
                                                    <div class="col-md-4"><center>Photo</center></div>
                                                    <div class="col-md-4"><center><button  onclick="printAndDownloadImage()"><i class="fa fa-print" style="font-size:15px"></i></button></center></div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    <?php $count++; } ?>
                                    
                                    
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
		<!-- end #content -->
	
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
		  xmlhttp.onreadystatechange = function() {
			  if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
			  {
				  //alert(xmlhttp.responseText);
			  }
		  };
		  xmlhttp.open("GET", "status/banner.php?id=" +id, true);
		  xmlhttp.send();
	  }
   </script>
    <!----------------Check Box-----------------------> 
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
  // Get references to the modal and link elements
const modal = document.getElementById("myModal");
const openModalLink = document.getElementById("openModalLink");
const closeModal = document.getElementById("closeModal");

// Function to open the modal
function openModal() {
    modal.style.display = "block";
}

// Function to close the modal
function closeModalFunction() {
    modal.style.display = "none";
}

// Event listeners
openModalLink.addEventListener("click", function(event) {
    event.preventDefault(); // Prevent the default link behavior
    openModal();
});

closeModal.addEventListener("click", closeModalFunction);

// Close the modal if the user clicks outside of it
window.addEventListener("click", function(event) {
    if (event.target === modal) {
        closeModalFunction();
    }
});

    </script>
    <script>
    function printAndDownloadImage() {
        const image = document.getElementById('sog');
        const printWindow = window.open('', '', 'width=600,height=600');
        printWindow.document.open();
        printWindow.document.write('<html><head><title>Print Image</title></head><body>');
        printWindow.document.write('<img src="' + image.src + '" style="width:100%;">');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
        
        const downloadLink = document.createElement('a');
        downloadLink.href = image.src;
        downloadLink.download = 'downloaded_image.jpg';
        downloadLink.style.display = 'none';
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
    
    
</script>
</body>
</html>
