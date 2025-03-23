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
                        <li class="breadcrumb-item active">Platform Penjamin</li>
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
                            <h3 class="card-title">Data Platform</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th>Kode</th>
                                        <th>Platform</th>
                                        <th>Persen</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <thead>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th><?php echo form_input(array('id'=>'kode', 'name'=>'kode', 'class'=>'form-control rounded-0', 'placeholder'=>'Kode ...')) ?></th>
                                        <th colspan="2"><?php echo form_input(array('id'=>'platform', 'name'=>'platform', 'class'=>'form-control rounded-0', 'placeholder'=>'Platform ...')) ?></th>
                                        <th class="text-left">
                                            <button class="btn btn-primary btn-flat">
                                                <i class="fa fa-search-plus"></i> Filter
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($platform)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($platform as $platform) {
                                            $sql_tipe = $this->db->where('id', $platform->id_grup)->get('tbl_m_pelanggan_grup')->row();
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td class="text-lefy" style="width: 100px;"><?php echo $platform->kode ?></td>
                                                <td><?php echo $platform->penjamin ?></td>
                                                <td><?php echo (float)$platform->persen ?>%</td>
                                                <td>
                                                    <?php if ($platform->id > 1) { ?>
                                                        <?php echo nbs() ?>
                                                        <?php echo anchor(base_url('master/data_platform_pjm_tambah.php?id=' . general::enkrip($platform->id)), '<i class="fas fa-edit"></i> Ubah', 'class="btn btn-info btn-flat btn-xs" style="width: 55px;"') ?>
                                                        <?php echo nbs() ?>
                                                        <?php echo anchor(base_url('master/data_platform_pjm_hapus.php?id=' . general::enkrip($platform->id)), '<i class="fas fa-trash"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $platform->penjamin. '] ? \')" class="btn btn-danger btn-flat btn-xs" style="width: 55px;"') ?>
                                                    <?php } else { ?>
                                                        <i class="fa fas-trash"></i> Hapus
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