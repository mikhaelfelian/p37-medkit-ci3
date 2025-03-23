<?php $sql_icd_rm = $this->db->where('id', $sql_medc_rm_rw->id_icd)->get('tbl_m_icd')->row() ?>
<?php $sql_icd10_rm = $this->db->where('id', $sql_medc_rm_rw->id_icd10)->get('tbl_m_icd')->row() ?>
<?php $hasError = $this->session->flashdata('form_error'); ?>
<?php
    $anamnesa   = $this->session->flashdata('anamnesa');
    $priksa     = $this->session->flashdata('pemeriksaan');
    $diagnos    = $this->session->flashdata('diagnosa');
    $program    = $this->session->flashdata('program');
    $terapi     = $this->session->flashdata('terapi');
    $ttv_st     = $this->session->flashdata('ttv_st');
    $ttv_bb     = $this->session->flashdata('ttv_bb');
    $ttv_tb     = $this->session->flashdata('ttv_tb');
    $ttv_sst    = $this->session->flashdata('ttv_sistole');
    $ttv_dst    = $this->session->flashdata('ttv_diastole');
    $ttv_sat    = $this->session->flashdata('ttv_saturasi');
    $ttv_ndi    = $this->session->flashdata('ttv_nadi');
    $ttv_lju    = $this->session->flashdata('ttv_laju');
    $ttv_skl    = $this->session->flashdata('ttv_skala');
?>

<?php if (!empty($sql_medc_rm_rw->id)) { ?>
    <?php echo form_open_multipart(base_url('medcheck/set_medcheck_icd.php'), 'autocomplete="off"') ?>
    <?php echo form_hidden('id', $this->input->get('id')) ?>
    <?php echo form_hidden('id_rm', general::enkrip($sql_medc_rm_rw->id)) ?>
    <?php echo form_hidden('status', '1') ?>
    <?php echo form_hidden('status_icd', '2') ?>
    <?php echo form_hidden('route', 'medcheck/tambah.php?act=rm_ubah&id=' . $this->input->get('id') . '&status=7&id_item=' . general::enkrip($sql_medc_rm_rw->id)) ?>
    <input type="hidden" id="id_icd" name="icd" value="<?php // echo $sql_icd->id        ?>">

    <!-- Default box -->                    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">DIAGNOSA ICD 10 - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
        </div>
        <div class="card-body">
            <div class="input-group input-group">
                <?php echo form_input(array('id' => 'icd', 'name' => '', 'class' => 'form-control' . (!empty($hasError['icd']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan ICD 10 menggunakan bahasa inggris ...')) ?>
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-<?php echo (!empty($hasError['icd']) ? 'danger' : 'info') ?> btn-flat"><i class="fa fa-plus"></i></button>
                </span>
            </div>
            <hr/>
            <?php
            $sql_medc_icd = $this->db->where('id_medcheck', $sql_medc->id)->where('id_medcheck_rm', $sql_medc_rm_rw->id)->where('status_icd', '2')->get('tbl_trans_medcheck_icd');
            ?>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th style="width: 50px">Kode</th>
                        <th>Diagnosa</th>
                        <th style="width: 25px"></th>
                    </tr>
                    <?php $no = 1; ?>
                    <?php foreach ($sql_medc_icd->result() as $icd) { ?>
                        <tr>
                            <td><?php echo $no ?>.</td>
                            <td><?php echo $icd->kode ?></td>
                            <td>
                                <?php echo (!empty($icd->icd) ? $icd->icd . ' &raquo;' . br() : '') ?>
                                <small><?php echo $icd->diagnosa_en ?></small>
                            </td>
                            <td>
                                <?php echo anchor(base_url('medcheck/set_medcheck_icd_hps.php?id=' . general::enkrip($sql_medc->id) . '&id_item=' . general::enkrip($icd->id) . '&status=' . $this->input->get('status')), '<i class="fa fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus ?\')" style="width: 60px;"') ?>
                            </td>
                        </tr>
                        <?php $no++ ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <?php echo form_close() ?>
<?php } ?>

<?php $hasError = $this->session->flashdata('form_error'); ?>
<?php echo form_open_multipart(base_url('medcheck/' . (!empty($sql_medc_rm_rw->id) ? 'cart_medcheck_rm_upd' : 'cart_medcheck_rm') . '.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_rm', general::enkrip($sql_medc_rm_rw->id)); ?>
<?php echo form_hidden('id_pasien', general::enkrip($sql_medc->id_pasien)); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">INPUT REKAM MEDIS RAWAT INAP - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body table-responsive">
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 col-form-label">Tanggal Entri</label>
            <div class="col-sm-9">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                    <?php echo form_input(array('id' => '', 'name' => 'tgl', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'value' => (!empty($sql_medc_rm_rw->id) ? $this->tanggalan->tgl_indo($sql_medc_rm_rw->tgl_simpan) : date('d-m-Y')), 'readonly' => 'true')) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputEmail3" class="">Anamnesa*</label>
                    <?php echo form_textarea(array('name' => 'anamnesa', 'class' => 'form-control pull-left rounded-0' . (!empty($hasError['anamnesa']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Anamnesa ...', 'rows' => '10', 'value' => (!empty($anamnesa) ? $anamnesa : html_entity_decode($sql_medc_rm_rw->anamnesa)))) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="">Pemeriksaan*</label>
                    <?php echo form_textarea(array('name' => 'pemeriksaan', 'class' => 'form-control pull-left rounded-0' . (!empty($hasError['pemeriksaan']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Pemeriksaan ...', 'rows' => '10', 'value' => (!empty($priksa) ? $priksa : html_entity_decode($sql_medc_rm_rw->pemeriksaan)))) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputEmail3" class="">Diagnosa*</label>
                    <?php echo form_textarea(array('name' => 'diagnosa', 'class' => 'form-control pull-left rounded-0' . (!empty($hasError['diagnosa']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Diagnosa ...', 'rows' => '10', 'value' => (!empty($diagnos) ? $diagnos : html_entity_decode($sql_medc_rm_rw->diagnosa)))) ?>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="">Program*</label>
                    <?php echo form_textarea(array('name' => 'program', 'class' => 'form-control pull-left rounded-0' . (!empty($hasError['program']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Program ...', 'rows' => '10', 'value' => (!empty($program) ? $program : html_entity_decode($sql_medc_rm_rw->program)))) ?>
                </div>
            </div>
        </div>  
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="inputEmail3" class="">Terapi*</label>
                    <?php echo form_textarea(array('name' => 'terapi', 'class' => 'form-control pull-left rounded-0' . (!empty($hasError['terapi']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Terapi ...', 'rows' => '10', 'value' => (!empty($terapi) ? $terapi : html_entity_decode($sql_medc_rm_rw->terapi)))) ?>
                </div>
            </div>
        </div>

        <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakPerawat() == TRUE) { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Suhu Tubuh*</label>
                        <div class="col-sm-3">
                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_st', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['ttv_st']) ? ' is-invalid' : ''), 'placeholder' => 'Suhu Tubuh ...', 'value' => (!empty($ttv_st) ? $ttv_st : $sql_medc_rm_rw->ttv_st))) ?>
                        </div>
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Berat Badan*</label>
                        <div class="col-sm-3">
                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_bb', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['ttv_bb']) ? ' is-invalid' : ''), 'placeholder' => 'Berat Badan ...', 'value' => (!empty($ttv_bb) ? $ttv_bb : $sql_medc_rm_rw->ttv_bb))) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Tinggi Badan*</label>
                        <div class="col-sm-3">
                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_tb', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['ttv_tb']) ? ' is-invalid' : ''), 'placeholder' => 'Tinggi Badan ...', 'value' => (!empty($ttv_tb) ? $ttv_tb : $sql_medc_rm_rw->ttv_tb))) ?>
                        </div>
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Nadi*</label>
                        <div class="col-sm-3">
                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_nadi', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['ttv_nadi']) ? ' is-invalid' : ''), 'placeholder' => 'Nadi ...', 'value' => (!empty($ttv_ndi) ? $ttv_ndi : $sql_medc_rm_rw->ttv_nadi))) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Sistole*</label>
                        <div class="col-sm-3">
                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_sistole', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['ttv_sistole']) ? ' is-invalid' : ''), 'placeholder' => 'Sistole ...', 'value' => (!empty($ttv_sst) ? $ttv_sst : $sql_medc_rm_rw->ttv_sistole))) ?>
                        </div>
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Diastole*</label>
                        <div class="col-sm-3">
                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_diastole', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['ttv_diastole']) ? ' is-invalid' : ''), 'placeholder' => 'Diastole ...', 'value' => (!empty($ttv_dst) ? $ttv_dst : $sql_medc_rm_rw->ttv_diastole))) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Laju Napas*</label>
                        <div class="col-sm-3">
                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_laju', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['ttv_laju']) ? ' is-invalid' : ''), 'placeholder' => 'Laju Napas ...', 'value' => (!empty($ttv_lju) ? $ttv_st : $sql_medc_rm_rw->ttv_laju))) ?>
                        </div>
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Saturasi*</label>
                        <div class="col-sm-3">
                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_saturasi', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['ttv_saturasi']) ? ' is-invalid' : ''), 'placeholder' => 'Saturasi ...', 'value' => (!empty($ttv_sat) ? $ttv_sat : $sql_medc_rm_rw->ttv_saturasi))) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Skala Nyeri*</label>
                        <div class="col-sm-3">
                            <select name="ttv_skala" class="form-control rounded-0 <?php echo (!empty($hasError['ttv_skala']) ? ' is-invalid' : '') ?>">
                                <option value="">- Pilih -</option>
                                <?php for ($a = 0; $a <= 10; $a++) { ?>
                                    <option value="<?php echo $a; ?>" <?php echo ($sql_medc_rm_rw->ttv_skala == $a  || !empty($sql_medc_rm_rw->ttv_skala) ? 'selected' : '') ?>>Skala <?php echo $a; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') . '&status=7' : 'medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=7') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>                            
    </div>
</div>
<?php echo form_close() ?>

<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<script type="text/javascript">
    $(function () {
        $("input[id=ttv]").autoNumeric({aSep: '', aDec: '.', aPad: false});        
        <?php echo $this->session->flashdata('gudang_toast'); ?>
    });
</script>