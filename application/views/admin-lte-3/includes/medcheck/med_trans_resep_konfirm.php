<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Medical Checkup</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('medcheck/index.php') ?>">Medical Checkup</a></li>
                        <li class="breadcrumb-item active">Farmasi</li>
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
                <div class="col-md-6"><?php // echo form_open_multipart(base_url('medcheck/set_medcheck_inform.php'), 'autocomplete="off"')            ?>
                    <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                    <?php echo form_hidden('status', $st_medrep); ?>
                    <style>
                        /* mengatur ukuran canvas tanda tangan  */
                        canvas {
                            border: 1px solid #ccc;
                            border-radius: 0.5rem;
                            width: 100%;
                            height: 250px;
                        }
                    </style>

                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">KONFIRMASI PENGAMBILAN OBAT - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
                        </div>
                        <div class="card-body">        
                            <div id="inputTTD" class="form-group row <?php echo (!empty($hasError['ttd']) ? 'text-danger' : '') ?>">
                                <label for="inputJnsKlm" class="col-sm-3 col-form-label">TTD Pasien<br/><small><i>Konfirmasi Pengambilan Obat</i></small></label>
                                <div class="col-sm-9">
                                    <canvas id="signature-pad" class="signature-pad rounded-0"></canvas>
                                </div>
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
                            <div class="form-group <?php echo (!empty($hasError['status_res']) ? 'text-danger' : '') ?>">
                                <label class="control-label">Status Resep</label>
                                <select id="status_res" name="status_res" class="form-control rounded-0 <?php echo (!empty($hasError['status_res']) ? ' is-invalid' : '') ?>">
                                    <option value="">- {Resep] -</option>
                                    <option value="1">Non Racikan</option>
                                    <option value="2">Racikan</option>
                                </select>
                            </div>
                            <div class="form-group <?php echo (!empty($hasError['petugas']) ? 'text-danger' : '') ?>">
                                <label class="control-label">Yang menyerahkan</label>
                                <select id="dokter" name="petugas" class="form-control rounded-0 select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                    <option value="">- Petugas -</option>
                                    <?php foreach ($this->ion_auth->users('farmasi')->result() as $doctor) { ?>
                                        <option value="<?php echo $doctor->id ?>"><?php echo $doctor->first_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/index.php?tipe=1&filter_bayar=' . $this->input->get('filter_bayar')) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" id="btn-submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
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

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!--Signature CDN-->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>

<!-- Page script -->
<script type="text/javascript">
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

    $(function () {
        $(document).on('click', '#btn-submit', function () {
            var signature   = signaturePad.toDataURL();
            var petugas     = $('select[name=petugas]').find(":selected").val();
            var status      = $('select[name=status_res]').find(":selected").val();

            $.ajax({
                url: "<?php echo base_url('medcheck/set_medcheck_resep_upd_ttd.php') ?>",
                data: {
                    id: "<?php echo $this->input->get('id') ?>",
                    status_res: status,
                    petugas: petugas,
                    foto: signature
                },
                method: "POST",
                success: function () {
                    toastr.success("Resep sudah dikonfirmasi dan ditanda tangani");
                    window.location.href = '<?php echo base_url('medcheck/index.php?tipe=' . $this->input->get('tipe') . '&filter_bayar=' . $this->input->get('filter_bayar')) ?>';
                }
            });
        });
    });
</script>