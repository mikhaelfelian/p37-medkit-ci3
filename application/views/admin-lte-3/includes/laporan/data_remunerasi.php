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
                        <li class="breadcrumb-item active">Data Remunerasi</li>
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
                    <?php echo form_open(base_url('laporan/set_data_remunerasi.php'), 'autocomplete="off"') ?> 
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Laporan Remunerasi</h3>
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
                                            <select id="dokter" name="tipe" class="form-control select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                                <option value="">- [Pilih] -</option>
                                                <option value="3">Laborat</option>
                                                <option value="5">Radiologi</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nama Dokter</label>
                                        <div class="input-group mb-3">
                                            <select id="dokter" name="dokter" class="form-control select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                                <option value="">- Semua Dokter -</option>
                                                <?php foreach ($sql_doc as $doctor) { ?>
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
                                            <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => '02/15/2022 ...')) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tanggal Rentang</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <?php echo form_input(array('id' => 'tgl_rentang', 'name' => 'tgl_rentang', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => '02/15/2022 - 02/15/2022 ...')) ?>
                                        </div>
                                    </div>
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
            <?php if (!empty($sql_remun)) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Data Laporan Remunerasi</h3>
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
                                    $jml        = $this->input->get('jml');
                                    $tipe       = $this->input->get('tipe');
                                    $doc        = $this->input->get('id_dokter');

                                    switch ($case) {
                                        case 'per_tanggal':
                                            $uri_pdf = base_url('laporan/'.$uri.'_pdf.php?case='.$case.'&tgl='.$query.(!empty($sales) ? "&id_sales=" . $sales . "" : ""));
                                            $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case.(!empty($tipe) ? '&tipe='.$tipe : '') . '&tgl=' . $query . (!empty($doc) ? "&id_dokter=" . $doc . "" : "") . (!empty($jml) ? "&jml=" . $jml . "" : ""));
                                            break;
    
                                        case 'per_rentang':
                                            $uri_pdf = base_url('laporan/' . $uri . '_pdf.php?case=' . $case . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr . (!empty($sales) ? "&id_sales=" . $sales : "") . '&metode=' . $metode . (!empty($jml) ? "&jml=" . $jml . "" : ""));
                                            $uri_xls = base_url('laporan/xls_'.$uri.'.php?case='.$case.(!empty($tipe) ? '&tipe='.$tipe : '').'&tgl_awal='.$tg_awal.'&tgl_akhir='.$tg_akhr.(!empty($doc) ? "&id_dokter=" . $doc . "" : ""). (!empty($jml) ? "&jml=" . $jml . "" : ""));
                                            break;
                                    }
                                ?>
                                <button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo $uri_xls ?>'"><i class="fas fa-file-excel"></i> Cetak Excel</button>
                                
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>ID</th>
                                            <th>Dokter</th>
                                            <th>Tindakan</th>
                                            <th class="text-center">Jml</th>
                                            <th class="text-right">Harga</th>
                                            <th class="text-right">Remunerasi</th>
                                            <th class="text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($sql_remun)) {
                                            $tot_remun = 0;
                                            $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                            foreach ($sql_remun as $remun) {
//                                                $sql_doc     = $this->db->where('id_user', $remun->id_dokter)->get('tbl_m_karyawan')->row();
                                                $remun_nom   = ($remun->remun_tipe == '2' ? $remun->remun_nom : (($remun->remun_perc / 100) * $remun->harga));
                                                $tot_remun   = $tot_remun + $remun->remun_subtotal;
                                                ?>
                                                <tr>
                                                    <td class="text-center" style="width: 10px">
                                                        <?php echo $no++ ?>.
                                                    </td>
                                                    <td class="text-left" style="width: 150px;">
                                                        <?php echo anchor(base_url('medcheck/detail.php?id=' . general::enkrip($remun->id)), '#' . $remun->no_rm, 'class="text-default" target="_blank"') ?>
                                                        <?php echo br(); ?>
                                                        <span class="mailbox-read-time float-left"><?php echo $this->tanggalan->tgl_indo5($remun->tgl_simpan); ?></span>
                                                    </td>
                                                    <td class="text-left" style="width: 150px;">
                                                        <?php echo $remun->dokter.(!empty($remun->dokter_blk) ? ', '.$remun->dokter_blk : '') ?>
                                                    </td>
                                                    <td class="text-left" style="width: 450px;">
                                                        <b><?php echo $remun->item; ?></b>
                                                        <?php echo br(); ?>
                                                        <small><?php echo $remun->nama_pgl; ?> / <i><?php echo $remun->poli; ?> (<b><?php echo general::status_rawat2($remun->tipe); ?></b></i>)</small>
                                                    </td>
                                                    <td class="text-center" style="width: 50px;">
                                                        <?php echo general::format_angka($remun->jml); ?>
                                                    </td>
                                                    <td class="text-right" style="width: 100px;">
                                                        <?php echo general::format_angka($remun->harga); ?>
                                                    </td>
                                                    <td class="text-right" style="width: 100px;">
                                                        <?php echo general::format_angka($remun_nom); ?>
                                                    </td>
                                                    <td class="text-right" style="width: 100px;">
                                                        <?php echo general::format_angka($remun->remun_subtotal); ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td class="text-right text-bold" colspan="7">Total</td>
                                                <td class="text-right text-bold"><?php echo general::format_angka($tot_remun) ?></td>
                                            </tr>
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

        $('#tgl_rentang').daterangepicker({
            locale: {
                format: 'MM/DD/YYYY'
            }
        })
    });
</script>