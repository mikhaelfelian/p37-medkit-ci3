<input type="hidden" id="nik_lama">
<div class="col-md-6">
    <section id="pasien_baru1">
        <div class="form-group <?php echo (!empty($hasError['nik']) ? 'text-danger' : '') ?>">
            <label class="control-label">NIK <small><i>(* KTP / Passport / KIA)</i></small></label>
            <?php echo form_input(array('id' => 'nik_baru', 'name' => 'nik', 'class' => 'form-control rounded-0' . (!empty($hasError['nik']) ? ' is-invalid' : ''), 'value' => (!empty($sql_dft_id->nik) ? $sql_dft_id->nik : $this->session->flashdata('nik_baru')), 'value' => $sql_dft_id->nik, 'placeholder' => 'Nomor Identitas ...')) ?>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group <?php echo (!empty($hasError['gelar']) ? 'text-danger' : '') ?>">
                    <label class="control-label">Gelar*</label>
                    <select name="gelar"
                        class="form-control rounded-0 <?php echo (!empty($hasError['gelar']) ? 'is-invalid' : '') ?>">
                        <option value="">- Pilih -</option>
                        <?php foreach ($gelar as $gelar) { ?>
                            <option value="<?php echo $gelar->id ?>" <?php echo ($gelar->id == $sql_dft_id->id_gelar ? 'selected' : '') ?>><?php echo $gelar->gelar ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-9">
                <div class="form-group <?php echo (!empty($hasError['nama']) ? 'text-danger' : '') ?>">
                    <label class="control-label">Nama Lengkap*</label>
                    <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control rounded-0' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'value' => (!empty($sql_dft_id->nama) ? $sql_dft_id->nama : $this->session->flashdata('nama')), 'placeholder' => 'John Doe ...')) ?>
                </div>
            </div>
        </div>
        <div class="form-group <?php echo (!empty($hasError['jns_klm']) ? 'text-danger' : '') ?>">
            <label class="control-label">Jenis Kelamin*</label>
            <select name="jns_klm"
                class="form-control rounded-0 <?php echo (!empty($hasError['jns_klm']) ? 'is-invalid' : '') ?>">
                <option value="">- Pilih -</option>
                <option value="L" <?php echo (!empty($sql_dft_id->jns_klm) ? ('L' == $sql_dft_id->jns_klm ? 'selected' : '') : ('L' == $this->session->flashdata('jns_klm') ? 'selected' : '')) ?>>Laki - laki</option>
                <option value="P" <?php echo (!empty($sql_dft_id->jns_klm) ? ('P' == $sql_dft_id->jns_klm ? 'selected' : '') : ('P' == $this->session->flashdata('jns_klm') ? 'selected' : '')) ?>>Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">Tempat Lahir</label>
            <?php echo form_input(array('id' => 'tmp_lahir', 'name' => 'tmp_lahir', 'class' => 'form-control rounded-0', 'value' => (!empty($sql_dft_id->tmp_lahir) ? $sql_dft_id->tmp_lahir : $this->session->flashdata('tmp_lahir')), 'placeholder' => 'Isikan Tempat Lahir ...')) ?>
        </div>
        <div class="form-group">
            <label class="control-label">Tgl Lahir *(Bulan/Tanggal/Tahun) - mm/dd/YYYY</label>
            <div class="input-group mb-3">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                </div>
                <?php echo form_input(array('id' => 'tgl_lahir', 'name' => 'tgl_lahir', 'class' => 'form-control rounded-0', 'value' => (!empty($sql_dft_id->tgl_lahir) ? $this->tanggalan->tgl_indo8($sql_dft_id->tgl_lahir) : $this->session->flashdata('tgl_lahir')), 'placeholder' => 'Isi dengan format berikut : 02/15/1992 ...', 'readonly' => 'TRUE')) ?>
            </div>
        </div>
        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
            <label class="control-label">No. HP / WA</label>
            <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control rounded-0', 'value' => (!empty($sql_dft_id->kontak) ? $sql_dft_id->kontak : $this->session->flashdata('no_hp')), 'placeholder' => 'Nomor kontak WA pasien / keluarga pasien ...')) ?>
        </div>
    </section>
</div>
<div class="col-md-6">
    <section id="pasien_baru2">
        <div class="form-group <?php echo (!empty($hasError['alamat']) ? 'text-danger' : '') ?>">
            <label class="control-label">Alamat KTP<small><i>* Sesuai Identitas</i></small></label>
            <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control rounded-0' . (!empty($hasError['alamat']) ? ' is-invalid' : ''), 'value' => (!empty($sql_dft_id->alamat) ? $sql_dft_id->alamat : $this->session->flashdata('alamat')), 'style' => 'height: 124px;', 'placeholder' => 'Mohon diisi alamat sesuai pada identitas ...')) ?>
        </div>
        <div class="form-group <?php echo (!empty($hasError['alamat']) ? 'text-danger' : '') ?>">
            <label class="control-label">Alamat Domisili<small><i>* Sesuai Domisili</i></small></label>
            <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat_dom', 'class' => 'form-control rounded-0' . (!empty($hasError['alamat_dom']) ? ' is-invalid' : ''), 'value' => (!empty($sql_dft_id->alamat) ? $sql_dft_id->alamat : $this->session->flashdata('alamat')), 'style' => 'height: 124px;', 'placeholder' => 'Mohon diisi alamat sesuai domisili ...')) ?>
        </div>
        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
            <label class="control-label">Pekerjaan</label>
            <select name="pekerjaan" class="form-control rounded-0 select2bs4">
                <option value="">- Pilih -</option>
                <?php foreach ($kerja as $kerja) { ?>
                    <option value="<?php echo $kerja->id ?>" <?php echo (!empty($sql_dft_id->id_pekerjaan) ? ($kerja->id == $sql_dft_id->id_pekerjaan ? 'selected' : '') : (($kerja->id == $this->session->flashdata('pekerjaan') ? 'selected' : ''))) ?>>
                        <?php echo $kerja->jenis ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
            <label class="control-label">No. Rmh</label>
            <?php echo form_input(array('id' => 'no_rmh', 'name' => 'no_rmh', 'class' => 'form-control rounded-0', 'value' => (!empty($sql_dft_id->kontak_rmh) ? $sql_dft_id->kontak_rmh : $this->session->flashdata('no_rmh')), 'placeholder' => 'Isikan Nomor rumah (PSTN) pasien / keluarga pasien ...')) ?>
        </div>
    </section>
</div>
<div class="col-md-6">
    <section id="pasien_baru2">
        <div class="form-group">
            <label class="control-label">Instansi / Perusahaan</label>
            <select name="instansi" class="form-control rounded-0 select2bs4">
                <option value="">- Pilih -</option>
                <?php foreach ($this->db->get('tbl_m_pelanggan')->result() as $instansi) { ?>
                    <option value="<?php echo $instansi->id ?>" <?php echo (!empty($pasien->id_pekerjaan) ? ($instansi->nama == $pasien->instansi ? 'selected' : '') : (($kerja->id == $this->session->flashdata('pekerjaan') ? 'selected' : ''))) ?>>
                        <?php echo $instansi->nama ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </section>
</div>
<div class="col-md-6">
    <section id="pasien_baru2">
        <div class="form-group">
            <label class="control-label">&nbsp;</label><br />
            <button type="button" class="btn btn-primary btn-flat rounded-0" data-toggle="modal"
                data-target="#modalTambahKlinik">
                <i class="fa fa-plus-circle"></i> Tambah
            </button>
        </div>
    </section>
</div>