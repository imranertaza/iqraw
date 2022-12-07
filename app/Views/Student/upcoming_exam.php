<section class="extra-head">
    <img src="<?php echo base_url()?>/assets/image/class-bn.svg" alt="banner" class="bn-cl" >
</section>

<section class="content" style="margin-bottom: 90px;">
    <div class="row pt-2">
        <?php if (!empty($subject)){ foreach ($subject as $sub){ $totalExamPending = get_subID_by_upcoming_exam($sub->subject_id) ; ?>
            <div class="col-6 cl-p-r" >
                <a href="<?php echo base_url()?>/Student/Quiz/exam_upcoming/<?php echo $sub->subject_id?>" class="btn d-block btn-cl position-relative" ><?php echo $sub->name;?> <span class="position-absolute  badge bg-secondary rounded-pill top-0 bg-success"><?php echo $totalExamPending;?></span></a>
            </div>
        <?php } }else{ echo '<div class="col-6 math-p" style="padding-right: 4px !important;"><p>No data available</p> </div>';}?>
    </div>
</section>