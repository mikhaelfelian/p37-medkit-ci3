<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!--<h1 class="m-0">Master Data</h1>-->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('pengaturan/index.php') ?>">Pengaturan</a></li>
                        <li class="breadcrumb-item active">Daftar Pengguna</li>
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
                <?php if ($_GET['page'] == 'tambah') { ?>
                    <div class="col-md-6">
                        <?php echo form_open(base_url('pengaturan/data_user_' . (isset($_GET['id']) ? 'update' : 'simpan') . '.php')) ?>
                        <?php echo form_hidden('id', general::enkrip($pengguna->id)); ?>

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Form Data Pengguna</h3>
                            </div>
                            <div class="card-body">
                                <?php echo form_hidden('email', 'noreply@esensia.co.id') ?>
                                <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Nama</label>
                                    <?php echo form_input(array('name' => 'nama', 'class' => 'form-control', 'value' => $pengguna->first_name)) ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['user']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Username</label>
                                    <?php echo form_input(array('name' => 'user', 'class' => 'form-control', 'value' => $pengguna->username)) ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['pass1']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Kata Sandi</label>
                                    <?php echo form_password(array('name' => 'pass1', 'class' => 'form-control')) ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['pass2']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Ulang Kata Sandi</label>
                                    <?php echo form_password(array('name' => 'pass2', 'class' => 'form-control')) ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['grup']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Grup</label>
                                    <select name="grup" class="form-control">
                                        <option value="">- Pilih -</option>
                                        <?php
                                        $grup = $this->ion_auth->groups()->result();
                                        foreach ($grup as $grup) {
                                            if ($grup->name != 'superadmin') {
                                                echo '<option value="' . $grup->id . '" ' . ($grup->name == $this->ion_auth->get_users_groups($pengguna->id)->row()->name ? 'selected' : '') . '>' . ucfirst($grup->description) . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php if (akses::hakSA() == TRUE) { ?>
                                    <div class="form-group <?php echo (!empty($hasError['cabang']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Cabang / Lokasi</label>
                                        <select name="cabang" class="form-control">
                                            <option value="">- Pilih -</option>
                                            <?php
                                            $cbg = $this->db->order_by('id', 'asc')->get('tbl_pengaturan_cabang')->result();
                                            foreach ($cbg as $cbg) {
                                                echo '<option value="' . $cbg->id . '" ' . ($cbg->id == $pengguna->id_app ? 'selected' : '') . '>' . strtoupper($cbg->keterangan) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6 text-left">
                                        <button type="button" class="btn btn-primary btn-flat pull-left" onclick="window.location.href = '<?php echo base_url('pengaturan/data_user_list.php') ?>'">&laquo; Kembali</button>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="submit" class="btn btn-primary btn-flat pull-right"><i class="fa fa-save"></i> Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Form Data Karyawan</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-right">
                                        <?php echo $pagination ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <?php echo $this->session->flashdata('master'); ?>
                                <?php $hasError = $this->session->flashdata('form_error'); ?>
                                <?php echo form_hidden('id', general::enkrip($sales->id)) ?>
                                <?php echo form_hidden('grup', $sales->id_user_group) ?>

                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="form-group <?php echo (!empty($hasError['nik']) ? 'text-danger' : '') ?>">
                                            <label class="control-label">NIK* <small><i>(* Bisa diisi dengan SIP / SIPB / STR)</i></small></label>
                                            <?php echo form_input(array('id' => 'nik', 'name' => 'nik', 'class' => 'form-control' . (!empty($hasError['nik']) ? ' is-invalid' : ''), 'value' => $sales->nik, 'placeholder' => 'Nomor Identitas ...')) ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-group <?php echo (!empty($hasError['gelar']) ? 'text-danger' : '') ?>">
                                                    <label class="control-label">Gelar</label>
                                                    <?php echo form_input(array('id' => 'nama_dpn', 'name' => 'nama_dpn', 'class' => 'form-control' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'value' => $sales->nama_dpn, 'placeholder' => 'dr. ...')) ?>
                                                </div>
                                            </div>
                                            <div class="col-7">
                                                <div class="form-group <?php echo (!empty($hasError['nama']) ? 'text-danger' : '') ?>">
                                                    <label class="control-label">Nama Lengkap*</label>
                                                    <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'value' => $sales->nama, 'placeholder' => 'John Doe ...')) ?>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group <?php echo (!empty($hasError['gelar']) ? 'text-danger' : '') ?>">
                                                    <label class="control-label">Gelar</label>
                                                    <?php echo form_input(array('id' => 'nama_blk', 'name' => 'nama_blk', 'class' => 'form-control' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'value' => $sales->nama_blk, 'placeholder' => 'Sp.PD ...')) ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group <?php echo (!empty($hasError['jns_klm']) ? 'text-danger' : '') ?>">
                                            <label class="control-label">Jenis Kelamin*</label>
                                            <select name="jns_klm" class="form-control <?php echo (!empty($hasError['jns_klm']) ? 'is-invalid' : '') ?>">
                                                <option value="">- Pilih -</option>
                                                <option value="L" <?php echo ('L' == $sales->jns_klm ? 'selected' : '') ?>>Laki - laki</option>
                                                <option value="P" <?php echo ('P' == $sales->jns_klm ? 'selected' : '') ?>>Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['tmp_lahir']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Tempat Lahir</label>
                                            <?php echo form_input(array('id' => 'tmp_lahir', 'name' => 'tmp_lahir', 'class' => 'form-control', 'value' => $sales->tmp_lahir, 'placeholder' => 'Semarang ...')) ?>
                                        </div>

                                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Tgl Lahir</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                </div>
                                                <?php echo form_input(array('id' => 'tgl_lahir', 'name' => 'tgl_lahir', 'class' => 'form-control', 'value' => $this->tanggalan->tgl_indo($sales->tgl_lahir), 'placeholder' => '02/15/1992 ...')) ?>
                                            </div>                                        
                                        </div>

                                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                            <label class="control-label">No. HP</label>
                                            <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control', 'value' => $sales->no_hp, 'placeholder' => 'Nomor kontak WA pasien / keluarga pasien ...')) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group <?php echo (!empty($hasError['nik']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Alamat KTP<small><i>* Sesuai Identitas</i></small></label>
                                            <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control', 'value' => $sales->alamat, 'style' => 'height: 124px;', 'placeholder' => 'Mohon diisi alamat lengkap ...')) ?>
                                        </div>

                                        <div class="form-group <?php echo (!empty($hasError['nik']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Alamat Domisili<small><i>* Sesuai Domisili</i></small></label>
                                            <?php echo form_textarea(array('id' => 'alamat_dom', 'name' => 'alamat_dom', 'class' => 'form-control', 'value' => $sales->alamat_dom, 'style' => 'height: 124px;', 'placeholder' => 'Mohon diisi alamat lengkap ...')) ?>
                                        </div>

                                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Jabatan</label>
                                            <?php echo form_input(array('id' => 'jabatan', 'name' => 'jabatan', 'class' => 'form-control', 'value' => $sales->jabatan, 'placeholder' => 'Isikan Jabatan ...')) ?>
                                        </div>

                                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                            <label class="control-label">No. Rumah</label>
                                            <?php echo form_input(array('id' => 'no_rmh', 'name' => 'no_rmh', 'class' => 'form-control', 'value' => $sales->no_rmh, 'placeholder' => 'Isikan Nomor rumah (PSTN) pasien / keluarga pasien ...')) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <!--<button type="button" onclick="window.location.href = '<?php // echo base_url('master/data_pasien_list.php')   ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>-->
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Data Pengguna</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-right">
                                        <?php echo $pagination ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <?php echo $this->session->flashdata('pengaturan') ?>                                
                                    </div>
                                </div>
                                <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdmin() == TRUE) { ?>
                                    <!--<a href="<?php // echo base_url('pengaturan/data_user_list.php?page=tambah') ?>" class="btn btn-sm btn-primary"><i class="fas fa-user-plus"></i> Tambah</a>-->
                                <?php } ?>
                                <table class="table table-stripped todo-list ui-sortable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <?php if (akses::hakSA() == TRUE) { ?>
                                                <th>Kantor / Lokasi</th>
                                            <?php } ?>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>Level</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($users as $user) { ?>
                                            <?php if ($this->ion_auth->get_users_groups($user->id)->row()->name != 'superadmin') { ?>
                                                <?php $cbg = $this->db->where('id', $user->id_app)->get('tbl_pengaturan_cabang')->row() ?>
                                                <tr>
                                                    <td style="width: 15px; text-align: center;"><?php echo $no++ ?></td>
                                                    <?php if (akses::hakSA() == TRUE) { ?>
                                                        <td style="width: 150px;text-align: left;"><?php echo $cbg->keterangan ?></td>
                                                    <?php } ?>
                                                    <td style="width: 150px; text-align: left;"><?php echo $user->first_name ?></td>
                                                    <td style="width: 100px; text-align: left;"><?php echo $user->username ?></td>
                                                    <td style="width: 55px; text-align: left;"><?php echo ucwords($this->ion_auth->get_users_groups($user->id)->row()->description) ?></td>
                                                    <td style="width: 100px; text-align: left;">
                                                        <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE) { ?>
                                                            <?php // echo anchor(base_url('pengaturan/data_user_list.php?page=tambah&id=' . general::enkrip($user->id)), '<i class="fas fa-edit"></i> Ubah', 'class="btn btn-info btn-flat btn-xs" style="width: 55px;"') ?>
                                                            <?php echo nbs() ?>
                                                            <?php if ($user->username != $this->ion_auth->user()->row()->username) { ?>
                                                                <?php echo anchor(base_url('pengaturan/data_user_hapus.php?id=' . general::enkrip($user->id)), '<i class="fas fa-trash"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $user->username . '] ? \')" class="btn btn-danger btn-flat btn-xs" style="width: 55px;"') ?>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <?php // echo anchor(base_url('pengaturan/data_user_list.php?page=tambah&id=' . general::enkrip($user->id)), '<i class="fas fa-edit"></i> Ubah', 'class="btn btn-info btn-flat btn-xs" style="width: 55px;"') ?>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->