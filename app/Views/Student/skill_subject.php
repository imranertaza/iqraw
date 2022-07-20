<section class="extra-head">
    <img src="<?php echo base_url() ?>/assets/image/slill.svg" alt="banner" class="bn-cl">
</section>

<section class="content" style="margin-bottom: 90px;">
    <div class="row pt-2 text-capitalize">
        <?php if (!empty($subject)){ foreach ($subject as $val){  ?>
        <div class="col-6" style="padding-right: 4px !important;">
            <a href="<?php echo base_url()?>/Student/Skill_development/video_list/<?php echo $val->skill_subject_id?>" class="btn d-block btn-cl"><?php echo $val->name?></a>
        </div>
        <?php } }else{ echo '<div class="col-6 math-p" style="padding-right: 4px !important;"><p>No data available</p> </div>';} ?>

    </div>
</section>