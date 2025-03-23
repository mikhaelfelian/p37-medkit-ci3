<?php echo form_open_multipart(base_url('medcheck/set_medcheck_kamar.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_pasien', general::enkrip($sql_medc->id_pasien)); ?>
<?php echo form_hidden('id_kamar', $this->input->get('id_item')); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">[INPUT] RUANG PERAWATAN - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 col-form-label">Nama Ruangan</label>
            <div class="col-sm-7">
                <?php echo form_input(array('id' => 'kamar', 'name' => 'kamar', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Isikan Nama Kamar ...', 'value' => $sql_kamar_rw->kamar, 'readonly' => 'true')) ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 col-form-label">Tipe</label>
            <div class="col-sm-7">
                <?php echo form_input(array('id' => 'kamar', 'name' => 'kamar', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Isikan Nama Kamar ...', 'value' => $sql_kamar_rw->tipe, 'readonly' => 'true')) ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 col-form-label">Tgl Masuk</label>
            <div class="col-sm-7">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text rounded-0"><i class="fas fa-calendar"></i></span>
                    </div>
                    <?php echo form_input(array('id' => 'tgl_masuk', 'name' => 'tgl_masuk', 'class' => 'form-control rounded-0 pull-right', 'placeholder' => 'Silahkan isi tgl periksa ...', 'value' => date('d-m-Y'))) ?>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 col-form-label">Catatan</label>
            <div class="col-sm-7">
                <?php echo form_textarea(array('id' => 'catatan', 'name' => 'catatan', 'class' => 'form-control rounded-0', 'value' => $pasien->alamat, 'style' => 'height: 210px;', 'placeholder' => 'Catatan perawat ...')) ?>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=14') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">                                 
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>                            
    </div>
</div>
<?php echo form_close(); ?>