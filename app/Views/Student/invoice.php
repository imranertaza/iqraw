<section class="extra-head text-center" style="margin-top: 14px;">
    <img src="<?php echo base_url() ?>/assets/image/logo.svg" alt="banner" >
    <p class="top-tit">Thank You!</p>
</section>

<section class="content-2" style="margin-bottom: 90px;">
    <div class="row pt-2 ">
        <div class="col-12 top-div-in">
            <div class="row" style="padding: 10px 0px;">
                <div class="col-6 p-l-r">
                    <div class="back-color-inv " style="margin-right: 6px;">
                        <p class="inv-top-ti">Order Receipt</p>
                        <p class="inv-top-text d-flex justify-content-between"><span>Date</span> <span><?php echo date( 'd-m-Y', strtotime($order->createdDtm)); ?></span></p>
                        <p class="inv-top-text d-flex justify-content-between"><span>Order</span> <span><?php echo $order->order_id; ?></span></p>
                        <p class="inv-top-text d-flex justify-content-between"><span>Customer Number</span> <span><?php echo get_data_by_id('phone', 'student', 'std_id', $order->std_id);?></span></p>
                    </div>
                </div>
                <div class="col-6 p-l-r">
                    <div class="back-color-inv " style="margin-left: 6px;">
                        <p class="inv-top-ti">Billed To</p>
                        <p class="inv-top-text d-flex justify-content-between"><span>Method</span> <span>Coin</span></p>
                        <p class="inv-top-text d-flex justify-content-between"><span>Date</span> <span><?php echo date( 'd-m-Y', strtotime($order->createdDtm)); ?></span></p>
                        <p class="inv-top-text d-flex justify-content-between"><span>Number</span> <span>01928174380</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row pt-2 mt-2">
        <div class="col-12 p-l-r">
            <table class="table table-cus " style="border-radius:15px !important;">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($orderItem as $item){?>
                    <tr>
                        <td><?php echo get_data_by_id('name', 'products', 'prod_id',$item->prod_id);?></td>
                        <td><?php echo $item->price ?>৳</td>
                        <td><?php echo $item->quantity?></td>
                        <td><?php echo $item->total_price ?>৳</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="col-6"></div>
        <div class="col-6 d-flex justify-content-between">
            <span class="bu-ti-fot">Total</span>
            <span class="bu-cen-hr"></span>
            <span class="bu-ti-fot" style="margin-right: 15px;"><?php echo $order->final_amount;?>৳</span>
        </div>

    </div>
</section>

