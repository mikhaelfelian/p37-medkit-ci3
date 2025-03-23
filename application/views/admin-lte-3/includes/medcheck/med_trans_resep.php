<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Medical Checkup</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('medcheck/index.php') ?>">Medical Checkup</a></li>
                        <li class="breadcrumb-item active">Farmasi</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Data Pasien</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th class="text-left">Nama Pasien</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $sql_pasien->nama_pgl; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Jenis Kelamin</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $sql_pasien->jns_klm; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Tgl Lahir</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $this->tanggalan->tgl_indo2($sql_pasien->tgl_lahir); ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Usia</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $this->tanggalan->usia_lkp($sql_pasien->tgl_lahir); ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Alamat</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $sql_pasien->alamat; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <!--<button type="button" onclick="window.location.href = '<?php echo base_url('master/data_kategori_list.php') ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>-->
                                </div>
                                <div class="col-lg-6 text-right">
                                    <!--<button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-undo"></i> Bersih</button>-->
                                    <!--<button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>-->
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Data Medcheck</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th class="text-left">ID Transaksi</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $sql_medc->no_rm; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Tipe</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo general::status_rawat2($sql_medc->tipe); ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Klinik</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $sql_poli->lokasi; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Dokter Utama</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $sql_dokter->nama; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Petugas</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $this->ion_auth->user($sql_medc->id_user)->row()->first_name; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <!--<button type="button" onclick="window.location.href = '<?php echo base_url('master/data_kategori_list.php') ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>-->
                                </div>
                                <div class="col-lg-6 text-right">
                                    <!--<button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-undo"></i> Bersih</button>-->
                                    <!--<button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>-->
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Data Item Resep <?php echo $sql_medc_res_rw->no_resep; ?></h3>
                        </div>
                        <div class="card-body table-responsive">
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
                                    <?php
                                    $no = 1;
                                    $sr = 0;
                                    ?>
                                    <?php $subtot_gt = 0; ?>
                                    <?php foreach ($sql_medc_res_dt as $cart) { ?>
                                        <?php $sql_item = $this->db->where('id', $cart->id_item)->get('tbl_m_produk')->row(); ?>
                                        <?php $sql_racikan = $this->db->select('SUM(subtotal) AS harga')->where('id_resep_det', $cart->id)->get('tbl_trans_medcheck_resep_det_rc')->row(); ?>
                                        <?php $sql_racikan_dt = $this->db->select('*')->where('id_resep_det', $cart->id)->get('tbl_trans_medcheck_resep_det_rc')->result(); ?>
                                        <?php $sr = $sr + $cart->status_resep; ?>                                    
                                        <tr>
                                            <th class="text-center">
                                                <?php if ($sql_medc_res_rw->status == '0') { ?>
                                                    <?php // if ($cart->id_user == $this->ion_auth->user()->row()->id) { ?>
                                                    <?php echo anchor(base_url('medcheck/cart_medcheck_resep_itm_hps.php?id=' . $this->input->get('id') . '&id_resep=' . $this->input->get('id_resep') . '&status=' . $this->input->get('status') . '&id_item=' . general::enkrip($cart->id)), '<i class="fa fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $cart->item . '] ?\')"') ?>
                                                    <?php // } ?>
                                                <?php } elseif ($sql_medc_res_rw->status == '2') { ?>
                                                    <?php // if ($cart->id_user == $this->ion_auth->user()->row()->id) { ?>
                                                    <?php echo anchor(base_url('medcheck/cart_medcheck_resep_itm_hps.php?id=' . $this->input->get('id') . '&id_resep=' . $this->input->get('id_resep') . '&status=' . $this->input->get('status') . '&id_item=' . general::enkrip($cart->id)), '<i class="fa fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $cart->item . '] ?\')"') ?>
                                                    <?php // } ?>
                                                <?php } ?>
                                            </th>
                                            <td class="text-center"><?php echo $no . '.'; ?></td>
                                            <td class="text-left">
                                                <?php $harga = $sql_racikan->harga + $cart->harga; ?>
                                                <?php echo 'R/ ' . nbs(2) . $cart->item . br(); ?>
                                                <small><?php echo 'Rp. ' . general::format_angka($cart->harga) . br(); ?></small>
                                                <?php if ($sql_item->status_racikan == '1') { ?>
                                                    <?php if ($sql_medc_res_rw->status == '0') { ?>
                                                        <?php echo anchor(base_url('medcheck/resep/tambah.php?act=resep_racikan_form&id=' . $this->input->get('id') . '&id_resep=' . $this->input->get('id_resep') . '&status=' . $this->input->get('status') . '&item_id=' . general::enkrip($cart->id)), '<i class="fas fa-plus"></i> Tambah Racikan'); ?>
                                                    <?php } elseif ($sql_medc_res_rw->status == '2') { ?>
                                                        <?php echo anchor(base_url('medcheck/resep/tambah.php?act=resep_racikan_form&id=' . $this->input->get('id') . '&id_resep=' . $this->input->get('id_resep') . '&status=' . $this->input->get('status') . '&item_id=' . general::enkrip($cart->id)), '<i class="fas fa-plus"></i> Tambah Racikan'); ?>
                                                    <?php } else { ?>
                                                        <?php if ($sql_medc_res_rw->status != '4') { ?>
                                                            <i class="fas fa-plus"></i> Tambah Racikan
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
                                                <?php // if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE OR akses::hakFarmasi() == TRUE) { ?>
                                                <?php if ($sql_medc_res_rw->status == '0') { ?>
                                                    <?php echo anchor(base_url('medcheck/resep/tambah.php?act=resep_edit_form' . '&id=' . general::enkrip($cart->id_medcheck) . '&id_resep=' . general::enkrip($cart->id_resep) . '&status=' . $this->input->get('status') . '&id_item_resep=' . general::enkrip($cart->id) . '&satuan=' . $cart->satuan), 'Aksi &raquo;', 'class="btn ' . ($cart->status_resep == 1 ? 'btn-success' : 'btn-primary') . ' btn-flat btn-xs"') ?>
                                                <?php } elseif ($sql_medc_res_rw->status == '2') { ?>
                                                    <?php echo anchor(base_url('medcheck/resep/tambah.php?act=resep_edit_form' . '&id=' . general::enkrip($cart->id_medcheck) . '&id_resep=' . general::enkrip($cart->id_resep) . '&status=' . $this->input->get('status') . '&id_item_resep=' . general::enkrip($cart->id) . '&satuan=' . $cart->satuan), 'Aksi &raquo;', 'class="btn ' . ($cart->status_resep == 1 ? 'btn-success' : 'btn-primary') . ' btn-flat btn-xs"') ?>
                                                <?php } ?>
                                                <?php // } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-center"></th>
                                            <th class="text-left" colspan="4">
                                                <small><?php echo $cart->dosis . (!empty($cart->dosis_ket) ? ' (' . $cart->dosis_ket . ')' : '') ?></small>
                                                <?php echo br() ?>
                                                <small><?php echo (!empty($cart->keterangan) ? '' . $cart->keterangan . '' : '') ?></small>
                                            </th>
                                        </tr>
                                        <?php if (!empty($sql_racikan_dt)) { ?>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td class="text-left" colspan="3">
                                                    <strong>BAHAN RACIKAN :</strong><br/>
                                                    <?php foreach ($sql_racikan_dt as $racikan) { ?>
                                                        <?php if ($sql_medc_res_rw->status < 4) { ?>
                                                            <small><i><?php echo anchor(base_url('medcheck/cart_medcheck_resep_rc_hps.php?id=' . $this->input->get('id') . '&id_resep=' . $this->input->get('id_resep') . '&item_id_det=' . general::enkrip($racikan->id_resep_det) . '&status=' . $this->input->get('status') . '&item_id=' . general::enkrip($racikan->id)), '<i class="fa fa-remove"></i>' . nbs(2), 'class="text-danger" onclick="return confirm(\'Hapus [' . $racikan->item . '] ?\')"') ?></i></small>
                                                        <?php } ?>
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

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
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
                                                <?php echo form_hidden('status', $sql_medc->status); ?>
                                                <?php echo form_hidden('status_res', '1'); ?>

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
                                                    <?php echo form_hidden('status', $sql_medc->status); ?>
                                                    <?php echo form_hidden('status_res', '2'); ?>
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

                                                        <button type="submit" class="btn btn-danger btn-flat" onclick="return confirm('Apakah ingin melakukan pembatalan resep dengan no [<?php echo $sql_medc_res_rw->no_resep; ?>] ?')"><i class="fas fa-file-pr"></i> Batalkan</button>
                                                        <?php echo form_close(); ?>
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
                </div>
                <?php if (isset($_GET['act']) AND $_GET['act'] == 'resep_edit_form') { ?>
                    <div class="col-md-6">
                        <?php $hasError = $this->session->flashdata('form_error'); ?>
                        <?php echo form_open_multipart(base_url('medcheck/cart_medcheck_resep_upd2.php'), 'autocomplete="off"') ?>
                        <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                        <?php echo form_hidden('id_resep', $this->input->get('id_resep')); ?>
                        <?php echo form_hidden('id_item_resep', general::enkrip($sql_medc_res_dt_rw->id)); ?>
                        <?php echo form_hidden('status', $this->input->get('status')); ?>

                        <input type="hidden" id="harga" name="harga" value="<?php echo (!empty($sql_produk->harga_jual) ? (float) $sql_produk->harga_jual : '0'); ?>">

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Form Item Farmasi</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <div class="form-group row <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label"><?php echo (!empty($sql_produk) ? 'Kode' : 'Item') ?></label>
                                    <div class="col-sm-9">
                                        <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Kode / Nama / Alias Obat ...', 'value' => $sql_produk->kode)) ?>
                                    </div>
                                </div>
                                <?php if (!empty($sql_produk)) { ?>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label"><?php echo (akses::hakDokter() == TRUE ? 'Obat' : 'Item / Obat') ?></label>
                                        <div class="col-sm-9">
                                            <?php echo form_input(array('id' => 'item', 'name' => 'item', 'class' => 'form-control pull-right', 'value' => $sql_produk->produk, 'readonly' => 'true')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Alias</label>
                                        <div class="col-sm-9">
                                            <?php echo form_input(array('id' => 'item', 'name' => 'item_alias', 'class' => 'form-control pull-right', 'value' => $sql_produk->produk_alias, 'readonly' => 'true')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Harga</label>
                                        <div class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp</span>
                                                </div>
                                                <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control pull-right', 'value' => $sql_produk->harga_jual, 'readonly' => 'true')) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Jml</label>
                                    <div class="col-sm-2">
                                        <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control pull-right text-center', 'placeholder' => 'Jml ...', 'value' => (float) $sql_medc_res_dt_rw->jml)) ?>
                                    </div>
                                    <div class="col-sm-7">
                                        <?php if (!empty($sql_produk)) { ?>
                                            <?php echo form_input(array('id' => 'satuan', 'name' => 'satuan', 'class' => 'form-control pull-left text-left', 'placeholder' => 'Satuan ...', 'value' => $this->input->get('satuan'), 'readonly' => 'true')) ?>
                                        <?php } ?>
                                    </div>
                                </div>

                                <?php if (empty($sql_medc_res_dt_rw)) { ?>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Dosis</label>
                                        <div class="col-sm-2">
                                            <?php echo form_input(array('id' => 'harga', 'name' => 'dos_jml1', 'class' => 'form-control pull-right text-center', 'placeholder' => 'Jml ...')) ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <select name="dos_sat" class="form-control">
                                                <option value="">- Satuan -</option>
                                                <?php foreach ($sql_sat_pake as $pake) { ?>
                                                    <option value="<?php echo $pake->id ?>"><?php echo $pake->satuan ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <?php echo form_input(array('id' => '', 'name' => 'x', 'class' => 'form-control text-center', 'value' => 'Tiap', 'disabled' => 'TRUE')) ?>
                                        </div>
                                        <div class="col-sm-2">
                                            <?php echo form_input(array('id' => 'harga', 'name' => 'dos_jml2', 'class' => 'form-control pull-right text-center', 'placeholder' => 'Jml ...')) ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <select name="dos_wkt" class="form-control">
                                                <option value="">- Pilih -</option>
                                                <option value="1">Menit</option>
                                                <option value="2">Jam</option>
                                                <option value="3">Hari</option>
                                                <option value="4">Minggu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Aturan</label>
                                        <div class="col-sm-12">
                                            <?php echo form_input(array('id' => '', 'name' => 'dos_ket', 'class' => 'form-control pull-right text-left', 'placeholder' => 'Aturan Tambahan ...')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Cara Minum</label>
                                        <div class="col-sm-12">
                                            <?php echo form_radio(array('id' => '', 'name' => 'status_mkn', 'value' => '1')) ?> Sebelum Makan
                                            <?php echo nbs(2) ?>
                                            <?php echo form_radio(array('id' => '', 'name' => 'status_mkn', 'value' => '2')) ?> Saat Makan
                                            <?php echo nbs(2) ?>
                                            <?php echo form_radio(array('id' => '', 'name' => 'status_mkn', 'value' => '3')) ?> Sesudah Makan
                                            <?php echo nbs(2) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Catatan</label>
                                        <div class="col-sm-12">
                                            <?php echo form_input(array('id' => '', 'name' => 'keterangan', 'class' => 'form-control pull-right text-left', 'placeholder' => 'Inputkan Catatan ...', 'value'=>$sql_medc_res_dt_rw->keterangan)) ?>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <?php $dosis_edt = explode(' ', $sql_medc_res_dt_rw->dosis) ?>
                                    <!--                                    <div class="form-group row">
                                                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Dosis</label>
                                                                            <div class="col-sm-9">
                                    <?php echo form_input(array('id' => '', 'name' => 'dos', 'class' => 'form-control pull-right text-left', 'value' => $sql_medc_res_dt_rw->dosis, 'readonly' => 'true')) ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Aturan</label>
                                                                            <div class="col-sm-9">
                                    <?php echo form_input(array('id' => '', 'name' => 'dos_ket', 'class' => 'form-control pull-right text-left', 'value' => $sql_medc_res_dt_rw->dosis_ket, 'readonly' => 'true')) ?>
                                                                            </div>
                                                                        </div>-->
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Dosis</label>
                                        <div class="col-sm-2">
                                            <?php echo form_input(array('id' => 'harga', 'name' => 'dos_jml1', 'class' => 'form-control pull-right text-center', 'placeholder' => 'Jml ...', 'value' => $dosis_edt[0])) ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <select name="dos_sat" class="form-control">
                                                <option value="">- Satuan -</option>
                                                <?php foreach ($sql_sat_pake as $pake) { ?>
                                                    <option value="<?php echo $pake->id ?>" <?php echo ($pake->satuan == $dosis_edt[1] ? 'selected' : '') ?>><?php echo $pake->satuan ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <?php echo form_input(array('id' => '', 'name' => 'x', 'class' => 'form-control text-center', 'value' => 'Tiap', 'disabled' => 'TRUE')) ?>
                                        </div>
                                        <div class="col-sm-2">
                                            <?php echo form_input(array('id' => 'harga', 'name' => 'dos_jml2', 'class' => 'form-control pull-right text-center', 'placeholder' => 'Jml ...', 'value' => $dosis_edt[3])) ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <select name="dos_wkt" class="form-control">
                                                <option value="">- Pilih -</option>
                                                <option value="1" <?php echo ($dosis_edt[4] == 'Menit' ? 'selected' : '') ?>>Menit</option>
                                                <option value="2" <?php echo ($dosis_edt[4] == 'Jam' ? 'selected' : '') ?>>Jam</option>
                                                <option value="3" <?php echo ($dosis_edt[4] == 'Hari' ? 'selected' : '') ?>>Hari</option>
                                                <option value="4" <?php echo ($dosis_edt[4] == 'Minggu' ? 'selected' : '') ?>>Minggu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Aturan</label>
                                        <div class="col-sm-12">
                                            <?php echo form_input(array('id' => '', 'name' => 'dos_ket', 'class' => 'form-control pull-right text-left', 'placeholder' => 'Aturan Tambahan ...', 'value' => $sql_medc_res_dt_rw->dosis_ket)) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Tipe</label><br>
                                        <div class="col-sm-9">
                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                <label class="btn btn-light active">
                                                    <input type="radio" name="tipe" id="option_a1" autocomplete="off" value="1" <?php echo ($sql_medc_res_dt_rw->status_resep == '1' ? 'checked="TRUE"' : '') ?>>  <i class="fas fa-check text-success"></i>
                                                </label>
                                                <label class="btn btn-light">
                                                    <input type="radio" name="tipe" id="option_a2" autocomplete="off" value="2" <?php echo ($sql_medc_res_dt_rw->status_resep == '2' ? 'checked="TRUE"' : '') ?>> <i class="fas fa-edit text-primary"></i>
                                                </label>
                                                <label class="btn btn-light">
                                                    <input type="radio" name="tipe" id="option_a3" autocomplete="off" value="3" <?php echo ($sql_medc_res_dt_rw->status_resep == '3' ? 'checked="TRUE"' : '') ?>> <i class="fas fa-xmark text-danger"></i>
                                                </label>
                                            </div>
                                            <br/>
                                            <i>* Status untuk farmasi, diterima, ganti obat / item, dibatalkan</i>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Cara Minum</label>
                                        <div class="col-sm-12">
                                            <input type="radio" name="status_mkn" value="1" <?php echo ($sql_medc_res_dt_rw->status_mkn == '1' ? 'checked' : '') ?>> Sebelum Makan
                                            <?php echo nbs(2) ?>
                                            <input type="radio" name="status_mkn" value="2" <?php echo ($sql_medc_res_dt_rw->status_mkn == '2' ? 'checked' : '') ?>> Saat Makan
                                            <?php echo nbs(2) ?>
                                            <input type="radio" name="status_mkn" value="3" <?php echo ($sql_medc_res_dt_rw->status_mkn == '3' ? 'checked' : '') ?>> Sesudah Makan
                                            <?php echo nbs(2) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Catatan</label>
                                        <div class="col-sm-12">
                                            <?php echo form_input(array('id' => '', 'name' => 'keterangan', 'class' => 'form-control pull-right text-left', 'placeholder' => 'Inputkan Catatan ...', 'value'=>$sql_medc_res_dt_rw->status_mkn)) ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <?php if (!empty($sql_medc_res_dt_rw)) { ?>
                                            <button type="button" onclick="window.location.href = '<?php echo base_url('medcheck/resep/tambah.php?id=' . general::enkrip($sql_medc->id) . '&id_resep=' . $this->input->get('id_resep') . '&status=' . $this->input->get('status')); ?>'" class="btn btn-danger btn-flat"><i class="fas fa-refresh"></i> Reset</button>
                                        <?php } ?>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-save"></i> Simpan</button>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                <?php } elseif (isset($_GET['act']) AND $_GET['act'] == 'resep_racikan_form') { ?>
                    <div class="col-md-6">
                        <?php $hasError = $this->session->flashdata('form_error'); ?>
                        <?php echo form_open_multipart(base_url('medcheck/cart_medcheck_resep_rc.php'), 'autocomplete="off"') ?>
                        <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                        <?php echo form_hidden('id_resep', $this->input->get('id_resep')); ?>
                        <?php echo form_hidden('id_resep_det', $this->input->get('item_id')); ?>
                        <?php echo form_hidden('id_item', $this->input->get('item_id')); ?>
                        <?php echo form_hidden('id_item_rc', $this->input->get('id_item')); ?>
                        <?php echo form_hidden('status', $this->input->get('status')); ?>

                        <input type="hidden" id="harga" name="harga" value="<?php echo (!empty($sql_produk->harga_jual) ? (float) $sql_produk->harga_jual : '0'); ?>">

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Form Racikan Farmasi</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <div class="form-group row <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label"><?php echo (!empty($sql_produk) ? 'Kode' : 'Item') ?></label>
                                    <div class="col-sm-9">
                                        <?php echo form_input(array('id' => 'kode_rc', 'name' => 'kode_rc', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Kode / Nama / Alias Obat ...', 'value' => $sql_produk->kode)) ?>
                                    </div>
                                </div>
                                <?php if (!empty($sql_produk)) { ?>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label"><?php echo (akses::hakDokter() == TRUE ? 'Obat' : 'Bahan') ?></label>
                                        <div class="col-sm-9">
                                            <?php echo form_input(array('id' => 'item_rc', 'name' => 'item_rc', 'class' => 'form-control pull-right', 'value' => $sql_produk->produk, 'readonly' => 'true')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Alias</label>
                                        <div class="col-sm-9">
                                            <?php echo form_input(array('id' => 'item_rc', 'name' => 'item_alias_rc', 'class' => 'form-control pull-right', 'value' => $sql_produk->produk_alias, 'readonly' => 'true')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Harga</label>
                                        <div class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp</span>
                                                </div>
                                                <?php echo form_input(array('id' => 'harga', 'name' => 'harga_rc', 'class' => 'form-control pull-right', 'value' => $sql_produk->harga_jual, 'readonly' => 'true')) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Jml</label>
                                    <div class="col-sm-2">
                                        <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control pull-right text-center', 'placeholder' => 'Jml ...', 'value' => 1)) ?>
                                    </div>
                                    <div class="col-sm-7">
                                        <?php if (!empty($sql_produk)) { ?>
                                            <?php echo form_input(array('id' => 'satuan', 'name' => 'satuan', 'class' => 'form-control pull-left text-left', 'placeholder' => 'Satuan ...', 'value' => $this->input->get('satuan'))) ?>
                                        <?php } ?>
                                    </div>
                                </div>

                                <?php if (empty($sql_medc_res_dt_rw)) { ?>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Satuan Farmasi</label>
                                        <div class="col-sm-2">
                                            <?php echo form_input(array('id' => 'harga', 'name' => 'dos_jml1', 'class' => 'form-control pull-right text-center', 'placeholder' => 'Jml ...')) ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <select name="dos_sat" class="form-control">
                                                <option value="">- Satuan -</option>
                                                <?php foreach ($sql_sat_pake as $pake) { ?>
                                                    <option value="<?php echo $pake->id ?>"><?php echo $pake->satuan ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Cara Minum</label>
                                        <div class="col-sm-12">
                                            <?php echo form_radio(array('id' => '', 'name' => 'status_mkn', 'value' => '1')) ?> Sebelum Makan
                                            <?php echo nbs(2) ?>
                                            <?php echo form_radio(array('id' => '', 'name' => 'status_mkn', 'value' => '2')) ?> Saat Makan
                                            <?php echo nbs(2) ?>
                                            <?php echo form_radio(array('id' => '', 'name' => 'status_mkn', 'value' => '3')) ?> Sesudah Makan
                                            <?php echo nbs(2) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Catatan</label>
                                        <div class="col-sm-12">
                                            <?php echo form_input(array('id' => '', 'name' => 'dos_ket', 'class' => 'form-control pull-right text-left', 'placeholder' => 'Catatan Racikan ...')) ?>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Dosis</label>
                                        <div class="col-sm-9">
                                            <?php echo form_input(array('id' => '', 'name' => 'dos', 'class' => 'form-control pull-right text-left', 'value' => $sql_medc_res_dt_rw->dosis, 'readonly' => 'true')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Cara Minum</label>
                                        <div class="col-sm-12">
                                            <input type="radio" name="status_mkn" value="1" checked="<?php echo ($sql_medc_res_dt_rw->status_mkn == '1' ? 'TRUE' : '') ?>"> Sebelum Makan
                                            <?php echo nbs(2) ?>
                                            <input type="radio" name="status_mkn" value="1" checked="<?php echo ($sql_medc_res_dt_rw->status_mkn == '2' ? 'TRUE' : '') ?>"> Saat Makan
                                            <?php echo nbs(2) ?>
                                            <input type="radio" name="status_mkn" value="1" checked="<?php echo ($sql_medc_res_dt_rw->status_mkn == '3' ? 'TRUE' : '') ?>"> Sesudah Makan
                                            <?php echo nbs(2) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Aturan</label>
                                        <div class="col-sm-9">
                                            <?php echo form_input(array('id' => '', 'name' => 'dos_ket', 'class' => 'form-control pull-right text-left', 'value' => $sql_medc_res_dt_rw->dosis_ket, 'readonly' => 'true')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Tipe</label><br>
                                        <div class="col-sm-9">
                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                <label class="btn btn-light active">
                                                    <input type="radio" name="tipe" id="option_a1" autocomplete="off" value="1" <?php echo ($sql_medc_res_dt_rw->status_resep == '1' ? 'checked="TRUE"' : '') ?>>  <i class="fas fa-check text-success"></i>
                                                </label>
                                                <label class="btn btn-light">
                                                    <input type="radio" name="tipe" id="option_a2" autocomplete="off" value="2" <?php echo ($sql_medc_res_dt_rw->status_resep == '2' ? 'checked="TRUE"' : '') ?>> <i class="fas fa-edit text-primary"></i>
                                                </label>
                                                <label class="btn btn-light">
                                                    <input type="radio" name="tipe" id="option_a3" autocomplete="off" value="3" <?php echo ($sql_medc_res_dt_rw->status_resep == '3' ? 'checked="TRUE"' : '') ?>> <i class="fas fa-xmark text-danger"></i>
                                                </label>
                                            </div>
                                            <br/>
                                            <i>* Status untuk farmasi, diterima, ganti obat / item, dibatalkan</i>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <button type="button" onclick="window.location.href = '<?php echo base_url('medcheck/resep/tambah.php?id=' . general::enkrip($sql_medc->id) . '&id_resep=' . $this->input->get('id_resep') . '&status=' . $this->input->get('status')); ?>'" class="btn btn-danger btn-flat"><i class="fas fa-refresh"></i> Reset</button>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-save"></i> Simpan</button>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                <?php } else { ?>
                    <div class="col-md-6">
                        <?php if ($sql_medc_res_rw->status != '4') { ?>
                            <?php $hasError = $this->session->flashdata('form_error'); ?>
                            <?php echo form_open_multipart(base_url('medcheck/cart_medcheck_resep_upd1.php'), 'autocomplete="off"') ?>
                            <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                            <?php echo form_hidden('id_resep', $this->input->get('id_resep')); ?>
                            <?php echo form_hidden('id_item', general::enkrip($sql_produk->id)); ?>
                            <?php echo form_hidden('status', $this->input->get('status')); ?>
                            <?php echo form_hidden('act', $this->input->get('act')); ?>

                            <input type="hidden" id="harga" name="harga" value="<?php echo (!empty($sql_produk->harga_jual) ? (float) $sql_produk->harga_jual : '0'); ?>">

                            <div class="card card-default">
                                <div class="card-header">
                                    <h3 class="card-title">Form Input Resep</h3>
                                </div>
                                <div class="card-body table-responsive">
                                    <div class="form-group row <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label"><?php echo (!empty($sql_produk) ? 'Kode' : 'Item') ?></label>
                                        <div class="col-sm-9">
                                            <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Kode / Nama / Alias Obat ...', 'value' => $sql_produk->kode)) ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($sql_produk)) { ?>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label"><?php echo (akses::hakDokter() == TRUE ? 'Obat' : 'Item / Obat') ?></label>
                                            <div class="col-sm-9">
                                                <?php echo form_input(array('id' => 'item', 'name' => 'item', 'class' => 'form-control pull-right', 'value' => $sql_produk->produk, 'readonly' => 'true')) ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Alias</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input(array('id' => 'item', 'name' => 'item_alias', 'class' => 'form-control pull-right', 'value' => $sql_produk->produk_alias, 'readonly' => 'true')) ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Kandungan</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input(array('id' => 'item', 'name' => 'item_kandungan', 'class' => 'form-control pull-right', 'value' => strtolower($sql_produk->produk_kand), 'readonly' => 'true')) ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Jml</label>
                                        <div class="col-sm-2">
                                            <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control pull-right text-center', 'placeholder' => 'Jml ...', 'value' => '1')) ?>
                                        </div>
                                        <div class="col-sm-7">
                                            <?php if (!empty($sql_produk)) { ?>
                                                <?php echo form_input(array('id' => 'satuan', 'name' => 'satuan', 'class' => 'form-control pull-left text-left', 'placeholder' => 'Satuan ...', 'value' => $this->input->get('satuan'), 'readonly' => 'true')) ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Dosis</label>
                                        <div class="col-sm-2">
                                            <?php echo form_input(array('id' => 'harga', 'name' => 'dos_jml1', 'class' => 'form-control pull-right text-center', 'placeholder' => 'Jml ...')) ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <select name="dos_sat" class="form-control">
                                                <option value="">- Satuan -</option>
                                                <?php foreach ($sql_sat_pake as $pake) { ?>
                                                    <option value="<?php echo $pake->id ?>"><?php echo $pake->satuan ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <?php echo form_input(array('id' => '', 'name' => 'x', 'class' => 'form-control text-center', 'value' => 'Tiap', 'disabled' => 'TRUE')) ?>
                                        </div>
                                        <div class="col-sm-2">
                                            <?php echo form_input(array('id' => 'harga', 'name' => 'dos_jml2', 'class' => 'form-control pull-right text-center', 'placeholder' => 'Jml ...')) ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <select name="dos_wkt" class="form-control">
                                                <option value="">- Pilih -</option>
                                                <option value="1">Menit</option>
                                                <option value="2">Jam</option>
                                                <option value="3">Hari</option>
                                                <option value="4">Minggu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Aturan</label>
                                        <div class="col-sm-12">
                                            <?php echo form_input(array('id' => '', 'name' => 'dos_ket', 'class' => 'form-control pull-right text-left', 'placeholder' => 'Aturan Tambahan ...')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Cara Minum</label>
                                        <div class="col-sm-12">
                                            <?php echo form_radio(array('id' => '', 'name' => 'status_mkn', 'value' => '1')) ?> Sebelum Makan
                                            <?php echo nbs(2) ?>
                                            <?php echo form_radio(array('id' => '', 'name' => 'status_mkn', 'value' => '2')) ?> Saat Makan
                                            <?php echo nbs(2) ?>
                                            <?php echo form_radio(array('id' => '', 'name' => 'status_mkn', 'value' => '3')) ?> Sesudah Makan
                                            <?php echo nbs(2) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Catatan</label>
                                        <div class="col-sm-12">
                                            <?php echo form_input(array('id' => '', 'name' => 'keterangan', 'class' => 'form-control pull-right text-left', 'placeholder' => 'Inputkan Catatan ...', 'value'=>$sql_medc_res_dt_rw->keterangan)) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-lg-6">

                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-save"></i> Simpan</button>
                                        </div>
                                    </div>                            
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $("input[id=harga]").autoNumeric({aSep: '.', aDec: ',', aPad: false});

        var dateToday = new Date();
        $("input[id=tgl]").datepicker({
            format: 'dd/mm/yyyy',
            defaultDate: "+1w",
            changeMonth: true,
            minDate: dateToday,
            autoclose: true
        });

<?php if (!empty($sql_medc->id)) { ?>
    <?php if ($_GET['act'] == 'resep_racikan_form') { ?>
                // Data Item Cart
                $('#kode_rc').autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: "<?php echo base_url('medcheck/json_item.php?page=obat&status=' . $this->input->get('status')) ?>",
                            dataType: "json",
                            data: {
                                term: request.term
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 1,
                    select: function (event, ui) {
                        var $itemrow = $(this).closest('tr');
                        //Populate the input fields from the returned values
                        $itemrow.find('#id_item_rc').val(ui.item.id);
                        $('#id_item_rc').val(ui.item.id);
                        $('#kode_rc').val(ui.item.kode);
                        window.location.href = "<?php echo base_url('medcheck/resep/tambah.php?act=' . $this->input->get('act') . '&id=' . $this->input->get('id') . (isset($_GET['id_resep']) ? '&id_resep=' . $this->input->get('id_resep') : '') . '&status=' . $this->input->get('status') . '&item_id=' . $this->input->get('item_id')) ?>&id_item=" + ui.item.id + "&harga=" + ui.item.harga + "&satuan=" + ui.item.satuan;

                        // Give focus to the next input field to recieve input from user
                        $('#jml_rc').focus();
                        return false;
                    }

                    // Format the list menu output of the autocomplete
                }).data("ui-autocomplete")._renderItem = function (ul, item) {
                    return $("<li></li>")
                            .data("item.autocomplete", item)
                            .append("<a>" + item.name + "</a><br/><a><i><small>" + item.alias + "</small></i></a><a><i><small> " + item.kandungan + "</small></i></a>")
                            .appendTo(ul);
                };
    <?php } else { ?>
                // Data Item Cart
                $('#kode').autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: "<?php echo base_url('medcheck/json_item.php?page=obat&status=4') ?>",
                            dataType: "json",
                            data: {
                                term: request.term
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 1,
                    select: function (event, ui) {
                        var $itemrow = $(this).closest('tr');
                        //Populate the input fields from the returned values
                        $itemrow.find('#id_item').val(ui.item.id);
                        $('#id_item').val(ui.item.id);
                        $('#kode').val(ui.item.kode);
                        window.location.href = "<?php echo base_url('medcheck/resep/tambah.php?id=' . $this->input->get('id') . (isset($_GET['id_resep']) ? '&id_resep=' . $this->input->get('id_resep') : '') . '&status=' . $this->input->get('status')) ?>&id_item=" + ui.item.id + "&harga=" + ui.item.harga + "&satuan=" + ui.item.satuan;

                        // Give focus to the next input field to recieve input from user
                        $('#jml').focus();
                        return false;
                    }

                    // Format the list menu output of the autocomplete
                }).data("ui-autocomplete")._renderItem = function (ul, item) {
                    return $("<li></li>")
                            .data("item.autocomplete", item)
                            .append("<a>" + item.name + "</a><br/><a><i><small>" + item.alias + "</small></i></a><a><i><small> " + item.kandungan + "</small></i></a>")
                            .appendTo(ul);
                };
    <?php } ?>
<?php } ?>
    });
</script>