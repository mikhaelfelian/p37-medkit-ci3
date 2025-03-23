<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Transaksi
                <small>Pembelian</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('dashboard.php') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
                <li class="active">Form Pembelian</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-shopping-cart"></i> Form Pembelian</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <?php echo form_open_multipart(base_url('transaksi/'.(!empty($_GET['id']) ? 'set_nota_beli_update_po' : 'set_nota_beli_update_po').'.php')) ?>
                                <input type="hidden" id="id_supplier" name="id_supplier" value="<?php echo $sql_beli->id_supplier ?>">
                                <input type="hidden" id="id" name="id" value="<?php echo $this->input->get('id') ?>">
                                
                                <div class="col-md-6">                                    
                                    <table class="table table-striped">
                                        <tr>
                                            <th style="vertical-align: middle;">Nama Supplier</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">                                   
                                                <div id="bag-pelanggan" class="<?php echo (!empty($hasError['pelanggan']) ? 'has-error' : '') ?>">
                                                    <!--<div class="form-group text-middle">-->
                                                    <div class="input-group date">
                                                        <?php echo form_input(array('id' => 'supplier', 'name' => 'supplier', 'class' => 'form-control text-middle', 'style' => 'vertical-align: middle;', 'value'=>$sql_supplier->nama)) ?>
                                                        <div class="input-group-addon text-middle">                                                        
                                                            <a href="#" data-toggle="modal" data-target="#modal-primary" style="vertical-align: middle;">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <!--</div>-->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Tgl</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <?php echo form_input(array('id' => 'tgl_masuk', 'name' => 'tgl_masuk', 'class' => 'form-control pull-right', 'value' => $this->tanggalan->tgl_indo($sql_beli->tgl_masuk))) ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Keterangan</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <?php echo form_input(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control pull-right', 'value'=>$sql_beli->keterangan)) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Pengiriman</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <?php echo form_input(array('id' => 'pengiriman', 'name' => 'pengiriman', 'class' => 'form-control pull-right', 'value'=>$sql_beli->pengiriman)) ?>
                                            </td>
                                        </tr>
                                        <!--
                                        <tr>
                                            <th style="vertical-align: middle;">Sales</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <?php echo form_input(array('id' => 'sales', 'name' => 'sales', 'class' => 'form-control pull-right')) ?>
                                            </td>
                                        </tr>
                                        -->
                                        <tr>
                                            <td style="vertical-align: middle; text-align: right;" colspan="3">                                                
                                                <button type="button" class="btn btn-warning btn-flat" onclick="window.location.href='<?php echo base_url('transaksi/set_nota_batal.php?term=beli&route=data_po_list.php') ?>'">Batal</button>
                                                <button type="submit" class="btn btn-primary btn-flat">Set Order</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <?php echo form_close() ?>
                                <?php if (!empty($sess_beli)) { ?>
                                <?php echo form_open_multipart(base_url('transaksi/cart_beli_simpan_po.php')) ?>
                                <input type="hidden" id="id_barang" name="id_barang" value="<?php echo $this->input->get('id_produk') ?>">
                                <input type="hidden" id="id_pembelian" name="id_pembelian" value="<?php echo $_GET['id'] ?>">
                                <input type="hidden" id="no_nota" name="no_nota" value="<?php echo $_GET['id'] ?>">
                                <input type="hidden" id="no_nota" name="rute" value="transaksi/trans_beli_edit_po.php">
                                
                                <div class="col-md-6">                                    
                                    <table class="table table-striped">
                                        <tr>
                                            <th style="vertical-align: middle;">Kode</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right', 'value'=>(isset($_GET['id_produk']) ? $sql_produk->kode : ''))) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Jumlah</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div class="input-group">
                                                        <?php if($sql_produk->status_brg_dep == '1'){ ?>
                                                                <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'value' => '1', 'style' => (!isset($_GET['id_produk']) ? 'width: 100px;' : ''), 'readonly'=>'TRUE')) ?><?php if (isset($_GET['id_produk'])) { ?>
                                                                    <span class="input-group-addon no-border text-bold"><?php echo nbs() ?></span>
                                                                    <select name="satuan" class="form-control">
                                                                        <?php foreach ($sql_produk_sat as $satuan){ ?>
                                                                            <option value="<?php echo $satuan->satuan ?>"><?php echo ucwords($satuan->satuan).($satuan->satuan != $sql_satuan->satuanTerkecil ? ' ('.$satuan->jml.' '.$sql_satuan->satuanTerkecil.')' : '') ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <span class="input-group-addon no-border text-bold"><?php echo nbs(10) ?></span>
                                                                <?php } ?>
                                                        <?php }else{ ?>
                                                            <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'value'=>'1', 'style'=>(!isset($_GET['id_produk']) ? 'width: 100px;' : ''))) ?>
                                                            <?php if(isset($_GET['id_produk'])){ ?>
                                                                <span class="input-group-addon no-border text-bold"><?php echo nbs() ?></span>
                                                                <select name="satuan" class="form-control">
                                                                    <?php foreach ($sql_produk_sat as $satuan){ ?>
                                                                       <option value="<?php echo $satuan->satuan ?>"><?php echo ucwords($satuan->satuan).($satuan->satuan != $sql_satuan->satuanTerkecil ? ' ('.$satuan->jml.' '.$sql_satuan->satuanTerkecil.')' : '') ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            <?php } ?>
                                                        <?php } ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Keterangan</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <?php echo form_input(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control pull-right')) ?>
                                            </td>
                                        </tr>
                                        <?php if(isset($_GET['id'])){ ?>
                                        <tr>
                                            <td style="vertical-align: middle; text-align: right;" colspan="3">                                                
                                                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-cart-plus"></i> Simpan</button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                                <?php echo form_close() ?>
                                <?php } ?>
                            </div>
                            <?php if (!empty($sess_beli)) { ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($sess_beli)) { ?>
            <div class="row">                
                    <div class="col-lg-12">
                        <div class="box box-warning" id="data_pelanggan">
                            <div class="box-body">
                                <?php
                                $tglm = explode('-', $sess_beli['tgl_masuk']);
                                $tglj = explode('-', $sess_beli['tgl_keluar']);
                                ?>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Nama Supplier</th>
                                        <th>:</th>
                                        <td><?php echo ucwords($sql_supplier->nama) ?></td>
                                        
                                        <th>Tgl PO</th>
                                        <th>:</th>
                                        <td><?php echo $tglm[1].'/'.$tglm[2].'/'.$tglm[0] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Kode Supplier</th>
                                        <th>:</th>
                                        <td><?php echo ucwords($sql_supplier->kode) ?></td>
                                        
                                        <th>Keterangan</th>
                                        <th>:</th>
                                        <td><?php echo $sql_beli->keterangan ?></td>
                                    </tr>
                                    <tr>
                                        <th>No. Purchase Order</th>
                                        <th>:</th>
                                        <td colspan="4"><?php echo strtoupper($sess_beli['no_nota']) ?></td>
                                    </tr>
                                </table>
                                <hr/>
                                    <table class="table table-striped">
                                        <thead>                                        
                                            <tr>
                                                <th class="text-right"></th>
                                                <th class="text-center">No</th>
                                                <th class="text-left">Kode Barang</th>
                                                <th class="text-left">Nama Barang</th>
                                                <th class="text-right" colspan="2">Jml PO</th>
                                                <th class="text-right">Jml Stok</th>
                                                <th class="text-left">Keterangan</th>
                                                <th class="text-left">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($sql_beli_det)) { ?>
                                                <?php $no = 1; $tot_pemb = 0; ?>
                                                <?php foreach ($sql_beli_det as $pemb_det) { ?>
                                                <?php $tot_pemb = $tot_pemb + $pemb_det->subtotal ?>
                                                <?php $sql_brg  = $this->db->select_sum('jml')->where('id_produk', $pemb_det->id_produk)->get('tbl_m_produk_stok')->row() ?>
                                                    <?php if($_GET['route'] == 'edit' AND $_GET['kd_produk'] == general::enkrip($pemb_det->id_produk)){ ?>
                                                        <tr>
                                                            <td class="text-center">
                                                                <?php echo anchor(base_url('transaksi/cart_beli_upd_hapus.php?id=' . general::enkrip($pemb_det->id) . '&no_nota=' . general::enkrip($pemb_det->id_pembelian)), '<i class="fa fa-remove"></i>', 'class="text-danger" onclick="return confirm(\'Hapus [' . $pemb_det->produk . '] ?\')"') ?>
                                                            </td>
                                                            <td class="text-center"><?php echo $no++; ?></td>
                                                            <td class="text-left"><?php echo $pemb_det->kode ?></td>
                                                            <td class="text-left"><?php echo $pemb_det->produk ?></td>
                                                            <!--<td class="text-right"><?php echo general::format_angka($pemb_det->harga, 0) ?></td>-->
                                                            <!--<td class="text-center"><?php echo (float)$pemb_det->jml.' '.$pemb_det->satuan.' '.$pemb_det->keterangan ?></td>-->
                                                            <!--<td class="text-center"><?php echo general::format_angka($pemb_det->disk1, 2) . (!empty($pemb_det->disk2) ? ' + ' . general::format_angka($pemb_det->disk2, 2) : '') . (!empty($pemb_det->disk3) ? ' + ' . general::format_angka($pemb_det->disk3, 2) : '') ?></td>-->
                                                            <!--<td class="text-right"><?php echo (!empty($pemb->potongan) ? general::format_angka($pemb_det->potongan, 0) : '0') ?></td>-->
                                                            <td class="text-right" colspan="6" style="vertical-align: middle;">
                                                                <?php echo form_open(base_url('transaksi/set_nota_beli_upd_item.php')) ?>
                                                                <?php echo form_hidden('id', $this->input->get('id')) ?>
                                                                <?php echo form_hidden('id_satuan', general::enkrip($pemb_det->id_satuan)) ?>
                                                                <?php echo form_hidden('id_produk', general::enkrip($pemb_det->id_produk)) ?>
                                                                <?php echo form_hidden('aid', $this->input->get('aid')) ?>
                                                                <div class="input-group date">                                                                    
                                                                    <?php echo form_input(array('id'=>'edit_harga', 'name'=>'edit_harga', 'class'=>'form-control', 'value'=>$pemb_det->harga, 'style'=>'width: 85px; text-align:center;')) ?>
                                                                    <span class="input-group-addon no-border text-bold">&nbsp;</span>
                                                                    <?php echo form_input(array('id' => 'edit_jml', 'name' => 'edit_jml', 'class' => 'form-control', 'value'=>(float)$pemb_det->jml, 'style'=>'width: 50px; text-align:center;')) ?>
                                                                    <span class="input-group-addon no-border text-bold">&nbsp;</span>
                                                                    <select name="edit_satuan" class="form-control">
                                                                        <?php foreach ($sql_produk_sat2 as $satuan){ ?>
                                                                            <option value="<?php echo $satuan->satuan ?>" <?php echo ($pemb_det->satuan == $satuan->satuan ? 'selected' : '') ?>><?php echo ucwords($satuan->satuan).($satuan->jml != '1' ? ' ('.$satuan->jml.' '.$sql_satuan->satuanTerkecil.')' : '') ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <span class="input-group-addon no-border text-bold">&nbsp;</span>
                                                                    <?php echo form_input(array('id' => 'edit_disk1', 'name' => 'edit_disk1', 'class' => 'form-control', 'value'=>(float)$pemb_det->disk1, 'style'=>'width: 35px;')) ?>
                                                                    <span class="input-group-addon no-border text-bold">+</span>
                                                                    <?php echo form_input(array('id' => 'edit_disk1', 'name' => 'edit_disk2', 'class' => 'form-control', 'value'=>(float)$pemb_det->disk2, 'style'=>'width: 35px;')) ?>
                                                                    <span class="input-group-addon no-border text-bold">+</span>
                                                                    <?php echo form_input(array('id' => 'edit_disk1', 'name' => 'edit_disk3', 'class' => 'form-control', 'value'=>(float)$pemb_det->disk3, 'style'=>'width: 35px;')) ?>
                                                                    <span class="input-group-addon no-border text-bold">&nbsp;</span>
                                                                    <?php echo form_input(array('id' => 'edit_pot', 'name' => 'edit_pot', 'class' => 'form-control', 'value'=>(float)$pemb_det->potongan, 'style'=>'width: 85px;')) ?>
                                                                    <span class="input-group-addon no-border text-bold">&nbsp;</span>
                                                                    <!--<span class="input-group-addon no-border"><?php echo general::format_angka($penj_det->subtotal, 0) ?></span>-->
                                                                    <!--<span class="input-group-addon no-border text-bold"></span>-->
                                                                    <button type="button" class="btn btn-flat btn-danger" style="vertical-align: text-bottom; margin-bottom: 4px;" onclick="window.location.href='<?php echo base_url('transaksi/trans_beli_edit.php?id='.$this->input->get('id').'#item'.$penj_det->id) ?>'"><i class="fa fa-close"></i></button>
                                                                    <?php echo nbs() ?>
                                                                    <button type="submit" class="btn btn-flat btn-success" style="vertical-align: text-bottom; margin-bottom: 4px;"><i class="fa fa-save"></i></button>
                                                                </div>
                                                                <?php echo form_close() ?>
                                                            </td>
                                                            <!--<td class="text-right"><?php echo anchor(base_url('transaksi/cart_beli_hapus_po.php?id='.$this->input->get('id').'&route=edit&kd_produk='.general::enkrip($penj_det->kode).'&aid='.general::enkrip($penj_det->id).'#item'.$penj_det->id),'<i class="fa fa-edit"></i>', 'onclick="return confirm(\'Lanjutkan ?\')"') ?></td>-->
                                                        </tr>
                                                    <?php }else{ ?>
                                                        <?php if(!empty($this->session->flashdata('transaksi'))){ ?>
                                                            <tr><td colspan="10"><?php echo $this->session->flashdata('transaksi'); ?></td></tr>
                                                        <?php } ?>                                                        
                                                        <tr>
                                                            <td class="text-center">
                                                                <?php echo anchor(base_url('transaksi/cart_beli_upd_hapus.php?id=' . general::enkrip($pemb_det->id) . '&no_nota=' . general::enkrip($pemb_det->id_pembelian).'&route=transaksi/trans_beli_edit_po.php'), '<i class="fa fa-remove"></i>', 'class="text-danger" onclick="return confirm(\'Hapus [' . $pemb_det->produk . '] ?\')"') ?>
                                                            </td>
                                                            <td class="text-center"><?php echo $no++; ?></td>
                                                            <td class="text-left"><?php echo $pemb_det->kode ?></td>
                                                            <td class="text-left"><?php echo $pemb_det->produk ?></td>
                                                            <td class="text-right" colspan="2"><?php echo (float)$pemb_det->jml.' '.$pemb_det->satuan.' '.$pemb_det->keterangan ?></td>
                                                            <td class="text-right"><?php echo $sql_brg->jml ?></td>
                                                            <td class="text-left"><?php echo $pemb_det->keterangan_itm ?></td>
                                                            <td class="text-left"><?php // echo $pemb_det->keterangan_itm ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php }else{ ?>
                                                <tr>
                                                    <td colspan="8" class="text-center text-bold">Data barang kosong</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                            </div>
                            <div class="box-footer">
                                <button type="button" class="btn btn-danger btn-flat pull-left" onclick="window.location.href='<?php echo base_url('transaksi/set_nota_batal.php?term=beli&route=data_po_list.php') ?>'"><i class="fa fa-remove"></i> Batal</button>
                                <?php if (!empty($sql_beli_det)) { ?>
                                    <?php echo form_open(base_url('transaksi/set_nota_beli_proses_po_upd.php')) ?>
                                    <?php echo form_hidden('no_nota', $_GET['id']) ?>
                                    <button type="submit" class="btn btn-primary btn-flat pull-right">Simpan &raquo;</button>
                                    <?php echo form_close() ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
        <?php } ?>
            
            
            <!--Modal form-->
            <div class="modal modal-default fade" id="modal-primary">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Form Supplier</h4>
                        </div>                
                        <form class="tagForm" id="form-pelanggan">
                            <div class="modal-body">
                                <!--Nampilin message box success-->
                                <div id="msg-success" class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="glyphicon glyphicon-ok"></i><?php echo nbs(4) ?>Pelanggan berhasil ditambahkan !!</h5>
                                </div>

                                <div class="form-group <?php echo (!empty($hasError['kode']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Kode</label>
                                    <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control', 'value' => $supplier->kode)) ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Nama</label>
                                    <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control', 'value' => $supplier->nama)) ?>
                                </div>                        
                                <div class="form-group <?php echo (!empty($hasError['npwp']) ? 'has-error' : '') ?>">
                                    <label class="control-label">NPWP</label>
                                    <?php echo form_input(array('id' => 'npwp', 'name' => 'npwp', 'class' => 'form-control', 'value' => $supplier->npwp)) ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['no_hp']) ? 'has-error' : '') ?>">
                                    <label class="control-label">No. HP</label>
                                    <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control', 'value' => $supplier->no_hp)) ?>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['no_tlp']) ? 'has-error' : '') ?>">
                                    <label class="control-label">No. Tlp</label>
                                    <?php echo form_input(array('id' => 'no_tlp', 'name' => 'no_tlp', 'class' => 'form-control', 'value' => $supplier->no_tlp)) ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Alamat</label>
                                    <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control', 'value' => $supplier->alamat)) ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Kota</label>
                                    <?php echo form_input(array('id' => 'kota', 'name' => 'kota', 'class' => 'form-control', 'value' => $supplier->kota)) ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">CP</label>
                                    <?php echo form_input(array('id' => 'cp', 'name' => 'cp', 'class' => 'form-control', 'value' => $supplier->cp)) ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary btn-flat pull-left" data-dismiss="modal">Close</button>
                                <button type="button" id="submit-pelanggan" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
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
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.min.css') ?>">

<!--Datepicker-->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Page script -->
<script>
$(function () {
  $('#msg-success').hide(); 
  $(".select2").select2();
  $('#tgl_masuk').datepicker({
      autoclose: true,
  });

  $('#tgl_tempo').datepicker({
    autoclose: true,
  });

  $('#tgl_bayar').datepicker({
       autoclose: true,
  });
  
  $("#harga, #edit_harga").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("#disk1").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("#disk2").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("#disk3").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("#potongan").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("#jml, #edit_jml").keydown(function (e) {
      // kibot: backspace, delete, tab, escape, enter .
      if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
              // kibot: Ctrl+A, Command+A
                      (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                      // kibot: home, end, left, right, down, up
                              (e.keyCode >= 35 && e.keyCode <= 40)) {
                  // Biarin wae, ga ngapa2in return false
                  return;
              }
              // Cuman nomor
              if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                  e.preventDefault();
              }
          });
  $("#ppn").keydown(function (e) {
      // kibot: backspace, delete, tab, escape, enter .
      if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
              // kibot: Ctrl+A, Command+A
                      (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                      // kibot: home, end, left, right, down, up
                              (e.keyCode >= 35 && e.keyCode <= 40)) {
                  // Biarin wae, ga ngapa2in return false
                  return;
              }
              // Cuman nomor
              if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                  e.preventDefault();
              }
          });
  
  //Autocomplete buat produk
  $('#supplier').autocomplete({
      source: function (request, response) {
          $.ajax({
              url: "<?php echo base_url('transaksi/json_supplier.php') ?>",
              dataType: "json",
              data: {
                  term: request.term
              },
              success: function (data) {
                  response(data);
              }
          });
      },
      minLength: 1,
      select: function (event, ui) {
          var $itemrow = $(this).closest('tr');
          //Populate the input fields from the returned values
          $itemrow.find('#id_supplier').val(ui.item.id);
          $('#id_supplier').val(ui.item.id);
          $('#supplier').val(ui.item.nama);
          
          //Give focus to the next input field to recieve input from user
          $('#supplier').focus();
          return false;
      }
      
  //Format the list menu output of the autocomplete
  }).data("ui-autocomplete")._renderItem = function (ul, item) {
      return $("<li></li>")
              .data("item.autocomplete", item)
              .append("<a>["+ item.kode +"] " + item.nama + "</a>")
              .appendTo(ul);
  };
  
  <?php if (!empty($sess_beli)) { ?>
  //Autocomplete buat Barang
  $('#kode').autocomplete({
      source: function (request, response) {
          $.ajax({
              url: "<?php echo base_url('transaksi/json_barang.php?mod=beli') ?>",
              dataType: "json",
              data: {
                  term: request.term
              },
              success: function (data) {
                  response(data);
              }
          });
      },
      minLength: 1,
      select: function (event, ui) {
          var $itemrow = $(this).closest('tr');
          //Populate the input fields from the returned values
          $itemrow.find('#id_barang').val(ui.item.id);
          $('#id_barang').val(ui.item.id);
          $('#kode').val(ui.item.kode);
          $('#harga').val(ui.item.harga_beli);
          $('#satuan').val(ui.item.satuan);
          
          window.location.href = "<?php echo base_url('transaksi/trans_beli_edit_po.php?id='.$this->input->get('id')) ?>&id_produk="+ui.item.id; 
          //Give focus to the next input field to recieve input from user
          $('#jml').focus();
          return false;
      }
      
  //Format the list menu output of the autocomplete
  }).data("ui-autocomplete")._renderItem = function (ul, item) {
      return $("<li></li>")
              .data("item.autocomplete", item)
              .append("<a>["+ item.kode +"] " + item.produk + " (" + item.jml + ")</a>")
              .appendTo(ul);
  };
  <?php } ?>

       $('#submit-pelanggan').on('click', function (e) {
           var nik = $('#nik').val();
           var nama = $('#nama').val();
           var no_hp = $('#no_hp').val();
           var alamat = $('#alamat').val();
////
           e.preventDefault();
           $.ajax({
               type: "POST",
               url: "<?php echo base_url('master/data_supplier_simpan2.php') ?>",
               data: $("#form-pelanggan").serialize(),
               success: function (data) {
                   $('#nik').val('');
                   $('#nama').val('');
                   $('#no_hp').val('');
                   $('#alamat').val('');
//
//                   $("#bag-pelanggan").load("<?php echo base_url('transaksi/trans_beli.php') ?> #bag-pelanggan", function () {
//                       $(".select2").select2();
//                   });
                   $('#msg-success').show();
                   $("#modal-primary").modal('hide');
                   setTimeout(function () {
                       $('#msg-success').hide('blind', {}, 500)
                   }, 3000);
               },
               error: function () {
                   alert('Error');
               }
           });
           return false;
       });
   });
</script>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            