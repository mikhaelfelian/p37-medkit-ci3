<?php echo $this->session->flashdata('produk') ?>
<?php
$tgl_msk = explode('-', $sql_penj->tgl_masuk);
$tgl_klr = explode('-', $sql_penj->tgl_keluar);
$tgl_byr = explode('-', $sql_penj->tgl_bayar);

$pelanggan = $this->db->select('tbl_m_pelanggan.kode, tbl_m_pelanggan.nik, tbl_m_pelanggan.nama, tbl_m_pelanggan.nama_toko, tbl_m_pelanggan.no_hp, tbl_m_pelanggan.lokasi, tbl_m_pelanggan.alamat')->where('tbl_m_pelanggan.id', $sql_penj->id_pelanggan)->get('tbl_m_pelanggan')->row();
?>
<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Transaksi
                <small>Mutasi Gudang</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('dashboard.php') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
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
                                        <td class="text-left" style="width: 250px;"><?php echo anchor(base_url('gudang/data_stok_tambah.php?id='.general::enkrip($produk->id)), $items->kode, 'target="_blank"') ?></td>
                                        <td class="text-left" style="width: 550px;">                                            
                                            <?php echo ucwords($items->produk); ?>
                                        </td>
                                        <td class="text-right" style="width: 150px;"><?php echo (!empty($items->keterangan) ? $items->jml : $items->jml) . ' ' . $items->satuan . (!empty($items->keterangan) ? $items->keterangan : ''); ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" onclick="window.location.href = '<?php echo base_url('gudang/data_mutasi.php') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <?php // echo nbs(5) ?>
                                    <?php if ($sql_penj->status_draft != '1') { ?>
                                            <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('gudang/cetak_nota.php?id=' . $this->input->get('id')) ?>'"><i class="fa fa-truck"></i> Cetak Mutasi</button>
                                            <?php echo nbs() ?>
                                    <?php } ?>
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
                                            $("#jml_ongkir").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_biaya").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_subtotal").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#disk1").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#disk2").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#disk3").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_total").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_retur").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_ppn").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_gtotal").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_bayar").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_kembali").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $("#jml_kurang").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                        });
                                        var myWindow;

                                        function download() {
                                            myWindow = window.open("<?php echo base_url('cart/cetak_nota.php?id=' . $this->input->get('id')) ?>", "", "width=200,height=100,scrollbars=no,toolbar=no,menubar=no,location=no");
//     myWindow.document.write('<p>This is \'MsgWindow\'. <?php // echo anchor(base_url('cart/cetak_nota.php?id='.$this->input->get('id')),'Refresh','onclick="tutup();"')  ?></p>');
                                            this.window.focus();
                                        }

                                        function thanks() {
                                            document.getElementById('thanks').style.display = 'block';
                                        }

                                        function tutup() {
                                            myWindow.close();
                                        }
</script>