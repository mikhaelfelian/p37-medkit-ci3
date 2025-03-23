<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Item <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Data Item</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <?php echo $this->session->flashdata('master'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo form_open(base_url('master/data_barang_' . (isset($_GET['id']) ? 'update' : 'simpan') . '.php'), 'autocomplete="off"') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Data Item</h3>
                    </div>
                    <div class="box-body">
                        <?php $hasError = $this->session->flashdata('form_error'); ?>
                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                        <div class="form-group <?php echo (!empty($hasError['jml']) ? 'has-error' : '') ?>">
                            <label class="control-label">Kategori</label>
                            <select name="kategori" class="form-control">
                                <!--<option value="">- Pilih -</option>-->
                                <?php foreach ($kategori as $kategori) { ?>
                                    <option value="<?php echo $kategori->id ?>" <?php echo ($barang->id_kategori == $kategori->id ? 'selected' : '') ?>><?php echo $kategori->keterangan ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['merk']) ? 'has-error' : '') ?>">
                            <label class="control-label">Merk</label>
                            <select name="merk" class="form-control">
                                <option value="">- Pilih -</option>
                                <?php foreach ($sql_merk as $merk) { ?>
                                    <option value="<?php echo $merk->id ?>" <?php echo ($barang->id_merk == $merk->id ? 'selected' : '') ?>><?php echo $merk->merk ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['satKcl']) ? 'has-error' : '') ?>">
                            <label class="control-label">Kode Item</label>
                            <?php $kd = explode('-', $barang->kode) ?>
                            <table class="table table-bordered">
                                <tr>
                                    <td style="vertical-align: middle; width: 75px;">
                                        <?php echo form_input(array('id' => 'kode', 'name' => 'kode_dpn', 'class' => 'form-control', 'value' => (!empty($barang->id) ? $kd[0] : ''), 'placeholder'=>'PS')) ?>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <?php echo form_input(array('id' => 'kode', 'name' => 'kode_tgh', 'class' => 'form-control', 'value' => (!empty($kd[1]) ? $kd[1] : date('ynd')), 'readonly'=>'TRUE')) ?>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <?php echo form_input(array('id' => 'kode', 'name' => 'kode_blk', 'class' => 'form-control', 'value' => $kode, 'readonly'=>'TRUE')) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle; width: 75px;">
                                        * Kode
                                    </td>
                                    <td style="vertical-align: middle;">
                                        * Tanggal Hari Ini
                                    </td>
                                    <td style="vertical-align: middle;">
                                        * No. Urut di database
                                    </td>
                                </tr>
                            </table>
                            <i>* Cth Format : PS-xxxx-xxxx</i>
                            <?php // echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control', 'value' => (isset($_GET['id']) ? $barang->kode : $kode))) ?>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['satKcl']) ? 'has-error' : '') ?>">
                            <label class="control-label">Barcode</label>
                            <?php echo form_input(array('id' => 'barcode', 'name' => 'barcode', 'class' => 'form-control', 'value' => $barang->barcode, 'placeholder'=>'Isikan barcode item jika ada ...')) ?>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['satBsr']) ? 'has-error' : '') ?>">
                            <label class="control-label">Item</label>
                            <?php echo form_input(array('id' => 'barang', 'name' => 'barang', 'class' => 'form-control', 'value' => $barang->produk)) ?>
                        </div>
                        <?php if(akses::hakKasir() != TRUE){ ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group <?php echo (!empty($hasError['jml']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Stok</label>
                                    <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'value'=>(!empty($barang_stk->jml) ? $barang_stk->jml : '(Default)'), 'readonly'=>'TRUE')) ?>
                                </div>  
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group <?php echo (!empty($hasError['jml']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Satuan</label>
                                    <select name="satuan" class="form-control">
                                        <option value="">- Pilih -</option>
                                        <?php foreach ($sql_satuan as $satuan){ ?>
                                            <option value="<?php echo $satuan->id ?>" <?php echo ($barang->id_satuan == $satuan->id ? 'selected' : '') ?>><?php echo $satuan->satuanTerkecil; //.' ('.$satuan->satuanBesar.')('.$satuan->jml.')' ?></option>
                                        <?php } ?>
                                    </select>
                                </div>  
                            </div>
                        </div>
                        <?php } ?>
                        <?php if(akses::hakKasir() != TRUE AND akses::hakAdmin() != TRUE AND akses::hakAdminM() != TRUE){ ?>
                        <div class="form-group <?php echo (!empty($hasError['harga_beli']) ? 'has-error' : '') ?>">
                            <label class="control-label">Harga Beli (Default)</label>
                            <?php echo form_input(array('id' => 'harga_beli', 'name' => 'harga_beli', 'class' => 'form-control', 'readonly'=>'TRUE', 'value' => $barang->harga_beli)) ?>
                        </div>
                        <?php } ?>
                        <div class="form-group <?php echo (!empty($hasError['harga_jual']) ? 'has-error' : '') ?>">
                            <label class="control-label">Harga Jual (Default)</label>
                            <?php echo form_input(array('id' => 'harga_jual', 'name' => 'harga_jual', 'class' => 'form-control', 'readonly'=>'TRUE', 'value' => $barang->harga_jual)) ?>
                        </div>
                        <div class="form-group ">
                            <label class="control-label">Non Stockable</label><br>
                            <input type="checkbox" name="status_brg_dep" value="1" id="status_brg_dep" <?php echo ($barang->status_brg_dep == '1' ? 'checked="TRUE"' : '') ?>> Aktifkan<br>
                            <i>* Item berupa jasa (tidak mengurangi stok)</i>
                        </div>
                    </div>
                    <div class="box-footer">                        
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" onclick="window.location.href = '<?php echo base_url((isset($_GET['route']) ? 'gudang/data_stok_list' : 'master/data_barang_list').'.php') ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>
                            </div>
                            <div class="col-lg-6 text-right">
                                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
            <?php if(isset($_GET['id'])){ ?>
            <div class="col-lg-4">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Informasi Satuan</h3>
                    </div>
                    <div class="box-body">
                        <?php echo form_open('page=master&act=data_barang_simpan_sat') ?>
                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th class="text-center text-bold">No.</th>
                                    <th class="text-left">Satuan</th>
                                    <th class="text-left">Jml Satuan</th>
                                    <th class="text-left">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($barang_sat as $satuan2) { ?>
                                    <?php echo form_hidden('id_sat[]', $satuan2->id) ?>
                                    <?php $sql_sat_prod = $this->db->where('id_produk', general::dekrip($this->input->get('id')))->where('id_satuan',$satuan2->id)->get('tbl_m_produk_satuan')->row() ?>
                                
                                    <tr>
                                        <td class="text-center text-bold" style="vertical-align: middle;">
                                            <?php echo $no++; ?>
                                        </td>
                                        <td class="text-left" style="vertical-align: middle;"><?php echo ($satuan2->status == '1' ? '<strong>'.strtoupper($satuan2->satuan).'</strong>' : strtoupper($satuan2->satuan)); ?></td>
                                        <td class="text-left" style="vertical-align: middle;"><?php echo form_input(array('id' => 'jml_satuan', 'name' => 'jml_satuan[]', 'class' => 'form-control pull-right', 'value'=>(!empty($sql_sat_prod->jml) ? $sql_sat_prod->jml : (!empty($satuan2->jml) ? $satuan2->jml : '0')))) ?></td>
                                        <td class="text-left" style="vertical-align: middle;">
                                            
                                        </td>
                                    </tr>
                                <?php } ?>
                                    <tr>
                                        <td colspan="3" class="text-right"><button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i></button></td>
                                        <td></td>
                                    </tr>
                            </tbody>
                        </table>
                        <?php echo form_close() ?>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <!--<button type="button" onclick="window.location.href = '<?php echo site_url('page=produk&act=prod_list') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>-->
                            </div>
                            <div class="col-lg-6 text-right">
                                <!--<button type="reset" class="btn btn-default">Batal</button>-->
                                <!--<button type="submit" class="btn btn-info btn-flat">Simpan</button>-->
                            </div>
                        </div>
                    </div>
                </div>        
            </div>
            <div class="col-lg-4">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Informasi Harga Jual</h3>
                    </div>
                    <div class="box-body">
                        <?php echo form_open('page=master&act=data_barang_simpan_hrg') ?>
                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th class="text-center text-bold">No.</th>
                                    <th class="text-left">Satuan</th>
                                    <th class="text-left">Harga</th>
                                    <th class="text-left">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($barang_sat as $satuan2) { ?>
                                    <?php echo form_hidden('id_sat[]', $satuan2->id) ?>
                                    <?php echo form_hidden('id_satm[]', $satuan2->id_satuan) ?>
                                    <?php echo form_hidden('id_prod[]', $satuan2->id_produk) ?>
                                    <?php $sql_sat_prod = $this->db->where('id_produk', general::dekrip($this->input->get('id')))->where('id_satuan',$satuan2->id)->get('tbl_m_produk_satuan')->row() ?>
                                
                                    <tr>
                                        <td class="text-center text-bold" style="vertical-align: middle;"><?php echo $no++; ?></td>
                                        <td class="text-left" style="vertical-align: middle;"><?php echo ($satuan2->status == '1' ? '<strong>'.strtoupper($satuan2->satuan).'</strong>' : strtoupper($satuan2->satuan)); ?></td>
                                        <?php //if($satuan2->satuan == 'LUSIN (SET)'){ ?>
                                            <!--<td class="text-left" style="vertical-align: middle;"><?php echo form_input(array('id' => 'hrg_satuan', 'name' => 'hrg_satuan[]', 'class' => 'form-control pull-right', 'disabled'=>'TRUE', 'value'=>(!empty($sql_sat_prod->harga) ? $sql_sat_prod->harga : (!empty($satuan2->harga) ? $satuan2->harga : '0')))) ?></td>-->
                                        <?php //}else{ ?>
                                            <td class="text-left" style="vertical-align: middle;"><?php echo form_input(array('id' => 'hrg_satuan', 'name' => 'hrg_satuan[]', 'class' => 'form-control pull-right', 'value'=>(!empty($sql_sat_prod->harga) ? $sql_sat_prod->harga : (!empty($satuan2->harga) ? $satuan2->harga : '0')))) ?></td>
                                        <?php //} ?>
                                        <td class="text-left" style="vertical-align: middle;">
                                            <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                                                <?php // echo anchor(base_url('master/data_barang_hapus_sat.php?').'id=' . general::enkrip($produk_sat->id).'&ref='.$this->input->get('id'), '<i class="fa fa-remove"></i>', 'class="text-danger" onclick="return confirm(\'Hapus ?\')"') ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                    <tr>
                                        <td colspan="3" class="text-right"><button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i></button></td>
                                        <td></td>
                                    </tr>
                            </tbody>
                        </table>
                        <?php echo form_close() ?>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <!--<button type="button" onclick="window.location.href = '<?php echo site_url('page=produk&act=prod_list') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>-->
                            </div>
                            <div class="col-lg-6 text-right">
                                <!--<button type="reset" class="btn btn-default">Batal</button>-->
                                <!--<button type="submit" class="btn btn-info btn-flat">Simpan</button>-->
                            </div>
                        </div>
                    </div>
                </div>         
            </div>
            <?php } ?>
        </div>
        <!-- /.row -->
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<style>
    .clicked {
        background-color: #ffff00;
    }
</style>

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
    $("#harga_beli").autoNumeric({aSep: '.', aDec: ',', aPad: false});
    $("#harga_jual").autoNumeric({aSep: '.', aDec: ',', aPad: false});
    $("#harga_jual_pls").autoNumeric({aSep: '.', aDec: ',', aPad: false});
    $("#harga_jual_nom").autoNumeric({aSep: '.', aDec: ',', aPad: false});
    $("#harga_grosir").autoNumeric({aSep: '.', aDec: ',', aPad: false});
    $("[name*='hrg_satuan']").autoNumeric({aSep: '.', aDec: ',', aPad: false});
//
    $("[name*='jml_satuan']").keydown(function (e) {
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
            
    $("#jml_satuan").keydown(function (e) {
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
});
</script>