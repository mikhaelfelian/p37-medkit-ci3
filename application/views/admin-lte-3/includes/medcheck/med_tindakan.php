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
                        <li class="breadcrumb-item active">Tindakan</li>
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
                                            <?php $this->load->view('admin-lte-3/includes/medcheck/med_tindakan_aksi') ?>
                                            <hr/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <?php echo $this->session->flashdata('master'); ?>
                                            <h4>Detail Item</h4>
                                            <!--<div class="post">-->
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-left">Tgl</th>
                                                        <th class="text-left">Item</th>
                                                        <th class="text-center">Jml</th>
                                                        <th class="text-right">Harga</th>
                                                        <th class="text-right">Subtotal</th>
                                                    </tr>                                    
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    $gtotal = 0;
                                                    ?>
                                                    <?php foreach ($sql_medc_det as $det) { ?>
                                                        <?php
                                                        $sql_det = $this->db
                                                                        ->select("tbl_trans_medcheck_det.id, tbl_trans_medcheck_det.id_medcheck, tbl_trans_medcheck_det.id_item, tbl_trans_medcheck_det.tgl_simpan, tbl_trans_medcheck_det.item, tbl_trans_medcheck_det.resep, tbl_trans_medcheck_det.jml, tbl_trans_medcheck_det.harga, tbl_trans_medcheck_det.subtotal, tbl_m_karyawan.nama_dpn, tbl_m_karyawan.nama, tbl_m_karyawan.nama_blk")
                                                                        ->join('tbl_m_karyawan', 'tbl_m_karyawan.id_user=tbl_trans_medcheck_det.id_dokter', 'left')
                                                                        ->where('tbl_trans_medcheck_det.status_pkt', '0')
                                                                        ->where('tbl_trans_medcheck_det.id_medcheck', $det->id_medcheck)
                                                                        ->where('tbl_trans_medcheck_det.id_item_kat', $det->id_item_kat)
                                                                        ->get('tbl_trans_medcheck_det')->result();
                                                        ?>

                                                        <tr>
                                                            <td class="text-left text-bold" colspan="7"><i><?php echo $det->keterangan . ' (' . $det->kategori . ')'; ?></i></td>
                                                        </tr>
                                                        <?php $sub = 0; ?>
                                                        <?php foreach ($sql_det as $medc) { ?>
                                                            <?php $sql_rc_det = $this->db->where('id_medcheck', $medc->id_medcheck)->where('status_rc', '1')->get('tbl_trans_medcheck_det')->result(); ?>
                                                            <?php $sql_rf     = $this->db->where('id_produk', $medc->id_item)->get('tbl_m_produk_ref'); ?>
                                                            <?php $sub = $sub + $medc->subtotal ?>              
                                                            <tr>
                                                                <td class="text-center">                                                             
                                                                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakPerawat() == TRUE) { ?>
                                                                        <?php if ($sql_medc->status < 5 AND $medc->status != '4') { ?>
                                                                            <?php // echo anchor(base_url('medcheck/cart_medcheck_hapus.php?id=' . general::enkrip($medc->id) . '&no_nota=' . general::enkrip($medc->id_medcheck) . '&status=' . $this->input->get('status').'&route=medcheck/tindakan.php?id='.general::enkrip($medc->id_medcheck)), '<i class="fa fa-trash"></i>', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $medc->item . '] ?\')"') ?>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </td>
                                                                <td class="text-left"><?php echo $this->tanggalan->tgl_indo5($medc->tgl_simpan); ?></td>
                                                                <td class="text-left">
                                                                    <?php echo $medc->item; ?>
                                                                    <?php if ($medc->nama != '-') { ?>
                                                                        <!--Iki nggo nampilke nama dokter ndes-->
                                                                        <?php echo br(); ?>
                                                                        <small><?php echo (!empty($medc->nama_dpn) ? $medc->nama_dpn . ' ' : '') . $medc->nama . (!empty($medc->nama_blk) ? ', ' . $medc->nama_blk : '') ?></small>
                                                                    <?php } ?>
                                                                </td>
                                                                <td class="text-center"><?php echo (float) $medc->jml; ?></td>
                                                                <td class="text-right"><?php echo general::format_angka($medc->harga); ?></td>
                                                                <td class="text-right"><?php echo general::format_angka($medc->subtotal); ?></td>
                                                            </tr>

                                                            <?php if ($sql_rf->num_rows() > 0) { ?>
                                                                <?php foreach ($sql_rf->result() as $reff) { ?>
                                                                    <tr>
                                                                        <td colspan="2"></td>
                                                                        <td class="text-left"><small>- <i><?php echo $reff->item ?></i></small></td>
                                                                        <td class="text-center"><small><i><?php echo (float) $reff->jml ?></i></small></td>
                                                                        <td class="text-right"><small><i></i></small></td>
                                                                        <td class="text-right"><small><i></i></small></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            <?php } ?>                                                                
                                                            <?php $no++ ?>
                                                        <?php } ?>
                                                        <tr>
                                                            <td class="text-right text-bold" colspan="5">Subtotal</td>
                                                            <td class="text-right text-bold" colspan="5"><?php echo general::format_angka($sub); ?></td>
                                                        </tr>
                                                        <?php $gtotal = $gtotal + $sub ?>
                                                    <?php } ?>
                                                    <tr>
                                                        <td class="text-right text-bold" colspan="5">Grand Total</td>
                                                        <td class="text-right text-bold" colspan="5"><?php echo general::format_angka($gtotal, 2); ?></td>
                                                    </tr>
                                                    <?php $sql_tpp = $this->db->where('id_medcheck', $sql_medc->id)->where('status_kwi', '3')->get('tbl_trans_medcheck_kwi'); ?>
                                                    <?php foreach ($sql_tpp->result() as $tpp) { ?>
                                                        <tr>
                                                            <td class="text-right text-bold" colspan="5">TPP</td>
                                                            <td class="text-right text-bold" colspan="5"><?php echo general::format_angka($tpp->nominal, 2); ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <!--</div>-->
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
                    <?php $data['sql_dokter'] = $sql_dokter ?>
                    <?php $data['sql_petugas'] = $sql_petugas ?>
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