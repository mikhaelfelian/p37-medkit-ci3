<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Rekap Penjualan<small>per kasir</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li>Laporan</li>
            <li class="active">Penjualan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <?php echo form_open(base_url('laporan/set_lap_penjualan_produk.php'), '') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Laporan</h3>
                    </div>
                    <div class="box-body">           
                        <div class="row">
                            <div class="col-lg-12">
                                <?php
                                $uri     = substr($this->uri->segment(2), 0, -4);
                                $case    = $this->input->get('case');
                                $query   = $this->input->get('query');
                                $kat     = $this->input->get('kategori');
                                $tg_awal = (isset($_GET['tgl_awal']) ? $this->input->get('tgl_awal') : date('Y-m-d'));
                                $tg_akhr = (isset($_GET['tgl_akhir']) ? $this->input->get('tgl_akhir') : date('Y-m-d'));

                                $uri_pdf = base_url('laporan/' . $uri . '_pdf.php?tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr);
                                ?>

                                <?php echo br() ?>
                                <table class="table table-condensed" style="width: 750px;">
                                    <tr>
                                        <!--
                                        <td>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <?php // echo form_input(array('id' => 'tgl_rentang', 'name' => 'tgl_rentang', 'class' => 'form-control pull-right', 'value' => '')) ?>
                                            </div>                                            
                                        </td>
                                        <td style="width: 100px;">
                                            <button type="submit" class="btn btn-info btn-flat pull-right"><i class="fa fa-search"></i> Cari</button>                                            
                                        </td>
                                        -->
                                        <td>
                                            <button type="button" class="btn btn-success btn-flat pull-left" onclick="window.location.href = '<?php echo $uri_pdf ?>'"><i class="fa fa-file-pdf-o"></i> Cetak</button>
                                        </td>
                                    </tr>
                                </table>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Kode</th>
                                            <th>Produk</th>
                                            <th class="text-left">Jml</th>
                                            <th class="text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($penjualan)) { ?>
                                            <?php $no = 1; ?>
                                            <?php $total = 0; ?>
                                            <?php foreach ($penjualan as $penjualan) { ?>
                                                <?php $total = $total + $penjualan->subtotal; ?>
                                        
                                                <tr>
                                                    <td class="text-center"><?php echo $no++ ?></td>
                                                    <!--<td><?php echo $penjualan->no_nota ?></td>-->
                                                    <td><?php echo $penjualan->kode ?></td>
                                                    <td><?php echo $penjualan->produk ?></td>
                                                    <td class="text-left"><?php echo $penjualan->jml.' '.$penjualan->satuan ?></td>
                                                    <td class="text-right"><?php echo general::format_angka($penjualan->subtotal) ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="4" class="text-right"><label>Total Penjualan</label></td>
                                                <td class="text-right"><label><?php echo general::format_angka($total) ?></label></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">

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