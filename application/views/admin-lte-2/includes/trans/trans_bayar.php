<?php echo $this->session->flashdata('produk') ?>
<?php
$tgl_msk = $this->tanggalan->tgl_indo($sql_penj->tgl_masuk);
$tgl_klr = $this->tanggalan->tgl_indo($sql_penj->tgl_keluar);

$pelanggan = $this->db->where('id', $sql_penj->id_pelanggan)->get('tbl_m_pelanggan');
$klinik    = $this->db->where('id', $sql_penj->id_lokasi)->get('tbl_m_lokasi')->row();
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
                <li class="active">Keranjang Transaksi</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-shopping-cart"></i> Form Medical Checkup</h3>
                        </div>
                        <div class="box-body">
                            <?php echo $this->session->flashdata('transaksi') ?>
                            <table class="table table-striped">
                                <tr>
                                    <th>No. Invoice</th>
                                    <th>:</th>
                                    <td><?php echo $sql_penj->kode_nota_dpn.$sql_penj->no_nota.(!empty($sql_penj->kode_nota_blk) ? '/'.$sql_penj->kode_nota_blk : '') ?></td>

                                    <th>Pasien</th>
                                    <th>:</th>
                                    <td><?php echo $pelanggan->row()->nama ?></td>
                                </tr>
                                <tr>
                                    <th>Tgl Masuk</th>
                                    <th>:</th>
                                    <td><?php echo $this->tanggalan->tgl_indo($sql_penj->tgl_masuk) ?></td>

                                    <th>Tgl Keluar</th>
                                    <th>:</th>
                                    <td><?php echo $this->tanggalan->tgl_indo($sql_penj->tgl_keluar) ?></td>
                                </tr>
                                <tr>
                                    <th>Tipe</th>
                                    <th>:</th>
                                    <td><?php echo general::status_tp($sql_penj->status) ?></td>

                                    <th>Klinik</th>
                                    <th>:</th>
                                    <td><?php echo $klinik->lokasi ?></td>
                                </tr>
                            </table>
                            <hr/>
                            <?php echo $sql_penj->id_kategori; ?>
                            <br/>
                            <table class="table table-striped">
                                <tr>
                                    <th class="text-right"></th>
                                    <th class="text-center">No.</th>
                                    <th class="text-left">Kode</th>
                                    <th class="text-left">Item</th>
                                    <th class="text-right">Jml</th>
                                    <th class="text-right">Harga</th>
                                    <th class="text-left">Diskon</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                                <?php $no = 1; ?>
                                <?php $subtotal = 0; ?>
                                <?php foreach ($penj_det as $items) { ?>
                                    <?php
                                    $subtotal = $subtotal + $items->subtotal;
                                    ?>
                                    <tr>
                                        <td class="text-right" style="width: 25px; vertical-align: middle;"><?php // echo ($items->id_kategori2 == 0 && $sql_penj->status_bayar == 0 ? anchor(base_url('cart/cart_hapus_brg.php?id=' . general::enkrip($items->id) . '&no_nota=' . general::enkrip($items->no_nota)), '<i class="fa fa-remove"></i>', 'onclick="return confirm(\'Hapus ?\')" class="text-danger"') : '<i class="fa fa-remove"></i>')  ?></td>
                                        <td class="text-center" style="width: 50px; vertical-align: middle;"><?php echo $no++ ?></td>
                                        <td class="text-left" style="width: 150px; vertical-align: middle;">                                            
                                            <?php echo strtoupper($items->kode); ?>
                                        </td>
                                        <td class="text-left" style="width: 350px; vertical-align: middle;">                                            
                                            <?php echo ucwords($items->produk); ?>
                                        </td>
                                        <td class="text-right" style="width: 175px; vertical-align: middle;"><?php echo $items->jml.' '.$items->satuan.$items->keterangan; ?></td>
                                        <td class="text-right" style="width: 100px; vertical-align: middle;">
                                            <?php echo ($items->harga != 0 ? general::format_angka($items->harga) : ''); ?>
                                        </td>
                                        <td class="text-left" style="width: 75px; vertical-align: middle;">
                                            <?php echo ($items->disk1 != '0' ? general::format_angka($items->disk1) : '').($items->disk2 != '0' ? ' + '.general::format_angka($items->disk2) : '').($items->disk3 != '0' ? ' + '.general::format_angka($items->disk3) : '') ?>
                                        </td>
                                        <td class="text-right" style="vertical-align: middle; width: 200px;">
                                            <?php
                                            $disk1 = $items->subtotal - (($items->disk1 / 100) * $items->subtotal);
                                            $disk2 = $disk1 - (($items->disk2 / 100) * $disk1);
                                            $disk3 = $disk2 - (($items->disk3 / 100) * $disk2);
                                            ?>
                                            <?php echo general::format_angka($items->subtotal); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php echo form_open(base_url('transaksi/set_nota_bayar.php')) ?>
                                <?php echo form_hidden('no_nota', general::enkrip($sql_penj->id)) ?>
                                <!--
                                <tr>
                                    <th class="text-right" colspan="6" style="vertical-align: middle;">Total</th>
                                    <th class="text-right" colspan="2" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php $jml_dpp = $sql_penj->jml_total - $sql_penj->jml_retur ?>
                                            <?php echo form_input(array('id' => 'jml_total', 'name' => 'jml_total', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => general::format_angka($sql_penj->jml_total)   )) ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-right" style="vertical-align: middle;" colspan="6">Diskon 1 <?php echo (!empty($sql_penj->disk1) ? '('.round($sql_penj->disk1).'%)' : '') ?></th>
                                    <th class="text-right" style="width: 200px;" colspan="2">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'disk1', 'name' => 'jml_diskon', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => (int)$sql_penj->jml_disk1)) ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-right" style="vertical-align: middle;" colspan="6">Diskon 2 <?php echo (!empty($sql_penj->disk1) ? '('.round($sql_penj->disk2).'%)' : '') ?></th>
                                    <th class="text-right" style="width: 200px;" colspan="2">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'disk2', 'name' => 'jml_diskon', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => (int)$sql_penj->jml_disk2)) ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-right" style="vertical-align: middle;" colspan="6">Diskon 3 <?php echo (!empty($sql_penj->disk1) ? '('.round($sql_penj->disk3).'%)' : '') ?></th>
                                    <th class="text-right" style="width: 200px;" colspan="2">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'disk3', 'name' => 'jml_diskon', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => (int)$sql_penj->jml_disk3)) ?>
                                        </div>
                                    </th>
                                </tr>
                                -->
                                <tr>
                                    <th class="text-right" colspan="6" style="vertical-align: middle;">Subtotal</th>
                                    <th class="text-right" colspan="2" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_subtotal', 'name' => 'jml_subtotal', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => general::format_angka($sql_penj->jml_subtotal + $sql_penj->jml_diskon + $sql_penj->jml_retur))) ?>
                                        </div>
                                    </th>
                                </tr>
                                <?php if($sql_penj->status_bayar != '2'){ ?>
                                <tr>
                                    <th class="text-right" colspan="6" style="vertical-align: middle;">Diskon</th>
                                    <th class="text-right" colspan="2" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            %
                                            </div>
                                            <?php echo form_input(array('id' => 'diskon', 'name' => 'diskon', 'class' => 'form-control pull-right text-right', 'style'=>'width: 50px;', 'value' => general::format_angka($sql_penj->diskon))) ?>
                                            <span class="input-group-addon no-border text-bold"></span>
                                            <?php echo form_input(array('id' => 'jml_diskon', 'name' => 'jml_diskon', 'class' => 'form-control pull-right text-right', 'value' => 0)) ?>
                                        </div>
                                    </th>
                                </tr>
                                <?php }else{ ?>
                                <tr>
                                    <th class="text-right" colspan="6" style="vertical-align: middle;">Diskon</th>
                                    <th class="text-right" colspan="2" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            %
                                            </div>
                                            <?php echo form_input(array('id' => 'diskon', 'name' => 'diskon', 'class' => 'form-control pull-right text-right', 'style'=>'width: 50px;', 'readonly'=>'TRUE', 'value' => general::format_angka($sql_penj->diskon))) ?>
                                            <span class="input-group-addon no-border text-bold"></span>
                                            <?php echo form_input(array('id' => 'jml_diskon', 'name' => 'jml_diskon', 'class' => 'form-control pull-right text-right', 'readonly'=>'TRUE', 'value' => general::format_angka($sql_penj->jml_diskon))) ?>
                                        </div>
                                    </th>
                                </tr>
                                <?php } ?>
<!--                                <tr>
                                    <th class="text-right" colspan="6" style="vertical-align: middle;">Potongan Penj</th>
                                    <th class="text-right" colspan="2" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_potongan', 'name' => 'jml_potongan', 'class' => 'form-control pull-right text-right')) ?>
                                        </div>
                                    </th>
                                </tr>-->
                                <tr>
                                    <th class="text-right" colspan="6" style="vertical-align: middle;">Jml Biaya / Charge</th>
                                    <th class="text-right" colspan="2" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_biaya', 'name' => 'jml_biaya', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => '0')) ?>
                                        </div>
                                    </th>
                                </tr>
                                <?php if($sql_penj->status == '1'){ ?>
                                <tr>
                                    <th class="text-right" colspan="6" style="vertical-align: middle;">Potongan Retur</th>
                                    <th class="text-right" colspan="2" style="width: 200px;">
                                        <?php if($sql_penj->jml_retur > 0){ ?>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_retur', 'name' => 'jml_retur', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => general::format_angka($sql_penj->jml_retur))) ?>
                                        </div>
                                        <?php }else{ ?>
                                            <?php echo anchor(base_url('transaksi/trans_retur_jual.php?no_nota='.general::enkrip($sql_penj->id).'&route=trans_bayar_jual'), 'Retur Penjualan', 'class="text-red" style="font-style: italic;"') ?>
                                        <?php } ?>
                                    </th>
                                </tr>
                                <?php } ?>
                                <?php if($sql_penj->status_ppn == '1'){ ?>
                                <tr>
                                    <th colspan="6" class="text-right" style="vertical-align: middle;">
                                    PPN <?php echo (!empty($sql_penj->ppn) ? $sql_penj->ppn.' %' : '') ?>
                                    </th>
                                    <th class="text-right" colspan="2" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_ppn', 'name' => 'jml_ppn', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => general::format_angka($sql_penj->jml_ppn))) ?>
                                        </div>
                                    </th>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <th colspan="6" class="text-right" style="vertical-align: middle;">
                                        Grand Total
                                    </th>
                                    <th class="text-right" colspan="2" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_gtotal', 'name' => 'jml_gtotal', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => general::format_angka($sql_penj->jml_gtotal))) ?>
                                        </div>
                                    </th>
                                </tr>
                                <?php if($sql_penj->jml_kurang > 0){ ?>
                                    <tr>
                                        <th colspan="6" class="text-right" style="vertical-align: middle;">
                                            Jml Kekurangan
                                        </th>
                                        <th class="text-right" colspan="2" style="width: 200px;">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    Rp.
                                                </div>
                                                <?php echo form_input(array('id' => 'jml_kurang', 'name' => 'jml_kurang', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => general::format_angka($sql_penj->jml_kurang))) ?>
                                            </div>
                                        </th>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <th class="text-right" colspan="6" style="vertical-align: middle;">Tanggal Bayar</th>
                                    <th class="text-right" colspan="2" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <?php echo form_input(array('id' => 'tgl_bayar', 'name' => 'tgl_bayar', 'class' => 'form-control pull-right text-right', 'value'=>date('m/d/Y'))) ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-right" colspan="6" style="vertical-align: middle;">Jml Bayar</th>
                                    <th class="text-right" colspan="2" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_bayar', 'name' => 'jml_bayar', 'class' => 'form-control pull-right text-right')) ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="6" class="text-right" style="vertical-align: middle;">
                                        Metode Pembayaran
                                    </th>
                                    <th class="text-right" colspan="2" style="width: 250px;">
                                        <?php // if ($sql_penj->status_bayar == '0') { ?>
                                        <?php // echo form_radio(array('id' => 'tunai', 'name' => 'metode_bayar', 'value' => '1', 'checked' => 'TRUE')) . nbs(2) ?> 
                                        <select id="metode_bayar" name="metode_bayar" class="form-control" <?php // echo($sql_penj->status_bayar != '0' ? 'disabled="TRUE"' : '') ?>>
                                            <!--<option value="1">Tunai</option>-->
                                            <?php
                                            $sql_dep  = $this->db->select('tbl_m_pelanggan_grup.status_deposit')->join('tbl_m_pelanggan_grup','tbl_m_pelanggan_grup.id=tbl_m_pelanggan.id_grup')->where('tbl_m_pelanggan.id', $sql_penj->id_user)->get('tbl_m_pelanggan')->row();
                                                                                        
                                            if($sql_dep->status_deposit == '1'){
                                                echo '<option value="2">Deposit</option>';
                                            }
                                            ?>                                            
                                            <?php foreach ($platform as $platform) { ?>
                                                <?php // if($platform->id > 2) { ?>
                                                    <option value="<?php echo $platform->id ?>" <?php echo ($sql_penj->metode_bayar == $platform->id ? 'selected' : '') ?>><?php echo $platform->platform.($platform->persen != '0' ? ' + '.(int)$platform->persen.' %' : '').(!empty($platform->keterangan) ? ' ['.$platform->keterangan.']' : '') ?></option>
                                                <?php // } ?>
                                            <?php } ?>
                                        </select>
                                    </th>
                                </tr>
                                <tr id="bank">
                                    <th colspan="6" class="text-right" style="vertical-align: middle;">
                                        Nama Bank
                                    </th>
                                    <th class="text-right" colspan="2" style="width: 250px;">
                                        <?php echo form_input(array('name' => 'bank', 'class' => 'form-control pull-right text-right', 'placeholder' => 'Nama Bank ...')) ?>
                                    </th>
                                </tr>
                                <tr id="no_kartu">
                                    <th colspan="6" class="text-right" style="vertical-align: middle;">
                                        Bukti / No. Referensi
                                    </th>
                                    <th class="text-right" colspan="2" style="width: 250px;">
                                        <?php echo form_input(array('name' => 'no_kartu', 'class' => 'form-control pull-right text-right', 'placeholder' => 'Bukti / No. Ref / No. Kartu ...')) ?>
                                    </th>
                                </tr>
                            </table>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" onclick="window.location.href = '<?php echo base_url('transaksi/data_pemb_jual_list.php') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <?php if ($sql_penj->status_bayar == '0') { ?>
                                                    <!--//<?php // echo form_checkbox(array('name' => 'cetak', 'value' => '1')) . nbs(2)    ?> Cetak Nota-->
                                    <?php } ?>
                                    <?php echo nbs(5) ?>
                                    <?php if ($sql_penj->status_bayar != '1' OR $sql_penj->jml_kurang > 0) { ?>
                                        <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-cart-arrow-down"></i> Bayar &raquo;</button>
                                    <?php } else { ?>
                                        <button type="button" class="btn <?php echo ($sql_penj->cetak == '1' ? 'btn-danger' : 'btn-primary') ?> btn-flat" onclick="window.location.href = '<?php echo base_url('cart/cetak_nota.php?id=' . $this->input->get('id') . '&status_ctk=' . $sql_penj->cetak) ?>'"><i class="fa fa-print"></i> <?php echo ($sql_penj->cetak == '1' ? 'Cetak Ulang Nota' : 'Cetak Nota') ?></button>
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
         
        $("#disk1").autoNumeric({aSep: '.', aDec: ',', aPad: false});
        $("#disk2").autoNumeric({aSep: '.', aDec: ',', aPad: false});
        $("#disk3").autoNumeric({aSep: '.', aDec: ',', aPad: false});
//
         $('#tunai').click(function () {
             $('#bank').hide()
             $('#no_kartu').hide()
         });
         
         var metode_byr = $('#metode_bayar option:selected').val();
         $("#metode_bayar").on('change',function () {
			 var met_byr = $('#metode_bayar option:selected').val();
			 
             if($('#metode_bayar option:selected').val() > 2){
                $('#bank').show();
                $('#no_kartu').show();
             }else{
                $('#bank').hide()
                $('#no_kartu').hide()
             }
			 
           $.ajax({
               type: "GET",
               url: "<?php echo site_url('page=transaksi&act=json_platform') ?>&id=" + met_byr + "",
               dataType: "json",
               success: function (data) {
                   <?php if($sql_penj->jml_kurang > 0){ ?>
                           var jml_kurang   = $('#jml_kurang').val().replace(/[.]/g,"");
                           var jml_bayar    = parseFloat(jml_kurang);
                           
                           $('#jml_bayar').val(Math.round(jml_bayar)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                   <?php }else{ ?>
                        var jml_total    = $('#jml_subtotal').val().replace(/[.]/g,"");
                        var jml_diskon   = $('#jml_diskon').val().replace(/[.]/g,"");
                        var jml_diskon2  = <?php echo $sql_penj->jml_diskon ?>;
                        var jml_gtotal   = $('#jml_gtotal').val().replace(/[.]/g,"");
                        var jml_subtotal = (parseFloat(jml_total) - (parseFloat(jml_diskon) + parseFloat(jml_diskon2)));
                        var biaya        = (data.persen / 100) * jml_subtotal;
                        var jml_bayar    = parseFloat(jml_subtotal) + parseFloat(biaya);
          
                        $('#jml_biaya').val(Math.round(biaya)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                        $('#jml_gtotal').val(Math.round(jml_bayar)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                        $('#jml_bayar').val(Math.round(jml_bayar)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                   <?php } ?>
               }
           });
         });

         // Tanggale Masuk
         $('#tgl_bayar').datepicker({
             autoclose: true,
         });
         
//      Jquery kanggo format angka
         $("#jml_bayar").autoNumeric({aSep: '.', aDec: ',', aPad: false});
//         $("#jml_diskon").autoNumeric({aSep: '.', aDec: ',', aPad: false});
         $("#jml_potongan").autoNumeric({aSep: '.', aDec: ',', aPad: false});
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
                 
         /* Diskon */
         $("#diskon").keydown(function (e) {
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
                 
            $("#diskon").keyup(function(){
                var jml_total   = $('#jml_subtotal').val().replace(/[.]/g,"");
                var diskon      = $('#diskon').val().replace(/[.]/g,"");
                var jml_diskon  = (parseInt(diskon) / 100) * parseFloat(jml_total);
                var jml_gtotal  = parseFloat(jml_total) - parseFloat(jml_diskon);
          
                $('#jml_diskon').val(Math.round(jml_diskon)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                $('#jml_gtotal').val(Math.round(jml_gtotal)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
            });
                 
            $("#jml_diskon").keyup(function(){
                var jml_total   = $('#jml_subtotal').val().replace(/[.]/g,"");
                var diskon      = $('#jml_diskon').val().replace(/[.]/g,"");
                var jml_diskon  = (parseFloat(diskon) / parseFloat(jml_total)) * 100;
                var jml_gtotal  = parseFloat(jml_total) - parseFloat(diskon);
          
                $('#diskon').val('0').autoNumeric({aSep: '.', aDec: ',', aPad: false});
                $('#jml_gtotal').val(Math.round(jml_gtotal)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
            });
     });
</script>