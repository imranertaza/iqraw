<section class="extra-head">
    <img src="<?php echo base_url()?>/assets/image/class-bn.svg" alt="banner" class="bn-cl" >
</section>

<section class="content" style="margin-bottom: 90px;">
    <div class="row pt-2">
            <div class="col-12 cl-p-r" >
                <table class="table text-capitalize">
                    <tbody>
                    <?php if (!empty($course)){ foreach ($course as $cor){ ?>
                        <tr>
                            <td style="padding: 18px;"><?php echo $cor->course_name;?></td>
                            <td width="60"><a href="<?php echo base_url()?>/Student/Course/details/<?php echo $cor->course_id?>" class="btn btn-join">Details</a></td>
                        </tr>
                    <?php } }else{ echo '<div class="col-6 math-p" style="padding-right: 4px !important;"><p>No data available</p> </div>';}?>
                    </tbody>
                </table>
            </div>

    </div>
</section>