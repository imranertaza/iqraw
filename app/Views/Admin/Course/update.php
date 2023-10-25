<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Course update</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Course</li>
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
                                <h3 class="card-title">Course update</h3>
                            </div>
                            <div class="col-md-4">

                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data" >
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Course name: </label>
                                        <input type="text" class="form-control" name="course_name" value="<?php echo $course->course_name;?>" required>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price">Price: </label>
                                        <input type="number" class="form-control" name="price" value="<?php echo $course->price;?>" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="chapter_id">Class: </label>
                                        <select class="form-control text-capitalize" onchange="get_group(this.value)"
                                                name="class_id">
                                            <option value="">Please select</option>
                                            <?php echo getListInOption($course->class_id, 'class_id', 'name', 'class') ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="class_group_id">Class Group : </label>
                                        <select class="form-control" name="class_group_id" id="groupId">
                                            <option value="">Please select</option>
                                            <?php echo getClassIdByGroupListInOption($course->class_group_id,$course->class_id);?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="class_id">Education Type: </label>
                                        <select class="form-control" name="edu_type_id" >
                                            <option value="">Please select</option>
                                            <?php echo getListInOption($course->edu_type_id,'edu_type_id','type_name','education_type') ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description">Image: </label>
                                        <input type="file" class="form-control" name="image" required>
                                        <small>Size: 1116x500</small>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description: </label>
                                        <textarea class="form-control" name="description" id="description" required><?php echo $course->description;?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12" >
                                    <h3 class="card-title">Video</h3>
                                    <br><hr>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="chapter_id">Category: </label>
                                        <select class="form-control text-capitalize" name="course_cat_id" id="courseCatId"
                                                required>
                                            <?php echo course_category_by_course_id($courseVideo->course_cat_id,$course->course_id);?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Title: </label>
                                        <input type="text" class="form-control" name="title" value="<?php echo $courseVideo->title;?>" required>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="author">Author: </label>
                                        <input type="text" class="form-control" name="author" value="<?php echo $courseVideo->author;?>" required>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="URL">URL: </label>
                                        <input type="text" class="form-control" name="URL" value="<?php echo $courseVideo->URL;?>" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Hand  Note: </label>
                                        <input type="file" accept=".pdf," class="form-control" name="hand_note" >
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="thumb">thumb: </label>
                                        <input type="file" class="form-control" name="thumb" required>
                                    </div>
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


</script>