

    <section class="extra-head">
        <img src="<?php echo base_url()?>/assets/image/class-bn.svg" alt="banner" class="bn-cl" >
    </section>

    <section class="content" style="margin-bottom: 90px;">
        <div class="row pt-2">
            <?php foreach ($subject as $sub){ ?>
            <div class="col-6 cl-p-r" >
                <a href="<?php echo base_url()?>/Student/Subject/chapter/<?php echo $sub->subject_id?>" class="btn d-block btn-cl"><?php echo $sub->name;?></a>
            </div>
            <?php } ?>
        </div>
    </section>