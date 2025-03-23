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
                            <h3 class="card-title">Data MCU</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>                                
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th>Kategori</th>
                                        <th>Pemeriksaan</th>
                                        <th>Keterangan</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
<!--                                    <tr>
                                        <td></td>
                                        <td><?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control', 'placeholder' => 'Kode ...')) ?></td>
                                        <td><?php echo form_input(array('id' => 'pasien', 'name' => 'pasien', 'class' => 'form-control', 'placeholder' => 'kategori ...')) ?></td>
                                        <td></td>
                                    </tr>-->
                                    <?php
                                    if (!empty($sql_mcu)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($sql_mcu as $mcu) {
                                            $sql_kat = $this->db->where('id', $mcu->id_kategori)->get('tbl_m_mcu_kat')->row();
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td><?php echo $sql_kat->kategori ?></td>
                                                <td><?php echo $mcu->pemeriksaan ?></td>
                                                <td><?php echo $mcu->keterangan ?></td>
                                                <td>
                                                    <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE) { ?>
                                                        <?php echo nbs() ?>
                                                        <?php echo anchor(base_url('master/data_mcu_tambah.php?id=' . general::enkrip($mcu->id)), '<i class="fa fa-edit"></i> Ubah', 'class="btn btn-info btn-flat btn-xs" style="width: 55px;"') ?>
                                                        <?php echo nbs() ?>
                                                        <?php echo anchor(base_url('master/data_mcu_hapus.php?id=' . general::enkrip($mcu->id)), '<i class="fas fa-trash"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $mcu->pemeriksaan . '] ? \')" class="btn btn-danger btn-flat btn-xs" style="width: 55px;"') ?>
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