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
                        <li class="breadcrumb-item active">Transfer Pasien</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                            <div class="row">
                                <div class="col-12">
                                    <?php echo $this->session->flashdata('medcheck'); ?>
                                    <?php echo form_open_multipart(base_url('medcheck/set_medcheck_transfer.php'), 'autocomplete="off"') ?>
                                    <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                                    <?php echo form_hidden('status', $sql_medc->status); ?>
                                    
                                    <h4>Transfer Pasien</h4>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Asal Poli</label>
                                        <div class="col-sm-7">
                                            <select name="poli_asl" class="form-control <?php echo (!empty($hasError['poli']) ? ' is-invalid' : '') ?>">
                                                <option value="">- Poli -</option>
                                                <?php foreach ($poli as $poliasl) { ?>
                                                    <option value="<?php echo $poliasl->id ?>" <?php echo ($poliasl->id == $sql_medc->id_poli ? 'selected' : '') ?>><?php echo $poliasl->lokasi ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Tujuan Poli</label>
                                        <div class="col-sm-7">
                                            <select name="poli_7an" class="form-control <?php echo (!empty($hasError['poli']) ? ' is-invalid' : '') ?>">
                                                <option value="">- Poli -</option>
                                                <?php foreach ($poli as $poli7an) { ?>
                                                    <option value="<?php echo $poli7an->id ?>"><?php echo $poli7an->lokasi ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Dokter</label>
                                        <div class="col-sm-7">
                                            <select name="dokter" class="form-control <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                                <option value="">- Dokter -</option>
                                                <?php foreach ($sql_doc as $doctor) { ?>
                                                    <option value="<?php echo $doctor->id_user ?>"><?php echo strtoupper($doctor->nama) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Tipe</label>
                                        <div class="col-sm-7">
                                            <select name="tipe" class="form-control <?php echo (!empty($hasError['tipe']) ? ' is-invalid' : '') ?>">
                                                <option value="">- Tipe -</option>
                                                <option value="1">Laborat</option>
                                                <option value="4">Radiologi</option>
                                                <option value="2">Rawat Jalan</option>
                                                <option value="3">Rawat Inap</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Catatan</label>
                                        <div class="col-sm-7">
                                            <?php echo form_textarea(array('id' => 'catatan', 'name' => 'catatan', 'class' => 'form-control', 'value' => $pasien->alamat, 'style' => 'height: 210px;', 'placeholder' => 'Catatan perawat ...')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-7 pull-right">
                                            <button type="submit" class="btn btn-primary btn-flat pull-right">Simpan</button>
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                            <h3 class="text-primary"><i class="fas fa-hospital-user"></i> <?php echo anchor(base_url('master/data_pasien_det.php?id='.general::enkrip($sql_medc->id_pasien)), $sql_pasien->nama_pgl); ?></h3>
                            <?php $this->load->view('admin-lte-3/includes/medcheck/med_tindakan_kanan') ?>
                            <div class="text-left mt-5 mb-3">
                                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href='<?php echo base_url('medcheck/tindakan.php?id='.general::enkrip($sql_medc->id)) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
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
        $("#harga").autoNumeric({aSep: '.', aDec: ',', aPad: false});

        // Data Item Cart
        $('#kode').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('medcheck/json_item.php?status=0') ?>",
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
                window.location.href = "<?php echo base_url('medcheck/tambah.php?id=' . $this->input->get('id') . '&status=' . $this->input->get('status')) ?>&id_produk=" + ui.item.id + "&harga=" + ui.item.harga;

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
                    $('#id_dokter').val(ui.item.id);
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