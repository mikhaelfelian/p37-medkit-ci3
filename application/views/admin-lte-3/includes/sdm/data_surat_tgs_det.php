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
                        <li class="breadcrumb-item active">Surat Tugas Detail</li>
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">SURAT TUGAS</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php $hasError = $this->session->flashdata('form_error'); ?>

                                    <div class="form-group row <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Nama Karyawan</label>
                                        <div class="col-sm-8">
                                            <?php echo form_input(array('id' => 'karyawan', 'name' => 'nama', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'readonly' => 'TRUE', 'placeholder' => 'Cari nama karyawan ...', 'value' => (!empty($sql_kary)) ? $sql_kary->nama : '')) ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($sql_kary)) { ?>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Tanggal Penugasan</label>
                                            <div class="col-sm-8">
                                                <?php echo form_input(array('id' => 'tgl_masuk', 'name' => 'tgl_masuk', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'readonly' => 'TRUE', 'placeholder' => 'Isikan tanggal mulai ...', 'value' => $this->tanggalan->tgl_indo2($sql_tgs->tgl_masuk))) ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Sampai dengan</label>
                                            <div class="col-sm-8">
                                                <?php echo form_input(array('id' => 'tgl_keluar', 'name' => 'tgl_keluar', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'readonly' => 'TRUE', 'placeholder' => 'Isikan tanggal selesai ...', 'value' => $this->tanggalan->tgl_indo2($sql_tgs->tgl_keluar))) ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Penugasan</label>
                                            <div class="col-sm-8">
                                                <?php echo form_input(array('id' => 'judul', 'name' => 'judul', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'readonly' => 'TRUE', 'placeholder' => 'Isikan kegiatan ...', 'value' => $sql_tgs->judul)) ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-md-6">
                                    <?php if (!empty($sql_kary)) { ?>
                                        <div class="form-group">
                                            <!--<label for="inputEmail3">Keperluan</label>-->
                                            <?php echo form_textarea(array('id' => 'keterangan', 'name' => 'ket', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'readonly' => 'TRUE', 'placeholder' => 'Isikan keterangan atau detail penugasan ...', 'value' => $sql_tgs->keterangan)) ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-lg-6">
                                    <?php echo form_open(base_url('sdm/set_surat_tgs_simpan_kary.php'), 'autocomplete="off"') ?>
                                    <?php echo form_hidden('id', general::enkrip($sql_tgs->id)) ?>
                                    <input type="hidden" id="id_karyawan_tmbh" name="id_karyawan">
                                    
                                    <div class="form-group row <?php echo (!empty($hasError['kary_tambah']) ? 'text-danger' : '') ?>">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label"><small><i class="fa fa-plus"></i> Karyawan Tambahan</small></label>
                                        <div class="col-sm-6">
                                            <?php echo form_input(array('id' => 'karyawan_tmbh', 'name' => 'karyawan_tmbh', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'placeholder' => 'Cari nama karyawan ...')) ?>
                                        </div>
                                        <div class="col-sm-2">
                                            <button class="btn btn-primary btn-flat" type="submit">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <?php echo form_close() ?>
                                </div>
                                <div class="col-lg-6">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>NIK</th>
                                                <th>Nama</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            <?php foreach ($sql_tgs_tmbh as $peg){ ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no; ?></td>
                                                    <td><?php echo $peg->nik; ?></td>
                                                    <td><?php echo $peg->nama; ?></td>
                                                    <td>
                                                        <?php echo anchor(base_url('sdm/set_surat_tgs_hapus_kary.php?id='.general::enkrip($peg->id).'&id_surat='.general::enkrip($peg->id_surat_tgs)), '<i class="fa fa-trash"></i>', 'class="text-danger" onclick="return confirm(\'Hapus ?\')"') ?>
                                                    </td>
                                                </tr>
                                                <?php $no++?>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'sdm/data_surat_tgs_list.php') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">

                                </div>
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
                                            $('#karyawan_tmbh').autocomplete({
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
                                                    $('#id_karyawan_tmbh').val(ui.item.id);
                                                    $('#karyawan_tmbh').val(ui.item.nama);

                                                    // Give focus to the next input field to recieve input from user
                                                    $('#karyawan_tmbh').focus();
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