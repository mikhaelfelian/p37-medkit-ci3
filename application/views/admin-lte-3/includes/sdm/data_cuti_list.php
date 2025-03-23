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
                        <li class="breadcrumb-item active">Pengajuan Cuti</li>
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
                            <h3 class="card-title">Data Pengajuan Cuti</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <?php echo $this->session->flashdata('master'); ?>                            
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th>Tanggal</th>
                                        <th>Nama</th>
                                        <th class="text-center">Tgl Cuti</th>
                                        <th class="text-center">s/d Tgl</th>
                                        <th class="text-left">Keterangan</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo form_open_multipart(base_url('sdm/set_cari_cuti.php'), 'autocomplete="off"') ?>
                                    <?php echo form_hidden('tipe', $this->input->get('tipe')) ?>                                    
                                    <tr>
                                        <td class="text-center"></td>
                                        <td></td>
                                        <td>
                                            <?php echo form_input(array('id' => '', 'name' => 'nama', 'class' => 'form-control rounded-0', 'placeholder' => 'Isikan Nama Karyawan ...', 'value' => (!empty($_GET['filter_nama']) ? $_GET['filter_nama'] : ''))) ?>
                                        </td>
                                        <td class="text-center" colspan="2">
                                            <select name="status" class="form-control rounded-0">
                                                <option value="">- [Pilih Status] -</option>
                                                <option value="0">Menunggu</option>
                                                <option value="1">Setuju</option>
                                                <option value="2">Ditolak</option>
                                            </select>
                                        </td>
                                        <td class="text-center"></td>
                                        <td class="text-left"></td>
                                        <td>                                            
                                            <button class="btn btn-primary btn-flat">
                                                <i class="fa fa-search-plus"></i> Filter
                                            </button>
                                        </td>
                                    </tr>
                                    <?php echo form_close() ?>
                                    <?php
                                    if (!empty($sql_cuti)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($sql_cuti as $cuti) {
                                            ?>
                                            <tr>
                                                <td class="text-center" style="width: 50px;"><?php echo $no++ ?>.</td>
                                                <td class="text-left" style="width: 100px;">
                                                    <?php echo $this->tanggalan->tgl_indo2($cuti->tgl_simpan) ?>
                                                    <?php echo br() ?>
                                                    <?php echo general::status_cuti($cuti->status) ?>
                                                </td>
                                                <td class="text-left" style="width: 350px;">
                                                    <b><?php echo $cuti->nama ?></b>
                                                    <?php echo br() ?>
                                                    <small><i><?php echo $cuti->alamat ?></i></small>
                                                    <?php echo br() ?>
                                                    <i><label class="badge badge-primary"><?php echo $cuti->tipe ?></label></i>
                                                </td>
                                                <td class="text-center" style="width: 100px;"><?php echo $this->tanggalan->tgl_indo2($cuti->tgl_masuk) ?></td>
                                                <td class="text-center" style="width: 100px;"><?php echo $this->tanggalan->tgl_indo2($cuti->tgl_keluar) ?></td>
                                                <!--<td class="text-center" style="width: 100px;"><?php // echo $this->tanggalan->tgl_indo2(date('Y-m-d', strtotime("+1 day", strtotime($cuti->tgl_keluar)))) ?></td>-->
                                                <td class="text-left" style="width: 250px;"><?php echo $cuti->keterangan ?></td>
                                                <td class="text-left" style="width: 150px;">
                                                    <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE) { ?>
                                                        <?php echo anchor(base_url('sdm/data_cuti_det.php?id=' . general::enkrip($cuti->id).'&route=sdm/data_cuti_list.php?tipe='.$this->input->get('tipe')), '<i class="fas fa-edit"></i> Detail', 'class="btn btn-info btn-flat btn-xs" style="width: 55px;"') ?>
                                                        <?php echo nbs() ?>
                                                        <?php echo anchor(base_url('sdm/pdf_cuti.php?id='.general::enkrip($cuti->id).'&id_karyawan='.general::enkrip($cuti->id_karyawan)), '<i class="fa fa-print"></i> Cetak', 'class="btn btn-primary btn-flat btn-xs" style="width: 55px;"') ?>
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