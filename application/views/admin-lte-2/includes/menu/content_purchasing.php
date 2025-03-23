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
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php echo $trans_beli_jml ?></h3>

                            <p>Nota Pembelian</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="<?php echo base_url('transaksi/data_pembelian_list.php') ?>" class="small-box-footer">Selebihnya <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?php echo $trans_beli_tmp ?></h3>

                            <p>Tagihan jatuh tempo</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?php echo base_url('transaksi/data_pembelian_list.php?filter_tgl_tempo=' . $tgl_tempo) ?>" class="small-box-footer">Selebihnya <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Rekap Pembelian Bulanan</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <p class="text-center">
                                        <strong>Pembelian: <?php echo $this->tanggalan->tgl_indo3(date('Y') . '-01-01') ?> - <?php echo $this->tanggalan->tgl_indo3(date('Y-m-d')) ?></strong>
                                    </p>

                                    <div class="chart">
                                        <!-- Sales Chart Canvas -->
                                        <canvas id="salesChart" style="height: 180px;"></canvas>
                                    </div>
                                    <!-- /.chart-responsive -->
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
                                        <h5 class="description-header"><?php echo general::format_angka($pemb_jml->nominal) ?></h5>
                                        <span class="description-text">TOTAL PEMBELIAN</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-xs-6">
                                    <div class="description-block border-right">
                                        <!--<span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>-->
                                        <h5 class="description-header"><?php echo general::format_angka($pemb_jml_thn->nominal) ?></h5>
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
            <div class="row">
                <div class="col-md-8">
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Transaksi Pembelian Terakhir</h3>

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
                                            <th>User</th>
                                            <th>Supplier</th>
                                            <th class="text-right">Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($trans_beli_new as $trans) { ?>
                                            <?php $sql_supp = $this->db->where('id', $trans->id_supplier)->get('tbl_m_supplier')->row() ?>
                                            <tr>
                                                <td><a href="<?php echo base_url('transaksi/trans_beli_det.php?id=' . general::enkrip($trans->no_nota) . '&route=dashboard.php') ?>"><?php echo sprintf("%05d", $trans->id) ?></a></td>
                                                <td><?php echo $this->tanggalan->tgl_indo($trans->tgl_simpan) ?></td>
                                                <td><?php echo $this->ion_auth->user($trans->id_user)->row()->first_name ?></td>
                                                <td><?php echo ucwords($sql_supp->nama) ?></td>
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
                            <a href="<?php echo base_url('transaksi/trans_beli.php') ?>" class="btn btn-sm btn-info btn-flat pull-left">Transaksi Baru</a>
                            <a href="<?php echo base_url('transaksi/data_pembelian_list.php') ?>" class="btn btn-sm btn-default btn-flat pull-right">Semua Transaksi</a>
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
                        <?php if (!empty($prod_new)) { ?>
                            <div class="box-body">
                                <ul class="products-list product-list-in-box">
                                    <?php foreach ($prod_new as $prod) { ?>
                                        <li class="item">
                                            <div class="product-img">
                                                <img src="<?php echo base_url('assets/theme/admin-lte-2/dist/img/default-50x50.gif') ?>" alt="Product Image">
                                            </div>
                                            <div class="product-info">
                                                <a href="<?php echo base_url('master/data_barang_det.php?id=' . general::enkrip($prod->id) . '&route=dashboard.php') ?>" class="product-title"><?php echo $prod->kode ?>
                                                    <span class="label label-warning pull-right"><?php echo general::format_angka($prod->harga_jual) ?></span></a>
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
        var salesChart = new Chart(salesChartCanvas);

        var salesChartData = {
            labels: [<?php for ($b = 1; $b <= date('m'); $b++) { ?>'<?php echo $this->tanggalan->bulan_ke($b) ?>',<?php } ?>],
                    datasets: [
                        {
                            label: 'Total Produk Terjual',
                            fillColor: 'rgba(60,141,188,0.9)',
                            strokeColor: 'rgba(60,141,188,0.8)',
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: [<?php for ($b = 1; $b <= date('m'); $b++) { $sql_jml = $this->db->select('SUM(jml_gtotal) as jml')->like('tbl_trans_beli.id_user', $user_id)->where('MONTH(tbl_trans_beli.tgl_masuk)', $b)->get('tbl_trans_beli')->row(); echo (!empty($sql_jml->jml) ? $sql_jml->jml : 0) . ','; } ?>]
                        }
                    ]
        };

        var salesChartOptions = {
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
            tooltipTemplate: function (valueObject) {
                return valueObject.label + ' : Rp. ' + valueObject.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
        };

        // Create the line chart
        salesChart.Line(salesChartData, salesChartOptions);

        // ---------------------------
        // - END MONTHLY SALES CHART -
        // ---------------------------

        // -------------
        // - PIE CHART -
        // -------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
        var pieChart = new Chart(pieChartCanvas);
        var PieData = [
            {
                value: 700,
                color: '#f56954',
                highlight: '#f56954',
                label: 'Chrome'
            },
            {
                value: 500,
                color: '#00a65a',
                highlight: '#00a65a',
                label: 'IE'
            },
            {
                value: 400,
                color: '#f39c12',
                highlight: '#f39c12',
                label: 'FireFox'
            },
            {
                value: 600,
                color: '#00c0ef',
                highlight: '#00c0ef',
                label: 'Safari'
            },
            {
                value: 300,
                color: '#3c8dbc',
                highlight: '#3c8dbc',
                label: 'Opera'
            },
            {
                value: 100,
                color: '#d2d6de',
                highlight: '#d2d6de',
                label: 'Navigator'
            }
        ];
        var pieOptions = {
            // Boolean - Whether we should show a stroke on each segment
            segmentShowStroke: true,
            // String - The colour of each segment stroke
            segmentStrokeColor: '#fff',
            // Number - The width of each segment stroke
            segmentStrokeWidth: 1,
            // Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 50, // This is 0 for Pie charts
            // Number - Amount of animation steps
            animationSteps: 100,
            // String - Animation easing effect
            animationEasing: 'easeOutBounce',
            // Boolean - Whether we animate the rotation of the Doughnut
            animateRotate: true,
            // Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale: false,
            // Boolean - whether to make the chart responsive to window resizing
            responsive: true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: false,
            // String - A legend template
            legendTemplate: '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
            // String - A tooltip template
            tooltipTemplate: '<%=value %> <%=label%> users'
        };
        // Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions);
        // -----------------
        // - END PIE CHART -
        // -----------------

        /* jVector Maps
         * ------------
         * Create a world map with markers
         */
        $('#world-map-markers').vectorMap({
            map: 'world_mill_en',
            normalizeFunction: 'polynomial',
            hoverOpacity: 0.7,
            hoverColor: false,
            backgroundColor: 'transparent',
            regionStyle: {
                initial: {
                    fill: 'rgba(210, 214, 222, 1)',
                    'fill-opacity': 1,
                    stroke: 'none',
                    'stroke-width': 0,
                    'stroke-opacity': 1
                },
                hover: {
                    'fill-opacity': 0.7,
                    cursor: 'pointer'
                },
                selected: {
                    fill: 'yellow'
                },
                selectedHover: {}
            },
            markerStyle: {
                initial: {
                    fill: '#00a65a',
                    stroke: '#111'
                }
            },
            markers: [
                {latLng: [41.90, 12.45], name: 'Vatican City'},
                {latLng: [43.73, 7.41], name: 'Monaco'},
                {latLng: [-0.52, 166.93], name: 'Nauru'},
                {latLng: [-8.51, 179.21], name: 'Tuvalu'},
                {latLng: [43.93, 12.46], name: 'San Marino'},
                {latLng: [47.14, 9.52], name: 'Liechtenstein'},
                {latLng: [7.11, 171.06], name: 'Marshall Islands'},
                {latLng: [17.3, -62.73], name: 'Saint Kitts and Nevis'},
                {latLng: [3.2, 73.22], name: 'Maldives'},
                {latLng: [35.88, 14.5], name: 'Malta'},
                {latLng: [12.05, -61.75], name: 'Grenada'},
                {latLng: [13.16, -61.23], name: 'Saint Vincent and the Grenadines'},
                {latLng: [13.16, -59.55], name: 'Barbados'},
                {latLng: [17.11, -61.85], name: 'Antigua and Barbuda'},
                {latLng: [-4.61, 55.45], name: 'Seychelles'},
                {latLng: [7.35, 134.46], name: 'Palau'},
                {latLng: [42.5, 1.51], name: 'Andorra'},
                {latLng: [14.01, -60.98], name: 'Saint Lucia'},
                {latLng: [6.91, 158.18], name: 'Federated States of Micronesia'},
                {latLng: [1.3, 103.8], name: 'Singapore'},
                {latLng: [1.46, 173.03], name: 'Kiribati'},
                {latLng: [-21.13, -175.2], name: 'Tonga'},
                {latLng: [15.3, -61.38], name: 'Dominica'},
                {latLng: [-20.2, 57.5], name: 'Mauritius'},
                {latLng: [26.02, 50.55], name: 'Bahrain'},
                {latLng: [0.33, 6.73], name: 'São Tomé and Príncipe'}
            ]
        });

        /* SPARKLINE CHARTS
         * ----------------
         * Create a inline charts with spark line
         */

        // -----------------
        // - SPARKLINE BAR -
        // -----------------
        $('.sparkbar').each(function () {
            var $this = $(this);
            $this.sparkline('html', {
                type: 'bar',
                height: $this.data('height') ? $this.data('height') : '30',
                barColor: $this.data('color')
            });
        });

        // -----------------
        // - SPARKLINE PIE -
        // -----------------
        $('.sparkpie').each(function () {
            var $this = $(this);
            $this.sparkline('html', {
                type: 'pie',
                height: $this.data('height') ? $this.data('height') : '90',
                sliceColors: $this.data('color')
            });
        });

        // ------------------
        // - SPARKLINE LINE -
        // ------------------
        $('.sparkline').each(function () {
            var $this = $(this);
            $this.sparkline('html', {
                type: 'line',
                height: $this.data('height') ? $this.data('height') : '90',
                width: '100%',
                lineColor: $this.data('linecolor'),
                fillColor: $this.data('fillcolor'),
                spotColor: $this.data('spotcolor')
            });
        });
    });

</script>