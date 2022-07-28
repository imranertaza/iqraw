<section class="extra-head mt-3 text-center">
    <h5><?php echo  get_data_by_id('title','vocabulary_exam','voc_exam_id', $voc_exam_id) ?></h5>

</section>

<section class="content mt-3" style="margin-bottom: 90px;">
    <div class="row pt-2">
        <?php if(!empty($quiz)){?>
            <div class="col-12 mt-2 d-flex justify-content-between" >
                <span class="fc-ti-2" >Vocabulary Quiz Exam</span>
                <span class="fc-ti-2"><?php echo $pager->getCurrentPage(); ?>/<?php echo $pager->getPageCount(); ?></span>
            </div>
            <?php foreach ($quiz as $key => $qu){
                $q = get_data_by_id('question','vocabulary_quiz','voc_quiz_id',$qu->voc_quiz_id);
                $one = get_data_by_id('one','vocabulary_quiz','voc_quiz_id',$qu->voc_quiz_id);
                $two = get_data_by_id('two','vocabulary_quiz','voc_quiz_id',$qu->voc_quiz_id);
                $three = get_data_by_id('three','vocabulary_quiz','voc_quiz_id',$qu->voc_quiz_id);
                $four = get_data_by_id('four','vocabulary_quiz','voc_quiz_id',$qu->voc_quiz_id);
            ?>

                <div class="col-12 mt-4 " >
                    <span class="m-qu">(<?php echo $pager->getCurrentPage(); ?>) <?php echo $q ?></span>
                    <span id="mess"></span>
                </div>

                <div class="col-12 mt-2 q-ans" >
                    <!-- line -->
                    <input type="hidden" id="voc_quiz_id" value="<?php echo $qu->voc_quiz_id ?>">
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" value="one" >
                    <label class="btn btn-outline-success d-block" for="btnradio1"><?php echo $one?></label>
                    <!-- line -->

                    <!-- line -->
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" value="two">
                    <label class="btn btn-outline-success d-block" for="btnradio2"><?php echo $two ?></label>
                    <!-- line -->

                    <!-- line -->
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off" value="three">
                    <label class="btn btn-outline-success d-block" for="btnradio3"><?php echo $three ?></label>
                    <!-- line -->

                    <!-- line -->
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off" value="four">
                    <label class="btn btn-outline-success d-block" for="btnradio4"><?php echo $four ?></label>
                    <!-- line -->

                </div>
                <div class="col-12 mt-3 " >
                    <?php echo $pager->voccustomLinks();?>
                </div>

            <?php } ?>



        <?php } ?>

    </div>
</section>