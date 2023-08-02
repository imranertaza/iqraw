<section class="content-one con-mr">
    <div class="container">
        <div class="row ">
            <div class="col-3"></div>
            <div class="col-6">
                <form id="subscribe_form" class="form-inline" action="<?php print API_URL; ?>" method="POST">
                    <?= csrf_field() ?>
                    <?php foreach ($pack as $key => $pa){ ?>
                        <div class="form-check box mt-3">
                            <input class="form-check-input" onclick="pack_sub_calculate()" type="radio" data-price="<?php echo $pa->m_fee;?>" name="class_subscription_package_id" id="exampleRadios_<?php echo $pa->class_subscription_package_id;?>"
                                   value="<?php echo $pa->class_subscription_package_id;?>" <?php if (!isset(newSession()->packId)){ echo ($key == 0)?'checked':'';}else{ echo (newSession()->packId == $pa->class_subscription_package_id)?'checked':''; }?> >
                            <label class="form-check-label d-flex justify-content-between" for="exampleRadios_<?php echo $pa->class_subscription_package_id;?>">
                                <div class="text-1">
                                    <p class="m-0 text-1-t"><?php echo $pa->name;?></p>
                                    <p class="m-0 text-1-t-2"><?php echo $pa->short_description;?></p>
                                </div>
                                <div class="text-2">
                                    <p><?php echo $pa->m_fee;?>৳</p>
                                </div>
                            </label>
                        </div>
                    <?php } ?>

                    <table class="table mt-5 text-center">
                        <tbody>
                        <tr>
                            <td><b>Total</b></td>
                            <td id="tp"></td>
                        </tr>
                        <tr>
                            <td><b>Due</b></td>
                            <td id="dp"></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="form-check box mt-3" style="padding-top: 0px;">
                                    <input class="form-check-input" type="radio" onclick="paymentmethod('<?php print API_URL; ?>')"  name="payment_met" id="payment_amarPay" value="1" checked >
                                    <label class="form-check-label d-flex justify-content-between" style="margin-top: 12px;" for="payment_amarPay" >Aamarpay</label>
                                </div>

                                <div class="form-check box mt-3" style="padding-top: 0px;">
                                    <input class="form-check-input" type="radio" onclick="paymentmethod('<?php print base_url('/Web/Class_subscribe/sub_manual_action'); ?>')"  name="payment_met" id="payment_genarel" value="2"  >
                                    <label class="form-check-label d-flex justify-content-between" style="margin-top: 12px;" for="payment_genarel" >Manual pay</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="checkbox" id="terms" name="opt_c" style="width: 13px;" required>
                                <label for="terms" class="label-tarm">I agree with the <a style="color:#39aa35;" href="<?php print base_url(); ?>/Web/Home/tarmsandcondition" target="_blank">terms and conditions</a></label>
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
                            <input type="hidden" readonly class="form-control" value="<?php echo base_url()?>/Web/Class_subscribe/sub_action" name="success_url">
                            <input type="hidden" readonly class="form-control" value="<?php echo base_url()?>/Web/Class_subscribe/canceled" name="fail_url">
                            <input type="hidden" readonly class="form-control" value="<?php echo base_url()?>/Web/Class_subscribe/canceled" name="cancel_url">
                            <input type="hidden" readonly class="form-control" value="Class Subscription Enroll" name="desc">
                            <input type="hidden" class="form-control" name="opt_a" id="opt_a" >
                            <input type="hidden"  name="opt_b" value="<?php print $std_info->std_id; ?>">
                            <input type="hidden"  class="form-control" id="amount"  name="amount">
                            <td colspan="2"><button type="submit" class="btn a-btn text-white mt-3">Continue</button></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</section>