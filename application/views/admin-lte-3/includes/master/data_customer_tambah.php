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
                        <li class="breadcrumb-item active">Pasien</li>
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
                    <?php echo form_open(base_url('master/data_customer_' . (isset($_GET['id']) ? 'update' : 'simpan') . '.php'), 'autocomplete="off"') ?>
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Data Pasien</h3>
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
                            <div class="form-group <?php echo (!empty($hasError['nik']) ? 'has-error' : '') ?>">
                                <label class="control-label">NIK</label>
                                <?php echo form_input(array('id' => 'nik', 'name' => 'nik', 'class' => 'form-control', 'value' => $sales->nik)) ?>
                            </div>

                            <div class="form-group <?php echo (!empty($hasError['kode']) ? 'has-error' : '') ?>">
                                <label class="control-label">Kode</label>
                                <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control', 'value' => $sales->kode)) ?>
                            </div>

                            <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                <label class="control-label">Nama</label>
                                <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control', 'value' => $sales->nama)) ?>
                            </div>
                            <div class="form-group <?php echo (!empty($hasError['no_hp']) ? 'has-error' : '') ?>">
                                <label class="control-label">No. HP</label>
                                <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control', 'value' => $sales->no_hp)) ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Alamat</label>
                                <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control', 'value' => $sales->alamat)) ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Kota</label>
                                <?php echo form_input(array('id' => 'kota', 'name' => 'kota', 'class' => 'form-control', 'value' => $sales->kota)) ?>
                            </div>
                            <div class="form-group <?php echo (!empty($hasError['grup']) ? 'has-error' : '') ?>">
                                <label class="control-label">Status</label>
                                <select name="grup" class="form-control">
                                    <option value="">- Pilih -</option>
                                    <?php
                                    $grup = $this->ion_auth->groups()->result();
                                    foreach ($grup as $grup) {
                                        if ($grup->id > 3) {
                                            echo '<option value="' . $grup->id . '" ' . ($grup->name == $this->ion_auth->get_users_groups($user->id)->row()->name ? 'selected' : '') . '>' . ucfirst($grup->description) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" onclick="window.location.href = '<?php echo base_url('master/data_customer_list.php') ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>
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