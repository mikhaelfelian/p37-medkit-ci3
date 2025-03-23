<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Transaksi <small>Penjualan</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Transaksi</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <?php echo $this->session->flashdata('transaksi') ?>
                    </div>
                    <div class="box-body table-responsive">
                        <div class="row">
                            <div class="col-lg-4">
                                <?php echo form_open(site_url('page=pajak&act=set_cari_penj2')) ?>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Tahun</th>
                                        <th></th>
                                        <th>Total</th>
                                    </tr>
                                    <tr>
                                        <td>                                            
                                            <select name="bulan" class="form-control">
                                                <option value="">- Bulan -</option>
                                                <?php for ($bln = 1; $bln < 13; $bln++) { ?>
                                                    <option value="<?php echo $bln ?>" <?php echo ($bln == $_GET['bln'] ? 'selected' : '') ?>><?php echo $this->tanggalan->bulan_ke($bln) ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="tahun" class="form-control">
                                                <option value="">- Tahun -</option>
                                                <?php for ($thn = date('Y'); $thn > (date('Y') - 6); $thn--) { ?>
                                                    <option value="<?php echo $thn ?>" <?php echo ($thn == $_GET['thn'] ? 'selected' : '') ?>><?php echo $thn ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td><button type="submit" class="btn btn-info btn-flat pull-left"><i class="fa fa-search"></i> Cari</button></td>
                                        <td class="text-right"><?php echo (!empty($sql_total) ? general::format_angka($sql_total->jml_gtotal) : '')?></td>
                                    </tr>
                                </table>
                                <?php echo form_close() ?>
                            </div>
                        </div>
                        <?php echo nbs(3) ?>
                        <?php echo form_open(site_url('page=pajak&act=set_nota_jual_simpan2')) ?>
                        <?php echo form_hidden('tahun', $_GET['thn']) ?>
                        <?php echo form_hidden('bulan', $_GET['bln']) ?>
                        <?php echo form_hidden('hal', $_GET['halaman']) ?>
                        <table class="table table-striped">
                            <thead>
                            <?php if (!empty($penj)) { ?>
                            <tr>
                                <td class="text-left text-bold" colspan="7"></td>
                                <td class="text-left text-bold" colspan="2"><button type="submit" class="btn btn-primary btn-flat pull-left">Set Input</button></td>
                            </tr>
                            <?php } ?>
                                <tr>
                                    <th>No.</th>
                                    <th>No. Invoice</th>
                                    <th>Lokasi</th>
                                    <th>Tgl Transaksi</th>
                                    <th>Pelanggan</th>
                                    <th>Sales</th>
                                    <th class="text-right">Nominal</th>
                                    <th class="text-left"><?php echo form_checkbox(array('id'=>'ckAll')) ?></th>
                                    <th colspan="2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($penj)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    $total = 0;
                                    foreach ($penj as $penj) {
                                        $sales = $this->db->where('id', $penj->id_sales)->get('tbl_m_sales')->row();
                                        $cust = $this->db->where('id', $penj->id_pelanggan)->get('tbl_m_pelanggan')->row();
                                        $app = $this->db->where('id', $penj->id_app)->get('tbl_pengaturan_cabang')->row();
                                        $total = $total + $penj->jml_gtotal;
                                        ?>
                                        <tr>
                                            <td class="text-center" style="width: 50px;"><?php echo $no++ ?>.</td>
                                            <td><?php echo anchor(base_url('transaksi/trans_jual_det.php?id=' . general::enkrip($penj->id)), $penj->kode_nota_dpn . $penj->no_nota . (!empty($penj->kode_nota_blk) ? '/' . $penj->kode_nota_blk : ''), 'class="text-default"') ?></td>
                                            <td><?php echo (!empty($penj->id_app) ? $app->keterangan : '') ?></td>
                                            <td><?php echo $this->tanggalan->tgl_indo($penj->tgl_masuk) ?></td>
                                            <td><?php echo $cust->nama_toko ?></td>
                                            <td><?php echo $sales->nama ?></td>
                                            <td class="text-right"><?php echo general::format_angka($penj->jml_gtotal) ?></td>
                                            <td class="text-left" style="width: 20px;"><?php echo form_checkbox(array('id'=>'ck', 'name'=>'input['.$penj->id.']', 'value'=>'1', 'onclick'=>'ilang()')) ?></td>
                                            <td>
                                                <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                                                    <?php echo anchor(base_url('pajak/set_nota_jual_simpan.php?id=' . general::enkrip($penj->id).(!empty($_GET['bln']) ? '&bln='.$_GET['bln'].'&thn='.$_GET['thn'] : '').(!empty($_GET['halaman']) ? '&halaman='.$_GET['halaman'] : '')), 'Input <i class="fa fa-arrow-right"></i>', 'class="label label-warning"') ?>
                                                <?php } ?>

                                                <?php // echo general::status_nota($penj->status_nota) ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="text-right text-bold text-middle" colspan="6">Total</td>
                                        <td class="text-right text-bold"><?php echo general::format_angka($total) ?></td>
                                        <td class="text-left text-bold" colspan="2"><button type="submit" class="btn btn-primary btn-flat pull-left">Set Input</button></td>
                                        <td class="text-right"></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php echo form_close() ?>
                    </div>
                    <?php if (!empty($pagination)) { ?>
                        <div class="box-footer">                        
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php echo $pagination ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
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

<!-- Page script -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/sb-admin') ?>/ui/jquery-ui.min.css" rel="stylesheet">

<!--Datepicker-->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">
<script>
        
        function ilang(){
            $('#ckAll').removeAttr('checked');
        }
    $(function () {        
        $("#ckAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    });
</script>