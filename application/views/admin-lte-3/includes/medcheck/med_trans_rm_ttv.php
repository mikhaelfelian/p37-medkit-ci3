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
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Pemeriksaan Harian <?php echo $this->input->get('pasien') ?></h3>
                                <!--<a href="javascript:void(0);">View Report</a>-->
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            $uri = $this->input->get('route');
                            $case = $this->input->get('case');
                            $tg = $this->input->get('tgl');
                            $tg_awal = $this->input->get('tgl_awal');
                            $tg_akhir = $this->input->get('tgl_akhir');
                            $idp = $this->input->get('id_pasien');
                            $jml = $this->input->get('jml');

                            switch ($case) {
                                case 'per_tanggal':
                                    $uri_det = base_url($uri . '?case=' . $case . '&tgl=' . $tg . (!empty($idp) ? '&id_pasien=' . $idp : '') . '&jml=' . $jml);
                                    $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . '&tgl=' . $tg . '&bln=' . $bl . '&poli=' . $poli . '&tipe=' . $tipe);
                                    $uri_xls2 = base_url('laporan/xls_' . $uri . '2.php?');

                                    $btn_ctk = '<button class="btn btn-success btn-flat" onclick="window.location.href = \'' . $uri_xls . '\'"><i class="fas fa-file-excel"></i> WA Birthday</button>';
                                    break;

                                case 'per_rentang':
                                    $uri_det = base_url($uri . '?case=' . $case . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhir . (!empty($idp) ? '&id_pasien=' . $idp : '') . '&jml=' . $jml);
                                    $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhir . '&bln=' . $bl . '&poli=' . $poli . '&tipe=' . $tipe);
                                    $uri_xls2 = base_url('laporan/xls_' . $uri . '2.php?');
                                    $btn_ctk = '<button class="btn btn-success btn-flat" onclick="window.location.href = \'' . $uri_xls . '\'"><i class="fas fa-file-excel"></i> Data Pasien</button>';
                                    break;
                            }
                            ?>
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <!--<span class="text-bold text-lg">820</span>-->
                                    <span>Grafik TTV</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
<!--                                    <span class="text-success">
                                        <i class="fas fa-arrow-up"></i> 12.5%
                                    </span>
                                    <span class="text-muted">Since last week</span>-->
                                </p>
                            </div>
                            <!-- /.d-flex -->

                            <div class="position-relative mb-4">
                                <canvas id="visitors-chart" height="300"></canvas>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('/medcheck/tindakan.php?id='.$this->input->get('id')) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <!-- /.card -->
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

<!-- OPTIONAL SCRIPTS -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/chart.js/Chart.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        'use strict'
        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        }

        var mode = 'index'
        var intersect = true

        var $visitorsChart = $('#visitors-chart')
        // eslint-disable-next-line no-unused-vars
        var visitorsChart = new Chart($visitorsChart, {
            data: {
//                labels: ['Suhu', 'TB', 'Sistole', 'Diastole', 'Pernafasan', 'Nadi', 'Nyeri'],
                labels: [
                        <?php foreach ($sql_ttv as $rs){ ?>
                        '<?php echo $this->tanggalan->tgl_indo5($rs->tgl_simpan) ?>',
                        <?php } ?>
                        ],
                datasets: [{
                        type: 'line',
                        label: 'Sistole',
                        data: [
                        <?php foreach ($sql_ttv as $rs){ ?>
                        '<?php echo (float)$rs->ttv_sistole ?>',
                        <?php } ?>
                        ],
                        backgroundColor: 'transparent',
                        borderColor: '#007bff',
                        pointBorderColor: '#007bff',
                        pointBackgroundColor: '#007bff',
                        fill: false
                                // pointHoverBackgroundColor: '#007bff',
                                // pointHoverBorderColor    : '#007bff'
                    },
                    {
                        type: 'line',
                        label: 'Diastole',
                        data: [
                        <?php foreach ($sql_ttv as $rs){ ?>
                        '<?php echo (float)$rs->ttv_diastole ?>',
                        <?php } ?>
                        ],
                        backgroundColor: 'tansparent',
                        borderColor: '#ced4da',
                        pointBorderColor: '#ced4da',
                        pointBackgroundColor: '#ced4da',
                        fill: false
                                // pointHoverBackgroundColor: '#ced4da',
                                // pointHoverBorderColor    : '#ced4da'
                    },
                    {
                        type: 'line',
                        label: 'Nadi',
                        data: [
                        <?php foreach ($sql_ttv as $rs){ ?>
                        '<?php echo (float)$rs->ttv_nadi ?>',
                        <?php } ?>
                        ],
                        backgroundColor: 'tansparent',
                        borderColor: '#28ad0a',
                        pointBorderColor: '#28ad0a',
                        pointBackgroundColor: '#28ad0a',
                        fill: false
                                // pointHoverBackgroundColor: '#ced4da',
                                // pointHoverBorderColor    : '#ced4da'
                    },
                    {
                        type: 'line',
                        label: 'Suhu',
                        data: [
                        <?php foreach ($sql_ttv as $rs){ ?>
                        '<?php echo (float)$rs->ttv_st ?>',
                        <?php } ?>
                        ],
                        backgroundColor: 'tansparent',
                        borderColor: '#ebb223',
                        pointBorderColor: '#ebb223',
                        pointBackgroundColor: '#ebb223',
                        fill: false
                                // pointHoverBackgroundColor: '#ced4da',
                                // pointHoverBorderColor    : '#ced4da'
                    },
                    {
                        type: 'line',
                        label: 'Pernafasan',
                        data: [
                        <?php foreach ($sql_ttv as $rs){ ?>
                        '<?php echo (float)$rs->ttv_saturasi ?>',
                        <?php } ?>
                        ],
                        backgroundColor: 'tansparent',
                        borderColor: '#c498e3',
                        pointBorderColor: '#c498e3',
                        pointBackgroundColor: '#c498e3',
                        fill: false
                                // pointHoverBackgroundColor: '#ced4da',
                                // pointHoverBorderColor    : '#ced4da'
                    },
                    {
                        type: 'line',
                        label: 'Nyeri',
                        data: [
                        <?php foreach ($sql_ttv as $rs){ ?>
                        '<?php echo (float)$rs->ttv_skala ?>',
                        <?php } ?>
                        ],
                        backgroundColor: 'tansparent',
                        borderColor: '#fac0cb',
                        pointBorderColor: '#fac0cb',
                        pointBackgroundColor: '#fac0cb',
                        fill: false
                                // pointHoverBackgroundColor: '#ced4da',
                                // pointHoverBorderColor    : '#ced4da'
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    mode: mode,
                    intersect: intersect
                },
                hover: {
                    mode: mode,
                    intersect: intersect
                },
                legend: {
                    display: true
                },
                scales: {
                    yAxes: [{
                            // display: false,
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: $.extend({
                                beginAtZero: true,
                                suggestedMax: 180
                            }, ticksStyle)
                        }],
                    xAxes: [{
                            display: true,
                            gridLines: {
                                display: false
                            },
                            ticks: ticksStyle
                        }]
                }
            }
        });
    });
</script>