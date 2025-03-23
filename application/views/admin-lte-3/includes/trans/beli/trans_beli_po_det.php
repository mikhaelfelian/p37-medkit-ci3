<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pembelian</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('transaksi/pembelian/index.php') ?>">Pembelian</a></li>
                        <li class="breadcrumb-item active">Purchase Order</li>
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
                <?php if (!empty($sql_beli)) { ?>
                <?php $sql_po_cek = $this->db->where('id_po', $sql_beli->id)->get('tbl_trans_beli'); ?>
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-shopping-cart"></i> Data Item Pembelian</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-right">

                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                            <table class="table table-striped">
                                <tr>
                                    <th>No. Purchase Order</th>
                                    <th>:</th>
                                    <td><?php echo $sql_beli->no_nota ?></td>

                                    <th>Supplier</th>
                                    <th>:</th>
                                    <td><?php echo '['.$sql_supplier->kode.'] '.$sql_supplier->nama ?></td>
                                </tr>
                                <tr>
                                    <th>Tgl</th>
                                    <th>:</th>
                                    <td><?php echo $this->tanggalan->tgl_indo2($sql_beli->tgl_masuk) ?></td>

                                    <th></th>
                                    <th></th>
                                    <td></td>
                                </tr>
                            </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-left">Item</th>
                                                    <th class="text-center">Jml</th>
                                                    <th class="text-center">Stok</th>
                                                    <th class="text-left">Keterangan</th>
                                                </tr>                                    
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($sql_beli_det)) { ?>
                                                    <?php $no = 1 ?>
                                                    <?php foreach ($sql_beli_det as $cart) { ?>
                                                    <?php $sql_brg  = $this->db->select('jml')->where('id', $cart->id_produk)->get('tbl_m_produk')->row() ?>
                                                    <?php $sql_sat  = $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row() ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $no; ?></td>
                                                            <td class="text-left"><?php echo $cart->produk; ?></td>
                                                            <td class="text-center"><?php echo $cart->jml; ?></td>
                                                            <td class="text-center"><?php echo $sql_brg->jml.' '.$sql_sat->satuanTerkecil ?></td>
                                                            <td class="text-left"><?php echo $cart->keterangan_itm; ?></td>
                                                        </tr>
                                                        <?php $no++; ?>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <tr>
                                                        <th class="text-center" colspan="8">Tidak Ada Data</th>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">

                                    </div>
                                    <div class="col-md-6 text-right">
                                        <?php if($sql_po_cek->num_rows() == 0){ ?>
                                            <button type="button" class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo base_url('transaksi/beli/trans_beli.php?id_po='.general::enkrip($sql_beli->id).'&id_supplier='.general::enkrip($sql_beli->id_supplier)) ?>'"><i class="fa fa-shopping-cart"></i> Buat Faktur</button>
                                        <?php }else{ ?>
                                            <?php echo anchor(base_url('transaksi/trans_beli_det.php?id='.general::enkrip($sql_po_cek->row()->id)), '<i class="fas fa-eye-slash"></i> Faktur &raquo;', 'class="btn btn-flat btn-warning"') ?>
                                        <?php } ?>
                                        <!--<button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('transaksi/beli/cetak_nota_po.php?id=' . $this->input->get('id')) ?>'"><i class="fas fa-print"></i> Cetak PO</button>-->
                                        <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('transaksi/beli/cetak_nota_po_pdf.php?id=' . $this->input->get('id')) ?>'"><i class="fas fa-file-pdf"></i> Cetak PO</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        // Mengcover tanggal masuk dan tempo
        $('input[id=tgl]').datepicker({
            format: 'mm/dd/yyyy',
            autoclose: true
        });
        $('input[id=tgl_keluar]').datepicker({
            format: 'mm/dd/yyyy',
            autoclose: true
        });

        $('input[id=harga], input[id=jml], input[id=diskon]').autoNumeric({aSep: '.', aDec: ',', aPad: false});


        // Autocomplete Data Supplier
        $('#supplier').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('transaksi/beli/json_supplier.php') ?>",
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
                $itemrow.find('#id_supplier').val(ui.item.id);
                $('#id_supplier').val(ui.item.id);
                $('#supplier').val(ui.item.nama);

                // Give focus to the next input field to recieve input from user
                $('#supplier').focus();
                return false;
            }

            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.kode + "</a></br><a>" + item.nama + "</a></br><a>" + item.alamat + "<br/>--------------------------------------------------------------</a>")
                    .appendTo(ul);
        };

<?php if (!empty($sess_beli)) { ?>
            // Autocomplete Data Item
            $('#kode').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url('transaksi/beli/json_item.php') ?>",
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
                    $('#id_item').val(ui.item.id_item);
                    window.location.href = "<?php echo base_url('transaksi/beli/trans_beli.php?id=' . general::enkrip($sess_beli['no_nota'])) ?>&id_item=" + ui.item.id_item + "&harga=" + ui.item.harga_beli;

                    // Give focus to the next input field to recieve input from user
                    $('#item').focus();
                    return false;
                }

                // Format the list menu output of the autocomplete
            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<a>[" + item.kode + "] " + item.produk + "</a>")
                        .appendTo(ul);
            };
<?php } ?>
    });
</script>