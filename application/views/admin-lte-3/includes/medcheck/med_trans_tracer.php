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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="timeline">
                                <div class="time-label">
                                    <span class="bg-red"><?php echo $this->tanggalan->tgl_indo3($sql_medc->tgl_simpan) ?></span>
                                </div>
                                <div>
                                    <i class="fas fa-user-plus bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($sql_dft->tgl_simpan) ?></span>
                                        <h3 class="timeline-header"><a href="#">Pendaftaran</a></h3>
                                    </div>
                                </div>
                                <?php if ($sql_medc->status_periksa == '1') { ?>
                                    <div>
                                        <i class="fas fa-stethoscope bg-blue"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($sql_medc->tgl_periksa) ?></span>
                                            <h3 class="timeline-header"><a href="#">Pemeriksaan Dokter</a> oleh <i><?php echo (!empty($sql_dokter->nama_dpn) ? $sql_dokter->nama_dpn . ' ' : '') . $sql_dokter->nama . (!empty($sql_dokter->nama_blk) ? ', ' . $sql_dokter->nama_blk . ' ' : ''); ?></i></h3>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($sql_medc_lab->num_rows() > 0) { ?>
                                    <div>
                                        <i class="fas fa-microscope bg-blue"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($sql_medc_lab->row()->tgl_keluar) ?></span>
                                            <h3 class="timeline-header"><a href="#">Instalasi Laborat</a></h3>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($sql_medc_rad->num_rows() > 0) { ?>
                                    <div>
                                        <i class="fas fa-circle-radiation bg-blue"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($sql_medc_rad->row()->tgl_keluar) ?></span>
                                            <h3 class="timeline-header"><a href="#">Instalasi Radiologi</a></h3>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($sql_medc_res->num_rows() > 0) { ?>
                                    <div>
                                        <i class="fas fa-kit-medical bg-blue"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($sql_medc_res->row()->tgl_keluar) ?></span>
                                            <h3 class="timeline-header"><a href="#">Instalasi Farmasi</a> pengambilan obat</h3>
                                        </div>
                                    </div>
                                <?php } ?>                                
                                <?php if ($sql_medc->status_bayar == '1') { ?>
                                    <div>
                                        <i class="fas fa-shopping-cart bg-blue"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($sql_medc->tgl_bayar) ?></span>
                                            <h3 class="timeline-header"><a href="#">Pembayaran Kasir</a></h3>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="fas fa-stopwatch bg-blue"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($sql_medc->tgl_bayar) ?></span>
                                            <h3 class="timeline-header"><a href="#">Total Waktu Pelayanan</a> <small>(<?php echo ($sql_medc->tipe != '3' ? $this->tanggalan->usia_wkt($sql_medc->tgl_masuk, $sql_medc->tgl_bayar) : $this->tanggalan->usia_hari($sql_medc->tgl_masuk, $sql_medc->tgl_bayar)) ?>)</small></h3>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="fas fa-check-circle bg-success"></i>
                                    </div>
                                <?php }else{ ?>
                                    <div>
                                        <i class="fas fa-question-circle bg-gray"></i>
                                    </div>
                                <?php } ?>
                            </div>
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
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function () {
<?php if (!empty($sql_medc_rm_rw)) { ?>
            // Autocomplete INA-CBG
            $('#icd').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url('medcheck/json_icd.php?status=2') ?>",
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
                    $itemrow.find('#id_icd').val(ui.item.id);
                    $('#id_icd').val(ui.item.id);
                    $('#icd').val(ui.item.diagnosa_en);

                    // Give focus to the next input field to recieve input from user
                    $('#icd').focus();
                    return false;
                }

                // Format the list menu output of the autocomplete
            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<a>[" + item.kode + "] " + item.diagnosa_en + "</a>")
                        .appendTo(ul);
            };
<?php } ?>

<?php echo $this->session->flashdata('medcheck_toast'); ?>
    });
</script>