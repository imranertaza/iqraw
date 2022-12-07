<!--    footer-->
<nav class="navbar navbar-expand-md navbar-dark fixed-bottom p-2 footer" id="reloadCart">
    <a class="navbar-brand" href="#"><img src="<?php echo base_url(); ?>/assets/image/icon-w.svg" alt=""></a>
    <?php if ($footer_icon == 'Shopping'){ ?>
        <a class="navbar-brand" href="<?php echo $cart_url;?>"><div class="h-icon-bg"><img src="<?php echo base_url(); ?>/assets/image/icon-shopping-w.svg" alt="" style="margin-top: 13px;"></div> <?php if (!empty(Cart()->totalItems())){?>
                <span class="position-absolute translate-middle badge rounded-pill bg-danger " style="top:20px;" ><?php echo Cart()->totalItems();?></span>
            <?php } ?></a>

    <?php }else{ ?>
    <a class="navbar-brand" href="<?php echo base_url() ?>/Student/Shopping"><img src="<?php base_url(); ?>/assets/image/icon-shopping.svg" alt=""></a>
    <?php } ?>

    <?php if ($footer_icon == 'Home'){ ?>
    <a class="navbar-brand" href="<?php echo base_url() ?>/Student/Dashboard">
        <div class="h-icon-bg"><img src="<?php echo base_url(); ?>/assets/image/icon-home-alt.svg" alt=""
                                    style="margin-top: 11px;"></div>
    </a>
    <?php }else{ ?>
        <a class="navbar-brand" href="<?php echo base_url() ?>/Student/Dashboard"><img src="<?php base_url(); ?>/assets/image/icon-home-alt-w.svg" alt="">
        </a>
    <?php } ?>
    <a class="navbar-brand" href="#"><img src="<?php echo base_url(); ?>/assets/image/icon-notification.svg" alt=""></a>

    <?php if ($footer_icon == 'Ranking'){ ?>
        <a class="navbar-brand" href="<?php echo base_url() ?>/Student/Ranking"><div class="h-icon-bg"><img src="<?php echo base_url(); ?>/assets/image/icon-badge-rank-w.svg" alt="" style="margin-top: 11px;"></div></a>
    <?php }else{ ?>
        <a class="navbar-brand" href="<?php echo base_url() ?>/Student/Ranking"><img src="<?php echo base_url(); ?>/assets/image/icon-badge-rank.svg" alt=""></a>
    <?php } ?>
</nav>

<script>
    function anscatculate(url) {
        var quizId = $("#quiz_id").val();
        var ans = $('input[name="btnradio"]:checked').val();
        if (ans == undefined) {
            $("#mess").html('<p style="color: red;">Please select your answer</p>');
        } else {
            $.ajax({
                url: '<?php echo base_url('Student/VideoQuiz/sessionUpdate')?>',
                type: "Post",
                data: {quizId: quizId, ans: ans},
                success: function (data) {
                    location.replace(url);
                }
            });
        }
    }

    function join_exam(url){
        var agree = confirm("Are you sure you wish to joined?");
        if (agree)
            location.replace(url);
        else
        return false;
    }

    function quizanscatculate(url){
        var quizId = $("#quiz_question_id").val();
        var ans = $('input[name="btnradio"]:checked').val();
        if (ans == undefined) {
            $("#mess").html('<p style="color: red;">Please select your answer</p>');
        }else{

            $.ajax({
                url: '<?php echo base_url('Student/Quiz/result')?>',
                type: "Post",
                data: {quizId: quizId, ans: ans},
                success: function (data) {
                    location.replace(url);
                }
            });
        }
    }

    function mcqanscatculate(url){
        var quizId = $("#skill_question_id").val();
        var ans = $('input[name="btnradio"]:checked').val();

        if (ans == undefined) {
            $("#mess").html('<p style="color: red;">Please select your answer</p>');
        }else {

            $.ajax({
                url: '<?php echo base_url('Student/Skill_development/ans_quiz')?>',
                type: "Post",
                data: {quizId: quizId, ans: ans},
                success: function (data) {
                    location.replace(url);
                }
            });
        }
    }

    function vocanscatculate(url){
        var quizId = $("#voc_quiz_id").val();
        var ans = $('input[name="btnradio"]:checked').val();

        if (ans == undefined) {
            $("#mess").html('<p style="color: red;">Please select your answer</p>');
        }else {
            $.ajax({
                url: '<?php echo base_url('Student/Vocabulary/ans_quiz')?>',
                type: "Post",
                data: {quizId: quizId, ans: ans},
                success: function (data) {
                    location.replace(url);
                }
            });
        }
    }

    function addToCart(id){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('/Student/Shopping/addToCart') ?>",
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

    function updatePlus(id){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('/Student/Shopping/updatePlus') ?>",
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
    function updateMinus(id){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('/Student/Shopping/updateMinus') ?>",
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

    function searchPro(keyWord){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('/Student/Shopping/search') ?>",
            dataType: "text",
            data: {keyWord: keyWord},
            beforeSend: function () {
                $('#upazila').html('<img src="<?php print base_url(); ?>/assets/images/loading.gif" width="20" alt="loading"/> Progressing...');
            },
            success: function (msg) {
                $('#resultProduct').html(msg);
            }

        });
    }

    function coinAdd(){
        var sub_total = $('#sub_total').val();
        var myCoin = $('#myCoin').val();
        alert(sub_total);
        alert(myCoin);
        if (sub_total <= myCoin){
            $('#titlePay').html('Coin');
            $('#titleAmo').html('-' +sub_total+'৳');
            $('#due_total').val('0');
            $('#dueData').html('0৳');
        }else{
            $('input[name="btnradio"]').attr('checked', false);
            $('#coinDiv').load(location.href + " #coinDiv");

            var msg = 'Not enough coin';
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
                icon: 'error',
                title: msg
            })
        }

    }

    function video_open(video_id){
        $('#exampleModal').modal('show');

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('/Student/VideoQuiz/show_video') ?>",
            dataType: "text",
            data: {video_id: video_id},
            beforeSend: function () {
                $('#upazila').html('<img src="<?php print base_url(); ?>/assets/images/loading.gif" width="20" alt="loading"/> Progressing...');
            },
            success: function (msg) {
                $('#videoUrl').html(msg);
            }

        });
    }

</script>
</body>
</html>