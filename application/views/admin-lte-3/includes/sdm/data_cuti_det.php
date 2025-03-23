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
                        <li class="breadcrumb-item active">Pengajuan Cuti</li>
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
                    <?php // echo form_open_multipart(base_url('sdm/set_cuti_update.php'), 'autocomplete="off"') ?>
                    <?php echo form_hidden('id', general::enkrip($sql_cuti->id)); ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">FORM DETAIL CUTI</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row <?php echo (!empty($hasError['nama']) ? 'text-danger' : '') ?>">
                                        <label for="label" class="col-sm-4 col-form-label">Nama Karyawan</label>
                                        <div class="col-sm-8">
                                            <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control rounded-0', 'value' => $sql_cuti->nama, 'readonly' => 'TRUE')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row <?php echo (!empty($hasError['tgl_masuk']) ? 'text-danger' : '') ?>">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Tanggal Cuti<i class="text-danger">*</i></label>
                                        <div class="col-sm-8">
                                            <?php echo form_input(array('id' => '', 'name' => 'tgl_masuk', 'class' => 'form-control rounded-0', 'value' => $this->tanggalan->tgl_indo2($sql_cuti->tgl_masuk), 'readonly' => 'TRUE')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Tanggal Masuk</label>
                                        <div class="col-sm-8">
                                            <?php echo form_input(array('id' => '', 'name' => 'tgl_keluar', 'class' => 'form-control rounded-0', 'value' => $this->tanggalan->tgl_indo2($sql_cuti->tgl_keluar), 'readonly' => 'TRUE')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="label" class="col-sm-4 col-form-label">
                                            Alasan Cuti
                                        </label>
                                        <div class="col-sm-8">
                                            <?php echo form_textarea(array('id' => 'ket', 'name' => 'ket', 'class' => 'form-control rounded-0', 'placeholder' => 'Alasan Cuti Karyawan ...', 'value' => $sql_cuti->keterangan, 'readonly' => 'TRUE')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="label" class="col-sm-4 col-form-label">
                                            Lampiran Berkas 
                                        </label>
                                        <div class="col-sm-8">
                                            <?php echo (!empty($sql_cuti->file_type) ? anchor(base_url($sql_cuti->file_name), 'Berkas Cuti', 'target="_blank"') : ''); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row <?php echo (!empty($hasError['status']) ? 'text-danger' : '') ?>">
                                        <label for="label" class="col-sm-4 col-form-label">Status<i class="text-danger">*</i></label>
                                        <div class="col-sm-8">
                                            <select id="status_prtk" name="status" class="form-control rounded-0 select2bs4 <?php echo (!empty($hasError['poli']) ? ' is-invalid' : '') ?>">
                                                <option value="">- Status -</option>
                                                <option value="1" <?php echo ($sql_cuti->status == '1' ? 'selected' : '') ?>>Setuju</option>
                                                <option value="2" <?php echo ($sql_cuti->status == '2' ? 'selected' : '') ?>>Tidak Setuju</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row <?php echo (!empty($hasError['status_prtk']) ? 'text-danger' : '') ?>">
                                        <label for="label" class="col-sm-4 col-form-label">Catatan Manajemen<i class="text-danger">*</i></label>
                                        <div class="col-sm-8">
                                            <?php echo form_textarea(array('id' => 'catatan', 'name' => 'catatan', 'class' => 'form-control rounded-0', 'placeholder' => 'Isikan Catatan dari manajemen ...', 'value' => $sql_cuti->catatan, 'rows' => '5')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row <?php echo (!empty($hasError['status_prtk']) ? 'text-danger' : '') ?>">
                                        <label for="label" class="col-sm-4 col-form-label">TTD Manajemen<i class="text-danger">*</i></label>
                                        <div class="col-sm-8">
                                            <?php if(empty($sql_cuti->ttd)){ ?>
                                                <div id="inputTTD" class="form-group <?php echo (!empty($hasError['ttd']) ? 'text-danger' : '') ?>">
                                                    <canvas id="signature-pad" class="signature-pad rounded-0"></canvas>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">              
                                                        <div style="float: right;">
                                                            <!-- tombol hapus tanda tangan  -->
                                                            <button type="button" class="btn btn-danger btn-flat" id="clear">
                                                                <span class="fas fa-eraser"></span>
                                                                Clear
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php }else{ ?>
                                                <img src="<?php echo base_url($sql_cuti->ttd) ?>">
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>                         
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-stripped">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Keperluan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($sql_cuti_list as $cti){ ?>
                                                <tr>
                                                    <td style="width: 250px;"><?php echo $this->tanggalan->tgl_indo8($cti->tgl_masuk) ?></td>
                                                    <td><?php echo $cti->keterangan ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>                         
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <a class="btn btn-primary btn-flat" href="<?php echo (isset($_GET['route']) ? base_url($this->input->get('route')) : base_url('sdm/data_cuti_list.php?id=' . $this->input->get('id'))) ?>">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <button id="btn-submit" type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php // echo form_close() ?>
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
<!--<script src="<?php // echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js')              ?>"></script>-->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.css'); ?>">

<!-- Ekko Lightbox -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/ekko-lightbox/ekko-lightbox.min.js') ?>"></script>

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!--Signature CDN-->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        // script di dalam ini akan dijalankan pertama kali saat dokumen dimuat
        document.addEventListener('DOMContentLoaded', function () {
            resizeCanvas();
        })

        //script ini berfungsi untuk menyesuaikan tanda tangan dengan ukuran canvas
        function resizeCanvas() {
            var ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            //            canvas.getContext("webgl", {preserveDrawingBuffer: true});
            canvas.getContext("2d").scale(ratio, ratio);
        }


        var canvas = document.getElementById('signature-pad');

        //warna dasar signaturepad
        var signaturePad = new SignaturePad(canvas, {
            backgroundColor: '#ffffff'
        });

        signaturePad.penColor = "rgba(0, 0, 255, 1)";

        //saat tombol clear diklik maka akan menghilangkan seluruh tanda tangan
        document.getElementById('clear').addEventListener('click', function () {
            signaturePad.clear();
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
        

        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });
        
        $(document).on('click', '#btn-submit', function () {
            /* Tanda Tangan Manajemen */
            var signature   = signaturePad.toDataURL();
            var status_prtk = $('#status_prtk').val();
            var ket         = $('#catatan').val();

            $.ajax({
                url: "<?php echo base_url('sdm/set_cuti_update.php') ?>",
                data: {
                    id: "<?php echo general::enkrip($sql_cuti->id) ?>",
                    status: status_prtk,
                    catatan: ket,
                    ttd: signature
                },
                method: "POST",
                success: function (data) {
//                    toastr.success("TTD Berhasil disimpan");
                    window.location.href='<?php echo base_url('sdm/data_cuti_det.php?id='.$this->input->get('id').'&route=sdm/data_cuti_list.php?tipe=1') ?>';
                }
            });
        });

        <?php echo $this->session->flashdata('sdm_toast'); ?>
    });
</script>