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


    <section class="content mt-5">
        <form action="<?php echo base_url('Mobile_app/My_class/package_purchase')?>"  method="post">
            <div class="row">
                <div class="col-12">
                    <p class="title-n-n m-0">সুবিধামত ফি পরিশোধ করুন</p>
                    <p class="title-n-t m-0">লাইভ ক্লাস, পরীক্ষা– সব নিয়ে বছরব্যাপী পড়াশোনার আয়োজন</p>
                </div>
                <div class="col-12 mt-4">
                    <?php foreach ($pack as $key => $pa){ ?>
                        <div class="form-check box mt-3">
                            <input class="form-check-input"  type="radio"  name="class_subscription_package_id" id="exampleRadios_<?php echo $pa->class_subscription_package_id;?>"
                                   value="<?php echo $pa->class_subscription_package_id;?>" <?php echo ($key == 0)?'checked':'';?> >
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
                </div>

                <div class="col-12">
                    <button type="submit" class="btn w-100 btn-cu-n fixed-bottom py-3 ">এগিয়ে যান</button>
                </div>
            </div>
        </form>
    </section>
</div>


</body>
</html>