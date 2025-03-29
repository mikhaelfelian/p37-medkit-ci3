<?php if ($sql_medc->status < 5) { ?>
<?php echo form_open(base_url('medcheck/cart_medcheck_simpan.php'), 'id="rad_input_form" autocomplete="off"') ?>
<?php echo form_hidden('id', !empty($sql_medc->id) ? general::enkrip($sql_medc->id) : ''); ?>
<?php echo form_hidden('id_rad', !empty($sql_medc_rad_rw->id) ? general::enkrip($sql_medc_rad_rw->id) : ''); ?>
<?php echo form_hidden('id_item', !empty($sql_produk->id) ? general::enkrip($sql_produk->id) : ''); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>
<?php echo form_hidden('status_item', '5'); ?>
<?php echo form_hidden('act', $this->input->get('act')); ?>
<?php echo form_hidden('route', uri_string() . '?' . $_SERVER['QUERY_STRING']); ?>
<?php echo add_form_protection(); ?>
<input type="hidden" id="id_dokter" name="id_dokter">

<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">INSTALASI RADIOLOGI - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">                    
                <?php $hasError = $this->session->flashdata('form_error'); ?>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label"><?php echo (!empty($sql_produk) ? 'Kode' : 'Item') ?></label>
                    <div class="col-sm-9">
                        <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => (!empty($sql_produk) ? 'Isikan Kode Item' : 'Isikan Item Pemeriksaan').' ...', 'value' => $sql_produk->kode)) ?>
                    </div>
                </div>
                <?php if (!empty($sql_produk)) { ?>
                    <?php echo form_hidden('harga', (float) $sql_produk->harga_jual) ?>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Item</label>
                        <div class="col-sm-9">
                            <?php echo form_input(array('id' => 'item', 'name' => 'item', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Isikan Item Pemeriksaan ...', 'value' => $sql_produk->produk, 'readonly' => 'true')) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Dokter</label>
                        <div class="col-sm-9">
                            <?php echo form_input(array('id' => 'dokter', 'name' => 'dokter', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Dokter Terkait ...')) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Tipe</label>
                        <div class="col-sm-9">
                            <?php echo form_checkbox(array('id' => 'status_hsl', 'class' => '', 'name' => 'status_hsl', 'value' => '1', 'checked' => 'true')); //, 'checked' => 'true' ?> Hasil Radiologi
                            <br/>
                            <small><i>* Jika di centang, maka item ini akan tampil di <b class="text-danger"><u>CETAK HASIL</u></b> Radiologi</i></small>
                        </div>
                    </div>
                <?php } ?>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Jml</label>
                    <div class="col-sm-2">
                        <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control pull-right rounded-0 text-center', 'placeholder' => 'Jml ...', 'value' => '1')) ?>
                    </div>
                    <div class="col-sm-7">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <?php //echo form_open(base_url('medcheck/set_medcheck_rad_upd.php'), 'autocomplete="off"') ?>
        <?php //echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
        <?php //echo form_hidden('id_user', $sql_medc_rad_rw->id_radiografer); ?>
        <?php //echo form_hidden('id_rad', general::enkrip($sql_medc_rad_rw->id)); ?>
        <?php //echo form_hidden('no_sampel', $sql_medc_rad_rw->no_sample); ?>
        <?php //echo form_hidden('dokter', $sql_medc_rad_rw->id_dokter); ?>
        <?php //echo form_hidden('dokter_kirim', $sql_medc_rad_rw->id_dokter_kirim); ?>
        <?php //echo form_hidden('kesan', $sql_medc_rad_rw->kesan); ?>
        <?php //echo form_hidden('status', $this->input->get('status')); ?>
        <?php //echo form_hidden('status_rad', '4'); ?>
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/tambah.php?id='.general::enkrip($sql_medc->id).'&status=5') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- /.card -->
<?php echo add_double_submit_protection('rad_input_form'); ?>
<?php echo form_close() ?>
<?php } ?>


<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">ITEM RADIOLOGI</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <p><i>* Jika terdapat tanda <i class="fa fa-check-circle text-success" aria-hidden="true"></i>, maka item tersebut akan <b class="text-danger"><u>TAMPIL PADA HASIL CETAK</u></b></i></p>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-left">Item</th>
                            <th class="text-center">Jml</th>
                            <th class="text-right">Subtotal</th>
                            <th class="text-center">#</th>
                        </tr>                                    
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($sql_medc_rad_dt as $det) { ?>
                            <?php $sql_kat = $this->db->where('id', $det->id_item_kat)->get('tbl_m_kategori')->row(); ?>
                            <?php $sql_det = $this->db->where('id_medcheck', $det->id_medcheck)->where('id_rad', $det->id_rad)->where('id_item_kat', $det->id_item_kat)->get('tbl_trans_medcheck_det')->result(); ?>
                            <tr>
                                <td class="text-left text-bold" colspan="9"><?php echo $sql_kat->keterangan . ' (' . $sql_kat->kategori . ')'; ?></td>
                            </tr>
                            <?php foreach ($sql_det as $medc) { ?>
                                <?php $sql_doc = $this->db->where('id_user', $medc->id_dokter)->get('tbl_m_karyawan')->row(); ?>
                                <tr>
                                    <td class="text-center"><?php echo $no . '.'; ?></td>
                                    <td class="text-left" style="width: 460px;">
                                        <small><i><?php echo $this->tanggalan->tgl_indo5($det->tgl_simpan); ?></i></small><br/>
                                        <?php echo $medc->item.($medc->status_hsl == '1' ? nbs().'<i class="fa fa-check-circle text-success" aria-hidden="true"></i>' : ''); ?><br/>
                                        <small><b>Rp. <?php echo general::format_angka($medc->harga); ?></b></small>
                                        <?php if (!empty($sql_doc->nama)) { ?>
                                            <?php echo br() ?>
                                            <small><?php echo (!empty($sql_doc->nama_dpn) ? $sql_doc->nama_dpn.' ' : '').$sql_doc->nama.(!empty($sql_doc->nama_blk) ? ', '.$sql_doc->nama_blk : '') ?></small>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center"><?php echo (float) $medc->jml; ?></td>
                                    <td class="text-right"><?php echo general::format_angka($medc->subtotal); ?></td>
                                    <td class="text-center">
                                        <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakRad() == TRUE OR akses::hakDokter() == TRUE) { ?>
                                            <?php echo anchor(base_url('medcheck/tambah.php?act=rad_hasil&id=' . $this->input->get('id') . '&id_rad=' . $this->input->get('id_rad') . '&status=' . $this->input->get('status') . '&id_item=' . general::enkrip($medc->id) . '&id_produk=' . general::enkrip($medc->id_item)), '<i class="fas fa-check"></i> Input', 'class="btn btn-success btn-flat btn-xs" style="width: 65px;"') ?>
                                            <?php echo br() ?>
                                            <?php echo anchor(base_url('medcheck/tambah.php?act=rad_hasil_lamp&id=' . $this->input->get('id') . '&id_rad=' . $this->input->get('id_rad') . '&status=' . $this->input->get('status') . '&id_item=' . general::enkrip($medc->id) . '&id_produk=' . general::enkrip($medc->id_item)), '<i class="fas fa-paperclip"></i> Foto', 'class="btn btn-success btn-flat btn-xs" style="width: 65px;"') ?>
                                            <?php $sql_hsl = $this->db->where('id_medcheck', general::dekrip($this->input->get('id')))->where('id_rad', general::dekrip($this->input->get('id_rad')))->where('id_medcheck_det', $medc->id)->get('tbl_trans_medcheck_rad_det')->num_rows(); ?>
                                            <?php if ($sql_hsl == '0') { ?>
                                                <?php if ($sql_medc->status < 5) { ?>                                                
                                                    <?php echo br() ?>
                                                    <?php echo anchor(base_url('medcheck/cart_medcheck_hapus.php?act=' . $this->input->get('act') . '&id=' . general::enkrip($medc->id) . '&id_rad=' . $this->input->get('id_rad') . '&no_nota=' . general::enkrip($medc->id_medcheck) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $medc->item . '] ?\')" style="width: 65px;"') ?>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php $no++; ?>
                            <?php } ?>
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
    <!-- /.card-body -->
    <div class="card-footer">
        <?php echo form_open(base_url('medcheck/set_medcheck_rad_upd.php'), 'autocomplete="off"') ?>
        <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
        <?php echo form_hidden('id_user', $sql_medc_rad_rw->id_radiografer); ?>
        <?php echo form_hidden('id_rad', general::enkrip($sql_medc_rad_rw->id)); ?>
        <?php echo form_hidden('no_sampel', $sql_medc_rad_rw->no_sample); ?>
        <?php echo form_hidden('dokter', $sql_medc_rad_rw->id_dokter); ?>
        <?php echo form_hidden('dokter_kirim', $sql_medc_rad_rw->id_dokter_kirim); ?>
        <?php echo form_hidden('kesan', $sql_medc_rad_rw->ket); ?>
        <?php echo form_hidden('status', $this->input->get('status')); ?>
        <?php echo form_hidden('status_rad', '4'); ?>
        
        <div class="row">
            <div class="col-lg-6">
                <?php if ($sql_medc->status >= 5) { ?>
                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/tambah.php?id='.general::enkrip($sql_medc->id).'&status=5') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                <?php } ?>
            </div>
            <div class="col-lg-6 text-right">
                <?php if ($_GET['act'] == 'rad_input' AND !empty($sql_medc_rad_dt)) { ?>
                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/surat/cetak_pdf_rad.php?id=' . $this->input->get('id') . '&id_rad=' . $this->input->get('id_rad')) ?>'"><i class="fas fa-print"></i> Cetak</button>
                <?php } ?>
                <?php if (akses::hakDokter() != TRUE) { ?>
                    <?php if ($_GET['act'] == 'rad_input' AND $sql_medc_rad_rw->status < '4') { ?>
                        <button type="submit" class="btn btn-success btn-flat"><i class="fas fa-check"></i> Selesai</button>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<!-- /.card -->
