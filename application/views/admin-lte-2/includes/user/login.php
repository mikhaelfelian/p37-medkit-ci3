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
        <link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/bootstrap/css/bootstrap.min.css') ?>">

        <!-- Font Awesome Offline -->
        <link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/font-awesome/css/font-awesome.min.css') ?>">
        <!--Ionicons Offline--> 
        <link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/ionicons/css/ionicons.min.css') ?>">

        <!-- jvectormap -->
        <link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jvectormap/jquery-jvectormap-1.2.2.css') ?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/dist/css/AdminLTE.min.css') ?>">
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/dist/css/skins/_all-skins.min.css') ?>">
        <!-- jQuery 2.2.0 -->
        <script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQuery/jQuery-2.2.0.min.js') ?>"></script>

        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo base_url('assets/theme/admin-lte-2/bootstrap/js/bootstrap.min.js') ?>"></script>

        <!-- AdminLTE App -->
        <script src="<?php echo base_url('assets/theme/admin-lte-2/dist/js/app.min.js') ?>"></script>

        <!--API Recaptcha-->
        <script src='https://www.google.com/recaptcha/api.js'></script>

        <script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
        <link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

        <!--Datepicker-->
        <script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
        <link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">    
            <?php $err_msg = $this->session->flashdata('form_error') ?>
            <?php $msg = $this->session->flashdata('login') ?>
            <div class="login-logo">
                <a href="<?php echo base_url('pasien') ?>"><b>RS</b> Esensia</a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <div class="box-header with-border text-center">
                    <a href="https://esensia.co.id" class="h1"><img src="<?php echo base_url('assets/theme/admin-lte-3/dist/img/' . (!empty($pengaturan->logo) ? $pengaturan->logo : 'AdminLTELogo.png')); ?>" alt="<?php echo $pengaturan->judul . ' Logo'; ?>" class="brand-image img-rounded" style="width: 209px; height: 94px; background-color: #fff;"></a>
                </div>
                <?php // echo (!empty($msg) ? $msg : '<p class="login-box-msg">Silahkan masuk terlebih dahulu.</p>') ?>

                <!-- iCheck  -->
                <link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/iCheck/square/blue.css') ?>">
                <script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQuery/jQuery-2.2.0.min.js') ?>"></script>
                <script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/iCheck/icheck.min.js') ?>"></script>
                <script>
                    var s = $.noConflict();
                    s(function () {
                        s('input').iCheck({
                            checkboxClass: 'icheckbox_square-blue',
                            radioClass: 'iradio_square-blue',
                            increaseArea: '20%'
                        });
                    });
                </script>
                
                <?php echo form_open(base_url('pasien/cek_login2.php'), 'autocomplete="off"') ?>
                <div class="form-group has-feedback <?php echo (!empty($err_msg['user']) ? 'has-error' : '') ?>">
                    <?php echo form_input(array('name' => 'user', 'class' => 'form-control', 'placeholder' => 'Gunakan No RM anda (cth: pke00001) ...', 'value' => $this->session->flashdata('user'))) ?>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback  <?php echo (!empty($err_msg['pass']) ? 'has-error' : '') ?>">
                    <?php echo form_input(array('id' => 'tgl', 'name' => 'pass', 'class' => 'form-control', 'placeholder' => 'Gunakan Tgl Lahir (cth: 17-08-1945) ...', 'readonly' => 'TRUE')) ?>
                    <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                </div>
                <?php echo $recaptcha; ?>
                <br/>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-xs-12">
                        <button type="submit" name="login" value="login_aksi" class="btn btn-primary btn-block btn-flat"><i class="fa fa-sign-in-alt"></i> MASUK</button>
                    </div>
                    <!-- /.col -->
                </div>
                <?php echo form_close() ?>
            </div>
            <!-- /.login-box-body -->
            <div class="box-footer">
                <div class="social-auth-links text-center">
                    <p>- ATAU -</p>
                    <?php echo anchor(base_url('pasien/pendaftaran_baru.php'), '<i class="fa fa-user-plus"></i> PASIEN BARU', 'class="btn btn-block btn-primary btn-flat"') ?>
                </div>
            </div>
        </div>
        <!-- /.login-box -->

        <!-- Page script -->
        <script type="text/javascript">
            $(function () {
                $('#tgl').datepicker({
                    format: 'dd-mm-yyyy',
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '1920:<?php echo date('Y') ?>',
                    autoclose: true
                });
            });
        </script>
    </body>
</html>