<section class="content-three con-mr ">
    <div class="container">
        <div class="row " style="margin-bottom: 108px;">
            <div class="col-md-4 col-sm-4 col-lg-4"></div>

            <div class="col-md-4 col-sm-4 col-lg-4 " style="border: 1px solid #e6e6e6;">
                <div class="text-center d-logo mt-3">
                    <a href="<?php echo base_url() ?>"><img src="<?php echo base_url() ?>/assets_web/image/logo.svg"
                                                            alt="logo"></a>
                </div>
                <img src="<?php echo base_url() ?>/assets_web/image/banner.svg" alt="banner" class="log-img">

                <div class="text-center position-relative ">
                    <span class="con-l-1st">পড় তোমার</span><br>
                    <span class="con-l-2nd">প্রভুর <span style="color: #000000;">নামে</span></span>
                </div>
                <form id="sign_up_form" action="<?php base_url() ?>/Web/Login/sign_up_action" method="post">
                    <span class="title-1">Sign Up</span>
                    <div class="message mt-2" >
                        <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                    </div>
                    <div class="input-group mb-3 mt-3">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                    </div>
                    <label id="namemessage"></label>
                    <div class="input-group mb-3 ">
                        <input type="number" class="form-control" name="phone" id="phone" placeholder="Phone">
                    </div>
                    <label id="phonemessage"></label>
                    <div class="input-group mb-3 ">
                        <input type="password" class="form-control" name="password" id="password"
                               placeholder="Password">
                    </div>
                    <label id="passmessage"></label>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="con_password" id="con_password"
                               placeholder="Conform Password">
                    </div>
                    <label id="con_passmessage"></label>
                    <div class="btn-g ">
                        <center><a class="btn btnSignIn" onclick="signUpformValidation()">Sign Up</a></center>
                        <center><span class="cre-sig">Already an account.<a href="<?php echo base_url() ?>/Web/Login"
                                                                            class="sig">Sign In</a></span></center>
                    </div>

                </form>
            </div>

            <div class="col-md-4 col-sm-4 col-lg-4"></div>
        </div>
    </div>
</section>