<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data <small>Kantor</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo site_url('page=pengaturan&act=user_list') ?>">Data Kantor</a></li>
            <?php echo (isset($_GET['id']) ? '<li>Kantor</li><li class="active">Update</li>' : '') ?>            
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-8">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                        <div class="box-tools">
                            <?php echo form_open(base_url('pengaturan/set_cari_cabang.php')) ?>
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
                        <?php echo form_open(base_url('pengaturan/data_cabang_' . (isset($_GET['id']) ? 'update' : 'simpan') . '.php')) ?>
                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                        <div class="input-group input-group-sm has-primary" style="width: 200px;">
                            <input type="text" name="cabang" class="form-control pull-right" placeholder="Kantor / Cabang" value="<?php echo $cabang->keterangan ?>">

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i></button>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                        <table class="table table-striped todo-list ui-sortable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kantor</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($cabangs as $cabangs) { ?>
                                    <tr>
                                        <td style="width: 15px; text-align: center;"><?php echo $no++ ?></td>
                                        <td style="width: 150px;text-align: left;"><?php echo $cabangs->keterangan ?></td>
                                        <td class="text-left">
                                            <?php if ($cabangs->id == 1) { ?>
                                                <?php echo anchor(base_url('pengaturan/data_cabang_list.php?id=' . general::enkrip($cabangs->id)), '<i class="fa fa-edit"></i> Ubah', 'class="label label-success"') ?>
                                            <?php }else{ ?>
                                                <?php echo anchor(base_url('pengaturan/data_cabang_list.php?id=' . general::enkrip($cabangs->id)), '<i class="fa fa-edit"></i> Ubah', 'class="label label-success"') ?>
                                                <?php echo nbs() ?>
                                                <?php echo anchor(base_url('pengaturan/data_cabang_hapus.php?id=' . general::enkrip($cabangs->id)), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $cabangs->keterangan . '] ? \')" class="label label-danger"') ?>
                                            <?php } ?>
                                        </td>
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