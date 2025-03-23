<?php echo form_open(base_url('medcheck/set_medcheck_ass_fisik_upd.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_ass', $this->input->get('id_ass')); ?>
<?php echo form_hidden('id_analis', (!empty($sql_medc_ass_rw->id_analis) ? general::enkrip($sql_medc_ass_rw->id_analis) : general::enkrip($this->ion_auth->user()->row()->id))); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>
<?php echo form_hidden('act', $this->input->get('act')); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">[FORM ASSESMENT] INSTALASI LABORATORIUM - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9">
                <?php if (akses::hakDokter() != TRUE) { ?>
                    <?php $hasError = $this->session->flashdata('form_error'); ?>
                    <div class="form-group row <?php echo (!empty($hasError['no_sampel']) ? 'text-danger' : '') ?>">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                </div>
                                <?php echo form_input(array('id' => 'tgl_masuk', 'name' => 'tgl_masuk', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['tgl_masuk']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Tgl Entri ...', 'value' => $this->tanggalan->tgl_indo($sql_medc_ass_rw->tgl_masuk))) ?>
                            </div>                            
                        </div>
                    </div>
                    <div class="form-group row <?php echo (!empty($hasError['no_sampel']) ? 'text-danger' : '') ?>">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">No. Sampel</label>
                        <div class="col-sm-8">
                            <?php echo form_input(array('id' => 'no_sampel', 'name' => 'no_sampel', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['no_sampel']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan No Sample ...', 'value' => $sql_medc_ass_rw->no_sample)) ?>
                        </div>
                    </div>
                    <div class="form-group row <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Dokter</label>
                        <div class="col-sm-8">
                            <select id="dokter" name="dokter" class="form-control rounded-0 select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                <option value="0">- Dokter -</option>
                                <?php foreach ($sql_doc as $doctor) { ?>
                                    <option value="<?php echo $doctor->id_user ?>" <?php echo ($doctor->id_user == $sql_medc_ass_rw->id_dokter ? 'selected' : '') ?>><?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn.' ' : '').$doctor->nama.(!empty($doctor->nama_blk) ? ', '.$doctor->nama_blk : '') ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Keterangan</label>
                        <div class="col-sm-8">
                            <?php echo form_textarea(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control pull-left rounded-0', 'placeholder' => 'Isikan Keterangan ...', 'style' => 'height: 163px;', 'value' => $sql_medc_ass_rw->ket)) ?>
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
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=17') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">                                 
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>                            
    </div>
</div>
<?php echo form_close() ?>
