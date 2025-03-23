<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Stok <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Data Stok</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-4">
                <?php // echo form_open(base_url('gudang/data_barang_' . (isset($_GET['id']) ? 'update' : 'simpan') . '.php')) ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Stok</h3>
                    </div>
                    <div class="box-body">
                        <?php echo $this->session->flashdata('master'); ?>
                        <?php $hasError = $this->session->flashdata('form_error'); ?>
                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                        <div class="form-group <?php echo (!empty($hasError['satKcl']) ? 'has-error' : '') ?>">
                            <label class="control-label">Kode</label>
                            <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control', 'readonly'=>'TRUE', 'value' => $barang->kode)) ?>
                        </div>

                        <div class="form-group <?php echo (!empty($hasError['satBsr']) ? 'has-error' : '') ?>">
                            <label class="control-label">Nama Stok</label>
                            <?php echo form_input(array('id' => 'barang', 'name' => 'barang', 'class' => 'form-control', 'readonly'=>'TRUE', 'value' => $barang->produk)) ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">                                
                                <div class="form-group <?php echo (!empty($hasError['jml']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Jumlah</label>
                                    <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'readonly'=>'TRUE', 'value' => $barang->jml)) ?>
                                </div>  
                            </div>
                            <div class="col-lg-6">                                
                                <div class="form-group <?php echo (!empty($hasError['jml']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Satuan</label>
                                    <select name="satuan" readonly="TRUE" class="form-control">
                                        <option value="">- Pilih -</option>
                                        <?php foreach ($satuan as $satuan){ ?>
                                            <option value="<?php echo $satuan->id ?>" <?php echo ($barang->id_satuan == $satuan->id ? 'selected' : '') ?>><?php echo $satuan->satuanTerkecil.' ('.$satuan->satuanBesar.')('.$satuan->jml.')' ?></option>
                                        <?php } ?>
                                    </select>
                                </div>  
                            </div>
                        </div>                    
                    </div>
                    <div class="box-footer">                        
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" onclick="window.location.href = '<?php echo base_url('gudang/data_stok_list.php') ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>
                            </div>
                            <div class="col-lg-6 text-right">
                                <!--<button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>-->
                            </div>
                        </div>
                    </div>
                </div>
                <?php // echo form_close() ?>
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
    $("#harga_jual").autoNumeric({aSep: '.', aDec: ',', aPad: false});
    $("#harga_grosir").autoNumeric({aSep: '.', aDec: ',', aPad: false});
    
    $("#jml").keydown(function (e) {
        // kibot: backspace, delete, tab, escape, enter .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // kibot: Ctrl+A, Command+A
                        (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // kibot: home, end, left, right, down, up
                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // Biarin wae, ga ngapa2in return false
                    return;
                }
                // Cuman nomor
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
});
</script>