<?php $hasError = $this->session->flashdata('form_error'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Apotik</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Apotik</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="nav-icon fa fa-shopping-cart"></i> Data Item</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr class="bg-yellow">
                                                        <th class="text-left">Item</th>
                                                        <th class="text-center">Jml</th>
                                                        <th class="text-right">Harga</th>
                                                        <th class="text-right">Pot</th>
                                                        <th class="text-right">Subtotal</th>
                                                        <th class="text-right"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    $gtotal = 0;
                                                    ?>
                                                    <?php foreach ($this->cart->contents() as $cart) { ?>
                                                        <?php
                                                        $sql_item = $this->db->where('id', $cart['options']['id_item'])->get('tbl_m_produk')->row();
                                                        ?>
                                                        <tr>
                                                            <td class="text-left" style="width: 250px;">
                                                                <?php echo $sql_item->produk ?></td>
                                                            <td class="text-center" style="width: 75px;">
                                                                <?php echo $cart['qty'] ?></td>
                                                            <td class="text-right" style="width: 150px;">
                                                                <?php echo general::format_angka($cart['options']['harga']); ?>
                                                                <?php if ($cart['options']['disk'] != '0') { ?>
                                                                    <!--Iki nggo nampilke diskon ndes-->
                                                                    <?php echo br(); ?>
                                                                    <small>(<?php echo (float) $cart['options']['disk1'] . ($cart['options']['disk2'] != '0' ? ' + ' . $cart['options']['disk2'] : '') . ($cart['options']['disk3'] != '0' ? ' + ' . $cart['options']['disk3'] : '') ?>
                                                                        %)</small>
                                                                <?php } ?>
                                                            </td>
                                                            <td class="text-right" style="width: 100px;">
                                                                <?php echo general::format_angka($cart['options']['potongan']); ?>
                                                            </td>
                                                            <td class="text-right" style="width: 150px;">
                                                                <?php echo general::format_angka($cart['subtotal']); ?></td>
                                                            <td class="text-right">
                                                                <?php echo anchor(base_url('pos/set_trans_jual_hapus_item.php?id=' . $this->input->get('id') . '&item_id=' . general::enkrip($cart['rowid'])), '<i class="fa fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" style="width: 55px;" onclick="return confirm(\'Hapus [' . $cart['name'] . '] ?\')"') ?>
                                                            </td>
                                                        </tr>

                                                        <?php $gtotal = $gtotal + $sub ?>
                                                    <?php } ?>
                                                    <?php $x = $this->cart->contents() ?>
                                                    <?php if (!empty($x)) { ?>
                                                        <tr>
                                                            <td class="text-right text-bold" colspan="4">Grand Total</td>
                                                            <td class="text-right text-bold">
                                                                <?php echo general::format_angka($this->cart->total()); ?>
                                                            </td>
                                                            <td class="text-right text-bold"></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <?php if (!empty($x)) { ?>
                                <?php echo form_open(base_url('pos/set_trans_jual_proses.php'), 'id="apt_proses_form" autocomplete="off"'); ?>
                                <?php echo add_form_protection() ?>
                                <?php echo form_hidden('id', $this->input->get('id')); ?>

                                <button type="submit" class="btn btn-info float-right rounded-0"
                                    onclick="return confirm('posting ?')"><i class="fa fa-arrows-rotate"></i>
                                    Posting</button>
                                <?php echo add_double_submit_protection('apt_proses_form') ?>
                                <?php echo form_close(); ?>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-lg-4">
                    <?php echo form_open(base_url('pos/set_trans_jual_upd.php'), 'id="apt_form" autocomplete="off"') ?>
                    <?php echo add_form_protection() ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user"></i> Pelanggan</h3>
                        </div>
                        <div class="card-body">
                            <?php echo form_hidden('id', $this->input->get('id')) ?>

                            <input type="hidden" id="id_pelanggan" name="id_pelanggan" value="<?php echo !empty($sql_pelanggan->id) ? $sql_pelanggan->id : '30354'; ?>">

                            <div class="form-group">
                                <label for="inputEmail3">Pelanggan</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <?php echo form_input(array('id' => 'pelanggan', 'name' => 'pelanggan', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['pelnggan']) ? ' is-invalid' : ''), 'placeholder' => 'Inputkan Nama Pelanggan ...', 'value' => $sql_pelanggan->nama)) ?>
                                    <div class="input-group-append">
                                        <span
                                            class="input-group-text rounded-0"><?php echo anchor(base_url('pos/data_pelanggan_tambah.php'), '<i class="fas fa-plus text-bold"></i>', 'class="text-default"') ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3">Tanggal</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                    <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl_masuk', 'class' => 'form-control pull-right' . (!empty($hasError['tgl']) ? ' is-invalid' : ''), 'placeholder' => 'Inputkan Tgl ...', 'value' => date('d-m-Y'))) ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo base_url('pos/set_trans_jual_batal.php?id=' . $this->input->get('id')) ?>"
                                class="btn btn-danger rounded-0" onclick="return confirm('Batalkan transaksi ?')"><i
                                    class="fa fa-refresh"></i> Batal</a>
                            <button type="submit" class="btn btn-info float-right rounded-0"><i class="fa fa-save"></i>
                                Simpan</button>
                        </div>
                    </div>
                    <?php echo add_double_submit_protection('apt_form') ?>
                    <?php echo form_close(); ?>
                    <?php echo form_open(base_url('pos/set_trans_jual_simpan_item.php'), 'id="apt_item_form" autocomplete="off"') ?>
                    <?php echo add_form_protection() ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-shopping-cart"></i> Form Data Item</h3>
                        </div>
                        <div class="card-body">
                            <?php echo form_hidden('id', $this->input->get('id')); ?>
                            <?php echo form_hidden('id_item', general::enkrip($sql_produk->id)); ?>

                            <div class="form-group">
                                <label for="inputEmail3">Item</label>
                                <?php echo form_input(array('id' => 'produk', 'name' => 'produk', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['produk']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Item ...', 'value' => $sql_produk->produk)) ?>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="inputEmail3">Jml</label>
                                        <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control text-center rounded-0', 'placeholder' => 'Jml ...', 'value' => (!empty($sql_medc_det2->jml) ? $sql_medc_det2->jml : '1'))) ?>
                                    </div>
                                    <div class="col-md-9">
                                        <label for="inputEmail3">Satuan</label>
                                        <div class="form-group">
                                            <select name="satuan" class="form-control rounded-0" readonly="TRUE">
                                                <option value="">- Pilih -</option>
                                                <?php foreach ($sql_satuan as $satuan) { ?>
                                                    <option value="<?php echo $satuan->id ?>" <?php echo ($satuan->id == $sql_produk->id_satuan ? 'selected' : '') ?>>
                                                        <?php echo strtoupper($satuan->satuanTerkecil) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3">Harga</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Rp. </span>
                                    </div>
                                    <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Harga ...', 'value' => (!empty($sql_medc_det2->harga) ? ceil($sql_medc_det2->harga) : $sql_produk->harga_jual), 'readonly' => 'TRUE')) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="inputEmail3">Diskon 1 (%)</label>
                                        <?php echo form_input(array('id' => 'diskon', 'name' => 'disk1', 'class' => 'form-control text-center rounded-0' . (!empty($hasError['produk']) ? ' is-invalid' : ''), 'placeholder' => 'Disk1 ...', 'value' => (!empty($sql_medc_det2->disk1) ? $sql_medc_det2->disk1 : '0'))) ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="inputEmail3">Diskon 2 (%)</label>
                                        <?php echo form_input(array('id' => 'diskon', 'name' => 'disk2', 'class' => 'form-control text-center rounded-0' . (!empty($hasError['produk']) ? ' is-invalid' : ''), 'placeholder' => 'Disk2 ...', 'value' => (!empty($sql_medc_det2->disk2) ? $sql_medc_det2->disk2 : '0'))) ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="inputEmail3">Diskon 3 (%)</label>
                                        <?php echo form_input(array('id' => 'diskon', 'name' => 'disk3', 'class' => 'form-control text-center rounded-0' . (!empty($hasError['produk']) ? ' is-invalid' : ''), 'placeholder' => 'Disk3 ...', 'value' => (!empty($sql_medc_det2->disk3) ? $sql_medc_det2->disk3 : '0'))) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3">Potongan</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Rp. </span>
                                    </div>
                                    <?php echo form_input(array('id' => 'potongan', 'name' => 'potongan', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Potongan ...', 'value' => (!empty($sql_medc_det2->potongan) ? $sql_medc_det2->potongan : '0'))) ?>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($sql_produk)) { ?>
                            <div class="card-footer">
                                <button type="button" class="btn btn-danger rounded-0"
                                    onclick="window.location.href = '<?php echo base_url('medcheck/invoice/bayar.php?id=' . $this->input->get('id')) ?>'"><i
                                        class="fa fa-refresh"></i> Batal</button>
                                <button type="submit" class="btn btn-info float-right rounded-0"><i class="fa fa-save"></i>
                                    Simpan</button>
                            </div>
                        <?php } ?>
                    </div>
                    <?php echo add_double_submit_protection('apt_item_form') ?>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet"
    href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $("input[id=jml], input[id=harga], input[id=diskon], input[id=potongan]").autoNumeric({ aSep: '.', aDec: ',', aPad: false });
        $("input[id=jml_total], input[id=jml_gtotal], input[id=jml_diskon], input[id=jml_diskon], input[id=jml_bayar], input[id=jml_kurang]").autoNumeric({ aSep: '.', aDec: ',', aPad: false });

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        var dateToday = new Date();
        $("#tgl").datepicker({
            dateFormat: 'dd-mm-yy',
            //defaultDate: "+1w",
            SetDate: new Date(),
            changeMonth: true,
            minDate: dateToday,
            autoclose: true
        });

        //Autocomplete buat produk
        $('#pelanggan').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('pos/json_customer.php') ?>",
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
                $itemrow.find('#id_pelanggan').val(ui.item.id);
                $('#id_pelanggan').val(ui.item.id);
                $('#pelanggan').val(ui.item.nama);

                //Give focus to the next input field to recieve input from user
                $('#pelanggan').focus();
                return false;
            }

            //Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                .data("item.autocomplete", item)
                .append("<a>" + item.nama2 + " - " + item.alamat + "</a>")
                .appendTo(ul);
        };

        // Data Item Cart
        $('#produk').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('pos/json_item.php') ?>",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 4,
            select: function (event, ui) {
                var $itemrow = $(this).closest('tr');
                //Populate the input fields from the returned values
                $itemrow.find('#id_item').val(ui.item.id);
                $('#id_item').val(ui.item.id);
                $('#produk').val(ui.item.name);
                $('#harga').val(ui.item.harga);
                window.location.href = "<?php echo base_url('pos/trans_jual.php?id=' . $this->input->get('id')) ?>&item_id=" + ui.item.id + "&harga=" + ui.item.harga + "&satuan=" + ui.item.satuan;

                // Give focus to the next input field to recieve input from user
                $('#jml').focus();
                return false;
            }

            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                .data("item.autocomplete", item)
                .append("<a>" + item.name + "</a><br/><a><i><small>" + item.alias + "</small></i></a><a><i><small> " + item.kandungan + "</small></i></a>")
                .appendTo(ul);
        };
    });
</script>