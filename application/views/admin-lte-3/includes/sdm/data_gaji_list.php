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
                        <li class="breadcrumb-item active">Data Penggajian</li>
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
                            <h3 class="card-title">Data Penggajian</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body">
                            <?php echo $this->session->flashdata('master'); ?>   
                            <a href="<?php echo base_url('sdm/data_gaji_tambah.php') ?>" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Buat Surat</a>
                            
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-left">Nama</th>
                                        <th class="text-left">Keterangan</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo form_open_multipart(base_url('sdm/set_cari_gaji.php'), 'autocomplete="off"') ?>
                                    <?php echo form_hidden('tipe', $this->input->get('tipe')) ?>
                                    
                                    <tr>
                                        <td class="text-center"></td>
                                        <td></td>
                                        <td>
                                            <?php echo form_input(array('id' => '', 'name' => 'nama', 'class' => 'form-control rounded-0', 'placeholder' => 'Isikan Nama Karyawan ...', 'value' => (!empty($_GET['filter_nama']) ? $_GET['filter_nama'] : ''))) ?>
                                        </td>
                                        <td></td>
                                        <td>                                            
                                            <button class="btn btn-primary btn-flat">
                                                <i class="fa fa-search-plus"></i> Filter
                                            </button>
                                        </td>
                                    </tr>
                                    <?php echo form_close() ?>
                                    <?php
                                    if (!empty($sql_gaji)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($sql_gaji as $gaji) {
                                            ?>
                                            <tr>
                                                <td class="text-center" style="width: 50px;"><?php echo $no++ ?>.</td>
                                                <td class="text-left" style="width: 100px;">
                                                    <?php echo $this->tanggalan->tgl_indo2($gaji->tgl_simpan) ?>
                                                    <?php echo br() ?>
                                                    <?php echo general::status_cuti($gaji->status) ?>
                                                </td>
                                                <td class="text-left" style="width: 350px;">
                                                    <b><?php echo $gaji->nama ?></b>
                                                    <?php echo br() ?>
                                                    <small><i><?php echo $gaji->alamat ?></i></small>
                                                    <?php echo br() ?>
                                                    <i><label class="badge badge-primary"><?php echo $gaji->tipe ?></label></i>
                                                </td>
                                                <td class="text-left" style="width: 250px;"><?php echo $gaji->keterangan ?></td>
                                                <td class="text-left" style="width: 150px;">
                                                    <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE) { ?>
                                                        <?php echo anchor(base_url('sdm/data_gaji_det.php?id=' . general::enkrip($gaji->id).'&route=sdm/data_gaji.php'), '<i class="fas fa-edit"></i> Detail', 'class="btn btn-info btn-flat btn-xs" style="width: 55px;"') ?>
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
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        <?php echo $this->session->flashdata('sdm_toast'); ?>
    });
</script>