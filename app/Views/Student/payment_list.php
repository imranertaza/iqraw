<section class="extra-head">
    <img src="<?php echo base_url()?>/assets/image/class-bn.svg" alt="banner" class="bn-cl" >
</section>

<section class="content" style="margin-bottom: 90px;">
    <div class="row pt-2">
        <div class="col-12">
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Join Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php  foreach ($package as $val){ ?>
                    <tr>
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
</section>