<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Transaksi
                <small>Retur</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('dashboard.php') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
                <li class="active">Form Retur Pembelian</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-shopping-cart"></i> Form Retur Pembelian</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <?php echo form_open_multipart(base_url('transaksi/'.(!empty($_GET['id']) ? 'set_retur_beli_update' : 'set_retur_beli').'.php')) ?>
                                <input type="hidden" id="id" name="id" value="<?php echo $this->input->get('id') ?>">
                                <input type="hidden" id="no_nota" name="no_nota" value="<?php echo $this->input->get('no_nota') ?>">
                                <input type="hidden" id="route" name="route" value="<?php echo $this->input->get('route') ?>">
                                
                                <?php
                                    $tgl_msk = explode('-', $sql_pemb->tgl_masuk);
                                    $tgl_klr = explode('-', $sql_pemb->tgl_keluar);
                                ?>
                                <div class="col-md-6">
                                    <table class="table table-striped">
                                        <tr>
                                            <th style="vertical-align: middle;">No. Purchase Order</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">                                   
                                                <?php echo anchor(base_url('transaksi/trans_beli_det.php?id='.$this->input->get('no_nota')), $sql_ret->no_nota) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">No. Retur</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <?php echo form_input(array('name'=>'no_retur', 'class'=>'form-control', 'value' => $sql_ret->no_retur)) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Supplier</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">                                   
                                                <?php echo $sql_supplier->nama ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Tgl Transaksi</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <?php echo $tgl_msk[1].'/'.$tgl_msk[2].'/'.$tgl_msk[0] ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Jatuh Tempo</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <?php echo $tgl_klr[1].'/'.$tgl_klr[2].'/'.$tgl_klr[0] ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Status PPN</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <input type="checkbox" name="status_ppn" value="1" <?php echo ($sql_pemb->status_ppn == 1 ? 'checked="TRUE"' : '') ?>> Termasuk PPN
                                            </td>
                                        </tr>
                                        <!--
                                        <tr>
                                            <th style="vertical-align: middle;">Kode Faktur Pajak</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <?php echo $sql_pemb->kode_fp ?>
                                            </td>
                                        </tr>
                                        -->
                                        <tr>
                                            <td style="vertical-align: middle; text-align: right;" colspan="3">
                                                <?php $sess_ret_beli = $this->session->userdata('trans_retur_beli') ?>
                                                <?php if(!empty($sess_ret_beli)){ ?>
                                                <button type="button" class="btn btn-warning btn-flat" onclick="window.location.href='<?php echo base_url('transaksi/set_retur_beli_batal.php?no_nota='.$this->input->get('no_nota')) ?>'">Batal</button>
                                                <?php } ?>
                                                <button type="submit" class="btn btn-primary btn-flat">Set Retur Beli</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <?php echo form_close() ?>
                                <?php if (!empty($sess_ret_beli_ubah)) { ?>
                                <?php echo form_open_multipart(base_url('transaksi/cart_retur_beli_update.php')) ?>
                                <input type="hidden" id="id" name="id" value="<?php echo $_GET['id'] ?>">
                                <input type="hidden" id="id_barang" name="id_barang" value="<?php echo $_GET['id_produk'] ?>">
                                <input type="hidden" id="no_nota" name="no_nota" value="<?php echo $_GET['no_nota'] ?>">
                                <input type="hidden" id="route" name="route" value="<?php echo $_GET['route'] ?>">
                                
                                <div class="col-md-6">                                    
                                    <table class="table table-striped">
                                        <tr>
                                            <th style="vertical-align: middle;">Kode</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right', 'value'=>$sql_produk->kode)) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Jumlah</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div id="bag-pelanggan" class="<?php echo (!empty($hasError['pelanggan']) ? 'has-error' : '') ?>">
                                                    <div class="input-group date">
                                                        <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'style' => 'width: 100px;', 'value'=>1)) ?>
                                                        <?php if(isset($_GET['id_produk'])){ ?>
                                                            <span class="input-group-addon no-border text-bold"><?php echo nbs() ?></span>
                                                            <select name="satuan" class="form-control">
                                                                <option value="<?php echo $sql_satuan->satuanBesar ?>"><?php echo $sql_satuan->satuanBesar.' ('.$sql_satuan->jml.' '.$sql_satuan->satuanTerkecil.')' ?></option>
                                                                <option value="<?php echo $sql_satuan->satuanTerkecil ?>"><?php echo $sql_satuan->satuanTerkecil ?></option>
                                                            </select>
                                                            <span class="input-group-addon no-border text-bold"><?php echo nbs() ?></span>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Harga</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        Rp
                                                    </div>
                                                    <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control pull-right', 'value'=>$sql_pemb_det_row->harga)) ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Diskon</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div class="input-group">
                                                    <?php echo form_input(array('id' => 'disk1', 'name' => 'disk1', 'class' => 'form-control', 'value'=>$sql_pemb_det_row->disk1)) ?>
                                                    <span class="input-group-addon no-border text-bold">+</span>
                                                    <?php echo form_input(array('id' => 'disk2', 'name' => 'disk2', 'class' => 'form-control', 'value'=>$sql_pemb_det_row->disk2)) ?>
                                                    <span class="input-group-addon no-border text-bold">+</span>
                                                    <?php echo form_input(array('id' => 'disk3', 'name' => 'disk3', 'class' => 'form-control', 'value'=>$sql_pemb_det_row->disk3)) ?>
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
                                                    <?php echo form_input(array('id' => 'potongan', 'name' => 'potongan', 'class' => 'form-control pull-right', 'value'=>$sql_pemb_det_row->potongan)) ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;" colspan="3">
                                                <?php echo form_hidden(array('name'=>'tipe', 'value'=>'1')) ?>
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
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($sess_ret_beli_ubah)) { ?>
            <div class="row">                
                    <div class="col-lg-12">
                        <div class="box box-warning" id="data_pelanggan">
                            <div class="box-body">
                                <?php
                                $tglm = explode('-', $sql_pemb->tgl_masuk);
                                $tglj = explode('-', $sql_pemb->tgl_keluar);                                
                                ?>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Supplier</th>
                                        <th>:</th>
                                        <td><?php echo ucwords($sql_supplier->nama) ?></td>
                                        
                                        <th>Tgl Pembelian</th>
                                        <th>:</th>
                                        <td><?php echo $tglm[1].'/'.$tglm[2].'/'.$tglm[0] ?></td>
                                    </tr>
                                    <tr>
                                        <th>No. Purchase Order</th>
                                        <th>:</th>
                                        <td><?php echo ucwords($sql_pemb->no_nota) ?></td>
                                        
                                        <th>Tgl Jatuh Tempo</th>
                                        <th>:</th>
                                        <td><?php echo $tglj[1].'/'.$tglj[2].'/'.$tglj[0] ?></td>
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
                                                <th class="text-right">Harga Lusin</th>
                                                <th class="text-center">Jml</th>
                                                <th class="text-center">Diskon (%)</th>
                                                <th class="text-center">Potongan</th>
                                                <th class="text-right">Subtotal</th>
                                                <th class="text-right"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($sql_ret_det)) { ?>
                                                <?php $no = 1; $tot_penj = 0; ?>
                                                <?php foreach ($sql_ret_det as $penj_det) { ?>
                                                <?php $tot_penj = $tot_penj + $penj_det->subtotal; ?>
                                                    <tr>
                                                        <td class="text-center">
                                                            <?php echo anchor(base_url('transaksi/cart_retur_beli_hapus.php?id='.$this->input->get('id').'&no_nota='.$this->input->get('no_nota').'&id_barang='.general::enkrip($penj_det->id).'&route=ubah'), '<i class="fa fa-remove"></i>', 'class="text-danger" onclick="return confirm(\'Hapus [' . $penj_det->produk . '] ?\')"') ?>
                                                        </td>
                                                        <td class="text-center"><?php echo $no++; ?></td>
                                                        <td class="text-left"><?php echo $penj_det->kode ?></td>
                                                        <td class="text-left"><?php echo $penj_det->produk ?></td>
                                                        <td class="text-right"><?php echo general::format_angka($penj_det->harga) ?></td>
                                                        <td class="text-center"><?php echo (!empty($penj_det->keterangan) ? $penj_det->jml.' '.$penj_det->satuan.' '.$penj_det->keterangan : $penj_det->jml.' '.$penj_det->satuan) ?></td>
                                                        <td class="text-center"><?php echo general::format_angka($penj_det->disk1) . (!empty($penj_det->disk2) ? ' + ' . general::format_angka($penj_det->disk2) : '') . (!empty($penj_det->disk3) ? ' + ' . general::format_angka($penj_det->disk3) : '') ?></td>
                                                        <td class="text-right"><?php echo general::format_angka($penj_det->potongan, 0) ?></td>
                                                        <td class="text-right"><?php echo general::format_angka($penj_det->subtotal, 0) ?></td>
                                                        <td class="text-right"><?php echo general::status_retur($penj_det->status_retur) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <th class="text-right" colspan="8">
                                                        Total
                                                    </th>
                                                    <th class="text-right"><?php echo general::format_angka($tot_penj, 0) ?></th>
                                                    <th class="text-right"></th>
                                                </tr>
                                            <?php }else{ ?>
                                                <tr>
                                                    <td colspan="9" class="text-center text-bold">Data barang kosong</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                            </div>
                            <div class="box-footer">
                                <?php if (!empty($sql_ret_det)) { ?>
                                    <?php echo form_open(base_url('transaksi/set_retur_beli_proses_update.php')) ?>
                                    <?php echo form_hidden('route', $_GET['route']) ?>
                                    <?php echo form_hidden('id', $_GET['id']) ?>
                                    <?php echo form_hidden('no_nota', $_GET['no_nota']) ?>
                                    <button type="submit" class="btn btn-primary btn-flat pull-right">Simpan &raquo;</button>
                                    <?php echo form_close() ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="row">                
                    <div class="col-lg-12">
                        <div class="box box-warning" id="data_pelanggan">
                            <div class="box-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th colspan="8">No. Purchase Order <?php echo $sql_pemb->no_nota ?></th>
                                            </tr>
                                            <tr>
                                                <th class="text-right"></th>
                                                <th class="text-center">No</th>
                                                <th class="text-left">Kode Barang</th>
                                                <th class="text-left">Nama Barang</th>
                                                <th class="text-right">Harga Lusin</th>
                                                <th class="text-right">Jml</th>
                                                <th class="text-center">Diskon (%)</th>
                                                <th class="text-center">Potongan</th>
                                                <th class="text-right">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($sql_pemb_det)) { ?>
                                                <?php $no = 1; $tot_penj = 0; ?>
                                                <?php foreach ($sql_pemb_det as $penj_det) { ?>
                                                <?php $tot_penj = $tot_penj + $penj_det->subtotal; ?>
                                                <?php $sql_prod = $this->db->where('kode', $penj_det->kode)->get('tbl_m_produk')->row(); ?>
                                                    <tr>
                                                        <td class="text-center">
                                                            <?php echo anchor(base_url('transaksi/trans_retur_beli_ubah.php?id='.$this->input->get('id').'&no_nota='.$this->input->get('no_nota').'&id_produk='.general::enkrip($sql_prod->id)), '<i class="fa fa-mail-forward"></i>', 'class="text-danger" onclick="return confirm(\'Retur [' . $penj_det->produk . '] ?\')"') ?>
                                                        </td>
                                                        <td class="text-center"><?php echo $no++; ?><i class="fa fa-"></i></td>
                                                        <td class="text-left"><?php echo $penj_det->kode ?></td>
                                                        <td class="text-left"><?php echo $penj_det->produk ?></td>
                                                        <td class="text-right"><?php echo general::format_angka($penj_det->harga) ?></td>
                                                        <td class="text-right"><?php echo (!empty($penj_det->keterangan) ? $penj_det->jml.' '.$penj_det->satuan.' '.$penj_det->keterangan : $penj_det->jml.' '.$penj_det->satuan) ?></td>
                                                        <td class="text-center"><?php echo general::format_angka($penj_det->disk1) . (!empty($penj_det->disk2) ? ' + ' . general::format_angka($penj_det->disk2) : '') . (!empty($penj_det->disk3) ? ' + ' . general::format_angka($penj_det->disk3) : '') ?></td>
                                                        <td class="text-right"><?php echo general::format_angka($penj_det->potongan, 0) ?></td>
                                                        <td class="text-right"><?php echo general::format_angka($penj_det->subtotal, 0) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <th class="text-right" colspan="8">
                                                        Total
                                                    </th>
                                                    <th class="text-right"><?php echo general::format_angka($tot_penj, 0) ?></th>
                                                </tr>
                                            <?php }else{ ?>
                                                <tr>
                                                    <td colspan="8" class="text-center text-bold">Data barang kosong</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                            </div>
                            <div class="box-footer">
                                
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
                            <h4 class="modal-title">Form Pelanggan</h4>
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
  
  $("#harga").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("#potongan").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("#disk1").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("#disk2").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("#disk3").autoNumeric({aSep: '.', aDec: ',', aPad: false});
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
  
  //Autocomplete buat Barang
  $('#kode').autocomplete({
      source: function (request, response) {
          $.ajax({
              url: "<?php echo base_url('transaksi/json_barang.php') ?>",
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
          $('#harga').val(ui.item.harga);
          
          window.location.href = "<?php echo base_url('transaksi/trans_retur_beli.php?id='.$this->input->get('id').'&no_nota='.$this->input->get('no_nota').'&route='.$this->input->get('route')) ?>&id_produk="+ui.item.id;
          
          //Give focus to the next input field to recieve input from user
          $('#kode').focus();
          return false;
      }
      
  //Format the list menu output of the autocomplete
  }).data("ui-autocomplete")._renderItem = function (ul, item) {
      return $("<li></li>")
              .data("item.autocomplete", item)
              .append("<a>["+ item.kode +"] " + item.produk + " (" + item.jml + ")</a>")
              .appendTo(ul);
  };
   });
</script>