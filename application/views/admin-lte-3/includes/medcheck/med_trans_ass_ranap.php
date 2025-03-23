<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Medical Checkup</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('medcheck/index.php') ?>">Medical Checkup</a></li>
                        <li class="breadcrumb-item active">Assesment Rawat Inap</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <?php $hasError = $this->session->flashdata('form_error'); ?>
                    <?php echo form_open_multipart(base_url('medcheck/set_medcheck_ass_ranap.php'), 'autocomplete="off"') ?>
                    <?php echo form_hidden('id', $this->input->get('id')) ?>
                    <?php echo form_hidden('id_ass', $sql_ass_rnp->id) ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">MODUL ASSESMENT RAWAT INAP - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Keluhan Utama</label>
                                        <div class="input-group mb-3">
                                            <?php echo form_input(array('id' => 'keluhan', 'name' => 'keluhan', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['keluhan']) ? ' is-invalid' : ''), 'value' => $sql_ass_rnp->keluhan, 'placeholder' => 'Isikan Keluhan Utama ...')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Riwayat Penyakit Sekarang</label>
                                        <div class="input-group mb-3">
                                            <?php echo form_textarea(array('id' => 'riwayat_skg', 'name' => 'riwayat_skg', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['riwayat']) ? ' is-invalid' : ''), 'value' => $sql_ass_rnp->riwayat_skg, 'placeholder' => 'Isikan Riwayat ...', 'style' => 'height: 123px;')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Pemeriksaan Fisik</label>
                                        <div class="input-group mb-3">
                                            <?php echo form_textarea(array('id' => 'pemeriksaan', 'name' => 'pemeriksaan', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['riwayat']) ? ' is-invalid' : ''), 'value' => $sql_ass_rnp->pemeriksaan, 'placeholder' => 'Isikan Pemeriksaan Fisik ...', 'style' => 'height: 123px;')) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Penyakit yang pernah diderita</label>
                                        <div class="input-group mb-3">
                                            <?php echo form_input(array('id' => 'penyakit', 'name' => 'penyakit', 'class' => 'form-control pull-right rounded-0', 'value' => $sql_ass_rnp->penyakit, 'placeholder' => 'Isikan Penyakit Pasien ...')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Riwayat Penyakit Keluarga</label>
                                        <div class="input-group mb-3">
                                            <?php echo form_input(array('id' => 'riwayat_klg', 'name' => 'riwayat_klg', 'class' => 'form-control pull-right rounded-0', 'value' => $sql_ass_rnp->riwayat_klg, 'placeholder' => 'Isikan riwayat penyakit keluarga ...')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Skala Nyeri</label>
                                        <div class="input-group mb-3">
                                            <select name="skala_nyeri" class="form-control rounded-0">
                                                <option value="">- Pilih -</option>
                                                <?php for($a = 0; $a <= 10; $a++){ ?>
                                                    <option value="<?php echo $a; ?>" <?php echo ($sql_ass_rnp->skala_nyeri == $a ? 'selected' : '') ?>>Skala <?php echo $a; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                <?php $sudah = ($sql_ass_rnp->status_rnp == '1' ? 'TRUE' : ''); ?>
                                                <?php echo form_checkbox(array('id' => 'customSwitch3', 'name' => 'status_rnp', 'class' => 'custom-control-input' . (!empty($hasError['status_rnp']) ? ' is-invalid' : ''), 'value' => '1', 'checked' => $sudah)) ?>
                                                <label class="custom-control-label" for="customSwitch3">Ya, saya pernah rawat inap <?php echo (!empty($hasError['status_rnp']) ? '*' : '') ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Masalah Keperawatan</label>
                                        <div class="input-group mb-3">
                                            <?php echo form_textarea(array('id' => 'askep_mslh', 'name' => 'askep_mslh', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['riwayat']) ? ' is-invalid' : ''), 'value' => $sql_ass_rnp->askep_masalah, 'placeholder' => 'Isikan Masalah Keperawatan ...', 'style' => 'height: 123px;')) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tujuan Terukur</label>
                                        <div class="input-group mb-3">
                                            <?php echo form_textarea(array('id' => 'askep_7an', 'name' => 'askep_7an', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['riwayat']) ? ' is-invalid' : ''), 'value' => $sql_ass_rnp->askep_tujuan, 'placeholder' => 'Isikan Tujuan Terukur ...', 'style' => 'height: 123px;')) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <a href="<?php echo base_url('medcheck/surat/cetak_pdf_ass_rnp.php?id='.general::enkrip($sql_medc->id)) ?>" class="btn btn-success btn-flat"><i class="fa fa-print"></i> Cetak</a>
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>                            
                        </div>
                    </div>

                    <?php echo form_close() ?>

                    <?php if (!empty($sql_ass_rnp)) { ?>
                        <?php echo form_open_multipart(base_url('medcheck/set_medcheck_ass_ranap_obt.php'), 'autocomplete="off"') ?>
                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                        <?php echo form_hidden('id_ass', $sql_ass_rnp->id) ?>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">RIWAYAT MINUM OBAT RAWAT INAP - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row <?php echo (!empty($hasError['kary_tambah']) ? 'text-danger' : '') ?>">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">Jenis Obat</label>
                                            <div class="col-sm-6">
                                                <?php echo form_input(array('id' => 'param', 'name' => 'param', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['param']) ? ' is-invalid' : ''), 'placeholder' => 'Tulis nama obat ...')) ?>
                                            </div>
                                            <div class="col-sm-2">
                                                <?php echo form_input(array('id' => 'param_nilai', 'name' => 'param_nilai', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['param_nilai']) ? ' is-invalid' : ''), 'placeholder' => 'Cth: 1 TAB ...')) ?>
                                            </div>
                                            <div class="col-sm-2">
                                                <button class="btn btn-primary btn-flat" type="submit">
                                                    <i class="fa fa-save"></i>
                                                </button>
                                            </div>
                                            <hr/>
                                            <br/>
                                            <br/>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Jenis Obat</th>
                                                        <th>Jml</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1; ?>
                                                    <?php foreach ($sql_ass_rnp_obt as $obt) { ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $no; ?></td>
                                                            <td><?php echo $obt->param; ?></td>
                                                            <td><?php echo $obt->param_nilai; ?></td>
                                                            <td>
                                                                <?php echo anchor(base_url('medcheck/set_medcheck_ass_ranap_obt_hps.php?id=' . general::enkrip($obt->id) . '&id_medc=' . $this->input->get('id') . '&status=' . $this->input->get('status')), '<i class="fa fa-trash"></i>', 'class="text-danger" onclick="return confirm(\'Hapus ?\')"') ?>
                                                            </td>
                                                        </tr>
                                                        <?php $no++ ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    <?php } ?>

                </div>
                <div class="col-lg-4">
                    <?php $data['gtotal'] = $gtotal ?>
                    <?php $this->load->view('admin-lte-3/includes/medcheck/med_tindakan_kanan', $data) ?>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $("#tgl_masuk").datepicker({
            dateFormat: 'dd-mm-yy',
            SetDate: new Date(),
            autoclose: true
        });

        // Select2   
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
<?php echo $this->session->flashdata('medcheck_toast'); ?>
    });
</script>