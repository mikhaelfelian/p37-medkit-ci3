<?php echo $this->session->flashdata('produk') ?>
<?php
$tgl_msk = explode('-', $sql_beli->tgl_masuk);
$tgl_klr = explode('-', $sql_beli->tgl_keluar);
$tgl_byr = explode('-', $sql_beli->tgl_bayar);
?>
<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Transaksi
                <small>Penerimaan</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
                <li class="active">Detail</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-shopping-cart"></i> Form Transaksi</h3>
                        </div>
                        <div class="box-body">
                            <?php echo $this->session->flashdata('transaksi') ?>
                            <table class="table table-striped">
                                <tr>
                                    <th>No. Purchase Order</th>
                                    <th>:</th>
                                    <td><?php echo $sql_beli->no_nota ?></td>

                                    <th>Supplier</th>
                                    <th>:</th>
                                    <td><?php echo '['.$sql_supplier->kode.'] '.$sql_supplier->nama ?></td>
                                </tr>
                                <tr>
                                    <th>Tgl Masuk</th>
                                    <th>:</th>
                                    <td><?php echo $tgl_msk[1].'/'.$tgl_msk[2].'/'.$tgl_msk[0] ?></td>

                                    <th>Username</th>
                                    <th>:</th>
                                    <td><?php echo $this->ion_auth->users($sql_beli->id_user)->row()->first_name ?></td>
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
                                    <!--<th class="text-left">User</th>-->
                                    <th class="text-center" style="width: 75px;">Jml</th>
                                    <th class="text-center" style="width: 75px;">Jml Diterima</th>
                                    <th class="text-center" style="width: 75px;">Kekurangan</th>
                                </tr>
                                <?php $no = 1; ?>
                                <?php $subtotal = 0; ?>
                                <?php foreach ($sql_beli_det as $items) { ?>
                                    <?php
                                    $subtotal = $subtotal + $items->subtotal;
                                    $sql_mut  = $this->db->where('id_pembelian', $sql_beli->id)->where('id_produk', $items->id_produk)->where('status', '1')->get('tbl_m_produk_hist')->result();
                                    ?>
                                    <tr>
                                        <td class="text-right" style="width: 25px;"><?php // echo ($items->id_kategori2 == 0 && $sql_beli->status_bayar == 0 ? anchor(base_url('cart/cart_hapus_brg.php?id=' . general::enkrip($items->id) . '&no_nota=' . general::enkrip($items->no_nota)), '<i class="fa fa-remove"></i>', 'onclick="return confirm(\'Hapus ?\')" class="text-danger"') : '<i class="fa fa-remove"></i>')   ?></td>
                                        <td class="text-center" style="width: 50px;"><?php echo $no++ ?></td>
                                        <td class="text-left" style="width: 100px;"><?php echo anchor(base_url('gudang/data_stok_tambah.php?id='.general::enkrip($items->id_produk)), $items->kode, 'target="_blank"') ?></td>
                                        <td class="text-left"><?php echo anchor(base_url('master/data_barang_tambah.php?id='.general::enkrip($items->id_produk)), ucwords($items->produk), 'target="_blank"') ?></td>
                                        <!--<td class="text-left"><?php echo ucwords($items->produk); ?></td>-->
                                        <td class="text-center" style="width: 150px;"><?php echo (float)(!empty($items->keterangan) ? $items->jml : $items->jml).' '.$items->satuan.(!empty($items->keterangan) ? $items->keterangan : ''); ?></td>
                                        <td class="text-center" style="width: 150px;"><?php echo (float)(!empty($items->jml_diterima) ? $items->jml_diterima : '0'); ?></td>
                                        <td class="text-center" style="width: 150px;"><?php echo (float)(!empty($items->jml_diterima) ? ($items->jml * $items->jml_satuan) - $items->jml_diterima : '0'); ?></td>
                                    </tr>
                                    <?php foreach ($sql_mut as $ph){ ?>
                                    <?php $sql_gd  = $this->db->where('id', $ph->id_gudang)->get('tbl_m_gudang')->row(); ?>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td colspan="4"><i>* <?php echo $this->tanggalan->tgl_indo($ph->tgl_masuk) ?> [<?php echo $sql_gd->gudang ?>] - [<?php echo ($ph->jml * $ph->jml_satuan).' '.$ph->satuan ?>]</i></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </table>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" onclick="window.location.href = '<?php echo base_url((isset($_GET['route']) ? $this->input->get('route') : 'gudang/data_po_list.php')) ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.container -->
</div>

<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/sb-admin') ?>/ui/jquery-ui.min.css" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.min.css') ?>">

<!--Datepicker-->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Page script -->
<script>
   $(function () {
       // Jquery kanggo format angka
       $("#jml_dpp").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_ppn").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_total").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_retur").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_bayar").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_kurang").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_gtotal").autoNumeric({aSep: '.', aDec: ',', aPad: false});
   });
</script>