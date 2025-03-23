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
                        <li class="breadcrumb-item active">Detail</li>
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
                            <h3 class="card-title text-bold"><i class="fas fa-user"></i> Biodata Pasien</h3>
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
                                    <td class="text-left"><?php echo general::jns_klm($sql_pasien->jns_klm); ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Tempat & Tgl Lahir</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $sql_pasien->tmp_lahir . ', ' . $this->tanggalan->tgl_indo2($sql_pasien->tgl_lahir); ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Usia</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir); ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Alamat</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $sql_pasien->alamat; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title text-bold"><i class="fas fa-hospital"></i> Data Medcheck</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <tr>
                                    <th class="text-left">ID Transaksi</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $sql_medc->no_rm; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">No. Nota</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo (!empty($sql_medc->no_nota) ? $sql_medc->no_nota : ''); ?></td>
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
                                    <th class="text-left">Petugas</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $this->ion_auth->user($sql_medc->id_user)->row()->first_name; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Dokter Utama</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $this->ion_auth->user($sql_medc->id_dokter)->row()->first_name; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title text-bold"><i class="fas fa-hospital-user"></i> Data Medis</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <tr>
                                    <th class="text-left" style="width: 200px;;">Keluhan</th>
                                    <th class="text-center" style="width: 15px;">:</th>
                                    <td class="text-left"><?php echo $sql_medc->keluhan; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left" style="width: 200px;;">TTV</th>
                                    <th class="text-center" style="width: 15px;">:</th>
                                    <td class="text-left">
                                        <small>
                                            <b>Suhu :</b> <?php echo (float)$sql_medc->ttv_st ?> &deg;C<br/>
                                            <b>TB :</b> <?php echo (float)$sql_medc->ttv_tb ?> Cm<br/>
                                            <b>BB :</b> <?php echo (float)$sql_medc->ttv_bb ?> Kg<br/>
                                            <b>Nadi :</b> <?php echo (float)$sql_medc->ttv_nadi ?> / Menit<br/>
                                            <b>Sistole :</b> <?php echo (float)$sql_medc->ttv_sistole ?> mmHg<br/>
                                            <b>Diastole :</b> <?php echo (float)$sql_medc->ttv_diastole ?> mmHg<br/>
                                            <b>Laju Nafas :</b> <?php echo (float)$sql_medc->ttv_laju ?> / Menit<br/>
                                            <b>Saturasi :</b> <?php echo (float)$sql_medc->ttv_saturasi ?> %<br/>
                                            <b>Skala Nyeri :</b> <?php echo (float)$sql_medc->ttv_skala ?><br/>
                                        </small>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-left" style="width: 200px;;">Anamnesa</th>
                                    <th class="text-center" style="width: 15px;">:</th>
                                    <td class="text-left"><?php echo $sql_medc->anamnesa; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left" style="width: 200px;;">Pemeriksaan</th>
                                    <th class="text-center" style="width: 15px;">:</th>
                                    <td class="text-left"><?php echo $sql_medc->pemeriksaan; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left" style="width: 200px;;">Diagnosa</th>
                                    <th class="text-center" style="width: 15px;">:</th>
                                    <td class="text-left"><?php echo $sql_medc->diagnosa; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left" style="width: 200px;;">Diagnosa ICD 10</th>
                                    <th class="text-center" style="width: 15px;">:</th>
                                    <td class="text-left">
                                        <?php foreach ($this->db->where('id_medcheck', $sql_medc->id)->get('tbl_trans_medcheck_icd')->result() AS $icd) { ?>
                                            - <?php echo ($icd->diagnosa_en) ?><br/>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-left" style="width: 200px;;">Program</th>
                                    <th class="text-center" style="width: 15px;">:</th>
                                    <td class="text-left"><?php echo $sql_medc->program; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>                   
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title text-bold"><i class="fas fa-user-nurse"></i> Data Item Tindakan & Obat</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-left">Tgl</th>
                                        <th class="text-left">Item</th>
                                        <th class="text-left">Keterangan</th>
                                        <th class="text-center">Jml</th>
                                        <th class="text-right">Harga</th>
                                        <th class="text-right">Subtotal</th>
                                    </tr>                                    
                                </thead>
                                <tbody>
                                    <?php $no = 1; $gtotal = 0; ?>
                                    <?php foreach ($sql_medc_det as $det) { ?>
                                        <?php $sql_kat = $this->db->where('id', $det->id_item_kat)->get('tbl_m_kategori')->row(); ?>
                                        <?php $sql_det = $this->db->where('id_medcheck', $det->id_medcheck)->where('id_item_kat', $det->id_item_kat)->get('tbl_trans_medcheck_det')->result(); ?>
                                        <tr>
                                            <td class="text-left text-bold" colspan="9"><i><?php echo $sql_kat->keterangan . ' (' . $sql_kat->kategori . ')'; ?></i></td>
                                        </tr>
                                        <?php foreach ($sql_det as $medc) { ?>
                                            <?php $sql_doc      = $this->db->where('id_user', $medc->id_dokter)->get('tbl_m_karyawan')->row(); ?>
                                            <?php $sql_res_det  = $this->db->where('id_medcheck', $medc->id_medcheck)->where('id_resep', $medc->id_resep)->where('id_item', $medc->id_item)->get('tbl_trans_medcheck_resep_det')->row(); ?>
                                            <?php $sub          = $sub + $medc->subtotal ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no . '.'; ?></td>
                                                <td class="text-left"><?php echo $this->tanggalan->tgl_indo5($medc->tgl_simpan); ?></td>
                                                <td class="text-left">
                                                    <?php echo $medc->item; ?>

                                                    <?php if (!empty($medc->id_dokter)) { ?>
                                                        <!--Iki nggo nampilke nama dokter ndes-->
                                                        <?php echo br(); ?>
                                                        <small><?php echo (!empty($sql_doc->nama_dpn) ? $sql_doc->nama_dpn . ' ' : '') . $sql_doc->nama . (!empty($sql_doc->nama_blk) ? ', ' . $sql_doc->nama_blk : '') ?></small>
                                                    <?php } ?>

                                                    <?php if (!empty($medc->resep)) { ?>
                                                        <!--Iki kanggo item racikan su-->
                                                        <?php echo br(); ?>
                                                        <?php foreach (json_decode($medc->resep) as $racikan) { ?>
                                                            <small><i><?php echo $racikan->item ?></i></small><br/>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-left"><?php echo $sql_res_det->keterangan; ?></td>
                                                <td class="text-center"><?php echo (float) $medc->jml; ?></td>
                                                <td class="text-right"><?php echo general::format_angka($medc->harga); ?></td>
                                                <td class="text-right"><?php echo general::format_angka($medc->subtotal); ?></td>
                                            </tr>
                                            <?php if (!empty($medc->dosis) OR !empty($medc->dosis_ket)) { ?>
                                                <tr>
                                                    <td class="text-center"></td>
                                                    <td class="text-right text-bold">Dosis :</td>
                                                    <td class="text-left" colspan="6"><?php echo $medc->dosis . (!empty($medc->dosis_ket) ? ' (' . $medc->dosis_ket . ')' : ''); ?></td>
                                                </tr>
                                            <?php } ?>
                                            <?php $no++ ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php $gtotal = $gtotal + $sub ?>
                                    <tr>
                                        <td class="text-right text-bold" colspan="6">Grand Total</td>
                                        <td class="text-right text-bold"><?php echo general::format_angka($gtotal); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <?php
                                    $rute = explode('$', $this->input->get('route'));
                                    $route = $rute[0] . '?' . $rute[1] . '=' . $rute[2] . '#' . $rute[3];
                                    $rutenya = (!empty($rute[3]) ? $route : $this->input->get('route'));
                                    ?>
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url($rutenya) ?>'">&laquo; Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <?php if (!empty($sql_medc_det)) { ?>
                                        <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/surat/cetak_pdf_rsm.php?id=' . $this->input->get('id')) ?>'"><i class="fas fa-print"></i> Cetak</button>
                                    <?php } ?>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->