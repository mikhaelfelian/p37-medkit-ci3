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
                    <?php echo form_open(base_url('gudang/trans_mutasi_terima_simpan.php'), [
                        'id' => 'mutasi_terima_form',
                        'autocomplete' => 'off'
                    ]); ?>
                    <?php echo add_form_protection(); ?>
                    <div class="card card-default rounded-0">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-download"></i> Penerimaan</h3>
                        </div>
                        <div class="card-body">
                            <?php echo $this->session->flashdata('gudang') ?>
                            <table class="table table-striped" id="mutasiTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-left">Kode</th>
                                        <th class="text-left">Produk</th>
                                        <th class="text-right">Jml</th>
                                        <th class="text-center">Jml Diterima</th>
                                        <th class="text-center">Jml Kurang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($sql_penj_det as $items):
                                        $remaining_stock = $items->jml - $items->jml_diterima;
                                        ?>
                                        <tr>
                                            <?php
                                            // Hidden inputs for each row
                                            echo form_hidden('id[]', general::enkrip($items->id));
                                            echo form_hidden('no_nota', $this->input->get('id'));
                                            echo form_hidden('current_stock[]', $remaining_stock);
                                            ?>

                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td class="text-left"><?php echo $items->kode; ?></td>
                                            <td class="text-left"><?php echo ucwords($items->produk); ?></td>
                                            <td class="text-right">
                                                <?php echo $items->jml . ' ' . $items->satuan; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($remaining_stock > 0): ?>
                                                    <div class="form-group mb-0">
                                                        <small class="text-muted">Max: <?php echo $remaining_stock; ?></small>
                                                        <div class="input-group">
                                                            <?php echo form_input([
                                                                'name' => 'jml_terima[]',
                                                                'class' => 'form-control text-center',
                                                                'type' => 'number',
                                                                'min' => '0',
                                                                'max' => $remaining_stock,
                                                                'required' => 'required',
                                                                'placeholder' => $remaining_stock,
                                                                'value' => $remaining_stock,
                                                                'readonly' => 'true'
                                                            ]); ?>
                                                            <div class="input-group-append">
                                                                <span
                                                                    class="input-group-text"><?php echo $items->satuan; ?></span>
                                                            </div>
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
                                            </td>
                                            <td class="text-center">
                                                <?php echo $remaining_stock; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <?php if (empty($sql_penj_det)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="<?php echo base_url('gudang/data_mutasi_terima.php') ?>"
                                        class="btn btn-primary btn-flat">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <?php if ($jml_kurang == '0' && $sql_penj->status_terima == '0'): ?>
                                        <a href="<?php echo base_url('gudang/set_trans_mutasi_finish.php?id=' . $this->input->get('id')) ?>"
                                            class="btn btn-success btn-flat">
                                            <i class="fa fa-check"></i> Selesai
                                        </a>
                                    <?php else: ?>
                                        <a href="<?php echo base_url('gudang/set_trans_mutasi_tolak.php?id=' . $this->input->get('id')) ?>"
                                            class="btn btn-warning btn-flat mr-2"
                                            onclick="return confirm('Tolak permintaan?')">
                                            <i class="fa fa-times-circle"></i> Tolak
                                        </a>
                                        <?php if ($sql_penj->status_terima != '2'): ?>
                                            <button type="submit" class="btn btn-success btn-flat">
                                                <i class="fa fa-check-circle"></i> Terima
                                            </button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php echo add_double_submit_protection('mutasi_terima_form'); ?>
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
        const form = $('#mutasi_terima_form');
        const submitBtn = form.find('button[type="submit"]');
        const modal = $('#mutasi_terima_modal');
        const redirectUrl = '<?php echo base_url("gudang/data_mutasi_terima.php") ?>';
        const csrfToken = {
            name: '<?php echo $this->security->get_csrf_token_name(); ?>',
            hash: '<?php echo $this->security->get_csrf_hash(); ?>'
        };

        // Form submission handler
        form.on('submit', function (e) {
            e.preventDefault();
            handleFormSubmit();
        });

        // Modal close handler
        modal.on('hidden.bs.modal', function () {
            resetForm();
        });

        function handleFormSubmit() {
            // Clear previous errors
            clearErrors();

            // Show loading state
            toggleLoadingState(true);

            // Prepare form data
            const formData = new FormData(form[0]);
            formData.append(csrfToken.name, csrfToken.hash);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json'
            })
                .done(handleSuccess)
                .fail(handleError)
                .always(() => toggleLoadingState(false));
        }

        function handleSuccess(response) {
            console.log('Response:', response);

            if (response.success) {
                toastr.success(response.message || 'Data berhasil disimpan');
                resetForm();
                modal.modal('hide');

                // Redirect after short delay
                setTimeout(() => {
                    window.location.href = redirectUrl;
                }, 800);
            } else {
                handleValidationErrors(response.errors);
                toastr.error(response.message || 'Terjadi kesalahan saat menyimpan data');
            }
        }

        function handleError(xhr, status, error) {
            console.error('AJAX Error:', {
                status: status,
                error: error,
                response: xhr.responseText
            });

            toastr.error('Terjadi kesalahan sistem. Silakan coba lagi.');
        }

        function toggleLoadingState(isLoading) {
            submitBtn.prop('disabled', isLoading);
            submitBtn.html(isLoading ?
                '<i class="fas fa-spinner fa-spin"></i> Menyimpan...' :
                '<i class="fa fa-save"></i> Simpan'
            );
        }

        function clearErrors() {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
        }

        function handleValidationErrors(errors) {
            if (!errors) return;

            Object.entries(errors).forEach(([field, message]) => {
                const input = form.find(`[name="${field}"]`);
                input.addClass('is-invalid');
                input.after(`<div class="invalid-feedback">${message}</div>`);
            });
        }

        function resetForm() {
            form[0].reset();
            clearErrors();
        }
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
    $(document).ready(function () {
        $('#receiveAllBtn').on('click', function () {
            var itemsData = [];
            var hasItems = false;

            // Collect items data
            $('.receive-qty').each(function () {
                var $input = $(this);
                var remaining = parseInt($input.attr('data-max'));
                var $row = $input.closest('tr');

                if (remaining > 0) {
                    hasItems = true;
                    var item = {
                        id: $row.find('input[name="id"]').val(),
                        no_nota: $row.find('input[name="no_nota"]').val(),
                        jml_terima: remaining,
                        current_stock: $row.find('input[name="current_stock"]').val(),
                        kode: $row.find('.product-link').text().trim(),
                        produk: $row.find('.product-name').text().trim(),
                        satuan: $row.find('.input-group-text').text().trim(),
                        rowId: $row.attr('id').replace('row-', '')
                    };
                    console.log('Adding item:', item);
                    itemsData.push(item);
                }
            });

            if (!hasItems) {
                toastr.info('Semua item sudah diterima');
                return;
            }

            if (confirm('Anda yakin ingin menerima semua item yang tersisa?')) {
                // Show loading state
                $('#receiveAllBtn').prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin"></i> Memproses...'
                );

                // Get the CSRF token and form protection
                var csrfName = $('.receive-form input[name="csrf_test_name"]').attr('name');
                var csrfHash = $('.receive-form input[name="csrf_test_name"]').val();
                var medkitTokens = $('input[name="medkit_tokens"]').val();

                // Prepare the data
                var postData = {
                    [csrfName]: csrfHash,
                    medkit_tokens: medkitTokens,
                    receive_all: '1',
                    items: JSON.stringify(itemsData),
                    no_nota_master: $('input[name="no_nota"]').val()
                };

                console.log('Sending data:', postData);

                $.ajax({
                    url: '<?php echo base_url("gudang/trans_mutasi_terima_simpan") ?>',
                    type: 'POST',
                    data: postData,
                    dataType: 'json',
                    success: function (response) {
                        console.log('%c Success Response:', 'background: #4CAF50; color: white; padding: 2px 5px;');
                        console.log(response);

                        if (response && response.success) {
                            if (response.debug) {
                                console.log('%c Debug Info:', 'background: #2196F3; color: white; padding: 2px 5px;');
                                console.log(response.debug);
                            }

                            // Update each processed row
                            if (response.data && Array.isArray(response.data)) {
                                console.log('Processing multiple items:', response.data);
                                response.data.forEach(function (item) {
                                    console.log('Processing item:', item);
                                    updateRowAfterReceive(item);
                                });
                            } else if (response.data) {
                                console.log('Processing single item:', response.data);
                                updateRowAfterReceive(response.data);
                            }

                            toastr.success(response.message);
                        } else {
                            console.error('Error in response:', response);
                            toastr.error(response.message || 'Terjadi kesalahan sistem');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error Details:', {
                            status: status,
                            error: error,
                            responseText: xhr.responseText,
                            xhr: xhr
                        });
                        toastr.error('Terjadi kesalahan sistem. Silakan coba lagi.');
                    }
                });
            }
        });

        // Helper function to update row after receiving items
        function updateRowAfterReceive(item) {
            var $row = $('#row-' + (item.rowId || item.id));
            if ($row.length) {
                // Update the remaining quantity display
                $row.find('.remaining-qty').text(item.remaining || 0);

                // Update the receive input section
                var $receiveSection = $row.find('.form-group');
                if (parseInt(item.remaining) === 0) {
                    // If fully received, replace with "Selesai" badge and disabled input
                    $receiveSection.html(
                        '<span class="badge badge-success">Selesai</span>' +
                        '<input class="form-control text-center" disabled value="' +
                        (item.jml_diterima || item.jml_terima) + '">'
                    );
                } else {
                    // Update max value and placeholder for partial receive
                    var $receiveInput = $row.find('.receive-qty');
                    $receiveInput.attr({
                        'max': item.remaining,
                        'data-max': item.remaining,
                        'placeholder': item.remaining
                    });
                    $receiveInput.closest('.form-group')
                        .find('small.text-muted')
                        .text('Max: ' + item.remaining);
                }

                // Update hidden inputs if needed
                $row.find('input[name="current_stock"]').val(item.new_stock || 0);
            }
        }
    });
</script>