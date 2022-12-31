<section class="extra-head" style="position: relative;">
    <?php $videoID = (!empty($video->video_id))?$video->video_id:''; ?>
    <a href="javascript:void(0)" onclick="video_open('<?php echo $videoID?>')" > <img src="<?php echo base_url()?>/assets/image/video.svg" alt="banner" class="bn-cl" ></a>

</section>

<section class="content-2" style="margin-bottom: 90px;">
    <div class="row pt-2">
        <div class="col-12 text-center mt-2" >
            <?php if(!empty($hand_note)){ ?>
            <span class="fc-ti-1">Hand Note <i class="fa-solid fa-arrow-right-long" style="margin-left: 15px;" ></i></span> <a href="<?php echo base_url('assets/upload/chapter/'.$hand_note);?>" download="<?php echo $page_title;?>" class="btn-down" style="margin-left: 15px; color: #ffffff;">Download</a>
            <?php } ?>
        </div>
        <div class="col-12 mt-4">
            <?php if (!empty($video->chapter_id)){ $check = already_join_chapter_check($video->chapter_id); if ($check == 0){ ?>
            <center><button onclick="join_exam('<?php echo base_url()?>/Mobile_app/VideoQuiz/join_quiz/<?php echo $video->chapter_id?>')"  class="btn-down ">Join MCQ</button></center>
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