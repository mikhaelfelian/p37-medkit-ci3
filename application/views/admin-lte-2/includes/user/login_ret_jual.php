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
    </head>
<body class="hold-transition login-page">
<div class="login-box">    
    <?php $err_msg = $this->session->flashdata('form_error') ?>
    <?php $msg = $this->session->flashdata('login') ?>
    <!-- /.login-logo -->
    <div class="login-box-body">        
        <?php echo (!empty($msg) ? $msg : '<p class="login-box-msg">Silahkan masukkan autentifikasi owner, untuk melanjutkan retur</p>') ?>
        <!-- iCheck  -->
        <p class="text-danger"><i>* Harus menggunakan level akun owner / administrator</i></p>
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
        <?php echo form_open(base_url('cek_login_ret_jual.php'), 'autocomplete="off"') ?>
        <?php echo form_hidden('rute', 'transaksi/trans_retur_jual.php?no_nota='.general::enkrip($sql_penj->id).'&route=input_retur_jual.php') ?>
        
        <div class="form-group has-feedback <?php echo (!empty($err_msg['user']) ? 'has-error' : '') ?>">
            <?php echo form_input(array('name' => 'user', 'class' => 'form-control', 'placeholder' => 'Username ...', 'value' => $this->session->flashdata('user'))) ?>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback  <?php echo (!empty($err_msg['pass']) ? 'has-error' : '') ?>">
            <?php echo form_password(array('name' => 'pass', 'class' => 'form-control', 'placeholder' => 'Kata Sandi ...')) ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
            </div>
            <!-- /.col -->
        </div>
        <?php echo form_close() ?>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
</body>
</html>