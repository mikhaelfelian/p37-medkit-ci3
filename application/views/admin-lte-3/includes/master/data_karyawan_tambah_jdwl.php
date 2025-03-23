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
                        <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE) { ?>
                            <li class="breadcrumb-item"><a href="<?php echo base_url('master/index.php') ?>">Master Data</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo base_url('master/data_karyawan_list.php') ?>">Karyawan</a></li>
                            <li class="breadcrumb-item active">Jadwal Dokter</li>
                        <?php }else{ ?>
                            <li class="breadcrumb-item active">Jadwal Dokter</li>
                        <?php } ?>
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
                <div class="col-md-12">
                    <?php echo form_open_multipart(base_url('master/set_karyawan_simpan_jadwal.php'), 'autocomplete="off"') ?>
                    <?php echo form_hidden('id', general::enkrip($sql_kary->id)); ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">JADWAL PRAKTEK DOKTER - <?php echo (!empty($sql_kary->nama_dpn) ? $sql_kary->nama_dpn . ' ' : '') . $sql_kary->nama . (!empty($sql_kary->nama_blk) ? ', ' . $sql_kary->nama_blk : ''); ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row <?php echo (!empty($hasError['instansi']) ? 'text-danger' : '') ?>">
                                        <label for="label" class="col-sm-4 col-form-label">Poli<i class="text-danger">*</i></label>
                                        <div class="col-sm-8">
                                            <select id="poli" name="poli" class="form-control rounded-0 select2bs4 <?php echo (!empty($hasError['poli']) ? ' is-invalid' : '') ?>">
                                                <option value="">- Poli -</option>
                                                <?php foreach ($poli as $poli) { ?>
                                                    <option value="<?php echo $poli->id ?>" <?php echo (!empty($sql_dft_id->id_poli) ? ($poli->id == $sql_dft_id->id_poli ? 'selected' : '') : (($poli->id == $this->session->flashdata('poli') ? 'selected' : ''))) ?>><?php echo $poli->lokasi ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="label" class="col-sm-4 col-form-label">
                                            Hari
                                            <br/><small><i>Isikan Jam praktek</i></small>
                                            <br/><small><i>cth: 10:00-11:00</i></small>
                                        </label>
                                        <div class="col-sm-4">
                                            <?php echo form_input(array('id'=>'ck', 'name'=>'ck_hari[1]', 'class'=>'form-control rounded-0', 'placeholder' => 'Hari Senin')) ?></br>
                                            <?php echo form_input(array('id'=>'ck', 'name'=>'ck_hari[2]', 'class'=>'form-control rounded-0', 'placeholder' => 'Hari Selasa')) ?></br>
                                            <?php echo form_input(array('id'=>'ck', 'name'=>'ck_hari[3]', 'class'=>'form-control rounded-0', 'placeholder' => 'Hari Rabu')) ?></br>
                                            <?php echo form_input(array('id'=>'ck', 'name'=>'ck_hari[4]', 'class'=>'form-control rounded-0', 'placeholder' => 'Hari Kamis')) ?></br>
                                        </div>
                                        <div class="col-sm-4">
                                            <?php echo form_input(array('id'=>'ck', 'name'=>'ck_hari[5]', 'class'=>'form-control rounded-0', 'placeholder' => 'Hari Jumat')) ?></br>
                                            <?php echo form_input(array('id'=>'ck', 'name'=>'ck_hari[6]', 'class'=>'form-control rounded-0', 'placeholder' => 'Hari Sabtu')) ?></br>
                                            <?php echo form_input(array('id'=>'ck', 'name'=>'ck_hari[7]', 'class'=>'form-control rounded-0', 'placeholder' => 'Hari Minggu')) ?></br>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row <?php echo (!empty($hasError['status_prtk']) ? 'text-danger' : '') ?>">
                                        <label for="label" class="col-sm-4 col-form-label">Status Praktek<i class="text-danger">*</i></label>
                                        <div class="col-sm-8">
                                            <select id="status_prtk" name="status_prtk" class="form-control rounded-0 select2bs4 <?php echo (!empty($hasError['poli']) ? ' is-invalid' : '') ?>">
                                                <option value="">- Status Praktek -</option>
                                                <option value="0">Tidak Praktek</option>
                                                <option value="1">Praktek</option>
                                            </select>
                                        </div>
                                    </div>
<!--                                    <div class="form-group row <?php // echo (!empty($hasError['instansi']) ? 'text-danger' : '') ?>">
                                        <label for="label" class="col-sm-4 col-form-label">Jam Praktek<i class="text-danger">*</i></label>
                                        <div class="col-sm-8">
                                            <?php // echo form_input(array('name' => 'waktu_prtk', 'class' => 'form-control rounded-0', 'placeholder' => 'Isikan Jam Praktek cth : 10.00 - 12.00')) ?>
                                        </div>
                                    </div>-->
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
                            <h3 class="card-title"><i class="fas fa-graduation-cap"></i> Jadwal Praktek Dokter</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-left">Poli</th>
                                        <th class="text-center">Senin</th>
                                        <th class="text-center">Selasa</th>
                                        <th class="text-center">Rabu</th>
                                        <th class="text-center">Kamis</th>
                                        <th class="text-center">Jumat</th>
                                        <th class="text-center">Sabtu</th>
                                        <th class="text-center">Minggu</th>
                                        <th class="text-center">#</th>
                                    </tr>                                    
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($sql_kary_jdwl as $jadwal) { ?>
                                    <?php 
                                        $sql_poli = $this->db->where('id', $jadwal->id_poli)->get('tbl_m_poli')->row();
                                    ?>
                                        <tr>
                                            <td class="text-center" style="width:30px;"><?php echo $no; ?></td>
                                            <td class="text-left" style="width:200px;">
                                                <?php echo $sql_poli->lokasi; ?><br/>                                             
                                            </td>
                                            <td class="text-center" style="width:150px;"><?php echo $jadwal->hari_1; ?></td>
                                            <td class="text-center" style="width:150px;"><?php echo $jadwal->hari_2; ?></td>
                                            <td class="text-center" style="width:150px;"><?php echo $jadwal->hari_3; ?></td>
                                            <td class="text-center" style="width:150px;"><?php echo $jadwal->hari_4; ?></td>
                                            <td class="text-center" style="width:150px;"><?php echo $jadwal->hari_5; ?></td>
                                            <td class="text-center" style="width:150px;"><?php echo $jadwal->hari_6; ?></td>
                                            <td class="text-center" style="width:150px;"><?php echo $jadwal->hari_7; ?></td>
                                            <td class="text-left" style="width:70px;">
                                                <?php echo anchor(base_url('master/set_karyawan_hapus_jadwal.php?id=' . general::enkrip($jadwal->id) . '&id_karyawan=' . general::enkrip($sql_kary->id)), '<i class="fa fa-trash"></i>', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus Jadwal [' . $sql_poli->lokasi . '] ?\')"') ?>
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
<!--<script src="<?php // echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js')         ?>"></script>-->
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