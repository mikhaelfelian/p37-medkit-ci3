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
                        <li class="breadcrumb-item active">Administrasi</li>
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
                <div class="col-lg-8">
                    <?php
                    switch ($_GET['act']) {
                        default:
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_inform_index', $data);
                            break;

                        # Inform Detail
                        case 'inf_detail':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_inform_detail', $data);
                            break;

                        # Inform TTD
                        case 'inf_ttd':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_inform_ttd', $data);
                            break;

                        # Inform Ubah Form
                        case 'inf_ubah':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_inform_ubah', $data);
                            break;
                    }
                    ?>
                </div>
                <div class="col-lg-4">
                    <?php $data['gtotal'] = $gtotal ?>
                    <?php $this->load->view('admin-lte-3/includes/medcheck/med_tindakan_kanan', $data) ?>
                </div>
            </div>
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

<!--Signature CDN-->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
<?php if ($_GET['act'] == 'inf_ttd') { ?>
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
            var signature = signaturePad.toDataURL();

            $.ajax({
                url: "<?php echo base_url('medcheck/set_medcheck_inform_upd_ttd.php') ?>",
                data: {
                    id: "<?php echo $this->input->get('id') ?>",
                    id_form: "<?php echo $this->input->get('id_form') ?>",
                    foto: signature
                },
                method: "POST",
                success: function () {
                    toastr.success("TTD Berhasil disimpan");
                    window.location.href='<?php echo base_url('medcheck/tambah.php?id='.$this->input->get('id').'&status='.$this->input->get('status')) ?>';
                }
            });
        });
<?php } ?>

    $(document).ready(function () {
        <?php if(!isset($_GET['act'])){ ?>
            $("#1").hide().find('input').prop('disabled', true);
            $("#2").hide().find('input').prop('disabled', true);
            $("select[name=dokter]").prop('disabled', true);
//            $("input[name=dokter]").hide().find('select').prop('disabled', true);
            $("input[name=nama]").prop('disabled', true);
            $("input[name=tgl_lahir]").prop('disabled', true);
            $("select[name=jns_klm]").prop('disabled', true);
            $("select[name=hubungan]").prop('disabled', true);
        <?php }  ?>
        // Select2   
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $('input[name=tgl_masuk]').datepicker({
            dateFormat: 'dd-mm-yy',
            autoclose: true
        });
        
        $("input[name=tgl_lahir]").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: '1920:<?php echo date('Y') ?>',
            autoclose: true
        });

        <?php if(!isset($_GET['act'])){ ?>
            $('#tipe_surat').on('change', function () {
                var tipe_surat = $(this).val();

                $("div.divSurat").hide();
                $("#" + tipe_surat).show().find('input').prop('disabled', false);
//                $("#dokter" + tipe_surat).show().find('select').prop('disabled', false);
                $("#dokter" + tipe_surat).prop('disabled', false);
                $("#nama" + tipe_surat).show().find('input').prop('disabled', false);
                $("#jns_klm" + tipe_surat).prop('disabled', false);
                $("#hubungan" + tipe_surat).prop('disabled', false);
                $("#tgl_lahir" + tipe_surat).prop('disabled', false);
            });
        <?php } ?>
    });
</script>