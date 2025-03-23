<?php echo $this->session->flashdata('produk') ?>
<?php
$tgl_msk = explode('-', $sql_ret->tgl_simpan);
$tgl_klr = explode('-', $sql_ret->tgl_keluar);
$tgl_byr = explode('-', $sql_ret->tgl_bayar);

$pelanggan = $this->db->select('tbl_m_pelanggan.kode, tbl_m_pelanggan.nik, tbl_m_pelanggan.nama, tbl_m_pelanggan.no_hp, tbl_m_pelanggan.lokasi, tbl_m_pelanggan.alamat, tbl_m_pelanggan_grup.grup, tbl_m_pelanggan_grup.status_deposit')->join('tbl_m_pelanggan_grup', 'tbl_m_pelanggan_grup.id=tbl_m_pelanggan.id_grup')->where('tbl_m_pelanggan.id', $sql_ret->id_pelanggan)->get('tbl_m_pelanggan');
?>
<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Data
                <small>Transaksi</small>
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
                            <h3 class="box-title"><i class="fa fa-shopping-cart"></i> Data Retur Penjualan</h3>
                        </div>
                        <div class="box-body">
                            <?php echo $this->session->flashdata('transaksi') ?>
                            <table class="table table-striped">
                                <tr>
                                    <th>No. Retur</th>
                                    <th>:</th>
                                    <td><?php echo '#'.$sql_ret->no_retur ?></td>

                                    <th>No. Nota Penjualan</th>
                                    <th>:</th>
                                    <td><?php echo '#'.$sql_ret->no_nota ?></td>
                                </tr>
                                <tr>
                                    <th>Tgl Retur</th>
                                    <th>:</th>
                                    <td><?php echo $tgl_msk[1].'/'.$tgl_msk[2].'/'.$tgl_msk[0] ?></td>
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
                                    <th class="text-right">Harga</th>
                                    <th class="text-center">Diskon</th>
                                    <th class="text-right">Subtotal</th>
                                    <th class="text-right"></th>
                                </tr>                               

                                <?php $no = 1; ?>
                                <?php $subtotal = 0; ?>
                                <?php foreach ($sql_ret_det as $items) { ?>
                                    <?php
                                    $subtotal = $subtotal + $items->subtotal;
                                    ?>
                                    <tr>
                                        <td class="text-right" style="width: 25px;"><?php // echo ($items->id_kategori2 == 0 && $sql_ret->status_bayar == 0 ? anchor(base_url('cart/cart_hapus_brg.php?id=' . general::enkrip($items->id) . '&no_nota=' . general::enkrip($items->no_nota)), '<i class="fa fa-remove"></i>', 'onclick="return confirm(\'Hapus ?\')" class="text-danger"') : '<i class="fa fa-remove"></i>')   ?></td>
                                        <td class="text-right" style="width: 50px;"><?php echo $no++ ?></td>
                                        <td class="text-left" style="width: 100px;"><?php echo $items->kode ?></td>
                                        <td class="text-left">                                            
                                            <?php echo ucwords($items->produk); ?>
                                        </td>
                                        <td class="text-right" style="width: 150px;"><?php echo $items->jml.' '.$items->satuan.' '.(!empty($items->keterangan) ? $items->keterangan : ''); ?></td>
                                        <td class="text-right">
                                            <?php echo ($items->harga != 0 ? general::format_angka($items->harga) : ''); ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo general::format_angka($items->disk1) . (!empty($items->disk2) ? ' + ' . general::format_angka($items->disk2) : '') . (!empty($items->disk3) ? ' + ' . general::format_angka($items->disk3) : '') ?>
                                        </td>
                                        <td class="text-right">
                                            <?php echo ($items->harga != 0 ? general::format_angka($items->subtotal) : ''); ?>
                                        </td>
                                        <td class="text-right">
                                            <?php echo general::status_retur($items->status_retur); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <th colspan="6" class="text-right" style="vertical-align: middle;">
                                    </th>
                                    <th class="text-right" style="vertical-align: middle;"><?php echo ($sql_ret->jml_retur < 0 ? 'Kurang Bayar' : 'Grand Total') ?></th>
                                    <th  class="text-right" style="width: 200px;">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                Rp.
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_retur', 'name' => 'jml_retur', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => (int)$sql_ret->jml_retur)) ?>
                                        </div>
                                    </th>
                                </tr>
                            </table>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" onclick="window.location.href = '<?php echo base_url('transaksi/'.(isset($_GET['route']) ? $this->input->get('route') : 'data_retur_jual_list.php')) ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <?php if ($sql_ret->status_bayar == '0') { ?>
                                                        <!--//<?php // echo form_checkbox(array('name' => 'cetak', 'value' => '1')) . nbs(2)     ?> Cetak Nota-->
                                    <?php } ?>
                                    <?php echo nbs(5) ?>
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href='<?php echo base_url('transaksi/cetak_nota_retjual.php?id=' . $this->input->get('id')) ?>'"><i class="fa fa-print"></i> Cetak Nota Retur</button>
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
       $("#jml_diskon").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_total").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_subtotal").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_retur").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_ppn").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_gtotal").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_bayar").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_kembali").autoNumeric({aSep: '.', aDec: ',', aPad: false});
       $("#jml_kurang").autoNumeric({aSep: '.', aDec: ',', aPad: false});
   });
 var myWindow;

 function download() {
     myWindow = window.open("<?php echo base_url('cart/cetak_nota.php?id=' . $this->input->get('id')) ?>", "", "width=200,height=100,scrollbars=no,toolbar=no,menubar=no,location=no" );
//     myWindow.document.write('<p>This is \'MsgWindow\'. <?php // echo anchor(base_url('cart/cetak_nota.php?id='.$this->input->get('id')),'Refresh','onclick="tutup();"') ?></p>');
     this.window.focus();
 }

 function thanks() {
     document.getElementById('thanks').style.display = 'block';
 }
 
 function tutup(){
     myWindow.close();
 }
</script>