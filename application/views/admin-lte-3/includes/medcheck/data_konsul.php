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
                <div class="col-md-8">
                    <div class="card card-default rounded-0">
                        <div class="card-body">
                            <?php echo form_open(base_url('medcheck/set_cari_konsul.php'), 'autocomplete="off"') ?>
                            <table class="table table-condensed">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                                <?php echo form_input(array('id' => 'cari', 'name' => 'judul', 'class' => 'form-control rounded-0', 'placeholder' => 'Isikan judul konsultasi ...', 'value' => (!empty($_GET['filter_nama']) ? $_GET['filter_tgl'] : ''))) ?>
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-default">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php echo anchor(base_url('medcheck/data_konsul_post.php'), '<i class="fa fa-pencil"></i> Buat Thread', 'class="btn btn-primary btn-flat"') ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="row">
                <div class="col-md-8">
                    <?php if (!empty($pagination)) { ?>
                        <div class="card card-default rounded-0">
                            <div class="card-header">
                                <div class="card-tools">
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
                                <h3 class="card-title"><?php echo $konsul->judul ?> - <small><i><?php echo $this->ion_auth->user($konsul->id_user)->row()->first_name ?></i></small></h3>
                                <div class="card-tools">
                                    <small><span class="time"><i class="fas fa-clock"></i> <?php echo $this->tanggalan->sejak($konsul->tgl_simpan) ?></span></small>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php echo html_entity_decode($konsul->posting) ?>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php if($this->ion_auth->user()->row()->id == $konsul->id_user){ ?>
                                            <?php // echo anchor(base_url('medcheck/data_konsul_detail.php?id=' . general::enkrip($konsul->id)), '<i class="fas fa-comments"></i>', 'class="btn btn-flat bg-yellow btn-sm" style="width: 40px;"') ?>
                                            <?php echo anchor(base_url('medcheck/set_konsul_hapus.php?id=' . general::enkrip($konsul->id)), '<i class="fas fa-trash"></i>', 'class="btn btn-flat bg-danger btn-sm" style="width: 40px;" onclick="return confirm(\'Hapus ?\')"') ?>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <?php echo anchor(base_url('medcheck/data_konsul_balas.php?id=' . general::enkrip($konsul->id)), '<i class="fas fa-reply"></i> Balas', 'class="btn btn-flat bg-green btn-sm"') ?>
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