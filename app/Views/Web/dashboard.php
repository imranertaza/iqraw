<section class="content-three con-mr">
    <div class="container">
        <div class="row ">
            <div class="col-12 text-center" style="margin-bottom: 100px;">
                <p class="cor-title"> আমার কোর্স </p>
            </div>
            <?php foreach ($couSub as $row){
                $course = get_all_data_by_id('course', 'course_id', $row->course_id);
                foreach ($course as $val){ $img = (!empty($val->image))?$val->image:'noImage.svg';
            ?>
                    <div class="col-md-3 col-sm-3 col-lg-3">
                        <a href="<?php echo base_url()?>/Web/Dashboard/course/<?php echo $val->course_id;?>" class="nav-link ">
                            <div class="cor-box">
                                <div class="cou-img">
                                    <img src="<?php echo base_url()?>/assets/upload/course/<?php echo $img;?>" alt="" width="100%">
                                </div>
                                <div class="cou-con">
                                    <p class="cor-t-2 text-capitalize "><?php echo $val->course_name;?></p>
                                </div>
                                <div class="d-flex justify-content-between ">
                                    <img src="<?php echo base_url()?>/assets_web/star.svg" alt="">
                                    <p class="cor-t-3"><?php echo $val->price;?>৳</p>
                                </div>
                            </div>
                        </a>
                    </div>

            <?php } } ?>
        </div>
    </div>
</section>