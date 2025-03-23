<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Medical Checkup</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('medcheck/index.php') ?>">Medical Checkup</a></li>
                        <li class="breadcrumb-item active">Resume Medis</li>
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
                <div class="col-lg-8">
                    <?php
                    switch ($_GET['act']) {

                        default:
                            $data['sql_resume'] = $gtotal;
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_resume_index', $data);
                            break;

                        case 'resm_fisik':
                            $data['sql_medc_resm_rw']   = $sql_medc_rsm_rw;
                            $data['sql_medc_resm_hs']   = $sql_medc_rsm_dt4;
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_resume_fisik', $data);
                            break;

                        case 'resm_surat':
                            $data['sql_medc_resm_rw'] = $sql_medc_rsm_rw;
                            if($sql_medc->tipe == '3'){
                                $this->load->view('admin-lte-3/includes/medcheck/med_trans_resume_surat_rnp', $data);
                            }else{
                                $this->load->view('admin-lte-3/includes/medcheck/med_trans_resume_surat', $data);
                            }
                            break;

                        case 'resm_input':
                            $data['sql_medc_resm_rw']   = $sql_medc_rsm_rw;
                            $data['sql_medc_resm_hs']   = $sql_medc_rsm_dt;
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_resume_input', $data);
                            break;

                        case 'resm_edit':
                            $data['sql_medc_resm_rw']   = $sql_medc_rsm_rw;
                            $data['sql_medc_resm_hs']   = $sql_medc_rsm_dt4;
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_resume_input', $data);
                            break;

                        case 'resm_input_rnp':
                            $data['sql_medc']           = $sql_medc;
                            $data['sql_medc_resm_rw']   = $sql_medc_rsm_rw;
                            $data['sql_medc_resm_hs']   = $sql_medc_rsm_dt;
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_resume_input_rnp', $data);
                            break;

                        case 'resm_edit_rnp':
                            $data['sql_medc']           = $sql_medc;
                            $data['sql_medc_resm_rw']   = $sql_medc_rsm_rw;
                            $data['sql_medc_resm_hs']   = $sql_medc_rsm_dt;
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_resume_edit_rnp', $data);
                            break;

                        case 'resm_input_trp':
                            $data['sql_medc']           = $sql_medc;
                            $data['sql_medc_resm_rw']   = $sql_medc_rsm_rw;
                            $data['sql_medc_resm_hs']   = $sql_medc_rsm_dt;
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_resume_input_trp', $data);
                            break;

                        case 'resm_edit_trp':
                            $data['sql_medc']           = $sql_medc;
                            $data['sql_medc_resm_rw']   = $sql_medc_rsm_rw;
                            $data['sql_medc_resm_hs']   = $sql_medc_rsm_dt;
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_resume_edit_trp', $data);
                            break;
                    }
                    ?>
                </div>
                <div class="col-lg-4">
                    <?php $data['gtotal'] = $gtotal ?>
                    <?php $this->load->view('admin-lte-3/includes/medcheck/med_tindakan_kanan', $data) ?>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
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

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $("#harga").autoNumeric({aSep: '.', aDec: ',', aPad: false});

        // Select2   
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
        <?php echo $this->session->flashdata('medcheck_toast'); ?> 
    });
</script>