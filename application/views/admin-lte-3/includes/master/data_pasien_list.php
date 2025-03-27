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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('master/index.php') ?>">Master Data</a>
                        </li>
                        <li class="breadcrumb-item active">Pasien</li>
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
                            <h3 class="card-title">Data Pasien</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php echo $this->session->flashdata('master'); ?>
                            <?php echo form_open(base_url('master/set_cari_pasien.php'), 'autocomplete="off"') ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th>No. CM</th>
                                        <th>Pasien</th>
                                        <th class="text-center">L / P</th>
                                        <th class="text-left">No. Hp</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td><?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control rounded-0', 'placeholder' => 'No RM ...')) ?></td>
                                        <td><?php echo form_input(array('id' => 'pasien', 'name' => 'pasien', 'class' => 'form-control rounded-0', 'placeholder' => 'Isikan Pasien ...')) ?></td>
                                        <td></td>
                                        <td></td>
                                        <td><button type="submit" class="btn btn-flat btn-success rounded-0"><i class="fas fa-search"></i> Cari</button></td>
                                    </tr>
                                    <?php
                                    if (!empty($pasien)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($pasien as $pasien) {
                                            ?>
                                            <tr>
                                                <td class="text-center" style="width: 150px;"><?php echo $no++ ?>.</td>
                                                <td class="text-left" style="width: 120px;">
                                                    <?php echo anchor(base_url('master/data_pasien_det.php?id=' . general::enkrip($pasien->id)), $pasien->kode_dpn . $pasien->kode) ?>
                                                </td>
                                                <td class="text-left" style="width: 850px;">
                                                    <b><?php echo $pasien->nama_pgl ?></b>
                                                    <?php echo br() ?>
                                                    <small><?php echo $pasien->nik ?></small>
                                                    <?php echo br() ?>
                                                    <small><?php echo $this->tanggalan->tgl_indo2($pasien->tgl_lahir) . ' (' . $this->tanggalan->usia_lkp($pasien->tgl_lahir) . ')' ?></small>
                                                    <?php echo br() ?>
                                                    <small><i><?php echo $pasien->alamat ?></i></small>
                                                </td>
                                                <td class="text-center" style="width: 100px;">
                                                    <?php echo general::jns_klm($pasien->jns_klm) ?></td>
                                                <td class="text-left" style="width: 100px;"><?php echo $pasien->no_hp ?></td>
                                                <td class="text-left" style="width: 200px;">
                                                    <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE) { ?>
                                                        <?php echo anchor(base_url('master/data_pasien_tambah.php?id=' . general::enkrip($pasien->id) . (isset($_GET['q']) ? '&q=' . $this->input->get('q') : '') . (isset($_GET['jml']) ? '&jml=' . $this->input->get('jml') : '') . (isset($_GET['halaman']) ? '&halaman=' . $this->input->get('halaman') : '')), '<i class="fas fa-edit"></i> Ubah', 'class="btn btn-info btn-flat btn-xs rounded-0" style="width: 55px;"') ?>
                                                        <?php echo nbs() ?>
                                                        <?php echo anchor(base_url('master/data_pasien_hapus.php?id=' . general::enkrip($pasien->id) . '&id_user=' . general::enkrip($pasien->id_user) . (isset($_GET['q']) ? '&q=' . $this->input->get('q') : '') . (isset($_GET['jml']) ? '&jml=' . $this->input->get('jml') : '') . (isset($_GET['halaman']) ? '&halaman=' . $this->input->get('halaman') : '')), '<i class="fas fa-trash"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $pasien->nama . '] ? \')" class="btn btn-danger btn-flat btn-xs rounded-0" style="width: 55px;"') ?>
                                                    <?php } ?>
                                                    <?php if (akses::hakPerawat() == TRUE or akses::hakFarmasi() == TRUE or akses::hakAnalis() == TRUE) { ?>
                                                        <?php echo anchor(base_url('master/data_pasien_tambah.php?id=' . general::enkrip($pasien->id) . (isset($_GET['q']) ? '&q=' . $this->input->get('q') : '') . (isset($_GET['jml']) ? '&jml=' . $this->input->get('jml') : '') . (isset($_GET['halaman']) ? '&halaman=' . $this->input->get('halaman') : '')), '<i class="fas fa-edit"></i> Ubah', 'class="btn btn-info btn-flat btn-xs rounded-0" style="width: 55px;"') ?>
                                                        <?php echo nbs() ?>
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