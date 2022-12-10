<section class="extra-head" style="margin-top: 30px;">
    <img src="<?php echo base_url() ?>/assets/image/payment-img.svg" alt="banner" class="bn-cl">
</section>

<section class="content-2" style="margin-bottom: 90px;">
    <form action="<?php echo base_url('/Mobile_app/Shopping/buy_action') ?>" method="post">
    <div class="row pt-2 payment">

        <div class="col-4">
            <img src="<?php echo base_url() ?>/assets/image/bkash.svg" alt="wallet" class="wallet">
            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" value="bkash" >
            <label class="btn btn-outline-success d-block mt-3 shadow-none disabled" for="btnradio1">Select</label>
        </div>
        <div class="col-4">
            <img src="<?php echo base_url() ?>/assets/image/roket.svg" alt="wallet" class="wallet">
            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" value="roket" >
            <label class="btn btn-outline-success d-block mt-3 shadow-none disabled" for="btnradio2">Select</label>
        </div>
        <div class="col-4">
            <img src="<?php echo base_url() ?>/assets/image/nogod.svg" alt="wallet" class="wallet">
            <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off" value="nogod" >
            <label class="btn btn-outline-success d-block mt-3 shadow-none disabled" for="btnradio3">Select</label>
        </div>

        <div class="col-4 mt-4" >
<!--            <p class="coin-div">Coin --><?php //echo get_data_by_id('coin', 'student', 'std_id', newSession()->std_id) ?><!--৳</p>-->
            <img src="<?php echo base_url() ?>/assets/image/coin.png" alt="wallet" class="wallet">
            <div id="coinDiv">
            <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off" value="1" >
            <label class="btn btn-outline-success d-block mt-3 shadow-none" onclick="coinAdd()"  for="btnradio4">Select</label>
            </div>
            <input type="hidden" name="myCoin" id="myCoin" value="<?php echo get_data_by_id('coin', 'student', 'std_id', newSession()->std_id) ?>">
        </div>

        <div class="col-12">

            <table class="table mt-5 text-center">
                <tbody>
                    <tr>
                        <td>Total
                            <input type="hidden" name="sub_total" id="sub_total" value="<?php print Cart()->total();?>">
                        </td>
                        <td><?php print Cart()->total();?>৳</td>

                    </tr>
                    <tr>
                        <td id="titlePay"></td>
                        <td id="titleAmo"></td>
                    </tr>
                    <tr>
                        <td>Due</td>
                        <td id="dueData"><?php print Cart()->total();?>৳</td>
                    </tr>
                    <tr>
                        <td colspan="2"><button type="submit" class="btn a-btn text-white mt-3">Checkout</button></td>
                    </tr>
                </tbody>
            </table>


        </div>

    </div>
    </form>
</section>