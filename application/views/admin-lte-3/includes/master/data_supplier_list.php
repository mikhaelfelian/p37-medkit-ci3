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
                        <li class="breadcrumb-item active">Supplier</li>
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
                            <h3 class="card-title">Data Supplier</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <?php echo $this->session->flashdata('master'); ?>
                            <table class="table table-striped">
                                <thead>
                                    <?php echo form_open(base_url('master/set_cari_supplier.php')) ?>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th>Kode</th>
                                        <th>
                                            Supplier
                                        </th>
                                        <th>CP</th>
                                        <th>#</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th>
                                            <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' =>'form-control rounded-0', 'placeholder' => 'Isikan kode ...')) ?>
                                        </th>
                                        <th>
                                            <?php echo form_input(array('id' => 'supplier', 'name' => 'supplier', 'class' =>'form-control rounded-0', 'placeholder' => 'Isikan supplier ...')) ?>
                                        </th>
                                        <th></th>
                                        <th><button class="btn btn-primary btn-flat" type="submit"><i class="fa fa-search"></i> Filter</button></th>
                                    </tr>
                                    <?php echo form_close() ?>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($supplier)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($supplier as $supplier) {
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td style="width: 170px;"><?php echo $supplier->kode ?></td>
                                                <td style="width: 450px;">
                                                    <b><?php echo $supplier->nama ?></b>
                                                    <?php if (!empty($supplier->npwp) OR $supplier->npwp == '-') { ?>
                                                        <?php echo br(); ?>
                                                        <small><i><?php echo $supplier->npwp; ?></i></small>
                                                    <?php } ?>
                                                    <?php if (!empty($supplier->alamat) OR $supplier->alamat != '-') { ?>
                                                        <?php echo br(); ?>
                                                        <small><i><?php echo $supplier->alamat; ?></i></small>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php echo $supplier->no_hp ?>
                                                    <?php echo br(); ?>
                                                    <small><i><b><?php echo (!empty($supplier->cp) ? ' ' . $supplier->cp : ''); ?></b></i></small>
                                                </td>
                                                <td>
                                                    <?php echo anchor(base_url('master/data_supplier_tambah.php?id=' . general::enkrip($supplier->id)), '<i class="fas fa-edit"></i> Ubah', 'class="btn btn-info btn-flat btn-xs" style="width: 55px;"') ?>
                                                    <?php echo nbs() ?>
                                                    <?php echo anchor(base_url('master/data_supplier_hapus.php?id=' . general::enkrip($supplier->id)), '<i class="fas fa-trash"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $supplier->nama . '] ? \')" class="btn btn-danger btn-flat btn-xs" style="width: 55px;"') ?>
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
        <?php echo $this->session->flashdata('master_toast'); ?>
    });
</script>