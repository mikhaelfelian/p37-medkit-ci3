<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data <small>User</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo site_url('page=pengaturan&act=user_list') ?>">Data User</a></li>
            <?php echo (isset($_GET['id']) ? '<li>User</li><li class="active">Update</li>' : '<li class="active">User</li>') ?>            
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-4">
                <?php echo form_open(base_url('pengaturan/data_user_' . (isset($_GET['id']) ? 'update' : 'simpan') . '.php')) ?>
                <?php echo form_hidden('id', $this->input->get('id')) ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Data Pengguna</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group <?php echo (!empty($hasError['email']) ? 'has-error' : '') ?>">
                            <label class="control-label">E-mail</label>
                            <?php echo form_input(array('name' => 'email', 'class' => 'form-control', 'value' => $user->email)) ?>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                            <label class="control-label">Nama</label>
                            <?php echo form_input(array('name' => 'nama', 'class' => 'form-control', 'value' => $user->first_name)) ?>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['user']) ? 'has-error' : '') ?>">
                            <label class="control-label">Username</label>
                            <?php echo form_input(array('name' => 'user', 'class' => 'form-control', 'value' => $user->username)) ?>
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
                                        echo '<option value="' . $grup->id . '" ' . ($grup->name == $this->ion_auth->get_users_groups($user->id)->row()->name ? 'selected' : '') . '>' . ucfirst($grup->description) . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <?php if(akses::hakSA() == TRUE){ ?>
                        <div class="form-group <?php echo (!empty($hasError['cabang']) ? 'has-error' : '') ?>">
                            <label class="control-label">Cabang / Lokasi</label>
                            <select name="cabang" class="form-control">
                                <option value="">- Pilih -</option>
                                <?php
                                $cbg = $this->db->order_by('id', 'asc')->get('tbl_pengaturan_cabang')->result();
                                foreach ($cbg as $cbg) {
                                   echo '<option value="' . $cbg->id . '" ' . ($cbg->id == $user->id_app ? 'selected' : '') . '>' . strtoupper($cbg->keterangan) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="box-footer">
                        <button type="button" class="btn btn-danger btn-flat" onclick="window.location.href='<?php echo base_url('pengaturan/data_user_list.php') ?>'"><i class="fa fa-remove"></i> Batal</button>
                        <button type="submit" class="btn btn-primary btn-flat pull-right"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
            <div class="col-lg-8">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Pengguna</h3>
                        <div class="box-tools">
                            <?php echo form_open(base_url('pengaturan/set_cari_user.php')) ?>
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" name="pencarian" class="form-control pull-right" placeholder="Pencarian">

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <?php echo form_close() ?>                     
                        </div>
                    </div>
                    <div class="box-body">
                        <?php echo $this->session->flashdata('pengaturan') ?>
                        <table class="table table-stripped todo-list ui-sortable">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <?php if(akses::hakSA() == TRUE){ ?>
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
                                            <?php if(akses::hakSA() == TRUE){ ?>
                                            <td style="width: 150px;text-align: left;"><?php echo $cbg->keterangan ?></td>
                                            <?php } ?>
                                            <td style="width: 150px; text-align: left;"><?php echo $user->first_name ?></td>
                                            <td style="width: 100px; text-align: left;"><?php echo $user->username ?></td>
                                            <td style="width: 55px; text-align: left;"><?php echo ucwords($this->ion_auth->get_users_groups($user->id)->row()->name) ?></td>
                                            <td style="width: 100px; text-align: left;">
                                                <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE) { ?>
                                                    <?php echo anchor(base_url('pengaturan/data_user_list.php?id=' . general::enkrip($user->id)), '<i class="fa fa-edit"></i> Ubah', 'class="label label-success"') ?>
                                                    <?php echo nbs() ?>
                                                    <?php if($user->username != $this->ion_auth->user()->row()->username){ ?>
                                                        <?php echo anchor(base_url('pengaturan/data_user_hapus.php?id=' . general::enkrip($user->id)), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $user->username . '] ? \')" class="label label-danger"') ?>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <?php echo anchor(base_url('pengaturan/data_user_list.php?id=' . general::enkrip($user->id)), '<i class="fa fa-edit"></i> Ubah', 'class="label label-success"') ?>
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
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<style>
    .clicked {
        background-color: #ffff00;
    }
</style>
<script>
    $(function () {
        $('#cekAbeh').click(function () {
            $('input:checkbox').prop('checked', true);
            $(".itemnya").css("background", "yellow");
            $('#apusPilih').show();
        });

        $('#cekAbehIlang').click(function () {
            $('input:checkbox').prop('checked', false);
            $(".itemnya").css("background", "#f4f4f4");
            $('#apusPilih').hide();
        });

        $('#apusPilih').hide();
        $('#apusPilih').click(function () {
            $('#HapusBanyak').submit();
        });

        /* The todo list plugin */
        $(".todo-list").todolist({
            onCheck: function (ele) {
                $(this).css("background", "yellow");
                $('#apusPilih').show();
                return ele;
            },
            onUncheck: function (ele) {
                $(this).css("background", "#f4f4f4");
                $('#apusPilih').hide();
                return ele;
            }
        });
    });
</script>