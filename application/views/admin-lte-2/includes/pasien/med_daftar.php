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
                            <?php if (isset($_GET['tipe_pas'])) { ?>
                                <button type="button" onclick="takeSnapshot()" class="btn btn-primary btn-flat btn-block"><i class="fa fa-camera"></i> Ambil Gambar</button>
                            <?php } ?>
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
                            <?php if (isset($_GET['tipe_pas'])) { ?>
                                <button type="button" onclick="takeSnapshot_id()" class="btn btn-primary btn-flat btn-block"><i class="fa fa-camera"></i> Ambil Gambar</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <?php echo form_open(base_url('medcheck/daftar_' . (isset($_GET['dft']) ? 'update' : 'simpan') . '.php'), 'autocomplete="off"') ?>
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
                            <?php echo form_hidden('id_dft', general::enkrip($sql_dft_id->id)) ?>

                            <input type="hidden" id="file" name="file" value="<?php echo $pasien->file_base64 ?>">
                            <input type="hidden" id="file_id" name="file_id" value="<?php echo $pasien->file_base64_id ?>">
                            <input type="hidden" id="file" name="id_pasien" value="<?php echo $this->input->get('id_pasien') ?>">

                            <div class="row">
                                <div class="col-md-12">                                        
                                    <div class="form-group <?php echo (!empty($hasError['tipe_pas']) ? 'text-danger' : '') ?>">

                                        <?php echo form_hidden('tipe_pas', $this->input->get('tipe_pas')) ?>
                                        <?php
                                        switch ($_GET['tipe_pas']) {
                                            default:
                                                ?>
                                                <label class="control-label">Apakah Anda*</label>
                                                <br/>
                                                <a href="<?php echo base_url('medcheck/daftar.php?tipe_pas=1') ?>">
                                                    <button type="button" class="btn <?php echo ($_GET['tipe_pas'] == '1' ? 'btn-default' : 'btn-primary') ?> btn-flat" id="pas_lama">Pasien Lama</button>
                                                </a>
                                                <a href="<?php echo base_url('medcheck/daftar.php?tipe_pas=2') ?>">
                                                    <button type="button" class="btn <?php echo ($_GET['tipe_pas'] == '2' ? 'btn-default' : 'btn-primary') ?> btn-flat" id="pas_baru">Pasien Baru</button>
                                                </a>
                                                <?php
                                                break;

                                            case '1':
                                                ?>
                                                <label class="control-label">Apakah Anda*</label>
                                                <br/>
                                                <a href="<?php echo base_url('medcheck/daftar.php?tipe_pas=1') ?>">
                                                    <button type="button" class="btn <?php echo ($_GET['tipe_pas'] == '1' ? 'btn-default' : 'btn-primary') ?> btn-flat" id="pas_lama">Pasien Lama</button>
                                                </a>
                                                <a href="<?php echo base_url('medcheck/daftar.php?tipe_pas=2') ?>">
                                                    <button type="button" class="btn <?php echo ($_GET['tipe_pas'] == '2' ? 'btn-default' : 'btn-primary') ?> btn-flat" id="pas_baru">Pasien Baru</button>
                                                </a>
                                                <?php
                                                break;

                                            case '2':
                                                ?>
                                                <label class="control-label">Apakah Anda*</label>
                                                <br/>
                                                <a href="<?php echo base_url('medcheck/daftar.php?tipe_pas=1') ?>">
                                                    <button type="button" class="btn <?php echo ($_GET['tipe_pas'] == '1' ? 'btn-default' : 'btn-primary') ?> btn-flat" id="pas_lama">Pasien Lama</button>
                                                </a>
                                                <a href="<?php echo base_url('medcheck/daftar.php?tipe_pas=2') ?>">
                                                    <button type="button" class="btn <?php echo ($_GET['tipe_pas'] == '2' ? 'btn-default' : 'btn-primary') ?> btn-flat" id="pas_baru">Pasien Baru</button>
                                                </a>
                                                <?php
                                                break;

                                            case '3':

                                                break;

                                            case '4':

                                                break;
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                                switch ($_GET['tipe_pas']) {
                                    case '1':
                                        $data['hasError'] = $hasError;
                                        $this->load->view('admin-lte-3/includes/medcheck/med_daftar_pas_lama', $data);
                                        break;

                                    case '2':
                                        $data['hasError'] = $hasError;
                                        $this->load->view('admin-lte-3/includes/medcheck/med_daftar_pas_baru', $data);
                                        break;

                                    case '3':
                                        $data['hasError'] = $hasError;
                                        $this->load->view('admin-lte-3/includes/medcheck/med_daftar_pas_edit', $data);
                                        break;

                                    case '4':
                                        $data['hasError'] = $hasError;
                                        $this->load->view('admin-lte-3/includes/medcheck/med_daftar_pas_edit2', $data);
                                        break;
                                }
                                ?>
                            </div>
                            <?php
                            switch ($_GET['tipe_pas']) {
                                case '1':
                                    if (!empty($pasien)) {
                                        $this->load->view('admin-lte-3/includes/medcheck/med_daftar_poli', $data);
                                    }
                                    break;

                                case '2':
                                    $this->load->view('admin-lte-3/includes/medcheck/med_daftar_poli', $data);
                                    break;

                                case '3':
                                    $this->load->view('admin-lte-3/includes/medcheck/med_daftar_poli', $data);
                                    break;
                            }
                            ?>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">

                                </div>
                                <div class="col-lg-6 text-right">
                                    <?php if (!empty($pasien) AND empty($_GET['act'])) { ?>
                                        <a href="<?php echo base_url('medcheck/daftar.php?tipe_pas=' . $this->input->get('tipe_pas') . '&id_pasien=' . $this->input->get('id_pasien') . '&act=ubah_data') ?>">
                                            <button type="button" class="btn btn-warning btn-flat"><i class="fa fa-user-nurse"></i> Ubah</button>
                                        </a>
                                    <?php } ?>
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-user-plus"></i> Daftar</button>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <?php echo form_close() ?>
                    <!--<pre><?php print_r($sql_dft_id); ?></pre>-->
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

<style>
  .autocomplete-scroll {
    max-height: 250px;
    overflow-y: auto;
    overflow-x: hidden;
  }
</style>
<!-- Page script -->
<script type="text/javascript">
    /* Ambil gambar dari webcam */
    var video = document.querySelector("#kamera");
    var video2 = document.querySelector("#kamera_id");
    var gambar = document.querySelector("#gambar");
    var gambar2 = document.querySelector("#gambar_id");
    gambar.style.display = 'none';
    gambar2.style.display = 'none';

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

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

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

        // Autocomplete untuk pasien lama
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
        
        // Add CSS for the autocomplete scrollbar
        $("#nik_lama").autocomplete("widget").addClass("autocomplete-scroll");

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
    });
</script>