<?php $hasError = $this->session->flashdata('form_error'); ?>
<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Transaksi
                <small>Pembayaran</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('dashboard.php') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
                <li class="active">Form Pembayaran</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-shopping-cart"></i> Form Pembayaran Penjualan</h3>
                        </div>
                        <div class="box-body">
                            <?php echo $this->session->flashdata('transaksi') ?>

                            <div class="row">
                                <?php if (isset($_GET['id_produk'])) { ?>
                                    <div class="col-md-6">
                                        <table class="table table-striped table-responsive">
                                            <tr>
                                                <th colspan="5"><i class="fa fa-history"></i> Riwayat Produk</th>
                                            </tr>
                                            <tr>
                                                <th class="text-right">Tanggal</th>
                                                <th class="text-right">Nominal</th>
                                                <th class="text-right">Disk 1</th>
                                                <th class="text-right">Disk 2</th>
                                                <th class="text-right">Disk 3</th>
                                            </tr>
                                            <?php foreach ($sql_produk_hist as $prd_hist) { ?>
                                                <?php $sql_hst_dsk = $this->db->where('id_penjualan', $prd_hist->id_penjualan)->where('kode', $prd_hist->kode)->get('tbl_trans_jual_det')->row() ?>
                                                <tr>
                                                    <td class="text-right"><?php echo $this->tanggalan->tgl_indo($prd_hist->tgl_simpan) ?></td>
                                                    <td class="text-right"><?php echo general::format_angka($prd_hist->nominal) ?></td>
                                                    <td class="text-right"><?php echo (float) $sql_hst_dsk->disk1 ?>%</td>
                                                    <td class="text-right"><?php echo (float) $sql_hst_dsk->disk2 ?>%</td>
                                                    <td class="text-right"><?php echo (float) $sql_hst_dsk->disk3 ?>%</td>
                                                </tr>
                                                <?php $last_hj = $prd_hist->nominal; ?>
                                                <?php $id_hj = $prd_hist->id_harga_jual; ?>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="2"><?php echo $this->session->flashdata('notif'); ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                <?php } else { ?>
                                    <?php echo form_open_multipart(base_url('transaksi/set_pemb_jual.php'), 'autocomplete="off"') ?>
                                    <input type="hidden" id="id_customer" name="id_customer">
                                    <input type="hidden" id="id_sales" name="id_sales" <?php echo (akses::hakKasir() == TRUE ? 'value="' . $kasir_id . '"' : '') ?>>
                                    <input type="hidden" id="no_nota" name="no_nota" value="<?php echo $no_nota ?>">
                                    <input type="hidden" id="id" name="id" value="<?php echo $this->input->get('id') ?>">

                                    <div class="col-md-6">                                    
                                        <table class="table table-striped">
                                            <tr>
                                                <th style="vertical-align: middle;">Tgl Bayar</th>
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
                                                <th style="vertical-align: middle;">Sales</th>
                                                <th style="vertical-align: middle;">:</th>
                                                <td style="vertical-align: middle;">
                                                    <div class="form-group <?php echo (!empty($hasError['pelanggan']) ? 'has-error' : '') ?>">
                                                        <?php if (akses::hakKasir() == TRUE) { ?>
                                                            <?php echo form_input(array('id' => 'sales', 'name' => 'sales', 'class' => 'form-control pull-right', 'readonly' => TRUE, 'value' => $kasir)) ?>
                                                        <?php } else { ?>
                                                            <?php echo form_input(array('id' => 'sales', 'name' => 'sales', 'class' => 'form-control pull-right')) ?>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php echo form_hidden('status_ppn', '0') ?>
                                            <tr>
                                                <td style="vertical-align: middle; text-align: right;" colspan="3">                                                
                                                    <button type="reset" onclick="window.location.href = '<?php echo site_url('page=transaksi&act=set_nota_batal&term=trans_jual&route=trans_jual.php') ?>'" class="btn btn-warning btn-flat">Bersih</button>
                                                    <button type="submit" class="btn btn-primary btn-flat">Set Order</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php echo form_close() ?>
                                <?php } ?>
                                <?php if (!empty($sess_jual)) { ?>
                                    <?php echo form_open_multipart(base_url('transaksi/input_pemb_jual_simpan.php'), 'autocomplete="off"') ?>
                                    <input type="hidden" id="id_bayar" name="id_bayar" value="<?php echo general::enkrip($sess_jual['id']) ?>">
                                    <input type="hidden" id="id" name="id_penjualan" value="<?php echo general::enkrip($sql_penj->id) ?>">

                                    <div class="col-md-6">                                    
                                        <table class="table table-striped">
                                            <tr>
                                                <th style="vertical-align: middle;">No. Nota</th>
                                                <th style="vertical-align: middle;">:</th>
                                                <td style="vertical-align: middle;">
                                                    <div class="form-group <?php echo (!empty($hasError['no_nota']) ? 'has-error' : '') ?>">
                                                        <?php echo form_input(array('id' => 'no_nota', 'name' => 'no_nota', 'class' => 'form-control pull-right', 'readonly' => 'TRUE', 'value' => (isset($_GET['no_nota']) ? $sql_penj->no_nota : ''))) ?>
                                                    </div>                                                
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="vertical-align: middle;"></th>
                                                <th style="vertical-align: middle;"></th>
                                                <td style="vertical-align: middle;">
                                                    <?php echo anchor(base_url('transaksi/input_pemb_jual_list.php?id=' . general::enkrip($sess_jual['id'])), '<i class="fa fa-search"></i> Cari Nota', 'class="text-bold"') ?>                                           
                                                </td>
                                            </tr>
                                            <?php if (isset($_GET['no_nota'])) { ?>
                                                <tr>
                                                    <th style="vertical-align: middle; width: 200px;">
                                                        <div class="input-group <?php echo (!empty($hasError['harga']) ? 'has-error' : '') ?>">
                                                            Subtotal
                                                        </div>
                                                    </th>
                                                    <th style="vertical-align: middle;">:</th>
                                                    <td style="vertical-align: middle;">
                                                        <div class="input-group <?php echo (!empty($hasError['jml_diskon']) ? 'has-error' : '') ?>">
                                                            <div class="input-group-addon">Rp</div>
                                                            <?php echo form_input(array('id' => 'nominal', 'name' => 'jml_subtotal', 'class' => 'form-control pull-right', 'readonly' => 'TRUE', 'value' => (!empty($sql_penj->jml_gtotal) ? $sql_penj->jml_gtotal : 0))) ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle; width: 200px;">
                                                        <div class="input-group <?php echo (!empty($hasError['harga']) ? 'has-error' : '') ?>">
                                                            Pembayaran
                                                        </div>
                                                    </th>
                                                    <th style="vertical-align: middle;">:</th>
                                                    <td style="vertical-align: middle;">
                                                        <div class="input-group <?php echo (!empty($hasError['jml_dibayar']) ? 'has-error' : '') ?>">
                                                            <div class="input-group-addon">Rp</div>
                                                            <?php echo form_input(array('id' => 'nominal', 'name' => 'jml_dibayar', 'class' => 'form-control pull-right', 'readonly' => 'TRUE', 'value' => (!empty($sql_penj->jml_bayar) ? $sql_penj->jml_bayar : 0))) ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle; width: 200px;">
                                                        <div class="input-group <?php echo (!empty($hasError['jml_bayar']) ? 'has-error' : '') ?>">
                                                            Potongan
                                                        </div>
                                                    </th>
                                                    <th style="vertical-align: middle;">:</th>
                                                    <td style="vertical-align: middle;">
                                                        <div class="input-group <?php echo (!empty($hasError['jml_diskon']) ? 'has-error' : '') ?>">
                                                            <div class="input-group-addon">Rp</div>
                                                            <?php echo form_input(array('id' => 'nominal', 'name' => 'jml_diskon', 'class' => 'form-control pull-right', 'value' => (!empty($sql_penj->jml_potongan) ? $sql_penj->jml_potongan : 0))) ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle; width: 200px;">
                                                        <div class="input-group <?php echo (!empty($hasError['jml_retur']) ? 'has-error' : '') ?>">
                                                            Potongan Retur
                                                        </div>
                                                    </th>
                                                    <th style="vertical-align: middle;">:</th>
                                                    <td style="vertical-align: middle;">
                                                        <div class="input-group <?php echo (!empty($hasError['jml_retur']) ? 'has-error' : '') ?>">
                                                            <div class="input-group-addon">Rp</div>
                                                            <?php echo form_input(array('id' => 'nominal', 'name' => 'jml_retur', 'class' => 'form-control pull-right', 'value' => (!empty($sql_penj->jml_retur) ? $sql_penj->jml_retur : 0))) ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle; width: 200px;">
                                                        <div class="input-group <?php echo (!empty($hasError['harga']) ? 'has-error' : '') ?>">
                                                            Grand Total
                                                        </div>
                                                    </th>
                                                    <th style="vertical-align: middle;">:</th>
                                                    <td style="vertical-align: middle;">
                                                        <div class="input-group <?php echo (!empty($hasError['jml_diskon']) ? 'has-error' : '') ?>">
                                                            <div class="input-group-addon">Rp</div>
                                                            <?php echo form_input(array('id' => 'nominal', 'name' => 'jml_gtotal', 'class' => 'form-control pull-right', 'readonly' => 'TRUE', 'value' => (!empty($sql_penj->jml_gtotal) ? $sql_penj->jml_gtotal : 0))) ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle; width: 200px;">
                                                        <div class="input-group <?php echo (!empty($hasError['harga']) ? 'has-error' : '') ?>">
                                                            Kurang Bayar
                                                        </div>
                                                    </th>
                                                    <th style="vertical-align: middle;">:</th>
                                                    <td style="vertical-align: middle;">
                                                        <div class="input-group <?php echo (!empty($hasError['jml_diskon']) ? 'has-error' : '') ?>">
                                                            <div class="input-group-addon">Rp</div>
                                                            <?php echo form_input(array('id' => 'nominal', 'name' => 'jml_kurang', 'class' => 'form-control pull-right', 'readonly' => 'TRUE', 'value' => (!empty($sql_penj->jml_kurang) ? $sql_penj->jml_kurang : 0))) ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle; width: 200px;">
                                                        <div class="input-group <?php echo (!empty($hasError['jml_bayar']) ? 'has-error' : '') ?>">
                                                            Jml Bayar
                                                        </div>
                                                    </th>
                                                    <th style="vertical-align: middle;">:</th>
                                                    <td style="vertical-align: middle;">
                                                        <div class="input-group <?php echo (!empty($hasError['jml_bayar']) ? 'has-error' : '') ?>">
                                                            <div class="input-group-addon">Rp</div>
                                                            <?php echo form_input(array('id' => 'nominal', 'name' => 'jml_bayar', 'class' => 'form-control pull-right', 'value' => (!empty($last_hj) ? $last_hj : 0))) ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle; width: 200px;">
                                                        <div class="input-group">
                                                            Metode Bayar
                                                        </div>
                                                    </th>
                                                    <th style="vertical-align: middle;">:</th>
                                                    <td style="vertical-align: middle;">
                                                        <select id="metode_bayar" name="metode" class="form-control">
                                                            <!--<option value="">- Pilih -</option>-->
                                                            <?php foreach ($platform as $pl) { ?>
                                                                <option value="<?php echo $pl->id ?>"><?php echo $pl->platform ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr id="bank">
                                                    <th class="text-left" style="vertical-align: middle;">
                                                        Nama Bank
                                                    </th>                                                
                                                    <th style="vertical-align: middle;">:</th>
                                                    <th class="text-right">
                                                        <?php echo form_input(array('name' => 'platform', 'class' => 'form-control pull-right text-right', 'placeholder' => 'Nama Bank ...')) ?>
                                                    </th>
                                                </tr>
                                                <tr id="no_kartu">
                                                    <th class="text-left" style="vertical-align: middle;">
                                                        Bukti / No. Referensi
                                                    </th>                                                
                                                    <th style="vertical-align: middle;">:</th>
                                                    <th class="text-right">
                                                        <?php echo form_input(array('name' => 'keterangan', 'class' => 'form-control pull-right text-right', 'placeholder' => 'Bukti / No. Ref / No. Kartu ...')) ?>
                                                    </th>
                                                </tr>
                                                <?php if ($msg != NULL) { ?>
                                                    <tr>
                                                        <td colspan="3"><?php echo $msg; // $this->session->flashdata('notif');      ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php echo form_hidden('potongan', '0') ?>
                                            <?php } ?>
                                            <!--
                                            <tr>
                                                <th style="vertical-align: middle;">Potongan</th>
                                                <th style="vertical-align: middle;">:</th>
                                                <td style="vertical-align: middle;">
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            Rp
                                                        </div>
                                            <?php echo form_input(array('id' => 'harga', 'name' => 'potongan', 'class' => 'form-control pull-right', 'value' => '0')) ?>                                                   
                                                    </div>
                                                </td>
                                            </tr>
                                            -->
                                            <?php if (isset($_GET['id']) && isset($_GET['no_nota'])) { ?>
                                                <tr>
                                                    <td style="vertical-align: middle; text-align: right;" colspan="3">
                                                        <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-cart-plus"></i> Bayar</button>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                    <?php echo form_close() ?>
                                <?php } ?>
                            </div>
                            <?php if (!empty($sess_jual)) { ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($sess_jual)) { ?>
                <div class="row">                
                    <div class="col-lg-12">
                        <?php echo form_open(base_url('transaksi/input_pemb_jual_proses.php')) ?>
                        <div class="box box-warning" id="data_pelanggan">
                            <div class="box-body  table-responsive">
                                <?php
                                $tglm = $this->tanggalan->tgl_indo($sess_jual['tgl_masuk']);
                                $tglj = $this->tanggalan->tgl_indo($sess_jual['tgl_keluar']);

                                $sql_cust = $this->db->where('id', $sess_jual['id_pelanggan'])->get('tbl_m_pelanggan')->row();
                                ?>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Sales</th>
                                        <th>:</th>
                                        <td><?php echo ucwords($sql_sales->nama) ?></td>

                                        <th><?php echo nbs(5); ?></th>
                                        <th><?php echo nbs(); ?></th>
                                        <td><?php echo nbs(100); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tgl Pembayaran</th>
                                        <th>:</th>
                                        <td><?php echo $tglm ?></td>

                                        <th><?php echo nbs(10); ?></th>
                                        <th><?php echo nbs(); ?></th>
                                        <td><?php echo nbs(100); ?></td>
                                    </tr>
                                </table>
                                <hr/>
                                <table class="table table-striped">
                                    <thead>                                        
                                        <tr>
                                            <th class="text-right"></th>
                                            <th class="text-center">No</th>
                                            <th class="text-left">No. Nota</th>
                                            <th class="text-left">Metode</th>
                                            <th class="text-left">Tgl Transaksi</th>
                                            <th class="text-right">Nominal</th>
                                            <th class="text-right">Jml Bayar</th>
                                            <th class="text-right">Kurang Byr / Kembali</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($sql_penj_det)) { ?>
                                            <?php
                                            $no = 1;
                                            $tot_penj = 0;
                                            ?>
                                            <?php foreach ($sql_penj_det as $penj_det) { ?>
                                                <?php $tot_penj = $tot_penj + $penj_det['options']['jml_gtotal']; ?>
                                                <?php $platform = $this->db->where('id', $penj_det['options']['metode_bayar'])->get('tbl_m_platform')->row(); ?>
                                                <?php $penjualan = $this->db->where('no_nota', $penj_det['name'])->get('tbl_trans_jual')->row(); ?>
                                                <?php
                                                $jml_kurang = $penj_det['options']['jml_kurang'];
                                                $jml_kembali = $penj_det['options']['jml_kembali'];
                                                ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <?php echo anchor(base_url('transaksi/cart_jual_hapus.php?id=' . general::enkrip($penj_det['rowid']) . '&no_nota=' . general::enkrip($sess_jual['id']) . '&route=transaksi/input_pemb_jual.php'), '<i class="fa fa-remove"></i>', 'class="text-danger" onclick="return confirm(\'Hapus [' . $penj_det['name'] . '] ?\')"') ?>
                                                    </td>
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="text-left"><?php echo $penj_det['name'] ?></td>
                                                    <td class="text-left"><?php echo $platform->platform . (!empty($penj_det['options']['platform']) ? ' ' . $penj_det['options']['platform'] : '') . (!empty($penj_det['options']['keterangan']) ? '-' . $penj_det['options']['keterangan'] : '') ?></td>
                                                    <td class="text-left"><?php echo $this->tanggalan->tgl_indo($penj_det['options']['tgl_bayar']) ?></td>
                                                    <td class="text-right"><?php echo general::format_angka($penj_det['options']['jml_gtotal']) ?></td>
                                                    <td class="text-right"><?php echo general::format_angka($penj_det['price']) ?></td>
                                                    <td class="text-right"><?php echo general::format_angka(($jml_kurang < 0 ? $jml_kembali : $jml_kurang)) ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <th class="text-right" colspan="5">
                                                    Total
                                                </th>
                                                <th class="text-right"><?php echo general::format_angka($tot_penj, 0) ?></th>
                                                <th class="text-right" colspan="2"></th>
                                            </tr>
                                        <?php } else { ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-bold">Data transaksi kosong</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="box-footer">
                                <button type="button" class="btn btn-danger btn-flat pull-left" onclick="window.location.href = '<?php echo base_url('transaksi/set_nota_batal.php?term=byr_jual&route=input_pemb_jual.php') ?>'"><i class="fa fa-remove"></i> Batal</button>
                                <?php if (!empty($sql_penj_det)) { ?>
                                    <?php echo form_hidden('no_nota', $_GET['id']) ?>
                                    <button type="submit" class="btn btn-primary btn-flat pull-right">Simpan &raquo;</button>
                                <?php } ?>
                            </div>
                        </div>
                        <?php echo form_close() ?>
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
<script>
                                    $(function () {
                                        /* Metode Pembayaran */
                                        $('#bank').hide();
                                        $('#no_kartu').hide();

                                        $("#metode_bayar").on('change', function () {
                                            var met_byr = $('#metode_bayar option:selected').val();

                                            if ($('#metode_bayar option:selected').val() > 2) {
                                                $('#bank').show();
                                                $('#no_kartu').show();
                                            } else {
                                                $('#bank').hide()
                                                $('#no_kartu').hide()
                                            }
                                        });

                                        $('#msg-success').hide();
                                        $(".select2").select2();
                                        $('#tgl_masuk').datepicker({
                                            autoclose: true,
                                        });

                                        $('#tgl_bayar').datepicker({
                                            autoclose: true,
                                        });

                                        $("input[id=nominal]").autoNumeric({aSep: '.', aDec: ',', aPad: false});

<?php if (!isset($_GET['id_produk'])) { ?>
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
<?php } ?>

                                        /* Data Harga */
                                        $("#jns_harga").on('change', function () {
                                            var regone = $('#jns_harga option:selected').val();
                                            $('#harga').val(regone);
                                        });

                                        /* Hitung Diskon */
                                        $("input[name=jml_diskon]").keyup(function () {
                                            var jml_total = $('input[name=jml_subtotal]').val().replace(/[.]/g, "");
                                            var diskon = $('input[name=jml_diskon]').val().replace(/[.]/g, "");
                                            var retur = $('input[name=jml_retur]').val().replace(/[.]/g, "");
                                            var jml_gtotal = parseFloat(jml_total) - parseFloat(diskon) - parseFloat(retur);

//                                            $('input[name=jml_diskon]').val('0').autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $('input[name=jml_gtotal]').val(Math.round(jml_gtotal)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                        });
                                        
                                        /* Hitung Retur */
                                        $("input[name=jml_retur]").keyup(function () {
                                            var jml_total = $('input[name=jml_subtotal]').val().replace(/[.]/g, "");
                                            var diskon = $('input[name=jml_diskon]').val().replace(/[.]/g, "");
                                            var retur = $('input[name=jml_retur]').val().replace(/[.]/g, "");
                                            var jml_gtotal = parseFloat(jml_total) - parseFloat(diskon) - parseFloat(retur);

//                                            $('input[name=jml_diskon]').val('0').autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                            $('input[name=jml_gtotal]').val(Math.round(jml_gtotal)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
                                        });

                                    });
</script>