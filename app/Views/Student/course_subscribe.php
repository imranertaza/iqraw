<section class="extra-head" style="margin-top: 30px;">
    <img src="<?php echo base_url() ?>/assets/image/payment-img.svg" alt="banner" class="bn-cl">
</section>

<section class="content-2" style="margin-bottom: 90px;">
    <form action="<?php echo base_url()?>/Mobile_app/Course/sub_action" method="post">
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



        <div class="col-12">

            <table class="table mt-5 text-center">
                <tbody>
                    <tr>
                        <td>Total</td>
                        <td><?php print $course->price;?>৳</td>

                    </tr>

                    <tr>
                        <td>Due</td>
                        <td id="dueData"><?php print $course->price;?>৳</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="checkbox" id="terms" name="terms" style="width: 13px;" required>
                            <label for="terms" class="label-tarm">I agree with the <a href="https://iqraw.com/tarmsandcondition.html" target="_blank">terms and conditions</a></label>
                            <input type="hidden" name="course_id" value="<?php echo $course->course_id ?>">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><button type="submit" class="btn a-btn text-white mt-3">Subscribe</button></td>
                    </tr>
                </tbody>
            </table>



        </div>

    </div>
    </form>
</section>