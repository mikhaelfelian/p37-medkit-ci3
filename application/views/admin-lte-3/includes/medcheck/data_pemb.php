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
                            <h3 class="card-title">Data Pembayaran</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <?php echo $this->session->flashdata('medcheck'); ?>
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">No.</th>
                                        <th>Tgl</th>
                                        <th>Pasien</th>
                                        <th>No Faktur</th>
                                        <th class="text-right">Jml Total</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo form_open(base_url('medcheck/set_cari_medcheck_bayar.php'), 'autocomplete="off"') ?> 
                                    <tr>
                                        <td></td>
                                        <td><?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control', 'placeholder' => 'Tgl ...')) ?></td>
                                        <td><?php echo form_input(array('id' => 'pasien', 'name' => 'pasien', 'class' => 'form-control', 'placeholder' => 'Isikan Nama Pasien ...')) ?></td>
                                        <td><?php // echo form_input(array('id' => 'no_nota', 'name' => 'no_nota', 'class' => 'form-control', 'placeholder' => 'No Nota ...'))  ?></td>
                                        <td><?php // echo form_input(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control', 'placeholder' => 'Alamat ...'))  ?></td>
                                        <td>                                            
                                            <button class="btn btn-primary btn-flat">
                                                <i class="fa fa-search-plus"></i> Filter
                                            </button>
                                        </td>
                                    </tr>
                                    <?php echo form_close() ?> 
                                    <?php
                                    if (!empty($penj)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($penj as $penj) {
                                            $petugas = $this->db->where('id', $penj->id_sales)->get('tbl_m_sales')->row();
                                            $pasien = $this->db->where('id', $penj->id_pasien)->get('tbl_m_pasien')->row();
                                            $poli = $this->db->where('id', $penj->id_poli)->get('tbl_m_poli')->row();
                                            $app = $this->db->where('id', $penj->id_app)->get('tbl_pengaturan_cabang')->row();
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td style="width: 150px;">
                                                    <?php echo $this->tanggalan->tgl_indo($penj->tgl_masuk) ?><br/>
                                                    <small><b>ID : </b><?php echo $penj->id ?></small>
                                                </td>
                                                <td style="width: 600px;"><?php echo $pasien->nama_pgl ?></td>
                                                <td style="width: 150px;"><?php echo anchor(base_url('medcheck/tindakan.php?id=' . general::enkrip($penj->id)), $penj->no_nota, 'class="text-default"') ?></td>
                                                <td class="text-right" style="width: 150px;"><?php echo general::format_angka($penj->jml_gtotal) ?></td>
                                                <td style="width: 250px;">
                                                    <?php echo anchor(base_url('medcheck/invoice/bayar.php?id=' . general::enkrip($penj->id) . '#jml_bayar'), '<i class="fa fa-shopping-cart"></i> Bayar &raquo;', 'class="btn btn-warning btn-flat btn-xs" style="width: 75px;"') . nbs() ?>
                                                    <?php echo br(); ?>
                                                    <?php echo anchor(base_url('medcheck/tambah.php?id=' . general::enkrip($penj->id) . '&status=8&name=Bukti Pembayaran&route=medcheck/data_pemb.php'), '<i class="fa fa-file-upload"></i> Upload &raquo;', 'class="btn btn-warning btn-flat btn-xs" style="width: 75px;"') . nbs() ?>
                                                    <?php echo br(); ?>
                                                    <?php echo anchor(base_url('medcheck/invoice/print_dm_pdf.php?id=' . general::enkrip($penj->id) . '#jml_bayar'), '<i class="fa fa-file-pdf"></i> PDF Nota&raquo;', 'class="btn btn-success btn-flat btn-xs" style="width: 75px;"') . nbs() ?>
                                                    <?php echo br(); ?>
                                                    <?php echo general::status_bayar($penj->status_bayar); ?>  
                                                </td>
                                            </tr>
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
<!--<script src="<?php // echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js')     ?>"></script>-->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.css'); ?>">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!-- Page script -->
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