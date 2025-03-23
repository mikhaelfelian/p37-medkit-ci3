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
                    <?php echo form_open(base_url('laporan/set_data_tracer_div.php'), 'autocomplete="off"') ?> 
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
                                    <div class="form-group">
                                        <label class="control-label">Tipe</label>
                                        <select name="tipe" class="form-control <?php // echo (!empty($hasError['tipe']) ? ' is-invalid' : '') ?>">
                                            <option value="">[Pilih]</option>
                                            <option value="1" <?php // echo ($_GET['tipe'] == '3' ? 'selected' : '') ?>>Pendaftaran</option>
                                            <option value="2" <?php // echo ($_GET['tipe'] == '1' ? 'selected' : '') ?>>Laborat</option>
                                            <option value="3" <?php // echo ($_GET['tipe'] == '4' ? 'selected' : '') ?>>Radiologi</option>
                                            <option value="4" <?php // echo ($_GET['tipe'] == '2' ? 'selected' : '') ?>>Farmasi</option>
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

                                switch ($case) {
                                    case 'per_tanggal':
                                        $uri_pdf = base_url('laporan/' . $uri . '_pdf.php?case=' . $case . '&tgl=' . $tg . (!empty($tipe) ? "&tipe=" . $tipe . "" : ""));
                                        $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . '&tgl=' . $tg . (!empty($tipe) ? "&tipe=" . $tipe . "" : ""));
                                        break;

                                    case 'per_rentang':
                                        $uri_pdf = base_url('laporan/' . $uri . '_pdf.php?case=' . $case . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr . (!empty($tipe) ? "&tipe=" . $tipe : "") . '&metode=' . $metode);
                                        $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr. (!empty($tipe) ? "&tipe=" . $tipe : ""));
                                        break;
                                }
                                ?>
                                <button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo $uri_xls ?>'"><i class="fas fa-file-excel"></i> Cetak Excel</button>
                                <?php echo br(); ?>
                                <?php echo $this->session->flashdata('medcheck'); ?>
                                <?php 
                                switch ($_GET['tipe']){
                                    default:
                                        break;
                                    
                                    case '1':
                                        $this->load->view('admin-lte-3/includes/laporan/data_tracer_div_px', $data);
                                        break;
                                    
                                    case '2':
                                        $this->load->view('admin-lte-3/includes/laporan/data_tracer_div_lab', $data);
                                        break;
                                    
                                    case '3':
                                        $this->load->view('admin-lte-3/includes/laporan/data_tracer_div_rad', $data);
                                        break;
                                    
                                    case '4':
                                        $this->load->view('admin-lte-3/includes/laporan/data_tracer_div_farm', $data);
                                        break;
                                }
                                ?>
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