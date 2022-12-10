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
</script>

</body>
</html>