<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Products update</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Products update</li>
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
                                <h3 class="card-title">Product update</h3>
                            </div>

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="update-form" method="POST" enctype="multipart/form-data" class="pl-3 pr-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name"> Name: <span class="text-danger">*</span> </label>
                                        <input type="hidden" id="prodId" name="prodId" value="<?php echo $product->prod_id;?>">
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Name"
                                               value="<?php echo $product->name;?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="prodCatId"> Product Category: <span class="text-danger">*</span></label>
                                        <select class="form-control" onchange="subCategory(this.value)" required>
                                            <option value="">Please Select</option>
                                            <?php
                                                $proCat = get_data_by_id('parent_pro_cat_id','product_category','prod_cat_id',$product->prod_cat_id);
                                                foreach ($proCategory as $item) {
                                                $sel = ($proCat == $item->prod_cat_id )?'selected':'';
                                            ?>
                                                <option value="<?php echo $item->prod_cat_id; ?>" <?php echo $sel;?> ><?php echo $item->product_category; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="prodSubCatId"> Product Subcategory: <span class="text-danger">*</span></label>
                                        <select id="prodCatId" name="prodCatId" class="form-control" required>
                                            <?php echo proSubCatListInOption($proCat,$product->prod_cat_id);?>
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
                                            <?php echo unitInOptionArray($product->unit); ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="storeId"> Store : <span class="text-danger">*</span> </label>
                                        <select id="storeId" name="storeId" class="form-control" required>
                                            <option value="">Please Select</option>
                                            <?php foreach ($store as $sto) {
                                                $sel = ($sto->store_id == $product->store_id)?'selected':'';
                                            ?>
                                                <option value="<?php echo $sto->store_id; ?>" <?php echo $sel;?> ><?php echo $sto->name; ?></option>
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
                                            <?php foreach ($brand as $bra) {
                                                $sel = ($bra->brand_id == $product->brand_id)?'selected':'';
                                            ?>
                                                <option value="<?php echo $bra->brand_id; ?>" <?php echo $sel;?>><?php echo $bra->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="price"> Price: </label>
                                        <input type="number" id="price" name="price" class="form-control"
                                               placeholder="price"  number="true" value="<?php echo $product->price; ?>" maxlength="155" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status"> Status: <span class="text-danger">*</span> </label>
                                        <select id="status" name="status" class="form-control" required>
                                            <?php echo globalStatus($product->status); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div id="image">
                                            <?php $prod = no_image_view('/assets/upload/product/'.$product->prod_id.'/'.$product->picture,'/assets/upload/product/no_img.svg',$product->picture)?>
                                            <img src="<?php echo $prod; ?>" width="100">
                                        </div>
                                        <label for="picture"> Picture: </label>
                                        <input type="file" id="picture" name="picture" class="form-control"
                                               placeholder="Picture" maxlength="155">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="picture"> Gender Type: </label>
                                        <select id="gender_type" name="gender_type" class="form-control" required>
                                            <option value="Man" <?php echo ($product->gender_type == 'Man')?'selected':''; ?> >Man</option>
                                            <option value="Women" <?php echo ($product->gender_type == 'Women')?'selected':''; ?> >Women</option>
                                            <option value="Both" <?php echo ($product->gender_type == 'Both')?'selected':''; ?> >Both</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="productType"> Product type: </label>
                                        <select id="productType" name="productType" class="form-control" required>
                                            <?php echo productTypeInOption($product->product_type); ?>
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
                                                  class="form-control" placeholder="Description"><?php echo $product->description; ?></textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group text-center">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-success" id="add-form-btn" onclick="update()" >Update</button>
                                    <a href="<?php echo base_url($controller)?>" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</a>
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


    function update() {
        // reset the form
        $(".form-control").removeClass('is-invalid').removeClass('is-valid');
        // submit the add from
        $('#update-form').validate({

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
                    var form = $("#update-form");
                    var formData = new FormData(form[0]);
                    // remove the text-danger
                    $(".text-danger").remove();

                    $.ajax({
                        url: '<?php echo base_url($controller . '/updateAction') ?>',
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
                                    // $('#data_table').DataTable().ajax.reload(null, false).draw(false);
                                    // $('#add-modal').modal('hide');
                                    $('#image').load(document.URL + ' #image');
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