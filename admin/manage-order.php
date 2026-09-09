<?php
require('checksession.php');
include '../inc/function.php';
$mqry = "SELECT * FROM `tbl_orders` WHERE `method` = 'COD' ORDER BY `date_time` DESC";

//change status..
if (isset($_POST['status']) && isset($_POST['order_id'])) {
	$orderId = mysqli_real_escape_string($conn, $_POST['order_id']);
	$status = mysqli_real_escape_string($conn, $_POST['status']);
	$xyz = mysqli_query($conn, "UPDATE tbl_orders SET status = $status WHERE id=$orderId");
	if ($xyz == true) {
		$aj = mysqli_query($conn, "SELECT * FROM tbl_orders WHERE id=$orderId");
		$maj = mysqli_fetch_assoc($aj);
		$serv = $maj['status'];
		$user = $maj['user_id'];

		$userData = mysqli_query($conn, "SELECT * FROM `tbl_users` where `id`='$user'");
		$user = mysqli_fetch_assoc($userData);


		if ($serv == 'cancelled') {
			$service = 'Has been Cancelled';
		}
		if ($serv == 'processing') {
			$service = 'is Processing';
		}
		if ($serv == 'dispatch') {
			$service = 'Has Been Dispatched';
		}
		if ($serv == 'delivered') {
			$service = 'has been Delivered';
		}
		//===========//
		$receipient = $user['email'];
		$orid = $orderId;
		$to = "$receipient";
		$subject = "Your Order $service";
		$body = '<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
		<tbody><tr>
			<td align="center" valign="top">
				<table width="600px" border="0" cellpadding="0" cellspacing="0" style="margin-top:50px;border:1px solid #ccc">
					<tbody><tr>
						<td align="left" style="text-align:left;padding:16px;background:#fff">
							<img src="' . SITE_URL . 'uploads/logo.png" style="width:100%;max-width:200px" class="CToWUd">
						</td>
					</tr>
					<tr style="background:#f3f3f3">
						<td align="left" style="text-align:left;padding:28px;font-family:sans-serif;line-height:24px">
							<h2 style="margin-bottom:0;color:#4a4a4a">Your Order ' . $service . '</h2>
							Thank you for Shopping with ' . SITE_NAME . ', We are glad you are here. Your Order number ' . $orid . ' ' . $service . '.<br><br>
							<a href=""></a>
							<p>Have a Good day
							<br>Team ' . SITE_NAME . '</p>
						</td>
					</tr>
					<tr style="background:#adbbbd;color:#ffffff">
						<td align="center" style="text-align:center;padding:10px;font-family:sans-serif;line-height:23px">
							<p>© ' . date('Y') . ', <a style="color:#ffffff" href="' . SITE_URL . '">' . SITE_NAME . '</a><br></p>
						</td>
					</tr>
				</tbody></table>
			</td>
		</tr>
	</tbody></table>';

		$headers .= 'From: ' . SITE_NAME . ' <' . SITE_EMAIL . '>' . "\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'Bcc:developerwt093@gmail.com' . "\r\n";
		$sent = mail($to, $subject, $body, $headers);
	}
	exit();
}

//delete row...
if (isset($_GET['delete-row'])) {
	$id = mysqli_real_escape_string($conn, $_GET['delete-row']);
	if (mysqli_query($conn, "UPDATE tbl_orders SET status = 0 WHERE id= $id") == true) {
		$_SESSION['toast']['msg'] = "Successfully deleted.";
		header('location:manage-order.php');
		exit();
	} else {
		$_SESSION['toast']['msg'] = "Something went wrong, Please try again.";
		header('location:manage-order.php');
		exit();
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
			<li class="breadcrumb-item"><a href="javascript:;">Order</a></li>
			<li class="breadcrumb-item active">Manage Order</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header">Manage Order</h1>
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
						<h4 class="panel-title">Manage Order</h4>
					</div>
					<!-- end panel-heading -->
					<form name="myform" method="post">
						<!-- begin alert -->

						<!-- end alert -->
						<!-- begin panel-body -->
						<div class="panel-body">
							<table id="data-table-responsive" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th width="1%">S.No.</th>
										<th width="1%">DATE</th>
										<th width="1%">ORDER-ID</th>
										<th class="text-nowrap">NAME</th>
										<!-- <th width="1%">EMAIL</th> -->
										<th class="text-nowrap">PHONE</th>
										<th width="1%">TOTAL</th>
										<th class="text-nowrap">METHOD</th>
										<th class="text-nowrap">STATUS</th>
										<th class="text-nowrap">PAYMENT</th>
										<th class="text-nowrap">OPTIONS</th>

									</tr>
								</thead>
								<tbody>
									<?php $count = 1;
									$fetch = mysqli_query($conn, $mqry);
									while ($web = mysqli_fetch_array($fetch)) {
										$pcdata = mysqli_query($conn, "select * from `tbl_users` where `id`='" . $web['user_id'] . "'");
										$pcrec = mysqli_fetch_array($pcdata);
									?>
										<tr class="odd gradeX">
											<td width="1%" class="f-s-600 text-inverse"><?php echo $count; ?></td>
											<td width="10%"><?php $bck = $web['date_time']; echo date('M d, Y', strtotime($bck)); ?></td>
											<td width="1%" style="font-weight:700; color:#00F;"><?= $web['order_id']; ?></td>
											<td width="10%" style="font-weight:700; color:#000;"><?= $pcrec['name']; ?></td>
											<!-- <td><?= $pcrec['email']; ?></td> -->
											<td width="10%"><?= $pcrec['phone']; ?></td>
											<td width="10%" style="font-weight:700; color:#F00;"><?= number_format($web['totalamount'],2); ?> /-</td>
											<td style="color:#00F; font-weight:700;"><?= $web['method']; ?></td>
											<td>
												<div class="form-group">
													<select class="order-status form-control" data-order-id="<?php echo $web['id']; ?>" style=" width: 110px; ">
														<option value="" selected="" disabled="">Change Status</option>
														<option value="cancelled" <?php if ($web['status'] == 'cancelled') { echo 'selected'; } ?>>Cancelled</option>
														<option value="processing" <?php if ($web['status'] == 'processing') { echo ' selected'; } ?>>Processing</option>
														<option value="dispatch" <?php if ($web['status'] == 'dispatch') { echo ' selected'; } ?>>Dispatched</option>
														<option value="delivered" <?php if ($web['status'] == 'delivered') { echo ' selected'; } ?>>Delivered</option>
													</select>
												</div>
											</td>
											<td width="10%">
												<div class="form-group">
													<a style="color:#fff;" class="btn btn-<?php if ($web['payment'] == 'Pending') { echo 'danger'; } else if ($web['payment'] == 'Success') { echo 'success'; } ?> btn-xs"><?php if ($web['payment'] == 'Pending') { echo 'Pending'; } else if ($web['payment'] == 'Success') { echo 'Success'; } ?></a>
												</div>
											</td>
											<td width="10%">
												<a target="_blank" href="generate-invoice.php?id=<?php echo $web['id']; ?>&print=true" class="btn btn-sm btn-danger btn-icon btn-square" data-toggle="tooltip" data-original-title="Download" style="background: #ff0600;"><i class="fa fa-cloud-download"></i></a>
												<a href="manage-orderdetail.php?id=<?php echo $web['id']; ?>" class="btn btn-danger btn-icon btn-sm btn-square" data-toggle="tooltip" data-original-title="View Invoice" style="background: #ff0600;"><i class="fa fa-eye"></i></a>
												<a href="delete/order-delete.php?id=<?php echo $web['id']; ?>" class="btn btn-danger btn-sm btn-icon btn-square" data-toggle="tooltip" data-original-title="Delete" onClick="if(confirm('Are You Sure Want To Delete This Order')){ return true;} else { return false; }" style="background: #ff0600;"><i class="fa fa-trash"></i></a>
											</td>
										</tr>
									<?php $count++;
									} ?>

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
	<script type="text/javascript">
		$(document).ready(function() {
			$("body").on('change', '.order-status', function() {
				var status = $(this).val(), orderId = $(this).data('order-id');
				if (status != "" && status != null) {
					$.ajax({
						url: 'ajax/order_status_update.php',
						type: 'post',
						data: {
							status: status,
							order_id: orderId
						},
						success: function(data) {
							console.log(orderId);
							 alert('Status Changed');
						},
						error: function() {
							alert('Something went wrong, Please try again');
						}
					});
				}
			});
		});
		//delete row...
		$('.delete-row').on('click', function() {
			var id = $(this).data('this-id');
			if (confirm("Do you want to delete this row?.")) {
				window.location = "?delete-row=" + id;
				return true;
			} else {
				return false;
			}
		});
	</script>

</body>

</html>