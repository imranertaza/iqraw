<section class="extra-head">
    <img src="<?php echo base_url()?>/assets/image/class-bn.svg" alt="banner" class="bn-cl" >
</section>

<section class="content" style="margin-bottom: 90px;">
    <div class="row pt-2">
        <?php if(!empty($quiz)){?>
            <div class="col-12 mt-2 d-flex justify-content-between" >
                <span class="fc-ti-2" >Quiz Exam</span>
                <span class="fc-ti-2"><?php echo $pager->getCurrentPage(); ?>/<?php echo $pager->getPageCount(); ?></span>
            </div>
            <?php foreach ($quiz as $key => $qu){ ?>

                <div class="col-12 mt-2 " >
                    <span class="m-qu"> <?php echo $qu->question?></span>
                    <span id="mess"></span>
                </div>

                <div class="col-12 mt-2 q-ans" >
                    <!-- line -->
                    <input type="hidden" id="quiz_question_id" value="<?php echo $qu->quiz_question_id?>">
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" value="one" >
                    <label class="btn btn-outline-success d-block" for="btnradio1"><?php echo $qu->one?></label>
                    <!-- line -->

                    <!-- line -->
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" value="two">
                    <label class="btn btn-outline-success d-block" for="btnradio2"><?php echo $qu->two?></label>
                    <!-- line -->

                    <!-- line -->
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off" value="three">
                    <label class="btn btn-outline-success d-block" for="btnradio3"><?php echo $qu->three?></label>
                    <!-- line -->

                    <!-- line -->
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off" value="four">
                    <label class="btn btn-outline-success d-block" for="btnradio4"><?php echo $qu->four?></label>
                    <!-- line -->

                </div>
                <div class="col-12 mt-3 " >
                    <?php echo $pager->quizecustomLinks();?>
                </div>

            <?php } ?>



        <?php } ?>

    </div>
</section>