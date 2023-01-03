

    <section class="extra-head">
        <img src="<?php echo base_url()?>/assets/image/class-bn.svg" alt="banner" class="bn-cl" >
    </section>

    <section class="content" style="margin-bottom: 90px;">
        <div class="row pt-2">
            <?php if(!empty($subject)){ foreach ($subject as $sub){ ?>
            <div class="col-6 cl-p-r" >
                <a href="<?php echo base_url()?>/Mobile_app/Subject/chapter/<?php echo $sub->subject_id?>" class="btn d-block btn-cl"><?php echo $sub->name;?></a>
            </div>
            <?php } }else{echo '<div class="col-12 math-p"><p class="noDataMsg">No data available</p> </div>';} ?>
        </div>
    </section>