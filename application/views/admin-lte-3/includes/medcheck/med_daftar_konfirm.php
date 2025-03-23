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
                        <li class="breadcrumb-item active">KonfirmasiPendaftaran</li>
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
                <div class="row">
                    <div class="col-md-3">
                        <?php echo form_open(base_url('medcheck/daftar_konf_simpan.php'), 'autocomplete="off"') ?>
                        <?php echo form_hidden('id', $_GET['dft']) ?>
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Konfirmasi Pendaftaran</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <div class="form-group <?php echo (!empty($hasError['nama']) ? 'text-danger' : '') ?>">
                                    <label class="control-label">Antrian</label>
                                    <?php echo form_input(array('id' => 'no_antrian', 'name' => 'no_antrian', 'class' => 'form-control', 'value' => $sql_dft_id->no_urut)) ?>
                                </div>                                         
                                <div class="form-group <?php echo (!empty($hasError['jns_klm']) ? 'text-danger' : '') ?>">
                                    <label class="control-label">Status</label>
                                    <br/>
                                    <input type="radio" name="status_hdr" value="0" id=""> Tidak Hadir
                                    <?php echo nbs(2) ?>
                                    <input type="radio" name="status_hdr" value="1" checked="true" id=""> Hadir
                                </div>                               
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-flat btn-block"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>

                    <div class="col-md-9">
                        <?php echo form_open(base_url('medcheck/daftar_' . (isset($_GET['id']) ? 'update' : 'simpan') . '.php'), 'autocomplete="off"') ?>
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Data Pasien</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-right">
                                        <?php echo $pagination ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <?php echo $this->session->flashdata('master'); ?>
                                <?php $hasError = $this->session->flashdata('form_error'); ?>
                                <?php echo form_hidden('id', general::enkrip($pasien->id)) ?>
                                <input type="hidden" id="file" name="file">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group <?php echo (!empty($hasError['nik']) ? 'text-danger' : '') ?>">
                                            <label class="control-label">NIK* <small><i>(* KTP / Passport / KIA)</i></small></label>
                                            <?php echo form_input(array('id' => 'nik', 'name' => 'nik', 'class' => 'form-control' . (!empty($hasError['nik']) ? ' is-invalid' : ''), 'value' => $pasien->nik, 'value' => $sql_dft_id->nik, 'readonly' => 'TRUE')) ?>
                                        </div>
                                        <section id="pasien_lama">
                                            <div class="form-group <?php // echo (!empty($hasError['no_rm']) ? 'text-danger' : '')                   ?>">
                                                <label class="control-label">No RM* <small><i>(* Nomor Rekam Medis)</i></small></label>
                                                <div class="input-group mb-3">
                                                    <?php echo form_input(array('id' => 'no_rm', 'name' => 'no_rm', 'class' => 'form-control' . (!empty($hasError['nik']) ? ' is-invalid' : ''), 'value' => $pasien->nik, 'placeholder' => 'Nomor Rekam Medis ...')) ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>

                                        <section id="pasien_baru1">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="form-group <?php echo (!empty($hasError['gelar']) ? 'text-danger' : '') ?>">
                                                        <label class="control-label">Gelar*</label>
                                                        <select name="gelar" class="form-control <?php echo (!empty($hasError['gelar']) ? 'is-invalid' : '') ?>" readonly="TRUE">
                                                            <option value="">- Pilih -</option>
                                                            <?php foreach ($gelar as $gelar) { ?>
                                                                <option value="<?php echo $gelar->id ?>" <?php echo ($gelar->id == $sql_dft_id->id_gelar ? 'selected' : '') ?>><?php echo $gelar->gelar ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-9">
                                                    <div class="form-group <?php echo (!empty($hasError['nama']) ? 'text-danger' : '') ?>">
                                                        <label class="control-label">Nama Lengkap*</label>
                                                        <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'value' => $sql_dft_id->nama, 'readonly' => 'TRUE')) ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group <?php echo (!empty($hasError['jns_klm']) ? 'text-danger' : '') ?>">
                                                <label class="control-label">Jenis Kelamin*</label>
                                                <select name="jns_klm" class="form-control <?php echo (!empty($hasError['jns_klm']) ? 'is-invalid' : '') ?>" readonly="TRUE">
                                                    <option value="">- Pilih -</option>
                                                    <option value="L" <?php echo ('L' == $sql_dft_id->jns_klm ? 'selected' : '') ?>>Laki - laki</option>
                                                    <option value="P" <?php echo ('P' == $sql_dft_id->jns_klm ? 'selected' : '') ?>>Perempuan</option>
                                                </select>
                                            </div>

                                            <div class="form-group <?php echo (!empty($hasError['tmp_lahir']) ? 'has-error' : '') ?>">
                                                <label class="control-label">Tempat Lahir</label>
                                                <?php echo form_input(array('id' => 'tmp_lahir', 'name' => 'tmp_lahir', 'class' => 'form-control', 'value' => $sql_dft_id->tmp_lahir, 'readonly' => 'TRUE')) ?>
                                            </div>

                                            <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                                <label class="control-label">Tgl Lahir</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                    </div>
                                                    <?php echo form_input(array('id' => 'tgl_lahir', 'name' => 'tgl_lahir', 'class' => 'form-control', 'value' => $sql_dft_id->tgl_lahir, 'readonly' => '15/02/1992 ...')) ?>
                                                </div>                                        
                                            </div>
                                            <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                                <label class="control-label">No. HP</label>
                                                <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control', 'value' => $sql_dft_id->no_hp, 'readonly' => 'TRUE')) ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Instansi / Perusahaan</label>
                                                <?php echo form_input(array('id' => 'instansi', 'name' => 'instansi', 'class' => 'form-control', 'value' => (!empty($sql_dft_id->instansi) ? $sql_dft_id->instansi : $this->session->flashdata('instansi')), 'placeholder' => 'Isikan nama Instansi / Perusahaan ...', 'readonly' => 'TRUE')) ?>
                                            </div>
                                        </section>
                                    </div>
                                    <div class="col-md-6">
                                        <section id="pasien_baru2">
                                            <div class="form-group <?php echo (!empty($hasError['nik']) ? 'has-error' : '') ?>">
                                                <label class="control-label">Alamat <small><i>* Sesuai Identitas</i></small></label>
                                                <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control', 'value' => $sql_dft_id->alamat, 'style' => 'height: 124px;', 'readonly' => 'TRUE')) ?>
                                            </div>
                                            <div class="form-group <?php echo (!empty($hasError['nik']) ? 'has-error' : '') ?>">
                                                <label class="control-label">Alamat Domisili<small><i>* Sesuai Domisili</i></small></label>
                                                <?php echo form_textarea(array('id' => 'alamat_dom', 'name' => 'alamat_dom', 'class' => 'form-control', 'value' => $sql_dft_id->alamat_dom, 'style' => 'height: 124px;', 'readonly' => 'TRUE')) ?>
                                            </div>

                                            <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                                <label class="control-label">Pekerjaan</label>
                                                <select name="pekerjaan" class="form-control" readonly="TRUE">
                                                    <option value="">- Pilih -</option>
                                                    <?php foreach ($kerja as $kerja) { ?>
                                                        <option value="<?php echo $kerja->id ?>" <?php echo ($kerja->id == $sql_dft_id->id_pekerjaan ? 'selected' : '') ?>><?php echo $kerja->jenis ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                                <label class="control-label">No. Rmh</label>
                                                <?php echo form_input(array('id' => 'no_rmh', 'name' => 'no_rmh', 'class' => 'form-control', 'value' => $sql_dft_id->no_rmh, 'readonly' => 'TRUE')) ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Alamat Instansi</label>
                                                <?php echo form_input(array('id' => 'instansi_almt', 'name' => 'instansi_almt', 'class' => 'form-control', 'value' => (!empty($sql_dft_id->instansi_alamat) ? $sql_dft_id->instansi_alamat : $this->session->flashdata('instansi_alamat')), 'placeholder' => 'Isikan alamat lengkapnya ...', 'readonly' => 'TRUE')) ?>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="form-group <?php echo (!empty($hasError['poli']) ? 'text-danger' : '') ?>">
                                            <label class="control-label">Poli</label>
                                            <select name="poli" class="form-control <?php echo (!empty($hasError['poli']) ? ' is-invalid' : '') ?>" readonly="TRUE">
                                                <option value="">- Poli -</option>
                                                <?php foreach ($poli as $poli) { ?>
                                                    <option value="<?php echo $poli->id ?>" <?php echo ($poli->id == $sql_dft_id->id_poli ? 'selected' : '') ?>><?php echo $poli->lokasi ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['dokter']) ? 'text-danger' : '') ?>">
                                            <label class="control-label">Dokter</label>
                                            <select name="dokter" class="form-control <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>" readonly="TRUE">
                                                <option value="">- Dokter -</option>
                                                <?php foreach ($sql_doc as $doctor) { ?>
                                                    <option value="<?php echo $doctor->id_user ?>" <?php echo ($doctor->id_user == $sql_dft_id->id_dokter ? 'selected' : '') ?>><?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn.' ' : '').strtoupper($doctor->nama).(!empty($doctor->nama_blk) ? ', '.$doctor->nama_blk : '') ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['jns_klm']) ? 'text-danger' : '') ?>">
                                            <label class="control-label">Tgl Periksa*</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                </div>
                                                <?php echo form_input(array('id' => 'tgl_masuk', 'name' => 'tgl_masuk', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'value' => $sql_dft_id->tgl_masuk, 'readonly' => 'TRUE')) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-6">

                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <!--<button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-user-plus"></i> Daftar</button>-->
                                    </div>
                                </div>                            
                            </div>
                        </div>
                    </div>
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
    $("#pasien_lama").hide();
    $("#pasien_baru").show();

    $("#pas_lama").click(function () {
        $("#pasien_baru").hide();
        $("#foto_pasien").hide();
        $("#pasien_lama").show();
    });

    $("#pas_baru").click(function () {
        $("#pasien_baru").show();
        $("#foto_pasien").show();
        $("#pasien_lama").hide();
    });

    $("#tgl_lahir").datepicker({
        format: 'dd/mm/yyyy',
        changeMonth: true,
        changeYear: true,
        yearRange: '1920:<?php echo date('Y') ?>',
        autoclose: true
    });

    var dateToday = new Date();
    $("#tgl_masuk").datepicker({
        format: 'dd/mm/yyyy',
        defaultDate: "+1w",
        changeMonth: true,
        minDate: dateToday,
        autoclose: true
    });
</script>