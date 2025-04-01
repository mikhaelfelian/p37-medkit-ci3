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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('home.php') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('medcheck/index.php') ?>">Medical Checkup</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('medcheck/tindakan.php?id=' . $this->input->get('id')) ?>">Tindakan</a></li>
                        <li class="breadcrumb-item active">Tracer</li>
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
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="card-title">Timeline Pelayanan Pasien</h3>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="time-label">
                                    <span class="bg-primary"><?php echo $this->tanggalan->tgl_indo3($sql_medc->tgl_simpan) ?></span>
                                </div>
                                <div>
                                    <i class="fas fa-user-plus bg-info"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($sql_dft->tgl_simpan) ?></span>
                                        <h3 class="timeline-header"><a href="#">Pendaftaran</a></h3>
                                    </div>
                                </div>
                                <?php if ($sql_medc->status_periksa == '1') { ?>
                                    <div>
                                        <i class="fas fa-stethoscope bg-success"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($sql_medc->tgl_periksa) ?></span>
                                            <h3 class="timeline-header"><a href="#">Pemeriksaan Dokter</a> oleh <i><?php echo (!empty($sql_dokter->nama_dpn) ? $sql_dokter->nama_dpn . ' ' : '') . $sql_dokter->nama . (!empty($sql_dokter->nama_blk) ? ', ' . $sql_dokter->nama_blk . ' ' : ''); ?></i></h3>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($sql_medc_lab->num_rows() > 0) { ?>
                                    <div>
                                        <i class="fas fa-microscope bg-warning"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($sql_medc_lab->row()->tgl_keluar) ?></span>
                                            <h3 class="timeline-header"><a href="#">Instalasi Laborat</a></h3>
                                            <div class="timeline-body">
                                                <p>Pemeriksaan laboratorium telah selesai</p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($sql_medc_rad->num_rows() > 0) { ?>
                                    <div>
                                        <i class="fas fa-radiation-alt bg-danger"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($sql_medc_rad->row()->tgl_keluar) ?></span>
                                            <h3 class="timeline-header"><a href="#">Instalasi Radiologi</a></h3>
                                            <div class="timeline-body">
                                                <p>Pemeriksaan radiologi telah selesai</p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($sql_medc_res->num_rows() > 0) { ?>
                                    <div>
                                        <i class="fas fa-pills bg-purple"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($sql_medc_res->row()->tgl_keluar) ?></span>
                                            <h3 class="timeline-header"><a href="#">Instalasi Farmasi</a></h3>
                                            <div class="timeline-body">
                                                <p>Pengambilan obat telah selesai</p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>                                
                                <?php if ($sql_medc->status_bayar == '1') { ?>
                                    <div>
                                        <i class="fas fa-cash-register bg-olive"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($sql_medc->tgl_bayar) ?></span>
                                            <h3 class="timeline-header"><a href="#">Pembayaran Kasir</a></h3>
                                            <div class="timeline-body">
                                                <p>Pembayaran telah selesai</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="fas fa-stopwatch bg-navy"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($sql_medc->tgl_bayar) ?></span>
                                            <h3 class="timeline-header"><a href="#">Total Waktu Pelayanan</a></h3>
                                            <div class="timeline-body">
                                                <p><?php echo ($sql_medc->tipe != '3' ? $this->tanggalan->usia_wkt($sql_medc->tgl_masuk, $sql_medc->tgl_bayar) : $this->tanggalan->usia_hari($sql_medc->tgl_masuk, $sql_medc->tgl_bayar)) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="fas fa-check-circle bg-success"></i>
                                        <div class="timeline-item">
                                            <h3 class="timeline-header"><a href="#">Selesai</a></h3>
                                            <div class="timeline-body">
                                                <p>Semua proses telah selesai</p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div>
                                        <i class="fas fa-hourglass-half bg-gray"></i>
                                        <div class="timeline-item">
                                            <h3 class="timeline-header"><a href="#">Dalam Proses</a></h3>
                                            <div class="timeline-body">
                                                <p>Menunggu pembayaran</p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo base_url('medcheck/tindakan.php?id=' . $this->input->get('id')) ?>" class="btn btn-secondary rounded-0">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <?php $data['gtotal'] = $gtotal ?>
                    <?php $this->load->view('admin-lte-3/includes/medcheck/med_tindakan_kanan', $data) ?>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>