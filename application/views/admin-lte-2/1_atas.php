<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?php echo $meta_equiv; ?>
        <?php $pengaturan = $this->db->get('tbl_pengaturan')->row(); ?>
        <title><?php echo $pengaturan->judul ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/bootstrap/css/bootstrap.css') ?>">

        <!--ICON ESENSIA-->
        <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/theme/admin-lte-3/dist/img/favicon.ico') ?>">
        
        <!-- Font Awesome Offline -->
        <!--<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/font-awesome/css/font-awesome.min.css') ?>">-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-fD9DI5bZwQxOi7MhYWnnNPlvXdp/2Pj3XSTRrFs5FQa4mizyGLnJcN6tuvUS6LbmgN1ut+XGSABKvjN0H6Aoow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        
        <!--Ionicons Offline--> 
        <link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/ionicons/css/ionicons.min.css') ?>">

        <!-- jvectormap -->
        <link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jvectormap/jquery-jvectormap-1.2.2.css') ?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/dist/css/AdminLTE.css') ?>">
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/dist/css/skins/_all-skins.min.css') ?>">
        
        <!-- REQUIRED SCRIPTS -->
        <!-- jQuery -->
        <script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery/jquery.min.js') ?>"></script>
        <!-- jQuery Bootstrap 4 -->
        <script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
        <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
        
        <!-- date-range-picker -->
        <script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.js') ?>"></script>
        
        <!-- Bootstrap -->
        <script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

        <!-- AdminLTE App -->
        <script src="<?php echo base_url('assets/theme/admin-lte-2/dist/js/app.min.js') ?>"></script>
        
    </head>
    <!--<body class="hold-transition <?php // echo (!empty($login) ? 'login-page' : 'skin-blue layout-top-nav') ?>">-->
    <body class="hold-transition <?php echo (akses::aksesLogin() == TRUE ? 'skin-blue sidebar-mini' : 'skin-blue layout-top-nav') ?>">
    <!--layout-top-nav-->
    <!--<body class="hold-transition skin-green layout-top-nav">-->
