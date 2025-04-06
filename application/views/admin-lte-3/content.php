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
                                    <span class="text-bold text-lg" id="total-visits">0</span>
                                    <span>Grafik Kunjungan Pasien</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                        <i class="fas fa-user-injured"></i> <span id="percentage-change">0%</span>
                                    </span>
                                    <span class="text-muted">Dibandingkan tahun lalu</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->

                            <div class="position-relative mb-4" style="min-height: 300px;">
                                <canvas id="visitors-chart" height="300"></canvas>
                            </div>

                            <script>
                            $(function() {
                                'use strict'
                                
                                var ticksStyle = {
                                    fontColor: '#495057',
                                    fontStyle: 'bold'
                                }

                                var mode = 'index';
                                var intersect = true;
                                
                                // Fetch patient visit data from the server
                                $.ajax({
                                    url: '<?php echo base_url('home/get_patient_visits'); ?>',
                                    method: 'GET',
                                    dataType: 'json',
                                    success: function(response) {
                                        // Update the total visits and percentage change
                                        $('#total-visits').text(response.total_visits);
                                        
                                        var percentageChange = response.percentage_change;
                                        $('#percentage-change').text(percentageChange + '%');
                                        
                                        // Set the appropriate color based on percentage change
                                        if (percentageChange >= 0) {
                                            $('#percentage-change').parent().removeClass('text-danger').addClass('text-success');
                                            $('#percentage-change').parent().find('i').removeClass('fa-arrow-down').addClass('fa-arrow-up');
                                        } else {
                                            $('#percentage-change').parent().removeClass('text-success').addClass('text-danger');
                                            $('#percentage-change').parent().find('i').removeClass('fa-arrow-up').addClass('fa-arrow-down');
                                        }
                                        
                                        // Initialize the chart with the data from the server
                                        var $visitorsChart = $('#visitors-chart');
                                        var visitorsChart = new Chart($visitorsChart, {
                                            type: 'bar',
                                            data: {
                                                labels: response.labels,
                                                datasets: [{
                                                    data: response.visit_data,
                                                    backgroundColor: '#007bff',
                                                    borderColor: '#007bff',
                                                    pointRadius: 3,
                                                    pointBackgroundColor: '#007bff',
                                                    pointBorderColor: '#007bff',
                                                    pointHoverBackgroundColor: '#007bff',
                                                    pointHoverBorderColor: '#007bff',
                                                    fill: false,
                                                    label: 'Kunjungan'
                                                }]
                                            },
                                            options: {
                                                responsive: true,
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
                                                    display: false
                                                },
                                                scales: {
                                                    yAxes: [{
                                                        display: true,
                                                        gridLines: {
                                                            display: true,
                                                            lineWidth: '4px',
                                                            color: 'rgba(0, 0, 0, .2)',
                                                            zeroLineColor: 'transparent'
                                                        },
                                                        ticks: $.extend({
                                                            beginAtZero: true,
                                                            callback: function(value) {
                                                                if (value >= 1000) {
                                                                    value /= 1000
                                                                    value += 'k'
                                                                }
                                                                return value
                                                            }
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
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Error fetching patient visit data:', error);
                                    }
                                });
                            });
                            </script>
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