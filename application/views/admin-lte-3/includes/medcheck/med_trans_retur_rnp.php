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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('medcheck/index.php') ?>">Medical
                                Checkup</a></li>
                        <li class="breadcrumb-item active">Retur Ranap</li>
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
                    <?php if (!empty($sql_produk)) { ?>
                        <?php echo form_open(base_url('medcheck/cart_medcheck_ret_rnp.php'), 'id="retur_form" autocomplete="off"') ?>
                        <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                        <?php echo form_hidden('id_item', $this->input->get('item_id')); ?>
                        <?php echo form_hidden('id_produk', $this->input->get('id_produk')); ?>
                        <?php echo form_hidden('no_urut', $this->input->get('no_urut')); ?>
                        <?php echo form_hidden('status', $this->input->get('status')); ?>
                        <?php echo form_hidden('status_itm', $this->input->get('status')); ?>
                        <?php echo form_hidden('route', $this->input->get('route')); ?>
                        <?php echo add_form_protection(); ?>

                        <!-- INPUT RETUR MEDICINE -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">RETUR RAWAT INAP - <?php echo $sql_pasien->nama_pgl; ?>
                                    <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small>
                                </h3>
                            </div>
                            <div class="card-body">
                                <?php if ($sql_medc->status >= 5 or $sql_medc->status_bayar != '0') { ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h6><i class="icon fas fa-ban"></i> Peringatan !!</h6>
                                        Retur hanya bisa di lakukan sebelum posting, guna menghindari selisih stok.
                                    </div>
                                <?php } ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php $hasError = $this->session->flashdata('form_error'); ?>
                                        <div class="form-group row">
                                            <label for="inputEmail3"
                                                class="col-sm-3 col-form-label"><?php echo (!empty($sql_produk) ? 'Kode' : 'Item') ?></label>
                                            <div class="col-sm-9">
                                                <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Item ...', 'value' => $sql_produk->kode)) ?>
                                            </div>
                                        </div>
                                        <?php if (!empty($sql_produk)) { ?>
                                            <?php echo form_hidden('harga', (float) $sql_produk->harga_jual) ?>
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="col-sm-3 col-form-label">Item</label>
                                                <div class="col-sm-9">
                                                    <?php echo form_input(array('id' => 'item', 'name' => 'item', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Kode Item ...', 'value' => $sql_produk->produk, 'readonly' => 'true')) ?>
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
                                <div class="row">
                                    <div class="col-lg-6">
                                        <button type="button" class="btn btn-primary btn-flat"
                                            onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)) ?>'"><i
                                                class="fas fa-arrow-left"></i> Kembali</button>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <?php if (!empty($sql_produk)) { ?>
                                            <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i>
                                                Simpan</button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                        <?php echo add_double_submit_protection('retur_form') ?>
                        <?php echo form_close() ?>
                    <?php } ?>

                    <?php if ($sql_medc->status < 5) { ?>
                        <!-- DATA ENTRY ITEM RETUR -->
                        <div class="card rounded-0">
                            <div class="card-header">
                                <h3 class="card-title">DATA ITEM RETUR RAWAT INAP</h3>
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
                                                            <small><i><?php echo $this->tanggalan->tgl_indo5($medc->tgl_simpan); ?></i></small><br />
                                                            <?php echo $medc->item; ?>
                                                        </td>
                                                        <td class="text-center"><?php echo (float) $medc->jml; ?></td>
                                                        <td class="text-center">
                                                            <?php if (akses::hakSA() == TRUE or akses::hakOwner() == TRUE or akses::hakOwner2() == TRUE or akses::hakAdminM() == TRUE or akses::hakAdmin() == TRUE or akses::hakPerawat() == TRUE or akses::hakFarmasi() == TRUE) { ?>
                                                                <?php echo anchor(base_url('medcheck/cart_medcheck_ret_rnp_hps.php?id=' . general::enkrip($sql_medc->id) . '&item_id=' . general::enkrip($medc->id)), '<i class="fas fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $medc->item . '] ?\')" style="width: 65px;"') ?>
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
                        <div class="card rounded-0">
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
                                                <?php $no = 1;
                                                $gtotal = 0; ?>
                                                <?php foreach ($sql_medc_det as $det) { ?>
                                                    <?php
                                                    $sql_det = $this->db
                                                        ->select("tbl_trans_medcheck_det.id, tbl_trans_medcheck_det.id_medcheck, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.tgl_simpan, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.resep, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.subtotal")
                                                        ->where('tbl_trans_medcheck_det.id_medcheck', $det->id_medcheck)
                                                        ->where('tbl_trans_medcheck_det.id_item_kat', $det->id_item_kat)
                                                        ->get('tbl_trans_medcheck_det')->result();
                                                    ?>

                                                    <tr>
                                                        <td class="text-left text-bold" colspan="7">
                                                            <i><?php echo $det->keterangan . ' (' . $det->kategori . ')'; ?></i>
                                                        </td>
                                                    </tr>
                                                    <?php $sub = 0; ?>
                                                    <?php foreach ($sql_det as $medc) { ?>
                                                        <?php $sub = $sub + $medc->subtotal ?>

                                                        <tr>
                                                            <td class="text-center" style="width: 15px;"><?php echo $no; ?>.</td>
                                                            <td class="text-left" style="width: 150px;">
                                                                <?php echo $this->tanggalan->tgl_indo5($medc->tgl_simpan); ?></td>
                                                            <td class="text-left" style="width: 350px;">
                                                                <?php echo $medc->item; ?>
                                                                <?php if (!empty($medc->resep)) { ?>
                                                                    <!--Iki kanggo item racikan su-->
                                                                    <?php echo br(); ?>
                                                                    <?php foreach (json_decode($medc->resep) as $racikan) { ?>
                                                                        <small><i><?php echo $racikan->item ?></i></small><br />
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if (!empty($medc->id_dokter)) { ?>
                                                                    <!--Iki nggo nampilke nama dokter ndes-->
                                                                    <?php echo br(); ?>
                                                                    <small><?php echo (!empty($sql_doc->nama_dpn) ? $sql_doc->nama_dpn . ' ' : '') . $sql_doc->nama . (!empty($sql_doc->nama_blk) ? ', ' . $sql_doc->nama_blk : '') ?></small>
                                                                <?php } ?>
                                                            </td>
                                                            <td class="text-center" style="width: 65px;">
                                                                <?php echo (float) $medc->jml; ?></td>
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
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-primary btn-flat"
                                            onclick="window.location.href = '<?php echo base_url('medcheck/tindakan.php?id='.general::enkrip($sql_medc->id)) ?>'"><i
                                                class="fas fa-arrow-left"></i> Kembali</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    <?php } ?>
                </div>
                <div class="col-lg-4">
                    <?php $data['gtotal'] = $gtotal ?>
                    <?php $this->load->view('admin-lte-3/includes/medcheck/med_tindakan_kanan', $data) ?>
                    <?php $this->load->view('admin-lte-3/includes/medcheck/med_tindakan_kanan_print', $data) ?>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->