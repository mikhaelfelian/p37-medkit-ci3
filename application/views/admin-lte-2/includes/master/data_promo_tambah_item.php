<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Promo <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Promo</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-4">
                <?php echo form_open(base_url('master/data_promo_'.(isset($_GET['id']) ? 'update' : 'simpan').'.php'), 'autocomplete="off"') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Data Promo</h3>
                    </div>
                    <div class="box-body">
                        <?php $hasError = $this->session->flashdata('form_error'); ?>
                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                        <div class="form-group <?php echo (!empty($hasError['kategori']) ? 'has-error' : '') ?>">
                            <label class="control-label">Promo</label>
                            <?php echo form_input(array('id' => 'promo', 'name' => 'promo', 'class' => 'form-control', 'value' => $promo->promo, 'readonly'=>'TRUE')) ?>
                        </div>

                        <div class="form-group <?php echo (!empty($hasError['keterangan']) ? 'has-error' : '') ?>">
                            <label class="control-label">Keterangan</label>
                            <?php echo form_input(array('id' => 'promo', 'name' => 'promo', 'class' => 'form-control', 'value' => $promo->keterangan, 'readonly'=>'TRUE')) ?>
                        </div>                       
                    </div>
                    <div class="box-footer">                        
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" onclick="window.location.href = '<?php echo base_url('master/data_promo_list.php') ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>
                            </div>
                            <div class="col-lg-6 text-right">
                                <!--<button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>-->
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
            <div class="col-lg-4">
                <?php echo form_open(base_url('master/data_promo_simpan_item.php')) ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Masukkan Barang Promo</h3>
                    </div>
                    <div class="box-body">
                        <?php echo $this->session->flashdata('master'); ?>
                        <?php $hasError = $this->session->flashdata('form_error'); ?>
                        <input type="hidden" id="id" name="id" value="<?php echo $this->input->get('id') ?>">
                        <input type="hidden" id="id_barang" name="id_barang">
                        
                        <div class="form-group <?php echo (!empty($hasError['kategori']) ? 'has-error' : '') ?>">
                            <label class="control-label">Produk</label>
                            <?php echo form_input(array('id' => 'produk', 'name' => 'produk', 'class' => 'form-control')) ?>
                        </div>                       
                        <div id="persen" class="form-group <?php echo (!empty($hasError['diskon']) ? 'has-error' : '') ?>">
                            <label class="control-label">Diskon (%)</label>
                            <div class="input-group">
                                <?php echo form_input(array('id' => 'diskon', 'name' => 'disk1', 'class' => 'form-control')) ?>
                                <span class="input-group-addon no-border text-bold">+</span>
                                <?php echo form_input(array('id' => 'diskon', 'name' => 'disk2', 'class' => 'form-control')) ?>
                                <span class="input-group-addon no-border text-bold">+</span>
                                <?php echo form_input(array('id' => 'diskon', 'name' => 'disk3', 'class' => 'form-control')) ?>
                            </div>
                        </div>                       
                    </div>
                    <div class="box-footer">                        
                        <div class="row">
                            <div class="col-lg-6">
                                <!--<button type="button" onclick="window.location.href = '<?php echo base_url('master/data_promo_list.php') ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>-->
                            </div>
                            <div class="col-lg-6 text-right">
                                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Barang Promo</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Promo</th>
                                    <th>Diskon (%)</th>
                                    <!--<th>Diskon</th>-->
                                    <!--<th>Tipe</th>-->
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($promo_item)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($promo_item as $promo) {
                                        $sql_produk = $this->db->where('id', $promo->id_produk)->get('tbl_m_produk')->row();
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <td><?php echo $sql_produk->produk ?></td>
                                            <td><?php echo ($promo->disk1 != 0 ? general::format_angka($promo->disk1) : '').($promo->disk2 != 0 ? ' + '.general::format_angka($promo->disk2) : '').($promo->disk3 != 0 ? ' + '.general::format_angka($promo->disk3) : '') ?></td>
                                            <!--<td><?php echo ($promo->tipe == 2 ? general::format_angka($promo->nominal) : general::format_angka($promo->disk1) . ' + ' . general::format_angka($promo->disk2) . ' + ' . general::format_angka($promo->disk3)) ?></td>-->
                                            <!--<td><?php echo general::status_promo($promo->tipe) ?></td>-->
                                            <td>
                                                <?php echo anchor(base_url('master/data_promo_hapus_item.php?id=' . general::enkrip($promo->id_promo).'&id_item=' . general::enkrip($promo->id)), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $sql_produk->produk . '] ? \')" class="label label-danger"') ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
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
  //Autocomplete buat produk
  $('#produk').autocomplete({
      source: function (request, response) {
          $.ajax({
              url: "<?php echo site_url('page=master&act=json_produk') ?>",
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
          $itemrow.find('#id_customer').val(ui.item.id);
          $('#id_barang').val(ui.item.id);
          $('#produk').val(ui.item.produk);
          
          //Give focus to the next input field to recieve input from user
          $('#produk').focus();
          return false;
      }
      
  //Format the list menu output of the autocomplete
  }).data("ui-autocomplete")._renderItem = function (ul, item) {
      return $("<li></li>")
              .data("item.autocomplete", item)
              .append("<a>" + item.kode + " - " + item.produk + "</a>")
              .appendTo(ul);
  };
});
</script>