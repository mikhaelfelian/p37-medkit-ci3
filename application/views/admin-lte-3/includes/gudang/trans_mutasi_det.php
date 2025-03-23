<?php $hasError = $this->session->flashdata('form_error'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">MUTASI STOK</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('gudang/index.php') ?>">Gudang</a></li>
                        <li class="breadcrumb-item active">Mutasi Stok Detail</li>
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
                    <div class="card card-default rounded-0">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-truck"></i> Mutasi Stok Detail</h3>
                        </div>
                        <div class="card-body">
                            <?php echo $this->session->flashdata('gudang') ?>
                            <table class="table table-striped">
                                <tr>
                                    <th>No. Mutasi</th>
                                    <th>:</th>
                                    <td><?php echo $sql_penj->no_nota ?></td>

                                    <th>Petugas</th>
                                    <th>:</th>
                                    <td><?php echo strtoupper($this->ion_auth->user($sql_penj->id_user)->row()->first_name) ?></td>
                                </tr>
                                <tr>
                                    <th>Tgl Transaksi</th>
                                    <th>:</th>
                                    <td><?php echo $this->tanggalan->tgl_indo($sql_penj->tgl_masuk) ?></td>
                                    
                                    <th>Gudang Asal</th>
                                    <th>:</th>
                                    <td><?php echo strtoupper($this->db->where('id', $sql_penj->id_gd_asal)->get('tbl_m_gudang')->row()->gudang) ?></td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <th>:</th>
                                    <td><?php echo $sql_penj->keterangan ?></td>
                                    
                                    <th>Gudang Tujuan</th>
                                    <th>:</th>
                                    <td><?php echo strtoupper($this->db->where('id', $sql_penj->id_gd_tujuan)->get('tbl_m_gudang')->row()->gudang) ?></td>
                                </tr>
                            </table>
                            <hr/>
                            <br/>
                            <table class="table table-striped">
                                <tr>
                                    <th class="text-right" style="width: 25px;"></th>
                                    <th class="text-center" style="width: 50px;">No.</th>
                                    <th class="text-left" style="width: 100px;">Kode</th>
                                    <th class="text-left">Produk</th>
                                    <th class="text-right" style="width: 75px;">Jml</th>
                                </tr>                               

                                <?php $no = 1; ?>
                                <?php $jml_total = 0; $jml_diskon = 0; $jml_gtotal = 0; ?>
                                <?php foreach ($sql_penj_det as $items) { ?>
                                    <?php
                                    $jml_total   = $jml_total + $items->subtotal;
                                    $jml_diskon  = $jml_diskon + ($items->diskon + $items->potongan);
                                    $jml_gtotal  = $jml_gtotal + $items->subtotal;
                                    $produk      = $this->db->where('kode', $items->kode)->get('tbl_m_produk')->row();
                                    ?>
                                    <tr>
                                        <td class="text-right" style="width: 25px;"><?php // echo ($items->id_kategori2 == 0 && $sql_penj->status_bayar == 0 ? anchor(base_url('cart/cart_hapus_brg.php?id=' . general::enkrip($items->id) . '&no_nota=' . general::enkrip($items->no_nota)), '<i class="fa fa-remove"></i>', 'onclick="return confirm(\'Hapus ?\')" class="text-danger"') : '<i class="fa fa-remove"></i>')    ?></td>
                                        <td class="text-right" style="width: 50px;"><?php echo $no++ ?></td>
                                        <td class="text-left" style="width: 250px;">
                                            <?php echo anchor(base_url('gudang/data_stok_tambah.php?id='.general::enkrip($produk->id)), $items->kode, 'target="_blank"').br() ?>
                                            <small><b>ID:</b><?php echo $items->id; ?></small>
                                        </td>
                                        <td class="text-left" style="width: 550px;">                                            
                                            <?php echo ucwords($items->produk); ?><br/>
                                            <small><?php echo $items->kode_batch.(!empty($items->tgl_ed) ? ' / '.$items->tgl_ed : ''); ?></small><br/>
                                        </td>
                                        <td class="text-right" style="width: 150px;"><?php echo (!empty($items->keterangan) ? $items->jml : $items->jml) . ' ' . $items->satuan . (!empty($items->keterangan) ? $items->keterangan : ''); ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('gudang/data_mutasi.php') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-md-6 text-right">
                                    
                                </div>
                            </div>
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
        <?php echo $this->session->flashdata('gudang_toast'); ?>
    });
</script>