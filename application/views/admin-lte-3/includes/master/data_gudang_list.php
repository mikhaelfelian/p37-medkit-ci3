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
                        <li class="breadcrumb-item active">Gudang</li>
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
                            <h3 class="card-title">Data Gudang</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <?php
                            $filter_kode = strtoupper($this->input->get('filter_kode'));
                            $filter_produk = strtoupper($this->input->get('filter_produk'));
                            $filter_barcode = $this->input->get('filter_barcode');
                            $filter_stok = $this->input->get('filter_stok');
                            $filter_merk = $this->input->get('filter_merk');
                            $filter_lokasi = $this->input->get('filter_lokasi');
                            $jml = $this->input->get('jml');
                            ?>
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th>Gudang</th>
                                        <th>Keterangan</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    if (!empty($gudang)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($gudang as $gudang) {
                                            $sql_tipe = $this->db->where('id', $gudang->id_grup)->get('tbl_m_pelanggan_grup')->row();
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td><?php echo $gudang->gudang ?></td>
                                                <td><?php echo $gudang->keterangan ?></td>
                                                <td>
                                                    <?php echo nbs() ?>
                                                    <?php echo anchor(base_url('master/data_gudang_tambah.php?id=' . general::enkrip($gudang->id)), '<i class="fas fa-edit"></i> Ubah', 'class="btn btn-info btn-flat btn-xs" style="width: 55px;"') ?>
                                                    <?php if (akses::hakSA() == TRUE) { ?>
                                                        <?php echo nbs() ?>
                                                        <?php echo anchor(base_url('master/data_gudang_hapus.php?id=' . general::enkrip($gudang->id)), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $gudang->gudang . '] ? \')" class="label label-danger"') ?>
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