<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">DATA ITEM RESEP <?php echo $sql_medc_res_rw->no_resep; ?></h3>
        <div class="card-tools">
            <?php echo ($sql_medc_res_rw->status_plg == '1' ? nbs(4) . '<i class="fas fa-check-circle text-success"></i> Resep Pulang' : ''); ?>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center"></th>
                    <th class="text-center">No.</th>
                    <th class="text-left">Item</th>
                    <th class="text-right">Jml</th>
                    <th class="text-center">#</th>
                </tr>                                    
            </thead>
            <tbody>
                <?php $no = 1;
                $sr = 0; ?>
                <?php $subtot_gt = 0; ?>
                <?php foreach ($sql_medc_res_dt as $cart) { ?>
                    <?php $sql_item = $this->db->where('id', $cart->id_item)->get('tbl_m_produk')->row(); ?>
                    <?php $sql_racikan = $this->db->select('SUM(subtotal) AS harga')->where('id_resep_det', $cart->id)->get('tbl_trans_medcheck_resep_det_rc')->row(); ?>
                    <?php $sql_racikan_dt = $this->db->select('*')->where('id_resep_det', $cart->id)->get('tbl_trans_medcheck_resep_det_rc')->result(); ?>
                    <?php $sr = $sr + $cart->status_resep; ?>                                  
                    <tr>
                        <th class="text-center">
                            <?php if ($_GET['act'] != 'res_input_rc') { ?>
                                <?php if ($sql_medc_res_rw->status == '0') { ?>
                                    <?php // if ($cart->id_user == $this->ion_auth->user()->row()->id) { ?>
                                    <?php echo anchor(base_url('medcheck/cart_medcheck_resep_itm_hps.php?id=' . $this->input->get('id') . '&id_resep=' . $this->input->get('id_resep') . '&status=' . $this->input->get('status') . '&id_item=' . general::enkrip($cart->id)), '<i class="fa fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $cart->item . '] ?\')"') ?>
                                    <?php // } ?>
                                <?php } elseif ($sql_medc_res_rw->status == '2') { ?>
                                    <?php // if ($cart->id_user == $this->ion_auth->user()->row()->id) { ?>
                                    <?php echo anchor(base_url('medcheck/cart_medcheck_resep_itm_hps.php?id=' . $this->input->get('id') . '&id_resep=' . $this->input->get('id_resep') . '&status=' . $this->input->get('status') . '&id_item=' . general::enkrip($cart->id)), '<i class="fa fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $cart->item . '] ?\')"') ?>
                                    <?php // } ?>
                                <?php } ?>
                            <?php } ?>
                        </th>
                        <td class="text-center"><?php echo $no . '.'; ?></td>
                        <td class="text-left">
                            <?php $harga = $sql_racikan->harga + $cart->harga; ?>
                            <?php echo 'R/ ' . nbs(2) . $cart->item . br(); ?>
                            <small><?php echo 'Rp. ' . general::format_angka($cart->harga) . br(); ?></small>
                            <?php if ($_GET['act'] != 'res_input_rc') { ?>
                                <?php if ($sql_item->status_racikan == '1') { ?>
                                    <?php if ($sql_medc_res_rw->status == '0') { ?>
                                        <?php echo anchor(base_url('medcheck/tambah.php?act=res_input_rc&id=' . $this->input->get('id') . '&id_resep=' . $this->input->get('id_resep') . '&status=' . $this->input->get('status') . '&item_id=' . general::enkrip($cart->id)), '<i class="fas fa-plus"></i> Tambah Racikan'); ?>
                                    <?php } elseif ($sql_medc_res_rw->status == '2') { ?>
                                        <?php echo anchor(base_url('medcheck/tambah.php?act=res_input_rc&id=' . $this->input->get('id') . '&id_resep=' . $this->input->get('id_resep') . '&status=' . $this->input->get('status') . '&item_id=' . general::enkrip($cart->id)), '<i class="fas fa-plus"></i> Tambah Racikan'); ?>
                                    <?php } else { ?>
                                        <?php if ($sql_medc_res_rw->status != '4') { ?>
                                            <i class="fas fa-plus"></i> Tambah Racikan
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </td>
                        <td class="text-right">
                            <?php $subtotal = $sql_racikan->harga + ($cart->harga * $cart->jml); ?>
                            <?php $subtot_gt = $subtot_gt + $subtotal; ?>
                            <?php echo (float) $cart->jml . ' ' . $cart->satuan . br() ?>
                            <?php echo 'Rp. ' . general::format_angka($subtotal); ?>
                        </td>
                        <td class="text-center">
                            <?php if ($_GET['act'] != 'res_input_rc') { ?>
                                <?php // if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE OR akses::hakFarmasi() == TRUE) { ?>
                                <?php if ($sql_medc_res_rw->status == '0') { ?>
                                    <?php echo anchor(base_url('medcheck/tambah.php?act=res_edit' . '&id=' . general::enkrip($cart->id_medcheck) . '&id_resep=' . general::enkrip($cart->id_resep) . '&status=' . $this->input->get('status') . '&id_produk=' . general::enkrip($cart->id_item) . '&id_item_resep=' . general::enkrip($cart->id) . '&satuan=' . $cart->satuan), 'Aksi &raquo;', 'class="btn ' . ($cart->status_resep == 1 ? 'btn-success' : 'btn-primary') . ' btn-flat btn-xs"') ?>
                                <?php } elseif ($sql_medc_res_rw->status == '2') { ?>
                                    <?php echo anchor(base_url('medcheck/tambah.php?act=res_edit' . '&id=' . general::enkrip($cart->id_medcheck) . '&id_resep=' . general::enkrip($cart->id_resep) . '&status=' . $this->input->get('status') . '&id_produk=' . general::enkrip($cart->id_item) . '&id_item_resep=' . general::enkrip($cart->id) . '&satuan=' . $cart->satuan), 'Aksi &raquo;', 'class="btn ' . ($cart->status_resep == 1 ? 'btn-success' : 'btn-primary') . ' btn-flat btn-xs"') ?>
                                <?php } ?>
                                <?php // } ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-left" colspan="4">
                            <small><?php echo $cart->dosis . (!empty($cart->dosis_ket) ? ' (' . $cart->dosis_ket . ')' : '') ?></small>
                            <?php echo br() ?>
                            <small><?php echo (!empty($cart->keterangan) ? '' . $cart->keterangan . '' : '') ?></small>
    <?php echo br() ?>
                            <small class="text-bold"><?php echo (!empty($cart->status_mkn) ? general::tipe_obat_makan($cart->status_mkn) : '') ?></small>
                        </th>
                    </tr>
    <?php if (!empty($sql_racikan_dt)) { ?>
                        <tr>
                            <td colspan="2"></td>
                            <td class="text-left" colspan="3">
                                <strong>BAHAN RACIKAN :</strong><br/>
                                <?php foreach ($sql_racikan_dt as $racikan) { ?>
                                    <?php // if ($_GET['act'] == 'res_input_rc') { ?>
                                    <?php if ($sql_medc_res_rw->status < 4) { ?>
                                        <small><i><?php echo anchor(base_url('medcheck/cart_medcheck_resep_rc_hps.php?id=' . $this->input->get('id') . '&id_resep=' . $this->input->get('id_resep') . '&item_id_det=' . general::enkrip($racikan->id_resep_det) . '&status=' . $this->input->get('status') . '&item_id=' . general::enkrip($racikan->id)), '<i class="fa fa-remove"></i>' . nbs(2), 'class="text-danger" onclick="return confirm(\'Hapus [' . $racikan->item . '] ?\')"') ?></i></small>
                                    <?php } ?>
                                <?php // }  ?>
                                    <small><i><?php echo $racikan->item; ?></i></small>
                                    <small><i>(<?php echo (float) $racikan->jml . ' ' . $racikan->satuan; ?>) [Rp. <?php echo general::format_angka($racikan->subtotal); ?>]</i></small><br/>
                            <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php $no++; ?>
                    <?php } ?>                                            
                <tr>
                    <th class="text-right" colspan="3">Subtotal</th>
                    <th class="text-right">
<?php echo general::format_angka($subtot_gt) ?>
                    </th>
                    <th class="text-left">
                    </th>
                </tr>
            </tbody>
        </table> 
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <?php
                switch ($sql_medc_res_rw->status) {
                    case '1':
//                            if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner() == TRUE OR akses::hakFarmasi() == TRUE) {
                        ?>
                        <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&id_resep=' . $this->input->get('id_resep') . '&status=4') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                        <?php
//                            }
                        break;

                    case '4':
//                            if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner() == TRUE OR akses::hakFarmasi() == TRUE) {
                        ?>
                        <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&id_resep=' . $this->input->get('id_resep') . '&status=4') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                        <?php
//                            }
                        break;
                }
                ?>
            </div>
            <div class="col-lg-6 text-right">
                <?php if (!empty($sql_medc_res_dt)) { ?>
                    <?php
                    switch ($sql_medc_res_rw->status) {
                        case '0':
                            ?>
                            <?php echo form_open_multipart(base_url('medcheck/set_medcheck_resep_stat.php'), 'autocomplete="off"') ?>
                            <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                            <?php echo form_hidden('id_resep', general::enkrip($sql_medc_res_rw->id)); ?>
                            <?php echo form_hidden('id_farmasi', general::enkrip($sql_medc_res_rw->id_farmasi)); ?>
                            <?php echo form_hidden('status', $this->input->get('status')); ?>
                            <?php echo form_hidden('status_res', '1'); ?>
                            <?php echo form_hidden('msg', 'Resep sudah terkirim'); ?>

                            <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-paper-plane"></i> Kirim</button>
                            <?php echo form_close(); ?>
                            <?php
                            break;

                        case '1':
                            if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner() == TRUE OR akses::hakFarmasi() == TRUE) {
                                ?>
                                <?php echo form_open_multipart(base_url('medcheck/set_medcheck_resep_stat.php'), 'autocomplete="off"') ?>
                                <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                                <?php echo form_hidden('id_resep', general::enkrip($sql_medc_res_rw->id)); ?>
                                <?php echo form_hidden('id_farmasi', general::enkrip($this->ion_auth->row()->id)); ?>
                                <?php echo form_hidden('status', $this->input->get('status')); ?>
                                <?php echo form_hidden('status_res', '2'); ?>
                                <?php echo form_hidden('act', $this->input->get('act')); ?>
                                <?php echo form_hidden('msg', 'Resep sudah di konfirmasi'); ?>

                                <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-check"></i> Konfirm</button>

                                <?php echo form_close(); ?>
                                <?php
                            }
                            break;

                        case '2':
                            if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner() == TRUE OR akses::hakFarmasi() == TRUE) {
                                ?>
                                <?php if ($sql_medc_res_rw->status == '2') { ?>
                                    <?php echo form_open_multipart(base_url('medcheck/set_medcheck_proses_farm.php'), 'autocomplete="off"') ?>
                                    <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                                    <?php echo form_hidden('id_resep', $this->input->get('id_resep')); ?>
                                    <?php echo form_hidden('status', $this->input->get('status')); ?>
                                    <?php echo form_hidden('msg_route', 'proses'); ?>

                                    <button type="button" class="btn <?php echo ($sql_medc_res_rw->status_plg == '1' ? 'btn-danger' : 'btn-warning') ?> btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/set_medcheck_resep_upd.php?id=' . general::enkrip($sql_medc->id) . '&id_resep=' . $this->input->get('id_resep') . '&status=' . $this->input->get('status') . '&status_plg='.($sql_medc_res_rw->status_plg == '1' ? '0' : '1')) ?>'"><i class="fas <?php echo ($sql_medc_res_rw->status_plg == '1' ? 'fa-times-circle' : 'fa-check-circle') ?>"></i> Resep Plg</button>
                                    <button type="submit" class="btn btn-success btn-flat"><i class="fas fa-shopping-cart"></i> Proses</button>
                                    <?php echo form_close(); ?>
                                <?php } ?>
                                <?php
                            }
                            break;

                        case '4':
                            if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner() == TRUE OR akses::hakFarmasi() == TRUE) {
                                ?>
                                <?php if ($sql_medc->status < 5) { ?>
                                    <?php echo form_open_multipart(base_url('medcheck/set_medcheck_proses_farm_batal.php'), 'autocomplete="off"') ?>
                                    <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                                    <?php echo form_hidden('id_resep', $this->input->get('id_resep')); ?>
                                    <?php echo form_hidden('status', $this->input->get('status')); ?>

                                    <!--<button type="button" class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tambah.php?act=res_pas_ttd&id=' . general::enkrip($sql_medc->id) . '&id_resep=' . $this->input->get('id_resep') . '&status=4') ?>'"><i class="fas fa-signature"></i> TTD Pasien</button>-->
                                    <button type="submit" class="btn btn-danger btn-flat" onclick="return confirm('Apakah ingin melakukan pembatalan resep dengan no [<?php echo $sql_medc_res_rw->no_resep; ?>] ?')"><i class="fas fa-file-pr"></i> Batalkan</button>
                                    <?php echo form_close(); ?>
                                <?php }else{ ?>
                                    <!--<button type="button" class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tambah.php?act=res_pas_ttd&id=' . general::enkrip($sql_medc->id) . '&id_resep=' . $this->input->get('id_resep') . '&status=4') ?>'"><i class="fas fa-signature"></i> TTD Pasien</button>-->
                                <?php } ?>
                                <?php
                            }
                            break;
                    }
                    ?>
<?php } ?>
            </div>
        </div>                            
    </div>
</div>
<!-- /.card -->