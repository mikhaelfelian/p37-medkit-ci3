<?php $hasError = $this->session->flashdata('form_error'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Konsul Antar Dokter</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('medcheck/index.php') ?>">Medical Checkup</a></li>
                        <li class="breadcrumb-item active">Konsul</li>
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
                <div class="col-lg-8">
                </div>
                <div class="col-lg-8">
                    <?php echo form_open(base_url('medcheck/set_konsul.php'), 'autocomplete="off"') ?>
                    <?php echo form_hidden('id_medc', $this->input->get('id')) ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">THREAD BARU</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                                    <?php echo $this->session->flashdata('medcheck'); ?>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <?php echo form_input(array('id' => 'cari', 'name' => 'judul', 'class' => 'form-control rounded-0', 'placeholder' => 'Untuk mencari data pemeriksaan pasien, silahkan klik ikon pencarian ...', 'value' => (!empty($_GET['pasien']) ? $_GET['pasien'] : ''), 'readonly' => 'true')) ?>
                                                <div class="input-group-append">
                                                    <?php echo anchor(base_url('medcheck/data_konsul_cari.php'), '<i class="fa fa-search"></i>', 'class="btn btn-default"') ?>
                                                </div>
                                            </div>
                                            <?php if (!isset($_GET['id'])) { ?>
                                                <br/>
                                                <div class="alert alert-danger alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    <h5><i class="icon fas fa-ban"></i> Perhatian!</h5>
                                                    Silahkan cari data pemeriksaan pasien yang ingin di konsultasikan terlebih dahulu..
                                                </div>
                                            <?php } ?>
                                            <?php if (isset($_GET['id'])) { ?>
                                                <br/>
                                                <div class="form-group">
                                                    <label for="inputEmail3">Judul</label>
                                                    <?php echo form_input(array('id' => 'judul', 'name' => 'judul', 'class' => 'form-control pull-left rounded-0', 'placeholder' => 'Isikan judul thread terkait pokok diskusi anda ...')) ?>
                                                </div>
                                                <br/>
                                                <div class="form-group <?php echo (!empty($hasError['dokter']) ? 'text-danger' : '') ?>">
                                                    <label for="inputEmail3">Dokter</label>                                            
                                                    <select id="dokter" name="dokter" class="form-control rounded-0 select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                                        <option value="">- Dokter -</option>
                                                        <?php foreach ($sql_doc as $doctor) { ?>
                                                            <option value="<?php echo $doctor->id_user ?>" <?php echo (!empty($sql_dft_id->id_dokter) ? ($doctor->id == $sql_dft_id->id_dokter ? 'selected' : '') : (($doctor->id == $this->session->flashdata('dokter') ? 'selected' : ''))) ?>><?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . strtoupper($doctor->nama) . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail3">Posting</label>
                                                    <?php echo form_textarea(array('id' => 'keterangan', 'name' => 'posting', 'class' => 'form-control pull-left rounded-0', 'placeholder' => 'Isikan deskripsi yang ingin dikonsultasikan ke dokter terkait ...', 'rows' => '8')) ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/data_konsul.php') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <?php if (isset($_GET['id'])) { ?>
                                        <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-paper-plane"></i> Kirim</button>
                                    <?php } ?>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <?php echo form_close() ?>
                    <hr/>
                    <!-- The time line -->
                    <div class="timeline">
                        <?php foreach ($sql_konsul as $konsul) { ?>
                            <?php $sql_konsul_bls = $this->db->where('id_parent', $konsul->id)->get('tbl_trans_konsul')->result() ?>

                            <!-- timeline time label -->
                            <div class="time-label">
                                <span class="bg-red"><?php echo $this->tanggalan->tgl_indo3($konsul->tgl_simpan); ?></span>
                            </div>
                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                            <div>
                                <i class="fas fa-user-md bg-blue"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($konsul->tgl_simpan); ?></span>
                                    <h3 class="timeline-header"><a href="#"><?php echo (!empty($sql_dokter->nama_dpn) ? $sql_dokter->nama_dpn . ' ' : '') . $sql_dokter->nama . (!empty($sql_dokter->nama_blk) ? ', ' . $sql_dokter->nama_blk . ' ' : ''); ?></a> sent you an question</h3>

                                    <div class="timeline-body">
                                        <?php echo $konsul->posting ?>
                                    </div>
                                    <div class="timeline-footer">
                                        <?php echo anchor(base_url('medcheck/tambah.php?id=' . general::enkrip($konsul->id_medcheck) . '&status=' . $this->input->get('status') . '&id_post=' . general::enkrip($konsul->id)), '<i class="fa fa-reply"></i> Balas', 'class="btn btn-primary btn-sm"') ?>
                                        <a class="btn btn-danger btn-sm">Hapus</a>
                                    </div>
                                </div>
                            </div>
                            <!-- END timeline item -->

                            <?php foreach ($sql_konsul_bls as $konsul_bls) { ?>
                                <?php $sql_user = $this->db->where('id_user', $konsul_bls->id_user)->get('tbl_m_karyawan')->row(); ?>
                                <div>
                                    <i class="fas fa-comments bg-yellow"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($konsul_bls->tgl_simpan); ?></span>
                                        <h3 class="timeline-header"><a href="#"><?php echo (!empty($sql_user->nama_dpn) ? $sql_user->nama_dpn . ' ' : '') . $sql_user->nama . (!empty($sql_user->nama_blk) ? ', ' . $sql_user->nama_blk . ' ' : ''); ?></a> commented on your post</h3>
                                        <div class="timeline-body">
                                            <?php echo $konsul_bls->posting ?>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-warning btn-sm">View comment</a>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <div>
                            <i class="fas fa-clock bg-gray"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">

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

<!--TinyMCE Editor-->
<script src="https://cdn.tiny.cloud/1/791yvh8m8x15hn314u1az9ucxk0sz0qflojtqo5y4z1ygmbm/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<!-- Page script -->
<script type="text/javascript">
                                        $(function () {
//        TinyMCE scripts
                                            tinymce.init({
                                                selector: 'textarea',
                                                menubar: '',
                                                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                                                toolbar: 'undo redo | bold italic underline | numlist bullist | charmap | removeformat',
                                            });
<?php echo $this->session->flashdata('medcheck_toast'); ?>
                                        });
</script>