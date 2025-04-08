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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('gudang/index.php') ?>">Gudang</a></li>
                        <li class="breadcrumb-item active">Stock Opname</li>
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
                            <h3 class="card-title">Data Stok Opname</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo isset($pagination) ? $pagination : ''; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th>Tgl Opname</th>
                                        <th>User</th>
                                        <th>Keterangan</th>
                                        <th></th>
                                    </tr>
                                    <?php echo form_open_multipart(base_url('gudang/set_cari_opn.php'), 'autocomplete="off"') ?>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th><?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control rounded-0', 'placeholder' => 'Isikan Tgl ...')) ?></th>
                                        <th></th>
                                        <th><?php echo form_input(array('id' => 'ket', 'name' => 'ket', 'class' => 'form-control rounded-0', 'placeholder' => 'Isikan Keterangan ...')) ?></th>
                                        <th>
                                            <button class="btn btn-primary btn-flat">
                                                <i class="fa fa-search-plus"></i> Filter
                                            </button>
                                        </th>
                                    </tr>
                                    <?php echo form_close() ?>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($opname)) {
                                        $no = (isset($_GET['halaman']) && is_numeric($_GET['halaman'])) ? (int)$_GET['halaman'] + 1 : 1;
                                        foreach ($opname as $opname) {
                                            ?>
                                            <tr>
                                                <td style="width: 50px;" class="text-center"><?php echo $no++ ?>.</td>
                                                <td style="width: 100px;" class="text-left"><?php echo $this->tanggalan->tgl_indo($opname->tgl_simpan) ?></td>
                                                <td style="width: 250px;" class="text-left"><?php echo anchor(base_url('gudang/data_opname_det.php?id=' . general::enkrip($opname->id)), $this->ion_auth->user($opname->id_user)->row()->first_name, '') ?></td>
                                                <td style="width: 350px;" class="text-left"><?php echo $opname->keterangan; // echo (!empty($opname->dl_file) ? anchor(base_url('gudang/data_opname_dl.php?id='.general::enkrip($opname->id).'&file='.$opname->nm_file), $opname->nm_file) : $opname->nm_file)  ?></td>
                                                <td style="width: 100px;" class="text-left">
                                                    <?php if($opname->id_user == $this->ion_auth->user()->row()->id): ?>
                                                        <?php echo anchor(base_url('gudang/data_opname_tambah.php?nota=' . general::enkrip($opname->id)), '<i class="fa fa-edit"></i> Ubah', 'class="btn btn-info btn-flat btn-xs" style="width: 55px;"') ?>
                                                    <?php endif; ?>
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

<!-- Page script -->
<script type="text/javascript">
    $(function () {        
        $("input[id=tgl]").datepicker({
            dateFormat: 'mm/dd/yy',
            changeMonth: true,
            changeYear: true,
            autoclose: true
        });
    });
</script>