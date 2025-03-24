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
                        <li class="breadcrumb-item active">Merk</li>
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
                    <div class="card card-default rounded-0">
                        <div class="card-header">
                            <h3 class="card-title">Data Merk</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php echo $this->session->flashdata('master'); ?>
                            <?php echo form_open(base_url('master/set_merk_cari.php'), ['method' => 'get']); ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th>Merk</th>
                                        <th>Keterangan</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <tr>
                                        <td></td>
                                        <td><?php echo form_input(array('id' => 'merk', 'name' => 'merk', 'class' => 'form-control rounded-0', 'placeholder' => 'Merk ...')) ?></td>
                                        <td></td>
                                        <td>
                                            <button type="submit" class="btn btn-primary btn-flat rounded-0">
                                                <i class="fas fa-search"></i> Cari
                                            </button>
                                        </td>
                                    </tr>
                                    <?php
                                    if (!empty($merk)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($merk as $merk) {
                                            $sql_tipe = $this->db->where('id', $merk->id_grup)->get('tbl_m_pelanggan_grup')->row();
                                            $sql_prd = $this->db->where('id_merk', $merk->id)->get('tbl_m_produk')->num_rows();
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td><?php echo $merk->merk ?></td>
                                                <td><?php echo $merk->keterangan ?></td>
                                                <td>
                                                    <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE) { ?>
                                                        <?php echo nbs() ?>
                                                        <?php echo anchor(base_url('master/data_merk_tambah.php?id=' . general::enkrip($merk->id)), '<i class="fas fa-edit"></i> Ubah', 'class="btn btn-info btn-flat btn-xs rounded-0" style="width: 55px;"') ?>
                                                        <?php echo nbs() ?>
                                                        <?php echo anchor(base_url('master/data_merk_hapus.php?id=' . general::enkrip($merk->id)), '<i class="fas fa-trash"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $merk->merk . '] ? \')" class="btn btn-danger btn-flat btn-xs rounded-0" style="width: 55px;"') ?>
                                                        <?php if (akses::hakSA() == TRUE) { ?>
                                                            <?php echo nbs() ?>
                                                            <?php echo anchor(base_url('gudang/data_stok_export.php?filter_merk=' . $merk->id . '&jml=' . $sql_prd . '&filename=' . strtolower(str_replace(array(' ', '/', '/\/', '-', '+', '&', '='), '_', $merk->merk))), '<i class="fa fa-download"></i> Unduh', 'class="label label-warning rounded-0"') ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php echo form_close(); ?>
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