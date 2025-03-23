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
                        <li class="breadcrumb-item active">Karyawan</li>
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
                            <h3 class="card-title">Data Karyawan</h3>
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
                                        <th>NIK</th>
                                        <th>
                                            <?php $so = $this->input->get('sort_order') ?>
                                            <?php echo anchor(base_url('master/' . $this->uri->segment(2) . '?sort_type=nama&sort_order=' . ($so == 'asc' ? 'desc' : 'asc') . (!empty($jml) ? '&jml=' . $jml : '')), 'Nama ' . ($so == 'asc' ? '<i class="fa fa-sort-up"></i>' : ($so == 'desc' ? '<i class="fa fa-sort-down"></i>' : '<i class="fa fa-sort"></i>')), 'style="color: #000;"') ?>
                                        </th>
                                        <th>Jabatan</th>
                                        <!--<th>Alamat</th>-->
                                        <!--<th>Tipe Member</th>-->
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo form_open(base_url('master/set_cari_sales.php'), 'autocomplete="off"') ?>
                                    <tr>
                                        <td></td>
                                        <td><?php echo form_input(array('id' => 'nik', 'name' => 'nik', 'class' => 'form-control', 'placeholder' => 'Isikan NIK ...')) ?></td>
                                        <td><?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control', 'placeholder' => 'Isikan Nama Karyawan (Tanpa Gelar) ...')) ?></td>
                                        <td></td>
                                        <td><button type="submit" class="btn btn-flat btn-success"><i class="fas fa-search"></i> Cari</button></td>
                                    </tr>
                                    <?php echo form_close() ?>
                                    <?php
                                    if (!empty($sales)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($sales as $sales) {
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td><?php echo $sales->nik ?></td>
                                                <td><?php echo (!empty($sales->nama_dpn) ? $sales->nama_dpn.' ' : '').$sales->nama.(!empty($sales->nama_blk) ? ', '.$sales->nama_blk : '') ?></td>
                                                <td><?php echo $this->ion_auth->group($sales->id_user_group)->row()->description; ?></td>
                                                <!--<td><?php echo $sales->alamat ?></td>-->
                                                <!--<td><?php echo $sql_tipe->grup ?></td>-->
                                                <td>
                                                    <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE) { ?>
                                                        <?php echo anchor(base_url('master/data_sales_tambah.php?id=' . general::enkrip($sales->id)), '<i class="fas fa-edit"></i> Ubah', 'class="btn btn-info btn-flat btn-xs" style="width: 55px;"') ?>
                                                        <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE) { ?>
                                                            <?php echo nbs() ?>
                                                            <?php echo anchor(base_url('master/data_sales_hapus.php?id=' . general::enkrip($sales->id)), '<i class="fas fa-trash"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $sales->nama . '] ? \')" class="btn btn-danger btn-flat btn-xs" style="width: 55px;"') ?>
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