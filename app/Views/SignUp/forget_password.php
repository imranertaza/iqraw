
<section class="content">
    <div class="row">
        <div class="col-12 ">

            <form id="forgetPass" method="post" action="<?php echo base_url();?>/Mobile_app/SignUp/send_otp">
                <div class="container">
                    <div class="text-center position-relative ">
                        <span class="con-l-1st">পড় তোমার</span><br>
                        <span class="con-l-2nd">প্রভুর <span style="color: #000000;">নামে</span></span>
                    </div>
                    <br>
                    <span class="title-1">Input your phone number(without 88)</span>
                    <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                    <div class="input-group mb-3 mt-3">
                        <input type="number" class="form-control" name="phone" id="phone" placeholder="phone">
                    </div>
                    <p style="font-size: 10px;padding-top: 0;">example: 01700000000</p>
                    <label id="phonemessage"></label>
                    <div class="btn-g ">
                        <center><a class="btn btnSignIn" onclick="forgetformValidation()">Send otp</a></center>
                        <center><span class="cre-sig"><a href="<?php echo base_url();?>/Mobile_app/SignUp/signIn" class="sig">Sign In</a></span></center>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>