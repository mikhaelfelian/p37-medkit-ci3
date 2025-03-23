<div class="col-md-6">
    <section id="pasien_baru1">
        <div class="form-group">
            <label class="control-label"><?php echo (!empty($pasien) ? 'NIK <small><i>(* KTP / Passport / KIA)</i></small>' : 'Cari Pasien*') ?></label>
            <div class="input-group mb-3">
                <?php echo form_input(array('id' => 'nik_lama', 'name' => 'nik_lama', 'class' => 'form-control' . (!empty($hasError['nik']) ? ' is-invalid' : ''), 'value' => (!empty($pasien->nik) ? $pasien->nik : $this->session->flashdata('nik_lama')), 'placeholder' => ($pasien->nik == '' ? 'Cari data Pasien' : ''))) ?>
                <?php if (empty($pasien)) { ?>
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                <?php } ?>
            </div>                                                    
        </div>

        <?php if (!empty($pasien)) { ?>
            <?php if ($_GET['act'] == 'ubah_data') { ?>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label class="control-label">Gelar*</label>
                            <select name="gelar" class="form-control <?php echo (!empty($hasError['gelar']) ? 'is-invalid' : '') ?>">
                                <option value="">- Pilih -</option>
                                <?php foreach ($gelar as $gelar) { ?>
                                    <option value="<?php echo $gelar->id ?>" <?php echo ($gelar->id == $pasien->id_gelar ? 'selected' : '') ?>><?php echo $gelar->gelar ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'text-danger' : '') ?>">
                            <label class="control-label">Nama Lengkap*</label>
                            <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'value' => (!empty($pasien->nama) ? $pasien->nama : $this->session->flashdata('nama')), 'placeholder' => 'John Doe ...')) ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Jenis Kelamin*</label>
                    <select name="jns_klm" class="form-control <?php echo (!empty($hasError['jns_klm']) ? 'is-invalid' : '') ?>">
                        <option value="">- Pilih -</option>
                        <option value="L" <?php echo (!empty($pasien->jns_klm) ? ('L' == $pasien->jns_klm ? 'selected' : '') : ('L' == $this->session->flashdata('jns_klm') ? 'selected' : '')) ?>>Laki - laki</option>
                        <option value="P" <?php echo (!empty($pasien->jns_klm) ? ('P' == $pasien->jns_klm ? 'selected' : '') : ('P' == $this->session->flashdata('jns_klm') ? 'selected' : '')) ?>>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Tempat Lahir</label>
                    <?php echo form_input(array('id' => 'tmp_lahir', 'name' => 'tmp_lahir', 'class' => 'form-control', 'value' => (!empty($pasien->tmp_lahir) ? $pasien->tmp_lahir : $this->session->flashdata('tmp_lahir')), 'placeholder' => 'Semarang ...')) ?>
                </div>
                <div class="form-group">
                    <label class="control-label">Tgl Lahir *(Bulan/Tanggal/Tahun) - mm/dd/YYYY</label>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <?php echo form_input(array('id' => 'tgl_lahir', 'name' => 'tgl_lahir', 'class' => 'form-control', 'value' => (!empty($pasien->tgl_lahir) ? $this->tanggalan->tgl_indo($pasien->tgl_lahir) : $this->session->flashdata('tgl_lahir')), 'placeholder' => 'Isi dengan format berikut : 02/15/1992 ...')) ?>
                    </div>                                        
                </div>

                <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                    <label class="control-label">No. HP</label>
                    <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control', 'value' => (!empty($pasien->no_hp) ? $pasien->no_hp : $this->session->flashdata('no_hp')), 'placeholder' => 'Nomor kontak pasien / keluarga pasien ...')) ?>
                </div>
            <?php } else { ?>
                <div class="row">
                    <div class="col-3">
                        <?php echo form_hidden('gelar', $pasien->id_gelar) ?>
                        <div class="form-group">
                            <label class="control-label">Gelar*</label>
                            <select name="" class="form-control <?php echo (!empty($hasError['gelar']) ? 'is-invalid' : '') ?>" readonly="TRUE">
                                <option value="">- Pilih -</option>
                                <?php foreach ($gelar as $gelar) { ?>
                                    <option value="<?php echo $gelar->id ?>" <?php echo ($gelar->id == $pasien->id_gelar ? 'selected' : '') ?>><?php echo $gelar->gelar ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'text-danger' : '') ?>">
                            <label class="control-label">Nama Lengkap*</label>
                            <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'value' => (!empty($pasien->nama) ? $pasien->nama : $this->session->flashdata('nama')), 'placeholder' => 'John Doe ...', 'readonly' => 'TRUE')) ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_hidden('jns_klm', $pasien->jns_klm) ?>
                    <label class="control-label">Jenis Kelamin*</label>
                    <select name="" class="form-control <?php echo (!empty($hasError['jns_klm']) ? 'is-invalid' : '') ?>"  readonly="TRUE">
                        <option value="">- Pilih -</option>
                        <option value="L" <?php echo (!empty($pasien->jns_klm) ? ('L' == $pasien->jns_klm ? 'selected' : '') : ('L' == $this->session->flashdata('jns_klm') ? 'selected' : '')) ?>>Laki - laki</option>
                        <option value="P" <?php echo (!empty($pasien->jns_klm) ? ('P' == $pasien->jns_klm ? 'selected' : '') : ('P' == $this->session->flashdata('jns_klm') ? 'selected' : '')) ?>>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Tempat Lahir</label>
                    <?php echo form_input(array('id' => 'tmp_lahir', 'name' => 'tmp_lahir', 'class' => 'form-control', 'value' => (!empty($pasien->tmp_lahir) ? $pasien->tmp_lahir : $this->session->flashdata('tmp_lahir')), 'placeholder' => 'Semarang ...', 'readonly' => 'TRUE')) ?>
                </div>
                <div class="form-group">
                    <label class="control-label">Tgl Lahir *(Bulan/Tanggal/Tahun) - mm/dd/YYYY</label>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <?php echo form_input(array('id' => '', 'name' => 'tgl_lahir', 'class' => 'form-control', 'value' => (!empty($pasien->tgl_lahir) ? $this->tanggalan->tgl_indo($pasien->tgl_lahir) : $this->session->flashdata('tgl_lahir')), 'placeholder' => 'Isi dengan format berikut : 02/15/1992 ...', 'readonly' => 'TRUE')) ?>
                    </div>                                        
                </div>
                <div class="form-group">
                    <label class="control-label">No. HP</label>
                    <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control', 'value' => (!empty($pasien->no_hp) ? $pasien->no_hp : $this->session->flashdata('no_hp')), 'placeholder' => 'Nomor kontak pasien / keluarga pasien ...', 'readonly' => 'TRUE')) ?>
                </div>
            <?php } ?>
        <?php } ?>
    </section>
</div>
<div class="col-md-6">
    <?php if (!empty($pasien)) { ?>
        <?php if ($_GET['act'] == 'ubah_data') { ?>
            <section id="pasien_baru2">
                <div class="form-group <?php echo (!empty($hasError['nik']) ? 'has-error' : '') ?>">
                    <label class="control-label">Alamat KTP<small><i>* Sesuai Identitas</i></small></label>
                    <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control', 'value' => (!empty($pasien->alamat) ? $pasien->alamat : $this->session->flashdata('alamat')), 'style' => 'height: 124px;', 'placeholder' => 'Mohon diisi alamat lengkap ...')) ?>
                </div>
                <div class="form-group <?php echo (!empty($hasError['nik']) ? 'has-error' : '') ?>">
                    <label class="control-label">Alamat Domisili<small><i>* Sesuai Domisili</i></small></label>
                    <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat_dom', 'class' => 'form-control', 'value' => (!empty($pasien->alamat_dom) ? $pasien->alamat_dom : $this->session->flashdata('alamat_dom')), 'style' => 'height: 124px;', 'placeholder' => 'Mohon diisi alamat lengkap ...')) ?>
                </div>

                <div class="form-group">
                    <label class="control-label">Pekerjaan</label>
                    <select name="pekerjaan" class="form-control select2bs4">
                        <option value="">- Pilih -</option>
                        <?php foreach ($kerja as $kerja) { ?>
                            <option value="<?php echo $kerja->id ?>" <?php echo (!empty($pasien->id_pekerjaan) ? ($kerja->id == $pasien->id_pekerjaan ? 'selected' : '') : (($kerja->id == $this->session->flashdata('pekerjaan') ? 'selected' : ''))) ?>><?php echo $kerja->jenis ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="control-label">No. Rmh</label>
                    <?php echo form_input(array('id' => 'no_rmh', 'name' => 'no_rmh', 'class' => 'form-control', 'value' => (!empty($pasien->no_rmh) ? $pasien->no_rmh : $this->session->flashdata('no_rmh')), 'placeholder' => 'Nomor kontak pasien / keluarga pasien ...')) ?>
                </div>
            </section>                                                
        <?php } else { ?>
            <section id="pasien_baru2">
                <div class="form-group <?php echo (!empty($hasError['nik']) ? 'has-error' : '') ?>">
                    <label class="control-label">Alamat KTP<small><i>* Sesuai Identitas</i></small></label>
                    <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control', 'value' => (!empty($pasien->alamat) ? $pasien->alamat : $this->session->flashdata('alamat')), 'style' => 'height: 124px;', 'placeholder' => 'Mohon diisi alamat lengkap ...', 'disabled' => 'TRUE')) ?>
                </div>
                <div class="form-group <?php echo (!empty($hasError['nik']) ? 'has-error' : '') ?>">
                    <label class="control-label">Alamat Domisili<small><i>* Sesuai Domisili</i></small></label>
                    <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat_dom', 'class' => 'form-control', 'value' => (!empty($pasien->alamat_dom) ? $pasien->alamat_dom : $this->session->flashdata('alamat_dom')), 'style' => 'height: 124px;', 'placeholder' => 'Mohon diisi alamat lengkap ...', 'disabled' => 'TRUE')) ?>
                </div>

                <div class="form-group">
                    <?php echo form_hidden('pekerjaan', $pasien->id_pekerjaan) ?>
                    <label class="control-label">Pekerjaan</label>
                    <select name="" readonly="TRUE" class="form-control">
                        <option value="">- Pilih -</option>
                        <?php foreach ($kerja as $kerja) { ?>
                            <option value="<?php echo $kerja->id ?>" <?php echo (!empty($pasien->id_pekerjaan) ? ($kerja->id == $pasien->id_pekerjaan ? 'selected' : '') : (($kerja->id == $this->session->flashdata('pekerjaan') ? 'selected' : ''))) ?>><?php echo $kerja->jenis ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="control-label">No. Rmh</label>
                    <?php echo form_input(array('id' => 'no_rmh', 'name' => 'no_rmh', 'class' => 'form-control', 'value' => (!empty($pasien->no_rmh) ? $pasien->no_rmh : $this->session->flashdata('no_rmh')), 'placeholder' => 'Nomor kontak pasien / keluarga pasien ...', 'readonly' => 'TRUE')) ?>
                </div>
            </section>
        <?php } ?>
    <?php } ?>
</div>
<?php if ($_GET['act'] == 'ubah_data') { ?>
    <div class="col-md-6">
        <section id="pasien_baru2">
            <div class="form-group">
                <label class="control-label">Instansi / Perusahaan</label>
                <?php echo form_input(array('id' => 'instansi', 'name' => 'instansi', 'class' => 'form-control', 'value' => (!empty($pasien->instansi) ? $pasien->instansi : $this->session->flashdata('instansi')), 'placeholder' => 'Isikan nama Instansi / Perusahaan ...')) ?>
            </div>
        </section>
    </div>
    <div class="col-md-6">
        <section id="pasien_baru2">
            <div class="form-group">
                <label class="control-label">Alamat Instansi</label>
                <?php echo form_input(array('id' => 'instansi_almt', 'name' => 'instansi_almt', 'class' => 'form-control', 'value' => (!empty($pasien->instansi_alamat) ? $pasien->instansi_alamat : $this->session->flashdata('instansi_alamat')), 'placeholder' => 'Isikan alamat lengkapnya ...')) ?>
            </div>
        </section>
    </div>
<?php } else { ?>
    <div class="col-md-6">
        <section id="pasien_baru2">
            <div class="form-group">
                <label class="control-label">Instansi / Perusahaan</label>
                <?php echo form_input(array('id' => 'instansi', 'name' => 'instansi', 'class' => 'form-control', 'value' => (!empty($pasien->instansi) ? $pasien->instansi : $this->session->flashdata('instansi')), 'placeholder' => 'Isikan nama Instansi / Perusahaan ...', 'readonly' => 'TRUE')) ?>
            </div>
        </section>
    </div>
    <div class="col-md-6">
        <section id="pasien_baru2">
            <div class="form-group">
                <label class="control-label">Alamat Instansi</label>
                <?php echo form_input(array('id' => 'instansi_almt', 'name' => 'instansi_almt', 'class' => 'form-control', 'value' => (!empty($pasien->instansi_alamat) ? $pasien->instansi_alamat : $this->session->flashdata('instansi_alamat')), 'placeholder' => 'Isikan alamat lengkapnya ...', 'readonly' => 'TRUE')) ?>
            </div>
        </section>
    </div>
<?php } ?>