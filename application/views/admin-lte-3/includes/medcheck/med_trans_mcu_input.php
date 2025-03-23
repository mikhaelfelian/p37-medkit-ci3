<?php echo form_open_multipart(base_url('medcheck/set_medcheck_resm_hsl.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_resume', general::enkrip($sql_medc_rsm_rw->id)); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>
<?php echo form_hidden('act', $this->input->get('act')); ?>
<?php echo form_hidden('route', $this->input->get('route')); ?>

<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">MCU - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">            
                <?php $hasError = $this->session->flashdata('form_error'); ?>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Pemeriksaan</label>
                    <div class="col-sm-8">
                        <?php echo form_input(array('id' => 'pemeriksaan', 'name' => 'pemeriksaan', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['pemeriksaan']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Pemeriksaan ...')) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Hasil</label>
                    <div class="col-sm-8">
                        <?php echo form_input(array('id' => 'hasil', 'name' => 'hasil', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['pemeriksaan']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Hasil ...')) ?>
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

<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">HASIL MCU MEDIS</h3>
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
                            <th class="text-center">#</th>
                        </tr>                                    
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($sql_medc_rsm_dt as $det) { ?>
                            <tr>
                                <td class="text-center"><?php echo $no; ?>.</td>
                                <td class="text-left text-bold"><?php echo $det->param; ?></td>
                                <td class="text-left"><?php echo $det->param_nilai; ?></td>
                                <td class="text-left">
                                    <?php echo anchor(base_url('medcheck/resume/hapus_hsl.php?act=' . $this->input->get('act') . '&id=' . general::enkrip($sql_medc->id) . '&id_resm=' . $this->input->get('id_resm'). '&status=' . $this->input->get('status').'&item_id='.general::enkrip($det->id)), '<i class="fas fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $det->param . '] ?\')" style="width: 65px;"') ?>
                                </td>
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
                    <?php echo anchor(base_url('medcheck/surat/cetak_pdf_rsm_lab.php?id='.$this->input->get('id').'&id_resm='.$this->input->get('id_resm')), '<i class="fas fa-print"></i> Cetak', 'class="btn btn-primary btn-flat" target="_blank"') ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- /.card -->