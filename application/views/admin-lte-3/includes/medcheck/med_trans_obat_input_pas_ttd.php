<?php // echo form_open_multipart(base_url('medcheck/set_medcheck_inform.php'), 'autocomplete="off"')     ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('status', $st_medrep); ?>
<style>
    /* mengatur ukuran canvas tanda tangan  */
    canvas {
        border: 1px solid #ccc;
        border-radius: 0.5rem;
        width: 100%;
        height: 250px;
    }
</style>

<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">KONFIRMASI PENGAMBILAN OBAT - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    
    <?php echo form_open('', ['id' => 'signature-form', 'class' => 'form-horizontal']); ?>
    <?php echo add_form_protection(); ?>
    
    <div class="card-body">        
        <div id="inputTTD" class="form-group row <?php echo (!empty($hasError['ttd']) ? 'text-danger' : '') ?>">
            <label for="inputJnsKlm" class="col-sm-3 col-form-label">TTD Pasien<br/><small><i>Konfirmasi Pengambilan Obat</i></small></label>
            <div class="col-sm-9">
                <canvas id="signature-pad" class="signature-pad rounded-0"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">              
                <div style="float: right;">
                    <!-- tombol hapus tanda tangan  -->
                    <button type="button" class="btn btn-danger btn-flat" id="clear">
                        <span class="fas fa-eraser"></span>
                        Clear
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-md-6">
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tambah.php?act=res_input&id=' . general::enkrip($sql_medc->id) . '&id_resep=' . $this->input->get('id_resep') . '&status=4') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-md-6 text-right">
                <button type="button" id="btn-submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<!-- /.card -->