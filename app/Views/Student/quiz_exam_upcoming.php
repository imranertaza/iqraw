<section class="extra-head">
    <img src="<?php echo base_url() ?>/assets/image/class-bn.svg" alt="banner" class="bn-cl">
</section>

<section class="content" style="margin-bottom: 90px;">
    <div class="row pt-2">
        <div class="col-12 quiz-exam mt-2">
            <table class="table text-capitalize">
                <tbody>
                <?php if (!empty($quiz_exam)) {
                    foreach ($quiz_exam as $exam) {
                            $url = base_url() . '/Student/Quiz/question/' . $exam->quiz_exam_info_id; ?>
                            <tr>
                                <td style="padding: 18px;"><?php echo $exam->quiz_name; ?></td>
                                <td style="padding: 18px;"><?php echo $exam->published_date; ?></td>
                            </tr>
                <?php  }
                } else {
                    echo '<div class="col-6 math-p" style="padding-right: 4px !important;"><p>No Exam available</p> </div>';
                } ?>
                </tbody>
            </table>

        </div>

    </div>
</section>