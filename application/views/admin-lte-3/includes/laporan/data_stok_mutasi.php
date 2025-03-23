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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard2.php') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('laporan/index.php') ?>">Laporan</a></li>
                        <li class="breadcrumb-item active">Data Stok Mutasi</li>
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
                <div class="col-md-8">
                    <?php echo form_open(base_url('laporan/set_data_stok_mutasi.php'), 'autocomplete="off"') ?> 
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Laporan Mutasi Stok</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php $hasError = $this->session->flashdata('form_error'); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tanggal</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => '02/15/2022 ...', 'value' => (isset($_GET['tgl']) ? $this->tanggalan->tgl_indo($_GET['tgl']) : ''))) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tanggal Rentang</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <?php echo form_input(array('id' => 'tgl_rentang', 'name' => 'tgl_rentang', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => '02/15/2022 - 02/15/2022 ...', 'value' => (isset($_GET['tgl_awal']) ? $this->tanggalan->tgl_indo2($_GET['tgl_awal']) : ''))) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">

                                </div>
                                <div class="col-lg-6 text-right">
                                    <!--<button type="button" class="btn btn-warning btn-flat"><i class="fa fa-undo"></i> Bersih</button>-->
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-search"></i> Cari</button>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <?php echo form_close() ?> 
                </div>
            </div>
            <?php if ($_GET['jml'] > 0) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Data Laporan Penjualan</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-right">
                                        <?php echo $pagination ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
                                $uri        = substr($this->uri->segment(2), 0, -4);
                                $case       = $this->input->get('case');
                                $tg_awal    = $this->input->get('tgl_awal');
                                $tg_akhir   = $this->input->get('tgl_akhir');
                                $tg         = $this->input->get('tgl');

                                switch ($case) {
                                    case 'per_tanggal':
                                        $uri_pdf = base_url('laporan/' . $uri . '_pdf.php?case=' . $case . '&query=' . $query . (!empty($sales) ? "&id_sales=" . $sales . "" : ""));
                                        $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . '&query=' . $query . (!empty($sales) ? "&id_sales=" . $sales . "" : ""));
                                        break;

                                    case 'per_rentang':
                                        $uri_pdf = base_url('laporan/' . $uri . '_pdf.php?case=' . $case . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr . (!empty($sales) ? "&id_sales=" . $sales : "") . '&metode=' . $metode);
                                        $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr);
                                        break;
                                }
                                ?>
                                <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdmin() == TRUE) { ?>
                                    <!--<button class="btn btn-success btn-flat" onclick="window.location.href = '<?php // echo $uri_xls ?>'"><i class="fas fa-file-excel"></i> Cetak Excel</button>-->
                                    <?php echo br(); ?>
                                <?php } ?>
                                
                                <?php echo $this->session->flashdata('medcheck'); ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Item</th>
                                            <th class="text-center">Stok Masuk</th> 
                                            <th class="text-center">Stok Keluar</th> 
                                            <th class="text-center">Stok Sisa</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($sql_penj)) {
                                            $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                            foreach ($sql_penj as $penj) {                                                
                                                switch ($case) {
                                                    case 'per_tanggal':
                                                        $sm     = $this->db->select_sum('stok_masuk')->where('id', $penj->id)->where('DATE(tgl_simpan)', $tg)->get('v_produk_stok_masuk')->row();
                                                        $sk     = $this->db->select_sum('stok_keluar')->where('id', $penj->id)->where('DATE(tgl_simpan)', $tg)->get('v_produk_stok_keluar')->row();
                                                        $sisa   = $sm->stok_masuk - $sk->stok_keluar;
                                                        break;

                                                    case 'per_rentang':
                                                        $sm     = $this->db->select_sum('stok_masuk')->where('id', $penj->id)->where('DATE(tgl_simpan)>=', $tg_awal)->where('DATE(tgl_simpan)<=', $tg_akhir)->get('v_produk_stok_masuk')->row();
                                                        $sk     = $this->db->select_sum('stok_keluar')->where('id', $penj->id)->where('DATE(tgl_simpan)>=', $tg_awal)->where('DATE(tgl_simpan)<=', $tg_akhir)->get('v_produk_stok_keluar')->row();
                                                        $sisa   = $sm->stok_masuk - $sk->stok_keluar;
                                                        break;
                                                }
                                                ?>
                                                <tr>
                                                    <td class="text-center" style="width: 10px">
                                                        <?php echo $no++ ?>.
                                                    </td>
                                                    <td class="text-left" style="width: 250px;">
                                                        <b><?php echo anchor(base_url('gudang/data_stok_tambah.php?id='.general::enkrip($penj->id)), $penj->item, 'target="_blank"'); ?></b>
                                                    </td>
                                                    <td class="text-center" style="width: 100px;">
                                                        <?php echo general::format_angka($sm->stok_masuk); ?>
                                                    </td>
                                                    <td class="text-center" style="width: 100px;">
                                                        <?php echo general::format_angka($sk->stok_keluar); ?>
                                                    </td>
                                                    <td class="text-center" style="width: 50px;">
                                                        <?php echo general::format_angka($sisa); ?>
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
            <?php } ?>
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
<!--<script src="<?php // echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js')    ?>"></script>-->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.css'); ?>">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!-- Page script -->
<script type="text/javascript">
                                    $(function () {
                                        $('.select2bs4').select2({
                                            theme: 'bootstrap4'
                                        });

                                        $("#tgl").datepicker({
                                            format: 'mm/dd/yyyy',
                                            //defaultDate: "+1w",
                                            SetDate: new Date(),
                                            changeMonth: true,
                                            changeYear: true,
                                            yearRange: '2022:<?php echo date('Y') ?>',
                                            autoclose: true
                                        });

                                        $('#tgl_rentang').daterangepicker({
                                            locale: {
                                                format: 'MM/DD/YYYY'
                                            }
                                        })
                                    });
</script>