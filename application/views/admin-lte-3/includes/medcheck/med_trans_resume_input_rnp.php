<?php echo form_open_multipart(base_url('medcheck/set_medcheck_resm_hsl2.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_resume', general::enkrip($sql_medc_rsm_rw->id)); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>
<?php echo form_hidden('act', $this->input->get('act')); ?>
<?php echo form_hidden('route', $this->input->get('route')); ?>

<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">RESUME RANAP - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <?php $hasError = $this->session->flashdata('form_error'); ?>
            
            <div class="col-md-12">
                <?php echo $this->session->flashdata('medcheck'); ?>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputEmail3">Anamnesis</label>
                    <?php echo form_hidden('pemeriksaan1', 'Anamnesis') ?>                    
                    <?php echo form_textarea(array('id' => 'hasil', 'name' => 'hasil1', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['hasil']) ? ' is-invalid' : ''), 'rows'=>'5', 'placeholder' => 'Isikan Anamnesis ...')) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3">Riwayat Perjalanan Penyakit</label>
                    <?php echo form_hidden('pemeriksaan2', 'Riwayat Perjalanan Penyakit') ?>                    
                    <?php echo form_textarea(array('id' => 'hasil', 'name' => 'hasil2', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['hasil']) ? ' is-invalid' : ''), 'rows'=>'5', 'placeholder' => 'Isikan Riwayat Perjalanan Penyakit ...')) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3">Pemeriksaan Fisik</label>
                    <?php echo form_hidden('pemeriksaan3', 'Pemeriksaan Fisik') ?>                    
                    <?php echo form_textarea(array('id' => 'hasil', 'name' => 'hasil3', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['hasil']) ? ' is-invalid' : ''), 'rows'=>'5', 'placeholder' => 'Isikan Pemeriksaan Fisik ...')) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3">Pemeriksaan Penunjang <small><i>* (Lab,Rad)</i></small></label>
                    <?php echo form_hidden('pemeriksaan4', 'Pemeriksaan Penunjang') ?>                    
                    <?php echo form_textarea(array('id' => 'hasil', 'name' => 'hasil4', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['hasil']) ? ' is-invalid' : ''), 'rows'=>'5', 'placeholder' => 'Isikan Pemeriksaan (Lab,Rad,dll) ...')) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3">Diagnosis Awal</label>
                    <?php echo form_hidden('pemeriksaan5', 'Diagnosis Awal') ?>                    
                    <?php echo form_textarea(array('id' => 'hasil', 'name' => 'hasil5', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['hasil']) ? ' is-invalid' : ''), 'rows'=>'5', 'placeholder' => 'Isikan Diagnosis Awal ...')) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3">Kondisi Saat Pulang</label>
                    <?php echo form_hidden('pemeriksaan6', 'Kondisi Saat Pulang') ?>                    
                    <?php echo form_textarea(array('id' => 'hasil', 'name' => 'hasil6', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['hasil']) ? ' is-invalid' : ''), 'rows'=>'5', 'placeholder' => 'Isikan Kondisi Saat Pulang ...')) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputEmail3">Diagnosis Utama</label>
                    <?php echo form_hidden('pemeriksaan7', 'Diagnosis Utama') ?>                    
                    <?php echo form_textarea(array('id' => 'hasil', 'name' => 'hasil7', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['hasil']) ? ' is-invalid' : ''), 'rows'=>'5', 'placeholder' => 'Isikan Diagnosis Utama ...')) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3">Diagnosis Sekunder</label>
                    <?php echo form_hidden('pemeriksaan8', 'Diagnosis Sekunder') ?>                    
                    <?php echo form_textarea(array('id' => 'hasil', 'name' => 'hasil8', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['hasil']) ? ' is-invalid' : ''), 'rows'=>'5', 'placeholder' => 'Isikan Diagnosis Sekunder ...')) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3">Obat Selama Perawatan</label>
                    <?php echo form_hidden('pemeriksaan9', 'Obat Selama Perawatan') ?>                    
                    <?php echo form_textarea(array('id' => 'hasil', 'name' => 'hasil9', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['hasil']) ? ' is-invalid' : ''), 'rows'=>'5', 'placeholder' => 'Isikan Obat Selama di RS ...')) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3">Tindakan Selama Perawatan</label>
                    <?php echo form_hidden('pemeriksaan10', 'Tindakan Selama Perawatan') ?>                    
                    <?php echo form_textarea(array('id' => 'hasil', 'name' => 'hasil10', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['hasil']) ? ' is-invalid' : ''), 'rows'=>'5', 'placeholder' => 'Isikan Tindakan Selama di RS ...')) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3">Edukasi</label>
                    <?php echo form_hidden('pemeriksaan11', 'Edukasi') ?>                    
                    <?php echo form_textarea(array('id' => 'hasil', 'name' => 'hasil11', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['hasil']) ? ' is-invalid' : ''), 'rows'=>'5', 'placeholder' => 'Isikan Edukasi ...')) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3">Anjuran</label>
                    <?php echo form_hidden('pemeriksaan12', 'Anjuran') ?>                    
                    <?php echo form_textarea(array('id' => 'hasil', 'name' => 'hasil12', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['hasil']) ? ' is-invalid' : ''), 'rows'=>'5', 'placeholder' => 'Isikan Anjuran ...')) ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="inputEmail3">Alasan Pulang</label>
                    <?php echo form_hidden('pemeriksaan13', 'Alasan Pulang') ?>                    
                    <?php echo form_textarea(array('id' => 'hasil', 'name' => 'hasil13', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['hasil']) ? ' is-invalid' : ''), 'rows'=>'5', 'placeholder' => 'Isikan Alasan Pulang ...')) ?>
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

<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">HASIL RESUME MEDIS</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-left">Pemeriksaan</th>
                            <th class="text-left">Hasil</th>
                            <th class="text-right">
                                <?php if(!empty($sql_medc_rsm_dt2)){ ?>
                                    <?php echo anchor(base_url('medcheck/tambah.php?act=resm_edit_rnp&id=' . general::enkrip($sql_medc->id) . '&id_resm=' . $this->input->get('id_resm'). '&status=' . $this->input->get('status')), '<i class="fas fa-edit"></i> Ubah', 'class="btn btn-info btn-flat btn-xs" style="width: 65px;"') ?>
                                    <?php echo anchor(base_url('medcheck/resume/hapus_hsl_rnp.php?act=' . $this->input->get('act') . '&id=' . general::enkrip($sql_medc->id) . '&id_resm=' . $this->input->get('id_resm'). '&status=' . $this->input->get('status').'&item_id='.general::enkrip($det->id)), '<i class="fas fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus Hasil ?\')" style="width: 65px;"') ?>
                                <?php } ?>
                            </th>
                        </tr>                                    
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($sql_medc_rsm_dt2 as $det) { ?>
                            <tr>
                                <td class="text-center"><?php echo $no; ?>.</td>
                                <td class="text-left text-bold"><?php echo $det->param; ?></td>
                                <td class="text-left" colspan="2"><?php echo $det->param_nilai; ?></td>
                            </tr>
                            <?php $no++ ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <?php if ($sql_medc->status >= 5) { ?>
                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/tambah.php?id='.general::enkrip($sql_medc->id).'&status='.$this->input->get('status')) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                <?php } ?>
            </div>
            <div class="col-lg-6 text-right">  
                <?php if (!empty($sql_medc_rsm_dt)) { ?>
                    <?php if ($sql_medc->tipe != '3') { ?>
                        <?php echo anchor(base_url('medcheck/surat/cetak_pdf_rsm_'.($sql_medc->tipe == '3' ? 'rnp' : 'lab').'.php?id='.$this->input->get('id').'&id_resm='.$this->input->get('id_resm')), '<i class="fas fa-print"></i> Cetak', 'class="btn btn-primary btn-flat" target="_blank"') ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- /.card -->
