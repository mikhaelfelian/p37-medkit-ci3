<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!--<h1 class="m-0">Master Data</h1>-->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('master/index.php') ?>">Master Data</a></li>
                        <li class="breadcrumb-item active">Medical Checkup</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Data Kategori MCU</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php echo form_open(base_url('master/set_mcu_kat_cari.php'), array('method' => 'get')) ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th>Kategori</th>
                                        <th>Keterangan</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <tr>
                                        <td></td>
                                        <td><?php echo form_input(array('id' => 'kategori', 'name' => 'kategori', 'class' => 'form-control rounded-0', 'placeholder' => 'Kategori ...')) ?></td>
                                        <td></td>
                                        <td><button type="submit" class="btn btn-primary rounded-0"><i class="fa fa-search"></i> Cari</button></td>
                                    </tr>
                                    <?php
                                    if (!empty($kategori)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($kategori as $kategori) {
                                            
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td><?php echo $kategori->kategori ?></td>
                                                <td><?php echo $kategori->keterangan ?></td>
                                                <td>
                                                    <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE) { ?>
                                                        <?php echo nbs() ?>
                                                        <?php echo anchor(base_url('master/data_mcu_kat_tambah.php?id=' . general::enkrip($kategori->id)), '<i class="fa fa-edit"></i> Ubah', 'class="btn btn-info btn-flat btn-xs rounded-0" style="width: 55px;"') ?>
                                                        <?php echo nbs() ?>
                                                        <?php echo anchor(base_url('master/data_mcu_kat_hapus.php?id=' . general::enkrip($kategori->id)), '<i class="fas fa-trash"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $kategori->kategori . '] ? \')" class="btn btn-danger btn-flat btn-xs rounded-0" style="width: 55px;"') ?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
    $(function () {
        <?php echo $this->session->flashdata('master_toast'); ?>
    });
</script>