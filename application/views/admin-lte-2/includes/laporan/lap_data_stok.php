<?php $hasError = $this->session->flashdata('form_error') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Laporan <small>Mutasi Stok</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li>Laporan</li>
            <li class="active">Mutasi Stok</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-6">
                <?php echo form_open(base_url('laporan/set_lap_stok.php'), 'autocomplete="off"') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Laporan</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group <?php echo (!empty($hasError['bulan']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Bulan</label>
                                    <select name="bulan" class="form-control">
                                        <option value="">- Bulan -</option>
                                        <?php for($bln = 1; $bln < 13; $bln++) { ?>
                                            <option value="<?php echo $bln ?>" <?php echo ($bln == $_GET['bulan'] ? 'selected' : '') ?>><?php echo $this->tanggalan->bulan_ke($bln) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group <?php echo (!empty($hasError['tahun']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Tahun</label>
                                    <select name="tahun" class="form-control">
                                        <option value="">- Tahun -</option>
                                        <?php for($thn = date('Y'); $thn > (date('Y') - 6); $thn--) { ?>
                                            <option value="<?php echo $thn ?>" <?php echo ($thn == $_GET['tahun'] ? 'selected' : '') ?>><?php echo $thn ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info btn-flat pull-right"><i class="fa fa-search"></i> Cari</button>
                    </div>
                </div>
                <?php echo form_close() ?>
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
                            $bulan      = $this->input->get('bulan');
                            $tahun      = $this->input->get('tahun');

                            $uri_pdf = base_url('laporan/' . $uri . '_pdf.php?bulan='.$bulan.'&tahun='.$tahun);
                            $uri_xls = base_url('laporan/xls_' . $uri . '.php?bulan='.$bulan.'&tahun='.$tahun);
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
                                        <th class="text-center">Awal</th>
                                        <th class="text-center">Masuk</th>
                                        <th class="text-center">Keluar</th>
                                        <th class="text-center">Akhir</th>
                                        <th class="text-right">Harga Beli</th>
                                        <!--<th class="text-right">Harga Jual</th>-->
                                        <th class="text-right">Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($stok)) { ?>
                                        <?php $no       = 1; ?>
                                        <?php $total    = 0; ?>
                                        <?php foreach ($stok as $penjualan) { ?>
                                            <?php $sql_sawl1= $this->db->select('jml')->where('id_produk', $penjualan->id)->where('status <', '3')->where('MONTH(tgl_simpan) <', $this->input->get('bulan'))->where('YEAR(tgl_simpan)', $this->input->get('tahun'))->order_by('tgl_simpan','desc')->get('tbl_m_produk_hist')->row(); ?>
                                            <?php $sql_sawl2= $this->db->select_sum('jml')->where('id_produk', $penjualan->id)->where('status', '3')->where('MONTH(tgl_simpan) <', $this->input->get('bulan'))->where('YEAR(tgl_simpan)', $this->input->get('tahun'))->get('tbl_m_produk_hist')->row(); ?>
                                            <?php $sakhwl   = $sql_sawl1->jml - (!empty($sql_sawl2->jml) ? $sql_sawl2->jml : 0); ?>
                                            <?php $sm       = $sakhwl + ($penjualan->status == '1' ? $penjualan->jml : '0'); ?>
                                            <?php $sk       = ($penjualan->status == 3 ? $penjualan->jml : '0'); ?>
                                            <?php $sa       = $sm - $sk; ?>
                                            <?php $hb       = $penjualan->harga_beli * $sa; ?>
                                            <?php $total    = $total + $hb; ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?></td>
                                                <td><?php echo $this->tanggalan->tgl_indo($penjualan->tgl_simpan) ?></td>
                                                <td><?php echo $penjualan->kode ?></td>
                                                <td><?php echo $penjualan->produk.' '.$penjualan->id ?></td>
                                                <td class="text-center"><?php echo $sakhwl ?></td>
                                                <td class="text-center"><?php echo $sm ?></td>
                                                <td class="text-center"><?php echo $sk ?></td>
                                                <td class="text-center"><?php echo $sa ?></td>
                                                <td class="text-right"><?php echo general::format_angka($penjualan->harga_beli) ?></td>
                                                <!--<td class="text-right"><?php echo general::format_angka($penjualan->harga_beli) ?></td>-->
                                                <td class="text-right"><?php echo general::format_angka($hb) ?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="9" class="text-right"><label>Total</label></td>
                                            <td class="text-right"><label><?php echo general::format_angka($total) ?></label></td>
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