<?php $pengaturan = $this->db->get('tbl_pengaturan')->row(); ?>
<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php echo $pengaturan->judul ?>
                <small><?php echo $pengaturan->kota ?></small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <?php
            /*
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php echo $trans_jml ?></h3>

                            <p>Nota Penjualan</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="<?php echo base_url('transaksi/data_penj_list.php') ?>" class="small-box-footer">Selebihnya <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?php echo general::format_angka($prod_jml) ?></h3>

                            <p>Produk Stok < <?php echo $pengaturan->jml_limit_stok ?></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?php echo base_url('gudang/data_stok_list.php?filter_stok='.$pengaturan->jml_limit_stok.'&jml='.$prod_jml) ?>" class="small-box-footer">Selebihnya <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?php echo general::format_angka($trans_jual_tmp->num_rows()) ?></h3>

                            <p>Penjualan Tempo < <?php echo $pengaturan->jml_limit_tempo.' Hari' ?></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?php echo base_url('transaksi/data_penj_list_tempo.php?route=tempo&jml='.$trans_jual_tmp->num_rows()) ?>" class="small-box-footer">Selebihnya <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?php echo general::format_angka($trans_beli_tmp->num_rows()) ?></h3>

                            <p>Pembelian Tempo < <?php echo $pengaturan->jml_limit_tempo.' Hari' ?></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?php echo base_url('transaksi/data_pembelian_list_tempo.php?route=tempo&jml='.$trans_beli_tmp->num_rows()) ?>" class="small-box-footer">Selebihnya <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            */
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Rekap Penjualan Bulanan</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <p class="text-center">
                                        <strong>Penjualan & Pembelian: <?php echo $this->tanggalan->tgl_indo3(date('Y') . '-01-01') ?> - <?php echo $this->tanggalan->tgl_indo3(date('Y-m-d')) ?></strong>
                                    </p>

                                    <div class="chart">
                                        <!-- Sales Chart Canvas -->
                                        <canvas id="salesChart" style="height: 180px;"></canvas>
                                    </div>
                                    <!-- /.chart-responsive -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4">
                                    <p class="text-center">
                                        <strong>Penjualan</strong>
                                    </p>
                                    <!-- /.progress-group -->
                                    <div class="progress-group">
                                        <span class="progress-text">Jml Item Terjual</span>
                                        <span class="progress-number"><b><?php echo $trans_jual_prd->jml ?></b></span>

                                        <div class="progress sm">
                                            <div class="progress-bar progress-bar-green" style="width: 80%"></div>
                                        </div>
                                    </div>
                                    <!-- /.progress-group -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./box-body -->
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-3 col-xs-6">
                                    <div class="description-block border-right">
                                        <!--<span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>-->
                                        <h5 class="description-header"><?php echo general::format_angka($pem_jml->nominal) ?></h5>
                                        <span class="description-text">TOTAL OMSET</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-xs-6">
                                    <div class="description-block border-right">
                                        <!--<span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>-->
                                        <h5 class="description-header"><?php echo general::format_angka($pem_jml_thn->nominal) ?></h5>
                                        <span class="description-text">TOTAL OMSET TAHUN <?php echo date('Y') ?></span>
                                    </div>
                                     <!--/.description-block--> 
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <div class="description-block border-right">
                                        <!--<span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>-->
                                        <h5 class="description-header"><?php echo general::format_angka($pemb_jml->nominal) ?></h5>
                                        <span class="description-text">TOTAL PEMBELIAN TAHUN <?php echo date('Y') ?></span>
                                    </div>
                                     <!--/.description-block--> 
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <?php
            /*
            <div class="row">
                <div class="col-md-8">
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Transaksi Penjualan Terakhir</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                        <tr>
                                            <th>No. INV</th>
                                            <th>Tgl Transaksi</th>
                                            <th>Pelanggan</th>
                                            <th>Kasir</th>
                                            <th class="text-right">Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($trans_new as $trans){ ?>
                                        <?php $sql_kasir = $this->db->where('id', $trans->id_sales)->get('tbl_m_sales')->row() ?>
                                        <?php $sql_cust  = $this->db->where('id', $trans->id_pelanggan)->get('tbl_m_pelanggan')->row() ?>
                                        <tr>
                                            <td><a href="<?php echo base_url('transaksi/trans_jual_det.php?id='.general::enkrip($trans->id).'&route=dashboard.php') ?>"><?php echo $trans->kode_nota_dpn.$trans->no_nota.'/'.$trans->kode_nota_blk ?></a></td>
                                            <td><?php echo $this->tanggalan->tgl_indo($trans->tgl_simpan) ?></td>
                                            <td><?php echo $sql_cust->nama ?></td>
                                            <td><?php echo $sql_kasir->nama ?></td>
                                            <td class="text-right"><?php echo general::format_angka($trans->jml_gtotal) ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <a href="<?php echo base_url('transaksi/set_nota_jual_umum.php') ?>" class="btn btn-sm btn-info btn-flat pull-left">Transaksi Baru (UMUM)</a>
                            <a href="<?php echo base_url('transaksi/data_penj_list.php') ?>" class="btn btn-sm btn-default btn-flat pull-right">Semua Transaksi</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                </div>
                <div class="col-md-4">
                    <!-- PRODUCT LIST -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Produk Terbaru</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <?php if(!empty($prod_new)){ ?>
                        <div class="box-body">
                            <ul class="products-list product-list-in-box">
                                <?php foreach($prod_new as $prod){ ?>
                                <?php $sql_sat = $this->db->where('id', $prod->id_satuan)->get('tbl_m_satuan')->row() ?>
                                <li class="item">
                                    <div class="product-img">
                                        <img src="<?php echo base_url('assets/theme/admin-lte-2/dist/img/default-50x50.gif') ?>" alt="Product Image">
                                    </div>
                                    <div class="product-info">
                                        <a href="<?php echo base_url('master/data_barang_det.php?id='.general::enkrip($prod->id).'&route=dashboard.php') ?>" class="product-title"><?php echo $prod->kode ?>
                                            <span class="label label-warning pull-right"><?php echo general::format_angka($prod->jml).' '.strtoupper($sql_sat->satuanTerkecil) ?></span></a>
                                        <span class="product-description">
                                            <?php echo $prod->produk ?>
                                        </span>
                                    </div>
                                </li>
                                <!-- /.item -->
                                <?php } ?>
                            </ul>
                        </div>
                        <?php } ?>
                        <!-- /.box-body -->
                        <div class="box-footer text-center">
                            <a href="<?php echo base_url('master/data_barang_list.php') ?>" class="uppercase">Semua Produk</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            */
            ?>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.container -->
</div>
<style>
    .clicked {
        background-color: #ffff00;
    }
</style>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.min.css') ?>">

<!--Datepicker-->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- ChartJS -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/chartjs/Chart.js') ?>"></script>
<!-- Page script -->
<script>
    $(function () {

        'use strict';

        // -----------------------------
        // - Grafis Penjualan Perbulan -
        // -----------------------------

        // Get context with jQuery - using jQuery's .get() method.
        var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
        // This will get the first returned node in the jQuery collection.
//        var salesChart = new Chart(salesChartCanvas);
        
        var numberNames = [
            <?php for ($b = 1; $b <= date('m'); $b++) { ?>
            { number: <?php echo $b ?>, name: '<?php echo $this->tanggalan->bulan_ke($b) ?>' },
            <?php } ?>
        ];
        
        var salesChartData = {
//            labels: [<?php for ($b = 1; $b <= date('m'); $b++) { ?>'<?php echo $this->tanggalan->bulan_ke($b) ?>',<?php } ?>],
              labels: numberNames.map(function(e) { return e.name }),
                    datasets: [
                        {
                          label               : 'Pembelian',
                          fillColor           : 'rgb(210, 214, 222)',
                          strokeColor         : 'rgb(210, 214, 222)',
                          pointColor          : 'rgb(210, 214, 222)',
                          pointStrokeColor    : '#c1c7d1',
                          pointHighlightFill  : '#fff',
                          pointHighlightStroke: 'rgb(220,220,220)',
                          data: [<?php for ($b = 1; $b <= date('m'); $b++) { $sql_jml = $this->db->select('SUM(jml_gtotal) as jml')->like('tbl_trans_beli.id_user', $user_id)->where('MONTH(tbl_trans_beli.tgl_masuk)', $b)->get('tbl_trans_beli')->row(); echo (!empty($sql_jml->jml) ? $sql_jml->jml : 0) . ','; } ?>]
                        },
                        {
                            label: 'Penjualan',
                            fillColor: 'rgba(60,141,188,0.9)',
                            strokeColor: 'rgba(60,141,188,0.8)',
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: [<?php for ($b = 1; $b <= date('m'); $b++) { $sql_jual_jml = $this->db->select('SUM(jml_gtotal) as jml')->like('tbl_trans_jual.id_user', $user_id)->where('MONTH(tbl_trans_jual.tgl_masuk)', $b)->get('tbl_trans_jual')->row(); echo (!empty($sql_jual_jml->jml) ? $sql_jual_jml->jml : 0) . ','; } ?>]
                        }
                    ]
        };

        var salesChartOptions = new Chart(salesChartCanvas).Line(salesChartData, {
            // Boolean - If we should show the scale at all
            showScale: true,
            // Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: false,
            // String - Colour of the grid lines
            scaleGridLineColor: 'rgba(0,0,0,.05)',
            // Number - Width of the grid lines
            scaleGridLineWidth: 1,
            // Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            // Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            // Boolean - Whether the line is curved between points
            bezierCurve: true,
            // Number - Tension of the bezier curve between points
            bezierCurveTension: 0.3,
            // Boolean - Whether to show a dot for each point
            pointDot: false,
            // Number - Radius of each point dot in pixels
            pointDotRadius: 4,
            // Number - Pixel width of point dot stroke
            pointDotStrokeWidth: 1,
            // Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius: 20,
            // Boolean - Whether to show a stroke for datasets
            datasetStroke: true,
            // Number - Pixel width of dataset stroke
            datasetStrokeWidth: 2,
            // Boolean - Whether to fill the dataset with a color
            datasetFill: true,
            // String - A legend template
            legendTemplate: '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<datasets.length; i++){%><li><span style=\'background-color:<%=datasets[i].lineColor%>\'></span><%=datasets[i].label%></li><%}%></ul>',
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            // Boolean - whether to make the chart responsive to window resizing
            responsive: true,
            scaleLabel:
                    function (label) {
                        return  label.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    },
            multiTooltipTemplate: function (valueObject) {
//                return valueObject.label + ' : Rp. ' + valueObject.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                return 'Rp. ' + valueObject.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
//                  return numberNames.filter(function (e) { return e.number === valueObject.label })[0].name + ': Rp. ' + valueObject.value
            }
        });

        // Create the line chart
        // salesChart.Line(salesChartOptions);

        // ---------------------------
        // - END MONTHLY SALES CHART -
        // ---------------------------
    });

</script>