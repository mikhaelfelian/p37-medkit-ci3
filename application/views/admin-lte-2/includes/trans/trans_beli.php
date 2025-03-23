<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Transaksi
                <small>Pembelian</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('dashboard.php') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
                <li class="active">Form Pembelian</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-shopping-cart"></i> Form Pembelian</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <?php echo form_open_multipart(base_url('transaksi/set_nota_beli.php'), 'autocomplete="off"') ?>
                                <input type="hidden" id="id_supplier" name="id_supplier">
                                <input type="hidden" id="id_sales" name="id_sales">
                                <!--<input type="hidden" id="no_nota" name="no_nota" value="<?php echo $no_nota ?>">-->
                                
                                <div class="col-md-6">                                    
                                    <table class="table table-striped">
                                        <tr>
                                            <th style="vertical-align: middle;">Nama Supplier</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">                                   
                                                <div id="bag-pelanggan" class="<?php echo (!empty($hasError['pelanggan']) ? 'has-error' : '') ?>">
                                                    <!--<div class="form-group text-middle">-->
                                                    <div class="input-group date">
                                                        <?php echo form_input(array('id' => 'supplier', 'name' => 'supplier', 'class' => 'form-control text-middle', 'style' => 'vertical-align: middle;')) ?>
                                                        <div class="input-group-addon text-middle">                                                        
                                                            <a href="#" data-toggle="modal" data-target="#modal-primary" style="vertical-align: middle;">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <!--</div>-->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Tgl</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <?php echo form_input(array('id' => 'tgl_masuk', 'name' => 'tgl_masuk', 'class' => 'form-control pull-right', 'value' => date('m/d/Y'))) ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Jatuh Tempo</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <?php echo form_input(array('id' => 'tgl_tempo', 'name' => 'tgl_tempo', 'class' => 'form-control pull-right', 'value' => date('m/d/Y'))) ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Kode Purchase Order</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <?php echo form_input(array('id' => 'no_nota', 'name' => 'no_nota', 'class' => 'form-control pull-right')) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Status PPN</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <?php echo form_radio(array('id' => 'status_ppn', 'name' => 'status_ppn', 'value' => '0', 'checked'=>'TRUE')) ?> Non PPN <?php echo nbs(2); ?>
                                                <?php echo form_radio(array('id' => 'status_ppn', 'name' => 'status_ppn', 'value' => '1')) ?> Tambah PPN <?php echo nbs(2); ?>
                                                <?php echo form_radio(array('id' => 'status_ppn', 'name' => 'status_ppn', 'value' => '2')) ?> Include PPN  <?php echo nbs(2); ?>
                                                <?php // echo form_checkbox(array('id' => 'status_ppn', 'name' => 'status_ppn', 'value' => '1', 'class' => 'pull-left')).nbs(3) ?>
                                            </td>
                                        </tr>
                                        <!--
                                        <tr>
                                            <th style="vertical-align: middle;">Sales</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <?php echo form_input(array('id' => 'sales', 'name' => 'sales', 'class' => 'form-control pull-right')) ?>
                                            </td>
                                        </tr>
                                        -->
                                        <tr>
                                            <td style="vertical-align: middle; text-align: right;" colspan="3">                                                
                                                <button type="reset" class="btn btn-warning btn-flat">Bersih</button>
                                                <button type="submit" class="btn btn-primary btn-flat">Set Order</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <?php echo form_close() ?>
                                <?php if (!empty($sess_beli)) { ?>
                                <?php echo form_open_multipart(base_url('transaksi/cart_beli_simpan.php')) ?>
                                <input type="hidden" id="id_barang" name="id_barang" value="<?php echo $this->input->get('id_produk') ?>">
                                <input type="hidden" id="no_nota" name="no_nota" value="<?php echo $_GET['id'] ?>">
                                
                                <div class="col-md-6">                                    
                                    <table class="table table-striped">
                                        <tr>
                                            <th style="vertical-align: middle;">Kode</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right', 'value'=>(isset($_GET['id_produk']) ? $sql_produk->kode : ''))) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Jumlah</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div class="input-group">
                                                        <?php if($sql_produk->status_brg_dep == '1'){ ?>
                                                                <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'value' => '1', 'style' => (!isset($_GET['id_produk']) ? 'width: 100px;' : ''), 'readonly'=>'TRUE')) ?><?php if (isset($_GET['id_produk'])) { ?>
                                                                    <span class="input-group-addon no-border text-bold"><?php echo nbs() ?></span>
                                                                    <select name="satuan" class="form-control">
                                                                        <?php foreach ($sql_produk_sat as $satuan){ ?>
                                                                            <option value="<?php echo $satuan->satuan ?>"><?php echo ucwords($satuan->satuan).($satuan->satuan != $sql_satuan->satuanTerkecil ? ' ('.$satuan->jml.' '.$sql_satuan->satuanTerkecil.')' : '') ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <span class="input-group-addon no-border text-bold"><?php echo nbs(10) ?></span>
                                                                <?php } ?>
                                                        <?php }else{ ?>
                                                            <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'value'=>'1', 'style'=>(!isset($_GET['id_produk']) ? 'width: 100px;' : ''))) ?>
                                                            <?php if(isset($_GET['id_produk'])){ ?>
                                                                <span class="input-group-addon no-border text-bold"><?php echo nbs() ?></span>
                                                                <select name="satuan" class="form-control">
                                                                    <?php foreach ($sql_produk_sat as $satuan){ ?>
                                                                       <option value="<?php echo $satuan->satuan ?>"><?php echo ucwords($satuan->satuan).($satuan->satuan != $sql_satuan->satuanTerkecil ? ' ('.$satuan->jml.' '.$sql_satuan->satuanTerkecil.')' : '') ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            <?php } ?>
                                                        <?php } ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php if($sql_produk->status_brg_dep == '1'){ ?>
                                        <tr>
                                            <th style="vertical-align: middle;">Deposit</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        Rp
                                                    </div>
                                                    <?php echo form_input(array('id' => 'jml_deposit', 'name' => 'jml_deposit', 'class' => 'form-control pull-right', 'value'=>(isset($_GET['id_produk']) ? '0' : ''))) ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        <?php 
                                        $sess_beli['status_ppn'];
                                        
                                        $harga_beli = ($sql_produk->harga_beli_ppn > 0 ? ($sql_produk->harga_beli / 1.1) : $sql_produk->harga_beli)
                                        ?>
                                        <tr>
                                            <th style="vertical-align: middle;">Harga</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        Rp
                                                    </div>
                                                    <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control pull-right', 'value'=>(isset($_GET['id_produk']) ? $harga_beli : ''))) ?>
                                                </div>
                                            </td>
                                        </tr>                                        
                                        <tr>
                                            <th style="vertical-align: middle;">Diskon</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div class="input-group">
                                                    <?php echo form_input(array('id' => 'diskon', 'name' => 'disk1', 'class' => 'form-control')) ?>
                                                    <span class="input-group-addon no-border text-bold">+</span>
                                                    <?php echo form_input(array('id' => 'diskon', 'name' => 'disk2', 'class' => 'form-control')) ?>
                                                    <span class="input-group-addon no-border text-bold">+</span>
                                                    <?php echo form_input(array('id' => 'diskon', 'name' => 'disk3', 'class' => 'form-control')) ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Potongan</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        Rp
                                                    </div>
                                                    <?php echo form_input(array('id' => 'potongan', 'name' => 'potongan', 'class' => 'form-control pull-right')) ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php if(isset($_GET['id'])){ ?>
                                        <tr>
                                            <td style="vertical-align: middle; text-align: right;" colspan="3">                                                
                                                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-cart-plus"></i> Simpan</button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                                <?php echo form_close() ?>
                                <?php } ?>
                            </div>
                            <?php if (!empty($sess_beli)) { ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($sess_beli)) { ?>
            <div class="row">                
                    <div class="col-lg-12">
                        <div class="box box-warning" id="data_pelanggan">
                            <div class="box-body">
                                <?php
                                $tglm = explode('-', $sess_beli['tgl_masuk']);
                                $tglj = explode('-', $sess_beli['tgl_keluar']);
                                ?>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Nama Supplier</th>
                                        <th>:</th>
                                        <td><?php echo ucwords($sql_supplier->nama) ?></td>
                                        
                                        <th>Tgl Pembelian</th>
                                        <th>:</th>
                                        <td><?php echo $tglm[1].'/'.$tglm[2].'/'.$tglm[0] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Kode Supplier</th>
                                        <th>:</th>
                                        <td><?php echo ucwords($sql_supplier->kode) ?></td>
                                        
                                        <th>Tgl Jatuh Tempo</th>
                                        <th>:</th>
                                        <td><?php echo $tglj[1].'/'.$tglj[2].'/'.$tglj[0] ?></td>
                                    </tr>
                                    <tr>
                                        <th>No. Purchase Order</th>
                                        <th>:</th>
                                        <td><?php echo strtoupper($sess_beli['no_nota']) ?></td>
                                        
                                        <th>Status PPN</th>
                                        <th>:</th>
                                        <td><?php echo general::status_ppn($sess_beli['status_ppn']) ?></td>
                                    </tr>
                                </table>
                                <hr/>
                                    <table class="table table-striped">
                                        <thead>                                        
                                            <tr>
                                                <th class="text-right"></th>
                                                <th class="text-center">No</th>
                                                <th class="text-left">Kode Barang</th>
                                                <th class="text-left">Nama Barang</th>
                                                <th class="text-right">Harga</th>
                                                <th class="text-center" colspan="3">Jml</th>
                                                <th class="text-center">Diskon (%)</th>
                                                <th class="text-right">Potongan</th>
                                                <th class="text-right">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($sql_pemb_det)) { ?>
                                                <?php $no = 1; $tot_penj = 0; ?>
                                                <?php foreach ($sql_pemb_det as $pemb_det) { ?>
                                                <?php $tot_penj = $tot_penj + $pemb_det['options']['subtotal'] ?>
                                                <?php echo form_open(site_url('page=transaksi&act=cart_beli_simpan2')) ?>
                                                <?php echo form_hidden('id['.$no.']', $pemb_det['rowid']) ?>
                                                <?php echo form_hidden('kode['.$no.']', $pemb_det['options']['kode']) ?>
                                                <?php echo form_hidden('id_barang['.$no.']', general::enkrip($pemb_det['options']['id_barang'])) ?>
                                                <?php echo form_hidden('no_nota', general::enkrip($pemb_det['options']['no_nota'])) ?>
                                                    <tr>
                                                        <td class="text-center">
                                                            <?php echo anchor(base_url('transaksi/cart_beli_hapus.php?id=' . general::enkrip($pemb_det['rowid']) . '&no_nota=' . general::enkrip($pemb_det['options']['no_nota'])), '<i class="fa fa-remove"></i>', 'class="text-danger" onclick="return confirm(\'Hapus [' . $pemb_det['name'] . '] ?\')"') ?>
                                                        </td>
                                                        <td class="text-center"><?php echo $no; ?></td>
                                                        <td class="text-left"><?php echo $pemb_det['options']['kode'] ?></td>
                                                        <td class="text-left"><?php echo $pemb_det['name'] ?></td>
                                                        <td class="text-right"><?php echo form_input(array('id'=>'harga2', 'name'=>'harga['.$no.']', 'class'=>'form-control text-right', 'style'=>'width: 100px;', 'value'=>$pemb_det['price'])) ?></td>
                                                        <td class="text-center"><?php echo form_input(array('id'=>'jml', 'name'=>'jml['.$no.']', 'class'=>'form-control text-right', 'style'=>'width: 50px;', 'value'=>$pemb_det['options']['jml'])) ?></td>
                                                        <td class="text-left">
                                                            <select name="satuan<?php echo '['.$no.']' ?>" class="form-control">
                                                                <?php $sql_satuan2     =$this->db->where('id', $pemb_det['options']['id_satuan'])->get('tbl_m_satuan')->row() ?>
                                                                <?php $sql_produk_sat2 =$this->db->where('id_produk', $pemb_det['options']['id_barang'])->where('jml !=', '0')->get('tbl_m_produk_satuan')->result() ?>
                                                                <?php foreach ($sql_produk_sat2 as $satuan){ ?>
                                                                    <option value="<?php echo $satuan->satuan ?>" <?php echo ($satuan->satuan == $pemb_det['options']['satuan'] ? 'selected' : '') ?>><?php echo ucwords($satuan->satuan).($satuan->satuan != $sql_satuan2->satuanTerkecil ? ' ('.$satuan->jml.' '.$sql_satuan2->satuanTerkecil.')' : '') ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                        <td class="text-center"><button type="submit" class="btn btn-flat btn-success" style="vertical-align: text-bottom; margin-bottom: 4px;"><i class="fa fa-recycle"></i></button></td>
                                                        <td class="text-center">
                                                            <?php echo form_input(array('id'=>'diskon', 'name'=>'disk1['.$no.']', 'class'=>'text-center', 'style'=>'width: 25px;', 'value'=>(float)$pemb_det['options']['disk1'])) . ' + ' .
                                                                    form_input(array('id'=>'diskon', 'name'=>'disk2['.$no.']', 'class'=>'text-center', 'style'=>'width: 25px;', 'value'=>(float)$pemb_det['options']['disk2'])) . ' + ' .
                                                                    form_input(array('id'=>'diskon', 'name'=>'disk3['.$no.']', 'class'=>'text-center', 'style'=>'width: 25px;', 'value'=>(float)$pemb_det['options']['disk3'])) ?></td>
                                                        <td class="text-right"><?php echo form_input(array('id'=>'potongan', 'name'=>'potongan['.$no.']', 'class'=>'form-control text-right', 'style'=>'width: 100px;', 'value'=>$pemb_det['options']['potongan']))  ?></td>
                                                        <td class="text-right"><?php echo general::format_angka($pemb_det['options']['subtotal'], 0) ?></td>
                                                    </tr>
                                                        <?php $no++ ?>
                                                <?php } ?>
                                                <tr>
                                                    <th class="text-right" colspan="10">
                                                        Total
                                                    </th>
                                                    <th class="text-right"><?php echo general::format_angka($tot_penj, 0) ?></th>
                                                </tr>
                                            <?php }else{ ?>
                                                <tr>
                                                    <td colspan="8" class="text-center text-bold">Data barang kosong</td>
                                                </tr>
                                            <?php } ?>
                                                <?php echo form_close(); ?>
                                        </tbody>
                                    </table>
                            </div>
                            <div class="box-footer">
                                <button type="button" class="btn btn-danger btn-flat pull-left" onclick="window.location.href='<?php echo base_url('transaksi/set_nota_batal.php?term=beli&route=transaksi/trans_beli.php') ?>'"><i class="fa fa-remove"></i> Batal</button>
                                <?php if (!empty($sql_pemb_det)) { ?>
                                    <?php echo form_open(base_url('transaksi/set_nota_beli_proses.php')) ?>
                                    <?php echo form_hidden('no_nota', $_GET['id']) ?>
                                    <button type="submit" class="btn btn-primary btn-flat pull-right">Simpan &raquo;</button>
                                    <?php echo form_close() ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
        <?php } ?>
            
            
            <!--Modal form-->
            <div class="modal modal-default fade" id="modal-primary">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Form Supplier</h4>
                        </div>                
                        <form class="tagForm" id="form-pelanggan">
                            <div class="modal-body">
                                <!--Nampilin message box success-->
                                <div id="msg-success" class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="glyphicon glyphicon-ok"></i><?php echo nbs(4) ?>Pelanggan berhasil ditambahkan !!</h5>
                                </div>

                                <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                    <label class="control-label">NIK</label>
                                    <?php echo form_input(array('id' => 'nik', 'name' => 'nik', 'class' => 'form-control')) ?>
                                </div>

                                <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Nama</label>
                                    <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control')) ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['no_hp']) ? 'has-error' : '') ?>">
                                    <label class="control-label">No. HP</label>
                                    <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control')) ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Alamat</label>
                                    <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control')) ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary btn-flat pull-left" data-dismiss="modal">Close</button>
                                <button type="button" id="submit-pelanggan" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.container -->
</div>

<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.min.css') ?>">

<!--Datepicker-->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Page script -->
<script>
$(function () {
  $('#msg-success').hide(); 
  $(".select2").select2();
  $('#tgl_masuk').datepicker({
      autoclose: true,
  });

  $('#tgl_tempo').datepicker({
    autoclose: true,
  });

  $('#tgl_bayar').datepicker({
       autoclose: true,
  });
  
  $("input[id='harga'],input[id='potongan']").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("input[id='harga2']").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("input[id='diskon']").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("#jml_deposit").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("input[id='jml']").keydown(function (e) {
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
  $("#ppn").keydown(function (e) {
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
  
  //Autocomplete buat produk
  $('#supplier').autocomplete({
      source: function (request, response) {
          $.ajax({
              url: "<?php echo base_url('transaksi/json_supplier.php') ?>",
              dataType: "json",
              data: {
                  term: request.term
              },
              success: function (data) {
                  response(data);
              }
          });
      },
      minLength: 1,
      select: function (event, ui) {
          var $itemrow = $(this).closest('tr');
          //Populate the input fields from the returned values
          $itemrow.find('#id_supplier').val(ui.item.id);
          $('#id_supplier').val(ui.item.id);
          $('#supplier').val(ui.item.nama);
          
          //Give focus to the next input field to recieve input from user
          $('#supplier').focus();
          return false;
      }
      
  //Format the list menu output of the autocomplete
  }).data("ui-autocomplete")._renderItem = function (ul, item) {
      return $("<li></li>")
              .data("item.autocomplete", item)
              .append("<a>["+ item.kode +"] " + item.nama + "</a>")
              .appendTo(ul);
  };
  
  <?php if (!empty($sess_beli)) { ?>
  //Autocomplete buat Barang
  $('#kode').autocomplete({
      source: function (request, response) {
          $.ajax({
              url: "<?php echo base_url('transaksi/json_barang.php?mod=beli') ?>",
              dataType: "json",
              data: {
                  term: request.term
              },
              success: function (data) {
                  response(data);
              }
          });
      },
      minLength: 1,
      select: function (event, ui) {
          var $itemrow = $(this).closest('tr');
          //Populate the input fields from the returned values
          $itemrow.find('#id_barang').val(ui.item.id);
          $('#id_barang').val(ui.item.id);
          $('#kode').val(ui.item.kode);
          $('#harga').val(ui.item.harga_beli);
          $('#satuan').val(ui.item.satuan);
          
          window.location.href = "<?php echo base_url('transaksi/trans_beli.php?id='.$this->input->get('id')) ?>&id_produk="+ui.item.id; 
          //Give focus to the next input field to recieve input from user
          $('#jml').focus();
          return false;
      }
      
  //Format the list menu output of the autocomplete
  }).data("ui-autocomplete")._renderItem = function (ul, item) {
      return $("<li></li>")
              .data("item.autocomplete", item)
              .append("<a>["+ item.kode +"] " + item.produk + " (" + item.jml + ")</a>")
              .appendTo(ul);
  };
  <?php } ?>

       $('#submit-pelanggan').on('click', function (e) {
           var nik = $('#nik').val();
           var nama = $('#nama').val();
           var no_hp = $('#no_hp').val();
           var alamat = $('#alamat').val();
////
           e.preventDefault();
           $.ajax({
               type: "POST",
               url: "<?php echo base_url('master/data_supplier_simpan2.php') ?>",
               data: $("#form-pelanggan").serialize(),
               success: function (data) {
                   $('#nik').val('');
                   $('#nama').val('');
                   $('#no_hp').val('');
                   $('#alamat').val('');
//
//                   $("#bag-pelanggan").load("<?php echo base_url('transaksi/trans_beli.php') ?> #bag-pelanggan", function () {
//                       $(".select2").select2();
//                   });
                   $('#msg-success').show();
                   $("#modal-primary").modal('hide');
                   setTimeout(function () {
                       $('#msg-success').hide('blind', {}, 500)
                   }, 3000);
               },
               error: function () {
                   alert('Error');
               }
           });
           return false;
       });
   });
</script>