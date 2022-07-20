

    <section class="extra-head">
    <img src="<?php base_url();?>/assets/image/profile-ban.svg" alt="banner" class="bn-cl">
    <a href="#"><img src="<?php base_url();?>/assets/image/edit-pen.svg" alt="profile" class="pro-edit"></a>
    <center><img src="<?php base_url();?>/assets/upload/profile/<?php echo $user->std_id;?>/<?php echo $user->pic;?>" alt="profile" class="pro-pic"></center>
    <center><img src="<?php base_url();?>/assets/image/1st.svg" alt="profile" class="pro-lavel"></center>
    <center><p class="h-t"><?php echo $user->name;?> <a href="#"><img src="<?php base_url();?>/assets/image/edit-pen.svg"></a></p></center>
</section>

    <section class="content" style="margin-bottom: 90px; margin-top: -90px;">
    <div class="row pt-2">
        <div class="col-6 text-center mt-4">
            <p class="num-p">85</p>
            <p class="text-p">Total Exam Attend</p>
        </div>
        <div class="col-6 text-center mt-4">
            <p class="num-p"><?php echo numberView($user->point);?></p>
            <p class="text-p">Total point</p>
        </div>
        <div class="col-6 text-center mt-4">
            <p class="num-p"><?php echo get_data_by_id('name','class','class_id',$user->class_id) ;?></p>
            <p class="text-p">Class</p>
        </div>
        <div class="col-6 text-center mt-4">
            <p class="num-p"><?php echo numberView($user->coin);?></p>
            <p class="text-p">Total Coin</p>
        </div>
        <div class="col-6 text-center mt-4">
            <p class="num-p">2</p>
            <p class="text-p">Total Skill</p>
        </div>
        <div class="col-6 text-center mt-4">
            <img src="<?php base_url();?>/assets/image/1st.svg" alt="profile" class="lab-bat">
            <p class="text-p">Top Batch</p>
        </div>
    </div>
</section>