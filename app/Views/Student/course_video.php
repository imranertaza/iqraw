<section class="extra-head" style="position: relative;">
    <a href="javascript:void(0)" onclick="video_open_course('<?php echo $video->course_video_id?>')" ><img src="<?php echo base_url() ?>/assets/ion_logo-youtube.svg" alt="play_btn" class="play_btn"  ></a>
    <a href="javascript:void(0)" onclick="video_open_course('<?php echo $video->course_video_id?>')" > <img src="<?php echo base_url() ?>/assets/upload/courseVideo/<?php echo $video->thumb; ?>" alt="banner" class="bn-cl" width="100%" ></a>



</section>

<section class="content" style="margin-bottom: 90px;">
    <div class="row pt-2 text-capitalize">
        <div class="col-12 text-center mt-2" >
            <?php if(!empty($video->hand_note)){ ?>
                <span class="fc-ti-1">Hand Note <i class="fa-solid fa-arrow-right-long" style="margin-left: 15px;" ></i></span> <a href="<?php echo base_url('assets/upload/courseVideo/'.$video->hand_note);?>" download="course_hand_note" class="btn-down" style="margin-left: 15px; color: #ffffff;">Download</a>
            <?php } ?>
        </div>

        <div class="col-12 mt-4">
            <?php if ($checkExam != 0){ $check = already_join_course_exam_check($video->course_video_id); if($check == 0){  ?>
                <center><a href="<?php echo base_url()?>/Mobile_app/Course/join_quiz/<?php echo $video->course_video_id?>" class="btn-down ">Join MCQ</a></center>
            <?php } } ?>
        </div>
    </div>
</section>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog mo-cls">
        <div class="modal-content mo-cont">
            <div class="point-vi" ><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="margin-right: 74px;background-color: white;"></button></div>
            <div class="point-vi3" ></div>
            <div class="modal-body mo-bod" id="videoUrl">
            </div>
        </div>
    </div>
</div>