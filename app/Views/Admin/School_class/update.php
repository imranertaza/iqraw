<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Class Update</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Class Update</li>
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
                                <h3 class="card-title">Class List</h3>
                            </div>
                            <div class="col-md-4">


                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="edit-form" class="pl-3 pr-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Class Name: </label>
                                        <input type="text" class="form-control" name="name" id="name"
                                               value="<?php echo $class->name; ?>" required>
                                        <input type="hidden" class="form-control" name="class_id" id="class_id"
                                               value="<?php echo $class->class_id; ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status: </label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="">please select</option>
                                            <?php echo globalStatus($class->status) ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Class Group: </label>
                                    </div>
                                </div>
                                <?php $i = 1; $j = 1;  foreach ($group as $key => $val) { ?>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="group_id[]"
                                                   value="<?php echo $val->class_group_id ?>" <?php if (!empty($classGroup)){ foreach ($classGroup as $gr){ echo ($val->class_group_id == $gr->class_group_id)?'checked':''; }} ?> id="flexCheckDefault_<?php echo $i++ ?>">
                                            <label class="form-check-label"
                                                   for="flexCheckDefault_<?php echo $j++ ?>"><?php echo $val->group_name ?></label>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="form-group text-center mt-4">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-success" onclick="edit()" id="edit-form-btn">
                                        Update
                                    </button>
                                    <a href="<?php echo base_url($controller) ?>" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</a>
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
        $("#edit-form").submit(function(e) {
            e.preventDefault();
            var form = $(this);
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
        });

    }
</script>