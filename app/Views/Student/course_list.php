<section class="extra-head">
    <img src="<?php echo base_url()?>/assets/image/class-bn.svg" alt="banner" class="bn-cl" >
</section>

<section class="content" style="margin-bottom: 90px;">
    <div class="row pt-2">
        <?php if (!empty($course)){ foreach ($course as $cor){  ?>
            <div class="col-12 cl-p-r" >
                <a href="<?php echo base_url()?>/Student/Course/video/<?php echo $cor->course_id?>" class=" d-block btn-cl position-relative" ><?php echo $cor->course_name;?></a>
            </div>
        <?php } }else{ echo '<div class="col-6 math-p" style="padding-right: 4px !important;"><p>No data available</p> </div>';}?>
    </div>
</section>