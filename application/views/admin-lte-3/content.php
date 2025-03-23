<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
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
                <div class="col-lg-12">
                    <div class="card card-default rounded-0">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-bed"></i> Informasi Ketersediaan Tempat Tidur</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-left">Kelas</th>
                                        <th class="text-center">Kapasitas</th>
                                        <th class="text-center">Terpakai</th>
                                        <th class="text-center">Sisa</th>
                                    </tr>                                    
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($sql_kamar as $kamar) { ?>
                                        <tr>
                                            <td class="text-center" style="width:30px;"><?php echo $no; ?></td>
                                            <td class="text-left" style="width:250px;">
                                                <?php echo anchor(base_url('medcheck/kamar.php?id='.general::enkrip($kamar->id).'&route=dashboard2.php'), $kamar->kamar); ?><br/>
                                            </td>
                                            <td class="text-center" style="width:100px;"><?php echo $kamar->jml_max; ?></td>
                                            <td class="text-center" style="width:100px;"><?php echo $kamar->jml; ?></td>
                                            <td class="text-center" style="width:100px;"><?php echo $kamar->sisa; ?></td>
                                        </tr>
                                        <?php $no++ ?>
                                    <?php } ?>
                                </tbody>
                            </table>                            
                        </div>
                    </div>
                    <!-- /.card -->                    
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-default rounded-0">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-bed"></i> Informasi Kunjungan Pasien</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span>Grafik Kunjungan</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                </p>
                            </div>
                            <!-- /.d-flex -->

                            <div class="position-relative mb-4">
                                <canvas id="visitors-chart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->                    
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12"> 
                    <div class="card card-default rounded-0">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-stethoscope"></i> Jadwal Praktek Dokter</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <!--<th class="text-left">Dokter</th>-->
                                        <th class="text-center">Senin</th>
                                        <th class="text-center">Selasa</th>
                                        <th class="text-center">Rabu</th>
                                        <th class="text-center">Kamis</th>
                                        <th class="text-center">Jumat</th>
                                        <th class="text-center">Sabtu</th>
                                        <th class="text-center">Minggu</th>
                                    </tr>                                    
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($sql_kary_jdwl as $jadwal) { ?>
                                        <?php
                                        $sql_poli = $this->db->where('id', $jadwal->id_poli)->get('tbl_m_poli')->row();
                                        ?>
                                        <tr>
                                            <td class="text-center" style="width:30px;"><?php echo $no; ?>.</td>
                                            <td class="text-left" colspan="7">
                                                <?php echo (!empty($jadwal->nama_dpn) ? $jadwal->nama_dpn . ' ' : '') . $jadwal->nama . (!empty($jadwal->nama_blk) ? ', ' . $jadwal->nama_blk : ''); ?> / 
                                                <small><?php echo $jadwal->lokasi; ?></small><br/>                                            
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center" style="width:30px;"><?php // echo $no; ?></td>
<!--                                            <td class="text-left" style="width:200px;">
                                                <?php echo (!empty($jadwal->nama_dpn) ? $jadwal->nama_dpn . ' ' : '') . $jadwal->nama . (!empty($jadwal->nama_blk) ? ', ' . $jadwal->nama_blk : ''); ?><br/>
                                                <small><?php echo $jadwal->lokasi; ?></small><br/>                                            
                                            </td>-->
                                            <td class="text-center" style="width:150px;"><?php echo $jadwal->hari_1; ?></td>
                                            <td class="text-center" style="width:150px;"><?php echo $jadwal->hari_2; ?></td>
                                            <td class="text-center" style="width:150px;"><?php echo $jadwal->hari_3; ?></td>
                                            <td class="text-center" style="width:150px;"><?php echo $jadwal->hari_4; ?></td>
                                            <td class="text-center" style="width:150px;"><?php echo $jadwal->hari_5; ?></td>
                                            <td class="text-center" style="width:150px;"><?php echo $jadwal->hari_6; ?></td>
                                            <td class="text-center" style="width:150px;"><?php echo $jadwal->hari_7; ?></td>
                                        </tr>
                                        <?php $no++ ?>
                                    <?php } ?>
                                </tbody>
                            </table>                            
                        </div>
                    </div>
                    <!-- /.card -->
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
<script type="text/javascript">
    $(function () {
//        'use strict'
//
//        var ticksStyle = {
//            fontColor: '#495057',
//            fontStyle: 'bold'
//        }
//
//        var mode = 'index'
//        var intersect = true
//
//        var $visitorsChart = $('#visitors-chart')
//        // eslint-disable-next-line no-unused-vars
//        var visitorsChart = new Chart($visitorsChart, {
//            data: {
//                labels: [
//                        <?php // foreach ($sql_visit as $det){ ?>
//                                            <?php // $sql_kunj = $this->db->where('id_poli', $poli->id)->group_by('DATE(tgl_simpan)')->limit(15)->get('v_medcheck_visit')->result(); ?>
//                        '<?php // echo $det->tgl_simpan ?>',
//                        <?php // } ?>
//                        ],
//                datasets: [
//                    <?php // foreach ($sql_mpoli as $poli){ ?>
//                    <?php 
//                        $sql_kunj = $this->db->select('id, DATE(tgl_masuk) AS tgl_simpan, id_poli, poli, COUNT(tgl_simpan) AS jml_kunj ')
//                                                   ->where('status_bayar', '1')
////                                                   ->where('DATE(tgl_masuk)', $poli->id_poli)
//                                                   ->where('id_poli', $poli->id)
//                                                   ->group_by('DATE(tgl_masuk),id_poli')
//                                                   ->order_by('DATE(tgl_masuk)', 'desc')
//                                                   ->limit(15)
//                                                   ->get('v_medcheck_visit')->result();
                    ?>//
//                    {
//                        type: 'line',
//                        label: '<?php // echo $poli->lokasi ?>',
//                        data: [
//                            <?php // foreach ($sql_kunj as $kunj){ ?>
//                            '<?php // echo $kunj->jml_kunj ?>',
//                            <?php // } ?>
//                        ],
//                        backgroundColor: 'transparent',
//                        borderColor: '<?php // echo $poli->warna; ?>',
//                        pointBorderColor: '<?php // echo $poli->warna; ?>',
//                        pointBackgroundColor: '<?php // echo $poli->warna; ?>',
//                        fill: false
//                                // pointHoverBackgroundColor: '#007bff',
//                                // pointHoverBorderColor    : '#007bff'
//                    },
//                    <?php // } ?>
//                ]
//            },
//            options: {
//                maintainAspectRatio: false,
//                tooltips: {
//                    mode: mode,
//                    intersect: intersect
//                },
//                hover: {
//                    mode: mode,
//                    intersect: intersect
//                },
//                legend: {
//                    display: true
//                },
//                scales: {
//                    yAxes: [{
//                            // display: false,
//                            gridLines: {
//                                display: true,
//                                lineWidth: '4px',
//                                color: 'rgba(0, 0, 0, .2)',
//                                zeroLineColor: 'transparent'
//                            },
//                            ticks: $.extend({
//                                beginAtZero: true,
//                                suggestedMax: 180
//                            }, ticksStyle)
//                        }],
//                    xAxes: [{
//                            display: true,
//                            gridLines: {
//                                display: false
//                            },
//                            ticks: ticksStyle
//                        }]
//                }
//            }
//        });
    });
</script>