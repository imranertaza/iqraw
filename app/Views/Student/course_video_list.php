<section class="extra-head">
    <img src="<?php echo base_url()?>/assets/image/class-bn.svg" alt="banner" class="bn-cl" >
</section>

<section class="content" style="margin-bottom: 90px;">
    <div class="row pt-2">
        <?php if (!empty($video)){ foreach ($video as $val){
            $url = base_url().'/Student/Course/video_view/'.$val->course_video_id; ?>

            <div class="col-12">
                <div class="w-50 float-start p-2">
                    <img src="<?php echo base_url() ?>/assets/upload/courseVideo/<?php echo $val->thumb; ?>" alt="banner" class="skill-img w-100" >
                </div>
                <div class="w-50 float-start p-2 sch-nd text-capitalize">
                    <span class="sk-ti"><a href="<?php echo $url?>" ><?php echo $val->title; ?></a></span><br>
                    <span class="sk-n"><?php echo $val->author; ?></span><br>
                    <img src="<?php echo base_url() ?>/assets/image/star.svg" alt="banner" class="star" >
                </div>
            </div>


        <?php  } }else{ echo '<div class="col-6 math-p" style="padding-right: 4px !important;"><p>No data available</p> </div>';} ?>
    </div>
</section>