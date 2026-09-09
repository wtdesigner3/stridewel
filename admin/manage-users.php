<?php
require('checksession.php');
@extract($_REQUEST);
include '../inc/function.php';
//-------------------------------//
$mqry = "select * from `tbl_users` order by `add_on` desc";
//-------------------------------//
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
			<li class="breadcrumb-item"><a href="javascript:;">Users Management</a></li>
			<li class="breadcrumb-item active">View Registered Users</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"> Registered Users </h1>
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
						<h4 class="panel-title">Registered Users</h4>
					</div>
					<!-- end alert -->
					<!-- begin panel-body -->
					<div class="panel-body">
						<table id="data-table-responsive" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th width="1%">S.No.</th>
									<!-- <th width="1%">Image</th> -->
									<th class="text-nowrap">Date</th>
									<th class="text-nowrap">Name</th>
									<th class="text-nowrap">Email</th>
									<th class="text-nowrap">Phone</th>
									<th class="text-nowrap">Status</th>
									<th class="text-nowrap">View</th>
								</tr>
							</thead>
							<tbody>
								<?php $count = 1;
								$fetch = mysqli_query($conn, $mqry);
								while ($web = mysqli_fetch_array($fetch)) {
								?>
									<tr class="odd gradeX" style="font-weight:600;">
										<td width="1%" class="f-s-600 text-inverse"><?php echo $count; ?></td>
										<!-- <td width="1%" class="with-img"><?php if(!empty($web['image'])){?><img src="../uploads/profiles/<?php echo $web['image']; ?>" class="img-rounded height-60" /><?php }else{ ?> <img src="../uploads/dummy.png" class="img-rounded height-60" /> <?php } ?></td> -->
										<td><?php $beck = $web['add_on']; echo date('d M, Y', strtotime($beck)); ?></td>
										<td> <?php echo $web['name']; ?></td>
										<td><?php echo $web['email']; ?></td>
										<td><?php echo $web['phone']; ?></td>
										<td>
											<?php
											if ($web['status'] == '1')
												echo '<a title="Active" href="status/users.php?id=' . $web['id'] . '" class="label label-sm label-success" style="text-decoration:none; color:#FFF;"><i class="fa fa-check"></i> Active</a>';
											else
												echo '<a title="Inactive" href="status/users.php?id=' . $web['id'] . '" class="label label-sm label-danger" style="text-decoration:none; color:#FFF;"><i class="fa fa-times"></i> Inactive</a>';
											?>
										</td>
										<td class="d-flex">
											<div class="form-group"><a style="color:#fff;" data-toggle="modal" data-target="#myModal<?= $web['id']; ?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a></div>
												<div class="modal" id="myModal<?= $web['id']; ?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																
																<?php if($web["image"]!=''){ ?>
																	<img class="card-img-top" src="../uploads/profiles/<?= $web['image']; ?>" alt="Card image" style="width: 90px; height: 90px; object-fit: contain; padding: 10px;border-radius : 20px;border:2px solid #03373c;">
																<?php } else { ?>
																	<img class="card-img-top" src="../uploads/dummy.png" alt="Card image" style="width: 90px; height: 90px; object-fit: contain; padding: 10px;border-radius : 20px;border:2px solid #03373c;">
																<?php } ?>	
																<h4 class="modal-title text-center mt-3 text-capitalize"><?= $web['name']; ?></h4><br>
																<button type="button" class="close" data-dismiss="modal">&times;</button>
															</div>
															<div class="modal-body">
																<table class="table table-striped">
																	<thead>
																		<tr><th>Name </th> <th><?= $web['name']; ?></th></tr>
																	</thead>
																	<tbody>
																	<tr><td>Phone</td><td><?= $web['phone']; ?></td></tr>
																	<tr><td>Email</td><td><?= $web['email']; ?></td></tr>
																	<tr><td>Country</td><td><?= $web['country']; ?></td></tr>
																	<tr><td>State</td><td><?= $web['state']; ?></td></tr>
																	<tr><td>City</td><td><?= $web['city']; ?></td></tr>
																	<tr><td>Address</td><td><?= $web['address']; ?></td></tr>
																	<tr><td>Pincode</td><td><?= $web['pincode']; ?></td></tr>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
												</div>
										</td>
									</tr>
								<?php $count++;
								} ?>
							</tbody>
						</table>
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
			TableManageResponsive.init();
		});
	</script>




</body>

</html>