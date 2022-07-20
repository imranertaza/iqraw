<section class="extra-head" >
<!--    <img src="--><?php //echo base_url()?><!--/assets/image/video.svg" alt="banner" class="bn-cl" >-->

    <?php if (!empty($video->URL)){ echo $video->URL;}else{ ?>
    <img src="<?php echo base_url()?>/assets/image/video.svg" alt="banner" class="bn-cl" >
    <?php }?>
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