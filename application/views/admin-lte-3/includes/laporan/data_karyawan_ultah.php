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
                        <li class="breadcrumb-item active">Data Karyawan</li>
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
                    <?php echo form_open(base_url('laporan/set_data_karyawan_ultah.php'), 'autocomplete="off"') ?> 
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Cari Karyawan Ultah</h3>
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
                                            <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Isikan tgl dan bulan saja cth: 17-08 ...', 'value' => (isset($_GET['tgl']) ? $_GET['tgl'].'-'.$_GET['bln'] : ''))) ?>
                                        </div>
                                        <label class="control-label"><small><i class="text-danger">*Cari berdasarkan tanggal dan bulan ulang tahun karyawan tanpa menyertakan tahun</i></small></label>
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
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Data Ultah Karyawan</h3>
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
                                $tg         = $this->input->get('tgl');
                                $bl         = $this->input->get('bln');
                                $hr_awal    = $this->input->get('hr_awal');
                                $bln_awal   = $this->input->get('bln_awal');
                                $hr_akhir   = $this->input->get('hr_akhir');
                                $bln_akhir  = $this->input->get('bln_akhir');

                                switch ($case) {
                                    case 'per_tanggal':
                                        $uri_xls    = base_url('laporan/xls_' . $uri . '.php?case=' . $case . '&tgl=' . $tg . '&bln=' . $bl);
                                        $uri_xls2   = base_url('laporan/xls_' . $uri . '2.php?');
                                        $btn_ctk    = '<button class="btn btn-success btn-flat" onclick="window.location.href = \''.$uri_xls.'\'"><i class="fas fa-file-excel"></i> WA Birthday</button>';
                                        break;
                                    
                                    case 'per_rentang':
                                        $uri_xls    = base_url('laporan/xls_' . $uri . '.php?case=' . $case . '&hr_awal=' . $hr_awal . '&hr_akhir='.$hr_akhir.'&bln_awal=' . $bln_awal.'&bln_akhir='.$bln_akhir);
                                        $uri_xls2   = base_url('laporan/xls_' . $uri . '2.php?');
                                        
                                        $btn_ctk    = '<button class="btn btn-success btn-flat" onclick="window.location.href = \''.$uri_xls.'\'"><i class="fas fa-file-excel"></i> WA Birthday</button>';
                                        break;
                                }
                                ?>
                                <?php echo $btn_ctk ?>
                                <!--<button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo $uri_xls2 ?>'"><i class="fas fa-file-excel"></i> Data Pasien</button>-->
                                <?php echo br(); ?>
                                <?php echo $this->session->flashdata('medcheck'); ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>NIK</th>
                                            <th>Karyawan</th>
                                            <th class="text-center">Tgl Lahir</th>
                                            <th class="text-left">No. HP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($sql_karyawan)) {   
                                            $wkt    = $this->tanggalan->wkt_teks(date('H:i'));
                                            $no     = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                            foreach ($sql_karyawan as $kary) {
                                                $title   = '*'.str_replace('-', ' ', url_title($pengaturan->judul)).'*';
                                                $msg     = 'Selamat '.$wkt.',%0A';
                                                $msg    .= 'Mengucapkan selamat ulang tahun untuk *'.$kary->nama.'*%0A%0A';
//                                                $msg    .= 'Mohon untuk membantu perbaikan kami dengan mengisi link berikut :%0A';
                                                $msg    .= 'https%3A%2F%2Fforms.gle%2FFS6ADeAGEDNGwXyc9%0A%0A';
                                                $msg    .= 'Semoga Sehat Selalu';
                                                ?>
                                                <tr>
                                                    <td class="text-center" style="width: 10px">
                                                        <?php echo $no++ ?>.
                                                    </td>
                                                    <td class="text-left" style="width: 150px;">
                                                        <?php echo $kary->nik ?>
                                                        <?php if(!empty($kary->no_hp) OR strlen($kary->no_hp) > '9'){ ?>
                                                            <?php echo br(); ?>
                                                            <span class="mailbox-read-time float-left"><?php echo $this->tanggalan->tgl_indo5($kary->tgl_simpan); ?></span><br/>
                                                            <a href="https://wa.me/62<?php echo substr($kary->no_hp, 1).'?text='.$msg ?>" target="_blank">
                                                                <img alt="" class="xz74otr x193iq5w xxymvpz" referrerpolicy="origin-when-cross-origin" src="<?php echo base_url('assets/theme/admin-lte-3/dist/img/WhatsAppButtonGreenSmall.png') ?>" style="width: 136px; height: 29px;">
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-left" style="width: 450px;">
                                                        <b><?php echo $kary->nama; ?></b>
                                                        <?php echo br(); ?>
                                                        <small><?php echo '[' . $this->tanggalan->usia($kary->tgl_lahir) . ']'; ?></small>
                                                    </td>
                                                    <td class="text-center"><?php echo $this->tanggalan->tgl_indo2($kary->tgl_lahir) ?></td>
                                                    <td class="text-left"><?php echo $kary->no_hp ?></td>
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
            dateFormat: 'dd-mm',
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