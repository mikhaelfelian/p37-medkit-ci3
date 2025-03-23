<?php $hasError = $this->session->flashdata('form_error'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Medical Checkup</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('medcheck/index.php') ?>">Medical Checkup</a></li>
                        <li class="breadcrumb-item active">Invoice</li>
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
                <div class="col-md-12">
                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <?php echo $setting->judul ?>
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-2 invoice-col">
                                <address>
                                    <strong>No. RM / Usia</strong><br/>
                                    <strong>Nama Pasien</strong><br/>
                                    <strong>Alamat</strong><br/>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-10 invoice-col">
                                <address>
                                    <strong>:</strong> <?php echo $sql_pasien->kode_dpn . '' . $sql_pasien->kode . ' / ' . (!empty($sql_pasien->tgl_lahir) ? $this->tanggalan->usia($sql_pasien->tgl_lahir) : '') ?><br>
                                    <strong>:</strong> <?php echo $sql_pasien->nama_pgl ?><br/>
                                    <strong>:</strong> <?php echo $sql_pasien->alamat ?><br/>
                                </address>
                            </div>
                            <!-- /.col -->
                        </div>
                        <div class="row invoice-info">
                            <div class="col-sm-2 invoice-col">
                                <address>
                                    <strong>Tgl Masuk</strong><br/>
                                    <strong>No. STRUK</strong><br/>
                                </address>
                            </div>
                            <div class="col-sm-2 invoice-col">
                                <address>
                                    <strong>:</strong> <?php echo $this->tanggalan->tgl_indo5($sql_medc->tgl_masuk) ?><br/>
                                    <strong>:</strong> <?php echo $sql_medc->no_nota ?><br/>
                                </address>
                            </div>
                            <div class="col-sm-2 invoice-col">
                                <address>
                                    <strong>Tgl Selesai</strong><br/>
                                    <strong>ID Transaksi</strong><br/>
                                </address>
                            </div>
                            <div class="col-sm-2 invoice-col">
                                <address>
                                    <strong>:</strong> <?php echo $this->tanggalan->tgl_indo5($sql_medc->tgl_keluar) ?><br/>
                                    <strong>:</strong> <?php echo $sql_medc->no_rm ?><br/>
                                </address>
                            </div>
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <h4 class="text-center">
                                    FORM PEMBAYARAN
                                </h4>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-left">Item</th>
                                            <th class="text-center">Jml</th>
                                            <th class="text-right">Harga</th>
                                            <th class="text-center">Diskon</th>
                                            <th class="text-center">Diskon</th>
                                            <th class="text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($sql_medc_det as $det) { ?>
                                            <?php $sql_kat = $this->db->where('id', $det->id_item_kat)->get('tbl_m_kategori')->row(); ?>
                                            <?php $sql_det = $this->db->where('id_medcheck', $det->id_medcheck)->where('id_item_kat', $det->id_item_kat)->get('tbl_trans_medcheck_det')->result(); ?>
                                            <tr>
                                                <td class="text-center" style="width: 15px;"></td>
                                                <td class="text-left text-bold" style="width: 15px;" colspan="6"><i><?php echo $sql_kat->keterangan . ' (' . $sql_kat->kategori . ')'; ?></i></td>
                                            </tr>

                                            <?php foreach ($sql_det as $medc) { ?>
                                                <tr>
                                                    <td class="text-center" style="width: 15px;"><?php echo $no; ?>.</td>
                                                    <td class="text-left" style="width: 200px;">
                                                        <small><?php echo $medc->item; ?></small>
                                                    </td>
                                                    <td class="text-center" style="width: 25px;"><?php echo (float) $medc->jml; ?></td>
                                                    <td class="text-right" style="width: 50px;"><?php echo general::format_angka($medc->harga); ?></td>
                                                    <td class="text-center" style="width: 100px;">
                                                        <div class="form-group row">
                                                            <div class="col-sm-3">
                                                                <?php echo form_input(array('id' => 'disk1', 'name' => 'disk1', 'class' => 'form-control rounded-0', 'value' => $sql_medc->disk2)) ?>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <?php echo form_input(array('id' => 'disk2', 'name' => 'disk2', 'class' => 'form-control rounded-0', 'value' => $sql_medc->disk2)) ?>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <?php echo form_input(array('id' => 'disk3', 'name' => 'disk3', 'class' => 'form-control rounded-0', 'value' => $sql_medc->disk2)) ?>
                                                            </div>
                                                        </div>
                                                        <?php echo form_close() ?>
                                                    </td>
                                                    <td class="text-right" style="width: 250px;"><?php echo general::format_angka($medc->subtotal); ?></td>
                                                </tr>
                                                <?php $no++ ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <?php $hasError = $this->session->flashdata('form_error'); ?>
                        <?php echo form_open_multipart(base_url('medcheck/set_medcheck_bayar.php'), 'autocomplete="off"') ?>
                        <?php echo form_hidden('no_nota', general::enkrip($sql_medc->id)) ?>
                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-6">
                                <p class="lead">Metode Pembayaran:</p>
                                <div class="row">
                                    <div class="col-sm-7">
                                        <select name="metode_bayar" class="form-control select2bs4  <?php echo (!empty($hasError['metode']) ? 'is-invalid' : '') ?>">
                                            <option value="">- Pilih -</option>
                                            <?php foreach ($sql_platform as $platform) { ?>
                                                <option value="<?php echo $platform->id ?>" <?php // echo (!empty($pasien->id_pekerjaan) ? ($kerja->id == $pasien->id_pekerjaan ? 'selected' : '') : (($kerja->id == $this->session->flashdata('pekerjaan') ? 'selected' : '')))    ?>><?php echo $platform->platform ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <br/>
                                        <table class="table">
                                            <?php foreach ($sql_medc_plat as $plat) { ?>
                                                <?php $sql_plat = $this->db->where('id', $plat->id_platform)->get('tbl_m_platform')->row() ?>
                                                <tr>
                                                    <th style="width:50%"><?php echo $sql_plat->platform ?></th>
                                                    <td><?php echo general::format_angka($plat->nominal) ?></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                </div>
<!--                                <img src="https://adminlte.io/themes/v3/dist/img/credit/visa.png" alt="Visa">
                <img src="https://adminlte.io/themes/v3/dist/img/credit/mastercard.png" alt="Mastercard">
                <img src="https://adminlte.io/themes/v3/dist/img/credit/american-express.png" alt="American Express">
                <img src="https://adminlte.io/themes/v3/dist/img/credit/paypal2.png" alt="Paypal">-->

                                <!--
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                                    plugg
                                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                                </p>
                                -->
                            </div>
                            <!-- /.col -->
                            <div class="col-6">
                                <p class="lead">Pembayaran</p>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:100px;" colspan="2">Subtotal</th>
                                            <th style="width:5px;" class="text-center">:</th>
                                            <td><?php echo form_input(array('id' => 'jml_total', 'name' => 'jml_total', 'class' => 'form-control', 'value' => $sql_medc->jml_total, 'readonly' => 'TRUE')) ?></td>
                                        </tr>
<!--                                        <tr>
                                            <th style="width:100px;" colspan="2">PPn (<?php echo (float) $sql_medc->ppn ?>%)</th>
                                            <th style="width:5px;" class="text-center">:</th>
                                            <td><?php echo general::format_angka($sql_medc->jml_ppn) ?></td>
                                        </tr>-->
                                        <tr>
                                            <th style="width:100px;">Diskon</th>
                                            <th style="width:75px;"><?php echo form_input(array('id' => 'diskon', 'name' => 'diskon', 'class' => 'form-control text-center', 'value' => $sql_medc->diskon)) ?></th>
                                            <th style="width:5px;" class="text-center">:</th>
                                            <td><?php echo form_input(array('id' => 'jml_diskon', 'name' => 'jml_diskon', 'class' => 'form-control', 'value' => $sql_medc->jml_diskon)) ?></td>
                                        </tr>
                                        <tr>
                                            <th style="width:100px;" colspan="2">Grand Total</th>
                                            <th style="width:5px;" class="text-center">:</th>
                                            <td><?php echo form_input(array('id' => 'jml_gtotal', 'name' => 'jml_gtotal', 'class' => 'form-control', 'value' => $sql_medc->jml_gtotal, 'readonly' => 'TRUE')) ?></td>
                                        </tr>
                                        <tr>
                                            <th style="width:100px;" colspan="2">Jml Bayar</th>
                                            <th style="width:5px;" class="text-center">:</th>
                                            <td><?php echo form_input(array('id' => 'jml_bayar', 'name' => 'jml_bayar', 'class' => 'form-control')) ?></td>
                                        </tr>
                                        <tr>
                                            <th style="width:100px;" colspan="2">Jml Kembali</th>
                                            <th style="width:5px;" class="text-center">:</th>
                                            <td><?php echo form_input(array('id' => 'jml_kembali', 'name' => 'jml_kembali', 'class' => 'form-control', 'value' => (float) $sql_medc->jml_kembali, 'readonly' => 'TRUE')) ?></td>
                                        </tr>
                                        <tr>
                                            <th style="width:100px;" colspan="2">Jml Kurang</th>
                                            <th style="width:5px;" class="text-center">:</th>
                                            <td><?php echo form_input(array('id' => 'jml_kurang', 'name' => 'jml_kurang', 'class' => 'form-control', 'value' => (float) $sql_medc->jml_kurang, 'readonly' => 'TRUE')) ?></td>
                                        </tr>
                                        <!--                                        
                                        <tr>
                                                                                    <th>Diskon</th>
                                                                                    <td><?php echo form_input(array('id' => 'jml_diskon', 'name' => 'jml_diskon', 'class' => 'form-control', 'value' => $sql_medc->jml_diskon)) ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Grand Total</th>
                                                                                    <td><?php echo form_input(array('id' => 'jml_gtotal', 'name' => 'jml_gtotal', 'class' => 'form-control', 'value' => $sql_medc->jml_gtotal)) ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Tgl Bayar:</th>
                                                                                    <td><?php echo form_input(array('id' => 'tanggal', 'name' => 'tgl_bayar', 'class' => 'form-control', 'value' => date('d/m/Y'))) ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Jml Bayar</th>
                                                                                    <td><?php echo form_input(array('id' => 'jml_bayar', 'name' => 'jml_bayar', 'class' => 'form-control')) ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Total:</th>
                                                                                    <td><?php echo general::format_angka($sql_medc->jml_gtotal) ?></td>
                                                                                </tr>-->
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-10">
                                <button type="button" class="btn btn-success float-right" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_dm.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                                    <i class="fa fa-print"></i> Cetak
                                </button>
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-primary float-right"><i class="far fa-credit-card"></i> Bayar</button>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                    <!-- /.invoice -->              
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!-- Page script -->
<script type="text/javascript">
                                    $(function () {
                                        $("#jml_total").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                        $("#diskon").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                        $("#jml_subtotal").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                        $("#jml_diskon").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                        $("#jml_bayar").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                        $("#jml_gtotal").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                        $("#jml_kembali").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                        $("input[name=jml_diskon_itm]").autoNumeric({aSep: '.', aDec: ',', aPad: false});

                                        $("#diskon").keyup(function () {
                                            var jml_total = $('#jml_total').val().replace(/[.]/g, "");
                                            var diskon = $('#diskon').val().replace(/[.]/g, "");
                                            var jml_diskon = (parseInt(diskon) / 100) * parseFloat(jml_total);
                                            var jml_gtotal = parseFloat(jml_total) - parseFloat(jml_diskon);

                                            $('#jml_diskon').val(Math.round(jml_diskon)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $('#jml_gtotal').val(Math.round(jml_gtotal)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                        });

                                        $("#jml_diskon").keyup(function () {
                                            var jml_total = $('#jml_total').val().replace(/[.]/g, "");
                                            var diskon = $('#jml_diskon').val().replace(/[.]/g, "");
                                            var jml_diskon = (parseFloat(diskon) / parseFloat(jml_total)) * 100;
                                            var jml_gtotal = parseFloat(jml_total) - parseFloat(diskon);

                                            $('#diskon').val(Math.round(jml_diskon)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $('#jml_gtotal').val(Math.round(jml_gtotal)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                        });

                                        $("#jml_bayar").keyup(function () {
                                            var jml_gtotal = $('#jml_gtotal').val().replace(/[.]/g, "");
                                            var jml_bayar = $('#jml_bayar').val().replace(/[.]/g, "");
                                            var jml_kembali = parseFloat(Math.round(jml_bayar)) - parseFloat(jml_gtotal);

                                            $('#jml_kembali').val(Math.round(jml_kembali)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                        });

                                        $('.select2bs4').select2({
                                            theme: 'bootstrap4'
                                        });
<?php if (!empty($hasError['bayar'])) { ?>
                                            /* Error Jml Bayar */
                                            toastr.error('<b>Jumlah Bayar</b> belum diinput !!')
<?php } ?>
<?php if (!empty($hasError['metode'])) { ?>
                                            /* Error Metode Pembayaran */
                                            toastr.error('<b>Metode Pembayaran</b> belum diinput !!')
<?php } ?>
                                    });
</script>