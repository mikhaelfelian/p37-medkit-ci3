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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">PEMERIKSAAN PENUNJANG - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 col-sm-3">
                                    <div class="nav flex-column nav-tabs h-100" id="" role="" aria-orientation="vertical">
                                        <?php $this->load->view('admin-lte-3/includes/medcheck/med_trans_penunjang_sidebar') ?>
                                    </div>
                                </div>
                                <div class="col-7 col-sm-9">
                                    <div class="tab-content" id="vert-tabs-tabContent">
                                        <div class="tab-pane text-left fade show active" id="tab-pemeriksaan" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                                            <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakDokter() == TRUE OR akses::hakPerawat() == TRUE OR akses::hakAnalis() == TRUE) { ?>
                                                <?php if ($sql_medc->status < 5) { ?>
                                                    <a href="<?php echo base_url('medcheck/set_medcheck_ass_fisik.php?id=' . general::enkrip($sql_medc->id) . '&status=' . $this->input->get('status')) ?>" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Assesment</a><?php echo br(2) ?>
                                                <?php } ?>
                                            <?php } ?>

                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-left" colspan="2">Pemeriksaan</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $grup = $this->ion_auth->get_users_groups()->row(); ?>
                                                    <?php $no = 1; ?>
                                                    <?php foreach ($sql_medc_lab->result() as $lab) { ?>
                                                        <?php $sql_lab_cek = $this->db->where('id_lab', $lab->id)->get('tbl_trans_medcheck_det'); ?>
                                                        <tr>
                                                            <td class="text-center" style="width: 50px;">                    
                                                                <?php if ($sql_lab_cek->num_rows() == 0) { ?>
                                                                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE OR akses::hakAnalis() == TRUE OR akses::hakDokter() == TRUE) { ?>
                                                                        <?php echo anchor(base_url('medcheck/lab/hapus.php?id=' . $this->input->get('id') . '&item_id=' . general::enkrip($lab->id) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i>', 'class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus [' . $lab->no_lab . '] ?\')"') ?>
                                                                    <?php } elseif ($lab->id_analis == $this->ion_auth->user()->row()->id) { ?>
                                                                        <?php if ($sql_medc->status_bayar == '0') { ?>
                                                                            <?php echo anchor(base_url('medcheck/lab/hapus.php?id=' . $this->input->get('id') . '&item_id=' . general::enkrip($lab->id) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i>', 'class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus [' . $lab->no_lab . '] ?\')"') ?>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </td>
                                                            <td class="text-center" style="width: 50px;"><?php echo $no; ?>.</td>
                                                            <td class="text-left" style="width: 50px;" colspan="2">
                                                                <?php echo $this->tanggalan->tgl_indo2($lab->tgl_masuk); ?>
                                                                <?php echo br(); ?>
                                                                <?php echo $lab->no_sample; ?>
                                                                <?php echo br(); ?>
                                                                <small><?php echo $this->ion_auth->user($lab->id_analis)->row()->first_name; ?></small>
                                                            </td>
                                                            <td class="text-left" style="width: 90px;">
                                                                <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAnalis() == TRUE OR akses::hakDokter() == TRUE OR akses::hakPerawat() == TRUE) { ?>
                                                                    <?php echo anchor(base_url('medcheck/tambah.php?act=lab_surat&id=' . general::enkrip($sql_medc->id) . '&id_lab=' . general::enkrip($lab->id) . '&status=' . $this->input->get('status')), 'Sample &raquo;', 'class="btn btn-success btn-flat btn-xs text-bold" style="width: 70px;"') ?>
                                                                    <?php echo anchor(base_url('medcheck/tambah.php?act=lab_input&id=' . general::enkrip($sql_medc->id) . '&id_lab=' . general::enkrip($lab->id) . '&status=' . $this->input->get('status')), 'Input &raquo;', 'class="btn btn-warning btn-flat btn-xs text-bold" style="width: 70px;"') ?>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                        <?php $no++ ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">

                                </div>
                            </div>                            
                        </div>
                    </div>
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
                        $("#harga").autoNumeric({aSep: '.', aDec: ',', aPad: false});
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

<?php echo $this->session->flashdata('medcheck_toast'); ?>
                    });
</script>