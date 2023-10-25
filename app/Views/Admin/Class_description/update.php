<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Class Description Update</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Class Description Update</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content" id="reload">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8 mt-2">
                                <h3 class="card-title">Class Description Update</h3>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="edit-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="chapter_id">Class: </label>
                                        <select class="form-control text-capitalize" name="class_group_jnt_id"
                                                id="class_group_jnt_id" required>
                                            <option value="">Please select</option>
                                            <?php foreach ($class_group as $group) { ?>
                                                <option value="<?php echo $group->class_group_jnt_id ?>" <?php echo ($desc->class_group_jnt_id == $group->class_group_jnt_id) ? 'selected' : ''; ?> ><?php echo get_data_by_id('name', 'class', 'class_id', $group->class_id);
                                                    echo (!empty($group->class_group_id)) ? ' -> ' . get_data_by_id('group_name', 'class_group', 'class_group_id', $group->class_group_id) : ''; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="chapter_id">Title: </label>
                                        <input type="text" class="form-control" name="title" placeholder="Title"
                                               value="<?php echo $desc->title; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="chapter_id">Short Description: </label>
                                        <textarea class="form-control" rows="6" name="short_description"
                                                  placeholder="Short Description"
                                                  required><?php echo $desc->short_description; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="chapter_id">Description: </label>
                                        <textarea class="form-control" rows="6" name="description"
                                                  placeholder="Description"><?php echo $desc->description; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="chapter_id">Feature Details: </label>
                                        <textarea class="form-control" rows="6" name="feature_details"
                                                  placeholder="Feature Details"
                                                  required><?php echo $desc->feature_details; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="chapter_id">Video: </label>
                                        <input type="text" class="form-control" name="video" placeholder="Video Url"
                                               value="<?php echo $desc->video; ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="chapter_id">For Who: </label>
                                        <textarea class="form-control" name="for_who" id="description"
                                                  placeholder="For Who" required><?php echo $desc->for_who; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="chapter_id">For Why: </label>
                                        <textarea class="form-control" name="for_why" id="description2"
                                                  placeholder="For Why" required><?php echo $desc->for_why; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="chapter_id">What Is Included: </label>
                                        <textarea class="form-control" name="what_is_included" id="description3"
                                                  placeholder="What Is Included" required><?php echo $desc->what_is_included; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="chapter_id">Syllabus: </label>
                                        <textarea class="form-control" name="syllabus" id="description4" placeholder="Syllabus" required><?php echo $desc->syllabus; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="chapter_id">Faq: </label>
                                        <textarea class="form-control" name="faq" id="description5" placeholder="Faq" required><?php echo $desc->faq; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <input type="hidden" name="class_des_id" value="<?php echo $desc->class_des_id; ?>"
                                           required>
                                    <button type="submit" class="btn btn-success" onclick="edit()" id="edit-form-btn">
                                        Update
                                    </button>
                                    <a href="<?php echo base_url($controller) ?>" class="btn btn-danger"
                                       id="edit-form-btn">Cancel</a>
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
                    url: '<?php echo base_url($controller . '/create_action') ?>',
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
                            })
                            $("#reload").load(location.href + " #reload");

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

    function edit() {
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
                    url: '<?php echo base_url($controller . '/update_action') ?>',
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


</script>