<?php echo form_open_multipart(base_url('medcheck/set_medcheck_lab_ekg_upload.php'), [
    'id' => 'uploadForm',
    'autocomplete' => 'off',
    'enctype' => 'multipart/form-data'
]); ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_lab_ekg', $this->input->get('id_lab')); // general::enkrip($sql_medc_lab_ekg_rw->id)); ?>
<?php echo form_hidden('id_analis', (!empty($sql_medc_lab_ekg_rw->id_analis) ? general::enkrip($sql_medc_lab_ekg_rw->id_analis) : general::enkrip($this->ion_auth->user()->row()->id))); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>
<?php echo form_hidden('act', $this->input->get('act')); ?>

<!--Default box-->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">[EKG] INSTALASI LABORATORIUM - <?php echo $sql_pasien->nama_pgl; ?>
            <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <?php $hasError = $this->session->flashdata('form_error'); ?>

                <div class="form-group row <?php echo (!empty($hasError['judul']) ? 'text-danger' : '') ?>">
                    <label for="label" class="col-sm-3 col-form-label">Judul*</label>
                    <div class="col-sm-9">
                        <?php echo form_input(array(
                            'id' => 'judul',
                            'name' => 'judul',
                            'class' => 'form-control rounded-0' . (!empty($hasError['judul']) ? ' is-invalid' : ''),
                            'placeholder' => 'Isikan Judul ...',
                            'required' => 'required'
                        )) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="fileInput" class="col-sm-3 col-form-label">File*</label>
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
                                   accept=".jpg,.png,.pdf,.jpeg,.jfif"
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
                        <small class="text-muted">* File yang diijinkan: jpg|png|pdf|jpeg|jfif (Maks. 2MB)</small>
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
    <!--/.card-body-->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat"
                    onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/tambah.php?act=pen_ekg&id=' . $this->input->get('id') . '&status=' . $this->input->get('status')) ?>'"><i
                        class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>

<!--Default box-->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">[EKG] INSTALASI LABORATORIUM - LAMPIRAN</h3>
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
                        <?php foreach ($sql_medc_ekg_file as $rad_hasil) { ?>
                            <?php
                            $sql_medc = $this->db->where('id', $rad_hasil->id_medcheck)->get('tbl_trans_medcheck')->row();
                            $sql_pasien = $this->db->where('id', $sql_medc->id_pasien)->get('tbl_m_pasien')->row();
                            $no_rm = strtolower($sql_pasien->kode_dpn) . $sql_pasien->kode;
                            $file = (!empty($rad_hasil->file_name) ? realpath('./file/pasien/' . $no_rm . '/' . $rad_hasil->file_name) : '');
                            $foto = (file_exists($file) ? base_url('/file/pasien/' . $no_rm . '/' . $rad_hasil->file_name) : $sql_pasien->file_base64);
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
                                    <?php echo anchor(base_url('medcheck/cart_medcheck_lab_file_ekg_hapus.php?act=' . $this->input->get('act') . '&id=' . $this->input->get('id') . '&id_lab=' . $this->input->get('id_lab') . '&status=' . $this->input->get('status') . '&file_id=' . general::enkrip($rad_hasil->id)), '<i class="fas fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $rad_hasil->judul . '] ?\')" style="width: 65px;"') ?>
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

<!-- Dropzone CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">

<!-- Dropzone JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(document).ready(function() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    let selectedFile = null;

    // Modify click handler to prevent infinite loop
    dropZone.addEventListener('click', function(e) {
        // Stop if clicking the close button
        if (e.target.classList.contains('drop-zone__thumb-close')) {
            e.stopPropagation();
            clearFile();
            return;
        }

        // Stop if clicking the thumb info
        if (e.target.classList.contains('drop-zone__thumb-info')) {
            e.stopPropagation();
            return;
        }

        // Trigger file input click
        fileInput.click();
    });

    // File input change handler
    fileInput.addEventListener('change', function() {
        if (this.files.length) {
            handleFiles(this.files);
        }
    });

    // Drag and drop handlers
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('drop-zone--over');
    });

    ['dragleave', 'dragend'].forEach(type => {
        dropZone.addEventListener(type, function() {
            this.classList.remove('drop-zone--over');
        });
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('drop-zone--over');

        if (e.dataTransfer.files.length) {
            handleFiles(e.dataTransfer.files);
        }
    });

    // Form submission handler
    $('#uploadForm').on('submit', function(e) {
        e.preventDefault();
        if (validateForm()) {
            uploadFileWithForm();
        }
    });
});

// Rest of your functions remain the same
function handleFiles(files) {
    if (files.length > 0) {
        const file = files[0];
        
        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'application/pdf', 'image/jfif'];
        if (!validTypes.includes(file.type)) {
            showError('Tipe file tidak diizinkan. Gunakan format: jpg, png, pdf, jpeg, atau jfif');
            selectedFile = null;
            clearFile();
            return;
        }

        // Validate file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            showError('Ukuran file terlalu besar. Maksimal 5MB');
            selectedFile = null;
            clearFile();
            return;
        }

        selectedFile = file;
        updateThumbnail(file);
    }
}

function clearFile() {
    selectedFile = null;
    const fileInput = document.getElementById('fileInput');
    const thumbElement = document.getElementById('dropZoneThumb');
    const promptElement = document.querySelector('.drop-zone__prompt');
    
    fileInput.value = '';
    thumbElement.style.display = 'none';
    thumbElement.style.backgroundImage = '';
    thumbElement.innerHTML = '';
    promptElement.style.display = 'flex';
    document.querySelector('.upload-status').style.display = 'none';
}

function updateThumbnail(file) {
    const thumbElement = document.getElementById('dropZoneThumb');
    const promptElement = document.querySelector('.drop-zone__prompt');

    // First time - hide the prompt
    promptElement.style.display = 'none';
    thumbElement.style.display = 'block';

    // Update the thumbnail info
    thumbElement.querySelector(".drop-zone__thumb-info").textContent = 
        `${file.name} (${(file.size / (1024 * 1024)).toFixed(2)} MB)`;

    // Show thumbnail for images
    if (file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
            thumbElement.style.backgroundImage = `url('${reader.result}')`;
        };
    } else {
        thumbElement.style.backgroundImage = null;
    }
}

function uploadFileWithForm() {
    const formData = new FormData($('#uploadForm')[0]);
    
    if (selectedFile) {
        formData.set('fupload', selectedFile);
    }

    const progressBar = $('.progress-bar');
    const uploadStatus = $('.upload-status');
    const submitBtn = $('button[type="submit"]');

    submitBtn.prop('disabled', true);
    uploadStatus.show();
    progressBar.css('width', '0%').text('0%');

    $.ajax({
        url: $('#uploadForm').attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        xhr: function() {
            const xhr = new XMLHttpRequest();
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percent = Math.round((e.loaded / e.total) * 100);
                    progressBar.css('width', percent + '%').text(percent + '%');
                }
            });
            return xhr;
        },
        success: function(response) {
            submitBtn.prop('disabled', false);
            try {
                toastr.success('File berhasil diupload');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } catch (e) {
                console.error('Error processing response:', e);
                toastr.error('Terjadi kesalahan saat memproses response server');
            }
        },
        error: function(xhr, status, error) {
            submitBtn.prop('disabled', false);
            console.error('Upload error:', error);
            toastr.error('Gagal mengunggah file: ' + error);
        }
    });
}

function validateForm() {
    let isValid = true;
    
    // Validate required fields
    $('input[required], select[required], textarea[required]').each(function() {
        if (!$(this).val()) {
            isValid = false;
            $(this).addClass('is-invalid');
            toastr.error(`Field ${$(this).attr('name')} harus diisi`);
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Validate file
    if (!selectedFile) {
        isValid = false;
        $('#dropZone').addClass('drop-zone--error');
        toastr.error('Pilih file terlebih dahulu!');
        setTimeout(() => {
            $('#dropZone').removeClass('drop-zone--error');
        }, 2000);
    }

    return isValid;
}

function showError(message) {
    toastr.error(message);
    selectedFile = null;
    clearFile();
}
</script>

<style>
    .drop-zone {
        max-width: 100%;
        height: 200px;
        padding: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        font-weight: 500;
        font-size: 1.2rem;
        cursor: pointer;
        color: #777;
        border: 2px dashed #009578;
        border-radius: 10px;
        position: relative;
        transition: all 0.3s ease;
    }

    .drop-zone--over {
        border-style: solid;
        background-color: rgba(0, 158, 247, 0.1);
    }

    .drop-zone__prompt {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .drop-zone__thumb {
        width: 100%;
        height: 100%;
        border-radius: 10px;
        overflow: hidden;
        background-color: #cccccc;
        background-size: cover;
        position: relative;
    }

    .drop-zone__thumb-close {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        padding: 2px 8px;
        border-radius: 50%;
        cursor: pointer;
    }

    .drop-zone__thumb-info {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        padding: 5px;
        font-size: 14px;
    }
</style>

<!-- Configure Toastr -->
<script>
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};
</script>