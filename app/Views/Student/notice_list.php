

<section class="content" style="margin-bottom: 90px;margin-top: 13px;">
    <div class="row pt-2 text-capitalize">
        <div class="col-12" style="padding: 0px 24px;">
                <?php foreach ($notice as $val){ $check = (check_unread_notice($val->notice_id) == true)?'bold-data':'note-ti';   ?>

                    <p class=" <?php echo $check;?>"><a href="<?php echo base_url('Mobile_app/Notice/details/'.$val->notice_id)?>"><?php echo $val->title;?></a></p>

                <?php } ?>
        </div>
    </div>
</section>