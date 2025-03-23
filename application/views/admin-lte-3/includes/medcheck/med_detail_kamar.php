<?php $hasError = $this->session->flashdata('form_error'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Medical Checkup</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('medcheck/index.php') ?>">Medical Checkup</a></li>
                        <li class="breadcrumb-item active">Ruang Perawatan</li>
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
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">RUANG PERAWATAN</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Nama Ruangan</label>
                                <div class="col-sm-7">
                                    <?php echo form_input(array('id' => 'kamar', 'name' => 'kamar', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Isikan Nama Kamar ...', 'value' => $sql_kamar_rw->kamar, 'readonly' => 'true')) ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Tipe</label>
                                <div class="col-sm-7">
                                    <?php echo form_input(array('id' => 'kamar', 'name' => 'kamar', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Isikan Nama Kamar ...', 'value' => $sql_kamar_rw->tipe, 'readonly' => 'true')) ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Kapasitas Bed</label>
                                <div class="col-sm-7">
                                    <?php echo form_input(array('id' => 'jml_max', 'name' => 'jml_max', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Isikan Nama Kamar ...', 'value' => $sql_kamar_rw->jml_max, 'readonly' => 'true')) ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Terpakai</label>
                                <div class="col-sm-7">
                                    <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Isikan Nama Kamar ...', 'value' => $sql_kamar_rs->num_rows(), 'readonly' => 'true')) ?>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('dashboard2.php') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">                                 

                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">

                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">DATA PASIEN</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped project">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-left">Tgl Masuk</th>
                                        <th class="text-left">No. RM</th>
                                        <th class="text-left">Pasien</th>
                                        <th class="text-center">L / P</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($sql_kamar_rs->result() as $kamar) { ?>
                                        <tr>
                                            <td class="text-center" style="width: 50px;"><?php echo $no; ?></td>
                                            <td class="text-left" style="width: 100px;"><?php echo $this->tanggalan->tgl_indo5($kamar->tgl_simpan); ?></td>
                                            <td class="text-left" style="width: 100px;"><?php echo anchor(base_url('medcheck/transfer.php?id='.general::enkrip($kamar->id).'&status=7'), $kamar->kode_dpn.$kamar->kode, 'target="_blank"'); ?></td>
                                            <td class="text-left" style="width: 350px;"><?php echo $kamar->pasien; ?></td>
                                            <td class="text-center" style="width: 100px;"><?php echo $kamar->jns_klm; ?></td>
                                        </tr>
                                        <?php $no++; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">

                                </div>
                                <div class="col-lg-6 text-right">                                 

                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">

                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
                                        $(function () {
<?php echo $this->session->flashdata('medcheck_toast'); ?>
                                        });
</script>