<?php echo form_open(base_url('medcheck/cart_medcheck_lab_nilai.php'), array('autocomplete' => 'off', 'id' => 'lab_hasil_form')) ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_item', general::enkrip($sql_produk->id)); ?>
<?php echo form_hidden('id_lab', $this->input->get('id_lab')); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>
<?php echo form_hidden('id_det', $this->input->get('id_item')); ?>
<?php echo form_hidden('act', 'lab_input'); ?>
<?php echo form_hidden('route', uri_string() . '?' . $_SERVER['QUERY_STRING']); ?>
<?php echo add_form_protection(); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">INSTALASI LABORATORIUM - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <?php $hasError = $this->session->flashdata('form_error'); ?>

                <input type="hidden" id="id_dokter" name="id_dokter">

                <div class="form-group row <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Kode</label>
                    <div class="col-sm-8">
                        <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Kode Lab ...', 'value' => $sql_produk->kode)) ?>
                    </div>
                </div>
                <?php if (!empty($sql_produk)) { ?>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Lab Item</label>
                        <div class="col-sm-6">
                            <?php echo form_input(array('id' => 'item', 'name' => 'item', 'class' => 'form-control pull-right', 'placeholder' => 'Kode Item ...', 'value' => $sql_produk->produk, 'readonly' => 'true')) ?>
                        </div>
                        <div class="col-sm-2">
                            <?php // echo form_checkbox(array('name'=>'item_ket', 'value'=>'1')) ?> (*)
                        </div>
                    </div>
                <?php } ?>
                <?php foreach ($sql_produk_ip as $item_input) { ?>
                <?php 
                    $usia = $this->tanggalan->usia_angka($sql_pasien->tgl_lahir);
                    if($sql_pasien->jns_klm == 'L'){
                        $val = ($usia >= 14 ? $item_input->item_value_l1 : $item_input->item_value_l2);
                    }elseif($sql_pasien->jns_klm == 'P'){
                        $val = ($usia >= 14 ? $item_input->item_value_p1 : $item_input->item_value_p2);
                    }
                ?>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><small><?php echo $item_input->item_name ?></small></label>
                        <div class="col-sm-3">
                            <?php echo form_input(array('id' => 'jml', 'name' => 'nilai_normal[' . $item_input->id . ']', 'class' => 'form-control pull-right text-left rounded-0', 'value' => html_entity_decode(htmlspecialchars($val)), 'placeholder' => 'Isikan Nilai Normal ...')) ?>
                        </div>
                        <div class="col-sm-2">
                            <?php echo form_input(array('id' => 'jml', 'name' => 'nilai_hasil[' . $item_input->id . ']', 'class' => 'form-control pull-right text-left rounded-0', 'placeholder' => 'Isikan Hasil Lab ...')) ?>
                        </div>
                        <div class="col-sm-2">
                            <?php echo form_input(array('id' => 'jml', 'name' => 'nilai_satuan[' . $item_input->id . ']', 'class' => 'form-control pull-right text-left rounded-0', 'value' => html_entity_decode(htmlspecialchars($item_input->item_satuan)), 'placeholder' => 'Isikan Satuan ...')) ?>
                        </div>
                        <div class="col-sm-1">
                            <?php echo form_checkbox(array('name' => 'status_hsl[' . $item_input->id . ']', 'value' => '1')) ?> (*)
                            <?php echo form_checkbox(array('name' => 'status_wrn[' . $item_input->id . ']', 'value' => '1')) ?> <i class="fa fa-exclamation-triangle text-danger"></i>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tambah.php?act=lab_input&id=' . general::enkrip($sql_medc->id).'&id_lab='.$this->input->get('id_lab').'&status=' . $this->input->get('status')) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">
                <button type="button" class="btn btn-danger btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tambah.php?act=lab_input&id=' . general::enkrip($sql_medc->id) . '&id_lab=' . $this->input->get('id_lab') . '&status=' . $this->input->get('status')) ?>'"><i class="fas fa-refresh"></i> Reset</button>
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>                            
    </div>
</div>

<?php echo add_double_submit_protection('lab_hasil_form'); ?>
<?php echo form_close() ?>
