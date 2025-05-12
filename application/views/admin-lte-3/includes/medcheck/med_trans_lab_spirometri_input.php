<?php echo form_open(base_url('medcheck/set_medcheck_lab_spr_hsl.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_spiro', general::enkrip($sql_medc_lab_spr_rw->id)); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>
<?php echo form_hidden('act', $this->input->get('act')); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">[SPIROMETRI] INSTALASI LABORATORIUM - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <?php foreach ($sql_spirometri as $spiro) { ?>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label"><small><?php echo $spiro->kategori ?></small></label>
                <div class="col-sm-2">
                    <?php echo form_input(array('id' => 'jml', 'name' => 'hsl_ukur[' . $spiro->id . ']', 'class' => 'form-control pull-right text-center rounded-0', 'placeholder' => 'Isikan Hasil ...')) ?>
                </div>
                <div class="col-sm-2">
                    <?php echo form_input(array('id' => 'jml', 'name' => 'hsl_pred[' . $spiro->id. ']', 'class' => 'form-control pull-right text-center rounded-0', 'placeholder' => 'Prediksi ...')) ?>
                </div>
                <div class="col-sm-2">
                    <?php echo form_input(array('id' => 'jml', 'name' => 'hsl_pred2[' . $spiro->id . ']', 'class' => 'form-control pull-right text-center rounded-0', 'placeholder' => 'Isikan % ...')) ?>
                </div>
                <div class="col-sm-2">
                    <?php echo form_input(array('id' => '', 'name' => 'hsl_lln[' . $spiro->id . ']', 'class' => 'form-control pull-right text-left rounded-0', 'value' => (float)$spiro->jml_lln, 'placeholder' => 'Isikan LLN ...', 'disabled' => 'TRUE')) ?>
                </div>
            </div>
        <?php } ?>
        <div class="form-group">
            <label for="inputEmail3">Keterangan Hasil</label>
            <?php echo form_input(array('id' => 'ket', 'name' => 'ket', 'class' => 'form-control pull-left rounded-0', 'placeholder' => 'Isikan Keterangan Hasil, cth : Gangguan Restriktif  ...')) ?>
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

<?php if (!empty($sql_medc_lab_spr_dt)) { ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-microscope"></i> HASIL PEMBACAAN SPIROMETRI</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-center">Hasil</th>
                        <th class="text-center">Prediksi</th>
                        <th class="text-center">% Prediksi</th>
                        <th class="text-center">LLN</th>
                        <th class="text-center">#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sql_medc_lab_spr_dt as $spiro) { ?>
                        <?php $sql_spiro = $this->db->where('id', $spiro->id_lab_spiro_kat)->get('tbl_m_kategori_spiro')->row(); ?>

                        <tr>
                            <td style="width: 250px;" class="text-left"><?php echo $spiro->item_name ?></td>
                            <td style="width: 200px;" class="text-center"><?php echo general::format_angka2($spiro->item_value, 2) ?></td>
                            <td style="width: 150px;" class="text-center"><?php echo general::format_angka2($spiro->item_value2, 2) ?></td>
                            <td style="width: 150px;" class="text-center"><?php echo general::format_angka2($spiro->item_value3, 2) ?></td>
                            <td style="width: 150px;" class="text-center"><?php echo general::format_angka2($sql_spiro->jml_lln, 2) ?></td>
                            <td style="width: 150px;" class="text-center">
                                <?php echo anchor(base_url('medcheck/set_medcheck_lab_spr_hps_hsl.php?act=' . $this->input->get('act') . '&id=' . $this->input->get('id') . '&id_lab=' . $this->input->get('id_lab') . '&item_id=' . general::enkrip($spiro->id) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $spiro->item_name . '] ?\')" style="width: 65px;"') ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php echo br() ?>
            <div class="form-group">
                <label for="inputEmail3">Keterangan Hasil</label>
                <?php echo form_input(array('id' => '', 'name' => '', 'class' => 'form-control pull-left rounded-0', 'placeholder' => 'Isikan Keterangan Hasil, cth : Gangguan Restriktif  ...', 'value' => $sql_medc_lab_spr_rw->ket, 'disabled' => 'TRUE')) ?>
            </div>
        </div>
        <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
            </div>
            <div class="col-lg-6 text-right">                                 
                <a href="<?php echo base_url('medcheck/set_medcheck_lab_spr_cetak.php?id='.$this->input->get('id').'&status='.$this->input->get('status').'&id_lab='.$this->input->get('id_lab')) ?>">
                    <button type="button" class="btn btn-primary btn-flat"><i class="fa fa-print"></i> Cetak</button>
                </a>
            </div>
        </div>                            
    </div>
    </div>
<?php } ?>
<!-- Page script -->
<script type="text/javascript">
    $(function () {
//        $("input[id=jml]").autoNumeric({aSep: '.', aDec: ',', aPad: false});
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
