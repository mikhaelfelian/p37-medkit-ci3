<?php $pengaturan = $this->db->get('tbl_pengaturan')->row(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk | <?php echo $pengaturan->judul ?></title>

    <!--ICON ESENSIA-->
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/theme/admin-lte-3/dist/img/favicon.ico') ?>">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
        integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/dist/css/adminlte.min.css'); ?>">

    <!-- icheck bootstrap -->
    <link rel="stylesheet"
        href="<?php echo base_url('assets/theme/admin-lte-3/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery/jquery.min.js') ?>"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>

    <!-- Bootstrap -->
    <script
        src="<?php echo base_url('assets/theme/admin-lte-3/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- AdminLTE -->
    <script src="<?php echo base_url('assets/theme/admin-lte-3/dist/js/adminlte.js'); ?>"></script>

    <!--API Recaptcha-->
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <!-- Toastr -->
    <link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
    <script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-success rounded-0">
            <div class="card-header text-center">
                <a href="#" class="h1"><img
                        src="<?php echo base_url('assets/theme/admin-lte-3/dist/img/' . (!empty($pengaturan->logo) ? $pengaturan->logo : 'AdminLTELogo.png')); ?>"
                        alt="<?php echo $pengaturan->judul . ' Logo'; ?>" class="brand-image img-rounded"
                        style="width: 209px; height: 94px; background-color: #fff;"></a>
                        test
            </div>
            <div class="card-body">
                <?php $msg = $this->session->flashdata('login') ?>
                <?php $hasError = $this->session->flashdata('form_error'); ?>

                <?php echo form_open(base_url('cek_login.php'), 'autocomplete="off"') ?>
                <div class="input-group mb-3">
                    <?php echo form_input([
                        'name' => 'user',
                        'class' => 'form-control rounded-0' . (!empty($hasError['user']) ? ' is-invalid' : ''),
                        'placeholder' => 'Username ...',
                        'value' => $this->session->flashdata('user')
                    ]) ?>
                    <div class="input-group-append">
                        <div class="input-group-text rounded-0">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <?php if (!empty($hasError['user'])) { ?>
                        <span id="exampleInputPassword1-error"
                            class="error invalid-feedback"><?php echo $hasError['user']; ?></span>
                    <?php } ?>
                </div>
                <div class="input-group mb-3">
                    <?php echo form_password([
                        'name' => 'pass',
                        'class' => 'form-control rounded-0' . (!empty($hasError['pass']) ? ' is-invalid' : ''),
                        'placeholder' => 'Kata Sandi ...'
                    ]) ?>
                    <div class="input-group-append">
                        <div class="input-group-text rounded-0">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <?php if (!empty($hasError['pass'])) { ?>
                        <span id="exampleInputPassword1-error"
                            class="error invalid-feedback"><?php echo $hasError['pass']; ?></span>
                    <?php } ?>
                </div>
                <div class="input-group mb-3">
                    <?php echo $recaptcha; ?>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" name="login" value="login_aksi"
                            class="btn btn-primary btn-block rounded-0">Masuk</button>
                    </div>
                    <!-- /.col -->
                </div>
                <?php echo form_close() ?>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- Page script -->
    <script type="text/javascript">
        $(function () {
            <?php echo $this->session->flashdata('login_toast'); ?>
        });
    </script>
</body>
</html>