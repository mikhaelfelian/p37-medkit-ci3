<?php $hasError = $this->session->flashdata('form_error'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">MUTASI STOK</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('gudang/index.php') ?>">Gudang</a></li>
                        <li class="breadcrumb-item active">Mutasi Stok Detail</li>
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
                    <?php echo form_open(base_url('gudang/trans_mutasi_terima_simpan.php'), ['id' => 'mutasi_terima_form', 'class' => 'receive-form', 'autocomplete' => 'off']); ?>
                    <?php echo add_form_protection(); ?>
                    <div class="card card-default rounded-0">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-download"></i> Penerimaan</h3>
                        </div>
                        <div class="card-body">
                            <?php echo $this->session->flashdata('gudang') ?>
                            <div class="mb-3">
                                <button type="button" id="receiveAllBtn" class="btn btn-primary btn-flat">
                                    <i class="fas fa-check-double"></i> Terima Semua
                                </button>
                            </div>
                            <table class="table table-striped" id="mutasiTable">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="25">No</th>
                                        <th class="text-left" width="70">Kode</th>
                                        <th class="text-left" width="250">Produk</th>
                                        <th class="text-right" width="50">Jml</th>
                                        <th class="text-center" width="100">Jml Diterima</th>
                                        <th class="text-center" width="75">Jml Kurang</th>
                                        <th class="text-center" width="50">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $jml_total = $jml_diskon = $jml_gtotal = $jml_item = $jml_item_krg = 0;

                                    foreach ($sql_penj_det as $items):
                                        // Pre-calculate all needed values
                                        $jml_total += $items->subtotal;
                                        $jml_diskon += ($items->diskon + $items->potongan);
                                        $jml_gtotal += $items->subtotal;
                                        $remaining_stock = $items->jml - $items->jml_diterima;
                                        $jml_item += ($items->jml * $items->jml_satuan);
                                        $jml_item_krg += $remaining_stock;

                                        // Get product data
                                        $produk = $this->db->where('kode', $items->kode)->get('tbl_m_produk')->row();
                                        ?>
                                        <tr id="row-<?php echo $items->id; ?>">

                                            <?php
                                            // Hidden inputs
                                            echo form_hidden([
                                                'id' => general::enkrip($items->id),
                                                'no_nota' => $this->input->get('id'),
                                                'current_stock' => $remaining_stock
                                            ]);
                                            ?>

                                            <!-- Item Number -->
                                            <td class="text-center"><?php echo $no++; ?></td>

                                            <!-- Product Code -->
                                            <td class="text-left">
                                                <?php echo anchor(
                                                    base_url('gudang/data_stok_tambah.php?id=' . general::enkrip($produk->id)),
                                                    $items->kode,
                                                    ['target' => '_blank', 'class' => 'product-link']
                                                ); ?>
                                                <br />
                                                <small class="text-muted"><b>ID:</b><?php echo $items->id; ?></small>
                                            </td>

                                            <!-- Product Name & User -->
                                            <td class="text-left">
                                                <div class="product-info">
                                                    <div class="product-name"><?php echo ucwords($items->produk); ?></div>
                                                    <small class="text-muted">
                                                        <i><?php echo $this->ion_auth->user($items->id_user)->row()->first_name; ?></i>
                                                    </small>
                                                </div>
                                            </td>

                                            <!-- Total Quantity -->
                                            <td class="text-right">
                                                <span class="quantity">
                                                    <?php echo $items->jml . ' ' . $items->satuan; ?>
                                                    <?php echo !empty($items->keterangan) ? $items->keterangan : ''; ?>
                                                </span>
                                            </td>

                                            <!-- Receive Quantity Input -->
                                            <td class="text-center">
                                                <div class="form-group mb-0">
                                                    <?php if ($remaining_stock > 0): ?>
                                                        <small class="text-muted">Max: <?php echo $remaining_stock; ?></small>
                                                        <div class="input-group">
                                                            <?php echo form_input([
                                                                'name' => 'jml_terima',
                                                                'class' => 'form-control text-center receive-qty rounded-0',
                                                                'type' => 'number',
                                                                'min' => '0',
                                                                'max' => $remaining_stock,
                                                                'step' => '1',
                                                                'required' => 'required',
                                                                'placeholder' => $remaining_stock,
                                                                'data-id' => $items->id,
                                                                'data-max' => $remaining_stock
                                                            ]); ?>
                                                            <div class="input-group-append rounded-0">
                                                                <span
                                                                    class="input-group-text rounded-0"><?php echo $items->satuan; ?></span>
                                                            </div>
                                                        </div>
                                                    <?php else: ?>
                                                        <span class="badge badge-success">Selesai</span>
                                                        <?php echo form_input([
                                                            'value' => $items->jml_diterima,
                                                            'class' => 'form-control text-center',
                                                            'disabled' => 'true'
                                                        ]); ?>
                                                    <?php endif; ?>
                                                </div>
                                            </td>

                                            <!-- Remaining Quantity Display -->
                                            <td class="text-center">
                                                <div class="remaining-qty" id="remaining-display-<?php echo $items->id; ?>">
                                                    <?php echo $remaining_stock; ?>
                                                </div>
                                            </td>

                                            <!-- Action Button -->
                                            <td class="text-center">
                                                <!--
                                                <?php if ($remaining_stock > 0): ?>
                                                    <button type="submit" class="btn btn-success btn-sm btn-receive rounded-0">
                                                        <i class="fas fa-check-circle"></i> Terima
                                                    </button>
                                                <?php endif; ?>
                                                -->
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <?php if (empty($sql_penj_det)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary btn-flat"
                                        onclick="window.location.href = '<?php echo base_url('gudang/data_mutasi_terima.php') ?>'"><i
                                            class="fas fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check-circle"></i> Terima</button>

                                    <?php if ($jml_kurang == '0' && $sql_penj->status_terima == '0') { ?>
                                        <button type="button"
                                            onclick="window.location.href = '<?php echo base_url('gudang/set_trans_mutasi_finish.php?id=' . $this->input->get('id')) ?>'"
                                            class="btn btn-success btn-flat"><i class="fa fa-check"></i> Selesai</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo add_double_submit_protection('mutasi_terima_form') ?>
                    <?php echo form_close(); ?>
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

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        // Menampilkan Tanggal
        $("[id*='tgl']").datepicker({
            dateFormat: 'dd-mm-yy',
            SetDate: new Date(),
            autoclose: true
        });
    });

    function updateRemainingStock(input, maxStock) {
        const receivedQty = parseFloat(input.value) || 0;
        const itemId = input.closest('form').querySelector('input[name="id"]').value;
        const remainingDisplay = document.getElementById('remaining-display-' + itemId.replace('general::enkrip(', '').replace(')', ''));
        const remainingSpan = document.getElementById('remaining-' + itemId.replace('general::enkrip(', '').replace(')', ''));

        // Validate input
        if (receivedQty < 0) {
            input.value = 0;
        } else if (receivedQty > maxStock) {
            input.value = maxStock;
        }

        // Calculate and display remaining stock
        const remaining = maxStock - parseFloat(input.value);
        if (remainingDisplay) {
            remainingDisplay.value = remaining.toFixed(0);
        }
        if (remainingSpan) {
            remainingSpan.textContent = remaining.toFixed(0);
        }
    }

    // Add these utility functions
    function formatNumber(number) {
        return parseFloat(number).toFixed(0);
    }

    function updateRowStatus(rowId, data) {
        const row = $(`#${rowId}`);
        const remainingDisplay = row.find('.remaining-qty');
        const qtyInput = row.find('.receive-qty');
        const submitBtn = row.find('.btn-receive');

        remainingDisplay.text(formatNumber(data.remaining));

        if (data.remaining <= 0) {
            qtyInput.prop('disabled', true);
            submitBtn.replaceWith('<span class="badge badge-success">Selesai</span>');
        } else {
            qtyInput.val('').prop('disabled', false);
            submitBtn.html('<i class="fas fa-check-circle"></i> Terima')
                .prop('disabled', false);
        }
    }
</script>

<script>
    $(document).ready(function () {
        console.log('Document ready - initializing mutasi terima form handlers');

        // Handle quantity input changes
        $('.receive-qty').on('input', function () {
            const input = $(this);
            const max = parseFloat(input.data('max'));
            const val = parseFloat(input.val()) || 0;
            const id = input.data('id');

            console.log('Input changed:', {
                id: id,
                value: val,
                max: max
            });

            // Validate input
            if (val < 0) input.val(0);
            if (val > max) input.val(max);

            // Update remaining display
            const remaining = max - parseFloat(input.val());
            console.log('Remaining calculated:', remaining);
            $(`#remaining-display-${id}`).text(remaining.toFixed(0));
        });

        // Form submission handling
        $('.receive-form').on('submit', function (e) {
            e.preventDefault();
            const form = $(this);
            const submitBtn = form.find('.btn-receive');
            const formData = form.serialize();

            console.log('Form submitted:', {
                formId: form.attr('id'),
                action: form.attr('action'),
                data: formData
            });

            // Disable button to prevent double submission
            submitBtn.prop('disabled', true);

            // Show loading state
            submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Proses...');

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    console.log('AJAX success response:', response);

                    if (response.success) {
                        toastr.success(response.message);

                        // Update the row instead of reloading
                        const rowId = form.closest('tr').attr('id');
                        const remainingDisplay = $(`#remaining-display-${response.data.id}`);
                        const qtyInput = form.find('input[name="jml_terima"]');

                        console.log('Updating row:', {
                            rowId: rowId,
                            remaining: response.data.remaining
                        });

                        // Update remaining quantity
                        remainingDisplay.text(response.data.remaining);

                        // If no remaining quantity, disable input and show completed
                        if (response.data.remaining <= 0) {
                            console.log('Item fully received, disabling controls');
                            qtyInput.prop('disabled', true);
                            submitBtn.replaceWith('<span class="badge badge-success">Selesai</span>');
                        } else {
                            // Reset input and re-enable button
                            console.log('Item partially received, resetting form');
                            qtyInput.val('').prop('disabled', false);
                            submitBtn.html('<i class="fas fa-check-circle"></i> Terima')
                                .prop('disabled', false);
                        }

                    } else {
                        console.error('Server returned error:', response.message);
                        toastr.error(response.message);
                        submitBtn.html('<i class="fas fa-check-circle"></i> Terima')
                            .prop('disabled', false);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', {
                        status: status,
                        error: error,
                        response: xhr.responseText
                    });

                    toastr.error(
                        xhr.responseText ?
                            `Error: ${xhr.responseText}` :
                            'Terjadi kesalahan sistem. Silakan coba lagi.'
                    );

                    submitBtn.html('<i class="fas fa-check-circle"></i> Terima')
                        .prop('disabled', false);
                }
            });
        });

        // Add input validation
        $('.receive-qty').on('input', function () {
            const input = $(this);
            const form = input.closest('form');
            const submitBtn = form.find('.btn-receive');
            const val = parseFloat(input.val()) || 0;
            const max = parseFloat(input.data('max'));

            console.log('Validating input:', {
                value: val,
                max: max,
                valid: (val > 0 && val <= max)
            });

            // Validate input
            if (val <= 0 || val > max) {
                submitBtn.prop('disabled', true);
                input.addClass('is-invalid');
            } else {
                submitBtn.prop('disabled', false);
                input.removeClass('is-invalid');
            }
        });

        // Add form reset handling
        $('.receive-form').on('reset', function (e) {
            const form = $(this);
            const submitBtn = form.find('.btn-receive');

            console.log('Form reset:', form.attr('id'));

            submitBtn.prop('disabled', false)
                .html('<i class="fas fa-check-circle"></i> Terima');
            form.find('.is-invalid').removeClass('is-invalid');
        });

        console.log('Mutasi terima form handlers initialized');
    });
</script>

<style>
    .product-info {
        display: flex;
        flex-direction: column;
    }

    .product-name {
        font-weight: 500;
    }

    .remaining-qty {
        font-weight: bold;
        padding: 6px;
        background: #f8f9fa;
        border-radius: 3px;
    }

    .receive-qty {
        text-align: center;
        font-weight: 500;
    }

    .badge {
        padding: 8px 12px;
    }

    .table td {
        vertical-align: middle !important;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    .invalid-feedback {
        display: none;
        color: #dc3545;
        font-size: 80%;
        margin-top: 0.25rem;
    }

    .is-invalid~.invalid-feedback {
        display: block;
    }

    .btn-receive:disabled {
        cursor: not-allowed;
    }

    .loading {
        opacity: 0.7;
        pointer-events: none;
    }
</style>

<script>
$(document).ready(function() {
    $('#receiveAllBtn').on('click', function() {
        // Get the CSRF token
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        
        // Collect items data
        var itemsData = [];
        var hasItems = false;
        
        $('.receive-qty').each(function() {
            var $input = $(this);
            var remaining = parseInt($input.attr('data-max'));
            var $row = $input.closest('tr');
            
            if (remaining > 0) {
                hasItems = true;
                itemsData.push({
                    id: $row.find('input[name="id"]').val(),
                    no_nota: $row.find('input[name="no_nota"]').val(),
                    jml_terima: remaining
                });
            }
        });

        if (!hasItems) {
            toastr.info('Semua item sudah diterima');
            return;
        }

        if (confirm('Anda yakin ingin menerima semua item yang tersisa?')) {
            $('#receiveAllBtn').prop('disabled', true).html(
                '<i class="fas fa-spinner fa-spin"></i> Memproses...'
            );

            // Create form data
            var formData = new FormData();
            formData.append(csrfName, csrfHash);
            formData.append('receive_all', '1');
            formData.append('items', JSON.stringify(itemsData));
            formData.append('medkit_tokens', $('input[name="medkit_tokens"]').val());
            formData.append('form_id', $('input[name="form_id"]').val());

            $.ajax({
                url: '<?php echo base_url("gudang/trans_mutasi_terima_simpan") ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    console.log('Response:', response); // Debug line
                    if (response.success) {
                        toastr.success(response.message);
                        window.location.reload();
                    } else {
                        toastr.error(response.message || 'Terjadi kesalahan sistem');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', {
                        status: status,
                        error: error,
                        response: xhr.responseText
                    });
                    toastr.error('Terjadi kesalahan sistem. Silakan coba lagi.');
                },
                complete: function() {
                    $('#receiveAllBtn').prop('disabled', false).html(
                        '<i class="fas fa-check-double"></i> Terima Semua'
                    );
                }
            });
        }
    });
});
</script>