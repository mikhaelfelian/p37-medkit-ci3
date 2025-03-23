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
                        <li class="breadcrumb-item active">Assesment</li>
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
                    $hasError   = $this->session->flashdata('form_error');
                    
                    switch ($_GET['act']) {
                        default:
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_ass_fisik_index', $data);
                            break;
                            
                        case 'ass_surat':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_ass_fisik_surat', $data);
                            break;
                            
                        case 'ass_fisik':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_ass_fisik_input', $data);
                            break;
                            
                        case 'ass_fisik2':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_ass_fisik_input2', $data);
                            break;
                            
                        case 'ass_fisik3':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_ass_fisik_input3', $data);
                            break;
                            
                        case 'ass_fisik4':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_ass_fisik_input4', $data);
                            break;
                            
                        case 'ass_fisik5':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_ass_fisik_input5', $data);
                            break;
                            
                        case 'ass_fisik6':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_ass_fisik_input6', $data);
                            break;
                            
                        case 'ass_fisik7':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_ass_fisik_input7', $data);
                            break;
                            
                        case 'ass_fisik8':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_ass_fisik_input8', $data);
                            break;
                            
                        case 'ass_fisik9':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_ass_fisik_input9', $data);
                            break;
                            
                        case 'ass_fisik10':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_ass_fisik_input10', $data);
                            break;
                            
                        case 'ass_fisik11':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_ass_fisik_input11', $data);
                            break;
                        
                        case 'ass_fisik12':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_ass_fisik_input12', $data);
                            break;
                        
                        case 'ass_fisik13':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_ass_fisik_input13', $data);
                            break;
                        
                        case 'ass_fisik14':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_ass_fisik_input14', $data);
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
        $("#tgl_masuk").datepicker({
            dateFormat: 'dd-mm-yy',
            SetDate: new Date(),
            autoclose: true
        });
        
        // Select2   
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
        <?php echo $this->session->flashdata('medcheck_toast'); ?>                
    });
</script>