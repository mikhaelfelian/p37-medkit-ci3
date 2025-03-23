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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('medcheck/tambah.php') ?>">Tambah</a></li>
                        <li class="breadcrumb-item"><a href="#">Anamnesa</a></li>
                        <li class="breadcrumb-item active">Pemeriksaan</li>
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
                <div class="col-md-12">
                    <?php echo form_open_multipart(base_url('medcheck/set_medcheck_upd.php'), 'autocomplete="off"') ?>
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Medical Checkup</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php $hasError = $this->session->flashdata('form_error'); ?>
                                    <?php echo form_hidden('id', $this->input->get('id')) ?>
                                    <?php echo form_hidden('status', '3') ?>
                                    
                                    <div class="form-group <?php echo (!empty($hasError['pasien']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Nama Pasien</label>
                                        <div class="input-group mb-3">
                                            <?php echo form_input(array('id' => 'pasien', 'name' => 'pasien', 'class' => 'form-control text-middle'.(!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'value' => $sql_pasien->nama_pgl, 'disabled'=>'true')) ?>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-plus"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group <?php echo (!empty($hasError['tipe']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Tipe</label>

                                        <select name="tipe" class="form-control <?php echo (!empty($hasError['tipe']) ? ' is-invalid' : '') ?>" disabled>
                                            <option value="">- Tipe -</option>
                                            <option value="2" <?php echo ($sql_medc->tipe == '2' ? 'selected' : '') ?>>Rawat Jalan</option>
                                            <option value="3" <?php echo ($sql_medc->tipe == '3' ? 'selected' : '') ?>>Rawat Inap</option>
                                        </select>
                                    </div>
                                    <div class="form-group <?php echo (!empty($hasError['poli']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Klinik</label>
                                        <select name="poli" class="form-control <?php echo (!empty($hasError['poli']) ? ' is-invalid' : '') ?>" disabled>
                                            <option value="">- Poli -</option>
                                            <?php foreach ($poli as $poli) { ?>
                                                <option value="<?php echo $poli->id ?>" <?php echo ($sql_medc->id_poli == $poli->id ? 'selected' : '') ?>><?php echo $poli->lokasi ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group <?php echo (!empty($hasError['dokter']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Dokter Utama</label>
                                        <select name="dokter" class="form-control <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>" disabled>
                                            <option value="">- Tipe -</option>
                                            <?php foreach ($sql_doc as $doctor) { ?>
                                                <option value="<?php echo $doctor->id ?>" <?php echo ($sql_medc->id_dokter == $doctor->id ? 'selected' : '') ?>><?php echo strtoupper($doctor->nama) ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group <?php // echo (!empty($hasError['pasien']) ? 'has-error' : '')       ?>">
                                        <label class="control-label">Petugas</label>
                                        <div class="input-group mb-3">
                                            <?php echo form_input(array('id' => 'petugas', 'name' => 'petugas', 'class' => 'form-control pull-right', 'placeholder' => 'Nama Petugas ...', 'value'=>$this->ion_auth->user($sql_medc->id_user)->row()->first_name, 'disabled'=>'true')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group <?php // echo (!empty($hasError['keluhan']) ? 'has-error' : '')       ?>">
                                        <label class="control-label">Keluhan</label>
                                        <div class="input-group mb-3">
                                            <?php echo form_textarea(array('id' => 'anamnesa', 'name' => 'anamnesa', 'class' => 'form-control pull-right', 'value' => $sql_medc->keluhan, 'style'=>'height: 211px;', 'readonly'=>'true')) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group <?php // echo (!empty($hasError['keluhan']) ? 'has-error' : '')       ?>">
                                        <label class="control-label">Anamnesa</label>
                                        <div class="input-group mb-3">
                                            <?php echo form_textarea(array('id' => 'anamnesa', 'name' => 'anamnesa', 'class' => 'form-control pull-right', 'value' => $sql_medc->anamnesa,'placeholder' => 'Tindakan Anamnesa ...', 'style'=>'height: 211px;', 'readonly'=>'true')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group <?php // echo (!empty($hasError['keluhan']) ? 'has-error' : '')       ?>">
                                        <label class="control-label">Pemeriksaan</label>
                                        <div class="input-group mb-3">
                                            <?php echo form_textarea(array('id' => 'pemeriksaan', 'name' => 'pemeriksaan', 'class' => 'form-control pull-right', 'value' => $sql_medc->pemeriksaan, 'placeholder' => 'Tindakan Pemeriksaan ...', 'style'=>'height: 211px;')) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <!--<button type="button" onclick="window.location.href = '<?php echo base_url('master/data_kategori_list.php') ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>-->
                                </div>
                                <div class="col-lg-6 text-right">
                                    <button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-undo"></i> Bersih</button>
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

<!-- Page script -->
<script type="text/javascript">
    $(function () {

    });
</script>