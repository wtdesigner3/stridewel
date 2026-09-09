<?php
require('checksession.php');
require('../inc/function.php');
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
			<li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home"></i></a></li>
			<li class="breadcrumb-item active">Shipping</li>
		</ol>
		<!-- begin page-header -->
		<h1 class="page-header"><a href="javascript:;" onClick="javascript:history.go(-1)" class="btn btn-l btn-icon btn-circle btn-primary" data-click="panel-remove"><i class="fa fa-arrow-left"></i></a> Manage Shipping </h1>
		<!-- begin row -->
		<div class="row">
			<?php if (isset($_GET['edit'])) { ?>
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
							<h4 class="panel-title">Update Shipping Charge</h4>
						</div>
						<!-- end panel-heading -->

						<!-- begin panel-body -->
						<div class="panel-body">

							<?php
							$bdata = mysqli_query($conn, "SELECT * FROM `tbl_shipping`");
							$brec = mysqli_fetch_array($bdata);
							if (isset($_POST['updateshipping'])) {
								$maxprice = mysqli_real_escape_string($conn, $_POST['maxamount']);
								$shippingamount = mysqli_real_escape_string($conn, $_POST['shippingamount']);
								$query = mysqli_query($conn, "UPDATE `tbl_shipping` SET `maxprice`='$maxprice', `shippingamount`='$shippingamount'");
								if ($query == true) {
								    //$_SESSION['success'] = "Shipping Price Updated successfully";
									echo "<script>alert('Shipping Price Updated successfully'); window.location.href='manage-shipping.php'; </script>";
									//header("refresh:3;url=manage-shipping.php");
								} else {
									$_SESSION['error'] = "Something went wrong. Please try again";
								}
							}
							?>
							<form role="form" method="POST" enctype="multipart/form-data">
								<div class="box-body">
									<div class="row">

										<div class="form-group col-6">
											<label>ENTER MAX AMOUNT</label>
											<input type="number" name="maxamount" class="form-control" placeholder="Enter Max Amount" required="" value="<?= $brec['maxprice']; ?>">
										</div>

										<div class="form-group col-6">
											<label>ENTER SHIPPING CHARGERS</label>
											<input type="number" name="shippingamount" class="form-control" placeholder="Enter Shipping Charge" required="" value="<?= $brec['shippingamount']; ?>">
										</div>
									</div>
								</div>
								<!-- /.box-body -->
								<div class="box-footer">
									<button type="submit" name="updateshipping" class="btn btn-primary">Click To Update Data</button>
									<a class="btn btn-danger" href="manage-shipping.php">Cancel</a>
								</div>
							</form>

						</div>
						<!-- end panel-body -->
					</div>
					<!-- end panel -->
				</div>
			<?php } ?>
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
						<h4 class="panel-title">Manage Shipping </h4>
					</div>
					<!-- end panel-heading -->
					<form name="myform" method="post" action="">
						<!-- begin panel-body -->
						<div class="panel-body">
							<div class="table-responsive">
								<table id="data-table-responsive" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th width="1%">No</th>
											<th class="text-nowrap">Max Price</th>
											<th class="text-nowrap">Shipping Charge</th>
											<th width="1%">Edit</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$mqry = "select * from tbl_shipping order by id desc";
										$fetch = mysqli_query($conn, $mqry);
										while ($web = mysqli_fetch_array($fetch)) {
										?>
											<tr class="odd gradeX">
												<td width="1%" class="f-s-600 text-inverse">1</td>
												<td style="font-weight:700; color:#000;">₹ <?= $web['maxprice']; ?></td>
												<td style="font-weight:700; color:#000;">₹ <?= $web['shippingamount']; ?></td>
												<td><a href="manage-shipping.php?edit=<?php echo $web['id']; ?>" class='label label-sm label-primary' data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i> Edit</a></td>

											</tr>
										<?php } ?>
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

	<?php require("includes/footer.php"); ?>
	<script>
		$(document).ready(function() {
			App.init();
			TableManageResponsive.init();
		});
	</script>
</body>

</html>