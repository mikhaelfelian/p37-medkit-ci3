<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Retur</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('gudang/index.php') ?>">Medcheck</a></li>
                        <li class="breadcrumb-item active">Retur</li>
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
                            <h3 class="card-title">Form Retur</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php echo form_open_multipart(base_url('medcheck/set_medcheck_retur.php'), 'autocomplete="off"') ?>
                                    <?php $hasError = $this->session->flashdata('form_error'); ?>
                                    <?php echo form_hidden('id', $this->input->get('id')) ?>
                                    <input type="hidden" id="id_pasien" name="id_pasien">

                                    <div class="form-group <?php echo (!empty($hasError['pasien']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Pasien</label>
                                        <?php echo form_input(array('id' => 'pasien', 'name' => 'pasien', 'class' => 'form-control text-middle', 'style' => 'vertical-align: middle;')) ?>
                                    </div>

                                    <div class="form-group <?php echo (!empty($hasError['tipe']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Tanggal</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl_masuk', 'class' => 'form-control text-middle', 'style' => 'vertical-align: middle;')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group <?php echo (!empty($hasError['tipe']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Keterangan</label>
                                        <?php echo form_textarea(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control text-middle', 'style' => 'vertical-align: middle; height: 283px;')) ?>
                                    </div>
                                    <div class="text-right">
                                        <button type="reset" class="btn btn-warning btn-flat"><i class="fa fa-undo"></i> Bersih</button>
                                        <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                    </div>
                                    <?php echo form_close() ?>
                                </div>
                                <div class="col-md-6">
                                    <?php if (!empty($sess_retur)) { ?>
                                        <?php echo form_open(base_url('medcheck/cart_retur_simpan.php'), 'autocomplete="off"') ?>
                                        <input type="hidden" id="no_nota" name="no_nota" value="<?php echo general::enkrip($sess_beli['no_nota']) ?>">                                  
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
                                                    <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control rounded-0 pull-right' . (!empty($hasError['tgl_masuk']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Jml ...', 'value' => '1')) ?>
                                                </div>                                            
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group <?php echo (!empty($hasError['satuan']) ? 'text-danger' : '') ?>">
                                                    <label class="control-label">Satuan</label>
                                                    <select name="satuan" class="form-control rounded-0">
                                                        <option value="">- Pilih -</option>
                                                        <?php foreach ($sql_satuan as $satuan) { ?>
                                                            <option value=""><?php echo strtoupper($satuan->satuanTerkecil) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>                                           
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group <?php echo (!empty($hasError['harga']) ? 'text-danger' : '') ?>">
                                                    <label class="control-label">Harga</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control rounded-0 pull-right' . (!empty($hasError['tgl_keluar']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Harga ...', 'value' => (float) $sql_item->harga_beli)) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group <?php echo (!empty($hasError['potongan']) ? 'text-danger' : '') ?>">
                                                    <label class="control-label">Potongan</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <?php echo form_input(array('id' => 'potongan', 'name' => 'potongan', 'class' => 'form-control rounded-0 pull-right' . (!empty($hasError['tgl_keluar']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Potongan ...', 'value' => '0')) ?>
                                                    </div>
                                                </div>                                                
                                            </div>
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
<!--<script src="<?php // echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js')     ?>"></script>-->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.css'); ?>">

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $("input[id=tgl]").datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        // Data Pasien
        $('#pasien').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('medcheck/json_pasien.php') ?>",
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
                $itemrow.find('#id_pasien').val(ui.item.id);
                $('#id_pasien').val(ui.item.id);
                $('#pasien').val(ui.item.nama);

                // Give focus to the next input field to recieve input from user
                $('#pasien').focus();
                return false;
            }

            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.nik + "</a> <a>(" + item.jns_klm + ")</a></br><a>" + item.nama + "</a></br><a>" + item.alamat + "<br/>--------------------------------------------------------------</a>")
                    .appendTo(ul);
        };
    });
</script>