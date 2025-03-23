<?php if (!empty($sql_produk)) { ?>
    <!-- Default box -->
    <?php echo form_open_multipart(base_url('medcheck/cart_medcheck_resep_upd2.php'), 'autocomplete="off"') ?>
    <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
    <?php echo form_hidden('id_resep', $this->input->get('id_resep')); ?>
    <?php echo form_hidden('id_item_resep', $this->input->get('id_item_resep')); ?>
    <?php echo form_hidden('id_item', general::enkrip($sql_produk->id)); ?>
    <?php echo form_hidden('status', $this->input->get('status')); ?>
    <?php echo form_hidden('act', $this->input->get('act')); ?>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">INSTALASI FARMASI - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?php $hasError = $this->session->flashdata('form_error'); ?>

                    <div class="form-group row <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                        <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo (!empty($sql_produk) ? 'Kode' : 'Item') ?></label>
                        <div class="col-sm-10">
                            <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Kode / Item / Kandungan ...', 'value' => $sql_produk->kode, 'readonly' => 'true')) ?>
                        </div>
                    </div>
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
                            <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control pull-right text-center rounded-0', 'placeholder' => 'Jml ...', 'value' => (float) $sql_medc_res_dt_rw->jml)) ?>
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
                                    <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Harga ...', 'value' => (!empty($sql_produk->harga_jual) ? (float) $sql_produk->harga_jual : ''), 'readonly' => 'true')) ?>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <?php echo form_hidden('harga', $sql_produk->harga_jual); ?>
                    <?php } ?>
                    <?php $dosis_edt = explode(' ', $sql_medc_res_dt_rw->dosis) ?>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Dosis</label>
                        <div class="col-sm-2">
                            <?php echo form_input(array('id' => 'harga', 'name' => 'dos_jml1', 'class' => 'form-control pull-right text-center rounded-0', 'placeholder' => 'Jml ...', 'value' => $dosis_edt[0])) ?>
                        </div>
                        <div class="col-sm-2">
                            <select name="dos_sat" class="form-control rounded-0">
                                <option value="">- Satuan -</option>
                                <?php foreach ($sql_sat_pake as $pake) { ?>
                                    <option value="<?php echo $pake->id ?>" <?php echo ($pake->satuan == $dosis_edt[1] ? 'selected' : '') ?>><?php echo $pake->satuan ?></option>
                                <?php } ?>
                            </select>                            
                        </div>
                        <div class="col-sm-2">
                            <?php echo form_input(array('id' => '', 'name' => 'x', 'class' => 'form-control text-center rounded-0', 'value' => 'Tiap', 'disabled' => 'TRUE')) ?>                           
                        </div>
                        <div class="col-sm-2">
                            <?php echo form_input(array('id' => 'harga', 'name' => 'dos_jml2', 'class' => 'form-control pull-right text-center rounded-0', 'placeholder' => 'Jml ...', 'value' => $dosis_edt[3])) ?>
                        </div>
                        <div class="col-sm-2">                         
                            <select name="dos_wkt" class="form-control rounded-0">
                                <option value="1" <?php echo ($dosis_edt[4] == 'Menit' ? 'selected' : '') ?>>Menit</option>
                                <option value="2" <?php echo ($dosis_edt[4] == 'Jam' ? 'selected' : '') ?>>Jam</option>
                                <option value="3" <?php echo ($dosis_edt[4] == 'Hari' ? 'selected' : '') ?>>Hari</option>
                                <option value="4" <?php echo ($dosis_edt[4] == 'Minggu' ? 'selected' : '') ?>>Minggu</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Aturan</label>
                        <div class="col-sm-10">
                            <?php echo form_input(array('id' => '', 'name' => 'dos_ket', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Isikan Aturan Tambahan. cth : 3x1 Cth ...', 'value' => $sql_medc_res_dt_rw->dosis_ket)) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Cara Minum</label>
                        <div class="col-sm-10">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="status_mkn" value="1" id="customRadio1" class="custom-control-input" <?php echo ($sql_medc_res_dt_rw->status_mkn == '1' ? 'checked' : '') ?>> <label for="customRadio1" class="custom-control-label">Sebelum Makan</label>
                            </div>                          
                            <div class="custom-control custom-radio">
                                <input type="radio" name="status_mkn" value="2" id="customRadio2" class="custom-control-input" <?php echo ($sql_medc_res_dt_rw->status_mkn == '2' ? 'checked' : '') ?>> <label for="customRadio2" class="custom-control-label">Saat Makan</label>
                            </div>                          
                            <div class="custom-control custom-radio">
                                <input type="radio" name="status_mkn" value="3" id="customRadio3" class="custom-control-input" <?php echo ($sql_medc_res_dt_rw->status_mkn == '3' ? 'checked' : '') ?>> <label for="customRadio3" class="custom-control-label">Sesudah Makan</label>
                            </div>                          
                            <div class="custom-control custom-radio">
                                <input type="radio" name="status_mkn" value="4" id="customRadio4" class="custom-control-input" <?php echo ($sql_medc_res_dt_rw->status_mkn == '4' ? 'checked' : '') ?>> <label for="customRadio4" class="custom-control-label">Lain-lain</label>
                            </div>                          
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Catatan</label>
                        <div class="col-sm-10">
                            <?php echo form_input(array('id' => '', 'name' => 'keterangan', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Isikan Catatan ...', 'value' => $sql_medc_res_dt_rw->keterangan)) ?>
                        </div>
                    </div>
                    <?php if (akses::hakDokter() != TRUE) { ?>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tipe</label><br>
                            <div class="col-sm-10">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-light active">
                                        <input type="radio" name="tipe" id="option_a1" autocomplete="off" value="1" <?php echo ($sql_medc_res_dt_rw->status_resep == '1' ? 'checked="TRUE"' : '') ?>>  <i class="fas fa-check text-success"></i>
                                    </label>
                                    <label class="btn btn-light">
                                        <input type="radio" name="tipe" id="option_a2" autocomplete="off" value="2" <?php echo ($sql_medc_res_dt_rw->status_resep == '2' ? 'checked="TRUE"' : '') ?>> <i class="fas fa-edit text-primary"></i>
                                    </label>
                                    <label class="btn btn-light">
                                        <input type="radio" name="tipe" id="option_a3" autocomplete="off" value="3" <?php echo ($sql_medc_res_dt_rw->status_resep == '3' ? 'checked="TRUE"' : '') ?>> <i class="fas fa-xmark text-danger"></i>
                                    </label>
                                </div>
                                <br/>
                                <i>* Status untuk farmasi, diterima, ganti obat / item, dibatalkan</i>
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
                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=4') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                </div>
                <div class="col-lg-6 text-right">
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </div>                            
        </div>
    </div>
    <?php echo form_close(); ?>
    <!-- /.card -->
<?php } ?>

<?php # Item yang terinput di resep di panggil disini ?>
<?php $this->load->view('admin-lte-3/includes/medcheck/med_trans_obat_input_list', $data); ?>