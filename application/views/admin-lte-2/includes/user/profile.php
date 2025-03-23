<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Profile <small>Pengguna</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard.php') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Profile</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-4">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Profile</h3>
                    </div>
                    <div class="box-body">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="height: 100px;"></div>
                            <div class="panel-body">
                                <div class="row" style="margin-top: -65px;margin-bottom: 20px">
                                    <div class="col-xs-offset-2 col-xs-8 col-sm-offset-4 col-sm-4 text-center">
                                        <img class="img-thumbnail" src="<?php echo base_url('assets/theme/admin-lte-2/icon_putra.png') ?>">
                                    </div>
                                </div>
                                <div class="table-responsiveX">
                                    <table class="table" style="margin-bottom: 0;">
                                        <tbody>
                                            <tr><td style="width: 140px;">Nama Lengkap</td><td>: <?php echo ucwords($user->first_name) ?></td></tr>
                                            <tr><td style="width: 140px;">Nama Pengguna</td><td>: <?php echo $user->username ?></td></tr>
                                            <tr><td style="width: 140px;">Email</td><td>: <?php echo $user->email ?></td></tr>
                                            <tr><td style="width: 140px;">Jenis Akun</td><td>: <a href="#"><i class="fa fa-shopping-bag"></i> <?php echo ucwords($this->ion_auth->get_users_groups()->row()->name) ?></a></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Profile</h3>
                    </div>
                    <div class="box-body">
                        <?php echo $this->session->flashdata('pengaturan') ?>
                        <?php echo form_open('page=pengaturan&act=profile_update', 'id="FormSimpan"') ?>
                        <?php echo form_hidden('id', $user->id) ?>
                        <div class="form-group">
                            <label>E-MAIL</label>
                            <?php echo form_input(array('name' => 'email', 'readonly' => 'TRUE', 'class' => 'form-control', 'value' => $user->email)) ?>
                            <br/>
                            <label>Username</label>
                            <?php echo form_input(array('name' => 'username', 'placeholder' => 'Username ..', 'class' => 'form-control', 'value' => $user->username)) ?>
                            <br/>
                            <label>Nama</label>
                            <?php echo form_input(array('name' => 'nama', 'placeholder' => 'Username ..', 'class' => 'form-control', 'value' => $user->first_name)) ?>
                            <br/>
                            <label>Kata Sandi</label>
                            <?php echo form_password(array('name' => 'pass1', 'placeholder' => 'Kata Sandi ..', 'class' => 'form-control', 'value' => $user->nm_akun)) ?>
                            <br/>
                            <button type="submit" class="btn btn-flat btn-primary"><i class="fa fa-save"></i> UBAH DATA</button>
                        </div>
                        <?php echo form_close() ?>
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