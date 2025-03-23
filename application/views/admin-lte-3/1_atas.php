<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php $pengaturan = $this->db->get('tbl_pengaturan')->row(); ?>
        <title><?php echo $pengaturan->judul ?></title>
        
        <!--ICON ESENSIA-->
        <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/theme/admin-lte-3/dist/img/favicon.ico') ?>">
        
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <!--<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/fontawesome-free/css/all.min.css'); ?>">--> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- IonIcons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/dist/css/adminlte.min.css'); ?>">
        
        <!-- REQUIRED SCRIPTS -->
        <!-- jQuery -->
        <script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery/jquery.min.js') ?>"></script>
        <!-- jQuery Bootstrap 4 -->
        <script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
        <!--<script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>-->
        
        <!-- date-range-picker -->
        <script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.js') ?>"></script>
        
        <!-- Bootstrap -->
        <script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
        
        <!-- AdminLTE -->
        <script src="<?php echo base_url('assets/theme/admin-lte-3/dist/js/adminlte.js'); ?>"></script>
        
        <!-- Toastr -->
        <link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
        <script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>
</head>

    <body class="hold-transition <?php echo (!empty($layout) ? $layout : 'sidebar-mini') ?> layout-navbar-fixed">