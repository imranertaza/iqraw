<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Student Test</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Student Test</li>
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
                                <h3 class="card-title">Student Test list</h3>
                            </div>
                            <div class="col-md-4">

                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-3">
                                <h4>Chapter Test</h4>

                                <table class="table table-bordered table-striped text-capitalize">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Result</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($chapExam as $ch){ ?>
                                        <tr>
                                            <td><?php echo get_data_by_id('name','chapter','chapter_id',$ch->chapter_id) ?></td>
                                            <td><?php echo $ch->correct_answers;?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <h4>Quiz</h4>

                                <table class="table table-bordered table-striped text-capitalize">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Result</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($quizExam as $qz){ ?>
                                        <tr>
                                            <td><?php echo get_data_by_id('quiz_name','quiz_exam_info','quiz_exam_info_id',$qz->quiz_exam_info_id) ?></td>
                                            <td><?php echo $qz->correct_answers;?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <h4>Skill Development</h4>

                                <table class="table table-bordered table-striped text-capitalize">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Result</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($mcqExam as $mc){ ?>
                                        <tr>
                                            <td><?php echo get_data_by_id('title','skill_video','skill_video_id',$mc->skill_video_id) ?></td>
                                            <td><?php echo $mc->correct_answers;?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-3">
                                <h4>Vocabulary</h4>

                                <table class="table table-bordered table-striped text-capitalize">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Result</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($vocExam as $voc){ ?>
                                        <tr>
                                            <td><?php echo get_data_by_id('title','vocabulary_exam','voc_exam_id',$voc->voc_exam_id) ?></td>
                                            <td><?php echo $voc->correct_answers;?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
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
                        }).then(function() {
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



    function checkInst(){
        $("#btnr2").attr('checked', false);
        $("#btnr1").attr('checked', true);
    }
    function checkInst2(){
        $("#btnr1").attr('checked', false);
        $("#btnr2").attr('checked', true);
    }
</script>