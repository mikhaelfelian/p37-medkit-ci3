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
                            <a href="<?php echo base_url('gudang/data_mutasi.php?filter_status=2'); ?>"
                                class="small-box-footer">
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
                            <a href="<?php echo base_url('gudang/data_mutasi.php?filter_status=3'); ?>"
                                class="small-box-footer">
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
                                <table id="minimum-stock-table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Simpan</th>
                                            <th>Kode</th>
                                            <th>Item</th>
                                            <th>Stok</th>
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
                                                <td><?php if (akses::hakperawat() != true && akses::hakfarmasi() != true): ?><a
                                                            href="<?php echo base_url('gudang/data_stok_tambah.php?id=' . general::enkrip($item->id)); ?>" target="_blank"><?php echo $item->produk; ?></a><?php else: ?><?php echo $item->produk; ?><?php endif; ?>
                                                </td>
                                                <td><?php echo $item->jml; ?></td>
                                                <td>
                                                    <?php echo general::status_stok_badge($item->jml); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <!-- DataTables CSS -->
                                <link rel="stylesheet"
                                    href="<?php echo base_url('assets/theme/admin-lte-3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
                                <link rel="stylesheet"
                                    href="<?php echo base_url('assets/theme/admin-lte-3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
                                <link rel="stylesheet"
                                    href="<?php echo base_url('assets/theme/admin-lte-3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">

                                <!-- DataTables JS -->
                                <script
                                    src="<?php echo base_url('assets/theme/admin-lte-3/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
                                <script
                                    src="<?php echo base_url('assets/theme/admin-lte-3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
                                <script
                                    src="<?php echo base_url('assets/theme/admin-lte-3/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
                                <script
                                    src="<?php echo base_url('assets/theme/admin-lte-3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
                                <script
                                    src="<?php echo base_url('assets/theme/admin-lte-3/plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
                                <script
                                    src="<?php echo base_url('assets/theme/admin-lte-3/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>

                                <script>
                                    $(document).ready(function () {
                                        if ($.fn.DataTable.isDataTable('#minimum-stock-table')) {
                                            $('#minimum-stock-table').DataTable().destroy();
                                        }

                                        $('#minimum-stock-table').DataTable({
                                            "responsive": true,
                                            "lengthChange": true,
                                            "autoWidth": false,
                                            "paging": true,
                                            "pageLength": 10,
                                            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
                                            "pagingType": "full_numbers",
                                            "ordering": true,
                                            "searching": true,
                                            "info": true,
                                            "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                                                "<'row'<'col-sm-12'tr>>" +
                                                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                                            "language": {
                                                "search": "Cari:",
                                                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                                                "zeroRecords": "Tidak ada data yang ditemukan",
                                                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                                                "infoEmpty": "Tidak ada data yang tersedia",
                                                "infoFiltered": "(difilter dari _MAX_ total data)",
                                                "paginate": {
                                                    "first": "&laquo;",
                                                    "last": "&raquo;",
                                                    "next": "&rsaquo;",
                                                    "previous": "&lsaquo;"
                                                }
                                            },
                                            "drawCallback": function (settings) {
                                                // Ensure pagination is properly displayed
                                                if ($('.dataTables_paginate .paginate_button').length > 2) {
                                                    $('.dataTables_paginate').show();
                                                } else {
                                                    $('.dataTables_paginate').hide();
                                                }
                                            }
                                        });
                                    });
                                </script>
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