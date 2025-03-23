<?php $pengaturan = $this->db->get('tbl_pengaturan')->row(); ?>
<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php // echo $pengaturan->judul ?>
                <small><?php // echo $pengaturan->kota               ?></small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <?php if (!empty($sql_dft)) { ?>
                <?php if ($sql_dft->num_rows() > 0) { ?>
                    <div class="row">
                        <div class="col-md-4"><?php echo nbs() ?></div>
                        <div class="col-md-4">                    
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Pendaftaran Online</h3>
                                </div>
                                <div class="box-body">
                                    <table class="table">
                                        <tr>
                                            <td class="text-center"><?php echo $pengaturan->judul ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center" style="font-size: 12px;"><?php echo $pengaturan->alamat ?></td>
                                        </tr>
                                    </table>                                
                                    <div class="row">
                                        <div class="col-sm-12">                                        
                                            <p class="card-text text-center">
                                                ====================================<br/>
                                                ANTRIAN ONLINE<br/>
                                                <?php echo $sql_poli2->lokasi; ?>
                                            </p>
                                        </div>
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-7">
                                            <div class="error-page">
                                                <h2 class="headline text-primary"><?php echo sprintf('%03d', $sql_dft->row()->no_urut); ?></h2>
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>
                                    <p class="card-text text-center">                                    
                                        <small><i><b><?php echo strtoupper($sql_dft->row()->nama); ?></b></i></small><br/>
                                        <small><i><b><?php echo strtoupper($sql_dokter->nama); ?></b></i></small><br/>
                                        <?php echo $sql_dft->row()->tgl_simpan ?><br/>
                                        TERIMAKASIH ATAS KUNJUNGAN ANDA
                                    </p>
                                </div><div class="box-footer">
        <!--                                <a href="<?php echo base_url('pasien/set_daftar_hapus.php?id=' . general::enkrip($sql_dft->row()->id)) ?>">
                                        <button type="button" class="btn btn-danger btn-flat" onclick="return confirm('Batalkan ?')">Batalkan</button>
                                    </a>-->
                                    <!--<button type="submit" class="btn btn-info pull-right">Sign in</button>-->
                                </div>
                            </div>
                        </div>                    
                        <div class="col-md-4"><?php echo nbs() ?></div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="row">
                    <div class="col-lg-1"><?php echo nbs() ?></div>
                    <div class="col-lg-10">
                        <?php $hasError = $this->session->flashdata('form_error') ?>
                        <?php $msg = $this->session->flashdata('login') ?>
                        <?php echo form_open_multipart(base_url('pasien/set_daftar_baru.php'), 'autocomplete="off"') ?>
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">FORM PENDAFTARAN PASIEN BARU</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group <?php echo (!empty($hasError['nik']) ? 'has-error' : '') ?>">
                                            <label class="control-label">NIK <small><i>(* KTP / Passport / KIA)</i></small></label>
                                            <?php echo form_input(array('id' => 'nik', 'name' => 'nik', 'class' => 'form-control' . (!empty($hasError['nik']) ? ' is-invalid' : ''), 'value' => (!empty($pasien->nik) ? $pasien->nik : $this->session->flashdata('nik_baru')), 'placeholder' => 'Nomor Identitas ...')) ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <div class="form-group <?php echo (!empty($hasError['gelar']) ? 'has-error' : '') ?>">
                                                    <label class="control-label">Gelar*</label>
                                                    <select name="gelar" class="form-control <?php echo (!empty($hasError['gelar']) ? 'is-invalid' : '') ?>">
                                                        <option value="">- Pilih -</option>
                                                        <?php foreach ($gelar as $gelar) { ?>
                                                            <option value="<?php echo $gelar->id ?>" <?php echo ($gelar->id == $pasien->id_gelar ? 'selected' : '') ?>><?php echo $gelar->gelar ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-9">
                                                <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                                    <label class="control-label">Nama Lengkap*</label>
                                                    <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'value' => (!empty($pasien->nama) ? $pasien->nama : $this->session->flashdata('nama')), 'placeholder' => 'John Doe ...')) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['jns_klm']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Jenis Kelamin*</label>
                                            <select name="jns_klm" class="form-control <?php echo (!empty($hasError['jns_klm']) ? 'is-invalid' : '') ?>">
                                                <option value="">- Pilih -</option>
                                                <option value="L" <?php echo (!empty($pasien->jns_klm) ? ('L' == $pasien->jns_klm ? 'selected' : '') : ('L' == $this->session->flashdata('jns_klm') ? 'selected' : '')) ?>>Laki - laki</option>
                                                <option value="P" <?php echo (!empty($pasien->jns_klm) ? ('P' == $pasien->jns_klm ? 'selected' : '') : ('P' == $this->session->flashdata('jns_klm') ? 'selected' : '')) ?>>Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Tempat Lahir</label>
                                            <?php echo form_input(array('id' => 'tmp_lahir', 'name' => 'tmp_lahir', 'class' => 'form-control', 'value' => (!empty($pasien->tmp_lahir) ? $pasien->tmp_lahir : $this->session->flashdata('tmp_lahir')), 'placeholder' => 'Isikan Tempat Lahir ...')) ?>
                                        </div>                           
                                        <div class="form-group <?php echo (!empty($hasError['tgl_lahir']) ? 'has-error' : '') ?>">
                                            <label>Tanggal Lahir</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <?php echo form_input(array('id' => 'tgl_lahir', 'name' => 'tgl_lahir', 'class' => 'form-control', 'value' => (!empty($pasien->tgl_lahir) ? $this->tanggalan->tgl_indo($pasien->tgl_lahir) : $this->session->flashdata('tgl_lahir')), 'placeholder' => 'dd-mm-yyyy ...', 'readonly' => 'TRUE')) ?>
                                            </div>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                            <label class="control-label">No. HP / WA</label>
                                            <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control', 'value' => (!empty($pasien->no_hp) ? $pasien->no_hp : $this->session->flashdata('no_hp')), 'placeholder' => 'Nomor kontak WA pasien / keluarga pasien ...')) ?>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Instansi / Perusahaan</label>
                                            <?php echo form_input(array('id' => 'instansi', 'name' => 'instansi', 'class' => 'form-control', 'value' => (!empty($pasien->instansi) ? $pasien->instansi : $this->session->flashdata('instansi')), 'placeholder' => 'Isikan nama Instansi / Perusahaan ...')) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group <?php echo (!empty($hasError['alamat']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Alamat KTP<small><i>* Sesuai Identitas</i></small></label>
                                            <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control' . (!empty($hasError['alamat']) ? ' is-invalid' : ''), 'value' => (!empty($pasien->alamat) ? $pasien->alamat : $this->session->flashdata('alamat')), 'style' => 'height: 108px;', 'placeholder' => 'Mohon diisi alamat sesuai pada identitas ...')) ?>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['alamat_dom']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Alamat Domisili<small><i>* Sesuai Domisili</i></small></label>
                                            <?php echo form_textarea(array('id' => 'alamat_dom', 'name' => 'alamat_dom', 'class' => 'form-control' . (!empty($hasError['alamat_dom']) ? ' is-invalid' : ''), 'value' => (!empty($pasien->alamat) ? $pasien->alamat : $this->session->flashdata('alamat')), 'style' => 'height: 108px;', 'placeholder' => 'Mohon diisi alamat sesuai domisili ...')) ?>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Pekerjaan</label>
                                            <select name="pekerjaan" class="form-control select2bs4">
                                                <option value="">- Pilih -</option>
                                                <?php foreach ($kerja as $kerja) { ?>
                                                    <option value="<?php echo $kerja->id ?>" <?php echo (!empty($pasien->id_pekerjaan) ? ($kerja->id == $pasien->id_pekerjaan ? 'selected' : '') : (($kerja->id == $this->session->flashdata('pekerjaan') ? 'selected' : ''))) ?>><?php echo $kerja->jenis ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">No. Rmh</label>
                                            <?php echo form_input(array('id' => 'no_rmh', 'name' => 'no_rmh', 'class' => 'form-control', 'value' => (!empty($pasien->no_hp) ? $pasien->no_rmh : $this->session->flashdata('no_rmh')), 'placeholder' => 'Isikan Nomor rumah (PSTN) pasien / keluarga pasien ...')) ?>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Alamat Instansi</label>
                                            <?php echo form_input(array('id' => 'instansi_almt', 'name' => 'instansi_almt', 'class' => 'form-control', 'value' => (!empty($pasien->instansi_alamat) ? $pasien->instansi_alamat : $this->session->flashdata('instansi_alamat')), 'placeholder' => 'Isikan alamat lengkapnya ...')) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group <?php echo (!empty($hasError['platform']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Penjamin</label>
                                            <select id="platform" name="platform" class="form-control rounded-0<?php echo (!empty($hasError['platform']) ? ' is-invalid' : '') ?>">
                                                <option value="">- PENJAMIN -</option>
                                                <?php foreach ($sql_penjamin as $penj) { ?>
                                                    <option value="<?php echo $penj->id ?>"><?php echo $penj->penjamin ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['poli']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Poli</label>
                                            <select id="poli" name="poli" class="form-control select2bs4 <?php echo (!empty($hasError['poli']) ? ' is-invalid' : '') ?>">
                                                <option value="">- Poli -</option>
                                                <?php foreach ($poli as $poli) { ?>
                                                    <option value="<?php echo $poli->id ?>" <?php echo (!empty($pasien->id_pekerjaan) ? ($poli->id == $pasien->id_poli ? 'selected' : '') : (($poli->id == $this->session->flashdata('poli') ? 'selected' : ''))) ?>><?php echo $poli->lokasi ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['dokter']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Dokter</label>
                                            <select id="dokter" name="dokter" class="form-control select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                                <option value="">- Dokter -</option>
                                                <?php foreach ($sql_doc as $doctor) { ?>
                                                    <option value="<?php echo $doctor->id ?>" <?php echo (!empty($pasien->id_dokter) ? ($doctor->id == $pasien->id_dokter ? 'selected' : '') : (($doctor->id == $this->session->flashdata('dokter') ? 'selected' : ''))) ?>><?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . strtoupper($doctor->nama) . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['alergi']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Alergi Obat ?</label>
                                            <?php echo form_input(array('id' => 'alergi', 'name' => 'alergi', 'class' => 'form-control', 'value' => $this->session->flashdata('alergi'), 'placeholder' => 'Ada alergi obat ...')) ?>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['tgl_periksa']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Tgl Periksa*</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <?php echo form_input(array('id' => 'tgl_masuk', 'name' => 'tgl_masuk', 'class' => 'form-control pull-right', 'placeholder' => 'Silahkan isi tgl periksa ...', 'value' => date('d-m-Y'))) ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo $recaptcha; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="row">
                                    <div class="col-lg-6">

                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <button type="submit" name="daftar" value="daftar_aksi" class="btn btn-primary btn-flat"><i class="fa fa-user-plus"></i> Daftar</button>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                    <div class="col-lg-1"><?php echo nbs() ?></div>
                </div>
            <?php } ?>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.container -->
</div>
<style>
    .clicked {
        background-color: #ffff00;
    }
</style>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.min.css') ?>">

<!--Datepicker-->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">


<!--API Recaptcha-->
<script src='https://www.google.com/recaptcha/api.js'></script>

<!-- Page script -->
<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $('#tgl_lahir').datepicker({
            format: 'dd-mm-yyyy',
            changeMonth: true,
            changeYear: true,
            yearRange: '1920:<?php echo date('Y') ?>',
            autoclose: true
        });

        var dateToday = new Date();
        $("#tgl_masuk").datepicker({
            format: 'dd-mm-yyyy',
            //defaultDate: "+1w",
            SetDate: new Date(),
            changeMonth: true,
            minDate: dateToday,
            autoclose: true
        });
    });
</script>