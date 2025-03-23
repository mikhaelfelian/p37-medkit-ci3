<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Transaksi
                <small>Mutasi Gudang</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('dashboard.php') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
                <li class="active">Form Mutasi Stok</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-shopping-cart"></i> Form Mutasi Stok</h3>
                        </div>
                        <div class="box-body table-responsive">
                            <?php echo $this->session->flashdata('gudang') ?>
<!--                            <pre>
                                <?php print_r($this->session->all_userdata()); ?>
                            </pre>-->
                            <div class="row">                                
                                <?php echo form_open_multipart(base_url('gudang/set_nota_mutasi.php'), 'autocomplete="off"') ?>
                                <input type="hidden" id="id_customer" name="id_customer">
                                <input type="hidden" id="no_nota" name="no_nota" value="<?php echo $no_nota ?>">
                                <input type="hidden" id="id" name="id" value="<?php echo $this->input->get('id') ?>">
                                
                                <div class="col-md-6">                                    
                                    <table class="table table-striped">
                                        <tr>
                                            <th style="vertical-align: middle;">User</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">                                   
                                                <div id="bag-pelanggan" class="<?php echo (!empty($hasError['pelanggan']) ? 'has-error' : '') ?>">
                                                    <!--<div class="form-group text-middle">-->
                                                    <!--<div class="input-group date">-->
                                                        <?php echo form_input(array('id' => 'customer', 'name' => 'customer', 'class' => 'form-control text-middle', 'style' => 'vertical-align: middle;', 'value'=>$this->ion_auth->user()->row()->first_name, 'readonly'=>'TRUE')) ?>
                                                    <!--</div>-->
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
                                            <th style="vertical-align: middle;">Tipe</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <select id="tipe" name="tipe" class="form-control">
                                                    <option value="">- Pilih -</option>
                                                    <option value="1">Pindah Gudang</option>
                                                    <option value="2">Stok Masuk</option>
                                                    <option value="3">Stok Keluar</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr id="gd_asal">
                                            <th style="vertical-align: middle;">Gudang Asal</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <select name="gd_asal" class="form-control">
                                                    <option value="">- Pilih -</option>
                                                    <?php foreach ($gudang as $gd_asal){ ?>
                                                        <option value="<?php echo $gd_asal->id ?>"><?php echo $gd_asal->gudang; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr id="gd_tujuan">
                                            <th style="vertical-align: middle;">Gudang Tujuan</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <select name="gd_tujuan" class="form-control">
                                                    <option value="">- Pilih -</option>
                                                    <?php foreach ($gudang as $gd_tujuan){ ?>
                                                        <option value="<?php echo $gd_tujuan->id ?>"><?php echo $gd_tujuan->gudang; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: top;">Keterangan</th>
                                            <th style="vertical-align: top;">:</th>
                                            <td style="vertical-align: middle;">
                                                <?php echo form_textarea(array('id' => 'keterangan', 'name' => 'ket', 'class' => 'form-control pull-right')) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle; text-align: right;" colspan="3">                                                
                                                <button type="reset" onclick="window.location.href='<?php echo site_url('page=transaksi&act=set_nota_batal&term=trans_jual&route=trans_jual.php') ?>'" class="btn btn-warning btn-flat">Bersih</button>
                                                <button type="submit" class="btn btn-primary btn-flat">Set Order</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <?php echo form_close() ?>
                                <?php if (!empty($sess_jual)) { ?>
                                <?php echo form_open_multipart('page=gudang&act=cart_nota_mutasi_simpan') ?>
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
                                            <th style="vertical-align: middle;">Jml</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div id="bag-pelanggan" class="<?php echo (!empty($hasError['pelanggan']) ? 'has-error' : '') ?>">
                                                    <div class="input-group date">
                                                        <?php if($sql_produk->status_brg_dep == '1'){ ?>
                                                                <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'value' => '1', 'style' => (!isset($_GET['id_produk']) ? 'width: 100px;' : ''), 'readonly'=>'TRUE')) ?>
                                                                    <?php if (isset($_GET['id_produk'])) { ?>
                                                                    <span class="input-group-addon no-border text-bold"><?php echo nbs() ?></span>
                                                                    <select id="satuan" name="satuan" class="form-control">
                                                                        <?php foreach ($sql_produk_sat as $satuan){ ?>
                                                                            <option value="<?php echo $satuan->satuan ?>"><?php echo ucwords($satuan->satuan).($satuan->satuan != $sql_satuan->satuanTerkecil ? ' ('.$satuan->jml.' '.$sql_satuan->satuanTerkecil.')' : '') ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <span class="input-group-addon no-border text-bold"><?php echo nbs(10) ?></span>
                                                                <?php } ?>
                                                        <?php }else{ ?>
                                                            <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'value'=>'1', 'style'=>(isset($_GET['id_produk']) ? 'width: 75px;' : ''))) ?>
                                                            <?php if(isset($_GET['id_produk'])){ ?>
                                                                <span class="input-group-addon no-border text-bold"><?php echo nbs() ?></span>
                                                                <select id="satuan" name="satuan" class="form-control">
                                                                    <?php foreach ($sql_produk_sat as $satuan){ ?>
                                                                       <option value="<?php echo $satuan->satuan ?>"><?php echo ucwords($satuan->satuan).($satuan->satuan != $sql_satuan->satuanTerkecil ? ' ('.$satuan->jml.' '.$sql_satuan->satuanTerkecil.')' : '') ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php if(isset($_GET['id_produk'])){ ?>
                                            <?php foreach ($sql_produk_stk as $stokny){ ?>
                                                <tr>
                                                    <th style="vertical-align: middle;"><?php echo $stokny->gudang ?></th>
                                                    <th style="vertical-align: middle;">:</th>
                                                    <td style="vertical-align: middle;"><?php echo floor($stokny->jml / $stokny->jml_satuan).' '.$stokny->satuanKecil; //.($stokny->satuan != $stokny->satuanKecil ? ' ('.$stokny->jml.' '.$stokny->satuanKecil.')' : '') ?></td>
                                                </tr>                                        
                                            <?php } ?>
                                        <?php } ?>
                                        <tr>
                                            <th style="vertical-align: middle;">&nbsp;</th>
                                            <th style="vertical-align: middle;"></th>
                                            <td style="vertical-align: middle;">
<!--                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        Rp
                                                    </div>
                                                    <?php // echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control pull-right', 'value'=>$sql_produk->harga_jual)) ?>
                                                </div>-->
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
                            <?php if (!empty($sess_jual)) { ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($sess_jual)) { ?>
            <div class="row">                
                    <div class="col-lg-12">
                        <div class="box box-warning" id="data_pelanggan">
                            <div class="box-body  table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Nama Petugas</th>
                                        <th>:</th>
                                        <td><?php echo strtoupper($this->ion_auth->user()->row()->first_name) ?></td>
                                        
                                        <th>Tgl Transaksi</th>
                                        <th>:</th>
                                        <td><?php echo $this->tanggalan->tgl_indo($sess_jual['tgl_masuk']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Keterangan</th>
                                        <th>:</th>
                                        <td colspan="4"><?php echo strtoupper($sess_jual['keterangan']) ?></td>
                                    </tr>
                                </table>
                                <hr/>
                                    <table class="table table-striped">
                                        <thead>                                        
                                            <tr>
                                                <th class="text-right" style="width: 20px;"></th>
                                                <th class="text-center" style="width: 20px;">No</th>
                                                <th class="text-left" style="width: 250px;">Kode Barang</th>
                                                <th class="text-left" style="width: 650px;">Nama Barang</th>
                                                <th class="text-right" style="width: 150px;">Jml</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($sql_penj_det)) { ?>
                                                <?php $no = 1; $tot_penj = 0; $itm = 0; ?>
                                                <?php foreach ($sql_penj_det as $penj_det) { ?>
                                                <?php $tot_penj = $tot_penj + $penj_det['qty']; ?>
                                                <?php $produk  = $this->db->where('id', $penj_det['options']['id_barang'])->get('tbl_m_produk')->row(); ?>
                                                    <tr>
                                                        <td class="text-center">
                                                            <?php echo anchor('page=gudang&act=cart_nota_mutasi_hapus&id='.general::enkrip($penj_det['rowid']) . '&no_nota=' . general::enkrip($penj_det['options']['no_nota']), '<i class="fa fa-remove"></i>', 'class="text-danger" onclick="return confirm(\'Hapus [' . $penj_det['name'] . '] ?\')"') ?>
                                                        </td>
                                                        <td class="text-center"><?php echo $no; ?></td>
                                                        <td class="text-left"><?php echo $penj_det['options']['kode'] ?></td>
                                                        <td class="text-left"><?php echo $penj_det['name'] ?></td>
                                                        <td class="text-right"><?php echo $penj_det['qty'].' '.$penj_det['options']['satuan'].' '.$penj_det['options']['satuan_ket'] ?></td>
                                                    </tr>
                                                <?php $no++; $itm++; ?>
                                                <?php } ?>
                                                <tr>
                                                    <th class="text-right" colspan="4">
                                                        Total item
                                                    </th>
                                                    <th class="text-right"><?php echo general::format_angka($itm, 0) ?> Item</th>
                                                </tr>
                                            <?php }else{ ?>
                                                <tr>
                                                    <td colspan="5" class="text-center text-bold">Data barang kosong</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <!--<pre>-->
                                    <?php // print_r($this->session->all_userdata()) ?>
                                <!--</pre>-->
                            </div>
                            <div class="box-footer">
                                <button type="button" class="btn btn-danger btn-flat pull-left" onclick="window.location.href='<?php echo site_url('page=gudang&act=set_nota_mutasi_batal') ?>'"><i class="fa fa-remove"></i> Batal</button>
                                <?php if (!empty($sql_penj_det)) { ?>
                                    <?php echo form_open('page=gudang&act=set_nota_mutasi_proses') ?>
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
  $('#gd_asal').hide();
  $('#gd_tujuan').hide();
  $('#msg-success').hide(); 
  $(".select2").select2();
  $('#tgl_masuk').datepicker({
      autoclose: true,
  });
  
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
          
    $("input[id=diskon]").keydown(function (e) {
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
  
<?php if (!empty($sess_jual)) { ?>
      //Autocomplete buat Barang
      $('#kode').autocomplete({
          source: function (request, response) {
              $.ajax({
                  url: "<?php echo site_url('page=gudang&act=json_barang') ?>",
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
              $('#jml').val('1');
              window.location.href = "<?php echo base_url('gudang/trans_mutasi.php?id='.$this->input->get('id')) ?>&id_produk="+ui.item.id+"&harga="+ui.item.harga; 
              
              //Give focus to the next input field to recieve input from user
              $('#jml').focus();
              return false;
          }
          
      //Format the list menu output of the autocomplete
      }).data("ui-autocomplete")._renderItem = function (ul, item) {
          return $("<li></li>")
                  .data("item.autocomplete", item)
                  .append("<a>["+ item.kode +"] " + item.produk + "</a>")
                  .appendTo(ul);
      };
<?php } ?>
       
         /* Data Satuan */         
         $("#satuan").on('change',function () {
             var sat_jual = $('#satuan option:selected').val();
           $.ajax({
               type: "GET",
               url: "<?php echo site_url('page=transaksi&act=json_barang_sat&id='.general::dekrip($this->input->get('id_produk'))) ?>&satuan=" + sat_jual + "",
               dataType: "json",
               success: function (data) {
                   $('#harga').val(data.harga);
               }
           });
         });
         
        $('#tipe').on('change', function() {
            if(this.value == '1'){
                $('#gd_asal').show();
                $('#gd_tujuan').show();
            }else if(this.value == '2'){
                $('#gd_asal').hide();
                $('#gd_tujuan').show();
            }else if(this.value == '3'){
                $('#gd_asal').show();
                $('#gd_tujuan').hide();
            }else{
                $('#gd_asal').hide();
                $('#gd_tujuan').hide();                
            }
        });

   });
</script>