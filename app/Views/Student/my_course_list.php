<section class="extra-head">
    <img src="<?php echo base_url()?>/assets/image/class-bn.svg" alt="banner" class="bn-cl" >
</section>

<section class="content" style="margin-bottom: 90px;">
    <div class="row pt-2">
        <?php $course_available = false;
        if (!empty($course)){ foreach ($course as $cor){  ?>
            <div class="col-12 cl-p-r" >
                <?php $checkSubscribe = check_subscribe_by_course_id($cor->course_id);
                if ($checkSubscribe == 1){
                    $course_available = true; ?>
                <a href="<?php echo base_url()?>/Mobile_app/Course/category/<?php echo $cor->course_id?>" class=" d-block btn-cl position-relative" ><?php echo $cor->course_name;?></a>
                <?php } ?>
            </div>
        <?php } }
        if ($course_available == false) { echo '<div class="col-12 math-p"><p class="noDataMsg">No data available</p> </div>';} ?>

    </div>
</section>