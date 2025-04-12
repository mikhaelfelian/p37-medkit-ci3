<?php $hasError = $this->session->flashdata('form_error'); ?>
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
                        <li class="breadcrumb-item active">Form Pembayaran</li>
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
                <div class="col-lg-8">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr class="bg-yellow">
                                                        <th class="text-left" colspan="2">Item</th>
                                                        <th class="text-center">Jml</th>
                                                        <th class="text-right">Harga</th>
                                                        <th class="text-right">Pot</th>
                                                        <th class="text-right">Subtotal</th>
                                                        <th class="text-right"></th>
                                                    </tr>                                    
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    $gtotal = 0; ?>
                                                    <?php foreach ($sql_medc_det as $det) { ?>
                                                        <?php
                                                        $sql_det = $this->db
                                                                        ->select("tbl_trans_medcheck_det.id, tbl_trans_medcheck_det.id_medcheck, tbl_trans_medcheck_det.tgl_simpan, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.keterangan, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.disk1, tbl_trans_medcheck_det.disk2, tbl_trans_medcheck_det.disk3, tbl_trans_medcheck_det.diskon, tbl_trans_medcheck_det.potongan, tbl_trans_medcheck_det.subtotal, tbl_trans_medcheck_det.status_rc, tbl_m_karyawan.nama_dpn, tbl_m_karyawan.nama, tbl_m_karyawan.nama_blk")
                                                                        ->join('tbl_m_karyawan', 'tbl_m_karyawan.id_user=tbl_trans_medcheck_det.id_dokter', 'left')
                                                                        ->where('tbl_trans_medcheck_det.status_pkt', '0')
                                                                        ->where('tbl_trans_medcheck_det.id_medcheck', $det->id_medcheck)
                                                                        ->where('tbl_trans_medcheck_det.id_item_kat', $det->id_item_kat)
                                                                        ->get('tbl_trans_medcheck_det')->result();
                                                        ?>                                                    
                                                        <tr>
                                                            <td class="text-left text-bold" colspan="8"><i><?php echo $det->keterangan . ' (' . $det->kategori . ')'; ?></i></td>
                                                        </tr>
                                                        <?php $sub = 0; ?>
                                                        <?php foreach ($sql_det as $medc) { ?>
        <?php $sub = $sub + $medc->subtotal ?>
                                                            <tr>
                                                                <td class="text-center"><?php echo $no . '.'; ?></td>
                                                                <td class="text-left">
                                                                    <?php echo $medc->item; ?>
                                                                    <?php if (!empty($medc->nama)) { ?>
                                                                        <!--Iki nggo nampilke nama dokter ndes-->
                                                                        <?php echo br(); ?>
                                                                        <small><?php echo (!empty($medc->nama_dpn) ? $medc->nama_dpn . ' ' : '') . $medc->nama . (!empty($medc->nama_blk) ? ', ' . $medc->nama_blk : '') ?></small>
                                                                    <?php } ?>
                                                                    <?php echo br(); ?>
                                                                    <small><i><?php echo $this->tanggalan->tgl_indo5($medc->tgl_simpan); ?></i></small>
                                                                    
                                                                    <?php if (!empty($medc->keterangan)) { ?>
                                                                        <!--Iki nggo nampilke catatan ndes-->
                                                                        <?php echo br(); ?>
                                                                        <small><i><?php echo $medc->keterangan ?></i></small>
                                                                    <?php } ?>
                                                                </td>
                                                                <td class="text-center"><?php echo (float) $medc->jml; ?></td>
                                                                <td class="text-right">
                                                                    <?php echo general::format_angka($medc->harga); ?>                                                                    
                                                                    <?php if ($medc->disk1 != '0') { ?>
                                                                        <!--Iki nggo nampilke nama dokter ndes-->
                                                                        <?php echo br(); ?>
                                                                        <small>(<?php echo (float) $medc->disk1 . ($medc->disk2 != '0' ? ' + ' . $medc->disk2 : '') . ($medc->disk3 != '0' ? ' + ' . $medc->disk3 : '') ?> %)</small>
        <?php } ?>
                                                                </td>
                                                                <td class="text-right"><?php echo general::format_angka($medc->potongan); ?></td>
                                                                <td class="text-right"><?php echo general::format_angka($medc->subtotal); ?></td>
                                                                <td class="text-right">
                                                                    <?php if ($medc->status_rc == '0') { ?>
                                                                        <?php echo anchor(base_url('medcheck/invoice/bayar.php?id=' . $this->input->get('id') . '&item_id=' . general::enkrip($medc->id)), '<i class="fa fa-edit"></i> Ubah', 'class="btn btn-info btn-flat btn-xs" style="width: 55px;"') ?>
        <?php } ?>
                                                                </td>
                                                            </tr>
                                                            
                                                            <?php $no++ ?>
    <?php } ?>
                                                        <tr>
                                                            <td class="text-right text-bold" colspan="5">Subtotal</td>
                                                            <td class="text-right text-bold"><?php echo general::format_angka($sub); ?></td>
                                                            <td class="text-right text-bold"></td>
                                                        </tr>

                                                        <?php $gtotal = $gtotal + $sub ?>
<?php } ?>
                                                    <tr>
                                                        <td class="text-right text-bold" colspan="5">Grand Total</td>
                                                        <td class="text-right text-bold"><?php echo general::format_angka($gtotal); ?></td>
                                                        <td class="text-right text-bold"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-lg-4">
                    <?php if (!empty($sql_produk)) { ?>
    <?php echo form_open(base_url('medcheck/cart_medcheck_update.php'), 'id="medc_item_form" autocomplete="off"') ?>
    <?php echo add_form_protection(); ?>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-shopping-cart"></i> Form Data Item</h3>
                            </div>
                            <div class="card-body">                            
                                <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                                <?php echo form_hidden('item_id', general::enkrip($sql_produk->id)); ?>
                                <?php echo form_hidden('item_id_det', general::enkrip($sql_medc_det2->id)); ?>
                                <?php echo form_hidden('id_lab', $sql_medc_det2->id_lab); ?>
                                <?php echo form_hidden('id_rad', $sql_medc_det2->id_rad); ?>
                                <?php echo form_hidden('id_dokter', $sql_medc_det2->id_dokter); ?>
    <?php echo form_hidden('status', $sql_medc_det2->status); ?>

                                <input type="hidden" id="id_dokter" name="id_dokter" value="<?php echo (!empty($sql_medc_det2->id_dokter) ? $sql_medc_det2->id_dokter : '') ?>">

                                <div class="form-group">
                                    <label for="inputEmail3">Item</label>
    <?php echo form_input(array('id' => '', 'name' => 'produk', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['produk']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Item ...', 'value' => $sql_produk->produk)) ?>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="inputEmail3">Jml</label>
    <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control text-center rounded-0', 'placeholder' => 'Jml ...', 'value' => (!empty($sql_medc_det2->jml) ? $sql_medc_det2->jml : '1'))) ?>
                                        </div>
                                        <div class="col-md-9">
                                            <label for="inputEmail3">Satuan</label>
                                            <div class="form-group">
                                                <select name="satuan" class="form-control rounded-0">
                                                    <option value="">- Pilih -</option>
                                                    <?php foreach ($sql_satuan as $satuan) { ?>
                                                        <option value="<?php echo $satuan->id ?>" <?php echo ($satuan->id == $sql_produk->id_satuan ? 'selected' : '') ?>><?php echo strtoupper($satuan->satuanTerkecil) ?></option>
    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3">Harga</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Harga ...', 'value' => (!empty($sql_medc_det2->harga) ? ceil($sql_medc_det2->harga) : $sql_produk->harga_jual))) ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="inputEmail3">Diskon 1 (%)</label>
                                            <?php echo form_input(array('id' => 'diskon', 'name' => 'disk1', 'class' => 'form-control text-center rounded-0' . (!empty($hasError['produk']) ? ' is-invalid' : ''), 'placeholder' => 'Disk1 ...', 'value' => (!empty($sql_medc_det2->disk1) ? $sql_medc_det2->disk1 : '0'))) ?>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputEmail3">Diskon 2 (%)</label>
                                            <?php echo form_input(array('id' => 'diskon', 'name' => 'disk2', 'class' => 'form-control text-center rounded-0' . (!empty($hasError['produk']) ? ' is-invalid' : ''), 'placeholder' => 'Disk2 ...', 'value' => (!empty($sql_medc_det2->disk2) ? $sql_medc_det2->disk2 : '0'))) ?>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputEmail3">Diskon 3 (%)</label>
                                            <?php echo form_input(array('id' => 'diskon', 'name' => 'disk3', 'class' => 'form-control text-center rounded-0' . (!empty($hasError['produk']) ? ' is-invalid' : ''), 'placeholder' => 'Disk3 ...', 'value' => (!empty($sql_medc_det2->disk3) ? $sql_medc_det2->disk3 : '0'))) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3">Potongan</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <?php echo form_input(array('id' => 'potongan', 'name' => 'potongan', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Potongan ...', 'value' => (!empty($sql_medc_det2->potongan) ? $sql_medc_det2->potongan : '0'))) ?>
                                    </div>
                                </div>
                                <!--
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="inputEmail3">TOTAL POIN</label>
                                            <div class="input-group mb-3">                                                
                                                <?php echo form_input(array('id' => 'total_poin', 'name' => '', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Poin ...', 'value' => (float) $sql_poin->jml_poin, 'readonly' => 'TRUE')) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="inputEmail3"><?php echo nbs(2) ?></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Rp. </span>
                                                </div>
                                                <?php echo form_input(array('id' => 'total_poin', 'name' => '', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Poin anda ...', 'value' => (float) $sql_poin->jml_poin_nom, 'readonly' => 'TRUE')) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if($sql_medc->tipe_bayar == '1'){ ?>
                                    <div class="form-group">
                                        <label for="inputEmail3">PAKAI POIN</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <?php echo form_input(array('id' => 'potongan_poin', 'name' => 'potongan_poin', 'class' => 'form-control pull-right' . (!empty($hasError['jml_potongan_poin']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Potongan Poin ...', 'value' => (!empty($sql_medc_det2->potongan_poin) ? (float) $sql_medc_det2->potongan_poin : '0'))) ?>
                                        </div>
                                    </div>
                                <?php }else{ ?>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="text-danger"><i>*Tidak bisa menukar poin karena asuransi</i></label>
                                    </div>
                                <?php } ?>
                                -->
                                <!--
                                <div class="form-group">
                                    <label for="inputEmail3">Ongkir</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <?php echo form_input(array('id' => 'ongkir', 'name' => 'jml_ongkir', 'class' => 'form-control pull-right' . (!empty($hasError['ongkir']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Ongkir ...', 'value' => (!empty($sql_medc_det2->jml_ongkir) ? $sql_medc_det2->jml_ongkir : '0'))) ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3">Dokter</label>
    <?php // echo form_input(array('id' => 'dokter', 'name' => 'dokter', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['produk']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Dokter ...', 'value' => $sql_dokter->nama))  ?>
                                </div>
                                -->
                            </div>
    <?php if (!empty($sql_produk)) { ?>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-danger rounded-0" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/bayar.php?id=' . $this->input->get('id')) ?>'"><i class="fa fa-refresh"></i> Batal</button>
                                    <button type="submit" class="btn btn-info float-right rounded-0"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                        <?php } ?>
                        </div>
                        <?php echo add_double_submit_protection('medc_item_form') ?>
                        <?php echo form_close(); ?>
                    <?php } ?>
                    <?php if (empty($sql_produk)) { ?>
                        <?php echo form_open(base_url('medcheck/set_medcheck_bayar.php'), 'id="medc_bayar_form" autocomplete="off"') ?>
                            <?php echo add_form_protection(); ?>
                        <?php echo form_hidden('no_nota', general::enkrip($sql_medc->id)) ?>
                            <div class="card">
                                <div class="card-body">                            
                                    <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                                    <?php echo form_hidden('item_id', general::enkrip($sql_produk->id)); ?>
        <?php echo form_hidden('item_id_det', general::enkrip($sql_medc_det2->id)); ?>

                                    <div class="form-group">
                                        <label for="inputEmail3">METODE PEMBAYARAN</label>
                                        <select name="metode_bayar" class="form-control select2bs4  <?php echo (!empty($hasError['metode']) ? 'is-invalid' : '') ?>">
                                            <option value="">- Pilih -</option>
                                                <?php foreach ($sql_platform as $platform) { ?>
                                                <option value="<?php echo $platform->id ?>">
                                                <?php echo (!empty($platform->kode) ? '[' . $platform->kode . '] ' : '') . $platform->platform ?>
                                                </option>
        <?php } ?>
                                        </select>
                                    </div>
                                    <?php
                                    $jml_gtotal_dp = (!empty($sql_medc->jml_gtotal) ? $sql_medc->jml_gtotal : $gtotal) - $jml_total_dp;
                                    ?>
                                    <div class="form-group">
                                        <label for="inputEmail3">SUBTOTAL</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
        <?php echo form_input(array('id' => 'jml_total', 'name' => 'jml_total', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Harga ...', 'value' => (float) $gtotal, 'readonly' => 'TRUE')) ?>
                                        </div>
                                    </div>
                                    <!--
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="inputEmail3">DISKON (%)</label>
        <?php echo form_input(array('id' => 'diskon', 'name' => 'diskon', 'class' => 'form-control text-center rounded-0', 'placeholder' => 'DISKON ...', 'value' => 0)) ?>
                                            </div>
                                            <div class="col-md-8">
                                                <label for="inputEmail3">NOMINAL</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Rp. </span>
                                                    </div>
        <?php echo form_input(array('id' => 'jml_diskon', 'name' => 'jml_diskon', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'NOMINAL DISKON ...', 'value' => 0)) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3">ONGKIR</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
        <?php echo form_input(array('id' => 'ongkir', 'name' => 'jml_ongkir', 'class' => 'form-control pull-right' . (!empty($hasError['ongkir']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Ongkir ...', 'value' => (!empty($sql_medc_det2->jml_ongkir) ? $sql_medc_det2->jml_ongkir : '0'))) ?>
                                        </div>
                                    </div>
                                    -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="inputEmail3">TOTAL POIN</label>
                                                <div class="input-group mb-3">                                                
                                                    <?php echo form_input(array('id' => 'total_poin', 'name' => '', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Poin ...', 'value' => (float) $sql_poin->jml_poin, 'readonly' => 'TRUE')) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="inputEmail3"><?php echo nbs(2) ?></label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Rp. </span>
                                                    </div>
                                                    <?php echo form_input(array('id' => 'total_poin_nom', 'name' => '', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Poin anda ...', 'value' => (float) $sql_poin->jml_poin_nom, 'readonly' => 'TRUE')) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($sql_medc->tipe_bayar == '1'){ ?>
                                        <div class="form-group">
                                            <label for="inputEmail3">PAKAI POIN</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Rp. </span>
                                                </div>
                                                <?php echo form_input(array('id' => 'potongan_poin', 'name' => 'potongan_poin', 'class' => 'form-control pull-right' . (!empty($hasError['jml_potongan_poin']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Potongan Poin ...', 'value' => (!empty($sql_medc_det2->potongan_poin) ? (float) $sql_medc_det2->potongan_poin : '0'))) ?>
                                            </div>
                                        </div>
                                    <?php }else{ ?>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="text-danger"><i>*Tidak bisa menukar poin karena asuransi</i></label>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <label for="inputEmail3">DP</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_total_dp', 'name' => 'jml_total_dp', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Harga ...', 'value' => (float) $jml_total_dp, 'readonly' => 'TRUE')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3">GRAND TOTAL</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_gtotal', 'name' => 'jml_gtotal', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Harga ...', 'value' => $jml_gtotal_dp, 'readonly' => 'TRUE')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3">PEMBAYARAN</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <?php echo form_input(array('id' => 'jml_bayar', 'name' => 'jml_bayar', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Harga ...', 'value' => 0)) ?>
                                        </div>
                                    </div>
                                    <?php if ($sql_medc->jml_kurang > 0) { ?>
                                        <div class="form-group">
                                            <label for="inputEmail3">KEKURANGAN</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Rp. </span>
                                                </div>
                                            <?php echo form_input(array('id' => 'jml_kurang', 'name' => 'jml_kurang', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Harga ...', 'value' => (!empty($sql_medc->jml_kurang) ? (float) $sql_medc->jml_kurang : '0'), 'readonly' => 'TRUE')) ?>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <input type="hidden" id="jml_kurang" name="jml_kurang" value="<?php echo (!empty($sql_medc->jml_kurang) ? (float) $sql_medc->jml_kurang : '0') ?>">
                                        <div class="form-group">
                                            <label for="inputEmail3">KEMBALIAN</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Rp. </span>
                                                </div>
                                                <?php echo form_input(array('id' => 'jml_kembali', 'name' => 'jml_kembali', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Harga ...', 'value' => '0', 'readonly' => 'TRUE')) ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info float-right rounded-0"><i class="fa fa-shopping-cart"></i> Bayar</button>
                                </div>
                            </div>
                        <?php echo add_double_submit_protection('medc_bayar_form') ?>
                        <?php echo form_close(); ?>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-shopping-cart"></i> Riwayat Pembayaran</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-left">PLATFORM</th>
                                            <th class="text-right">NOMINAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($sql_medc_plat as $plat) { ?>
                                            <?php $sql_plat = $this->db->where('id', $plat->id_platform)->get('tbl_m_platform')->row() ?>
                                            <tr>
                                                <td class="text-left" style="width:50%"><?php echo $sql_plat->platform ?></td>
                                                <td class="text-right"><?php echo general::format_angka($plat->nominal) ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php } ?>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $("input[id=jml], input[id=harga], input[id=diskon], input[id=potongan], input[id=ongkir], input[id=poin]").autoNumeric({aSep: '.', aDec: ',', aPad: false});
        $("input[id=jml_total], input[id=jml_total_dp], input[id=total_poin], input[id=jml_gtotal], input[id=jml_diskon], input[id=jml_diskon], input[id=jml_bayar], input[id=jml_kurang], input[name=potongan_poin]").autoNumeric({aSep: '.', aDec: ',', aPad: false});

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        <?php if (!empty($sql_produk)) { ?>
            // Data Item Cart
            $('#produk').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url('medcheck/json_item.php?status=0') ?>",
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
                    window.location.href = "<?php echo base_url('medcheck/invoice/bayar.php?id=' . $this->input->get('id')) ?>&item_id=" + ui.item.id + "&status=1";

                    // Give focus to the next input field to recieve input from user
                    $('#jml').focus();
                    return false;
                }

                // Format the list menu output of the autocomplete
            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<a>" + item.name + "</a>")
                        .appendTo(ul);
            };
        <?php } ?>

        $("#ongkir").keyup(function () {
            var jml_total = $('#jml_total').val().replace(/[.]/g, "");
            // var diskon = $('#jml_diskon').val().replace(/[.]/g, "");
            var ongkir = $('#ongkir').val().replace(/[.]/g, "");
            var dp = $('#jml_total_dp').val().replace(/[.]/g, "");
            var jml_gtotal = (parseFloat(jml_total) + parseFloat(ongkir)) - parseFloat(dp);

            $('#jml_gtotal').val(Math.round(jml_gtotal)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
        });
    
        $("#potongan_poin").keyup(function () {
            var jml_total       = $('#jml_total').val().replace(/[.]/g, "");
//            var ongkir          = $('#ongkir').val().replace(/[.]/g, "");
            var jml_tot_poin    = $('#total_poin_nom').val().replace(/[.]/g, "");
            var jml_pot_poin    = $('#potongan_poin').val().replace(/[.]/g, "");
            var dp              = $('#jml_total_dp').val().replace(/[.]/g, "");
            var jml_poin        = parseFloat(jml_tot_poin) - parseFloat(jml_pot_poin);
            var jml_gtotal      = parseFloat(jml_total) - parseFloat(dp) - parseFloat(jml_pot_poin);

            if(jml_poin < 0){
                $('#potongan_poin').val('0');
                alert('Jumlah poin tidak mencukupi !!');
            }
            $('#jml_gtotal').val(Math.round(jml_gtotal)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
        });

        $("#jml_bayar").keyup(function () {
            var jml_gtotal = $('#jml_gtotal').val().replace(/[.]/g, "");
            var jml_bayar = $('#jml_bayar').val().replace(/[.]/g, "");
            var jml_kurang = $('#jml_kurang').val().replace(/[.]/g, "");
            var jml_kembali = parseFloat(Math.round(jml_bayar)) - (parseFloat(jml_gtotal) - parseFloat(jml_kurang));
            var susuke;
            if (jml_kembali < 0) {
                susuke = '0';
            } else {
                susuke = jml_kembali;
            }

            $('#jml_kembali').val(Math.round(susuke)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
        });

<?php if (!empty($hasError['bayar'])) { ?>
            /* Error Jml Bayar */
            toastr.error('<b>Jumlah Bayar</b> belum diinput !!')
<?php } ?>
<?php if (!empty($hasError['metode'])) { ?>
            /* Error Metode Pembayaran */
            toastr.error('<b>Metode Pembayaran</b> belum diinput !!')
<?php } ?>
    });
</script>