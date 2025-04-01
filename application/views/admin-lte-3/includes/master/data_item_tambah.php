<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!--<h1 class="m-0">Master Data</h1>-->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('master/index.php') ?>">Master Data</a>
                        </li>
                        <li class="breadcrumb-item active">Klinik</li>
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
                <div class="col-md-5">
                    <?php echo form_open(base_url('master/data_barang_' . (isset($_GET['id']) ? 'update' : 'simpan') . '.php'), array('autocomplete' => 'off', 'id' => 'item_form')) ?>
                    <?php echo add_form_protection(); ?>
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Data Item</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php $hasError = $this->session->flashdata('form_error'); ?>
                            <?php echo form_hidden('id', $this->input->get('id')) ?>

                            <div class="form-group <?php echo (!empty($hasError['kategori']) ? 'text-danger' : '') ?>">
                                <label class="control-label">Kategori*</label>
                                <select name="kategori"
                                    class="form-control <?php echo (!empty($hasError['kategori']) ? 'is-invalid' : '') ?>">
                                    <option value="">- Pilih -</option>
                                    <?php foreach ($sql_kat as $kat) { ?>
                                        <option value="<?php echo $kat->id ?>" <?php echo ($barang->id_kategori == $kat->id ? 'selected' : '') ?>><?php echo $kat->keterangan ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <?php if ($barang->status == 3) { ?>
                                <!--Jika Item lab kategori bidang akan muncul disini-->
                                <div class="form-group <?php echo (!empty($hasError['kategori']) ? 'text-danger' : '') ?>">
                                    <label class="control-label">Kategori Bidang Lab *</label>
                                    <select name="kategori_lab"
                                        class="form-control <?php echo (!empty($hasError['kategori']) ? 'is-invalid' : '') ?>">
                                        <option value="">- Pilih -</option>
                                        <?php foreach ($sql_kat_lab as $kat_lab) { ?>
                                            <option value="<?php echo $kat_lab->id ?>" <?php echo ($barang->id_kategori_lab == $kat_lab->id ? 'selected' : '') ?>>
                                                <?php echo $kat_lab->keterangan ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } ?>

                            <div class="form-group <?php echo (!empty($hasError['merk']) ? 'text-danger' : '') ?>">
                                <label class="control-label">Merk</label>
                                <select name="merk" class="form-control">
                                    <?php foreach ($sql_merk as $merk) { ?>
                                        <option value="<?php echo $merk->id ?>" <?php echo ($barang->id_merk == $merk->id ? 'selected' : '') ?>><?php echo $merk->merk ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                                <label class="control-label">Kode Item</label>
                                <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'value' => (isset($_GET['id']) ? $barang->kode : $kode))) ?>
                            </div>
                            <div class="form-group <?php echo (!empty($hasError['barcode']) ? 'text-danger' : '') ?>">
                                <label class="control-label">Barcode</label>
                                <?php echo form_input(array('id' => 'barcode', 'name' => 'barcode', 'class' => 'form-control', 'value' => $barang->barcode, 'placeholder' => 'Isikan barcode item jika ada ...')) ?>
                            </div>
                            <div class="form-group <?php echo (!empty($hasError['barang']) ? 'text-danger' : '') ?>">
                                <label class="control-label">Item / Obat*</label>
                                <?php echo form_input(array('id' => 'barang', 'name' => 'barang', 'class' => 'form-control' . (!empty($hasError['barang']) ? ' is-invalid' : ''), 'value' => $barang->produk, 'placeholder' => 'Isikan nama item / obat / jasa dll ...')) ?>
                            </div>
                            <div class="form-group <?php echo (!empty($hasError['satBsr']) ? 'text-danger' : '') ?>">
                                <label class="control-label">Alias</label>
                                <?php echo form_input(array('id' => 'barang', 'name' => 'barang_alias', 'class' => 'form-control', 'value' => $barang->produk_alias, 'placeholder' => 'Isikan nama merk (khusus obat) ...')) ?>
                            </div>
                            <div class="form-group <?php echo (!empty($hasError['satBsr']) ? 'text-danger' : '') ?>">
                                <label class="control-label">Kandungan <small><i>* Gunakan "," (koma) untuk pemisah. Cth
                                            : Vit C,Amoxicillin</i></small></label>
                                <?php echo form_input(array('id' => 'barang', 'name' => 'barang_kand', 'class' => 'form-control', 'value' => $barang->produk_kand, 'placeholder' => 'Isikan nama kandungan (khusus obat) ...')) ?>
                            </div>
                            <?php if (akses::hakKasir() != TRUE) { ?>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div
                                            class="form-group <?php echo (!empty($hasError['jml']) ? 'text-danger' : '') ?>">
                                            <label class="control-label">Stok</label>
                                            <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control', 'value' => (!empty($barang->jml) ? $barang->jml : '(Default)'), 'readonly' => 'TRUE')) ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div
                                            class="form-group <?php echo (!empty($hasError['jml']) ? 'text-danger' : '') ?>">
                                            <label class="control-label">Satuan</label>
                                            <select name="satuan" class="form-control">
                                                <option value="">- Pilih -</option>
                                                <?php foreach ($sql_satuan as $satuan) { ?>
                                                    <option value="<?php echo $satuan->id ?>" <?php echo ($barang->id_satuan == $satuan->id ? 'selected' : '') ?>>
                                                        <?php echo $satuan->satuanTerkecil; //.' ('.$satuan->satuanBesar.')('.$satuan->jml.')'               ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (akses::hakSA() == TRUE or akses::hakOwner() == TRUE or akses::hakOwner2() == TRUE or akses::hakAdminM() == TRUE or akses::hakAdmin() == TRUE) { ?>
                                <div
                                    class="form-group <?php echo (!empty($hasError['harga_beli']) ? 'text-danger' : '') ?>">
                                    <label class="control-label">Harga Beli (Default)</label>
                                    <?php echo form_input(array('id' => 'harga', 'name' => 'harga_beli', 'class' => 'form-control', 'value' => $barang->harga_beli)) ?>
                                </div>
                            <?php } ?>
                            <?php if (akses::hakSA() == TRUE or akses::hakOwner() == TRUE or akses::hakOwner2() == TRUE or akses::hakAdminM() == TRUE or akses::hakAdmin() == TRUE) { ?>
                                <div
                                    class="form-group <?php echo (!empty($hasError['harga_jual']) ? 'text-danger' : '') ?>">
                                    <label class="control-label">Harga Jual (Default)</label>
                                    <?php echo form_input(array('id' => 'harga', 'name' => 'harga_jual', 'class' => 'form-control', 'value' => $barang->harga_jual)) ?>
                                </div>
                                <div
                                    class="form-group <?php echo (!empty($hasError['harga_jual_het']) ? 'text-danger' : '') ?>">
                                    <label class="control-label">Harga HET</label>
                                    <?php echo form_input(array('id' => 'harga', 'name' => 'harga_jual_het', 'class' => 'form-control', 'value' => $barang->harga_jual_het)) ?>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4"><label class="control-label">Remunerasi</label></div>
                                    <div class="col-lg-2"><label class="control-label">%</label></div>
                                    <div class="col-lg-6"><label class="control-label">Rp</label></div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <select name="remun_tipe" class="form-control">
                                                <option value="">[Tipe]</option>
                                                <option value="1" <?php echo ($barang->remun_tipe == '1' ? 'selected' : ''); ?>>Persen</option>
                                                <option value="2" <?php echo ($barang->remun_tipe == '2' ? 'selected' : ''); ?>>Nominal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <?php echo form_input(array('id' => 'remun_perc', 'name' => 'remun_perc', 'class' => 'form-control text-center', 'value' => (!empty($barang->remun_perc) ? (float) $barang->remun_perc : '0'))) ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <?php echo form_input(array('id' => 'remun_nom', 'name' => 'remun_nom', 'class' => 'form-control text-left', 'value' => (!empty($barang->remun_nom) ? (float) $barang->remun_nom : '0'))) ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4"><label class="control-label">Apresiasi</label></div>
                                    <div class="col-lg-2"><label class="control-label">%</label></div>
                                    <div class="col-lg-6"><label class="control-label">Rp</label></div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <select name="apres_tipe" class="form-control">
                                                <option value="">[Tipe]</option>
                                                <option value="1" <?php echo ($barang->apres_tipe == '1' ? 'selected' : ''); ?>>Persen</option>
                                                <option value="2" <?php echo ($barang->apres_tipe == '2' ? 'selected' : ''); ?>>Nominal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <?php echo form_input(array('id' => 'apres_perc', 'name' => 'apres_perc', 'class' => 'form-control text-center', 'value' => (!empty($barang->apres_perc) ? (float) $barang->apres_perc : '0'))) ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <?php echo form_input(array('id' => 'apres_nom', 'name' => 'apres_nom', 'class' => 'form-control text-left', 'value' => (!empty($barang->apres_nom) ? (float) $barang->apres_nom : '0'))) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="form-group ">
                                <label class="control-label">Stockable</label><br>
                                <input type="checkbox" name="status_subt" value="1" id="status_subt" <?php echo ($barang->status_subt == '1' ? 'checked="TRUE"' : '') ?>> Aktifkan<br>
                                <i>* Jika di centang maka akan mengurangi stok.</i>
                            </div>
                            <div class="form-group ">
                                <label class="control-label">Tipe Racikan</label><br>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-secondary active">
                                        <input type="radio" name="tipe_racikan" id="option_a1" autocomplete="off"
                                            value="0" <?php echo ($barang->status_racikan == '0' ? 'checked="TRUE"' : '') ?>> Non
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="tipe_racikan" id="option_a2" autocomplete="off"
                                            value="1" <?php echo ($barang->status_racikan == '1' ? 'checked="TRUE"' : '') ?>> Racikan
                                    </label>
                                </div>
                                <br />
                                <i>* Tipe Item untuk barang, lab, tindakan, radiologi</i>
                            </div>
                            <div class="form-group ">
                                <label class="control-label">Tipe</label><br>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-secondary active">
                                        <input type="radio" name="tipe" id="option_a1" autocomplete="off" value="2"
                                            <?php echo ($barang->status == '2' ? 'checked="TRUE"' : '') ?>> Tind
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="tipe" id="option_a2" autocomplete="off" value="3"
                                            <?php echo ($barang->status == '3' ? 'checked="TRUE"' : '') ?>> Lab
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="tipe" id="option_a3" autocomplete="off" value="4"
                                            <?php echo ($barang->status == '4' ? 'checked="TRUE"' : '') ?>> Obat
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="tipe" id="option_a3" autocomplete="off" value="5"
                                            <?php echo ($barang->status == '5' ? 'checked="TRUE"' : '') ?>> Rad
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="tipe" id="option_a3" autocomplete="off" value="6"
                                            <?php echo ($barang->status == '6' ? 'checked="TRUE"' : '') ?>> BHP
                                    </label>
                                </div>
                                <br />
                                <i>* Tipe Item untuk barang, lab, tindakan, radiologi</i>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">

                                </div>
                                <div class="col-lg-6 text-right">
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i>
                                        Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo add_double_submit_protection('item_form'); ?>
                    <?php echo form_close() ?>
                </div>
                <?php if (!empty($barang)) { ?>
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#item-ref" data-toggle="tab"><i
                                                class="fas fa-layer-group fa-solid fa-sharp"></i> Item Referensi</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#item-ref-input" data-toggle="tab"><i
                                                class="fa-solid fa-vials"></i> Item Lab Input</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="item-ref">
                                        <?php $hasError = $this->session->flashdata('form_error'); ?>
                                        <?php echo form_open(base_url('master/data_barang_simpan_bom.php'), 'autocomplete="off" id="item_ref_form"') ?>
                                        <?php echo add_form_protection(); ?>
                                        <input type="hidden" id="id" name="id" value="<?php echo general::enkrip($barang->id) ?>">
                                        <input type="hidden" id="item_id" name="item_id" value="<?php echo $this->input->get('id_item_lab') ?>">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group <?php echo (!empty($hasError['kode']) ? 'has-error' : '') ?>">
                                                    <label for="inputEmail3" class="control-label">Kode <span class="text-danger">*</span></label>
                                                    <?php echo form_input(array('id' => 'item_kd', 'name' => 'kode', 'class' => 'form-control pull-right'.(!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Kode ...', 'value' => $barang_bom_rw->kode)) ?>
                                                </div>
                                                <div class="form-group <?php echo (!empty($hasError['item']) ? 'has-error' : '') ?>">
                                                    <label for="inputEmail3" class="control-label">Item <span class="text-danger">*</span></label>
                                                    <?php echo form_input(array('id' => 'item_lab', 'name' => 'item', 'class' => 'form-control pull-right'.(!empty($hasError['item']) ? ' is-invalid' : ''), 'placeholder' => 'Item ...', 'value' => $barang_bom_rw->produk, 'readonly' => 'TRUE')) ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="control-label">Jml</label>
                                                    <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control pull-right', 'placeholder' => 'Jml ...', 'value' => 1)) ?>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="control-label">Harga</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control pull-right', 'placeholder' => 'Harga ...', 'value' => (float) $barang_bom_rw->harga_jual)) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-right">
                                                <button type="submit" class="btn btn-primary btn-flat pull-right"><i class="fa fa-save"></i> Simpan</button>
                                            </div>
                                        </div>
                                        <?php echo add_double_submit_protection('item_ref_form'); ?>
                                        <?php echo form_close() ?>
                                        <hr />
                                        <table class="table table-condensed">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No.</th>
                                                    <th>Item</th>
                                                    <th class="text-center" colspan="2">Jml</th>
                                                    <th class="text-right">Harga</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($barang_bom_rs)) {
                                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                                    foreach ($barang_bom_rs as $barang) {
                                                        $sql_tipe   = $this->db->where('id', $barang->id_grup)->get('tbl_m_pelanggan_grup')->row();
                                                        $sql_satuan = $this->db->where('id', $barang->id_satuan)->get('tbl_m_satuan')->row();
                                                        $sql_kat    = $this->db->where('id', $barang->id_kategori)->get('tbl_m_kategori')->row();
                                                        $sql_mrk    = $this->db->where('id', $barang->id_merk)->get('tbl_m_merk')->row();
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                                            <td class="text-left" style="width: 200px;"><?php echo $barang->item ?>
                                                            </td>
                                                            <td class="text-right" style="width: 25px;">
                                                                <?php echo (float) $barang->jml ?></td>
                                                            <td class="text-left" style="width: 50px;"><?php echo $barang->satuan ?>
                                                            </td>
                                                            <td class="text-right" style="width: 100px;">
                                                                <?php echo general::format_angka($barang->harga) ?></td>
                                                            <td>
                                                                <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE) { ?>
                                                                    <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE) { ?>
                                                                        <?php echo anchor(base_url('master/data_barang_hapus_ref.php?id=' . general::enkrip($barang->id) . '&ref=' . $this->input->get('id') . '#item-ref'), '<i class="fas fa-trash"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $barang->item . '] ? \')" class="btn btn-danger btn-flat btn-xs" style="width: 55px;"') ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="item-ref-input">
                                        <?php $hasError = $this->session->flashdata('form_error'); ?>
                                        <?php echo form_open(base_url('master/data_barang_' . (!empty($barang_bom_ip2) ? 'update' : 'simpan') . '_bom_input.php'), 'autocomplete="off" id="item_ref_input_form"') ?>
                                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                                        <?php echo form_hidden('item_id', general::enkrip($barang_bom_ip2->id)) ?>
                                        <?php echo add_form_protection(); ?>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group <?php echo (!empty($hasError['item_periksa']) ? 'has-error' : '') ?>">
                                                    <label for="inputEmail3" class="control-label">Item Pemeriksaan <span class="text-danger">*</span></label>
                                                    <?php echo form_input(array('id' => 'item_periksa', 'name' => 'item_periksa', 'class' => 'form-control pull-right'.(!empty($hasError['item_periksa']) ? ' is-invalid' : ''), 'placeholder' => 'Item Pemeriksaan ...', 'value' => $barang_bom_ip2->item_name)) ?>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="control-label">Nilai</label>
                                                    <?php echo form_input(array('id' => 'item_nilai', 'name' => 'item_nilai', 'class' => 'form-control pull-right', 'placeholder' => 'Nilai Default ...', 'value' => $barang_bom_ip2->item_value)) ?>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="control-label">Satuan</label>
                                                    <?php echo form_input(array('id' => 'item_satuan', 'name' => 'item_satuan', 'class' => 'form-control pull-right', 'placeholder' => 'Nilai Satuan ...', 'value' => $barang_bom_ip2->item_satuan)) ?>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="control-label">Nilai L 1</label>
                                                    <?php echo form_input(array('id' => '', 'name' => 'item_value_11', 'class' => 'form-control pull-right', 'placeholder' => 'N. Laki Dws ...', 'value' => $barang_bom_ip2->item_value_l1)) ?>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="control-label">Nilai L 2</label>
                                                    <?php echo form_input(array('id' => '', 'name' => 'item_value_12', 'class' => 'form-control pull-right', 'placeholder' => 'N. Laki Ank ...', 'value' => $barang_bom_ip2->item_value_l2)) ?>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="control-label">Nilai P 1</label>
                                                    <?php echo form_input(array('id' => '', 'name' => 'item_value_p1', 'class' => 'form-control pull-right', 'placeholder' => 'N. Perempuan Dws ...', 'value' => $barang_bom_ip2->item_value_p1)) ?>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="control-label">Nilai P 2</label>
                                                    <?php echo form_input(array('id' => '', 'name' => 'item_value_p2', 'class' => 'form-control pull-right', 'placeholder' => 'N. Perempuan Ank ...', 'value' => $barang_bom_ip2->item_value_p2)) ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-right">
                                                <button type="submit" class="btn btn-primary btn-flat pull-right"><i
                                                        class="fa fa-save"></i> Simpan</button>
                                            </div>
                                        </div>
                                        <?php echo add_double_submit_protection('item_ref_input_form'); ?>
                                        <?php echo form_close() ?>
                                        <hr />
                                        <table class="table table-condensed">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No.</th>
                                                    <th>Item Pemeriksaan</th>
                                                    <th>Nilai Default</th>
                                                    <th>Satuan</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($barang_bom_ip)) {
                                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                                    foreach ($barang_bom_ip as $item) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                                            <td class="text-left" style="width: 200px;">
                                                                <?php echo $item->item_name . br() ?>
                                                                <?php if (!empty($item->item_value_l1) or !empty($item->item_value_p1) or !empty($item->item_value_l2) or !empty($item->item_value_p2)) { ?>
                                                                    <small>* Laki-laki Dewasa</small><br />
                                                                    <small>* Laki-laki Anak</small><br />
                                                                    <small>* Perempuan Dewasa</small><br />
                                                                    <small>* Perempuan Anak</small><br />
                                                                <?php } ?>
                                                            </td>
                                                            <td class="text-left" style="width: 200px;">
                                                                <?php echo $item->item_value . br() ?>
                                                                <?php if (!empty($item->item_value_l1) or !empty($item->item_value_p1) or !empty($item->item_value_l2) or !empty($item->item_value_p2)) { ?>
                                                                    <small><?php echo $item->item_value_l1 ?></small><br />
                                                                    <small><?php echo $item->item_value_l2 ?></small><br />
                                                                    <small><?php echo $item->item_value_p1 ?></small><br />
                                                                    <small><?php echo $item->item_value_p2 ?></small><br />
                                                                <?php } ?>
                                                            </td>
                                                            <td class="text-left" style="width: 200px;">
                                                                <?php echo $item->item_satuan ?></td>
                                                            <td>
                                                                <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE) { ?>
                                                                    <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE) { ?>
                                                                        <?php echo anchor(base_url('master/data_barang_tambah.php?id=' . $this->input->get('id') . '&ref=' . general::enkrip($item->id) . '#item-ref-input'), '<i class="fas fa-edit"></i> Ubah', 'class="btn btn-primary btn-flat btn-xs" style="width: 55px;"') ?>
                                                                        <?php echo anchor(base_url('master/data_barang_hapus_ref_ip.php?id=' . general::enkrip($item->id) . '&ref=' . $this->input->get('id') . '#item-ref-input'), '<i class="fas fa-trash"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $item->item_name . '] ? \')" class="btn btn-danger btn-flat btn-xs" style="width: 55px;"') ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
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
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        var aidi = "<?php echo $this->input->get('id') ?>";
        var url = window.location.href;
        var activeTab = url.substring(url.indexOf("#") + 1);

        // Autoactive tabbed jquery
        $('a[href="#' + activeTab + '"]').tab('show');

        // Autonumber Item Refrensi
        $("input[id=harga]").autoNumeric({ aSep: '.', aDec: ',', aPad: false });

        <?php if (akses::hakSA() == TRUE or akses::hakOwner() == TRUE or akses::hakOwner2() == TRUE or akses::hakAdminM() == TRUE or akses::hakAdmin() == TRUE) { ?>
            // Harga Remun
            $("input[id=remun_perc]").autoNumeric({ aSep: '.', aDec: ',', aPad: false });
            $("input[id=remun_nom]").autoNumeric({ aSep: '.', aDec: ',', aPad: false });

            //            // Tipe Remunerasi
            //            $("input[id=remun_perc]").keyup(function () {
            //                var harga       = $('input[name=harga_jual]').val().replace(/[.]/g, "");
            //                var rem_nom     = $('input[id=remun_nom]').val().replace(/[.]/g, "");
            //                var rem_persen  = $('input[id=remun_perc]').val().replace(/[.]/g, "");
            //                var remun       = (parseInt(rem_persen) / 100) * parseFloat(harga);
            //
            //                $('input[id=remun_nom]').val(Math.round(remun)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
            //            });

            //            $("input[id=remun_nom]").keyup(function () {
            //                var harga       = $('input[name=harga_jual]').val().replace(/[.]/g, "");
            //                var rem_nom     = $('input[id=remun_nom]').val().replace(/[.]/g, "");
            //                var rem_persen  = $('input[id=remun_perc]').val().replace(/[.]/g, "");
            //                var remun       = (parseInt(rem_nom) / parseFloat(harga)) * 100;
            //
            //                $('input[id=remun_perc]').val(Math.round(remun)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
            //            });
        <?php } ?>

        // Data Item Cart
        $('#item_kd').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('master/json_item.php') ?>",
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
                $('#item_id').val(ui.item.id);
                $('#item_kd').val(ui.item.kode);
                window.location.href = "<?php echo base_url('master/data_barang_tambah.php?id=' . $this->input->get('id')) ?>&id_item_lab=" + ui.item.id;

                // Give focus to the next input field to recieve input from user
                $('#item_jml').focus();
                return false;
            }

            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                .data("item.autocomplete", item)
                .append("<a>" + item.name + "</a>")
                .appendTo(ul);
        };
    });
</script>