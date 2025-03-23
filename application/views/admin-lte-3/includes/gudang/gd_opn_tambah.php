<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Gudang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('gudang/index.php') ?>">Gudang</a></li>
                        <li class="breadcrumb-item active">Stok Opname</li>
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
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Stok Opname</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <div class="row">
                                <div class="col-md-5">
                                    <?php echo form_open_multipart(base_url('gudang/set_opname.php'), 'autocomplete="off"') ?>
                                    <?php $hasError = $this->session->flashdata('form_error'); ?>
                                    <?php echo form_hidden('id', $this->input->get('id')) ?>

                                    <div class="form-group <?php echo (!empty($hasError['pasien']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">User</label>
                                        <?php echo form_input(array('id' => 'customer', 'name' => 'customer', 'class' => 'form-control rounded-0 text-middle', 'style' => 'vertical-align: middle;', 'value' => $this->ion_auth->user()->row()->first_name, 'readonly' => 'TRUE')) ?>
                                    </div>
                                    <div class="form-group <?php echo (!empty($hasError['tipe']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Tanggal</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl_masuk', 'class' => 'form-control text-middle', 'style' => 'vertical-align: middle;')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3">Gudang <i class="text-danger">*</i></label>
                                        <select name="gudang" class="form-control rounded-0 <?php echo (!empty($hasError['gd_asal']) ? 'is-invalid' : '') ?>">
                                            <option value="">- Pilih -</option>
                                            <?php foreach ($sql_gudang as $gd) { ?>
                                                <option value="<?php echo $gd->id ?>"><?php echo $gd->gudang . ($gd->status == '1' ? ' [Utama]' : ''); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group <?php echo (!empty($hasError['tipe']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Keterangan</label>
                                        <?php echo form_textarea(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control rounded-0 text-middle', 'style' => 'vertical-align: middle; height: 200px;')) ?>
                                    </div>
                                    <div class="text-right">
                                        <button type="reset" class="btn btn-warning btn-flat"><i class="fa fa-undo"></i> Bersih</button>
                                        <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                    </div>
                                    <?php echo form_close() ?>
                                </div>
                                <div class="col-md-8">
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

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $("input[id=tgl]").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            autoclose: true
        });
    });
</script>