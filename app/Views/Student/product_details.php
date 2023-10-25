
<section class="content-2" style="margin-bottom: 90px;margin-top: 30px;">
    <img src="<?php echo no_image_view('/assets/upload/product/'.$product->prod_id.'/'.$product->picture,'/assets/upload/product/no_img.svg',$product->picture) ?>" alt="pro-img" class="pro-big-img">
    <div class="row">
        <div class="col-12">
            <p class="pro-p">৳<?php echo $product->price;?> </p>
            <p class="pro-d-te"><?php echo $product->name;?> </p>
            <p class="pro-d-te"><strong>Details</strong> <br><?php echo $product->description;?> </p>
            <button type="submit" class="btn a-btn text-white mt-3" onclick="addToCart('<?php echo $product->prod_id;?>')"  ><i class="fa-solid fa-cart-plus"></i> Add to cart</button>

        </div>
    </div>
</section>