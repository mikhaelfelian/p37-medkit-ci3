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
                Purchase Order
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('dashboard.php') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
                <li class="active">Data PO</li>
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
                                    <td><?php echo '[' . $sql_supplier->kode . '] ' . $sql_supplier->nama ?></td>
                                </tr>
                                <tr>
                                    <th>Tgl Masuk</th>
                                    <th>:</th>
                                    <td><?php echo $this->tanggalan->tgl_indo($sql_beli->tgl_masuk) ?></td>

                                    <th>Keterangan</th>
                                    <th>:</th>
                                    <td><?php echo $sql_beli->keterangan ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <th>:</th>
                                    <td><?php echo general::status_nota_po($sql_beli->status_nota) ?></td>

                                    <th></th>
                                    <th></th>
                                    <td></td>
                                </tr>
                            </table>
                            <hr/>
                            <br/>
                            <table class="table table-striped">
                                <tr>
                                    <!--<th class="text-right" style="width: 25px;"></th>-->
                                    <th class="text-center" style="width: 50px;">No.</th>
                                    <th class="text-left" style="width: 150px;">Kode</th>
                                    <th class="text-left">Produk</th>
                                    <th class="text-center" style="width: 75px;">Jml PO</th>
                                    <th class="text-center" style="width: 50px;">Jml Stok</th>
                                    <th class="text-right">Keterangan</th>
                                </tr>                               

                                <?php $no = 1; ?>
                                <?php $subtotal = 0; ?>
                                <?php foreach ($sql_beli_det as $items) { ?>
                                    <?php $subtotal = $subtotal + $items->subtotal; ?>
                                    <?php $sql_brg = $this->db->where('id', $items->id_produk)->get('tbl_m_produk')->row() ?>
                                    <?php $sql_sat = $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row() ?>
                                    <tr>
                                        <!--<td class="text-right" style="width: 25px;"><?php // echo ($items->id_kategori2 == 0 && $sql_beli->status_bayar == 0 ? anchor(base_url('cart/cart_hapus_brg.php?id=' . general::enkrip($items->id) . '&no_nota=' . general::enkrip($items->no_nota)), '<i class="fa fa-remove"></i>', 'onclick="return confirm(\'Hapus ?\')" class="text-danger"') : '<i class="fa fa-remove"></i>')     ?></td>-->
                                        <td class="text-right" style="width: 50px;"><?php echo $no++ ?></td>
                                        <td class="text-left" style="width: 100px;"><?php echo $items->kode ?></td>
                                        <td class="text-left">                                            
                                            <?php echo ucwords($items->produk); ?>
                                        </td>
                                        <td class="text-right" style="width: 150px;"><?php echo (!empty($items->keterangan) ? $items->jml : $items->jml) . ' ' . $items->satuan . (!empty($items->keterangan) ? $items->keterangan : ''); ?></td>
                                        <td class="text-right" style="width: 75px;"><?php echo $sql_brg->jml . ' ' . $sql_sat->satuanTerkecil ?></td>
                                        <td class="text-right"><?php echo $items->keterangan_itm; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" onclick="window.location.href = '<?php echo base_url('transaksi/' . (isset($_GET['route']) ? $this->input->get('route') : 'data_po_list.php')) ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <?php if ($sql_beli->status_nota != '4') { ?>
                                        <button type="button" class="btn btn-danger btn-flat" onclick="window.location.href = '<?php echo base_url('transaksi/set_status_po.php?id=' . $this->input->get('id') . '&status=2') ?>'"><i class="fa fa-remove"></i> Set Tolak</button>
                                        <a href="#" data-toggle="modal" data-target="#modal-primary">
                                            <button type="button" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Set Setujui</button>
                                        </a>                                                                
                                    <?php } ?>
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('transaksi/cetak_nota_beli_po.php?id=' . $this->input->get('id')) ?>'"><i class="fa fa-print"></i> Cetak PO</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!--Modal form-->
            <div class="modal modal-default fade" id="modal-primary">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Form Persetujuan</h4>
                        </div>                
                        <form class="tagForm" id="form-setuju">
                            <div class="modal-body">
                                <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Proses ke pembelian ?</label><br/>
                                    <?php echo form_hidden('id', $this->input->get('id')) ?>
                                    <?php echo form_radio(array('id' => 'status-po-3', 'name' => 'status', 'value' => '3')) ?> Tidak
                                    <?php echo nbs(4) ?>
                                    <?php echo form_radio(array('id' => 'status-po-4', 'name' => 'status', 'value' => '4', 'checked' => 'TRUE')) ?> Ya
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal">Close</button>
                                <button type="button" id="submit-form-setuju" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
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
     $('#submit-form-setuju').on('click', function (e) {
         var status_po3 = $('#status-po-3').val();
         var status_po4 = $('#status-po-4').val();

         e.preventDefault();
         $.ajax({
             type: "POST",
             url: "<?php echo site_url('page=transaksi&act=set_nota_beli_status') ?>",
             data: $("form").serialize(),
             success: function (data) {
                 if($('#status-po-4').is(":checked") == true){
                    $("#modal-primary").modal('hide');
                    window.location.href="<?php echo site_url('page=transaksi&act=set_nota_beli_proses_po_st&id='.$this->input->get('id')) ?>";
                 }else{
                    $("#modal-primary").modal('hide');
                    window.location.href="<?php echo base_url('transaksi/trans_beli_po_det.php?id='.$this->input->get('id')) ?>";
                 }
             },
             error: function () {
                 alert('Error');
             }
         });
         return false;
     });
 });
</script>