<section class="extra-head">
    <img src="<?php echo base_url()?>/assets/image/class-bn.svg" alt="banner" class="bn-cl" >
</section>

<section class="content" style="margin-bottom: 90px;">
    <div class="row pt-2">

        <?php if (!empty($course)){ foreach ($course as $cor){ $cor->image;?>
        <div class="col-12" >
            <a href="<?php echo base_url()?>/Mobile_app/Course/details/<?php echo $cor->course_id?>">
            <div class="w-50 float-start p-2">
                <img src="<?php echo base_url() ?>/assets/upload/course/<?php echo $cor->image; ?>" alt="banner" class="skill-img w-100" >
            </div>
            <div class="w-50 float-start p-2 sch-nd text-capitalize">
                <span class="sk-n"><?php echo $cor->course_name; ?></span><br>
                <img src="<?php echo base_url() ?>/assets/image/star.svg" alt="banner" class="star" >
                <a href="<?php echo base_url()?>/Mobile_app/Course/details/<?php echo $cor->course_id?>" class="btn btn-join mt-1">Details</a>
            </div>
            </a>
        </div>

        <?php } }else{ echo '<div class="col-6 math-p" style="padding-right: 4px !important;"><p>No data available</p> </div>';}?>

    </div>
</section>