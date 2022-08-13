
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Invoice
                        <!--                        <small>#007612</small>-->
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Invoice</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content" id="printDiv">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8 mt-2">
                                <h2 class="card-title">

                                    iQraw
                                </h2>
                            </div>
                            <div class="col-md-4">
                                <small style="float: right;">Date: <?php echo date( 'd-m-Y', strtotime($order->createdDtm)); ?></small>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="font-size: 14px;">
                        <div class="row invoice-info" >
                            <div class="col-sm-4 invoice-col">
                                From
                                <address>
                                    <strong>iQraw</strong><br>
                                    Phone: 01923121212<br>
                                    Email: imranertaza12@gmail.com
                                </address>
                            </div>
                            <!-- /.col -->

                            <div class="col-sm-4 invoice-col">
                                To
                                <address>
                                    <strong><?php echo get_data_by_id('name', 'student', 'std_id', $order->std_id);?></strong><br>
                                    Phone: <?php echo get_data_by_id('phone', 'student', 'std_id', $order->std_id);?><br>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col" style="text-transform: capitalize;">
                                <b>Order ID:</b> <?php echo $order->order_id; ?><br>
                                <b>Status:</b> <?php //echo invoiceStatusView($order->status); ?>
                                <select name="status" onchange="orderStatusUpdate(this.value,'<?php echo $order->order_id?>')"  style="text-transform: capitalize;border: 1px solid #e1dfdf;">
                                    <?php echo orderStatusInOption($order->status);?>
                                </select>
                                <br>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 table-responsive" style="text-transform: capitalize;">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Qty</th>
                                        <th>Product</th>
                                        <th>Subtotal</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($orderItem as $item){?>
                                        <tr>
                                            <td><?php echo $item->quantity; ?></td>
                                            <td><?php echo get_data_by_id('name', 'products', 'prod_id',$item->prod_id); ?></td>
                                            <td><?php echo $item->final_price; ?></td>
                                        </tr>
                                    <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>

                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-6">
                                <p class="lead">Payment Methods:</p>
                                <img src="<?php echo base_url()?>/backhand/assets/dist/img/credit/visa.png" alt="Visa">
                                <img src="<?php echo base_url()?>/backhand/assets/dist/img/credit/mastercard.png" alt="Mastercard">
                                <img src="<?php echo base_url()?>/backhand/assets/dist/img/credit/american-express.png" alt="American Express">
                                <img src="<?php echo base_url()?>/backhand/assets/dist/img/credit/paypal2.png" alt="Paypal">

                                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg
                                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                                </p>
                            </div>
                            <!-- /.col -->
                            <div class="col-6">
                                <p class="lead">Amount Due <?php echo date( 'd/m/Y', strtotime($order->createdDtm)); ?></p>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody><tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td><?php echo $order->amount?></td>
                                        </tr>
                                        <tr>
                                            <th>Shipping:</th>
                                            <td><?php echo $order->delivery_charge?></td>
                                        </tr>
                                        <tr>
                                            <th>Total:</th>
                                            <td><?php echo $order->final_amount?></td>
                                        </tr>
                                        </tbody></table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-12">
                                <a href="#"  class="btn btn-default" onclick="printDiv();"><i class="fa fa-print"></i> Print</a>
                                <!--                                <button type="button" class="btn btn-success " style="float: right;"><i class="fa fa-credit-card"></i> Submit Payment-->
                                <!--                                </button>-->
                                <!--                                <button type="button" class="btn btn-primary " style="margin-right: 5px;float: right;">-->
                                <!--                                    <i class="fa fa-download"></i> Generate PDF-->
                                <!--                                </button>-->
                            </div>
                        </div>

                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
    </section>



</div>
<!-- /.content-wrapper -->

<script>
    function printDiv(){
        window.print();
    }

    function orderStatusUpdate(status,orderId){
        $.ajax({
            url: "<?= base_url('Admin/Order/orderStatusUpdate') ?>",
            type: "POST",
            cache: false,
            data: {status:status, orderId:orderId },
            dataType: "JSON",
            success: function(response) {

                if (response.success === true) {
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: response.messages,
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'error',
                        title: response.messages,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            }
        });
    }
</script>