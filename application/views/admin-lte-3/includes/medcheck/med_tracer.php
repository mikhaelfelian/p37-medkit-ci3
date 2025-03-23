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
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="timeline">
                                <div class="time-label">
                                    <span class="bg-red"><?php echo $this->tanggalan->tgl_indo3(date('Y-m-d')) ?></span>
                                </div>
                                <div>
                                    <i class="fas fa-user-plus bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"></span>
                                        <h3 class="timeline-header"><a href="#">PENDAFTARAN</a></h3>
                                        <div class="timeline-body">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-left">Pasien</th>
                                                        <th class="text-left">Jam Masuk</th>
                                                        <th class="text-left">Jam Selesai</th>
                                                        <th class="text-left">Waktu</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no_dft = 1; ?>
                                                    <?php foreach ($sql_dft->result() as $dft) { ?>
                                                        <tr>
                                                            <td style="width: 20px;" class="text-center"><?php echo $no_dft; ?></td>
                                                            <td style="width: 450px;" class="text-left"><?php echo $dft->nama_pgl; ?></td>
                                                            <td style="width: 150px;" class="text-left"><?php echo $this->tanggalan->tgl_indo5($dft->tgl_masuk); ?></td>
                                                            <td style="width: 150px;" class="text-left"><?php echo ($dft->tgl_modif != '0000-00-00 00:00:00' ? $this->tanggalan->tgl_indo5($dft->tgl_modif) : ''); ?></td>
                                                            <td style="width: 150px;" class="text-left"><?php echo $this->tanggalan->usia_wkt($dft->tgl_masuk, $dft->tgl_modif); ?></td>
                                                        </tr>
                                                    <?php $no_dft++; ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <i class="fas fa-stethoscope bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"></span>
                                        <h3 class="timeline-header"><a href="#">PEMERIKSAAN DOKTER</a></h3>
                                        <div class="timeline-body">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-left">Pasien</th>
                                                        <th class="text-left">Jam Masuk</th>
                                                        <th class="text-left">Jam Selesai</th>
                                                        <th class="text-left">Waktu</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no_prks = 1; ?>
                                                    <?php foreach ($sql_medc_prks->result() as $medc_prks) { ?>
                                                        <tr>
                                                            <td style="width: 20px;" class="text-center"><?php echo $no_prks; ?></td>
                                                            <td style="width: 450px;" class="text-left"><?php echo $medc_prks->pasien; ?></td>
                                                            <td style="width: 150px;" class="text-left"><?php echo $this->tanggalan->tgl_indo5($medc_prks->tgl_masuk); ?></td>
                                                            <td style="width: 150px;" class="text-left"><?php echo $this->tanggalan->tgl_indo5($medc_prks->tgl_modif); ?></td>
                                                            <td style="width: 150px;" class="text-left"><?php echo $this->tanggalan->usia_wkt($medc_prks->tgl_masuk, $medc_prks->tgl_modif); ?></td>
                                                        </tr>
                                                        <?php $no_prks++; ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <i class="fas fa-microscope bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"></span>
                                        <h3 class="timeline-header"><a href="#">INSTALASI LABORAT</a></h3>
                                        <div class="timeline-body">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-left">Pasien</th>
                                                        <th class="text-left">Jam Masuk</th>
                                                        <th class="text-left">Jam Selesai</th>
                                                        <th class="text-left">Waktu</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no_lab = 1; ?>
                                                    <?php foreach ($sql_medc_lab->result() as $medc_lab) { ?>
                                                        <tr>
                                                            <td style="width: 20px;" class="text-center"><?php echo $no_lab; ?></td>
                                                            <td style="width: 450px;" class="text-left"><?php echo $medc_lab->pasien; ?></td>
                                                            <td style="width: 150px;" class="text-left"><?php echo $this->tanggalan->tgl_indo5($medc_lab->tgl_masuk); ?></td>
                                                            <td style="width: 150px;" class="text-left"><?php echo $this->tanggalan->tgl_indo5($medc_lab->tgl_modif); ?></td>
                                                            <td style="width: 150px;" class="text-left"><?php echo $this->tanggalan->usia_wkt($medc_lab->tgl_masuk, $medc_lab->tgl_modif); ?></td>
                                                        </tr>
                                                        <?php $no_lab++; ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <i class="fas fa-circle-radiation bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"></span>
                                        <h3 class="timeline-header"><a href="#">INSTALASI RADIOLOGI</a></h3>
                                        <div class="timeline-body">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-left">Pasien</th>
                                                        <th class="text-left">Jam Masuk</th>
                                                        <th class="text-left">Jam Selesai</th>
                                                        <th class="text-left">Waktu</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no_rad = 1; ?>
                                                    <?php foreach ($sql_medc_rad->result() as $medc_rad) { ?>
                                                        <tr>
                                                            <td style="width: 20px;" class="text-center"><?php echo $no_rad; ?></td>
                                                            <td style="width: 450px;" class="text-left"><?php echo $medc_rad->pasien; ?></td>
                                                            <td style="width: 150px;" class="text-left"><?php echo $this->tanggalan->tgl_indo5($medc_rad->tgl_masuk); ?></td>
                                                            <td style="width: 150px;" class="text-left"><?php echo $this->tanggalan->tgl_indo5($medc_rad->tgl_modif); ?></td>
                                                            <td style="width: 150px;" class="text-left"><?php echo $this->tanggalan->usia_wkt($medc_rad->tgl_masuk, $medc_rad->tgl_modif); ?></td>
                                                        </tr>
                                                        <?php $no_rad++; ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <i class="fas fa-kit-medical bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"></span>
                                        <h3 class="timeline-header"><a href="#">INSTALASI FARMASI</a></h3>
                                        <div class="timeline-body">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-left">Pasien</th>
                                                        <th class="text-left">Jam Masuk</th>
                                                        <th class="text-left">Jam Selesai</th>
                                                        <th class="text-left">Waktu</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no_res = 1; ?>
                                                    <?php foreach ($sql_medc_res->result() as $medc_res) { ?>
                                                        <tr>
                                                            <td style="width: 20px;" class="text-center"><?php echo $no_res; ?></td>
                                                            <td style="width: 450px;" class="text-left"><?php echo $medc_res->pasien; ?></td>
                                                            <td style="width: 150px;" class="text-left"><?php echo $this->tanggalan->tgl_indo5($medc_res->tgl_masuk); ?></td>
                                                            <td style="width: 150px;" class="text-left"><?php echo $this->tanggalan->tgl_indo5($medc_res->tgl_modif); ?></td>
                                                            <td style="width: 150px;" class="text-left"><?php echo $this->tanggalan->usia_wkt($medc_res->tgl_masuk, $medc_res->tgl_modif); ?></td>
                                                        </tr>
                                                        <?php $no_res++; ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <i class="fas fa-shopping-cart bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"></span>
                                        <h3 class="timeline-header"><a href="#">KASIR</a></h3>
                                        <div class="timeline-body">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-left">Pasien</th>
                                                        <th class="text-left">Jam Masuk</th>
                                                        <th class="text-left">Jam Selesai</th>
                                                        <th class="text-left">Waktu</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no_ksr = 1; ?>
                                                    <?php foreach ($sql_medc_ksr->result() as $medc_ksr) { ?>
                                                        <tr>
                                                            <td style="width: 20px;" class="text-center"><?php echo $no_ksr; ?></td>
                                                            <td style="width: 450px;" class="text-left"><?php echo $medc_ksr->pasien; ?></td>
                                                            <td style="width: 150px;" class="text-left"><?php echo $this->tanggalan->tgl_indo5($medc_ksr->tgl_masuk); ?></td>
                                                            <td style="width: 150px;" class="text-left"><?php echo $this->tanggalan->tgl_indo5($medc_ksr->tgl_modif); ?></td>
                                                            <td style="width: 150px;" class="text-left"><?php echo $this->tanggalan->usia_wkt($medc_ksr->tgl_masuk, $medc_ksr->tgl_modif); ?></td>
                                                        </tr>
                                                        <?php $no_ksr++; ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <i class="fas fa-check-circle bg-success"></i>
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
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $("#harga").autoNumeric({aSep: '.', aDec: ',', aPad: false});

        // Data Item Cart
        $('#kode').autocomplete({
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
                window.location.href = "<?php echo base_url('medcheck/tambah.php?id=' . $this->input->get('id') . '&status=' . $this->input->get('status')) ?>&id_produk=" + ui.item.id + "&harga=" + ui.item.harga;

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

<?php if (!empty($sql_produk)) { ?>
            // Cari Data Dokter
            $('#dokter').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url('medcheck/json_dokter.php') ?>",
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
                    $itemrow.find('#id_dokter').val(ui.item.id);
                    $('#id_dokter').val(ui.item.id);
                    $('#dokter').val(ui.item.nama);
                    //                window.location.href = "<?php echo base_url('medcheck/tambah.php?id=' . $this->input->get('id') . '&status=' . $this->input->get('status')) ?>";

                    // Give focus to the next input field to recieve input from user
                    $('#dokter').focus();
                    return false;
                }

                // Format the list menu output of the autocomplete
            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<a>" + item.nama + "</a>")
                        .appendTo(ul);
            };
<?php } ?>
    });
</script>