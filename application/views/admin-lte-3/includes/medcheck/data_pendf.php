<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pendaftaran</li>
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
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Data Pendaftaran Pasien</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <?php echo $this->session->flashdata('medcheck'); ?>
                            <table class="table table-striped project">
                                <thead>
                                    <?php echo form_open_multipart(base_url('medcheck/set_cari_daftar.php'), 'autocomplete="off"') ?> 
                                    <tr>
                                        <td colspan="2">
                                            <select name="poli" class="form-control rounded-0">
                                                <option value="">[Poli]</option>
                                                <?php foreach($sql_poli as $poli){ ?>
                                                    <option value="<?php echo $poli->id ?>"><?php echo $poli->lokasi ?></option>
                                                <?php } ?>
                                            </select>                                              
                                        </td>
                                        <td>
                                            <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl_daftar', 'class' => 'form-control rounded-0', 'placeholder' => 'Tgl Pendaftaran ...')); //, 'value'=>(!empty($_GET['filter_tgl']) ? $this->tanggalan->tgl_indo2($this->input->get('filter_tgl')) : ''))) ?>
                                        </td>
                                        <td colspan="3">
                                            <?php echo form_input(array('id' => '', 'name' => 'pasien', 'class' => 'form-control rounded-0', 'placeholder' => 'Pasien ...', 'value' => (!empty($_GET['filter_nama']) ? $_GET['filter_nama'] : ''))) ?>
                                            <input type="hidden" id="id_daftar" name="id_daftar" value="<?php echo (!empty($_GET['id']) ? $_GET['id'] : '') ?>">
                                        </td>
                                        <td>
                                            <select name="tipe" class="form-control rounded-0">
                                                <option value="">[Tipe Perawatan]</option>
                                                <?php if (akses::hakDokter() != TRUE) { ?>
                                                    <option value="1" <?php echo ($_GET['filter_tipe'] == '1' ? 'selected' : '') ?>>Laborat</option>
                                                    <option value="4" <?php echo ($_GET['filter_tipe'] == '4' ? 'selected' : '') ?>>Radiologi</option>
                                                <?php } ?>
                                                <option value="2" <?php echo ($_GET['filter_tipe'] == '2' ? 'selected' : '') ?>>Rawat Jalan</option>
                                                <option value="3" <?php echo ($_GET['filter_tipe'] == '3' ? 'selected' : '') ?>>Rawat Inap</option>
                                                <option value="5" <?php echo ($_GET['filter_tipe'] == '5' ? 'selected' : '') ?>>MCU</option>
                                            </select>                                            
                                        </td>
                                        <td class="text-left">
                                            <button class="btn btn-primary btn-flat">
                                                <i class="fa fa-search-plus"></i> Filter
                                            </button>
                                        </td>
                                    </tr>
                                    <?php echo form_close() ?> 
                                    <tr>
                                        <th style="width: 10px"></th>
                                        <th style="width: 10px">No.</th>
                                        <th style="width: 50px;">Tgl</th>
                                        <th style="width: 50px;">Antrian</th>
                                        <!--<th style="width: 250px;">Poli</th>-->
                                        <th style="width: 700px;">Pasien</th>
                                        <th style="width: 150px;">L / P</th>
                                        <th style="width: 150px;">Tgl Lahir</th>
                                        <th style="width: 250px;">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($penj)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($penj as $penj) {
                                            $petugas = $this->db->where('id', $penj->id_sales)->get('tbl_m_sales')->row();
                                            $pasien = $this->db->where('id', $penj->id_pasien)->get('tbl_m_pasien')->row();
                                            $dokter = $this->db->where('id_user', $penj->id_dokter)->get('tbl_m_karyawan')->row();
                                            $poli = $this->db->where('id', $penj->id_poli)->get('tbl_m_poli')->row();
                                            $app = $this->db->where('id', $penj->id_app)->get('tbl_pengaturan_cabang')->row();
                                            $gc = $this->db->where('id_pendaftaran', $penj->id)->get('tbl_pendaftaran_gc');
                                            $plat = $this->db->where('id', $penj->tipe_bayar)->get('tbl_m_penjamin')->row();
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                                                        <?php echo anchor(base_url('medcheck/hapus_dft.php?id=' . general::enkrip($penj->id)), '<i class="fas fa-trash"></i>', 'class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus [' . $penj->nama_pgl . '] ?\')"') ?>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td style="width: 150px;">
                                                    <span class="mailbox-read-time float-left"><?php echo $this->tanggalan->tgl_indo5($penj->tgl_masuk) ?></span>
                                                    <?php echo br(); ?>
                                                    <small><i><b><?php echo general::status_rawat2($penj->tipe_rawat); ?></b></i></small>
                                                    <?php echo br(); ?>
                                                    <small><i><b><?php echo $poli->lokasi ?></b></i></small>
                                                    <?php echo br(); ?>
                                                    <small><i><b><?php echo general::status_dft($penj->status_dft) ?></b></i></small>
                                                </td> 
                                                <td style="width: 50px;"><?php echo sprintf('%03d', $penj->no_urut) ?></td>
                                                <td style="width: 700px;"> 
                                                    <b><?php echo $penj->nama_pgl ?></b>
                                                    <?php echo br() ?>
                                                    <small><i><?php echo (!empty($penj->alamat) || $penj->alamat != 0 ? $penj->alamat : (!empty($penj->alamat_dom) || $penj->alamat_dom != 0 ? $penj->alamat_dom : '-')); ?></i></small>
                                                    <?php echo br(); ?>
                                                    <small><i><?php echo $penj->kontak . (!empty($penj->kontak_rmh) ? ' / ' . $penj->kontak_rmh : ''); ?></i></small>
                                                    <?php echo br(); ?>
                                                    <small>[<b><?php echo $plat->penjamin ?></b>]</small>
                                                    <?php echo br(); ?>
                                                    <small><i><?php echo (!empty($dokter->nama_dpn) ? $dokter->nama_dpn . ' ' : '') . $dokter->nama . (!empty($dokter->nama_blk) ? ', ' . $dokter->nama_blk : '') ?></i></small>
                                                    <?php if ($penj->id_referall > 0) { ?>
                                                        <?php echo br(); ?>
                                                        <?php 
                                                            $referal = $this->ion_auth->user()->row();
                                                             if ($referal) {
                                                                echo '<small><i>Referal: ' . $referal->first_name . ' ' . $referal->last_name . '</i></small>' . br();
                                                             }
                                                        ?>
                                                    <?php } ?>
                                                </td>
                                                <td style="width: 150px;"><?php echo general::jns_klm($penj->jns_klm) ?></td>
                                                <td style="width: 150px;">
                                                    <?php echo $this->tanggalan->tgl_indo2($penj->tgl_lahir); ?>
                                                    <?php echo br(); ?>
                                                    <span class="mailbox-read-time float-left"><i>(<?php echo $this->tanggalan->usia($penj->tgl_lahir) ?>)</i></span>
                                                </td>
                                                <td style="width: 250px;">
                                                    <?php if ($penj->status_akt == '0') { ?>
                                                        <?php echo anchor(base_url('medcheck/set_pasien_konfirm.php?dft=' . general::enkrip($penj->id)), '<i class="fa fa-check"></i> Konfirm &raquo;', 'class="btn btn-' . ($gc->num_rows() == '0' ? 'danger' : 'success') . ' btn-flat btn-xs" style="width: 80px;"' . ($gc->num_rows() == '0' ? ' onclick="return confirm(\'Anda belum mengisi form GENERAL CONSENT, lanjutkan ?\')"' : '')) . br() ?>
                                                    <?php } else { 
                                                        $process_token = md5(uniqid(rand(), true));
                                                        $this->session->set_userdata('process_token_'.$penj->id, $process_token);
                                                    ?>
                                                        <form id="form_<?php echo $penj->id; ?>" method="POST" action="<?php echo base_url('medcheck/set_pasien.php'); ?>" style="display:inline;">
                                                            <?php 
                                                            // Get CSRF token from database session
                                                            $csrf = array(
                                                                'name' => $this->security->get_csrf_token_name(),
                                                                'hash' => $this->security->get_csrf_hash()
                                                            );
                                                            ?>
                                                            <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                                                            <?php echo add_form_protection(); ?>
                                                            <input type="hidden" name="dft" value="<?php echo general::enkrip($penj->id); ?>">
                                                            <input type="hidden" name="process_token" value="<?php echo $process_token; ?>">
                                                            <button type="submit" class="btn btn-warning btn-flat btn-xs submit-btn" style="width: 80px;">
                                                                <i class="fa fa-shopping-cart"></i> Input &raquo;
                                                            </button>
                                                        </form>
                                                        <script>
                                                        document.getElementById('form_<?php echo $penj->id; ?>').addEventListener('submit', function(e) {
                                                            if (this.getAttribute('data-submitted')) {
                                                                e.preventDefault();
                                                                return false;
                                                            }
                                                            this.setAttribute('data-submitted', 'true');
                                                        });
                                                        </script>
                                                        <?php echo add_double_submit_protection('form_'.$penj->id); ?>
                                                    <?php } ?>
                                                    <br/>
                                                    <?php echo anchor(base_url('medcheck/daftar.php?tipe_pas=3&dft=' . general::enkrip($penj->id)), '<i class="fa fa-edit"></i> Ubah &raquo;', 'class="btn btn-warning btn-flat btn-xs" style="width: 80px;"') . br() ?>
                                                    <?php echo anchor(base_url('medcheck/daftar_gc.php?tipe_pas=3&dft=' . general::enkrip($penj->id)), '<i class="fa fa-signature"></i> Form GC &raquo;', 'class="btn btn-info btn-flat btn-xs" style="width: 80px;"') . br() ?>
                                                    <?php echo anchor(base_url('medcheck/cetak_label_json_dft.php?dft=' . general::enkrip($penj->id)), '<i class="fa fa-print"></i> Label &raquo;', 'class="btn btn-primary btn-flat btn-xs" style="width: 80px;" target="_blank"') . br() ?>
                                                    <?php echo anchor($pengaturan->url_antrian . '/tr_queue?id_dft=' . $penj->id, '<i class="fa fa-users"></i> Antrian &raquo;', 'class="btn btn-info btn-flat btn-xs rounded-0" style="width: 80px;" target="_blank"'); ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
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
<!-- /.content-wrapper -->
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $("#tgl").datepicker({
            format: 'dd/mm/yyyy',
            changeMonth: true,
            autoclose: true
        });
    });
</script>