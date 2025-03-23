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
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Data Klinik</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <?php echo $this->session->flashdata('master'); ?>
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th>NIK</th>
                                        <th>
                                            <?php $so = $this->input->get('sort_order') ?>
                                            <?php echo anchor(base_url('master/' . $this->uri->segment(2) . '?sort_type=nama&sort_order=' . ($so == 'asc' ? 'desc' : 'asc') . (!empty($jml) ? '&jml=' . $jml : '')), 'Nama ' . ($so == 'asc' ? '<i class="fa fa-sort-up"></i>' : ($so == 'desc' ? '<i class="fa fa-sort-down"></i>' : '<i class="fa fa-sort"></i>')), 'style="color: #000;"') ?>
                                        </th>
                                        <th>Tgl Lahir</th>
                                        <th>L / P</th>
                                        <th>No. Hp</th>
                                        <th>
                                            <?php $so = $this->input->get('sort_order') ?>
                                            <?php echo anchor(base_url('master/' . $this->uri->segment(2) . '?sort_type=lokasi&sort_order=' . ($so == 'asc' ? 'desc' : 'asc') . (!empty($jml) ? '&jml=' . $jml : '')), 'Alamat ' . ($so == 'asc' ? '<i class="fa fa-sort-up"></i>' : ($so == 'desc' ? '<i class="fa fa-sort-down"></i>' : '<i class="fa fa-sort"></i>')), 'style="color: #000;"') ?>
                                        </th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td><?php echo form_input(array('id' => 'nik', 'name' => 'nik', 'class' => 'form-control', 'placeholder' => 'NIK ...')) ?></td>
                                        <td><?php echo form_input(array('id' => 'pasien', 'name' => 'pasien', 'class' => 'form-control', 'placeholder' => 'Pasien ...')) ?></td>
                                        <td><?php echo form_input(array('id' => 'tgl_lahir', 'name' => 'tgl_lahir', 'class' => 'form-control', 'placeholder' => 'Tgl Lahir ...')) ?></td>
                                        <td></td>
                                        <td><?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control', 'placeholder' => 'No. HP ...')) ?></td>
                                        <td></td>
                                    </tr>
                                    <?php
                                    if (!empty($pelanggan)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($pelanggan as $pelanggan) {
                                            $sql_diskon = $this->db->where('id_pelanggan', $pelanggan->id)->get('tbl_m_pelanggan_diskon')->row();
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td><?php echo anchor(base_url('master/data_pasien_det.php?id='.general::enkrip($pelanggan->id)), $pelanggan->nik) ?></td>
                                                <td><?php echo $pelanggan->nama ?></td>
                                                <td><?php echo $this->tanggalan->tgl_indo(date('Y-m-d')) ?></td>
                                                <td><?php echo $pelanggan->no_hp ?></td>
                                                <td>Laki - Laki</td>
                                                <td><?php echo $pelanggan->alamat ?></td>
                                                <td>
                                                    <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE) { ?>
                                                        <?php echo anchor(base_url('master/data_customer_tambah.php?id=' . general::enkrip($pelanggan->id) . (isset($_GET['q']) ? '&q=' . $this->input->get('q') : '') . (isset($_GET['jml']) ? '&jml=' . $this->input->get('jml') : '') . (isset($_GET['halaman']) ? '&halaman=' . $this->input->get('halaman') : '')), '<i class="fa fa-edit"></i> Ubah', 'class="label label-success"') ?>
                                                        <?php echo nbs() ?>
                                                        <?php echo anchor(base_url('master/data_customer_hapus.php?id=' . general::enkrip($pelanggan->id) . (isset($_GET['q']) ? '&q=' . $this->input->get('q') : '') . (isset($_GET['jml']) ? '&jml=' . $this->input->get('jml') : '') . (isset($_GET['halaman']) ? '&halaman=' . $this->input->get('halaman') : '')), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $pelanggan->nama . '] ? \')" class="label label-danger"') ?>
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