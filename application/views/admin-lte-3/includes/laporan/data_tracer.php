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
                        <li class="breadcrumb-item active">Data Tracer</li>
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
                    <?php echo form_open(base_url('laporan/set_data_tracer.php'), 'autocomplete="off"') ?> 
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Laporan Tracer Pasien</h3>
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
                                        <label class="control-label">Klinik</label>
                                        <select name="poli" class="form-control select2bs4 <?php echo (!empty($hasError['poli']) ? ' is-invalid' : '') ?>">
                                            <option value="">- Semua Poli -</option>
                                            <?php foreach ($sql_poli as $poli) { ?>
                                                <option value="<?php echo $poli->id ?>" <?php echo ($_GET['poli'] == $poli->id ? 'selected' : '') ?>><?php echo $poli->lokasi ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group <?php echo (!empty($hasError['tipe']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Tipe</label>
                                        <select name="tipe" class="form-control <?php echo (!empty($hasError['tipe']) ? ' is-invalid' : '') ?>">
                                            <option value="">[Tipe Perawatan]</option>
                                                <option value="1" <?php echo ($_GET['tipe'] == '1' ? 'selected' : '') ?>>Laborat</option>
                                                <option value="4" <?php echo ($_GET['tipe'] == '4' ? 'selected' : '') ?>>Radiologi</option>
                                                <option value="2" <?php echo ($_GET['tipe'] == '2' ? 'selected' : '') ?>>Rawat Jalan</option>
                                                <option value="3" <?php echo ($_GET['tipe'] == '3' ? 'selected' : '') ?>>Rawat Inap</option>
                                                <option value="5" <?php echo ($_GET['tipe'] == '5' ? 'selected' : '') ?>>MCU</option>
                                                <option value="6" <?php echo ($_GET['tipe'] == '6' ? 'selected' : '') ?>>Apotik / Farmasi</option>
                                        </select>
                                    </div> 
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
                                <h3 class="card-title">Data Laporan Tracer</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-right">
                                        <?php echo $pagination ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
                                $uri        = substr($this->uri->segment(2), 0, -4);
                                $case       = $this->input->get('case');
                                $tg_awal    = $this->input->get('tgl_awal');
                                $tg_akhr    = $this->input->get('tgl_akhir');
                                $tg         = $this->input->get('tgl');
                                $tipe       = $this->input->get('tipe');
                                $poli       = $this->input->get('poli');

                                switch ($case) {
                                    case 'per_tanggal':
                                        $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . '&tgl=' . $tg .(!empty($tipe) ? '&tipe='.$tipe : '').(!empty($poli) ? '&poli='.$poli : ''));
                                        break;

                                    case 'per_rentang':
                                        $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr.(!empty($tipe) ? '&tipe='.$tipe : '').(!empty($poli) ? '&poli='.$poli : ''));
                                        break;
                                }
                                ?>
                                <button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo $uri_xls ?>'"><i class="fas fa-file-excel"></i> Cetak Excel</button>
                                <?php echo br(); ?>
                                <?php echo $this->session->flashdata('medcheck'); ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>ID</th>
                                            <th class="text-left">Pasien</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Pendaftaran</th>
                                            <th class="text-center">PX Dokter</th>
                                            <th class="text-center">Sampling</th>
                                            <th class="text-center">Radiologi</th>
                                            <th class="text-center">Farmasi</th>
                                            <th class="text-center">Ranap</th>
                                            <th class="text-center">Selesai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($sql_tracer)) {
                                            $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                            foreach ($sql_tracer as $trace) {
                                                ?>
                                                <tr>
                                                    <td class="text-center" style="width: 10px">
                                                        <?php echo $no++ ?>.
                                                    </td>
                                                    <td class="text-left" style="width: 150px;">
                                                        <?php echo anchor(base_url('medcheck/detail.php?id=' . general::enkrip($trace->id).'&route=laporan/data_stok_keluar.php'), '#' . $trace->no_rm, 'class="text-default" target="_blank"') ?>
                                                        <?php echo br(); ?>
                                                        <span class="mailbox-read-time float-left"><?php echo $this->tanggalan->tgl_indo5($trace->tgl_simpan); ?></span>
                                                    </td>
                                                    <td class="text-left" style="width: 450px;">
                                                        <b><?php echo $trace->nama_pgl; ?></b>
                                                        <?php echo br(); ?>
                                                        <small><?php echo $trace->supplier; ?></small>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $this->tanggalan->tgl_indo($trace->tanggal); ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $this->tanggalan->tgl_indo5($trace->wkt_daftar); ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $this->tanggalan->tgl_indo5($trace->wkt_periksa); ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $this->tanggalan->tgl_indo5($trace->wkt_sampling); ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $this->tanggalan->tgl_indo5($trace->wkt_rad); ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $this->tanggalan->tgl_indo5($trace->wkt_farmasi); ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $this->tanggalan->tgl_indo5($trace->wkt_ranap); ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $this->tanggalan->tgl_indo5($trace->wkt_selesai); ?>
                                                    </td>
                                                </tr>
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