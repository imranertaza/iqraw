
<section class="content-2" style="margin-bottom: 90px;margin-top: 30px;">
    <div class="row" id="reloadtable">
    <?php $i =1;$j=1; foreach (Cart()->contents() as $val){ $img = get_data_by_id('picture','products','prod_id',$val['id']); $qty = get_data_by_id('quantity','products','prod_id',$val['id']); ?>
        <div class="col-12 mt-2">
            <div class="w-50 float-start">
                <img src="<?php echo no_image_view('/assets/upload/product/'.$val['id'].'/'.$img,'/assets/upload/product/no_img.svg',$img) ?>" alt="img" class="cart-img">
            </div>
            <div class="w-50 float-start">
                <p class="cart-t"><?php echo $val['name'];?></p>

                <div class="w-50 float-start">
                    <p class="cart-pri"><?php echo $val['price'];?>৳</p>
                </div>

                <div class="qty w-50 float-start text-center">
                    <span class="minus" onclick="updateMinus('<?php echo $val['rowid'];?>')">-</span>
                    <input type="number" class="count" name="qty" value="<?php echo $val['qty'];?>">
                    <span class="plus" onclick="updatePlus('<?php echo $val['rowid'];?>')" >+</span>
                </div>
            </div>
        </div>
    <?php } ?>

        <div class="col-12 mt-4">
            <div class="w-50 float-start">
                <p class="c-t-v">Total</p>
            </div>
            <div class="w-50 float-start" style="text-align: right;">
                <p class="c-t-v" ><?php print Cart()->total();?>৳</p>
            </div>
            <?php if (!empty(Cart()->contents())){ ?>
            <a href="<?php echo base_url('/Mobile_app/Shopping/checkout')?>" class="btn a-btn text-white mt-3">Checkout</a>
            <?php }else{ ?>
                <a href="#" class="btn a-btn2 text-white mt-3">Checkout</a>
            <?php } ?>
        </div>
    </div>
</section>