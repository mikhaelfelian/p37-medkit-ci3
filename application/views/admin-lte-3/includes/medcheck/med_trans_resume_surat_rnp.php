<?php echo form_open_multipart(base_url('medcheck/set_medcheck_resm_upd.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_resume', general::enkrip($sql_medc_resm_rw->id)); ?>
<?php echo form_hidden('route', $this->input->get('route')); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>

<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">FORM RESUME RANAP - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row"><div class="col-md-12"><?php echo $this->session->flashdata('medcheck'); ?></div></div>                              
        <!--
        <div class="row">                              
            <div class="col-md-6">                    
                <?php $hasError = $this->session->flashdata('form_error'); ?>
                <div class="form-group">
                    <label for="inputEmail3" class="">No. Sample</label>
                    <?php // echo form_input(array('id' => 'no_sample', 'name' => 'no_sample', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['no_sample']) ? ' is-invalid' : ''), 'placeholder' => 'No Sample ...', 'value' => $sql_medc_rsm_rw->no_sample)) ?>
                </div>
            </div>
            <div class="col-md-6">
                
            </div>
        </div>
        -->
        <div class="row">                           
            <div class="col-md-6">                    
                <?php $hasError = $this->session->flashdata('form_error'); ?>

                <?php if (!empty($sql_medc_rsm_rw->no_surat)) { ?>
                    <div class="form-group">
                        <label for="inputEmail3" class="">No. Surat</label>
                        <?php echo form_input(array('id' => 'no_surat', 'name' => 'no_surat', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['no_surat']) ? ' is-invalid' : ''), 'placeholder' => 'No Surat ...', 'value' => $sql_medc_rsm_rw->no_surat, 'readonly' => 'TRUE')) ?>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-6">                    
                <?php $hasError = $this->session->flashdata('form_error'); ?>
                <div class="form-group">
                    <label for="inputEmail3" class="">Dokter Penanggung Jawab</label>            
                    <select id="dokter_krm" name="dokter_kirim" class="form-control  rounded-0 select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                        <option value="">- Dokter -</option>
                        <?php foreach ($sql_doc as $doctor) { ?>
                            <option value="<?php echo $doctor->id_user ?>" <?php echo (!empty($sql_medc_rsm_rw->id_dokter) ? ($doctor->id_user == $sql_medc_rsm_rw->id_dokter ? 'selected' : '') : (($doctor->id == $this->session->flashdata('dokter') ? 'selected' : ''))) ?>><?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn.' ' : '').$doctor->nama.(!empty($doctor->nama_blk) ? ', '.$doctor->nama_blk : '') ?></option>
                        <?php } ?>
                    </select>
                </div>
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
<?php echo form_close(); ?>
