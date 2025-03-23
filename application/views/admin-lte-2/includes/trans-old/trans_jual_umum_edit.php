<?php $hasError = $this->session->flashdata('form_error'); ?>
<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Transaksi
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('dashboard.php') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
                <li class="active">Form Penjualan</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-shopping-cart"></i> Form Penjualan</h3>
                        </div>
                        <div class="box-body">
                            <?php echo $this->session->flashdata('transaksi') ?>
                            <div class="row">
                                <?php echo form_open_multipart(base_url('transaksi/'.(!empty($_GET['id']) ? 'set_nota_jual_update' : 'set_nota_jual').'.php'), 'autocomplete="off"') ?>
                                <input type="hidden" id="id_customer" name="id_customer">
                                <input type="hidden" id="id_sales" name="id_sales">
                                <input type="hidden" id="no_nota" name="no_nota" value="<?php echo $no_nota ?>">
                                <div class="col-md-6">                                    
                                    <table class="table table-striped">
                                        <tr>
                                            <th style="vertical-align: middle;">Nama Customer</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">                                   
                                                <div id="bag-pelanggan" class="<?php echo (!empty($hasError['pelanggan']) ? 'has-error' : '') ?>">
                                                    <?php echo form_input(array('id' => 'customer', 'name' => 'customer', 'class' => 'form-control text-middle', 'style' => 'vertical-align: middle;', 'value'=>$sql_customer->nama, 'readonly'=>'TRUE')) ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Tanggal Transaksi</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <?php echo form_input(array('id' => 'tgl_masuk', 'name' => 'tgl_masuk', 'class' => 'form-control pull-right', 'value' => date('m/d/Y'), 'disabled'=>'TRUE')) ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <!--<tr>-->
                                            <!--<th style="vertical-align: middle;">Tanggal Transaksi</th>-->
                                            <!--<th style="vertical-align: middle;">:</th>-->
                                            <!--<td style="vertical-align: middle;">-->
                                                <!--<div class="input-group date">-->
                                                    <!--<div class="input-group-addon">-->
                                                        <!--<i class="fa fa-calendar"></i>-->
                                                    <!--</div>-->
                                                    <?php echo form_hidden(array('id' => 'tgl_tempo', 'name' => 'tgl_tempo', 'class' => 'form-control pull-right', 'value' => date('m/d/Y'), 'disabled'=>'TRUE')) ?>
                                                <!--</div>-->
                                            <!--</td>-->
                                        <!--</tr>-->
                                        <!--
                                        <tr>
                                            <th style="vertical-align: middle;">Kode Faktur Pajak</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <?php echo form_input(array('id' => 'kode_fp', 'name' => 'kode_fp', 'class' => 'form-control pull-right')) ?>
                                            </td>
                                        </tr>
                                        -->
                                        <tr>
                                            <th style="vertical-align: middle;">Kasir</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <?php echo form_input(array('id' => 'sales', 'name' => 'sales', 'class' => 'form-control pull-right', 'value'=>$sql_sales->nama, 'readonly'=>'TRUE')) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Lokasi</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <?php echo form_input(array('id' => 'cabang', 'name' => 'cabang', 'class' => 'form-control pull-right', 'value'=>'PUSAT', 'readonly'=>'TRUE')) ?>
                                            </td>
                                        </tr>
                                        <!--
                                        <tr>
                                            <td style="vertical-align: middle; text-align: right;" colspan="3">                                                
                                                <button type="reset" onclick="window.location.href='<?php echo site_url('page=transaksi&act=set_nota_batal&term=data_penj_list.php') ?>'" class="btn btn-warning btn-flat">Batal</button>
                                                <button type="submit" class="btn btn-primary btn-flat">Set Order</button>
                                            </td>
                                        </tr>
                                        -->
                                    </table>
                                </div>
                                <?php echo form_close() ?>
                                <?php if (!empty($sess_jual)) { ?>
                                <?php echo form_open_multipart(base_url('transaksi/cart_jual_simpan_umum.php')) ?>
                                <input type="hidden" id="id_barang" name="id_barang" value="<?php echo $this->input->get('id_produk') ?>">
                                <input type="hidden" id="no_nota" name="no_nota" value="<?php echo $_GET['id'] ?>">

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
                                            <th style="vertical-align: middle;">Jml</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div id="bag-pelanggan" class="<?php echo (!empty($hasError['pelanggan']) ? 'has-error' : '') ?>">
                                                    <div class="input-group date">
                                                        <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'value'=>'1', 'style'=>(isset($_GET['id_produk']) ? 'width: 75px;' : ''))) ?>
                                                        <?php if(isset($_GET['id_produk'])){ ?>
                                                            <span class="input-group-addon no-border text-bold"><?php echo nbs() ?></span>
                                                            <?php // echo form_input(array('id'=>'satuan', 'name'=>'satuan', 'class'=>'form-control', 'readonly'=>'TRUE', 'value'=>$sql_satuan->satuanTerkecil)) ?>
                                                            <select id="satuan" name="satuan" class="form-control">
                                                                <?php foreach ($sql_produk_sat as $satuan){ ?>
                                                                    <option value="<?php echo $satuan->satuan ?>"><?php echo ucwords($satuan->satuan).($satuan->satuan != $sql_satuan->satuanTerkecil ? ' ('.$satuan->jml.' '.$sql_satuan->satuanTerkecil.')' : '') ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <span class="input-group-addon no-border text-bold"><?php echo nbs() ?></span>
                                                            <input type="checkbox" id="harga_ds" name="harga_ds" style="bottom: 190px;" value="1"> Harga DS
                                                            <!--<span class="input-group-addon no-border text-bold"><?php echo nbs() ?></span>-->
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Harga</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        Rp
                                                    </div>
                                                    <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control pull-right', 'value'=>$sql_produk->harga_jual, 'readonly'=>'TRUE')) ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Diskon</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div class="input-group">
                                                    <?php echo form_input(array('id' => 'diskon', 'name' => 'disk1', 'class' => 'form-control')) ?>
                                                    <span class="input-group-addon no-border text-bold">+</span>
                                                    <?php echo form_input(array('id' => 'diskon', 'name' => 'disk2', 'class' => 'form-control')) ?>
                                                    <span class="input-group-addon no-border text-bold">+</span>
                                                    <?php echo form_input(array('id' => 'diskon', 'name' => 'disk3', 'class' => 'form-control')) ?>
                                                </div>
                                            </td>
                                        </tr>                                                                                
                                        <!--
                                        <tr>
                                            <th style="vertical-align: middle;">Potongan</th>
                                            <th style="vertical-align: middle;"></th>
                                            <td style="vertical-align: middle;">
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        Rp
                                                    </div>
                                                    <?php echo form_input(array('id' => 'potongan', 'name' => 'potongan', 'class' => 'form-control pull-right')) ?>
                                                </div>
                                            </td>
                                        </tr>
                                        -->
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
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($sess_jual)) { ?>
            <div class="row">                
                    <div class="col-lg-12">
                        <div class="box box-warning" id="data_pelanggan">
                            <div class="box-body">
                                <?php
                                $tglm = explode('-', $sess_jual['tgl_masuk']);
                                $tglj = explode('-', $sess_jual['tgl_keluar']);
                                
                                $sql_cust = $this->db->where('id', $sess_jual['id_pelanggan'])->get('tbl_m_pelanggan')->row();
                                ?>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Nama Customer</th>
                                        <th>:</th>
                                        <td><?php echo ucwords($sql_cust->nama) ?></td>
                                        
                                        <th>Tgl Transaksi</th>
                                        <th>:</th>
                                        <td><?php echo $tglm[1].'/'.$tglm[2].'/'.$tglm[0] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Kasir</th>
                                        <th>:</th>
                                        <td><?php echo ucwords($sql_sales->nama) ?></td>
                                        
                                        <!--<th>Tgl Jatuh Tempo</th>-->
                                        <!--<th>:</th>-->
                                        <!--<td><?php echo $tglj[1].'/'.$tglj[2].'/'.$tglj[0] ?></td>-->
                                    </tr>
                                    <!--
                                    <tr>
                                        <th>Kode Faktur Pajak</th>
                                        <th>:</th>
                                        <td colspan="4"><?php echo strtoupper($sess_jual['kode_fp']) ?></td>
                                    </tr>
                                    -->
                                </table>
                                <hr/>
                                    <table class="table table-striped">
                                        <thead>                                        
                                            <tr>
                                                <th class="text-right"></th>
                                                <th class="text-center">No</th>
                                                <th class="text-left">Kode Barang</th>
                                                <th class="text-left">Nama Barang</th>
                                                <th class="text-right">Harga</th>
                                                <th class="text-center" colspan="3">Jml</th>
                                                <th class="text-right">Diskon</th>
                                                <th class="text-center">Potongan</th>
                                                <th class="text-right">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($sql_penj_det)) { ?>
                                                <?php $no = 1; $jml_tot = 0; $jml_pot = 0; $jml_subtotal = 0; $jml_tot_diskon = 0; ?>
                                                <?php foreach ($sql_penj_det as $penj_det) { ?>
                                                <?php 
                                                     $produk         = $this->db->where('id', $penj_det->id_barang)->get('tbl_m_produk')->row();
                                                     
                                                     $subtotal       = $penj_det->subtotal; //$penj_det['qty'] * $penj_det['options']['harga'];
                                                     $jml_tot        = $jml_tot + $penj_det->subtotal; //($penj_det['price'] * $penj_det['qty']);
                                                     $jml_pot        = $jml_pot + ($penj_det->potongan + $penj_det->diskon);
//                                                     $jml_tot_diskon = $jml_tot_diskon + ($penj_det['options']['diskon'] * $penj_det['qty']);
                                                     $jml_subtotal   = $jml_subtotal + $penj_det->subtotal;
                                                ?>
                                                    <tr>
                                                        <td class="text-right" style="vertical-align: middle;">
                                                            <?php echo anchor(base_url('transaksi/cart_jual_hapus_upd.php?route='.$this->uri->segment(2).'&id=' . general::enkrip($penj_det->id) . '&no_nota=' . general::enkrip($penj_det->no_nota)), '<i class="fa fa-remove"></i>', 'class="text-danger" onclick="return confirm(\'Hapus [' . $penj_det->produk . '] ?\')"') ?>
                                                        </td>
                                                        <td class="text-center" style="vertical-align: middle;"><?php echo $no++; ?></td>
                                                        <td class="text-left" style="width: 150px; vertical-align: middle;"><?php echo $penj_det->kode ?></td>
                                                        <td class="text-left" style="width: 450px; vertical-align: middle;"><?php echo $penj_det->produk ?></td>
                                                        <td class="text-right" style="vertical-align: middle;"><?php echo general::format_angka($penj_det->harga) ?></td>
                                                        <td class="text-right" style="width: 50px;">
                                                            <?php echo form_open(base_url('transaksi/cart_jual_update_qty.php')) ?>
                                                            <?php echo form_hidden('no_nota', $_GET['id']) ?>
                                                            <?php echo form_hidden('id_cart', $penj_det->id) ?>
                                                            <?php // echo form_hidden('satuan', $penj_det['options']['satuan']) ?>
                                                            <?php echo form_hidden('potongan2', $penj_det->potongan) ?>
                                                            <?php echo form_input(array('id' => 'qty2', 'name'=>'qty2', 'class'=>'form-control text-center', 'style'=>'width: 50px;', 'value'=>$penj_det->jml)) ?>
                                                            <?php echo form_close() ?>
                                                        </td>
                                                        <td class="text-left" style="width: 150px; vertical-align: middle;">
                                                            <?php // $prod_brg = $this->db->where('kode', $penj_det['options']['kode'])->get('tbl_m_produk')->row(); ?>
                                                            <?php // $prod_sat = $this->db->where('id_produk', $prod_brg->id)->get('tbl_m_produk_satuan')->result(); ?>
                                                            <!--<select id="satuan" name="satuan" class="form-control">-->
                                                                <?php // foreach ($prod_sat as $satuan){ ?>
                                                                    <!--<option value="<?php echo $satuan->satuan ?>"><?php echo ucwords($satuan->satuan).($satuan->satuan != $sql_satuan->satuanTerkecil ? ' ('.$satuan->jml.' '.$sql_satuan->satuanTerkecil.')' : '') ?></option>-->
                                                                <?php // } ?>
                                                            <!--</select>-->
                                                            <?php echo $penj_det->satuan ?>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <!--<input type="checkbox" id="harga_ds" name="harga_ds" style="bottom: 190px;" value="1"> Harga DS-->
                                                        </td>
                                                        <td class="text-center" style="vertical-align: middle;"><?php echo general::format_angka($penj_det->disk1, 0) . (!empty($penj_det->disk2) ? ' + ' . general::format_angka($penj_det->disk2, 0) : '') . (!empty($penj_det->disk3) ? ' + ' . general::format_angka($penj_det->disk3, 0) : '') ?></td>
                                                        <td class="text-right" style="vertical-align: middle;">
                                                            <?php echo form_open(base_url('transaksi/cart_jual_update_qty.php')) ?>
                                                            <?php echo form_hidden('no_nota', $_GET['id']) ?>
                                                            <?php echo form_hidden('id_cart', $penj_det->id) ?>
                                                            <?php echo form_hidden('qty2', $penj_det->jml) ?>
                                                            <?php echo form_input(array('id' => '', 'name'=>'potongan2', 'class'=>'form-control text-right', 'style'=>'width: 100px;', 'value'=>$penj_det->potongan)) ?>
                                                            <?php // echo general::format_angka($penj_det['options']['potongan'], 0) ?>
                                                            <?php echo form_close() ?>
                                                        </td>
                                                        <td class="text-right" style="vertical-align: middle;"><?php echo general::format_angka($penj_det->subtotal, 0) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                
                                                <?php echo form_open(base_url('transaksi/set_nota_proses_umum_upd.php'), 'id="frm_totalx"') ?>
                                                <?php echo form_hidden('id', $_GET['id']) ?>
                                                <tr>
                                                    <th colspan="3" class="text-right" style="vertical-align: middle;">
                                                        <select id="metode_bayar" name="metode_bayar" class="form-control" <?php // echo($sql_penj->status_bayar != '0' ? 'disabled="TRUE"' : '') ?>>
                                                            <option value="1">[Metode Pembayaran]</option>                                            
                                                            <option value="1">Tunai</option>                                            
                                                            <?php foreach ($sql_platform as $platform) { ?>
                                                                <?php if($platform->id > 2) { ?>
                                                                    <option value="<?php echo $platform->id ?>"><?php echo $platform->platform.(!empty($platform->persen) ? ' + '.(int)$platform->persen.' %' : '').(!empty($platform->keterangan) ? ' ['.$platform->keterangan.']' : '') ?></option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                    </th>
                                                    <th colspan="7" class="text-right" style="vertical-align: middle;">Total</th>
                                                    <th  class="text-right" style="width: 200px;">
                                                        <!--<input type="hidden" id="jml_total" name="jml_total2" value="<?php echo $jml_tot ?>">-->
                                                        <div class="input-group date">
                                                            <div class="input-group-addon">
                                                                Rp.
                                                            </div>
                                                            <?php echo form_input(array('id' => 'jml_total', 'name' => 'jml_total', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => general::format_angka($jml_tot))) ?>
                                                        </div>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-right" style="vertical-align: middle;">
                                                        <?php echo form_input(array('id' => 'bank','name' => 'bank', 'class' => 'form-control pull-right text-right', 'placeholder' => 'Nama Bank ...')) ?>
                                                    </th>
                                                    <th colspan="7" class="text-right" style="vertical-align: middle;">Diskon</th>
                                                    <th  class="text-right" style="width: 200px;">
                                                        <div class="input-group date">
                                                            <div class="input-group-addon">
                                                                Rp.
                                                            </div>
                                                            <input type="hidden" id="jml_diskon1" name="jml_diskon1" value="<?php echo $jml_pot ?>">
                                                            <?php echo form_input(array('id' => 'jml_diskon', 'name' => 'jml_diskon', 'class' => 'form-control pull-right text-right', 'value'=>'0')) ?>
                                                        </div>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-right" style="vertical-align: middle;">
                                                        <?php echo form_input(array('id' =>'no_kartu', 'name' => 'no_kartu', 'class' => 'form-control pull-right text-right', 'placeholder' => 'Bukti / No. Ref / No. Kartu ...')) ?>
                                                    </th>
                                                    <th colspan="7" class="text-right" style="vertical-align: middle;">Biaya Kirim</th>
                                                    <th  class="text-right" style="width: 200px;">
                                                        <div class="input-group date">
                                                            <div class="input-group-addon">
                                                                Rp.
                                                            </div>
                                                            <?php echo form_input(array('id' => 'jml_ongkir', 'name' => 'jml_ongkir', 'class' => 'form-control pull-right text-right', 'value'=>'0')) ?>
                                                        </div>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-right" style="vertical-align: middle;">
                                                        
                                                    </th>
                                                    <th colspan="7" class="text-right" style="vertical-align: middle;">Jml Biaya / Charge</th>
                                                    <th  class="text-right" style="width: 200px;">
                                                        <div class="input-group date <?php echo (!empty($hasError['jml_biaya']) ? 'has-error' : '') ?>">
                                                            <div class="input-group-addon <?php echo (!empty($hasError['jml_biaya']) ? 'has-error' : '') ?>">
                                                                Rp.
                                                            </div>
                                                            <?php echo form_input(array('id' => 'jml_biaya', 'name' => 'jml_biaya', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value'=>'0')) ?>
                                                        </div>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-right" style="vertical-align: middle;">
                                                        
                                                    </th>
                                                    <th colspan="7" class="text-right" style="vertical-align: middle;">Subtotal</th>
                                                    <th  class="text-right" style="width: 200px;">
                                                        <div class="input-group date">
                                                            <div class="input-group-addon">
                                                                Rp.
                                                            </div>
                                                            <?php echo form_input(array('id' => 'jml_subtotal', 'name' => 'jml_subtotal', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => general::format_angka($jml_subtotal))) ?>
                                                        </div>
                                                    </th>
                                                </tr>
                                                <?php if($sess_jual['status_ppn'] == 1){ ?>
                                                <tr>
                                                    <th colspan="7" class="text-right" style="vertical-align: middle;"></th>
                                                    <th colspan="3" class="text-right" style="vertical-align: middle;">DPP</th>
                                                    <th  class="text-right" style="width: 200px;">
                                                        <div class="input-group date">
                                                            <div class="input-group-addon">
                                                                Rp.
                                                            </div>
                                                            <?php $jml_dpp     = $jml_subtotal / 1.1 ?>
                                                            <?php $jml_ppn     = $jml_subtotal - $jml_dpp ?>
                                                            <?php $jml_gtotal  = $jml_subtotal ?>
                                                            <?php echo form_input(array('id' => 'jml_ppn', 'name' => 'jml_ppn', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => floor($jml_dpp))) ?>
                                                        </div>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="8" class="text-right" style="vertical-align: middle;"></th>
                                                    <th class="text-right" style="vertical-align: middle;">PPN <?php echo (!empty($ppn) ? $ppn.'%' : '') ?></th>
                                                    <th  class="text-right" style="width: 200px;">
                                                        <div class="input-group date">
                                                            <div class="input-group-addon">
                                                                Rp.
                                                            </div>
                                                            <?php $jml_ppn     = $jml_subtotal / 1.1 ?>
                                                            <?php $jml_ppn_tot = $jml_subtotal - $jml_ppn ?>
                                                            <?php $jml_gtotal  = $jml_subtotal ?>
                                                            <?php echo form_input(array('id' => 'jml_ppn', 'name' => 'jml_ppn', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => ceil($jml_ppn_tot))) ?>
                                                        </div>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="8" class="text-right" style="vertical-align: middle;"></th>
                                                    <th class="text-right" style="vertical-align: middle;">Grand Total</th>
                                                    <th  class="text-right" style="width: 200px;">
                                                        <div class="input-group date">
                                                            <div class="input-group-addon">
                                                                Rp.
                                                            </div>
                                                            <?php echo form_input(array('id' => 'jml_gtotal', 'name' => 'jml_gtotal', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE', 'value' => ceil($jml_gtotal))) ?>
                                                        </div>
                                                    </th>
                                                </tr>
                                                <?php } ?>
                                                <tr id="pembayaran">
                                                    <th colspan="10" class="text-right" style="vertical-align: middle;">Jml Bayar</th>
                                                    <th  class="text-right" style="width: 200px;">
                                                        <div class="input-group date <?php echo (!empty($hasError['jml_bayar']) ? 'has-error' : '') ?>">
                                                            <div class="input-group-addon <?php echo (!empty($hasError['jml_bayar']) ? 'has-error' : '') ?>">
                                                                Rp.
                                                            </div>
                                                            <?php echo form_input(array('id' => 'jml_bayar', 'name' => 'jml_bayar', 'class' => 'form-control pull-right text-right', 'data-format' => '0.0[,]00', 'value'=>'0')) ?>
                                                        </div>
                                                    </th>
                                                </tr>
                                                <tr id="pembayaran">
                                                    <th colspan="10" class="text-right" style="vertical-align: middle;">Kembalian</th>
                                                    <th  class="text-right" style="width: 200px;">
                                                        <div class="input-group date <?php echo (!empty($hasError['jml_bayar']) ? 'has-error' : '') ?>">
                                                            <div class="input-group-addon <?php echo (!empty($hasError['jml_bayar']) ? 'has-error' : '') ?>">
                                                                Rp.
                                                            </div>
                                                            <?php echo form_input(array('id' => 'jml_kembali', 'name' => 'jml_kembali', 'class' => 'form-control pull-right text-right', 'readonly' => 'TRUE')) ?>
                                                        </div>
                                                    </th>
                                                </tr>
                                                <tr id="pembayaran">
                                                    <th colspan="9" class="text-right" style="vertical-align: middle;"></th>
                                                    <th class="text-right" style="vertical-align: middle;"></th>
                                                    <th  class="text-right" style="width: 200px;">
                                                        <?php echo form_checkbox(array('id' => 'cetak', 'name' => 'cetak', 'value' => '1', 'checked'=>'TRUE')) ?> Cetak ke printer
                                                    </th>
                                                </tr>
                                            <?php }else{ ?>
                                                <tr>
                                                    <td colspan="9" class="text-center text-bold">Data barang kosong</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <!--<pre>-->
                                    <?php // print_r($this->session->all_userdata()) ?>
                                <!--</pre>-->
                            </div>
                            <div class="box-footer">
                                <button type="button" class="btn btn-danger btn-flat pull-left" onclick="window.location.href='<?php echo base_url('transaksi/set_nota_batal.php?term=jual_umum&route=data_penj_list.php') ?>'"><i class="fa fa-remove"></i> Batal</button>
                                <?php if (!empty($sql_penj_det)) { ?>
                                    <?php // echo form_open(base_url('transaksi/set_nota_proses_umum.php')) ?>
                                    <?php echo form_hidden('no_nota', $_GET['id']) ?>
                                    <?php // echo form_hidden('jml_total', $tot_penj) ?>
                                    <?php // echo form_hidden('jml_ppn', $sql_penj->jml_ppn) ?>
                                    <?php // echo form_hidden('act', 'trans_jual_umum') ?>
                                    <?php // echo form_hidden('route', 'trans_bayar_jual') ?>
                                    <button type="submit" class="btn btn-primary btn-flat pull-right">Simpan &raquo;</button>
                                    <?php // echo form_close() ?>
                                <?php } ?>
                            </div>
                            <?php echo form_close() ?>
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
                            <h4 class="modal-title">Form Pelanggan</h4>
                        </div>                
                        <form class="tagForm" id="form-pelanggan">
                            <div class="modal-body">
                                <!--Nampilin message box success-->
                                <div id="msg-success" class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="glyphicon glyphicon-ok"></i><?php echo nbs(4) ?>Pelanggan berhasil ditambahkan !!</h5>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                            <label class="control-label">NIK</label>
                                            <?php echo form_input(array('id' => 'nik', 'name' => 'nik', 'class' => 'form-control')) ?>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Nama</label>
                                            <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control')) ?>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['no_hp']) ? 'has-error' : '') ?>">
                                            <label class="control-label">No. HP</label>
                                            <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control')) ?>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['nama_toko']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Lokasi / Tempat Usaha</label>
                                            <?php echo form_input(array('id' => 'nama_toko', 'name' => 'nama_toko', 'class' => 'form-control')) ?>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Alamat</label>
                                            <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control')) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-8">                                        
                                        <table class="table table-striped">
                                            <tr>
                                                <th colspan="2"></th>
                                                <th class="text-center">Diskon 1</th>
                                                <th class="text-center">Diskon 2</th>
                                                <th class="text-center">Diskon 3</th>
                                            </tr>
                                            <?php foreach ($kategori as $kat) { ?>
                                                <?php $diskon = $this->db->where('id_pelanggan', $customer->id)->where('id_kategori', $kat->id)->get('tbl_m_pelanggan_diskon')->row() ?>
                                                <tr>
                                                    <th style="vertical-align: middle;"><?php echo $kat->keterangan ?></th>
                                                    <th style="vertical-align: middle;">:</th>
                                                    <td style="width: 150px;"><?php echo form_input(array('id' => 'diskon', 'name' => 'disk1[' . $kat->id . ']', 'class' => 'form-control', 'value' => (int) $diskon->disk1)) ?></td>
                                                    <td style="width: 150px;"><?php echo form_input(array('id' => 'diskon', 'name' => 'disk2[' . $kat->id . ']', 'class' => 'form-control', 'value' => (int) $diskon->disk2)) ?></td>
                                                    <td style="width: 150px;"><?php echo form_input(array('id' => 'diskon', 'name' => 'disk3[' . $kat->id . ']', 'class' => 'form-control', 'value' => (int) $diskon->disk3)) ?></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
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

<!--Calculator-->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/calx/jquery-calx-1.1.8.js') ?>"></script>

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.min.css') ?>">

<!--Datepicker-->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Page script -->
<script>
$(function () {
  $('#kode').focus();
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
  
  $("#jml_diskon").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("#jml_ongkir").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("#jml_ppn").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("#jml_gtotal").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("#jml_bayar").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("#potongan").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  
  $("#disk1").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("#disk2").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("#disk3").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("#harga").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  $("input[name=potongan2]").autoNumeric({aSep: '.', aDec: ',', aPad: false});
  
  $("#jml_ongkir").keyup(function(){
        var jml_total   = $('#jml_total').val().replace(/[.]/g,"");
        var jml_diskon  = $('#jml_diskon').val().replace(/[.]/g,"");
        var jml_ongkir  = $('#jml_ongkir').val().replace(/[.]/g,"");
        var jml_biaya  = $('#jml_biaya').val().replace(/[.]/g,"");
        
        var jml_subtotal = ((parseFloat(Math.round(jml_total)) - parseFloat(jml_diskon)) + parseFloat(jml_biaya) + parseFloat(jml_ongkir));
        
        $('#jml_subtotal').val(jml_subtotal).autoNumeric({aSep: '.', aDec: ',', aPad: false});
  });
  
  $("#jml_bayar").keyup(function(){
      <?php if($sess_jual['status_ppn'] == '1'){ ?>
        var jml_gtotal  = $('#jml_gtotal').val().replace(/[.]/g,"");
        var jml_bayar   = $('#jml_bayar').val().replace(/[.]/g,"");
        var jml_kembali = parseFloat(Math.round(jml_bayar)) - parseFloat(jml_gtotal);
      <?php }else{ ?>
        var jml_gtotal  = $('#jml_subtotal').val().replace(/[.]/g,"");
        var jml_bayar   = $('#jml_bayar').val().replace(/[.]/g,"");
        var jml_kembali = parseFloat(Math.round(jml_bayar)) - parseFloat(jml_gtotal);
      <?php } ?>
          
      $('#jml_kembali').val(jml_kembali).autoNumeric({aSep: '.', aDec: ',', aPad: false});
  });
  
  $("#jml_diskon").keyup(function(){
      var jml_total   = $('#jml_total').val().replace(/[.]/g,"");
      var jml_diskon  = $('#jml_diskon').val().replace(/[.]/g,"");
      var jml_ongkir  = $('#jml_ongkir').val().replace(/[.]/g,"");
      var jml_biaya   = $('#jml_biaya').val().replace(/[.]/g,"");
      var jml_gtotal  = (parseFloat(jml_total) - parseFloat(jml_diskon)) + parseFloat(jml_ongkir) + parseFloat(jml_biaya);
      var jml_bayar   = $('#jml_bayar').val().replace(/[.]/g,"");
      var jml_kembali = parseFloat(Math.round(jml_bayar)) - parseFloat(jml_gtotal);
      
      $('#jml_subtotal').val(jml_gtotal).autoNumeric({aSep: '.', aDec: ',', aPad: false});
      
      if(jml_kembali > 0){
        $('#jml_kembali').val(jml_kembali).autoNumeric({aSep: '.', aDec: ',', aPad: false});
      }
  });
  
  $("#jml").keydown(function (e) {
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
          
    $("input[id=diskon]").keydown(function (e) {
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
  $('#customer').autocomplete({
      source: function (request, response) {
          $.ajax({
              url: "<?php echo base_url('transaksi/json_customer.php') ?>",
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
          $itemrow.find('#id_customer').val(ui.item.id);
          $('#id_customer').val(ui.item.id);
          $('#customer').val(ui.item.nama);
          
          //Give focus to the next input field to recieve input from user
          $('#customer').focus();
          return false;
      }
      
  //Format the list menu output of the autocomplete
  }).data("ui-autocomplete")._renderItem = function (ul, item) {
      return $("<li></li>")
              .data("item.autocomplete", item)
              .append("<a>" + item.nama + " - " + item.nama_toko + "</a>")
              .appendTo(ul);
  };
  
  //Autocomplete buat sales
  $('#sales').autocomplete({
      source: function (request, response) {
          $.ajax({
              url: "<?php echo base_url('transaksi/json_sales.php') ?>",
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
          $itemrow.find('#id_sales').val(ui.item.id);
          $('#id_sales').val(ui.item.id);
          $('#sales').val(ui.item.nama);
          
          //Give focus to the next input field to recieve input from user
          $('#sales').focus();
          return false;
      }
      
  //Format the list menu output of the autocomplete
  }).data("ui-autocomplete")._renderItem = function (ul, item) {
      return $("<li></li>")
              .data("item.autocomplete", item)
              .append("<a>" + item.nama + "</a>")
              .appendTo(ul);
  };
  
<?php if (!empty($sess_jual)) { ?>
      //Autocomplete buat Barang
      $('#kode').autocomplete({
          source: function (request, response) {
              $.ajax({
                  url: "<?php echo base_url('transaksi/json_barang.php') ?>",
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
              $('#harga').val(ui.item.harga);
              $('#jml').val('1');
              window.location.href = "<?php echo base_url('transaksi/trans_jual_umum.php?id='.$this->input->get('id')) ?>&id_produk="+ui.item.id+"&harga="+ui.item.harga; 
              
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

           e.preventDefault();
           $.ajax({
               type: "POST",
               url: "<?php echo base_url('master/data_customer_simpan2.php') ?>",
               data: $("#form-pelanggan").serialize(),
               success: function (data) {
                   $('#nik').val('');
                   $('#nama').val('');
                   $('#no_hp').val('');
                   $('#alamat').val('');
                   
                   window.location.href='<?php echo base_url('master/data_customer_tambah.php?id=') ?>' + data.trim() + '&route=transaksi/trans_jual.php';
               },
               error: function () {
                   alert('Error');
               }
           });
           return false;
       });
       

       $('#bank').hide();
       $('#no_kartu').hide();
       
         $("#metode_bayar").on('change',function () {
             var met_byr = $('#metode_bayar option:selected').val();
			 
             if($('#metode_bayar option:selected').val() > 2){
                $('#bank').show();
                $('#no_kartu').show();
             }else{
                $('#bank').hide()
                $('#no_kartu').hide()
             }
			 
			 
           $.ajax({
               type: "GET",
               url: "<?php echo site_url('page=transaksi&act=json_platform') ?>&id=" + met_byr + "",
               dataType: "json",
               success: function (data) {
                    var jml_gtotal   = $('#jml_total').val().replace(/[.]/g,"");
                    var jml_diskon1  = $('#jml_diskon1').val().replace(/[.]/g,"");
                    var jml_diskon   = $('#jml_diskon').val().replace(/[.]/g,"");
                    var jml_ongkir   = $('#jml_ongkir').val().replace(/[.]/g,"");
                    var jml_biaya    = $('#jml_biaya').val().replace(/[.]/g,"");
                    var jml_subtotal = $('#jml_subtotal').val().replace(/[.]/g,"");
                    var biaya        = (data.persen / 100) * (jml_gtotal - jml_diskon);
                    var jml_bayar    = ((parseFloat(jml_gtotal) - parseFloat(jml_diskon)) + parseFloat(biaya) + parseFloat(jml_ongkir));

//                    $('#jml_subtotal').val(jml_bayar).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                    $('#jml_biaya').val(Math.round(biaya)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                    $('#jml_bayar').val(Math.round(jml_bayar)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                    $('#jml_subtotal').val(Math.round(jml_bayar)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                    $('#jml_kembali').val('0').autoNumeric({aSep: '.', aDec: ',', aPad: false});
               }
           });
         });
         
         /* Data Satuan */         
         $("#satuan").on('change',function () {
             var sat_jual = $('#satuan option:selected').val();
           $.ajax({
               type: "GET",
               url: "<?php echo site_url('page=transaksi&act=json_barang_sat&id='.general::dekrip($this->input->get('id_produk'))) ?>&satuan=" + sat_jual + "",
               dataType: "json",
               success: function (data) {
                   $('#harga').val(data.harga);
               }
           });
         });
         
         /* HARGA DS */         
         $("#harga_ds").on('change',function () {
            if(this.checked) {
                var jml_brg   = $('#jml').val().replace(/[.]/g,"");
                var harga_j   = $('#harga').val().replace(/[.]/g,"");
                var jml_harga = (jml_brg / 12) * harga_j;
                
                $('#harga').val(Math.round(jml_harga)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
            }
         });
   });
</script>