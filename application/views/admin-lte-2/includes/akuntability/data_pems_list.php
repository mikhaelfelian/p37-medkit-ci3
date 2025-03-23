<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Pemasukan <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Pemasukan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                        <div class="box-tools">
                            <?php echo form_open('page=akuntability&act=set_cari_pems') ?>
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
                        <button type="button" onclick="window.location.href = '<?php echo base_url('akuntability/data_pems_tambah.php') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Tambah</button>
                        <?php echo br(2) ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Tgl</th>
                                    <th>Kode</th>
                                    <th>Keterangan</th>
                                    <th class="text-right">Nominal</th>
                                    <!--<th class="text-left">Jenis Biaya</th>-->
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($biaya)) {
                                    $no    = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    $total = 0;
                                    foreach ($biaya as $biaya) {
                                        $jenis  = $this->db->where('id', $biaya->id_jenis)->get('tbl_akt_kas_jns')->row();
                                        $tgl    = explode('-',$biaya->tgl);
                                        $total  = $total + $biaya->nominal;
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <td><?php echo $tgl[1].'/'.$tgl[2].'/'.$tgl[0] ?></td>
                                            <td><?php echo $biaya->kode ?></td>
                                            <td><?php echo $biaya->keterangan ?></td>
                                            <td class="text-right"><?php echo general::format_angka($biaya->nominal) ?></td>
                                            <!--<td><?php echo $biaya->jenis ?></td>-->
                                            <td>
                                                <?php if(akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdmin() == TRUE){ ?>
                                                    <?php if($biaya->jenis == '1'){ ?>
                                                        <?php echo anchor(base_url('akuntability/data_pems_tambah.php?id=' . general::enkrip($biaya->id)), '<i class="fa fa-edit"></i> Ubah', 'class="label label-success"') ?>
                                                        <?php if(akses::hakSA() == TRUE OR akses::hakOwner() == TRUE){ ?>
                                                            <?php echo nbs() ?>
                                                            <?php echo anchor(base_url('akuntability/data_pems_hapus.php?id=' . general::enkrip($biaya->id)), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $biaya->nama . '] ? \')" class="label label-danger"') ?>
                                                        <?php } ?>
                                                    <?php }else{ ?>
                                                        <?php echo nbs(75) ?>
                                                    <?php } ?>
                                                <?php }else{ ?>
                                                    <?php echo nbs(75) ?>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                    } ?>
                                        <tr>
                                            <th colspan="4" class="text-right">Total</th>
                                            <th class="text-right"><?php echo general::format_angka($total) ?></th>
                                            <th class="text-right"></th>
                                        </tr>
                                <?php } ?>
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