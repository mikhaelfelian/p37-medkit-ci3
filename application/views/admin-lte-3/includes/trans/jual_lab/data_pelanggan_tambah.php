<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Pelanggan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pelanggan</li>
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
                <div class="col-md-9">
                    <?php echo form_open(base_url('pos/set_pelanggan_' . (isset($_GET['dft']) ? 'update' : 'simpan') . '.php'), 'autocomplete="off"') ?>
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Pendaftaran Pasien</h3>
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
                            <?php echo form_hidden('id_dft', general::enkrip($sql_dft_id->id)) ?>
                            <?php echo form_hidden('id_ant', $this->input->get('id_ant')) ?>
                            <?php echo form_hidden('antrian', $this->input->get('antrian')) ?>

                            <input type="hidden" id="file" name="file" value="<?php echo $pasien->file_base64 ?>">
                            <input type="hidden" id="file_id" name="file_id" value="<?php echo $pasien->file_base64_id ?>">
                            <input type="hidden" id="file" name="id_pasien" value="<?php echo $this->input->get('id_pasien') ?>">

                            <div class="row">
                                <input type="hidden" id="nik_lama">
                                <div class="col-md-6">
                                    <section id="pasien_baru1">
                                        <div class="form-group <?php echo (!empty($hasError['nik']) ? 'text-danger' : '') ?>">
                                            <label class="control-label">NIK <small><i>(* KTP / Passport / KIA)</i></small></label>
                                            <?php echo form_input(array('id' => 'nik_baru', 'name' => 'nik_baru', 'class' => 'form-control rounded-0' . (!empty($hasError['nik']) ? ' is-invalid' : ''), 'value' => (!empty($pasien->nik) ? $pasien->nik : $this->session->flashdata('nik_baru')), 'placeholder' => 'Nomor Identitas ...')) ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group <?php echo (!empty($hasError['gelar']) ? 'text-danger' : '') ?>">
                                                    <label class="control-label">Gelar*</label>
                                                    <select name="gelar" class="form-control rounded-0 <?php echo (!empty($hasError['gelar']) ? 'is-invalid' : '') ?>">
                                                        <option value="">- Pilih -</option>
                                                        <?php foreach ($gelar as $gelar) { ?>
                                                            <option value="<?php echo $gelar->id ?>" <?php echo ($gelar->id == $pasien->id_gelar ? 'selected' : '') ?>><?php echo $gelar->gelar ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                <div class="form-group <?php echo (!empty($hasError['nama']) ? 'text-danger' : '') ?>">
                                                    <label class="control-label">Nama Lengkap*</label>
                                                    <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control rounded-0' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'value' => (!empty($pasien->nama) ? $pasien->nama : $this->session->flashdata('nama')), 'placeholder' => 'John Doe ...')) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['jns_klm']) ? 'text-danger' : '') ?>">
                                            <label class="control-label">Jenis Kelamin*</label>
                                            <select name="jns_klm" class="form-control rounded-0 <?php echo (!empty($hasError['jns_klm']) ? 'is-invalid' : '') ?>">
                                                <option value="">- Pilih -</option>
                                                <option value="L" <?php echo (!empty($pasien->jns_klm) ? ('L' == $pasien->jns_klm ? 'selected' : '') : ('L' == $this->session->flashdata('jns_klm') ? 'selected' : '')) ?>>Laki - laki</option>
                                                <option value="P" <?php echo (!empty($pasien->jns_klm) ? ('P' == $pasien->jns_klm ? 'selected' : '') : ('P' == $this->session->flashdata('jns_klm') ? 'selected' : '')) ?>>Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Tempat Lahir</label>
                                            <?php echo form_input(array('id' => 'tmp_lahir', 'name' => 'tmp_lahir', 'class' => 'form-control rounded-0', 'value' => (!empty($pasien->tmp_lahir) ? $pasien->tmp_lahir : $this->session->flashdata('tmp_lahir')), 'placeholder' => 'Isikan Tempat Lahir ...')) ?>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Tgl Lahir *(Tanggal-Bulan-Tahun) / dd-mm-yyyy</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                </div>
                                                <?php echo form_input(array('id' => 'tgl_lahir', 'name' => 'tgl_lahir', 'class' => 'form-control rounded-0', 'value' => (!empty($pasien->tgl_lahir) ? $pasien->tgl_lahir : $this->session->flashdata('tgl_lahir')), 'placeholder' => 'Isi dengan format berikut : 17-08-1945 ...', 'readonly' => 'TRUE')) ?>
                                            </div>                                        
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                            <label class="control-label">No. HP / WA <i><small class="text-danger">* Inputkan Angka saja (cth: 085741220455)</small></i></label>
                                            <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control rounded-0', 'value' => (!empty($pasien->no_hp) ? $pasien->no_hp : $this->session->flashdata('no_hp')), 'placeholder' => 'Nomor kontak WA pasien / keluarga pasien ...')) ?>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-md-6">
                                    <section id="pasien_baru2">
                                        <div class="form-group <?php echo (!empty($hasError['alamat']) ? 'text-danger' : '') ?>">
                                            <label class="control-label">Alamat KTP<small><i>* Sesuai Identitas</i></small></label>
                                            <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control rounded-0' . (!empty($hasError['alamat']) ? ' is-invalid' : ''), 'value' => (!empty($pasien->alamat) ? $pasien->alamat : $this->session->flashdata('alamat')), 'style' => 'height: 124px;', 'placeholder' => 'Mohon diisi alamat sesuai pada identitas ...')) ?>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['alamat_dom']) ? 'text-danger' : '') ?>">
                                            <label class="control-label">Alamat Domisili<small><i>* Sesuai Domisili</i></small></label>
                                            <?php echo form_textarea(array('id' => 'alamat_dom', 'name' => 'alamat_dom', 'class' => 'form-control rounded-0' . (!empty($hasError['alamat_dom']) ? ' is-invalid' : ''), 'value' => (!empty($pasien->alamat) ? $pasien->alamat : $this->session->flashdata('alamat')), 'style' => 'height: 124px;', 'placeholder' => 'Mohon diisi alamat sesuai domisili ...')) ?>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Pekerjaan</label>
                                            <select name="pekerjaan" class="form-control rounded-0 select2bs4">
                                                <option value="">- Pilih -</option>
                                                <?php foreach ($kerja as $kerja) { ?>
                                                    <option value="<?php echo $kerja->id ?>" <?php echo (!empty($pasien->id_pekerjaan) ? ($kerja->id == $pasien->id_pekerjaan ? 'selected' : '') : (($kerja->id == $this->session->flashdata('pekerjaan') ? 'selected' : ''))) ?>><?php echo $kerja->jenis ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                            <label class="control-label">No. Rmh <i><small class="text-danger">* Inputkan No. Tlp dgn kode area (cth: 0248509988)</small></i></label>
                                            <?php echo form_input(array('id' => 'no_rmh', 'name' => 'no_rmh', 'class' => 'form-control rounded-0', 'value' => (!empty($pasien->no_hp) ? $pasien->no_rmh : $this->session->flashdata('no_rmh')), 'placeholder' => 'Isikan Nomor rumah (PSTN) pasien / keluarga pasien ...')) ?>
                                        </div>
                                    </section>
                                </div>
                            </div>
                            <?php
                            switch ($_GET['tipe_pas']) {
                                case '1':
                                    if (!empty($pasien)) {
                                        $this->load->view('admin-lte-3/includes/medcheck/med_daftar_poli', $data);
                                    }
                                    break;

                                case '2':
                                    $this->load->view('admin-lte-3/includes/medcheck/med_daftar_poli', $data);
                                    break;

                                case '3':
                                    $this->load->view('admin-lte-3/includes/medcheck/med_daftar_poli', $data);
                                    break;
                            }
                            ?>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">

                                </div>
                                <div class="col-lg-6 text-right">
                                    <?php if (!empty($pasien) AND empty($_GET['act'])) { ?>
                                        <a href="<?php echo base_url('medcheck/daftar.php?tipe_pas=' . $this->input->get('tipe_pas') . '&id_pasien=' . $this->input->get('id_pasien') . '&act=ubah_data') ?>">
                                            <button type="button" class="btn btn-warning btn-flat"><i class="fa fa-user-nurse"></i> Ubah</button>
                                        </a>
                                    <?php } ?>
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-user-plus"></i> Daftar</button>
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
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!--Phone Masking-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<style>
    .autocomplete-scroll {
        max-height: 250px;
        overflow-y: auto;
        overflow-x: hidden;
    }
</style>
<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $("#tgl_lahir").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: '1920:<?php echo date('Y') ?>',
            autoclose: true
        });
        
        $("#no_hp").keydown(function (e) {
            // kibot: backspace, delete, tab, escape, enter .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                // kibot: Ctrl+A, Command+A
                (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // kibot: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                // Biarin wae, ga ngapa2in return false
                return;
            }
                                                
            // Cuman nomor
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
        
        $('#no_rmh').mask('(000) 0000000');
    });
</script>