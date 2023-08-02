<section class="content-three con-mr">
    <div class="container">
<!--        <form action="--><?php //echo base_url()?><!--/Web/Home/payment_action" method="post">-->
            <div class="row ">
                <div class="col-12 text-center" style="margin-bottom: 85px;">
                    <p class="cor-title"> পেমেন্ট</p>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-6">
                    <div class="row">
                        <div class="col-sm-4 col-md-4 col-lg-4 bkash">
                            <img src="<?php echo base_url() ?>/assets_web/image/bkash.svg" alt="" width="100%">

                            <input type="radio" class="btn-check" name="paument_type" id="option1" autocomplete="off" checked
                                   value="amarpay"/>
                            <label class="btn btn-outline-primary btn-pay-web" for="option1">select</label>
                        </div>
<!--                        <div class="col-sm-4 col-md-4 col-lg-4 roket">-->
<!--                            <img src="--><?php //echo base_url() ?><!--/assets_web/image/roket.svg" alt="" width="100%">-->
<!---->
<!--                            <input type="radio" class="btn-check" name="paument_type" id="option2" autocomplete="off"-->
<!--                                   value="roket"/>-->
<!--                            <label class="btn btn-outline-primary btn-pay-web" for="option2">select</label>-->
<!--                        </div>-->
<!--                        <div class="col-sm-4 col-md-4 col-lg-4 nagad">-->
<!--                            <img src="--><?php //echo base_url() ?><!--/assets_web/image/nogod.svg" alt="" width="100%">-->
<!---->
<!--                            <input type="radio" class="btn-check" name="paument_type" id="option3" autocomplete="off"-->
<!--                                   value="nagad"/>-->
<!--                            <label class="btn btn-outline-primary btn-pay-web" for="option3">select</label>-->
<!--                        </div>-->
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 ">
                    <form class="form-inline" action="<?php print API_URL; ?>" method="POST">
                        <?= csrf_field() ?>
                    <div class="row h-100 justify-content-center align-items-center text-capitalize" style="height: 200px !important;">
                        <input type="hidden" readonly class="form-control" value="<?php print STORE_ID; ?>" name="store_id">
                        <input type="hidden" readonly class="form-control" value="VISA" name="payment_type">
                        <input type="hidden" readonly class="form-control" value="BDT" name="currency">
                        <input type="hidden" readonly class="form-control" value="<?php print TRANSECTION_PREFIX.rand(111111111111,999999999999); ?>" name="tran_id">
                        <input type="hidden" readonly class="form-control" value="<?php print $std_info->name; ?>" name="cus_name">
                        <input type="hidden" readonly class="form-control" value="<?php print $std_info->phone; ?>@iqraw.com" name="cus_email">
                        <input type="hidden" readonly class="form-control" value="<?php print $std_info->address; ?>" name="cus_add1">
                        <input type="hidden" readonly class="form-control" value="<?php print $std_info->address_2; ?>" name="cus_add2">
                        <input type="hidden" readonly class="form-control" value="<?php print $std_info->city; ?>" name="cus_city">
                        <input type="hidden" readonly class="form-control" value="<?php print $std_info->state; ?>" name="cus_state">
                        <input type="hidden" readonly class="form-control" value="<?php print $std_info->postcode; ?>" name="cus_postcode">
                        <input type="hidden" readonly class="form-control" value="<?php print $std_info->country; ?>" name="cus_country">
                        <input type="hidden" readonly class="form-control" value="<?php print $std_info->phone; ?>" name="cus_phone">
                        <input type="hidden" readonly class="form-control" value="<?php print SIGNATURE_KEY; ?>" name="signature_key">
                        <input type="hidden" readonly class="form-control" value="<?php echo base_url()?>/Web/Payment/payment_success_action" name="success_url">
                        <input type="hidden" readonly class="form-control" value="<?php echo base_url()?>/Web/Payment/payment_fail_action" name="fail_url">
                        <input type="hidden" readonly class="form-control" value="<?php echo base_url()?>/Web/Payment/payment_cancel" name="cancel_url">
                        <input type="hidden" readonly class="form-control" value="Course Enroll" name="desc">
                        <div class="col-sm-4 col-md-4 col-lg-4">
                           <p style="margin-left: 10px;"> <?php echo $course->course_name; ?></p>
                            <input type="hidden" name="opt_a" value="<?php echo $course->course_id; ?>">
                            <input type="hidden" name="opt_b" value="<?php print $std_info->std_id; ?>">
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <p><input type="text" readonly class="form-control" value="<?php echo $course->price; ?>" name="amount">৳</p>
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" required>
                            <label class="form-check-label" for="flexCheckDefault">I agree with the <br><a href="<?php echo base_url()?>/Web/Home/tarmsandcondition" target="_blank">terms and conditions</label>
                            <button type="submit" class="btn btn-pay-c mt-2">Pay</button>
                        </div>
                    </div>
                    </form>
                </div>


            </div>
<!--        </form>-->
    </div>
</section>