<?php $hasError = $this->session->flashdata('form_error'); ?>
<div class="row">
    <div class="col-md-12">                    
        <div class="card card-default rounded-0">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-history"></i> Riwayat Surat Tugas</h3>
            </div>
            <div class="card-body">
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-left">Nama</th>
                            <th class="text-left">Keperluan</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo form_open_multipart(base_url('sdm/set_cari_tgs.php'), 'autocomplete="off"') ?>
                        <?php echo form_hidden('tipe', $this->input->get('tipe')) ?>

                        <tr>
                            <td class="text-center"></td>
                            <td></td>
                            <td>
                                <?php echo form_input(array('id' => '', 'name' => 'nama', 'class' => 'form-control rounded-0', 'placeholder' => 'Isikan Nama Karyawan ...', 'value' => (!empty($_GET['filter_nama']) ? $_GET['filter_nama'] : ''))) ?>
                            </td>
                            <td></td>
                            <td>                                            
                                <button class="btn btn-primary btn-flat">
                                    <i class="fa fa-search-plus"></i> Filter
                                </button>
                            </td>
                        </tr>
                        <?php echo form_close() ?>
                        <?php
                        if (!empty($sql_surat_tgs)) {
                            $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                            foreach ($sql_surat_tgs as $surat) {
                                ?>
                                <tr>
                                    <td class="text-center" style="width: 50px;"><?php echo $no++ ?>.</td>
                                    <td class="text-left" style="width: 100px;">
                                        <?php echo $this->tanggalan->tgl_indo2($surat->tgl_simpan) ?>
                                        <?php echo br() ?>
                                        <?php echo general::status_cuti($surat->status) ?>
                                    </td>
                                    <td class="text-left" style="width: 350px;">
                                        <b><?php echo $surat->nama ?></b>
                                        <?php echo br() ?>
                                        <small><i><?php echo $surat->alamat ?></i></small>
                                        <?php echo br() ?>
                                        <i><label class="badge badge-primary"><?php echo $surat->tipe ?></label></i>
                                    </td>
                                    <td class="text-left" style="width: 250px;"><?php echo $surat->keterangan ?></td>
                                    <td class="text-left" style="width: 150px;">
                                        <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE) { ?>
                                            <?php echo anchor(base_url('sdm/data_surat_tgs_det.php?id=' . general::enkrip($surat->id) . '&route=sdm/data_surat_tgs_list.php'), '<i class="fas fa-edit"></i> Detail', 'class="btn btn-info btn-flat btn-xs" style="width: 55px;"') ?>
                                            <?php echo nbs() ?>
                                            <?php echo anchor(base_url('sdm/pdf_surat_tgs.php?id=' . general::enkrip($surat->id) . '&id_karyawan=' . general::enkrip($surat->id_karyawan)), '<i class="fa fa-print"></i> Cetak', 'class="btn btn-primary btn-flat btn-xs" style="width: 55px;"') ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
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