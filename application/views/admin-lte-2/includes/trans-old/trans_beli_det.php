<?php echo $this->session->flashdata('produk') ?>
<?php
$tgl_msk = explode('-', $sql_beli->tgl_masuk);
$tgl_klr = explode('-', $sql_beli->tgl_keluar);
$tgl_byr = explode('-', $sql_beli->tgl_bayar);
?>
<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Transaksi
                <small>Pembelian</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
                <li class="active">Detail</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-shopping-cart"></i> Form Transaksi</h3>
                        </div>
                        <div class="box-body table-responsive">
                            <?php echo $this->session->flashdata('transaksi') ?>
                            <table class="table table-striped">
                                <tr>
                                    <th>No. Purchase Order</th>
                                    <th>:</th>
                                    <td><?php echo $sql_beli->no_nota ?></td>

                                    <th>Supplier</th>
                                    <th>:</th>
                                    <td><?php echo '['.$sql_supplier->kode.'] '.$sql_supplier->nama ?></td>
                                </tr>
                                <tr>
                                    <th>Tgl Masuk</th>
                                    <th>:</th>
                                    <td><?php echo $tgl_msk[1].'/'.$tgl_msk[2].'/'.$tgl_msk[0] ?></td>

                                    <th>Tgl Jatuh Tempo</th>
                                    <th>:</th>
                                    <td><?php echo $tgl_klr[1].'/'.$tgl_klr[2].'/'.$tgl_klr[0] ?></td>
                                </tr>
                            </table>
                            <hr/>
                            <br/>
                            <table class="table table-striped">
                                <tr>
                                    <th class="text-right" style="width: 25px;"></th>
                                    <th class="text-center" style="width: 50px;">No.</th>
                                    <th class="text-left" style="width: 100px;">Kode</th>
                                    <th class="text-left">Produk</th>
                                    <th class="text-center" style="width: 75px;">Jml</th>
                                    <th class="text-right">Harga</th>
                                    <th class="text-center">Diskon (%)</th>
                                    <th class="text-right">Potongan</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>                               

                                <?php $no = 1; ?>
                                <?php $subtotal = 0; ?>
                                <?php foreach ($sql_beli_det as $items) { ?>
                                    <?php
                                    $subtotal = $subtotal + $items->subtotal;
                                    ?>
                                    <tr>
                                        <td class="text-right" style="width: 25px;"><?php // echo ($items->id_kategori2 == 0 && $sql_beli->status_bayar == 0 ? anchor(base_url('cart/cart_hapus_brg.php?id=' . general::enkrip($items->id) . '&no_nota=' . general::enkrip($items->no_nota)), '<i class="fa fa-remove"></i>', 'onclick="return confirm(\'Hapus ?\')" class="text-danger"') : '<i class="fa fa-remove"></i>')   ?></td>
                                        <td class="text-right" style="width: 50px;"><?php echo $no++ ?></td>
                                        <td class="text-left" style="width: 100px;"><?php echo anchor(base_url('master/data_barang_tambah.php?id='.general::enkrip($items->id_produk)), $items->kode, 'target="_blank"') ?></td>
                                        <td class="text-left">                                            
                                            <?php echo ucwords($items->produk); ?>
                                        </td>
                                        <td class="text-right" style="width: 150px;"><?php echo (float)$items->jml.' '.$items->satuan.(!empty($items->keterangan) ? $items->keterangan : ''); ?></td>
                                        <td class="text-right">
                                            <?php echo ($items->harga != 0 ? general::format_angka((!empty($items->keterangan) ? $items->harga : $items->harga)) : ''); ?>
                                        </td>
                                        <td class="text-center">
                                            <?php // echo ($items->disk1 != '0' && $items->disk2 != '0' && $items->disk3 != '0' ? general::format_angka($items->disk1) . (!empty($items->disk2) ? ' + ' . general::format_angka($items->disk2) : '') . (!empty($items->disk3) ? ' + ' . general::format_angka($items->disk3) : '') : '-') ?>
                                            <?php echo ((int)$items->disk1 != '0' ? $items->disk1 : '').' '.((int)$items->disk2 != '0' ? ' + '.$items->disk2 : '').' '.((int)$items->disk3 != '0' ? ' + '.$items->disk3 : '') ?>
                                        </td>
                                        <td class="text-right">
                                            <?php echo ($items->harga != 0 ? general::format_angka($items->potongan) : ''); ?>
                                        </td>
                                        <td class="text-right">
                                            <?php echo ($items->harga != 0 ? general::format_angka($items->subtotal) : ''); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <th colspan="7" class="text-right" style="vertical-align: middle;">
                                    </th>
                                    <th class="text-right" style="vertical-align: middle;">Total</th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_dpp', 'name' => 'jml_dpp', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => (int)$subtotal)) ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="7" class="text-right" style="vertical-align: middle;">
                                    </th>
                                    <th class="text-right" style="vertical-align: middle;">Diskon</th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_diskon', 'name' => 'jml_diskon', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => $sql_beli->jml_diskon)) ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="7" class="text-right" style="vertical-align: middle;">
                                    </th>
                                    <th class="text-right" style="vertical-align: middle;">PPN <?php echo (!empty($sql_beli->ppn) ? $sql_beli->ppn.' %' : '') ?></th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_ppn', 'name' => 'jml_ppn', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => $sql_beli->jml_ppn)) ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="7" class="text-right" style="vertical-align: middle;">
                                    </th>
                                    <th class="text-right" style="vertical-align: middle;">Grand Total</th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_gtotal', 'name' => 'jml_gtotal', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => $sql_beli->jml_gtotal)) ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="7" class="text-right" style="vertical-align: middle;">
                                    </th>
                                    <th class="text-right" style="vertical-align: middle;">Jml Bayar</th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_bayar', 'name' => 'jml_bayar', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => $sql_beli->jml_bayar)) ?>
                                        </div>
                                    </th>
                                </tr>
                                <?php if($sql_beli->jml_kurang > 0){ ?>
                                <tr>
                                    <th colspan="7" class="text-right" style="vertical-align: middle;">
                                    </th>
                                    <th class="text-right" style="vertical-align: middle;">Jml Kekurangan</th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_kurang', 'name' => 'jml_kurang', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => $sql_beli->jml_kurang)) ?>
                                        </div>
                                    </th>
                                </tr>
                                <?php } ?>
                                <?php if($sql_beli->jml_retur > 0){ ?>
                                <tr>
                                    <th colspan="8" class="text-right" style="vertical-align: middle;">
                                        Potongan Retur
                                    </th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php $jml_dpp = $sql_beli->jml_total - $sql_beli->jml_retur ?>
                                            <?php echo form_input(array('id' => 'jml_retur', 'name' => 'jml_retur', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => (int)$sql_beli->jml_retur)) ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="8" class="text-right" style="vertical-align: middle;">
                                        Nota Retur
                                    </th>
                                    <th  class="text-right" style="width: 200px;">
                                        <?php echo anchor(base_url('transaksi/trans_retur_beli_det.php?id='.general::enkrip($sql_retur->id).'&route='.$this->uri->segment(2).'?id='.$this->input->get('id')), '#'.sprintf("%05s", $sql_retur->id), 'class="text-red" style="font-style: italic;"') ?>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="7" class="text-right" style="vertical-align: middle;">
                                    </th>
                                    <th class="text-right" style="vertical-align: middle;">Grand Total</th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_gtotal2', 'name' => 'jml_gtotal', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => (int)$sql_beli->jml_gtotal)) ?>
                                        </div>
                                    </th>
                                </tr>
                                <?php } ?>
                            </table>
                            <hr/>
                            <table class="table table-striped col-lg-6">
                                    <tr>
                                        <th colspan="3"><i class="fa fa-bank"></i> Transaksi Pembayaran</th>
                                    </tr>
                                    <tr>
                                        <th class="text-left" style="width: 150px;">Tgl Pembayaran</th>
                                        <th class="text-right" style="width: 120px;">Nominal</th>
                                        <th class="text-left" style="width: 100px;">Metode</th>
                                        <th class="text-left" colspan="2" style="width: 250px;">Keterangan</th>
                                    </tr>
                                    <?php foreach ($sql_beli_plat as $items){ ?>
                                    <?php $metode      = $this->db->where('id', $items->id_platform)->get('tbl_m_platform')->row(); ?>
                                    <?php $tgl_byr_itm = explode('-', $items->tgl_simpan) ?>
                                    <tr>
                                        <td class="text-left"><?php echo ($items->tgl_bayar != '0000-00-00' ? $tgl_byr_itm[1].'/'.$tgl_byr_itm[2].'/'.$tgl_byr_itm[0].' '.$items->jam.':'.$items->menit : '-') ?></td>
                                        <td class="text-right"><?php echo general::format_angka($items->nominal) ?></td>
                                        <td class="text-left"><?php echo ($sql_penj->tgl_bayar != '0000-00-00' ? ($items->id_platform == '1' ? 'Tunai' : ucwords($metode->platform)) : '-') ?></td>
                                        <td class="text-left"><?php echo $items->platform.(!empty($items->keterangan) ? nbs(2).$items->keterangan : '') ?></td>
                                        <td class="text-left"><?php echo nbs() ?></td>
                                    </tr>
                                    <?php } ?>
                            </table>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" onclick="window.location.href = '<?php echo base_url('transaksi/'.(isset($_GET['route']) ? $this->input->get('route') : 'data_pembelian_list.php')) ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <?php if ($sql_beli->status_bayar == '0') { ?>
                                                        <!--//<?php // echo form_checkbox(array('name' => 'cetak', 'value' => '1')) . nbs(2)     ?> Cetak Nota-->
                                    <?php } ?>
                                    <?php echo nbs(5) ?>
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href='<?php echo base_url('transaksi/cetak_nota_beli.php?id='.$this->input->get('id')) ?>'"><i class="fa fa-print"></i> Cetak Nota</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.container -->
</div>

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
       // Jquery kanggo format angka
       $("#jml_dpp").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_diskon").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_ppn").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_total").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_retur").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_bayar").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_kurang").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_gtotal").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_gtotal2").autoNumeric({aSep: '.', aDec: ',', aPad: false});
   });
</script>