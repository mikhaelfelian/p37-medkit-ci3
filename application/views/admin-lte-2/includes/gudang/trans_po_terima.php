<?php
$tgl_msk = explode('-', $sql_beli->tgl_masuk);
$tgl_klr = explode('-', $sql_beli->tgl_keluar);
$tgl_byr = explode('-', $sql_beli->tgl_bayar);

$hasError = $this->session->flashdata('form_error');
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
                    <div class="box box-warning">
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

                                    <th></th>
                                    <th></th>
                                    <td></td>
                                </tr>
                            </table>
                            <hr/>
                            <?php echo $this->session->flashdata('gudang') ?>
                            <br/>
                            <table class="table table-striped">
                                <tr>
                                    <th class="text-center" style="width: 50px;">No.</th>
                                    <th class="text-left" style="width: 100px;">Kode</th>
                                    <th class="text-left">Produk</th>
                                    <th class="text-center" style="width: 75px;">Jml</th>
                                    <th class="text-center" style="width: 75px;">Gudang</th>
                                    <th class="text-center" style="width: 75px;">Tgl Diterima</th>
                                    <th class="text-center" style="width: 75px;" colspan="2">Jml Diterima</th>
                                    <th class="text-center" style="width: 75px;">Kekurangan</th>
                                    <th class="text-right"></th>
                                </tr>                               

                                <?php $no = 1; ?>
                                <?php $subtotal = 0; $jml_item = 0; $jml_item_krg = 0; ?>
                                <?php foreach ($sql_beli_det as $items) { ?>
                                    <?php
                                    $sql_satuan = $this->db->where('id', $items->id_satuan)->get('tbl_m_satuan')->row();
                                    $subtotal   = $subtotal + $items->subtotal;
                                    $sql_mut  = $this->db->where('id_pembelian', $sql_beli->id)->where('id_produk', $items->id_produk)->where('status', '1')->get('tbl_m_produk_hist')->result();
                                    ?>
                                    <?php echo form_open(base_url('gudang/set_po_terima.php')) ?>
                                    <?php echo form_hidden('id', general::enkrip($items->id)) ?>
                                    <?php echo form_hidden('no_nota', $this->input->get('id')) ?>
                                    <?php $jml_kurang   = ($items->jml * $items->jml_satuan) - $items->jml_diterima; ?>
                                    <?php $jml_item     = $jml_item + ($items->jml * $items->jml_satuan); ?>
                                    <?php $jml_item_krg = $jml_item_krg + $jml_kurang; ?>
                                    <tr>
                                        <td class="text-center" style="width: 50px; vertical-align: middle;"><?php echo $no++ ?></td>
                                        <td class="text-left" style="width: 100px;"><?php echo anchor(base_url('gudang/data_stok_tambah.php?id='.general::enkrip($items->id_produk)), $items->kode, 'target="_blank"') ?></td>
                                        <td class="text-left"><?php echo anchor(base_url('master/data_barang_tambah.php?id='.general::enkrip($items->id_produk)), ucwords($items->produk), 'target="_blank"') ?></td>
                                        <!--<td class="text-left" style="width: 100px; vertical-align: middle;"><?php // echo anchor(base_url('gudang/data_stok_tambah.php?id=' . general::enkrip($items->id_produk)), $items->kode, 'target="_blank"') ?></td>-->
                                        <!--<td class="text-left" style="vertical-align: middle;"><?php // echo ucwords($items->produk); ?></td>-->
                                        <td class="text-center" style="width: 150px; vertical-align: middle;"><?php echo (float)(!empty($items->keterangan) ? $items->jml : $items->jml).' '.$items->satuan.(!empty($items->keterangan) ? $items->keterangan : ''); ?></td>
                                        <td class="text-center" style="width: 150px; vertical-align: middle;">
                                            <?php if($jml_kurang != 0){ ?>
                                                <div class="form-group <?php echo (!empty($hasError['gd']) ? 'has-error' : '') ?>">
                                                    <select name="gudang" class="form-control">
                                                        <option value="">- [Pilih] -</option>
                                                        <?php foreach ($sql_gudang as $gudang){ ?>
                                                            <option value="<?php echo $gudang->id ?>" selected><?php echo $gudang->gudang ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            <?php }else{ ?>
                                                -
                                            <?php } ?>
                                        </td>
                                        <?php if($jml_kurang == 0){ ?>
                                            <td class="text-center" style="width: 150px; vertical-align: middle;"><?php echo $this->tanggalan->tgl_indo2($items->tgl_terima); ?></td>
                                            <td class="text-center" style="width: 100px; vertical-align: middle;"><?php echo ''; ?></td>
                                        <?php }else{?>
                                            <td class="text-center" style="width: 150px; vertical-align: middle;">
                                                <div class="form-group <?php echo (!empty($hasError['tgl']) ? 'has-error' : '') ?>">
                                                    <?php echo form_input(array('id'=>'tgl_terima', 'name'=>'tgl_terima', 'class'=>'form-control', 'value'=>$this->tanggalan->tgl_indo($sql_beli->tgl_masuk))); ?>
                                                </div>
                                            </td>
                                            <td class="text-center" style="width: 100px; vertical-align: middle;">
                                                <div class="form-group <?php echo (!empty($hasError['tgl']) ? 'has-error' : '') ?>">
                                                    <?php echo form_input(array('id'=>'jml_terima', 'name'=>'jml_terima', 'class'=>'form-control')); ?>
                                                </div
                                            </td>
                                        <?php } ?>
                                        <td class="text-left" style="width: 75px; vertical-align: middle;"><?php echo $items->jml_diterima.' '.$sql_satuan->satuanTerkecil; ?></td>
                                        <td class="text-center" style="width: 150px; vertical-align: middle;"><?php echo $jml_kurang.' '.$sql_satuan->satuanTerkecil; ?></td>
                                        <?php if($jml_kurang == '0'){ ?>
                                            <td class="text-center" style="width: 150px; vertical-align: middle;"></td>
                                        <?php }else{ ?>
                                            <td class="text-center" style="width: 150px; vertical-align: middle;"><button type="submit" class="btn btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button></td>
                                        <?php } ?>
                                    </tr>
                                    <?php echo form_close() ?>
                                    
                                    <?php foreach ($sql_mut as $ph){ ?>
                                    <?php $sql_gd  = $this->db->where('id', $ph->id_gudang)->get('tbl_m_gudang')->row(); ?>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td colspan="7"><i>* <?php echo $this->tanggalan->tgl_indo($ph->tgl_masuk) ?> [<?php echo $sql_gd->gudang ?>] - [<?php echo ($ph->jml * $ph->jml_satuan).' '.$ph->satuan ?>]</i><?php echo nbs().anchor('page=gudang&act=data_stok_hapus_hist&id='.general::enkrip($ph->id).'&uid='.general::enkrip($items->id_produk).'&route=gudang/trans_po_terima.php', '<i class="fa fa-remove"></i>','class="text-danger" onclick="return confirm(\'Hapus ?\')"') ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                    <tr>
                                        <th class="text-right" colspan="7"> Total Barang</th>
                                        <td class="text-left" style="width: 75px; vertical-align: middle;"><?php echo $jml_item; ?> Item</td>
                                        <td class="text-center" colspan="2"></td>                                       
                                    </tr>
                            </table>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" onclick="window.location.href = '<?php echo base_url((isset($_GET['route']) ? $this->input->get('route') : 'gudang/data_po_list.php')) ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <?php if(akses::hakSA() == TRUE){ ?>
                                        <button type="button" onclick="window.location.href = '<?php echo base_url('gudang/set_po_terima_reset.php?id='.$this->input->get('id')) ?>'" class="btn btn-danger btn-flat"><i class="fa fa-check"></i> Reset</button>
                                    <?php } ?>
                                    <?php if($jml_item_krg == '0' && $sql_beli->status_penerimaan == '0'){ ?>
                                        <button type="button" onclick="window.location.href = '<?php echo base_url('gudang/set_po_terima_finish.php?id='.$this->input->get('id')) ?>'" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Simpan</button>
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
       $("[name*='tgl_terima']").datepicker({autoclose: true});
   });
</script>