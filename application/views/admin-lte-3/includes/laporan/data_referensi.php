<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

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
                        <li class="breadcrumb-item active">Data Item Referensi</li>
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
                    <?php echo form_open(base_url('laporan/data_referensi.php'), ['method' => 'get', 'autocomplete' => 'off']); ?>
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Filter Data</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php $hasError = $this->session->flashdata('form_error'); ?>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Tipe Item</label><br>
                                        <input type="radio" name="tipe" value="0" <?= (isset($_GET['tipe']) && $_GET['tipe'] == '0') ? 'checked' : (!isset($_GET['tipe']) ? 'checked' : ''); ?>> Non Stockable <?php echo nbs(2); ?>
                                        <input type="radio" name="tipe" value="1" <?= (isset($_GET['tipe']) && $_GET['tipe'] == '1') ? 'checked' : ''; ?>> Stockable <?php echo nbs(2); ?>
                                        <input type="radio" name="tipe" value="2" <?= (isset($_GET['tipe']) && $_GET['tipe'] == '2') ? 'checked' : ''; ?>> Semua <?php echo nbs(2); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">

                                </div>
                                <div class="col-lg-6 text-right">
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-search"></i> Cari</button>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <?php if (!empty($sql_referensi)) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Data Item Referensi</h3>
                                <div class="card-tools">
                                    
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
                                $uri        = substr($this->uri->segment(2), 0, -4);
                                $case       = $this->input->get('tipe');
                                $stok       = $this->input->get('stok');

                                $uri_xls    = base_url('laporan/xls_' . $uri . '.php?tipe=' . $case . '&stok=' . $stok);
                                ?>
                                <button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo $uri_xls ?>'"><i class="fas fa-file-excel"></i> Export Excel</button>
                                <?php echo br(); ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kode</th>
                                            <th>Nama Item</th>
                                            <th>Kategori</th>
                                            <th>Satuan</th>
                                            <th class="text-right">Harga Jual</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($sql_referensi)) {
                                            $no = 1;
                                            foreach ($sql_referensi as $row) {
                                                // Get kategori name
                                                $item_kat = $this->db->where('id', $row->id_kategori)->get('tbl_m_kategori')->row();
                                                // Get satuan name
                                                $item_sat = $this->db->where('id', $row->id_satuan)->get('tbl_m_satuan')->row();
                                                ?>
                                                <tr>
                                                    <td class="text-center" style="width: 10px">
                                                        <?php echo $no++ ?>.
                                                    </td>
                                                    <td class="text-left" style="width: 75px;">
                                                        <a href="<?php echo base_url('master/data_barang_tambah.php?id='.general::enkrip($row->id)) ?>" target="_blank"><?php echo $row->kode ?></a>
                                                    </td>
                                                    <td class="text-left" style="width: 450px;">
                                                        <b><?php echo $row->nama_produk; ?></b>
                                                    </td>
                                                    <td class="text-left">
                                                        <?php echo $item_kat->keterangan; ?>
                                                    </td>
                                                    <td class="text-left">
                                                        <?php echo $item_sat->satuanBesar; ?>
                                                    </td>
                                                    <td class="text-right" style="width: 100px;">
                                                        <?php echo general::format_angka($row->harga_jual); ?>
                                                    </td>
                                                </tr>
                                            <?php } 
                                        } else { ?>
                                            <tr>
                                                <td colspan="7" class="text-center">Tidak ada data</td>
                                            </tr>
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
    });
</script>
