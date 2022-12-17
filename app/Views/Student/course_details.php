<section class="extra-head">
<!--    <img src="--><?php //echo base_url() ?><!--/assets/image/class-bn.svg" alt="banner" class="bn-cl">-->
    <img src="<?php echo base_url() ?>/assets/upload/course/big_<?php echo $course->image; ?>" alt="banner" class="bn-cl" >
</section>

<section class="content" style="margin-bottom: 90px;">
    <div class="row pt-2">
        <div class="col-12 mt-4">
            <?php $check = check_subscribe_by_course_id($course_id); if($check == 1){  ?>
            <center><a href="<?php echo base_url() ?>/Mobile_app/Course/category/<?php echo $course_id;?>" class="btn-down ">View</a></center>
            <?php }else{?>
            <center><a href="<?php echo base_url() ?>/Mobile_app/Course/subscribe/<?php echo $course_id;?>" class="btn-down ">Subscribe Now</a></center>
            <?php } ?>
        </div>
        <div class="col-12 cl-p-r" style="margin-top: 40px;">
            <h4>Description</h4>
            <?php echo $course->description;?>
        </div>
    </div>
</section>