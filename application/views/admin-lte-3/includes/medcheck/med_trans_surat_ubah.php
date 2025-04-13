<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Medical Checkup</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('medcheck/index.php') ?>">Medical
                                Checkup</a></li>
                        <li class="breadcrumb-item active">Administrasi</li>
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
                <div class="col-lg-8">
                    <?php $tipe_surat = $this->input->get('tipe'); ?>
                    <?php echo form_open_multipart(base_url('medcheck/set_medcheck_surat_upd.php'), 'autocomplete="off"') ?>
                    <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                    <?php echo form_hidden('id_surat', general::enkrip($sql_medc_srt_dt->id)); ?>
                    <?php echo form_hidden('status', $st_medrep); ?>
                    <?php echo form_hidden('tipe_surat', $tipe_surat); ?>

                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">[UBAH] MODUL SURAT KETERANGAN - <?php echo $sql_pasien->nama_pgl; ?>
                                <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <?php
                                    switch ($tipe_surat) {
                                        case '1':
                                            ?>
                                            <div id="1" class="divSurat">
                                                <!--SURAT SEHAT-->

                                                <div id="inputTglSuratMasuk"
                                                    class="form-group row <?php // echo (!empty($hasError['tinggi']) ? 'text-danger' : '')                   ?>">
                                                    <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl
                                                        Surat</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                            <?php echo form_input(array('id' => 'tgl_masuk_sht', 'name' => 'tgl_masuk', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Tgl Surat ...', 'value' => $this->tanggalan->tgl_indo($sql_medc_srt_dt->tgl_masuk))) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="inputTB"
                                                    class="form-group row <?php echo (!empty($hasError['tinggi']) ? 'text-danger' : '') ?>">
                                                    <label for="inputTinggi" class="col-sm-3 col-form-label">Tinggi</label>
                                                    <div class="col-sm-3">
                                                        <?php echo form_input(array('id' => 'angka', 'name' => 'tb', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Tinggi ...', 'value' => (float) $sql_medc_srt_dt->tb)) ?>
                                                    </div>
                                                    <label for="satuanTinggi" class="col-sm-6 col-form-label">cm</label>
                                                </div>
                                                <div id="inputTD"
                                                    class="form-group row <?php echo (!empty($hasError['darah']) ? 'text-danger' : '') ?>">
                                                    <label for="inputTD" class="col-sm-3 col-form-label">Tekanan Darah</label>
                                                    <div class="col-sm-3">
                                                        <?php echo form_input(array('id' => '', 'name' => 'td', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Tekanan ...', 'value' => (float) $sql_medc_srt_dt->td)) ?>
                                                    </div>
                                                    <label for="satuanTD" class="col-sm-6 col-form-label">mmHg</label>
                                                </div>
                                                <div id="inputBB"
                                                    class="form-group row <?php echo (!empty($hasError['berat']) ? 'text-danger' : '') ?>">
                                                    <label for="inputBB" class="col-sm-3 col-form-label">Berat Badan</label>
                                                    <div class="col-sm-3">
                                                        <?php echo form_input(array('id' => 'angka', 'name' => 'bb', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'BB ...', 'value' => (float) $sql_medc_srt_dt->bb)) ?>
                                                    </div>
                                                    <label for="satuanBB" class="col-sm-6 col-form-label">Kg</label>
                                                </div>
                                                <div id="inputBW"
                                                    class="form-group row <?php echo (!empty($hasError['hasil']) ? 'text-danger' : '') ?>">
                                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Buta Warna</label>
                                                    <div class="col-sm-9">
                                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                            <label class="btn btn-secondary active">
                                                                <input type="radio" name="bw" id="option_a1" autocomplete="off"
                                                                    value="1" <?php echo ($sql_medc_srt_dt->bw == '+' ? 'checked="TRUE"' : '') ?>> +
                                                            </label>
                                                            <label class="btn btn-secondary">
                                                                <input type="radio" name="bw" id="option_a2" autocomplete="off"
                                                                    value="0" <?php echo ($sql_medc_srt_dt->bw == '-' ? 'checked="TRUE"' : '') ?>> -
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="inputTD" class="form-group row">
                                                    <label for="inputTD" class="col-sm-3 col-form-label"></label>
                                                    <div class="col-sm-9">
                                                        <?php echo form_input(array('id' => '', 'name' => 'bw_ket', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Ket. Buta Warna ...', 'value' => $sql_medc_srt_dt->bw_ket)) ?>
                                                    </div>
                                                </div>
                                                <div id="inputHasil"
                                                    class="form-group row <?php echo (!empty($hasError['hasil']) ? 'text-danger' : '') ?>">
                                                    <label for="hasil" class="col-sm-3 col-form-label">Hasil</label>
                                                    <div class="col-sm-9">
                                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                            <label class="btn btn-secondary active">
                                                                <input type="radio" name="hasil" id="option_a1"
                                                                    autocomplete="off" value="1"> Sehat
                                                            </label>
                                                            <label class="btn btn-secondary">
                                                                <input type="radio" name="hasil" id="option_a2"
                                                                    autocomplete="off" value="0"> Tidak Sehat
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            break;

                                        case '2':
                                            ?>
                                            <div id="2" class="divSurat">
                                                <!--SURAT SAKIT-->

                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl
                                                        Surat</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                            <?php echo form_input(array('id' => 'tgl_masuk_skt', 'name' => 'tgl_masuk', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Tgl Surat ...', 'value' => $this->tanggalan->tgl_indo($sql_medc_srt_dt->tgl_masuk))) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Tgl Surat Sembuh-->
                                                <div id="inputTglSuratKeluar" class="form-group row">
                                                    <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl
                                                        Sembuh</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                            <?php echo form_input(array('id' => 'tgl_keluar_skt', 'name' => 'tgl_keluar', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Tgl Sembuh ...', 'value' => $this->tanggalan->tgl_indo($sql_medc_srt_dt->tgl_keluar))) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Tgl Surat Sembuh-->
                                                <div id="inputTglSuratKontol"
                                                    class="form-group row <?php // echo (!empty($hasError['tinggi']) ? 'text-danger' : '')                  ?>">
                                                    <label for="inputSembuh" class="col-sm-3 col-form-label">atau s/d
                                                        Sembuh</label>
                                                    <div class="col-sm-9">
                                                        <?php echo form_checkbox(array('id' => 'ckSembuh', 'class' => 'form-controller', 'name' => 'sembuh', 'value' => '1')) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            break;

                                        case '3':
                                            ?>
                                            <div id="3" class="divSurat">
                                                <!--SURAT RAWAT INAP-->

                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl
                                                        Masuk</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                            <?php echo form_input(array('id' => 'tgl_masuk_rnp', 'name' => 'tgl_masuk', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Tgl Surat ...', 'value' => $this->tanggalan->tgl_indo($sql_medc_srt_dt->tgl_masuk))) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Tgl Surat Sembuh-->
                                                <div id="inputTglSuratKeluar"
                                                    class="form-group row <?php // echo (!empty($hasError['tinggi']) ? 'text-danger' : '')           ?>">
                                                    <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl
                                                        Sembuh</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                            <?php echo form_input(array('id' => 'tgl_keluar_rnp', 'name' => 'tgl_keluar', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Tgl Sembuh ...', 'value' => $this->tanggalan->tgl_indo($sql_medc_srt_dt->tgl_keluar))) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Tgl Surat Sembuh-->
                                                <div id="inputTglSuratKontol"
                                                    class="form-group row <?php // echo (!empty($hasError['tinggi']) ? 'text-danger' : '')           ?>">
                                                    <label for="inputSembuh" class="col-sm-3 col-form-label">atau s/d
                                                        Sembuh</label>
                                                    <div class="col-sm-9">
                                                        <?php echo form_checkbox(array('id' => 'ckSembuh', 'class' => 'form-controller', 'name' => 'sembuh', 'value' => '1')) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            break;

                                        case '4':
                                            ?>
                                            <div id="4" class="divSurat">
                                                <!--SURAT KONTROL-->

                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglKontol" class="col-sm-3 col-form-label">Tgl
                                                        Kontrol</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                            <?php echo form_input(array('id' => 'tgl_masuk_kntl', 'name' => 'tgl_kontrol', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Tgl Surat ...', 'value' => $this->tanggalan->tgl_indo($sql_medc_srt_dt->tgl_masuk))) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            break;

                                        case '5':
                                            ?>
                                            <div id="5" class="divSurat">
                                                <!--SURAT KELAHIRAN-->

                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglKontol" class="col-sm-3 col-form-label">Tgl
                                                        Lahir</label>
                                                    <div class="col-sm-4">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                            <?php echo form_input(array('id' => 'lahir_tgl', 'name' => 'tgl_lahir', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Tgl Surat ...', 'value' => $this->tanggalan->tgl_indo($sql_medc_srt_dt->lahir_tgl))) ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-clock"></i></span>
                                                            </div>
                                                            <input type="time" name="wkt_lahir" class="form-control"
                                                                value="<?php echo $this->tanggalan->wkt_indo($sql_medc_srt_dt->lahir_tgl) ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglKontol" class="col-sm-3 col-form-label">Nama
                                                        Lahir</label>
                                                    <div class="col-sm-9">
                                                        <?php echo form_input(array('id' => '', 'name' => 'nm_lahir', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Nama Lahir...', 'value' => $sql_medc_srt_dt->lahir_nm)) ?>
                                                    </div>
                                                </div>
                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglKontol" class="col-sm-3 col-form-label">Jenis
                                                        Kelamin</label>
                                                    <div class="col-sm-9">
                                                        <select name="jns_klm"
                                                            class="form-control <?php echo (!empty($hasError['jns_klm']) ? 'is-invalid' : '') ?>">
                                                            <option value="">- Pilih -</option>
                                                            <option value="L" <?php echo ($sql_medc_srt_dt->jns_klm == 'L' ? 'selected' : '') ?>>Laki - laki</option>
                                                            <option value="P" <?php echo ($sql_medc_srt_dt->jns_klm == 'P' ? 'selected' : '') ?>>Perempuan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglKontol" class="col-sm-3 col-form-label">Nama
                                                        Ayah</label>
                                                    <div class="col-sm-9">
                                                        <?php echo form_input(array('id' => '', 'name' => 'nm_ayah', 'class' => 'form-control text-middle', 'style' => 'vertical-align: middle;', 'placeholder' => 'Nama Ayah...', 'value' => $sql_medc_srt_dt->lahir_nm_ayah)) ?>
                                                    </div>
                                                </div>
                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglKontol" class="col-sm-3 col-form-label">Nama Ibu</label>
                                                    <div class="col-sm-9">
                                                        <?php echo form_input(array('id' => '', 'name' => 'nm_ibu', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Nama Ibu...', 'value' => $sql_medc_srt_dt->lahir_nm_ibu)) ?>
                                                    </div>
                                                </div>
                                                <div id="inputTB"
                                                    class="form-group row <?php echo (!empty($hasError['tinggi']) ? 'text-danger' : '') ?>">
                                                    <label for="inputTinggi" class="col-sm-3 col-form-label">Panjang</label>
                                                    <div class="col-sm-3">
                                                        <?php echo form_input(array('id' => 'angka', 'name' => 'tb', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Panjang ...', 'value' => (float) $sql_medc_srt_dt->tb)) ?>
                                                    </div>
                                                    <label for="satuanTinggi" class="col-sm-6 col-form-label">cm</label>
                                                </div>
                                                <div id="inputBB"
                                                    class="form-group row <?php echo (!empty($hasError['berat']) ? 'text-danger' : '') ?>">
                                                    <label for="inputBB" class="col-sm-3 col-form-label">Berat Lahir</label>
                                                    <div class="col-sm-3">
                                                        <?php echo form_input(array('id' => 'angka', 'name' => 'bb', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'BB ...', 'value' => (float) $sql_medc_srt_dt->bb)) ?>
                                                    </div>
                                                    <label for="satuanBB" class="col-sm-6 col-form-label">Kg</label>
                                                </div>
                                            </div>
                                            <?php
                                            break;

                                        case '6':
                                            ?>
                                            <div id="6" class="divSurat">
                                                <!--SURAT KEMODARAN-->

                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglKontol" class="col-sm-3 col-form-label">Tgl &
                                                        Waktu</label>
                                                    <div class="col-sm-4">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                            <?php echo form_input(array('id' => 'mati_tgl', 'name' => 'mati_tgl', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Tgl ...', 'value' => $this->tanggalan->tgl_indo($sql_medc_srt_dt->mati_tgl))) ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-times-circle"></i></span>
                                                            </div>
                                                            <input type="time" name="mati_wkt" class="form-control"
                                                                value="<?php echo $this->tanggalan->wkt_indo($sql_medc_srt_dt->mati_tgl) ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglKontol" class="col-sm-3 col-form-label">Tempat</label>
                                                    <div class="col-sm-9">
                                                        <?php echo form_input(array('id' => 'mati_tmp', 'name' => 'mati_tmp', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Tempat ...', 'value' => $sql_medc_srt_dt->mati_tmp)) ?>
                                                    </div>
                                                </div>
                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglKontol" class="col-sm-3 col-form-label">Penyebab</label>
                                                    <div class="col-sm-9">
                                                        <?php echo form_input(array('id' => '', 'name' => 'mati_penyebab', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Penyebab Kematian ...', 'value' => $sql_medc_srt_dt->mati_penyebab)) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            break;

                                        case '8':
                                            ?>
                                            <div id="8" class="divSurat">
                                                <!--SURAT RUJUKAN-->

                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglKontol" class="col-sm-3 col-form-label">Nama
                                                        Dokter</label>
                                                    <div class="col-sm-9">
                                                        <?php echo form_input(array('id' => 'ruj_dokter', 'name' => 'ruj_dokter', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Nama Dokter ...', 'value' => $sql_medc_srt_dt->ruj_dokter)) ?>
                                                    </div>
                                                </div>
                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglKontol" class="col-sm-3 col-form-label">Tujuan
                                                        Faskes</label>
                                                    <div class="col-sm-9">
                                                        <?php echo form_input(array('id' => 'ruj_faskes', 'name' => 'ruj_faskes', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Tujuan Faskes ...', 'value' => $sql_medc_srt_dt->ruj_faskes)) ?>
                                                    </div>
                                                </div>
                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglKontol" class="col-sm-3 col-form-label">Keluhan</label>
                                                    <div class="col-sm-9">
                                                        <?php echo form_textarea(array('id' => 'ruj_keluhan', 'name' => 'ruj_keluhan', 'class' => 'form-control text-middle' . (!empty($hasError['ruj_keluhan']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle; height: 200px;', 'placeholder' => 'Keluhan ...', 'value' => $sql_medc_srt_dt->ruj_keluhan)) ?>
                                                    </div>
                                                </div>
                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglKontol" class="col-sm-3 col-form-label">Diagnosa</label>
                                                    <div class="col-sm-9">
                                                        <?php echo form_textarea(array('id' => 'ruj_diagnosa', 'name' => 'ruj_diagnosa', 'class' => 'form-control text-middle' . (!empty($hasError['ruj_diagnosa']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle; height: 200px;', 'placeholder' => 'Diagnosa ...', 'value' => $sql_medc_srt_dt->ruj_diagnosa)) ?>
                                                    </div>
                                                </div>
                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglKontol" class="col-sm-3 col-form-label">Terapi</label>
                                                    <div class="col-sm-9">
                                                        <?php echo form_textarea(array('id' => 'ruj_terapi', 'name' => 'ruj_terapi', 'class' => 'form-control text-middle' . (!empty($hasError['ruj_terapi']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle; height: 200px;', 'placeholder' => 'Terapi yang udah diberikan ...', 'value' => $sql_medc_srt_dt->ruj_terapi)) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            break;

                                        case '9':
                                            ?>
                                            <div id="9" class="divSurat">
                                                <!--SURAT KETERANGAN VAKSIN-->

                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl
                                                        Vaksin</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                            <?php echo form_input(array('id' => 'vks_tgl_periksa', 'name' => 'vks_tgl_periksa', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Tgl Vaksin ...', 'value' => $this->tanggalan->tgl_indo2($sql_medc_srt_dt->vks_tgl_periksa))) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputNmVaksin" class="col-sm-3 col-form-label">Jenis
                                                        Vaksin</label>
                                                    <div class="col-sm-9">
                                                        <?php echo form_input(array('id' => 'vks_nama', 'name' => 'vks_nama', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Isikan Jenis Vaksin ...', 'value' => $sql_medc_srt_dt->keterangan)) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            break;

                                        case '10':
                                            ?>
                                            <div id="10" class="divSurat">
                                                <!--SURAT KETERANGAN HAMIL-->

                                                <div id="Keterangan" class="form-group row">
                                                    <label for="inputTglSuratSehat"
                                                        class="col-sm-3 col-form-label">Pemeriksaan</label>
                                                    <div class="col-sm-9">
                                                        <?php echo form_textarea(array('id' => 'hml_periksa', 'name' => 'hml_periksa', 'class' => 'form-control text-middle rounded-0' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Tuliskan keterangan pemeriksaan ...', 'value' => $sql_medc_srt_dt->hml_periksa)) ?>
                                                    </div>
                                                </div>

                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tipe</label>
                                                    <div class="col-sm-9">
                                                        <select name="hml_tipe" class="form-control">
                                                            <option value="">- [Pilih] -</option>
                                                            <option value="1" <?php echo ($sql_medc_srt_dt->hml_tipe_ijin == '1' ? 'selected' : '') ?>>Cuti Hamil</option>
                                                            <option value="2" <?php echo ($sql_medc_srt_dt->hml_tipe_ijin == '2' ? 'selected' : '') ?>>Sakit</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Layak
                                                        Terbang</label>
                                                    <div class="col-sm-9">
                                                        <select name="hml_tipe_terbang" class="form-control">
                                                            <option value="">- [Pilih] -</option>
                                                            <option value="1" <?php echo ($sql_medc_srt_dt->hml_tipe_terbang == '1' ? 'selected' : '') ?>>
                                                                Layak</option>
                                                            <option value="2" <?php echo ($sql_medc_srt_dt->hml_tipe_terbang == '2' ? 'selected' : '') ?>>
                                                                Tidak Layak</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl
                                                        Mulai</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                            <?php echo form_input(array('id' => 'hml_tgl_awal', 'name' => 'hml_tgl_awal', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Tgl Surat ...', 'value' => $this->tanggalan->tgl_indo7($sql_medc_srt_dt->hml_tgl_awal))) ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!--Tgl Surat Sembuh-->
                                                <div id="inputTglSuratKeluar" class="form-group row">
                                                    <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl
                                                        Terakhir</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                            <?php echo form_input(array('id' => 'hml_tgl_akhir', 'name' => 'hml_tgl_akhir', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Tgl Sembuh ...', 'value' => $this->tanggalan->tgl_indo7($sql_medc_srt_dt->hml_tgl_akhir))) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            break;

                                        case '13':
                                            ?>
                                            <div id="13" class="divSurat">
                                                <!--SURAT BEBAS NARKOTIKA-->
                                                <div id="13" class="divSurat">
                                                    <div id="inputTglSuratMasuk" class="form-group row">
                                                        <label for="inputTglKetNarkoba" class="col-sm-3 col-form-label">Tgl
                                                            Periksa</label>
                                                        <div class="col-sm-9">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><i
                                                                            class="fas fa-calendar-alt"></i></span>
                                                                </div>
                                                                <?php echo form_input(array(
                                                                    'id' => 'napza_tgl_periksa',
                                                                    'name' => 'napza_tgl_periksa',
                                                                    'class' => 'form-control text-middle rounded-0 datepicker',
                                                                    'value' => isset($sql_medc_srt_dt) ? $this->tanggalan->tgl_indo7($sql_medc_srt_dt->napza_tgl_periksa) : '',
                                                                    'placeholder' => 'Tgl Periksa ...',
                                                                    'autocomplete' => 'off'
                                                                )) ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="inputDokter" class="form-group row">
                                                        <label for="inputTglKetNarkoba"
                                                            class="col-sm-3 col-form-label">Dokter</label>
                                                        <div class="col-sm-9">
                                                            <select id="dokter" name="dokter"
                                                                class="form-control rounded-0 select2bs4">
                                                                <option value="0">- Dokter -</option>
                                                                <?php foreach ($sql_doc as $doctor) { ?>
                                                                    <option value="<?php echo $doctor->id_user ?>" <?php echo (isset($sql_medc_srt_dt) && $sql_medc_srt_dt->id_dokter == $doctor->id_user ? 'selected' : '') ?>>
                                                                        <?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . $doctor->nama . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div id="inputHasil" class="form-group row">
                                                        <label for="hasil" class="col-sm-3 col-form-label">Hasil</label>
                                                        <div class="col-sm-9">
                                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                                <label
                                                                    class="btn btn-secondary <?php echo (isset($sql_medc_srt_dt) && $sql_medc_srt_dt->napza_hasil == '1' ? 'active' : ''); ?>">
                                                                    <input type="radio" name="napza_hasil" id="option_a1"
                                                                        autocomplete="off" value="1" <?php echo (isset($sql_medc_srt_dt) && $sql_medc_srt_dt->napza_hasil == '1' ? 'checked' : ''); ?>>
                                                                    Positif
                                                                </label>
                                                                <label
                                                                    class="btn btn-secondary <?php echo (isset($sql_medc_srt_dt) && $sql_medc_srt_dt->napza_hasil == '2' ? 'active' : ''); ?>">
                                                                    <input type="radio" name="napza_hasil" id="option_a2"
                                                                        autocomplete="off" value="2" <?php echo (isset($sql_medc_srt_dt) && $sql_medc_srt_dt->napza_hasil == '2' ? 'checked' : ''); ?>>
                                                                    Negatif
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            break;

                                        case '14':
                                            ?>
                                            <div id="14" class="divSurat">
                                                <!--SURAT LAYAK TERBANG--> <!-- Surat Layak Terbang Section -->
                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglSuratSehat"
                                                        class="col-sm-3 col-form-label">Pemeriksaan</label>
                                                    <div class="col-sm-9">
                                                        <?php echo form_textarea(array(
                                                            'id' => 'trb_periksa',
                                                            'name' => 'trb_periksa',
                                                            'class' => 'form-control text-middle rounded-0',
                                                            'value' => isset($sql_medc_srt_dt) ? $sql_medc_srt_dt->trb_periksa : '',
                                                            'placeholder' => 'Tuliskan keterangan pemeriksaan ...'
                                                        )) ?>
                                                    </div>
                                                </div>
                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Layak
                                                        Terbang</label>
                                                    <div class="col-sm-9">
                                                        <select name="trb_tipe_terbang" class="form-control rounded-0">
                                                            <option value="">- [Pilih] -</option>
                                                            <option value="1" <?php echo (isset($sql_medc_srt_dt) && $sql_medc_srt_dt->trb_tipe_terbang == '1' ? 'selected' : ''); ?>>
                                                                Layak
                                                            </option>
                                                            <option value="2" <?php echo (isset($sql_medc_srt_dt) && $sql_medc_srt_dt->trb_tipe_terbang == '2' ? 'selected' : ''); ?>>
                                                                Tidak
                                                                Layak</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="inputTglSuratMasuk" class="form-group row">
                                                    <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl
                                                        Mulai</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                            <?php echo form_input(array(
                                                                'id' => 'trb_tgl_awal',
                                                                'name' => 'trb_tgl_awal',
                                                                'class' => 'form-control text-middle rounded-0 datepicker',
                                                                'value' => isset($sql_medc_srt_dt) ? $this->tanggalan->tgl_indo7($sql_medc_srt_dt->trb_tgl_awal) : '',
                                                                'placeholder' => 'Tgl Surat ...',
                                                                'autocomplete' => 'off'
                                                            )) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="inputTglSuratKeluar" class="form-group row">
                                                    <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl
                                                        Terakhir</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                            <?php echo form_input(array(
                                                                'id' => 'trb_tgl_akhir',
                                                                'name' => 'trb_tgl_akhir',
                                                                'class' => 'form-control text-middle rounded-0 datepicker',
                                                                'value' => isset($sql_medc_srt_dt) ? $this->tanggalan->tgl_indo7($sql_medc_srt_dt->trb_tgl_akhir) : '',
                                                                'placeholder' => 'Tgl Sembuh ...',
                                                                'autocomplete' => 'off'
                                                            )) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            break;

                                        case '15':
                                            ?>
                                            <div id="15" class="divSurat">
                                                <!--SURAT KETERANGAN THT-->
                                                <div id="tht" class="form-group row">
                                                    <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Telinga
                                                        Kiri</label>
                                                    <div class="col-sm-3">
                                                        <?php echo form_input([
                                                            'id' => 'tht_lt_kiri',
                                                            'name' => 'tht_lt_kiri',
                                                            'class' => 'form-control text-middle rounded-0',
                                                            'value' => isset($sql_medc_srt_dt) ? $sql_medc_srt_dt->tht_lt_kiri : '',
                                                            'placeholder' => 'Bagian Kiri ...'
                                                        ]); ?>
                                                    </div>
                                                    <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Telinga
                                                        Kanan</label>
                                                    <div class="col-sm-3">
                                                        <?php echo form_input([
                                                            'id' => 'tht_lt_kanan',
                                                            'name' => 'tht_lt_kanan',
                                                            'class' => 'form-control text-middle rounded-0',
                                                            'value' => isset($sql_medc_srt_dt) ? $sql_medc_srt_dt->tht_lt_kanan : '',
                                                            'placeholder' => 'Bagian Kanan ...'
                                                        ]); ?>
                                                    </div>
                                                </div>
                                                <div id="tht" class="form-group row">
                                                    <label for="tht" class="col-sm-3 col-form-label">Membran Kiri</label>
                                                    <div class="col-sm-3">
                                                        <?php echo form_input([
                                                            'id' => 'tht_membran_kiri',
                                                            'name' => 'tht_membran_kiri',
                                                            'class' => 'form-control text-middle rounded-0',
                                                            'value' => isset($sql_medc_srt_dt) ? $sql_medc_srt_dt->tht_membran_kiri : '',
                                                            'placeholder' => 'Bagian Kiri ...'
                                                        ]); ?>
                                                    </div>
                                                    <label for="tht" class="col-sm-3 col-form-label">Membran Kanan</label>
                                                    <div class="col-sm-3">
                                                        <?php echo form_input([
                                                            'id' => 'tht_membran_kanan',
                                                            'name' => 'tht_membran_kanan',
                                                            'class' => 'form-control text-middle rounded-0',
                                                            'value' => isset($sql_medc_srt_dt) ? $sql_medc_srt_dt->tht_membran_kanan : '',
                                                            'placeholder' => 'Bagian Kanan ...'
                                                        ]); ?>
                                                    </div>
                                                </div>
                                                <div id="tht" class="form-group row">
                                                    <label for="tht" class="col-sm-3 col-form-label">Mukosa</label>
                                                    <div class="col-sm-3">
                                                        <?php echo form_input([
                                                            'id' => 'tht_mukosa_kiri',
                                                            'name' => 'tht_mukosa_kiri',
                                                            'class' => 'form-control text-middle rounded-0',
                                                            'value' => isset($sql_medc_srt_dt) ? $sql_medc_srt_dt->tht_mukosa_kiri : '',
                                                            'placeholder' => 'Bagian Kiri ...'
                                                        ]); ?>
                                                    </div>
                                                    <label for="tht" class="col-sm-3 col-form-label">Mukosa</label>
                                                    <div class="col-sm-3">
                                                        <?php echo form_input([
                                                            'id' => 'tht_mukosa_kanan',
                                                            'name' => 'tht_mukosa_kanan',
                                                            'class' => 'form-control text-middle rounded-0',
                                                            'value' => isset($sql_medc_srt_dt) ? $sql_medc_srt_dt->tht_mukosa_kanan : '',
                                                            'placeholder' => 'Bagian Kanan ...'
                                                        ]); ?>
                                                    </div>
                                                </div>
                                                <div id="tht" class="form-group row">
                                                    <label for="tht" class="col-sm-3 col-form-label">Konka Inferior</label>
                                                    <div class="col-sm-3">
                                                        <?php echo form_input([
                                                            'id' => 'tht_konka_kiri',
                                                            'name' => 'tht_konka_kiri',
                                                            'class' => 'form-control text-middle rounded-0',
                                                            'value' => isset($sql_medc_srt_dt) ? $sql_medc_srt_dt->tht_konka_kiri : '',
                                                            'placeholder' => 'Bagian Kiri ...'
                                                        ]); ?>
                                                    </div>
                                                    <label for="tht" class="col-sm-3 col-form-label">Konka Inferior</label>
                                                    <div class="col-sm-3">
                                                        <?php echo form_input([
                                                            'id' => 'tht_konka_kanan',
                                                            'name' => 'tht_konka_kanan',
                                                            'class' => 'form-control text-middle rounded-0',
                                                            'value' => isset($sql_medc_srt_dt) ? $sql_medc_srt_dt->tht_konka_kanan : '',
                                                            'placeholder' => 'Bagian Kanan ...'
                                                        ]); ?>
                                                    </div>
                                                </div>
                                                <div id="tht" class="form-group row">
                                                    <label for="tht" class="col-sm-3 col-form-label">Timpanometri</label>
                                                    <div class="col-sm-3">
                                                        <?php echo form_input([
                                                            'id' => 'tht_timpa_kiri',
                                                            'name' => 'tht_timpa_kiri',
                                                            'class' => 'form-control text-middle rounded-0',
                                                            'value' => isset($sql_medc_srt_dt) ? $sql_medc_srt_dt->tht_timpa_kiri : '',
                                                            'placeholder' => 'Bagian Kiri ...'
                                                        ]); ?>
                                                    </div>
                                                    <label for="tht" class="col-sm-3 col-form-label">Timpanometri</label>
                                                    <div class="col-sm-3">
                                                        <?php echo form_input([
                                                            'id' => 'tht_timpa_kanan',
                                                            'name' => 'tht_timpa_kanan',
                                                            'class' => 'form-control text-middle rounded-0',
                                                            'value' => isset($sql_medc_srt_dt) ? $sql_medc_srt_dt->tht_timpa_kanan : '',
                                                            'placeholder' => 'Bagian Kanan ...'
                                                        ]); ?>
                                                    </div>
                                                </div>
                                                <div id="tht" class="form-group row">
                                                    <label for="tht" class="col-sm-3 col-form-label">Tonsil Tenggorokan</label>
                                                    <div class="col-sm-3">
                                                        <?php echo form_input([
                                                            'id' => 'tht_tonsil_tg',
                                                            'name' => 'tht_tonsil_tg',
                                                            'class' => 'form-control text-middle rounded-0',
                                                            'value' => isset($sql_medc_srt_dt) ? $sql_medc_srt_dt->tht_tonsil_tg : '',
                                                            'placeholder' => 'Tonsil ...'
                                                        ]); ?>
                                                    </div>
                                                    <label for="tht" class="col-sm-3 col-form-label">Mukosa Tenggorokan</label>
                                                    <div class="col-sm-3">
                                                        <?php echo form_input([
                                                            'id' => 'tht_mukosa_tg',
                                                            'name' => 'tht_mukosa_tg',
                                                            'class' => 'form-control text-middle rounded-0',
                                                            'value' => isset($sql_medc_srt_dt) ? $sql_medc_srt_dt->tht_mukosa_tg : '',
                                                            'placeholder' => 'Mukosa ...'
                                                        ]); ?>
                                                    </div>
                                                </div>
                                                <div id="tht" class="form-group row">
                                                    <label for="tht" class="col-sm-3 col-form-label">Dinding Faring</label>
                                                    <div class="col-sm-3">
                                                        <?php echo form_input([
                                                            'id' => 'tht_faring_tg',
                                                            'name' => 'tht_faring_tg',
                                                            'class' => 'form-control text-middle rounded-0',
                                                            'value' => isset($sql_medc_srt_dt) ? $sql_medc_srt_dt->tht_faring_tg : '',
                                                            'placeholder' => 'Faring ...'
                                                        ]); ?>
                                                    </div>
                                                </div>
                                                <div id="tht" class="form-group row">
                                                    <label for="tht" class="col-sm-3 col-form-label">Kesimpulan</label>
                                                    <div class="col-sm-9">
                                                        <?php echo form_input([
                                                            'id' => 'tht_kesimpulan',
                                                            'name' => 'tht_kesimpulan',
                                                            'class' => 'form-control text-middle rounded-0',
                                                            'value' => isset($sql_medc_srt_dt) ? $sql_medc_srt_dt->tht_kesimpulan : '',
                                                            'placeholder' => 'Kesimpulan ...'
                                                        ]); ?>
                                                    </div>
                                                </div>
                                                <div id="tht" class="form-group row">
                                                    <label for="tht" class="col-sm-3 col-form-label">Audio</label>
                                                    <div class="col-sm-9">
                                                        <?php echo form_input([
                                                            'id' => 'tht_audio',
                                                            'name' => 'tht_audio',
                                                            'class' => 'form-control text-middle rounded-0',
                                                            'value' => isset($sql_medc_srt_dt) ? $sql_medc_srt_dt->tht_audio : '',
                                                            'placeholder' => 'Audio ...'
                                                        ]); ?>
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
                                    <button type="button" class="btn btn-primary btn-flat"
                                        onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=6') ?>'"><i
                                            class="fas fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i>
                                        Simpan</button>
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
                                            <?php foreach ($sql_medc_srt as $surat) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no . '.'; ?></td>
                                                    <td class="text-left">
                                                        <small><i><?php echo $this->tanggalan->tgl_indo2($surat->tgl_masuk); ?></i></small>
                                                        <?php echo br() ?>
                                                        <?php echo $surat->no_surat; ?>
                                                        <?php if (!empty($sql_dokter->nama)) { ?>
                                                            <?php echo br() ?>
                                                            <small><?php echo (!empty($sql_dokter->nama_dpn) ? $sql_dokter->nama_dpn . ' ' : '') . $sql_dokter->nama . (!empty($sql_dokter->nama_blk) ? ', ' . $sql_dokter->nama_blk . ' ' : ''); ?></small>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-left">
                                                        Surat <?php echo general::tipe_surat($surat->tipe); ?></td>
                                                    <td class="text-center">
                                                        <?php echo anchor(base_url('medcheck/tambah.php?act=inf_ubah&id=' . general::enkrip($sql_medc->id) . '&status=' . $this->input->get('status') . '&id_form=' . general::enkrip($surat->id) . '&tipe=' . $surat->tipe), '<i class="fa fa-edit"></i> Ubah', 'class="btn btn-primary btn-flat btn-xs" style="width: 55px;"') ?>
                                                        <?php echo anchor(base_url('medcheck/surat/cetak_pdf.php?id=' . general::enkrip($surat->id) . '&no_nota=' . general::enkrip($surat->id_medcheck) . '&status=' . $this->input->get('status')), '<i class="fas fa-print"></i> Cetak', 'target="_blank" class="btn btn-info btn-flat btn-xs" style="width: 55px;"') ?>
                                                        <?php echo anchor(base_url('medcheck/surat/hapus.php?id=' . general::enkrip($surat->id) . '&no_nota=' . general::enkrip($surat->id_medcheck) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $surat->no_surat . '] ?\')" style="width: 55px;"') ?>
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
                </div>
                <div class="col-lg-4">
                    <?php $data['gtotal'] = $gtotal ?>
                    <?php $this->load->view('admin-lte-3/includes/medcheck/med_tindakan_kanan', $data) ?>
                </div>
            </div>
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
        $('#tgl_masuk_sht').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $('#tgl_masuk_skt').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $('#tgl_keluar_skt').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $('#tgl_masuk_rnp').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $('#tgl_keluar_rnp').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $('#tgl_masuk_kntl').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $('#mati_tgl').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $('#lahir_tgl').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $('#cvd_tgl_periksa').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $('#cvd_tgl_awal').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $('#cvd_tgl_akhir').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $('#hml_tgl_awal').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $('#hml_tgl_akhir').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $('#vks_tgl_periksa').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $('#napza_tgl_periksa').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        // Hilangkan tanggal sembuh
        $('#ckSembuh').click(function () {
            if ($(this).prop('checked') == true) {
                $('#inputTglSuratKeluar').hide();
            } else {
                $('#inputTglSuratKeluar').show();
            }

        });
    });
</script>