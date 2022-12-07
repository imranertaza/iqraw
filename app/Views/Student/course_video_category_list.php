<section class="extra-head">
    <img src="<?php echo base_url()?>/assets/image/class-bn.svg" alt="banner" class="bn-cl" >
</section>

<section class="content" style="margin-bottom: 90px;">
    <div class="row pt-2">
        <?php if (!empty($video)){ foreach ($video as $val){
            $name = get_data_by_id('category_name','course_category','course_cat_id',$val->course_cat_id);
            $image = get_data_by_id('image','course_category','course_cat_id',$val->course_cat_id);
            $img = (!empty($image))?$image:'noImage.svg'
            ?>

            <div class="col-12">
                <a href="<?php echo base_url()?>/Student/Course/video/<?php echo $val->course_cat_id?>">
                <div class="w-50 float-start p-2">
                    <img src="<?php echo base_url() ?>/assets/upload/courseCategory/<?php echo $img; ?>" alt="banner" class="skill-img w-100" >
                </div>
                <div class="w-50 float-start p-2 sch-nd text-capitalize">
                    <span class="sk-n"><?php echo $name; ?></span><br>
                    <img src="<?php echo base_url() ?>/assets/image/star.svg" alt="banner" class="star" >
                </div>
                </a>
            </div>

        <?php } }else{ echo '<div class="col-6 math-p" style="padding-right: 4px !important;"><p>No data available</p> </div>';} ?>
    </div>
</section>