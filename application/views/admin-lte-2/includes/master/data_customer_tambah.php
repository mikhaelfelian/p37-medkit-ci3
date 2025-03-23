<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Pasien <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Data Pasien</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-10">
                <?php echo form_open(base_url('master/data_customer_' . (isset($_GET['id']) ? 'update' : 'simpan') . '.php'), 'autocomplete="off"') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Data Pasien</h3>
                    </div>
                    <div class="box-body">
                        <?php echo $this->session->flashdata('master'); ?>
                        <?php $hasError = $this->session->flashdata('form_error'); ?>
                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                        
                        <div class="row">
                            <div class="col-md-4">                                
                                <div class="form-group <?php echo (!empty($hasError['nik']) ? 'has-error' : '') ?>">
                                    <label class="control-label">NIK / Passport*</label>
                                    <?php echo form_input(array('id' => 'nik', 'name' => 'nik', 'class' => 'form-control', 'value' => $customer->nik)) ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Nama Lengkap</label>
                                    <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control', 'value' => $customer->nama)) ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Tgl Lahir</label>
                                    <?php echo form_input(array('id' => 'tgl_lahir', 'name' => 'tgl_lahir', 'class' => 'form-control', 'value' => $this->tanggalan->tgl_indo($customer->tgl_lahir))) ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['lokasi']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Jenis Kelamin</label>
                                    <select name="jns_klm" class="form-control">
                                        <option value="">- Pilih -</option>
                                        <option value="L" <?php echo ($customer->jns_klm == 'L' ? 'selected' : '') ?>>Laki - Laki</option>
                                        <option value="P" <?php echo ($customer->jns_klm == 'P' ? 'selected' : '') ?>>Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['no_hp']) ? 'has-error' : '') ?>">
                                    <label class="control-label">No. HP</label>
                                    <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control', 'value' => $customer->no_hp)) ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Alamat</label>
                                    <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control', 'value' => $customer->alamat)) ?>
                                </div>
                            </div>
                            <div class="col-md-8">
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">                        
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" onclick="window.location.href = '<?php echo (isset($_GET['route']) ? base_url($_GET['route']) : base_url('master/data_customer_list.php')) ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>
                            </div>
                            <div class="col-lg-6 text-right">
                                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<style>
    .clicked {
        background-color: #ffff00;
    }
</style>

<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/sb-admin') ?>/ui/jquery-ui.min.css" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.min.css') ?>">

<!--Datepicker-->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Page script -->
<script>
$(function () {
    $("#harga_beli").autoNumeric({aSep: '.', aDec: ',', aPad: false});
    $("#diskon").autoNumeric({aSep: '.', aDec: ',', aPad: false});
    
    $('#tgl_lahir').datepicker({autoclose: true});

//    $("input[id=diskon]").keydown(function (e) {
//        // kibot: backspace, delete, tab, escape, enter .
//        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
//                // kibot: Ctrl+A, Command+A
//                        (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
//                        // kibot: home, end, left, right, down, up
//                                (e.keyCode >= 35 && e.keyCode <= 40)) {
//                    // Biarin wae, ga ngapa2in return false
//                    return;
//                }
//                // Cuman nomor
//                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
//                    e.preventDefault();
//                }
//            });
});
</script>