<?php $hasError = $this->session->flashdata('form_error'); ?>
<div class="row">
    <div class="col-md-12">                    
        <div class="card card-default rounded-0">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-history"></i> Riwayat Surat Keterangan Kerja</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-left">Tanggal</th>
                            <th class="text-left">Keperluan</th>
                            <th class="text-center">#</th>
                        </tr>                                    
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($sql_kary_srt as $peg) { ?>
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
                                <td class="text-left" style="width:100px;">    
                                    <?php echo anchor(base_url('sdm/pdf_surat_krj.php?id=' . general::enkrip($peg->id) . '&id_karyawan=' . general::enkrip($sql_kary->id) . '&route=profile.php?page=profile_peg'), '<i class="fa fa-print"></i> Cetak', 'class="btn btn-primary btn-flat btn-xs" style="width: 55px;"') ?>
                                    <?php if ($peg->status == '0') { ?>
                                        <?php // echo anchor(base_url('sdm/set_cuti_hapus.php?id=' . general::enkrip($peg->id) . (!empty($peg->file_name) ? '&file_name=' . general::enkrip($peg->file_name) : '')), '<i class="fas fa-trash"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $sql_kary->nama . '] ? \')" class="btn btn-danger btn-flat btn-xs" style="width: 55px;"') ?>
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

        // Menampilkan Tanggal
        $("#tgl_masuk").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: '<?php echo date('Y') ?>:<?php echo $yrs ?>',
            autoclose: true
        });
        $("#tgl_keluar").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: '<?php echo date('Y') ?>:<?php echo $yrs ?>',
            autoclose: true
        });

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
<?php echo $this->session->flashdata('sdm_toast'); ?>
    });
</script>