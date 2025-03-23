<?php echo form_open_multipart(base_url('medcheck/cart_medcheck_rad.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_rad', general::enkrip($sql_medc_rad_rw->id)); ?>
<?php echo form_hidden('id_item', general::enkrip($sql_medc_det_rw->id)); ?>
<?php echo form_hidden('id_produk', general::enkrip($sql_produk->id)); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?> 
<?php echo form_hidden('act', 'rad_input'); ?>

<!--Default box--> 
<div class="card">
    <div class="card-header">
        <h3 class="card-title">INSTALASI RADIOLOGI - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">                    
                <?php $hasError = $this->session->flashdata('form_error'); ?>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Kode</label>
                    <div class="col-sm-9">
                        <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Kode Item ...', 'value' => $sql_produk->kode, 'readonly' => 'true')) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Item</label>
                    <div class="col-sm-9">
                        <?php echo form_input(array('id' => 'item', 'name' => 'item', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Jml ...', 'value' => $sql_produk->produk, 'readonly' => 'true')) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Nilai</label>
                    <div class="col-sm-9">
                        <?php echo form_input(array('id' => 'item_name', 'name' => 'item_name', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Nama Pemeriksaan ...')) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Hasil</label>
                    <div class="col-sm-9">
                        <?php echo form_textarea(array('id' => 'item_value', 'name' => 'item_value', 'class' => 'form-control pull-left rounded-0', 'placeholder' => 'Hasil Pembacaan ...')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/.card-body--> 
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/tambah.php?act=rad_input&id='.$this->input->get('id').'&id_rad='.$this->input->get('id_rad').'&status='.$this->input->get('status').'&id_item='.$this->input->get('id_item')) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">  
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
<!--/.card -->
<?php echo form_close(); ?>

<!--Default box--> 
<div class="card">
    <div class="card-header">
        <h3 class="card-title">ITEM RADIOLOGI</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-left">Nilai</th>
                            <th class="text-left">Hasil</th>
                            <th class="text-center">#</th>
                        </tr>                                    
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($sql_medc_rad_hs as $rad_hasil) { ?>
                            <tr>
                                <td class="text-left" style="width: 160px;">
                                    <?php echo $rad_hasil->item_name; ?>
                                </td>
                                <td class="text-left" style="width: 460px;">
                                    <?php echo $rad_hasil->item_value; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo anchor(base_url('medcheck/cart_medcheck_rad_hsl_hapus.php?act=' . $this->input->get('act') . '&id=' . $this->input->get('id') . '&id_rad=' . $this->input->get('id_rad') . '&status=' . $this->input->get('status') . '&id_item=' . $this->input->get('id_item') . '&id_produk=' . $this->input->get('id_produk') . '&hasil_id=' . general::enkrip($rad_hasil->id)), '<i class="fas fa-trash"></i>Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $rad_hasil->item_name . '] ?\')" style="width: 65px;"') ?>
                                </td>
                            </tr>
                            <?php $no++; ?>
                        <?php } ?>
                        <?php if (!empty($sql_medc_lab_rw->ket)) { ?>
                            <tr>
                                <td></td>
                                <td colspan="6"><small><?php echo $sql_medc_lab_rw->ket ?></small></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--/.card -->

