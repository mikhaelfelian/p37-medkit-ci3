<?php echo form_open_multipart(base_url('medcheck/set_medcheck_inform.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('status', $st_medrep); ?>

<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">MODUL INFORM CONSENT - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="hasil" class="col-sm-3 col-form-label">Tipe</label>
                    <div class="col-sm-9">
                        <select id="tipe_surat" name="tipe_surat" class="form-control">
                            <option value="">[Tipe Surat]</option>
                            <option value="1">Surat Pernyataan Rawat Inap</option>
                            <option value="2">Surat Persetujuan Medis</option>
                        </select>
                    </div>
                </div>
                <div id="1" class="divSurat">
                    <!--SURAT PERNYATAAN-->

                    <div id="inputTglSuratMasuk" class="form-group row <?php // echo (!empty($hasError['tinggi']) ? 'text-danger' : '')                 ?>">
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
                            <?php echo form_input(array('id' => 'nama1', 'name' => 'nama', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Nama Penanggungjawab ...')) ?>
                        </div>
                    </div>
                    <div id="inputJnsKlm" class="form-group row <?php echo (!empty($hasError['jns_klm']) ? 'text-danger' : '') ?>">
                        <label for="inputJnsKlm" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-9">
                            <select id="jns_klm1" name="jns_klm" class="form-control rounded-0<?php echo (!empty($hasError['jns_klm']) ? 'is-invalid' : '') ?>">
                                <option value="">- Pilih -</option>
                                <option value="L">Laki - laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div id="inputTglSuratMasuk" class="form-group row <?php // echo (!empty($hasError['tinggi']) ? 'text-danger' : '')                 ?>">
                        <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl Lahir</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <?php echo form_input(array('id' => 'tgl_lahir1', 'name' => 'tgl_lahir', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Tgl Lahir ...')) ?>
                            </div>
                        </div>
                    </div>
                    <div id="inputAddr" class="form-group row <?php echo (!empty($hasError['alamat']) ? 'text-danger' : '') ?>">
                        <label for="inputAddr" class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <?php echo form_textarea(array('id' => 'alamat1', 'name' => 'alamat', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['alamat']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Alamat lengkap ...', 'cols' => '4')) ?>
                        </div>
                    </div>
                    <div id="inputHub" class="form-group row <?php echo (!empty($hasError['hubungan']) ? 'text-danger' : '') ?>">
                        <label for="inputBB" class="col-sm-3 col-form-label">Hubungan</label>
                        <div class="col-sm-9">
                            <select id="hubungan1" name="hubungan" class="form-control rounded-0">
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
                    <div id="inputKmr" class="form-group row">
                        <label for="inputTD" class="col-sm-3 col-form-label">Ruang Perawatan</label>
                        <div class="col-sm-9">
                            <?php // echo form_input(array('id' => '', 'name' => 'kamar', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kamar']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Nama Kamar / Ruang Perawatan ...')) ?>
                            <select id="kamar" name="kamar" class="form-control rounded-0<?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                <option value="">- [Ruang Perawatan] -</option>
                                <?php foreach ($sql_kamar->result() as $ruang) { ?>
                                    <option value="<?php echo $ruang->id ?>"><?php echo $ruang->kamar ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div id="inputKmr" class="form-group row">
                        <label for="inputTD" class="col-sm-3 col-form-label">Nama Ruang</label>
                        <div class="col-sm-9">
                            <?php echo form_input(array('id' => '', 'name' => 'ruang', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kamar']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Nama Kamar / Ruang Perawatan ...', 'value' => $sql_medc_inf_rw->ruang)) ?>
                        </div>
                    </div>
                    <div id="inputHub" class="form-group row <?php echo (!empty($hasError['dokter']) ? 'text-danger' : '') ?>">
                        <label for="inputDokter" class="col-sm-3 col-form-label">Dokter</label>
                        <div class="col-sm-9">
                            <select id="dokter1" name="dokter" class="form-control select2bs4 rounded-0<?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                <option value="">- Dokter -</option>
                                <?php foreach ($sql_doc as $doctor) { ?>
                                    <option value="<?php echo $doctor->id_user ?>" <?php echo (!empty($sql_medc_rad_rw->id_dokter_kirim) ? ($doctor->id_user == $sql_medc_rad_rw->id_dokter_kirim ? 'selected' : '') : (($doctor->id == $this->session->flashdata('dokter') ? 'selected' : ''))) ?>><?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . $doctor->nama . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?></option>
                                <?php } ?>
                            </select>                         
                        </div>
                    </div>
                    <div id="inputJmn" class="form-group row">
                        <label for="inputJmn" class="col-sm-3 col-form-label">Penjamin</label>
                        <div class="col-sm-9">
                            <?php echo form_input(array('id' => '', 'name' => 'penjamin', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['penjamin']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Nama Penjamin (Perusahaan / Asuransi) ...')) ?>
                        </div>
                    </div>
                    <div id="inputTG" class="form-group row">
                        <label for="inputTG" class="col-sm-3 col-form-label">Keterangan</label>
                        <div class="col-sm-9">
                            <?php echo form_input(array('id' => '', 'name' => 'penanggung', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['penanggung']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Nama Penanggung. cth: PT. Mencari Cinta Sejati, Tbk ...')) ?>
                        </div>
                    </div>
                </div>                                
                <div id="2" class="divSurat">
                    <!--SURAT PERNYATAAN TINDAKAN MEDIS-->

                    <div id="inputTglSuratMasuk" class="form-group row <?php // echo (!empty($hasError['tinggi']) ? 'text-danger' : '')                 ?>">
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
                    <div id="inputTglSuratMasuk" class="form-group row <?php // echo (!empty($hasError['tinggi']) ? 'text-danger' : '')                 ?>">
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
                </div>                                
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

<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">DATA SURAT</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-left">Dokumen</th>
                            <th class="text-left">Tipe</th>
                            <th class="text-center">#</th>
                        </tr>                                    
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($sql_medc_inf as $surat) { ?>
                            <?php $sql_dokter2 = $this->db->where('id_user', $surat->id_dokter)->get('tbl_m_karyawan')->row(); ?>
                            <tr>
                                <td class="text-center"><?php echo $no . '.'; ?></td>
                                <td class="text-left">
                                    <small><i><?php echo $this->tanggalan->tgl_indo2($surat->tgl_masuk); ?></i></small>
                                    <?php echo br() ?>
                                    <?php echo $surat->no_surat; ?>
                                    <?php if (!empty($sql_dokter2->nama)) { ?>
                                        <?php echo br() ?>
                                        <small><?php echo (!empty($sql_dokter2->nama_dpn) ? $sql_dokter2->nama_dpn . ' ' : '') . $sql_dokter2->nama . (!empty($sql_dokter2->nama_blk) ? ', ' . $sql_dokter2->nama_blk : ''); ?></small>
                                    <?php } ?>                                                       
                                </td>
                                <td class="text-left">
                                    Surat <?php echo general::tipe_surat_inf($surat->tipe); ?>
                                </td>
                                <td class="text-center" style="width: 150px;">                                    
                                    <?php echo anchor(base_url('medcheck/tambah.php?act=inf_ttd&id=' . general::enkrip($sql_medc->id) . '&status=' . $this->input->get('status') . '&id_form=' . general::enkrip($surat->id)), '<i class="fas fa-signature"></i> TTD', 'class="btn btn-warning btn-flat btn-xs" style="width: 55px;"') ?>
                                    <?php if ($surat->status_ttd == '1') { ?>
                                        <?php echo anchor(base_url('medcheck/surat/cetak_pdf_inf.php?id=' . general::enkrip($surat->id) . '&no_nota=' . general::enkrip($surat->id_medcheck) . '&status=' . $this->input->get('status')), '<i class="fas fa-print"></i> Cetak', 'target="_blank" class="btn btn-info btn-flat btn-xs" style="width: 55px;"') ?>
                                    <?php } ?>
                                    <?php echo anchor(base_url('medcheck/tambah.php?act=inf_ubah&id=' . general::enkrip($sql_medc->id) . '&status=' . $this->input->get('status') . '&id_form=' . general::enkrip($surat->id) . '&tipe=' . $surat->tipe), '<i class="fa fa-edit"></i> Ubah', 'class="btn btn-primary btn-flat btn-xs" style="width: 55px;"') ?>
                                    <?php echo anchor(base_url('medcheck/surat/hapus_inform.php?id=' . general::enkrip($surat->id) . '&no_nota=' . general::enkrip($surat->id_medcheck) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $surat->no_surat . '] ?\')" style="width: 55px;"') ?>
                                </td>
                            </tr>
                            <?php $no++ ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->