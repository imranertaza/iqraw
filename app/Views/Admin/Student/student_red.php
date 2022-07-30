<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Student View</h1>
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
                                <h3 class="card-title">Student View</h3>
                            </div>
                            <div class="col-md-4">


                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-12 text-center mb-5" id="imgRelode">
                                <?php if (!empty($student->pic)){ ?>
                                <img class="rounded-circle" src="<?php echo base_url()?>/assets/upload/profile/<?php echo $student->std_id?>/<?php echo $student->pic?>" alt="">
                                <?php } ?>
                            </div>

                            <div class="col-md-4 mt-4 text-center">
                                <div class="form-group">
                                    <label for="name"> Institute </label>
                                    <p><?php echo $student->institute?></p>
                                </div>
                            </div>

                            <div class="col-md-4 mt-4 text-center">
                                <div class="form-group">
                                    <label for="name"> Class </label>
                                    <p><?php echo get_data_by_id('name','class','class_id',$student->class_id) ;?></p>
                                </div>
                            </div>

                            <div class="col-md-4 mt-4 text-center">
                                <div class="form-group">
                                    <label for="name"> Group</label>
                                    <p><?php echo $student->class_group?></p>
                                </div>
                            </div>

                            <div class="col-md-4 mt-4 text-center">
                                <div class="form-group">
                                    <label for="name"> Total point </label>
                                    <p><?php echo $student->point?></p>
                                </div>
                            </div>
                            <div class="col-md-4 mt-4 text-center">
                                <div class="form-group">
                                    <label for="father_name"> Coin </label>
                                    <p><?php echo $student->coin?></p>
                                </div>
                            </div>
                            <div class="col-md-4 mt-4 text-center">
                                <div class="form-group">
                                    <label for="father_name"> Top Batch </label><br>
                                    <img src="<?php base_url();?>/assets/image/1st.svg" alt="profile" class="lab-bat">
                                </div>
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