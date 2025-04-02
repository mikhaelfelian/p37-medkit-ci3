<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Persetujuan Umum</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('medcheck/index.php') ?>">Medical Checkup</a></li>
                        <li class="breadcrumb-item active">Persetujuan Umum</li>
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
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Persetujuan Umum</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php echo $this->session->flashdata('master'); ?>

                            <div id="inputNm" class="form-group row <?php echo (!empty($hasError['nik']) ? 'text-danger' : '') ?>">
                                <label for="inputTinggi" class="col-sm-3 col-form-label">Nomor Identitas</label>
                                <div class="col-sm-9">
                                    <?php echo form_input(array('id' => 'nik', 'name' => 'nik', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan nomor identitas / passport ...', 'value' => $sql_dft_gc->nik, 'disabled' => 'true')) ?>
                                </div>
                            </div>
                            <div id="inputNm" class="form-group row <?php echo (!empty($hasError['nama']) ? 'text-danger' : '') ?>">
                                <label for="inputTinggi" class="col-sm-3 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-9">
                                    <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Nama Penanggungjawab ...', 'value' => $sql_dft_gc->nama, 'disabled' => 'true')) ?>
                                </div>
                            </div>
                            <div id="inputNm" class="form-group row">
                                <label for="inputTinggi" class="col-sm-3 col-form-label">Hubungan</label>
                                <div class="col-sm-9">
                                    <select id="hubungan1" name="hubungan" class="form-control rounded-0" disabled>
                                        <option value="">[Hubungan dengan pasien]</option>
                                        <option value="1" <?php echo ($sql_dft_gc->status_hub == '1' ? 'selected' : '') ?>>Suami</option>
                                        <option value="2" <?php echo ($sql_dft_gc->status_hub == '2' ? 'selected' : '') ?>>Istri Orang</option>
                                        <option value="3" <?php echo ($sql_dft_gc->status_hub == '3' ? 'selected' : '') ?>>Orangtua</option>
                                        <option value="4" <?php echo ($sql_dft_gc->status_hub == '4' ? 'selected' : '') ?>>Anak</option>
                                        <option value="5" <?php echo ($sql_dft_gc->status_hub == '5' ? 'selected' : '') ?>>Keluarga</option>
                                        <option value="6" <?php echo ($sql_dft_gc->status_hub == '6' ? 'selected' : '') ?>>Kerabat</option>
                                        <option value="7" <?php echo ($sql_dft_gc->status_hub == '7' ? 'selected' : '') ?>>Diri Sendiri</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"><!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">TANDA TANGAN</h3>
                        </div>
                        <div class="card-body">        
                            <div id="inputTTD" class="form-group <?php echo (!empty($hasError['ttd']) ? 'text-danger' : '') ?>">
                                <label for="inputJnsKlm">TTD Pembuat Pernyataan</label>
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
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/daftar_gc.php?dft=' . general::enkrip($sql_dft->id)) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" id="btn-submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
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
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!--Signature CDN-->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>
<style>
    .autocomplete-scroll {
        max-height: 250px;
        overflow-y: auto;
        overflow-x: hidden;
    }
</style>
<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $("#no_hp").keydown(function (e) {
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

        $("input[id=tgl_lahir]").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            autoclose: true
        });
    });

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

    $(document).on('click', '#btn-submit', function () {
        if (signaturePad.isEmpty()) {
            toastr.error("Silakan tanda tangan terlebih dahulu");
            return;
        }

        var signature = signaturePad.toDataURL();        
        $.ajax({
            url: '<?php echo base_url('medcheck/set_gc_update'); ?>',
            type: 'POST',
            data: {
                id: "<?php echo general::enkrip($sql_dft_gc->id) ?>",
                id_dft: "<?php echo general::enkrip($sql_dft->id) ?>",
                foto: signature,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            beforeSend: function(xhr) {
                $('#btn-submit').prop('disabled', true);
                $('#btn-submit').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
                console.log('Request started');
            },
            complete: function() {
                $('#btn-submit').prop('disabled', false);
                $('#btn-submit').html('<i class="fa fa-save"></i> Simpan');
                console.log('Request completed');
            },
            success: function(response, status, xhr) {
                if (response && response.success) {
                    toastr.success(response.message || "TTD Berhasil disimpan");
                    setTimeout(function() {
                        window.location.href = '<?php echo base_url('medcheck/daftar_gc_det.php?dft=' . general::enkrip($sql_dft->id)) ?>';
                    }, 1500);
                } else {
                    toastr.error(response ? response.message : "Gagal menyimpan TTD");
                }
            },
            error: function(xhr, status, error) {                
                toastr.error("Terjadi kesalahan sistem. Silakan coba lagi.");
            }
        });
    });
</script>

<!-- Add this right after the opening <head> tag -->
<meta name="csrf-token" content="<?php echo $this->security->get_csrf_hash(); ?>">
