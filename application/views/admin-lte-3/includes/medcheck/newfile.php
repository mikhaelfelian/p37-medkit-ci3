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
                        <li class="breadcrumb-item active">Pendaftaran</li>
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
                <div class="row">
                    <div class="col-md-3">                        
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Foto Pasien</h3>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <section id="foto_pasien">
                                    <video autoplay="true" id="kamera" class="img-fluid">
                                        Browsermu tidak mendukung bro, upgrade donk!
                                    </video>
                                    <img id="gambar" class="p-0">
                                    <!--<canvas id="canvas"></canvas>-->
                                    <!--<img id="photo" alt="The screen capture will appear in this box.">-->
                                </section>
                            </div>
                            <div class="card-footer p-0">
                                <button type="button" onclick="takeSnapshot()" class="btn btn-primary btn-flat btn-block"><i class="fa fa-camera"></i> Ambil Gambar</button>
                            </div>
                        </div>

                        <?php if (!empty($pasien->id)) { ?>
                            <div class="card card-primary card-outline" id="profile-pasien-lama">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle" src="<?php echo (!empty($pasien->file_base64) ? $pasien->file_base64 : base_url('assets/theme/admin-lte-3/icon_putra.png')) ?>" alt="User profile picture" style="width: 100px; height: 100px;">
                                    </div>
                                    <h3 class="profile-username text-center"><?php echo strtoupper($pasien->nama) ?></h3>
                                    <p class="text-muted text-center"><?php echo $this->tanggalan->tgl_indo2($pasien->tgl_lahir) ?></p>
                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>No. RM</b> <a class="float-right"><?php echo strtoupper($pasien->kode_dpn . $pasien->kode) ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>No. HP</b> <a class="float-right"><?php echo strtoupper($pasien->no_hp) ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                    </div> 
                    <div class="col-md-9">
                        <?php echo form_open(base_url('medcheck/daftar_' . (isset($_GET['id']) ? 'update' : 'simpan') . '.php'), 'autocomplete="off"') ?>
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Form Pendaftaran Pasien</h3>
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
                                <input type="hidden" id="file" name="file" value="<?php echo $pasien->file_base64 ?>">
                                <input type="hidden" id="file" name="id_pasien" value="<?php echo $this->input->get('id_pasien') ?>">

                                <div class="row">
                                    <div class="col-md-12">                                        
                                        <div class="form-group <?php echo (!empty($hasError['jns_klm']) ? 'text-danger' : '') ?>">
                                            <label class="control-label">Apakah Anda*</label>
                                            <br/>
                                            <?php echo form_hidden('tipe_pas', $this->input->get('tipe_pas')) ?>

                                            <a href="<?php echo base_url('medcheck/daftar.php?tipe_pas=1') ?>">
                                                <button type="button" class="btn <?php echo ($_GET['tipe_pas'] == '1' ? 'btn-default' : 'btn-primary') ?> btn-flat" id="pas_lama">Pasien Lama</button>
                                            </a>
                                            <a href="<?php echo base_url('medcheck/daftar.php?tipe_pas=2') ?>">
                                                <button type="button" class="btn <?php echo ($_GET['tipe_pas'] == '2' ? 'btn-default' : 'btn-primary') ?> btn-flat" id="pas_baru">Pasien Baru</button>
                                            </a>
                                            <br/>
                                            <!--<input type="radio" name="tipe_pas" value="1" id="pas_lama" <?php echo (isset($_GET['tipe']) ? ($_GET['tipe'] == '1' ? 'checked="TRUE"' : '') : ($this->session->flashdata('tipe_pas') == '1' ? $this->session->flashdata('tipe_pas') : '')) ?>> Pasien Lama-->
                                            <?php // echo nbs(2) ?>
                                            <!--<input type="radio" name="tipe_pas" value="2" id="pas_baru" <?php echo (isset($_GET['tipe']) ? ($_GET['tipe'] == '2' ? 'checked="TRUE"' : '') : ($this->session->flashdata('tipe_pas') == '2' ? $this->session->flashdata('tipe_pas') : '')) ?>> Pasien Baru-->
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <section id="pasien_baru1">
                                            <div class="form-group <?php echo (!empty($hasError['nik']) ? 'text-danger' : '') ?>">
                                                <label class="control-label">NIK <small><i>(* KTP / Passport / KIA)</i></small></label>
                                                <?php echo form_input(array('id' => 'nik_baru', 'name' => 'nik_baru', 'class' => 'form-control' . (!empty($hasError['nik']) ? ' is-invalid' : ''), 'value' => (!empty($pasien->nik) ? $pasien->nik : $this->session->flashdata('nik_baru')), 'placeholder' => 'Nomor Identitas ...')) ?>
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
                                                        <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'value' => (!empty($pasien->nama) ? $pasien->nama : $this->session->flashdata('nama')), 'placeholder' => 'John Doe ...')) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Jenis Kelamin*</label>
                                                <select name="jns_klm" class="form-control <?php echo (!empty($hasError['jns_klm']) ? 'is-invalid' : '') ?>">
                                                    <option value="">- Pilih -</option>
                                                    <option value="L" <?php echo (!empty($pasien->jns_klm) ? ('L' == $pasien->jns_klm ? 'selected' : '') : ('L' == $this->session->flashdata('jns_klm') ? 'selected' : '')) ?>>Laki - laki</option>
                                                    <option value="P" <?php echo (!empty($pasien->jns_klm) ? ('P' == $pasien->jns_klm ? 'selected' : '') : ('P' == $this->session->flashdata('jns_klm') ? 'selected' : '')) ?>>Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Tempat Lahir</label>
                                                <?php echo form_input(array('id' => 'tmp_lahir', 'name' => 'tmp_lahir', 'class' => 'form-control', 'value' => (!empty($pasien->tmp_lahir) ? $pasien->tmp_lahir : $this->session->flashdata('tmp_lahir')), 'placeholder' => 'Semarang ...')) ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Tgl Lahir *(Bulan/Tanggal/Tahun) - mm/dd/YYYY</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                    </div>
                                                    <?php echo form_input(array('id' => '', 'name' => 'tgl_lahir', 'class' => 'form-control', 'value' => (!empty($pasien->tgl_lahir) ? $pasien->tgl_lahir : $this->session->flashdata('tgl_lahir')), 'placeholder' => 'Isi dengan format berikut : 02/15/1992 ...')) ?>
                                                </div>                                        
                                            </div>
                                        </section>
                                    </div>
                                    <div class="col-md-6">
                                        <section id="pasien_baru2">
                                            <div class="form-group <?php echo (!empty($hasError['nik']) ? 'has-error' : '') ?>">
                                                <label class="control-label">Alamat <small><i>* Sesuai Identitas</i></small></label>
                                                <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control', 'value' => (!empty($pasien->alamat) ? $pasien->alamat : $this->session->flashdata('alamat')), 'style' => 'height: 210px;', 'placeholder' => 'Mohon diisi alamat lengkap ...')) ?>
                                            </div>

                                            <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                                <label class="control-label">No. HP</label>
                                                <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control', 'value' => (!empty($pasien->no_hp) ? $pasien->no_hp : $this->session->flashdata('no_hp')), 'placeholder' => 'Nomor kontak pasien / keluarga pasien ...')) ?>
                                            </div>

                                            <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                                <label class="control-label">Pekerjaan</label>
                                                <select name="pekerjaan" class="form-control select2bs4">
                                                    <option value="">- Pilih -</option>
                                                    <?php foreach ($kerja as $kerja) { ?>
                                                        <option value="<?php echo $kerja->id ?>" <?php echo (!empty($pasien->id_pekerjaan) ? ($kerja->id == $pasien->id_pekerjaan ? 'selected' : '') : (($kerja->id == $this->session->flashdata('pekerjaan') ? 'selected' : ''))) ?>><?php echo $kerja->jenis ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group <?php echo (!empty($hasError['poli']) ? 'text-danger' : '') ?>">
                                            <label class="control-label">Poli</label>
                                            <select id="poli" name="poli" class="form-control select2bs4 <?php echo (!empty($hasError['poli']) ? ' is-invalid' : '') ?>">
                                                <option value="">- Poli -</option>
                                                <?php foreach ($poli as $poli) { ?>
                                                    <option value="<?php echo $poli->id ?>" <?php echo (!empty($pasien->id_pekerjaan) ? ($poli->id == $pasien->id_poli ? 'selected' : '') : (($poli->id == $this->session->flashdata('poli') ? 'selected' : ''))) ?>><?php echo $poli->lokasi ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['dokter']) ? 'text-danger' : '') ?>">
                                            <label class="control-label">Dokter</label>
                                            <select id="dokter" name="dokter" class="form-control select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                                <option value="">- Dokter -</option>
                                                <?php foreach ($sql_doc as $doctor) { ?>
                                                    <option value="<?php echo $doctor->id ?>" <?php echo (!empty($pasien->id_dokter) ? ($doctor->id == $pasien->id_dokter ? 'selected' : '') : (($doctor->id == $this->session->flashdata('dokter') ? 'selected' : ''))) ?>><?php echo strtoupper($doctor->nama) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['alergi']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Alergi Obat ?</label>
                                            <?php echo form_input(array('id' => 'alergi', 'name' => 'alergi', 'class' => 'form-control', 'value' => $this->session->flashdata('alergi'), 'placeholder' => 'Ada alergi obat ...')) ?>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['jns_klm']) ? 'text-danger' : '') ?>">
                                            <label class="control-label">Tgl Periksa*</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                </div>
                                                <?php echo form_input(array('id' => 'tgl_masuk', 'name' => 'tgl_masuk', 'class' => 'form-control pull-right', 'placeholder' => 'Silahkan isi tgl periksa ...', 'value' => date('m/d/Y'))) ?>
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
                                        <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-user-plus"></i> Daftar</button>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>
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
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!-- Page script -->
<script type="text/javascript">
                                    // seleksi elemen video
                                    var video = document.querySelector("#kamera");
                                    var gambar = document.querySelector("#gambar");

                                    gambar.style.display = 'none';


                                    function takeSnapshot() {
                                        // buat elemen img
                                        var img = document.getElementById('gambar');
                                        var nama = document.getElementById('file');
                                        var context;

                                        // ambil ukuran video
                                        var width = video.offsetWidth
                                                , height = video.offsetHeight;

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
                                    }

//    $("#pas_baru").prop("checked", true);

                                    // data poli   
                                    $('.select2bs4').select2({
                                        theme: 'bootstrap4'
                                    });
//    $('#dokter').select2();

//                                    $("#pas_lama").click(function () {
//                                        $("#pasien_baru").hide();
//                                        $("#foto_pasien").hide();
//                                        $("#nik_baru").hide();
//                                        $("#nik_lama").show();
//                                    });
//
//                                    $("#pas_baru").click(function () {
//                                        $("#pasien_baru").show();
//                                        $("#foto_pasien").show();
//                                        $("#nik_lama").hide();
//                                        $("#nik_baru").show();
//                                    });

                                    $("#tgl_lahir").datepicker({
                                        format: 'dd/mm/yyyy',
                                        changeMonth: true,
                                        changeYear: true,
                                        yearRange: '1920:<?php echo date('Y') ?>',
                                        autoclose: true
                                    });

                                    var dateToday = new Date();
                                    $("#tgl_masuk").datepicker({
                                        format: 'dd/mm/yyyy',
                                        //defaultDate: "+1w",
                                        SetDate: new Date(),
                                        changeMonth: true,
                                        minDate: dateToday,
                                        autoclose: true
                                    });



                                    $(function () {

<?php if ($_GET['tipe_pas'] == '1') { ?>
                                            $("#pasien_baru").hide();
                                            $("#foto_pasien").show();
                                            $("#nik_baru").hide();
                                            $("#nik_lama").show();
<?php } elseif ($_GET['tipe_pas'] == '2') { ?>
                                            $("#pasien_baru").show();
                                            $("#foto_pasien").show();
                                            $("#nik_lama").hide();
                                            $("#nik_baru").show();
<?php } else { ?>
                                            $("#nik_lama").hide();
                                            $("#nik_baru").show();
<?php } ?>

                                        $('#tgl_lahir').datepicker({
                                            format: 'dd/mm/yyyy',
                                            autoclose: true
                                        });

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
                                            alert("Untuk mengambil foto pasien, silahkan ijinkan akses kamera pada browser ini. Terimakasih")
                                        }

                                        // Data Pasien
                                        $('#nik_lama').autocomplete({
                                            source: function (request, response) {
                                                $.ajax({
                                                    url: "<?php echo base_url('medcheck/json_pasien.php') ?>",
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
                                                $itemrow.find('#id_pasien').val(ui.item.id);
                                                $('#id_pasien').val(ui.item.id);
                                                $('#nik').val(ui.item.nik);
                                                var input_id = $('input[name=tipe_pas]').val();

                                                // Give focus to the next input field to recieve input from user
                                                $('#nik').focus();

                                                window.location.href = "<?php echo base_url('medcheck/daftar.php?tipe_pas=' . $this->input->get('tipe_pas') . '&id_pasien=') ?>" + ui.item.id_pas + "&tipe=" + input_id;
                                                return false;
                                            }

                                            // Format the list menu output of the autocomplete
                                        }).data("ui-autocomplete")._renderItem = function (ul, item) {
                                            return $("<li></li>")
                                                    .data("item.autocomplete", item)
                                                    .append("<a>" + item.nik + "</a> <a>(" + item.jns_klm + ")</a></br><a>" + item.nama + "</a></br><a>" + item.alamat + "<br/>--------------------------------------------------------------</a>")
                                                    .appendTo(ul);
                                        };
                                    });
</script>