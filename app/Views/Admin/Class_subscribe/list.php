<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Class Subscribe</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Class Subscribe</li>
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
                                <h3 class="card-title">Class Subscribe</h3>

                            </div>
                            <div class="col-md-4">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row" >
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label for="course_id">Start Date: </label>
                                    <input type="date" id="st_date" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label for="course_id">End Date: </label>
                                    <input type="date" id="end_date" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary btn-sm filter" onclick="class_sub_Filter()" style="margin-top: 35px;">Filter</button>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        <table id="data_table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Class Subscribe id</th>
                                <th>Student</th>
                                <th>Class</th>
                                <th>Class Group</th>
                                <th>Subscribe End Date</th>
                                <th>status</th>
<!--                                <th>Action</th>-->
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
                "url": '<?php echo base_url($controller.'/getAll') ?>',
                "type": "POST",
                "dataType": "json",
                async: "true"
            }
        });
    });

    function class_sub_Filter(){
        var st_date = $("#st_date").val();
        var end_date = $("#end_date").val();

        if(st_date == ''){
            $("#st_date").css('border','1px solid #ff0000');
        }else{
            $("#st_date").css('border','1px solid #ced4da');
        }

        if(end_date == ''){
            $("#end_date").css('border','1px solid #ff0000');
        }else{
            $("#end_date").css('border','1px solid #ced4da');

            $.ajax({
                url: '<?php echo base_url($controller . '/filter') ?>',
                type: 'post',
                data: {st_date:st_date,end_date:end_date},
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