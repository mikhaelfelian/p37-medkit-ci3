<div class="row">
    <div class="col-md-12">
        <div class="form-group <?php echo (!empty($hasError['platform']) ? 'text-danger' : '') ?>">
            <label class="control-label">Penjamin</label>
            <select id="platform" name="platform" class="form-control rounded-0<?php echo (!empty($hasError['platform']) ? ' is-invalid' : '') ?>">
                <option value="">- PENJAMIN -</option>
                <?php foreach ($sql_penjamin as $penj){ ?>
                    <option value="<?php echo $penj->id ?>"><?php echo $penj->penjamin ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group <?php echo (!empty($hasError['poli']) ? 'text-danger' : '') ?>">
            <label class="control-label">Poli</label>
            <select id="poli" name="poli" class="form-control select2bs4 <?php echo (!empty($hasError['poli']) ? ' is-invalid' : '') ?>">
                <option value="">- Poli -</option>
                <?php foreach ($poli as $poli) { ?>
                    <option value="<?php echo $poli->id ?>" <?php echo (!empty($pasien->id_pekerjaan) ? ($poli->id == $pasien->id_poli ? 'selected' : '') : (($poli->id == $this->session->flashdata('poli') ? 'selected' : ''))) ?>><?php echo $poli->lokasi ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group <?php echo (!empty($hasError['dokter']) ? 'text-danger' : '') ?>">
            <label class="control-label">Dokter</label>
            <select id="dokter" name="dokter" class="form-control select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                <option value="">- Dokter -</option>
                <?php foreach ($sql_doc as $doctor) { ?>
                    <option value="<?php echo $doctor->id ?>" <?php echo (!empty($pasien->id_dokter) ? ($doctor->id == $pasien->id_dokter ? 'selected' : '') : (($doctor->id == $this->session->flashdata('dokter') ? 'selected' : ''))) ?>><?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn.' ' : '').strtoupper($doctor->nama).(!empty($doctor->nama_blk) ? ', '.$doctor->nama_blk : '') ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group <?php echo (!empty($hasError['alergi']) ? 'has-error' : '') ?>">
            <label class="control-label">Alergi Obat ?</label>
            <?php echo form_input(array('id' => 'alergi', 'name' => 'alergi', 'class' => 'form-control', 'value' => $this->session->flashdata('alergi'), 'placeholder' => 'Ada alergi obat ...')) ?>
        </div>
        <div class="form-group">
            <label class="control-label">Tgl Periksa*</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                </div>
                <?php echo form_input(array('id' => 'tgl_masuk', 'name' => 'tgl_masuk', 'class' => 'form-control pull-right', 'placeholder' => 'Silahkan isi tgl periksa ...', 'value' => date('m/d/Y'))) ?>
            </div>
        </div>
    </div>
</div>