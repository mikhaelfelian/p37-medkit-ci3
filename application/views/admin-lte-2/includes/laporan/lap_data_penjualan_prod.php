<?php $hasError = $this->session->flashdata('form_error'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Laporan <small>Data Penjualan Produk</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li>Laporan</li>
            <li class="active">Penjualan Produk</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-6">
                <?php echo form_open(base_url('laporan/set_lap_penjualan_prod.php'), 'autocomplete="off"') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Laporan</h3>
                    </div>
                    <div class="box-body">
                        <?php echo $this->session->flashdata('laporan'); ?>
                        <div class="form-group">
                            <label class="control-label">Tipe</label>
                            <br/>
                            <input type="radio" id="tp-semua" name="tipe" value="1" checked="TRUE"> Per Merk
                            <?php echo nbs(5); ?>
                            <input type="radio" id="tp-produk" name="tipe" value="2"> Per Produk
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Tgl</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control pull-right', 'value' => $this->tanggalan->tgl_indo($this->input->get('query')))) ?>
                                    </div>
                                </div>
                                <div class="form-group" id="lbl-merk">
                                    <label class="control-label">Merk</label>
                                    <select name="merk" class="form-control">
                                        <option value="">[Semua]</option>
                                        <?php foreach ($sql_merk as $merk) { ?>
                                            <option value="<?php echo $merk->merk ?>" <?php echo ($merk->merk == $_GET['merk'] ? 'selected' : '') ?>><?php echo strtoupper($merk->merk) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group" id="lbl-produk">
                                    <label class="control-label">Produk</label>
                                    <input type="hidden" id="id_produk" name="id_produk">
                                    <?php echo form_input(array('id' => 'produk', 'name' => 'produk', 'class' => 'form-control pull-right')) ?>
                                </div>
                            </div>
                            <div class="col-sm-6">                                
                                <div class="form-group <?php echo (!empty($hasError['tgl']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Rentang <i>* Cth : 10/01/2019 - 10/31/2019</i></label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i id="tgl_rtg" class="fa fa-calendar"></i>
                                        </div>
                                        <?php echo form_input(array('id' => 'tgl_rentang', 'name' => 'tgl_rentang', 'class' => 'form-control pull-right', 'value' => '')) ?>
                                    </div>                                    
                                </div>
                                <div class="form-group" id="">
                                    <label class="control-label">Kasir</label>
                                    <select name="kasir" class="form-control">
                                        <option value="">[Semua]</option>
                                        <?php foreach ($sql_kasir as $kasir) { ?>
                                            <option value="<?php echo $kasir->id_user ?>" <?php echo ($kasir->id_user == $_GET['sales'] ? 'selected' : '') ?>><?php echo strtoupper($kasir->nama) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info btn-flat pull-right"><i class="fa fa-search"></i> Cari</button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>

        <?php if (!empty($penjualan)) { ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data Penjualan Produk</h3>
                        </div>
                        <div class="box-body table-responsive">
                            <?php
                            $uri     = substr($this->uri->segment(2), 0, -4);
                            $case    = $this->input->get('case');
                            $query   = $this->input->get('query');
                            $merk    = $this->input->get('merk');
                            $tipe    = $this->input->get('tipe');
                            $sales   = $this->input->get('sales');
                            $tg_awal = $this->input->get('tgl_awal');
                            $tg_akhr = $this->input->get('tgl_akhir');

                            switch ($case) {
                                case 'per_tanggal':
                                    $uri_pdf = base_url('laporan/' . $uri . '_pdf.php?case=' . $case . '&tipe='.$tipe.'&query=' . $query.(!empty($merk) ? '&merk='.$merk : '').(!empty($sales) ? '&sales='.$sales : ''));
                                    break;

                                case 'per_rentang':
                                    $uri_pdf = base_url('laporan/' . $uri . '_pdf.php?case=' . $case . '&tipe='.$tipe.'&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr.(!empty($merk) ? '&merk='.$merk : '').(!empty($sales) ? '&sales='.$sales : ''));
                                    break;
                            }
                            ?>
                            <button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo $uri_pdf ?>'"><i class="fa fa-file-pdf-o"></i> Cetak</button>
                            <?php echo br() ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Merk</th>
                                        <th>Kode</th>
                                        <th>Produk</th>
                                        <th class="text-left">Jml</th>
                                        <th class="text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($penjualan)) { ?>
                                        <?php $no = 1; ?>
                                        <?php $total = 0; ?>
                                        <?php foreach ($penjualan as $penjualan) { ?>
                                            <?php $total = $total + $penjualan->subtotal; ?>                                        
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?></td>
                                                <!--<td><?php echo $penjualan->no_nota ?></td>-->
                                                <td><?php echo $penjualan->merk ?></td>
                                                <td><?php echo anchor(base_url('gudang/data_stok_tambah.php?id='.general::enkrip($penjualan->id_produk)), $penjualan->kode, 'target="blank"') ?></td>
                                                <td><?php echo $penjualan->produk ?></td>
                                                <td class="text-left"><?php echo $penjualan->jml . ' ' . $penjualan->satuan ?></td>
                                                <td class="text-right"><?php echo general::format_angka($penjualan->subtotal) ?></td>
                                            </tr>
                                        <?php } ?>
                                            <tr>
                                                <td colspan="5" class="text-right"><label>Total Penjualan</label></td>
                                                <td class="text-right"><label><?php echo general::format_angka($total) ?></label></td>
                                            </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
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

<!--Datepicker-->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/moment.js/2.11.2/moment.min.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/daterangepicker/daterangepicker-bs3.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Page script -->
<script>
    $(function () {
        $('#lbl-produk').hide();
        $('#lbl-kasir').hide();
        $('#tp-semua').on('click', function (e) {
            $('#lbl-merk').show();
            $('#lbl-produk').hide();
            $('#lbl-kasir').hide();
        });
        $('#tp-produk').on('click', function (e) {
            $('#lbl-produk').show();
            $('#lbl-kasir').show();
            $('#lbl-merk').hide();
        });
        $('#tgl').datepicker({autoclose:true, maxDate: '<?php echo date('m/d/Y'); ?>'});
        $('#tgl_rentang').daterangepicker({maxDate: '<?php echo date('m/d/Y'); ?>'});
      
      //Autocomplete buat Barang
      $('#produk').autocomplete({
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
              $itemrow.find('#id_produk').val(ui.item.id);
              $('#id_produk').val(ui.item.id);
              $('#produk').val(ui.item.produk);

              //Give focus to the next input field to recieve input from user
              $('#produk').focus();
              return false;
          }
          
      //Format the list menu output of the autocomplete
      }).data("ui-autocomplete")._renderItem = function (ul, item) {
          return $("<li></li>")
                  .data("item.autocomplete", item)
                  .append("<a>["+ item.kode +"] " + item.produk + "</a>")
                  .appendTo(ul);
      };
      
    });
</script>