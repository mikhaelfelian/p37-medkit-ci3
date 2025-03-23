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
                        <li class="breadcrumb-item active">Unggah Berkas</li>
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
                            <h3 class="card-title">BERKAS - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
                        </div>
                        <div class="card-body">
                            <?php echo form_open_multipart(base_url('medcheck/set_medcheck_upload.php'), 'autocomplete="off"') ?>
                            <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group row">
                                        <label for="label" class="col-sm-4 col-form-label">Nama Berkas*</label>
                                        <div class="col-sm-8">
                                            <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control', 'placeholder' => 'Isikan Judul Berkas ...')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="label" class="col-sm-4 col-form-label">Keterangan*</label>
                                        <div class="col-sm-8">
                                            <?php echo form_textarea(array('id' => 'ket', 'name' => 'ket', 'class' => 'form-control', 'style' => 'height: 183px;', 'placeholder' => 'Isikan Keterangan ...')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="label" class="col-sm-4 col-form-label">Unggah Berkas*</label>
                                        <div class="col-sm-8">
                                            <?php echo form_upload(array('name' => 'fupload', 'class' => 'form-control')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9 text-right">
                                            <!--<button type="button" class="btn btn-danger btn-flat" onclick="window.location.href = '<?php // echo base_url('medcheck/tambah.php?act=lab_input&id=' . general::enkrip($sql_medc->id) . '&id_lab=' . $this->input->get('id_lab') . '&status=' . $this->input->get('status'))     ?>'"><i class="fas fa-refresh"></i> Reset</button>-->
                                            <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close() ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Tgl Masuk</th>
                                                <th class="text-left">Nama Berkas</th>
                                                <th class="text-left">Keterangan</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
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
                    <!-- /.card -->
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
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        // Data Pasien
        $('#pasien').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('medcheck/json_pasien.php') ?>",
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
                $itemrow.find('#id_pasien').val(ui.item.id);
                $('#id_pasien').val(ui.item.id);
                $('#pasien').val(ui.item.nama);

                // Give focus to the next input field to recieve input from user
                $('#pasien').focus();
                return false;
            }

            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.nik + "</a> <a>(" + item.jns_klm + ")</a></br><a>" + item.nama + "</a></br><a>" + item.alamat + "<br/>--------------------------------------------------------------</a>")
                    .appendTo(ul);
        };

    });
</script>