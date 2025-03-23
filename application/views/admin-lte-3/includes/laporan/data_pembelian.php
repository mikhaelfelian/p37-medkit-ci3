<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!--<h1 class="m-0">Master Data</h1>-->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard2.php') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('laporan/index.php') ?>">Laporan</a></li>
                        <li class="breadcrumb-item active">Data Pembelian</li>
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
                <div class="col-md-8">
                    <?php echo form_open(base_url('laporan/set_data_pembelian.php'), 'autocomplete="off"') ?> 
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Laporan Pembelian</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php $hasError = $this->session->flashdata('form_error'); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tanggal</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => '02/15/2022 ...', 'value' => (isset($_GET['tgl']) ? $this->tanggalan->tgl_indo($_GET['tgl']) : ''))) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tanggal Rentang</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <?php echo form_input(array('id' => 'tgl_rentang', 'name' => 'tgl_rentang', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => '02/15/2022 - 02/15/2022 ...', 'value' => (isset($_GET['tgl_awal']) ? $this->tanggalan->tgl_indo2($_GET['tgl_awal']) : ''))) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group <?php echo (!empty($hasError['poli']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Supplier</label>
                                        <select name="supplier" class="form-control select2bs4 <?php echo (!empty($hasError['poli']) ? ' is-invalid' : '') ?>">
                                            <option value="">- Semua Supplier -</option>
                                            <?php foreach ($sql_supp as $supp) { ?>
                                                <option value="<?php echo $supp->id ?>" <?php echo ($_GET['supplier'] == $supp->id ? 'selected' : '') ?>><?php echo (!empty($supp->kode) ? '[' . $supp->kode . '] ' : '') . $supp->nama ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>                                    
                                </div>
                                <div class="col-md-6">

                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">

                                </div>
                                <div class="col-lg-6 text-right">
                                    <!--<button type="button" class="btn btn-warning btn-flat"><i class="fa fa-undo"></i> Bersih</button>-->
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-search"></i> Cari</button>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <?php echo form_close() ?> 
                </div>
            </div>
            <?php if ($_GET['jml'] > 0) { ?><div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Data Laporan Pembelian</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-right">
                                        <?php echo $pagination ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
                                $uri = substr($this->uri->segment(2), 0, -4);
                                $case = $this->input->get('case');
                                $tg_awal = $this->input->get('tgl_awal');
                                $tg_akhr = $this->input->get('tgl_akhir');
                                $tg = $this->input->get('tgl');
                                $id_supp = $this->input->get('id_supplier');
                                $supp = $this->input->get('supplier');

                                switch ($case) {
                                    case 'per_tanggal':
                                        $uri_pdf = base_url('laporan/' . $uri . '_pdf.php?case=' . $case . (!empty($supp) ? '&id_supplier=' . $id_supp . '&supplier=' . $supp : '') . '&tgl=' . $tg);
                                        $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . (!empty($supp) ? '&id_supplier=' . $id_supp . '&supplier=' . $supp : '') . '&tgl=' . $tg);
                                        $uri_htm = base_url('laporan/htm_' . $uri . '.php?case=' . $case . (!empty($supp) ? '&id_supplier=' . $id_supp . '&supplier=' . $supp : '') . '&tgl=' . $tg);
                                        $uri_csv = base_url('laporan/csv_' . $uri . '.php?case=' . $case . (!empty($supp) ? '&id_supplier=' . $id_supp . '&supplier=' . $supp : '') . '&tgl=' . $tg);
                                        break;

                                    case 'per_rentang':
                                        $uri_pdf = base_url('laporan/' . $uri . '_pdf.php?case=' . $case . (!empty($supp) ? '&id_supplier=' . $id_supp . '&supplier=' . $supp : '') . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr . '&metode=' . $metode);
                                        $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . (!empty($supp) ? '&id_supplier=' . $id_supp . '&supplier=' . $supp : '') . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr);
                                        $uri_htm = base_url('laporan/htm_' . $uri . '.php?case=' . $case . (!empty($supp) ? '&id_supplier=' . $id_supp . '&supplier=' . $supp : '') . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr);
                                        $uri_csv = base_url('laporan/csv_' . $uri . '.php?case=' . $case . (!empty($supp) ? '&id_supplier=' . $id_supp . '&supplier=' . $supp : '') . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr);
                                        break;
                                }
                                ?>
                                <button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo $uri_htm ?>'"><i class="fas fa-file-excel"></i> Excel</button>
                                <?php echo br(); ?>
                                <?php echo $this->session->flashdata('medcheck'); ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>No. Faktur</th>
                                            <th>Item</th>
                                            <th class="text-right">Harga</th>
                                            <th class="text-right">HET</th>
                                            <th class="text-right">Diskon</th>
                                            <th class="text-right">Jml</th>
                                            <th class="text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($sql_pembelian)) {
                                            $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                            foreach ($sql_pembelian as $beli) {
                                                $sql_beli_det = $this->db->select('*')
                                                                ->where('tbl_trans_beli_det.id_pembelian', $beli->id)
                                                                ->get('tbl_trans_beli_det')->result();
                                                ?>
                                                <tr>
                                                    <td class="text-center" style="width: 10px"><?php echo $no ?></td>
                                                    <td class="text-left" style="width: 150px;">
                                                        <?php echo anchor(base_url('transaksi/trans_beli_det.php?id=' . general::enkrip($beli->id)), '#' . $beli->no_nota, 'class="text-default" target="_blank"') ?>
                                                        <?php echo br(); ?>
                                                        <span class="mailbox-read-time float-left"><?php echo $this->tanggalan->tgl_indo($beli->tgl_masuk); ?></span>
                                                    </td>
                                                    <td class="text-left" style="width: 450px;" colspan="5">
                                                        <b><?php echo $beli->nama; ?></b>
                                                    </td>
                                                    <td class="text-right" style="width: 100px;">
                                                        <b><?php echo general::format_angka($beli->jml_gtotal); ?></b>
                                                    </td>
                                                </tr>
                                                <?php $jml_subtot = 0; ?>
                                                <?php foreach ($sql_beli_det as $beli_det) { ?>
                                                    <?php $jml_subtot = $jml_subtot + $beli_det->subtotal; ?>
                                                    <tr>
                                                        <td class="text-center" colspan="2">

                                                        </td>
                                                        <td class="text-left" style="width: 350px;">
                                                            <?php if (!empty($beli_det->kode_batch)) { ?>
                                                                <small><i><?php echo $beli_det->kode_batch ?></i></small><br/>
                                                            <?php } ?>
                                                            <i><?php echo $beli_det->produk ?></i><br/>
                                                            <small><i><?php echo $this->tanggalan->tgl_indo2($beli_det->tgl_ed) ?></i></small>
                                                        </td>
                                                        <td class="text-right" style="width: 100px;">
                                                            <?php echo general::format_angka($beli_det->harga); ?>
                                                        </td>
                                                        <td class="text-right" style="width: 100px;">
                                                            <?php echo general::format_angka($beli_det->harga_het); ?>
                                                        </td>
                                                        <td class="text-right" style="width: 100px;">
                                                            <?php echo ($beli_det->diskon > 0 || $beli_det->potongan > 0 ? (float) $beli_det->diskon + $beli_det->potongan : '0') ?>
                                                        </td>
                                                        <td class="text-right" style="width: 100px;">
                                                            <?php echo (float) $beli_det->jml; ?>
                                                        </td>
                                                        <td class="text-right" style="width: 100px;">
                                                            <?php echo general::format_angka($beli_det->subtotal); ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td class="text-right text-bold" colspan="7">Subtotal</td>
                                                    <td class="text-right text-bold"><?php echo general::format_angka($jml_subtot) ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right text-bold" colspan="7">Diskon</td>
                                                    <td class="text-right text-bold"><?php echo general::format_angka($beli->jml_diskon) ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right text-bold" colspan="7">PPN</td>
                                                    <td class="text-right text-bold"><?php echo general::format_angka($beli->jml_ppn) ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right text-bold" colspan="7">Grand Total</td>
                                                    <td class="text-right text-bold"><?php echo general::format_angka($beli->jml_gtotal) ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" style="background-color: #17a2b8;"></td>
                                                </tr>
                                                <?php $no++ ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!--Tanggal Rentang-->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<!--<script src="<?php // echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js')      ?>"></script>-->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.css'); ?>">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $("#tgl").datepicker({
            dateFormat: 'dd-mm-yy',
            //defaultDate: "+1w",
            SetDate: new Date(),
            changeMonth: true,
            changeYear: true,
            yearRange: '2022:<?php echo date('Y') ?>',
            autoclose: true
        });

        $('#tgl_rentang').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY',
            }
        })
    });
</script>