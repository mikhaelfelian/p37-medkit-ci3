<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Transaksi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Transaksi</li>
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
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo $this->db->where('status_nota', '0')->get('tbl_trans_beli_po')->num_rows(); ?></h3>
                            <p>PO Baru</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="<?php echo base_url('transaksi/beli/trans_beli_po_list.php') ?>" class="small-box-footer">Selanjutnya <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo $this->db->where('status_penerimaan', '0')->get('tbl_trans_beli')->num_rows(); ?></h3>
                            <p>Faktur Baru</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="<?php echo base_url('transaksi/beli/index.php') ?>" class="small-box-footer">Selanjutnya <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <?php
                        $date = date('Y-m-d');
                        $date = strtotime($date);
                        $date = strtotime("+7 day", $date);
                        $tgl_fkt = date('Y-m-d', $date);
                    ?>
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?php echo $this->db->where('DATE(tgl_keluar)', $tgl_fkt)->get('tbl_trans_beli')->num_rows(); ?></h3>
                            <p>Faktur Jatuh Tempo</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?php echo base_url('transaksi/beli/index.php?filter_tgl_tempo='.$tgl_fkt) ?>" class="small-box-footer">Selanjutnya <i class="fas fa-arrow-circle-right"></i></a>
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