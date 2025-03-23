<?php echo form_open(base_url('medcheck/set_medcheck_lab_ekg_upd.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_lab_spiro', general::enkrip($sql_medc_lab_ekg_rw->id)); ?>
<?php echo form_hidden('id_analis', (!empty($sql_medc_lab_ekg_rw->id_analis) ? general::enkrip($sql_medc_lab_ekg_rw->id_analis) : general::enkrip($this->ion_auth->user()->row()->id))); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>
<?php echo form_hidden('act', $this->input->get('act')); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">[EKG] INSTALASI LABORATORIUM - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <?php if (akses::hakDokter() != TRUE) { ?>
                <div class="col-md-6">
                    <?php $hasError = $this->session->flashdata('form_error'); ?>
                    <div class="form-group <?php echo (!empty($hasError['tgl_masuk']) ? 'text-danger' : '') ?>">
                        <label for="inputEmail3">Tanggal</label>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            </div>
                            <?php echo form_input(array('id' => 'tgl_masuk', 'name' => 'tgl_masuk', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['tgl_masuk']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Tgl Entri ...', 'value' => date('d-m-Y'))) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                        <label for="inputEmail3">Dokter</label>
                        <select id="dokter" name="dokter" class="form-control rounded-0 select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                            <option value="0">- Dokter -</option>
                            <?php foreach ($sql_doc as $doctor) { ?>
                                <option value="<?php echo $doctor->id_user ?>" <?php echo ($doctor->id_user == $sql_medc_lab_ekg_rw->id_dokter ? 'selected' : '') ?>><?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . $doctor->nama . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            <?php }else{ ?>
                <?php // echo form_hidden('dokter', $sql_medc_lab_ekg_rw->id_dokter) ?>
                <?php echo form_hidden('tgl_masuk', date('d-m-Y')) ?>
                <div class="col-md-12">
                    <div class="form-group <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                        <label for="inputEmail3">Dokter</label>
                        <select id="dokter" name="dokter" class="form-control rounded-0 select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                            <option value="0">- Dokter -</option>
                            <?php foreach ($sql_doc as $doctor) { ?>
                                <option value="<?php echo $doctor->id_user ?>" <?php echo ($doctor->id_user == $sql_medc_lab_ekg_rw->id_dokter ? 'selected' : '') ?>><?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . $doctor->nama . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputEmail3">Irama</label>
                    <?php echo form_input(array('id' => 'hsl_irama', 'name' => 'hsl_irama', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_lab_ekg_rw->hsl_irama)) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3">Frekuensi</label>
                    <?php echo form_input(array('id' => 'hsl_frek', 'name' => 'hsl_frek', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_lab_ekg_rw->hsl_frek)) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3">Axis</label>
                    <?php echo form_input(array('id' => 'hsl_axis', 'name' => 'hsl_axis', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_lab_ekg_rw->hsl_axis)) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3">Posisi</label>
                    <?php echo form_input(array('id' => 'hsl_pos', 'name' => 'hsl_pos', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_lab_ekg_rw->hsl_pos)) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3">Zona Transisi</label>
                    <?php echo form_input(array('id' => 'hsl_zona', 'name' => 'hsl_zona', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_lab_ekg_rw->hsl_zona)) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3">Gelombang P</label>
                    <?php echo form_input(array('id' => 'hsl_gelp', 'name' => 'hsl_gelp', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_lab_ekg_rw->hsl_gelp)) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputEmail3">Interval P - R</label>
                    <?php echo form_input(array('id' => 'hsl_int', 'name' => 'hsl_int', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_lab_ekg_rw->hsl_int)) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3">Kompleks Q R S</label>
                    <?php echo form_input(array('id' => 'hsl_qrs', 'name' => 'hsl_qrs', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_lab_ekg_rw->hsl_qrs)) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3">Segment ST</label>
                    <?php echo form_input(array('id' => 'hsl_st', 'name' => 'hsl_st', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_lab_ekg_rw->hsl_st)) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3">Gelombang T</label>
                    <?php echo form_input(array('id' => 'hsl_gelt', 'name' => 'hsl_gelt', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_lab_ekg_rw->hsl_gelt)) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3">Gelombang U</label>
                    <?php echo form_input(array('id' => 'hsl_gelu', 'name' => 'hsl_gelu', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_lab_ekg_rw->hsl_gelu)) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3">Lain-lain</label>
                    <?php echo form_input(array('id' => 'hsl_lain', 'name' => 'hsl_lain', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_lab_ekg_rw->hsl_lain)) ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="inputEmail3">Kesimpulan</label>
                    <?php echo form_textarea(array('id' => 'kesimpulan', 'name' => 'kesimpulan', 'class' => 'form-control pull-left rounded-0', 'placeholder' => 'Isikan Kesimpulan ...', 'style' => 'height: 163px;', 'value' => $sql_medc_lab_ekg_rw->kesimpulan)) ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tambah.php?act=pen_ekg&id=' . general::enkrip($sql_medc->id) . '&status=' . $this->input->get('status')) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">                                 
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>                            
    </div>
</div>
<?php echo form_close() ?>
