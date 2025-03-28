<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Pengaturan <small>Aplikasi</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo site_url('page=pengaturan&act=user_list') ?>">Data User</a></li>
            <li class="active">Pengaturan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-4">
                <?php echo form_open('page=pengaturan&act=user_simpan') ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form User</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                            <label class="control-label">Nama</label>
                            <?php echo form_input(array('name' => 'nama', 'class' => 'form-control')) ?>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['user']) ? 'has-error' : '') ?>">
                            <label class="control-label">Username</label>
                            <?php echo form_input(array('name' => 'user', 'class' => 'form-control')) ?>
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
                                    echo '<option value="' . $grup->id . '">' . ucfirst($grup->name) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="reset" class="btn btn-default">Batal</button>
                        <button type="submit" class="btn btn-info pull-right">Simpan</button>
                    </div>
                </div>
                <?php echo form_close() ?>
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