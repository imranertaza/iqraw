</div>
<script>

    // $(document).ready(function(){
    //     $('a[data-bs-toggle="tab"]').on('show.bs.tab', function(e) {
    //         localStorage.setItem('activeTab', $(e.target).attr('href'));
    //         if ($(e.target).attr('href') == '#menu1'){
    //             $('.d-logo a').css('display','block');
    //         }
    //         if ($(e.target).attr('href') == '#menu2'){
    //             $('.d-logo a').css('display','block');
    //         }
    //     });
    //     var activeTab = localStorage.getItem('activeTab');
    //     if(activeTab){
    //         $('#myTab a[href="' + activeTab + '"]').tab('show');
    //     }
    // });


    // $('.btnNext').click(function() {
    //     const nextTabLinkEl = $('.nav-tabs .active').closest('li').next('li').find('a')[0];
    //     const nextTab = new bootstrap.Tab(nextTabLinkEl);
    //     nextTab.show();
    //     $('.d-logo a').css('display','block');
    // });

    $('.btnPrevious').click(function() {
        const prevTabLinkEl = $('.nav-tabs .active').closest('li').prev('li').find('a')[0];
        const prevTab = new bootstrap.Tab(prevTabLinkEl);
        prevTab.show();
        if ($('.nav-tabs .active').attr('href') == '#home'){
            $('.d-logo a').css('display','none');
        }
    });


    function ClickNextBtn() {
        const nextTabLinkEl = $('.nav-tabs .active').closest('li').next('li').find('a')[0];
        const nextTab = new bootstrap.Tab(nextTabLinkEl);
        nextTab.show();
        $('.d-logo a').css('display','block');
    }

    function conformValidation1st(){
        var result = 0;
        if ($('#name').val() == ''){ result = 1;}
        if ($('#father_name').val() == ''){ result = 1;}
        if ($('#address').val() == ''){result = 1; }
        if (result == 1){
            $('#message').html('<p style="color: red;">All field is required </p>');
        }else{
            $('#message').html('<p style="color: green;">Success </p>');
            ClickNextBtn();
        }
    }
    function conformValidation2st(){
        var result = 0;
        if ($('#school_name').val() == ''){ result = 1;}
        if ($('#gender').val() == ''){ result = 1;}
        if ($('#religion').val() == ''){result = 1; }
        if ($('#age').val() == ''){result = 1; }
        if (result == 1){
            $('#message2').html('<p style="color: red;">All field is required </p>');
        }else{
            $('#message2').html('<p style="color: green;">Success </p>');
            ClickNextBtn();
        }
    }

    function checkInst(){
        $("#btnr1").attr('checked', true);
        $("#btnr2").attr('checked', false);
    }
    function checkInst2(){
        $("#btnr2").attr('checked', true);
        $("#btnr1").attr('checked', false);
    }

    function conformValidation3rd(){
        var result = 0;
        // if ($('input[name="class_group"]:checked').val()){ result = 0;}else{ result = 1;}
        if ($('input[name="institute"]:checked').val()){ result = 0;}else{ result = 1;}
        if ($('#phone').val() == ''){ result = 1;}
        if ($('#password').val() == ''){ result = 1;}
        if ($('#class_id').val() == ''){ result = 1;}

        if (result == 1){
            $('#message3').html('<p style="color: red;">All field is required </p>');
        }else{
            $('#message3').html('<p style="color: green;">Success </p>');
            $('#signupForm').submit();
        }
    }
    function signInformValidation(){
        var result = 0;
        if ($('#phone').val() == ''){
            $('#phonemessage').html('<p style="color: red;">Phone field is required </p>');
            result = 1;
        }else {
            $('#phonemessage').html('<p style="color: green;">success</p>');
        }
        if ($('#password').val() == ''){
            $('#passmessage').html('<p style="color: red;">Password field is required </p>');
            result = 1;
        }else {
            $('#passmessage').html('<p style="color: green;">success</p>');
        }

        if (result == 1){
            // $('#message').html('<p style="color: red;">All field is required </p>');
        }else{
            $('#signIn').submit();
        }
    }

    function forgetformValidation(){
        var result = 0;
        if ($('#phone').val() == ''){
            $('#phonemessage').html('<p style="color: red;">Phone field is required </p>');
            result = 1;
        }else {
            $('#phonemessage').html('<p style="color: green;">success</p>');
        }

        if (result == 1){
            // $('#message').html('<p style="color: red;">All field is required </p>');
        }else{
            $('#forgetPass').submit();
        }
    }

    function otpValidation(){
        var result = 0;
        if ($('#otp').val() == ''){
            $('#otpmessage').html('<p style="color: red;">OTP field is required </p>');
            result = 1;
        }
        // else {
        //     $('#otpmessage').html('<p style="color: green;">success</p>');
        // }



        if (result == 1){
            // $('#message').html('<p style="color: red;">All field is required </p>');
        }else{
            $('#signIn').submit();
        }
    }
    function passValidation(){
        var result = 0;
        if ($('#password').val() == ''){
            $('#passmessage').html('<p style="color: red;">Password field is required </p>');
            result = 1;
        }else {
            $('#passmessage').html('<p style="color: green;">success</p>');
        }

        if ($('#con_password').val() == ''){
            $('#conPasswordmessage').html('<p style="color: red;">Confirm Password field is required </p>');
            result = 1;
        }else {
            $('#conPasswordmessage').html('<p style="color: green;">success</p>');
        }

        if (result == 1){
            // $('#message').html('<p style="color: red;">All field is required </p>');
        }else{
            $('#conPass').submit();
        }
    }


    function viewGroup(class_id){
        $.ajax({
            url: '<?php echo base_url('Mobile_app/SignUp/classGroup') ?>',
            type: 'post',
            data: {class_id:class_id},
            success: function (response) {
                $("#gorupview").html(response);
            }
        });
    }



</script>

</body>
</html>