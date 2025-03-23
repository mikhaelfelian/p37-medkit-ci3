<!-- Default box -->
<?php echo form_open_multipart(base_url('medcheck/cart_medcheck_resep_rc.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_resep', $this->input->get('id_resep')); ?>
<?php echo form_hidden('id_resep_det', $this->input->get('item_id')); ?>
<?php echo form_hidden('id_item', $this->input->get('item_id')); ?>
<?php echo form_hidden('id_item_rc', general::enkrip($sql_produk->id)); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>
<?php echo form_hidden('act', $this->input->get('act')); ?>

<div id="card" class="card">
    <div class="card-header">
        <h3 class="card-title">FORM RACIKAN - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <?php $hasError = $this->session->flashdata('form_error'); ?>
                <div class="alert alert-warning alert-dismissible">
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Perhatian !</h5>
                    Halaman ini merupakan form racikan. Untuk menambahkan item racikan, anda tidak perlu klik <b>KEMBALI</b>. 
                    Namun bisa langsung mengisi dari kolom dibawah ini.
                </div>
                <div class="form-group row <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                    <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo (!empty($sql_produk) ? 'Kode' : 'Item') ?></label>
                    <div class="col-sm-10">
                        <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Kode / Item / Kandungan ...', 'value' => $sql_produk->kode)) ?>
                    </div>
                </div>
                <?php if (!empty($sql_produk)) { ?>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Item</label>
                        <div class="col-sm-10">
                            <?php echo form_input(array('id' => 'item', 'name' => 'item', 'class' => 'form-control pull-right rounded-0', 'value' => $sql_produk->produk, 'readonly' => 'true')) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Alias</label>
                        <div class="col-sm-10">
                            <?php echo form_input(array('id' => 'item', 'name' => 'item_alias', 'class' => 'form-control pull-right rounded-0', 'value' => $sql_produk->produk_alias, 'readonly' => 'true')) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Kandungan</label>
                        <div class="col-sm-10">
                            <?php echo form_textarea(array('id' => 'item', 'name' => 'item_kandungan', 'class' => 'form-control pull-right rounded-0', 'rows' => '4', 'value' => strtolower($sql_produk->produk_kand), 'readonly' => 'true')) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Jml</label>
                        <div class="col-sm-2">
                            <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control pull-right text-center rounded-0', 'placeholder' => 'Jml ...', 'value' => '1')) ?>
                        </div>
                        <div class="col-sm-5">

                        </div>
                    </div>
                    <?php if (akses::hakDokter() != TRUE) { ?>
                        <div class="form-group row <?php echo (!empty($hasError['harga']) ? 'text-danger' : '') ?>">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Harga</label>
                            <div class="col-sm-10">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Rp. </span>
                                    </div>
                                    <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['harga']) ? ' is-invalid' : ''), 'placeholder' => 'Harga ...', 'value' => (!empty($sql_produk->harga_jual) ? (float) $sql_produk->harga_jual : ''), 'readonly' => 'true')) ?>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <?php echo form_hidden('harga', general::format_angka($sql_produk->harga_jual)); ?>
                    <?php } ?>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Satuan</label>
                        <div class="col-sm-2">
                            <?php echo form_input(array('id' => 'harga', 'name' => 'dos_jml1', 'class' => 'form-control pull-right text-center rounded-0', 'placeholder' => 'Jml ...')) ?>
                        </div>
                        <div class="col-sm-3">
                            <select name="dos_sat" class="form-control rounded-0">
                                <option value="">- Satuan -</option>
                                <?php foreach ($sql_sat_pake as $pake) { ?>
                                    <option value="<?php echo $pake->id ?>"><?php echo $pake->satuan ?></option>
                                <?php } ?>
                            </select>                            
                        </div>
                        <div class="col-sm-7">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Catatan</label>
                        <div class="col-sm-10">
                            <?php echo form_input(array('id' => '', 'name' => 'dos_ket', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Isikan catatan untuk farmasi ...')) ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tambah.php?act=res_input&id=' . general::enkrip($sql_medc->id) . '&id_resep=' . $this->input->get('id_resep') . '&status=4') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">
                <?php if (!empty($sql_produk)) { ?>
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-save"></i> Simpan</button>
                <?php } ?>
            </div>
        </div>                            
    </div>
</div>
<?php echo form_close(); ?>
<!-- /.card -->

<?php # Item yang terinput di resep di panggil disini ?>
<?php $this->load->view('admin-lte-3/includes/medcheck/med_trans_obat_input_list', $data); ?>