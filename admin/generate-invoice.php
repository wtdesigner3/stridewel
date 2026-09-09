<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
?>
<script type="text/javascript">
    <?php 
        if (@$_GET['print'] == true) 
        {   ?>
                window.print();
            <?php 
        } 
    ?>
</script>
<html xmlns="http://www.w3.org/1999/xhtml" class="gr__flyingcakes_in">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <?php
    
        include('../inc/function.php');
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
            $protax = explode(',', $data['p_gst']);
            $prodIdArr = explode(',', $data['p_id']);
            $prodQuan = explode(',', $data['p_quantity']);
            $prodWeight = explode(',', $data['p_weight']);
            $prodFor_whom = explode('|', $data['p_for_whom']);
            $prodIMG = explode(',', $data['p_image']);
        }
    ?>

<body data-gr-c-s-loaded="true">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo $data['order_id']; ?></title>
    <style>
        body {
            /*font-family: calibri !important;*/
            font-size: 14px;
        }

        .brder6 {
            border-bottom: 1px solid #666;
        }

        .brder7 {
            border-right: 1px solid #666;
        }

        .brder8 {
            border-right: 1px solid #666;
            border-left: 1px solid #666;
        }

        .brder5 {
            border-left: 1px solid #666;
            border-bottom: 1px solid #666;
        }

        .brder1 {
            border-top: 1px solid #666;
            border-left: 1px solid #666;
        }

        .brder4 {
            border-top: 1px solid #666;
            border-right: 1px solid #666;
        }

        .brder {
            border-top: 1px solid #666;
            border-left: 1px solid #666;
            border-right: 1px solid #666;
        }

        .brder-2 {
            border-top: 1px solid #666;
            border-right: 1px solid #666;
        }

        .brder-3 {
            border-top: 1px solid #666;
        }

        .width1 {
            width: 80%;
            float: left;
        }

        .width2 {
            width: 20%;
            float: left;
        }

        .clr {
            clear: both;
        }

        td {
            padding: 5px;
            vertical-align: top;
        }

        p {
            margin: 5px 0;
            padding: 0px;
        }

        .taxes {
            margin-top: 7px;
            margin-bottom: 11px;
        }

        .main-div {
            width: 1000px;
            margin: 0 auto;
        }
    </style>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:200,300,400,500,600,700,800&amp;subset=all" rel="stylesheet" type="text/css">

    <div class="main-div" align="center">
        <table border="0" width="800">
            <tbody>
                <tr>
                    <td style="text-align: end;"> </td>
                    <td width="131">
                        <div class="uppr-div">
                            <img src="<?= SITE_URL; ?>uploads/logo_dark.jpeg" class="img-responsive" width="100%">
                        </div>
                    </td>
                    <td style="text-align: end;"> </td>
                </tr>
            </tbody>
        </table>
        <table cellpadding="5" cellspacing="0" width="900" border="1">
            <tbody>
                <tr>
                    <td valign="top" width="30%" class="brder" rowspan="2">
                        <span>Sender Detail</span>
                        <p><b><?=SITE_NAME?></b></p>
                        <p style="font-size:14px;">
                            <?=$contact['con_address']?>
                        </p>
                        <p>Ph No: <?=$contact['con_phone1']?></p>
                        <p>Email : <?=$contact['con_email1']?></p>
                    </td>
                    <td valign="top" width="30%" class="brder-2">
                        <span>GSTIN/UIN : </span>
                        <p><b>07XXTFC3481C1ZE</b></p>
                    </td>
                    <td valign="top" width="30%" class="brder-2" rowspan="2">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td valign="top"><span>Date Of Order</span>
                                        <p><b><?php echo date("d-F-Y h:i A", strtotime($data['date_time'])); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" class="brder-3">
                                        <span>Invoice No </span>
                                        <p><b><?php echo $data['invoice']; ?></b></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top" width="30%" class="brder-2">
                        <span>Order No.</span>
                        <p><b>#<?php echo $data['order_id']; ?></b></p>
                    </td>
                </tr>
                <tr>
                    <td valign="top" width="30%" class="brder" rowspan="4">
                        <span>Billing Address</span>
                        <p><b><?= $daA['name']; ?> </b></p>
                        <p style="font-size:14px;"><?= $daA['address']; ?>, <?= $daA['city']; ?>, <?= $daA['state']; ?>,<?= $daA['pincode']; ?></p>
                        Ph No: <?= $daA['phone']; ?></p>
                        <p>Email : <?= $daA['email']; ?></p>
                    </td>
                    <?php if($data['ship_username']){
                        $delstate = $data['ship_state'];
                    ?>
                    <td valign="top" width="30%" class="brder" rowspan="4">
                        <span>Delivery Address</span>
                        <p><b><?php echo $data['ship_username']; ?> </b></p>
                        <p style="font-size:14px;"><?php echo $data['ship_address']; ?>, <?php echo $data['ship_city']; ?>, <?php echo $data['ship_state']; ?>,<?php echo $data['ship_pincode']; ?></p>
                        <p>Phone :- <?php echo $data['ship_phone']; ?></p>
                        <p>Email : <?php echo $data['ship_email']; ?></p>
                    </td>
                    <?php }else{
                        $delstate = $daA['state'];
                    ?>
                    <td valign="top" width="30%" class="brder" rowspan="4">
                        <span>Delivery Address</span>
                        <p><b><?= $daA['name']; ?> </b></p>
                        <p style="font-size:14px;"><?= $daA['address']; ?>, <?= $daA['city']; ?>, <?= $daA['state']; ?>,<?= $daA['pincode']; ?></p>
                        <p>Phone :- <?= $daA['phone']; ?></p>
                        <p>Email : <?= $daA['email']; ?></p>
                    </td>
                    <?php } ?>
                    <td valign="top" width="30%" class="brder-2">
                        <span>Payment Mode:-</span>
                        <p><b><?php if ($data['method'] == 1) { echo 'Online Payment'; } else { echo 'Cash On Delivery'; } ?></b></p>
                    </td>
                </tr>
                <tr>
                </tr>
                <tr>
                </tr>
                <tr>
                    <td valign="top" width="30%" class="brder-2">
                        <span>Portal</span>
                        <p><?= SITE_URL; ?></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="padding:0px;">
                        <table cellpadding="5" cellspacing="0" width="100%" border="1" rules="COLS" frame="VSIDES">
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

                                            $proTotalValue = (float)$proTotal[$idKey];
                                            $gstRate = (float)$prodData['gst'];
                                            
                                            $gst_amount = $proTotalValue - ($proTotalValue * ($gstRate / 100));

                                            $gst_amounts = $gst_amount * $prodQuan[$idKey];
                                            $percentcgst = number_format($gst_amounts/2, 2);
                                            $percentsgst =  number_format($gst_amounts/2, 2);
                                            
                                            // $Total = (($proTotal[$idKey]-$gst_amount)*$prodQuan[$idKey])+($proTotal[$idKey]);
                                            $subTotal += $total;
                                            ?>
                                                <tr>
                                                    <td width="6%" height="45" class="brder brder6" bgcolor="#EDEDEB"><?php echo $i; ?></td>
                                                    <td class="brder-2 brder6" width="9%" align="center" bgcolor="#EDEDEB">
                                                        <a href="<?=SITE_URL?>uploads/product/<?= $prodIMG[$idKey]; ?>">
                                                        <img src="../uploads/service/<?= $prodIMG[$idKey]; ?>" style="height: 75px; width: 75px;">
                                                        </a>
                                                    </td>
                                                    <td class="brder-2 brder6" width="15%" align="center" bgcolor="#EDEDEB"><?php echo $proName[$idKey]; ?></td>
                                                    <!--<td class="brder-2 brder6" width="9%" align="center" bgcolor="#EDEDEB"><?php echo $procode[$idKey]; ?></td>-->
                                                    <td class="brder-2 brder6" width="9%" align="center" bgcolor="#EDEDEB"><?php echo $prodFor_whom[$idKey]; ?></td> 
                                                    <td class="brder-2 brder6" width="9%" align="center" bgcolor="#EDEDEB"><?php echo $prodWeight[$idKey]; ?></td> 
                                                    <td class="brder-2 brder6" width="9%" align="center" bgcolor="#EDEDEB">₹ <?php echo $proTotal[$idKey]; ?></td> 
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
                                    // $gst = $grandTotal;
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
                    </td>
                </tr>
                <tr>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>