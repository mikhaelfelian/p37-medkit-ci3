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
                        <li class="breadcrumb-item active">Tindakan</li>
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
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                                    <div class="row">
                                        <div class="col-12">
                                            <?php $this->load->view('admin-lte-3/includes/medcheck/med_tindakan_aksi') ?>
                                            <hr/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>Detail Item</h4>
                                            <!--<div class="post">-->
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-left">Tgl</th>
                                                        <th class="text-left">Item</th>
                                                        <th class="text-center">Jml</th>
                                                        <th class="text-right">Harga</th>
                                                        <th class="text-right">Subtotal</th>
                                                    </tr>                                    
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    $gtotal = 0 ?>
                                                    <?php foreach ($sql_medc_det as $det) { ?>
                                                        <?php $sql_kat = $this->db->where('id', $det->id_item_kat)->get('tbl_m_kategori')->row(); ?>
    <?php $sql_det = $this->db->where('id_medcheck', $det->id_medcheck)->where('id_item_kat', $det->id_item_kat)->get('tbl_trans_medcheck_det')->result(); ?>
                                                        <tr>
                                                            <td class="text-left text-bold" colspan="6"><i><?php echo $sql_kat->keterangan . ' (' . $sql_kat->kategori . ')'; ?></i></td>
                                                        </tr>
                                                        <?php $sub = 0; ?>
                                                        <?php foreach ($sql_det as $medc) { ?>                                                
                                                            <?php $sub = $sub + $medc->subtotal ?>
        <?php // $sql_doc = $this->db->where('id', $medc->id_dokter)->get('tbl_m_sales')->row();  ?>
                                                            <tr>
                                                                <td class="text-center"><?php echo $no . '.'; ?></td>
                                                                <td class="text-left"><?php echo $this->tanggalan->tgl_indo5($medc->tgl_simpan); ?></td>
                                                                <td class="text-left"><?php echo $medc->item; ?></td>
                                                                <td class="text-center"><?php echo (float) $medc->jml; ?></td>
                                                                <td class="text-right"><?php echo general::format_angka($medc->harga); ?></td>
                                                                <td class="text-right"><?php echo general::format_angka($medc->subtotal); ?></td>
                                                            </tr>
                                                            <?php $no++ ?>
    <?php } ?>
                                                        <tr>
                                                            <td class="text-right text-bold" colspan="5">Subtotal</td>
                                                            <td class="text-right text-bold" colspan="5"><?php echo general::format_angka($sub); ?></td>
                                                        </tr>

                                                        <?php $gtotal = $gtotal + $sub ?>
<?php } ?>
                                                    <tr>
                                                        <td class="text-right text-bold" colspan="5">Grand Total</td>
                                                        <td class="text-right text-bold" colspan="5"><?php echo general::format_angka($gtotal); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <!--</div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-lg-4">
                    <?php $data['gtotal'] = $gtotal ?>
                    <?php $this->load->view('admin-lte-3/includes/medcheck/med_tindakan_kanan', $data) ?>
                    <?php $this->load->view('admin-lte-3/includes/medcheck/med_tindakan_kanan_print', $data) ?>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $("#harga").autoNumeric({aSep: '.', aDec: ',', aPad: false});

        // Data Item Cart
        $('#kode').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('medcheck/json_item.php?status=0') ?>",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 1,
            select: function (event, ui) {
                var $itemrow = $(this).closest('tr');
                //Populate the input fields from the returned values
                $itemrow.find('#id_item').val(ui.item.id);
                $('#id_item').val(ui.item.id);
                $('#kode').val(ui.item.kode);
                window.location.href = "<?php echo base_url('medcheck/tambah.php?id=' . $this->input->get('id') . '&status=' . $this->input->get('status')) ?>&id_produk=" + ui.item.id + "&harga=" + ui.item.harga;

                // Give focus to the next input field to recieve input from user
                $('#jml').focus();
                return false;
            }

            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.name + "</a>")
                    .appendTo(ul);
        };

<?php if (!empty($sql_produk)) { ?>
            // Cari Data Dokter
            $('#dokter').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url('medcheck/json_dokter.php') ?>",
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                minLength: 1,
                select: function (event, ui) {
                    var $itemrow = $(this).closest('tr');
                    //Populate the input fields from the returned values
                    $itemrow.find('#id_dokter').val(ui.item.id);
                    $('#id_dokter').val(ui.item.id);
                    $('#dokter').val(ui.item.nama);
                    //                window.location.href = "<?php echo base_url('medcheck/tambah.php?id=' . $this->input->get('id') . '&status=' . $this->input->get('status')) ?>";

                    // Give focus to the next input field to recieve input from user
                    $('#dokter').focus();
                    return false;
                }

                // Format the list menu output of the autocomplete
            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<a>" + item.nama + "</a>")
                        .appendTo(ul);
            };
<?php } ?>
    });
</script>