<?php echo form_open(base_url('medcheck/set_medcheck_pen_hrv_upd.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_analis', (!empty($sql_medc_hrv_rw->id_analis) ? general::enkrip($sql_medc_hrv_rw->id_analis) : general::enkrip($this->ion_auth->user()->row()->id))); ?>
<?php echo form_hidden('id_pen', $this->input->get('id_pen')); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>
<?php echo form_hidden('act', $this->input->get('act')); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">[HRV] PEMERIKSAAN PENUNJANG - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
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
                                <option value="<?php echo $doctor->id_user ?>" <?php echo ($doctor->id_user == $sql_medc_hrv_rw->id_dokter ? 'selected' : '') ?>><?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . $doctor->nama . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            <?php }else{ ?>
                <?php echo form_hidden('dokter', $sql_medc_hrv_rw->id_dokter) ?>
                <?php echo form_hidden('tgl_masuk', date('d-m-Y')) ?>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputEmail3"><i>Mean Heart Rate (bpm)</i></label>
                    <?php echo form_input(array('id' => 'hsl_mhr', 'name' => 'hsl_mhr', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_hrv_rw->hsl_mhr)) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3"><i>SDNN (ms)</i></label>
                    <?php echo form_input(array('id' => 'hsl_sdnn', 'name' => 'hsl_sdnn', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_hrv_rw->hsl_sdnn)) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3"><i>RMSSD (ms)</i></label>
                    <?php echo form_input(array('id' => 'hsl_rmssd', 'name' => 'hsl_rmssd', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_hrv_rw->hsl_rmssd)) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3"><i>PSI</i></label>
                    <?php echo form_input(array('id' => 'hsl_psi', 'name' => 'hsl_psi', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_hrv_rw->hsl_psi)) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3"><i>LH / HF</i></label>
                    <?php echo form_input(array('id' => 'hsl_lhhf', 'name' => 'hsl_lhhf', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_hrv_rw->hsl_lhhf)) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputEmail3"><i>Ectopic Beat</i></label>
                    <?php echo form_input(array('id' => 'hsl_eb', 'name' => 'hsl_eb', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_hrv_rw->hsl_eb)) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3"><i>Autonomic Nervous System</i></label>
                    <?php echo form_input(array('id' => 'hsl_ans', 'name' => 'hsl_ans', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_hrv_rw->hsl_ans)) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3"><i>Pressure Index</i></label>
                    <?php echo form_input(array('id' => 'hsl_pi', 'name' => 'hsl_pi', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_hrv_rw->hsl_pi)) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3"><i>Emotional State</i></label>
                    <?php echo form_input(array('id' => 'hsl_es', 'name' => 'hsl_es', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_hrv_rw->hsl_es)) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3"><i>RRV</i></label>
                    <?php echo form_input(array('id' => 'hsl_rrv', 'name' => 'hsl_rrv', 'class' => 'form-control pull-right rounded-0', 'placeholder' => '', 'value' => $sql_medc_hrv_rw->hsl_rrv)) ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="inputEmail3">Komentar / Catatan</label>
                    <?php echo form_textarea(array('id' => 'ket', 'name' => 'ket', 'class' => 'form-control pull-left rounded-0', 'placeholder' => 'Isikan Kesimpulan ...', 'style' => 'height: 163px;', 'value' => $sql_medc_hrv_rw->keterangan)) ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tambah.php?act=lab_ekg&id=' . general::enkrip($sql_medc->id) . '&status=' . $this->input->get('status')) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">                                 
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>                            
    </div>
</div>
<?php echo form_close() ?>
