

    <section class="content">
    <div class="row">
        <div class="col-12 ">

            <form id="signIn" method="post" action="<?php echo base_url();?>/Mobile_app/SignUp/otp_reg_submit_action">
                <div class="container">
                    <div class="text-center position-relative ">
                        <span class="con-l-1st">পড় তোমার</span><br>
                        <span class="con-l-2nd">প্রভুর <span style="color: #000000;">নামে</span></span>
                    </div>
                    <br>
                    <p><?php print (session()->getFlashdata('message') !== NULL) ? session()->getFlashdata('message') : ''; ?></p>
                    <span class="title-1">Please Input the OTP code </span>
                    <div class="input-group mb-3 mt-3">
                        <input type="number" class="form-control" name="otp" id="otp" placeholder="Code" required >
                    </div>
                    <div class="btn-g ">
                        <center><button type="submit" class="btn btnSignIn"  >Submit</button></center>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>