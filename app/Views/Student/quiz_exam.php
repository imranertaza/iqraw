<section class="extra-head">
    <img src="<?php echo base_url()?>/assets/image/class-bn.svg" alt="banner" class="bn-cl" >
</section>

<section class="content" style="margin-bottom: 90px;">
    <div class="row pt-2">
        <div class="col-12 quiz-exam mt-2">
            <ul class="nav nav-tabs card-header-tabs voc-ac" data-bs-tabs="tabs">
                <li class="nav-item ">
                    <a class="nav-link  d-block active" aria-current="true" data-bs-toggle="tab" href="#dhcp">New Exam</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-block" data-bs-toggle="tab" href="#static">Already Done Exam</a>
                </li>
            </ul>

            <div class="tab-content mt-4 mb-4">
                <div class="tab-pane active" id="dhcp">
                    <table class="table text-capitalize">
                        <tbody>
                        <?php if (!empty($quiz_exam)){ foreach ($quiz_exam as $exam){ if (already_join_check($exam->quiz_exam_info_id) == 0){ $url = base_url().'/Student/Quiz/question/'.$exam->quiz_exam_info_id; ?>
                            <tr>
                                <td style="padding: 18px;"><?php echo $exam->quiz_name;?></td>
                                <td width="60"><a href="javascript:void(0)" onclick="join_exam('<?php echo $url;?>')" class="btn btn-join">Join</a></td>
                            </tr>
                        <?php } } }else{ echo '<div class="col-6 math-p" style="padding-right: 4px !important;"><p>No Exam available</p> </div>';}?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="static">

                    <table class="table text-capitalize">
                        <tbody>
                        <?php if (!empty($join_quiz_exam)){ foreach ($join_quiz_exam as $join){ ?>
                            <tr>
                                <td style="padding: 18px;"><?php echo $join->quiz_name;?></td>
                                <td width="60"><a href="<?php echo base_url()?>/Student/Quiz/exam_result/<?php echo $join->qe_joined_id ?>"  class="btn btn-join">Result</a></td>
                            </tr>
                        <?php } }else{ echo '<div class="col-6 math-p" style="padding-right: 4px !important;"><p>No Exam available</p> </div>';}?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>