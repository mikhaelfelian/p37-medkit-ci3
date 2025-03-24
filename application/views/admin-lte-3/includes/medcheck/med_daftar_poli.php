<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label">Referensi</label>
            <select id="referall" name="referall" class="form-control rounded-0">
                <option value="">- REFERENSI -</option>
                <?php foreach ($sql_kary as $karyawan) { ?>
                    <option value="<?php echo $karyawan->id_user ?>" <?php // echo ($sql_dft_id->tipe_bayar == $penj->id ? 'selected' : '') ?>><?php echo $karyawan->nama ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group <?php echo (!empty($hasError['platform']) ? 'text-danger' : '') ?>">
            <label class="control-label">Penjamin</label>
            <select id="platform" name="platform"
                class="form-control rounded-0 rounded-0<?php echo (!empty($hasError['platform']) ? ' is-invalid' : '') ?>">
                <option value="">- PENJAMIN -</option>
                <?php foreach ($sql_penjamin as $penj) { ?>
                    <option value="<?php echo $penj->id ?>" <?php echo ($sql_dft_id->tipe_bayar == $penj->id ? 'selected' : '') ?>><?php echo $penj->penjamin ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group <?php echo (!empty($hasError['tipe_rawat']) ? 'text-danger' : '') ?>">
            <label class="control-label">TIPE PERAWATAN</label>
            <select id="tipe_rawat" name="tipe_rawat"
                class="form-control rounded-0 rounded-0<?php echo (!empty($hasError['tipe_rawat']) ? ' is-invalid' : '') ?>">
                <option value="">- Tipe -</option>
                <option value="1" <?php echo (!empty($sql_dft_id->tipe_rawat) && $sql_dft_id->tipe_rawat == 1 ? 'selected' : '') ?>>Laborat</option>
                <option value="4" <?php echo (!empty($sql_dft_id->tipe_rawat) && $sql_dft_id->tipe_rawat == 4 ? 'selected' : '') ?>>Radiologi</option>
                <option value="2" <?php echo (!empty($sql_dft_id->tipe_rawat) && $sql_dft_id->tipe_rawat == 2 ? 'selected' : '') ?>>Rawat Jalan</option>
                <option value="3" <?php echo (!empty($sql_dft_id->tipe_rawat) && $sql_dft_id->tipe_rawat == 3 ? 'selected' : '') ?>>Rawat Inap</option>
                <option value="5" <?php echo (!empty($sql_dft_id->tipe_rawat) && $sql_dft_id->tipe_rawat == 5 ? 'selected' : '') ?>>MCU</option>
            </select>
        </div>
        <div class="form-group <?php echo (!empty($hasError['poli']) ? 'text-danger' : '') ?>">
            <label class="control-label">Poli</label>
            <select id="poli" name="poli"
                class="form-control rounded-0 select2bs4 <?php echo (!empty($hasError['poli']) ? ' is-invalid' : '') ?>">
                <option value="">- Poli -</option>
                <?php foreach ($poli as $poli) { ?>
                    <option value="<?php echo $poli->id ?>" <?php echo (!empty($sql_dft_id->id_poli) ? ($poli->id == $sql_dft_id->id_poli ? 'selected' : '') : (($poli->id == $this->session->flashdata('poli') ? 'selected' : ''))) ?>><?php echo $poli->lokasi ?></option>
                <?php } ?>
            </select>
        </div>
        <?php if (isset($sql_dft_id->id_dokter)) { ?>
            <div class="form-group <?php echo (!empty($hasError['dokter']) ? 'text-danger' : '') ?>">
                <label class="control-label">Dokter</label>
                <select name="dokter"
                    class="form-control rounded-0 select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                    <option value="">- Dokter -</option>
                    <?php foreach ($sql_doc as $doctor) { ?>
                        <option value="<?php echo $doctor->id ?>" <?php echo (!empty($sql_dft_id->id_dokter) ? ($doctor->id_user == $sql_dft_id->id_dokter ? 'selected' : '') : (($doctor->id == $this->session->flashdata('dokter') ? 'selected' : ''))) ?>>
                            <?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . strtoupper($doctor->nama) . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        <?php } else { ?>
            <div class="form-group <?php echo (!empty($hasError['dokter']) ? 'text-danger' : '') ?>">
                <label class="control-label">Dokter</label>
                <select id="dokter" name="dokter"
                    class="form-control rounded-0 select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                    <option value="">- Dokter -</option>
                    <!-- <?php // foreach ($sql_doc as $doctor) { ?> -->
                    <!--<option value="<?php // echo $doctor->id ?>" <?php // echo (!empty($sql_dft_id->id_dokter) ? ($doctor->id == $sql_dft_id->id_dokter ? 'selected' : '') : (($doctor->id == $this->session->flashdata('dokter') ? 'selected' : ''))) ?>><?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . strtoupper($doctor->nama) . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?></option>-->
                    <?php // } ?>
                </select>
            </div>
        <?php } ?>
        <div class="form-group <?php echo (!empty($hasError['alergi']) ? 'has-error' : '') ?>">
            <label class="control-label">Alergi Obat ?</label>
            <?php echo form_input(array('id' => 'alergi', 'name' => 'alergi', 'class' => 'form-control rounded-0', 'value' => (!empty($pasien->alergi) ? $pasien->alergi : $this->session->flashdata('alergi')), 'placeholder' => 'Ada alergi obat ...')) ?>
        </div>
        <div class="form-group">
            <label class="control-label">Tgl Periksa*</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text rounded-0"><i class="fas fa-calendar"></i></span>
                </div>
                <?php echo form_input(array('id' => 'tgl_masuk', 'name' => 'tgl_masuk', 'class' => 'form-control rounded-0 pull-right', 'placeholder' => 'Silahkan isi tgl periksa ...', 'value' => date('d-m-Y'))) ?>
            </div>
        </div>
    </div>
</div>