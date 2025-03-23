<?php $hasError = $this->session->flashdata('form_error'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!--<h1 class="m-0">Data Karyawan</h1>-->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('master/index.php') ?>">Master Data</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('master/data_karyawan_list.php') ?>">Karyawan</a></li>
                        <li class="breadcrumb-item active"><?php echo (isset($_GET['id']) ? 'Ubah' : 'Tambah'); ?></li>
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
                <div class="col-md-9">
                    <?php echo form_open_multipart(base_url('master/set_karyawan_simpan_sert.php'), 'autocomplete="off"') ?>
                    <?php echo form_hidden('id', general::enkrip($sql_kary->id)); ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">BERKAS SERTIFIKASI - <?php echo (!empty($sql_kary->nama_dpn) ? $sql_kary->nama_dpn . ' ' : '') . $sql_kary->nama . (!empty($sql_kary->nama_blk) ? ', ' . $sql_kary->nama_blk : ''); ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row <?php echo (!empty($hasError['instansi']) ? 'text-danger' : '') ?>">
                                        <label for="label" class="col-sm-4 col-form-label">Instansi<i class="text-danger">*</i></label>
                                        <div class="col-sm-8">
                                            <?php echo form_input(array('id' => 'instansi', 'name' => 'instansi', 'class' => 'form-control rounded-0' . (!empty($hasError['instansi']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Institusi Pendidikan ...')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row <?php echo (!empty($hasError['pt']) ? 'text-danger' : '') ?>">
                                        <label for="label" class="col-sm-4 col-form-label">Perguruan Tinggi</label>
                                        <div class="col-sm-8">
                                            <?php echo form_input(array('id' => 'pt', 'name' => 'pt', 'class' => 'form-control rounded-0' . (!empty($hasError['pt']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Perguruan Tinggi ...')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row <?php echo (!empty($hasError['keterangan']) ? 'text-danger' : '') ?>">
                                        <label for="label" class="col-sm-4 col-form-label">Kompetensi</label>
                                        <div class="col-sm-8">
                                            <?php echo form_textarea(array('id' => 'ket', 'name' => 'ket', 'class' => 'form-control rounded-0', 'style' => 'height: 183px;', 'placeholder' => 'Isikan Kompetensi Sertifikasi (Perawat/Bidan/Dokter) ...')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row <?php echo (!empty($hasError['fupload']) ? 'text-danger' : '') ?>" id="tp_berkas">
                                        <label for="label" class="col-sm-4 col-form-label">Unggah Berkas*</label>
                                        <div class="col-sm-8">
                                            <?php echo form_upload(array('name' => 'fupload', 'class' => 'form-control rounded-0' . (!empty($hasError['fupload']) ? ' is-invalid' : ''))) ?>
                                            <i>* File yang diijinkan : jpg|png|pdf|jpeg|jfif</i>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <?php echo $this->session->flashdata('master') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row <?php echo (!empty($hasError['no_dok']) ? 'text-danger' : '') ?>">
                                        <label for="label" class="col-sm-4 col-form-label">No. Dokumen<i class="text-danger">*</i></label>
                                        <div class="col-sm-8">
                                            <?php echo form_input(array('id' => '', 'name' => 'no_dok', 'class' => 'form-control rounded-0' . (!empty($hasError['no_dok']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan No. STR/SIP/SIPB ...')) ?>
                                        </div>
                                    </div>                                   
                                    <div class="form-group row">
                                        <label for="label" class="col-sm-4 col-form-label">Tgl Berlaku</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                </div>
                                                <?php echo form_input(array('id' => 'tgl_berlaku', 'name' => 'tgl_berlaku', 'class' => 'form-control rounded-0', 'placeholder' => 'Isikan Tgl Berlaku ...')) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row <?php echo (!empty($hasError['tipe']) ? 'text-danger' : '') ?>">
                                        <label for="label" class="col-sm-4 col-form-label">Tipe / Jenis<i class="text-danger">*</i></label>
                                        <div class="col-sm-8">
                                            <?php echo form_input(array('id' => '', 'name' => 'tipe', 'class' => 'form-control rounded-0' . (!empty($hasError['tipe']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Jenis Sertifikat Mis. : STR/Seminar/dll ...')) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>                         
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE) { ?>
                                        <a class="btn btn-primary btn-flat" href="<?php echo base_url('master/data_karyawan_tambah.php?id=' . $this->input->get('id')) ?>">
                                            <i class="fas fa-arrow-left"></i> Kembali
                                        </a>
                                    <?php } ?>
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

            <div class="row">
                <div class="col-md-12">                    
                    <div class="card card-default rounded-0">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-graduation-cap"></i> Berkas Riwayat Sertifikasi</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-left">No. Dokumen</th>
                                        <th class="text-left">Instansi</th>
                                        <th class="text-left">Perguruan Tinggi</th>
                                        <th class="text-left">Berkas</th>
                                        <th class="text-left">Tipe</th>
                                        <th class="text-center">#</th>
                                    </tr>                                    
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($sql_kary_sert as $sert) { ?>
                                        <?php
                                        $is_image   = substr($sert->file_type, 0, 5);
                                        $filename   = base_url('file/karyawan/' . $sert->id_karyawan . '/' . $sert->file_name);
                                        $foto       = (file_exists($filename) ? base_url('file/karyawan/' . $sert->id_karyawan . '/' . $sert->file_name) : '');
                                        ?>
                                        <tr>
                                            <td class="text-center" style="width:30px;"><?php echo $no; ?></td>
                                            <td class="text-left" style="width:160px;"><?php echo $sert->no_dok; ?></td>
                                            <td class="text-left" style="width:250px;">
                                                <?php echo $sert->instansi; ?><br/>
                                                <small><?php echo $sert->keterangan; ?></small><br/>
                                                <small><b>Berlaku :</b> <i><?php echo ($sert->tgl_masuk != '0000' ? $this->tanggalan->tgl_indo2($sert->tgl_masuk) : '') . ' - ' . ($sert->tgl_keluar != '0000' ? $this->tanggalan->tgl_indo2($sert->tgl_keluar) : ''); ?></i></small><br/>
                                            </td>
                                            <td class="text-left" style="width:400px;"><?php echo $sert->pt; ?></td>
                                            <td class="text-left" style="width:400px;">
                                                <?php if ($is_image == 'image') { ?>
                                                    <a href="<?php echo $filename ?>" data-toggle="lightbox" data-title="<?php echo strtolower($sert->judul . ' - ' . $sql_pasien->nama_pgl) ?>">
                                                        <i class="fas fa-paperclip"></i> <?php echo $sert->file_name ?>
                                                    </a>
                                                <?php } else { ?>
                                                    <a href="<?php echo $filename ?>" target="_blank">
                                                        <i class="fas fa-paperclip"></i> <?php echo $sert->file_name ?>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                            <td class="text-left" style="width:100px;"><?php echo $sert->tipe; ?></td>
                                            <td class="text-left" style="width:70px;">
                                                <?php echo anchor(base_url('master/set_karyawan_hapus_sert.php?id=' . general::enkrip($sert->id) . '&id_karyawan=' . general::enkrip($sql_kary->id) . (!empty($sert->file_name) ? '&file_name=' . $sert->file_name : '')), '<i class="fa fa-trash"></i>', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus Berkas [' . $sert->no_dok . '] ?\')"') ?>
                                            </td>
                                        </tr>
                                        <?php $no++ ?>
                                    <?php } ?>
                                </tbody>
                            </table>                            
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6 text-right">

                                </div>
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

<!--Tanggal Rentang-->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<!--<script src="<?php // echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js')        ?>"></script>-->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.css'); ?>">

<!-- Ekko Lightbox -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/ekko-lightbox/ekko-lightbox.min.js') ?>"></script>

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });

        $("input[id=thn]").keydown(function (e) {
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

        $('#tgl_berlaku').daterangepicker({
            locale: {
                format: 'MM/DD/YYYY'
            }
        });

        <?php echo $this->session->flashdata('master_toast'); ?>
    });
</script>