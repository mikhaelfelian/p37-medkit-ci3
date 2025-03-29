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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('medcheck/index.php') ?>">Medical
                                Checkup</a></li>
                        <li class="breadcrumb-item active">Pemeriksaan Penunjang</li>
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
                    <!-- Default box -->
                    <?php
                    switch ($_GET['act']) {
                        default:
                            $data['sql_lab'] = $gtotal;
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_pen_spiro_index', $data);
                            //                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_pen_ass_index', $data);
                            break;

                        case 'pen_ass_surat':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_ass_fisik_surat', $data);
                            break;

                        case 'pen_ass_fisik':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_ass_fisik_input', $data);
                            break;

                        case 'pen_spirometri':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_pen_spiro_index', $data);
                            break;

                        case 'pen_spirometri_surat':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_lab_spirometri_surat', $data);
                            break;

                        case 'pen_spirometri_input':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_lab_spirometri_input', $data);
                            break;

                        case 'pen_ekg':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_pen_ekg', $data);
                            break;

                        case 'pen_ekg_input':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_lab_ekg_input', $data);
                            break;

                        case 'pen_ekg_upload':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_lab_ekg_file', $data);
                            break;

                        case 'pen_hrv':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_pen_hrv', $data);
                            break;

                        case 'pen_hrv':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_pen_hrv', $data);
                            break;

                        case 'pen_hrv_input':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_pen_hrv_input', $data);
                            break;

                        case 'pen_adm':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_pen_audiometri', $data);
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
<link rel="stylesheet"
    href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $("#harga").autoNumeric({ aSep: '.', aDec: ',', aPad: false });
        $("#tgl_masuk").datepicker({
            dateFormat: 'dd-mm-yy',
            SetDate: new Date(),
            autoclose: true
        });

        // Select2   
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        <?php if ($_GET['act'] == 'lab_input') { ?>
            // Data Item Cart
            $('#kode').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url('medcheck/json_item.php?page=lab&status=3') ?>",
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                minLength: 1,
                select: function (event, ui) {
                    var $itemrow = $(this).closest('tr');
                    //Populate the input fields from the returned values
                    $itemrow.find('#id_item').val(ui.item.id);
                    $('#id_item').val(ui.item.id);
                    $('#kode').val(ui.item.kode);
                    window.location.href = "<?php echo base_url('medcheck/tambah.php?act=' . $this->input->get('act') . '&id=' . $this->input->get('id') . '&id_lab=' . $this->input->get('id_lab') . '&status=' . $this->input->get('status')) ?>&id_produk=" + ui.item.id + "&harga=" + ui.item.harga;

                    // Give focus to the next input field to recieve input from user
                    $('#jml').focus();
                    return false;
                }

                // Format the list menu output of the autocomplete
            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.name + "</a>")
                    .appendTo(ul);
            };
        <?php } ?>

        <?php if (!empty($sql_produk)) { ?>
            // Cari Data Dokter
            $('#dokter').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url('medcheck/json_dokter.php') ?>",
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                minLength: 1,
                select: function (event, ui) {
                    var $itemrow = $(this).closest('tr');
                    //Populate the input fields from the returned values
                    $itemrow.find('#id_dokter').val(ui.item.id);
                    $('#id_dokter').val(ui.item.id_user);
                    $('#dokter').val(ui.item.nama);
                    //                window.location.href = "<?php echo base_url('medcheck/tambah.php?id=' . $this->input->get('id') . '&status=' . $this->input->get('status')) ?>";

                    // Give focus to the next input field to recieve input from user
                    $('#dokter').focus();
                    return false;
                }

                // Format the list menu output of the autocomplete
            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.nama + "</a>")
                    .appendTo(ul);
            };
        <?php } ?>
    });
</script>