<section class="extra-head" style="position: relative;">
<!--    <img src="--><?php //echo base_url()?><!--/assets/image/video.svg" alt="banner" class="bn-cl" >-->
<!--    <div class="point-vi" ></div>-->
<!--    <div class="point-vi2" ></div>-->
<!--    --><?php //if (!empty($video->URL)){ echo $video->URL;}else{ ?>
<!--    <img src="--><?php //echo base_url()?><!--/assets/image/video.svg" alt="banner" class="bn-cl" >-->
<!--    --><?php //}?>
    <a href="javascript:void(0)" onclick="video_open('<?php echo $video->video_id?>')" > <img src="<?php echo base_url()?>/assets/image/video.svg" alt="banner" class="bn-cl" ></a>

</section>

<section class="content-2" style="margin-bottom: 90px;">
    <div class="row pt-2">
        <div class="col-12 text-center mt-2" >
            <span class="fc-ti-1">Hand Note <i class="fa-solid fa-arrow-right-long" style="margin-left: 15px;" ></i></span> <a href="#" class="btn-down" style="margin-left: 15px; color: #ffffff;">Download</a>
        </div>
        <div class="col-12 mt-4">
            <?php if (!empty($video->chapter_id)){ $check = already_join_chapter_check($video->chapter_id); if ($check == 0){ ?>
            <center><button onclick="join_exam('<?php echo base_url()?>/Student/VideoQuiz/join_quiz/<?php echo $video->chapter_id?>')"  class="btn-down ">Join MCQ</button></center>
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