<?php if ($sql_medc_res_rw->status == '1') { ?>
    <?php # Form resep tidak akan muncul ketika status 1, petugas farmasi harus konfirm dahulu     ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">INSTALASI FARMASI - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
        </div>
        <div class="card-body">
            <div class="alert alert-warning alert-dismissible">
                <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan!</h5>
                Resep ini belum di <b>KONFIRMASI</b> oleh petugas farmasi,<br/>
                Silahkan menghubungi bagian farmasi.<br/>
                - Terimakasih -
            </div>
        </div>
    </div>
<?php } elseif ($sql_medc_res_rw->status == '4') { ?>
    <?php # Form resep tidak akan muncul ketika status 4, karena resep sudah di proses oleh petugas  ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">INSTALASI FARMASI - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
        </div>
        <div class="card-body">
            <div class="alert alert-warning alert-dismissible">
                <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan!</h5>
                Resep ini sudah di <b>PROSES</b> oleh petugas farmasi,<br/>
                Silahkan tekan tombol <b>BATALKAN</b> jika ingin membatalkan.<br/>
                - Terimakasih -
            </div>
        </div>
    </div>
<?php } else { ?>
    <!-- Default box -->
    <?php echo form_open(base_url('medcheck/cart_medcheck_resep_upd1.php'), 'id="resep_input_form" autocomplete="off"') ?>
    <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
    <?php echo form_hidden('id_resep', $this->input->get('id_resep')); ?>
    <?php echo form_hidden('id_item', general::enkrip($sql_produk->id)); ?>
    <?php echo form_hidden('status', $this->input->get('status')); ?>
    <?php echo form_hidden('act', $this->input->get('act')); ?>
    <?php 
        if(isset($_GET['id_produk'])){
            echo add_form_protection();
        }
    ?>

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
                            <select id="kode" name="kode" class="form-control select2bs4 rounded-0<?php echo (!empty($hasError['kode']) ? ' is-invalid' : '') ?>" style="width: 100%;">
                                <option value="">-- Pilih Obat --</option>
                                <?php if(!empty($sql_produk->kode)): ?>
                                    <option value="<?php echo $sql_produk->kode ?>" selected><?php echo $sql_produk->kode ?></option>
                                <?php endif; ?>
                            </select>
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
                        <?php // if (akses::hakDokter() != TRUE) { ?>
                        <div class="form-group row <?php echo (!empty($hasError['harga']) ? 'text-danger' : '') ?>">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Harga</label>
                            <div class="col-sm-10">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Rp. </span>
                                    </div>
                                    <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Harga ...', 'value' => (!empty($sql_produk->harga_jual) ? (float) $sql_produk->harga_jual : '0'), 'readonly' => 'true')) ?>
                                </div>
                            </div>
                        </div>
                        <?php // } else { ?>
                        <?php // echo form_hidden('harga', general::format_angka($sql_produk->harga_jual)); ?>
                        <?php // } ?>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Dosis</label>
                            <div class="col-sm-2">
                                <?php echo form_input(array('id' => 'harga', 'name' => 'dos_jml1', 'class' => 'form-control pull-right text-center rounded-0', 'placeholder' => 'Jml ...')) ?>
                            </div>
                            <div class="col-sm-2">
                                <select name="dos_sat" class="form-control rounded-0">
                                    <option value="">- Satuan -</option>
                                    <?php foreach ($sql_sat_pake as $pake) { ?>
                                        <option value="<?php echo $pake->id ?>"><?php echo $pake->satuan ?></option>
                                    <?php } ?>
                                </select>                            
                            </div>
                            <div class="col-sm-2">
                                <?php echo form_input(array('id' => '', 'name' => 'x', 'class' => 'form-control text-center rounded-0', 'value' => 'Tiap', 'disabled' => 'TRUE')) ?>                           
                            </div>
                            <div class="col-sm-2">
                                <?php echo form_input(array('id' => 'harga', 'name' => 'dos_jml2', 'class' => 'form-control pull-right text-center rounded-0', 'placeholder' => 'Jml ...')) ?>
                            </div>
                            <div class="col-sm-2">                         
                                <select name="dos_wkt" class="form-control rounded-0">
                                    <option value="">- Pilih -</option>
                                    <option value="1">Menit</option>
                                    <option value="2">Jam</option>
                                    <option value="3">Hari</option>
                                    <option value="4">Minggu</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Aturan</label>
                            <div class="col-sm-10">
                                <?php echo form_input(array('id' => '', 'name' => 'dos_ket', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Isikan Aturan Tambahan. cth : 3x1 Cth ...')) ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Etiket</label>
                            <div class="col-sm-10">
                                <select id="status_etiket" name="status_etiket" class="form-control rounded-0">
                                    <option value="">- Pilih -</option>
                                    <option value="1">Putih</option>
                                    <option value="2">Biru</option>
                                </select>
                            </div>
                        </div>
                        <div id="1" class="divEtiket">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Cara Minum</label>
                                <div class="col-sm-10">
                                    <div class="custom-control custom-radio">
                                        <?php echo form_radio(array('id' => 'customRadio1', 'name' => 'status_mkn', 'class' => 'custom-control-input', 'value' => '1')) ?> <label for="customRadio1" class="custom-control-label">Sebelum Makan</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <?php echo form_radio(array('id' => 'customRadio2', 'name' => 'status_mkn', 'class' => 'custom-control-input', 'value' => '2')) ?> <label for="customRadio2" class="custom-control-label">Saat Makan</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <?php echo form_radio(array('id' => 'customRadio3', 'name' => 'status_mkn', 'class' => 'custom-control-input', 'value' => '3')) ?> <label for="customRadio3" class="custom-control-label">Sesudah Makan</label>
                                    </div>                            
                                    <div class="custom-control custom-radio">
                                        <?php echo form_radio(array('id' => 'customRadio4', 'name' => 'status_mkn', 'class' => 'custom-control-input', 'value' => '4')) ?> <label for="customRadio4" class="custom-control-label">Lain-lain</label>
                                    </div>                            
                                </div>
                            </div>
                        </div>
                        <div id="2" class="divEtiket"></div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Catatan</label>
                            <div class="col-sm-10">
                                <?php echo form_input(array('id' => '', 'name' => 'keterangan', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Isikan Catatan ...')) ?>
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
                    <?php if (!empty($sql_produk)) { ?>
                        <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-save"></i> Simpan</button>
                    <?php } ?>
                </div>
            </div>                            
        </div>
    </div>
    <?php echo add_double_submit_protection('resep_input_form'); ?>
    <?php echo form_close(); ?>
    <!-- /.card -->
<?php } ?>

<?php # Item yang terinput di resep di panggil disini ?>
<?php $this->load->view('admin-lte-3/includes/medcheck/med_trans_obat_input_list', $data); ?>