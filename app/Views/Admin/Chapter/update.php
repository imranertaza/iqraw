<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chapter Update</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Chapter</li>
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
                                <h3 class="card-title">Chapter Update</h3>
                            </div>
                            <div class="col-md-4">
                                <!-- <button type="button" class="btn btn-block btn-success" onclick="add()" title="Add"><i
                                        class="fa fa-plus"></i> Add
                                </button> -->

                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="edit-form" action="<?php echo base_url($controller)?>/update_action" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php $class_id = get_data_by_id('class_id','subject','subject_id',$chapter->subject_id);?>
                                    <div class="form-group ">
                                        <label for="chapter_id">Class: </label>
                                        <select class="form-control text-capitalize" onchange="get_subject(this.value)" id="class_id" required>
                                            <option value="">Please select</option>
                                            <?php echo getListInOption($class_id,'class_id','name','class') ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="chapter_id">Subject: </label>
                                        <select class="form-control" name="subject_id" onchange="get_chapter(this.value)"  id="subject_id" required>
                                            <option value="">Please select</option>
                                            <?php echo getListInOptionParentIdBySub($chapter->subject_id, 'subject_id', 'name', 'subject','class_id',$class_id)?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Chapter Name: </label>
                                        <input type="text" class="form-control" name="name" id="name" value="<?php echo $chapter->name;?>" required>
                                        <input type="hidden" class="form-control" name="chapter_id" id="chapter_id" value="<?php echo $chapter->chapter_id;?>" required>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status: </label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="">please select</option>
                                            <?php echo globalStatus($chapter->status)?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Hand  Note: </label>
                                        <input type="file" accept=".pdf," class="form-control" name="hand_note" >                                    
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="card-title">Video</h3>
                                    <br><hr>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Title: </label>
                                        <input type="text" class="form-control" name="title" id="title" value="<?php echo !empty($chapterVideo->name)?$chapterVideo->name:'';?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">URL: </label>
                                        <input type="text" class="form-control" name="URL" id="URL" value="<?php echo !empty($chapterVideo->URL)?$chapterVideo->URL:'';?>" required>
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
                                        <?php foreach($chapterQuize as $qz){ ?>
                                        <div class="block col-md-12 row">
                                            <div class="form-group col">
                                                <label for="question">Question: </label>
                                                <input type="text" class="form-control" name="question[]" value="<?php echo $qz->question;?>"  required>
                                                <input type="hidden" name="quiz_id[]" value="<?php echo $qz->quiz_id;?>"  >
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
                                                <a href="javascript:void(0)" class="btn btn-danger" onclick="removeItem(this),deleteitem(<?php echo $qz->quiz_id;?>)" style="margin-top: 30px;" >Remove</a>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        
                                    </div>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12 text-end ">
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
    <!-- Add modal content -->
   
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    $('.add').click(function() {
        var temp = `<div class="block col-md-12 row">
                        <div class="form-group col">
                            <label for="question">Question: </label>
                            <input type="text" class="form-control" name="question[]" required>
                            <input type="hidden" name="quiz_id[]" value=""  >
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

    function deleteitem(id){
        $.ajax({
            type: "POST",
            url: '<?php echo base_url($controller)?>/deletQuiz',
            data: {quiz_id:id},
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