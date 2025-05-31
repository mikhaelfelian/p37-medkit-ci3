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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard2.php') ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('laporan/index.php') ?>">Laporan</a>
                        </li>
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
                    <?php echo form_open(base_url('laporan/set_data_pasien.php'), 'autocomplete="off"') ?>
                    <div class="card card-default rounded-0">
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
                                        <label class="control-label">Tanggal</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text rounded-0"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control rounded-0 text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Isikan tgl dan bulan saja cth: 17-08 ...', 'value' => (isset($_GET['tgl']) ? $_GET['tgl'] . '-' . $_GET['bln'] : ''))) ?>
                                        </div>
                                        <label class="control-label"><small><i class="text-danger">*Cari berdasarkan
                                                    tanggal dan bulan ulang tahun pasien tanpa menyertakan
                                                    tahun</i></small></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Bulan</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text rounded-0"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <select id="bulan" name="bulan"
                                                class="form-control rounded-0 form-control-inline<?php echo !empty($hasError['pasien']) ? ' is-invalid' : ''; ?>">
                                                <option value="">Pilih Bulan</option>
                                                <option value="1">Januari</option>
                                                <option value="2">Februari</option>
                                                <option value="3">Maret</option>
                                                <option value="4">April</option>
                                                <option value="5">Mei</option>
                                                <option value="6">Juni</option>
                                                <option value="7">Juli</option>
                                                <option value="8">Agustus</option>
                                                <option value="9">September</option>
                                                <option value="10">Oktober</option>
                                                <option value="11">November</option>
                                                <option value="12">Desember</option>
                                            </select>
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
                                    <button type="submit" class="btn btn-primary btn-flat rounded-0"><i class="fa fa-search"></i>
                                        Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
            <?php if ($sql_pasien) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
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
                                $uri = substr($this->uri->segment(2), 0, -4);
                                $case = $this->input->get('case');
                                $tgl = explode('-', $this->input->get('tgl'));
                                $tg = $tgl[0];
                                $bl = $tgl[1];

                                switch ($case) {
                                    default:
                                        $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . '&tgl=' . $tg . '&bln=' . $bl);
                                        $uri_xls2 = base_url('laporan/xls_' . $uri . '2.php?');
                                        $btn_ctk = '<button class="btn btn-success btn-flat" onclick="window.location.href = \'' . $uri_xls2 . '\'"><i class="fas fa-file-excel"></i> Data Pasien</button>';
                                        break;

                                    case 'per_tanggal':
                                        $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . '&tgl=' . $tg . '&bln=' . $bl);
                                        $uri_xls2 = base_url('laporan/xls_' . $uri . '2.php?');

                                        $btn_ctk = '<button class="btn btn-success btn-flat" onclick="window.location.href = \'' . $uri_xls . '\'"><i class="fas fa-file-excel"></i> WA Birthday</button>';
                                        break;
                                }
                                ?>
                                <?php echo $btn_ctk ?>
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
                                                        <?php echo $pasien->kode_dpn . '' . $pasien->kode ?>
                                                    </td>
                                                    <td class="text-left" style="width: 450px;">
                                                        <b><?php echo $pasien->nama; ?></b>
                                                        <?php echo br(); ?>
                                                        <small><?php echo '[' . $this->tanggalan->usia($pasien->tgl_lahir) . ']'; ?></small>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php 
                                                        $tgl_lahir = explode('-', $pasien->tgl_lahir);
                                                        echo '<b>' . $tgl_lahir[2] . '-' . $tgl_lahir[1] . '</b>-' . $tgl_lahir[0]; 
                                                        ?>
                                                    </td>
                                                    <td class="text-left">
                                                        <?php 
                                                        // Perbaiki icon dan line break agar tampil baik di WhatsApp
                                                        $message = rawurlencode(
                                                            "🎉 Selamat Ulang Tahun! 🎉\n\n" .
                                                            "Hai Tn./Nn. " . $pasien->nama . ",\n\n" .
                                                            "Selamat ulang tahun dari kami Klinik Esensia!\n\n" .
                                                            "Sebagai bentuk apresiasi, kami punya hadiah spesial untuk Anda:\n" .
                                                            "• Diskon Pemeriksaan Laboratorium\n" .
                                                            "• Gratis Konsultasi dengan Dokter Spesialis Penyakit Dalam (SpPD)\n\n" .
                                                            "✨ Berlaku dengan minimal transaksi Rp250.000\n\n" .
                                                            "Promo hanya berlaku untuk Anda dan bisa digunakan sampai satu bulan setelah menerima pesan ini.\n" .
                                                            "Tunjukkan pesan ini saat datang ke klinik, ya!\n\n" .
                                                            "Terima kasih sudah menjadi bagian dari Sahabat Sehat Keluarga 💙\n\n" .
                                                            "📍 Jl. Wolter Monginsidi No.40, Pedurungan Tengah, Kec. Pedurungan, Kota Semarang\n" .
                                                            "WA: 088809995150\n" .
                                                            "IG & TikTok: klinikesensia\n" .
                                                            "Website: esensia.co.id"
                                                        );
                                                        $wa_link = "https://wa.me/" . preg_replace('/[^0-9]/', '', $pasien->no_hp) . "?text=" . $message;
                                                        ?>
                                                        <a href="<?php echo $wa_link ?>" target="_blank" class="btn btn-success btn-sm">
                                                            <i class="fab fa-whatsapp"></i> <?php echo $pasien->no_hp ?>
                                                        </a>
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
<link rel="stylesheet"
    href="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.css'); ?>">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet"
    href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

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
                format: 'DD/MM/YYYY'
            }
        });
    });
</script>