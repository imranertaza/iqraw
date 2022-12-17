<section class="content-three con-mr">
    <div class="container">
        <form action="<?php echo base_url()?>/Web/Home/payment_action" method="post">
            <div class="row ">
                <div class="col-12 text-center" style="margin-bottom: 85px;">
                    <p class="cor-title"> পেমেন্ট</p>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-6">
                    <div class="row">
                        <div class="col-sm-4 col-md-4 col-lg-4 bkash">
                            <img src="<?php echo base_url() ?>/assets_web/image/bkash.svg" alt="" width="100%">

                            <input type="radio" class="btn-check" name="paument_type" id="option1" autocomplete="off" checked
                                   value="bkash"/>
                            <label class="btn btn-outline-primary btn-pay-web" for="option1">select</label>
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-4 roket">
                            <img src="<?php echo base_url() ?>/assets_web/image/roket.svg" alt="" width="100%">

                            <input type="radio" class="btn-check" name="paument_type" id="option2" autocomplete="off"
                                   value="roket"/>
                            <label class="btn btn-outline-primary btn-pay-web" for="option2">select</label>
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-4 nagad">
                            <img src="<?php echo base_url() ?>/assets_web/image/nogod.svg" alt="" width="100%">

                            <input type="radio" class="btn-check" name="paument_type" id="option3" autocomplete="off"
                                   value="nagad"/>
                            <label class="btn btn-outline-primary btn-pay-web" for="option3">select</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 ">

                    <div class="row h-100 justify-content-center align-items-center text-capitalize" style="height: 200px !important;">
                        <div class="col-sm-4 col-md-4 col-lg-4">
                           <p style="margin-left: 10px;"> <?php echo $course->course_name; ?></p>
                            <input type="hidden" name="course_id" value="<?php echo $course->course_id; ?>">
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <p><?php echo $course->price; ?>৳</p>
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" required>
                            <label class="form-check-label" for="flexCheckDefault">I agree with the <br><a href="<?php echo base_url()?>/Web/Home/tarmsandcondition" target="_blank">terms and conditions</label>
                            <button type="submit" class="btn btn-pay-c mt-2">Pay</button>
                        </div>
                    </div>

                </div>


            </div>
        </form>
    </div>
</section>