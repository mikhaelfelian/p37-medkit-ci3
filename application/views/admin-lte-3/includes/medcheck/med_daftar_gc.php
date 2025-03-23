<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Persetujuan Umum</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('medcheck/index.php') ?>">Medical Checkup</a></li>
                        <li class="breadcrumb-item active">Persetujuan Umum</li>
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
                <div class="col-md-8">
                    <?php echo form_open(base_url('medcheck/set_gc_simpan.php'), 'autocomplete="off"') ?>
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Persetujuan Umum</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php echo $this->session->flashdata('master'); ?>
                            <?php $hasError = $this->session->flashdata('form_error'); ?>
                            <?php echo form_hidden('id', general::enkrip($sql_dft->id)) ?>

                            <div id="inputNm" class="form-group row <?php echo (!empty($hasError['nik']) ? 'text-danger' : '') ?>">
                                <label for="inputTinggi" class="col-sm-3 col-form-label">Nomor Identitas</label>
                                <div class="col-sm-9">
                                    <?php echo form_input(array('id' => 'nik', 'name' => 'nik', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan nomor identitas / passport ...', 'value' => $sql_dft->nik)) ?>
                                </div>
                            </div>
                            <div id="inputNm" class="form-group row <?php echo (!empty($hasError['nama']) ? 'text-danger' : '') ?>">
                                <label for="inputTinggi" class="col-sm-3 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-9">
                                    <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Nama Penanggungjawab ...', 'value' => $sql_dft->nama)) ?>
                                </div>
                            </div>
                            <div id="inputNm" class="form-group row <?php echo (!empty($hasError['nama']) ? 'text-danger' : '') ?>">
                                <label for="inputTinggi" class="col-sm-3 col-form-label">Hubungan</label>
                                <div class="col-sm-9">
                                    <select id="hubungan1" name="hubungan" class="form-control rounded-0">
                                        <option value="">[Hubungan dengan pasien]</option>
                                        <option value="1">Suami</option>
                                        <option value="2">Istri</option>
                                        <option value="3">Orangtua</option>
                                        <option value="4">Anak</option>
                                        <option value="5">Keluarga</option>
                                        <option value="6">Kerabat</option>
                                        <option value="7" selected>Diri Sendiri</option>
                                    </select>   
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">

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

<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!--Phone Masking-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<style>
    .autocomplete-scroll {
        max-height: 250px;
        overflow-y: auto;
        overflow-x: hidden;
    }
</style>
<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $("#no_hp").keydown(function (e) {
            // kibot: backspace, delete, tab, escape, enter .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                    // kibot: Ctrl+A, Command+A
                            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // kibot: home, end, left, right, down, up
                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // Biarin wae, ga ngapa2in return false
                        return;
                    }

                    // Cuman nomor
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });

        $("input[id=tgl_lahir]").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            autoclose: true
        });
    });
</script>
