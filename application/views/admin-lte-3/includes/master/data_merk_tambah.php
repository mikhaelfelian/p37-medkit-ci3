<!-- Content Wrapper. Contains page content -->
<!-- 
    View: data_merk_tambah
    Description: Form to add or edit merk data
    Modified by: Mikhael Felian Waskito - mikhaelfelian@gmail.com
    Date: 2025-03-14
    GitHub: mikhaelfelian
-->
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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('master/index.php') ?>">Master Data</a>
                        </li>
                        <li class="breadcrumb-item active">Merk</li>
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
                    <?php echo form_open(base_url('master/data_merk_' . (isset($_GET['id']) ? 'update' : 'simpan') . '.php'), array('autocomplete' => 'off', 'id' => 'merk_form')) ?>
                    <?php echo add_form_protection(); ?>
                    <div class="card card-default rounded-0">
                        <div class="card-header">
                            <h3 class="card-title">Form Data Merk</h3>
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
                            <?php echo form_hidden('form_id', uniqid()) ?>
                            <div class="form-group <?php echo (!empty($hasError['merk']) ? 'has-error' : '') ?>">
                                <label class="control-label">Merk <span class="text-danger">*</span></label>
                                <?php echo form_input(array('id' => 'merk', 'name' => 'merk', 'class' => 'form-control rounded-0'.(!empty($hasError['merk']) ? ' is-invalid' : ''), 'value' => $merk->merk)) ?>
                            </div>
                            <div class="form-group <?php echo (!empty($hasError['keterangan']) ? 'has-error' : '') ?>">
                                <label class="control-label">Keterangan</label>
                                <?php echo form_input(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control rounded-0', 'value' => $merk->keterangan)) ?>
                                <?php if (!empty($hasError['keterangan'])) echo $hasError['keterangan']; ?>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button"
                                        onclick="window.location.href = '<?php echo base_url('master/data_merk_list.php') ?>'"
                                        class="btn btn-primary btn-flat rounded-0">&laquo; Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <button type="submit" class="btn btn-primary btn-flat rounded-0"><i
                                            class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo add_double_submit_protection('merk_form'); ?>
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
<script type="text/javascript">
    /* 
     * JavaScript for handling toast notifications
     * Modified by: Mikhael Felian Waskito - mikhaelfelian@gmail.com
     * Date: 2025-03-14
     */
    $(function () {
        <?php echo $this->session->flashdata('master_toast'); ?>
    });
</script>