<?php echo form_open(base_url('medcheck/set_medcheck_lab_spr_upd.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_lab_spiro', general::enkrip($sql_medc_lab_spr_rw->id)); ?>
<?php echo form_hidden('id_analis', (!empty($sql_medc_lab_spr_rw->id_analis) ? general::enkrip($sql_medc_lab_spr_rw->id_analis) : general::enkrip($this->ion_auth->user()->row()->id))); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>
<?php echo form_hidden('act', $this->input->get('act')); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">[SPIROMETRI] INSTALASI LABORATORIUM - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <?php // if (akses::hakDokter() != TRUE) { ?>
                    <?php $hasError = $this->session->flashdata('form_error'); ?>
                    <div class="form-group <?php echo (!empty($hasError['tgl_masuk']) ? 'text-danger' : '') ?>">
                        <label for="inputEmail3">Tanggal</label>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            </div>
                            <?php echo form_input(array('id' => 'tgl_masuk', 'name' => 'tgl_masuk', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['tgl_masuk']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Tgl Entri ...', 'value' => $this->tanggalan->tgl_indo($sql_medc_lab_spr_rw->tgl_masuk))) ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo (!empty($hasError['no_sampel']) ? 'text-danger' : '') ?>">
                        <label for="inputEmail3">No. Sampel*</label>
                        <?php echo form_input(array('id' => 'no_sampel', 'name' => 'no_sampel', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['no_sampel']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan No Sample ...', 'value' => $sql_medc_lab_spr_rw->no_sample)) ?>
                    </div>
                    <div class="form-group <?php echo (!empty($hasError['dokter']) ? 'text-danger' : '') ?>">
                        <label for="inputEmail3">Dokter*</label>
                        <select id="dokter" name="dokter" class="form-control rounded-0 select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                            <option value="">- Dokter -</option>
                            <?php foreach ($sql_doc as $doctor) { ?>
                                <option value="<?php echo $doctor->id_user ?>" <?php echo ($doctor->id_user == $sql_medc_lab_spr_rw->id_dokter ? 'selected' : '') ?>><?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . $doctor->nama . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3">Keluhan <?php echo (!empty($hasError['keluhan']) ? 'text-danger' : '') ?></label>
                        <?php echo form_textarea(array('id' => 'keluhan', 'name' => 'keluhan', 'class' => 'form-control pull-left rounded-0' . (!empty($hasError['keluhan']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Keluhan Pasien ...', 'style' => 'height: 163px;', 'value' => $sql_medc_lab_spr_rw->keluhan)) ?>
                    </div>
                    <div class="form-group <?php echo (!empty($hasError['riwayat']) ? 'text-danger' : '') ?>">
                        <label for="inputEmail3">Riwayat Asma</label>
                        <?php echo form_textarea(array('id' => 'riwayat', 'name' => 'riwayat', 'class' => 'form-control pull-left rounded-0' . (!empty($hasError['riwayat']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Data Riwayat Asma pada Pasien ...', 'style' => 'height: 163px;', 'value' => $sql_medc_lab_spr_rw->riwayat)) ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group <?php echo (!empty($hasError['status_rokok']) ? 'text-danger' : '') ?>">
                        <label for="inputEmail3">Apakah Anda Perokok ?*</label><?php echo br(1) ?>
                        <select id="status_rokok" name="status_rokok" class="form-control rounded-0 <?php echo (!empty($hasError['status_rokok']) ? ' is-invalid' : '') ?>">
                            <option value="">- Pilih -</option>
                            <option value="1" <?php echo ($sql_medc_lab_spr_rw->status_rokok == '1' ? 'selected' : '') ?>>Ya, saya perokok</option>
                            <option value="2" <?php echo ($sql_medc_lab_spr_rw->status_rokok == '2' ? 'selected' : '') ?>>Tidak</option>
                        </select>
                    </div>
                    <div class="form-group <?php echo (!empty($hasError['tb']) ? 'text-danger' : '') ?>">
                        <label for="inputEmail3">Tinggi Badan*</label>
                        <?php echo form_input(array('id' => 'jml', 'name' => 'tb', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['tb']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Tinggi Badan ...', 'value' => $sql_medc_lab_spr_rw->tb)) ?>
                    </div>
                    <div class="form-group <?php echo (!empty($hasError['bb']) ? 'text-danger' : '') ?>">
                        <label for="inputEmail3">Berat Badan*</label>
                        <?php echo form_input(array('id' => 'jml', 'name' => 'bb', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['bb']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Tinggi Badan ...', 'value' => $sql_medc_lab_spr_rw->bb)) ?>
                    </div>
                    <div class="form-group <?php echo (!empty($hasError['imt']) ? 'text-danger' : '') ?>">
                        <label for="inputEmail3">IMT*</label>
                        <?php echo form_input(array('id' => 'jml', 'name' => 'imt', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['imt']) ? ' is-invalid' : ''), 'value' => (!empty($sql_medc_lab_spr_rw->imt) ? $sql_medc_lab_spr_rw->imt : 0), 'readonly'=>'TRUE')) ?>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3">Reference</label>
                        <?php echo form_input(array('id' => 'ref', 'name' => 'ref', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Isikan Nilai Standar Pneumobile, cth : Pneumobile Project Indonesia ...', 'value' => $sql_medc_lab_spr_rw->ref)) ?>
                    </div>
                <?php // } ?>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tambah.php?act=pen_spirometri&id=' . general::enkrip($sql_medc->id) . '&status=' . $this->input->get('status')) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">                                 
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>                            
    </div>
</div>
<?php echo form_close() ?>
<!-- Page script -->
<script type="text/javascript">
    $(function () {
//        $("input[id=jml]").autoNumeric({aSep: '.', aDec: ',', aPad: false});

        $("input[name=bb]").keyup(function () {
            var bb  = $('input[name=bb]').val().replace(/[.]/g, "");
            var tb  = $('input[name=tb]').val().replace(/[.]/g, "");
            var tbb = parseFloat(tb) / 100;
            var imt = parseFloat(bb) / (parseFloat(tbb) * parseFloat(tbb));

            $('input[name=imt]').val(Math.round(imt)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
        });

        $("input[name=tb]").keyup(function () {
            var bb  = $('input[name=bb]').val().replace(/[.]/g, "");
            var tb  = $('input[name=tb]').val().replace(/[.]/g, "");
            var tbb = parseFloat(tb) / 100;
            var imt = parseFloat(bb) / (parseFloat(tbb) * parseFloat(tbb));

            $('input[name=imt]').val(Math.round(imt)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
        });

        $("input[id=jml]").keydown(function (e) {
            // kibot: backspace, delete, tab, escape, enter .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // kibot: Ctrl+A, Command+A
                            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // kibot: home, end, left, right, down, up
                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // Biarin wae, ga ngapa2in return false
                        return;
                    }
                    // Cuman nomor
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });
    });
</script>
