<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Pelanggan <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Kategori</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Pelanggan</h3>
                        <div class="box-tools">
                            <?php echo form_open('page=produk&act=set_cari_plgn') ?>
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" name="pencarian" class="form-control pull-right" placeholder="Pencarian">

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>No. Hp</th>
                                    <th>Alamat</th>
                                    <th>Tipe Member</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($pelanggan)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($pelanggan as $pelanggan) {
                                        if ($pelanggan->id != 1) {
                                            $sql_tipe = $this->db->where('id', $pelanggan->id_grup)->get('tbl_m_pelanggan_grup')->row();
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td><?php echo $pelanggan->nik ?></td>
                                                <td><?php echo $pelanggan->nama ?></td>
                                                <td><?php echo $pelanggan->no_hp ?></td>
                                                <td><?php echo $pelanggan->alamat ?></td>
                                                <td><?php echo $sql_tipe->grup ?></td>
                                                <td>
                                                    <?php if ($sql_tipe->status_deposit == 1) { ?>
                                                        <?php echo anchor(base_url('member/member_deposit.php?id=' . general::enkrip($pelanggan->id)), '<i class="fa fa-plus"></i> Deposit', 'class="label label-primary"') ?>
                                                    <?php } else { ?>
                                                        <label class="label label-default"><i class="fa fa-plus"></i> Deposit</label>
                                                    <?php } ?>

                                                    <?php if ($pelanggan->id > 1) { ?>
                                                        <?php echo nbs() ?>
                                                        <?php echo anchor(base_url('member/member_ubah.php?id=' . general::enkrip($pelanggan->id)), '<i class="fa fa-edit"></i> Ubah', 'class="label label-success"') ?>
                                                        <?php // echo nbs() ?>
                                                        <?php // echo anchor('page=produk&act=prod_pelanggan_hapus&id=' . general::enkrip($pelanggan->id), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $pelanggan->kategori . '] ? \')" class="label label-danger"') ?>
                                                    <?php } else { ?>
                                                        <i class="fa fa-remove"></i> Hapus
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
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