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
                    <?php echo form_open(base_url('medcheck/set_konsul_balas.php'), 'autocomplete="off"') ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">BALAS THREAD - <small><i><?php echo $sql_konsul->judul ?></i></small></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                                    <?php echo form_hidden('id', $this->input->get('id')); ?>
                                    <?php echo form_hidden('status', $this->input->get('status')); ?>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <!--<label for="inputEmail3">Posting</label>-->
                                                <?php echo form_textarea(array('id' => 'keterangan', 'name' => 'posting', 'class' => 'form-control pull-left rounded-0', 'placeholder' => 'Isikan komentar balasan terkait thread ' . $sql_konsul->judul . ' ...', 'rows' => '8')) ?>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="row">
                                        <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                                            <?php $hasError = $this->session->flashdata('form_error'); ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group <?php // echo (!empty($hasError['keluhan']) ? 'has-error' : '')                    ?>">
                                                        <label class="control-label">Anamnesa</label>
                                                        <div class="input-group mb-3">
                                                            <?php echo form_input(array('id' => 'anamnesa', 'name' => 'anamnesa', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['anamnesa']) ? ' is-invalid' : ''), 'value' => $sql_medc->anamnesa, 'placeholder' => 'Isikan Anamnesa ...')) ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group <?php // echo (!empty($hasError['keluhan']) ? 'has-error' : '')                   ?>">
                                                        <label class="control-label">Pemeriksaan</label>
                                                        <div class="input-group mb-3">
                                                            <?php echo form_input(array('id' => 'pemeriksaan', 'name' => 'pemeriksaan', 'class' => 'form-control pull-right rounded-0', 'value' => $sql_medc->pemeriksaan, 'placeholder' => 'Isikan Pemeriksaan ...')) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group <?php // echo (!empty($hasError['keluhan']) ? 'has-error' : '')    ?>">
                                                        <label class="control-label">Diagnosa</label>
                                                        <div class="input-group mb-3">
                                                            <?php echo form_input(array('id' => 'diagnosa', 'name' => 'diagnosa', 'class' => 'form-control pull-right rounded-0', 'value' => $sql_medc->diagnosa, 'placeholder' => 'Isikan Diagnosa ...')) ?>
                                                        </div>
                                                    </div>
                                                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE OR akses::hakDokter() == TRUE) { ?>
                                                        <div class="form-group">
                                                            <label class="control-label">Program</label>
                                                            <div class="input-group mb-3">
                                                                <?php echo form_input(array('id' => 'program', 'name' => 'program', 'class' => 'form-control pull-right rounded-0', 'value' => $sql_medc->program, 'placeholder' => 'Isikan Program (Khusus Dokter) ...')) ?>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
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
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-paper-plane"></i> Kirim</button>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <?php echo form_close() ?>
                    <?php if (!empty($sql_konsul_bls)) { ?>
                        <hr/>
                        <!-- The time line -->
                        <div class="timeline">
                            <?php foreach ($sql_konsul_bls as $konsul_bls) { ?>
                                <?php $sql_bls = $this->db->where('id_parent', $konsul_bls->id_parent)->where('DATE(tgl_simpan)', $this->tanggalan->tgl_indo_sys($konsul_bls->tgl_simpan))->get('tbl_trans_konsul')->result() ?>

                                <!-- timeline time label -->
                                <div class="time-label">
                                    <span class="bg-red"><?php echo $this->tanggalan->tgl_indo3($konsul_bls->tgl_simpan); ?></span>
                                </div>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <?php foreach ($sql_bls as $bls) { ?>
                                    <?php $sql_user = $this->db->where('id_user', $bls->id_user)->get('tbl_m_karyawan')->row(); ?>
                                    <div>
                                        <i class="fas fa-comments bg-yellow"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i> <?php echo $this->tanggalan->sejak($bls->tgl_simpan); ?></span>
                                            <h3 class="timeline-header"><a href="#"><?php echo (!empty($sql_user->nama_dpn) ? $sql_user->nama_dpn . ' ' : '') . $sql_user->nama . (!empty($sql_user->nama_blk) ? ', ' . $sql_user->nama_blk . ' ' : ''); ?></a> membalas thread anda</h3>
                                            <div class="timeline-body">
                                                <?php echo html_entity_decode($bls->posting) ?>
                                                <?php echo br() ?>
                                                <table class="table table-striped">
                                                    <tr>
                                                        <th>Anamnesa</th>
                                                        <th>Diagnosa</th>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo $bls->anamnesa ?></td>
                                                        <td><?php echo $bls->diagnosa ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Pemeriksaan</th>
                                                        <th>Program</th>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo $bls->pemeriksaan ?></td>
                                                        <td><?php echo $bls->program ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="timeline-footer">
                                                <!--<a class="btn btn-warning btn-sm">View comment</a>-->
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <!-- END timeline item -->
                            <?php } ?>
                            <div>
                                <i class="fas fa-clock bg-gray"></i>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">THREAD - <small><?php echo $sql_konsul->judul ?></small></h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="mailbox-read-info">
                                <h6>                                    
                                    <span class="mailbox-read-time float-left"><?php echo $this->ion_auth->user($sql_konsul->id_user)->row()->first_name ?></span>
                                    <span class="mailbox-read-time float-right"><small><i><?php echo $this->tanggalan->tgl_indo5($sql_konsul->tgl_simpan) ?></i></small></span>
                                </h6>
                            </div>
                            <div class="mailbox-read-message">
                                <?php echo html_entity_decode($sql_konsul->posting) ?>
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
                                                toolbar_location: 'bottom',
                                                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                                                toolbar: 'undo redo | bold italic underline | numlist bullist | charmap | removeformat',
                                                height: "250"
                                            });
<?php echo $this->session->flashdata('medcheck_toast'); ?>
                                        });
</script>