<?php $hasError = $this->session->flashdata('form_error') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Laporan <small>Data Stok</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li>Laporan</li>
            <li class="active">Data Stok</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-6">
                <form type="GET">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Laporan</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group <?php echo (!empty($hasError['bulan']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Merk</label>
                                    <select name="merk" class="form-control">
                                        <option value="">[Semua]</option>
                                        <?php foreach($merk as $merk){ ?>
                                            <option value="<?php echo $merk->id ?>"><?php echo strtoupper($merk->merk) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['bulan']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Jml Stok</label>
                                    <?php echo br(); ?>
                                    <?php echo form_radio(array('name'=>'st', 'value'=>'1')); ?> Kurang Dari < <?php echo nbs(2); ?>
                                    <?php echo form_radio(array('name'=>'st', 'value'=>'2', 'checked'=>TRUE)); ?> Sama Dengan = <?php echo nbs(2); ?>
                                    <?php echo form_radio(array('name'=>'st', 'value'=>'3')); ?> Lebih Dari > <?php echo nbs(2); ?>
                                    <?php echo form_input(array('name'=>'stok', 'class'=>'form-control', 'style'=>'width:100px;', 'placeholder'=>'Mis. 100')) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info btn-flat pull-right"><i class="fa fa-search"></i> Cari</button>
                    </div>
                </div>
                </form>
                <?php // echo form_close() ?>
            </div>
        </div>

        <?php if (!empty($stok)) { ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data Mutasi Stok</h3>
                        </div>
                        <div class="box-body table-responsive">
                            <?php
                            $uri        = substr($this->uri->segment(2), 0, -4);
                            $bulan      = $this->input->get('st');
                            $tahun      = $this->input->get('stok');
                            $merk       = $this->input->get('merk');

                            $uri_pdf = base_url('laporan/' . $uri . '_pdf.php?bulan='.$bulan.'&tahun='.$tahun);
                            $uri_xls = base_url('laporan/xls_' . $uri . '.php?merk='.$merk.'&st='.$bulan.'&stok='.$tahun);
                            ?>
                            <!--<button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo $uri_pdf ?>'"><i class="fa fa-file-pdf-o"></i> Cetak</button>-->
                            <button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo $uri_xls ?>'"><i class="fa fa-file-excel-o"></i> Cetak</button>
                            <?php echo br() ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Tanggal</th>
                                        <th>Kode</th>
                                        <th>Produk</th>
                                        <th class="text-center">Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($stok)) { ?>
                                        <?php $no       = 1; ?>
                                        <?php $total    = 0; ?>
                                        <?php foreach ($stok as $penjualan) { ?>
                                        <?php $total    = $total + $penjualan->jml; ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?></td>
                                                <td><?php echo $this->tanggalan->tgl_indo($penjualan->tgl_simpan) ?></td>
                                                <td><?php echo anchor(base_url('gudang/data_stok_tambah.php?id='.general::enkrip($penjualan->id)), $penjualan->kode, 'target="_blank"') ?></td>
                                                <td><?php echo $penjualan->produk ?></td>
                                                <td class="text-center"><?php echo $penjualan->jml ?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="4" class="text-right"><label>Total</label></td>
                                            <td class="text-center"><label><?php echo general::format_angka($total) ?></label></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<style>
    .clicked {
        background-color: #ffff00;
    }
</style>
<!--Datepicker-->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/moment.js/2.11.2/moment.min.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/daterangepicker/daterangepicker-bs3.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.min.css') ?>">


<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins') ?>/JAutoNumber/autonumeric.js"></script>
<!-- Page script -->
<script>
                                $(function () {
                                    //Date picker
                                    $('#tgl').datepicker({
                                        autoclose: true,
                                    });
                                    $('#tgl_rentang').daterangepicker();
                                });
</script>