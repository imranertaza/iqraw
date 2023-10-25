<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quiz Exam Update</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Quiz Exam Update</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8 mt-2">
                                <h3 class="card-title">Quiz Exam Update</h3>
                            </div>
                            <div class="col-md-4">

                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <form id="edit-form" action="<?php echo base_url($controller)?>/update_action" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="class_id">Class: </label>
                                    <select class="form-control" name="class_id" id="class_id"
                                            onchange="subject_get(this.value)" required>
                                        <option value="">Please select</option>
                                        <?php echo getListInOption($exam->class_id, 'class_id', 'name', 'class') ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subject_id">Subject: </label>
                                    <select class="form-control" name="subject_id" id="subject_id" required>
                                        <option value="">Please select</option>
                                        <?php echo getListInOption($exam->subject_id, 'subject_id', 'name', 'subject') ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quiz_name">Quiz Name: </label>
                                    <input type="text" class="form-control" name="quiz_name" id="quiz_name" value="<?php echo $exam->quiz_name; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="published_date">Published date: </label>
                                    <input type="date" class="form-control" name="published_date" id="published_date" value="<?php echo $exam->published_date; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_questions">Total Questions: </label>
                                    <input type="text" class="form-control" name="total_questions" id="total_questions" value="<?php echo $exam->total_questions; ?>"
                                           required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status: </label>
                                    <select class="form-control" name="status" id="status" required>
                                        <option value="">please select</option>
                                        <?php echo globalStatus($exam->status) ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="card-title">Quiz</h3>
                                <br><hr>
                            </div>

                            <div class="col-md-12">
                                <div class="optionBox row">
                                    <div class="block col-md-12">
                                        <a href="javascript:void(0)" class="add btn btn-primary " style="float: right;" >Add Option</a>
                                    </div>
                                    <?php foreach($examQuest as $qz){ ?>
                                    <div class="block col-md-12 row">
                                        <div class="form-group col">
                                            <label for="question">Question: </label>
                                            <input type="text" class="form-control" name="question[]" value="<?php echo $qz->question;?>"  required>
                                            <input type="hidden" name="quiz_question_id[]" value="<?php echo $qz->quiz_question_id;?>"  >
                                        </div>
                                        <div class="form-group col">
                                            <label for="one">One: </label>
                                            <input type="text" class="form-control" name="one[]" value="<?php echo $qz->one;?>" required>
                                        </div>

                                        <div class="form-group col">
                                            <label for="two">Two: </label>
                                            <input type="text" class="form-control" name="two[]" value="<?php echo $qz->two;?>" required>
                                        </div>

                                        <div class="form-group col">
                                            <label for="three">Three: </label>
                                            <input type="text" class="form-control" name="three[]" value="<?php echo $qz->three;?>" required>
                                        </div>

                                        <div class="form-group col">
                                            <label for="four">Four: </label>
                                            <input type="text" class="form-control" name="four[]" value="<?php echo $qz->four;?>"required>
                                        </div>

                                        <div class="form-group col">
                                            <label for="correct_answer">Correct answer: </label>
                                            <select class="form-control" name="correct_answer[]" required>
                                                <option value="">Please select</option>
                                                <option value="one" <?php echo ($qz->correct_answer == 'one')?'selected':'';?> >One</option>
                                                <option value="two" <?php echo ($qz->correct_answer == 'two')?'selected':'';?> >Two</option>
                                                <option value="three" <?php echo ($qz->correct_answer == 'three')?'selected':'';?> >Three</option>
                                                <option value="four" <?php echo ($qz->correct_answer == 'four')?'selected':'';?> >Four</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col">
                                            <a href="javascript:void(0)" class="btn btn-danger" onclick="removeItem(this),deleteitem(<?php echo $qz->quiz_question_id;?>)" style="margin-top: 30px;" >Remove</a>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    
                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12 text-end ">
                                <input type="hidden" class="form-control" name="quiz_exam_info_id" id="quiz_exam_info_id" value="<?php echo $exam->quiz_exam_info_id; ?>" required>
                                <button type="submit" class="btn btn-success" >Update</button>
                            </div>
                        </div>
                    </form>
                        
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    

    
</div>
<!-- /.content-wrapper -->
<script>
    
    $('.add').click(function() {
        var temp = `<div class="block col-md-12 row">
                        <div class="form-group col">
                            <label for="question">Question: </label>
                            <input type="text" class="form-control" name="question[]" required>
                            <input type="hidden" name="quiz_question_id[]" value=""  >
                        </div>
                        <div class="form-group col">
                            <label for="one">One: </label>
                            <input type="text" class="form-control" name="one[]" required>
                        </div>
                        <div class="form-group col">
                            <label for="two">Two: </label>
                            <input type="text" class="form-control" name="two[]" required>
                        </div>
                        <div class="form-group col">
                            <label for="three">Three: </label>
                            <input type="text" class="form-control" name="three[]" required>
                        </div>
                        <div class="form-group col">
                            <label for="four">Four: </label>
                            <input type="text" class="form-control" name="four[]" required>
                        </div>
                        <div class="form-group col">
                            <label for="correct_answer">Correct answer: </label>
                            <select class="form-control" name="correct_answer[]" required>
                                <option value="">Please select</option>
                                <option value="one">One</option>
                                <option value="two">Two</option>
                                <option value="three">Three</option>
                                <option value="four">Four</option>
                            </select>
                        </div>                                            
                        <div class="form-group col">
                            <a href="javascript:void(0)" class="btn btn-danger" onclick="removeItem(this)" style="margin-top: 30px;" >Remove</a>
                        </div>
                    </div>`;
        $('.optionBox').append(temp);
    });

    function removeItem(item){
        $(item).parent().parent().remove();
    } 
    
    $("#edit-form").submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function () {
                $('#edit-form-btn').html('<i class="fa fa-spinner fa-spin"></i>');
            },
            success: function (response) {

                if (response.success === true) {

                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: response.messages,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        $('#data_table').DataTable().ajax.reload(null, false).draw(false);
                    })

                } else {

                    if (response.messages instanceof Object) {
                        $.each(response.messages, function (index, value) {
                            var id = $("#" + index);

                            id.closest('.form-control')
                                .removeClass('is-invalid')
                                .removeClass('is-valid')
                                .addClass(value.length > 0 ? 'is-invalid' : 'is-valid');

                            id.after(value);

                        });
                    } else {
                        Swal.fire({
                            position: 'bottom-end',
                            icon: 'error',
                            title: response.messages,
                            showConfirmButton: false,
                            timer: 1500
                        })

                    }
                }
                $('#edit-form-btn').html('Update');
            }
        });
    });
    

    

    function subject_get(class_id) {
        $.ajax({
            url: '<?php echo base_url($controller . '/get_subject') ?>',
            type: 'post',
            data: {
                class_id: class_id
            },
            success: function (val) {
                $("#subject_id").html(val);
                $("#edit-form #subject_id").html(val);
                $("#subject_id_search").html(val);
            }
        });
    }

    function deleteitem(id){
        $.ajax({
            type: "POST",
            url: '<?php echo base_url($controller)?>/deletQuiz',
            data: {quiz_question_id:id},
            dataType: 'json',
            beforeSend: function () {
                $('#edit-form-btn').html('<i class="fa fa-spinner fa-spin"></i>');
            },
            success: function (response) {

                if (response.success === true) {

                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: response.messages,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        $('#data_table').DataTable().ajax.reload(null, false).draw(false);
                    })

                } else {

                    if (response.messages instanceof Object) {
                        $.each(response.messages, function (index, value) {
                            var id = $("#" + index);

                            id.closest('.form-control')
                                .removeClass('is-invalid')
                                .removeClass('is-valid')
                                .addClass(value.length > 0 ? 'is-invalid' : 'is-valid');

                            id.after(value);

                        });
                    } else {
                        Swal.fire({
                            position: 'bottom-end',
                            icon: 'error',
                            title: response.messages,
                            showConfirmButton: false,
                            timer: 1500
                        })

                    }
                }
            }
        });
    }

    
</script>