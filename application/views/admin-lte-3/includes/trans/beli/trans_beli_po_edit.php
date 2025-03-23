<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Purchase Order</h1>
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
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Purchase Order</h3>
                            <div class="card-tools">
                                
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php $hasError = $this->session->flashdata('form_error'); ?>
                                    <?php echo form_open(base_url('transaksi/beli/set_trans_beli_po_upd.php'), 'autocomplete="off"') ?>
                                    <input type="hidden" id="id_supplier" name="id_supplier" value="<?php echo $sql->id_supplier ?>">                                  
                                    <input type="hidden" id="id" name="id" value="<?php echo general::enkrip($sql->id) ?>">                                  

                                    <div class="form-group <?php echo (!empty($hasError['id_supplier']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Nama Supplier*</label>
                                        <?php echo form_input(array('id' => 'supplier', 'name' => 'supplier', 'class' => 'form-control rounded-0 text-middle' . (!empty($hasError['id_supplier']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Isikan Nama Supplier ...', 'value'=>$sql_supplier->nama)) ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group <?php echo (!empty($hasError['tgl_beli']) ? 'text-danger' : '') ?>">
                                                <label class="control-label">Tgl PO</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                    </div>
                                                    <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl_masuk', 'class' => 'form-control rounded-0 pull-right' . (!empty($hasError['tgl_masuk']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Tgl PO ...', 'value'=>$this->tanggalan->tgl_indo($sql->tgl_masuk))) ?>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Keterangan</label>
                                        <div class="input-group mb-3">
                                            <?php echo form_input(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control rounded-0 text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Isikan Keterangan ...', 'value'=>$sql->keterangan)) ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Alamat Pengiriman</label>
                                        <div class="input-group mb-3">
                                            <?php echo form_textarea(array('id' => 'pengiriman', 'name' => 'pengiriman', 'class' => 'form-control rounded-0 text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Isikan Alamat ...', 'value'=>$sql->pengiriman)) ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-danger btn-flat" onclick="window.location.href='<?php echo base_url('transaksi/beli/set_trans_beli_po_batal.php?id='.general::enkrip($sess_beli['no_nota'])) ?>'"><i class="fa fa-remove"></i> Batal</button>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-shopping-cart"></i> Set Beli</button>
                                        </div>
                                    </div>
                                    <?php echo form_close() ?>
                                </div>
                                <div class="col-md-6">
                                    <?php if (!empty($sess_beli)) { ?>
                                        <?php echo form_open(base_url('transaksi/beli/cart_beli_po_upd.php'), 'autocomplete="off"') ?>
                                        <input type="hidden" id="id" name="id" value="<?php echo general::enkrip($sql->id) ?>">                                  
                                        <input type="hidden" id="no_nota" name="no_nota" value="<?php echo general::enkrip($sql->no_nota) ?>">                                  
                                        <input type="hidden" id="id_item" name="id_item" value="<?php echo general::enkrip($sql_item->id) ?>">                                  

                                        <div class="form-group <?php echo (!empty($hasError['id_produk']) ? 'text-danger' : '') ?>">
                                            <label class="control-label">Kode</label>
                                            <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control rounded-0 text-middle' . (!empty($hasError['id_produk']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Isikan Kode ...', 'value' => $sql_item->kode)) ?>
                                        </div>
                                        <?php if (!empty($sql_item->produk)) { ?>
                                            <div class="form-group <?php echo (!empty($hasError['id_produk']) ? 'text-danger' : '') ?>">
                                                <label class="control-label">Item</label>
                                                <?php echo form_input(array('id' => 'item', 'name' => 'item', 'class' => 'form-control rounded-0 text-middle' . (!empty($hasError['id_produk']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Isikan Produk ...', 'value' => $sql_item->produk, 'readonly' => 'TRUE')) ?>
                                            </div>
                                        <?php } ?>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group <?php echo (!empty($hasError['jml']) ? 'text-danger' : '') ?>">
                                                    <label class="control-label">Jml</label>
                                                    <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control rounded-0 pull-right' . (!empty($hasError['tgl_masuk']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Jml ...', 'value'=>'1')) ?>
                                                </div>                                            
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group <?php echo (!empty($hasError['satuan']) ? 'text-danger' : '') ?>">
                                                    <label class="control-label">Satuan</label>
                                                    <select name="satuan" class="form-control rounded-0">
                                                        <option value="">- Pilih -</option>
                                                        <?php foreach ($sql_satuan as $satuan) { ?>
                                                            <option value="<?php echo $satuan->id ?>"><?php echo strtoupper($satuan->satuanTerkecil) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>                                           
                                            </div>
                                        </div>
                                        <div class="form-group <?php // echo (!empty($hasError['id_produk']) ? 'text-danger' : '') ?>">
                                            <label class="control-label">Keterangan</label>
                                            <?php echo form_input(array('id' => 'keterangan', 'name' => 'ket', 'class' => 'form-control rounded-0 text-middle' . (!empty($hasError['ket']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Isikan keterangan ...')) ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">

                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-shopping-cart"></i> Simpan</button>
                                            </div>
                                        </div>
                                        <?php echo form_close() ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (!empty($sess_beli)) { ?>
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
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">No. Faktur</label>
                                            <div class="col-sm-8">
                                                <?php echo form_input(array('id' => '', 'name' => 'disk3', 'class' => 'form-control rounded-0 pull-right', 'value' => $sess_beli['no_nota'], 'readonly' => 'TRUE')) ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Supplier</label>
                                            <div class="col-sm-8">
                                                <?php echo form_input(array('id' => '', 'name' => 'disk3', 'class' => 'form-control rounded-0 pull-right', 'value' => $sql_supplier->nama, 'readonly' => 'TRUE')) ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Alamat</label>
                                            <div class="col-sm-8">
                                                <?php echo form_input(array('id' => '', 'name' => 'disk3', 'class' => 'form-control rounded-0 pull-right', 'value' => $sql_supplier->alamat, 'readonly' => 'TRUE')) ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Pengiriman</label>
                                            <div class="col-sm-8">
                                                <?php echo form_input(array('id' => '', 'name' => 'disk3', 'class' => 'form-control rounded-0 pull-right', 'value' => $sess_beli['pengiriman'], 'readonly' => 'TRUE')) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Tgl Faktur</label>
                                            <div class="col-sm-8">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                    </div>
                                                    <?php echo form_input(array('id' => '', 'name' => 'disk3', 'class' => 'form-control rounded-0 pull-right', 'value' => $this->tanggalan->tgl_indo2($sess_beli['tgl_masuk']), 'readonly' => 'TRUE')) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Tgl Tempo</label>
                                            <div class="col-sm-8">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                    </div>
                                                    <?php echo form_input(array('id' => '', 'name' => 'disk3', 'class' => 'form-control rounded-0 pull-right', 'value' => $this->tanggalan->tgl_indo2($sess_beli['tgl_keluar']), 'readonly' => 'TRUE')) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">No</th>
                                                    <th class="text-left">Item</th>
                                                    <th class="text-center">Jml</th>
                                                    <th class="text-center">Stok</th>
                                                    <th class="text-left">Keterangan</th>
                                                </tr>                                    
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($sql_det)) { ?>
                                                    <?php $no = 1 ?>
                                                    <?php foreach ($sql_det as $cart) { ?>
                                                    <?php $sql_brg  = $this->db->select('jml')->where('id', $cart->id_produk)->get('tbl_m_produk')->row() ?>
                                                    <?php $sql_sat  = $this->db->where('id', $sql_brg->id_satuan)->get('tbl_m_satuan')->row() ?>
                                                        <tr>
                                                            <td class="text-right" style="width: 50px;">
                                                                <?php echo anchor(base_url('transaksi/beli/cart_beli_po_upd_hapus.php?id='.general::enkrip($cart->id_pembelian).'&item_id='.general::enkrip($cart->id)), '<i class="fas fa-trash"></i>', 'class="btn btn-danger btn-sm rounded-0" onclick="return confirm(\'Hapus [' . $cart->produk . '] ?\')"') ?>
                                                            </td>
                                                            <td class="text-center"><?php echo $no; ?></td>
                                                            <td class="text-left"><?php echo $cart->produk; ?></td>
                                                            <td class="text-center"><?php echo $cart->jml; ?></td>
                                                            <td class="text-center"><?php echo $sql_brg->jml.' '.$sql_sat->satuanTerkecil ?></td>
                                                            <td class="text-left"><?php echo $cart->keterangan; ?></td>
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
                                        <?php if (!empty($sql)) { ?>
                                            <?php echo form_open(base_url('transaksi/beli/set_trans_beli_po_proses_upd.php'), 'autocomplete="off"') ?>
                                            <?php echo form_hidden('id', general::enkrip($sql->id)) ?>

                                            <button type="submit" class="btn btn-success btn-flat"><i class="fas fa-arrow-right"></i> Proses &raquo;</button>
                                            <?php echo form_close() ?>
                                        <?php } ?>
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
                    window.location.href = "<?php echo base_url('transaksi/beli/trans_beli_po_edit.php?id=' . general::enkrip($sql->id)) ?>&id_item=" + ui.item.id_item + "&harga=" + ui.item.harga_beli;

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