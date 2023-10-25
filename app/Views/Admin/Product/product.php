<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Products</li>
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
                                <h3 class="card-title">Products</h3>
                            </div>
                            <div class="col-md-4">
                                    <button type="button" class="btn btn-block btn-success" onclick="add()" title="Add">
                                        <i class="fa fa-plus"></i> Add
                                    </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="data_table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Store</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Brand</th>
                                <th>Picture</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Action</th>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="text-center bg-info p-3">
                    <h4 class="modal-title text-white" id="info-header-modalLabel">Add</h4>
                </div>
                <div class="modal-body">
                    <form id="add-form" method="POST" enctype="multipart/form-data" class="pl-3 pr-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name"> Name: <span class="text-danger">*</span> </label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Name"
                                           maxlength="55" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="prodCatId"> Product Category: <span class="text-danger">*</span></label>
                                    <select class="form-control" onchange="subCategory(this.value)" required>
                                        <option value="">Please Select</option>
                                        <?php foreach ($proCategory as $item) { ?>
                                            <option value="<?php echo $item->prod_cat_id; ?>"><?php echo $item->product_category; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="prodSubCatId"> Product Subcategory: <span class="text-danger">*</span></label>
                                    <select id="prodCatId" name="prodCatId" class="form-control" required>
<!--                                        <option value="">Please Select</option>-->
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quantity"> Quantity: <span class="text-danger">*</span> </label>
                                    <input type="number" id="quantity" name="quantity" class="form-control"
                                           placeholder="Quantity" value="1" number="true" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="unit"> Unit: <span class="text-danger">*</span> </label>
                                    <select id="unit" name="unit" class="form-control" required>
                                        <?php echo unitInOptionArray(1); ?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="storeId"> Store : <span class="text-danger">*</span> </label>
                                    <select id="storeId" name="storeId" class="form-control" required>
                                        <option value="">Please Select</option>
                                        <?php foreach ($store as $sto) { ?>
                                            <option value="<?php echo $sto->store_id; ?>"><?php echo $sto->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="brandId"> Brand : </label>
                                    <select id="brandId" name="brandId" class="form-control" required>
                                        <option value="">Please Select</option>
                                        <?php foreach ($brand as $bra) { ?>
                                            <option value="<?php echo $bra->brand_id; ?>"><?php echo $bra->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="price"> Price: </label>
                                    <input type="number" id="price" name="price" class="form-control"
                                           placeholder="price"  number="true"  maxlength="155" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status"> Status: <span class="text-danger">*</span> </label>
                                    <select id="status" name="status" class="form-control" required>
                                        <?php echo globalStatus(1); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="picture"> Gender Type: </label>
                                    <select id="gender_type" name="gender_type" class="form-control" required>
                                        <option value="Man" >Man</option>
                                        <option value="Women" >Women</option>
                                        <option value="Both" >Both</option>
                                    </select>
                                </div>
                            </div>



                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="picture"> Picture: </label>
                                    <input type="file" id="picture" name="picture" class="form-control"
                                           placeholder="Picture" maxlength="155">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="productType"> Product type: </label>
                                    <select id="productType" name="productType" class="form-control" required>
                                        <?php echo productTypeInOption(0); ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="description"> Description: </label>
                                    <textarea cols="40" rows="5" id="description" name="description"
                                              class="form-control" placeholder="Description"></textarea>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="text-center bg-info p-3">
                    <h4 class="modal-title text-white" id="info-header-modalLabel">Update</h4>
                </div>
                <div class="modal-body">
                    <form id="edit-form" method="POST" enctype="multipart/form-data" class="pl-3 pr-3">
                        <div class="row">
                            <input type="hidden" id="prodId" name="prodId" class="form-control" placeholder="Prod id"
                                   maxlength="11" required>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name"> Name: <span class="text-danger">*</span> </label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Name"
                                           maxlength="55" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="prodCatId"> Product Category: <span class="text-danger">*</span></label>
                                    <select class="form-control" onchange="subCategory(this.value)" required>
                                        <option value="">Please Select</option>
                                        <?php foreach ($proCategory as $item) { ?>
                                            <option value="<?php echo $item->prod_cat_id; ?>"><?php echo $item->product_category; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="prodSubCatId"> Product Subcategory: <span class="text-danger">*</span></label>
                                    <select id="prodCatId" name="prodCatId" class="form-control" required>
                                        <!--                                        <option value="">Please Select</option>-->
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quantity"> Quantity: <span class="text-danger">*</span> </label>
                                    <input type="number" id="quantity" name="quantity" class="form-control"
                                           placeholder="Quantity" value="1" number="true" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="unit"> Unit: <span class="text-danger">*</span> </label>
                                    <select id="unit" name="unit" class="form-control" required>
                                        <?php echo unitInOptionArray(1); ?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="storeId"> Store : <span class="text-danger">*</span> </label>
                                    <select id="storeId" name="storeId" class="form-control" required>
                                        <option value="">Please Select</option>
                                        <?php foreach ($store as $sto) { ?>
                                            <option value="<?php echo $sto->store_id; ?>"><?php echo $sto->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="brandId"> Brand : </label>
                                    <select id="brandId" name="brandId" class="form-control" required>
                                        <option value="">Please Select</option>
                                        <?php foreach ($brand as $bra) { ?>
                                            <option value="<?php echo $bra->brand_id; ?>"><?php echo $bra->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="productType"> Product type: </label>
                                    <select id="productType" name="productType" class="form-control" required>
                                        <?php echo productTypeInOption(0); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status"> Status: <span class="text-danger">*</span> </label>
                                    <select id="status" name="status" class="form-control" required>
                                        <?php echo globalStatus(1); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="picture"> Gender Type: </label>
                                    <input type="file" id="gender_type" name="gender_type" class="form-control"
                                           placeholder="Picture" maxlength="155">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="picture"> Picture: </label>
                                    <input type="file" id="picture" name="picture" class="form-control"
                                           placeholder="Picture" maxlength="155">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="description"> Description: </label>
                                    <textarea cols="40" rows="5" id="description" name="description"
                                              class="form-control" placeholder="Description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                        </div>

                        <div class="form-group text-center">
                            <div class="btn-group">
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

    function add() {
        $("#add-form")[0].reset();
        $(".richText-editor").html('');
        // reset the form
        $(".form-control").removeClass('is-invalid').removeClass('is-valid');
        $('#add-modal').modal('show');
        // submit the add from
        $('#add-form').validate({

                highlight: function (element) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                },
                errorElement: 'div ',
                errorClass: 'invalid-feedback',
                errorPlacement: function (error, element) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else if ($(element).is('.select')) {
                        element.next().after(error);
                    } else if (element.hasClass('select2')) {
                        //error.insertAfter(element);
                        error.insertAfter(element.next());
                    } else if (element.hasClass('selectpicker')) {
                        error.insertAfter(element.next());
                    } else {
                        error.insertAfter(element);
                    }
                },

                submitHandler: function (form) {
                    var form = $("#add-form");
                    var formData = new FormData(form[0]);
                    // remove the text-danger
                    $(".text-danger").remove();

                    $.ajax({
                        url: '<?php echo base_url($controller . '/add') ?>',
                        method: "POST",
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
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
                                }).then(function () {
                                    $('#data_table').DataTable().ajax.reload(null, false).draw(false);
                                    $('#add-modal').modal('hide');
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
                        }
                    });

                    return false;
                }
            });
            $('#add-form').validate();

    }

    function edit(prod_id) {
        $.ajax({
            url: '<?php echo base_url($controller . '/getOne') ?>',
            type: 'post',
            data: {
                prod_id: prod_id
            },
            dataType: 'json',
            success: function (response) {
                // reset the form
                $("#edit-form")[0].reset();
                $(".form-control").removeClass('is-invalid').removeClass('is-valid');
                $('#edit-modal').modal('show');

                $("#edit-form #prodId").val(response.prod_id);
                $("#edit-form #storeId").val(response.store_id);
                $("#edit-form #name").val(response.name);
                $("#edit-form #quantity").val(response.quantity);
                $("#edit-form #unit").val(response.unit);
                $("#edit-form #brandId").val(response.brand_id);
                $("#edit-form #picture").val(response.picture);
                $("#edit-form #prodCatId").val(response.prod_cat_id);
                $("#edit-form #productType").val(response.product_type);
                $("#edit-form #description").val(response.description);
                $("#edit-form #status").val(response.status);

                // submit the edit from
                $.validator.setDefaults({
                    highlight: function (element) {
                        $(element).addClass('is-invalid').removeClass('is-valid');
                    },
                    unhighlight: function (element) {
                        $(element).removeClass('is-invalid').addClass('is-valid');
                    },
                    errorElement: 'div ',
                    errorClass: 'invalid-feedback',
                    errorPlacement: function (error, element) {
                        if (element.parent('.input-group').length) {
                            error.insertAfter(element.parent());
                        } else if ($(element).is('.select')) {
                            element.next().after(error);
                        } else if (element.hasClass('select2')) {
                            //error.insertAfter(element);
                            error.insertAfter(element.next());
                        } else if (element.hasClass('selectpicker')) {
                            error.insertAfter(element.next());
                        } else {
                            error.insertAfter(element);
                        }
                    },

                    submitHandler: function (form) {
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

                        return false;
                    }
                });
                $('#edit-form').validate();

            }
        });
    }

    function remove(prod_id) {
        Swal.fire({
            title: 'Are you sure of the deleting process?',
            text: "You cannot back after confirmation",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel'
        }).then((result) => {

            if (result.value) {
                $.ajax({
                    url: '<?php echo base_url($controller . '/remove') ?>',
                    type: 'post',
                    data: {
                        prod_id: prod_id
                    },
                    dataType: 'json',
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
                            Swal.fire({
                                position: 'bottom-end',
                                icon: 'error',
                                title: response.messages,
                                showConfirmButton: false,
                                timer: 1500
                            })


                        }
                    }
                });
            }
        })
    }

    function subCategory(id) {
        $.ajax({
            url: '<?php echo base_url($controller . '/subcategory') ?>',
            type: 'post',
            data: {
                subId: id
            },
            dataType: 'text',
            success: function (response) {
                $('#prodCatId').html(response);
            }
        });
    }
</script>