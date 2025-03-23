<?php $hasError = $this->session->flashdata('form_error'); ?>
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
                        <li class="breadcrumb-item active">Unggah Berkas</li>
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
                <div class="col-lg-8">
                    <?php echo form_open_multipart(base_url('medcheck/set_medcheck_upload.php'), 'autocomplete="off"') ?>
                    <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                    <?php echo form_hidden('status', '8'); ?>
                    <?php echo form_hidden('status_file', (isset($_GET['name']) ? '3' : '1')); ?>
                    <?php echo form_hidden('route', (isset($_GET['route']) ? $_GET['route'] : '')); ?>
                    
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">BERKAS - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group row <?php echo (!empty($hasError['judul']) ? 'text-danger' : '') ?>">
                                        <label for="label" class="col-sm-4 col-form-label">Nama Berkas*</label>
                                        <div class="col-sm-8">
                                            <?php echo form_input(array('id' => 'judul', 'name' => 'judul', 'class' => 'form-control rounded-0' . (!empty($hasError['judul']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Judul Berkas ...', 'value'=>(isset($_GET['name']) ? $_GET['name'] : ''))) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row <?php echo (!empty($hasError['keterangan']) ? 'text-danger' : '') ?>">
                                        <label for="label" class="col-sm-4 col-form-label">Keterangan</label>
                                        <div class="col-sm-8">
                                            <?php echo form_textarea(array('id' => 'ket', 'name' => 'ket', 'class' => 'form-control rounded-0', 'style' => 'height: 183px;', 'placeholder' => 'Isikan Keterangan ...')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row <?php echo (!empty($hasError['tipe']) ? 'text-danger' : '') ?>">
                                        <label for="label" class="col-sm-4 col-form-label">Tipe</label>
                                        <div class="col-sm-8">
                                            <?php echo form_radio(array('id'=>'tipe_fl', 'name'=>'tipe_ft', 'class' => (!empty($hasError['tipe']) ? 'is-invalid' : ''), 'value'=>'1', 'checked'=>'TRUE')) ?> File Berkas
                                            <?php echo nbs(2) ?>
                                            <?php echo form_radio(array('id'=>'tipe_ft', 'name'=>'tipe_ft', 'class' => (!empty($hasError['tipe']) ? 'is-invalid' : ''), 'value'=>'2')) ?> Kamera
                                        </div>
                                    </div>
                                    <div class="form-group row" id="tp_berkas">
                                        <label for="label" class="col-sm-4 col-form-label">Unggah Berkas*</label>
                                        <div class="col-sm-8">
                                            <?php echo form_upload(array('name' => 'fupload', 'class' => 'form-control' . (!empty($hasError['fupload']) ? ' is-invalid' : ''))) ?>
                                            <i>* File yang diijinkan : jpg|png|pdf|jpeg|jfif</i>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="tp_foto">
                                        <label for="label" class="col-sm-4 col-form-label">Foto Berkas*</label>
                                        <div class="col-sm-8">
                                            <input type="hidden" id="file_foto" name="file_foto">
                                            <section id="foto_pasien">
                                                <video autoplay="true" id="kamera" class="img-fluid">
                                                    Silahkan perbarui peramban anda !!
                                                </video>
                                                <img id="gambar" class="p-0">
                                            </section>
                                            <button type="button" onclick="takeSnapshot()" class="btn btn-primary btn-flat btn-block"><i class="fa fa-camera"></i> Ambil Gambar</button>
                                            <i>* File yang diijinkan : jpg|png|pdf|jpeg|jfif</i>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <?php echo $this->session->flashdata('medcheck') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>                         
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <a class="btn btn-primary btn-flat" href="<?php echo base_url((isset($_GET['route']) ? $this->input->get('route') : 'medcheck/tindakan.php').'?id=' . general::enkrip($sql_medc->id)) ?>">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                    
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">DATA BERKAS</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-left">Tgl Masuk</th>
                                                <th class="text-left">Nama Berkas</th>
                                                <th class="text-left">Keterangan</th>
                                                <th class="text-center">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            <?php foreach ($sql_medc_file as $file) { ?>
                                            <?php $no_rm       = strtolower($sql_pasien->kode_dpn).$sql_pasien->kode; ?>
                                            <?php $berkas      = realpath('.'.$file->file_name); ?>
                                            <?php $is_image    = substr($file->file_type, 0, 5); ?>
                                            <?php $filename    = base_url($file->file_name); ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no; ?></td>
                                                    <td class="text-left"><?php echo $this->tanggalan->tgl_indo5($file->tgl_masuk); ?></td>
                                                    <td class="text-left">
                                                        <?php if($is_image == 'image'){ ?>
                                                            <a href="<?php echo $filename ?>" data-toggle="lightbox" data-title="<?php echo strtolower($file->judul.' - '.$sql_pasien->nama_pgl) ?>">
                                                                <i class="fas fa-paperclip"></i> <?php echo $file->judul ?>
                                                            </a>
                                                        <?php }else{ ?>
                                                            <a href="<?php echo $filename ?>" target="_blank">
                                                                <i class="fas fa-paperclip"></i> <?php echo $file->judul ?>
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-left"><?php echo $file->keterangan; ?></td>
                                                    <td class="text-left">
                                                        <?php echo anchor(base_url('medcheck/file/file_hapus.php?id=' . general::enkrip($file->id_medcheck) . '&item_id=' . general::enkrip($file->id) . '&file=' . $file->file_name . '&status=' . $this->input->get('status')), '<i class="fa fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $file->judul . '] ?\')"') ?>
                                                    </td>
                                                </tr>
                                                <?php $no++; ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <?php $data['gtotal'] = $gtotal ?>
                    <?php $this->load->view('admin-lte-3/includes/medcheck/med_tindakan_kanan', $data) ?>
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
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

<!-- Ekko Lightbox -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/ekko-lightbox/ekko-lightbox.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
    /* Ambil gambar dari webcam */
    var video = document.querySelector("#kamera");
    var gambar = document.querySelector("#gambar");
    gambar.style.display = 'none';

    function takeSnapshot() {
        var img = document.getElementById('gambar');
        var nama = document.getElementById('file_foto');
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
    
    $(function () {
        // Module pilih kamera atau berkas
        $('#tp_berkas').show();
        $('#tp_foto').hide();
        
        // Tampilkan dari sumber unggah
        $('#tipe_fl').click(function() {
            $('#tp_berkas').show();
            $('#tp_foto').hide();
        });
        
        // Tampilkan dari sumber kamera webcam
        $('#tipe_ft').click(function() {
            $('#tp_berkas').hide();
            $('#tp_foto').show();
        });
        
        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
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
//            alert("Untuk mengambil foto pasien, silahkan ijinkan akses kamera pada browser ini. Terimakasih")
        }
    });
</script>