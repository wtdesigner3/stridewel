<?php
require('checksession.php');
require('../inc/function.php');

if (isset($_POST['submit'])) {
	$title = mysqli_real_escape_string($conn, $_POST['title']);
	$subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$amount = mysqli_real_escape_string($conn, $_POST['amount']);
	$coupon = mysqli_real_escape_string($conn, $_POST['coupon']);
	$limit = mysqli_real_escape_string($conn, $_POST['limit']);
	$startd = mysqli_real_escape_string($conn, $_POST['startd']);
	$endd = mysqli_real_escape_string($conn, $_POST['endd']);
	$status = mysqli_real_escape_string($conn, $_POST['status']);

	$query = mysqli_query($conn, "INSERT INTO `tbl_discount`(`dis_title`, `dis_subtitle`, `dis_name`, `dis_amount`, `dis_coupon`,`dis_limit`,`dis_startdate`, `dis_enddate`, `dis_status`) VALUES ('$title', '$subtitle', '$name','$amount','$coupon','$limit','$startd','$endd', '$status')");
	if ($query == true) {
		$_SESSION['success'] = "Record Added successfully";
		header("Refresh: 3;");
	} else {
		$erromsg = "Something went wrong. Please try again";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require("includes/head.php"); ?>

<body>
	<style>
		.switcher label:after {
			content: '';
			height: 15px;
			width: 15px;
		}

		.switcher label:before {
			width: 36px;
			height: 19px;
		}
	</style>
	<!-- begin #page-container -->
	<?php require("includes/header.php"); ?>
	<!-- end #header -->
	<!-- begin #sidebar -->
	<?php require("includes/left.php"); ?>

	<!-- begin #content -->
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:;">Discount</a></li>
			<li class="breadcrumb-item"><a href="javascript:;">Manage Discount</a></li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header">Discount Management</h1>
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
						<h4 class="panel-title">Add Discount</h4>
					</div>
					<!-- end panel-heading -->

					<!-- begin panel-body -->
					<div class="panel-body">
						<form role="form" method="POST" enctype="multipart/form-data">
							<div class="box-body">

								<div class="row">
								    <div class="col-sm-6">
										<div class="form-group">
											<label for="bannerlink">Discount Title</label>
											<input type="text" name="title" placeholder="Enter Discount Title" class="form-control" id="bannerlink">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="bannerlink">Discount Subtitle</label>
											<input type="text" name="subtitle" placeholder="Enter Discount Subtitle" class="form-control" id="bannerlink">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="bannerlink">Discount Name</label>
											<input type="text" name="name" placeholder="Enter Discount Name" class="form-control" id="bannerlink">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="bannerlink">Discount Percent(%) (Applied on Total Price)<code> Ex: 5 / 10 </code></label>
											<input type="number" name="amount" placeholder="Enter Discount Percent(%)" class="form-control" id="bannerlink">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="bannerlink">Discount Coupon</label>
											<input type="text" name="coupon" placeholder="Discount Coupon EX:- ABC678886766" class="form-control" id="bannerlink">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="bannerlink">Minimum Price To Apply Coupon</label>
											<input type="number" name="limit" placeholder="Enter Minimum Price for Coupon Apply" class="form-control" id="bannerlink">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="bannerlink">Discount Start From Date (No Future Date Allowed)</label>
											<input type="date" name="startd" class="form-control" id="bannerlink">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="bannerlink">Discount End On Date</label>
											<input type="date" name="endd" class="form-control" id="bannerlink">
										</div>
									</div>

									<div class="col-sm-12" style="margin-top: 21px !important;">
										<div class="form-group">
											<input type="radio" value="1" id="optionsRadios3" name="status" checked>
											<label for="optionsRadios3">Active</label>
											<input type="radio" value="0" id="optionsRadios4" name="status">
											<label for="optionsRadios4">Inactive</label>
										</div>
									</div>
								</div>
							</div>
							<!-- /.box-body -->
							<div class="box-footer">
								<button type="submit" name="submit" class="btn btn-primary">Click Here To Submit</button>
								<button type="reset" name="reset" class="btn btn-danger">Reset</button>
							</div>
						</form>
					</div>
					<!-- end panel-body -->
				</div>
				<!-- end panel -->
			</div>

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
						<h4 class="panel-title">View Discount</h4>
					</div>
					<!-- end panel-heading -->
					<div class="panel-body">
						<!-- begin panel-body -->
						<div class="table-responsive">
							<table class="table table-striped table-bordered">
								<thead>
									<tr>
										<th width="1%">S.No.</th>
										<th class="text-nowrap">Discount Name</th>
										<th class="text-nowrap">% Discount</th>
										<th class="text-nowrap">Coupon</th>
										<th class="text-nowrap">Limit</th>
										<th class="text-nowrap">Start-Date</th>
										<th class="text-nowrap">End-Date</th>
										<th class="text-nowrap">Status</th>
										<th class="text-nowrap">Edit</th>
										<th class="text-nowrap">Delete</th>
									</tr>
								</thead>
								<tbody>
									<?php $count = 1;
									$trc = mysqli_query($conn, "SELECT * FROM `tbl_discount` ORDER BY `dis_id`");
									while ($mrc = mysqli_fetch_array($trc)) {
									?>
										<tr class="odd gradeX">
											<td width="1%" class="f-s-600 text-inverse"><?php echo $count; ?></td>
											<td><?php echo $mrc['dis_name']; ?></td>
											<td><?php echo $mrc['dis_amount']; ?></td>
											<td><?php echo $mrc['dis_coupon']; ?></td>
											<td>₹ <?php echo $mrc['dis_limit']; ?></td>
											<td><?php echo date('F d, Y', strtotime($mrc['dis_startdate'])); ?></td>
											<td><?php echo date('F d, Y', strtotime($mrc['dis_enddate'])); ?></td>
											<td>
												<div class="switcher">
													<input type="checkbox" onClick="window.location.href='status/discount.php?id=<?= $mrc['dis_id']; ?>'" name="switcher_checkbox_<?php echo $count; ?>" id="switcher_checkbox_<?php echo $count; ?>" <?php if ($mrc['dis_status'] == '1') { echo "checked"; } else { } ?> value="1">
													<label for="switcher_checkbox_<?php echo $count; ?>"></label>
												</div>
											</td>
											<td><a href="edit-discount.php?id=<?php echo $mrc['dis_id']; ?>" class="label label-sm label-primary" title="Edit" style="text-decoration: none;"><i class="fa fa-pencil"></i> Edit</a></td>
											<td><a href="delete/discount.php?cid=<?php echo $mrc['dis_id']; ?>" onClick="if(confirm('Are You Sure Want To Delete This Record')){ return true;} else { return false; }" class="label label-sm label-danger" title="Delete" style="text-decoration: none;"><i class="fa fa-trash"></i> Delete</a></td>
										</tr>
									<?php $count++;
									} ?>
								</tbody>
							</table>
						</div>
						<!-- end panel-body -->
					</div>
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
	<!--------------------------------------->


</body>

</html>