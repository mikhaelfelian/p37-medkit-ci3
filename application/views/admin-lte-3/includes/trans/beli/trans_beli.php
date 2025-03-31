<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pembelian</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('transaksi/pembelian/index.php') ?>">Pembelian</a></li>
                        <li class="breadcrumb-item active">Trans Beli</li>
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
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Pembelian</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php // echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php echo form_open(base_url('transaksi/beli/set_trans_beli.php'), 'id="trans_beli_form" autocomplete="off"') ?>
                                    <?php echo add_form_protection() ?>
                                    <input type="hidden" id="id_supplier" name="id_supplier" value="<?php echo (!empty($sql_po->id_supplier) ? $sql_po->id_supplier : '') ?>">                                  
                                    <input type="hidden" id="id_po" name="id_po" value="<?php echo (!empty($sql_po->id) ? $sql_po->id : '') ?>">                                  

                                    <div class="form-group">
                                        <label class="control-label">Kode PO</label>
                                        <div class="input-group mb-3">
                                            <?php echo form_input(array('id' => 'kode_po', 'name' => 'kode_po', 'class' => 'form-control rounded-0 text-middle' . (!empty($hasError['kode_po']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Isikan Kode Purchase Order ...', 'value'=>$sql_po->no_nota)) ?>
                                        </div>
                                    </div>
                                    <div class="form-group <?php echo (!empty($hasError['id_supplier']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Nama Supplier*</label>
                                        <?php echo form_input(array('id' => 'supplier', 'name' => 'supplier', 'class' => 'form-control rounded-0 text-middle' . (!empty($hasError['id_supplier']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Isikan Nama Supplier ...', 'value'=>$sql_supplier->nama)) ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group <?php echo (!empty($hasError['tgl_beli']) ? 'text-danger' : '') ?>">
                                                <label class="control-label">Tgl Faktur</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                    </div>
                                                    <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl_masuk', 'class' => 'form-control rounded-0 pull-right' . (!empty($hasError['tgl_masuk']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Tgl Faktur ...')) ?>
                                                </div>
                                            </div>                                            
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group <?php echo (!empty($hasError['tgl_keluar']) ? 'text-danger' : '') ?>">
                                                <label class="control-label">Tgl Tempo</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                    </div>
                                                    <?php echo form_input(array('id' => 'tgl_keluar', 'name' => 'tgl_keluar', 'class' => 'form-control rounded-0 pull-right' . (!empty($hasError['tgl_keluar']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Tgl Tempo ...')) ?>
                                                </div>
                                            </div>                                           
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">No. Faktur</label>
                                        <div class="input-group mb-3">
                                            <?php echo form_input(array('id' => 'no_nota', 'name' => 'no_nota', 'class' => 'form-control rounded-0 text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Isikan No Faktur ...')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Status PPn</label>
                                        <div class="input-group mb-3">
                                            <?php echo form_radio(array('id' => 'status_ppn', 'name' => 'status_ppn', 'value' => '0', 'checked'=>'TRUE')).nbs(2) ?> Non PPN <?php echo nbs(4); ?>
                                            <?php echo form_radio(array('id' => 'status_ppn', 'name' => 'status_ppn', 'value' => '1')).nbs(2) ?> Tambah PPN <?php echo nbs(4); ?>
                                            <?php echo form_radio(array('id' => 'status_ppn', 'name' => 'status_ppn', 'value' => '2')).nbs(2) ?> Include PPN  <?php echo nbs(4); ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-danger btn-flat" onclick="window.location.href='<?php echo base_url('transaksi/beli/set_trans_beli_batal.php?id='.general::enkrip($sess_beli['no_nota'])) ?>'"><i class="fa fa-remove"></i> Batal</button>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-shopping-cart"></i> Set Beli</button>
                                        </div>
                                    </div>
                                    <?php echo add_double_submit_protection('trans_beli_form') ?>
                                    <?php echo form_close() ?>
                                </div>
                                <div class="col-md-6">
                                    <?php if (!empty($sess_beli)) { ?>
                                        <?php echo form_open(base_url('transaksi/beli/cart_beli'.(isset($_GET['rowid']) ? '_upd' : '_simpan').'.php'), 'id="cart_beli_form" autocomplete="off"') ?>
                                        <?php echo add_form_protection() ?>
                                        <input type="hidden" id="id" name="id" value="<?php echo general::enkrip($sql_beli->id) ?>">                                  
                                        <input type="hidden" id="id_item" name="id_item" value="<?php echo general::enkrip($sql_item->id) ?>">                                  
                                        <input type="hidden" id="rowid" name="rowid" value="<?php echo $this->input->get('rowid') ?>">                                  
                                        
                                        <div class="row">
                                            <div class="col-md-<?php echo (!empty($sql_item->produk) ? '3' : '12') ?>">
                                                <div class="form-group <?php echo (!empty($hasError['id_produk']) ? 'text-danger' : '') ?>">
                                                    <label class="control-label">Kode</label>
                                                    <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control rounded-0 text-middle' . (!empty($hasError['id_produk']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Isikan Kode ...', 'value' => $sql_item->kode)) ?>
                                                </div>                                                
                                            </div>
                                            <?php if (!empty($sql_item->produk)) { ?>
                                            <div class="col-md-3">
                                                <div class="form-group <?php echo (!empty($hasError['kode_batch']) ? 'text-danger' : '') ?>">
                                                    <label class="control-label">Nomor Batch</label>
                                                    <?php echo form_input(array('id' => 'kode_batch', 'name' => 'kode_batch', 'class' => 'form-control rounded-0 text-middle' . (!empty($hasError['kode_batch']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Isikan Kode Batch...', 'value' => (float) $sql_beli_det_rw->kode_batch)) ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group <?php echo (!empty($hasError['tgl_ed']) ? 'text-danger' : '') ?>">
                                                    <label class="control-label">Tgl Kadaluarsa</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                        </div>
                                                        <?php echo form_input(array('id' => 'tgl_ed', 'name' => 'tgl_ed', 'class' => 'form-control rounded-0 text-middle' . (!empty($hasError['kode_batch']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Isikan Kode Batch...', 'value' => $this->tanggalan->tgl_indo7($sql_beli_det_rw->tgl_ed))) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <?php if (!empty($sql_item->produk)) { ?>
                                            <div class="form-group <?php echo (!empty($hasError['id_produk']) ? 'text-danger' : '') ?>">
                                                <label class="control-label">Item</label>
                                                <?php echo form_input(array('id' => 'item', 'name' => 'item', 'class' => 'form-control rounded-0 text-middle' . (!empty($hasError['id_produk']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Isikan Produk ...', 'value' => $sql_item->produk, 'readonly' => 'TRUE')) ?>
                                            </div>
                                        <?php } ?>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group <?php echo (!empty($hasError['jml']) ? 'text-danger' : '') ?>">
                                                    <label class="control-label">Jml</label>
                                                    <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control rounded-0 pull-right' . (!empty($hasError['tgl_masuk']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Jml ...', 'value'=>(!empty($_GET['qty']) ? $this->input->get('qty') : '1'))) ?>
                                                </div>                                            
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group <?php echo (!empty($hasError['satuan']) ? 'text-danger' : '') ?>">
                                                    <label class="control-label">Satuan</label>
                                                    <select name="satuan" class="form-control rounded-0">
                                                        <option value="">- Pilih -</option>
                                                        <?php foreach ($sql_satuan as $satuan) { ?>
                                                            <option value="<?php echo $satuan->id ?>" <?php echo ($satuan->id == $_GET['id_satuan'] ? 'selected' : '') ?>><?php echo strtoupper($satuan->satuanTerkecil) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>                                           
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group <?php echo (!empty($hasError['harga_het']) ? 'text-danger' : '') ?>">
                                                    <label class="control-label">Harga Eceran Tertinggi (HET)</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <?php echo form_input(array('id' => 'harga', 'name' => 'harga_het', 'class' => 'form-control rounded-0 pull-right' . (!empty($hasError['tgl_keluar']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Harga ...', 'value' => (float) $sql_beli_det_rw->harga_het)) ?>
                                                    </div>
                                                </div>                                       
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group <?php echo (!empty($hasError['harga']) ? 'text-danger' : '') ?>">
                                                    <label class="control-label">Harga</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control rounded-0 pull-right' . (!empty($hasError['tgl_keluar']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Harga ...', 'value' => (float) $sql_item->harga_beli)) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group <?php echo (!empty($hasError['potongan']) ? 'text-danger' : '') ?>">
                                                    <label class="control-label">Potongan</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <?php echo form_input(array('id' => 'potongan', 'name' => 'potongan', 'class' => 'form-control rounded-0 pull-right' . (!empty($hasError['tgl_keluar']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Potongan ...', 'value'=>'0')) ?>
                                                    </div>
                                                </div>                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Diskon 1</label>
                                                    <?php echo form_input(array('id' => 'diskon', 'name' => 'disk1', 'class' => 'form-control rounded-0 pull-right' . (!empty($hasError['tgl_keluar']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Disk 1 ...', 'value'=>'0')) ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Diskon 2</label>
                                                    <?php echo form_input(array('id' => 'diskon', 'name' => 'disk2', 'class' => 'form-control rounded-0 pull-right' . (!empty($hasError['tgl_keluar']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Disk 1 ...', 'value'=>'0')) ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Diskon 3</label>
                                                    <?php echo form_input(array('id' => 'diskon', 'name' => 'disk3', 'class' => 'form-control rounded-0 pull-right' . (!empty($hasError['tgl_keluar']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Disk 1 ...', 'value'=>'0')) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">

                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-shopping-cart"></i> Simpan</button>
                                            </div>
                                        </div>
                                        <?php echo add_double_submit_protection('cart_beli_form') ?>
                                        <?php echo form_close() ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (!empty($sess_beli)) { ?>
                        <div class="col-md-12">
                            <?php echo form_open(base_url('transaksi/beli/set_trans_beli_proses.php'), 'id="trans_beli_proses_form" autocomplete="off"') ?>
                            <?php echo form_hidden('no_nota', general::enkrip($sql_beli->id)) ?>               
                            <?php echo add_form_protection() ?>
                            <div class="card card-default">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-shopping-cart"></i> Data Item Pembelian</h3>
                                    <div class="card-tools">
                                        <ul class="pagination pagination-sm float-right">

                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-striped">
                                                    <tr>
                                                        <th>Nama Supplier</th>
                                                        <th>:</th>
                                                        <td><?php echo ucwords($sql_supplier->nama) ?></td>

                                                        <th>Tgl Pembelian</th>
                                                        <th>:</th>
                                                        <td><?php echo $this->tanggalan->tgl_indo2($sess_beli['tgl_masuk']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Kode Supplier</th>
                                                        <th>:</th>
                                                        <td><?php echo ucwords($sql_supplier->kode) ?></td>

                                                        <th>Tgl Jatuh Tempo</th>
                                                        <th>:</th>
                                                        <td><?php echo $this->tanggalan->tgl_indo2($sess_beli['tgl_keluar']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>No. Purchase Order</th>
                                                        <th>:</th>
                                                        <td><?php echo strtoupper($sess_beli['no_nota']) ?></td>

                                                        <th>Status PPN</th>
                                                        <th>:</th>
                                                        <td><?php echo general::status_ppn($sess_beli['status_ppn']) ?></td>
                                                    </tr>
                                                </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">No</th>
                                                        <th class="text-left">Item</th>
                                                        <th class="text-center">Jml</th>
                                                        <th class="text-right">Harga</th>
                                                        <th class="text-right">Diskon</th>
                                                        <th class="text-right">Potongan</th>
                                                        <th class="text-right">Subtotal</th>
                                                        <th class="text-right"></th>
                                                    </tr>                                    
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($sql_beli_det)) { ?>
                                                        <?php $no = 1; $subtotal = 0; ?>
                                                        <?php foreach ($sql_beli_det as $cart) { ?>
                                                        <?php $subtotal = $subtotal + $cart->subtotal; ?>
                                                            <tr>
                                                                <td class="text-right" style="width: 50px;">
                                                                    <?php echo anchor(base_url('transaksi/cart_beli_hapus.php?id='.general::enkrip($sql_beli->id).'&item_id='.general::enkrip($cart->id)), '<i class="fas fa-trash"></i>', 'class="btn btn-danger btn-sm rounded-0" onclick="return confirm(\'Hapus [' . $cart->produk . '] ?\')"') ?>
                                                                </td>
                                                                <td class="text-center"><?php echo $no; ?></td>
                                                                <td class="text-left">
                                                                    <?php echo (!empty($cart->kode_batch) ? $cart->kode_batch.br() : ''); ?>
                                                                    <?php echo $cart->produk; ?><br/>
                                                                    <small><b>ED :</b><?php echo $this->tanggalan->tgl_indo($cart->tgl_ed); ?></small><br/>
                                                                    <small><b>HET :</b><?php echo general::format_angka($cart->harga_het); ?></small><br/>
                                                                </td>
                                                                <td class="text-center"><?php echo (float)$cart->jml; ?></td>
                                                                <td class="text-right"><?php echo general::format_angka($cart->harga); ?></td>
                                                                <td class="text-center"><?php echo ($cart->disk1 != '0' ? (float)$cart->disk1 : '') . ($cart->disk2 != '0' ? ' + ' . (float)$cart->disk2 : '') . ($cart->disk3 != '0' ? ' + ' . (float)$cart->disk3 : ''); ?></td>
                                                                <td class="text-right"><?php echo general::format_angka($cart->potongan); ?></td>
                                                                <td class="text-right"><?php echo general::format_angka($cart->subtotal); ?></td>
                                                                <td class="text-left"><?php echo anchor(base_url('transaksi/beli/trans_beli.php?id='.$this->input->get('id').'&rowid='.general::enkrip($cart->id).'&id_item='.general::enkrip($cart->id_produk).'&id_satuan='.$cart->id_satuan.'&harga='.(float)$cart->harga.'&qty='.(float)$cart->jml), '<i class="fa fa-edit"></i> Ubah', 'class="btn btn-info btn-flat btn-xs" style="width: 55px;"') ?></td>
                                                            </tr>
                                                            <?php $no++; ?>
                                                        <?php } ?>
                                                        <tr>
                                                            <th class="text-right" colspan="7">Total</th>
                                                            <th class="text-right"><?php echo general::format_angka($subtotal); ?></th>
                                                            <th class="text-right"></th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-right" colspan="7">Ongkir</th>
                                                            <th class="text-right"><?php echo form_input(array('id' => 'ongkir', 'name' => 'jml_ongkir', 'class' => 'form-control rounded-0 pull-right' . (!empty($hasError['ongkir']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Ongkir ...')) ?></th>
                                                            <th class="text-right"></th>
                                                        </tr>
                                                    <?php } else { ?>
                                                        <tr>
                                                            <th class="text-center" colspan="8">Tidak Ada Data</th>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-6">

                                        </div>
                                        <div class="col-md-6 text-right">
                                            <?php if (!empty($sql_beli_det)) { ?>
                                                <button type="submit" class="btn btn-success btn-flat"><i class="fas fa-arrow-right"></i> Proses &raquo;</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo add_double_submit_protection('trans_beli_proses_form') ?>
                            <?php echo form_close() ?>  
                        </div>                                      
                <?php } ?>
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
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        // Mengcover tanggal masuk dan tempo
        $('input[id=tgl]').datepicker({
            format: 'mm/dd/yyyy',
            autoclose: true
        });
        $('input[id=tgl_keluar]').datepicker({
            format: 'mm/dd/yyyy',
            autoclose: true
        });
        $('input[id=tgl_ed]').datepicker({
            format: 'mm/dd/yyyy',
            autoclose: true
        });

        $('input[id=harga], input[id=jml], input[id=diskon], input[id=potongan], input[id=ongkir]').autoNumeric({aSep: '.', aDec: ',', aPad: false});

        // Autocomplete Data Purchase Order
        $('#kode_po').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('transaksi/beli/json_po.php') ?>",
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
                $itemrow.find('#id_po').val(ui.item.id);
                $('#id_po').val(ui.item.id);
                $('#kode_po').val(ui.item.supplier);
                window.location.href = "<?php echo base_url('transaksi/beli/trans_beli.php?id_po=') ?>" + ui.item.id +"&id_supplier=" + ui.item.id_supplier;
                
                // Give focus to the next input field to recieve input from user
                $('#kode_po').focus();
                return false;
            }

            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.no_nota + "</a></br><a>" + item.supplier + "</a></br><a>" + item.alamat + "<br/>--------------------------------------------------------------</a>")
                    .appendTo(ul);
        };

        // Autocomplete Data Supplier
        $('#supplier').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('transaksi/beli/json_supplier.php') ?>",
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

                // Give focus to the next input field to recieve input from user
                $('#supplier').focus();
                return false;
            }

            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.kode + "</a></br><a>" + item.nama + "</a></br><a>" + item.alamat + "<br/>--------------------------------------------------------------</a>")
                    .appendTo(ul);
        };

<?php if (!empty($sess_beli)) { ?>
            // Autocomplete Data Item
            $('#kode').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url('transaksi/beli/json_item.php') ?>",
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
                    $itemrow.find('#id_item').val(ui.item.id);
                    $('#id_item').val(ui.item.id_item);
                    window.location.href = "<?php echo base_url('transaksi/beli/trans_beli.php?id='.general::enkrip($sql_beli->id)) ?>&id_item=" + ui.item.id_item + "&harga=" + ui.item.harga_beli;

                    // Give focus to the next input field to recieve input from user
                    $('#item').focus();
                    return false;
                }

                // Format the list menu output of the autocomplete
            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<a>[" + item.kode + "] " + item.produk + "</a>")
                        .appendTo(ul);
            };
<?php } ?>
        <?php echo $this->session->flashdata('transaksi_toast'); ?>
    });
</script>