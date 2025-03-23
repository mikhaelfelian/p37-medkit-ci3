<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Medical Check</li>
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
                            <h3 class="card-title">Data Penunjang EKG</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php echo $this->session->flashdata('medcheck'); ?>
                            <table class="table table-striped project">
                                <thead>
                                    <?php echo form_open(base_url('medcheck/ekg/set_cari_ekg.php'), 'autocomplete="off"') ?> 
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>
                                            <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control', 'placeholder' => 'Isikan Tgl ...', 'value' => (!empty($_GET['filter_nama']) ? $_GET['filter_tgl'] : ''))) ?>
                                        </td>
                                        <td>
                                            <?php echo form_input(array('id' => '', 'name' => 'pasien', 'class' => 'form-control', 'placeholder' => 'Isikan Nama Pasien ...', 'value' => (!empty($_GET['filter_nama']) ? $_GET['filter_nama'] : ''))) ?>
                                            <input type="hidden" id="id_medcheck" name="id_medcheck" value="<?php echo (!empty($_GET['id']) ? $_GET['id'] : '') ?>">
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">
                                            <button class="btn btn-primary btn-flat">
                                                <i class="fa fa-search-plus"></i> Filter
                                            </button>
                                        </td>
                                    </tr>
                                    <?php echo form_close() ?> 
                                    <tr>
                                        <th></th>
                                        <th>No.</th>
                                        <th>ID</th>
                                        <th>Pasien</th>
                                        <th class="text-center">L / P</th>
                                        <th>Tgl Lahir</th>
                                        <th colspan="3"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($penj)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($penj as $penj) {
                                            ?>
                                            <tr>
                                                <td class="text-center" style="width: 5px">
                                                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                                                        <?php echo anchor(base_url('medcheck/hapus.php?id=' . general::enkrip($penj->id)), '<i class="fas fa-trash"></i>', 'class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus [' . $penj->no_rm . '] ?\')"') ?>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center" style="width: 10px">
                                                    <?php echo $no ?>.
                                                </td>
                                                <td class="text-left" style="width: 170px;">
                                                    <?php echo anchor(base_url('medcheck/detail.php?id=' . general::enkrip($penj->id)), '#' . $penj->no_rm, 'class="text-default"') ?>
                                                    <?php echo br(); ?>
                                                    <span class="mailbox-read-time float-left"><?php echo $this->tanggalan->tgl_indo5($penj->tgl_simpan); ?></span>
                                                    <?php echo br(); ?>
                                                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakDokter() == TRUE) { ?>
                                                        <?php if ($penj->tipe == '2') { ?>
                                                            <?php echo br(); ?>
                                                            <?php echo general::status_periksa($penj->status_periksa); ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </td>
                                                <td style="width: 450px;">
                                                    <b><?php echo $penj->pasien; ?></b>
                                                    <?php echo br(); ?>
                                                    <small><i><b><?php echo general::status_rawat2($penj->tipe); ?></b> / <?php echo $penj->poli; ?></i></small>
                                                    <?php if ($penj->jml_gtotal > 0) { ?>
                                                        <?php echo br(); ?>
                                                        <small><i><b>Rp. <?php echo general::format_angka($penj->jml_gtotal); ?></b></i></small>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center" style="width: 150px;"><?php echo general::jns_klm($penj->jns_klm) ?></td>
                                                <td class="text-left" style="width: 150px;">
                                                    <?php echo $this->tanggalan->tgl_indo2($penj->tgl_lahir); ?>
                                                    <?php echo br(); ?>
                                                    <span class="mailbox-read-time float-left"><i>(<?php echo $this->tanggalan->usia($penj->tgl_lahir) ?>)</i></span>
                                                </td>
                                                <td class="text-center" style="width: 150px;">
                                                    <a class="btn btn-primary btn-sm" href="<?php echo base_url('medcheck/tambah.php?act=pen_ekg&id=' . general::enkrip($penj->id_medcheck) . '&status=17') ?>">
                                                        <i class="fas fa-folder"></i>
                                                        <?php echo nbs(); ?>
                                                        Aksi
                                                        &raquo;
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php $no++ ?>
                                        <?php } ?>
                                    <?php } ?>
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

<!--Tanggal Rentang-->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<!--<script src="<?php // echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js')       ?>"></script>-->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.css'); ?>">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<script type="text/javascript">
    $(function () {
        $("#tgl").datepicker({
            format: 'mm/dd/yyyy',
            //defaultDate: "+1w",
            SetDate: new Date(),
            changeMonth: true,
            changeYear: true,
            yearRange: '2022:<?php echo date('Y') ?>',
            autoclose: true
        });
    });
</script>