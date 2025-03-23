<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Promo <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Promo</li>
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
                            <?php echo form_open(base_url('master/set_cari_promo.php')) ?>
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
                        <?php if(akses::hakKasir() != TRUE){ ?>
                        <button type="button" onclick="window.location.href = '<?php echo base_url('master/data_promo_tambah.php') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Tambah</button>
                        <?php } ?>
                        <?php echo br(2) ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Promo</th>
                                    <th>Keterangan</th>
                                    <!--<th>Diskon</th>-->
                                    <!--<th>Tipe</th>-->
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($promo)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($promo as $promo) {
                                            $sql_tipe = $this->db->where('id', $promo->id_grup)->get('tbl_m_pelanggan_grup')->row();
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td><?php echo $promo->promo ?></td>
                                                <td><?php echo $promo->keterangan ?></td>
                                                <!--<td><?php echo ($promo->tipe == 2 ? general::format_angka($promo->nominal) : general::format_angka($promo->disk1).' + '.general::format_angka($promo->disk2).' + '.general::format_angka($promo->disk3)) ?></td>-->
                                                <!--<td><?php echo general::status_promo($promo->tipe) ?></td>-->
                                                <td>
                                                    <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE){ ?>
                                                    <?php echo nbs() ?>
                                                    <?php echo anchor(base_url('master/data_promo_tambah.php?id=' . general::enkrip($promo->id)), '<i class="fa fa-edit"></i> Ubah', 'class="label label-success"') ?>
                                                    <?php echo nbs() ?>
                                                    <?php echo anchor(base_url('master/data_promo_tambah_item.php?id=' . general::enkrip($promo->id)), '<i class="fa fa-plus"></i> Tambah', 'class="label label-primary"') ?>
                                                    <?php echo nbs() ?>
                                                    <?php echo anchor(base_url('master/data_promo_hapus.php?id=' . general::enkrip($promo->id)), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $promo->promo . '] ? \')" class="label label-danger"') ?>
                                                    <?php } ?>
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