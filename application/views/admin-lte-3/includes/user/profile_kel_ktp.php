<?php $hasError = $this->session->flashdata('form_error'); ?>
<div class="row">
    <div class="col-md-10">
        <?php // echo form_open_multipart(base_url('master/set_karyawan_'.(!empty($sql_kary_kel_rw) ? 'update' : 'simpan').'_kel.php'), 'autocomplete="off"') ?>
        <?php echo form_open_multipart(base_url('master/set_karyawan_simpan_kel_ktp.php'), 'autocomplete="off"') ?>
        <?php echo form_hidden('id', general::enkrip($sql_kary->id)); ?>
        <?php echo form_hidden('id_kel', general::enkrip($sql_kary_kel_rw->id)); ?>
        <?php echo form_hidden('status', '8'); ?>
        <?php echo form_hidden('route', 'profile.php?page=profile_kel'); ?>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">DATA KELUARGA - <?php echo (!empty($sql_kary->nama_dpn) ? $sql_kary->nama_dpn . ' ' : '') . $sql_kary->nama . (!empty($sql_kary->nama_blk) ? ', ' . $sql_kary->nama_blk : ''); ?></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row <?php echo (!empty($hasError['fupload_ktp']) ? 'text-danger' : '') ?>" id="tp_berkas">
                            <label for="label" class="col-sm-4 col-form-label">Unggah Berkas KTP*</label>
                            <div class="col-sm-8 text-left">
                                <?php echo form_upload(array('name' => 'fupload', 'class' => 'form-control rounded-0' . (!empty($hasError['fupload']) ? ' is-invalid' : ''))) ?><?php echo br() ?>
                                <i>* File yang diijinkan : jpg|png|pdf|jpeg|jfif</i><?php echo br() ?>
                                <i>* Dokumen yg diunggah : KTP</i><?php echo br() ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>                        
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-6">
                        <a class="btn btn-primary btn-flat" href="<?php echo base_url('profile.php?page=profile_kel&id=' . $this->input->get('id') . '&route=' . $this->input->get('route')) ?>">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
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

<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

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