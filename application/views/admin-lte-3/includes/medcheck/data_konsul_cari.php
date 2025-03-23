<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cari Data Pasien</h1>
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
                <div class="col-md-8">
                    <?php echo form_open(base_url('medcheck/set_cari_medcheck_kons.php'), 'autocomplete="off"') ?>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="input-group">
                                        <?php echo form_input(array('id' => 'cari', 'name' => 'pasien', 'class' => 'form-control rounded-0', 'placeholder' => 'Isikan nama pasien untuk melakukan pencarian ...', 'value' => (!empty($_GET['filter_nama']) ? $_GET['filter_tgl'] : ''))) ?>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php echo form_open(base_url('medcheck/daftar_' . (isset($_GET['dft']) ? 'update' : 'simpan') . '.php'), 'autocomplete="off"') ?>
                </div>                
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-info"></i> Perhatian!</h5>
                        Silahkan memilih data pemeriksaan terlebih dahulu untuk membuka thread diskusi dengan dokter lain.<br/>
                        Tulis nama pasien pada kolom pencarian, kemudian silahkan klik pilih.
                    </div>
                </div>
                <div class="col-md-8">
                    <?php if(!empty($pagination)){ ?>
                    <div class="card card-default rounded-0">
                        <div class="card-header">
                            <div class="card-tools">
                                <?php if (!empty($_GET['jml'])) { ?>
                                    <small><b><?php echo $this->input->get('jml') ?></b> data ditemukan !!<?php echo nbs(2) ?></small>
                                <?php } ?>
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php foreach ($sql_konsul as $konsul) { ?>
                        <div class="card card-default rounded-0">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo $konsul->pasien ?> - <small><i><?php echo $this->tanggalan->usia_lkp($konsul->tgl_lahir) ?></i></small></h3>
                                <div class="card-tools">
                                    <small><span class="time"><?php echo $this->tanggalan->tgl_indo5($konsul->tgl_simpan) ?></span></small>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <table class="table table-responsive">
                                            <tr>
                                                <th style="width: 100px;">No. TRX</th>
                                                <th style="width: 10px;">:</th>
                                                <td><?php echo $konsul->no_rm ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 100px;">Keluhan</th>
                                                <th style="width: 10px;">:</th>
                                                <td><?php echo $konsul->keluhan ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 100px;">Diagnosa</th>
                                                <th style="width: 10px;">:</th>
                                                <td><?php echo $konsul->diagnosa ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 100px;">Dokter</th>
                                                <th style="width: 10px;">:</th>
                                                <td><?php echo $this->ion_auth->user($konsul->id_dokter)->row()->first_name ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card-body box-profile">
                                            <div class="text-center">
                                                <?php
                                                $file = (!empty($konsul->file_name) ? realpath($konsul->file_name) : '');
                                                $foto = (file_exists($file) ? base_url($konsul->file_name) : $konsul->file_base64);
                                                ?>
                                                <img class="profile-user-img img-fluid img-circle" src="<?php echo (!empty($foto) ? $foto : base_url('assets/theme/admin-lte-3/icon_putra.png')) ?>" alt="User profile picture" style="width: 100px; height: 100px;">
                                            </div>
                                            <p class="text-muted text-center">
                                                <?php echo $this->tanggalan->tgl_indo2($konsul->tgl_lahir) ?>
                                                <?php echo br() ?>
                                                <?php echo general::jns_klm($konsul->jns_klm) ?>
                                                <?php echo br() ?>
                                                <?php echo strtoupper($konsul->kode_dpn . $konsul->kode) ?>
                                            </p>
                                        </div>                                       
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">

                                    </div>
                                    <div class="col-md-6 text-right">
                                        <?php echo anchor(base_url('medcheck/data_konsul_post.php?id=' . general::enkrip($konsul->id) . '&pasien=' . $konsul->pasien), '<i class="fas fa-check"></i> Pilih', 'class="btn btn-flat bg-green btn-sm"') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function () {
<?php echo $this->session->flashdata('medcheck_toast'); ?>
    });
</script>