<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo base_url() ?>/assets/image/faveiocn.png" type="image/x-icon">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url()?>/backhand/assets/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url()?>/backhand/assets/css/ionicons.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php echo base_url()?>/backhand/assets/css/bootstrap-4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>/backhand/assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>/backhand/assets/css/responsive.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url()?>/backhand/assets/css/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>/backhand/assets/css/css.css">

    <link rel="stylesheet" href="<?php echo base_url()?>/backhand/assets/css/richtext.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href="<?php echo base_url()?>/backhand/assets/fontawesome/css/all.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="<?php echo base_url()?>/backhand/assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>/backhand/assets/js/jquery.richtext.js"></script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Home</a>
            </li>

        </ul>

        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>



        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link"  href="#">
                    <i class="far fa-comments"></i>
                    <span class="badge badge-danger navbar-badge"></span>
                    <span class="badge badge-danger navbar-badge"></span>
                    <span class="badge badge-danger navbar-badge"></span>

                </a>

            </li>
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item">
<!--                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">-->
<!--                    <i class="fas fa-th-large"></i>-->
<!--                </a>-->
                <a href="<?php print site_url("Admin/Login/logout"); ?>" class="nav-link">Logout</a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link text-center">
            iQraw
<!--            --><?php //$logoside = no_image_view('/backhand/assets/upload/hospital/'.newSession()->h_Id.'/'. hospitalLogo(),'/backhand/assets//upload/hospital/no_image.jpg',$imageName = '1')?>
<!--            <img src="--><?php //echo $logoside;?><!--" alt="--><?php //echo hospitalName();?><!--" class=" elevation-3" style="opacity: .8;width: 200px;">-->
        </a>