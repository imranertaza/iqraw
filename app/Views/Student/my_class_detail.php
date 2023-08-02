<!DOCTYPE html>
<html lang="en">
<head>
    <title>iqraw</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo base_url() ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>/assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">

    <script src="<?php echo base_url() ?>/assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/b4655c4a4e.js" crossorigin="anonymous"></script>

    <script src="<?php echo base_url() ?>/assets/js/jquery.min.js"></script>

</head>
<body>

<div class="container-fluid">
    <section class="header">
        <div class="row">
            <div class="col-12 mt-3 mb-3  d-flex justify-content-between">
                <a href="<?php echo base_url('Mobile_app') ?>"><img src="<?php echo base_url() ?>/assets/image/logo.svg"
                                                                    alt="logo"></a>
                <a href="<?php echo base_url('Mobile_app/login') ?>" class="btn btn-n-sin">Sign In</a>
                <a href="<?php echo base_url('/Mobile_app/register') ?>" class="btn btn-n-sin">Sign Up</a>
            </div>
        </div>
    </section>


    <section class="content mt-3">
        <div class="row p-0">
            <div class="col-12 p-0">
                <iframe width="100%" class="video-big" height="250" src="<?php echo $description->video; ?>"
                        title="" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
            </div>
            <div class="col-12 mt-3">
                <p class="big-title"><?php echo $description->title; ?></p>
                <p class="big-text"><?php echo $description->short_description; ?></p>
            </div>

            <div class="col-12 mt-5">
                <p class="big-title-2">ফুল সিলেবাস কোর্সে যা যা থাকছে</p>
            </div>
            <div class="col-12 border rounded-3 p-2 syllabus">
                <?php echo $description->syllabus; ?>
            </div>

            <div class="col-12 mt-5">
                <p class="big-title-2">কোর্স সম্পর্কে বিস্তারিত</p>
            </div>

            <div class="col-12 border rounded-3 p-2 pb-4 syllabus-2">
                <p class="big-title-sub mt-3">কোর্সটি কাদের জন্য?</p>
                <?php echo $description->for_who; ?>

                <hr class="hr-n my-5">

                <p class="big-title-sub mt-3">কোর্সটি কেন প্রয়োজন?</p>

                <?php echo $description->for_why; ?>

                <hr class="hr-n my-5">

                <p class="big-title-sub mt-3">কোর্সে যা যা থাকছে:</p>
                <?php echo $description->what_is_included; ?>

            </div>

            <div class="col-12 mt-5">
                <p class="big-title-2">প্রায়শ জিজ্ঞাসিত প্রশ্নাবলী</p>
            </div>
            <div class="col-12 border rounded-3 p-2 syllabus-2">
                <?php echo $description->faq; ?>
            </div>


            <div class="col-12">
                <a href="<?php echo base_url('Mobile_app/My_class/enrol/'.$description->class_group_jnt_id) ?>"
                   class="btn w-100 rounded btn-cu-big fixed-bottom py-3 ">enrol now</a>
            </div>
        </div>
    </section>
</div>

</body>
</html>