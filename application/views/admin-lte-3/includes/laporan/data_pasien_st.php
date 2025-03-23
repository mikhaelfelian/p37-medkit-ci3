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
                        <li class="breadcrumb-item active">Data Pasien</li>
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
                    <?php echo form_open(base_url('laporan/set_data_pasien_st.php'), 'autocomplete="off"') ?> 
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Cari Pasien</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php $hasError = $this->session->flashdata('form_error'); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tanggal Rentang</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <?php echo form_input(array('id' => 'tgl_rentang', 'name' => 'tgl_rentang', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => '02/15/2022 - 02/15/2022 ...')) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Status Pasien</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="statusPasien" id="pasienBaru" value="1" checked="TRUE">
                                            <label class="form-check-label" for="pasienBaru">Pasien Baru</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="statusPasien" id="pasienLama" value="2">
                                            <label class="form-check-label" for="pasienLama">Pasien Lama</label>
                                        </div>
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
            <?php if ($_GET['jml'] > 0) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default rounded-0">
                            <div class="card-header">
                                <h3 class="card-title">Data Pasien</h3>
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
                                $tgl        = $this->input->get('tgl');
                                $tgl_awal   = $this->input->get('tgl_awal'); 
                                $tgl_akhir  = $this->input->get('tgl_akhir');
                                $statusPas  = $this->input->get('status_pas');

                                // Generate URL untuk Excel & PDF
                                $uri_xls = base_url('laporan/xls_data_pasien_st.php?case=' . $case 
                                    . (!empty($tgl) ? '&tgl=' . $tgl : '') 
                                    . (!empty($tgl_awal) && !empty($tgl_akhir) ? '&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir : '') 
                                    . '&status_pas=' . $statusPas);

                                $uri_pdf = base_url('laporan/pdf_data_pasien_st.php?case=' . $case 
                                    . (!empty($tgl) ? '&tgl=' . $tgl : '') 
                                    . (!empty($tgl_awal) && !empty($tgl_akhir) ? '&tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir : '') 
                                    . '&status_pas=' . $statusPas);

                                // Menentukan tombol cetak berdasarkan case
                                switch ($case) {
                                    default:
                                        $btn_cetak = '
                                            <a href="'.$uri_xls.'" class="btn btn-success btn-flat">
                                                <i class="fas fa-file-excel"></i> Export Excel
                                            </a>';
                                        break;

                                    case 'per_tanggal':
                                        $btn_cetak = '
                                            <a href="'.$uri_xls.'" class="btn btn-success btn-flat">
                                                <i class="fas fa-file-excel"></i> WA Birthday (Excel)
                                            </a>';
                                        break;
                                }

                                echo $btn_cetak;
                                ?>
                                <?php echo br(); ?>
                                <?php echo $this->session->flashdata('medcheck'); ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>No. RM</th>
                                            <th>Pasien</th>
                                            <th class="text-center">Tgl Lahir</th>
                                            <th class="text-left">No. HP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($sql_pasien)) {                                            
                                            $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                            foreach ($sql_pasien as $pasien) {
                                                ?>
                                                <tr>
                                                    <td class="text-center" style="width: 10px">
                                                        <?php echo $no++ ?>.
                                                    </td>
                                                    <td class="text-left" style="width: 150px;">
                                                        <?php echo $pasien->kode_pasien ?>
                                                    </td>
                                                    <td class="text-left" style="width: 450px;">
                                                        <b><?php echo $pasien->pasien; ?></b>
                                                        <?php echo br(); ?>
                                                        <small><?php echo '[' . $this->tanggalan->usia($pasien->tgl_lahir) . ']'; ?></small>
                                                    </td>
                                                    <td class="text-center"><?php echo $this->tanggalan->tgl_indo2($pasien->tgl_lahir) ?></td>
                                                    <td class="text-left">
                                                        <?php if (!empty($pasien->no_hp)) { 
                                                            // Hapus karakter selain angka, kecuali tanda +
                                                            $no_hp_clean = preg_replace('/[^0-9+]/', '', $pasien->no_hp);

                                                            // Jika nomor dimulai dengan 0, ubah menjadi format internasional (Indonesia: +62)
                                                            if (substr($no_hp_clean, 0, 1) === "0") {
                                                                $no_hp_clean = "+62" . substr($no_hp_clean, 1);
                                                            }
                                                        ?>
                                                            <a href="https://wa.me/<?php echo $no_hp_clean; ?>" target="_blank" class="btn btn-success btn-sm">
                                                                <i class="fab fa-whatsapp"></i> <?php echo $pasien->no_hp; ?>
                                                            </a>
                                                        <?php } else { ?>
                                                            <span class="text-muted">No HP Tidak Tersedia</span>
                                                        <?php } ?>
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
<!--<script src="<?php // echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js')     ?>"></script>-->
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
            SetDate: new Date(),            
            dateFormat: 'mm/dd/yy',
            changeMonth: true,
            autoclose: true
        });       
        
        $('#tgl_rentang').daterangepicker({
            locale: {
                format: 'MM/DD/YYYY'
            }
        });
    });
</script>