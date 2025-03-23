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
                        <li class="breadcrumb-item active">Klinik</li>
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
                    <?php echo form_open(base_url('master/data_klinik_' . (isset($_GET['id']) ? 'update' : 'simpan') . '.php'), array('autocomplete' => 'off', 'id' => 'klinik_form')) ?>
                    <?php echo add_form_protection() ?>
                    <div class="card card-default rounded-0">
                        <div class="card-header">
                            <h3 class="card-title">Form Data Klinik</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php $hasError = $this->session->flashdata('form_error'); ?>
                            <?php echo form_hidden('id', $this->input->get('id')) ?>
                            <div class="form-group">
                                <label class="control-label">Kode</label>
                                <?php echo form_input(array('id' => 'klinik_kode', 'name' => 'kode', 'class' => 'form-control rounded-0'.(!empty($hasError['kode']) ? ' is-invalid' : ''), 'value' => $lokasi->kode)) ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Klinik</label>
                                <?php echo form_input(array('id' => 'klinik_lokasi', 'name' => 'lokasi', 'class' => 'form-control rounded-0'.(!empty($hasError['lokasi']) ? ' is-invalid' : ''), 'value' => $lokasi->lokasi)) ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Keterangan</label>
                                <?php echo form_input(array('id' => 'klinik_keterangan', 'name' => 'keterangan', 'class' => 'form-control rounded-0'.(!empty($hasError['keterangan']) ? ' is-invalid' : ''), 'value' => $lokasi->keterangan)) ?>
                            </div> 
                            <div class="form-group">
                                <label class="control-label">Post Location (Satu Sehat)</label>
                                <?php echo form_input(array('id' => 'postlocation', 'name' => 'postlocation', 'class' => 'form-control rounded-0'.(!empty($hasError['postlocation']) ? ' is-invalid' : ''), 'value' => $lokasi->post_location)) ?>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" onclick="window.location.href = '<?php echo base_url('master/data_klinik_list.php') ?>'" class="btn btn-primary btn-flat rounded-0">&laquo; Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <button type="submit" class="btn btn-primary btn-flat rounded-0"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <?php echo add_double_submit_protection('klinik_form') ?>
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
    $(function () {
        <?php echo $this->session->flashdata('master_toast'); ?>
    });
</script>