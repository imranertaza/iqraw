<!DOCTYPE html>
<html lang="en">
<head>
    <title>iqraw</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php base_url();?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php base_url();?>/assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">

    <script src="<?php base_url();?>/assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/b4655c4a4e.js" crossorigin="anonymous"></script>

    <script src="<?php base_url();?>/assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url()?>/assets/js/sweetalert2@11.js"></script>

</head>
<body>
<section class="header" style="margin-top: 10px;">
    <div class="head">
        <a href="<?php echo $back_url;?>" style="float: left; color: #000000;"><img src="<?php base_url();?>/assets/image/arrow-left.svg" alt="icon"></a>
        <a href="<?php echo $cart_url;?>" id="reloadCart">
            <?php if (!empty(Cart()->totalItems())){?>
            <span class="position-absolute translate-middle badge rounded-pill bg-danger badge_cus"><?php echo Cart()->totalItems();?></span>
            <?php } ?>
            <img src="<?php base_url();?>/assets/image/shopping-bag.svg" alt="shopping" class="float-end"></a>
        <form class="search-form float-end" id="search-form" style="margin-right: 35px;">
            <input class="search expandright" oninput="searchPro(this.value)" id="searchright" type="search" name="q" placeholder="Search">
            <label class="button searchbutton" for="searchright"><span class="mglass" style="font-size: 30px;">&#9906;</span></label>
        </form>
    </div>
</section>