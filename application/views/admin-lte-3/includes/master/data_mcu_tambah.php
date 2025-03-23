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
                        <li class="breadcrumb-item active">Medical Checkup</li>
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
                    <?php echo form_open(base_url('master/data_mcu_' . (isset($_GET['id']) ? 'update' : 'simpan') . '.php'), 'autocomplete="off"') ?>
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Master MCU</h3>
                            <div class="card-tools">
                                
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php echo $this->session->flashdata('master'); ?>
                            <?php $hasError = $this->session->flashdata('form_error'); ?>
                            <?php echo form_hidden('id', $this->input->get('id')) ?>
                            
                            <div class="form-group <?php echo (!empty($hasError['bagian']) ? 'has-error' : '') ?>">
                                <label class="control-label">Bagian</label>
                                <select name="bagian" class="form-control rounded-0">
                                    <option value="">- Section MCU -</option>
                                    <?php $bag_no = 'A'; ?>
                                    <?php for($bag = 1; $bag <= 6; $bag++){ ?>
                                        <option value="<?php echo $bag ?>" <?php // echo ($bagian->id == $mcu->id_bagian ? 'selected' : '') ?>><?php echo 'BAGIAN '.strtoupper($bag_no) ?></option>
                                        <?php $bag_no++; ?> 
                                    <?php } ?> 
                                </select>
                            </div>
                            
                            <div class="form-group <?php echo (!empty($hasError['kategori']) ? 'has-error' : '') ?>">
                                <label class="control-label">Kategori</label>
                                <select name="kategori" class="form-control rounded-0">
                                    <option value="">- Kategori MCU -</option>
                                    <?php foreach($sql_kat as $kategori){ ?>
                                        <option value="<?php echo $kategori->id ?>" <?php echo ($kategori->id == $mcu->id_kategori ? 'selected' : '') ?>><?php echo strtoupper($kategori->kategori) ?></option>
                                    <?php } ?> 
                                </select>
                            </div>
                            
                            <div class="form-group <?php echo (!empty($hasError['periksa']) ? 'has-error' : '') ?>">
                                <label class="control-label">Pemeriksaan</label>
                                <?php echo form_input(array('id' => 'periksa', 'name' => 'periksa', 'class' => 'form-control rounded-0', 'value' => $mcu->pemeriksaan, 'placeholder'=>'Isikan Item Pemeriksaan ...')) ?>
                            </div>
                            
                            <!--
                            <div class="form-group <?php // echo (!empty($hasError['keterangan']) ? 'has-error' : '') ?>">
                                <label class="control-label">Satuan</label>
                                <?php // echo form_input(array('id' => 'satuan', 'name' => 'satuan', 'class' => 'form-control rounded-0', 'value' => $mcu->satuan, 'placeholder'=>'Isikan Satuan ...')) ?>
                            </div>
                            -->
                            
                            <div class="form-group <?php echo (!empty($hasError['keterangan']) ? 'has-error' : '') ?>">
                                <label class="control-label">Keterangan</label>
                                <?php echo form_input(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control rounded-0', 'value' => $mcu->keterangan, 'placeholder'=>'Isikan Keterangan ...')) ?>
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