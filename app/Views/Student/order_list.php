<section class="content-2" style="margin-bottom: 90px;">
    <div class="row pt-2 ">
        <?php foreach ($order as $view){ ?>
        <div class="col-12" style="margin-top: 29px;">
            <div class="row">
                <div class="col-4">
                    <p class="or-ti">Order: <?php echo $view->order_id;?></p>
                    <p class="or-ti"><?php echo date( 'd.m.Y', strtotime($view->createdDtm));?></p>
                </div>
                <div class="col-4">
                    <p class="or-ti">Total Price</p>
                    <p class="or-ti-sub"><?php echo $view->final_amount;?>৳</p>
                </div>
                <div class="col-4 text-center">
                    <p class="or-ti"><?php echo invoiceStatusView($view->status);?></p>
                    <a href="<?php echo base_url()?>/Mobile_app/Shopping/invoice/<?php echo $view->order_id;?>" class="btn view-btn-or">View</a>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
</section>