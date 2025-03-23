<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Laporan <small>Data Retur Pembelian</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard.php') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li>Laporan</li>
            <li class="active">Retur Pembelian</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-6">
                <?php echo form_open(base_url('laporan/set_lap_ret_pembelian.php'), 'autocomplete="off"') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Laporan</h3>
                    </div>
                    <div class="box-body">
<!--                        <div class="form-group">
                            <label class="control-label">Semua</label>
                            <br/>
                            <input type="checkbox" name="semua" value="1"> Semua
                        </div>
                        <div class="form-group">
                            <label class="control-label">Per Hari</label>
                            <br/>
                            <input type="checkbox" name="hari_ini" value="<?php echo date('m/d/Y') ?>"> Hari Ini
                        </div>-->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Tgl</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control pull-right', 'value' => '')) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">                                
                                <div class="form-group <?php echo (!empty($hasError['tgl']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Rentang</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <?php echo form_input(array('id' => 'tgl_rentang', 'name' => 'tgl_rentang', 'class' => 'form-control pull-right', 'value' => '')) ?>
                                    </div>
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

        <?php if (!empty($penbelian)) { ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data Pembelian</h3>
                        </div>
                        <div class="box-body table-responsive">
                            <?php
                            $uri       = substr($this->uri->segment(2), 0, -4);
                            $case      = $this->input->get('case');
                            $tgl_awal  = $this->input->get('tgl_awal');
                            $tgl_akhir = $this->input->get('tgl_akhir');
                            $query     = $this->input->get('query');
                            ?>
                            <button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo base_url('laporan/'.$uri.'_pdf.php?case='.$case.'&query='.$query.'&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir) ?>'"><i class="fa fa-file-pdf-o"></i> Cetak</button>
                            <?php echo br() ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Tgl</th>
                                        <th>No. Retur</th>
                                        <th>User</th>
                                        <th class="text-right">Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($penbelian)) { ?>
                                        <?php $no = 1; ?>
                                        <?php $total = 0; ?>
                                        <?php foreach ($penbelian as $retur) { ?>
                                            <?php $total     = $total + $retur->jml_retur; ?>
                                            <?php $tgl       = explode('-', $retur->tgl_simpan) ?>
                                            <?php $tgl_tempo = explode('-', $retur->tgl_keluar) ?>
                                            <?php $tgl_byr   = explode('-', $retur->tgl_bayar) ?>
                                            <?php $platform  = $this->db->select('tbl_m_platform.platform as metode_bayar, tbl_trans_jual_plat.platform, tbl_trans_jual_plat.keterangan')->where('no_nota', $retur->no_nota)->join('tbl_m_platform', 'tbl_m_platform.id=tbl_trans_jual_plat.id_platform')->get('tbl_trans_jual_plat')->row() ?>
                                            <?php $sales     = $this->db->where('kode', $retur->kode_nota_blk)->get('tbl_m_sales')->row() ?>
                                            <?php // $nota_det = $this->db->select('tbl_m_produk.id, tbl_m_produk.produk, tbl_m_produk.harga_beli, tbl_trans_jual_det.harga as harga_jual, tbl_trans_jual_det.jml, tbl_trans_jual_det.subtotal')->where('tbl_trans_jual_det.no_nota', $retur->no_nota)->join('tbl_m_produk', 'tbl_m_produk.id=tbl_trans_jual_det.id_produk')->get('tbl_trans_jual_det')->result() ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?></td>
                                                <td><?php echo $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0] ?></td>
                                                <td><?php echo anchor('page=transaksi&act=trans_jual_detail&route=data_penjualan&case=' . $this->input->get('case') . '&query=' . $this->input->get('query') . '&tgl_awal=' . $this->input->get('tgl_awal') . '&tgl_akhir=' . $this->input->get('tgl_akhir') . '&id=' . general::enkrip($retur->no_nota), $retur->no_nota) ?></td>
                                                <td><?php echo ucwords($this->ion_auth->users($retur->id_user)->row()->first_name) ?></td>
                                                <td class="text-right"><?php echo general::format_angka($retur->jml_retur) ?></td>
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