<?php $sql_icd_rm    = $this->db->where('id', $sql_medc_rm_rw->id_icd)->get('tbl_m_icd')->row() ?>
<?php $sql_icd10_rm  = $this->db->where('id', $sql_medc_rm_rw->id_icd10)->get('tbl_m_icd')->row() ?>


<?php if (!empty($sql_medc_rm_rw->id)) { ?>
    <!-- Default box -->                    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">DIAGNOSA ICD 10 - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
        </div>
        <div class="card-body">
            <?php
            $sql_medc_icd = $this->db->where('id_medcheck', (float)$sql_medc_rm_rw->id)->where('id_medcheck_rm', $sql_medc_rm_rw->id)->where('status_icd', '2')->get('tbl_trans_medcheck_icd');
            ?>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th colspan="2">Diagnosa</th>
                        <th style="width: 25px"></th>
                    </tr>
                    <?php $no = 1; ?>
                    <?php foreach ($sql_medc_icd->result() as $icd) { ?>
                        <tr>
                            <td><?php echo $no ?>.</td>
                            <td>
                                <?php echo $icd->diagnosa ?><br/>
                                <i><?php echo $icd->diagnosa_en ?></i>
                            </td>
                            <td></td>
                        </tr>
                        <?php $no++ ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
<?php } ?>

<?php $hasError = $this->session->flashdata('form_error'); ?>
<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">DETAIL REKAM MEDIS RAWAT INAP - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body table-responsive">
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 col-form-label">Tanggal Entri</label>
            <div class="col-sm-9">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                    <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control pull-right', 'value' => $this->tanggalan->tgl_indo($sql_medc_rm_rw->tgl_simpan), 'disabled'=>'TRUE')) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputEmail3" class="">Anamnesa</label><br/>
                    <?php echo html_entity_decode($sql_medc_rm_rw->anamnesa); ?>
                    <?php // echo form_textarea(array('name' => 'anamnesa', 'class' => 'form-control pull-left rounded-0', 'placeholder' => 'Isikan Anamnesa ...', 'rows' => '10', 'value' => $sql_medc_rm_rw->anamnesa, 'disabled'=>'TRUE')) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="">Pemeriksaan</label><br/>
                    <?php echo html_entity_decode($sql_medc_rm_rw->pemeriksaan); ?>
                    <?php // echo form_textarea(array('name' => 'pemeriksaan', 'class' => 'form-control pull-left rounded-0', 'placeholder' => 'Isikan Pemeriksaan ...', 'rows' => '10', 'value' => $sql_medc_rm_rw->pemeriksaan, 'disabled'=>'TRUE')) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputEmail3" class="">Diagnosa</label><br/>
                    <?php echo html_entity_decode($sql_medc_rm_rw->diagnosa); ?>
                    <?php // echo form_textarea(array('name' => 'diagnosa', 'class' => 'form-control pull-left rounded-0', 'placeholder' => 'Isikan Diagnosa ...', 'rows' => '10', 'value' => $sql_medc_rm_rw->diagnosa, 'disabled'=>'TRUE')) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="">Program</label><br/>
                    <?php echo html_entity_decode($sql_medc_rm_rw->program); ?>
                    <?php // echo form_textarea(array('name' => 'program', 'class' => 'form-control pull-left rounded-0', 'placeholder' => 'Isikan Program ...', 'rows' => '10', 'value' => $sql_medc_rm_rw->program, 'disabled'=>'TRUE')) ?>
                </div>
            </div>
        </div>    
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="inputEmail3" class="">Terapi</label><br/>
                    <?php echo ($sql_medc_rm_rw->terapi); ?>
                    <?php // echo form_textarea(array('name' => 'terapi', 'class' => 'form-control pull-left rounded-0', 'placeholder' => 'Isikan Terapi ...', 'rows' => '10', 'value' => $sql_medc_rm_rw->terapi, 'disabled'=>'TRUE')) ?>
                </div>
            </div>
            <div class="col-md-12">
                    <table class="table table-sm">
                        <tr>
                            <td style="width: 75px;"><small>Suhu</small></td>
                            <td style="width: 10px;" class="text-center"><small>:</small></td>
                            <td style="width: 80px;"><small><?php echo (float)$sql_medc_rm_rw->ttv_st ?> &deg;C</small></td>
                            <td style="width: 75px;"><small>BB</small></td>
                            <td style="width: 10px;" class="text-center"><small>:</small></td>
                            <td style="width: 80px;;"><small><?php echo (float)$sql_medc_rm_rw->ttv_bb ?> Kg</small></td>
                        </tr>
                        <tr>
                            <td style="width: 75px;"><small>TB</small></td>
                            <td style="width: 10px;" class="text-center"><small>:</small></td>
                            <td style="width: 80px;"><small><?php echo (float)$sql_medc_rm_rw->ttv_tb ?> Cm</small></td>
                            <td style="width: 75px;"><small>Nadi</small></td>
                            <td style="width: 10px;" class="text-center"><small>:</small></td>
                            <td style="width: 80px;"><small><?php echo (float)$sql_medc_rm_rw->ttv_nadi ?> / Menit</small></td>
                        </tr>
                        <tr>
                            <td style="width: 75px;"><small>Sistole</small></td>
                            <td style="width: 10px;" class="text-center"><small>:</small></td>
                            <td style="width: 80px;"><small><?php echo (float)$sql_medc_rm_rw->ttv_sistole ?> mmHg</small></td>
                            <td style="width: 75px;"><small>Diastole</small></td>
                            <td style="width: 10px;" class="text-center"><small>:</small></td>
                            <td style="width: 80px;;"><small><?php echo (float)$sql_medc_rm_rw->ttv_diastole ?> mmHg</small></td>
                        </tr>
                        <tr>
                            <td style="width: 75px;"><small>Laju Nafas</small></td>
                            <td style="width: 10px;" class="text-center"><small>:</small></td>
                            <td style="width: 80px;"><small><?php echo (float)$sql_medc_rm_rw->ttv_laju ?> / Menit</small></td>
                            <td style="width: 75px;"><small>Saturasi</small></td>
                            <td style="width: 10px;" class="text-center"><small>:</small></td>
                            <td style="width: 80px;"><small><?php echo (float)$sql_medc_rm_rw->ttv_saturasi ?> %</small></td>
                        </tr>
                        <tr>
                            <td style="width: 75px;"><small>Nyeri</small></td>
                            <td style="width: 10px;" class="text-center"><small>:</small></td>
                            <td style="width: 80px;"><small><?php echo (float)$sql_medc_rm_rw->ttv_skala ?></small></td>
                            <td style="width: 75px;"><small></small></td>
                            <td style="width: 10px;" class="text-center"><small></small></td>
                            <td style="width: 80px;"><small></small></td>
                        </tr>
                    </table>
            </div>
        </div>    
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route').(isset($_GET['status']) ? '&status='.$this->input->get('status') : '') : 'medcheck/tambah.php?id=' . general::enkrip((float)$sql_medc_rm_rw->id) . '&status=7') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">
                
            </div>
        </div>                            
    </div>
</div>