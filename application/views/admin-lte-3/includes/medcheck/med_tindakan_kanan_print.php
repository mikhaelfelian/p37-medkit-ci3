<div class="card" id="medc_posting_container">
    <div class="card-body rounded-0">
        <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakKasir() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakPerawat() == TRUE) { ?>
            
            <?php if ($sql_medc->status < 5 AND $sql_medc->status_bayar == 0) { ?>
                    <?php 
                    $form_id = 'medc_posting_' . uniqid();
                    echo form_open(base_url('medcheck/set_medcheck_proses.php'), [
                        'id' => $form_id, 
                        'autocomplete' => 'off', 
                        'class' => 'posting-form',
                        'onsubmit' => 'return confirm("Apakah Anda yakin ingin melakukan posting transaksi ini?");'
                    ]); 
                    ?>
                    <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                    <?php echo form_hidden('status', $sql_medc->status); ?>
                    <?php echo form_hidden('jml_total', $gtotal); ?>
                    <?php echo add_form_protection() ?>
                    <button type="submit" class="btn btn-app bg-info">
                        <i class="fa-solid fa-arrows-rotate"></i><br/>
                        Posting
                    </button>
                    <br/>
                    <?php echo add_double_submit_protection($form_id); ?>
                    <?php echo form_close(); ?>
                    <script>
                    $(document).ready(function() {
                        $('.posting-form').on('submit', function(e) {
                            e.preventDefault();
                            const form = $(this);
                            const submitBtn = form.find('button[type="submit"]');
                            
                            // Create FormData object to properly handle all form data
                            const formData = new FormData(form[0]);
                            
                            // Show loading state
                            submitBtn.prop('disabled', true)
                                .html('<i class="fa-solid fa-spinner fa-spin"></i><br/>Processing...');

                            $.ajax({
                                url: form.attr('action'),
                                type: 'POST',
                                data: formData,
                                processData: false,  // Don't process the data
                                contentType: false,  // Don't set content type
                                dataType: 'json',
                                success: function(response) {
                                    console.log('Response:', response);
                                    
                                    if (response.status === 'success') {
                                        // Show success message using existing toastr setup
                                        toastr.success(response.message || 'Transaksi berhasil di proses!');
                                        
                                        // Reload only the medc_posting_container div
                                        $('#medc_posting_container').fadeOut(300, function() {
                                            $(this).load(window.location.href + ' #medc_posting_container > *', function() {
                                                $(this).fadeIn(300);
                                            });
                                        });
                                    } else {
                                        // Show error message
                                        toastr.error(response.message || 'Terjadi kesalahan sistem');
                                        
                                        // Reset button state
                                        submitBtn.prop('disabled', false)
                                            .html('<i class="fa-solid fa-arrows-rotate"></i><br/>Posting');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    // Log error details for debugging
                                    console.error('AJAX Error:', {
                                        status: status,
                                        error: error,
                                        response: xhr.responseText
                                    });
                                    
                                    // Show error message using existing toastr setup
                                    toastr.error('Terjadi kesalahan sistem. Silakan coba lagi.');
                                    
                                    // Reset button state
                                    submitBtn.prop('disabled', false)
                                        .html('<i class="fa-solid fa-arrows-rotate"></i><br/>Posting');
                                },
                                // Add request header for CSRF token if needed
                                headers: {
                                    'X-CSRF-TOKEN': $('input[name="medkit_tokens"]').val()
                                }
                            });
                        });
                    });
                    </script>
            <?php } else { ?>
                <?php if ($sql_medc->status >= 5 AND $sql_medc->status_bayar != 1) { ?>
                    <?php echo form_open(base_url('medcheck/set_medcheck_proses_batal.php'), 'id="medc_batal_posting" autocomplete="off"') ?>
                    <?php echo add_form_protection() ?>
                    <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                    <?php echo form_hidden('status', $sql_medc->status); ?>
                    <?php echo form_hidden('jml_total', $gtotal); ?>
                    <button type="submit" class="btn btn-app bg-danger" onclick="return confirm('Yakin Batal Posting ?')">
                        <i class="fa-solid fa-arrows-rotate"></i><br/>
                        Batal Posting
                    </button>
                    <br/>
                    <?php echo add_double_submit_protection('medc_batal_posting');?>
                    <?php echo form_close(); ?>
                    <br/>
                <?php } else { ?>
                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                        <?php if ($sql_medc->tipe != '6') { ?>
                            <?php echo form_open(base_url('medcheck/set_medcheck_bayar_batal.php'), 'autocomplete="off"') ?>
                            <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>

                            <button type="submit" class="btn btn-app bg-danger" onclick="return confirm('Yakin Batal Bayar ?')">
                                <i class="fa-solid fa-arrows-rotate"></i><br/>
                                Batal Bayar
                            </button>
                            <br/>
                            <?php echo form_close(); ?>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            <?php } ?>                    
        <?php } ?>
        <?php
        switch ($sql_medc->tipe) {
            default:
                ?>
                <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf_ranap.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                    <i class="fa-solid fa-print"></i><br/>
                    Billings
                </button>
                <?php if ($sql_medc->status_bayar == '1') { ?>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf_ranap3.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Kwitansi
                    </button>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_dm.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Dot Matrix
                    </button>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_dm_pdf.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Dot Matrix PDF
                    </button>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        PDF
                    </button>
                <?php } ?>
                <?php
                break;

            # Laborat
            case '1':
                ?>
                <?php if ($sql_medc->status_bayar == '1') { ?>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf_ranap3.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Kwitansi
                    </button>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_dm.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Dot Matrix
                    </button>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_dm_pdf.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Dot Matrix PDF
                    </button>
                <?php }else{ ?>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        TAGIHAN
                    </button>
                <?php } ?>
                <?php
                break;

            # Rawat Jalan
            case '2':
                ?>
                <?php if ($sql_medc->status_bayar == '1') { ?>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf_ranap3.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Kwitansi
                    </button>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_dm.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Dot Matrix
                    </button>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_dm_pdf.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Dot Matrix PDF
                    </button>
                <?php }else{ ?>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        TAGIHAN
                    </button>
                <?php } ?>
                <?php
                break;

            # Rawat Inap
            case '3':
                ?>  
                <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/' . ($sql_medc->status_bayar == '1' ? 'print_pdf_ranap2' : 'print_pdf_ranap') . '.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                    <i class="fa-solid fa-print"></i><br/>
                    <?php echo ($sql_medc->status_bayar == '1' ? 'Nota ' : 'Tagihan '); ?>Ranap
                </button>
                <?php if ($sql_medc->status_bayar == '1') { ?>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf_ranap3.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Kwitansi
                    </button>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_dm_ranap.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Dot Matrix
                    </button>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_dm_pdf.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Dot Matrix PDF
                    </button>
                <?php } ?>
                <?php
                break;

            # Radiologi
            case '4':
                ?>
                <?php if ($sql_medc->status_bayar == '1') { ?>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf_ranap.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Billings
                    </button>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf_ranap3.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Kwitansi
                    </button>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_dm.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Dot Matrix
                    </button>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_dm_pdf.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Dot Matrix PDF
                    </button>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        PDF
                    </button>
                <?php } ?>
                <?php
                break;

            # MCU
            case '5':
                ?>
                <?php if ($sql_medc->status_bayar == '1') { ?>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_dm.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Dot Matrix
                    </button>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_dm_pdf.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Dot Matrix PDF
                    </button>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        PDF
                    </button>
                <?php } ?>
                <?php
                break;

            # POS
            case '6':
                ?>
                <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                    <i class="fa-solid fa-print"></i><br/>
                    Billing
                </button>
                <?php if ($sql_medc->status_bayar == '1') { ?>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf_ranap3.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Kwitansi
                    </button>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_dm.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Dot Matrix
                    </button>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_dm_pdf.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Dot Matrix PDF
                    </button>
                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        PDF
                    </button>
                <?php } ?>
                <?php
                break;
        }
        ?>
    </div>
</div>