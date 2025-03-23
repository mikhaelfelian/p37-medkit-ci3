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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('master/index.php') ?>">Master Data</a></li>
                        <li class="breadcrumb-item active">Supplier</li>
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
                <div class="col-md-4">
                    <?php echo form_open(base_url('master/data_supplier_' . (isset($_GET['id']) ? 'update' : 'simpan') . '.php'), 'autocomplete="off"') ?>
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Data Supplier</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php echo $this->session->flashdata('master'); ?>
                            <?php $hasError = $this->session->flashdata('form_error'); ?>
                            <?php echo form_hidden('id', $this->input->get('id')) ?>
                            
                            <?php if(!empty($supplier->kode)){ ?>
                                <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Kode</label>
                                    <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control', 'value' => $supplier->kode)) ?>
                                </div>
                            <?php } ?>
                            
                            <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                <label class="control-label">Nama</label>
                                <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control', 'value' => $supplier->nama)) ?>
                            </div>                        
                            <div class="form-group <?php echo (!empty($hasError['npwp']) ? 'has-error' : '') ?>">
                                <label class="control-label">NPWP</label>
                                <?php echo form_input(array('id' => 'npwp', 'name' => 'npwp', 'class' => 'form-control', 'value' => $supplier->npwp)) ?>
                            </div>
                            <div class="form-group <?php echo (!empty($hasError['no_hp']) ? 'has-error' : '') ?>">
                                <label class="control-label">No. HP</label>
                                <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control', 'value' => $supplier->no_hp)) ?>
                            </div>
                            <div class="form-group <?php echo (!empty($hasError['no_tlp']) ? 'has-error' : '') ?>">
                                <label class="control-label">No. Tlp</label>
                                <?php echo form_input(array('id' => 'no_tlp', 'name' => 'no_tlp', 'class' => 'form-control', 'value' => $supplier->no_tlp)) ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Alamat</label>
                                <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control', 'value' => $supplier->alamat)) ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Kota</label>
                                <?php echo form_input(array('id' => 'kota', 'name' => 'kota', 'class' => 'form-control', 'value' => $supplier->kota)) ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">CP</label>
                                <?php echo form_input(array('id' => 'cp', 'name' => 'cp', 'class' => 'form-control', 'value' => $supplier->cp)) ?>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" onclick="window.location.href = '<?php echo base_url('master/data_supplier_list.php') ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>
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
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!--Phone Masking-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
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
                
        $('#no_tlp').mask('(000) 0000000');
        
        <?php echo $this->session->flashdata('master_toast'); ?>
    });
</script>