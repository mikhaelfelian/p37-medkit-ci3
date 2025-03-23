<?php 
$txt_pasien = explode(' ', $pasien->nama);
$nm_file    = strtolower($pasien->nik);
?>
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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('master/index.php') ?>">Master Data</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('master/data_pasien_list.php') ?>">Pasien</a></li>
                        <li class="breadcrumb-item active"><?php echo (isset($_GET['id']) ? 'Ubah' : 'Tambah'); ?></li>
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
                <div class="col-md-3">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Foto Pasien</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <section id="foto_pasien">
                                <video autoplay="true" id="kamera" class="img-fluid">
                                    Silahkan perbarui peramban anda !!
                                </video>
                                <img id="gambar" class="p-0">
                            </section>
                        </div>
                        <div class="card-footer p-0">
                            <button type="button" onclick="takeSnapshot()" class="btn btn-primary btn-flat btn-block"><i class="fa fa-camera"></i> Ambil Gambar</button>
                        </div>
                    </div>
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Foto Identitas</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <section id="foto_pasien_id">
                                <video autoplay="true" id="kamera_id" class="img-fluid">
                                    Silahkan perbarui peramban anda !!
                                </video>
                                <img id="gambar_id" class="p-0">
                            </section>
                        </div>
                        <div class="card-footer p-0">
                            <button type="button" onclick="takeSnapshot_id()" class="btn btn-primary btn-flat btn-block"><i class="fa fa-camera"></i> Ambil Gambar</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <?php echo form_open_multipart(base_url('master/data_pasien_' . (isset($_GET['id']) ? 'update' : 'simpan') . '.php'), 'autocomplete="off"') ?>
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Data Pasien</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php echo $this->session->flashdata('master'); ?>
                            <?php $hasError = $this->session->flashdata('form_error'); ?>
                            <?php echo form_hidden('id', general::enkrip($pasien->id)) ?>
                            <?php echo form_hidden('route', $this->input->get('route')) ?>
                            <input type="hidden" id="file" name="file">
                            <input type="hidden" id="file_id" name="file_id">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group <?php echo (!empty($hasError['nik']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">NIK* <small><i>(* KTP / Passport / KIA)</i></small></label>
                                        <?php echo form_input(array('id' => 'nik', 'name' => 'nik', 'class' => 'form-control' . (!empty($hasError['nik']) ? ' is-invalid' : ''), 'value' => $pasien->nik, 'placeholder' => 'Nomor Identitas ...')) ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group <?php echo (!empty($hasError['gelar']) ? 'text-danger' : '') ?>">
                                                <label class="control-label">Gelar*</label>
                                                <select name="gelar" class="form-control <?php echo (!empty($hasError['gelar']) ? 'is-invalid' : '') ?>">
                                                    <option value="">- Pilih -</option>
                                                    <?php foreach ($gelar as $gelar) { ?>
                                                        <option value="<?php echo $gelar->id ?>" <?php echo ($gelar->id == $pasien->id_gelar ? 'selected' : '') ?>><?php echo $gelar->gelar ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                            <div class="form-group <?php echo (!empty($hasError['nama']) ? 'text-danger' : '') ?>">
                                                <label class="control-label">Nama Lengkap*</label>
                                                <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'value' => $pasien->nama, 'placeholder' => 'John Doe ...')) ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group <?php echo (!empty($hasError['jns_klm']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Jenis Kelamin*</label>
                                        <select name="jns_klm" class="form-control <?php echo (!empty($hasError['jns_klm']) ? 'is-invalid' : '') ?>">
                                            <option value="">- Pilih -</option>
                                            <option value="L" <?php echo ('L' == $pasien->jns_klm ? 'selected' : '') ?>>Laki - laki</option>
                                            <option value="P" <?php echo ('P' == $pasien->jns_klm ? 'selected' : '') ?>>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group <?php echo (!empty($hasError['tmp_lahir']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Tempat Lahir</label>
                                        <?php echo form_input(array('id' => 'tmp_lahir', 'name' => 'tmp_lahir', 'class' => 'form-control', 'value' => $pasien->tmp_lahir, 'placeholder' => 'Semarang ...')) ?>
                                    </div>

                                    <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Tgl Lahir</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <?php echo form_input(array('id' => 'tgl_lahir', 'name' => 'tgl_lahir', 'class' => 'form-control', 'value' => $this->tanggalan->tgl_indo8($pasien->tgl_lahir), 'readonly'=>'TRUE', 'placeholder' => 'Isikan dengan format 15-02-1992 ...')) ?>
                                        </div>                                        
                                    </div>
                                    <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                        <label class="control-label">No. HP</label>
                                        <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control', 'value' => $pasien->no_hp, 'placeholder' => 'Nomor kontak WA pasien / keluarga pasien ...')) ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="control-label">Upload Foto</label>
                                        <input type="file" name="fupload" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group <?php echo (!empty($hasError['nik']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Alamat KTP<small><i>* Sesuai Identitas</i></small></label>
                                        <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control', 'value' => $pasien->alamat, 'style' => 'height: 124px;', 'placeholder' => 'Mohon diisi alamat lengkap ...')) ?>
                                    </div>

                                    <div class="form-group <?php echo (!empty($hasError['nik']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Alamat Domisili<small><i>* Sesuai Domisili</i></small></label>
                                        <?php echo form_textarea(array('id' => 'alamat_dom', 'name' => 'alamat_dom', 'class' => 'form-control', 'value' => $pasien->alamat_dom, 'style' => 'height: 124px;', 'placeholder' => 'Mohon diisi alamat lengkap ...')) ?>
                                    </div>

                                    <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Pekerjaan</label>
                                        <select name="pekerjaan" class="form-control">
                                            <option value="">- Pilih -</option>
                                            <?php foreach ($kerja as $kerja) { ?>
                                                <option value="<?php echo $kerja->id ?>" <?php echo ($kerja->id == $pasien->id_pekerjaan ? 'selected' : '') ?>><?php echo $kerja->jenis ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                        <label class="control-label">No. Rumah</label>
                                        <?php echo form_input(array('id' => 'no_rmh', 'name' => 'no_rmh', 'class' => 'form-control', 'value' => $pasien->no_telp, 'placeholder' => 'Isikan Nomor rumah (PSTN) pasien / keluarga pasien ...')) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <!--<button type="button" onclick="window.location.href = '<?php // echo base_url('master/data_pasien_list.php')      ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>-->
                                </div>
                                <div class="col-lg-6 text-right">
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <?php echo form_close() ?>
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
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
    // seleksi elemen video
    var video = document.querySelector("#kamera");
    var video2 = document.querySelector("#kamera_id");
    var gambar = document.querySelector("#gambar");
    var gambar2 = document.querySelector("#gambar_id");
    gambar.style.display = 'none';
    gambar2.style.display = 'none';

    $(function () {
        // minta izin user
        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

        // jika user memberikan izin
        if (navigator.getUserMedia) {
            // jalankan fungsi handleVideo, dan videoError jika izin ditolak
            navigator.getUserMedia({video: true}, handleVideo, videoError);
        }

        // fungsi ini akan dieksekusi jika  izin telah diberikan
        function handleVideo(stream) {
            video.srcObject = stream;
        }

        // fungsi ini akan dieksekusi kalau user menolak izin
        function videoError(e) {
            // do something
            alert("Izinkan menggunakan webcam untuk demo!")
        }
    });

    function takeSnapshot() {
        var img = document.getElementById('gambar');
        var nama = document.getElementById('file');
        var context;

        // video
        var width = video.offsetWidth, height = video.offsetHeight;

        // buat elemen canvas
        canvas = document.createElement('canvas');
        canvas.width = width;
        canvas.height = height;

        // ambil gambar dari video dan masukan 
        // ke dalam canvas
        context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, width, height);

        // render hasil dari canvas ke elemen img
        img.src = canvas.toDataURL('image/png');

        video.style.display = 'none';
        gambar.style.display = 'block'
        nama.value = canvas.toDataURL('image/png');
        
        // Download data gambar dari kamera otomatis
        const link = document.createElement('a');
        canvas.toBlob(function(blob) {
            link.href = URL.createObjectURL(blob);
            link.download = 'pasien_<?php echo (!empty($nm_file) ? $nm_file.'_'.date('ymd') : date('YmdHis')) ?>.png'; // naming the downloaded file with email
            link.click();
        }, 'image/png');
    }

    function takeSnapshot_id() {
        var img2 = document.getElementById('gambar_id');
        var nama2 = document.getElementById('file_id');
        var context;

        // video
        var width = video2.offsetWidth, height = video2.offsetHeight;

        // buat elemen canvas
        canvas2 = document.createElement('canvas');
        canvas2.width = width;
        canvas2.height = height;

        // ambil gambar dari video dan masukan 
        // ke dalam canvas
        context = canvas2.getContext('2d');
        context.drawImage(video2, 0, 0, width, height);

        // render hasil dari canvas ke elemen img
        img2.src = canvas2.toDataURL('image/png');

        video2.style.display = 'none';
        gambar2.style.display = 'block'
        nama2.value = canvas2.toDataURL('image/png');
    }

    // minta izin user
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

    // jika user memberikan izin
    if (navigator.getUserMedia) {
        // jalankan fungsi handleVideo, dan videoError jika izin ditolak
        navigator.getUserMedia({video: true}, handleVideo, videoError);
    }

    // fungsi ini akan dieksekusi jika  izin telah diberikan
    function handleVideo(stream) {
        video.srcObject = stream;
        video2.srcObject = stream;
    }

    // fungsi ini akan dieksekusi kalau user menolak izin
    function videoError(e) {
        // do something
//            alert("Untuk mengambil foto pasien, silahkan ijinkan akses kamera pada browser ini. Terimakasih")
    }

    $(function () {
        $("#tgl_lahir").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: '1920:<?php echo date('Y') ?>',
            autoclose: true
        });
        
        <?php echo $this->session->flashdata('master_toast'); ?>
    });
</script>