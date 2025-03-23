<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">INSTALASI FARMASI - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">No Resep</label>
            <div class="col-sm-9">
                <?php echo form_input(array('id' => 'tgl', 'name' => 'resep', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'value' => $sql_medc_res_rw->no_resep, 'readonly' => 'TRUE')) ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Tgl Resep</label>
            <div class="col-sm-9">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                    <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl_resep', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'value' => $this->tanggalan->tgl_indo2($sql_medc_res_rw->tgl_simpan), 'readonly' => 'TRUE')) ?>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Dokter</label>
            <div class="col-sm-9">
                <?php echo form_input(array('id' => 'tgl', 'name' => 'dokter', 'class' => 'form-control pull-right rounded-0', 'value' => (!empty($sql_dokter->nama_dpn) ? $sql_dokter->nama_dpn.' ' : '').$sql_dokter->nama.(!empty($sql_dokter->nama_blk) ? ', '.$sql_dokter->nama_blk.' ' : ''), 'readonly' => 'TRUE')) ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Farmasi</label>
            <div class="col-sm-9">
                <?php echo form_input(array('id' => 'tgl', 'name' => 'farmasi', 'class' => 'form-control pull-right rounded-0', 'value' => $this->ion_auth->user($sql_medc_res_rw->id_farmasi)->row()->first_name, 'readonly' => 'TRUE')) ?>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=4') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">
                <?php if (!empty($sql_produk)) { ?>
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-save"></i> Simpan</button>
                <?php } ?>
            </div>
        </div>                            
    </div>
</div>
<!-- /.card -->

<?php # Item yang terinput di resep di panggil disini ?>
<?php $this->load->view('admin-lte-3/includes/medcheck/med_trans_obat_input_list', $data); ?>