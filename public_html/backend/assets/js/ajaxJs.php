<script>
    // $(document).ready(function() {
    //     $("#exampleModal").modal();
    // });
    function viewdistrict(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('ajax/search_district') ?>",
            dataType: "text",
            data: {divisionsId: id},

            beforeSend: function () {
                $('#district').html('<img src="<?php print base_url(); ?>/assets/images/loading.gif" width="20" alt="loading"/> Progressing...');
            },
            success: function (msg) {
                $('#district').html(msg);
                $('#zila').html(msg);
            }

        });
    }

    function viewupazila(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('ajax/search_upazila') ?>",
            dataType: "text",
            data: {districtId: id},

            beforeSend: function () {
                $('#upazila').html('<img src="<?php print base_url(); ?>/assets/images/loading.gif" width="20" alt="loading"/> Progressing...');
            },
            success: function (msg) {
                $('#upazila').html(msg);
                $('#subdistrict').html(msg);
            }

        });
    }

    function passShow() {
        $('#password').attr('type', 'text');
    }

    function addToCart(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('ajax/addToCart') ?>",
            dataType: "text",
            data: {proId: id},

            beforeSend: function () {
                $('#upazila').html('<img src="<?php print base_url(); ?>/assets/images/loading.gif" width="20" alt="loading"/> Progressing...');
            },
            success: function (msg) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'success',
                    title: msg
                })
                $('#reloadCart').load(location.href + " #reloadCart");
                $('#reloadtable').load(location.href + " #reloadtable");
            }

        });
    }

    function updateQty(val, id) {

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('ajax/updateQty') ?>",
            dataType: 'json',
            data: {proId: id, val: val},

            beforeSend: function () {
                $('#upazila').html('<img src="<?php print base_url(); ?>/assets/images/loading.gif" width="20" alt="loading"/> Progressing...');
            },
            success: function (response) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                if (response.success === true) {
                    Toast.fire({
                        icon: 'success',
                        title: response.msg
                    })
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.msg
                    })
                }

                $('#reloadCart').load(location.href + " #reloadCart");
                $('#cartDetail').load(location.href + " #cartDetail");
                $('#reloadtable').load(location.href + " #reloadtable");
            }

        });
    }

    function removeCart(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('ajax/removeCart') ?>",
            dataType: "text",
            data: {proId: id},
            beforeSend: function () {
                $('#upazila').html('<img src="<?php print base_url(); ?>/assets/images/loading.gif" width="20" alt="loading"/> Progressing...');
            },
            success: function (msg) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'success',
                    title: msg
                })
                $('#reloadCart').load(location.href + " #reloadCart");
                $('#cartDetail').load(location.href + " #cartDetail");
                $('#reloadtable').load(location.href + " #reloadtable");
            }

        });
    }

    function showModal() {
        $("#address").modal();
        $('#address-update').trigger("reset");

        $('#address-update').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            <?php //echo base_url('Mobile_app/Cart/addressUpdate')?>
            $.ajax({
                url: "<?= base_url('ajax/addressUpdate') ?>",
                type: "POST",
                cache: false,
                data: formData,
                processData: false,
                contentType: false,
                dataType: "JSON",
                success: function (data) {

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    if (data.success == true) {
                        Toast.fire({
                            icon: 'success',
                            title: data.msg
                        })
                        $("#address").modal('hide');
                        location.reload();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.msg
                        })
                        $("#address").modal('hide');
                        // location.reload();
                    }
                }
            });
        });

    }

    function getBranch(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('ajax/getInHosBranch') ?>",
            dataType: "text",
            data: {ind_h_id: id},

            beforeSend: function () {
                $('#upazila').html('<img src="<?php print base_url(); ?>/assets/images/loading.gif" width="20" alt="loading"/> Progressing...');
            },
            success: function (msg) {
                $('#hos_branch').html(msg);
            }

        });
    }


    //$(function () {
    //    hospitalAdView();
    //    nationalAdView()
    //    setInterval(hospitalAdView, 25000);
    //    setInterval(nationalAdView, 25000);
    //
    //    function hospitalAdView() {
    //        $.ajax({
    //            type: "POST",
    //            url: "<?php //echo site_url('ajax/hospitalAd') ?>//",
    //            dataType: "text",
    //            success: function (data) {
    //                $('#addView').html(data);
    //                $("#carouselExampleSlidesOnly").carousel();
    //
    //                var addId = $('#carouselExampleSlidesOnly div.active').attr('add-id');
    //                addViewCount(addId);
    //            }
    //        });
    //    }
    //
    //    function nationalAdView() {
    //        $.ajax({
    //            type: "POST",
    //            url: "<?php //echo site_url('ajax/nationalAd') ?>//",
    //            dataType: "text",
    //            success: function (data) {
    //                $('#addViewNational').html(data);
    //                $("#carouselExampleSlidesOnly").carousel();
    //
    //                var addId = $('#carouselExampleSlidesOnly div.active').attr('add-id');
    //                addViewCount(addId);
    //            }
    //        });
    //    }
    //
    //    $('#carouselExampleSlidesOnly').carousel({
    //        interval: 5000
    //    });
    //
    //    $('#carouselExampleSlidesOnly').on('slid.bs.carousel', function () {
    //        var addId = $('#carouselExampleSlidesOnly div.active').attr('add-id');
    //        addViewCount(addId);
    //        // $('.num').html(addId);
    //    });
    //
    //    function addViewCount(addId) {
    //        $.ajax({
    //            type: "POST",
    //            url: "<?php //echo site_url('ajax/adViewCount') ?>//",
    //            data: {adId: addId},
    //            dataType: "text",
    //            success: function (data) {
    //                // $('.num').html(data);
    //            }
    //        });
    //    }
    //});


</script>