<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Persediaan Awal <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Persediaan Awal</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-4">
                <?php echo form_open(base_url('akuntability/data_pers_'.(isset($_GET['id']) ? 'update' : 'simpan').'.php')) ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Data Persediaan Awal</h3>
                    </div>
                    <div class="box-body">
                        <?php echo $this->session->flashdata('master'); ?>
                        <?php $hasError = $this->session->flashdata('form_error'); ?>
                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                        <div class="form-group <?php echo (!empty($hasError['nominal']) ? 'has-error' : '') ?>">
                            <label class="control-label">Tanggal Simpan</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <?php echo form_input(array('id' => 'tgl_simpan', 'name' => 'tgl_simpan', 'class' => 'form-control', 'value' => $this->tanggalan->tgl_indo($pers->tgl_simpan))) ?>
                            </div>                            
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['nominal']) ? 'has-error' : '') ?>">
                            <label class="control-label">Nominal</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    Rp
                                </div>
                                <?php echo form_input(array('id' => 'nominal', 'name' => 'nominal', 'class' => 'form-control', 'value' => $pers->nominal)) ?>
                            </div>                            
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['satBsr']) ? 'has-error' : '') ?>">
                            <label class="control-label">Keterangan</label>
                            <?php echo form_input(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control', 'value' => $pers->keterangan)) ?>
                        </div>                      
                    </div>
                    <div class="box-footer">                        
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" onclick="window.location.href = '<?php echo base_url('akuntability/data_pers_list.php') ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>
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
    $("#nominal").autoNumeric({aSep: '.', aDec: ',', aPad: false});  
    $('#tgl_simpan').datepicker({ autoclose: true });
});
</script>