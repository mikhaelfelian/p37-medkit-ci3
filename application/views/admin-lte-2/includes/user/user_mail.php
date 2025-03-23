<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Pengaturan <small>Aplikasi</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Pengaturan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <?php echo $this->session->flashdata('pengaturan') ?>
                <?php $hasError = $this->session->flashdata('form_error') ?>
                <?php // echo $hasError['email'] ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <?php echo form_open('page=pengaturan&act=simpan') ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Pengaturan</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group <?php echo (!empty($hasError['user']) ? 'has-error' : '') ?>">
                            <label class="control-label">Stok Minimal</label>
                            <?php echo br() ?>
                            <i class="text text-success">* Limit stok, jika ada stok dibawah limit akan ada notifikasi email.</i>
                            <?php echo form_input(array('name' => 'stok_limit', 'class' => 'form-control', 'value'=>$setting->stok_limit)) ?>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['email']) ? 'has-error' : '') ?>">
                            <label class="control-label">Email Notifikasi (Utama)</label>
                            <?php echo br() ?>
                            <i class="text text-success">* Email utama untuk notifikasi email</i>
                            <?php echo form_input(array('name' => 'email', 'class' => 'form-control', 'value'=>$setting->email)) ?>
                        </div>
                    </div>
                    <div class="box-footer">
                        <!--<button type="reset" class="btn btn-default">Batal</button>-->
                        <button type="submit" class="btn btn-success btn-flat pull-right">Simpan</button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
            <div class="col-lg-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Bcc Notifikasi</h3>
                    </div>
                    <div class="box-body">
                        <p class="text-success">
                            <i>
                                * Jika ada stok barang kurang dari <b><?php echo $this->db->get('tbl_pengaturan')->row()->stok_limit ?></b> Unit, 
                                <?php echo br().nbs(3) ?>maka email dibawah ini akan menerima notifikasi sebagai bcc
                            </i>
                        </p>
                        <?php echo form_open('page=pengaturan&act=mail_notif_simpan') ?>
                        <div class="input-group input-group-md <?php echo (!empty($hasError['email_bcc']) ? 'has-error' : '') ?>">
                            <?php echo form_input(array('name' => 'email', 'placeholder' => 'Alamat E-mail ...', 'class' => 'form-control')) ?>
                            <span class="input-group-btn <?php echo (!empty($hasError['email']) ? 'has-error' : '') ?>">
                                <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-plus"></i> Tambah</button>
                            </span>
                        </div>
                        <?php echo form_close() ?>

                        <table class="table table-striped todo-list ui-sortable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>E-mail</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($users as $user) { ?>
                                    <tr>
                                        <td style="width: 15px; text-align: center;"><?php echo $no++ ?></td>
                                        <td><?php echo $user->email ?></td>
                                        <td style="width: 15px; text-align: center;"><?php echo anchor('page=pengaturan&act=mail_notif_hapus&id=' . general::enkrip($user->id), '<i class="fa fa-remove"></i>', 'onclick="return confirm(\'Hapus ?\')" class="text-danger"') ?></td>
                                    </tr>
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