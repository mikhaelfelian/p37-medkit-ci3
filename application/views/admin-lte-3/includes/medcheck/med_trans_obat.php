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

<?php if ($_GET['act'] == 'res_pas_ttd') { ?>
    <!--Signature CDN-->
    <!--<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>-->
    <script src="https://cdn.cdnhub.io/signature_pad/1.5.3/signature_pad.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<?php } ?>

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

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
            
            // Get CSRF token
            var csrfName = $('input[name="csrf_test_name"]').attr('name');
            var csrfHash = $('input[name="csrf_test_name"]').val();
            var medkitTokens = $('input[name="medkit_tokens"]').val();

            // Prepare the data
            var postData = {
                [csrfName]: csrfHash,
                medkit_tokens: medkitTokens,
                id: "<?php echo $this->input->get('id') ?>",
                id_resep: "<?php echo $this->input->get('id_resep') ?>",
                foto: signature
            };

            $.ajax({
                url: "<?php echo base_url('medcheck/set_medcheck_resep_upd_ttd.php') ?>",
                type: "POST",
                data: postData,
                dataType: 'json',
                beforeSend: function() {
                    $('#btn-submit').prop('disabled', true).html(
                        '<i class="fas fa-spinner fa-spin"></i> Memproses...'
                    );
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success("Resep sudah dikonfirmasi dan ditanda tangani");
                        setTimeout(function() {
                            window.location.href = '<?php echo base_url('medcheck/tambah.php?id='.$this->input->get('id').'&status='.$this->input->get('status')) ?>';
                        }, 1500);
                    } else {
                        toastr.error(response.message || "Terjadi kesalahan");
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error("Terjadi kesalahan: " + error);
                    console.error("Error details:", {
                        status: status,
                        error: error,
                        response: xhr.responseText
                    });
                },
                complete: function() {
                    $('#btn-submit').prop('disabled', false).html(
                        '<i class="fa fa-save"></i> Simpan'
                    );
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

        // Initialize select2bs4
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        // Initialize select2 for kode field
        $('#kode').select2({
            theme: 'bootstrap4',
            placeholder: 'Cari Item ...',
            minimumInputLength: 3,
            dropdownCssClass: 'select2-dropdown-bootstrap4 rounded-0',
            containerCssClass: 'select2-container-bootstrap4 rounded-0',
            ajax: {
                url: "<?php echo base_url('medcheck/json_item.php?page=obat&status=4') ?>",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            // Only include items with quantity greater than 0
                            if (parseFloat(item.jml) > 0) {
                                return {
                                    id: item.kode,
                                    text: item.name,
                                    item: item
                                };
                            }
                            return null;
                        }).filter(function(item) {
                            return item !== null;
                        })
                    };
                },
                cache: true
            },
            templateResult: formatItem,
            templateSelection: function (data) {
                return data.text || data.id;
            }
        }).on('select2:select', function (e) {
            var data = e.params.data.item;
            
            $('#id_item').val(data.id);
            $('#kode').val(data.kode);
            
            window.location.href = "<?php echo base_url('medcheck/tambah.php?act=' . $this->input->get('act') . '&id=' . $this->input->get('id') . (isset($_GET['id_resep']) ? '&id_resep=' . $this->input->get('id_resep') : '') . '&status=' . $this->input->get('status') . (isset($_GET['item_id']) ? '&item_id=' . $this->input->get('item_id') : '') . (isset($_GET['id_item_resep']) ? '&id_item_resep=' . $this->input->get('id_item_resep') : '')) ?>&id_produk=" + data.id + "&harga=" + data.harga + "&satuan=" + data.satuan;
            
            // Give focus to the next input field
            $('#jml').focus();
            return false;
        });
        
        // Format the dropdown items
        function formatItem(item) {
            if (!item.item) return item.text;
            
            var $result = $('<div class="select2-result-item">' +
                '<div class="select2-result-item__title">' + item.item.name + ' (' + item.item.jml + ')</div>' +
                '<div class="select2-result-item__description"><small><i>' + item.item.alias + '</i></small></div>' +
                '<div class="select2-result-item__description"><small><i>' + item.item.kandungan + '</i></small></div>' +
                '</div>');
                
            return $result;
        }
    });
</script>