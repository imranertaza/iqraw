

    <section class="content">
    <div class="row">
        <div class="col-12 ">

            <form id="signIn" method="post" action="<?php echo base_url();?>/Mobile_app/SignUp/otp_submit_action">
                <div class="container">
                    <div class="text-center position-relative ">
                        <span class="con-l-1st">পড় তোমার</span><br>
                        <span class="con-l-2nd">প্রভুর <span style="color: #000000;">নামে</span></span>
                    </div>
                    <br>
                    <span class="title-1">Otp Submit <?php print $_COOKIE['forget_otp']?></span>
                    <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                    <div class="input-group mb-3 mt-3">
                        <input type="number" class="form-control" name="otp" id="otp" placeholder="Otp">
                    </div>
                    <label id="otpmessage"></label>
                    <div class="btn-g ">
                        <center><a class="btn btnSignIn" onclick="otpValidation()">Submit</a></center>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>