<section class="extra-head">
    <img src="<?php echo base_url() ?>/assets/image/slill.svg" alt="banner" class="bn-cl">
</section>

<section class="content" style="margin-bottom: 90px;">
    <div class="row pt-2 text-capitalize">
        <div class="col-12 mt-3 mb-3">
            <button class="btn btn-video-count"><?php echo count($video)?> Video</button>
        </div>
        <?php if (!empty($video)){ foreach ($video as $val){  ?>
            <div class="col-12">
                <div class="w-50 float-start p-2">
                    <img src="<?php echo base_url() ?>/assets/upload/skillVideo/<?php echo $val->thumb; ?>" alt="banner" class="skill-img w-100" >
                </div>
                <div class="w-50 float-start p-2 sch-nd">
                    <span class="sk-ti"><a href="<?php echo base_url()?>/Student/Skill_development/video/<?php echo $val->skill_video_id; ?>"><?php echo $val->title; ?></a></span><br>
                    <span class="sk-n"><?php echo $val->author; ?></span><br>
<!--                    <span class="sk-n">40+ videos</span><br>-->
                    <img src="<?php echo base_url() ?>/assets/image/star.svg" alt="banner" class="star" >
                </div>
            </div>
        <?php } }else{ echo '<div class="col-6 math-p" style="padding-right: 4px !important;"><p>No data available</p> </div>';} ?>

    </div>
</section>