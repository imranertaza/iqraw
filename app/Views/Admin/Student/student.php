<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Student</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Student</li>
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
                                <h3 class="card-title">Student List</h3>
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
                        <table id="data_table" class="table table-bordered table-striped text-capitalize ">
                            <thead>
                            <tr>
                                <th width="60">Id</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>School Name</th>
                                <th>Class</th>
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
                                <div class="form-group">
                                    <label for="name"> Name: </label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="father_name"> Father Name: </label>
                                    <input type="text" class="form-control" name="father_name" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address: </label>
                                    <input type="text" class="form-control" name="address" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="school_name"> School Name: </label>
                                    <input type="text" class="form-control" name="school_name" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="gender"> Gender: </label>
                                        <select class="form-control" name="gender" id="gender"
                                                style="margin-right: 5px;" required>
                                            <option value="">Select</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="Unisex">Unisex</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="religion"> Religion: </label>
                                        <select class="form-control" name="religion" id="religion"
                                                style="margin-left: 5px;" required>
                                            <option value="">Select</option>
                                            <option value="Islam" >Islam</option>
                                            <option value="Hindu" >Hindu</option>
                                            <option value="Christian" >Christian</option>
                                            <option value="Buddhism" >Buddhism</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="class_id"> Class: </label>
                                        <select class="form-control" name="class_id" id="class_id" required>
                                            <option value="">Please select</option>
                                            <?php echo getListInOption('', 'class_id', 'name', 'class'); ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="age"> Age: </label>
                                        <input type="number" class="form-control" name="age" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone"> Phone: </label>
                                    <input type="number" class="form-control" name="phone" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password"> Password: </label>
                                    <input type="number" class="form-control" name="password" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-fill sut-t">
                                    <li class="nav-item ">
                                        <input type="radio" class="d-none"  name="institute" id="btnr1"   value="School" />
                                        <a class="nav-link active" data-toggle="tab" onclick="checkInst()" href="#home">School</a>
                                    </li>
                                    <li class="nav-item">
                                        <input type="radio" class="d-none" name="institute" id="btnr2"   value="Madrasha" />
                                        <a class="nav-link " data-toggle="tab" onclick="checkInst2()" href="#menu1">Madrasah</a>
                                    </li>

                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div id="home" class="container tab-pane active"><br>
                                        <h4>School</h4>
                                        <div class="btn-group mt-4 required">
                                            <input type="radio" class="btn-check" name="class_group" id="option1" autocomplete="off"  value="science" checked/>
                                            <label class=" btn-css" for="option1">Science</label>

                                            <input type="radio" class="btn-check" name="class_group" id="option2" autocomplete="off" value="commerce"/>
                                            <label class=" btn-css" for="option2">Commerce</label>

                                            <input type="radio" class="btn-check" name="class_group" id="option3" autocomplete="off" value="arts"/>
                                            <label class=" btn-css" for="option3">Arts</label>
                                        </div>
                                    </div>
                                    <div id="menu1" class="container tab-pane fade"><br>
                                        <h4>Madrasah</h4>
                                        <div class="btn-group mt-4">
                                            <input type="radio" class="btn-check" name="class_group" id="option4" autocomplete="off"  value="science"/>
                                            <label class=" btn-css" for="option4">Science</label>

                                            <input type="radio" class="btn-check" name="class_group" id="option5" autocomplete="off" value="commerce"/>
                                            <label class=" btn-css" for="option5">Commerce</label>

                                            <input type="radio" class="btn-check" name="class_group" id="option6" autocomplete="off" value="arts"/>
                                            <label class=" btn-css" for="option6">Arts</label>
                                        </div>


                                    </div>
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
                    <form id="edit-form" class="pl-3 pr-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name"> Name: </label>
                                    <input type="text" class="form-control" name="name" id="name" required>
                                    <input type="hidden" class="form-control" name="std_id" id="std_id" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="father_name"> Father Name: </label>
                                    <input type="text" class="form-control" name="father_name" id="father_name" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address: </label>
                                    <input type="text" class="form-control" name="address" id="address" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="school_name"> School Name: </label>
                                    <input type="text" class="form-control" name="school_name" id="school_name" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="gender"> Gender: </label>
                                        <select class="form-control" name="gender" id="gender"
                                                style="margin-right: 5px;" required>
                                            <option value="">Select</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="religion"> Religion: </label>
                                        <select class="form-control" name="religion" id="religion"
                                                style="margin-left: 5px;" required>
                                            <option value="">Select</option>
                                            <option value="islam">Islam</option>
                                            <option value="hindu">Hindu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="class_id"> Class: </label>
                                        <select class="form-control" name="class_id" id="class_id" required>
                                            <option value="">Please select</option>
                                            <?php echo getListInOption('', 'class_id', 'name', 'class'); ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="age"> Age: </label>
                                        <input type="number" class="form-control" name="age" id="age" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone"> Phone: </label>
                                    <input type="number" class="form-control" name="phone" id="phone" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password"> Password: </label>
                                    <input type="number" class="form-control" name="password" required>
                                </div>
                            </div>

                            <div class="col-md-12" id="inst">
                                <ul class="nav nav-tabs nav-fill sut-t">
                                    <li class="nav-item ">
                                        <input type="radio" class="d-none"  name="institute" id="btnr1"   value="School" />
                                        <a class="nav-link active" data-toggle="tab" onclick="checkInst()" href="#home">School</a>
                                    </li>
                                    <li class="nav-item">
                                        <input type="radio" class="d-none" name="institute" id="btnr2"   value="Madrasha" />
                                        <a class="nav-link " data-toggle="tab" onclick="checkInst2()" href="#menu1">Madrasah</a>
                                    </li>

                                </ul>
                                <div class="tab-content">
                                    <div id="home" class="container tab-pane active"><br>
                                        <h4>School</h4>
                                        <div class="btn-group mt-4 required">
                                            <input type="radio" class="btn-check" name="class_group" id="option1" autocomplete="off"  value="science" checked/>
                                            <label class=" btn-css" for="option1">Science</label>

                                            <input type="radio" class="btn-check" name="class_group" id="option2" autocomplete="off" value="commerce"/>
                                            <label class=" btn-css" for="option2">Commerce</label>

                                            <input type="radio" class="btn-check" name="class_group" id="option3" autocomplete="off" value="arts"/>
                                            <label class=" btn-css" for="option3">Arts</label>
                                        </div>
                                    </div>
                                    <div id="menu1" class="container tab-pane fade"><br>
                                        <h4>Madrasah</h4>
                                        <div class="btn-group mt-4">
                                            <input type="radio" class="btn-check" name="class_group" id="option4" autocomplete="off"  value="science"/>
                                            <label class=" btn-css" for="option4">Science</label>

                                            <input type="radio" class="btn-check" name="class_group" id="option5" autocomplete="off" value="commerce"/>
                                            <label class=" btn-css" for="option5">Commerce</label>

                                            <input type="radio" class="btn-check" name="class_group" id="option6" autocomplete="off" value="arts"/>
                                            <label class=" btn-css" for="option6">Arts</label>
                                        </div>


                                    </div>
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

    //function edit(std_id) {
    //    $.ajax({
    //        url: '<?php //echo base_url($controller . '/getOne') ?>//',
    //        type: 'post',
    //        data: {
    //            std_id: std_id
    //        },
    //        //dataType: 'json',
    //        success: function (response) {
    //            // reset the form
    //            $("#edit-form")[0].reset();
    //            $(".form-control").removeClass('is-invalid').removeClass('is-valid');
    //            $('#edit-modal').modal('show');
    //
    //
    //            $("#edit-form #std_id").val(response.std_id);
    //            $("#edit-form #name").val(response.name);
    //            $("#edit-form #start_date").val(response.start_date);
    //            $("#edit-form #end_date").val(response.end_date);
    //
    //            // submit the edit from
    //            $.validator.setDefaults({
    //                highlight: function (element) {
    //                    $(element).addClass('is-invalid').removeClass('is-valid');
    //                },
    //                unhighlight: function (element) {
    //                    $(element).removeClass('is-invalid').addClass('is-valid');
    //                },
    //                errorElement: 'div ',
    //                errorClass: 'invalid-feedback',
    //                errorPlacement: function (error, element) {
    //                    if (element.parent('.input-group').length) {
    //                        error.insertAfter(element.parent());
    //                    } else if ($(element).is('.select')) {
    //                        element.next().after(error);
    //                    } else if (element.hasClass('select2')) {
    //                        //error.insertAfter(element);
    //                        error.insertAfter(element.next());
    //                    } else if (element.hasClass('selectpicker')) {
    //                        error.insertAfter(element.next());
    //                    } else {
    //                        error.insertAfter(element);
    //                    }
    //                },
    //
    //                submitHandler: function (form) {
    //                    var form = $('#edit-form');
    //                    $(".text-danger").remove();
    //                    $.ajax({
    //                        url: '<?php //echo base_url($controller . '/edit') ?>//',
    //                        type: 'post',
    //                        data: form.serialize(),
    //                        dataType: 'json',
    //                        beforeSend: function () {
    //                            $('#edit-form-btn').html('<i class="fa fa-spinner fa-spin"></i>');
    //                        },
    //                        success: function (response) {
    //
    //                            if (response.success === true) {
    //
    //                                Swal.fire({
    //                                    position: 'bottom-end',
    //                                    icon: 'success',
    //                                    title: response.messages,
    //                                    showConfirmButton: false,
    //                                    timer: 1500
    //                                }).then(function () {
    //                                    $('#data_table').DataTable().ajax.reload(null, false).draw(false);
    //                                    $('#edit-modal').modal('hide');
    //                                })
    //
    //                            } else {
    //
    //                                if (response.messages instanceof Object) {
    //                                    $.each(response.messages, function (index, value) {
    //                                        var id = $("#" + index);
    //
    //                                        id.closest('.form-control')
    //                                            .removeClass('is-invalid')
    //                                            .removeClass('is-valid')
    //                                            .addClass(value.length > 0 ? 'is-invalid' : 'is-valid');
    //
    //                                        id.after(value);
    //
    //                                    });
    //                                } else {
    //                                    Swal.fire({
    //                                        position: 'bottom-end',
    //                                        icon: 'error',
    //                                        title: response.messages,
    //                                        showConfirmButton: false,
    //                                        timer: 1500
    //                                    })
    //
    //                                }
    //                            }
    //                            $('#edit-form-btn').html('Update');
    //                        }
    //                    });
    //
    //                    return false;
    //                }
    //            });
    //            $('#edit-form').validate();
    //
    //        }
    //    });
    //}

    function remove(std_id) {
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
                        std_id: std_id
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

    function checkInst(){
        $("#btnr2").attr('checked', false);
        $("#btnr1").attr('checked', true);
    }
    function checkInst2(){
        $("#btnr1").attr('checked', false);
        $("#btnr2").attr('checked', true);
    }
    $( document ).ready(function() {
        $("#btnr1").attr('checked', true);
    });
</script>