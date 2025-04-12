<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Penjualan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Penjualan</li>
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
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <?php
                            $total_penjualan = $this->db->where('status_pos', '1')
                                                       ->where('status_bayar', '1')
                                                       ->where('status_hps', '0')
                                                       ->get('tbl_trans_medcheck')->num_rows();
                            ?>
                            <h3><?php echo $total_penjualan; ?></h3>
                            <p>Total Penjualan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <?php
                            $total_produk = $this->db->where('status_subt', '1')
                                                    ->get('tbl_m_produk')->num_rows();
                            ?>
                            <h3><?php echo $total_produk; ?></h3>
                            <p>Total Produk</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <?php
                            $total_pelanggan = $this->db->select('id_pasien')
                                                       ->where('status_pos', '1')
                                                       ->where('status_bayar', '1')
                                                       ->where('status_hps', '0')
                                                       ->group_by('id_pasien')
                                                       ->get('tbl_trans_medcheck')->num_rows();
                            ?>
                            <h3><?php echo $total_pelanggan; ?></h3>
                            <p>Total Pelanggan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <?php
                            $low_stock_count = $this->db->select('COUNT(*) as count')
                                                      ->from('tbl_m_produk p')
                                                      ->where('p.status_subt', '1')
                                                      ->where('p.status_hps', '0')
                                                      ->get()
                                                      ->row()->count;
                            ?>
                            <h3><?php echo $low_stock_count; ?></h3>
                            <p>Produk Tersedia</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <a href="<?php echo base_url('gudang/data_stok.php'); ?>" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Highest Monthly Sales Card -->
            <div class="row">
                <div class="col-12">
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="card-title">Penjualan Tertinggi Tahun <?php echo date('Y'); ?></h3>
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
                                            <th>Bulan</th>
                                            <th>Total Penjualan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        $current_year = date('Y');
                                        $months = array(
                                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 
                                            4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                                            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                        );
                                        
                                        $monthly_sales = array();
                                        
                                        // Get monthly sales for current year
                                        foreach ($months as $month_num => $month_name) {
                                            $sales = $this->db->select('SUM(jml_gtotal) as total')
                                                ->from('tbl_trans_medcheck')
                                                ->where('status_pos', '1')
                                                ->where('status_bayar', '1')
                                                ->where('status_hps', '0')
                                                ->where('YEAR(tgl_simpan)', $current_year)
                                                ->where('MONTH(tgl_simpan)', $month_num)
                                                ->get()
                                                ->row();
                                                
                                            $monthly_sales[$month_num] = array(
                                                'month' => $month_name,
                                                'total' => ($sales->total ? $sales->total : 0)
                                            );
                                        }
                                        
                                        // Sort by total in descending order
                                        usort($monthly_sales, function($a, $b) {
                                            return $b['total'] - $a['total'];
                                        });
                                        
                                        // Display top months
                                        foreach ($monthly_sales as $sales) {
                                            if ($sales['total'] > 0) {
                                        ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $sales['month']; ?></td>
                                                <td class="text-right">Rp <?php echo number_format($sales['total'], 0, ',', '.'); ?></td>
                                                <td>
                                                    <?php if ($no == 2): ?>
                                                        <span class="badge badge-success">Tertinggi</span>
                                                    <?php elseif ($sales['total'] > 0): ?>
                                                        <span class="badge badge-info">Normal</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-warning">Tidak Ada Penjualan</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php 
                                            }
                                        }
                                        
                                        // If no sales data found
                                        if ($no == 1) {
                                        ?>
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada data penjualan untuk tahun <?php echo $current_year; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Best Seller Products -->
            <div class="row">
                <div class="col-12">
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="card-title">25 Produk Terlaris</h3>
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
                                            <th>Kode Produk</th>
                                            <th>Nama Produk</th>
                                            <th>Jumlah Terjual</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Get best seller products
                                        $best_sellers = $this->db->query("
                                            SELECT 
                                                tmd.kode, 
                                                tmd.item, 
                                                SUM(tmd.jml) as total_sold
                                            FROM 
                                                tbl_trans_medcheck_det tmd
                                            JOIN 
                                                tbl_trans_medcheck tm ON tmd.id_medcheck = tm.id
                                            WHERE 
                                                tm.status_pos = '1' AND
                                                tm.status_bayar = '1' AND
                                                tm.status_hps = '0'
                                            GROUP BY 
                                                tmd.kode, tmd.item
                                            ORDER BY 
                                                total_sold DESC
                                            LIMIT 25
                                        ")->result();
                                        
                                        $no = 1;
                                        if (!empty($best_sellers)) {
                                            foreach ($best_sellers as $product) {
                                        ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $product->kode; ?></td>
                                                <td><?php echo $product->item; ?></td>
                                                <td class="text-right"><?php echo number_format($product->total_sold, 0, ',', '.'); ?></td>
                                            </tr>
                                        <?php 
                                            }
                                        } else {
                                        ?>
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada data produk terlaris</td>
                                            </tr>
                                        <?php } ?>
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
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        <?php echo $this->session->flashdata('pos_toast'); ?>
    });
</script>