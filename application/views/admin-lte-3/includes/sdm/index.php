<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">SDM</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">SDM</li>
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
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3><?php echo $this->db->where('status', '0')->where('id_kategori', '1')->get('tbl_sdm_cuti')->num_rows(); ?></h3>
                            <p>Cuti Baru</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="<?php echo base_url('sdm/data_cuti_list.php?tipe=1&filter_status=0') ?>" class="small-box-footer">Selanjutnya <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo $this->db->where('status', '0')->where('id_kategori', '2')->get('tbl_sdm_cuti')->num_rows(); ?></h3>
                            <p>Ijin Baru</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="<?php echo base_url('sdm/data_cuti_list.php?tipe=2&filter_status=0') ?>" class="small-box-footer">Selanjutnya <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?php echo $this->db->where('status', '2')->where('id_kategori', '1')->get('tbl_sdm_cuti')->num_rows(); ?></h3>
                            <p>Cuti ditolak</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?php echo base_url('sdm/data_cuti_list.php?tipe=1&filter_status=2') ?>" class="small-box-footer">Selanjutnya <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?php echo $this->db->where('status', '2')->where('id_kategori', '2')->get('tbl_sdm_cuti')->num_rows(); ?></h3>
                            <p>Ijin ditolak</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?php echo base_url('sdm/data_cuti_list.php?tipe=2&filter_status=2') ?>" class="small-box-footer">Selanjutnya <i class="fas fa-arrow-circle-right"></i></a>
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