<!DOCTYPE html>
<html lang="en">
<head>
    <title>iqraw</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo base_url() ?>/assets/image/faveiocn.png" type="image/x-icon">
    <link href="<?php base_url();?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php base_url();?>/assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">

    <script src="<?php base_url();?>/assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/b4655c4a4e.js" crossorigin="anonymous"></script>

    <script src="<?php base_url();?>/assets/js/jquery.min.js"></script>

</head>
<body>
<section class="header">
    <div class="header-bac">
        <div style="width: 30%;float: left; margin-top: 10px;">
            <?php $proImg = (empty($student->pic))?'noimage.png':$student->std_id.'/'.$student->pic; ?>
            <a href="<?php echo base_url()?>/Mobile_app/Profile"><img src="<?php base_url();?>/assets/upload/profile/<?php echo $proImg;?>"  alt="banner" class="img-pro"></a>
        </div>
        <div style="width: 40%;float: left;text-align: center; margin-top: 10px;color: #ffffff;line-height: 30px; ">
            <p class="c-h">My Point</p>
            <p class="c-t" style="margin-top: -5px;"><?php echo numberView($student->point);?></p>
        </div>
        <div style="width: 30%;float: left;text-align: right; margin-top: 10px;">
            <a href="" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><img src="<?php base_url();?>/assets/image/icon-settings.svg" alt="banner" class="h-ico"></a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="<?php echo base_url('/Mobile_app/SignUp/logout')?>">LogOut</a></li>
            </ul>
        </div>
    </div>
    <img src="<?php base_url();?>/assets/image/porasona vari moja.png" alt="banner" class="home-banner">
</section>