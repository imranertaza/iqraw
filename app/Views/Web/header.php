<!DOCTYPE html>
<html lang="en">
<head>
    <title>iQraw</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo base_url()?>/assets_web/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>/assets_web/css/style2.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@600&display=swap" rel="stylesheet">
    <script src="<?php echo base_url()?>/assets_web/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/b4655c4a4e.js" crossorigin="anonymous"></script>

    <script src="<?php echo base_url()?>/assets_web/js/jquery.min.js"></script>

</head>
<body>
<section class="nav-menu">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <div class="d-flex flex-grow-1">
                            <a class="navbar-brand d-none d-lg-inline-block" href="<?php echo base_url()?>"> <img src="<?php echo base_url()?>/assets_web/image/logo-web.svg" alt="" class="logo-img"> </a>
                            <a class="navbar-brand-two mx-auto d-lg-none d-inline-block" href="<?php echo base_url()?>">
                                <img src="<?php echo base_url()?>/assets_web/image/logo-web.svg" alt="" >
                            </a>

                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup"
                                    aria-expanded="false" aria-label="Toggle navigation" style="margin-right: 35px;">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </div>
                        <div class="collapse navbar-collapse flex-grow-1 text-right" id="navbarNavAltMarkup">
                            <div class="navbar-nav ms-auto flex-nowrap top-n">
                                <a class="nav-link " href="<?php echo base_url()?>/Web/Home/product">Product</a>
                                <a class="nav-link " href="<?php echo base_url()?>/Web/Home/course">Course</a>
                                <a class="nav-link" href="<?php echo base_url()?>/Web/Home/about_us">About us</a>
                                <a class="nav-link" href="<?php echo base_url()?>/Web/Home/contact_us">Contact us</a>
                                <?php $isLoggedInWeb = newSession()->isLoggedInWeb; if (!isset($isLoggedInWeb) || $isLoggedInWeb != TRUE) { ?>
                                    <a href="<?php echo base_url()?>/Web/Login" class="btn btn-sing mr-l">Sign in</a>
                                    <a href="<?php echo base_url()?>/Web/Login/sign_up" class="btn btn-sing ">Sign up</a>
                                <?php }else{ ?>
                                    <a class="nav-link" href="<?php echo base_url()?>/Web/Dashboard">Dashboard</a>
                                    <a class="nav-link" href="<?php echo base_url()?>/Web/Login/logout">Logout</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</section>