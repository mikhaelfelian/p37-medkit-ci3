<?php echo form_open_multipart(base_url('medcheck/set_medcheck_resm_hsl3_upd.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_resume', general::enkrip($sql_medc_rsm_rw->id)); ?>
<?php echo form_hidden('id_resume_det', general::enkrip($sql_medc_rsm_dt4->id)); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>
<?php echo form_hidden('act', $this->input->get('act')); ?>
<?php echo form_hidden('route', $this->input->get('route')); ?>
<?php $val = explode('#', $sql_medc_rsm_dt4->param_nilai); ?>

<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">[UBAH] RESUME RANAP - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">                    
                <?php $hasError = $this->session->flashdata('form_error'); ?>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Obat</label>
                    <div class="col-sm-10">
                        <?php echo form_input(array('id' => 'pemeriksaan', 'name' => 'pemeriksaan', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['pemeriksaan']) ? ' is-invalid' : ''), 'value' => $sql_medc_rsm_dt4->param)) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Jml</label>
                    <div class="col-sm-2">
                        <?php echo form_input(array('id' => 'hasil', 'name' => 'hasil1', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['pemeriksaan']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Jml ...', 'value' => $val[0])) ?>
                    </div>
                    <div class="col-sm-8">
                        <?php echo form_input(array('id' => 'hasil', 'name' => 'hasil2', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['pemeriksaan']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Dosis ...', 'value' => $val[1])) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-10">
                        <?php echo form_textarea(array('id' => 'hasil', 'name' => 'hasil3', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['pemeriksaan']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Frekuensi / Petunjuk / Cara Pemberian ...', 'value' => $val[0])) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/tambah.php?id='.general::enkrip($sql_medc->id).'&status='.$this->input->get('status')) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- /.card -->
<?php echo form_close() ?>
