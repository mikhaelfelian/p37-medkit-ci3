<?php echo $this->session->flashdata('produk') ?>
<?php $form_error = $this->session->flashdata('form_error') ?>
<?php
$tgl_msk = explode('-', $pemb->tgl_masuk);
$tgl_klr = explode('-', $pemb->tgl_keluar);
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
                <li class="active">Pembayaran Pembelian</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-shopping-cart"></i> Form Pembayaran Pembelian</h3>
                        </div>
                        <div class="box-body table-responsive">
                            <?php echo $this->session->flashdata('transaksi') ?>
                            <table class="table table-striped">
                                <tr>
                                    <th>No. Purchase Order</th>
                                    <th>:</th>
                                    <td><?php echo $pemb->kode_nota_dpn.$pemb->no_nota ?></td>

                                    <th>Supplier</th>
                                    <th>:</th>
                                    <td><?php echo '['.$supplier->kode.'] '.$supplier->nama ?></td>
                                </tr>
                                <tr>
                                    <th>Tgl Pembelian</th>
                                    <th>:</th>
                                    <td><?php echo $tgl_msk[1].'/'.$tgl_msk[2].'/'.$tgl_msk[0] ?></td>

                                    <th>Tgl Jatuh Tempo</th>
                                    <th>:</th>
                                    <td><?php echo $tgl_klr[1].'/'.$tgl_klr[2].'/'.$tgl_klr[0] ?></td>
                                </tr>
                                <tr>
                                    <th>Status PPN</th>
                                    <th>:</th>
                                    <td><?php echo general::status_ppn($pemb->status_ppn) ?><!--<button type="button" id="btnEditPPn" class="btn btn-<?php echo ($pemb->status_ppn == '1' ? 'danger' : 'primary'); ?> btn-flat" onclick="window.location.href='<?php echo site_url('page=transaksi&act=set_nota_beli_ppn_upd&id='.$this->input->get('id').'&ppn='.($pemb->status_ppn == '1' ? '0' : '10')); ?>'"><i class="fa fa-<?php echo ($pemb->status_ppn == '1' ? 'remove' : 'plus')?>"></i> PPN</button>--></td>

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
                                    <th class="text-left">Kode</th>
                                    <th class="text-left">Produk</th>
                                    <th class="text-center" style="width: 75px;">Jml</th>
                                    <th class="text-right">Harga</th>
                                    <th class="text-center">Diskon</th>
                                    <th class="text-right">Potongan</th>
                                    <th class="text-right">Subtotal</th>
                                    <th class="text-right"></th>
                                </tr>
                                <?php $no = 1; ?>
                                <?php $subtotal = 0; ?>
                                <?php foreach ($pemb_det as $items) { ?>
                                    <?php
                                    $subtotal = $subtotal + $items->subtotal;
                                    ?>
                                    <tr>
                                        <td class="text-right" style="width: 25px; vertical-align: middle;"><?php // echo ($items->id_kategori2 == 0 && $pemb->status_bayar == 0 ? anchor(base_url('cart/cart_hapus_brg.php?id=' . general::enkrip($items->id) . '&no_nota=' . general::enkrip($items->no_nota)), '<i class="fa fa-remove"></i>', 'onclick="return confirm(\'Hapus ?\')" class="text-danger"') : '<i class="fa fa-remove"></i>')  ?></td>
                                        <td class="text-center" style="width: 50px; vertical-align: middle;"><?php echo $no++ ?></td>
                                        <td class="text-left" style="width: 150px; vertical-align: middle;">                                            
                                            <?php echo anchor(base_url('master/data_barang_tambah.php?id='.general::enkrip($items->id_produk)), strtoupper($items->kode), 'target="_blank"') ?>
                                        </td>
                                        <td class="text-left" style="width: 450px; vertical-align: middle;">                                            
                                            <?php echo ucwords($items->produk); ?>
                                        </td>
                                        <td class="text-center" style="width: 175px; vertical-align: middle;"><?php echo (float)$items->jml.' '.$items->satuan.' '.$items->keterangan; ?></td>
                                        <td class="text-right" style="width: 100px; vertical-align: middle;">
                                            <?php echo ($items->harga != 0 ? general::format_angka($items->harga) : ''); ?>
                                        </td>
                                        <td class="text-center" style="width: 75px; vertical-align: middle;">
                                            <?php echo ((int)$items->disk1 != '0' ? general::format_angka($items->disk1, 2) : '').((int)$items->disk2 != '0' ? ' + '.general::format_angka($items->disk2, 2) : '').((int)$items->disk3 != '0' ? ' + '.general::format_angka($items->disk3, 2) : '') ?>
                                        </td>
                                        <td class="text-right" style="vertical-align: middle;">
                                            <?php echo general::format_angka($items->potongan); ?>
                                        </td>
                                        <td class="text-right" style="vertical-align: middle;">
                                            <?php echo general::format_angka($items->subtotal); ?>
                                        </td>
                                        <td>
                                            <?php // echo anchor('transaksi/trans_bayar_beli.php?id='.$this->input->get('beli').'&route=edit') ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php echo form_open(base_url('transaksi/set_nota_beli_bayar.php')) ?>
                                <?php echo form_hidden('id', general::enkrip($pemb->id)) ?>
                                <input type="hidden" name="ppn" id="ppn" value="<?php echo $pemb->ppn ?>">
                                <input type="hidden" name="status_ppn" id="status_ppn" value="<?php echo $pemb->status_ppn ?>">
                                
                                <tr>
                                    <th colspan="8" class="text-right" style="vertical-align: middle;">
                                        Total
                                    </th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_total', 'name' => 'jml_total', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => general::format_angka($pemb->jml_subtotal + $pemb->jml_retur))) ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-right" colspan="8" style="vertical-align: middle;">Potongan Retur</th>
                                    <th  class="text-right" style="width: 200px;">
                                        <?php if($pemb->jml_retur > 0){ ?>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_retur', 'name' => 'jml_retur', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => general::format_angka($pemb->jml_retur))) ?>
                                        </div>
                                        <?php }else{ ?>
                                            <?php if($pemb->status_bayar == '2'){ ?>
                                                -
                                            <?php }else{ ?>
                                                <?php echo anchor(base_url('transaksi/trans_retur_beli.php?no_nota='.general::enkrip($pemb->id).'&route='.$this->uri->segment(2)), 'Retur Pembelian', 'class="text-red" style="font-style: italic;"') ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </th>
                                </tr>
                                <?php if($pemb->jml_retur > 0){ ?>
                                <tr>
                                    <th class="text-right" colspan="8" style="vertical-align: middle;">Nota Retur</th>
                                    <th  class="text-right" style="width: 200px;">
                                        <?php echo anchor(base_url('transaksi/trans_retur_beli_det.php?id='.general::enkrip($pemb_retur->id).'&route='.$this->uri->segment(2)), '#'.$pemb_retur->no_retur, 'class="text-red" style="font-style: italic;"') ?>
                                    </th>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <th class="text-right" style="vertical-align: middle;" colspan="8">Tipe Diskon</th>
                                    <th class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <select id="tipe_disk" name="tipe_disk" class="form-control">
                                                <option value="persen">Persen (%)</option>
                                                <option value="nominal">Nominal (Rp)</option>
                                            </select>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-right" style="vertical-align: middle;" colspan="8">Diskon <?php echo (!empty($sql_penj->disk1) ? '('.round($sql_penj->disk1).'%)' : '') ?></th>
                                    <th class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp
                                            </div>
                                            <?php echo form_input(array('id' => 'disk_nom', 'name' => 'disk_nom', 'class' => 'form-control pull-right text-right', 'value'=>'0', 'disabled'=>'true')) ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-right" style="vertical-align: middle;" colspan="8">Diskon 1 <?php echo (!empty($sql_penj->disk1) ? '('.round($sql_penj->disk1).'%)' : '') ?></th>
                                    <th class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <?php echo form_input(array('id' => 'disk1', 'name' => 'disk1', 'class' => 'form-control pull-right text-right', 'value'=>'0')) ?>
                                            <div class="input-group-addon">
                                                %
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-right" style="vertical-align: middle;" colspan="8">Diskon 2 <?php echo (!empty($sql_penj->disk1) ? '('.round($sql_penj->disk2).'%)' : '') ?></th>
                                    <th class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <?php echo form_input(array('id' => 'disk2', 'name' => 'disk2', 'class' => 'form-control pull-right text-right', 'value'=>'0')) ?>
                                            <div class="input-group-addon">
                                                %
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-right" style="vertical-align: middle;" colspan="8">Diskon 3 <?php echo (!empty($sql_penj->disk1) ? '('.round($sql_penj->disk3).'%)' : '') ?></th>
                                    <th class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <?php echo form_input(array('id' => 'disk3', 'name' => 'disk3', 'class' => 'form-control pull-right text-right', 'value'=>'0')) ?>
                                            <div class="input-group-addon">
                                                %
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="8" class="text-right" style="vertical-align: middle;">
                                        Subtotal
                                    </th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_subtotal', 'name' => 'jml_subtotal', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => general::format_angka($pemb->jml_subtotal))) ?>
                                        </div>
                                    </th>
                                </tr>
                                <?php if($pemb->status_ppn == '2'){ ?>
                                <tr>
                                    <th colspan="8" class="text-right" style="vertical-align: middle;">
                                        DPP
                                    </th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_subtotal', 'name' => 'jml_subtotal', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => general::format_angka($pemb->jml_subtotal - $pemb->jml_ppn))) ?>
                                        </div>
                                    </th>
                                </tr>
                                <?php } ?>
                                <tr id="blok_ppn">
                                    <th colspan="8" class="text-right" style="vertical-align: middle;">
                                        <?php echo 'PPN '.(!empty($pemb->ppn) ? $pemb->ppn.' %' : '') ?>
                                    </th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_ppn', 'name' => 'jml_ppn', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => general::format_angka($pemb->jml_ppn))) ?>
                                        </div>
                                    </th>
                                    <!--
                                    <?php if($pemb->status_ppn == '0'){ ?>
                                    <th>
                                        <button type="button" id="btnEditPPn" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Edit PPN</button>
                                    </th>
                                    <?php } ?>
                                    -->
                                </tr>
                                <tr>
                                    <th colspan="8" class="text-right" style="vertical-align: middle;">
                                        Grand Total
                                    </th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_gtotal', 'name' => 'jml_gtotal', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => general::format_angka($pemb->jml_gtotal))) ?>
                                        </div>
                                    </th>
                                </tr>
                                <?php if($pemb->jml_kurang > 0){ ?>
                                    <tr>
                                        <th colspan="8" class="text-right" style="vertical-align: middle;">
                                            Jml Kekurangan
                                        </th>
                                        <th  class="text-right" style="width: 200px;">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    Rp.
                                                </div>
                                                <?php echo form_input(array('id' => 'jml_kurang', 'name' => 'jml_kurang', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => general::format_angka($pemb->jml_kurang))) ?>
                                            </div>
                                        </th>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <th class="text-right" colspan="8" style="vertical-align: middle;">Tanggal Bayar</th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <?php echo form_input(array('id' => 'tgl_bayar', 'name' => 'tgl_bayar', 'class' => 'form-control pull-right text-right', 'value'=>date('m/d/Y'))) ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-right" colspan="8" style="vertical-align: middle;">Jml Bayar</th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date <?php echo (!empty($form_error['jml_bayar']) ? 'has-error' : '') ?>">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_bayar', 'name' => 'jml_bayar', 'class' => 'form-control pull-right text-right')) ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="8" class="text-right" style="vertical-align: middle;">
                                        Metode Pembayaran
                                    </th>
                                    <th  class="text-right" style="width: 250px;">
                                        <?php // if ($pemb->status_bayar == '0') { ?>
                                        <?php // echo form_radio(array('id' => 'tunai', 'name' => 'metode_bayar', 'value' => '1', 'checked' => 'TRUE')) . nbs(2) ?> 
                                        <select id="metode_bayar" name="metode_bayar" class="form-control" <?php echo($pemb->status_bayar != '0' ? '' : '') ?>>
                                            <option value="1">Tunai</option>
                                            <?php
                                            $sql_dep  = $this->db->select('tbl_m_pelanggan_grup.status_deposit')->join('tbl_m_pelanggan_grup','tbl_m_pelanggan_grup.id=tbl_m_pelanggan.id_grup')->where('tbl_m_pelanggan.id', $pemb->id_user)->get('tbl_m_pelanggan')->row();
                                                                                        
                                            if($sql_dep->status_deposit == '1'){
                                                echo '<option value="2">Deposit</option>';
                                            }
                                            ?>                                            
                                            <?php foreach ($platform as $platform) { ?>
                                                <?php if($platform->id > 2) { ?>
                                                    <option value="<?php echo $platform->id ?>" <?php echo ($pemb->metode_bayar == $platform->id ? 'selected' : '') ?>><?php echo $platform->platform ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </th>
                                </tr>
                                <tr id="bank">
                                    <th colspan="8" class="text-right" style="vertical-align: middle;">
                                        Nama Bank
                                    </th>
                                    <th  class="text-right" style="width: 250px;">
                                        <?php echo form_input(array('name' => 'bank', 'class' => 'form-control pull-right text-right', 'placeholder' => 'Nama Bank ...')) ?>
                                    </th>
                                </tr>
                                <tr id="no_kartu">
                                    <th colspan="8" class="text-right" style="vertical-align: middle;">
                                        No. Rek / Kartu
                                    </th>
                                    <th  class="text-right" style="width: 250px;">
                                        <?php echo form_input(array('name' => 'no_kartu', 'class' => 'form-control pull-right text-right', 'placeholder' => 'Nomor Rek / Kartu ...')) ?>
                                    </th>
                                </tr>
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
                                    <?php foreach ($pemb_plat as $items){ ?>
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
                                    <button type="button" onclick="window.location.href = '<?php echo base_url('transaksi/data_pemb_beli_list.php') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <?php if ($pemb->status_bayar == '0') { ?>
                                                    <!--//<?php // echo form_checkbox(array('name' => 'cetak', 'value' => '1')) . nbs(2)    ?> Cetak Nota-->
                                    <?php } ?>
                                    <?php echo nbs(5) ?>
                                    <?php if ($pemb->status_bayar != '1' OR $pemb->jml_kurang > 0) { ?>
                                        <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-cart-arrow-down"></i> Bayar &raquo;</button>
                                    <?php } else { ?>
                                        <button type="button" class="btn <?php echo ($pemb->cetak == '1' ? 'btn-danger' : 'btn-primary') ?> btn-flat" onclick="window.location.href = '<?php echo base_url('cart/cetak_nota.php?id=' . $this->input->get('id') . '&status_ctk=' . $pemb->cetak) ?>'"><i class="fa fa-print"></i> <?php echo ($pemb->cetak == '1' ? 'Cetak Ulang Nota' : 'Cetak Nota') ?></button>
                                    <?php } ?>
                                </div>
                                <?php echo form_close() ?>
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
         $('#bank').hide();
         $('#no_kartu').hide();
//
         $('#tunai').click(function () {
             $('#bank').hide()
             $('#no_kartu').hide()
         });
         
         var metode_byr = $('#metode_bayar option:selected').val();
         $("#metode_bayar").on('change',function () {
             if($('#metode_bayar option:selected').val() > 2){
                $('#bank').show();
                $('#no_kartu').show();
             }else{
                $('#bank').hide()
                $('#no_kartu').hide()
             }
         });

         // Tanggale Masuk
         $('#tgl_bayar').datepicker({
             autoclose: true,
         });
         
//      Jquery kanggo format angka
         $("#jml_bayar").autoNumeric({aSep: '.', aDec: ',', aPad: false});
         $("#disk1, #disk2, #disk3").autoNumeric({aSep: '.', aDec: ',', aPad: false});
//
         $("#tunai").click(function () {
             $("#jml_bayar").prop('readonly', false);
             $("#jml_bayar").val('');
             $("#saldo").hide();
             $("#saldo_label").hide();
         });
//
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
                 
            $("#disk1").keyup(function(){
                var disk1       = $('#disk1').val().replace(/[.]/g,"");
                var disk2       = $('#disk2').val().replace(/[.]/g,"");
                var disk3       = $('#disk3').val().replace(/[.]/g,"");
                var total       = $('#jml_total').val().replace(/[.]/g,"");
                var status_ppn  = $('#status_ppn').val().replace(/[.]/g,"");
                var ppn         = $('#ppn').val().replace(/[.]/g,"");
                
                var diskon1     = parseFloat(total) - ((parseFloat(disk1) / 100) * total);
                var diskon2     = parseFloat(diskon1) - ((parseFloat(disk2) / 100) * diskon1);
                var diskon3     = parseFloat(diskon2) - ((parseFloat(disk2) / 100));
                var jml_diskon  = parseFloat(total) - parseFloat(diskon3);
                
                var jml_subtotal= parseFloat(total) - parseFloat(jml_diskon);
                var jml_ppn;
                
                if(status_ppn == '1'){
                    jml_ppn = ((parseFloat(ppn) / 100) * jml_subtotal);
                    var jml_gtotal  = parseFloat(jml_subtotal) + parseFloat(jml_ppn);
                }else if(status_ppn == '2'){
                    jml_ppn = jml_subtotal - (jml_subtotal / 1.1);
                    var jml_gtotal  = jml_subtotal;
                }else{
                    jml_ppn = 0;
                    var jml_gtotal  = parseFloat(jml_subtotal) + parseFloat(jml_ppn);
                }                
                
          
                $('#jml_subtotal').val(Math.round(jml_subtotal)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                $('#jml_ppn').val(Math.round(jml_ppn)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                $('#jml_gtotal').val(Math.round(jml_gtotal)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
            });
            $("#disk2").keyup(function(){
                var disk1       = $('#disk1').val().replace(/[.]/g,"");
                var disk2       = $('#disk2').val().replace(/[.]/g,"");
                var disk3       = $('#disk3').val().replace(/[.]/g,"");
                var total       = $('#jml_total').val().replace(/[.]/g,"");
                var status_ppn  = $('#status_ppn').val().replace(/[.]/g,"");
                var ppn         = $('#ppn').val().replace(/[.]/g,"");
                
                var diskon1     = parseFloat(total) - ((parseFloat(disk1) / 100) * total);
                var diskon2     = parseFloat(diskon1) - ((parseFloat(disk2) / 100) * diskon1);
                var diskon3     = parseFloat(diskon2) - ((parseFloat(disk2) / 100));
                var jml_diskon  = parseFloat(total) - parseFloat(diskon3);
                
                var jml_subtotal= parseFloat(total) - parseFloat(jml_diskon);
                var jml_ppn;
                
                if(status_ppn == '1'){
                    jml_ppn = ((parseFloat(ppn) / 100) * jml_subtotal);
                    var jml_gtotal  = parseFloat(jml_subtotal) + parseFloat(jml_ppn);
                }else if(status_ppn == '2'){
                    jml_ppn = jml_subtotal - (jml_subtotal / 1.1);
                    var jml_gtotal  = jml_subtotal;
                }else{
                    jml_ppn = 0;
                    var jml_gtotal  = parseFloat(jml_subtotal) + parseFloat(jml_ppn);
                } 
          
                $('#jml_subtotal').val(Math.round(jml_subtotal)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                $('#jml_ppn').val(Math.round(jml_ppn)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                $('#jml_gtotal').val(Math.round(jml_gtotal)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
            });
            $("#disk3").keyup(function(){
                var disk1       = $('#disk1').val().replace(/[.]/g,"");
                var disk2       = $('#disk2').val().replace(/[.]/g,"");
                var disk3       = $('#disk3').val().replace(/[.]/g,"");
                var total       = $('#jml_total').val().replace(/[.]/g,"");
                var status_ppn  = $('#status_ppn').val().replace(/[.]/g,"");
                var ppn         = $('#ppn').val().replace(/[.]/g,"");
                
                var diskon1     = parseFloat(total) - ((parseFloat(disk1) / 100) * total);
                var diskon2     = parseFloat(diskon1) - ((parseFloat(disk2) / 100) * diskon1);
                var diskon3     = parseFloat(diskon2) - ((parseFloat(disk3) / 100) * diskon2);
                var jml_diskon  = parseFloat(total) - parseFloat(diskon3);
                
                var jml_subtotal= parseFloat(total) - parseFloat(jml_diskon);
                var jml_ppn;
                
                if(status_ppn == '1'){
                    jml_ppn = ((parseFloat(ppn) / 100) * jml_subtotal);
                    var jml_gtotal  = parseFloat(jml_subtotal) + parseFloat(jml_ppn);
                }else if(status_ppn == '2'){
                    jml_ppn = jml_subtotal - (jml_subtotal / 1.1);
                    var jml_gtotal  = jml_subtotal;
                }else{
                    jml_ppn = 0;
                    var jml_gtotal  = parseFloat(jml_subtotal) + parseFloat(jml_ppn);
                } 
          
                $('#jml_subtotal').val(Math.round(jml_subtotal)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                $('#jml_ppn').val(Math.round(jml_ppn)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                $('#jml_gtotal').val(Math.round(jml_gtotal)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
            });
            
            $("#disk_nom").keyup(function(){
                var diskon      = $('#disk_nom').val().replace(/[.]/g,"");
                var total       = $('#jml_total').val().replace(/[.]/g,"");
//                var retur       = $('#jml_retur').val().replace(/[.]/g,"");
                var ppn         = $('#ppn').val().replace(/[.]/g,"");
                
                var jml_subtotal= parseFloat(total-diskon);
                var jml_ppn     = ((parseFloat(ppn) / 100) * jml_subtotal);
                var jml_gtotal  = parseFloat(jml_subtotal) + parseFloat(jml_ppn);
          
                $('#jml_subtotal').val(Math.round(jml_subtotal)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                $('#jml_ppn').val(Math.round(jml_ppn)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                $('#jml_gtotal').val(Math.round(jml_gtotal)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
            });
            
            //Tipe Diskon
            $('#tipe_disk').change(function(){
                var tipe = $("#tipe_disk").val();
                if(tipe == 'nominal'){
                    $('#disk1').attr("disabled", 'disabled');
                    $('#disk2').attr("disabled", 'disabled');
                    $('#disk3').attr("disabled", 'disabled');
                    $('#disk_nom').removeAttr("disabled");
                }else{
                    $('#disk_nom').attr("disabled", 'disabled');
                    $('#disk1').removeAttr("disabled");
                    $('#disk2').removeAttr("disabled");
                    $('#disk3').removeAttr("disabled");
                }
            });
     });
</script>