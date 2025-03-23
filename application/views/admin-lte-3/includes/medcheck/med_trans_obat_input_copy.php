<!-- Default box -->
<?php echo form_open_multipart(base_url('medcheck/set_medcheck_resep_copy.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_resep', $this->input->get('id_resep')); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>
<?php echo form_hidden('act', $this->input->get('act')); ?>
<input type="hidden" id="id_medc" name="id_medc">

<div class="card">
    <div class="card-header">
        <h3 class="card-title">INSTALASI FARMASI - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <?php $hasError = $this->session->flashdata('form_error'); ?>

                <div class="form-group row <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Pasien</label>
                    <div class="col-sm-10">
                        <?php echo form_input(array('id' => 'pasien', 'name' => 'pasien', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Nomor Kunjungan / ID Transaksi / Nama Pasien ...', 'value' => $sql_medc_cp->pasien)) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=4') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">
                <?php // if (!empty($sql_produk)) { ?>
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-save"></i> Copy</button>
                <?php // } ?>
            </div>
        </div>                            
    </div>
</div>
<?php echo form_close(); ?>
<!-- /.card -->
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        // Data Item Cart
        $('#pasien').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('medcheck/json_medcheck.php') ?>",
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
                $('#id_medc').val(ui.item.id);
                $('#pasien').val(ui.item.nama);
//                window.location.href = "<?php // echo base_url('medcheck/tambah.php?act=' . $this->input->get('act') . '&id=' . $this->input->get('id') . (isset($_GET['id_resep']) ? '&id_resep=' . $this->input->get('id_resep') : '') . '&status=' . $this->input->get('status') . (isset($_GET['item_id']) ? '&item_id=' . $this->input->get('item_id') : '') . (isset($_GET['id_item_resep']) ? '&id_item_resep=' . $this->input->get('id_item_resep') : '')) ?>&id_produk=" + ui.item.id + "&harga=" + ui.item.harga + "&satuan=" + ui.item.satuan;

                // Give focus to the next input field to recieve input from user
                $('#pasien').focus();
                return false;
            }

            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.nama + "</a><br/><a><i><small>" + item.no_rm + "</small></i></a>")
                    .appendTo(ul);
        };
    });
</script>