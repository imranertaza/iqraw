

    <section class="content">
    <div class="row">
        <div class="col-12 ">

            <form id="signIn" method="post" action="<?php echo base_url();?>/SignUp/login_action">
                <div class="container">
                    <div class="text-center position-relative ">
                        <span class="con-l-1st">পড় তোমার</span><br>
                        <span class="con-l-2nd">প্রভুর <span style="color: #000000;">নামে</span></span>
                    </div>
                    <br>
                    <span class="title-1">Sign in</span>
                    <div class="input-group mb-3 mt-3">
                        <input type="number" class="form-control" name="phone" id="phone" placeholder="Phone">
                    </div>
                    <label id="phonemessage"></label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="password" id="password" placeholder="Password">
                    </div>
                    <label id="passmessage"></label><br>
                    <span class="for-pass">Forget Password?</span>
                    <div class="btn-g ">
                        <center><a class="btn btnSignIn" onclick="signInformValidation()">Sign in</a></center>
                        <center><span class="cre-sig">Create an account.<a href="<?php echo base_url();?>/SignUp" class="sig">signup</a></span></center>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>