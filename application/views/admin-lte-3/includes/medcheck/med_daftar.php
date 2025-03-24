<?php 
$txt_pasien = explode(' ', $pasien->nama);
$nm         = strtolower(str_replace(array(' ','\'','-'),'', $pasien->nama));
$nm_file    = strtolower($pasien->nik).(!empty($pasien->nama) ? '_'.$nm : '');
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
                                <?php if (isset($_GET['id_pasien']) OR $_GET['tipe_pas'] == '2' OR $_GET['tipe_pas'] == '3') { ?>
                                    <button type="button" onclick="takeSnapshot()" class="btn btn-primary btn-flat btn-block"><i class="fa fa-camera"></i> Ambil Gambar</button>                                
                                    <button id="flip-btn" type="button" class="btn btn-primary btn-flat btn-block"><i class="fa fa-camera-rotate"></i> Pindah Kamera</button>
                                <?php } ?>
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
                                <?php if (isset($_GET['id_pasien']) OR $_GET['tipe_pas'] == '2' OR $_GET['tipe_pas'] == '3') { ?>
                                    <button type="button" onclick="takeSnapshot_id()" class="btn btn-primary btn-flat btn-block"><i class="fa fa-camera"></i> Ambil Gambar</button>
                                    <button id="flip-btn2" type="button" class="btn btn-primary btn-flat btn-block"><i class="fa fa-camera-rotate"></i> Pindah Kamera</button>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if (!empty($pasien)) { ?>
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Foto Pasien</h3>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <?php
                                    $file = (!empty($pasien->file_name) ? realpath($pasien->file_name) : '');
                                    $foto = (file_exists($file) ? base_url($pasien->file_name) : $pasien->file_base64);
                                    ?>                                
                                    <img class="img-thumbnail img-fluid img-lg" src="<?php echo (!empty($foto) ? $foto : base_url('assets/theme/admin-lte-3/icon_putra.png')) ?>" alt="User profile picture" style="width: 215px; height: 215px;">
                                </div>
                            </div>
                        </div>
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Foto Identitas</h3>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <div class="text-center">
                                    <?php
                                    $file = (!empty($pasien->file_name_id) ? realpath($pasien->file_name_id) : '');
                                    $foto = (file_exists($file) ? base_url($pasien->file_name_id) : '');
                                    ?>                               
                                    <img class="img-thumbnail img-fluid img-lg" src="<?php echo (!empty($foto) ? $foto : base_url('assets/theme/admin-lte-3/icon_putra.png')) ?>" alt="User profile picture" style="width: 256px; height: 192px;">
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-md-9">
                    <?php echo form_open(base_url('medcheck/daftar_' . (isset($_GET['dft']) ? 'update' : 'simpan') . '.php'), array('autocomplete' => 'off', 'id' => 'daftar_form')) ?>
                    <?php echo add_form_protection(); ?>
                    <div class="card card-default rounded-0">
                        <div class="card-header">
                            <h3 class="card-title">Form Pendaftaran Pasien</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php echo $this->session->flashdata('master'); ?>
                            <?php $hasError = $this->session->flashdata('form_error'); ?>
                            <?php echo form_hidden('id', general::enkrip($pasien->id)) ?>
                            <?php echo form_hidden('id_dft', general::enkrip($sql_dft_id->id)) ?>
                            <?php echo form_hidden('id_ant', $this->input->get('id_ant')) ?>
                            <?php echo form_hidden('antrian', $this->input->get('antrian')) ?>

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
                                                <a href="<?php echo base_url('medcheck/daftar.php?tipe_pas=1' . (!empty($this->input->get('id')) ? '&id_ant=' . $this->input->get('id') : '') . (!empty($this->input->get('antrian')) ? '&antrian=' . $this->input->get('antrian') : '')) ?>">
                                                    <button type="button" class="btn <?php echo ($_GET['tipe_pas'] == '1' ? 'btn-default' : 'btn-primary') ?> btn-flat" id="pas_lama">Pasien Lama</button>
                                                </a>
                                                <a href="<?php echo base_url('medcheck/daftar.php?tipe_pas=2' . (!empty($this->input->get('id')) ? '&id_ant=' . $this->input->get('id') : '') . (!empty($this->input->get('antrian')) ? '&antrian=' . $this->input->get('antrian') : '')) ?>">
                                                    <button type="button" class="btn <?php echo ($_GET['tipe_pas'] == '2' ? 'btn-default' : 'btn-primary') ?> btn-flat" id="pas_baru">Pasien Baru</button>
                                                </a>
                                                <?php
                                                break;

                                            case '1':
                                                ?>
                                                <label class="control-label">Apakah Anda*</label>
                                                <br/>
                                                <a href="<?php echo base_url('medcheck/daftar.php?tipe_pas=1' . (!empty($this->input->get('id_ant')) ? '&id_ant=' . $this->input->get('id_ant') : '') . (!empty($this->input->get('antrian')) ? '&antrian=' . $this->input->get('antrian') : '')) ?>">
                                                    <button type="button" class="btn <?php echo ($_GET['tipe_pas'] == '1' ? 'btn-default' : 'btn-primary') ?> btn-flat" id="pas_lama">Pasien Lama</button>
                                                </a>
                                                <a href="<?php echo base_url('medcheck/daftar.php?tipe_pas=2' . (!empty($this->input->get('id_ant')) ? '&id_ant=' . $this->input->get('id_ant') : '') . (!empty($this->input->get('antrian')) ? '&antrian=' . $this->input->get('antrian') : '')) ?>">
                                                    <button type="button" class="btn <?php echo ($_GET['tipe_pas'] == '2' ? 'btn-default' : 'btn-primary') ?> btn-flat" id="pas_baru">Pasien Baru</button>
                                                </a>
                                                <?php
                                                break;

                                            case '2':
                                                ?>
                                                <label class="control-label">Apakah Anda*</label>
                                                <br/>
                                                <a href="<?php echo base_url('medcheck/daftar.php?tipe_pas=1' . (!empty($this->input->get('id_ant')) ? '&id_ant=' . $this->input->get('id_ant') : '') . (!empty($this->input->get('antrian')) ? '&antrian=' . $this->input->get('antrian') : '')) ?>">
                                                    <button type="button" class="btn <?php echo ($_GET['tipe_pas'] == '1' ? 'btn-default' : 'btn-primary') ?> btn-flat" id="pas_lama">Pasien Lama</button>
                                                </a>
                                                <a href="<?php echo base_url('medcheck/daftar.php?tipe_pas=2' . (!empty($this->input->get('id_ant')) ? '&id_ant=' . $this->input->get('id_ant') : '') . (!empty($this->input->get('antrian')) ? '&antrian=' . $this->input->get('antrian') : '')) ?>">
                                                    <button type="button" class="btn <?php echo ($_GET['tipe_pas'] == '2' ? 'btn-default' : 'btn-primary') ?> btn-flat" id="pas_baru">Pasien Baru</button>
                                                </a>
                                                <?php
                                                break;

                                            case '3':
                                                
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
                                    <?php if (isset($_GET['tipe_pas']) && $_GET['tipe_pas'] == '3'): ?>
                                        <a href="<?php echo base_url('medcheck/data_pendaftaran.php?filter_tgl=' . date('Y-m-d')); ?>" class="btn btn-primary btn-flat rounded-0">
                                            <i class="fas fa-arrow-left"></i> Kembali
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-user-plus"></i> Daftar</button>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    
                    <?php echo add_double_submit_protection('daftar_form'); ?>
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

<!-- Add the Modal HTML at the bottom of the file -->
<div class="modal fade" id="modalTambahKlinik">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h4 class="modal-title">Form Instansi / Perusahaan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label">Instansi / Perusahaan</label>
                    <?php echo form_input('instansi', '', 'id="instansi" class="form-control rounded-0" placeholder="Masukkan nama"'); ?>
                </div>
                <div class="form-group">
                    <label class="control-label">Alamat</label>
                    <?php echo form_input('instansi_almt', '', 'id="instansi_almt" class="form-control rounded-0" placeholder="Masukkan alamat"'); ?>
                </div>
                <div class="form-group">
                    <label class="control-label">CP</label>
                    <?php echo form_input('instansi_cp', '', 'id="instansi_cp" class="form-control rounded-0" placeholder="Masukkan CP"'); ?>
                </div>
                <div class="form-group">
                    <label class="control-label">No. HP</label>
                    <?php echo form_input('instansi_no_hp', '', 'id="instansi_no_hp" class="form-control rounded-0" placeholder="Masukkan nomor HP"'); ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary rounded-0" onclick="submitForm()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!--Phone Masking-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<style>
    .autocomplete-scroll {
        max-height: 250px;
        overflow-y: auto;
        overflow-x: hidden;
    }
</style>
<!-- Page script -->
<script type="text/javascript">
<?php if (isset($_GET['tipe_pas'])) { ?>
    <?php if (isset($_GET['id_pasien']) OR $_GET['tipe_pas'] == '2' OR $_GET['tipe_pas'] == '3') { ?>
        /* Ambil gambar dari webcam */
        // minta izin user
        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

        var video               = document.querySelector("#kamera");
        var video2              = document.querySelector("#kamera_id");
        var gambar              = document.querySelector("#gambar");
        var gambar2             = document.querySelector("#gambar_id");
        gambar.style.display    = 'none';
        gambar2.style.display   = 'none';


        let on_stream_video     = document.querySelector('#kamera');
        let on_stream_video2    = document.querySelector('#kamera_id');
        // default user media options
        let constraints         = { audio: false, video: true }
        let shouldFaceUser      = true;
        let flipBtn             = document.querySelector('#flip-btn');
        let flipBtn2            = document.querySelector('#flip-btn2');

        // check whether we can use facingMode
        let supports = navigator.mediaDevices.getSupportedConstraints();
        if( supports['facingMode'] === true ) {
            flipBtn.disabled = false;
        }

        let stream  = null;
        let stream2 = null;

        function capture() {
            constraints.video = {
              facingMode: shouldFaceUser ? 'user' : 'environment'
            }
            navigator.mediaDevices.getUserMedia(constraints)
              .then(function(mediaStream) {
                stream  = mediaStream;
                on_stream_video.srcObject = stream;
                on_stream_video.play();
              })
              .catch(function(err) {
                console.log(err)
              });
        }

        function capture_id() {
            constraints.video = {
              facingMode: shouldFaceUser ? 'user' : 'environment'
            }
            navigator.mediaDevices.getUserMedia(constraints)
              .then(function(mediaStream) {
                stream2  = mediaStream;
                on_stream_video2.srcObject = stream2;
                on_stream_video2.play();
              })
              .catch(function(err) {
                console.log(err)
              });
        }

        flipBtn.addEventListener('click', function(){
          if( stream == null ) return
            // we need to flip, stop everything
            stream.getTracks().forEach(t => {
            t.stop();
          });
            // toggle / flip
            shouldFaceUser = !shouldFaceUser;
            capture();
        });

        flipBtn2.addEventListener('click', function(){
          if( stream2 == null ) return
            // we need to flip, stop everything
            stream2.getTracks().forEach(t => {
            t.stop();
          });
            // toggle / flip
            shouldFaceUser = !shouldFaceUser;
            capture_id();
        });

        capture();
        capture_id();

        function takeSnapshot() {
            var img     = document.getElementById('gambar');
            var nama    = document.getElementById('file');
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
    <?php } ?>
<?php } ?>

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
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: '1920:<?php echo date('Y') ?>',
            autoclose: true
        });

        var dateToday = new Date();
        $("#tgl_masuk").datepicker({
            dateFormat: 'dd-mm-yy',
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

                window.location.href = "<?php echo base_url('medcheck/daftar.php?tipe_pas=' . $this->input->get('tipe_pas') . '&id_ant='.$this->input->get('id_ant').'&id_pasien=') ?>" + ui.item.id_pas + "&tipe=" + input_id;
                return false;
            }

            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.nik + "</a> <a>(" + item.jns_klm + ")</a></br><a>" + item.nama + "</a></br><a>" + item.alamat + "<br/>--------------------------------------------------------------</a>")
                    .appendTo(ul);
        };

        $("#no_hp").keydown(function (e) {
            // kibot: backspace, delete, tab, escape, enter .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                    // kibot: Ctrl+A, Command+A
                            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // kibot: home, end, left, right, down, up
                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // Biarin wae, ga ngapa2in return false
                        return;
                    }

                    // Cuman nomor
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });

        $('#no_rmh').mask('(000) 0000000');

        // Add CSS for the autocomplete scrollbar
        $("#nik_lama").autocomplete("widget").addClass("autocomplete-scroll");
        
        // Pilih poli
        $("#poli").change(function () {
            var id_poli = $(this).val();

            $.ajax({
                type: "GET",
                dataType: "html",
                url: "<?php echo base_url('medcheck/data_dokter.php?') ?>",
                data: "id_poli=" + id_poli,
                success: function (msg) {
                    $("select#dokter").html(msg);
                }
            });
        });

        <?php echo $this->session->flashdata('medcheck_toast'); ?>
        <?php echo $this->session->flashdata('medcheck_file_toast'); ?>
        <?php echo $this->session->flashdata('medcheck_file_id_toast'); ?>
    });

    function submitForm() {
        var formData = {
            nama: $('#instansi').val(),
            alamat: $('#instansi_almt').val(),
            no_hp: $('#instansi_no_hp').val(),
            cp: $('#instansi_cp').val(),
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        };

        $.ajax({
            url: '<?php echo base_url('medcheck/set_instansi'); ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    toastr.success('Data klinik berhasil disimpan');
                    $('#modalTambahKlinik').modal('hide');
                    location.reload();
                } else {
                    toastr.error(response.message || 'Gagal menyimpan data');
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                toastr.error('Terjadi kesalahan sistem');
            }
        });
    }
</script>