<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Vocabulary Exam Update</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Vocabulary Update</li>
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
                                <h3 class="card-title">Vocabulary Exam Update</h3>
                            </div>
                            <div class="col-md-4">

                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form id="edit-form" action="<?php echo base_url($controller . '/edit') ?>" method="post" class="pl-3 pr-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="title">Title: </label>
                                                <input type="text" class="form-control" name="title" id="title" value="<?php echo $exam->title;?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="published_date">Published date: </label>
                                                <input type="date" class="form-control" name="published_date" value="<?php echo $exam->published_date;?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="title">Status: </label>

                                                <select class="form-control" name="status" required>
                                                    <option value="" >Please Select</option>
                                                    <option value="Published" <?php echo ($exam->status == 'Published')?'selected':''; ?> >Published</option>
                                                    <option value="Unpublished" <?php echo ($exam->status == 'Unpublished')?'selected':''; ?> >Unpublished</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <p>Please select Question</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <?php
                                            $i=1; $j=1; foreach ($quiz as $val){
                                            $sle = '';
                                            foreach ($quizData as $q){
                                                if ($q->voc_quiz_id == $val->voc_quiz_id){
                                                    $sle = 'checked';
                                                }
                                            }
                                        ?>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" <?php echo $sle;?> type="checkbox" name="voc_quiz_id[]" value="<?php echo $val->voc_quiz_id?>" id="flexCheckDefault_<?php echo $i++?>">
                                                    <label class="form-check-label" for="flexCheckDefault_<?php echo $j++?>"><?php echo $val->question?></label>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <div class="form-group text-center mt-5">
                                        <div class="btn-group">
                                            <input type="hidden" name="voc_exam_id" id="voc_exam_id" value="<?php echo $exam->voc_exam_id;?>" >
                                            <button type="submit" class="btn btn-success" id="edit-form-btn">Update</button>
                                            <a href="<?php echo base_url($controller) ?>" type="button" class="btn btn-danger" >Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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


    function edit(voc_exam_id) {

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




</script>