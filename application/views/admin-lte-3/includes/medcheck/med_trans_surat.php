<?php
/**
 * Medical Checkup Letter Form View
 * 
 * View for handling various types of medical letters and certificates
 * 
 * @author Mikhael Felian Waskito - mikhaelfelian@gmail.com
 * @date 2025-04-12
 */
?>

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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('medcheck/index.php') ?>">Medical Checkup</a></li>
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
                    <?php
                    $t_awl      = ($sql_medc->tgl_bayar == '0000-00-00 00:00:00' ? $sql_medc->tgl_simpan : $sql_medc->tgl_bayar);
                    $t_akh      = date('Y-m-d');
                    $jml_hari   = $this->tanggalan->jml_hari($t_awl, $t_akh);
                    ?>

                    <?php echo form_open_multipart(base_url('medcheck/set_medcheck_surat.php'), 'autocomplete="off"') ?>
                    <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                    <?php echo form_hidden('status', $st_medrep); ?>

                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">MODUL SURAT KETERANGAN - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label for="hasil" class="col-sm-3 col-form-label">Tipe</label>
                                        <div class="col-sm-9">
                                            <select id="tipe_surat" name="tipe_surat" class="form-control rounded-0">
                                                <option value="">[Tipe Surat]</option>
                                                <option value="1" <?php echo (isset($surat) && $surat->tipe == '1' ? 'selected' : ''); ?>>Surat Sehat</option>
                                                <option value="2" <?php echo (isset($surat) && $surat->tipe == '2' ? 'selected' : ''); ?>>Surat Sakit</option>
                                                <option value="3" <?php echo (isset($surat) && $surat->tipe == '3' ? 'selected' : ''); ?>>Surat Rawat Inap</option>
                                                <option value="4" <?php echo (isset($surat) && $surat->tipe == '4' ? 'selected' : ''); ?>>Surat Kontrol</option>
                                                <option value="5" <?php echo (isset($surat) && $surat->tipe == '5' ? 'selected' : ''); ?>>Surat Kelahiran</option>
                                                <option value="6" <?php echo (isset($surat) && $surat->tipe == '6' ? 'selected' : ''); ?>>Surat Kematian</option>
                                                <option value="7" <?php echo (isset($surat) && $surat->tipe == '7' ? 'selected' : ''); ?>>Surat Covid</option>
                                                <option value="8" <?php echo (isset($surat) && $surat->tipe == '8' ? 'selected' : ''); ?>>Surat Rujukan</option>
                                                <option value="9" <?php echo (isset($surat) && $surat->tipe == '9' ? 'selected' : ''); ?>>Surat Vaksin</option>
                                                <option value="10" <?php echo (isset($surat) && $surat->tipe == '10' ? 'selected' : ''); ?>>Surat Kehamilan</option>
                                                <option value="14" <?php echo (isset($surat) && $surat->tipe == '14' ? 'selected' : ''); ?>>Surat Layak Terbang</option>
                                                <option value="13" <?php echo (isset($surat) && $surat->tipe == '13' ? 'selected' : ''); ?>>Surat Ket. Bebas Narkoba</option>
                                                <option value="15" <?php echo (isset($surat) && $surat->tipe == '15' ? 'selected' : ''); ?>>Surat Ket. THT</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Surat Sehat Section -->
                                    <div id="1" class="divSurat">
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl Surat</label>
                                            <div class="col-sm-9">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <?php echo form_input(array(
                                                        'id' => 'tgl_masuk_sht',
                                                        'name' => 'tgl_masuk',
                                                        'class' => 'form-control text-middle rounded-0 datepicker',
                                                        'value' => isset($surat) ? date('d-m-Y', strtotime($surat->tgl_masuk)) : '',
                                                        'placeholder' => 'Tgl Surat ...',
                                                        'autocomplete' => 'off'
                                                    )) ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="inputTB" class="form-group row">
                                            <label for="inputTinggi" class="col-sm-3 col-form-label">Tinggi</label>
                                            <div class="col-sm-3">
                                                <?php echo form_input(array(
                                                    'id' => 'angka',
                                                    'name' => 'tb',
                                                    'class' => 'form-control pull-right rounded-0',
                                                    'value' => isset($surat) ? $surat->tb : '',
                                                    'placeholder' => 'Tinggi ...'
                                                )) ?>
                                            </div>
                                            <label for="satuanTinggi" class="col-sm-6 col-form-label">cm</label>
                                        </div>

                                        <div id="inputTD" class="form-group row">
                                            <label for="inputTD" class="col-sm-3 col-form-label">Tekanan Darah</label>
                                            <div class="col-sm-3">
                                                <?php echo form_input(array(
                                                    'id' => '',
                                                    'name' => 'td',
                                                    'class' => 'form-control pull-right rounded-0',
                                                    'value' => isset($surat) ? $surat->td : '',
                                                    'placeholder' => 'Tekanan ...'
                                                )) ?>
                                            </div>
                                            <label for="satuanTD" class="col-sm-6 col-form-label">mmHg</label>
                                        </div>

                                        <div id="inputBB" class="form-group row">
                                            <label for="inputBB" class="col-sm-3 col-form-label">Berat Badan</label>
                                            <div class="col-sm-3">
                                                <?php echo form_input(array(
                                                    'id' => 'angka',
                                                    'name' => 'bb',
                                                    'class' => 'form-control pull-right rounded-0',
                                                    'value' => isset($surat) ? $surat->bb : '',
                                                    'placeholder' => 'BB ...'
                                                )) ?>
                                            </div>
                                            <label for="satuanBB" class="col-sm-6 col-form-label">Kg</label>
                                        </div>

                                        <div id="inputBW" class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Buta Warna</label>
                                            <div class="col-sm-9">
                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                    <label class="btn btn-secondary <?php echo (isset($surat) && $surat->buta_warna == '1' ? 'active' : ''); ?>">
                                                        <input type="radio" name="bw" id="option_a1" autocomplete="off" value="1" <?php echo (isset($surat) && $surat->buta_warna == '1' ? 'checked' : ''); ?>> +
                                                    </label>
                                                    <label class="btn btn-secondary <?php echo (isset($surat) && $surat->buta_warna == '0' ? 'active' : ''); ?>">
                                                        <input type="radio" name="bw" id="option_a2" autocomplete="off" value="0" <?php echo (isset($surat) && $surat->buta_warna == '0' ? 'checked' : ''); ?>> -
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="inputTD" class="form-group row">
                                            <label for="inputTD" class="col-sm-3 col-form-label"></label>
                                            <div class="col-sm-9">
                                                <?php echo form_input(array(
                                                    'id' => '',
                                                    'name' => 'bw_ket',
                                                    'class' => 'form-control pull-right rounded-0',
                                                    'value' => isset($surat) ? $surat->bw_ket : '',
                                                    'placeholder' => 'Ket. Buta Warna ...'
                                                )) ?>
                                            </div>
                                        </div>

                                        <div id="inputHasil" class="form-group row">
                                            <label for="hasil" class="col-sm-3 col-form-label">Hasil</label>
                                            <div class="col-sm-9">
                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                    <label class="btn btn-secondary <?php echo (isset($surat) && $surat->hasil == '1' ? 'active' : ''); ?>">
                                                        <input type="radio" name="hasil" id="option_a1" autocomplete="off" value="1" <?php echo (isset($surat) && $surat->hasil == '1' ? 'checked' : ''); ?>> Sehat
                                                    </label>
                                                    <label class="btn btn-secondary <?php echo (isset($surat) && $surat->hasil == '0' ? 'active' : ''); ?>">
                                                        <input type="radio" name="hasil" id="option_a2" autocomplete="off" value="0" <?php echo (isset($surat) && $surat->hasil == '0' ? 'checked' : ''); ?>> Tidak Sehat
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Surat Sakit Section -->
                                    <div id="2" class="divSurat">
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl Surat</label>
                                            <div class="col-sm-9">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <?php echo form_input(array(
                                                        'id' => 'tgl_masuk_skt',
                                                        'name' => 'tgl_masuk',
                                                        'class' => 'form-control text-middle rounded-0 datepicker',
                                                        'value' => isset($surat) ? date('d-m-Y', strtotime($surat->tgl_masuk)) : '',
                                                        'placeholder' => 'Tgl Surat ...',
                                                        'autocomplete' => 'off'
                                                    )) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Tgl Surat Sembuh--> 
                                        <div id="inputTglSuratKeluar" class="form-group row">                                        
                                            <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl Sembuh</label>
                                            <div class="col-sm-9">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <?php echo form_input(array(
                                                        'id' => 'tgl_keluar_skt',
                                                        'name' => 'tgl_keluar',
                                                        'class' => 'form-control text-middle rounded-0 datepicker',
                                                        'value' => isset($surat) ? date('d-m-Y', strtotime($surat->tgl_keluar)) : '',
                                                        'placeholder' => 'Tgl Sembuh ...',
                                                        'autocomplete' => 'off'
                                                    )) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Tgl Surat Sembuh--> 
                                        <div id="inputTglSuratKontol" class="form-group row">                                        
                                            <label for="inputSembuh" class="col-sm-3 col-form-label">atau s/d Sembuh</label>
                                            <div class="col-sm-9">
                                                <?php echo form_checkbox(array(
                                                    'id' => 'ckSembuh',
                                                    'class' => 'form-controller',
                                                    'name' => 'sembuh',
                                                    'value' => '1',
                                                    'checked' => isset($surat) && $surat->sembuh == '1' ? true : false
                                                )) ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Surat Rawat Inap Section -->
                                    <div id="3" class="divSurat">
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl Masuk</label>
                                            <div class="col-sm-9">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <?php echo form_input(array(
                                                        'id' => 'tgl_masuk_rnp',
                                                        'name' => 'tgl_masuk',
                                                        'class' => 'form-control text-middle rounded-0 datepicker',
                                                        'value' => isset($surat) ? date('d-m-Y', strtotime($surat->tgl_masuk)) : '',
                                                        'placeholder' => 'Tgl Surat ...',
                                                        'autocomplete' => 'off'
                                                    )) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Tgl Surat Sembuh--> 
                                        <div id="inputTglSuratKeluar" class="form-group row">                                        
                                            <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl Sembuh</label>
                                            <div class="col-sm-9">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <?php echo form_input(array(
                                                        'id' => 'tgl_keluar_rnp',
                                                        'name' => 'tgl_keluar',
                                                        'class' => 'form-control text-middle rounded-0 datepicker',
                                                        'value' => isset($surat) ? date('d-m-Y', strtotime($surat->tgl_keluar)) : '',
                                                        'placeholder' => 'Tgl Sembuh ...',
                                                        'autocomplete' => 'off'
                                                    )) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Tgl Surat Sembuh--> 
                                        <div id="inputTglSuratKontol" class="form-group row">                                        
                                            <label for="inputSembuh" class="col-sm-3 col-form-label">atau s/d Sembuh</label>
                                            <div class="col-sm-9">
                                                <?php echo form_checkbox(array(
                                                    'id' => 'ckSembuh',
                                                    'class' => 'form-controller',
                                                    'name' => 'sembuh',
                                                    'value' => '1',
                                                    'checked' => isset($surat) && $surat->sembuh == '1' ? true : false
                                                )) ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Surat Kontrol Section -->
                                    <div id="4" class="divSurat">
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglKontol" class="col-sm-3 col-form-label">Tgl Kontrol</label>
                                            <div class="col-sm-9">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <?php echo form_input(array(
                                                        'id' => 'tgl_masuk_kntl',
                                                        'name' => 'tgl_kontrol',
                                                        'class' => 'form-control text-middle rounded-0 datepicker',
                                                        'value' => isset($surat) ? date('d-m-Y', strtotime($surat->tgl_kontrol)) : '',
                                                        'placeholder' => 'Tgl Surat ...',
                                                        'autocomplete' => 'off'
                                                    )) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Surat Kelahiran Section -->
                                    <div id="5" class="divSurat">
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglKontol" class="col-sm-3 col-form-label">Tgl Lahir</label>
                                            <div class="col-sm-4">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <?php echo form_input(array(
                                                        'id' => 'lahir_tgl',
                                                        'name' => 'tgl_lahir',
                                                        'class' => 'form-control text-middle rounded-0 datepicker',
                                                        'value' => isset($surat) ? date('d-m-Y', strtotime($surat->tgl_lahir)) : '',
                                                        'placeholder' => 'Tgl Surat ...',
                                                        'autocomplete' => 'off'
                                                    )) ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                    </div>
                                                    <input type="time" name="wkt_lahir" class="form-control rounded-0" value="<?php echo isset($surat) ? $surat->wkt_lahir : ''; ?>">
                                                </div>
                                            </div>
                                        </div>                                
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglKontol" class="col-sm-3 col-form-label">Nama Lahir</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input(array(
                                                    'id' => '',
                                                    'name' => 'nm_lahir',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->nm_lahir : '',
                                                    'placeholder' => 'Nama Lahir...'
                                                )) ?>
                                            </div>
                                        </div>
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglKontol" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                            <div class="col-sm-9">
                                                <select name="jns_klm" class="form-control rounded-0">
                                                    <option value="">- Pilih -</option>
                                                    <option value="L" <?php echo (isset($surat) && $surat->jns_klm == 'L' ? 'selected' : ''); ?>>Laki - laki</option>
                                                    <option value="P" <?php echo (isset($surat) && $surat->jns_klm == 'P' ? 'selected' : ''); ?>>Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglKontol" class="col-sm-3 col-form-label">Nama Ayah</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input(array(
                                                    'id' => '',
                                                    'name' => 'nm_ayah',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->nm_ayah : '',
                                                    'placeholder' => 'Nama Ayah...'
                                                )) ?>
                                            </div>
                                        </div>
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglKontol" class="col-sm-3 col-form-label">Nama Ibu</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input(array(
                                                    'id' => '',
                                                    'name' => 'nm_ibu',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->nm_ibu : '',
                                                    'placeholder' => 'Nama Ibu...'
                                                )) ?>
                                            </div>
                                        </div>
                                        <div id="inputTB" class="form-group row">
                                            <label for="inputTinggi" class="col-sm-3 col-form-label">Panjang</label>
                                            <div class="col-sm-3">
                                                <?php echo form_input(array(
                                                    'id' => 'angka',
                                                    'name' => 'tb',
                                                    'class' => 'form-control pull-right rounded-0',
                                                    'value' => isset($surat) ? $surat->tb : '',
                                                    'placeholder' => 'Panjang ...'
                                                )) ?>
                                            </div>
                                            <label for="satuanTinggi" class="col-sm-6 col-form-label">cm</label>
                                        </div>
                                        <div id="inputBB" class="form-group row">
                                            <label for="inputBB" class="col-sm-3 col-form-label">Berat Lahir</label>
                                            <div class="col-sm-3">
                                                <?php echo form_input(array(
                                                    'id' => 'angka',
                                                    'name' => 'bb',
                                                    'class' => 'form-control pull-right rounded-0',
                                                    'value' => isset($surat) ? $surat->bb : '',
                                                    'placeholder' => 'BB ...'
                                                )) ?>
                                            </div>
                                            <label for="satuanBB" class="col-sm-6 col-form-label">Kg</label>
                                        </div>
                                    </div>

                                    <!-- Surat Kematian Section -->
                                    <div id="6" class="divSurat">
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglKontol" class="col-sm-3 col-form-label">Tgl & Waktu</label>
                                            <div class="col-sm-4">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <?php echo form_input(array(
                                                        'id' => 'mati_tgl',
                                                        'name' => 'mati_tgl',
                                                        'class' => 'form-control text-middle rounded-0 datepicker',
                                                        'value' => isset($surat) ? date('d-m-Y', strtotime($surat->mati_tgl)) : '',
                                                        'placeholder' => 'Tgl ...',
                                                        'autocomplete' => 'off'
                                                    )) ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-times-circle"></i></span>
                                                    </div>
                                                    <input type="time" name="mati_wkt" class="form-control rounded-0" value="<?php echo isset($surat) ? $surat->mati_wkt : ''; ?>">
                                                </div>
                                            </div>
                                        </div>                                
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglKontol" class="col-sm-3 col-form-label">Tempat</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input(array(
                                                    'id' => 'mati_tmp',
                                                    'name' => 'mati_tmp',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->mati_tmp : '',
                                                    'placeholder' => 'Tempat ...'
                                                )) ?>
                                            </div>
                                        </div>
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglKontol" class="col-sm-3 col-form-label">Penyebab</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input(array(
                                                    'id' => '',
                                                    'name' => 'mati_penyebab',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->mati_penyebab : '',
                                                    'placeholder' => 'Penyebab Kematian ...'
                                                )) ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Surat Covid Section -->
                                    <div id="7" class="divSurat">
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglKontol" class="col-sm-3 col-form-label">Tgl & Waktu</label>
                                            <div class="col-sm-4">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <?php echo form_input(array(
                                                        'id' => 'cvd_tgl_periksa',
                                                        'name' => 'cvd_tgl_periksa',
                                                        'class' => 'form-control text-middle rounded-0 datepicker',
                                                        'class' => 'form-control text-middle rounded-0',
                                                        'value' => isset($surat) ? date('d-m-Y', strtotime($surat->cvd_tgl_periksa)) : '',
                                                        'placeholder' => 'Tgl ...'
                                                    )) ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-times-circle"></i></span>
                                                    </div>
                                                    <input type="time" name="cvd_wkt_periksa" class="form-control rounded-0" value="<?php echo isset($surat) ? $surat->cvd_wkt_periksa : ''; ?>">
                                                </div>
                                            </div>
                                        </div>                                
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglKontol" class="col-sm-3 col-form-label">Tempat</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input(array(
                                                    'id' => 'cvd_tmp',
                                                    'name' => 'cvd_tmp',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->cvd_tmp : '',
                                                    'placeholder' => 'Tempat ...'
                                                )) ?>
                                            </div>
                                        </div>
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglKontol" class="col-sm-3 col-form-label">Penyebab</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input(array(
                                                    'id' => '',
                                                    'name' => 'cvd_penyebab',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->cvd_penyebab : '',
                                                    'placeholder' => 'Penyebab ...'
                                                )) ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Surat Rujukan Section -->
                                    <div id="8" class="divSurat">
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglKontol" class="col-sm-3 col-form-label">Nama Dokter</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input(array(
                                                    'id' => 'ruj_dokter',
                                                    'name' => 'ruj_dokter',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->ruj_dokter : '',
                                                    'placeholder' => 'Nama Dokter ...'
                                                )) ?>
                                            </div>
                                        </div>
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglKontol" class="col-sm-3 col-form-label">Tujuan Faskes</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input(array(
                                                    'id' => 'ruj_faskes',
                                                    'name' => 'ruj_faskes',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->ruj_faskes : '',
                                                    'placeholder' => 'Tujuan Faskes ...'
                                                )) ?>
                                            </div>
                                        </div>
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglKontol" class="col-sm-3 col-form-label">Keluhan</label>
                                            <div class="col-sm-9">
                                                <?php echo form_textarea(array(
                                                    'id' => 'ruj_keluhan',
                                                    'name' => 'ruj_keluhan',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->ruj_keluhan : '',
                                                    'style' => 'vertical-align: middle; height: 200px;',
                                                    'placeholder' => 'Keluhan ...'
                                                )) ?>
                                            </div>
                                        </div>
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglKontol" class="col-sm-3 col-form-label">Diagnosa</label>
                                            <div class="col-sm-9">
                                                <?php echo form_textarea(array(
                                                    'id' => 'ruj_diagnosa',
                                                    'name' => 'ruj_diagnosa',
                                                    'class' => 'form-control text-middle',
                                                    'value' => isset($surat) ? $surat->ruj_diagnosa : '',
                                                    'style' => 'vertical-align: middle; height: 200px;',
                                                    'placeholder' => 'Diagnosa ...'
                                                )) ?>
                                            </div>
                                        </div>
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglKontol" class="col-sm-3 col-form-label">Terapi</label>
                                            <div class="col-sm-9">
                                                <?php echo form_textarea(array(
                                                    'id' => 'ruj_terapi',
                                                    'name' => 'ruj_terapi',
                                                    'class' => 'form-control text-middle',
                                                    'value' => isset($surat) ? $surat->ruj_terapi : '',
                                                    'style' => 'vertical-align: middle; height: 200px;',
                                                    'placeholder' => 'Terapi yang udah diberikan ...'
                                                )) ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Surat Vaksin Section -->
                                    <div id="9" class="divSurat">
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl Vaksin</label>
                                            <div class="col-sm-9">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <?php echo form_input(array(
                                                        'id' => 'vks_tgl_periksa',
                                                        'name' => 'vks_tgl_periksa',
                                                        'class' => 'form-control text-middle rounded-0',
                                                        'value' => isset($surat) ? date('d-m-Y', strtotime($surat->vks_tgl_periksa)) : '',
                                                        'placeholder' => 'Tgl Vaksin ...'
                                                    )) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputNmVaksin" class="col-sm-3 col-form-label">Jenis Vaksin</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input(array(
                                                    'id' => 'vks_nama',
                                                    'name' => 'vks_nama',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->vks_nama : '',
                                                    'placeholder' => 'Isikan Jenis Vaksin ...'
                                                )) ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Surat Kehamilan Section -->
                                    <div id="10" class="divSurat">
                                        <div id="Keterangan" class="form-group row">
                                            <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Pemeriksaan</label>
                                            <div class="col-sm-9">
                                                <?php echo form_textarea(array(
                                                    'id' => 'hml_periksa',
                                                    'name' => 'hml_periksa',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->hml_periksa : '',
                                                    'placeholder' => 'Tuliskan keterangan pemeriksaan ...'
                                                )) ?>
                                            </div>
                                        </div>

                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tipe</label>
                                            <div class="col-sm-9">
                                                <select name="hml_tipe" class="form-control rounded-0">
                                                    <option value="">- [Pilih] -</option>
                                                    <option value="1" <?php echo (isset($surat) && $surat->hml_tipe == '1' ? 'selected' : ''); ?>>Cuti Hamil</option>
                                                    <option value="2" <?php echo (isset($surat) && $surat->hml_tipe == '2' ? 'selected' : ''); ?>>Sakit</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Layak Terbang</label>
                                            <div class="col-sm-9">
                                                <select name="hml_tipe_terbang" class="form-control rounded-0">
                                                    <option value="">- [Pilih] -</option>
                                                    <option value="1" <?php echo (isset($surat) && $surat->hml_tipe_terbang == '1' ? 'selected' : ''); ?>>Layak</option>
                                                    <option value="2" <?php echo (isset($surat) && $surat->hml_tipe_terbang == '2' ? 'selected' : ''); ?>>Tidak Layak</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl Mulai</label>
                                            <div class="col-sm-9">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <?php echo form_input(array(
                                                        'id' => 'hml_tgl_awal',
                                                        'name' => 'hml_tgl_awal',
                                                        'class' => 'form-control text-middle rounded-0',
                                                        'value' => isset($surat) ? date('d-m-Y', strtotime($surat->hml_tgl_awal)) : '',
                                                        'placeholder' => 'Tgl Surat ...'
                                                    )) ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="inputTglSuratKeluar" class="form-group row">                                        
                                            <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl Terakhir</label>
                                            <div class="col-sm-9">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <?php echo form_input(array(
                                                        'id' => 'hml_tgl_akhir',
                                                        'name' => 'hml_tgl_akhir',
                                                        'class' => 'form-control text-middle rounded-0',
                                                        'value' => isset($surat) ? date('d-m-Y', strtotime($surat->hml_tgl_akhir)) : '',
                                                        'placeholder' => 'Tgl Sembuh ...'
                                                    )) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Surat Bebas Narkoba Section -->
                                    <div id="13" class="divSurat">
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglKetNarkoba" class="col-sm-3 col-form-label">Tgl Periksa</label>
                                            <div class="col-sm-9">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <?php echo form_input(array(
                                                        'id' => 'napza_tgl_periksa',
                                                        'name' => 'napza_tgl_periksa',
                                                        'class' => 'form-control text-middle rounded-0',
                                                        'value' => isset($surat) ? date('d-m-Y', strtotime($surat->napza_tgl_periksa)) : '',
                                                        'placeholder' => 'Tgl Surat ...'
                                                    )) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="inputDokter" class="form-group row">
                                            <label for="inputTglKetNarkoba" class="col-sm-3 col-form-label">Dokter</label>
                                            <div class="col-sm-9">
                                                <select id="dokter" name="dokter" class="form-control rounded-0 select2bs4">
                                                    <option value="0">- Dokter -</option>
                                                    <?php foreach ($sql_doc as $doctor) { ?>
                                                        <option value="<?php echo $doctor->id_user ?>" <?php echo (isset($surat) && $surat->id_dokter == $doctor->id_user ? 'selected' : '') ?>><?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . $doctor->nama . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="inputHasil" class="form-group row">
                                            <label for="hasil" class="col-sm-3 col-form-label">Hasil</label>
                                            <div class="col-sm-9">
                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                    <label class="btn btn-secondary <?php echo (isset($surat) && $surat->napza_hasil == '1' ? 'active' : ''); ?>">
                                                        <input type="radio" name="napza_hasil" id="option_a1" autocomplete="off" value="1" <?php echo (isset($surat) && $surat->napza_hasil == '1' ? 'checked' : ''); ?>> Positif
                                                    </label>
                                                    <label class="btn btn-secondary <?php echo (isset($surat) && $surat->napza_hasil == '2' ? 'active' : ''); ?>">
                                                        <input type="radio" name="napza_hasil" id="option_a2" autocomplete="off" value="2" <?php echo (isset($surat) && $surat->napza_hasil == '2' ? 'checked' : ''); ?>> Negatif
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Surat Layak Terbang Section -->
                                    <div id="14" class="divSurat">
                                        <div id="Keterangan" class="form-group row">
                                            <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Pemeriksaan</label>
                                            <div class="col-sm-9">
                                                <?php echo form_textarea(array(
                                                    'id' => 'trb_periksa',
                                                    'name' => 'trb_periksa',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->trb_periksa : '',
                                                    'placeholder' => 'Tuliskan keterangan pemeriksaan ...'
                                                )) ?>
                                            </div>
                                        </div>
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Layak Terbang</label>
                                            <div class="col-sm-9">
                                                <select name="trb_tipe_terbang" class="form-control rounded-0">
                                                    <option value="">- [Pilih] -</option>
                                                    <option value="1" <?php echo (isset($surat) && $surat->trb_tipe_terbang == '1' ? 'selected' : ''); ?>>Layak</option>
                                                    <option value="2" <?php echo (isset($surat) && $surat->trb_tipe_terbang == '2' ? 'selected' : ''); ?>>Tidak Layak</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="inputTglSuratMasuk" class="form-group row">
                                            <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl Mulai</label>
                                            <div class="col-sm-9">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <?php echo form_input(array(
                                                        'id' => 'trb_tgl_awal',
                                                        'name' => 'trb_tgl_awal',
                                                        'class' => 'form-control text-middle rounded-0 datepicker',
                                                        'value' => isset($surat) ? date('d/m/Y', strtotime($surat->trb_tgl_awal)) : '',
                                                        'placeholder' => 'Tgl Surat ...',
                                                        'autocomplete' => 'off'
                                                    )) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="inputTglSuratKeluar" class="form-group row">                                        
                                            <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Tgl Terakhir</label>
                                            <div class="col-sm-9">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <?php echo form_input(array(
                                                        'id' => 'trb_tgl_akhir',
                                                        'name' => 'trb_tgl_akhir',
                                                        'class' => 'form-control text-middle rounded-0 datepicker',
                                                        'value' => isset($surat) ? date('d/m/Y', strtotime($surat->trb_tgl_akhir)) : '',
                                                        'placeholder' => 'Tgl Sembuh ...',
                                                        'autocomplete' => 'off'
                                                    )) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Surat THT Section -->
                                    <div id="15" class="divSurat">
                                        <div id="tht" class="form-group row">
                                            <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Telinga Kiri</label>
                                            <div class="col-sm-3">
                                                <?php echo form_input(array(
                                                    'id' => 'tht_lt_kiri',
                                                    'name' => 'tht_lt_kiri',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->tht_lt_kiri : '',
                                                    'placeholder' => 'Bagian Kiri ...'
                                                )) ?>
                                            </div>
                                            <label for="inputTglSuratSehat" class="col-sm-3 col-form-label">Telinga Kanan</label>
                                            <div class="col-sm-3">
                                                <?php echo form_input(array(
                                                    'id' => 'tht_lt_kanan',
                                                    'name' => 'tht_lt_kanan',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->tht_lt_kanan : '',
                                                    'placeholder' => 'Bagian Kanan ...'
                                                )) ?>
                                            </div>
                                        </div>
                                        <div id="tht" class="form-group row">
                                            <label for="tht" class="col-sm-3 col-form-label">Membran Kiri</label>
                                            <div class="col-sm-3">
                                                <?php echo form_input(array(
                                                    'id' => 'tht_membran_kiri',
                                                    'name' => 'tht_membran_kiri',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->tht_membran_kiri : '',
                                                    'placeholder' => 'Bagian Kiri ...'
                                                )) ?>
                                            </div>
                                            <label for="tht" class="col-sm-3 col-form-label">Membran Kanan</label>
                                            <div class="col-sm-3">
                                                <?php echo form_input(array(
                                                    'id' => 'tht_membran_kanan',
                                                    'name' => 'tht_membran_kanan',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->tht_membran_kanan : '',
                                                    'placeholder' => 'Bagian Kanan ...'
                                                )) ?>
                                            </div>
                                        </div>
                                        <div id="tht" class="form-group row">
                                            <label for="tht" class="col-sm-3 col-form-label">Mukosa</label>
                                            <div class="col-sm-3">
                                                <?php echo form_input(array(
                                                    'id' => 'tht_mukosa_kiri',
                                                    'name' => 'tht_mukosa_kiri',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->tht_mukosa_kiri : '',
                                                    'placeholder' => 'Bagian Kiri ...'
                                                )) ?>
                                            </div>
                                            <label for="tht" class="col-sm-3 col-form-label">Mukosa</label>
                                            <div class="col-sm-3">
                                                <?php echo form_input(array(
                                                    'id' => 'tht_mukosa_kanan',
                                                    'name' => 'tht_mukosa_kanan',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->tht_mukosa_kanan : '',
                                                    'placeholder' => 'Bagian Kanan ...'
                                                )) ?>
                                            </div>
                                        </div>
                                        <div id="tht" class="form-group row">
                                            <label for="tht" class="col-sm-3 col-form-label">Konka Inferior</label>
                                            <div class="col-sm-3">
                                                <?php echo form_input(array(
                                                    'id' => 'tht_konka_kiri',
                                                    'name' => 'tht_konka_kiri',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->tht_konka_kiri : '',
                                                    'placeholder' => 'Bagian Kiri ...'
                                                )) ?>
                                            </div>
                                            <label for="tht" class="col-sm-3 col-form-label">Konka Inferior</label>
                                            <div class="col-sm-3">
                                                <?php echo form_input(array(
                                                    'id' => 'tht_konka_kanan',
                                                    'name' => 'tht_konka_kanan',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->tht_konka_kanan : '',
                                                    'placeholder' => 'Bagian Kanan ...'
                                                )) ?>
                                            </div>
                                        </div> 
                                        <div id="tht" class="form-group row">
                                            <label for="tht" class="col-sm-3 col-form-label">Timpanometri</label>
                                            <div class="col-sm-3">
                                                <?php echo form_input(array(
                                                    'id' => 'tht_timpa_kiri',
                                                    'name' => 'tht_timpa_kiri',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->tht_timpa_kiri : '',
                                                    'placeholder' => 'Bagian Kiri ...'
                                                )) ?>
                                            </div>
                                            <label for="tht" class="col-sm-3 col-form-label">Timpanometri</label>
                                            <div class="col-sm-3">
                                                <?php echo form_input(array(
                                                    'id' => 'tht_timpa_kanan',
                                                    'name' => 'tht_timpa_kanan',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->tht_timpa_kanan : '',
                                                    'placeholder' => 'Bagian Kanan ...'
                                                )) ?>
                                            </div>
                                        </div>
                                        <div id="tht" class="form-group row">
                                            <label for="tht" class="col-sm-3 col-form-label">Tonsil Tenggorokan</label>
                                            <div class="col-sm-3">
                                                <?php echo form_input(array(
                                                    'id' => 'tht_tonsil_tg',
                                                    'name' => 'tht_tonsil_tg',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->tht_tonsil_tg : '',
                                                    'placeholder' => 'Tonsil ...'
                                                )) ?>
                                            </div>
                                            <label for="tht" class="col-sm-3 col-form-label">Mukosa Tenggorokan</label>
                                            <div class="col-sm-3">
                                                <?php echo form_input(array(
                                                    'id' => 'tht_mukosa_tg',
                                                    'name' => 'tht_mukosa_tg',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->tht_mukosa_tg : '',
                                                    'placeholder' => 'Mukosa ...'
                                                )) ?>
                                            </div>
                                        </div>
                                        <div id="tht" class="form-group row">
                                            <label for="tht" class="col-sm-3 col-form-label">Dinding Faring</label>
                                            <div class="col-sm-3">
                                                <?php echo form_input(array(
                                                    'id' => 'tht_faring_tg',
                                                    'name' => 'tht_faring_tg',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->tht_faring_tg : '',
                                                    'placeholder' => 'Faring ...'
                                                )) ?>
                                            </div>
                                        </div>                                   
                                        <div id="tht" class="form-group row">
                                            <label for="tht" class="col-sm-3 col-form-label">Kesimpulan</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input(array(
                                                    'id' => 'tht_kesimpulan',
                                                    'name' => 'tht_kesimpulan',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->tht_kesimpulan : '',
                                                    'placeholder' => 'Kesimpulan ...'
                                                )) ?>
                                            </div>
                                        </div>                                   
                                        <div id="tht" class="form-group row">
                                            <label for="tht" class="col-sm-3 col-form-label">Audio</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input(array(
                                                    'id' => 'tht_audio',
                                                    'name' => 'tht_audio',
                                                    'class' => 'form-control text-middle rounded-0',
                                                    'value' => isset($surat) ? $surat->tht_audio : '',
                                                    'placeholder' => 'Audio ...'
                                                )) ?>
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

                    <!-- Data Surat Table -->
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
                                                <?php $sql_dokter = $this->db->where('id_user', $surat->id_dokter)->get('tbl_m_karyawan')->row(); ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no . '.'; ?></td>
                                                    <td class="text-left">
                                                        <small><i><?php echo $this->tanggalan->tgl_indo5($surat->tgl_simpan); ?></i></small>
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
                                                        <?php echo anchor(base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=' . $this->input->get('status') . '&id_form=' . general::enkrip($surat->id) . '&tipe=' . $surat->tipe), '<i class="fa fa-edit"></i> Ubah', 'class="btn btn-primary btn-flat btn-xs" style="width: 55px;"') ?>
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

<!-- Required Scripts -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

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

        // Initialize all sections as hidden
        $("div.divSurat").hide();
        
        // Show the selected section based on tipe_surat
        var selectedTipe = $('#tipe_surat').val();
        if (selectedTipe) {
            $("#" + selectedTipe).show().find('input').prop('disabled', false);
        }

        // Datepicker initialization for all date inputs
        $('.datepicker').datepicker({
            dateFormat: 'dd-mm-yy',
            autoclose: true
        });

        // Handle tipe_surat change
        $('#tipe_surat').on('change', function () {
            var tipe_surat = $(this).val();
            $("div.divSurat").hide();
            $("#" + tipe_surat).show().find('input').prop('disabled', false);
        });

        // Handle sembuh checkbox
        $('#ckSembuh').click(function () {
            if ($(this).prop('checked') == true) {
                $('#inputTglSuratKeluar').hide();
            } else {
                $('#inputTglSuratKeluar').show();
            }
        });
    });
</script>