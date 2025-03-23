<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Stok Opname <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Data Stok Opname</li>
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
                            <!--
                            <?php // echo form_open(base_url('master/set_cari_kategori.php')) ?>
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" name="pencarian" class="form-control pull-right" placeholder="Pencarian">

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <?php // echo form_close() ?>
                            -->
                        </div>
                    </div>
                    <div class="box-body">
                        <button type="button" onclick="window.location.href = '<?php echo base_url('gudang/data_opname_tambah.php') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> By Excel</button>
                        <!--<button type="button" onclick="window.location.href = '<?php // echo base_url('gudang/data_stok_op_tmp.php')  ?>'" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> Template</button>-->
                        <?php // echo (!empty($cetak) ? $cetak : '') ?>
                        <?php echo br(2) ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Tgl Opname</th>
                                    <th>User</th>
                                    <th>File</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($opname)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($opname as $opname) {
//                                            $sql_tipe = $this->db->where('id', $opname->id_grup)->get('tbl_m_pelanggan_grup')->row();
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <td><?php echo $this->tanggalan->tgl_indo($opname->tgl_simpan) ?></td>
                                            <td><?php echo anchor(base_url('gudang/data_opname_det.php?id=' . general::enkrip($opname->id)), $this->ion_auth->user($opname->id_user)->row()->first_name, '') ?></td>
                                            <td><?php // echo (!empty($opname->dl_file) ? anchor(base_url('gudang/data_opname_dl.php?id='.general::enkrip($opname->id).'&file='.$opname->nm_file), $opname->nm_file) : $opname->nm_file)  ?></td>
                                            <td><?php echo (!empty($opname->dl_file) ? anchor(base_url('file/import/' . $opname->dl_file), $opname->nm_file) : $opname->nm_file) ?></td>
                                            <td>
                                                <?php if (akses::hakSA() == TRUE AND $opname->reset == '0') { ?>
                                                    <?php echo anchor('page=gudang&act=so_reset&id=' . general::enkrip($opname->id), '<i class="fa fa-edit"></i> Reset', 'class="label label-warning"') ?>
                                                <?php } ?>
                                                <?php echo nbs(100) ?>
                                                <?php // echo anchor(base_url('master/data_kategori_tambah.php?id=' . general::enkrip($opname->id)), '<i class="fa fa-edit"></i> Ubah', 'class="label label-success"') ?>
                                                <?php // echo nbs() ?>
                                                <?php // echo anchor(base_url('master/data_kategori_hapus.php?id=' . general::enkrip($opname->id)), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $opname->kategoriTerkecil . '] ? \')" class="label label-danger"') ?>
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