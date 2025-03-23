<?php $hasError = $this->session->flashdata('form_error'); ?>
<div class="row">
    <div class="col-md-10">
        <!-- Content Wrapper. Contains page content -->        
        <?php echo form_open_multipart(base_url('sdm/set_cuti_simpan.php'), 'autocomplete="off"') ?>
        <?php echo form_hidden('id', general::enkrip($sql_kary->id)); ?>
        <?php echo form_hidden('status', '8'); ?>
        <?php echo form_hidden('route', 'profile.php?page=profile_cuti'); ?>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">PENGAJUAN CUTI - <?php echo (!empty($sql_kary->nama_dpn) ? $sql_kary->nama_dpn . ' ' : '') . $sql_kary->nama . (!empty($sql_kary->nama_blk) ? ', ' . $sql_kary->nama_blk : ''); ?></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row <?php echo (!empty($hasError['keterangan']) ? 'text-danger' : '') ?>">
                            <label for="label" class="col-sm-4 col-form-label">Keterangan</label>
                            <div class="col-sm-8">
                                <?php echo form_textarea(array('id' => 'ket', 'name' => 'ket', 'class' => 'form-control rounded-0', 'style' => 'height: 183px;', 'placeholder' => 'Isikan Alasan Cuti ...')) ?>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($hasError['tipe']) ? 'text-danger' : '') ?>">
                            <label for="label" class="col-sm-4 col-form-label">Tipe Cuti</label>
                            <div class="col-sm-8">
                                <select id="tipe" name="tipe" class="form-control rounded-0 <?php echo (!empty($hasError['tipe']) ? ' is-invalid' : '') ?>">
                                    <option value="">- Tipe -</option>
                                    <?php foreach ($sql_kat_cuti as $kat) { ?>
                                        <option value="<?php echo $kat->id ?>"><?php echo $kat->tipe ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <?php echo $this->session->flashdata('medcheck') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Tanggal Rentang</label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                    <?php echo form_input(array('id' => 'tgl_rentang', 'name' => 'tgl_rentang', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => '02/15/2022 - 02/15/2022 ...', 'value' => (isset($_GET['tgl_awal']) ? $this->tanggalan->tgl_indo2($_GET['tgl_awal']) : ''))) ?>
                                </div>
                            </div>
                        </div>
                        <!--
                        <div class="form-group row <?php // echo (!empty($hasError['tgl_masuk']) ? 'text-danger' : '') ?>">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Mulai Cuti<i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                    <?php // echo form_input(array('id' => 'tgl_masuk', 'name' => 'tgl_masuk', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['tgl_masuk']) ? ' is-invalid' : ''), 'placeholder' => 'Inputkan tanggal ...', 'value' => (!empty($sql_produk->harga_jual) ? (float) $sql_produk->harga_jual : ''), 'readonly' => 'TRUE')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row <?php // echo (!empty($hasError['tgl_keluar']) ? 'text-danger' : '') ?>">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Masuk Kerja</label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                    <?php // echo form_input(array('id' => 'tgl_keluar', 'name' => 'tgl_keluar', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['tgl_keluar']) ? ' is-invalid' : ''), 'placeholder' => 'Inputkan tanggal ...', 'value' => (!empty($sql_produk->harga_jual) ? (float) $sql_produk->harga_jual : ''), 'readonly' => 'TRUE')) ?>
                                </div>
                            </div>
                        </div>
                        -->
                        <div class="form-group row <?php echo (!empty($hasError['fupload']) ? 'text-danger' : '') ?>" id="tp_berkas">
                            <label for="label" class="col-sm-4 col-form-label">Unggah Berkas*</label>
                            <div class="col-sm-8">
                                <?php echo form_upload(array('name' => 'fupload', 'class' => 'form-control rounded-0' . (!empty($hasError['fupload']) ? ' is-invalid' : ''))) ?>
                                <i><small>* File yang diijinkan : jpg|png|pdf|jpeg</small></i><br/>
                                <i><small>* Bisa di unggah foto surat dokter, undangan, dll</small></i>
                            </div>
                        </div>
                    </div>
                </div>                         
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-6">

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
                <h3 class="card-title"><i class="fas fa-history"></i> Riwayat Pengajuan Cuti</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-left">Tgl Pengajuan</th>
                            <th class="text-left">Alasan Cuti</th>
                            <th class="text-center">Mulai Cuti</th>
                            <th class="text-center">Selesai Cuti</th>
                            <th class="text-center">#</th>
                        </tr>                                    
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($sql_kary_cuti as $peg) { ?>
                            <?php $sql_jab = $this->db->where('id', $peg->id_jabatan)->get('tbl_m_jabatan')->row(); ?>
                            <?php $sql_dep = $this->db->where('id', $peg->id_dept)->get('tbl_m_departemen')->row(); ?>
                            <?php $sql_tp = $this->db->where('id', $peg->tipe)->get('tbl_m_karyawan_tipe')->row(); ?>
                            <?php $filename = base_url($peg->file_name); ?>
                            <?php $is_image = substr($peg->file_type, 0, 5); ?>
                            <tr>
                                <td class="text-center" style="width:30px;"><?php echo $no; ?></td>
                                <td class="text-left" style="width:100px;">
                                    <?php echo ($peg->tgl_simpan != '0000-00-00 00:00:00' ? $this->tanggalan->tgl_indo5($peg->tgl_simpan) : ''); ?>
                                    <?php echo br() ?>
                                    <?php echo general::status_cuti($peg->status) ?>
                                </td>
                                <td class="text-left" style="width:250px;">
                                    <?php echo $peg->keterangan; ?>
                                    <?php echo br() ?>
                                    <i><label class="badge badge-primary"><?php echo $peg->tipe ?></label></i>
                                    <?php if (!empty($peg->file_name)) { ?>
                                        <?php echo br(); ?>
                                        <?php if ($is_image == 'image') { ?>
                                            <a href="<?php echo $filename ?>" data-toggle="lightbox" data-title="<?php echo strtolower($peg->keterangan) ?>">
                                                <i class="fas fa-paperclip"></i> Lampiran
                                            </a>
                                        <?php } else { ?>
                                            <a href="<?php echo $filename ?>" target="_blank">
                                                <i class="fas fa-paperclip"></i> Lampiran
                                            </a>
                                        <?php } ?>
                                    <?php } ?>
                                </td>
                                <td class="text-center" style="width:50px;"><?php echo ($peg->tgl_masuk != '0000' ? $this->tanggalan->tgl_indo2($peg->tgl_masuk) : ''); ?></td>
                                <td class="text-center" style="width:50px;"><?php echo ($peg->tgl_keluar != '0000' ? $this->tanggalan->tgl_indo2($peg->tgl_keluar) : ''); ?></td>
                                <td class="text-left" style="width:100px;">    
                                    <?php echo anchor(base_url('sdm/pdf_cuti.php?id=' . general::enkrip($peg->id) . '&id_karyawan=' . general::enkrip($sql_kary->id) . '&route=profile.php?page=profile_peg'), '<i class="fa fa-print"></i> Cetak', 'class="btn btn-primary btn-flat btn-xs" style="width: 55px;"') ?><br/>
                                    <?php if ($peg->status == '0') { ?>
                                        <?php echo anchor(base_url('sdm/set_cuti_hapus.php?id=' . general::enkrip($peg->id) . (!empty($peg->file_name) ? '&file_name=' . general::enkrip($peg->file_name) : '')), '<i class="fas fa-trash"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $sql_kary->nama . '] ? \')" class="btn btn-danger btn-flat btn-xs" style="width: 55px;"') ?>
                                    <?php }else{ ?>
                                        <?php echo anchor(base_url('sdm/pdf_cuti_bls.php?id=' . general::enkrip($peg->id) . '&id_karyawan=' . general::enkrip($sql_kary->id) . '&route=profile.php?page=profile_peg'), '<i class="fa fa-print"></i> Balas', 'class="btn btn-success btn-flat btn-xs" style="width: 55px;"') ?>
                                    <?php } ?>
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

<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!--Tanggal Rentang-->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<!--<script src="<?php // echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js')     ?>"></script>-->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.css'); ?>">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!-- Ekko Lightbox -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/ekko-lightbox/ekko-lightbox.min.js') ?>"></script>

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<?php $yrs = date('Y') + 10 ?>
<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });

//        // Menampilkan Tanggal
//        $("#tgl_masuk").datepicker({
//            dateFormat: 'dd-mm-yy',
//            changeMonth: true,
//            changeYear: true,
//            yearRange: '<?php // echo date('Y') ?>:<?php // echo $yrs ?>',
//            autoclose: true
//        });
//        $("#tgl_keluar").datepicker({
//            dateFormat: 'dd-mm-yy',
//            changeMonth: true,
//            changeYear: true,
//            yearRange: '<?php // echo date('Y') ?>:<?php // echo $yrs ?>',
//            autoclose: true
//        });

        $('#tgl_rentang').daterangepicker({
            locale: {
                format: 'MM/DD/YYYY'
            }
        });

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
<?php echo $this->session->flashdata('sdm_toast'); ?>
    });
</script>