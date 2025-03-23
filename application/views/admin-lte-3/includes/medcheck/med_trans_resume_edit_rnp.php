<?php echo form_open_multipart(base_url('medcheck/set_medcheck_resm_hsl2_upd.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_resume', general::enkrip($sql_medc_rsm_rw->id)); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>
<?php echo form_hidden('act', $this->input->get('act')); ?>
<?php echo form_hidden('route', $this->input->get('route')); ?>

<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">[UBAH] RESUME RANAP - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <?php $hasError = $this->session->flashdata('form_error'); ?>
            <div class="col-md-6">
                <?php $no = 1; ?>
                <?php foreach ($sql_medc_rsm_dt2 as $det) { ?>
                    <div class="form-group">
                        <label for="inputEmail3"><?php echo ucwords($det->param); ?></label>
                        <?php echo form_hidden('pemeriksaan' . $no, $det->param) ?>                    
                        <?php echo form_textarea(array('id' => 'hasil', 'name' => 'hasil' . $no, 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['hasil']) ? ' is-invalid' : ''), 'rows' => '5', 'value' => html_entity_decode($det->param_nilai))) ?>
                    </div>
                    <?php
                    if ($no %6 == 0) {
                        echo '</div><div class="col-md-6">';
                    }
                    ?>
                    <?php $no++ ?>
                <?php } ?>           
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=' . $this->input->get('status')) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- /.card -->
<?php echo form_close() ?>
