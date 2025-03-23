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
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE) { ?>
                                        <?php echo form_open(base_url('master/set_cari_karyawan.php'), 'autocomplete="off"') ?>
                                        <tr>
                                            <td></td>
                                            <td><?php echo form_input(array('id' => 'nik', 'name' => 'nik', 'class' => 'form-control rounded-0', 'placeholder' => 'Isikan NIK ...')) ?></td>
                                            <td><?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control rounded-0', 'placeholder' => 'Isikan Nama Karyawan (Tanpa Gelar) ...')) ?></td>
                                            <td>
                                                <select name="grup" class="form-control rounded-0">
                                                    <option value="">- Pilih -</option>
                                                    <?php
                                                    $grup = $this->ion_auth->groups()->result();
                                                    foreach ($grup as $grup) {
                                                        if ($grup->name != 'superadmin') {
                                                            echo '<option value="' . $grup->id . '" ' . (!empty($sql_kary->id_user) ? ($grup->name == $this->ion_auth->get_users_groups($sql_kary->id_user)->row()->name ? 'selected' : '') : '') . '>' . ucfirst($grup->description) . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td><button type="submit" class="btn btn-flat btn-success"><i class="fas fa-search"></i> Cari</button></td>
                                        </tr>
                                        <?php echo form_close() ?>
                                    <?php } ?>
                                    <?php
                                    if (!empty($sales)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($sales as $sales) {
                                            $sql_kel = $this->db->where('id_karyawan', $sales->id)->get('tbl_m_karyawan_kel');
                                            $sql_pnd = $this->db->where('id_karyawan', $sales->id)->get('tbl_m_karyawan_pend');
                                            $sql_srt = $this->db->where('id_karyawan', $sales->id)->get('tbl_m_karyawan_sert');
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td><?php echo $sales->nik ?></td>
                                                <td><?php echo (!empty($sales->nama_dpn) ? $sales->nama_dpn . ' ' : '') . $sales->nama . (!empty($sales->nama_blk) ? ', ' . $sales->nama_blk : '') ?></td>
                                                <td>
                                                    <?php echo $this->ion_auth->group($sales->id_user_group)->row()->description; ?>
                                                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE) { ?>
                                                        <?php
                                                    echo ($sql_kel->num_rows() == 0 ? br() . '<label class="badge badge-warning"><i class="far fa-solid fa-clock-rotate-left"></i> Keluarga Belum</label>' : '');
                                                    echo ($sql_pnd->num_rows() == 0 ? br() . '<label class="badge badge-warning"><i class="far fa-solid fa-clock-rotate-left"></i> Pendidikan Belum</label>' : '');
                                                    echo ($sql_srt->num_rows() == 0 ? br() . '<label class="badge badge-warning"><i class="far fa-solid fa-clock-rotate-left"></i> Sertifikasi Belum</label>' : '');
                                                    ?>
                                                    <?php } ?>
                                                </td>
                                                <!--<td><?php echo $sales->alamat ?></td>-->
                                                <!--<td><?php echo $sql_tipe->grup ?></td>-->
                                                <td>
                                                    <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE) { ?>
                                                        <?php echo anchor(base_url('master/data_karyawan_tambah.php?id=' . general::enkrip($sales->id)), '<i class="fas fa-edit"></i> Ubah', 'class="btn btn-info btn-flat btn-xs" style="width: 55px;"') ?>
                                                        <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE) { ?>
                                                            <?php echo nbs() ?>
                                                            <?php echo anchor(base_url('master/set_karyawan_hapus.php?id=' . general::enkrip($sales->id)), '<i class="fas fa-trash"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $sales->nama . '] ? \')" class="btn btn-danger btn-flat btn-xs" style="width: 55px;"') ?>
                                                        <?php } ?>
                                                    <?php }else{ ?>
                                                        <?php echo anchor(base_url('master/data_karyawan_jadwal.php?id=' . general::enkrip($sales->id)), '<i class="fas fa-edit"></i> Jadwal', 'class="btn btn-info btn-flat btn-xs" style="width: 75px;"') ?>
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