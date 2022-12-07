<section class="extra-head">
    <!--    <img src="--><?php //echo base_url()?><!--/assets/image/class-bn.svg" alt="banner" class="bn-cl" >-->
</section>

<section class="content-2" style="margin-bottom: 90px;">
    <div class="row pt-2">
        <div class="col-12 main-row text-capitalize">
            <div style="width: 40%;float: left;">
                <p class="r-n"><?php echo $studentBig->name ?><br>
                    <?php echo get_data_by_id('school_name','student','std_id',$studentBig->std_id);?></p>
            </div>
            <div style="width: 30%;float: left;" class="text-center" >
                <p class="r-n"><a href="#" style="color: #ffffff;"><?php echo $studentBig->point ?>P</a></p>
            </div>
            <div style="width: 30%;float: left;" class="r-n text-center">
                <i class="fa-solid fa-star r-star"></i>Top<i class="fa-solid fa-star r-star"></i>
            </div>
<!--            <div style="width: 20%;float: left;" class="text-center">-->
<!--                <img src="--><?php //echo base_url()?><!--/assets/image/1st.svg" alt="" class="r-h-st">-->
<!--            </div>-->
        </div>
        <div class="col-12">
            <table class="table text-capitalize">
                <tbody>
                <?php foreach ($student as $val){ $you = ($val->std_id == newSession()->std_id)?'You':''; $url = ($val->std_id == newSession()->std_id)?base_url('Student/Profile'):'#'; $schoolName = get_data_by_id('school_name','student','std_id',$val->std_id);  ?>
                    <tr class="<?php echo $you;?>">
                        <td  style="padding-top: 15px;" class="<?php echo $you;?>_p"><a href="<?php echo $url?>"><?php echo $val->name;?><br><?php echo $schoolName;?></a></td>
                        <td style="padding-top: 15px;" class="<?php echo $you;?>_p"><?php echo $val->point;?>p</td>
                        <td class="<?php echo $you;?>_p"><?php echo $you;?></td>
<!--                        <td width="20" class="--><?php //echo $you;?><!--_p2"><img src="--><?php //echo base_url()?><!--/assets/image/2nd.svg" alt="" class="r-h-st"></td>-->
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>