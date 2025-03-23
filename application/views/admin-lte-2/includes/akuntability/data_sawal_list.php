<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Akun <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Akun</li>
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
                            <?php echo form_open('page=akuntability&act=set_cari_akun') ?>
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
                        <!--<button type="button" onclick="window.location.href = '<?php echo base_url('akuntability/data_akun_tambah.php') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Tambah</button>-->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-left" style="width: 350px;">Akun</th>
                                    <th class="text-right">Debet</th>
                                    <th class="text-right">Kredit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($biaya)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($biaya as $akun) {
                                        if($akun->id_akun_grup != 4 && $akun->id_akun_grup != 5){
                                        ?>
                                            <tr>
                                                <td class="text-left" style="width: 350px;"><?php echo nbs(5).$akun->grup.' - '.$akun->nama ?></td>
                                                <td class="text-right" style="width: 350px;"><?php echo general::format_angka(($akun->saldo_awal < 0 ? -$akun->saldo_awal : 0)) ?></td>
                                                <td class="text-right" style="width: 350px;"><?php echo general::format_angka(($akun->saldo_awal > 0 ? $akun->saldo_awal : 0)) ?></td>
                                                <td>
                                                    <?php // echo anchor(base_url('akuntability/data_akun_tambah.php?id=' . general::enkrip($akun->id)), '<i class="fa fa-edit"></i> Ubah', 'class="label label-primary"') ?>
                                                    <?php // echo nbs(2) ?>
                                                    <?php // echo anchor(base_url('akuntability/data_akun_hapus.php?id=' . general::enkrip($akun->id)), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $akun->nama . '] ? \')" class="label label-danger"') ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }else{
                                        ?>
                                            <tr>
                                                <td class="text-left" style="width: 350px;"><?php echo nbs(5).$akun->grup.' - '.$akun->nama ?></td>
                                                <td class="text-right" style="width: 350px;"><?php echo general::format_angka(($akun->saldo_awal < 0 ? -$akun->saldo_awal : 0)) ?></td>
                                                <td class="text-right" style="width: 350px;"><?php echo general::format_angka(($akun->saldo_awal > 0 ? $akun->saldo_awal : 0)) ?></td>
                                                <td>
                                                    <?php // echo anchor(base_url('akuntability/data_akun_tambah.php?id=' . general::enkrip($akun->id)), '<i class="fa fa-edit"></i> Ubah', 'class="label label-primary"') ?>
                                                    <?php // echo nbs(2) ?>
                                                    <?php // echo anchor(base_url('akuntability/data_akun_hapus.php?id=' . general::enkrip($akun->id)), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $akun->nama . '] ? \')" class="label label-danger"') ?>
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