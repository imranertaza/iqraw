<section class="extra-head" style="margin-top: 30px;">
    <img src="<?php echo base_url() ?>/assets/image/payment-img.svg" alt="banner" class="bn-cl">
</section>

<section class="content-2" style="margin-bottom: 90px;">
    <div class="row pt-2 payment">

<!--        <div class="col-4">-->
<!--            <img src="--><?php //echo base_url() ?><!--/assets/image/bkash.svg" alt="wallet" class="wallet">-->
<!--            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" value="bkash" >-->
<!--            <label class="btn btn-outline-success d-block mt-3 shadow-none disabled" for="btnradio1">Select</label>-->
<!--        </div>-->
<!--        <div class="col-4">-->
<!--            <img src="--><?php //echo base_url() ?><!--/assets/image/roket.svg" alt="wallet" class="wallet">-->
<!--            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" value="roket" >-->
<!--            <label class="btn btn-outline-success d-block mt-3 shadow-none disabled" for="btnradio2">Select</label>-->
<!--        </div>-->
<!--        <div class="col-4">-->
<!--            <img src="--><?php //echo base_url() ?><!--/assets/image/nogod.svg" alt="wallet" class="wallet">-->
<!--            <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off" value="nogod" >-->
<!--            <label class="btn btn-outline-success d-block mt-3 shadow-none disabled" for="btnradio3">Select</label>-->
<!--        </div>-->



        <div class="col-12">
            <form class="form-inline" action="<?php print API_URL; ?>" method="POST">
                <?= csrf_field() ?>
            <table class="table mt-5 text-center">
                <tbody>
                    <tr>
                        <td>Total</td>
                        <td><?php print $pack->m_fee;?>৳</td>

                    </tr>

                    <tr>
                        <td>Due</td>
                        <td id="dueData"><?php print $pack->m_fee;?>৳</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="checkbox" id="terms" name="opt_c" style="width: 13px;" required>
                            <label for="terms" class="label-tarm">I agree with the <a style="color:#39aa35;" href="<?php print base_url(); ?>/Web/Home/tarmsandcondition" target="_blank">terms and conditions</a></label>
                            <input type="hidden" name="class_subscription_package_id" value="<?php echo $pack->class_subscription_package_id ?>">
                        </td>
                    </tr>
                    <tr>
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
                        <input type="hidden" readonly class="form-control" value="<?php echo base_url()?>/Mobile_app/Class_subscribe/sub_action" name="success_url">
                        <input type="hidden" readonly class="form-control" value="<?php echo base_url()?>/Mobile_app/Class_subscribe/failed_action" name="fail_url">
                        <input type="hidden" readonly class="form-control" value="<?php echo base_url()?>/Mobile_app/Class_subscribe/canceled" name="cancel_url">
                        <input type="hidden" readonly class="form-control" value="Class Subscription Enroll" name="desc">
                        <input type="hidden" name="opt_a" value="<?php echo $pack->class_subscription_package_id ?>">
                        <input type="hidden" name="opt_b" value="<?php print $std_info->std_id; ?>">
                        <input type="hidden" readonly class="form-control" value="<?php echo $pack->m_fee; ?>" name="amount">
                        <td colspan="2"><button type="submit" class="btn a-btn text-white mt-3">Continue</button></td>
                    </tr>
                </tbody>
            </table>
            </form>


        </div>

    </div>
</section>