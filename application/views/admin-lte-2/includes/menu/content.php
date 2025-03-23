<?php $pengaturan = $this->db->get('tbl_pengaturan')->row(); ?>
<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php // echo $pengaturan->judul ?>
                <small><?php // echo $pengaturan->kota ?></small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <?php $err_msg = $this->session->flashdata('form_error') ?>
            <?php $msg = $this->session->flashdata('login') ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">ALUR PENDAFTARAN</h3>
                        </div>
                        <div class="box-body">
                            <p><img src="<?php echo base_url('assets/theme/admin-lte-2/dist/img/alur_pendaftaran.jpg') ?>"></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header with-border text-center">
                            <a href="https://esensia.co.id" class="h1"><img src="<?php echo base_url('assets/theme/admin-lte-3/dist/img/' . (!empty($pengaturan->logo) ? $pengaturan->logo : 'AdminLTELogo.png')); ?>" alt="<?php echo $pengaturan->judul . ' Logo'; ?>" class="brand-image img-rounded" style="width: 209px; height: 94px; background-color: #fff;"></a>
                        </div>
                        <div class="box-body">
                            <?php echo (!empty($msg) ? $msg : '') ?>
                            <?php echo form_open(base_url('pasien/cek_login.php'), 'autocomplete="off"') ?>
                            <div class="form-group <?php echo (!empty($err_msg['user']) ? 'has-error' : '') ?>">
                                <label for="exampleInputPassword1">No. RM</label>
                                <div class="input-group">
                                    <?php echo form_input(array('name' => 'user', 'class' => 'form-control', 'placeholder' => 'Gunakan No RM anda (cth: pke00001) ...', 'value' => $this->session->flashdata('user'))) ?>
                                    <span class="input-group-addon"><i class="fa fa-user-alt"></i></span>
                                </div>
                            </div>
                            <div class="form-group <?php echo (!empty($err_msg['pass']) ? 'has-error' : '') ?>">
                                <label for="exampleInputPassword1">Kata Sandi</label>
                                <div class="input-group">
                                    <?php echo form_input(array('id' => 'tgl', 'name' => 'pass', 'class' => 'form-control', 'placeholder' => 'Gunakan Tgl Lahir (cth: 17-08-1945) ...', 'readonly' => 'TRUE')) ?>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php echo $recaptcha; ?>
                            </div>
                            <button type="submit" name="login" value="login_aksi" class="btn btn-success btn-block btn-flat"><i class="fa fa-sign-in-alt"></i> Masuk</button>
                            <?php echo form_close() ?>
                        </div>
                        <div class="box-footer">                            
                            <div class="social-auth-links text-center">
                                <p>- ATAU -</p>
                                <?php echo anchor(base_url('pasien/pendaftaran_baru.php'), '<i class="fa fa-user-plus"></i> PASIEN BARU', 'class="btn btn-block btn-primary btn-flat"') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.container -->
</div>
<style>
    .clicked {
        background-color: #ffff00;
    }
</style>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.min.css') ?>">

<!--Datepicker-->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">


<!--API Recaptcha-->
<script src='https://www.google.com/recaptcha/api.js'></script>

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