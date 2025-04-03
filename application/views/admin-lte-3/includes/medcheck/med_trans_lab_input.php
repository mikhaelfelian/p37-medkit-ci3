<?php if ($sql_medc->status < 5) { ?>
    <?php if ($sql_medc_lab_rw->status != '2') { ?>
        <?php echo form_open(base_url('medcheck/cart_medcheck_simpan.php'), array('autocomplete' => 'off', 'id' => 'lab_form')) ?>
        <?php echo form_hidden('id', !empty($sql_medc->id) ? general::enkrip($sql_medc->id) : ''); ?>
        <?php echo form_hidden('id_lab', !empty($sql_medc_lab_rw->id) ? general::enkrip($sql_medc_lab_rw->id) : ''); ?>
        <?php echo form_hidden('id_item', !empty($sql_produk->id) ? general::enkrip($sql_produk->id) : ''); ?>
        <?php // echo form_hidden('dokter', (!empty($sql_medc_lab_rw->id_dokter) ? $sql_medc_lab_rw->id_dokter : $sql_medc->id_dokter));     ?>
        <?php echo form_hidden('status', $this->input->get('status')); ?>
        <?php echo form_hidden('status_item', '3'); ?>
        <?php echo form_hidden('act', $this->input->get('act')); ?>
        <?php echo form_hidden('route', uri_string() . '?' . $_SERVER['QUERY_STRING']); ?>
        <?php echo add_form_protection(); ?>
        
        <input type="hidden" id="id_dokter" name="id_dokter">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">INSTALASI LABORATORIUM - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10">
                        <?php $hasError = $this->session->flashdata('form_error'); ?>

                        <div class="form-group row <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                            <label for="inputEmail3" class="col-sm-4 col-form-label"><?php echo (!empty($sql_produk) ? 'Kode' : 'Item') ?></label>
                            <div class="col-sm-8">
                                <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Item Laborat ...', 'value' => (!empty($sql_produk) ? $sql_produk->kode : ''))) ?>
                            </div>
                        </div>
                        <?php if (!empty($sql_produk)) { ?>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">Kategori Bidang</label>
                                <div class="col-sm-8">
                                    <select name="id_lab_kat" class="form-control <?php echo (!empty($hasError['kategori']) ? 'is-invalid' : '') ?>">
                                        <option value="">- Pilih -</option>
                                        <?php foreach ($sql_kat_lab as $kat_lab) { ?>
                                            <option value="<?php echo general::enkrip($kat_lab->id) ?>" <?php echo ($sql_produk->id_kategori_lab == $kat_lab->id ? 'selected' : '') ?>><?php echo $kat_lab->keterangan ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">Item Laborat</label>
                                <div class="col-sm-8">
                                    <?php echo form_input(array('id' => 'item', 'name' => 'item', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Item Laborat ...', 'value' => $sql_produk->produk, 'readonly' => 'true')) ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">Dokter</label>
                                <div class="col-sm-8">
                                    <?php echo form_input(array('id' => 'dokter', 'name' => 'dokter', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Dokter ...')) ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">Tipe</label>
                                <div class="col-sm-8">
                                    <?php echo form_checkbox(array('id' => 'status_hsl', 'class' => '', 'name' => 'status_hsl', 'value' => '1', 'checked' => 'true')); ?> Hasil Lab
                                    <br/>
                                    <small><i>* Jika di centang, maka item ini akan tampil di <b class="text-danger"><u>CETAK HASIL</u></b> Lab</i></small>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Jml</label>
                            <div class="col-sm-2">
                                <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control pull-right text-center rounded-0', 'placeholder' => 'Jml ...', 'value' => '1')) ?>
                            </div>
                            <div class="col-sm-5">

                            </div>
                        </div>
                        <?php if (akses::hakDokter() != TRUE) { ?>
                            <div class="form-group row <?php echo (!empty($hasError['harga']) ? 'text-danger' : '') ?>">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">Harga</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['harga']) ? ' is-invalid' : ''), 'placeholder' => 'Harga ...', 'value' => (!empty($sql_produk->harga_jual) ? (float) $sql_produk->harga_jual : ''), 'readonly' => 'true')) ?>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <?php echo form_hidden('harga', (!empty($sql_produk->harga_jual) ? (float)$sql_produk->harga_jual : '')); ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-6">
                        <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=3') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                    </div>
                    <div class="col-lg-6 text-right">                                 
                        <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>                            
            </div>
        </div>
        
        <?php echo add_double_submit_protection('lab_form'); ?>
        <?php echo form_close() ?>
    <?php } ?>
<?php } ?>


<?php echo form_open(base_url('medcheck/set_medcheck_lab_print.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_lab', general::enkrip($sql_medc_lab_rw->id)); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">ITEM LABORATORIUM</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <p><i>* Jika terdapat tanda <i class="fa fa-check-circle text-success" aria-hidden="true"></i>, maka item tersebut akan <b class="text-danger"><u>TAMPIL PADA HASIL CETAK</u></b></i></p>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox" name="print_all" id="ckAll"></th>
                            <th class="text-center">No.</th>
                            <th class="text-left">Lab Item</th>
                            <?php if (akses::hakAnalis() == TRUE OR akses::hakDokter() == TRUE) { ?>                
                                <th class="text-left" colspan="2">Hasil Lab</th>
                            <?php } else { ?>
                                <th class="text-center">Jml</th>    
                                <th class="text-right">Harga</th>
                                <th class="text-right">Subtotal</th>
                            <?php } ?>
                            <th class="text-center">#</th>
                        </tr>                                    
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($sql_medc_lab_dt as $det) { ?>
                            <?php $sql_kat = $this->db->where('id', $det->id_lab_kat)->get('tbl_m_kategori')->row(); ?>
                            <?php $sql_det = $this->db->where('id_medcheck', $det->id_medcheck)->where('id_lab', $det->id_lab)->where('id_lab_kat', $det->id_lab_kat)->get('tbl_trans_medcheck_det')->result(); ?>
                            <?php if (!empty($det->id_lab_kat)) { ?>
                                <tr>
                                    <td class="text-left text-bold" colspan="9"><?php echo $sql_kat->keterangan; ?></td>
                                </tr>
                            <?php } ?>
                            <?php foreach ($sql_det as $medc) { ?>
                                <?php // $sql_doc = $this->db->where('id_user', $medc->id_dokter)->get('tbl_m_karyawan')->row(); ?>
                                <?php $sql_lab_rws = $this->db->where('id_medcheck', $medc->id_medcheck)->get('tbl_trans_medcheck_lab'); ?>
                                <?php
                                if ($sql_lab_rws->num_rows() > 1) {
                                    $sql_lab = $this->db->where('id_medcheck', $medc->id_medcheck)->where('id_lab', general::dekrip($this->input->get('id_lab')))->where('id_item', $medc->id_item)->get('tbl_trans_medcheck_lab_hsl')->result();
                                } else {
                                    $sql_lab = $this->db->where('id_medcheck', $medc->id_medcheck)->where('id_item', $medc->id_item)->get('tbl_trans_medcheck_lab_hsl')->result();
                                }
                                ?>
                                <tr>
                                    <td class="text-center">
                                        <?php if ($medc->status_hsl == '1') { ?>
                                            <input type="checkbox" id="ck" name="print[<?php echo $medc->id ?>]" value="1">
                                            <input type="hidden" id="" name="print_lab[<?php echo $medc->id ?>]" value="<?php echo $medc->id_lab ?>">
                                            <input type="hidden" id="" name="print_kat[<?php echo $medc->id ?>]" value="<?php echo $medc->id_lab_kat ?>">
                                        <?php } ?>
                                    </td>
                                    <td class="text-center"><?php echo $no . '.'; ?></td>
                                    <td class="text-left">
                                        <small><i><?php echo $this->tanggalan->tgl_indo5($det->tgl_simpan); ?></i></small><br/>
                                        <?php echo $medc->item . ($medc->status_hsl == '1' ? nbs() . '<i class="fa fa-check-circle text-success" aria-hidden="true"></i>' : ''); ?><br/>
                                        <?php $nlab = 1; ?>
                                        <?php foreach ($sql_lab as $lab) { ?>
                                            <input type="hidden" id="" name="print_lab_hsl[<?php echo $medc->id ?>]" value="<?php echo $lab->id ?>">
                                            <small>
                                                <?php echo anchor(base_url('medcheck/cart_medcheck_lab_hsl_hapus.php?id=' . $this->input->get('id') . '&status=' . $this->input->get('status') . '&act=' . $this->input->get('act') . '&id_lab=' . $this->input->get('id_lab') . '&item_id=' . general::enkrip($lab->id)), '<i class="fa fa-remove"></i>' . nbs(2), 'class="text-danger" onclick="return confirm(\'Hapus [' . $lab->item_name . '] ?\')"') ?>
                                                <i><?php echo nbs() . $nlab++ . '. ' . $lab->item_name . (!empty($lab->item_value) ? ': ' . $lab->item_value : '') . (!empty($lab->item_satuan) ? ' - ' . $lab->item_satuan : '') . (!empty($lab->item_hasil) ? ' - ' . $lab->item_hasil : '') ?></i>
                                            </small>
                                            <br/>
                                        <?php } ?> 
                                    </td>
                                    <?php if (akses::hakAnalis() == TRUE OR akses::hakDokter() == TRUE) { ?>
                                        <td class="text-left" colspan="2">
                                            <?php if ($medc->status_baca == '1') { ?>
                                                <?php echo anchor(base_url('medcheck/tambah.php?act=lab_hasil&id=' . $this->input->get('id') . '&id_lab=' . $this->input->get('id_lab') . '&status=' . $this->input->get('status') . '&id_produk=' . general::enkrip($medc->id_item) . '&id_item=' . general::enkrip($medc->id)), '<i class="fas fa-check"></i> Input', 'class="btn btn-success btn-flat btn-xs" style="width: 65px;"') ?>
                                                <?php // echo form_input(array('id' => 'hasil_lab', 'name' => 'nilai_normal[' . general::enkrip($medc->id) . ']', 'class' => 'form-control', 'value' => (!empty($medc->hasil_lab) ? $medc->hasil_lab : ''), 'placeholder' => 'Hasil Lab ...')); ?>
                                            <?php } ?>
                                        </td>
                                    <?php } else { ?>
                                        <td class="text-center"><?php echo (float) $medc->jml; ?></td>
                                        <td class="text-right"><?php echo general::format_angka($medc->harga); ?></td>
                                        <td class="text-right"><?php echo general::format_angka($medc->subtotal); ?></td>
                                    <?php } ?>
                                    <td class="text-center">
                                        <!--
                                        <?php if (akses::hakAnalis() != TRUE) { ?>
                                            <?php echo anchor(base_url('medcheck/cart_medcheck_hapus.php?act=' . $this->input->get('act') . '&id=' . general::enkrip($medc->id) . '&id_lab=' . $this->input->get('id_lab') . '&no_nota=' . general::enkrip($medc->id_medcheck) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $medc->item . '] ?\')" style="width: 65px;"') ?>
                                        <?php } else { ?>
                                            <?php if ($medc->status_baca != '1') { ?>
                                                <?php echo anchor(base_url('medcheck/cart_medcheck_status.php?act=' . $this->input->get('act') . '&id=' . general::enkrip($medc->id) . '&id_lab=' . $this->input->get('id_lab') . '&no_nota=' . general::enkrip($medc->id_medcheck) . '&status=' . $this->input->get('status') . '&state=1'), '<i class="fas fa-check"></i> Terima', 'class="btn btn-success btn-flat btn-xs" onclick="" style="width: 60px;"') ?>
                                                <?php echo anchor(base_url('medcheck/cart_medcheck_status.php?act=' . $this->input->get('act') . '&id=' . general::enkrip($medc->id) . '&id_lab=' . $this->input->get('id_lab') . '&no_nota=' . general::enkrip($medc->id_medcheck) . '&status=' . $this->input->get('status') . '&state=2'), '<i class="fas fa-xmark"></i> Tolak', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Tolak [' . $medc->item . '] ?\')" style="width: 60px;"') ?>
                                            <?php } ?>
                                        <?php } ?>
                                        -->
                                        <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE OR akses::hakAnalis() == TRUE) { ?>
                                            <?php if ($sql_medc_lab_rw->status != '2') { ?>
                                                <?php echo anchor(base_url('medcheck/tambah.php?act=lab_hasil&id=' . $this->input->get('id') . '&id_lab=' . $this->input->get('id_lab') . '&status=' . $this->input->get('status') . '&id_produk=' . general::enkrip($medc->id_item) . '&id_item=' . general::enkrip($medc->id)), '<i class="fas fa-check"></i> Input', 'class="btn btn-success btn-flat btn-xs" style="width: 65px;"') ?>
                                                <?php if ($sql_medc->status < 5) { ?>
                                                    <?php echo br() ?>
                                                    <?php echo anchor(base_url('medcheck/cart_medcheck_hapus.php?act=' . $this->input->get('act') . '&id=' . general::enkrip($medc->id) . '&id_lab=' . $this->input->get('id_lab') . '&no_nota=' . general::enkrip($medc->id_medcheck) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $medc->item . '] ?\')" style="width: 65px;"') ?>
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
        <div class="row">
            <div class="col-lg-6">
                <?php if ($sql_medc_lab_rw->status == '2') { ?>
                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=3') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                <?php  } ?>
            </div>
            <div class="col-lg-6 text-right">
                <?php if (!empty($sql_medc_lab_dt)) { ?>
                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE OR akses::hakAnalis() == TRUE) { ?>
                        <?php if ($sql_medc_lab_rw->status == '2') { ?>
                            <?php echo anchor(base_url('medcheck/set_medcheck_lab_batal.php?act=' . $this->input->get('act') . '&id=' . $this->input->get('id') . '&item_id=' . $this->input->get('id_lab') . '&status=' . $this->input->get('status')), '<i class="fas fa-remove"></i> Batalkan', 'class="btn btn-danger btn-flat" onclick="return confirm(\'Batalkan ?\')"') ?>
                        <?php } else { ?>
                            <?php echo anchor(base_url('medcheck/set_medcheck_lab_finish.php?act=' . $this->input->get('act') . '&id=' . $this->input->get('id') . '&item_id=' . $this->input->get('id_lab') . '&status=' . $this->input->get('status')), '<i class="fas fa-check-circle"></i> Set Selesai', 'class="btn btn-success btn-flat"') ?>
                        <?php } ?>
                    <?php } ?>

                    <button type="submit" id="btnCetak" class="btn btn-primary btn-flat"><i class="fas fa-print"></i> Cetak</button>
                <?php } ?>
            </div>
        </div>                            
    </div>
</div>
<?php echo form_close() ?>
