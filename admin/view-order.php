<?php
require('checksession.php');
include '../inc/function.php';

if (isset($_GET['id'])) {
	$id = mysqli_real_escape_string($conn, $_GET['id']);
	$dataQ = mysqli_query($conn, "SELECT * FROM tbl_orders WHERE id='$id'");
	$data = mysqli_fetch_assoc($dataQ);
	//====User====//
	$dasA = mysqli_query($conn, "SELECT * FROM tbl_users WHERE id='" . $data['user_id'] . "'");
	$daA = mysqli_fetch_assoc($dasA);
	$proTotal = explode(',', $data['p_price']);
	$proName = explode(',', $data['p_name']);
	$procode = explode(',', $data['p_code']);
	$prodGst = explode(',', $data['p_gst']);
	$prodIdArr = explode(',', $data['p_id']);
	$prodQuan = explode(',', $data['p_quantity']);
	$prodIMG = explode(',', $data['p_image']);

	$discount=$data['coupon_discount'];
	$shipping=$data['shipping'];
}
//change status..
if (isset($_POST['status']) && isset($_POST['order_id'])) {
	$orderId = mysqli_real_escape_string($conn, $_POST['order_id']);
	$status = mysqli_real_escape_string($conn, $_POST['status']);
	$xyz = mysqli_query($conn, "UPDATE tbl_orders SET status = $status WHERE id=$orderId");
	if ($xyz == true) {
		$aj = mysqli_query($conn, "SELECT `status` FROM tbl_orders WHERE id=$orderId");
		$maj = mysqli_fetch_assoc($aj);
		$serv = $maj['status'];
		if ($serv == 0) {
			$service = 'Has been Cancelled';
		}
		if ($serv == 1) {
			$service = 'Was in Processing';
		}
		if ($serv == 2) {
			$service = 'Has Been Shipped';
		}
		if ($serv == 3) {
			$service = 'has been Delivered';
		}
		//===========//
		$receipient = $daA['email'];
		$orid = $data['orderid'];
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
					<tr style="background:#eee">
						<td align="left" style="text-align:left;padding:28px;font-family:sans-serif;line-height:24px">
							<h2 style="margin-bottom:0;color:#4a4a4a">Your Order ' . $service . '</h2>
							Thank you for Shopping with ' . SITE_NAME . ', We are glad you are here. Your Order number is ' . $orid . ' ' . $service . '.<br><br>
							<a href=""></a>
							<p>Have a Good day
							<br>Team ' . SITE_NAME . '</p>
						</td>
					</tr>
					<tr style="background:#464646;color:#ffffff">
						<td align="center" style="text-align:center;padding:12px;font-family:sans-serif;line-height:23px">
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
			<li class="breadcrumb-item"><a href="javascript:;">Order Detail</a></li>
			<li class="breadcrumb-item active">Manage Order Detail</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header">Manage Order Detail of <?= $daA['name']; ?></h1>
		<!-- end page-header -->

		<!-------------------Payment Area Status Here ---------------->

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
						<h4 class="panel-title">Order Detail of <?= $daA['name']; ?></h4>
					</div>
					<!-- begin panel-body -->
					<div class="panel-body">
						<div style="float: right;">

							<a target="_blank" href="generate-invoice.php?id=<?php echo $data['id']; ?>&print=true" class="btn btn-danger btn-icon btn-square" data-toggle="tooltip" data-original-title="Print" style="background: #ff0600;"><i class="fa fa-print"></i></a>
							<a href="javacript:void(0);" onclick="window.open('generate-invoice.php?id=<?php echo $data['id']; ?>','Windowname1','width=830,top=10,left=10,resizable,scrollbars,height=650'); return false;" class="btn btn-danger btn-icon btn-square" data-toggle="tooltip" data-original-title="View" style="background: #ff0600;"><i class="fa fa-eye"></i></a>
						</div>
						<br /><br />
						<div>
							<table class="table table-striped table-bordered">
								<tbody>
									<tr>
										<th>Invoice No : <b>#<?php echo $data['invoice']; ?></b></th>
										<th> ORDER ID : <b>#<?php echo $data['order_id']; ?></b></th>
										<th>Order Date-Time : <b><?php echo $data['date_time']; ?></b></th>

									</tr>

									<tr style=" font-size: 14px; color: black; ">
										<td colspan="2">
											<h5>User Details :- </h5>
											<?php
											echo '<b>Name : </b>' . $daA['name'] . ',</br> <b>Email : </b>' . $daA['email'] . ',</br> <b>Phone Number : </b>' . $daA['mobile'];
											?>
										</td>

										<td colspan="4">
											<h5>Shipping Details :-</h5>
											<?php
												$ano = mysqli_query($conn, "SELECT * FROM tbl_address WHERE userid='" . $data['user_id'] . "' && id='" . $data['address_id'] . "'");
												$another = mysqli_fetch_assoc($ano);

												$countryData=mysqli_query($conn,"SELECT * FROM `tbl_countries` where id='$another[country]'");
												$country=mysqli_fetch_assoc($countryData);

												$stateData=mysqli_query($conn,"SELECT * FROM `tbl_states` where id='$another[state]'");
												$state=mysqli_fetch_assoc($stateData);

												$cityData=mysqli_query($conn,"SELECT * FROM `tbl_cities` where id='$another[city]'");
												$city=mysqli_fetch_assoc($cityData);



												echo '<b>Name : </b>' . $another['name'] . ',</br> <b>Email : </b>' . $another['email'] . ',</br> <b>Phone Number : </b>' . $another['phone'] . '<br/> <b>Address : </b>' . $another['address'] . ',<br/> <b>City : </b>' . $city['name'] . ',&nbsp;&nbsp; <b>State : </b>' . $state['name'] . ',&nbsp;&nbsp;<br><b>Country : </b>' . $country['name'] . ',&nbsp;&nbsp;<b>Pincode : </b> ' . $another['zipcode'];
											?>
										</td>

									</tr>

									<tr>
										<th>Order Status</th>
										<td colspan="5">
											<div style="width:200px;">
												<p style="font-weight: 700; color: blue;">
													<?php if ($data['status'] == '0') { echo 'Cancelled'; } ?>
													<?php if ($data['status'] == '1') { echo 'Processing'; } ?>
													<?php if ($data['status'] == '2') { echo 'Shipped'; } ?>
													<?php if ($data['status'] == '3') { echo 'Delivered'; } ?>

													<select class="order-status form-control" data-order-id="<?php echo $data['id']; ?>">
														<option value="" selected="" disabled="">Change Status</option>
														<option value="0" <?php if ($data['status'] == 0) { echo ' selected'; } ?>>Cancelled</option>
														<option value="1" <?php if ($data['status'] == 1) { echo ' selected'; } ?>>Processing</option>
														<option value="2" <?php if ($data['status'] == 2) { echo ' selected'; } ?>>Shipped</option>
														<option value="3" <?php if ($data['status'] == 3) { echo ' selected'; } ?>>Delivered</option>
													</select>
												</p>
											</div>
										</td>
									</tr>
									<tr>
										<th>Payment Method</th>
										<td colspan="5">
											<div style="width:200px;">
												<p style="font-weight: 700; color: red;"><?php if ($data['method'] == 'Online') { echo 'Online Payment'; } else { echo 'Cash On Delivery'; } ?></p>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
							<hr />
							<table class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Sr. No.</th>
										<th>Product Image</th>
										<th>Product Name</th>
										<th>Code</th>
										<th>Price</th>
										<th>Tax</th>
										<th>Quantity</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$i = 0;
									$subTotal = 0;
									foreach ($prodIdArr as $idKey => $idVal) {
										$i++;
										$Total = $prodQuan[$idKey] * $proTotal[$idKey];
										$prodQ = mysqli_query($conn, "SELECT * FROM tbl_product WHERE id=$idVal");
										$prodData = mysqli_fetch_assoc($prodQ);
										$gst_amount = $proTotal[$idKey] - ($proTotal[$idKey] * (100 / (100 + $prodGst[$idKey])));
										$price = ($proTotal[$idKey]/$_SESSION['currency']['country_price_value']) - $gst_amount;	
									?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><img src="../uploads/product/<?= $prodIMG[$idKey]; ?>" style="height: 75px; width: 75px;"></td>
											<td><?php echo $proName[$idKey]; ?></td>
											<td><?php echo $prodData['skucode']; ?></td>
											<td><?= $data['currency_symbol']; ?> <?php echo $proTotal[$idKey]; ?> /-</td>
											<td><p><?= $data['currency_symbol']; ?> <?php echo round($gst_amount, 2); ?> <br> (<?php echo $prodData['gst']; ?> %)</p></td>
											<td><?php echo $prodQuan[$idKey]; ?></td>
											<?php $subTotal = $subTotal + $proTotal[$idKey] * $prodQuan[$idKey] + $prodQuan[$idKey] * $gst_amount; ?>
											<td><?= $data['currency_symbol']; ?> <b><?php echo round(($proTotal[$idKey] * $prodQuan[$idKey] + $prodQuan[$idKey] * $gst_amount),2); ?> /- </b></td>
										</tr>
									<?php
									}
									?>
								</tbody>
								<tfoot>
									<!-- <tr style="border-top:1px solid #ccc; font-weight: 900; font-size: 13x;">
										<th colspan="6" style="text-align:right;color: black;"><b>SubTotal : </b></th>
										<th colspan="3" style="color: red;"><?= $data['currency_symbol']; ?> <?php echo  round($subTotal,2); ?> /-
										</th>
									</tr> -->
									<tr style="border-top:1px solid #ccc; font-weight: 900; font-size: 13x;">
										<th colspan="6" style="text-align:right;color: black;"><b>Discount : </b></th>
										<th colspan="3" style="color: red;"><?= $data['currency_symbol']; ?> <?php echo  $discount; ?> /-
										</th>
									</tr>
									<tr style="border-top:1px solid #ccc; font-weight: 900; font-size: 13x;">
										<th colspan="6" style="text-align:right;color: black;"><b>Shipping Charges : </b></th>
										<th colspan="3" style="color: red;"><?= $data['currency_symbol']; ?> <?php echo  $shipping; ?> /-
										</th>
									</tr>
									<tr style="border-top:1px solid #ccc; font-weight: 900; font-size: 18px;">
										<th colspan="6" style="text-align:right;color: black;"><b>Grand Total : </b></th>
										<th colspan="3" style="color: red;"><?= $data['currency_symbol']; ?> <?php echo $data['totalamount']; ?> /-
										</th>
									</tr>
								</tfoot>
							</table>
						</div>

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
	<!------------------------------>
	<script type="text/javascript">
		$(document).ready(function() {
			$("body").on('change', '.order-status', function() {
				var status = $(this).val(),
					orderId = $(this).data('order-id');
				if (status != "" && status != null) {
					$.ajax({
						url: '',
						type: 'post',
						data: {
							status: status,
							order_id: orderId
						},
						success: function() {
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
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/bootstrap-select.min.js"></script>
	<script>
		$(document).ready(function() {
			$('select').selectpicker();
		});
	</script>
</body>

</html>