<?php
/**
 * Gudang Index View
 * 
 * View for displaying warehouse dashboard and minimum stock information
 * 
 * @author Mikhael Felian Waskito - mikhaelfelian@gmail.com
 * @date 2025-04-12
 */
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Gudang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Gudang</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <?php if (akses::hakPerawat() != '1' && akses::hakFarmasi() != '1'): ?>
            <!-- Transaction Summary Cards -->
            <div class="row">
                <!-- Pending Transactions -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <?php
                            $pending_count = $this->db->where('status_nota', '1')
                                                     ->where('status_terima', '0')
                                                     ->get('tbl_trans_mutasi')->num_rows();
                            ?>
                            <h3><?php echo $pending_count; ?></h3>
                            <p>Permintaan Pending</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <a href="<?php echo base_url('gudang/data_mutasi_terima.php'); ?>" class="small-box-footer">
                            Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Received Transactions -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <?php
                            $received_count = $this->db->where('status_nota', '2')->where('status_terima', '1')->get('tbl_trans_mutasi')->num_rows();
                            ?>
                            <h3><?php echo $received_count; ?></h3>
                            <p>Permintaan Diterima</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                            <a href="<?php echo base_url('gudang/data_mutasi.php?filter_status=2'); ?>" class="small-box-footer">
                                Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Rejected Transactions -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <?php
                            $rejected_count = $this->db->where('status_nota', '3')->where('status_terima', '2')->get('tbl_trans_mutasi')->num_rows();
                            ?>
                            <h3><?php echo $rejected_count; ?></h3>
                            <p>Permintaan Ditolak</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <a href="<?php echo base_url('gudang/data_mutasi.php?filter_status=3'); ?>" class="small-box-footer">
                            Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Minimum Stock Alert -->
            <div class="row">
                <div class="col-12">
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="card-title">Peringatan Stok Minimum</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Simpan</th>
                                            <th>Kode Produk</th>
                                            <th>Nama Produk</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($minimum_stock as $item): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo date('d-m-Y', strtotime($item->tgl_simpan)); ?></td>
                                                <td><?php echo $item->kode; ?></td>
                                                <td><?php if(akses::hakperawat() != true && akses::hakfarmasi() != true): ?><a href="<?php echo base_url('gudang/data_stok_tambah.php?id='.general::enkrip($item->id)); ?>"><?php echo $item->produk; ?></a><?php else: ?><?php echo $item->produk; ?><?php endif; ?></td>
                                                <td><?php echo $item->jml; ?></td>
                                                <td>
                                                    <?php echo general::status_stok_badge($item->jml); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
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