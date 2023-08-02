<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Course Video</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Course Video</li>
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
                                <h3 class="card-title">Course Video List</h3>
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
                                    <label for="course_id">Course: </label>
                                    <select class="form-control text-capitalize" onchange="course_category(this.value)"
                                            id="course_id_search" required>
                                        <option value="">Please select</option>
                                        <?php echo getListInOption('', 'course_id', 'course_name', 'course') ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label for="chapter_id">Category: </label>
                                    <select class="form-control text-capitalize" id="courseCatId_search"
                                            required>
                                        <option value="">Please select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3" >
                                <button class="btn btn-primary btn-sm filter" onclick="course_video_Filter()" style="margin-top: 35px;">Filter</button>
                            </div>
                            <div class="col-md-3" ></div>
                        </div>
                        <table id="data_table" class="table table-bordered table-striped text-capitalize ">
                            <thead>
                            <tr>
                                <th width="60">Id</th>
                                <th>Course Name</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Hand Note</th>
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
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="text-center bg-info p-3">
                    <h4 class="modal-title text-white" id="info-header-modalLabel">Add</h4>
                </div>
                <div class="modal-body text-capitalize">
                    <form id="add-form" class="pl-3 pr-3" method="post" enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label for="course_id">Course: </label>
                                    <select class="form-control text-capitalize" onchange="course_category(this.value)"
                                            name="course_id" required>
                                        <option value="">Please select</option>
                                        <?php echo getListInOption('', 'course_id', 'course_name', 'course') ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label for="chapter_id">Category: </label>
                                    <select class="form-control text-capitalize" name="course_cat_id" id="courseCatId"
                                            required>
                                        <option value="">Please select</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title">Title: </label>
                                    <input type="text" class="form-control" name="title" required>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="author">Author: </label>
                                    <input type="text" class="form-control" name="author" required>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="URL">URL: </label>
                                    <input type="text" class="form-control" name="URL" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Hand  Note: </label>
                                    <input type="file" accept=".pdf," class="form-control" name="hand_note" >
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="thumb">thumb: </label>
                                    <input type="file" class="form-control" name="thumb" required>
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
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="text-center bg-info p-3">
                    <h4 class="modal-title text-white" id="info-header-modalLabel">Update</h4>
                </div>
                <div class="modal-body">
                    <form id="edit-form" class="pl-3 pr-3" method="post" enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label for="course_id">Course: </label>
                                    <select class="form-control text-capitalize" onchange="course_category(this.value)"
                                            name="course_id" id="course_id" required>
                                        <option value="">Please select</option>
                                        <?php echo getListInOption('', 'course_id', 'course_name', 'course') ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label for="chapter_id">Category: </label>
                                    <select class="form-control text-capitalize" name="course_cat_id" id="course_cat_id"
                                            required>
                                        <option value="">Please select</option>
                                        <?php echo getListInOption('', 'course_cat_id', 'category_name', 'course_category') ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title">Title: </label>
                                    <input type="text" class="form-control" name="title" id="title" required>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="author">Author: </label>
                                    <input type="text" class="form-control" name="author" id="author" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="URL">URL: </label>
                                    <input type="text" class="form-control" name="URL" id="URL" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Hand  Note: </label>
                                    <input type="file" accept=".pdf," class="form-control" name="hand_note" >
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group" id="thumb">
                                </div>
                                <div class="form-group">
                                    <label for="thumb">thumb: </label>
                                    <input type="file" class="form-control" name="thumb">
                                </div>
                            </div>

                        </div>

                        <div class="form-group text-center">
                            <div class="btn-group">
                                <input type="hidden" class="form-control" name="course_video_id" id="course_video_id"
                                       required>
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
                $.ajax({
                    url: "<?php echo base_url($controller . '/add') ?>",
                    method: "POST",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
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

    function edit(course_video_id) {
        $.ajax({
            url: '<?php echo base_url($controller . '/getOne') ?>',
            type: 'post',
            data: { course_video_id: course_video_id },
            //dataType: 'json',
            success: function (response) {
                // reset the form
                $("#edit-form")[0].reset();
                $(".form-control").removeClass('is-invalid').removeClass('is-valid');
                $('#edit-modal').modal('show');


                $("#edit-form #course_video_id").val(response.course_video_id);
                $("#edit-form #course_id").val(response.course_id);
                $("#edit-form #course_cat_id").val(response.course_cat_id);
                $("#edit-form #title").val(response.title);
                $("#edit-form #author").val(response.author);
                $("#edit-form #thumb").val(response.thumb);
                $("#edit-form #URL").val(response.URL);

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
                        $(".text-danger").remove();
                        $.ajax({
                                url: '<?php echo base_url($controller . '/edit') ?>',
                                method: "POST",
                                data: new FormData(form),
                                contentType: false,
                                cache: false,
                                processData: false,
                                dataType: "json",
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

    function remove(course_video_id) {
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
                        course_video_id: course_video_id
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

    function get_group(class_id) {
        $.ajax({
            url: '<?php echo base_url($controller . '/get_group') ?>',
            type: 'post',
            data: {
                class_id: class_id
            },
            success: function (response) {
                $("#groupId").html(response);
                // $("#edit-form #groupId").html(response);
            }
        });
    }

    function course_category(val) {
        $.ajax({
            url: '<?php echo base_url($controller . '/get_category') ?>',
            type: 'post',
            data: {course_id: val},
            success: function (response) {
                $("#courseCatId").html(response);
                $("#course_cat_id").html(response);
                $("#courseCatId_search").html(response);
                // $("#edit-form #groupId").html(response);
            }
        });
    }

    function course_video_Filter(){
        var course_id = $("#course_id_search").val();
        var courseCatId = $("#courseCatId_search").val();

        if(course_id == ''){
            $("#course_id_search").css('border','1px solid #ff0000');
        }else{
            $("#course_id_search").css('border','1px solid #ced4da');
        }

        if(courseCatId == ''){
            $("#courseCatId_search").css('border','1px solid #ff0000');
        }else{
            $("#courseCatId_search").css('border','1px solid #ced4da');

            $.ajax({
                url: '<?php echo base_url($controller . '/filter') ?>',
                type: 'post',
                data: {course_id:course_id,course_cat_id:courseCatId},
                beforeSend: function () {
                    $('.filter').html('<i class="fa fa-spinner fa-spin"></i>');
                },
                success: function (date) {
                    $('#data_table').html(date);
                    $('#data_table_filter').hide();
                    $('#data_table_info').hide();
                    $('#data_table_paginate').hide();
                    $('.filter').html('Filter');
                }
            });
        }
    }

</script>