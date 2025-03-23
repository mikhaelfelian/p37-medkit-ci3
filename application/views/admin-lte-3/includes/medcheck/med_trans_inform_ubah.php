<?php echo form_open_multipart(base_url('medcheck/set_medcheck_inform_upd.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_form', general::enkrip($sql_medc_inf_rw->id)); ?>
<?php echo form_hidden('status', $st_medrep); ?>

<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">MODUL INFORM CONSENT - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <?php echo form_hidden('tipe_surat', $sql_medc_inf_rw->tipe) ?>
                <?php
                switch ($sql_medc_inf_rw->tipe) {

                    # Surat Pernyataan Rawat Inap
                    case '1':
                        ?>
                        <!--SURAT PERNYATAAN-->

                        <div id="inputTglSuratMasuk" class="form-group row <?php // echo (!empty($hasError['tinggi']) ? 'text-danger' : '')                  ?>">
                            <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl Surat</label>
                            <div class="col-sm-9">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                    <?php echo form_input(array('id' => '', 'name' => 'tgl_masuk', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Tgl Surat ...', 'value' => $sql_medc_inf_rw->tgl_simpan)) ?>
                                </div>
                            </div>
                        </div>                                  
                        <div id="inputNm" class="form-group row <?php echo (!empty($hasError['nama']) ? 'text-danger' : '') ?>">
                            <label for="inputTinggi" class="col-sm-3 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-9">
                                <?php echo form_input(array('id' => '', 'name' => 'nama', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Nama Penanggungjawab ...', 'value'=>$sql_medc_inf_rw->nama)) ?>
                            </div>
                        </div>
                        <div id="inputJnsKlm" class="form-group row <?php echo (!empty($hasError['jns_klm']) ? 'text-danger' : '') ?>">
                            <label for="inputJnsKlm" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-9">
                                <select id="jns_klm1" name="jns_klm" class="form-control rounded-0<?php echo (!empty($hasError['jns_klm']) ? 'is-invalid' : '') ?>">
                                    <option value="">- Pilih -</option>
                                    <option value="L"<?php echo ($sql_medc_inf_rw->jns_klm == 'L' ? ' selected' : '') ?>>Laki - laki</option>
                                    <option value="P"<?php echo ($sql_medc_inf_rw->jns_klm == 'P' ? ' selected' : '') ?>>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div id="inputTglSuratMasuk" class="form-group row <?php // echo (!empty($hasError['tinggi']) ? 'text-danger' : '')                  ?>">
                            <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl Lahir</label>
                            <div class="col-sm-9">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                    <?php echo form_input(array('id' => 'tgl_lahir1', 'name' => 'tgl_lahir', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Tgl Lahir ...', 'value'=>$this->tanggalan->tgl_indo2($sql_medc_inf_rw->tgl_lahir))) ?>
                                </div>
                            </div>
                        </div>
                        <div id="inputAddr" class="form-group row <?php echo (!empty($hasError['alamat']) ? 'text-danger' : '') ?>">
                            <label for="inputAddr" class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-9">
                                <?php echo form_textarea(array('id' => 'alamat1', 'name' => 'alamat', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['alamat']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Alamat lengkap ...', 'cols' => '4', 'value'=>$sql_medc_inf_rw->alamat)) ?>
                            </div>
                        </div>
                        <div id="inputHub" class="form-group row <?php echo (!empty($hasError['hubungan']) ? 'text-danger' : '') ?>">
                            <label for="inputBB" class="col-sm-3 col-form-label">Hubungan</label>
                            <div class="col-sm-9">
                                <select id="hubungan1" name="hubungan" class="form-control rounded-0">
                                    <option value="">[Hubungan dengan pasien]</option>
                                    <option value="1"<?php echo ($sql_medc_inf_rw->status_hub == '1' ? ' selected' : '') ?>>Suami</option>
                                    <option value="2"<?php echo ($sql_medc_inf_rw->status_hub == '2' ? ' selected' : '') ?>>Istri</option>
                                    <option value="3"<?php echo ($sql_medc_inf_rw->status_hub == '3' ? ' selected' : '') ?>>Orangtua</option>
                                    <option value="4"<?php echo ($sql_medc_inf_rw->status_hub == '4' ? ' selected' : '') ?>>Anak</option>
                                    <option value="5"<?php echo ($sql_medc_inf_rw->status_hub == '5' ? ' selected' : '') ?>>Keluarga</option>
                                    <option value="6"<?php echo ($sql_medc_inf_rw->status_hub == '6' ? ' selected' : '') ?>>Kerabat</option>
                                    <option value="7"<?php echo ($sql_medc_inf_rw->status_hub == '7' ? ' selected' : '') ?>>Diri Sendiri</option>
                                </select>                          
                            </div>
                        </div>
                        <div id="inputKmr" class="form-group row">
                            <label for="inputTD" class="col-sm-3 col-form-label">Nama Ruang</label>
                            <div class="col-sm-9">
                                <?php echo form_input(array('id' => '', 'name' => 'ruang', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kamar']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Nama Kamar / Ruang Perawatan ...', 'value'=>$sql_medc_inf_rw->ruang)) ?>
                            </div>
                        </div>
                        <div id="inputHub" class="form-group row <?php echo (!empty($hasError['dokter']) ? 'text-danger' : '') ?>">
                            <label for="inputDokter" class="col-sm-3 col-form-label">Dokter</label>
                            <div class="col-sm-9">
                                <select id="dokter1" name="dokter" class="form-control select2bs4 rounded-0<?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                    <option value="">- Dokter -</option>
                                    <?php foreach ($sql_doc as $doctor) { ?>
                                        <option value="<?php echo $doctor->id_user ?>"<?php echo ($doctor->id_user == $sql_medc_inf_rw->id_dokter ? ' selected' : '') ?>><?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . $doctor->nama . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?></option>
                                    <?php } ?>
                                </select>                         
                            </div>
                        </div>
                        <div id="inputJmn" class="form-group row">
                            <label for="inputJmn" class="col-sm-3 col-form-label">Penjamin</label>
                            <div class="col-sm-9">
                                <?php echo form_input(array('id' => '', 'name' => 'penjamin', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['penjamin']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Nama Penjamin (Perusahaan / Asuransi) ...', 'value'=>$sql_medc_inf_rw->penjamin)) ?>
                            </div>
                        </div>
                        <div id="inputTG" class="form-group row">
                            <label for="inputTG" class="col-sm-3 col-form-label">Keterangan</label>
                            <div class="col-sm-9">
                                <?php echo form_input(array('id' => '', 'name' => 'penanggung', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['penanggung']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Nama Penanggung. cth: PT. Mencari Cinta Sejati, Tbk ...', 'value'=>$sql_medc_inf_rw->penanggung)) ?>
                            </div>
                        </div>
                        <?php
                        break;

                    # Surat Persetujuan Medis
                    case '2':
                        ?>
                        <!--SURAT PERNYATAAN TINDAKAN MEDIS-->

                        <div id="inputTglSuratMasuk" class="form-group row <?php // echo (!empty($hasError['tinggi']) ? 'text-danger' : '')                  ?>">
                            <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl Surat</label>
                            <div class="col-sm-9">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                    <?php echo form_input(array('id' => '', 'name' => 'tgl_masuk', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Tgl Surat ...')) ?>
                                </div>
                            </div>
                        </div>                                  
                        <div id="inputNm" class="form-group row <?php echo (!empty($hasError['nama']) ? 'text-danger' : '') ?>">
                            <label for="inputTinggi" class="col-sm-3 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-9">
                                <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Nama Penanggungjawab ...')) ?>
                            </div>
                        </div>
                        <div id="inputJnsKlm" class="form-group row <?php echo (!empty($hasError['jns_klm']) ? 'text-danger' : '') ?>">
                            <label for="inputJnsKlm" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-9">
                                <select id="jns_klm2" name="jns_klm" class="form-control rounded-0<?php echo (!empty($hasError['jns_klm']) ? 'is-invalid' : '') ?>">
                                    <option value="">- Pilih -</option>
                                    <option value="L">Laki - laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div id="inputTglSuratMasuk" class="form-group row <?php // echo (!empty($hasError['tinggi']) ? 'text-danger' : '')                  ?>">
                            <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl Lahir</label>
                            <div class="col-sm-9">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                    <?php echo form_input(array('id' => 'tgl_lahir2', 'name' => 'tgl_lahir', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Tgl Lahir ...')) ?>
                                </div>
                            </div>
                        </div>
                        <div id="inputAddr" class="form-group row <?php echo (!empty($hasError['tindakan']) ? 'text-danger' : '') ?>">
                            <label for="inputAddr" class="col-sm-3 col-form-label">Tindakan Medis</label>
                            <div class="col-sm-9">
                                <?php echo form_textarea(array('id' => '', 'name' => 'tindakan', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['tindakan']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Tindakan ...', 'cols' => '4')) ?>
                            </div>
                        </div>
                        <div id="inputHub" class="form-group row <?php echo (!empty($hasError['hubungan']) ? 'text-danger' : '') ?>">
                            <label for="inputBB" class="col-sm-3 col-form-label">Hubungan</label>
                            <div class="col-sm-9">
                                <select id="hubungan2" name="hubungan" class="form-control rounded-0">
                                    <option value="">[Hubungan dengan pasien]</option>
                                    <option value="1">Suami</option>
                                    <option value="2">Istri</option>
                                    <option value="3">Orangtua</option>
                                    <option value="4">Anak</option>
                                    <option value="5">Keluarga</option>
                                    <option value="6">Kerabat</option>
                                    <option value="7">Diri Sendiri</option>
                                </select>                          
                            </div>
                        </div>
                        <!--
                        <div id="inputJmn" class="form-group row">
                            <label for="inputJmn" class="col-sm-3 col-form-label">Saksi 1</label>
                            <div class="col-sm-9">
                        <?php // echo form_input(array('id' => '', 'name' => 'saksi1', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['saksi1']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Saksi 1 ...')) ?>
                            </div>
                        </div>
                        <div id="inputJmn" class="form-group row">
                            <label for="inputJmn" class="col-sm-3 col-form-label">Saksi 2</label>
                            <div class="col-sm-9">
                        <?php // echo form_input(array('id' => '', 'name' => 'saksi2', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['saksi2']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Saksi 2 ...')) ?>
                            </div>
                        </div>
                        -->
                        <div id="inputHub" class="form-group row <?php echo (!empty($hasError['dokter']) ? 'text-danger' : '') ?>">
                            <label for="inputDokter" class="col-sm-3 col-form-label">Dokter</label>
                            <div class="col-sm-9">
                                <select id="dokter2" name="dokter" class="form-control select2bs4 rounded-0<?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                    <option value="">- Dokter -</option>
                                    <?php foreach ($sql_doc as $doctor) { ?>
                                        <option value="<?php echo $doctor->id_user ?>" <?php echo (!empty($sql_medc_rad_rw->id_dokter_kirim) ? ($doctor->id_user == $sql_medc_rad_rw->id_dokter_kirim ? 'selected' : '') : (($doctor->id == $this->session->flashdata('dokter') ? 'selected' : ''))) ?>><?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . $doctor->nama . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?></option>
                                    <?php } ?>
                                </select>                         
                            </div>
                        </div>
                        <div id="inputStj" class="form-group row <?php echo (!empty($hasError['setuju']) ? 'text-danger' : '') ?>">
                            <label for="inputStj" class="col-sm-3 col-form-label">Persetujuan</label>
                            <div class="col-sm-9">
                                <div class="custom-control custom-radio">
                                    <?php echo form_radio(array('id' => 'customRadio1', 'name' => 'status_stj', 'class' => 'custom-control-input', 'value' => '1')) ?> <label for="customRadio1" class="custom-control-label">SETUJU</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <?php echo form_radio(array('id' => 'customRadio2', 'name' => 'status_stj', 'class' => 'custom-control-input', 'value' => '2')) ?> <label for="customRadio2" class="custom-control-label">TIDAK SETUJU</label>
                                </div>                     
                            </div>
                        </div>
                        <?php
                        break;
                }
                ?>

            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- /.card -->
<?php echo form_close() ?>