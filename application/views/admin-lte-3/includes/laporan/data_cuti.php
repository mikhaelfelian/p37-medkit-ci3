<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!--<h1 class="m-0">Master Data</h1>-->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard2.php') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('laporan/index.php') ?>">Laporan</a></li>
                        <li class="breadcrumb-item active">Data Rekap Ijin & Cuti</li>
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
                <div class="col-md-8">
                    <?php echo form_open(base_url('laporan/set_data_cuti.php'), 'autocomplete="off"') ?> 
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Rekap Ijin & Cuti</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php $hasError = $this->session->flashdata('form_error'); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tipe</label>
                                        <div class="input-group mb-3">
                                            <select id="tipe" name="tipe" class="form-control rounded-0 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                                <option value="">- [Pilih] -</option>
                                                <?php foreach ($sql_kat_cuti as $kat){ ?>
                                                    <option value="<?php echo $kat->id ?>"><?php echo $kat->tipe ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Karyawan</label>
                                        <div class="input-group mb-3">
                                            <select id="dokter" name="karyawan" class="form-control select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                                <option value="">- Semua Karyawan -</option>
                                                <?php foreach ($sql_kry as $doctor) { ?>
                                                    <option value="<?php echo $doctor->id_user ?>" <?php echo ($doctor->id_user == general::dekrip($_GET['id_dokter']) ? 'selected' : '') ?>><?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn.' ' : '').$doctor->nama.(!empty($doctor->nama_blk) ? ', '.$doctor->nama_blk : '') ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tanggal</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control rounded-0 text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => '02/15/2022 ...')) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Bulan</label>
                                        <div class="input-group mb-3">
                                            <select id="dokter" name="bulan" class="form-control rounded-0 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                                <option value="">- Bulan -</option>
                                                <?php for ($bln = 1; $bln <= 12; $bln++) { ?>
                                                    <option value="<?php echo $bln ?>" <?php echo ($bln == $_GET['bln'] ? 'selected' : '') ?>><?php echo $this->tanggalan->bulan_ke($bln) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Status</label>
                                        <select name="status" class="form-control rounded-0">
                                            <option value="">- Pilih -</option>
                                            <option value="0">Baru</option>
                                            <option value="1">Disetujui</option>
                                            <option value="2">Ditolak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">

                                </div>
                                <div class="col-lg-6 text-right">
                                    <!--<button type="button" class="btn btn-warning btn-flat"><i class="fa fa-undo"></i> Bersih</button>-->
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-search"></i> Cari</button>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <?php echo form_close() ?> 
                </div>
            </div>
            <?php if ($_GET['jml'] > 0) { ?><div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Data Rekap Ijin & Cuti</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-right">
                                        <?php echo $pagination ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php echo $this->session->flashdata('medcheck'); ?>
                                <?php
                                    $uri        = substr($this->uri->segment(2), 0, -4);
                                    $case       = $this->input->get('case');
                                    $query      = $this->input->get('tgl');
                                    $tg_awal    = $this->input->get('tgl_awal');
                                    $tg_akhr    = $this->input->get('tgl_akhir');
                                    $tg         = $this->input->get('tgl');
                                    $bln        = $this->input->get('bln');
                                    $tipe       = $this->input->get('tipe');
                                    $status     = $this->input->get('status');
                                    $jml        = $this->input->get('jml');
                                    $karyawan   = $this->input->get('id_kary');

                                    switch ($case) {
                                        case 'per_tanggal':
                                            $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . '&tgl=' . $query .(!empty($karyawan) ? "&id_kary=" . $karyawan . "" : ""). (!empty($tipe) ? "&tipe=" . $tipe . "" : "") . (!empty($status) ? "&status=" . $status . "" : ""). (!empty($doc) ? "&id_dokter=" . $doc . "" : "") . (!empty($jml) ? "&jml=" . $jml . "" : ""));
                                            break;
    
                                        case 'per_rentang':
                                            $uri_xls = base_url('laporan/xls_'.$uri.'.php?case='.$case.'&tgl_awal='.$tg_awal.'&tgl_akhir='.$tg_akhr.(!empty($karyawan) ? "&id_kary=" . $karyawan . "" : "").(!empty($tipe) ? "&tipe=" . $tipe . "" : "") . (!empty($status) ? "&status=" . $status . "" : "").(!empty($doc) ? "&id_dokter=" . $doc . "" : ""). (!empty($jml) ? "&jml=" . $jml . "" : ""));
                                            break;
    
                                        case 'per_bulan':
                                            $uri_xls = base_url('laporan/xls_'.$uri.'.php?case='.$case.'&bln='.$bln.(!empty($karyawan) ? "&id_kary=" . $karyawan . "" : "").(!empty($tipe) ? "&tipe=" . $tipe . "" : "") . (!empty($status) ? "&status=" . $status . "" : ""). (!empty($jml) ? "&jml=" . $jml . "" : ""));
                                            break;
                                    }
                                ?>
                                <button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo $uri_xls.'&tipe='.$this->input->get('tipe').'&id_kary='.$this->input->get('id_kary') ?>'"><i class="fas fa-file-excel"></i> Cetak Excel</button>
                                
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>No. Surat</th>
                                            <th>Karyawan</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($sql_cuti)) {
                                            $tot_remun = 0;
                                            $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                            foreach ($sql_cuti as $cuti) {
//                                                $cuti     = $this->db->where('id', $cuti->id_karyawan)->get('tbl_m_karyawan')->row();
//                                                $cuti_nom   = ($cuti->remun_tipe == '2' ? $cuti->remun_nom : (($cuti->remun_perc / 100) * $cuti->harga));
//                                                $tot_remun   = $tot_remun + $cuti->remun_subtotal;
                                                ?>
                                                <tr>
                                                    <td class="text-center" style="width: 10px">
                                                        <?php echo $no++ ?>.
                                                    </td>
                                                    <td class="text-left" style="width: 200px;">
                                                        <?php echo anchor(base_url('sdm/data_cuti_det.php?id=' . general::enkrip($cuti->id).'&route=sdm/data_cuti_list.php?tipe=1'), '#' . (!empty($cuti->no_surat) ? $cuti->no_surat : '000000'), 'class="text-default" target="_blank"') ?>
                                                        <?php echo br(); ?>
                                                        <span class="mailbox-read-time float-left"><?php echo $this->tanggalan->tgl_indo($cuti->tgl_masuk); ?></span>
                                                        <br/>
                                                        <?php echo general::status_cuti($cuti->status) ?>
                                                    </td>
                                                    <td class="text-left" style="width: 250px;">
                                                        <?php echo (!empty($cuti->nama_dpn) ? $cuti->nama_dpn.' ' : '').$cuti->nama.(!empty($cuti->nama_blk) ? ', '.$cuti->nama_blk : '') ?>
                                                        <?php echo br() ?>
                                                        <i><label class="badge badge-primary"><?php echo $cuti->tipe ?></label></i>
                                                        <?php echo br() ?>
                                                        <b>Selama : </b><i><?php echo $this->tanggalan->jml_hari($cuti->tgl_masuk, $cuti->tgl_keluar) ?> Hari</i>
                                                    </td>
                                                    <td class="text-left">
                                                        <?php echo $cuti->keterangan ?>
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
            <?php } ?>
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
<!--<script src="<?php // echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js')  ?>"></script>-->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.css'); ?>">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $("#tgl").datepicker({
            format: 'mm/dd/yyyy',
            //defaultDate: "+1w",
            SetDate: new Date(),
            changeMonth: true,
            changeYear: true,
            yearRange: '2022:<?php echo date('Y') ?>',
            autoclose: true
        });

//        $('#tgl_rentang').daterangepicker({
//            locale: {
//                format: 'MM/DD/YYYY'
//            }
//        })
    });
</script>