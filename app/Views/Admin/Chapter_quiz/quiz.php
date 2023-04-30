<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chapter Quiz</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Chapter Quiz</li>
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
                                <h3 class="card-title">Chapter Quiz List</h3>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-block btn-success" onclick="add()" title="Add"><i
                                        class="fa fa-plus"></i> Add
                                </button>

                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label for="chapter_id">Class: </label>
                                    <select class="form-control text-capitalize" onchange="get_subject(this.value)" id="class_id_search" required>
                                        <option value="">Please select</option>
                                        <?php echo getListInOption('','class_id','name','class') ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="chapter_id">Subject: </label>
                                    <select class="form-control" onchange="get_chapter(this.value)"   id="subject_id_search" required>
                                        <option value="">Please select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="chapter_id">Chapter: </label>
                                    <select class="form-control" id="chapter_id_search" required>
                                        <option value="">Please select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary btn-sm filter" onclick="chapter_quiz_Filter()" style="margin-top: 35px;">Filter</button>
                            </div>
                        </div>

                        <table id="data_table" class="table table-bordered table-striped text-capitalize ">
                            <thead>
                            <tr>
                                <th width="40">Id</th>
                                <th>Chapter</th>
                                <th>Question</th>
                                <th>One</th>
                                <th>Two</th>
                                <th>Three</th>
                                <th>Four</th>
                                <th>Answer</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
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
    <div id="add-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="text-center bg-info p-3">
                    <h4 class="modal-title text-white" id="info-header-modalLabel">Add</h4>
                </div>
                <div class="modal-body text-capitalize">
                    <form id="add-form" class="pl-3 pr-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="chapter_id">Class: </label>
                                    <select class="form-control text-capitalize" onchange="get_subject(this.value)" name="class_id" required>
                                        <option value="">Please select</option>
                                        <?php echo getListInOption('','class_id','name','class') ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="chapter_id">Subject: </label>
                                    <select class="form-control" onchange="get_chapter(this.value)" name="subject_id" id="subject_id" required>
                                        <option value="">Please select</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="chapter_id">Chapter: </label>
                                    <select class="form-control" name="chapter_id" id="chapter_id" required>
                                        <option value="">Please select</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="question">Question: </label>
                                    <input type="text" class="form-control" name="question" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="one">One: </label>
                                    <input type="text" class="form-control" name="one" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="two">Two: </label>
                                    <input type="text" class="form-control" name="two" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="three">Three: </label>
                                    <input type="text" class="form-control" name="three" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="four">Four: </label>
                                    <input type="text" class="form-control" name="four" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="correct_answer">Correct answer: </label>
                                    <select class="form-control" name="correct_answer" required>
                                        <option value="">Please select</option>
                                        <option value="one">One</option>
                                        <option value="two">Two</option>
                                        <option value="three">Three</option>
                                        <option value="four">Four</option>
                                    </select>
                                </div>
                            </div>



                        </div>


                        <div class="form-group text-center">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success" id="add-form-btn">Add</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Add modal content -->
    <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="text-center bg-info p-3">
                    <h4 class="modal-title text-white" id="info-header-modalLabel">Update</h4>
                </div>
                <div class="modal-body">
                    <form id="edit-form" class="pl-3 pr-3">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="chapter_id">Class: </label>
                                    <select class="form-control text-capitalize" onchange="get_subject(this.value)" id="class_id" required>
                                        <option value="">Please select</option>
                                        <?php echo getListInOption('','class_id','name','class') ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="chapter_id">Subject: </label>
                                    <select class="form-control" onchange="get_chapter(this.value)"  id="subject_id" required>
                                        <option value="">Please select</option>
                                        <?php echo getListInOption('','subject_id','name','subject') ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quiz_id">Chapter: </label>
                                    <select class="form-control" name="chapter_id" id="chapter_id" required>
                                        <option value="">Please select</option>
                                        <?php echo getListInOption('','chapter_id','name','chapter') ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="question">Question: </label>
                                    <input type="text" class="form-control" name="question" id="question" required>
                                    <input type="hidden" class="form-control" name="quiz_id" id="quiz_id" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="one">One: </label>
                                    <input type="text" class="form-control" name="one" id="one" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="two">Two: </label>
                                    <input type="text" class="form-control" name="two" id="two" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="three">Three: </label>
                                    <input type="text" class="form-control" name="three" id="three"  required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="four">Four: </label>
                                    <input type="text" class="form-control" name="four" id="four" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="correct_answer">Correct answer: </label>
                                    <select class="form-control" name="correct_answer" id="correct_answer" required>
                                        <option value="">Please select</option>
                                        <option value="one">One</option>
                                        <option value="two">Two</option>
                                        <option value="three">Three</option>
                                        <option value="four">Four</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status: </label>
                                    <select class="form-control" name="status" id="status" required>
                                        <option value="">please select</option>
                                        <?php echo globalStatus('')?>
                                    </select>
                                </div>
                            </div>


                        </div>

                        <div class="form-group text-center">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success" id="edit-form-btn">Update</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    $(function () {
        $('#data_table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "ajax": {
                "url": '<?php echo base_url($controller . '/getAll') ?>',
                "type": "POST",
                "dataType": "json",
                async: "true"
            }
        });
    });

    function add() {
        // reset the form
        $("#add-form")[0].reset();
        $(".form-control").removeClass('is-invalid').removeClass('is-valid');
        $('#add-modal').modal('show');
        // submit the add from
        $.validator.setDefaults({
            highlight: function (element) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid').addClass('is-valid');
            },
            errorElement: 'div ',
            errorClass: 'invalid-feedback',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else if ($(element).is('.select')) {
                    element.next().after(error);
                } else if (element.hasClass('select2')) {
                    //error.insertAfter(element);
                    error.insertAfter(element.next());
                } else if (element.hasClass('selectpicker')) {
                    error.insertAfter(element.next());
                } else {
                    error.insertAfter(element);
                }
            },

            submitHandler: function (form) {

                var form = $('#add-form');
                // remove the text-danger
                $(".text-danger").remove();

                $.ajax({
                    url: '<?php echo base_url($controller . '/add') ?>',
                    type: 'post',
                    data: form.serialize(), // /converting the form data into array and sending it to server
                    dataType: 'json',
                    beforeSend: function () {
                        $('#add-form-btn').html('<i class="fa fa-spinner fa-spin"></i>');
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
                                $('#add-modal').modal('hide');
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
                        $('#add-form-btn').html('Add');
                    }
                });

                return false;
            }
        });
        $('#add-form').validate();
    }

    function edit(quiz_id) {
        $.ajax({
            url: '<?php echo base_url($controller . '/getOne') ?>',
            type: 'post',
            data: {
                quiz_id: quiz_id
            },
            //dataType: 'json',
            success: function (response) {
                // reset the form
                $("#edit-form")[0].reset();
                $(".form-control").removeClass('is-invalid').removeClass('is-valid');
                $('#edit-modal').modal('show');


                $("#edit-form #quiz_id").val(response.quiz_id);
                $("#edit-form #class_id").val(response.class_id);
                $("#edit-form #chapter_id").val(response.chapter_id);
                $("#edit-form #subject_id").val(response.subject_id);
                $("#edit-form #question").val(response.question);
                $("#edit-form #one").val(response.one);
                $("#edit-form #two").val(response.two);
                $("#edit-form #three").val(response.three);
                $("#edit-form #four").val(response.four);
                $("#edit-form #correct_answer").val(response.correct_answer);
                $("#edit-form #status").val(response.status);

                // submit the edit from
                $.validator.setDefaults({
                    highlight: function (element) {
                        $(element).addClass('is-invalid').removeClass('is-valid');
                    },
                    unhighlight: function (element) {
                        $(element).removeClass('is-invalid').addClass('is-valid');
                    },
                    errorElement: 'div ',
                    errorClass: 'invalid-feedback',
                    errorPlacement: function (error, element) {
                        if (element.parent('.input-group').length) {
                            error.insertAfter(element.parent());
                        } else if ($(element).is('.select')) {
                            element.next().after(error);
                        } else if (element.hasClass('select2')) {
                            //error.insertAfter(element);
                            error.insertAfter(element.next());
                        } else if (element.hasClass('selectpicker')) {
                            error.insertAfter(element.next());
                        } else {
                            error.insertAfter(element);
                        }
                    },

                    submitHandler: function (form) {
                        var form = $('#edit-form');
                        $(".text-danger").remove();
                        $.ajax({
                            url: '<?php echo base_url($controller . '/edit') ?>',
                            type: 'post',
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
                                        $('#edit-modal').modal('hide');
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

                        return false;
                    }
                });
                $('#edit-form').validate();

            }
        });
    }

    function remove(quiz_id) {
        Swal.fire({
            title: 'Are you sure of the deleting process?',
            text: "You cannot back after confirmation",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel'
        }).then((result) => {

            if (result.value) {
                $.ajax({
                    url: '<?php echo base_url($controller . '/remove') ?>',
                    type: 'post',
                    data: {
                        quiz_id: quiz_id
                    },
                    dataType: 'json',
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
                            Swal.fire({
                                position: 'bottom-end',
                                icon: 'error',
                                title: response.messages,
                                showConfirmButton: false,
                                timer: 1500
                            })


                        }
                    }
                });
            }
        })
    }

    function get_subject(class_id){
        $.ajax({
            url: '<?php echo base_url($controller . '/get_subject') ?>',
            type: 'post',
            data: {
                class_id: class_id
            },
            success: function (response){
                $("#subject_id").html(response);
                $("#edit-form #subject_id").html(response);
                $("#subject_id_search").html(response);
            }
        });
    }

    function get_chapter(subject_id){
        $.ajax({
            url: '<?php echo base_url($controller . '/get_chapter') ?>',
            type: 'post',
            data: {
                subject_id: subject_id
            },
            success: function (response){
                $("#chapter_id").html(response);
                $("#edit-form #chapter_id").html(response);
                $("#chapter_id_search").html(response);
            }
        });
    }

    function chapter_quiz_Filter(){
        var subject_id_search = $("#subject_id_search").val();
        var chapter_id_search = $("#chapter_id_search").val();
        var classId = $("#class_id_search").val();

        if(classId == ''){
            $("#class_id_search").css('border','1px solid #ff0000');
        }else{
            $("#class_id_search").css('border','1px solid #ced4da');
        }

        if(subject_id_search == ''){
            $("#subject_id_search").css('border','1px solid #ff0000');
        }else{
            $("#subject_id_search").css('border','1px solid #ced4da');
        }

        if(chapter_id_search == ''){
            $("#chapter_id_search").css('border','1px solid #ff0000');
        }else{
            $("#chapter_id_search").css('border','1px solid #ced4da');

            $.ajax({
                url: '<?php echo base_url($controller . '/filter') ?>',
                type: 'post',
                data: {chapter_id:chapter_id_search},
                beforeSend: function () {
                    $('#filter').html('<i class="fa fa-spinner fa-spin"></i>');
                },
                success: function (date) {
                    $('#data_table').html(date);
                    $('#data_table_filter').hide();
                    $('#data_table_info').hide();
                    $('#data_table_paginate').hide();

                }
            });
        }
    }

</script>