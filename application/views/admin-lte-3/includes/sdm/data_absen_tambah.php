<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!--<h1 class="m-0">Master Data</h1>-->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Absensi</li>
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
                <div class="col-md-12">
                    <?php echo form_open_multipart(base_url('sdm/set_absen_simpan.php'), 'autocomplete="off"') ?>
                    <input type="hidden" id="id_karyawan" name="id_karyawan" value="<?php echo general::enkrip($sql_kary->id) ?>">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Absen</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php $hasError = $this->session->flashdata('form_error'); ?>

                                    <div class="form-group row <?php echo (!empty($hasError['ket']) ? 'text-danger' : '') ?>">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Keterangan</label>
                                        <div class="col-sm-8">
                                            <?php echo form_input(array('id' => 'karyawan', 'name' => 'ket', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['ket']) ? ' is-invalid' : ''), 'placeholder' => 'Tulis keterangan ...')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Unggah Absen</label>
                                        <div class="col-sm-8">
                                            <?php echo form_upload(array('id' => 'fupload', 'name' => 'fupload', 'class' => (!empty($hasError['fupload']) ? ' is-invalid' : ''))) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'sdm/data_absen.php') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
                                        $(function () {
                                            // Menampilkan Tanggal
                                            $("#tgl_masuk").datepicker({
                                                dateFormat: 'dd-mm-yy',
                                                changeMonth: true,
                                                changeYear: true,
                                                yearRange: '1920:<?php echo date('Y') ?>',
                                                autoclose: true
                                            });
                                            $("#tgl_keluar").datepicker({
                                                dateFormat: 'dd-mm-yy',
                                                changeMonth: true,
                                                changeYear: true,
                                                yearRange: '1920:<?php echo date('Y') ?>',
                                                autoclose: true
                                            });

                                            // Cari data karyawan
                                            $('#karyawan').autocomplete({
                                                source: function (request, response) {
                                                    $.ajax({
                                                        url: "<?php echo base_url('sdm/json_karyawan.php') ?>",
                                                        dataType: "json",
                                                        data: {
                                                            term: request.term
                                                        },
                                                        success: function (data) {
                                                            response(data);
                                                        }
                                                    });
                                                },
                                                minLength: 4,
                                                select: function (event, ui) {
                                                    var $itemrow = $(this).closest('tr');
                                                    //Populate the input fields from the returned values
                                                    $itemrow.find('#id_karyawan').val(ui.item.id);
                                                    $('#id_karyawan').val(ui.item.id);
                                                    $('#karyawan').val(ui.item.nama);
                                                    window.location.href = "<?php echo base_url('sdm/data_gaji_tambah.php?') ?>id=" + ui.item.id;

                                                    // Give focus to the next input field to recieve input from user
                                                    $('#karyawan').focus();
                                                    return false;
                                                }

                                                // Format the list menu output of the autocomplete
                                            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                                                return $("<li></li>")
                                                        .data("item.autocomplete", item)
                                                        .append("<a>" + item.nama + "</a>")
                                                        .appendTo(ul);
                                            };

<?php echo $this->session->flashdata('sdm_toast'); ?>
                                        });
</script>