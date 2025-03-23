<?php $hasError = $this->session->flashdata('form_error'); ?>
<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Input Retur <small>Pembelian Multiple</small></h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Transaksi</li>
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
                            <?php echo $this->session->flashdata('transaksi') ?>

                            <div class="row">
                                    <?php echo form_open_multipart(base_url('transaksi/set_retur_beli_m.php'), 'autocomplete="off"') ?>
                                    <input type="hidden" id="id_customer" name="id_customer">
                                    <input type="hidden" id="id_supplier" name="id_supplier">
                                    <input type="hidden" id="no_nota" name="no_nota" value="<?php echo $no_nota ?>">
                                    <input type="hidden" id="route" name="route" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2) ?>">
                                    <input type="hidden" id="id" name="id" value="<?php echo $this->input->get('id') ?>">

                                    <div class="col-md-6">                                    
                                        <table class="table table-striped">
                                            <tr>
                                                <th style="vertical-align: middle;">Tgl Retur</th>
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
                                                <th style="vertical-align: middle;">Supplier</th>
                                                <th style="vertical-align: middle;">:</th>
                                                <td style="vertical-align: middle;">
                                                    <div class="form-group <?php echo (!empty($hasError['pelanggan']) ? 'has-error' : '') ?>">
                                                        <?php echo form_input(array('id' => 'supplier', 'name' => 'supplier', 'class' => 'form-control pull-right')) ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php echo form_hidden('status_ppn', '0') ?>
                                            <tr>
                                                <td style="vertical-align: middle; text-align: right;" colspan="3">                                                
                                                    <button type="reset" onclick="window.location.href='<?php echo site_url('page=transaksi&act=set_nota_batal&term=trans_jual&route=trans_jual.php') ?>'" class="btn btn-warning btn-flat">Bersih</button>
                                                    <button type="submit" class="btn btn-primary btn-flat">Set Order</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php echo form_close() ?>
                                <?php if (!empty($sess_beli)) { ?>
                                <?php echo form_open_multipart(base_url('transaksi/input_pemb_beli_simpan.php'), 'autocomplete="off"') ?>
                                <input type="hidden" id="id_bayar" name="id_bayar" value="<?php echo general::enkrip($sess_jual['id']) ?>">
                                <input type="hidden" id="id" name="id_pembelian" value="<?php echo general::enkrip($sql_pemb->id) ?>">

                                <div class="col-md-6">                                    
                                    <table class="table table-striped">
                                        <tr>
                                            <th style="vertical-align: middle;">Cari Barang</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div class="input-group <?php echo (!empty($hasError['kode']) ? 'has-error' : '') ?>">
                                                    <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right', 'readonly'=>'TRUE', 'value'=>(isset($_GET['no_nota']) ? $sql_pemb->no_nota : ''))) ?>
                                                    <div class="input-group-addon text-middle">                                                        
                                                        <a href="<?php echo base_url('master/data_barang_list_retur_beli.php?nota='.$sess_beli['sess_id'].'&supp='.general::enkrip($sql_supplier->id).'&jml='.$sql_jml.'&route='.$sess_beli['route']); ?>" style="vertical-align: middle;">
                                                            <i class="fa fa-search"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                * Klik logo search untuk cari barang
                                            </td>
                                        </tr>
                                        <!--
                                        <tr>
                                            <th style="vertical-align: middle; width: 200px;">
                                                <div class="input-group <?php echo (!empty($hasError['harga']) ? 'has-error' : '') ?>">
                                                    Nominal
                                                </div>
                                            </th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div class="form-group <?php echo (!empty($hasError['harga']) ? 'has-error' : '') ?>">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">Rp</div>
                                                        <?php echo form_input(array('id' => 'nominal', 'name' => 'jml_bayar', 'class' => 'form-control pull-right', 'value'=>(!empty($last_hj) ? $last_hj : 0))) ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr id="bank">
                                                <th class="text-left" style="vertical-align: middle;">
                                                    Nama Bank
                                                </th>                                                
                                                <th style="vertical-align: middle;">:</th>
                                                <th class="text-right">
                                                    <?php echo form_input(array('name' => 'platform', 'class' => 'form-control pull-right text-right', 'placeholder' => 'Nama Bank ...')) ?>
                                                </th>
                                            </tr>
                                            <tr id="no_kartu">
                                                <th class="text-left" style="vertical-align: middle;">
                                                    Bukti / No. Referensi
                                                </th>                                                
                                                <th style="vertical-align: middle;">:</th>
                                                <th class="text-right">
                                                    <?php echo form_input(array('name' => 'keterangan', 'class' => 'form-control pull-right text-right', 'placeholder' => 'Bukti / No. Ref / No. Kartu ...')) ?>
                                                </th>
                                            </tr>
                                        -->
                                        <?php if($msg != NULL){ ?>
                                            <tr>
                                                <td colspan="3"><?php echo $msg; // $this->session->flashdata('notif'); ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php echo form_hidden('potongan', '0') ?>
                                        <!--
                                        <tr>
                                            <th style="vertical-align: middle;">Potongan</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        Rp
                                                    </div>
                                                    <?php echo form_input(array('id' => 'harga', 'name' => 'potongan', 'class' => 'form-control pull-right', 'value'=>'0')) ?>                                                   
                                                </div>
                                            </td>
                                        </tr>
                                        -->
                                        <?php if(isset($_GET['id'])){ ?>
                                        <tr>
                                            <td style="vertical-align: middle; text-align: right;" colspan="3">
                                                <!--<button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-cart-plus"></i> Bayar</button>-->
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                                <?php echo form_close() ?>
                                <?php } ?>
                            </div>
                            <?php if (!empty($sess_jual)) { ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($sess_beli)) { ?>
            <div class="row">                
                    <div class="col-lg-12">                        
                        <div class="box box-warning" id="data_pelanggan">
                            <div class="box-body  table-responsive">
                                <?php
                                $tglm = $this->tanggalan->tgl_indo($sess_beli['tgl_simpan']);
                                $tglj = $this->tanggalan->tgl_indo($sess_beli['tgl_keluar']);
                                
                                $sql_cust = $this->db->where('id', $sess_jual['id_pelanggan'])->get('tbl_m_pelanggan')->row();
                                ?>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Supplier</th>
                                        <th>:</th>
                                        <td><?php echo ucwords($sql_supplier->nama) ?></td>
                                        
                                        <th><?php echo nbs(5); ?></th>
                                        <th><?php echo nbs(); ?></th>
                                        <td><?php echo nbs(100); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tgl Retur</th>
                                        <th>:</th>
                                        <td><?php echo $tglm ?></td>
                                        
                                        <th><?php echo nbs(10); ?></th>
                                        <th><?php echo nbs(); ?></th>
                                        <td><?php echo nbs(100); ?></td>
                                    </tr>
                                </table>
                                <hr/>
                                    <table class="table table-stripped">
                                        <thead>                                        
                                            <tr>
                                                <th class="text-right"></th>
                                                <th class="text-center">No</th>
                                                <th class="text-left">No Nota</th>
                                                <th class="text-left">Nama Barang</th>
                                                <th class="text-right">Harga</th>
                                                <th class="text-center" colspan="3">Jml</th>
                                                <th class="text-center">Diskon (%)</th>
                                                <th class="text-right">Potongan</th>
                                                <th class="text-right">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($sess_beli_det)) { ?>
                                                <?php $no = 1; $tot_penj = 0; ?>
                                                <?php foreach ($sess_beli_det as $penj_det) { ?>
                                                <?php $tot_penj = $tot_penj + $penj_det['options']['subtotal']; ?>
                                                
                                                <?php echo form_open(site_url('page=transaksi&act=cart_retur_beli_m_update')) ?>
                                                <?php echo form_hidden('id['.$no.']', $penj_det['rowid']) ?>
                                                <?php echo form_hidden('kode['.$no.']', $penj_det['options']['kode']) ?>
                                                <?php echo form_hidden('id_barang['.$no.']', general::enkrip($penj_det['options']['id_barang'])) ?>
                                                <?php echo form_hidden('id_beli['.$no.']', general::enkrip($penj_det['options']['id_beli'])) ?>
                                                <?php echo form_hidden('id_beli_det['.$no.']', general::enkrip($penj_det['options']['id_beli_det'])) ?>
                                                <?php echo form_hidden('no_nota', general::enkrip($penj_det['options']['no_nota'])) ?>
                                                    <tr>
                                                        <td class="text-center">
                                                            <?php echo anchor(base_url('transaksi/cart_beli_hapus.php?id=' . general::enkrip($penj_det['rowid']).'&no_nota='.$sess_beli['sess_id'].'&route='.$sess_beli['route']), '<i class="fa fa-remove"></i>', 'class="text-danger" onclick="return confirm(\'Hapus [' . $penj_det['name'] . '] ?\')"') ?>
                                                        </td>
                                                        <td class="text-center"><?php echo $no; ?></td>
                                                        <td class="text-left"><?php echo $penj_det['options']['no_nota'] ?></td>
                                                        <td class="text-left"><?php echo $penj_det['name'] ?></td>
                                                        <td class="text-right"><?php echo form_input(array('id'=>'harga2', 'name'=>'harga['.$no.']', 'class'=>'form-control text-right', 'style'=>'width: 100px;', 'value'=>$penj_det['price'])) ?></td>
                                                        <td class="text-center"><?php echo form_input(array('id'=>'jml', 'name'=>'jml['.$no.']', 'class'=>'form-control text-right', 'style'=>'width: 50px;', 'value'=>(float)$penj_det['options']['jml'])) ?></td>
                                                        <td class="text-left" style="width: 140px;">
                                                            <select name="satuan<?php echo '['.$no.']' ?>" class="form-control">
                                                                <?php $sql_satuan2     =$this->db->where('id', $penj_det['options']['id_satuan'])->get('tbl_m_satuan')->row() ?>
                                                                <?php $sql_produk_sat2 =$this->db->where('id_produk', $penj_det['options']['id_barang'])->where('jml !=', '0')->get('tbl_m_produk_satuan')->result() ?>
                                                                <?php foreach ($sql_produk_sat2 as $satuan){ ?>
                                                                    <option value="<?php echo $satuan->satuan ?>" <?php echo ($satuan->satuan == $penj_det['options']['satuan'] ? 'selected' : '') ?>><?php echo ucwords($satuan->satuan).($satuan->satuan != $sql_satuan2->satuanTerkecil ? ' ('.$satuan->jml.' '.$sql_satuan2->satuanTerkecil.')' : '') ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                        <td class="text-center"><button type="submit" class="btn btn-flat btn-success" style="vertical-align: text-bottom; margin-bottom: 4px; width: 40px;"><i class="fa fa-recycle"></i></button></td>
                                                        <td class="text-center" style="width: 150px;">
                                                            <?php echo form_input(array('id'=>'diskon', 'name'=>'disk1['.$no.']', 'class'=>'text-center', 'style'=>'width: 25px;', 'value'=>(float)$penj_det['options']['disk1'])) . ' + ' .
                                                                    form_input(array('id'=>'diskon', 'name'=>'disk2['.$no.']', 'class'=>'text-center', 'style'=>'width: 25px;', 'value'=>(float)$penj_det['options']['disk2'])) . ' + ' .
                                                                    form_input(array('id'=>'diskon', 'name'=>'disk3['.$no.']', 'class'=>'text-center', 'style'=>'width: 25px;', 'value'=>(float)$penj_det['options']['disk3'])) ?></td>
                                                        <td class="text-right"><?php echo form_input(array('id'=>'potongan', 'name'=>'potongan['.$no.']', 'class'=>'form-control text-right', 'style'=>'width: 100px;', 'value'=>$penj_det['options']['potongan']))  ?></td>
                                                        <td class="text-right"><?php echo general::format_angka($penj_det['options']['subtotal'], 0) ?></td>
                                                    </tr>
                                                    <?php echo form_close() ?>
                                                <?php } ?>
                                                <tr>
                                                    <th class="text-right" colspan="10">
                                                        Total
                                                    </th>
                                                    <th class="text-right"><?php echo general::format_angka($tot_penj, 0) ?></th>
                                                </tr>
                                            <?php }else{ ?>
                                                <tr>
                                                    <td colspan="11" class="text-center text-bold">Data transaksi kosong</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                            </div>
                            <div class="box-footer">
                                <button type="button" class="btn btn-danger btn-flat pull-left" onclick="window.location.href='<?php echo base_url('transaksi/set_nota_batal.php?term=retur_beli_m&route='.$sess_beli['route']) ?>'"><i class="fa fa-remove"></i> Batal</button>
                                <?php echo form_open(base_url('transaksi/set_retur_beli_m_proses.php')) ?>
                                <?php if (!empty($sess_beli_det)) { ?>
                                    <?php echo form_hidden('no_nota', $sess_beli['sess_id']) ?>
                                    <button type="submit" class="btn btn-primary btn-flat pull-right">Simpan &raquo;</button>
                                <?php } ?>
                                <?php echo form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
        <?php } ?>
<!--            <div class="row">
                <div class="col-lg-12">
                    <pre>
                        <?php print_r($this->session->all_userdata()); ?>
                    </pre>
                </div>
            </div>-->
            
            
            <!--Modal form-->
            <div class="modal modal-default fade" id="modal-primary">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Form Pelanggan</h4>
                        </div>                            
                            <div class="row">
                                <div class="col-md-12">                                    
                                    <!--Nampilin message box success-->
                                    <div id="msg-success" class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h5><i class="glyphicon glyphicon-ok"></i><?php echo nbs(4) ?>Pelanggan berhasil ditambahkan !!</h5>
                                    </div>
                                </div>
                            </div>                
                        <form class="tagForm" id="form-pelanggan">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                            <label class="control-label">NIK</label>
                                            <?php echo form_input(array('id' => 'nik', 'name' => 'nik', 'class' => 'form-control')) ?>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Nama</label>
                                            <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control')) ?>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['nama_toko']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Nama Toko</label>
                                            <?php echo form_input(array('id' => 'nama_toko', 'name' => 'nama_toko', 'class' => 'form-control')) ?>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['no_hp']) ? 'has-error' : '') ?>">
                                            <label class="control-label">No. HP</label>
                                            <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control')) ?>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['lokasi']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Lokasi / Tempat Usaha</label>
                                            <?php echo form_input(array('id' => 'lokasi', 'name' => 'lokasi', 'class' => 'form-control')) ?>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Alamat</label>
                                            <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control')) ?>
                                        </div>
                                    </div>
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
  /* Metode Pembayaran */
  $('#bank').hide();
  $('#no_kartu').hide();
  
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
    
  $('#msg-success').hide(); 
  $(".select2").select2();
  $('#tgl_masuk').datepicker({
      autoclose: true,
  });

  $('#tgl_bayar').datepicker({
       autoclose: true,
  });
  
<?php if(!isset($_GET['id_produk'])){ ?>  
  //Autocomplete buat sales
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
          $itemrow.find('#id_sales').val(ui.item.id);
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
              .append("<a>" + item.nama + "</a>")
              .appendTo(ul);
  };
<?php } ?>
  
//  $("input[id=nominal]").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("input[id='harga'],input[id='potongan']").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("input[id='harga2']").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("input[id='diskon']").autoNumeric({aSep: '.', aDec: ',', aPad: false});
//  $("input[id='jml']").autoNumeric({aSep: '.', aDec: ',', aPad: false});
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
//       
//         /* Data Harga */         
//         $("#jns_harga").on('change',function () {
//            var regone = $('#jns_harga option:selected').val();
//            $('#harga').val(regone);
//         }); 	 

   });
</script>