<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require('checksession.php');
include '../inc/function.php';

if (isset($_GET['id'])) 
{
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $dataQ = mysqli_query($conn, "SELECT * FROM tbl_orders WHERE id='$id'");
    $data = mysqli_fetch_assoc($dataQ);
    //====User====//
    $dasA = mysqli_query($conn, "SELECT * FROM tbl_users WHERE id='" . $data['user_id'] . "'");
    $daA = mysqli_fetch_assoc($dasA);

    $proTotal = explode(',', $data['p_price']);
    $proName = explode(',', $data['p_name']);
    $procode = explode(',', $data['p_code']);
    $protax = explode(',', $data['p_gst']);
    $prodIdArr = explode(',', $data['p_id']);
    $prodQuan = explode(',', $data['p_quantity']);
    $prodWeight = explode(',', $data['p_weight']);
    $prodFor_whom = explode('|', $data['p_for_whom']);
    $prodIMG = explode(',', $data['p_image']);
    
}

//change status..
if (isset($_POST['status']) && isset($_POST['order_id'])) {
	$orderId = mysqli_real_escape_string($conn, $_POST['order_id']);
	$status = mysqli_real_escape_string($conn, $_POST['status']);
	$xyz = mysqli_query($conn, "UPDATE tbl_orders SET `status` = '$status' WHERE `id`='$orderId'");
	if ($xyz == true) {
		$aj = mysqli_query($conn, "SELECT * FROM `tbl_orders` WHERE `id`='$orderId'");
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
                                        <th>Order Date-Time : <b><?php echo date("d-F-Y h:i A", strtotime($data['date_time'])); ?></b></th>

                                    </tr>

                                    <tr style=" font-size: 14px; color: black; ">
                                        <td colspan="2">
                                            <h5>User Details :- </h5>
                                            <?php
                                            echo '<b>Name : </b>' . $daA['name'] . ',</br> <b>Email : </b>' . $daA['email'] . ',</br> <b>Phone Number : </b>' . $daA['phone'] . '<br/> <b>Address : </b>' . $daA['address'] . ',
											<br/> <b>City : </b>' . $daA['city'] . ',
											<br/> <b>State : </b>' . $daA['state'] . ',
											</br><b>Pincode : </b> ' . $daA['pincode'];
                                            ?>
                                        </td>

                                        <td colspan="4">
                                            <h5>Shipping Details :-</h5>
                                            <?php
                                                if($data['address_id'] == '0' || $data['address_id'] == 0){
                                                    
                                                    $delstate = $daA['state'];
                                                    
                                                    echo '<b>Name : </b>' . $daA['name'] . ',</br> <b>Email : </b>' . $daA['email'] . ',</br> <b>Phone Number : </b>' . $daA['phone'] . '<br/> <b>Address : </b>' . $daA['address'] . ',
											            <br/> <b>City : </b>' . $daA['city'] . ',
											            <br/> <b>State : </b>' . $daA['state'] . ',
											            </br><b>Pincode : </b> ' . $daA['pincode'];
                                                }else{
                                                    $delstate = $data['ship_state'];
                                            ?>
                                                <b>Name : </b><?php echo $data['ship_username']; ?>,</br> 
                                                <b>Email : </b><?php echo $data['ship_email']; ?>,</br> 
                                                <b>Phone Number : </b><?php echo $data['ship_phone']; ?>,<br/> 
                                                <b>Address : </b><?php echo $data['ship_address']; ?>,<br/> 
                                                <b>City : </b><?php echo $data['ship_city']; ?>,<br/> 
                                                <b>State : </b><?php echo $data['ship_state']; ?>,</br>
                                                <b>Pincode : </b> <?php echo $data['ship_pincode']; ?>
                                            <?php } ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Order Status</th>
                                        <td colspan="5">
                                            <div style="width:200px;">
                                                <p style="font-weight: 700; color: blue;">
                                                    <?php if ($data['status'] == 'cancelled') { echo 'Cancelled'; } ?>
                                                    <?php if ($data['status'] == 'processing') { echo 'Processing'; } ?>
                                                    <?php if ($data['status'] == 'dispatch') { echo 'Dispatched'; } ?>
                                                    <?php if ($data['status'] == 'delivered') { echo 'Delivered'; } ?>

                                                    <select class="order-status form-control" data-order-id="<?php echo $data['id']; ?>">
                                                        <option value="" selected="" disabled="">Change Status</option>
                                                        <option value="cancelled" <?php if ($data['status'] == "cancelled") { echo ' selected'; } ?>>Cancelled</option>
                                                        <option value="processing" <?php if ($data['status'] == "processing") { echo ' selected'; } ?>>Processing</option>
                                                        <option value="dispatch" <?php if ($data['status'] == "dispatch") { echo ' selected'; } ?>>Dispatched</option>
                                                        <option value="delivered" <?php if ($data['status'] == "delivered") { echo ' selected'; } ?>>Delivered</option>
                                                    </select>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Payment Method</th>
                                        <td colspan="5">
                                            <div style="width:200px;">
                                                <p style="font-weight: 700; color: red;"><?php if ($data['method'] =='Online') { echo 'Online Payment'; } else { echo 'Cash On Delivery'; } ?></p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr />
                            <table class="table table-striped table-bordered">
                          <tbody>

                            <tr>
                                <th>Sr. No.</th>
                                <th>Product Image</th>
                                <th>Product <br> Name</th>
                                <th>Product For Whom</th>
                                <th>Product Weight</th>
                                <!--<th>SKU Code</th>-->
                                <th>Price</th>
                                <th>Qty</th>
                                <!--<th>GST</th>-->
                                <!--<th>Total GST</th>-->
                                <th>Total</th>
                            </tr>
                                <?php
                                $i = 0;
                                $subTotal = 0;
                                foreach ($prodIdArr as $idKey => $idVal) 
                                        {
                                            $i++;
                                            $total = $prodQuan[$idKey]*$proTotal[$idKey];
									        
                                            $prodQ = mysqli_query($conn, "SELECT * FROM `tbl_service` WHERE `id`='$idVal'");
                                            $prodData = mysqli_fetch_assoc($prodQ);

                                            $gst_amount = (float)$proTotal[$idKey] - ((float)$proTotal[$idKey] * (((float)$prodData['gst']) / 100));
                                            $gst_amounts = $gst_amount * $prodQuan[$idKey];
                                            $percentcgst = number_format($gst_amounts/2, 2);
                                            $percentsgst =  number_format($gst_amounts/2, 2);
                                            
                                            // $Total = (($proTotal[$idKey]-$gst_amount)*$prodQuan[$idKey])+($proTotal[$idKey]);
                                            $subTotal += $total;
                                            ?>
                                                <tr>
                                                    <td width="6%" height="45" class="brder brder6" bgcolor="#EDEDEB"><?php echo $i; ?></td>
                                                    <td class="brder-2 brder6" width="9%" align="center" bgcolor="#EDEDEB">
                                                        <a href="<?=SITE_URL?>uploads/service/<?= $prodIMG[$idKey]; ?>">
                                                        <img src="../uploads/service/<?= $prodIMG[$idKey]; ?>" style="height: 75px; width: 75px;">
                                                        </a>
                                                    </td>
                                                    <td class="brder-2 brder6" width="15%" align="center" bgcolor="#EDEDEB"><?php echo $proName[$idKey]; ?></td>
                                                    <!--<td class="brder-2 brder6" width="9%" align="center" bgcolor="#EDEDEB"><?php echo $procode[$idKey]; ?></td>-->
                                                    <td class="brder-2 brder6" width="9%" align="center" bgcolor="#EDEDEB"><?php echo $prodFor_whom[$idKey]; ?></td> 
                                                    <td class="brder-2 brder6" width="9%" align="center" bgcolor="#EDEDEB"><?php echo $prodWeight[$idKey]; ?></td> 
                                                    <td class="brder-2 brder6" width="9%" align="center" bgcolor="#EDEDEB"><?php echo $proTotal[$idKey]; ?></td> 
                                                    <td class="brder-2 brder6" width="9%" align="center" bgcolor="#EDEDEB"><?php echo $prodQuan[$idKey]; ?></td> 
                                <!--<td class="brder-2 brder6" width="9%" align="center" bgcolor="#EDEDEB">₹ <?php echo round($proTotal[$idKey]-$gst_amount,2); ?> /- <br>(<?=$prodData['gst']?>%)</td>-->
                                <!--                    <td class="brder-2 brder6" width="9%" align="center" bgcolor="#EDEDEB">₹ <?php echo round(($proTotal[$idKey]-$gst_amount)*$prodQuan[$idKey],2); ?> /-</td>-->
									           <td class="brder-2 brder6" width="9%" align="center" bgcolor="#EDEDEB"><b>₹ <?php echo round($total,2); ?> /-</b></td>
                                                </tr>
                                            <?php 
                                        }
                                        ?>

                                <tr style="border-top:1px solid #ccc; font-weight: 900; font-size: 13x;">
                                        <th colspan="7" style="text-align:right;color: black;"><b>SubTotal : </b></th>
                                        <th colspan="3" style="color: red;">₹ <?php echo number_format($subTotal,2); ?> /-
                                        </th>
                                    </tr>
                                    <tr style="border-top:1px solid #ccc; font-weight: 900; font-size: 13x;">
                                        <th colspan="7" style="text-align:right;color: black;"><b>Discount : </b></th>
                                        <th colspan="3" style="color: red;">₹ <?php echo $data['coupon_discount']; ?> /-
                                        </th>
                                    </tr>
                                    <tr style="border-top:1px solid #ccc; font-weight: 900; font-size: 13x;">
                                        <th colspan="7" style="text-align:right;color: black;"><b>Shipping : </b></th>
                                        <th colspan="3" style="color: red;">₹ <?php echo $data['shipping']; ?> /-
                                        </th>
                                    </tr>
                                    <?php 
                                     $grandTotal = ($subTotal - $data['coupon_discount']) + $data['shipping']; 
                                    // $gst = $grandTotal * 0.03;
                                    // $grandTotal += $gst;
                                    ?>

                                    <tr style="border-top:1px solid #ccc; font-weight: 900; font-size: 13x;">
                                        <th colspan="7" style="text-align:right;color: black;"><b>GST(5%) : </b></th>
                                        <th colspan="3" style="color: red;">₹ <?php echo $data['p_gst']; ?> /-
                                        </th>
                                    </tr>
                                    
                                    <tr style="border-top:1px solid #ccc; font-weight: 900; font-size: 18px;">
                                        <th colspan="7" style="text-align:right;color: black;"><b>Grand Total : </b></th>
                                        <th colspan="3" style="color: red;">₹ <?php echo $data['totalamount']; ?> /-
                                        </th>
                                    </tr>
                            </tbody>
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
                        url: 'ajax/order_status_update.php',
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