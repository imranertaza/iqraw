<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User Roll Update</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">User Roll Update</li>
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
                                <h3 class="card-title">User Roll Update</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="edit-form" method="post" class="pl-3 pr-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="role">Roll Name: </label>
                                        <input type="text" class="form-control" name="role"
                                               value="<?php echo $roll->role ?>" required>
                                        <input type="hidden" class="form-control" name="role_id" id="role_id"
                                               value="<?php echo $roll->role_id ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="class_id">Permission: </label>
                                        <ol>
                                            <?php foreach (json_decode($roll->permission) as $key => $value) { ?>
                                                <li><?php echo $key; ?>
                                                    <?php foreach ($value as $k => $v) {
                                                        $isChecked = ($v == 1) ? 'checked="checked"' : ''; ?>
                                                        <div class="form-check">
                                                            <label> <input class="form-check-input" <?php echo $isChecked; ?> type="checkbox" name="permission[<?php print $key; ?>][<?php print $k; ?>]" value="1"><?php echo $k ?></label>
                                                        </div>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-success" id="edit-form-btn">Update</button>
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


</div>
<!-- /.content-wrapper -->
<script>

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


</script>