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
                        <li class="breadcrumb-item active">Data Stok</li>
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
                    <?php echo form_open(base_url('laporan/set_data_stok.php'), 'autocomplete="off"') ?> 
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Laporan Data Item</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php $hasError = $this->session->flashdata('form_error'); ?>

                            <div class="row">
                                <div class="col-md-8">
                                    <?php // echo form_input(array('name'=>'tgl', 'class' => 'form-control', 'placeholder'=>'Silahkan isi tanggal ...')); ?>
                                </div>
                                <div class="col-md-8">
                                    <?php echo form_radio(array('name'=>'st', 'value'=>'0', 'checked'=>($_GET['tipe'] == '0' ? TRUE : FALSE))); ?> Non Stockable <?php echo nbs(2); ?>
                                    <?php echo form_radio(array('name'=>'st', 'value'=>'1', 'checked'=>($_GET['tipe'] == '1' ? TRUE : FALSE)));; ?> Stockable <?php echo nbs(2); ?>
                                    <?php echo form_radio(array('name'=>'st', 'value'=>'2', 'checked'=>($_GET['tipe'] == '2' ? TRUE : FALSE))); ?> Semua <?php echo nbs(2); ?>
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
                                <h3 class="card-title">Data Laporan Stok</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-right">
                                        <?php echo $pagination ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
                                $uri        = substr($this->uri->segment(2), 0, -4);
                                $case       = $this->input->get('tipe');
                                $stok       = $this->input->get('stok');

                                $uri_pdf    = base_url('laporan/' . $uri . '_pdf.php?tipe=' . $case . '&stok=' . $stok);
                                $uri_xls    = base_url('laporan/xls_' . $uri . '.php?tipe=' . $case . '&stok=' . $stok);
                                $uri_xls2   = base_url('laporan/xls_' . $uri . '_gomed.php?tipe=' . $case . '&stok=' . $stok);
                                $uri_xls3   = base_url('laporan/csv_' . $uri . '_gomed.php?tipe=' . $case . '&stok=' . $stok);
                                ?>
                                <button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo $uri_xls ?>'"><i class="fas fa-file-excel"></i> Cetak Excel</button>
                                <!--<button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo $uri_xls2 ?>'"><i class="fas fa-file-excel"></i> Cetak Gomed</button>-->
                                <!--<button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo $uri_xls3 ?>'"><i class="fas fa-file-excel"></i> CSV Gomed</button>-->
                                <?php echo br(); ?>
                                <?php echo $this->session->flashdata('medcheck'); ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Tgl</th>
                                            <th>Kode</th>
                                            <th>Item</th>
                                            <th class="text-center">Stok</th>
                                            <th class="text-right">Harga Beli</th>
                                            <th class="text-right">Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!--
                                        <tr>
                                            <td class="text-right text-bold" colspan="4">Total Persediaan</td>
                                            <td class="text-right text-bold"><?php echo general::format_angka($sql_stok_row->jml_gtotal) ?></td>
                                        </tr>
                                        -->
                                        <?php
                                        if (!empty($sql_stok)) {
                                            $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                            foreach ($sql_stok as $item) {
                                                $nilai_stok = $item->jml * $item->harga_jual;
                                                ?>
                                                <tr>
                                                    <td class="text-center" style="width: 10px">
                                                        <?php echo $no++ ?>.
                                                    </td>
                                                    <td class="text-left" style="width: 150px;">
                                                        <?php echo $this->tanggalan->tgl_indo5($item->tgl_modif); ?>
                                                    </td>
                                                    <td class="text-left" style="width: 75px;">
                                                        <?php echo $item->kode ?>
                                                        <?php // echo anchor(base_url('medcheck/detail.php?id=' . general::enkrip($item->id)), '#' . $item->no_rm, 'class="text-default" target="_blank"') ?>
                                                        <?php // echo br(); ?>
                                                        <!--<span class="mailbox-read-time float-left"><?php // echo $this->tanggalan->tgl_indo5($item->tgl_simpan); ?></span>-->
                                                    </td>
                                                    <td class="text-left" style="width: 450px;">
                                                        <b><?php echo $item->produk; ?></b>
                                                    </td>
                                                    <td class="text-right" style="width: 80px;">
                                                        <?php echo general::format_angka($item->jml); ?>
                                                    </td>
                                                    <td class="text-right" style="width: 100px;">
                                                        <?php echo general::format_angka($item->harga_beli); ?>
                                                    </td>
                                                    <td class="text-right" style="width: 100px;">
                                                        <?php echo general::format_angka($item->harga_jual); ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <!--
                                            <tr>
                                                <td class="text-right text-bold" colspan="4">Total</td>
                                                <td class="text-right text-bold"><?php echo general::format_angka($sql_omset_row->jml_gtotal) ?></td>
                                            </tr>
                                            -->
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
<!--<script src="<?php // echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js')    ?>"></script>-->
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
                                            format: 'mm/dd/yyyy',
                                            //defaultDate: "+1w",
                                            SetDate: new Date(),
                                            changeMonth: true,
                                            changeYear: true,
                                            yearRange: '2022:<?php echo date('Y') ?>',
                                            autoclose: true
                                        });

                                        $('#tgl_rentang').daterangepicker({
                                            locale: {
                                                format: 'MM/DD/YYYY'
                                            }
                                        })
                                    });
</script>