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
                    <?php echo form_open_multipart(base_url('master/set_karyawan_simpan_peg.php'), 'autocomplete="off"') ?>
                    <?php echo form_hidden('id', general::enkrip($sql_kary->id)); ?>
                    <?php echo form_hidden('status', '8'); ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">BERKAS KEPEGAWAIAN - <?php echo (!empty($sql_kary->nama_dpn) ? $sql_kary->nama_dpn . ' ' : '') . $sql_kary->nama . (!empty($sql_kary->nama_blk) ? ', ' . $sql_kary->nama_blk : ''); ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                                        <label for="label" class="col-sm-4 col-form-label">ID Karyawan <i class="text-danger">*</i></label>
                                        <div class="col-sm-8">
                                            <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control rounded-0' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan No. Induk Pegawai ...')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row <?php echo (!empty($hasError['divisi']) ? 'text-danger' : '') ?>">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Divisi <i class="text-danger">*</i></label>
                                        <div class="col-sm-8">                                    
                                            <select id="divisi" name="divisi" class="form-control rounded-0 select2bs4 <?php echo (!empty($hasError['divisi']) ? 'is-invalid' : '') ?>">
                                                <option value="">- Pilih -</option>
                                                <?php foreach ($sql_dep as $dep) { ?>
                                                    <option value="<?php echo $dep->id ?>"><?php echo $dep->dept ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row <?php echo (!empty($hasError['jabatan']) ? 'text-danger' : '') ?>">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Jabatan <i class="text-danger">*</i></label>
                                        <div class="col-sm-8">                                    
                                            <select id="jabatan" name="jabatan" class="form-control rounded-0 select2bs4 <?php echo (!empty($hasError['jabatan']) ? 'is-invalid' : '') ?>">
                                                <option value="">- Pilih -</option>
                                                <?php foreach ($sql_jab as $jab) { ?>
                                                    <option value="<?php echo $jab->id ?>"><?php echo $jab->jabatan ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row <?php echo (!empty($hasError['tipe']) ? 'text-danger' : '') ?>">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Status <i class="text-danger">*</i></label>
                                        <div class="col-sm-8">                                    
                                            <select id="tipe" name="tipe" class="form-control rounded-0 <?php echo (!empty($hasError['tipe']) ? 'is-invalid' : '') ?>">
                                                <option value="">- Pilih -</option>
                                                <?php foreach ($sql_kary_tipe as $tipe) { ?>
                                                    <option value="<?php echo $tipe->id ?>"><?php echo $tipe->tipe ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row <?php echo (!empty($hasError['keterangan']) ? 'text-danger' : '') ?>">
                                        <label for="label" class="col-sm-4 col-form-label">Keterangan</label>
                                        <div class="col-sm-8">
                                            <?php echo form_textarea(array('id' => 'ket', 'name' => 'ket', 'class' => 'form-control rounded-0', 'style' => 'height: 183px;', 'placeholder' => 'Isikan Keterangan ...')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <?php echo $this->session->flashdata('medcheck') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group row <?php echo (!empty($hasError['tgl_masuk']) ? 'text-danger' : '') ?>">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Tanggal Masuk<i class="text-danger">*</i></label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                </div>
                                                <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl_masuk', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['tgl_masuk']) ? ' is-invalid' : ''), 'placeholder' => 'Inputkan tanggal ...', 'value' => (!empty($sql_produk->harga_jual) ? (float) $sql_produk->harga_jual : ''), 'readonly' => 'TRUE')) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row <?php echo (!empty($hasError['tgl_keluar']) ? 'text-danger' : '') ?>">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Tanggal Selesai</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                </div>
                                                <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl_keluar', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['tgl_keluar']) ? ' is-invalid' : ''), 'placeholder' => 'Inputkan tanggal ...', 'value' => (!empty($sql_produk->harga_jual) ? (float) $sql_produk->harga_jual : ''), 'readonly' => 'TRUE')) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row <?php echo (!empty($hasError['no_bpjs_ks']) ? 'text-danger' : '') ?>">
                                        <label for="label" class="col-sm-4 col-form-label">No. BPJS</label>
                                        <div class="col-sm-8">
                                            <?php echo form_input(array('id' => 'no_bpjs_ks', 'name' => 'no_bpjs_ks', 'class' => 'form-control rounded-0' . (!empty($hasError['nik']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan No. BPJS Kes ...')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row <?php echo (!empty($hasError['no_bpjs']) ? 'text-danger' : '') ?>">
                                        <label for="label" class="col-sm-4 col-form-label">No. BPJS TK</label>
                                        <div class="col-sm-8">
                                            <?php echo form_input(array('id' => 'no_bpjs_tk', 'name' => 'no_bpjs_tk', 'class' => 'form-control rounded-0' . (!empty($hasError['nik']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan No. BPJS TK ...')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row <?php echo (!empty($hasError['no_bpjs']) ? 'text-danger' : '') ?>">
                                        <label for="label" class="col-sm-4 col-form-label">Status PTPKP</label>
                                        <div class="col-sm-8">
                                            <?php echo form_input(array('id' => 'no_ptkp', 'name' => 'no_ptkp', 'class' => 'form-control rounded-0' . (!empty($hasError['nik']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Status PTKP ...')) ?>
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
                            <h3 class="card-title"><i class="fas fa-boxes-stacked"></i> Data Kepegawaian</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-left">ID Karyawan</th>
                                        <th class="text-left">Divisi</th>
                                        <th class="text-left">Jabatan</th>
                                        <th class="text-left">Status PTKP</th>
                                        <th class="text-left">Status Kary</th>
                                        <th class="text-center">#</th>
                                    </tr>                                    
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($sql_kary_peg as $peg) { ?>
                                    <?php $sql_jab = $this->db->where('id', $peg->id_jabatan)->get('tbl_m_jabatan')->row(); ?>
                                    <?php $sql_dep = $this->db->where('id', $peg->id_dept)->get('tbl_m_departemen')->row(); ?>
                                    <?php $sql_tp  = $this->db->where('id', $peg->tipe)->get('tbl_m_karyawan_tipe')->row(); ?>
                                        <tr>
                                            <td class="text-center" style="width:30px;"><?php echo $no; ?></td>
                                            <td class="text-left" style="width:160px;"><?php echo $peg->kode; ?></td>
                                            <td class="text-left" style="width:250px;">
                                                <?php echo $sql_dep->dept; ?><br/>
                                                <small><?php echo $peg->keterangan; ?></small><br/>
                                                <small><b>Tgl Join :</b> <i><?php echo ($peg->tgl_masuk != '0000' ? $this->tanggalan->tgl_indo2($peg->tgl_masuk) : ''); ?></i></small><br/>
                                                <small><b>Tgl Keluar :</b> <i><?php echo ($peg->tgl_keluar != '0000' ? $this->tanggalan->tgl_indo2($peg->tgl_keluar) : ''); ?></i></small><br/>
                                            </td>
                                            <td class="text-left"><?php echo $sql_jab->jabatan; ?></td>
                                            <td class="text-left"><?php echo $peg->no_ptkp; ?></td>
                                            <td class="text-left"><?php echo $sql_tp->tipe; ?></td>
                                            <td class="text-left" style="width:70px;">
                                                <?php // echo anchor(base_url('master/set_karyawan_hapus_sert.php?id=' . general::enkrip($peg->id) . '&id_karyawan=' . general::enkrip($sql_kary->id) . (!empty($peg->file_name) ? '&file_name=' . $peg->file_name : '')), '<i class="fa fa-trash"></i>', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus Berkas [' . $peg->no_dok . '] ?\')"') ?>
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

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        // Menampilkan Tanggal
        $("[id*='tgl']").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: '1920:<?php echo date('Y') ?>',
            autoclose: true
        });

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

<?php echo $this->session->flashdata('master_toast'); ?>
    });
</script>