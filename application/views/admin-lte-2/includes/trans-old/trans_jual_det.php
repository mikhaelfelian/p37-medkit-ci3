<?php echo $this->session->flashdata('produk') ?>
<?php
$tgl_msk = explode('-', $sql_penj->tgl_masuk);
$tgl_klr = explode('-', $sql_penj->tgl_keluar);
$tgl_byr = explode('-', $sql_penj->tgl_bayar);

$pelanggan = $this->db->select('tbl_m_pelanggan.kode, tbl_m_pelanggan.nik, tbl_m_pelanggan.nama, tbl_m_pelanggan.nama_toko, tbl_m_pelanggan.no_hp, tbl_m_pelanggan.lokasi, tbl_m_pelanggan.alamat')->where('tbl_m_pelanggan.id', $sql_penj->id_pelanggan)->get('tbl_m_pelanggan')->row();
?>
<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Data
                <small>Transaksi</small>
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
                        <div class="box-body">
                            <?php echo $this->session->flashdata('transaksi') ?>
                            <table class="table table-striped">
                                <tr>
                                    <th>No. Invoice</th>
                                    <th>:</th>
                                    <td><?php echo $sql_penj->kode_nota_dpn . $sql_penj->no_nota . '/' . $sql_penj->kode_nota_blk ?></td>

                                    <th>Pelanggan</th>
                                    <th>:</th>
                                    <td><?php echo $pelanggan->nama.' - '.$pelanggan->nama_toko ?></td>
                                </tr>
                                <tr>
                                    <th>Tgl Masuk</th>
                                    <th>:</th>
                                    <td><?php echo $tgl_msk[1] . '/' . $tgl_msk[2] . '/' . $tgl_msk[0] ?></td>

                                    <th>Tgl Jatuh Tempo</th>
                                    <th>:</th>
                                    <td><?php echo $tgl_klr[1] . '/' . $tgl_klr[2] . '/' . $tgl_klr[0] ?></td>
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
                                    <th class="text-right" style="width: 75px;">Jml</th>
                                    <th class="text-right">Harga</th>
                                    <th class="text-center">Diskon</th>
                                    <th class="text-center">Potongan</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>                               

                                <?php $no = 1; ?>
                                <?php $jml_total = 0; $jml_diskon = 0; $jml_gtotal = 0; ?>
                                <?php foreach ($sql_penj_det as $items) { ?>
                                    <?php
                                    $jml_total   = $jml_total + $items->subtotal;
                                    $jml_diskon  = $jml_diskon + ($items->diskon + $items->potongan);
                                    $jml_gtotal  = $jml_gtotal + $items->subtotal;
                                    $produk      = $this->db->where('kode', $items->kode)->get('tbl_m_produk')->row();
                                    ?>
                                    <tr>
                                        <td class="text-right" style="width: 25px;"><?php // echo ($items->id_kategori2 == 0 && $sql_penj->status_bayar == 0 ? anchor(base_url('cart/cart_hapus_brg.php?id=' . general::enkrip($items->id) . '&no_nota=' . general::enkrip($items->no_nota)), '<i class="fa fa-remove"></i>', 'onclick="return confirm(\'Hapus ?\')" class="text-danger"') : '<i class="fa fa-remove"></i>')    ?></td>
                                        <td class="text-right" style="width: 50px;"><?php echo $no++ ?></td>
                                        <td class="text-left" style="width: 100px;"><?php echo $items->kode ?></td>
                                        <td class="text-left">                                            
                                            <?php echo ucwords($items->produk); ?>
                                        </td>
                                        <td class="text-right" style="width: 150px;"><?php echo (!empty($items->keterangan) ? $items->jml : $items->jml) . ' ' . $items->satuan . (!empty($items->keterangan) ? $items->keterangan : ''); ?></td>
                                        <td class="text-right">
                                            <?php echo ($items->harga != 0 ? general::format_angka((!empty($items->keterangan) ? $items->harga : $items->harga)) : ''); ?>
                                        </td>
                                        <td class="text-center"><?php echo ($items->disk1 != '0' ? general::format_angka($items->disk1) : '').($items->disk2 != '0' ? ' + '.general::format_angka($items->disk2) : '').($items->disk3 != '0' ? ' + '.general::format_angka($items->disk3) : '') ?></td>
                                        <td class="text-center"><?php echo general::format_angka($items->potongan) ?></td>
                                        <td class="text-right">
                                            <?php
                                            $disk1 = $items->subtotal - (($items->disk1 / 100) * $items->subtotal);
                                            $disk2 = $disk1 - (($items->disk2 / 100) * $disk1);
                                            $disk3 = $disk2 - (($items->disk3 / 100) * $disk2);
                                            ?>
                                            <?php echo general::format_angka($items->subtotal); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                    
                                <?php $pengaturan   = $this->db->get('tbl_pengaturan')->row(); ?>
                                <?php $jml_pot      = $sql_penj->jml_diskon - $jml_diskon; ?>
                                    
                                <tr>
                                    <td colspan="7" class="text-right" style="vertical-align: middle;">

                                    </td>
                                    <th class="text-right" style="vertical-align: middle;">Total</th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_total', 'name' => 'jml_subtotal', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => (float) $sql_penj->jml_total)) ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-right" style="vertical-align: middle;">

                                    </td>
                                    <th class="text-right" style="vertical-align: middle;">Diskon</th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_diskon', 'name' => 'jml_diskon', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => (float) $sql_penj->jml_diskon)) ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-right" style="vertical-align: middle;">

                                    </td>
                                    <th class="text-right" style="vertical-align: middle;">Ongkir</th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_ongkir', 'name' => 'jml_ongkir', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => (int) $sql_penj->jml_ongkir)) ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-right" style="vertical-align: middle;">

                                    </td>
                                    <th class="text-right" style="vertical-align: middle;">Biaya</th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_biaya', 'name' => 'jml_biaya', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => (int) $sql_penj->jml_biaya)) ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-right" style="vertical-align: middle;">

                                    </td>
                                    <th colspan="2" class="text-right" style="vertical-align: middle;">Potongan Retur</th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_retur', 'name' => 'jml_gtotal', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => (float) $sql_penj->jml_retur)) ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-right" style="vertical-align: middle;">

                                    </td>
                                    <th colspan="2" class="text-right" style="vertical-align: middle;">Grand Total</th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_gtotal', 'name' => 'jml_gtotal', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => (int) $sql_penj->jml_gtotal)) ?>
                                        </div>
                                    </th>
                                </tr>
                                <?php if($sql_penj->status_bayar > 0){ ?>
                                    <tr>
                                        <td colspan="7" class="text-right" style="vertical-align: middle;">

                                        </td>
                                        <th class="text-right" style="vertical-align: middle;">Jml Bayar</th>
                                        <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_bayar', 'name' => 'jml_bayar', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => (int) $sql_penj->jml_bayar)) ?>
                                        </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="text-right" style="vertical-align: middle;">

                                        </td>
                                        <th class="text-right" style="vertical-align: middle;">Jml Kembali</th>
                                        <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_kembali', 'name' => 'jml_kembali', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => (int) $sql_penj->jml_kembali)) ?>
                                        </div>
                                        </th>
                                    </tr>
                                <?php } ?>
                            </table>
                            <hr/>
                            <table class="table table-striped col-lg-8">
                                <tr>
                                    <th colspan="3"><i class="fa fa-bank"></i> Transaksi Pembayaran</th>
                                </tr>
                                <tr>
                                    <th class="text-left" style="width: 150px;">Tgl Pembayaran</th>
                                    <th class="text-right" style="width: 120px;">Nominal</th>
                                    <th class="text-left" style="width: 250px;">Metode</th>
                                    <th class="text-left" colspan="2" style="width: 250px;">Keterangan</th>
                                </tr>
                                <?php foreach ($sql_penj_plat as $items) { ?>
                                    <?php $metode = $this->db->where('id', $items->id_platform)->get('tbl_m_platform')->row(); ?>
                                    <?php $tgl_byr_itm = explode('-', $items->tgl_simpan) ?>
                                    <tr>
                                        <td class="text-left"><?php echo ($items->tgl_bayar != '0000-00-00' ? $tgl_byr_itm[1] . '/' . $tgl_byr_itm[2] . '/' . $tgl_byr_itm[0] . ' ' . $items->jam . ':' . $items->menit : '-') ?></td>
                                        <td class="text-right"><?php echo general::format_angka($items->nominal) ?></td>
                                        <td class="text-left"><?php echo ($sql_penj->tgl_bayar != '0000-00-00' ? ($items->id_platform == '1' ? 'Tunai' : ucwords($metode->platform)) : '-') ?></td>
                                        <td class="text-left"><?php echo $items->platform . (!empty($items->keterangan) ? nbs(2) . $items->keterangan : '') ?></td>
                                        <td class="text-left"><?php echo nbs() ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" onclick="window.location.href = '<?php echo base_url((isset($_GET['route']) ? ($_GET['act'] != 'bayar' ? $this->input->get('route') : 'transaksi/data_penj_list.php') : 'transaksi/data_penj_list.php')) ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <?php if ($sql_penj->status_bayar == '0') { ?>
                                    <!--//<?php // echo form_checkbox(array('name' => 'cetak', 'value' => '1')) . nbs(2)     ?> Cetak Nota-->
                                    <?php } ?>
                                    <?php echo nbs(5) ?>
                                    <?php if ($sql_penj->status_draft != '1') { ?>
										<button type="button" class="btn <?php echo ($sql_penj->cetak == '1' ? 'btn-danger' : 'btn-primary') ?> btn-flat" onclick="window.location.href = '<?php echo base_url('transaksi/cetak_nota_do.php?id=' . $this->input->get('id')) ?>'"><i class="fa fa-truck"></i> Cetak DO</button>
										<?php echo nbs() ?>
										<button type="button" class="btn <?php echo ($sql_penj->cetak == '1' ? 'btn-danger' : 'btn-primary') ?> btn-flat" onclick="window.location.href = '<?php echo base_url('transaksi/cetak_nota_termal.php?id=' . $this->input->get('id').'&route=transaksi/trans_jual_det') ?>'"><i class="fa fa-print"></i> Cetak Nota Kecil</button>
										<?php echo nbs() ?>
										<button type="button" class="btn <?php echo ($sql_penj->cetak == '1' ? 'btn-danger' : 'btn-primary') ?> btn-flat" onclick="window.location.href = '<?php echo base_url('transaksi/cetak_nota.php?id=' . $this->input->get('id')) ?>'"><i class="fa fa-print"></i> Cetak Nota Grosir</button>
										<?php echo nbs() ?>
                                    <?php // } else { ?>
										<!--<button type="button" class="btn <?php echo ($sql_penj->cetak == '1' ? 'btn-danger' : 'btn-primary') ?> btn-flat" onclick="window.location.href = '<?php echo base_url('transaksi/cetak_nota_termal.php?id=' . $this->input->get('id').'&route=transaksi/trans_jual_det') ?>'"><i class="fa fa-print"></i> Cetak Nota Kecil</button>-->
                                    <?php } ?>
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
                                            $("#jml_ongkir").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_biaya").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_subtotal").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#disk1").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#disk2").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#disk3").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_total").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_retur").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_ppn").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_gtotal").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_bayar").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_kembali").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_kurang").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                        });
                                        var myWindow;

                                        function download() {
                                            myWindow = window.open("<?php echo base_url('cart/cetak_nota.php?id=' . $this->input->get('id')) ?>", "", "width=200,height=100,scrollbars=no,toolbar=no,menubar=no,location=no");
//     myWindow.document.write('<p>This is \'MsgWindow\'. <?php // echo anchor(base_url('cart/cetak_nota.php?id='.$this->input->get('id')),'Refresh','onclick="tutup();"')  ?></p>');
                                            this.window.focus();
                                        }

                                        function thanks() {
                                            document.getElementById('thanks').style.display = 'block';
                                        }

                                        function tutup() {
                                            myWindow.close();
                                        }
</script>