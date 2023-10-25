<section class="content-three con-mr ">
    <div class="container">
        <div class="row " style="margin-bottom: 108px;">
            <div class="col-md-4 col-sm-4 col-lg-4"></div>

            <div class="col-md-4 col-sm-4 col-lg-4 " style="border: 1px solid #e6e6e6;">

                <div class="text-center position-relative mt-4">
                    <span class="con-l-1st">Otp submit</span><br><br>
                </div>
                <form id="sign_up_form" action="<?php base_url() ?>/Web/Login/otp_submit" method="post">

                    <div class="message mt-2" >
                        <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                    </div>
                    <div class="input-group mb-3 mt-3">
                        <input type="text" class="form-control" name="otp" placeholder="Enter 6 digit code" required>
                    </div>
                    <div class="btn-g ">
                        <center><button class="btn btnSignIn" >Submit</button></center>
                    </div>

                </form>
            </div>

            <div class="col-md-4 col-sm-4 col-lg-4"></div>
        </div>
    </div>
</section>