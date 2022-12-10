    <section class="extra-head">
        <img src="<?php echo base_url()?>/assets/image/class-bn.svg" alt="banner" class="bn-cl" >
    </section>

    <section class="content" style="margin-bottom: 90px;">
    <div class="row pt-2 text-capitalize">
        <?php if (!empty($chapter)){ foreach ($chapter as $chap){ ?>
        <div class="col-6 math-p" style="padding-right: 4px !important;">
            <a href="<?php echo base_url()?>/Mobile_app/VideoQuiz/index/<?php echo $chap->chapter_id?>" class="btn d-block btn-cl"><?php echo $chap->name?></a>
        </div>
        <?php } }else{ echo '<div class="col-6 math-p" style="padding-right: 4px !important;"><p>No data available</p> </div>';} ?>

    </div>
</section>