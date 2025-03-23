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
                        <li class="breadcrumb-item active">Resep</li>
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
                            <h3 class="card-title">Form Medical Checkup</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-responsive">
                                <tr>
                                    <th class="text-left">Nama Pasien</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $sql_pasien->nama_pgl; ?></td>
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
                                <tr>
                                    <th class="text-left">Keluhan</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $sql_medc->keluhan; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Anamnesa</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $sql_medc->anamnesa; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Pemeriksaan</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $sql_medc->pemeriksaan; ?></td>
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
                            <h3 class="card-title">Data Resep</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">No Resep</label>
                                <div class="col-sm-9">
                                    <?php echo form_input(array('id' => 'tgl', 'name' => 'resep', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'value' => $sql_medc_res_rw->no_resep, 'readonly' => 'TRUE')) ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Tgl Resep</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl_resep', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'value' => $this->tanggalan->tgl_indo2($sql_medc_res_rw->tgl_simpan), 'readonly' => 'TRUE')) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Dokter</label>
                                <div class="col-sm-9">
                                    <?php echo form_input(array('id' => 'tgl', 'name' => 'dokter', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'value' => $sql_dokter->nama, 'readonly' => 'TRUE')) ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Farmasi</label>
                                <div class="col-sm-9">
                                    <?php echo form_input(array('id' => 'tgl', 'name' => 'farmasi', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'value' => $this->ion_auth->user($sql_medc_res_rw->id_farmasi)->row()->first_name, 'readonly' => 'TRUE')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">

                                </div>
                                <div class="col-lg-6 text-right">
                                
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php if (isset($_GET['id_resep'])) { ?>
                        <?php if ($sql_medc_res_rw->status == 0) { ?>
                            <div class="card card-default">
                                <div class="card-header">
                                    <h3 class="card-title">Data Item</h3>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-left">Item</th>
                                                <th class="text-right">Jml</th>
                                                <th class="text-right">Harga</th>
                                                <th class="text-left">Dosis</th>
                                                <th class="text-center">#</th>
                                            </tr>                                    
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            <?php foreach ($this->cart->contents() as $cart) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no . '.'; ?></td>
                                                    <td class="text-left"><?php echo $cart['name']; ?></td>
                                                    <td class="text-right"><?php echo $cart['qty'] . ' ' . $cart['options']['satuan'] ?></td>
                                                    <td class="text-right"><?php echo general::format_angka($cart['options']['harga']); ?></td>
                                                    <td class="text-left"><?php echo $cart['options']['jml_dos'] . ' x ' . $cart['options']['jml_hari'] . ' ' . $cart['options']['jml_sat'] . ' / Hari' . (!empty($cart['options']['jml_ket']) ? ' (' . general::tipe_obat_pakai($cart['options']['jml_ket']) . ')' : ''); ?></td>
                                                    <td class="text-center"><?php echo anchor(base_url('medcheck/cart_medcheck_resep_hps.php?id=' . general::enkrip($sql_medc->id) . '&id_item=' . $cart['rowid'] . '&id_resep=' . $this->input->get('id_resep') . '&status=' . $this->input->get('status')), '<i class="fa fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $cart['name'] . '] ?\')"') ?></td>
                                                </tr>
                                                <?php $no++; ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php if (!empty($this->cart->contents())) { ?>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-lg-6">

                                            </div>
                                            <div class="col-lg-6 text-right">
                                                <?php echo form_open_multipart(base_url('medcheck/set_medcheck_resep_pros.php'), 'autocomplete="off"') ?>
                                                <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                                                <?php echo form_hidden('id_resep', $this->input->get('id_resep')); ?>
                                                <?php echo form_hidden('status', $this->input->get('status')); ?>

                                                <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-paper-plane"></i> Kirim</button>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>                            
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <div class="card card-default">
                                <div class="card-header">
                                    <h3 class="card-title">Data Item Farmasi</h3>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-left">Item</th>
                                                <th class="text-right">Jml</th>
                                                <th class="text-right">Harga</th>
                                                <th class="text-right">Diskon</th>
                                                <th class="text-right">Subtotal</th>
                                                <th class="text-left">Keterangan</th>
                                                <th class="text-center">#</th>
                                            </tr>                                    
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            <?php foreach (json_decode($sql_medc_res_rw->item) as $cart) { ?>
                                                <?php $sql_det = $this->db->where('id_medcheck', $sql_medc->id)->where('id_item', $cart->id_item)->get('tbl_trans_medcheck_det'); ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no . '.'; ?></td>
                                                    <td class="text-left"><?php echo $cart->item; ?></td>
                                                    <td class="text-right"><?php echo $cart->jml . ' ' . $cart->satuan; ?></td>
                                                    <td class="text-right"><?php echo general::format_angka($cart->harga); ?></td>
                                                    <td class="text-right"><?php echo (!empty($sql_det->row()->disk1) ? (float) $sql_det->row()->disk1 : '') . (!empty($sql_det->row()->disk2) ? ' + ' . (float) $sql_det->row()->disk2 : '') . (!empty($sql_det->row()->disk3) ? ' + ' . (float) $sql_det->row()->disk3 : ''); ?></td>
                                                    <td class="text-right"><?php echo general::format_angka($sql_det->row()->subtotal); ?></td>
                                                    <td class="text-right"><?php // echo general::format_angka($cart->harga);         ?></td>
                                                    <td class="text-right">
                                                        <?php if ($sql_det->num_rows() == 0) { ?>
                                                            <?php echo anchor(base_url('medcheck/set_medcheck_resep_farm.php?id=' . general::enkrip($sql_medc->id) . '&id_resep=' . general::enkrip($sql_medc_res_rw->id) . '&status=' . $this->input->get('status') . '&id_produk=' . general::enkrip($cart->id_item)), '<i class="fas fa-solid fa-check"></i> Input', 'class="btn btn-success btn-flat btn-xs text-bold" style="width: 70px;"') ?>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php $no++; ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php if ($sql_det->num_rows() > 0) { ?>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-lg-6">

                                            </div>
                                            <div class="col-lg-6 text-right">
                                                <?php echo form_open_multipart(base_url('medcheck/set_medcheck_proses.php'), 'autocomplete="off"') ?>
                                                <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                                                <?php echo form_hidden('status', $this->input->get('status')); ?>

                                                <?php echo form_checkbox(array('name' => 'status_sls', 'class' => '', 'value' => '1')) ?> Transaksi Selesai                                               
                                                <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-save"></i> Simpan</button>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>                            
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->