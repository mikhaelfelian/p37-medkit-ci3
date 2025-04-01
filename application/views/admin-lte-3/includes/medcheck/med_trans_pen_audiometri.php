<div class="card">
    <div class="card-header">
        <h3 class="card-title">PEMERIKSAAN PENUNJANG - <?php echo $sql_pasien->nama_pgl; ?>
            <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-4 col-sm-3">
                <div class="nav flex-column nav-tabs h-100" id="" role="" aria-orientation="vertical">
                    <?php $this->load->view('admin-lte-3/includes/medcheck/med_trans_pen_sidebar') ?>
                </div>
            </div>
            <div class="col-7 col-sm-9">
                <div class="tab-content" id="vert-tabs-tabContent">
                    <div class="tab-pane text-left fade show active" id="tab-pemeriksaan" role="tabpanel"
                        aria-labelledby="vert-tabs-home-tab">
                        <?php if (akses::hakSA() == TRUE or akses::hakOwner() == TRUE or akses::hakOwner2() == TRUE or akses::hakDokter() == TRUE or akses::hakPerawat() == TRUE or akses::hakAnalis() == TRUE) { ?>
                            <!-- Add Audiometri Form -->
                            <div class="card card-primary card-outline rounded-0">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Data Audiometri</h3>
                                </div>
                                <?php echo form_open_multipart(base_url('medcheck/set_medcheck_lab_adm_save'), 'id="audiometriForm" autocomplete="off"') ?>
                                    <div class="card-body">
                                        <input type="hidden" name="id_medcheck"
                                            value="<?php echo $this->input->get('id') ?>">
                                        <input type="hidden" name="id_pasien"
                                            value="<?php echo general::enkrip($sql_pasien->id) ?>">
                                        <input type="hidden" name="status"
                                            value="<?php echo $this->input->get('status') ?>">

                                            
                                        <?php $this->session->flashdata('form_error'); ?>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                                                    <label for="inputEmail3">Dokter Pengirim</label>
                                                    <select id="dokter_kirim" name="dokter_kirim"
                                                        class="form-control rounded-0 select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                                        <option value="0">- Dokter -</option>
                                                        <?php foreach ($sql_doc as $doctor) { ?>
                                                            <option value="<?php echo $doctor->id_user ?>" <?php echo ($doctor->id_user == $sql_medc_hrv_rw->id_dokter ? 'selected' : '') ?>>
                                                                <?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . $doctor->nama . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>No. Sample</label>
                                                    <?php echo form_input(array('name' => 'no_sample', 'class' => 'form-control rounded-0', 'placeholder' => 'Masukkan nomor sample', 'autocomplete' => 'off', 'required' => 'required')); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Tanggal Pemeriksaan</label>
                                                    <input type="text" class="form-control datepicker rounded-0"
                                                        name="tgl_masuk" id="tgl_masuk" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>File Hasil Audiometri</label>
                                                    <div class="drop-zone" id="dropZone" role="button" tabindex="0">
                                                        <div class="drop-zone__prompt">
                                                            <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                                            <span>Seret dan lepas file di sini atau klik untuk mengunggah</span>
                                                        </div>
                                                        <input type="file" 
                                                               name="file_audiometri" 
                                                               id="fileInput" 
                                                               class="drop-zone__input" 
                                                               accept=".pdf,.jpg,.jpeg,.png"
                                                               style="display: none;">
                                                        <div class="drop-zone__thumb" id="dropZoneThumb" style="display: none;">
                                                            <div class="drop-zone__thumb-close" title="Hapus file">&times;</div>
                                                            <div class="drop-zone__thumb-info"></div>
                                                        </div>
                                                    </div>
                                                    <div class="upload-status mt-2" style="display: none;">
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">* File yang diijinkan: jpg, jpeg, png, pdf (Maks. 2MB)</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                                                    <label for="inputEmail3">Dokter Pemeriksa / Pembaca</label>
                                                    <select id="dokter" name="dokter"
                                                        class="form-control rounded-0 select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                                        <option value="0">- Dokter -</option>
                                                        <?php foreach ($sql_doc as $doctor) { ?>
                                                            <option value="<?php echo $doctor->id_user ?>" <?php echo ($doctor->id_user == $sql_medc_hrv_rw->id_dokter ? 'selected' : '') ?>>
                                                                <?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . $doctor->nama . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Hasil Pemeriksaan</label>
                                            <textarea class="form-control rounded-0" name="hasil" rows="3"
                                                placeholder="Masukkan hasil pemeriksaan audiometri"
                                                autocomplete="off"></textarea>
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
                                    </div>
                                <?php echo form_close() ?>
                            </div>
                            <?php echo br() ?>
                        <?php } ?>

                        <!-- Display Records -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-left">File</th>
                                    <th class="text-left">Petugas</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $audiometri_records = $this->db->where('id_medcheck', general::dekrip($this->input->get('id')))
                                    ->order_by('tgl_simpan', 'DESC')
                                    ->get('tbl_trans_medcheck_lab_audiometri')
                                    ->result();
                                foreach ($audiometri_records as $record) {
                                    ?>
                                    <tr>
                                        <td class="text-center" style="width: 50px;">
                                            <?php if (akses::hakSA() == TRUE or akses::hakOwner() == TRUE or akses::hakOwner2() == TRUE or $record->id_user == $this->ion_auth->user()->row()->id) { ?>
                                                <?php
                                                echo anchor(
                                                    base_url('medcheck/set_medcheck_lab_adm_delete.php?id=' . $this->input->get('id') .
                                                        '&item_id=' . general::enkrip($record->id) .
                                                        '&status=' . $this->input->get('status')),
                                                    '<i class="fas fa-trash"></i>',
                                                    'class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus data ini?\')"'
                                                )
                                                    ?>
                                            <?php } ?>
                                        </td>
                                        <td class="text-center"><?php echo $this->tanggalan->tgl_indo($record->tgl_masuk) ?>
                                        </td>
                                        <td class="text-left">
                                            <a href="<?php echo base_url('file/pasien/' . strtolower($sql_pasien->kode_dpn . $sql_pasien->kode) . '/audiometri/' . $record->nama_file) ?>"
                                                target="_blank">
                                                <i class="fas fa-file"></i> <?php echo $record->nama_file ?>
                                            </a>
                                            <b>Hasil : </b>
                                            <p><?php echo $record->hasil ?></p>
                                        </td>
                                        <td class="text-left">
                                            <?php echo $this->ion_auth->user($record->id_user)->row()->first_name ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo anchor(
                                                base_url('medcheck/cetak_audiometri.php?id=' . general::enkrip($record->id)),
                                                '<i class="fas fa-print"></i> Cetak',
                                                'class="btn btn-info btn-sm" target="_blank"'
                                            )
                                                ?>
                                        </td>
                                    </tr>
                                        <tr>
                                            <td></td>
                                            <td colspan="4" class="text-left">
                                                <?php echo $this->ion_auth->user($record->id_dokter_kirim)->row()->first_name ?>
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
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat"
                    onclick="window.location.href = '<?php echo base_url('medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)) ?>'"><i
                        class="fas fa-arrow-left"></i> Kembali</button>
            </div>
        </div>
    </div>
</div>

<!-- Add this to your existing script section -->
<script>
    $(document).ready(function () {
        // Initialize datepicker
        $('#tgl_masuk').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        });

        // Update file input label
        $(".custom-file-input").on("change", function () {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    });
</script>

<!-- Add this CSS to your page -->
<style>
.drop-zone {
    width: 100%;
    height: 200px;
    padding: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    font-weight: 500;
    font-size: 1.2rem;
    cursor: pointer;
    color: #cccccc;
    border: 4px dashed #009ef7;
    border-radius: 10px;
}

.drop-zone--over {
    border-style: solid;
}

.drop-zone__input {
    display: none;
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

.drop-zone__thumb::after {
    content: attr(data-label);
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 5px 0;
    color: #ffffff;
    background: rgba(0, 0, 0, 0.75);
    font-size: 14px;
    text-align: center;
}

.drop-zone__thumb-close {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(0, 0, 0, 0.5);
    color: #fff;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    text-align: center;
    line-height: 24px;
    cursor: pointer;
}

/* Progress bar styles */
.progress {
    height: 20px;
    margin-bottom: 10px;
}

.progress-bar {
    background-color: #009ef7;
    height: 100%;
    text-align: center;
    transition: width .3s ease;
    color: white;
    font-size: 12px;
    line-height: 20px;
}

.upload-status {
    margin-top: 10px;
}
</style>

<!-- Add this JavaScript to your page -->
<script>
$(document).ready(function() {
    // Form submission handler
    $('#audiometriForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        // Show progress bar container
        $('.upload-status').show();
        
        $.ajax({
            url: '<?php echo base_url("medcheck/set_medcheck_lab_adm_save") ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $('.progress-bar').css('width', percentComplete + '%');
                        $('.progress-bar').attr('aria-valuenow', percentComplete);
                        $('.progress-bar').text(percentComplete + '%');
                        
                        if(percentComplete === 100) {
                            $('.progress-bar').text('Memproses...');
                        }
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                // Handle the response
                if (response.status === 'success') {
                    toastr.success(response.message);
                    // Redirect after successful upload
                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 1500);
                } else {
                    toastr.error(response.message || 'Gagal menyimpan data');
                }
            },
            error: function(xhr, status, error) {
                // Log the error details
                console.error('AJAX Error:', status, error);
                console.error('Response Text:', xhr.responseText);
                
                // Show error message
                toastr.error('Gagal mengunggah file: ' + error);
                
                // Reset progress bar
                $('.progress-bar').css('width', '0%');
                $('.progress-bar').attr('aria-valuenow', 0);
                $('.progress-bar').text('');
                $('.upload-status').hide();
            }
        });
    });

    // Existing dropzone code
    document.querySelectorAll(".drop-zone").forEach(dropZone => {
        const input = dropZone.querySelector(".drop-zone__input");
        const thumb = dropZone.querySelector(".drop-zone__thumb");
        const prompt = dropZone.querySelector(".drop-zone__prompt");

        dropZone.addEventListener("click", e => {
            input.click();
        });

        input.addEventListener("change", e => {
            if (input.files.length) {
                updateThumbnail(dropZone, input.files[0]);
            }
        });

        dropZone.addEventListener("dragover", e => {
            e.preventDefault();
            dropZone.classList.add("drop-zone--over");
        });

        ["dragleave", "dragend"].forEach(type => {
            dropZone.addEventListener(type, e => {
                dropZone.classList.remove("drop-zone--over");
            });
        });

        dropZone.addEventListener("drop", e => {
            e.preventDefault();

            if (e.dataTransfer.files.length) {
                input.files = e.dataTransfer.files;
                updateThumbnail(dropZone, e.dataTransfer.files[0]);
            }

            dropZone.classList.remove("drop-zone--over");
        });

        // Add click handler for close button
        if (thumb) {
            const closeBtn = thumb.querySelector(".drop-zone__thumb-close");
            if (closeBtn) {
                closeBtn.addEventListener("click", e => {
                    e.stopPropagation();
                    input.value = "";
                    thumb.style.display = "none";
                    prompt.style.display = "flex";
                });
            }
        }
    });
});

function updateThumbnail(dropZone, file) {
    let thumbnailElement = dropZone.querySelector(".drop-zone__thumb");
    const prompt = dropZone.querySelector(".drop-zone__prompt");

    // First time - remove the prompt
    if (prompt) {
        prompt.style.display = "none";
    }

    // Show thumbnail for image files
    if (thumbnailElement) {
        thumbnailElement.style.display = "block";
    }

    // First time - there is no thumbnail element, so lets create it
    if (!thumbnailElement) {
        thumbnailElement = document.createElement("div");
        thumbnailElement.classList.add("drop-zone__thumb");
        dropZone.appendChild(thumbnailElement);
    }

    thumbnailElement.dataset.label = file.name;

    // Show thumbnail for image files
    if (file.type.startsWith("image/")) {
        const reader = new FileReader();

        reader.readAsDataURL(file);
        reader.onload = () => {
            thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
        };
    } else {
        thumbnailElement.style.backgroundImage = null;
    }
}
</script>