<?php echo form_open_multipart(base_url('medcheck/cart_medcheck_rad_file.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_rad', general::enkrip($sql_medc_rad_rw->id)); ?>
<?php echo form_hidden('id_item', general::enkrip($sql_medc_det_rw->id)); ?>
<?php echo form_hidden('id_produk', general::enkrip($sql_produk->id)); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>
<?php echo form_hidden('act', $this->input->get('act')); ?>

<!--Default box-->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">INSTALASI RADIOLOGI - <?php echo $sql_pasien->nama_pgl; ?>
            <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <?php $hasError = $this->session->flashdata('form_error'); ?>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Judul</label>
                    <div class="col-sm-9">
                        <?php echo form_input(array('id' => 'judul', 'name' => 'judul', 'class' => 'form-control pull-left rounded-0', 'placeholder' => 'Isikan Judul ...')) ?>
                    </div>
                </div>
                <div class="form-group row" id="tp_berkas">
                    <label for="fileInput" class="col-sm-3 col-form-label">File</label>
                    <div class="col-sm-9">
                        <div class="drop-zone" id="dropZone" role="button" tabindex="0">
                            <div class="drop-zone__prompt">
                                <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                <span>Seret dan lepas file di sini atau klik untuk mengunggah</span>
                            </div>
                            <input type="file" 
                                   name="fupload" 
                                   id="fileInput" 
                                   class="drop-zone__input" 
                                   accept=".jpg,.png,.jpeg"
                                   style="display: none;">
                            <div class="drop-zone__thumb" id="dropZoneThumb" style="display: none;">
                                <div class="drop-zone__thumb-close" title="Hapus file">&times;</div>
                                <div class="drop-zone__thumb-info"></div>
                            </div>
                        </div>
                        <input type="hidden" name="uploaded_file" id="uploaded_file_name">
                        <div class="upload-status mt-2" style="display: none;">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                            </div>
                        </div>
                        <small class="text-muted">* File yang diijinkan: jpg|png|jpeg (Maks. 5MB)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/.card-body-->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/tambah.php?act=rad_input&id=' . $this->input->get('id') . '&id_rad=' . $this->input->get('id_rad') . '&status=' . $this->input->get('status') . '&id_item=' . $this->input->get('id_item')) ?>'"><i                   class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
<!--/.card -->
<?php echo form_close(); ?>

<!--Default box-->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">LAMPIRAN RADIOLOGI</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-left">Judul</th>
                            <th class="text-left">File</th>
                            <th class="text-center">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($sql_medc_rad_file as $rad_hasil) { ?>
                            <?php
                            // Get medical check data
                            $sql_medc = $this->db->where('id', $rad_hasil->id_medcheck)
                                               ->get('tbl_trans_medcheck')
                                               ->row();
                            
                            // Get patient data
                            $sql_pasien = $this->db->where('id', $sql_medc->id_pasien)
                                                 ->get('tbl_m_pasien')
                                                 ->row();
                            
                            // Format medical record number
                            $no_rm = strtolower($sql_pasien->kode_dpn) . $sql_pasien->kode;
                            
                            // Get file path
                            $file = (!empty($rad_hasil->file_name) 
                                    ? realpath('./file/pasien/' . $no_rm . '/' . $rad_hasil->file_name) 
                                    : '');
                            
                            // Set image source
                            $foto = (file_exists($file) 
                                    ? base_url('/file/pasien/' . $no_rm . '/' . $rad_hasil->file_name) 
                                    : $sql_pasien->file_base64);
                            ?>
                            <tr>
                                <td class="text-left" style="width: 160px;">
                                    <?php echo $rad_hasil->judul; ?>
                                </td>
                                <td class="text-left" style="width: 460px;">
                                    <a href="<?php echo $foto; ?>" data-toggle="lightbox"
                                        data-title="<?php echo $rad_hasil->judul; ?>">
                                        <?php echo $rad_hasil->file_name; ?>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <?php echo anchor(base_url('medcheck/cart_medcheck_rad_file_hapus.php?act=' . $this->input->get('act') . '&id=' . $this->input->get('id') . '&id_rad=' . $this->input->get('id_rad') . '&status=' . $this->input->get('status') . '&id_item=' . $this->input->get('id_item') . '&id_produk=' . $this->input->get('id_produk') . '&file_id=' . general::enkrip($rad_hasil->id)), '<i class="fas fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $rad_hasil->item . '] ?\')" style="width: 65px;"') ?>
                                </td>
                            </tr>
                            <?php $no++; ?>
                        <?php } ?>
                        <?php if (!empty($sql_medc_lab_rw->ket)) { ?>
                            <tr>
                                <td></td>
                                <td colspan="6"><small><?php echo $sql_medc_lab_rw->ket ?></small></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--/.card -->

<!-- Ekko Lightbox -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/ekko-lightbox/ekko-lightbox.min.js') ?>"></script>
<!-- Page script -->
<script type="text/javascript">
    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox({
            alwaysShowClose: true
        });
    });
</script>

<!-- Add this in the head section or before the form -->
<style>
    .drop-zone {
        max-width: 100%;
        height: 200px;
        padding: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        cursor: pointer;
        color: #666;
        border: 2px dashed #0087F7;
        border-radius: 5px;
        background-color: #f8f9fa;
    }

    .drop-zone:hover {
        background-color: #f1f3f5;
    }

    .drop-zone__prompt {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .drop-zone__thumb {
        width: 100%;
        height: 100%;
        border-radius: 5px;
        overflow: hidden;
        position: relative;
        background-color: #cccccc;
        display: none;
    }

    .drop-zone__thumb-info {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.5);
        color: #fff;
        padding: 5px;
        font-size: 14px;
    }

    .drop-zone__thumb-close {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(0, 0, 0, 0.5);
        color: #fff;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        text-align: center;
        line-height: 18px;
        cursor: pointer;
    }

    .progress {
        height: 20px;
        margin-bottom: 10px;
    }
</style>

<script>
$(document).ready(function() {
    const dropZone = document.querySelector('.drop-zone');
    const fileInput = document.querySelector('.drop-zone__input');
    const thumbElement = document.querySelector('.drop-zone__thumb');
    const progressBar = document.querySelector('.progress-bar');
    const uploadStatus = document.querySelector('.upload-status');
    const form = $('form').first();

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    // Handle drag events
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    // Handle file drop
    dropZone.addEventListener('drop', handleDrop, false);
    
    // Handle click to upload
    dropZone.addEventListener('click', () => fileInput.click());

    // Handle file selection
    fileInput.addEventListener('change', (e) => handleFiles(e.target.files));

    // Handle file removal
    $('.drop-zone__thumb-close').click(function(e) {
        e.stopPropagation();
        removeFile();
    });

    // Handle form submission
    form.on('submit', function(e) {
        e.preventDefault();
        
        const judul = $('#judul').val();
        if (!judul) {
            toastr.error('Judul harus diisi');
            return;
        }

        if (!fileInput.files.length) {
            toastr.error('Pilih file terlebih dahulu');
            return;
        }

        const formData = new FormData(this);
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                const xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        const percent = (e.loaded / e.total) * 100;
                        updateProgress(percent);
                    }
                }, false);
                return xhr;
            },
            beforeSend: function() {
                uploadStatus.style.display = 'block';
                progressBar.style.width = '0%';
                $('.btn-primary').prop('disabled', true);
            },
            success: function(response) {
                try {
                    const result = typeof response === 'string' ? JSON.parse(response) : response;
                    if (result.success) {
                        toastr.success(result.message);
                        setTimeout(() => window.location.reload(), 1500);
                    } else {
                        toastr.error(result.message || 'Upload failed');
                    }
                } catch (e) {
                    toastr.error('Invalid server response');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('Error: ' + (error || 'Upload failed'));
            },
            complete: function() {
                $('.btn-primary').prop('disabled', false);
            }
        });
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight(e) {
        dropZone.classList.add('bg-light');
    }

    function unhighlight(e) {
        dropZone.classList.remove('bg-light');
    }

    function handleDrop(e) {
        const dt = e.dataTransfer;
        handleFiles(dt.files);
    }

    function handleFiles(files) {
        if (files.length) {
            const file = files[0];
            
            // Validate file type
            const validTypes = ['image/jpeg', 'image/png'];
            if (!validTypes.includes(file.type)) {
                toastr.error('Tipe file tidak diizinkan. Gunakan jpg atau png.');
                removeFile();
                return;
            }

            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                toastr.error('Ukuran file terlalu besar. Maksimal 5MB.');
                removeFile();
                return;
            }

            updateThumbnail(file);
        }
    }

    function updateThumbnail(file) {
        thumbElement.style.display = 'block';
        dropZone.querySelector('.drop-zone__prompt').style.display = 'none';

        // Show file info
        thumbElement.querySelector('.drop-zone__thumb-info').textContent = 
            `${file.name} (${formatFileSize(file.size)})`;

        // Show preview if it's an image
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                thumbElement.style.backgroundImage = `url('${reader.result}')`;
                thumbElement.style.backgroundSize = 'contain';
                thumbElement.style.backgroundPosition = 'center';
                thumbElement.style.backgroundRepeat = 'no-repeat';
            };
        }
    }

    function removeFile() {
        fileInput.value = '';
        thumbElement.style.display = 'none';
        dropZone.querySelector('.drop-zone__prompt').style.display = 'flex';
        thumbElement.style.backgroundImage = '';
        uploadStatus.style.display = 'none';
    }

    function updateProgress(percent) {
        progressBar.style.width = percent + '%';
        progressBar.setAttribute('aria-valuenow', percent);
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
});
</script>