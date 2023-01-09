
<section class="content" style="margin-bottom: 90px;">
    <div class="row pt-2">
        <div class="col-12 text-center">
            <?php
            $course_id = get_data_by_id('course_id','course_video','course_video_id',$result->course_video_id);
            $course = get_data_by_id('course_name','course','course_id',$course_id);

            $videoTitle = get_data_by_id('title','course_video','course_video_id',$result->course_video_id);
            ?>
            <h2><?php echo $course; ?></h2>
            <h5><?php echo $videoTitle; ?></h5>
        </div>

        <?php $i=1; foreach (newSession()->quizCourse as $key => $qu){
            $quiztable = DB()->table('course_quiz');
            $quiz = $quiztable->where('course_quiz_id',$qu['quizId'])->get()->getRow();
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