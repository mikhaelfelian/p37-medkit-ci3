<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Medical Check</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Medical Check</li>
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
                <div class="col-lg-12"><?php echo $this->session->flashdata('login') ?></div>                
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!-- ChartJS -->
<!-- jQuery Mapael -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-mousewheel/jquery.mousewheel.js'); ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/raphael/raphael.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-mapael/jquery.mapael.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-mapael/maps/usa_states.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/chart.js/Chart.min.js'); ?>"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        <?php $chart2 = 1; ?>
        <?php foreach ($sql_kamar as $kmr) { ?>
        <?php $sisa_kmr = $kmr->jml_max - $kmr->jml ?>
        //-------------
        // - GRAFIK UNTUK <?php echo strtoupper($kmr->kamar) ?> -     
        var pieChartCanvas = $('#kamar<?php echo $chart2 ?>').get(0).getContext('2d')
        var pieData = {
            labels: ["Terpakai","Tersedia"],
            datasets: [
                {
                    data: ["<?php echo $kmr->jml ?>","<?php echo $sisa_kmr ?>"],
                    backgroundColor: ['#f56954', '#00a65a']
                }
            ]
        }
        var pieOptions = {
            legend: {
                display: false
            }
        }
        
        var pieChart = new Chart(pieChartCanvas, {
            type: 'doughnut',
            data: pieData,
            options: pieOptions
        })
        
        // - BATAS AKHIR -
        //-----------------
        <?php $chart2++ ?>
        <?php } ?>
    });
</script>