<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Course Video Create</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Course Video</li>
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
                                <h3 class="card-title">Course Video Create</h3>
                            </div>
                            <div class="col-md-4">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header id="add-form" -->
                    <div class="card-body">
                    <form id="add-form" action="<?php echo base_url($controller . '/add') ?>" class="pl-3 pr-3" method="post" enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="course_id">Course: </label>
                                    <select class="form-control text-capitalize" onchange="course_category(this.value)"
                                            name="course_id" required>
                                        <option value="">Please select</option>
                                        <?php echo getListInOption('', 'course_id', 'course_name', 'course') ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="chapter_id">Category: </label>
                                    <select class="form-control text-capitalize" name="course_cat_id" id="courseCatId"
                                            required>
                                        <option value="">Please select</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 " >
                                <div class="optionBox row">
                                    <div class="item col-md-12">
                                        <a href="javascript:void(0)" class="add btn btn-primary " style="float: right;" >Add video</a>
                                    </div>
                                    <div class="item col-md-12 row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="title">Title: </label>
                                                <input type="text" class="form-control" name="title[]" required>
                                            </div>
                                        </div>


                                        <div class="col">
                                            <div class="form-group">
                                                <label for="author">Author: </label>
                                                <input type="text" class="form-control" name="author[]" required>
                                            </div>
                                        </div>


                                        <div class="col">
                                            <div class="form-group">
                                                <label for="URL">URL: </label>
                                                <input type="text" class="form-control" name="URL[]" required>
                                            </div>
                                        </div>
                                        

                                        <div class="col">
                                            <div class="form-group">
                                                <label for="thumb">thumb: </label>
                                                <input type="file" class="form-control" name="thumb[]" required>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group col">
                                            <a href="javascript:void(0)" class="btn btn-danger" onclick="removeItem(this)" style="margin-top: 30px;" >Remove</a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            

                        </div>


                        <div class="form-group text-center">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success" id="add-form-btn">Add</button>
                                <a href="<?php echo base_url($controller) ?>" class="btn btn-danger" data-dismiss="modal">Cancel</a>
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
   
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    $('.add').click(function() {
        var temp = `<div class="item col-md-12 row">
                        <div class="col">
                            <div class="form-group">
                                <label for="title">Title: </label>
                                <input type="text" class="form-control" name="title[]" required>
                            </div>
                        </div>


                        <div class="col">
                            <div class="form-group">
                                <label for="author">Author: </label>
                                <input type="text" class="form-control" name="author[]" required>
                            </div>
                        </div>


                        <div class="col">
                            <div class="form-group">
                                <label for="URL">URL: </label>
                                <input type="text" class="form-control" name="URL[]" required>
                            </div>
                        </div>
                        

                        <div class="col">
                            <div class="form-group">
                                <label for="thumb">thumb: </label>
                                <input type="file" class="form-control" name="thumb[]" required>
                            </div>
                        </div>
                        
                        <div class="form-group col">
                            <a href="javascript:void(0)" class="btn btn-danger" onclick="removeItem(this)" style="margin-top: 30px;" >Remove</a>
                        </div>
                        
                    </div>`;
        $('.optionBox').append(temp);
    });

    function removeItem(item){
        $(item).parent().parent().remove();
    }


    $("#add-form").submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');

        var formd = $('#add-form')[0];
        var data = new FormData(formd);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: url,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
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
                $("#add-form")[0].reset();
            }
        });
    });

    

    function get_group(class_id) {
        $.ajax({
            url: '<?php echo base_url($controller . '/get_group') ?>',
            type: 'post',
            data: {
                class_id: class_id
            },
            success: function (response) {
                $("#groupId").html(response);
                // $("#edit-form #groupId").html(response);
            }
        });
    }

    function course_category(val) {
        $.ajax({
            url: '<?php echo base_url($controller . '/get_category') ?>',
            type: 'post',
            data: {course_id: val},
            success: function (response) {
                $("#courseCatId").html(response);
                $("#course_cat_id").html(response);
                $("#courseCatId_search").html(response);
                // $("#edit-form #groupId").html(response);
            }
        });
    }

    

</script>