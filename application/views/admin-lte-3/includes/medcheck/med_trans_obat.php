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
                        <li class="breadcrumb-item active">Instalasi Farmasi</li>
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
                    $hasError   = $this->session->flashdata('form_error');
                    
                    switch ($_GET['act']) {
                        default:
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_obat_index', $data);
                            break;

                        # Form Resep Detail
                        case 'res_detail':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_obat_detail', $data);
                            break;

                        # Form Input Resep
                        case 'res_input':
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_obat_input', $data);
                            break;

                        # Form Input Racikan
                        case 'res_input_rc':
                            $data['sql_produk'] = $sql_produk;
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_obat_input_rc', $data);
                            break;

                        # Form Resep Edit
                        case 'res_edit':
                            $data['sql_medc_res_dt_rw'] = $sql_medc_res_dt_rw;
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_obat_input_edit', $data);
                            break;

                        # Form Resep Pasien ttd
                        case 'res_pas_ttd':
                            $data['sql_medc_res_dt_rw'] = $sql_medc_res_dt_rw;
                            $this->load->view('admin-lte-3/includes/medcheck/med_trans_obat_input_pas_ttd', $data);
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

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!--Signature CDN-->
<!--<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>-->
<script src="https://cdn.cdnhub.io/signature_pad/1.5.3/signature_pad.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>

<!-- Page script -->
<script type="text/javascript">
<?php if ($_GET['act'] == 'res_pas_ttd') { ?>
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
                url: "<?php echo base_url('medcheck/set_medcheck_resep_upd_ttd.php') ?>",
                data: {
                    id: "<?php echo $this->input->get('id') ?>",
                    id_resep: "<?php echo $this->input->get('id_resep') ?>",
                    foto: signature
                },
                method: "POST",
                success: function () {
                    toastr.success("Resep sudah dikonfirmasi dan ditanda tangani");
                    window.location.href='<?php echo base_url('medcheck/tambah.php?id='.$this->input->get('id').'&status='.$this->input->get('status')) ?>';
                }
            });
        });
<?php } ?>

    $(function () {
        $("#1").hide().find('input').prop('disabled', true);
        $("#2").hide().find('input').prop('disabled', true);
        
        $('#status_etiket').on('change', function(){         
            var status_etiket = $(this).val();
        
            $("div.divEtiket").hide();
            $("#"+status_etiket).show().find('input').prop('disabled', false);
        });
        
        $('#kode').focus();
        $("input[id=harga]").autoNumeric({aSep: '.', aDec: ',', aPad: false});

        <?php echo $this->session->flashdata('medcheck_toast'); ?>

        // Data Item Cart
        $('#kode').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('medcheck/json_item.php?page=obat&status=4') ?>",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 4,
            select: function (event, ui) {
                var $itemrow = $(this).closest('tr');
                //Populate the input fields from the returned values
                $itemrow.find('#id_item').val(ui.item.id);
                $('#id_item').val(ui.item.id);
                $('#kode').val(ui.item.kode);
                window.location.href = "<?php echo base_url('medcheck/tambah.php?act=' . $this->input->get('act') . '&id=' . $this->input->get('id') . (isset($_GET['id_resep']) ? '&id_resep=' . $this->input->get('id_resep') : '') . '&status=' . $this->input->get('status') . (isset($_GET['item_id']) ? '&item_id=' . $this->input->get('item_id') : '') . (isset($_GET['id_item_resep']) ? '&id_item_resep=' . $this->input->get('id_item_resep') : '')) ?>&id_produk=" + ui.item.id + "&harga=" + ui.item.harga + "&satuan=" + ui.item.satuan;

                // Give focus to the next input field to recieve input from user
                $('#jml').focus();
                return false;
            }

            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.name + "</a><br/><a><i><small>" + item.alias + "</small></i></a><a><i><small> " + item.kandungan + "</small></i></a>")
                    .appendTo(ul);
        };
    });
</script>