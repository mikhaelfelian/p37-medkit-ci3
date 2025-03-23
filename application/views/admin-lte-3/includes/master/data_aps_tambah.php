<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!--<h1 class="m-0">Data Karyawan</h1>-->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('master/index.php') ?>">Master Data</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('master/data_karyawan_list.php') ?>">Karyawan</a></li>
                        <li class="breadcrumb-item active"><?php echo (isset($_GET['id']) ? 'Ubah' : 'Tambah'); ?></li>
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
                <div class="col-md-9">
                    <?php echo form_open(base_url('master/set_aps_' . (isset($_GET['id']) ? 'update' : 'simpan') . '.php'), 'autocomplete="off"') ?>
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Dokter APS</h3>
                            <div class="card-tools">
                                
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php echo $this->session->flashdata('master'); ?>
                            <?php $hasError = $this->session->flashdata('form_error'); ?>
                            <?php echo form_hidden('id', general::enkrip($sql_kary->id)) ?>
                            <?php echo form_hidden('id_user', general::enkrip($sql_kary->id_user)) ?>
                            <?php echo form_hidden('act', $this->input->get('act')) ?>
                            <?php echo form_hidden('id_medc', $this->input->get('id_medc')) ?>
                            <?php echo form_hidden('id_lab', $this->input->get('id_lab')) ?>
                            <?php echo form_hidden('status', $this->input->get('status')) ?>
                            <?php echo form_hidden('route', $this->input->get('route')) ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="form-group <?php echo (!empty($hasError['gelar']) ? 'text-danger' : '') ?>">
                                                <label class="control-label">Gelar</label>
                                                <?php echo form_input(array('id' => 'nama_dpn', 'name' => 'nama_dpn', 'class' => 'form-control rounded-0' . (!empty($hasError['gelar']) ? ' is-invalid' : ''), 'value' => $sql_kary->nama_dpn, 'placeholder' => 'dr. ...')) ?>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group <?php echo (!empty($hasError['nama']) ? 'text-danger' : '') ?>">
                                                <label class="control-label">Nama Lengkap*</label>
                                                <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control rounded-0' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'value' => $sql_kary->nama, 'placeholder' => 'John Doe ...')) ?>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group <?php echo (!empty($hasError['gelar']) ? 'text-danger' : '') ?>">
                                                <label class="control-label">Gelar</label>
                                                <?php echo form_input(array('id' => 'nama_blk', 'name' => 'nama_blk', 'class' => 'form-control rounded-0' . (!empty($hasError['nama_blk']) ? ' is-invalid' : ''), 'value' => $sql_kary->nama_blk, 'placeholder' => 'Sp.PD ...')) ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group <?php echo (!empty($hasError['jns_klm']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Jenis Kelamin*</label>
                                        <select name="jns_klm" class="form-control rounded-0 <?php echo (!empty($hasError['jns_klm']) ? 'is-invalid' : '') ?>">
                                            <option value="">- Pilih -</option>
                                            <option value="L" <?php echo ('L' == $sql_kary->jns_klm ? 'selected' : '') ?>>Laki - laki</option>
                                            <option value="P" <?php echo ('P' == $sql_kary->jns_klm ? 'selected' : '') ?>>Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                        <label class="control-label">No. HP</label>
                                        <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control rounded-0', 'value' => $sql_kary->no_hp, 'placeholder' => 'Nomor kontak WA karyawan / keluarga terdekat ...')) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <!--<button type="button" onclick="window.location.href = '<?php // echo base_url('master/data_pasien_list.php')     ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>-->
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
<script type="text/javascript">
    $(function () {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $("#tgl_lahir").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: '1920:<?php echo date('Y') ?>',
            autoclose: true
        });
        
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
        
        $('#no_rmh').mask('(000) 0000000');
        <?php echo $this->session->flashdata('master_toast'); ?>
    });
</script>