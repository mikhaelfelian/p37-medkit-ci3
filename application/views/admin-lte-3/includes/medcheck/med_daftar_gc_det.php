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
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Persetujuan Umum</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php echo $this->session->flashdata('master'); ?>

                            <div id="inputNm" class="form-group row <?php echo (!empty($hasError['nik']) ? 'text-danger' : '') ?>">
                                <label for="inputTinggi" class="col-sm-3 col-form-label">Nomor Identitas</label>
                                <div class="col-sm-9">
                                    <?php echo form_input(array('id' => 'nik', 'name' => 'nik', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan nomor identitas / passport ...', 'value' => $sql_dft_gc->nik, 'disabled' => 'true')) ?>
                                </div>
                            </div>
                            <div id="inputNm" class="form-group row <?php echo (!empty($hasError['nama']) ? 'text-danger' : '') ?>">
                                <label for="inputTinggi" class="col-sm-3 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-9">
                                    <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Nama Penanggungjawab ...', 'value' => $sql_dft_gc->nama, 'disabled' => 'true')) ?>
                                </div>
                            </div>
                            <div id="inputNm" class="form-group row">
                                <label for="inputTinggi" class="col-sm-3 col-form-label">Hubungan</label>
                                <div class="col-sm-9">
                                    <select id="hubungan1" name="hubungan" class="form-control rounded-0" disabled>
                                        <option value="">[Hubungan dengan pasien]</option>
                                        <option value="1" <?php echo ($sql_dft_gc->status_hub == '1' ? 'selected' : '') ?>>Suami</option>
                                        <option value="2" <?php echo ($sql_dft_gc->status_hub == '2' ? 'selected' : '') ?>>Istri Orang</option>
                                        <option value="3" <?php echo ($sql_dft_gc->status_hub == '3' ? 'selected' : '') ?>>Orangtua</option>
                                        <option value="4" <?php echo ($sql_dft_gc->status_hub == '4' ? 'selected' : '') ?>>Anak</option>
                                        <option value="5" <?php echo ($sql_dft_gc->status_hub == '5' ? 'selected' : '') ?>>Keluarga</option>
                                        <option value="6" <?php echo ($sql_dft_gc->status_hub == '6' ? 'selected' : '') ?>>Kerabat</option>
                                        <option value="7" <?php echo ($sql_dft_gc->status_hub == '7' ? 'selected' : '') ?>>Diri Sendiri</option>
                                    </select>   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">TANDA TANGAN</h3>
                        </div>
                        <div class="card-body">        
                            <div id="inputTTD" class="form-group <?php echo (!empty($hasError['ttd']) ? 'text-danger' : '') ?>">
                                <label for="inputJnsKlm">TTD Pembuat Pernyataan</label>
                                <img src="<?php echo base_url($sql_dft_gc->file_name) ?>" class="img-rounded">
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/data_pendaftaran.php?filter_tgl='.date('Y-m-d')) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'surat/print_pdf_gc.php?dft=' . general::enkrip($sql_dft_gc->id)) ?>'"><i class="fas fa-print"></i> Cetak</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                    <?php // echo form_close() ?>
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

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>
<style>
    .autocomplete-scroll {
        max-height: 250px;
        overflow-y: auto;
        overflow-x: hidden;
    }
</style>
<!-- Page script -->
