<section class="extra-head">
    <!--    <img src="--><?php //echo base_url()?><!--/assets/image/class-bn.svg" alt="banner" class="bn-cl" >-->
</section>

<section class="content-2" style="margin-bottom: 90px;">
    <div class="row pt-2">
        <div class="col-12">
            <ul class="nav nav-tabs card-header-tabs voc-ac" data-bs-tabs="tabs">
                <li class="nav-item">
                    <a class="nav-link  d-block active" aria-current="true" data-bs-toggle="tab" href="#dhcp">English to
                        Bangla</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-block" data-bs-toggle="tab" href="#static">Bangla to English</a>
                </li>
            </ul>
            <!-- Tabs content -->
            <div class="tab-content mt-4 mb-4">
                <div class="tab-pane active" id="dhcp">
                    <div class="row">
                        <div class="col-12 mt-4">
                            <div class="d-flex flex-column">
                                <?php foreach ($vocabulary as $val) { ?>
                                    <div class="d-flex justify-content-between">
                                        <p class="vo-t"><?php echo $val->english ?></p>
                                        <p class="vo-t"><?php echo $val->bangla ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="static">
                    <div class="row">
                        <div class="col-12 mt-4">
                            <div class="d-flex flex-column">
                                <?php foreach ($vocabulary as $val2) { ?>
                                    <div class="d-flex justify-content-between ">
                                        <p class="vo-t"><?php echo $val2->bangla ?></p>
                                        <p class="vo-t"><?php echo $val2->english ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Tabs content -->
        </div>

        <div class="col-12 mt-4">
            <center><h5>Vocabulary Exam list</h5></center>
            <table class="table text-capitalize mt-3">
                <tbody>
                <?php
                    if (!empty($vocabularyExam)){
                    foreach ($vocabularyExam as $ex){
                    $table = DB()->table('vocabulary_exam_joined');
                    $data = $table->where('voc_exam_id',$ex->voc_exam_id)->where('std_id',newSession()->std_id)->get()->getRow();
                    if (empty($data)){
                ?>
                    <tr>
                        <td style="padding: 18px;"><?php echo $ex->title?></td>
                        <td width="40"><a href="<?php echo base_url()?>/Mobile_app/Vocabulary/exam_join/<?php echo $ex->voc_exam_id?>"  class="btn btn-join"  >Join</a></td>
                    </tr>
                <?php } }  }else{ echo '<div class="col-12 math-p"><p class="noDataMsg">No Exam available</p> </div>';}?>

                </tbody>
            </table>
        </div>
    </div>
</section>