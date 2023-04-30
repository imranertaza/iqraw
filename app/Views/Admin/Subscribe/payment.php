<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Course Subscribe</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Course Subscribe</li>
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
                                <h3 class="card-title">Course Subscribe List</h3>
                            </div>
                            <div class="col-md-4">
<!--                                <button type="button" class="btn btn-block btn-success" onclick="add()" title="Add"><i-->
<!--                                        class="fa fa-plus"></i> Add-->
<!--                                </button>-->

                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label for="course_id">Course: </label>
                                    <select class="form-control text-capitalize" onchange="course_category(this.value)" id="course_id_search" required>
                                        <option value="">Please select</option>
                                        <?php echo getListInOption('', 'course_id', 'course_name', 'course') ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3" >
                                <button class="btn btn-primary btn-sm filter" onclick="subscribe_Filter()" style="margin-top: 35px;">Filter</button>
                            </div>

                        </div>

                        <table id="data_table" class="table table-bordered table-striped text-capitalize ">
                            <thead>
                            <tr>
                                <th width="60">Id</th>
                                <th>Student Name</th>
                                <th>Course Name</th>
                                <th>Status</th>
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
    <!-- Add modal content -->
    <div id="add-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="text-center bg-info p-3">
                    <h4 class="modal-title text-white" id="info-header-modalLabel">Add</h4>
                </div>
                <div class="modal-body text-capitalize">
                    <form id="add-form" class="pl-3 pr-3">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Course name: </label>
                                    <input type="text" class="form-control" name="course_name" required>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="price">Price: </label>
                                    <input type="number" class="form-control" name="price" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label for="chapter_id">Class: </label>
                                    <select class="form-control text-capitalize" onchange="get_group(this.value)" name="class_id" >
                                        <option value="">Please select</option>
                                        <?php echo getListInOption('','class_id','name','class') ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="class_group_id">Class Group : </label>
                                    <select class="form-control"  name="class_group_id" id="groupId" >
                                        <option value="">Please select</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description: </label>
                                    <textarea class="form-control" name="description"  required></textarea>
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

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Course name: </label>
                                    <input type="text" class="form-control" name="course_name" id="course_name" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="price">Price: </label>
                                    <input type="number" class="form-control" name="price" id="price" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label for="chapter_id">Class: </label>
                                    <select class="form-control text-capitalize" onchange="get_group(this.value)" name="class_id" id="class_id" >
                                        <option value="">Please select</option>
                                        <?php echo getListInOption('','class_id','name','class') ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="class_group_id">Class Group : </label>
                                    <select class="form-control"  name="class_group_id" id="class_group_id" >
                                        <option value="">Please select</option>
                                        <?php echo getListInOption('','class_group_id','group_name','class_group') ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description: </label>
                                    <textarea class="form-control" name="description" id="description3" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <div class="btn-group">
                                <input type="hidden" class="form-control" name="course_id" id="course_id" required>
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

    function subscribe_Filter(){
        var course_id_search = $("#course_id_search").val();

        if(course_id_search == ''){
            $("#course_id_search").css('border','1px solid #ff0000');
        }else{
            $("#course_id_search").css('border','1px solid #ced4da');

            $.ajax({
                url: '<?php echo base_url($controller . '/filter') ?>',
                type: 'post',
                data: {course_id:course_id_search},
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