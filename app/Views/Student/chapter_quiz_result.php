<section class="extra-head" >
    <div class="row">
        <div class="col-12 text-center text-capitalize ">
            <?php
                $chapter_id = get_data_by_id('chapter_id','chapter_exam_joined','chapter_joined_id',newSession()->chapter_joined_id);
                $subjectid = get_data_by_id('subject_id','chapter','chapter_id',$chapter_id);
                $chapterName = get_data_by_id('name','chapter','chapter_id',$chapter_id);
                $subjectName = get_data_by_id('name','subject','subject_id',$subjectid);
            ?>
            <h2><?php echo $subjectName;?></h2>
            <h6><?php echo $chapterName;?></h6>
        </div>
    </div>
</section>

<section class="content-2" style="margin-bottom: 90px;">
    <div class="row pt-2">
        <?php $i=1; foreach (newSession()->quiz as $key => $qu){
            $quiztable = DB()->table('chapter_quiz');
            $quiz = $quiztable->where('quiz_id',$qu['quizId'])->get()->getRow();
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


        <div class="col-12 mt-5 border-top p-4">
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