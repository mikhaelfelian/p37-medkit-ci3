<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Stok <small>Opname</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Data Stok Opname Detail</li>
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
                            <label class="control-label">Tanggal Opname</label>
                            <?php echo form_input(array('id' => 'tgl_masuk', 'name' => 'tgl_masuk', 'class' => 'form-control', 'readonly'=>'TRUE', 'value' => $barang->tgl_simpan)) ?>
                        </div>

                        <div class="form-group <?php echo (!empty($hasError['satBsr']) ? 'has-error' : '') ?>">
                            <label class="control-label">Keterangan</label>
                            <?php echo form_input(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control', 'readonly'=>'TRUE', 'value' => $barang->keterangan)) ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">                                
                                <div class="form-group <?php echo (!empty($hasError['jml']) ? 'has-error' : '') ?>">
                                    <label class="control-label">File</label>
                                    <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'readonly'=>'TRUE', 'value' => $barang->nm_file)) ?>
                                </div>  
                            </div>
                            <div class="col-lg-6">                                
                                 
                            </div>
                        </div>                    
                    </div>
                    <div class="box-footer">                        
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" onclick="window.location.href = '<?php echo base_url('gudang/data_opname_list.php') ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>
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


        <div class="row">
            <div class="col-lg-8">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Stok Opname Barang</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Tanggal SO</th>
                                    <th class="text-center">Kode</th>
                                    <th class="text-left">Produk</th>
                                    <th class="text-right">Jml</th>
                                    <th class="text-left">Merk</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($barang_log)) {
                                    $no        = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    $jml_total = 0;
                                    foreach ($barang_log as $barang) {
                                        $jml_total = $jml_total + $barang->jml;
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td class="text-left"><?php echo $this->tanggalan->tgl_indo($barang->tgl_masuk) ?></td>
                                                <td class="text-left"><?php echo anchor(base_url('gudang/data_stok_tambah.php?id='.general::enkrip($barang->id_produk)), $barang->kode, 'target="_blank"') ?></td>
                                                <td class="text-left"><?php echo $barang->produk ?></td>
                                                <td class="text-right"><?php echo (int)$barang->jml ?></td>
                                                <td class="text-left"><?php echo $barang->merk ?></td>
                                            </tr>
                                            <?php
                                        }
                                }
                                ?>
                            </tbody>
                        </table>
                        <hr/>
                        <table class="table table-striped">
                            <tr>
                                <td class="text-left" style="width: 70px;">Kuantitas</td>
                                <td class="text-center" style="width: 10px;">:</td>
                                <td class="text-left"><?php echo (int)$jml_total ?></td>
                            </tr>                            
                        </table>
                    </div>
                    <div class="box-footer">                        
                        <div class="row">
                            <div class="col-lg-6">
                            
                            </div>
                            <div class="col-lg-6 text-right">
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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