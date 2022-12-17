<section class="extra-head" style="position: relative;">
    <a href="javascript:void(0)" onclick="video_open_course('<?php echo $video->course_video_id?>')" ><img src="<?php echo base_url() ?>/assets/ion_logo-youtube.svg" alt="play_btn" class="play_btn"  ></a>
    <a href="javascript:void(0)" onclick="video_open_course('<?php echo $video->course_video_id?>')" > <img src="<?php echo base_url() ?>/assets/upload/courseVideo/<?php echo $video->thumb; ?>" alt="banner" class="bn-cl" width="100%" ></a>



</section>

<section class="content" style="margin-bottom: 90px;">
    <div class="row pt-2 text-capitalize">
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