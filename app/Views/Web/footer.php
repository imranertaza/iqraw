<section class="content-four con-mr-2">
    <div class="container">
        <div class="row " style="margin-bottom: 108px;">
            <div class="col-12 text-center">
                <p class="tit-four">নিয়মিত আপডেট পেতে সাবস্ক্রাইব করুন</p>
            </div>
            <div class="col-3"></div>
            <div class=" col-md-6 col-sm-12 col-lg-6" style="margin-top: 52px;">
                <form action="#" method="post">
                    <div class="input-group ">
                        <input type="text" class="form-control con-inp" placeholder="Email"
                               aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-sub" type="button" id="button-addon2">Subscribe Now</button>
                    </div>
                </form>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</section>

<footer>
    <div class="footer-top">
        <div class="container">
            <div class="row ">
                <div class="col-12 text-center ft-top">
                    <span class="ft-tit">এখনি ডাউনলোড করুন</span>
                    <img src="<?php echo base_url()?>/assets_web/image/ft-des.svg" alt="des" class="img-ft-d">
                    <img src="<?php echo base_url()?>/assets_web/image/google-play.svg" alt="googgle" class="googgle">
                </div>
            </div>
        </div>

    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row ">
                <div class="col-12 text-center">
                    <img src="<?php echo base_url()?>/assets_web/image/fot-logo.svg" alt="logo" class="logo-ft-we">
                </div>
                <div class="col-md-3 col-sm-12 col-lg-3">
                    <p class="ft-tit-f" >Contact us</p>
                    <p class="ft-con-t" style="margin-top: 53px;">Noapara avaynogar jessore</p>
                    <p class="ft-con-t">iqrawtuition@gmail.com</p>
                    <p class="ft-con-t">01713913100</p>
                    <p class="ft-con-t"><a target="_blank" href="https://wa.me/<?php echo get_settings_value_by_label('whatsapp_number');?>" class="text-decoration-none text-white">Contact at <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="20px" width="20px" version="1.1" id="Capa_1" viewBox="0 0 58 58" xml:space="preserve"><g><path style="fill:#2CB742;" d="M0,58l4.988-14.963C2.457,38.78,1,33.812,1,28.5C1,12.76,13.76,0,29.5,0S58,12.76,58,28.5   S45.24,57,29.5,57c-4.789,0-9.299-1.187-13.26-3.273L0,58z"/><path style="fill:#FFFFFF;" d="M47.683,37.985c-1.316-2.487-6.169-5.331-6.169-5.331c-1.098-0.626-2.423-0.696-3.049,0.42   c0,0-1.577,1.891-1.978,2.163c-1.832,1.241-3.529,1.193-5.242-0.52l-3.981-3.981l-3.981-3.981c-1.713-1.713-1.761-3.41-0.52-5.242   c0.272-0.401,2.163-1.978,2.163-1.978c1.116-0.627,1.046-1.951,0.42-3.049c0,0-2.844-4.853-5.331-6.169   c-1.058-0.56-2.357-0.364-3.203,0.482l-1.758,1.758c-5.577,5.577-2.831,11.873,2.746,17.45l5.097,5.097l5.097,5.097   c5.577,5.577,11.873,8.323,17.45,2.746l1.758-1.758C48.048,40.341,48.243,39.042,47.683,37.985z"/></g></svg></a></p>
                </div>
                <div class="col-md-3 col-sm-12 col-lg-3">
                    <p class="ft-tit-f">Categories</p>
                    <ul class="ft-menu">
                        <li><a href="#">Home</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-12 col-lg-3">
                    <p class="ft-tit-f">My Account</p>
                    <ul class="ft-menu">
                        <li><a href="#">My Account</a></li>
                        <li><a href="#">Login</a></li>
                        <li><a href="#">Register</a></li>
                        <li><a href="<?php echo base_url()?>/Web/Home/refundpolicy">Refund Policy</a></li>
                        <li><a href="<?php echo base_url()?>/Web/Home/privacypolicy">Privacy Policy</a></li>
                        <li><a href="<?php echo base_url()?>/Web/Home/tarmsandcondition">Tarms and condition</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-12 col-lg-3 ne-l">
                    <p class="ft-tit-f">Newsletter</p>
                    <form action="#" method="post">
                        <div class="input-group ">
                            <input type="text" class="form-control new-inp" placeholder="enter your Email">
                        </div>
                        <div class="input-group">
                            <button class="btn btn-f">Subscribe</button>
                        </div>
                    </form>
                </div>
                <div class="col-12">
                    <hr style="border: 1px solid #ffffff;">
                </div>
                <div class="col-12 text-center" style="padding: 20px 0px;">

                    <a href="#"><img src="<?php echo base_url()?>/assets_web/image/ft-facebook-f.svg" alt=""></a>
                    <a href="#" class="fo-icon-f"><img src="<?php echo base_url()?>/assets_web/image/ft-twitter.svg" alt=""></a>
                    <a href="#"><img src="<?php echo base_url()?>/assets_web/image/ft-pinterest-logo-thin.svg" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    $(document).ready(function() {
          $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            items:4,
            autoplay:true,
            nav:true,
            dots:false,

          })
    })
</script>

<script>
    function loginformValidation(){
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
            $('#loginForm').submit();
        }
    }

    function signUpformValidation(){
        var result = 0;
        if ($('#name').val() == ''){
            $('#namemessage').html('<p style="color: red;">Name field is required </p>');
            result = 1;
        }else {
            $('#namemessage').html('<p style="color: green;">success</p>');
        }
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

        if ($('#con_password').val() == ''){
            $('#con_passmessage').html('<p style="color: red;">Password field is required </p>');
            result = 1;
        }else {
            $('#con_passmessage').html('<p style="color: green;">success</p>');
        }

        if (result == 1){
            // $('#message').html('<p style="color: red;">All field is required </p>');
        }else{
            $('#sign_up_form').submit();
        }
    }

    function groupCheck(class_id){
        $.ajax({
            url: '<?php echo base_url('Web/Profile/groupCheck') ?>',
            type: 'post',
            data: {
                class_id: class_id
            },
            success: function (val) {
                $("#class_group_id").html(val);
                // alert(val);
            }
        });
    }

    $(document).ready(function () {
        pack_sub_calculate();
    });

    function pack_sub_calculate(){
        var package_id = $('input[name="class_subscription_package_id"]:checked').val();
        var price = $('input[name="class_subscription_package_id"]:checked').attr('data-price');

        $("#opt_a").val(package_id);
        $("#amount").val(price);
        $("#tp").html('<b>'+price+'৳ </b>');
        $("#dp").html('<b>'+price+'৳ </b>');
    }
</script>

</body>
</html>