<?php $hasError = $this->session->flashdata('form_error'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <?php if (Akses::hakFarmasi() == TRUE): ?>
                        <h1 class="m-0">PERMINTAAN STOK</h1>
                    <?php else: ?>
                        <h1 class="m-0">MUTASI STOK</h1>
                    <?php endif; ?>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('gudang/index.php') ?>">Gudang</a></li>
                        <?php if (Akses::hakFarmasi() == TRUE): ?>
                            <li class="breadcrumb-item active">Form Permintaan Stok</li>
                        <?php else: ?>
                            <li class="breadcrumb-item active">Form Mutasi Stok</li>
                        <?php endif; ?>
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
                <div class="col-md-6">
                    <?php echo form_open(base_url('gudang/set_trans_mutasi.php'), 'id="form_mutasi" autocomplete="off"') ?>
                    <?php echo add_form_protection(); ?>
                    <?php echo form_hidden('gd_asal', '2'); ?>
                    <?php echo form_hidden('gd_tujuan', '1'); ?>

                    <div class="card card-default rounded-0">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-truck"></i> Form Mutasi Stok</h3>
                        </div>
                        <div class="card-body">
                            <div
                                class="form-group row <?php echo (!empty($hasError['tgl_masuk']) ? 'text-danger' : '') ?>">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">Tanggal <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl_masuk', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['tgl_masuk']) ? ' is-invalid' : ''), 'placeholder' => 'Inputkan tanggal ...', 'value' => date('d-m-Y'))) ?>
                                    </div>
                                </div>
                            </div>
                            <?php if (Akses::hakFarmasi() == TRUE or Akses::hakPerawat() == TRUE): ?>
                                <?php echo form_hidden('tipe', '1') ?>
                            <?php else: ?>
                                <div class="form-group row <?php echo (!empty($hasError['tipe']) ? 'text-danger' : '') ?>">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Tipe <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <select id="tipe" name="tipe"
                                            class="form-control rounded-0 <?php echo (!empty($hasError['tipe']) ? 'is-invalid' : '') ?>"
                                            readonly="TRUE">
                                            <option value="1" selected="">Pindah Gudang</option>
                                        </select>
                                    </div>
                                </div>
                                <div
                                    class="form-group row <?php echo (!empty($hasError['gd_asal']) ? 'text-danger' : '') ?>">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Gudang Asal <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <select name=""
                                            class="form-control rounded-0 <?php echo (!empty($hasError['gd_asal']) ? 'is-invalid' : '') ?>"
                                            readonly="TRUE">
                                            <option value="">- Pilih -</option>
                                            <?php foreach ($sql_gudang as $gd_asal) { ?>
                                                <option value="<?php echo $gd_asal->id ?>" <?php echo ($gd_asal->status == '2' ? 'selected' : '') ?>>
                                                    <?php echo $gd_asal->gudang . ($gd_asal->status == '1' ? ' [Utama]' : ''); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div
                                    class="form-group row <?php echo (!empty($hasError['gd_tujuan']) ? 'text-danger' : '') ?>">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Gudang Tujuan <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <select name=""
                                            class="form-control rounded-0 <?php echo (!empty($hasError['gd_tujuan']) ? 'is-invalid' : '') ?>"
                                            readonly="TRUE">
                                            <option value="">- Pilih -</option>
                                            <?php foreach ($sql_gudang as $gd_tujuan) { ?>
                                                <option value="<?php echo $gd_tujuan->id ?>" <?php echo ($gd_tujuan->status == '1' ? 'selected' : '') ?>>
                                                    <?php echo $gd_tujuan->gudang . ($gd_tujuan->status == '1' ? ' [Utama]' : ''); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">Keterangan</label>
                                <div class="col-sm-8">
                                    <?php echo form_textarea(array('id' => 'keterangan', 'name' => 'ket', 'class' => 'form-control pull-right rounded-0', 'rows' => '5', 'placeholder' => 'Inputkan keterangan / catatan ...')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php if (!empty($sess_mut)): ?>
                                        <button type="button" class="btn btn-danger btn-flat"
                                            onclick="window.location.href = '<?php echo base_url('gudang/set_trans_mutasi_batal.php') ?>'"
                                            onclick="return confirm('Hapus ?')"><i class="fas fa-remove"></i> Batal</button>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i>
                                        Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo add_double_submit_protection('form_mutasi'); ?>
                    <?php echo form_close() ?>
                </div>
                <div class="col-md-6">
                    <?php if (!empty($sess_mut)) { ?>
                        <?php echo form_open(base_url('gudang/cart_mutasi_simpan.php'), 'id="cart_mutasi_form" autocomplete="off"') ?>
                        <?php echo form_hidden('id', $this->input->get('id')); ?>
                        <?php echo form_hidden('id_item', (!empty($sql_produk) ? general::enkrip($sql_produk->id) : '')); ?>
                        <?php echo add_form_protection(); ?>

                        <div class="card card-default rounded-0">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-box-open"></i> Form Input Stok</h3>
                            </div>
                            <div class="card-body">
                                <div
                                    class="form-group row <?php echo (!empty($hasError['id_item']) ? 'text-danger' : '') ?>">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Kode <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-9">
                                        <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Inputkan Kode / Nama Item ...', 'value' => (!empty($sql_produk->kode) ? $sql_produk->kode : ''))) ?>
                                    </div>
                                </div>
                                <?php if (!empty($sql_produk)) { ?>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Item</label>
                                        <div class="col-sm-9">
                                            <?php echo form_input(array('id' => 'item', 'name' => 'item', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['item']) ? ' is-invalid' : ''), 'placeholder' => 'Inputkan Nama Item ...', 'value' => (!empty($sql_produk->produk) ? $sql_produk->produk : ''), 'readonly' => 'TRUE')) ?>
                                        </div>
                                    </div>
                                    <?php if (Akses::hakFarmasi() != TRUE && Akses::hakPerawat() != TRUE): ?>
                                        <?php foreach ($sql_produk_stk as $stok) { ?>
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="col-sm-3 col-form-label"><i><small>Stok
                                                            <?php echo $stok->gudang ?></small></i></label>
                                                <div class="col-sm-2">
                                                    <?php echo form_input(array('id' => 'stok', 'name' => 'stok', 'class' => 'form-control pull-right text-center rounded-0', 'value' => (!empty($stok->jml) ? (float) $stok->jml : ''), 'disabled' => 'TRUE')) ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?php echo form_input(array('id' => 'st', 'name' => 'st', 'class' => 'form-control pull-right text-left rounded-0', 'value' => (!empty($stok->satuan) ? $stok->satuan : ''), 'disabled' => 'TRUE')) ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php endif; ?>
                                    <div class="form-group row <?php echo (!empty($hasError['jml']) ? 'text-danger' : '') ?>">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Jml</label>
                                        <div class="col-sm-2">
                                            <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control pull-right text-center rounded-0', 'placeholder' => 'Jml ...', 'value' => '1')) ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <select id="satuan" name="satuan" class="form-control rounded-0">
                                                <?php foreach ($sql_produk_satuan as $satuan) { ?>
                                                    <option value="<?php echo $satuan->id ?>">
                                                        <?php echo ucwords($satuan->satuanBesar) . ($satuan->satuanBesar != $sql_satuan->satuanTerkecil ? ' (' . $satuan->jml . ' ' . $sql_satuan->satuanTerkecil . ')' : '') ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Kode Batch</label>
                                        <div class="col-sm-9">
                                            <select id="kode_batch" name="kode_batch" class="form-control rounded-0">
                                                <?php foreach ($sql_produk_sn as $sn) { ?>
                                                    <option value="<?php echo $sn->kode_batch ?>"><?php echo $sn->kode_batch ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Tgl ED</label>
                                        <div class="col-sm-9">
                                            <?php echo form_input(array('id' => 'tgl_ed', 'name' => 'tgl_ed', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['item']) ? ' is-invalid' : ''), 'placeholder' => 'Inputkan tgl ED ...')) ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">

                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i>
                                            Tambah</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo add_double_submit_protection('cart_mutasi_form'); ?>
                        <?php echo form_close() ?>
                    <?php } ?>
                </div>
            </div>

            <?php if (!empty($sql_penj_det)) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default rounded-0">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-boxes-stacked"></i> Data Item</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-left">Item</th>
                                            <!--<th class="text-left">Catatan</th>-->
                                            <th class="text-center">Gudang</th>
                                            <th class="text-center">Stok Asal</th>
                                            <th class="text-center">Jml Mutasi</th>
                                            <th class="text-center"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($sql_penj_det)) { ?>
                                            <?php $no = 1 ?>
                                            <?php foreach ($sql_penj_det as $cart) { ?>
                                                <?php
                                                $sql_produk = $this->db->where('id', $cart->id_item)->get('tbl_m_produk')->row();
                                                $sql_gudang = $this->db->where('id', $sess_mut['id_gd_asal'])->get('tbl_m_gudang')->row();
                                                $sql_stok_asl = $this->db->where('id_produk', $cart->id_item)->where('id_gudang', $sess_mut['id_gd_asal'])->get('tbl_m_produk_stok')->row();
                                                ?>
                                                <tr>
                                                    <td class="text-center" style="width: 15px;"><?php echo $no; ?></td>
                                                    <td class="text-left" style="width: 350px;">
                                                        <?php echo anchor(base_url('gudang/data_stok_tambah.php?id=' . general::enkrip($cart->id_produk)), $sql_produk->produk, 'target="_blank"'); ?>
                                                        <?php echo br() ?>
                                                        <small><?php echo $cart->kode_batch ?> / <?php echo $cart->tgl_ed ?></small>
                                                    </td>
                                                    <!--<td class="text-left" style="width: 200px;"><?php // echo $cart['options']['ket']  ?></td>-->
                                                    <td class="text-center" style="width: 100px;"><?php echo $sql_gudang->gudang ?>
                                                    </td>
                                                    <td class="text-center" style="width: 75px;">
                                                        <?php echo (float) $sql_stok_asl->jml ?>
                                                    </td>
                                                    <td class="text-center" style="width: 100px;"><?php echo (float) $cart->jml ?>
                                                    </td>
                                                    <td class="text-center" style="width: 75px;">
                                                        <?php echo anchor(base_url('gudang/cart_mutasi_hapus.php?id=' . general::enkrip($cart->id) . '&no_nota=' . $this->input->get('id')), '<i class="fa fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus ?\')" style="width: 60px;"') ?>
                                                    </td>
                                                </tr>

                                                <?php $no++; ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <tr>
                                                <th class="text-center" colspan="7">Tidak Ada Data</th>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <?php if (!empty($sql_penj_det)) { ?>
                                            <?php echo form_open(base_url('gudang/set_trans_mutasi_proses.php?id=' . $this->input->get('id')), 'id="mutasi_proses_form"'); ?>
                                            <?php echo add_form_protection(); ?>
                                            <?php echo form_hidden('id', $this->input->get('id')); ?>
                                            <button type="submit" class="btn btn-success btn-flat">
                                                <i class="fa fa-check-circle"></i> Proses
                                            </button>
                                            <?php echo add_double_submit_protection('mutasi_proses_form'); ?>
                                            <?php echo form_close(); ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
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

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        // Menampilkan Tanggal
        $("[id*='tgl']").datepicker({
            dateFormat: 'dd-mm-yy',
            SetDate: new Date(),
            autoclose: true
            <?php if (Akses::hakFarmasi() == TRUE): ?>,
                minDate: 0
            <?php endif; ?>
        });

        <?php // if (!empty($this->cart->contents())) { ?>
        // Mengambil data item melalui autocomplete
        $('#kode').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('gudang/json_item.php') ?>",
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
                $itemrow.find('#kode').val(ui.item.kode);
                $('#kode').val(ui.item.kode);
                window.location.href = "<?php echo base_url('gudang/trans_mutasi.php?id=' . $this->input->get('id')) ?>&item_id=" + ui.item.id;

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
        <?php // } ?>

        <?php echo $this->session->flashdata('gudang_toast'); ?>
    });
</script>

<script>
    $(document).ready(function () {
        // Handle Receive All button click
        $('#receiveAllBtn').on('click', function (e) {
            e.preventDefault();

            // Confirm before proceeding
            if (!confirm('Apakah Anda yakin ingin menerima semua item?')) {
                return;
            }

            // Show loading state
            $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Memproses...');

            // Submit the form via AJAX
            $.ajax({
                url: $('#formReceiveAll').attr('action'),
                type: 'POST',
                data: $('#formReceiveAll').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        // Reload the page after 1.5 seconds
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500);
                    } else {
                        toastr.error(response.message || 'Terjadi kesalahan');
                        // Re-enable the button
                        $('#receiveAllBtn').prop('disabled', false)
                            .html('<i class="fas fa-check-circle"></i> Terima Semua');
                    }
                },
                error: function (xhr, status, error) {
                    toastr.error('Terjadi kesalahan: ' + error);
                    // Re-enable the button
                    $('#receiveAllBtn').prop('disabled', false)
                        .html('<i class="fas fa-check-circle"></i> Terima Semua');
                }
            });
        });

        // Validate quantity inputs
        $('.receive-qty').on('input', function () {
            var max = parseInt($(this).data('max'));
            var val = parseInt($(this).val());

            if (val > max) {
                $(this).val(max);
            } else if (val < 0) {
                $(this).val(0);
            }
        });
    });
</script>