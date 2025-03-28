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