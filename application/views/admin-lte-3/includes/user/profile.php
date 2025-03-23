<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <?php if (isset($_GET['page'])) { ?>
                <?php
                switch ($_GET['page']) {

                    case 'profile_kel':
                        $this->load->view('admin-lte-3/includes/user/profile_kel');
                        break;

                    case 'profile_kel_ktp':
                        $this->load->view('admin-lte-3/includes/user/profile_kel_ktp');
                        break;

                    case 'profile_pend':
                        $this->load->view('admin-lte-3/includes/user/profile_pend');
                        break;

                    case 'profile_sert':
                        $this->load->view('admin-lte-3/includes/user/profile_sert');
                        break;

                    case 'profile_peg':
                        $this->load->view('admin-lte-3/includes/user/profile_peg');
                        break;

                    case 'profile_cuti':
                        $this->load->view('admin-lte-3/includes/user/profile_cuti');
                        break;

                    case 'profile_surat_krj':
                        $this->load->view('admin-lte-3/includes/user/profile_surat_krj');
                        break;

                    case 'profile_surat_tgs':
                        $this->load->view('admin-lte-3/includes/user/profile_surat_tgs');
                        break;

                    case 'profile_gaji':
                        $this->load->view('admin-lte-3/includes/user/profile_gaji');
                        break;
                }
                ?>
            <?php } else { ?>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <?php $named    = 'userid_'.sprintf('%03d',$user->id); ?>
                                    <?php $file     = (!empty($user->file_name) ? realpath('/file/karyawan/'.$sql_kary->id.'/'.$user->file_name) : ''); ?>
                                    <?php $foto     = (!empty($user->file_name) ? base_url('file/user/userid_'.sprintf('%03d',$user->id).'/'.$user->file_name) : $user->file_base64); ?>

                                    <img class="profile-user-img img-fluid img-circle" src="<?php echo (!empty($foto) ? $foto : base_url('assets/theme/admin-lte-3/icon_putra.png')) ?>" alt="User profile picture" style="width: 100px; height: 100px;">
                                </div>
                                <h3 class="profile-username text-center"><?php echo ucwords($user->first_name) ?></h3>
                                <p class="text-muted text-center"><?php echo ucwords($this->ion_auth->get_users_groups()->row()->name) ?></p>
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Nama Lengkap</b> <a class="float-right"><?php echo ucwords($user->first_name) ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Username</b> <a class="float-right"><?php echo ucwords($user->username) ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <?php $hasError = $this->session->flashdata('form_error'); ?>
                        <?php $grup     = $this->ion_auth->get_users_groups()->row(); ?>
                        <?php echo form_open_multipart(base_url('set_profile_update.php'), 'autocomplete="off"') ?>
                        <?php echo form_hidden('id', general::enkrip($sql_kary->id)) ?>
                        <?php echo form_hidden('id_user', general::enkrip($this->ion_auth->user()->row()->id)) ?>
                        <?php echo form_hidden('route', 'profile.php') ?>
                        <?php echo form_hidden('grup', $grup->id) ?>

                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><?php echo nbs(2) ?>Profile Karyawan</li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="form-group <?php echo (!empty($hasError['nik']) ? 'text-danger' : '') ?>">
                                            <label class="control-label">NIK* <small><i>(* Bisa diisi dengan SIP / SIPB / STR)</i></small></label>
                                            <?php echo form_input(array('id' => 'nik', 'name' => 'nik', 'class' => 'form-control rounded-0' . (!empty($hasError['nik']) ? ' is-invalid' : ''), 'value' => $sql_kary->nik, 'placeholder' => 'Nomor Identitas ...')) ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-group <?php echo (!empty($hasError['gelar']) ? 'text-danger' : '') ?>">
                                                    <label class="control-label">Gelar</label>
                                                    <?php echo form_input(array('id' => 'nama_dpn', 'name' => 'nama_dpn', 'class' => 'form-control rounded-0' . (!empty($hasError['gelar']) ? ' is-invalid' : ''), 'value' => $sql_kary->nama_dpn, 'placeholder' => 'dr. ...')) ?>
                                                </div>
                                            </div>
                                            <div class="col-7">
                                                <div class="form-group <?php echo (!empty($hasError['nama']) ? 'text-danger' : '') ?>">
                                                    <label class="control-label">Nama Lengkap*</label>
                                                    <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control rounded-0' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'value' => $sql_kary->nama, 'placeholder' => 'John Doe ...')) ?>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group <?php echo (!empty($hasError['gelar']) ? 'text-danger' : '') ?>">
                                                    <label class="control-label">Gelar</label>
                                                    <?php echo form_input(array('id' => 'nama_blk', 'name' => 'nama_blk', 'class' => 'form-control rounded-0' . (!empty($hasError['nama_blk']) ? ' is-invalid' : ''), 'value' => $sql_kary->nama_blk, 'placeholder' => 'Sp.PD ...')) ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group <?php echo (!empty($hasError['jns_klm']) ? 'text-danger' : '') ?>">
                                            <label class="control-label">Jenis Kelamin*</label>
                                            <select name="jns_klm" class="form-control rounded-0 <?php echo (!empty($hasError['jns_klm']) ? 'is-invalid' : '') ?>">
                                                <option value="">- Pilih -</option>
                                                <option value="L" <?php echo ('L' == $sql_kary->jns_klm ? 'selected' : '') ?>>Laki - laki</option>
                                                <option value="P" <?php echo ('P' == $sql_kary->jns_klm ? 'selected' : '') ?>>Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['tmp_lahir']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Tempat Lahir</label>
                                            <?php echo form_input(array('id' => 'tmp_lahir', 'name' => 'tmp_lahir', 'class' => 'form-control rounded-0', 'value' => $sql_kary->tmp_lahir, 'placeholder' => 'Semarang ...')) ?>
                                        </div>

                                        <div class="form-group <?php echo (!empty($hasError['tgl_lahir']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Tgl Lahir*</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                </div>
                                                <?php echo form_input(array('id' => 'tgl_lahir', 'name' => 'tgl_lahir', 'class' => 'form-control rounded-0' . (!empty($hasError['tgl_lahir']) ? ' is-invalid' : ''), 'value' => $this->tanggalan->tgl_indo8($sql_kary->tgl_lahir), 'placeholder' => 'Isi dengan format berikut : 17-08-1945 ...', 'readonly' => 'TRUE')) ?>
                                            </div>                                        
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                            <label class="control-label">No. HP</label>
                                            <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control rounded-0', 'value' => $sql_kary->no_hp, 'placeholder' => 'Nomor kontak WA karyawan / keluarga terdekat ...')) ?>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Foto profile</label>
                                            <?php echo form_upload(array('name' => 'fupload', 'class' => 'form-control rounded-0', 'placeholder' => 'File ..')) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group <?php echo (!empty($hasError['alamat']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Alamat KTP<small><i>* Sesuai Identitas</i></small></label>
                                            <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control rounded-0' . (!empty($hasError['alamat']) ? ' is-invalid' : ''), 'value' => $sql_kary->alamat, 'style' => 'height: 124px;', 'placeholder' => 'Mohon diisi alamat lengkap sesuai ktp ...')) ?>
                                        </div>

                                        <div class="form-group <?php echo (!empty($hasError['alamat_dom']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Alamat Domisili<small><i>* Sesuai Domisili</i></small></label>
                                            <?php echo form_textarea(array('id' => 'alamat_dom', 'name' => 'alamat_dom', 'class' => 'form-control rounded-0' . (!empty($hasError['alamat_dom']) ? ' is-invalid' : ''), 'value' => $sql_kary->alamat_dom, 'style' => 'height: 124px;', 'placeholder' => 'Mohon diisi alamat lengkap sesuai domisili ...')) ?>
                                        </div>

                                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Jabatan</label>
                                            <?php echo form_input(array('id' => 'jabatan', 'name' => 'jabatan', 'class' => 'form-control rounded-0', 'value' => $sql_kary->jabatan, 'placeholder' => 'Isikan Jabatan ...')) ?>
                                        </div>

                                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                            <label class="control-label">No. Rumah</label>
                                            <?php echo form_input(array('id' => 'no_rmh', 'name' => 'no_rmh', 'class' => 'form-control rounded-0', 'value' => $sql_kary->no_rmh, 'placeholder' => 'Isikan Nomor rumah (PSTN) pasien / keluarga pasien ...')) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12"><hr/></div>
                                    <div class="col-md-4">
                                        <div class="form-group <?php echo (!empty($hasError['username']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Username</label>
                                            <?php echo form_input(array('id' => 'user', 'name' => 'user', 'class' => 'form-control rounded-0', 'value' => (!empty($sql_kary->id_user) ? $this->ion_auth->user($sql_kary->id_user)->row()->username : ''), 'placeholder' => 'Isikan Username ...')) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group <?php echo (!empty($hasError['pass1']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Kata Sandi</label>
                                            <?php echo form_password(array('name' => 'pass1', 'class' => 'form-control rounded-0')) ?>
                                        </div>                                   
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group <?php echo (!empty($hasError['pass1']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Ulang Kata Sandi*</label>
                                            <?php echo form_password(array('name' => 'pass2', 'class' => 'form-control rounded-0')) ?>
                                        </div>
                                    </div>
                                </div>
                                <!--
                                <div class="tab-content">
                                    <div class="tab-pane active" id="settings">
                                <?php echo form_open_multipart('page=pengaturan&act=profile_update', 'id="FormSimpan" class="form-horizontal"') ?>
                                <?php echo form_hidden('id', general::enkrip($user->id)) ?>

                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-3 col-form-label">Username</label>
                                            <div class="col-sm-9">
                                <?php echo form_input(array('name' => 'username', 'placeholder' => 'Username ..', 'class' => 'form-control', 'value' => $user->username)) ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName2" class="col-sm-3 col-form-label">Nama</label>
                                            <div class="col-sm-9">
                                <?php echo form_input(array('name' => 'nama', 'placeholder' => 'Nama ..', 'class' => 'form-control', 'value' => $user->first_name)) ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputSkills" class="col-sm-3 col-form-label">Kata Sandi</label>
                                            <div class="col-sm-9">
                                <?php echo form_password(array('name' => 'pass1', 'placeholder' => 'Kata Sandi ..', 'class' => 'form-control')) ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputSkills" class="col-sm-3 col-form-label">Ulang Kata Sandi</label>
                                            <div class="col-sm-9">
                                <?php echo form_password(array('name' => 'pass2', 'placeholder' => 'Ulang Kata Sandi ..', 'class' => 'form-control')) ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName2" class="col-sm-3 col-form-label">Foto User</label>
                                            <div class="col-sm-9">
                                <?php echo form_upload(array('name' => 'fupload', 'placeholder' => 'File ..')) ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-3 col-sm-9">
                                                <button type="submit" class="btn btn-danger">Simpan</button>
                                            </div>
                                        </div>
                                <?php echo form_close() ?>
                                    </div>
                                </div>
                                -->
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <!--<button type="button" onclick="window.location.href = '<?php // echo base_url('master/data_pasien_list.php')      ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>-->
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                    <!-- /.row -->
                </div>
            <?php } ?>
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

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>
<script type="text/javascript">
    $(function () {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

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
        
        <?php echo $this->session->flashdata('pengaturan_toast'); ?>
    });
</script>