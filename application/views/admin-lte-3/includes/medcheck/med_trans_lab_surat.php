<?php echo form_open(base_url('medcheck/set_medcheck_lab_upd.php'), 'autocomplete="off" id="lab_surat_form"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_lab', general::enkrip($sql_medc_lab_rw->id)); ?>
<?php echo form_hidden('id_analis', (!empty($sql_medc_lab_rw->id_analis) ? general::enkrip($sql_medc_lab_rw->id_analis) : general::enkrip($this->ion_auth->user()->row()->id))); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>
<?php echo form_hidden('act', $this->input->get('act')); ?>
<?php echo form_hidden('route', uri_string() . '?' . $_SERVER['QUERY_STRING']); ?>
<?php echo add_form_protection(); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">INSTALASI LABORATORIUM - <?php echo $sql_pasien->nama_pgl; ?>
            <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small>
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <?php if (akses::hakDokter() != TRUE) { ?>
                    <?php $hasError = $this->session->flashdata('form_error'); ?>
                    <div class="form-group row <?php echo (!empty($hasError['no_sampel']) ? 'text-danger' : '') ?>">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                </div>
                                <?php echo form_input(array('id' => 'tgl_masuk', 'name' => 'tgl_masuk', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['tgl_masuk']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Tgl Entri ...', 'value' => $this->tanggalan->tgl_indo($sql_medc_lab_rw->tgl_masuk))) ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row <?php echo (!empty($hasError['no_sampel']) ? 'text-danger' : '') ?>">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">No. Sampel</label>
                        <div class="col-sm-8">
                            <?php echo form_input(array('id' => 'no_sampel', 'name' => 'no_sampel', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['no_sampel']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan No Sample ...', 'value' => $sql_medc_lab_rw->no_sample)) ?>
                        </div>
                    </div>
                    <div class="form-group row <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Dokter Perujuk</label>
                        <div class="col-sm-6">
                            <select id="dokter" name="dokter"
                                class="form-control rounded-0 select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                <option value="0">- Dokter -</option>
                                <?php foreach ($sql_doc as $doctor) { ?>
                                    <option value="<?php echo $doctor->id_user ?>" <?php echo ($doctor->id_user == $sql_medc_lab_rw->id_dokter ? 'selected' : '') ?>>
                                        <?php echo ($doctor->status_aps == '1' ? '[APS] ' : '') . (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . $doctor->nama . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-primary btn-flat" data-toggle="modal"
                                data-target="#modal-tambah-dokter">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group row <?php echo (!empty($hasError['dokter_pemeriksa']) ? 'text-danger' : '') ?>">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Dokter Pemeriksa</label>
                        <div class="col-sm-6">
                            <select id="dokter_pem" name="dokter_pem"
                                class="form-control rounded-0 select2bs4 <?php echo (!empty($hasError['dokter_pem']) ? ' is-invalid' : '') ?>">
                                <option value="0">- Dokter -</option>
                                <?php foreach ($sql_doc as $doctor) { ?>
                                    <option value="<?php echo $doctor->id_user ?>" <?php echo ($doctor->id_user == $sql_medc_lab_rw->id_dokter_pem ? 'selected' : '') ?>>
                                        <?php echo ($doctor->status_aps == '1' ? '[APS] ' : '') . (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . $doctor->nama . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-2">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Keterangan</label>
                        <div class="col-sm-8">
                            <?php echo form_textarea(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control pull-left rounded-0', 'placeholder' => 'Isikan Keterangan ...', 'style' => 'height: 163px;', 'value' => $sql_medc_lab_rw->ket)) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Status Duplo</label>
                        <div class="col-sm-8">
                            <input type="checkbox" name="duplo" value="1" id="duplo" <?php echo ($sql_medc_lab_rw->status_duplo == '1' ? 'checked' : '') ?>>
                            <?php // echo form_checkbox(array('id' => 'duplo', 'name' => 'duplo', 'value' => '1')) ?> Sudah
                            dilakukan duplo
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Status Nilai Kritis</label>
                        <div class="col-sm-8">
                            <input type="radio" name="status_normal" value="0" <?php echo ($sql_medc_lab_rw->status_normal == '0' ? 'checked="checked"' : '') ?>> Normal<br />
                            <input type="radio" name="status_normal" value="1" <?php echo ($sql_medc_lab_rw->status_normal == '1' ? 'checked="checked"' : '') ?>> Tidak Normal<br />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Covid</label>
                        <div class="col-sm-8">
                            <input type="radio" name="status_cvd" value="0" <?php echo ($sql_medc_lab_rw->status_cvd == '0' ? 'checked="checked"' : '') ?>> None<br />
                            <input type="radio" name="status_cvd" value="1" <?php echo ($sql_medc_lab_rw->status_cvd == '1' ? 'checked="checked"' : '') ?>> Rapid Test<br />
                            <input type="radio" name="status_cvd" value="2" <?php echo ($sql_medc_lab_rw->status_cvd == '2' ? 'checked="checked"' : '') ?>> PCR Test<br />
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat"
                    onclick="window.location.href = '<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=' . $this->input->get('status')) ?>'"><i
                        class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
<?php echo add_double_submit_protection('lab_surat_form'); ?>
<?php echo form_close() ?>



<!-- Modal Tambah Dokter -->
<form id="formTambahDokter">
    <div class="modal fade" id="modal-tambah-dokter">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Dokter APS</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php $hasError = $this->session->flashdata('form_error'); ?>
                    <?php echo form_hidden('id', general::enkrip($sql_kary->id)) ?>
                    <?php echo form_hidden('id_user', general::enkrip($sql_kary->id_user)) ?>
                    <?php echo form_hidden('act', $this->input->get('act')) ?>
                    <?php echo form_hidden('id_medc', $this->input->get('id')) ?>
                    <?php echo form_hidden('id_lab', $this->input->get('id_lab')) ?>
                    <?php echo form_hidden('status', $this->input->get('status')) ?>
                    <?php echo form_hidden('route', $this->input->get('route')) ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-2">
                                    <div
                                        class="form-group <?php echo (!empty($hasError['gelar']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Gelar</label>
                                        <?php echo form_input(array('id' => 'nama_dpn', 'name' => 'nama_dpn', 'class' => 'form-control rounded-0' . (!empty($hasError['gelar']) ? ' is-invalid' : ''), 'value' => $sql_kary->nama_dpn, 'placeholder' => 'dr. ...')) ?>
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div
                                        class="form-group <?php echo (!empty($hasError['nama']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Nama Lengkap*</label>
                                        <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control rounded-0' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'value' => $sql_kary->nama, 'placeholder' => 'John Doe ...')) ?>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div
                                        class="form-group <?php echo (!empty($hasError['gelar']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Gelar</label>
                                        <?php echo form_input(array('id' => 'nama_blk', 'name' => 'nama_blk', 'class' => 'form-control rounded-0' . (!empty($hasError['nama_blk']) ? ' is-invalid' : ''), 'value' => $sql_kary->nama_blk, 'placeholder' => 'Sp.PD ...')) ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group <?php echo (!empty($hasError['jns_klm']) ? 'text-danger' : '') ?>">
                                <label class="control-label">Jenis Kelamin*</label>
                                <select name="jns_klm" id="jns_klm"
                                    class="form-control rounded-0 <?php echo (!empty($hasError['jns_klm']) ? 'is-invalid' : '') ?>">
                                    <option value="">- Pilih -</option>
                                    <option value="L" <?php echo ('L' == $sql_kary->jns_klm ? 'selected' : '') ?>>Laki
                                        - laki</option>
                                    <option value="P" <?php echo ('P' == $sql_kary->jns_klm ? 'selected' : '') ?>>
                                        Perempuan</option>
                                </select>
                            </div>

                            <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                <label class="control-label">No. HP</label>
                                <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control rounded-0', 'value' => $sql_kary->no_hp, 'placeholder' => 'Nomor kontak WA karyawan / keluarga terdekat ...')) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-primary btn-flat" data-dismiss="modal">Tutup</button>
                    <button type="button" id="btnSimpanDokter" class="btn btn-primary btn-flat"><i
                            class="fa fa-save"></i>
                        Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#btnSimpanDokter').click(function () {
            // Get CSRF token
            var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
            var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
            
            // Add CSRF token to form data
            var formData = $('#formTambahDokter').serialize();
            formData += '&' + csrfName + '=' + csrfHash;

            $.ajax({
                url: '<?php echo base_url("medcheck/set_master_aps"); ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (result) {
                    if (result.success) {
                        toastr.success(result.message);
                        $('#modal-tambah-dokter').modal('hide');
                        
                        // Reset form fields
                        $('#formTambahDokter')[0].reset();
                        
                        // Reload the doctor dropdowns with the new data
                        $.ajax({
                            url: '<?php echo base_url("medcheck/json_dokter.php"); ?>',
                            type: 'GET',
                            dataType: 'json',
                            success: function(doctors) {
                                // Clear existing options
                                $('#dokter, #dokter_pem').empty();
                                
                                // Add default option
                                $('#dokter, #dokter_pem').append('<option value="0">- Dokter -</option>');
                                
                                // Add doctor options
                                $.each(doctors, function(i, doctor) {
                                    var doctorName = (doctor.status_aps == '1' ? '[APS] ' : '') + 
                                                    (doctor.nama_dpn ? doctor.nama_dpn + ' ' : '') + 
                                                    doctor.nama + 
                                                    (doctor.nama_blk ? ', ' + doctor.nama_blk : '');
                                    
                                    var option = $('<option></option>')
                                        .attr('value', doctor.id)
                                        .text(doctorName);
                                    
                                    // If this is the newly added doctor, select it
                                    if (result.data && doctor.id == result.data.id_user) {
                                        option.attr('selected', 'selected');
                                    }
                                    
                                    $('#dokter, #dokter_pem').append(option);
                                });
                                
                                // Reinitialize select2
                                if ($.fn.select2) {
                                    $('.select2bs4').select2({
                                        theme: 'bootstrap4'
                                    });
                                }
                                
                                // Set the newly added doctor as selected in the dropdown
                                if (result.data && result.data.id_user) {
                                    $('#dokter').val(result.data.id_user).trigger('change');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error loading doctors:', error);
                            }
                        });
                    } else {
                        toastr.error(result.message || 'Terjadi kesalahan saat menyimpan data');
                    }
                },
                error: function (xhr, status, error) {
                    toastr.error('Error: ' + xhr.status + ' ' + xhr.statusText);
                    console.error('XHR Response:', xhr.responseText);
                }
            });
        });
    });
</script>