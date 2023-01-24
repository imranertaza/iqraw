

    <section class="content">
    <div class="row">
        <div class="col-12 ">

            <form id="conPass" method="post" action="<?php echo base_url();?>/Mobile_app/SignUp/reset_password_action">
                <div class="container">
                    <div class="text-center position-relative ">
                        <span class="con-l-1st">পড় তোমার</span><br>
                        <span class="con-l-2nd">প্রভুর <span style="color: #000000;">নামে</span></span>
                    </div>
                    <br>
                    <span class="title-1">Set new password</span>
                    <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                    <div class="input-group mb-3 mt-3">
                        <input type="password" class="form-control" name="password" id="password" placeholder="New Password">
                    </div>
                    <label id="passmessage"></label>
                    <div class="input-group mb-3 ">
                        <input type="password" class="form-control" name="con_password" id="con_password" placeholder="Confirm Password">
                    </div>
                    <label id="conPasswordmessage"></label><br>
                    <div class="btn-g ">
                        <center><a class="btn btnSignIn" onclick="passValidation()">Submit</a></center>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>