<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Antrian</li>
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
                <div class="col-md-6">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Data Antrian</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <div class="row">
                                <div class="col-md-3"><?php echo nbs() ?></div>
                                <div class="col-md-6 text-center">
                                    <h2 class="headline text-danger" style="font-size: 7rem;">
                                        <?php echo $this->input->get('antrian') ?>
                                    </h2>
                                    <?php if ($sql_antrian->status_pgl == '1') { ?>
                                        <a href="<?php echo base_url('medcheck/set_data_antrian.php?id=' . $this->input->get('id') . '&antrian=' . $this->input->get('antrian') . '&type=' . $this->input->get('type') . '&status=' . $this->input->get('status') . '&status_pgl=' . $sql_antrian->status_pgl . '&poli=' . $this->input->get('poli') . '&id_view=' . $this->input->get('id_view')) ?>">
                                            <button type="button" class="btn btn-danger">STOP</button>
                                        </a>
                                    <?php } else { ?>
                                        <a href="<?php echo base_url('medcheck/set_data_antrian.php?id=' . $this->input->get('id') . '&antrian=' . $this->input->get('antrian') . '&type=' . $this->input->get('type') . '&status=' . $this->input->get('status') . '&status_pgl=' . $this->input->get('status_pgl') . '&poli=' . $this->input->get('poli') . '&id_view=' . $this->input->get('id_view')) ?>">
                                            <button type="button" class="btn btn-primary">PANGGIL</button>
                                        </a>
                                    <?php } ?>

                                    <a href="<?php echo base_url('medcheck/daftar.php?id=' . $this->input->get('id') . '&antrian=' . $this->input->get('antrian') . '&type=' . $this->input->get('type') . '&status=' . $this->input->get('status') . '&status_pgl=' . $this->input->get('status_pgl') . '&poli=' . $this->input->get('poli') . '&id_view=' . $this->input->get('id_view')) ?>">
                                        <button type="button" class="btn btn-primary">SET Pendaftaran</button>
                                    </a>
                                </div>
                                <div class="col-md-3"><?php echo nbs() ?></div>
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

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $("#tgl").datepicker({
            format: 'dd/mm/yyyy',
            changeMonth: true,
//            minDate: dateToday,
            autoclose: true
        });
        function call_data() {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('tr_custsrv/call_data') . (!empty($_GET['id']) ? '?id=' . $_GET['id'] . '&antrian=' . $_GET['antrian'] : '') ?>",
                cache: false,
                success: function (data) {
                    $("#Num_Queue").html(data);
                }
            });
        }
    });
</script>