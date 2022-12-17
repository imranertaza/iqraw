<section class="content-three con-mr">
    <div class="container">
        <div class="row ">
            <div class="col-12 text-center" style="margin-bottom: 85px;">
                <?php $img = (!empty($course->image))?'big_'.$course->image:'noImage.svg'; ?>
                <img src="<?php echo base_url()?>/assets/upload/course/<?php echo $img;?>" alt="" width="100%">
            </div>

            <div class="col-12" style="margin-bottom: 62px;">
                <?php $isLoggedInWeb = newSession()->isLoggedInWeb; if (!isset($isLoggedInWeb) || $isLoggedInWeb != TRUE) { ?>
                <a href="<?php echo base_url()?>/Web/Home/payment/<?php echo $course->course_id;?>" class="btn btn-d-c">Enroll Now</a>
                <?php }else{ $check = check_subscribe_by_course_id($course->course_id); if ($check == 1){ ?>
                <a href="<?php echo base_url()?>/Web/Dashboard/course/<?php echo $course->course_id;?>" class="btn btn-d-c">Enroll Now</a>
                <?php }else{?>
                <a href="<?php echo base_url()?>/Web/Home/payment/<?php echo $course->course_id;?>" class="btn btn-d-c">Enroll Now</a>
                <?php } } ?>
            </div>

            <div class="col-12 cor-d-t">
                <?php echo $course->description;?>
            </div>

            <div class="col-12 text-center" style="margin-top: 70px;">
                <?php $isLoggedInWeb = newSession()->isLoggedInWeb; if (!isset($isLoggedInWeb) || $isLoggedInWeb != TRUE) { ?>
                    <a href="<?php echo base_url()?>/Web/Home/payment/<?php echo $course->course_id;?>" class="btn btn-d-c">Enroll Now</a>
                <?php }else{ $check = check_subscribe_by_course_id($course->course_id); if ($check == 1){ ?>
                    <a href="<?php echo base_url()?>/Web/Dashboard/course/<?php echo $course->course_id;?>" class="btn btn-d-c">Enroll Now</a>
                <?php }else{?>
                    <a href="<?php echo base_url()?>/Web/Home/payment/<?php echo $course->course_id;?>" class="btn btn-d-c">Enroll Now</a>
                <?php } } ?>
            </div>
        </div>
    </div>
</section>