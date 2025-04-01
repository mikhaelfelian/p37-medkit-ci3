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
                        <li class="breadcrumb-item active">Periksa</li>
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
                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakDokter() == TRUE) { ?>
                        <?php echo form_open(base_url('medcheck/set_medcheck_icd.php'), 'autocomplete="off"') ?>
                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                        <?php echo form_hidden('status', '1') ?>
                        <?php echo form_hidden('status_icd', '1') ?>
                        <input type="hidden" id="id_icd" name="icd" value="<?php // echo $sql_icd->id    ?>">

                    <!-- Default box -->                    
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">DIAGNOSA ICD 10 - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="input-group mt-2">
                                    <select id="icd" class="form-control select2bs4">
                                        <option value="">Isikan ICD 10 ...</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-<?php echo (!empty($hasError['icd']) ? 'danger' : 'primary') ?> btn-flat">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" id="selected_icd_display" name="selected_icd_display" value="">
                            </div>
                            <hr/>
                            <?php $sql_medc_icd = $this->db->where('id_medcheck', $sql_medc->id)->where('status_icd', '1')->get('tbl_trans_medcheck_icd'); ?>
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
                        <?php if (akses::hakPerawat() == TRUE) { ?>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                    </div>
                                    <div class="col-lg-6 text-right">

                                    </div>
                                </div>                            
                            </div>
                        <?php } ?>
                    </div>
                    <!-- /.card -->
                    <?php echo form_close() ?>
                    <?php } ?>
                    
                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakDokter() == TRUE OR akses::hakPerawat() == TRUE OR akses::hakFisioterapi() == TRUE) { ?>
                        <?php $hasError = $this->session->flashdata('form_error'); ?>
                        <?php echo form_open(base_url('medcheck/set_medcheck_upd.php'), 'autocomplete="off"') ?>
                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                        <?php echo form_hidden('status', '2') ?>
                        <?php echo form_hidden('route', '&status=1') ?>
                        <?php echo form_hidden('tgl_periksa', date('Y-m-d H:i:s')) ?>

                        <!-- Default box -->               
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">PEMERIKSAAN - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
                            </div>
                            <div class="card-body">
                                <?php echo $this->session->flashdata('medcheck'); ?>
                                <div class="row">
                                    <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                                        <?php $hasError = $this->session->flashdata('form_error'); ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Anamnesa</label>
                                                    <div class="input-group mb-3">
                                                        <?php echo form_textarea(array('id' => 'anamnesa', 'name' => 'anamnesa', 'class' => 'form-control rounded-0 pull-right' . (!empty($hasError['anamnesa']) ? ' is-invalid' : ''), 'value' => $sql_medc->anamnesa, 'placeholder' => 'Isikan Anamnesa ...', 'style' => 'height: 123px;')) ?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Pemeriksaan</label>
                                                    <div class="input-group mb-3">
                                                        <?php echo form_textarea(array('id' => 'pemeriksaan', 'name' => 'pemeriksaan', 'class' => 'form-control rounded-0 pull-right', 'value' => $sql_medc->pemeriksaan, 'placeholder' => 'Isikan Pemeriksaan ...', 'style' => 'height: 123px;')) ?>
                                                    </div>
                                                </div>
                                                <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE OR akses::hakPerawat() == TRUE OR akses::hakFisioterapi() == TRUE) { ?>
                                                    <div class="form-group">
                                                        <label class="control-label">Keluhan</label>
                                                        <div class="input-group mb-3">
                                                            <?php echo form_textarea(array('id' => 'keluhan', 'name' => 'keluhan', 'class' => 'form-control rounded-0 pull-right', 'value' => $sql_medc->keluhan, 'placeholder' => 'Isikan Keluhan ...', 'style' => 'height: 211px;')) ?>
                                                        </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <?php echo form_hidden('keluhan', $sql_medc->keluhan) ?>
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Diagnosa</label>
                                                    <div class="input-group mb-3">
                                                        <?php echo form_textarea(array('id' => 'diagnosa', 'name' => 'diagnosa', 'class' => 'form-control rounded-0 pull-right', 'value' => $sql_medc->diagnosa, 'placeholder' => 'Isikan Diagnosa ...', 'style' => 'height: 123px;')) ?>
                                                    </div>
                                                </div>
                                                <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE OR akses::hakDokter() == TRUE OR akses::hakFisioterapi() == TRUE) { ?>
                                                    <div class="form-group">
                                                        <label class="control-label">Program</label>
                                                        <div class="input-group mb-3">
                                                            <?php echo form_textarea(array('id' => 'program', 'name' => 'program', 'class' => 'form-control rounded-0 pull-right', 'value' => $sql_medc->program, 'placeholder' => 'Isikan Program (Khusus Dokter) ...', 'style' => 'height: 123px;')) ?>
                                                        </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <?php echo form_hidden('program', $sql_medc->program) ?>
                                                <?php } ?>

                                                <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE OR akses::hakPerawat() == TRUE) { ?>
                                                    <div class="form-group">
                                                        <label class="control-label">Alergi</label>
                                                        <div class="input-group mb-3">
                                                            <?php echo form_textarea(array('id' => 'alergi', 'name' => 'alergi', 'class' => 'form-control rounded-0 pull-right', 'value' => $sql_medc->alergi, 'placeholder' => 'Isikan Alergi ...', 'style' => 'height: 211px;')) ?>
                                                        </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <?php echo form_hidden('alergi', $sql_medc->alergi) ?>
                                                <?php } ?>

                                                <!--
                                                <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE OR akses::hakPerawat() == TRUE) { ?>
                                                            <div class="form-group">
                                                                <label class="control-label">TTV</label>
                                                                <div class="input-group mb-3">
                                                    <?php echo form_textarea(array('id' => 'ttv', 'name' => 'ttv', 'class' => 'form-control rounded-0 pull-right', 'value' => $sql_medc->ttv, 'placeholder' => 'Isikan TTV ...', 'style' => 'height: 211px;')) ?>
                                                                </div>
                                                            </div>
                                                <?php } else { ?>
                                                    <?php echo form_hidden('ttv', $sql_medc->ttv) ?>
                                                <?php } ?>
                                                -->
                                            </div>
                                        </div>

                                        <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE OR akses::hakPerawat() == TRUE) { ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Suhu Tubuh</label>
                                                        <div class="col-sm-3">
                                                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_st', 'class' => 'form-control rounded-0 pull-right', 'placeholder' => 'Suhu Tubuh ...', 'value' => $sql_medc->ttv_st)) ?>
                                                        </div>
                                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Berat Badan</label>
                                                        <div class="col-sm-3">
                                                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_bb', 'class' => 'form-control rounded-0 pull-right', 'placeholder' => 'Berat Badan ...', 'value' => $sql_medc->ttv_bb)) ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Tinggi Badan</label>
                                                        <div class="col-sm-3">
                                                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_tb', 'class' => 'form-control rounded-0 pull-right', 'placeholder' => 'Tinggi Badan ...', 'value' => $sql_medc->ttv_tb)) ?>
                                                        </div>
                                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Nadi</label>
                                                        <div class="col-sm-3">
                                                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_nadi', 'class' => 'form-control rounded-0 pull-right', 'placeholder' => 'Tinggi Badan ...', 'value' => $sql_medc->ttv_nadi)) ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Sistole</label>
                                                        <div class="col-sm-3">
                                                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_sistole', 'class' => 'form-control rounded-0 pull-right', 'placeholder' => 'Sistole ...', 'value' => $sql_medc->ttv_sistole)) ?>
                                                        </div>
                                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Diastole</label>
                                                        <div class="col-sm-3">
                                                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_diastole', 'class' => 'form-control rounded-0 pull-right', 'placeholder' => 'Diastole ...', 'value' => $sql_medc->ttv_diastole)) ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Laju Napas</label>
                                                        <div class="col-sm-3">
                                                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_laju', 'class' => 'form-control rounded-0 pull-right', 'placeholder' => 'Laju Napas ...', 'value' => $sql_medc->ttv_laju)) ?>
                                                        </div>
                                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Saturasi</label>
                                                        <div class="col-sm-3">
                                                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_saturasi', 'class' => 'form-control rounded-0 pull-right', 'placeholder' => 'Saturasi ...', 'value' => $sql_medc->ttv_saturasi)) ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Skala Nyeri</label>
                                                        <div class="col-sm-3">
                                                            <select name="ttv_skala" class="form-control rounded-0">
                                                                <option value="">- Pilih -</option>
                                                                <?php for($a = 0; $a <= 10; $a++){ ?>
                                                                    <option value="<?php echo $a; ?>" <?php echo ($sql_medc->ttv_skala == $a ? 'selected' : '') ?>>Skala <?php echo $a; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } else { 
                                            echo form_hidden('ttv_st', $sql_medc->ttv_st);
                                            echo form_hidden('ttv_bb', $sql_medc->ttv_bb);
                                            echo form_hidden('ttv_tb', $sql_medc->ttv_tb);
                                            echo form_hidden('ttv_sistole', $sql_medc->ttv_sistole);
                                            echo form_hidden('ttv_diastole', $sql_medc->ttv_diastole);
                                            echo form_hidden('ttv_nadi', $sql_medc->ttv_nadi);
                                            echo form_hidden('ttv_laju', $sql_medc->ttv_laju);
                                            echo form_hidden('ttv_saturasi', $sql_medc->ttv_saturasi);
                                            echo form_hidden('ttv_skala', $sql_medc->ttv_skala);
                                            echo form_hidden('ttv_nadi', $sql_medc->ttv_nadi);
                                        }
                                        ?>

                                        <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE OR akses::hakDokter() == TRUE) { ?>
                                            <div class="row">                                  
                                                <div class="col-lg-12">                                                
                                                    <div class="form-group">
                                                        <div class="input-group mb-3">
                                                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                                <?php $sudah = ($sql_medc->status_periksa == '1' ? 'TRUE' : ''); ?>
                                                                <?php echo form_checkbox(array('id' => 'customSwitch3', 'name' => 'status_periksa', 'class' => 'custom-control-input' . (!empty($hasError['status_periksa']) ? ' is-invalid' : ''), 'value' => '1', 'checked' => $sudah)) ?>
                                                                <label class="custom-control-label" for="customSwitch3">Sudah dilakukan pemeriksaan <?php echo (!empty($hasError['status_periksa']) ? '*' : '') ?></label>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                        <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                        <!-- /.card -->
                        <?php echo form_close() ?>
                    <?php } ?>
                </div>
                <div class="col-lg-4">
                    <?php $data['gtotal'] = $gtotal ?>
                    <?php $this->load->view('admin-lte-3/includes/medcheck/med_tindakan_kanan', $data) ?>
                </div>
            </div>            
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<script type="text/javascript">
    $(function () {
        $("input[id=ttv]").autoNumeric({aSep: '.', aDec: ',', aPad: false}); 
        
        // Initialize Select2 for ICD
        $('#icd').select2({
            theme: 'bootstrap4',
            placeholder: 'Isikan ICD 10 ...',
            minimumInputLength: 1,
            ajax: {
                url: "<?php echo base_url('medcheck/json_icd.php?status=2') ?>",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: '[' + item.kode + '] ' + item.diagnosa_en,
                                id: item.id,
                                kode: item.kode,
                                diagnosa_en: item.diagnosa_en
                            };
                        })
                    };
                },
                cache: true
            }
        }).on('select2:select', function (e) {
            var data = e.params.data;
            $('#id_icd').val(data.id);
            $('#selected_icd_display').val('[' + data.kode + '] ' + data.diagnosa_en);
        });
        
        $('.select2-container--bootstrap4 .select2-selection').addClass('rounded-0');
    });
</script>