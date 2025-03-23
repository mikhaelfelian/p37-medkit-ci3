<div class="col-lg-8">
    <?php echo form_open_multipart(base_url('medcheck/retur/set_medcheck_retur.php'), 'autocomplete="off"') ?>
    <?php echo form_hidden('route', $this->input->get('route')); ?>
    <input type="hidden" id="id_medcheck" name="id" <?php echo (isset($_GET['pasien']) ? 'value="'.$this->input->get('pasien').'"' : '') ?>>

    <!-- INPUT RETUR MEDICINE -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">TRANSAKSI RETUR</h3>
        </div>
        <div class="card-body">
            <?php echo $this->session->flashdata('medcheck'); ?>
            <div class="alert alert-danger">
                <h6><i class="icon fas fa-ban"></i> Peringatan !!</h6>
                Retur ini digunakan untuk mengembalikan item terjual yang telah lunas.<br/>
                Sehingga pencarian berdasarkan no transaksi medcheck yang telah <b>LUNAS</b>.<br/>
                - Terimakasih -
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php $hasError = $this->session->flashdata('form_error'); ?>

                    <div class="form-group <?php echo (!empty($hasError['no_nota']) ? 'text-danger' : '') ?>">
                        <label class="control-label">Cari Medcheck*</label>
                        <div class="input-group mb-3">
                            <?php echo form_input(array('id' => 'no_trx', 'name' => 'no_trx', 'class' => 'form-control text-left rounded-0' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Cari nama lengkap atau no transaksi medcheck ... ')) ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Tgl Retur</label>
                        <div class="col-sm-4">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                </div>
                                <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control text-middle rounded-0' . (!empty($hasError['tgl']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => '02/15/2022 ...', 'value' => date('m/d/Y'))) ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">No Trx</label>
                        <div class="col-sm-4">
                            <?php echo form_input(array('id' => 'no_rm', 'name' => 'no_rm', 'class' => 'form-control pull-right rounded-0', 'value' => $sql_medc->no_rm, 'disabled' => 'TRUE')) ?>
                        </div>
                        <label for="inputEmail3" class="col-sm-2 col-form-label">No Invoice</label>
                        <div class="col-sm-4">
                            <?php echo form_input(array('id' => 'no_nota', 'name' => 'no_nota', 'class' => 'form-control pull-right rounded-0', 'value' => $sql_medc->no_nota, 'disabled' => 'TRUE')) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Pasien</label>
                        <div class="col-sm-2">
                            <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right rounded-0', 'value' => $sql_pas->kode_dpn . $sql_pas->kode, 'disabled' => 'TRUE')) ?>
                        </div>
                        <div class="col-sm-8">
                            <?php echo form_input(array('id' => 'pasien', 'name' => 'pasien', 'class' => 'form-control pull-right rounded-0', 'value' => $sql_pas->nama_pgl, 'disabled' => 'TRUE')) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <?php echo form_input(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control pull-right rounded-0', 'value' => $sql_pas->alamat, 'disabled' => 'TRUE')) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Kontak</label>
                        <div class="col-sm-4">
                            <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control pull-right rounded-0', 'value' => $sql_pas->no_hp, 'disabled' => 'TRUE')) ?>
                        </div>
                        <label for="inputEmail3" class="col-sm-2 col-form-label">POLI</label>
                        <div class="col-sm-4">
                            <?php echo form_input(array('id' => 'poli', 'name' => 'poli', 'class' => 'form-control pull-right rounded-0', 'value' => $this->db->where('id', $sql_medc->id_poli)->get('tbl_m_poli')->row()->lokasi, 'disabled' => 'TRUE')) ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Catatan Retur</label>
                        <div class="col-sm-10">
                            <?php echo form_textarea(array('id' => 'ket', 'name' => 'ket', 'class' => 'form-control pull-right rounded-0', 'placeholder'=>'Isikan catatan retur, misal : Retur karena kemahalan / kadaluarsa, dll ...')) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <div class="row">
                <div class="col-lg-6">
                    <?php if (isset($_GET['pasien'])) { ?>
                        <button type="button" class="btn btn-danger btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/retur/retur.php') ?>'"><i class="fas fa-xmark"></i> Batal</button>
                    <?php } ?>
                </div>
                <div class="col-lg-6 text-right">
                    <?php if (isset($_GET['pasien'])) { ?>
                        <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Set Retur</button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card -->
    <?php echo form_close() ?>                    

    <?php if ($sql_medc->status < 5) { ?>
        <!-- DATA ENTRY ITEM RETUR -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">DATA ITEM RETUR</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-left">Item</th>
                                    <th class="text-center">Jml</th>
                                    <th class="text-center">#</th>
                                </tr>                                    
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($sql_medc_retur as $medc) { ?>
                                    <?php $sql_doc = $this->db->where('id', $medc->id_dokter)->get('tbl_m_karyawan')->row(); ?>
                                    <tr>
                                        <td class="text-center"><?php echo $no . '.'; ?></td>
                                        <td class="text-left" style="width: 460px;">
                                            <small><i><?php echo $this->tanggalan->tgl_indo5($medc->tgl_simpan); ?></i></small><br/>
                                            <?php echo $medc->item; ?>
                                        </td>
                                        <td class="text-center"><?php echo (float) $medc->jml; ?></td>
                                        <td class="text-center">
                                            <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE OR akses::hakPerawat() == TRUE OR akses::hakFarmasi() == TRUE) { ?>
                                                <?php echo anchor(base_url('medcheck/cart_medcheck_ret_hps.php?id=' . general::enkrip($sql_medc->id) . '&item_id=' . general::enkrip($medc->id)), '<i class="fas fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $medc->item . '] ?\')" style="width: 65px;"') ?>
                                            <?php } ?>
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
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- BOX DATA TINDAKAN -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">DATA ITEM & TINDAKAN</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-left">No.</th>
                                    <th class="text-left">Tgl</th>
                                    <th class="text-left">Item</th>
                                    <th class="text-center">Jml</th>
                                    <th class="text-right">#</th>
                                </tr>                                    
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $gtotal = 0
                                ?>
                                <?php foreach ($sql_medc_det as $det) { ?>
                                    <?php $sql_kat = $this->db->where('id', $det->id_item_kat)->get('tbl_m_kategori')->row(); ?>
                                    <?php $sql_det = $this->db->where('id_medcheck', $det->id_medcheck)->where('id_item_kat', $det->id_item_kat)->get('tbl_trans_medcheck_det')->result(); ?>
                                    <tr>
                                        <td class="text-left text-bold" colspan="7"><i><?php echo $sql_kat->keterangan . ' (' . $sql_kat->kategori . ')'; ?></i></td>
                                    </tr>
                                    <?php $sub = 0; ?>
                                    <?php foreach ($sql_det as $medc) { ?>
                                        <?php // if ($medc->jml >= 0) { ?>
                                        <?php $sub = $sub + $medc->subtotal ?>
                                        <?php $sql_doc = $this->db->where('id_user', $medc->id_dokter)->get('tbl_m_karyawan')->row(); ?>
                                        <?php $sql_rc = $this->db->where('id_medcheck', $medc->id_medcheck)->where('id_item', $medc->id_item)->get('tbl_trans_medcheck_resep_det')->row(); ?>
                                        <?php $sql_rc_det = $this->db->where('id_resep', $sql_rc->id_resep)->where('id_resep_det', $sql_rc->id)->get('tbl_trans_medcheck_resep_det_rc'); ?>
                                        <tr>
                                            <td class="text-center" style="width: 15px;"><?php echo $no; ?>.</td>
                                            <td class="text-left" style="width: 150px;"><?php echo $this->tanggalan->tgl_indo5($medc->tgl_simpan); ?></td>
                                            <td class="text-left" style="width: 350px;">
                                                <?php echo $medc->item; ?>
                                                <?php if (!empty($medc->resep)) { ?>
                                                    <!--Iki kanggo item racikan su-->
                                                    <?php echo br(); ?>
                                                    <?php foreach (json_decode($medc->resep) as $racikan) { ?>
                                                        <small><i><?php echo $racikan->item ?></i></small><br/>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if (!empty($medc->id_dokter)) { ?>
                                                    <!--Iki nggo nampilke nama dokter ndes-->
                                                    <?php echo br(); ?>
                                                    <small><?php echo $sql_doc->nama ?></small>
                                                <?php } ?>
                                            </td>
                                            <td class="text-center" style="width: 65px;"><?php echo (float) $medc->jml; ?></td>
                                            <td class="text-right" style="width: 65px;">
                                                <?php if ($sql_medc->status < 5) { ?>
                                                    <?php if ($medc->jml > 0) { ?>
                                                        <?php echo anchor(base_url('medcheck/retur.php?id=' . general::enkrip($sql_medc->id) . '&item_id=' . general::enkrip($medc->id) . '&id_produk=' . general::enkrip($medc->id_item) . '&no_urut=' . $no), 'Retur &raquo;', 'class="btn btn-warning btn-flat btn-xs" style="width: 65px;"') ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php $no++ ?>
                                        <?php // } ?>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    <?php } ?>
</div>