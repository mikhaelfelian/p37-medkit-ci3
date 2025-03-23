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
                    <?php
                    switch ($_GET['act']) {
                        default:
                            $data['sql_kamar'] = $sql_kamar;
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_kamar_index', $data);
                            break;

                        case 'kmr_input':
                            $data['sql_kamar_rw'] = $sql_kamar_rw;
                            $data['sql_medc_kmr'] = $sql_medc_kmr;
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_kamar_input', $data);
                            break;
                    }
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">DATA RUANG PERAWATAN</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-left">Tgl Masuk</th>
                                                <th class="text-left">Nama Ruang</th>
                                                <th class="text-left">Keterangan</th>
                                                <th class="text-center">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            <?php foreach ($sql_medc_kmr as $kamar) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no; ?></td>
                                                    <td class="text-left"><?php echo $this->tanggalan->tgl_indo5($kamar->tgl_simpan); ?></td>
                                                    <td class="text-left">
                                                        <?php echo $kamar->kamar; ?>
                                                    </td>
                                                    <td class="text-left"><?php echo $kamar->keterangan; ?></td>
                                                    <td class="text-left">
                                                        <?php echo anchor(base_url('medcheck/set_medcheck_kamar_hps.php?id=' . general::enkrip($kamar->id_medcheck) . '&item_id=' . general::enkrip($kamar->id). '&status=' . $this->input->get('status')), '<i class="fa fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $kamar->kamar . '] ?\')"') ?>
                                                    </td>
                                                </tr>
                                                <?php $no++; ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <?php $data['gtotal'] = $gtotal ?>
                    <?php $this->load->view('admin-lte-3/includes/medcheck/med_tindakan_kanan', $data) ?>
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