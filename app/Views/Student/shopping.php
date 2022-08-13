<section class="content-2" style="margin-bottom: 90px; margin-top: 30px;">
    <div class="row">
        <div class="col-3 mt-2">
            <a href="<?php echo get_category_link_by_name('Man', $category_url) ?>">
                <div class="s-box" style="background: #FFBC99;">
                    <img src="<?php echo base_url() ?>/assets/image/man.svg">
                </div>
                <center><span class="img-ti">Man</span></center>
            </a>
        </div>
        <div class="col-3 mt-2">
            <a href="<?php echo get_category_link_by_name('Women', $category_url) ?>">
                <div class="s-box" style="background: #CABDFF; padding: 14px 20px;">
                    <img src="<?php echo base_url() ?>/assets/image/women.svg">
                </div>
                <center><span class="img-ti">Women</span></center>
            </a>
        </div>
        <div class="col-3 mt-2">
            <a href="<?php echo get_category_link_by_name('Bag', $category_url) ?>">
                <div class="s-box" style="background: #B1E5FC;padding: 14px 14px;">
                    <img src="<?php echo base_url() ?>/assets/image/backpack.svg">
                </div>
                <center><span class="img-ti">Bag</span></center>
            </a>
        </div>
        <div class="col-3 mt-2">
            <a href="<?php echo get_category_link_by_name('Books', $category_url) ?>">
                <div class="s-box" style="background: #B5EBCD;padding: 14px 18px;">
                    <img src="<?php echo base_url() ?>/assets/image/books.svg">
                </div>
                <center><span class="img-ti">Books</span></center>
            </a>
        </div>

        <div class="col-3 mt-2">
            <a href="<?php echo get_category_link_by_name('Accessories', $category_url) ?>">
                <div class="s-box" style="background: #FFD88D;padding: 14px 18px;">
                    <img src="<?php echo base_url() ?>/assets/image/pen.svg">
                </div>
                <center><span class="img-ti">Accessories</span></center>
            </a>
        </div>
        <div class="col-3 mt-2">
            <a href="<?php echo get_category_link_by_name('Mobile', $category_url) ?>">
                <div class="s-box" style="background: #F9B0ED;padding: 17px 21px;">
                    <img src="<?php echo base_url() ?>/assets/image/mobile.svg">
                </div>
                <center><span class="img-ti">Mobile</span></center>
            </a>
        </div>
        <div class="col-3 mt-2">
            <a href="<?php echo get_category_link_by_name('Baby', $category_url) ?>">
                <div class="s-box" style="background: #FFD88D;padding: 15px 16px;">
                    <img src="<?php echo base_url() ?>/assets/image/baby.svg">
                </div>
                <center><span class="img-ti">Baby</span></center>
            </a>
        </div>
        <div class="col-3 mt-2">
            <a href="<?php echo get_category_link_by_name('Health', $category_url) ?>">
                <div class="s-box" style="background: #CBEBA4;padding: 17px 19px;">
                    <img src="<?php echo base_url() ?>/assets/image/healthy.svg">
                </div>
                <center><span class="img-ti">Health</span></center>
            </a>
        </div>

        <div class="col-12 mt-4">
            <p class="sop-ti " id="title_cat">All</p>
        </div>
        <div class="row" id="resultProduct" >
            <?php if (!empty($product)){ foreach ($product as $pro) { ?>
                <div class="col-6">
                    <a href="<?php echo base_url('/Student/Shopping/details/' . $pro->prod_id) ?>">
                        <img src="<?php echo no_image_view('/assets/upload/product/' . $pro->prod_id . '/' . $pro->picture, '/assets/upload/product/no_img.svg', $pro->picture) ?>"
                             alt="pro-img" class="pro-img">
                        <img src="<?php echo base_url() ?>/assets/image/cart-plus.svg" alt="icon" class="icon">
                        <p class="pro-p"><?php echo $pro->price; ?>৳ </p>
                        <p class="pro-p-t"><?php echo $pro->name; ?></p>
                    </a>
                </div>
            <?php } }else{ echo '<p class="pro-p">No data available</p>';}  ?>
        </div>

    </div>
</section>