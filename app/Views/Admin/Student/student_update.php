<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Student Update</h1>
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
                                <h3 class="card-title">Student Update</h3>
                            </div>
                            <div class="col-md-4">


                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="edit-form" method="post" enctype="multipart/form-data" class="pl-3 pr-3">
                            <div class="row">

                                <div class="col-md-12 text-center" id="imgRelode">
                                    <?php if (!empty($student->pic)) { ?>
                                        <img class="rounded-circle"
                                             src="<?php echo base_url() ?>/assets/upload/profile/<?php echo $student->std_id ?>/<?php echo $student->pic ?>"
                                             alt="">
                                    <?php } ?>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name"> Name: </label>
                                        <input type="text" class="form-control" name="name" id="name"
                                               value="<?php echo $student->name; ?>" required>
                                        <input type="hidden" class="form-control" name="std_id" id="std_id"
                                               value="<?php echo $student->std_id; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="father_name"> Father Name: </label>
                                        <input type="text" class="form-control" name="father_name" id="father_name"
                                               value="<?php echo $student->father_name; ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Address: </label>
                                        <input type="text" class="form-control" name="address" id="address"
                                               value="<?php echo $student->address; ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="school_name"> School Name: </label>
                                        <input type="text" class="form-control" name="school_name" id="school_name"
                                               value="<?php echo $student->school_name; ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="gender"> Gender: </label>
                                            <select class="form-control" name="gender" id="gender"
                                                    style="margin-right: 5px;" required>
                                                <option value="">Select</option>
                                                <option value="Male" <?php echo ($student->gender == 'Male') ? 'selected' : ''; ?> >
                                                    Male
                                                </option>
                                                <option value="Female" <?php echo ($student->gender == 'Female') ? 'selected' : ''; ?>>
                                                    Female
                                                </option>
                                                <option value="Unisex" <?php echo ($student->gender == 'Unisex') ? 'selected' : ''; ?>>
                                                    Unisex
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="religion"> Religion: </label>
                                            <select class="form-control" name="religion" id="religion"
                                                    style="margin-left: 5px;" required>
                                                <option value="">Select</option>
                                                <option value="Islam" <?php echo ($student->religion == 'Islam') ? 'selected' : ''; ?>>
                                                    Islam
                                                </option>
                                                <option value="Hindu" <?php echo ($student->religion == 'Hindu') ? 'selected' : ''; ?>>
                                                    Hindu
                                                </option>
                                                <option value="Christian" <?php echo ($student->religion == 'Christian') ? 'selected' : ''; ?>>
                                                    Christian
                                                </option>
                                                <option value="Buddhism" <?php echo ($student->religion == 'Buddhism') ? 'selected' : ''; ?>>
                                                    Buddhism
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="class_id"> Class: </label>
                                            <select class="form-control" name="class_id" id="class_id" onchange="viewGroup(this.value)" required>
                                                <option value="">Please select</option>
                                                <?php echo getListInOption($student->class_id, 'class_id', 'name', 'class'); ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="age"> Age: </label>
                                            <input type="number" class="form-control" name="age" id="age"
                                                   value="<?php echo $student->age; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone"> Phone: </label>
                                        <input type="number" class="form-control" name="phone" id="phone"
                                               value="<?php echo $student->phone; ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password"> Password: </label>
                                        <input type="number" class="form-control" name="password">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password"> Image:</label>
                                        <input type="file" class="form-control" name="pic">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password"> Status: </label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="">Please select</option>
                                            <?php echo globalStatus($student->status) ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-4">
                                    <ul class="nav nav-tabs nav-fill sut-t">
                                        <?php foreach ($education as $key => $val){ ?>
                                            <li class="nav-item ">
                                                <input type="radio" class="d-none"  name="institute" <?php echo ($key == 0)?'id="btnr1"':'id="btnr2"';?> <?php echo ($val->edu_type_id == $student->edu_type_id)?'checked="checked"':'';?>   value="<?php echo $val->edu_type_id;?>" />
                                                <a class="nav-link <?php echo ($val->edu_type_id == $student->edu_type_id)?'active':'';?>" data-toggle="tab" <?php echo ($key == 0)?'onclick="checkInst()"':'onclick="checkInst2()"';?> href="#home"><?php echo $val->type_name;?></a>
                                            </li>
                                        <?php } ?>


                                    </ul>

                                    <div class="tab-content mt-4" id="gorupview">
                                    <?php if (!empty($student->class_group_id)){ ?>
                                        <h4>Class Group</h4>
                                        <div class="btn-group mt-4 required">
                                            <?php $i=1; $j=1; foreach ($group as $val){ $sel = ($val->class_group_id == $student->class_group_id )?'checked':''; ?>
                                            <input type="radio" class="btn-check" name="class_group" id="option_<?php echo $i++;?>"
                                                   autocomplete="off" value="<?php echo $val->class_group_id;?>" <?php echo $sel; ?> />
                                            <label class=" btn-css" for="option_<?php echo $j++;?>"><?php echo $val->group_name;?></label>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                    </div>

                                </div>

                            </div>

                            <div class="form-group text-center mt-3">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-success" onclick="edit()" id="edit-form-btn">
                                        Update
                                    </button>
                                    <a href="<?php echo base_url() ?>/Admin/Student" type="button"
                                       class="btn btn-danger" data-dismiss="modal">Cancel</a>
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

    function edit() {
        $('#edit-form').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "<?php echo base_url($controller . '/update_action') ?>",
                method: "POST",
                data: new FormData(this),
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
                            document.getElementById("update-image").reset();
                            $('#imgRelode').load(document.URL + ' #imgRelode');
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
    }

    function viewGroup(class_id){
        $.ajax({
            url: '<?php echo base_url($controller . '/classGroup') ?>',
            type: 'post',
            data: {class_id:class_id},
            success: function (response) {
                $("#gorupview").html(response);
            }
        });
    }


    function checkInst() {
        $("#btnr2").attr('checked', false);
        $("#btnr1").attr('checked', true);
    }

    function checkInst2() {
        $("#btnr1").attr('checked', false);
        $("#btnr2").attr('checked', true);
    }
</script>