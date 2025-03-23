<div class="content-wrapper sidebar-mini">    
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Medical
                <small>Checkup</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('dashboard.php') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
                <li><a href="#">Form Medical Checkup</a></li>
                <?php echo $sql_penj->breadcrump; ?>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-shopping-cart"></i> Form Medical Checkup</h3>
                        </div>
                        <div class="box-body table-responsive">
                            <?php echo $this->session->flashdata('transaksi') ?>
                            <?php $hasError = $this->session->flashdata('form_error'); ?>

                            <div class="row">                                
                                <?php echo form_open_multipart(base_url('transaksi/set_nota_jual.php'), 'autocomplete="off"') ?>
                                <input type="hidden" id="id_customer" name="id_customer">
                                <input type="hidden" id="id_sales" name="id_sales" <?php echo (akses::hakKasir() == TRUE ? 'value="' . $kasir_id . '"' : '') ?>>
                                <input type="hidden" id="no_nota" name="no_nota" value="<?php echo $no_nota ?>">
                                <input type="hidden" id="id" name="id" value="<?php echo $this->input->get('id') ?>">

                                <div class="col-md-6">                                    
                                    <table class="table table-striped">
                                        <tr>
                                            <th style="vertical-align: middle;">Nama Pasien</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">                                   
                                                <div id="bag-pelanggan" class="<?php echo (!empty($hasError['pelanggan']) ? 'has-error' : '') ?>">
                                                    <!--<div class="form-group text-middle">-->
                                                    <div class="input-group date">
                                                        <?php echo form_input(array('id' => 'customer', 'name' => 'customer', 'class' => 'form-control text-middle', 'style' => 'vertical-align: middle;', 'placeholder' => 'Cari berdasarkan nama lengkap, telepon atau alamat ...')) ?>
                                                        <div class="input-group-addon text-middle" style="<?php echo (!empty($hasError['pelanggan']) ? 'border-color: #a94442;' : '') ?>">                                                        
                                                            <a href="#" data-toggle="modal" data-target="#modal-primary" style="vertical-align: middle;">
                                                                <i class="fa fa-plus" style="<?php echo (!empty($hasError['pelanggan']) ? 'color: #a94442;' : '') ?>"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <!--</div>-->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Tgl Masuk</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <?php echo form_input(array('id' => 'tgl_masuk', 'name' => 'tgl_masuk', 'class' => 'form-control pull-right', 'value' => date('m/d/Y'))) ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Tipe</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <!--<div class="input-group date">-->
                                                <select name="kategori" class="form-control">
                                                    <option value="">- Tipe -</option>
                                                    <option value="2">Rawat Jalan</option>
                                                    <option value="3">Rawat Inap</option>
                                                </select>
                                                <!--</div>-->
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Klinik</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <!--<div class="input-group date">-->
                                                <select name="poli" class="form-control">
                                                    <option value="">- Poli -</option>
                                                    <?php foreach ($poli as $poli) { ?>
                                                        <option value="<?php echo $poli->id ?>"><?php echo $poli->lokasi ?></option>
                                                    <?php } ?>
                                                </select>
                                                <!--</div>-->
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;">Dokter Utama</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <!--<div class="input-group date">-->
                                                <select name="dokter" class="form-control">
                                                    <option value="">- Tipe -</option>
                                                    <?php foreach ($sql_doc as $doctor) { ?>
                                                        <option value="<?php echo $doctor->id ?>"><?php echo strtoupper($doctor->nama) ?></option>
                                                    <?php } ?>
                                                </select>
                                                <!--</div>-->
                                            </td>
                                        </tr>
                                        <!--
                                        <tr>
                                            <th style="vertical-align: middle;">Jatuh Tempo</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                        <?php echo form_input(array('id' => 'tgl_tempo', 'name' => 'tgl_tempo', 'class' => 'form-control pull-right', 'value' => date('m/d/Y'))) ?>
                                                </div>
                                            </td>
                                        </tr>
                                        -->
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
                                            <th style="vertical-align: middle;">Petugas</th>
                                            <th style="vertical-align: middle;">:</th>
                                            <td style="vertical-align: middle;">
                                                <div class="form-group date">
                                                    <?php if (akses::hakKasir() == TRUE) { ?>
                                                        <?php echo form_input(array('id' => 'sales', 'name' => 'sales', 'class' => 'form-control pull-right', 'readonly' => TRUE, 'value' => $kasir, 'style' => (!empty($hasError['sales']) ? 'border-color: #a94442;' : ''))) ?>
                                                    <?php } else { ?>
                                                        <?php echo form_input(array('id' => 'sales', 'name' => 'sales', 'class' => 'form-control pull-right', 'style' => (!empty($hasError['sales']) ? 'border-color: #a94442;' : ''))) ?>
                                                    <?php } ?>                                                    
                                                </div>
                                            </td>
                                        </tr>
                                        <?php echo form_hidden('status_ppn', '0') ?>                                        
                                        <tr>
                                            <th style="vertical-align: top;">Keluhan</th>
                                            <th style="vertical-align: top;">:</th>
                                            <td style="vertical-align: top;">
                                                <?php echo form_textarea(array('id' => 'keluhan', 'name' => 'keluhan', 'class' => 'form-control pull-right')) ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="vertical-align: middle; text-align: right;" colspan="3">                                                
                                                <button type="reset" onclick="window.location.href = '<?php echo site_url('page=transaksi&act=set_nota_batal&term=trans_jual&route=trans_jual.php') ?>'" class="btn btn-warning btn-flat">Bersih</button>
                                                <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <?php echo form_close() ?>
                                <?php if (!empty($sess_jual)) { ?>
                                    <?php if ($sql_penj->status_nota == '1') { ?>
                                        <?php echo form_open_multipart(base_url('transaksi/set_nota_periksa.php')) ?>
                                        <input type="hidden" id="id_barang" name="id_barang" value="<?php echo $this->input->get('id_produk') ?>">
                                        <input type="hidden" id="no_nota" name="no_nota" value="<?php echo general::enkrip($sql_penj->id) ?>">
                                        <input type="hidden" id="kode" name="kode" value="1">

                                        <div class="col-md-6">                                    
                                            <table class="table table-striped">
                                                <tr>
                                                    <th style="vertical-align: middle;" colspan="3">Anamnesa / Pemeriksaan</th>
                                                    <!--<th style="vertical-align: middle;">:</th>-->
                                                    <!--<td style="vertical-align: middle;">-->
                                                    <!--</td>-->
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align: middle;" colspan="3">
                                                        <?php echo form_textarea(array('id' => 'anamnesa', 'name' => 'anamnesa', 'class' => 'form-control pull-right', 'value' => (isset($_GET['id_produk']) ? $sql_produk->harga_grosir : ''))) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle;">&nbsp;</th>
                                                    <th style="vertical-align: middle;"></th>
                                                    <td style="vertical-align: middle;"></td>
                                                </tr>
                                                <?php if (isset($_GET['id'])) { ?>
                                                    <tr>
                                                        <td style="vertical-align: middle; text-align: right;" colspan="3">                                                
                                                            <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-cart-plus"></i> Simpan</button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                        </div>
                                        <?php echo form_close() ?>
                                    <?php } elseif ($sql_penj->status_nota == 2) { ?>
                                        <?php echo form_open_multipart(base_url('transaksi/cart_jual_simpan.php')) ?>
                                        <input type="hidden" id="id_barang" name="id_barang" value="<?php echo $this->input->get('id_produk') ?>">
                                        <input type="hidden" id="no_nota" name="no_nota" value="<?php echo $_GET['id'] ?>">

                                        <div class="col-md-6">                                    
                                            <table class="table table-striped">
                                                <tr>
                                                    <th style="vertical-align: middle;" colspan="3"><i class="fa fa-stethoscope"></i> Tindakan</th>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle;">Kode</th>
                                                    <th style="vertical-align: middle;">:</th>
                                                    <td style="vertical-align: middle;">
                                                        <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right', 'value' => (isset($_GET['id_produk']) ? $sql_produk->kode : ''))) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle;">Jml</th>
                                                    <th style="vertical-align: middle;">:</th>
                                                    <td style="vertical-align: middle;">
                                                        <div id="bag-pelanggan" class="<?php echo (!empty($hasError['pelanggan']) ? 'has-error' : '') ?>">
                                                            <div class="input-group date">
                                                                <?php if ($sql_produk->status_brg_dep == '1') { ?>
                                                                    <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'value' => '1', 'style' => (!isset($_GET['id_produk']) ? 'width: 100px;' : ''))) ?>
                                                                    <?php if (isset($_GET['id_produk'])) { ?>
                                                                        <span class="input-group-addon no-border text-bold"><?php echo nbs() ?></span>
                                                                        <select id="satuan" name="satuan" class="form-control">
                                                                            <?php foreach ($sql_produk_sat as $satuan) { ?>
                                                                                <option value="<?php echo $satuan->satuan ?>"><?php echo ucwords($satuan->satuan) . ($satuan->satuan != $sql_satuan->satuanTerkecil ? ' (' . $satuan->jml . ' ' . $sql_satuan->satuanTerkecil . ')' : '') ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                        <span class="input-group-addon no-border text-bold"><?php echo nbs(10) ?></span>
                                                                    <?php } ?>
                                                                <?php } else { ?>
                                                                    <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'value' => '1', 'style' => (isset($_GET['id_produk']) ? 'width: 75px;' : ''))) ?>
                                                                    <?php if (isset($_GET['id_produk'])) { ?>
                                                                        <span class="input-group-addon no-border text-bold"><?php echo nbs() ?></span>
                                                                        <select id="satuan" name="satuan" class="form-control">
                                                                            <?php foreach ($sql_produk_sat as $satuan) { ?>
                                                                                <option value="<?php echo $satuan->satuan ?>"><?php echo ucwords($satuan->satuan) . ($satuan->satuan != $sql_satuan->satuanTerkecil ? ' (' . $satuan->jml . ' ' . $sql_satuan->satuanTerkecil . ')' : '') ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                        <span class="input-group-addon no-border text-bold"><?php echo nbs() ?></span>
                                                                        <!--<input type="checkbox" id="harga_ds" name="harga_ds" style="bottom: 190px;" value="1"> Harga DS-->
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php if (!empty($sql_produk->produk)) { ?>
                                                    <tr>
                                                        <th style="vertical-align: middle;">Item</th>
                                                        <th style="vertical-align: middle;">:</th>
                                                        <td style="vertical-align: middle;">
                                                            <div id="bag-pelanggan" class="<?php echo (!empty($hasError['nomor_pelanggan']) ? 'has-error' : '') ?>">
                                                                <?php echo $sql_produk->produk ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <th style="vertical-align: middle;">Harga</th>
                                                    <th style="vertical-align: middle;">:</th>
                                                    <td style="vertical-align: middle;">
                                                        <div class="input-group date">
                                                            <div class="input-group-addon">
                                                                Rp
                                                            </div>
                                                            <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control pull-right', 'value' => (isset($_GET['id_produk']) ? $sql_produk->harga_grosir : ''))) ?>                                                   
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
                                                <tr>
                                                    <th style="vertical-align: middle;">&nbsp;</th>
                                                    <th style="vertical-align: middle;"></th>
                                                    <td style="vertical-align: middle;">
                                                    </td>
                                                </tr>
                                                <?php if (isset($_GET['id'])) { ?>
                                                    <tr>
                                                        <td style="vertical-align: middle; text-align: right;" colspan="3">                                                
                                                            <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-cart-plus"></i> Simpan</button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                        </div>
                                        <?php echo form_close() ?>                                            
                                    <?php } elseif ($sql_penj->status_nota == 3) { ?>
                                        <?php echo form_open_multipart(base_url('transaksi/cart_jual_simpan.php')) ?>
                                        <input type="hidden" id="id_barang" name="id_barang" value="<?php echo $this->input->get('id_produk') ?>">
                                        <input type="hidden" id="no_nota" name="no_nota" value="<?php echo $_GET['id'] ?>">

                                        <div class="col-md-6">                                    
                                            <table class="table table-striped">
                                                <tr>
                                                    <th style="vertical-align: middle;" colspan="3"><i class="fa fa-medkit"></i> Obat</th>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle;">Kode</th>
                                                    <th style="vertical-align: middle;">:</th>
                                                    <td style="vertical-align: middle;">
                                                        <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right', 'value' => (isset($_GET['id_produk']) ? $sql_produk->kode : ''))) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle;">Jml</th>
                                                    <th style="vertical-align: middle;">:</th>
                                                    <td style="vertical-align: middle;">
                                                        <div id="bag-pelanggan" class="<?php echo (!empty($hasError['pelanggan']) ? 'has-error' : '') ?>">
                                                            <div class="input-group date">
                                                                <?php if ($sql_produk->status_brg_dep == '1') { ?>
                                                                    <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'value' => '1', 'style' => (!isset($_GET['id_produk']) ? 'width: 100px;' : ''))) ?>
                                                                    <?php if (isset($_GET['id_produk'])) { ?>
                                                                        <span class="input-group-addon no-border text-bold"><?php echo nbs() ?></span>
                                                                        <select id="satuan" name="satuan" class="form-control">
                                                                            <?php foreach ($sql_produk_sat as $satuan) { ?>
                                                                                <option value="<?php echo $satuan->satuan ?>"><?php echo ucwords($satuan->satuan) . ($satuan->satuan != $sql_satuan->satuanTerkecil ? ' (' . $satuan->jml . ' ' . $sql_satuan->satuanTerkecil . ')' : '') ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                        <span class="input-group-addon no-border text-bold"><?php echo nbs(10) ?></span>
                                                                    <?php } ?>
                                                                <?php } else { ?>
                                                                    <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'value' => '1', 'style' => (isset($_GET['id_produk']) ? 'width: 75px;' : ''))) ?>
                                                                    <?php if (isset($_GET['id_produk'])) { ?>
                                                                        <span class="input-group-addon no-border text-bold"><?php echo nbs() ?></span>
                                                                        <select id="satuan" name="satuan" class="form-control">
                                                                            <?php foreach ($sql_produk_sat as $satuan) { ?>
                                                                                <option value="<?php echo $satuan->satuan ?>"><?php echo ucwords($satuan->satuan) . ($satuan->satuan != $sql_satuan->satuanTerkecil ? ' (' . $satuan->jml . ' ' . $sql_satuan->satuanTerkecil . ')' : '') ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                        <span class="input-group-addon no-border text-bold"><?php echo nbs() ?></span>
                                                                        <!--<input type="checkbox" id="harga_ds" name="harga_ds" style="bottom: 190px;" value="1"> Harga DS-->
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php if (!empty($sql_produk->produk)) { ?>
                                                    <tr>
                                                        <th style="vertical-align: middle;">Item</th>
                                                        <th style="vertical-align: middle;">:</th>
                                                        <td style="vertical-align: middle;">
                                                            <div id="bag-pelanggan" class="<?php echo (!empty($hasError['nomor_pelanggan']) ? 'has-error' : '') ?>">
                                                                <?php echo $sql_produk->produk ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <th style="vertical-align: middle;">Harga</th>
                                                    <th style="vertical-align: middle;">:</th>
                                                    <td style="vertical-align: middle;">
                                                        <div class="input-group date">
                                                            <div class="input-group-addon">
                                                                Rp
                                                            </div>
                                                            <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control pull-right', 'value' => (isset($_GET['id_produk']) ? $sql_produk->harga_grosir : ''))) ?>                                                   
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
                                                <tr>
                                                    <th style="vertical-align: middle;">&nbsp;</th>
                                                    <th style="vertical-align: middle;"></th>
                                                    <td style="vertical-align: middle;">
                                                    </td>
                                                </tr>
                                                <?php if (isset($_GET['id'])) { ?>
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
                            <div class="box-body  table-responsive">
                                <?php
                                $tglm = $this->tanggalan->tgl_indo($sess_jual['tgl_masuk']);
                                $tglj = $this->tanggalan->tgl_indo($sess_jual['tgl_keluar']);

                                $sql_cust = $this->db->where('id', $sess_jual['id_pelanggan'])->get('tbl_m_pelanggan')->row();
                                $sql_poli = $this->db->where('id', $sess_jual['id_lokasi'])->get('tbl_m_lokasi')->row();
                                ?>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Nama Pasien</th>
                                        <th>:</th>
                                        <td><?php echo strtoupper($sql_cust->nik) . ' / ' . strtoupper($sql_cust->nama) . ' / ' . strtoupper($sql_cust->jns_klm) ?></td>

                                        <th>Tgl Masuk</th>
                                        <th>:</th>
                                        <td><?php echo $tglm ?></td>
                                    </tr>
                                    <tr>
                                        <th>Petugas</th>
                                        <th>:</th>
                                        <td><?php echo ucwords($sql_sales->nama) ?></td>

                                        <th>Tgl Keluar</th>
                                        <th>:</th>
                                        <td><?php echo $tglj ?></td>
                                    </tr>
                                    <tr>
                                        <th>Klinik</th>
                                        <th>:</th>
                                        <td><?php echo strtoupper($sql_poli->lokasi) ?></td>

                                        <th>Tipe</th>
                                        <th>:</th>
                                        <td><?php echo general::status_tp($sql_penj->status) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Keluhan</th>
                                        <th>:</th>
                                        <td colspan="4"><?php echo $sql_penj->keterangan ?></td>
                                    </tr>
                                    <tr>
                                        <th>Anamnesa</th>
                                        <th>:</th>
                                        <td colspan="4"><?php echo $sql_penj->anamnesa ?></td>
                                    </tr>
                                </table>
                                <hr/>
                                <table class="table table-striped">
                                    <thead>                                        
                                        <tr>
                                            <th class="text-right"></th>
                                            <th class="text-center">No</th>
                                            <th class="text-left">Kode</th>
                                            <th class="text-left">Item</th>
                                            <th class="text-right">Harga</th>
                                            <th class="text-right">Jml</th>
                                            <th class="text-center">Diskon (%)</th>
                                            <th class="text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($sql_penj_det)) { ?>
                                            <?php
                                            $no = 1;
                                            $tot_penj = 0;
                                            ?>
                                            <?php foreach ($sql_penj_det as $penj_det) { ?>
                                                <?php $tot_penj = $tot_penj + $penj_det->subtotal; ?>
                                                <?php $produk = $this->db->where('id', $penj_det['options']['id_barang'])->get('tbl_m_produk')->row(); ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <?php echo anchor(base_url('transaksi/cart_jual_hapus.php?id=' . general::enkrip($penj_det['rowid']) . '&no_nota=' . general::enkrip($penj_det['options']['no_nota'])), '<i class="fa fa-remove"></i>', 'class="text-danger" onclick="return confirm(\'Hapus [' . $penj_det['name'] . '] ?\')"') ?>
                                                    </td>
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-left"><?php echo $penj_det['options']['kode'] ?></td>
                                                    <td class="text-left"><?php echo $penj_det['name'] ?></td>
                                                    <td class="text-right"><?php echo general::format_angka($penj_det['options']['harga']) ?></td>
                                                    <td class="text-right"><?php echo $penj_det['qty'] . ' ' . $penj_det['options']['satuan'] . ' ' . $penj_det['options']['satuan_ket'] ?></td>
                                                    <td class="text-center"><?php echo general::format_angka($penj_det['options']['disk1'], 0) . (!empty($penj_det['options']['disk2']) ? ' + ' . general::format_angka($penj_det['options']['disk2'], 0) : '') . (!empty($penj_det['options']['disk3']) ? ' + ' . general::format_angka($penj_det['options']['disk3'], 0) : '') ?></td>
                                                    <td class="text-right"><?php echo general::format_angka($penj_det['subtotal'], 0) ?></td>
                                                </tr>
        <?php } ?>
                                            <tr>
                                                <th class="text-right" colspan="7">
                                                    Total
                                                </th>
                                                <th class="text-right"><?php echo general::format_angka($this->cart->total(), 0) ?></th>
                                            </tr>
    <?php } else { ?>
                                            <tr>
                                                <td colspan="8" class="text-center text-bold">Data item kosong</td>
                                            </tr>
    <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                            <div class="box-footer">
                                <button type="button" class="btn btn-danger btn-flat pull-left" onclick="window.location.href = '<?php echo base_url('transaksi/set_nota_batal.php?term=jual&route=transaksi/trans_jual.php') ?>'"><i class="fa fa-remove"></i> Batal</button>
                                <?php if (!empty($sql_penj_det)) { ?>
                                    <?php echo form_open(base_url('transaksi/set_nota_proses.php')) ?>
                                    <?php echo form_hidden('no_nota', $_GET['id']) ?>
                                    <?php echo form_hidden('jml_total', $tot_penj) ?>
                                    <?php echo form_hidden('jml_ppn', $sql_penj->jml_ppn) ?>
                                        <button type="submit" class="btn btn-primary btn-flat pull-right">Lanjut &raquo;</button>
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
                            <h4 class="modal-title">Form Pelanggan</h4>
                        </div>                            
                        <div class="row">
                            <div class="col-md-12">                                    
                                <!--Nampilin message box success-->
                                <div id="msg-success" class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="glyphicon glyphicon-ok"></i><?php echo nbs(4) ?>Pelanggan berhasil ditambahkan !!</h5>
                                </div>
                            </div>
                        </div>                
                        <form class="tagForm" id="form-pelanggan">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                            <label class="control-label">NIK</label>
<?php echo form_input(array('id' => 'nik', 'name' => 'nik', 'class' => 'form-control')) ?>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Nama</label>
<?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control')) ?>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['nama_toko']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Nama Toko</label>
<?php echo form_input(array('id' => 'nama_toko', 'name' => 'nama_toko', 'class' => 'form-control')) ?>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['no_hp']) ? 'has-error' : '') ?>">
                                            <label class="control-label">No. HP</label>
<?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control')) ?>
                                        </div>
                                        <div class="form-group <?php echo (!empty($hasError['lokasi']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Lokasi / Tempat Usaha</label>
<?php echo form_input(array('id' => 'lokasi', 'name' => 'lokasi', 'class' => 'form-control')) ?>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Alamat</label>
<?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control')) ?>
                                        </div>
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

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.min.css') ?>">

<!--Datepicker-->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Page script -->
<script type="text/javascript">
                                $(function () {
                                    $('#msg-success').hide();
                                    $(".select2").select2();
                                    $('#tgl_masuk').datepicker({autoclose: true});

                                    $('#tgl_tempo').datepicker({
                                        autoclose: true,
                                    });

                                    $('#tgl_bayar').datepicker({
                                        autoclose: true,
                                    });

                                    $("#harga").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                    $("#disk1").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                    $("#disk2").autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                    $("#disk3").autoNumeric({aSep: '.', aDec: ',', aPad: false});
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
                                                .append("<a>" + item.nik + "</a> <a>(" + item.jns_klm + ")</a></br><a>" + item.nama + "</a></br><a>" + item.alamat + "</a></br>-----------------------------------------")
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
                                                    url: "<?php echo base_url('transaksi/json_barang.php?status=2&kat=') ?>",
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
                                                $('#harga').val(ui.item.harga_grosir);
                                                $('#jml').val('1');
                                                window.location.href = "<?php echo base_url('transaksi/trans_jual.php?id=' . $this->input->get('id')) ?>&id_produk=" + ui.item.id + "&harga=" + ui.item.harga;

                                                //Give focus to the next input field to recieve input from user
                                                $('#jml').focus();
                                                return false;
                                            }

                                            //Format the list menu output of the autocomplete
                                        }).data("ui-autocomplete")._renderItem = function (ul, item) {
                                            return $("<li></li>")
                                                    .data("item.autocomplete", item)
                                                    .append("<a>[" + item.kode + "] " + item.produk + "</a>")
                                                    .appendTo(ul);
                                        };
<?php } ?>

                                    $('#submit-pelanggan').on('click', function (e) {
                                        var nik = $('#nik').val();
                                        var nama = $('#nama').val();
                                        var nama_toko = $('#nama_toko').val();
                                        var lokasi = $('#lokasi').val();
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
                                                $('#nama_toko').val('');
                                                $('#lokasi').val('');
                                                $('#no_hp').val('');
                                                $('#alamat').val('');

//                   window.location.href='<?php // echo base_url('master/data_customer_tambah.php?id=')    ?>' + data.trim() + '&route=transaksi/trans_jual.php';
//
//                   $("#bag-pelanggan").load("<?php // echo base_url('transaksi/trans_jual.php')    ?> #bag-pelanggan", function () {
//                       $(".select2").select2();
//                   });
                                                $('#msg-success').show();
                                                $("#modal-primary").modal('hide');
//                   setTimeout(function () {
//                       $('#msg-success').hide('blind', {}, 500)
//                   }, 3000);
//                    alert(result.id);
                                            },
                                            error: function () {
                                                alert('Error');
                                            }
                                        });
                                        return false;
                                    });

                                    /* Data Satuan */
                                    $("#satuan").on('change', function () {
                                        var sat_jual = $('#satuan option:selected').val();
                                        $.ajax({
                                            type: "GET",
                                            url: "<?php echo site_url('page=transaksi&act=json_barang_sat&id=' . general::dekrip($this->input->get('id_produk'))) ?>&satuan=" + sat_jual + "",
                                            dataType: "json",
                                            success: function (data) {
                                                $('#harga').val(data.harga);
                                            }
                                        });
                                    });


                                    /* HARGA DS */
                                    $("#harga_ds").on('change', function () {
                                        if (this.checked) {
                                            var jml_brg = $('#jml').val().replace(/[.]/g, "");
                                            var harga_j = $('#harga').val().replace(/[.]/g, "");
                                            var jml_harga = (jml_brg / 12) * harga_j;

                                            $('#harga').val(Math.round(jml_harga)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                        }
                                    });

                                });
</script>