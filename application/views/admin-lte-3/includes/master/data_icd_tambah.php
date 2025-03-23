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
                        <li class="breadcrumb-item active">ICD</li>
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
                <div class="col-md-6">
                    <?php echo form_open(base_url('master/data_icd_' . (isset($_GET['id']) ? 'update' : 'simpan') . '.php'), 'autocomplete="off"') ?>
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Master ICD</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php echo $this->session->flashdata('master'); ?>
                            <?php $hasError = $this->session->flashdata('form_error'); ?>
                            <?php echo form_hidden('id', $this->input->get('id')) ?>

                            <div class="form-group <?php echo (!empty($hasError['periksa']) ? 'has-error' : '') ?>">
                                <label class="control-label">Kode</label>
                                <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control rounded-0', 'value' => $icd->kode, 'placeholder' => 'Isikan Kode Diagnosa ...')) ?>
                            </div>

                            <div class="form-group <?php echo (!empty($hasError['diagnosa']) ? 'has-error' : '') ?>">
                                <label class="control-label">Diagnosa</label>
                                <?php echo form_input(array('id' => 'diagnosa', 'name' => 'diagnosa', 'class' => 'form-control rounded-0', 'value' => $icd->diagnosa, 'placeholder' => 'Isikan Diagnosa ...')) ?>
                            </div>

                            <div class="form-group <?php echo (!empty($hasError['diagnosa']) ? 'has-error' : '') ?>">
                                <label class="control-label">Diagnosa</label>
                                <?php echo form_input(array('id' => 'diagnosa', 'name' => 'diagnosa', 'class' => 'form-control rounded-0', 'value' => $icd->diagnosa, 'placeholder' => 'Isikan Diagnosa ...')) ?>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Keterangan</label>
                                <?php echo form_textarea(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control rounded-0', 'value' => $icd->keterangan, 'placeholder' => 'Isikan Keterangan ...')) ?>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Status</label><br/>
                                <input type="radio" name="tipe_icd" value="1" <?php echo ($icd->status_icd == '1' ? 'checked' : '') ?>> INA-CBG
                                <?php echo nbs(4); ?>
                                <input type="radio" name="tipe_icd" value="2" <?php echo ($icd->status_icd == '2' ? 'checked' : '') ?>> ICD 10
                            </div>

                            <div class="form-group">
                                <label class="control-label">Tipe Perawatan</label>
                                <select id="tipe" name="tipe" class="form-control rounded-0">
                                    <option value="">[Tipe Perawatan]</option>
                                    <option value="2">Rawat Jalan</option>
                                    <option value="3">Rawat Inap</option>
                                </select>
                            </div>

                            <div id="3" class="divRawat">
                                <div class="form-group">
                                    <label class="control-label">Kelas 1</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <?php echo form_input(array('id' => 'harga', 'name' => 'harga1', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['harga1']) ? ' is-invalid' : ''), 'placeholder' => 'Harga ...', 'value' => (!empty($icd->harga1) ? (float) $icd->harga1 : ''))) ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Kelas 2</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <?php echo form_input(array('id' => 'harga', 'name' => 'harga2', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['harga2']) ? ' is-invalid' : ''), 'placeholder' => 'Harga ...', 'value' => (!empty($icd->harga2) ? (float) $icd->harga2 : ''))) ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Kelas 3</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <?php echo form_input(array('id' => 'harga', 'name' => 'harga3', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['harga3']) ? ' is-invalid' : ''), 'placeholder' => 'Harga ...', 'value' => (!empty($icd->harga3) ? (float) $icd->harga3 : ''))) ?>
                                    </div>
                                </div>
                            </div>

                            <div id="2" class="divRawat">
                                <div class="form-group">
                                    <label class="control-label">Rawat Jalan</label>
                                    <div class="input-group mb-">
                                        <div class="input-group-append">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['harga']) ? ' is-invalid' : ''), 'placeholder' => 'Harga ...', 'value' => (!empty($icd->harga) ? (float) $icd->harga : ''))) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" onclick="window.location.href = '<?php echo base_url('master/data_mcu_list.php') ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>
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

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $("#2").hide().find('input').prop('disabled', true);
        $("#3").hide().find('input').prop('disabled', true);

        $('#kode').focus();
        $("input[id=harga]").autoNumeric({aSep: '.', aDec: ',', aPad: false});

        <?php echo $this->session->flashdata('medcheck_toast'); ?>
                
        $('#tipe').on('change', function () {
            var tipe = $(this).val();

            $("div.divRawat").hide();
            $("#" + tipe).show().find('input').prop('disabled', false);
        });
    });
</script>