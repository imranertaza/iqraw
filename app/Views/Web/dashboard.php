<section class="content-three con-mr">
    <div class="container">
        <div class="row ">
            <div class="col-12 text-center" style="margin-bottom: 50px;">
                <p class="cor-title"> আমার প্যাকেজ </p>
            </div>

            <div class="col-12" style="margin-bottom: 50px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Join Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; foreach ($pack as $val){ ?>
                        <tr>
                            <td><?php echo $i++;?></td>
                            <td><?php echo get_data_by_id('name','class_subscribe_package','class_subscription_package_id',$val->class_subscription_package_id);?></td>
                            <td><?php echo simpleDateFormat($val->createdDtm) ;?></td>
                            <td><?php echo get_data_by_id('end_date','class_subscribe_package','class_subscription_package_id',$val->class_subscription_package_id);?></td>
                            <td><?php echo statusView($val->status);?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>

        <div class="row ">
            <div class="col-12 text-center" style="margin-bottom: 50px;">
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