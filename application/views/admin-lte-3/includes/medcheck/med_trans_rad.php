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
                        <li class="breadcrumb-item active">Instalasi Radiologi</li>
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
                            $data['sql_lab'] = $gtotal;
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_rad_index', $data);
                            break;

                        case 'rad_surat':
                            $data['sql_medc_rad_rw'] = $sql_medc_rad_rw;
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_rad_surat', $data);
                            break;

                        case 'rad_input':
                            $data['sql_medc_rad_rw'] = $sql_medc_rad_rw;
//                            $data['sql_medc_rad_dt']     = $sql_medc_rad_dt;
                            $data['sql_det'] = $sql_det;
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_rad_input', $data);
                            break;

                        case 'rad_hasil':
                            $data['sql_medc_rad_rw'] = $sql_medc_rad_rw;
                            $data['sql_medc_rad_hs'] = $this->db->where('id_medcheck', general::dekrip($this->input->get('id')))->where('id_rad', general::dekrip($this->input->get('id_rad')))->where('id_medcheck_det', general::dekrip($this->input->get('id_item')))->get('tbl_trans_medcheck_rad_det')->result();
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_rad_hasil', $data);
                            break;

                        case 'rad_hasil_lamp':
                            $data['sql_medc_rad_rw'] = $sql_medc_rad_rw;
                            $data['sql_medc_rad_file'] = $this->db->where('id_medcheck_det', $sql_medc_det_rw->id)->get('tbl_trans_medcheck_rad_file')->result();
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_rad_lamp', $data);
                            break;
                    }
                    ?>
                    <!--
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">INSTALASI RADIOLOGI - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
                        </div>
                        <div class="card-body">
                        </div>
                        <div class="card-footer">
                    <?php echo form_open(base_url('medcheck/set_medcheck_rad_upd.php'), 'autocomplete="off"') ?>
                    <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                    <?php echo form_hidden('id_user', $sql_medc_rad_rw->id_radiografer); ?>
                    <?php echo form_hidden('id_rad', general::enkrip($sql_medc_rad_rw->id)); ?>
                    <?php echo form_hidden('no_sampel', $sql_medc_rad_rw->no_sample); ?>
                    <?php echo form_hidden('dokter', $sql_medc_rad_rw->id_dokter); ?>
                    <?php echo form_hidden('dokter_kirim', $sql_medc_rad_rw->id_dokter_kirim); ?>
                    <?php echo form_hidden('kesan', $sql_medc_rad_rw->kesan); ?>
                    <?php echo form_hidden('status', $this->input->get('status')); ?>
                    <?php echo form_hidden('status_rad', '4'); ?>
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">  
                    <?php if ($_GET['act'] == 'rad_input' AND!empty($sql_medc_det)) { ?>
                                            <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/surat/cetak_pdf_rad.php?id=' . $this->input->get('id') . '&id_lab=' . $this->input->get('id_lab')) ?>'"><i class="fas fa-print"></i> Cetak</button>
                    <?php } ?>
                    <?php if (akses::hakDokter() != TRUE) { ?>
                        <?php if ($_GET['act'] == 'rad_input' AND $sql_medc_rad_rw->status < '4') { ?>
                                                    <button type="submit" class="btn btn-success btn-flat"><i class="fas fa-check"></i> Selesai</button>
                        <?php } ?>
                    <?php } ?>
                                </div>
                            </div>
                    <?php echo form_close(); ?>
                        </div>
                    </div>
                    -->
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

<!-- Page script -->
<script type="text/javascript">
    $(function () {                
        $("#harga").autoNumeric({aSep: '.', aDec: ',', aPad: false});

        // Select2   
        $('.select2bs4').select2({theme: 'bootstrap4'});

        <?php if ($_GET['act'] != 'rad_hasil_lamp') { ?>
            // Data Item Cart
            $('#kode').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url('medcheck/json_item.php?page=rad&status=' . $this->input->get('status')) ?>",
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
                    window.location.href = "<?php echo base_url('medcheck/tambah.php?act=rad_input&id=' . $this->input->get('id') . '&id_rad=' . $this->input->get('id_rad') . '&status=' . $this->input->get('status') . '&route=' . $this->input->get('route')) ?>&id_produk=" + ui.item.id + "&harga=" + ui.item.harga + "";

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
                            $itemrow.find('#id_dokter').val(ui.item.id_user);
                            $('#id_dokter').val(ui.item.id_user);
                            $('#dokter').val(ui.item.nama);

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