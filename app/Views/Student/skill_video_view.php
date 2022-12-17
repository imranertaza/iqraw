<section class="extra-head">
    <?php //echo $video->URL;?>
    <iframe src="https://www.youtube-nocookie.com/embed/<?php echo $video->URL; ?>" title="YouTube video player" frameborder="20" allow="accelerometer; autoplay; clipboard-write;  encrypted-media=0; gyroscope; picture-in-picture" ></iframe>
</section>

<section class="content" style="margin-bottom: 90px;">
    <div class="row pt-2 text-capitalize">
        <div class="col-12">
            <h3><?php echo $video->title;?></h3>
            <p><?php echo $video->author;?></p>
            <?php if (($check == 0) && (!empty($checkMCQ))) { ?>
            <center><button onclick="join_exam('<?php echo base_url()?>/Mobile_app/Skill_development/join_mcq/<?php echo $video->skill_video_id?>')"  class="btn-down ">Join MCQ</button></center>
            <?php }  ?>
        </div>
    </div>
</section>