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
                        <li class="breadcrumb-item active">Medical Check</li>
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
                            <h3 class="card-title">Data Penjualan Apotik</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php echo $this->session->flashdata('medcheck'); ?>
                            <table class="table table-striped project">
                                <thead>
                                    <?php echo form_open(base_url('pos/set_trans_jual_cari.php'), 'autocomplete="off"') ?> 
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>
                                    <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control', 'placeholder' => 'Isikan Tgl ...', 'value' => (!empty($_GET['filter_nama']) ? $_GET['filter_tgl'] : ''))) ?>
                                        </td>
                                        <td>
                                            <?php echo form_input(array('id' => '', 'name' => 'pasien', 'class' => 'form-control', 'placeholder' => 'Isikan Nama Pasien ...', 'value' => (!empty($_GET['filter_nama']) ? $_GET['filter_nama'] : ''))) ?>
                                        </td>
                                        <td>
                                            <select name="status_bayar" class="form-control">
                                                <option value="">[Status Bayar]</option>
                                                <option value="0" <?php // echo ($_GET['filter_bayar'] == '0' ? 'selected' : '')     ?>>Belum</option>
                                                <option value="1" <?php // echo ($_GET['filter_bayar'] == '1' ? 'selected' : '')     ?>>Lunas</option>
                                                <option value="2" <?php // echo ($_GET['filter_bayar'] == '2' ? 'selected' : '')     ?>>Kurang</option>
                                            </select>
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-primary btn-flat">
                                                <i class="fa fa-search-plus"></i> Filter
                                            </button>
                                        </td>
                                    </tr>
                                    <?php echo form_close() ?> 
                                    <tr>
                                        <th></th>
                                        <th>No.</th>
                                        <th>ID</th>
                                        <th>Pelanggan</th>
                                        <th colspan="3"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($penj)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($penj as $penj) {
                                            $petugas = $this->db->where('id', $penj->id_sales)->get('tbl_m_sales')->row();
                                            $pasien = $this->db->where('id', $penj->id_pasien)->get('tbl_m_pasien')->row();
                                            $poli = $this->db->where('id', $penj->id_poli)->get('tbl_m_poli')->row();
                                            $app = $this->db->where('id', $penj->id_app)->get('tbl_pengaturan_cabang')->row();
                                            $farm_cek = $this->db->where('id_medcheck', $penj->id)->get('tbl_trans_medcheck_resep')->num_rows();
                                            $farm_baru = $this->db->where('id_medcheck', $penj->id)->where('status', '1')->get('tbl_trans_medcheck_resep');
                                            $farm_pros = $this->db->where('id_medcheck', $penj->id)->where('status', '2')->get('tbl_trans_medcheck_resep');
                                            $farm_sls = $this->db->where('id_medcheck', $penj->id)->where('status', '4')->get('tbl_trans_medcheck_resep');
                                            ?>
                                            <tr>
                                                <td class="text-center" style="width: 5px">
                                                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                                                        <?php // echo anchor(base_url('medcheck/hapus.php?id=' . general::enkrip($penj->id)), '<i class="fas fa-trash"></i>', 'class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus [' . $penj->no_rm . '] ?\')"') ?>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center" style="width: 10px">
                                                    <?php echo $no++ ?>.
                                                </td>
                                                <td class="text-left" style="width: 170px;">
                                                    <?php echo anchor(base_url('pos/trans_jual_inv.php?id=' . general::enkrip($penj->id)), '#' . $penj->no_nota, 'class="text-default"') ?>
                                                    <?php echo br(); ?>
                                                    <span class="mailbox-read-time float-left"><?php echo $this->tanggalan->tgl_indo5($penj->tgl_simpan); ?></span>
                                                </td>
                                                <td style="width: 450px;">
                                                    <b><?php echo $pasien->nama_pgl; ?></b>
                                                    <?php if ($penj->jml_gtotal > 0) { ?>
                                                        <?php echo br(); ?>
                                                        <small><i><b>Rp. <?php echo General::format_angka($penj->jml_gtotal); ?></b></i></small>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center" style="width: 150px;" colspan="2">
<!--                                                    <a class="btn btn-primary btn-sm" href="<?php echo base_url('medcheck/tindakan.php?id=' . general::enkrip($penj->id)) ?>">
                                                        <i class="fas fa-folder"></i>
                                                        <?php echo nbs(); ?>
                                                        Aksi
                                                        &raquo;
                                                    </a>-->
                                                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdmin() == TRUE OR akses::hakKasir() == TRUE OR akses::hakPerawat() == TRUE OR akses::hakDokter() == TRUE) { ?>
                                                        <?php echo br(); ?>
                                                        <?php echo general::status_bayar($penj->status_bayar); ?>
                                                    <?php } elseif (akses::hakFarmasi() == TRUE) { ?>
                                                        <?php if ($farm_baru->num_rows() > 0) { ?>
                                                            <label class="badge badge-warning"><b><?php echo $farm_baru->num_rows() ?></b> Resep Baru</label>
                                                        <?php } elseif ($farm_pros->num_rows() > 0) { ?>
                                                            <label class="badge badge-info"><b><?php echo $farm_pros->num_rows() ?></b> Resep Diterima</label>
                                                        <?php } elseif ($farm_sls->num_rows() > 0) { ?>
                                                            <label class="badge badge-success"><b><?php echo $farm_sls->num_rows() ?></b> Resep Selesai</label>
                                                                <?php } ?>
                                                                <?php echo br(); ?>
                                                            <?php } ?>
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
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!--Tanggal Rentang-->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<!--<script src="<?php // echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js')        ?>"></script>-->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.css'); ?>">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<script type="text/javascript">
    $(function () {
        $("#tgl").datepicker({
            format: 'mm/dd/yyyy',
            //defaultDate: "+1w",
            SetDate: new Date(),
            changeMonth: true,
            changeYear: true,
            yearRange: '2022:<?php echo date('Y') ?>',
            autoclose: true
        });
    });
</script>