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