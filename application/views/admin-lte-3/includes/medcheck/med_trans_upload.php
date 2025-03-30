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
                    <?php echo form_open_multipart(base_url('medcheck/set_medcheck_upload'), 'id="uploadForm" autocomplete="off"') ?>
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
                                    <div class="form-group row" id="tp_berkas">
                                        <label for="fileInput" class="col-sm-4 col-form-label">Unggah Berkas*</label>
                                        <div class="col-sm-8">
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
                                                <!-- <small class="text-muted upload-message"></small> -->
                                            </div>
                                            <small class="text-muted">* File yang diijinkan: jpg|png|pdf|jpeg|jfif (Maks. 5MB)</small>
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
                                    <button type="submit" class="btn btn-primary btn-flat">
                                        <i class="fa fa-save"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                    
                    <div class="card" id="dataBerkasTable">
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
    $(function () {        
        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });
    });
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
    background-color: rgba(0, 149, 120, 0.1);
}

.drop-zone__thumb {
    width: 100%;
    height: 100%;
    border-radius: 10px;
    overflow: hidden;
    position: relative;
}

.drop-zone__thumb-close {
    position: absolute;
    top: 8px;
    right: 8px;
    background: rgba(0, 0, 0, 0.5);
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    text-align: center;
    line-height: 24px;
    cursor: pointer;
    z-index: 10;
    transition: all 0.3s ease;
}

.drop-zone__thumb-close:hover {
    background: rgba(0, 0, 0, 0.8);
    transform: scale(1.1);
}

.drop-zone__thumb-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 8px;
    font-size: 12px;
    word-break: break-all;
}

.file-preview-container {
    padding: 20px;
    border-radius: 8px;
}

.drop-zone__prompt {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.drop-zone__prompt i {
    transition: transform 0.3s ease;
}

.drop-zone:hover .drop-zone__prompt i {
    transform: translateY(-5px);
}

.progress {
    height: 20px;
    margin-bottom: 10px;
    background-color: #f8f9fa;
    border-radius: 5px;
    overflow: hidden;
}

.progress-bar {
    background-color: #28a745;
    color: white;
    text-align: center;
    line-height: 20px;
    transition: width .6s ease;
}

.upload-message {
    margin-top: 5px;
    display: block;
}

.file-details {
    padding: 8px;
    background-color: #f8f9fa;
    border-radius: 4px;
    margin-top: 8px;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-10px); }
    75% { transform: translateX(10px); }
}

.drop-zone--error {
    border-color: #dc3545 !important;
    animation: shake 0.5s;
}
</style>

<script>
    // Define base_url from PHP
    const base_url = '<?php echo base_url(); ?>';
    // Define default PDF icon path
    const defaultPdfIcon = base_url + 'assets/theme/admin-lte-3/dist/img/pdf-icon.png';

$(document).ready(function() {
    const dropZone = $('#dropZone');
    const fileInput = $('#fileInput');
    let selectedFile = null;
    let isHandlingClick = false;

    // Click handler for drop zone
    dropZone.on('click', function(e) {
        if ($(e.target).hasClass('drop-zone__thumb-close') || isHandlingClick) {
            return;
        }
        
        isHandlingClick = true;
        fileInput.trigger('click');
        setTimeout(() => {
            isHandlingClick = false;
        }, 100);
    });

    // File input change handler
    fileInput.on('change', function(e) {
        if (this.files.length) {
            handleFiles(this.files);
        }
    });

    // Drag and drop handlers
    dropZone.on('dragover', function(e) {
        e.preventDefault();
        dropZone.addClass('drop-zone--over');
    });

    dropZone.on('dragleave dragend', function(e) {
        dropZone.removeClass('drop-zone--over');
    });

    dropZone.on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        dropZone.removeClass('drop-zone--over');
        
        const files = e.originalEvent.dataTransfer.files;
        if (files.length) {
            handleFiles(files);
        }
    });

    // Close button handler
    $('.drop-zone__thumb-close').on('click', function(e) {
        e.stopPropagation();
        clearFile();
    });

    // Update form submission handler
    $('form').on('submit', function(e) {
        e.preventDefault();

        // Check if file is selected either through input or drag & drop
        const fileInput = $('#fileInput')[0];
        if (!fileInput.files.length && !selectedFile) {
            $('#dropZone').addClass('drop-zone--error');
            toastr.error('Pilih file terlebih dahulu!');
            setTimeout(() => {
                $('#dropZone').removeClass('drop-zone--error');
            }, 2000);
            return false;
        }

        // Validate other form fields
        if (!validateForm()) {
            return false;
        }

        // If all validations pass, proceed with upload
        uploadFileWithForm();
        return false;
    });
});

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

        // Store the file and update UI
        selectedFile = file;
        $('#dropZone').removeClass('drop-zone--error');
        updateThumbnail(file);
        showFileDetails(file);
    }
}

function updateThumbnail(file) {
    const thumbElement = $('#dropZoneThumb');
    const promptElement = $('.drop-zone__prompt');
    
    thumbElement.show();
    promptElement.hide();

    // Clear previous content
    thumbElement.empty().append('<div class="drop-zone__thumb-close" title="Hapus file">&times;</div>');

    if (file.type.startsWith('image/')) {
        // For images
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
            thumbElement.css({
                'background-image': `url('${reader.result}')`,
                'background-size': 'cover',
                'background-position': 'center'
            });
        };
    } else {
        // For PDFs - use Font Awesome icon
        const iconContainer = $('<div>', {
            class: 'file-preview-container',
            css: {
                'width': '100%',
                'height': '100%',
                'display': 'flex',
                'align-items': 'center',
                'justify-content': 'center',
                'flex-direction': 'column',
                'background-color': '#f8f9fa'
            }
        });

        const icon = $('<i>', {
            class: 'fas fa-file-pdf fa-3x text-danger mb-2'
        });

        const fileName = $('<div>', {
            class: 'text-muted small',
            text: file.name,
            css: {
                'max-width': '90%',
                'overflow': 'hidden',
                'text-overflow': 'ellipsis',
                'white-space': 'nowrap'
            }
        });

        iconContainer.append(icon, fileName);
        thumbElement.append(iconContainer);
        thumbElement.css('background-image', 'none');
    }

    // Add file info at bottom
    const thumbInfo = $('<div>', {
        class: 'drop-zone__thumb-info',
        text: `${file.name} (${formatFileSize(file.size)})`
    });
    thumbElement.append(thumbInfo);
}

function showFileDetails(file) {
    const uploadStatus = $('.upload-status');
    const uploadMessage = $('.upload-message');
    
    uploadStatus.show();
    uploadMessage.removeClass('text-danger text-success')
        .addClass('text-info')
        .html(`
            <div class="file-details">
                <strong>File:</strong> ${file.name}<br>
                <strong>Ukuran:</strong> ${formatFileSize(file.size)}<br>
                <strong>Tipe:</strong> ${file.type}
            </div>
        `);
}

function showError(message) {
    const uploadStatus = $('.upload-status');
    const uploadMessage = $('.upload-message');
    
    uploadStatus.show();
    uploadMessage.removeClass('text-success text-info')
        .addClass('text-danger')
        .text(message);

    toastr.error(message);
}

function clearFile() {
    $('#fileInput').val('');
    selectedFile = null;
    const thumbElement = $('#dropZoneThumb');
    thumbElement.hide().css('background-image', 'none').empty();
    $('.drop-zone__prompt').show();
    $('.upload-status').hide();
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Make sure the PDF icon exists
function checkPdfIcon() {
    // Create a temporary image to check if the PDF icon exists
    const img = new Image();
    img.onerror = function() {
        console.warn('PDF icon not found at:', defaultPdfIcon);
        // Use a fallback icon or default styling
        $('.drop-zone__thumb').addClass('pdf-fallback');
    };
    img.src = defaultPdfIcon;
}

// Call this when document is ready
$(document).ready(function() {
    checkPdfIcon();
    // ... rest of your ready handler code ...
});

// Add fallback styling
const style = `
<style>
    .pdf-fallback {
        background-color: #f8f9fa !important;
        background-image: none !important;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .pdf-fallback::before {
        content: "PDF";
        font-size: 24px;
        color: #6c757d;
    }
</style>
`;
$('head').append(style);
</script>

<!-- Make sure Font Awesome is included in your header -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Add form validation function -->
<script>
function validateForm() {
    let isValid = true;
    
    // Only check required fields
    $('input[required], select[required], textarea[required]').each(function() {
        if (!$(this).val()) {
            isValid = false;
            $(this).addClass('is-invalid');
            toastr.error(`Field ${$(this).attr('name')} harus diisi`);
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    return isValid;
}

function uploadFileWithForm() {
    const formData = new FormData($('form')[0]);
    formData.set('fupload', selectedFile);

    const progressBar = $('.progress-bar');
    const uploadMessage = $('.upload-message');
    const submitBtn = $('button[type="submit"]');

    submitBtn.prop('disabled', true);
    
    $('.upload-status').show();
    progressBar.css('width', '0%');
    uploadMessage.removeClass('text-danger text-success')
        .addClass('text-info')
        .text('Mengunggah...');

    $.ajax({
        url: $('form').attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        xhr: function() {
            const xhr = new XMLHttpRequest();
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percent = Math.round((e.loaded / e.total) * 100);
                    progressBar.css('width', percent + '%');
                    progressBar.text(percent + '%');
                }
            });
            return xhr;
        },
        success: function(response) {
            submitBtn.prop('disabled', false);
            try {
                // Show success message
                toastr.success('Data berhasil disimpan!');
                
                // Clear form
                clearForm();
                
                // Reload just the data table div
                $('#dataBerkasTable').load(window.location.href + ' #dataBerkasTable > *', function() {
                    // Reinitialize lightbox after content load
                    $('[data-toggle="lightbox"]').off('click').on('click', function(e) {
                        e.preventDefault();
                        $(this).ekkoLightbox({
                            alwaysShowClose: true
                        });
                    });
                });
            } catch (e) {
                console.error('Error processing response:', e);
                showError('Terjadi kesalahan saat memproses response server');
            }
        },
        error: function(xhr, status, error) {
            submitBtn.prop('disabled', false);
            console.error('Upload error:', error);
            showError('Gagal mengunggah file: ' + error);
        }
    });
}

function clearForm() {
    clearFile();
    $('input[name="judul"]').val('');
    $('textarea[name="ket"]').val('');
    $('.is-invalid').removeClass('is-invalid');
    $('.drop-zone--error').removeClass('drop-zone--error');
}
</script>

<!-- Configure Toastr options -->
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
