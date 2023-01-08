<section class="extra-head" >
</section>

<section class="content-2" style="margin-bottom: 90px;">
    <div class="row pt-2">
        <div class="col-12 text-center mt-2" >
            <h4>Course Questions</h4>
            <?php if(!empty($quiz)){?>
                <div class="col-12 mt-2 d-flex justify-content-between mt-4" >
                    <span class="fc-ti-2" >Course Questions list</span>
                    <span class="fc-ti-2"><?php echo $pager->getCurrentPage(); ?>/<?php echo $pager->getPageCount(); ?></span>
                </div>
                <?php foreach ($quiz as $key => $qu){ ?>

                    <div class="col-12 mt-2 " >
                        <span class="m-qu"> <?php echo $qu->question?></span>
                        <span id="mess"></span>
                    </div>

                    <div class="col-12 mt-2 q-ans" >
                        <!-- line -->
                        <input type="hidden" id="course_quiz_id" value="<?php echo $qu->course_quiz_id?>">
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
                        <?php echo $pager->coursecustomLinks();?>
                    </div>

                <?php } ?>



            <?php } ?>
        </div>

    </div>
</section>