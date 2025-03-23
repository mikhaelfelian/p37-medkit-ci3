<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Persediaan Awal <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Persediaan Awal</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                        <div class="box-tools">
                            <?php echo form_open(base_url('akuntability/set_cari_pers.php')) ?>
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <div class="input-group-btn">
                                    <button type="button" id="tanggalan" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                </div>
                                <input type="text" id="pencarian" name="pencarian" class="form-control pull-right" placeholder="Pencarian">

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <div class="box-body">
                        <button type="button" onclick="window.location.href = '<?php echo base_url('akuntability/data_pers_tambah.php') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Tambah</button>

                        <?php echo br(2) ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Tgl Simpan</th>
                                    <th class="text-right">Nominal</th>
                                    <th>Keterangan</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($pers)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($pers as $pers) {
                                            $sql_tipe = $this->db->where('id', $pers->id_grup)->get('tbl_m_pelanggan_grup')->row();
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td><?php echo $this->tanggalan->tgl_indo($pers->tgl_simpan) ?></td>
                                                <td class="text-right"><?php echo general::format_angka($pers->nominal) ?></td>
                                                <td><?php echo $pers->keterangan ?></td>
                                                <td>
                                                    <?php echo nbs() ?>
                                                    <?php echo anchor(base_url('akuntability/data_pers_tambah.php?id=' . general::enkrip($pers->id)), '<i class="fa fa-edit"></i> Ubah', 'class="label label-success"') ?>
                                                    <?php echo nbs() ?>
                                                    <?php echo anchor(base_url('akuntability/data_pers_hapus.php?id=' . general::enkrip($pers->id)), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $pers->keterangan . '] ? \')" class="label label-danger"') ?>
                                                </td>
                                            </tr>
                                            <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (!empty($pagination)) { ?>
                        <div class="box-footer">                        
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php echo $pagination ?>
                            </ul>
                        </div>
                    <?php } ?>
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
<!--Datepicker-->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Page script -->
<script>
$(function () {
    $('#tanggalan').click(function() { $('#pencarian').datepicker("show"); });    
});
</script>