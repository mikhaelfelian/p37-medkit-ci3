<?php echo form_open_multipart(base_url('medcheck/set_medcheck_rad_upd.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_rad', general::enkrip($sql_medc_rad_rw->id)); ?>
<?php echo form_hidden('id_user', $sql_medc_rad_rw->id_radiografer); ?>
<?php echo form_hidden('route', $this->input->get('route')); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>
<?php echo form_hidden('status_rad', '1'); ?>

<!-- Default box -->
<div class="card">
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
                            <button type="button" class="btn btn-primary w-100 rounded-0"
                                onclick="window.location.href = '<?php echo base_url('master/data_karyawan_tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=5&route=') ?>'"><i
                                    class="fas fa-plus"></i> Tambah</button>
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