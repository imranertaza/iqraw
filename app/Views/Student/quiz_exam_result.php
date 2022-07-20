
<section class="content" style="margin-bottom: 90px;">
    <div class="row pt-2">
        <div class="col-12 text-center">
            <?php
            $subjectId = get_data_by_id('subject_id','quiz_exam_info','quiz_exam_info_id',$result->quiz_exam_info_id);
            $subject = get_data_by_id('name','subject','subject_id',$subjectId);
            $quiz_name = get_data_by_id('quiz_name','quiz_exam_info','quiz_exam_info_id',$result->quiz_exam_info_id);
            ?>
            <h2><?php echo $subject; ?></h2>
            <h5><?php echo $quiz_name; ?></h5>
        </div>

        <?php $i=1; foreach (newSession()->quiz_exam as $key => $qu){
            $quiztable = DB()->table('quiz_exam_questions');
            $quiz = $quiztable->where('quiz_question_id',$qu['quizId'])->get()->getRow();
            ?>

            <div class="col-12 mt-4" >
                <span class="m-qu"> <?php echo $i++ ?>) <?php echo $quiz->question?></span>
                <span id="mess"></span>
            </div>

            <div class="col-12 mt-2 q-ans" >
                <?php
                $answers = array("one","two","three","four");
                foreach ($answers as $val){
                    $correct = ($quiz->correct_answer == $val)?'correct':'';
                    $wrong = ($quiz->correct_answer != $qu['quizAns'] && $qu['quizAns'] == $val)?'wrong':'';

                    ?>
                    <label class="btn btn-outline-success d-block <?php echo $correct;?> <?php echo $wrong;?> " for="btnradio1"   ><?php echo $quiz->$val;?> </label>
                <?php } ?>

            </div>

        <?php } ?>


        <div class="col-12 mt-5 border-top pt-5 ">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <td>Total Question</td>
                        <td><?php echo $result->correct_answers + $result->incorrect_answers;?></td>
                    </tr>

                    <tr>
                        <td>Correct Answers</td>
                        <td><?php echo $result->correct_answers;?></td>
                    </tr>

                    <tr>
                        <td>Incorrect Answers</td>
                        <td><?php echo $result->incorrect_answers;?></td>
                    </tr>

                    <tr>
                        <td>Earn Points</td>
                        <td><?php echo $result->earn_points;?></td>
                    </tr>

                    <tr>
                        <td>Earn Coins</td>
                        <td><?php echo $result->earn_coins;?></td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</section>