<?php echo $this->session->flashdata('produk') ?>
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
                <div class="col-lg-3">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Status Antrian</h3>
                        </div>
                        <div class="box-body">

                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-shopping-cart"></i> Form Pemesanan</h3>
                        </div>
                        <?php echo form_open(base_url('set_nota_simpan.php')) ?>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group <?php echo (!empty($hasError['no_nota']) ? 'has-error' : '') ?>">
                                        <label>No. Nota</label>                                    
                                        <div class="input-group col-xs-12">
                                            <div class="input-group-addon">
                                                # 
                                            </div>
                                            <?php echo form_input(array('id' => 'no_nota', 'name' => 'no_nota', 'class' => 'form-control', 'value' => $no_nota, 'readonly' => 'TRUE')) ?>
                                        </div> 
                                    </div> 
<!--                                    <div class="form-group <?php echo (!empty($hasError['status_antrian']) ? 'has-error' : '') ?>">
                                        <label>Nomor Antrian</label>                                    
                                        <div class="input-group col-xs-12">
                                    <?php echo form_input(array('id' => 'no_antrian', 'name' => 'no_antrian', 'class' => 'form-control')) ?>
                                        </div> 
                                    </div>-->
                                    <div class="form-group <?php echo (!empty($hasError['tgl_masuk']) ? 'has-error' : '') ?>">
                                        <label>Tanggal Masuk</label>                                    
                                        <div class="input-group col-xs-12">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i> 
                                            </div>
                                            <?php echo form_input(array('id' => 'tgl_masuk', 'name' => 'tgl_masuk', 'class' => 'form-control', 'value' => '')) ?>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group <?php echo (!empty($hasError['no_nota']) ? 'has-error' : '') ?>">
                                        <label>Nama Pelanggan</label>                                   
                                        <div class="input-group col-xs-12">
                                            <?php echo form_input(array('id' => 'member', 'name' => 'nama', 'class' => 'form-control', 'value' => '')) ?>
                                            <input type="hidden" id="id_pelanggan" name="id_pelanggan">
                                            <div class="input-group-addon">
                                                <a href="<?php echo base_url('') ?>"><i class="fa fa-plus"></i></a> 
                                            </div>
                                        </div>
                                    </div> 
<!--                                    <div class="form-group <?php echo (!empty($hasError['status_member']) ? 'has-error' : '') ?>">
                                        <label>Tipe Member</label>                                    
                                        <div class="input-group col-xs-12">
                                    <?php echo form_radio(array('id' => 'tipe_member', 'name' => 'tipe_member', 'value' => '')) ?> Gold
                                        </div> 
                                    </div>-->
                                    <div class="form-group <?php echo (!empty($hasError['tgl_keluar']) ? 'has-error' : '') ?>">
                                        <label>Tanggal Keluar</label>                                    
                                        <div class="input-group col-xs-12">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i> 
                                            </div>
                                            <?php echo form_input(array('id' => 'tgl_keluar', 'name' => 'tgl_keluar', 'class' => 'form-control', 'value' => '')) ?>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-right">
                                    <!--<button type="submit" class="btn btn-info btn-flat"><i class="fa fa-save"></i> Simpan</button>-->
                                </div>
                            </div>

                            <hr/>
                            <br/>
                            <table class="table table-striped">
                                <tr>
                                    <th class="text-center" style="width: 50px;">No.</th>
                                    <th class="text-left">Jenis Laundry</th>
                                    <th class="text-center" style="width: 75px;">Jml</th>
                                    <th class="text-right">Harga</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                                <?php $no = 1; ?>
                                <?php $subtotal = 0; ?>
                                <?php foreach ($this->cart->contents() as $items) { ?>
                                    <?php
                                    $subtotal = $subtotal + $items['subtotal'];
                                    ?>
                                    <tr>
                                        <td class="text-right" style="width: 50px;"><?php echo $no++ ?></td>
                                        <td class="text-left"><?php echo ucwords($items['options']['kat1']) . ' &raquo; ' . ucwords($items['options']['kat2']) . ' &raquo; ' . $items['name']; ?></td>
                                        <td class="text-center" style="width: 75px;"><?php echo $items['qty']; ?></td>
                                        <td class="text-right"><?php echo general::format_angka($items['price']); ?></td>
                                        <td class="text-right"><?php echo general::format_angka($items['subtotal']); ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td class="text-right" colspan="4"><b>Total</b></td>
                                    <td class="text-right"><?php echo general::format_angka($subtotal); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="box-footer">

                            <div class="row">
                                <div class="col-lg-6">
                                    <!--<button type="button" onclick="window.location.href = '<?php echo site_url('page=produk&act=prod_list') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>-->
                                </div>
                                <div class="col-lg-6 text-right">
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Proses &raquo;</button>
                                    <!--<button class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('form_pemesan.php') ?>'">Proses &raquo;</button>-->
                                </div>
                            </div>
                        </div>                        
                        <?php echo form_close() ?>
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
        //      Tanggale Masuk
        $('#tgl_masuk').datepicker({
            autoclose: true,
        });
//      Tanggale Jadi
        $('#tgl_keluar').datepicker({
            autoclose: true,
        });
//      Jquery kanggo format angka
//        $("#gtotal").autoNumeric({aSep: '.', aDec: ',', aPad: false});
        $("#harga").autoNumeric({aSep: '.', aDec: ',', aPad: false});

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

        // Autocomplete buat produk
        $('#member').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('json_member.php') ?>",
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
                // Populate the input fields from the returned values
                $itemrow.find('#member').val(ui.item.nama);
                $('#member').val(ui.item.nama);
                $('#id_pelanggan').val(ui.item.id);

                // Give focus to the next input field to recieve input from user
//                                                    $('#panjang').focus();
                return false;
            }
            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>[" + item.kode + "] " + item.nama + "</a>")
                    .appendTo(ul);
        };
    });
</script>