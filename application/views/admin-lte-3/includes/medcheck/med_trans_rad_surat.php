<?php echo form_open_multipart(base_url('medcheck/set_medcheck_rad_upd.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_rad', general::enkrip($sql_medc_rad_rw->id)); ?>
<?php echo form_hidden('id_user', $sql_medc_rad_rw->id_radiografer); ?>
<?php echo form_hidden('route', $this->input->get('route')); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>
<?php echo form_hidden('status_rad', '1'); ?>

<!-- Default box -->
<div class="card rounded-0">
    <div class="card-header">
        <h3 class="card-title">INSTALASI RADIOLOGI - <?php echo $sql_pasien->nama_pgl; ?>
            <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small>
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12"><?php echo $this->session->flashdata('medcheck'); ?></div>
            <div class="col-md-6">
                <?php $hasError = $this->session->flashdata('form_error'); ?>

                <?php if (akses::hakDokter() == TRUE) { ?>
                    <div class="form-group">
                        <label for="inputEmail3" class="">Kesan</label>
                        <?php echo form_textarea(array('id' => 'kesan', 'name' => 'kesan', 'class' => 'form-control pull-left rounded-0', 'placeholder' => 'Kesan Pembacaan ...', 'value' => $sql_medc_rad_rw->ket)) ?>
                    </div>
                <?php } else { ?>
                    <?php if (!empty($sql_medc_rad_rw->no_rad)) { ?>
                        <div class="form-group">
                            <label for="inputEmail3" class="">No. Surat</label>
                            <?php echo form_input(array('id' => 'no_surat', 'name' => 'no_surat', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['no_surat']) ? ' is-invalid' : ''), 'placeholder' => 'No Surat ...', 'value' => $sql_medc_rad_rw->no_rad, 'readonly' => 'TRUE')) ?>
                        </div>
                    <?php } ?>
                    <div class="form-group row">
                        <!-- Dropdown Dokter (Lebar 8) -->
                        <div class="col-md-8">
                            <label for="dokter_krm">Dokter Pengirim</label>
                            <select id="dokter_krm" name="dokter_kirim"
                                class="form-control select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                <option value="">- Dokter -</option>
                                <?php foreach ($sql_doc as $doctor) { ?>
                                    <option value="<?php echo $doctor->id_user ?>" <?php echo ($doctor->id_user == $sql_medc->id_dokter ? 'selected' : '') ?>>
                                        <?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . $doctor->nama . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Tombol Submit (Lebar 4) -->
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="button" class="btn btn-primary w-100 rounded-0" data-toggle="modal" data-target="#tambahDokterModal">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-8">
                            <label for="inputEmail3" class="">Dokter Radiologi</label>
                            <select id="dokter" name="dokter"
                                class="form-control select2bs4 rounded-0 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                <option value="">- Dokter -</option>
                                <?php foreach ($sql_doc_rad as $doctor) { ?>
                                    <option value="<?php echo $doctor->id_user ?>" <?php echo (!empty($sql_medc_rad_rw->id_dokter) ? ($doctor->id_user == $sql_medc_rad_rw->id_dokter ? 'selected' : '') : (($doctor->id == $this->session->flashdata('dokter') ? 'selected' : ''))) ?>>
                                        <?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . $doctor->nama . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Tombol Submit (Lebar 4) -->
                        <div class="col-md-4 d-flex align-items-end">
                            <!-- <button type="button" class="btn btn-primary w-100 rounded-0"
                                onclick="window.location.href = '<?php echo base_url('master/data_aps_tambah.php?route=' . $this->input->get('route')) ?>'"><i
                                    class="fas fa-plus"></i> APS</button> -->
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-6">
                <?php $hasError = $this->session->flashdata('form_error'); ?>

                <div class="form-group">
                    <label for="inputEmail3" class="">No. Sampel</label>
                    <?php echo form_input(array('id' => 'no_sampel', 'name' => 'no_sampel', 'class' => 'form-control pull-right' . (!empty($hasError['no_sampel']) ? ' is-invalid' : ''), 'placeholder' => 'No Sampel Pengerjaan ...', 'value' => $sql_medc_rad_rw->no_sample)) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="">Kesan</label>
                    <?php echo form_textarea(array('id' => 'kesan', 'name' => 'kesan', 'class' => 'form-control pull-left rounded-0', 'placeholder' => 'Kesan Pembacaan ...', 'value' => $sql_medc_rad_rw->ket)) ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat"
                    onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=5') ?>'"><i
                        class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>

<!-- Modal -->
<div class="modal fade" id="tambahDokterModal" tabindex="-1" role="dialog" aria-labelledby="tambahDokterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h3 class="card-title">
                    <i class="fas fa-user-md"></i> Form Data Dokter
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?php echo form_open(base_url('medcheck/set_master_dokter'), ['id' => 'formTambahDokter', 'autocomplete' => 'off']) ?>
            <div class="modal-body">
                <?php echo $this->session->flashdata('master'); ?>
                <?php $hasError = $this->session->flashdata('form_error'); ?>
                <?php echo add_form_protection(); ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group <?php echo (!empty($hasError['nik']) ? 'text-danger' : '') ?>">
                            <label class="control-label">NIK* <small><i>(* Bisa diisi dengan NIK)</i></small></label>
                            <?php echo form_input(['id' => 'nik', 'name' => 'nik', 'class' => 'form-control rounded-0' . (!empty($hasError['nik']) ? ' is-invalid' : ''), 'placeholder' => 'Nomor Identitas ...']) ?>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label">SIP</label>
                            <?php echo form_input(['id' => 'sip', 'name' => 'sip', 'class' => 'form-control rounded-0', 'placeholder' => 'Nomor SIP ...']) ?>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label">STR</label>
                            <?php echo form_input(['id' => 'str', 'name' => 'str', 'class' => 'form-control rounded-0', 'placeholder' => 'Nomor STR ...']) ?>
                        </div>

                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label class="control-label">Gelar</label>
                                    <?php echo form_input(['id' => 'nama_dpn', 'name' => 'nama_dpn', 'class' => 'form-control rounded-0', 'placeholder' => 'dr. ...']) ?>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="form-group <?php echo (!empty($hasError['nama']) ? 'text-danger' : '') ?>">
                                    <label class="control-label">Nama Lengkap*</label>
                                    <?php echo form_input(['id' => 'nama', 'name' => 'nama', 'class' => 'form-control rounded-0' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'placeholder' => 'John Doe ...']) ?>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="control-label">Gelar</label>
                                    <?php echo form_input(['id' => 'nama_blk', 'name' => 'nama_blk', 'class' => 'form-control rounded-0', 'placeholder' => 'Sp.PD ...']) ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Jenis Kelamin*</label>
                            <select name="jns_klm" class="form-control rounded-0">
                                <option value="">- Pilih -</option>
                                <option value="L">Laki - laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label">No. HP</label>
                            <?php echo form_input(['id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control rounded-0', 'placeholder' => 'Nomor kontak WA karyawan / keluarga terdekat ...']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="row" style="width: 100%;">
                    <div class="col-lg-6">
                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">
                            <i class="fas fa-times"></i> Batal
                        </button>
                    </div>
                    <div class="col-lg-6 text-right">
                        <button type="submit" class="btn btn-primary btn-flat">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!-- Required Scripts -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<script>
$(document).ready(function() {
    // Initialize datepicker
    $("#tgl_lahir").datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '1945:2025',
        autoclose: true
    });

    // Handle form submission
    $('#formTambahDokter').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        
        // Create FormData object
        const formData = new FormData(form[0]);
        
        // Add CSRF token
        formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
        
        // Show loading state
        submitBtn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
            
        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                console.log('Response:', response);
                
                if (response.success) {
                    // Show success message
                    toastr.success(response.message || 'Data berhasil disimpan');
                    
                    // Reset form
                    form[0].reset();
                    
                    // Close modal
                    $('#tambahDokterModal').modal('hide');
                    
                    // Reload the page after a short delay
                    setTimeout(function() {
                        window.location.href = '<?php echo base_url("medcheck/tambah.php?act=rad_surat&id=" . $this->input->get("id") . "&id_rad=" . $this->input->get("id_rad") . "&status=5&route=") ?>';
                    }, 1000);
                } else {
                    // Show validation errors
                    if (response.errors) {
                        $.each(response.errors, function(field, message) {
                            const input = $(`[name="${field}"]`);
                            input.addClass('is-invalid');
                            input.after(`<div class="invalid-feedback">${message}</div>`);
                        });
                    }
                    
                    // Show error message
                    toastr.error(response.message || 'Terjadi kesalahan saat menyimpan data');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', {
                    status: status,
                    error: error,
                    response: xhr.responseText
                });
                
                toastr.error('Terjadi kesalahan sistem. Silakan coba lagi.');
            },
            complete: function() {
                // Reset button state
                submitBtn.prop('disabled', false)
                    .html('<i class="fa fa-save"></i> Simpan');
            }
        });
    });

    // Reset form and errors when modal is closed
    $('#tambahDokterModal').on('hidden.bs.modal', function() {
        const form = $('#formTambahDokter');
        form[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
    });
});
</script>

<style>
.modal-lg {
    max-width: 90%;
}

.form-group {
    margin-bottom: 1rem;
}

.modal-body {
    padding: 20px;
}

textarea {
    resize: none;
}

.is-invalid {
    border-color: #dc3545;
}

.text-danger {
    color: #dc3545;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
    padding: 1rem;
}

.input-group-text {
    border-radius: 0;
}
</style>