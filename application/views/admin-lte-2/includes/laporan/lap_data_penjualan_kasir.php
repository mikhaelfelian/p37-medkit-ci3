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
                <?php // echo form_open(base_url('laporan/set_lap_penjualan_kasir.php'), '') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Laporan</h3>
                    </div>
                    <div class="box-body">           
                        <div class="row">
                            <div class="col-lg-12">
                                <?php
                                $uri       = substr($this->uri->segment(2), 0, -4);
                                $case      = $this->input->get('case');
                                $query     = $this->input->get('query');
                                $kat       = $this->input->get('kategori');
                                $met_bayar = $this->input->get('metode');
                                
                                $tg_awal = (isset($_GET['tgl_awal']) ? $this->input->get('tgl_awal') : date('Y-m-d'));
                                $tg_akhr = (isset($_GET['tgl_akhir']) ? $this->input->get('tgl_akhir') : date('Y-m-d'));

                                $uri_pdf = base_url('laporan/' . $uri . '_pdf.php?tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr.(!empty($met_bayar) ? '&metode='.$met_bayar : ''));
                                $uri_pos = base_url('laporan/' . $uri . '_pos.php?tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr.'&route=laporan/data_penjualan_kasir'.(!empty($met_bayar) ? '&metode='.$met_bayar : ''));
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
                                        <td>
                                            <select name="metode_bayar" class="form-control">
                                                <?php // $sql_plat = $this->db->get('tbl_m_platform')->result(); ?>
                                                <option value="">- [Semua] -</option>
                                                <?php // foreach ($sql_plat as $platform){ ?>
                                                    <option value="<?php // echo $platform->id ?>"><?php // echo ucwords($platform->platform) ?></option> 
                                                <?php // } ?>
                                            </select>
                                        </td>
                                        <td style="width: 100px;">
                                            <button type="submit" class="btn btn-info btn-flat pull-right"><i class="fa fa-search"></i> Cari</button>                                            
                                        </td>
                                        -->
                                        <td style="width: 100px;">
                                            <button type="button" class="btn btn-success btn-flat pull-left" onclick="window.location.href = '<?php echo $uri_pdf ?>'"><i class="fa fa-file-pdf-o"></i> Cetak PDF</button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-flat pull-left" onclick="window.location.href = '<?php echo $uri_pos ?>'"><i class="fa fa-file-pdf-o"></i> Cetak POS</button>
                                        </td>
                                    </tr>
                                </table>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Tgl</th>
                                            <th>No. Invoice</th>
                                            <th>Sales</th>
                                            <th>Metode Pembayaran</th>
                                            <th>Jatuh Tempo</th>
                                            <th>Tgl Bayar</th>
                                            <th class="text-right">Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($penjualan)) { ?>
                                            <?php $no = 1; ?>
                                            <?php $total = 0; ?>
                                            <?php foreach ($penjualan as $penjualan) { ?>
                                                <?php $total = $total + $penjualan->jml_gtotal; ?>
                                                <?php $tgl = explode('-', $penjualan->tgl_simpan) ?>
                                                <?php $tgl_tempo = explode('-', $penjualan->tgl_keluar) ?>
                                                <?php $tgl_byr = explode('-', $penjualan->tgl_bayar) ?>
                                                <?php $platform = $this->db->select('tbl_m_platform.platform as metode_bayar, tbl_trans_jual_plat.platform, tbl_trans_jual_plat.keterangan')->where('no_nota', $penjualan->no_nota)->join('tbl_m_platform', 'tbl_m_platform.id=tbl_trans_jual_plat.id_platform')->get('tbl_trans_jual_plat')->row() ?>
                                                <?php $sales = $this->db->where('kode', $penjualan->kode_nota_blk)->get('tbl_m_sales')->row() ?>
                                                <?php // $nota_det = $this->db->select('tbl_m_produk.id, tbl_m_produk.produk, tbl_m_produk.harga_beli, tbl_trans_jual_det.harga as harga_jual, tbl_trans_jual_det.jml, tbl_trans_jual_det.subtotal')->where('tbl_trans_jual_det.no_nota', $penjualan->no_nota)->join('tbl_m_produk', 'tbl_m_produk.id=tbl_trans_jual_det.id_produk')->get('tbl_trans_jual_det')->result() ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no++ ?></td>
                                                    <td><?php echo $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0] ?></td>
                                                    <td><?php echo anchor(base_url('transaksi/trans_jual_det.php?id=' . general::enkrip($penjualan->id) . '&route=laporan/data_penjualan.php'), $penjualan->kode_nota_dpn . $penjualan->no_nota . '/' . $penjualan->kode_nota_blk) ?></td>
                                                    <td><?php echo ucwords($sales->nama) ?></td>
                                                    <td><?php echo (!empty($platform->metode_bayar) ? $platform->metode_bayar : 'Tunai') . ' ' . ucwords($platform->platform) . ' ' . $platform->keterangan ?></td>
                                                    <td><?php echo ($penjualan->tgl_keluar == '0000-00-00' ? '-' : $tgl_tempo[1] . '/' . $tgl_tempo[2] . '/' . $tgl_tempo[0]) ?></td>
                                                    <td><?php echo ($penjualan->tgl_bayar == '0000-00-00' ? '-' : $tgl_byr[1] . '/' . $tgl_byr[2] . '/' . $tgl_byr[0]) ?></td>
                                                    <td class="text-right"><?php echo general::format_angka($penjualan->jml_gtotal) ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="7" class="text-right"><label>Total Penjualan</label></td>
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