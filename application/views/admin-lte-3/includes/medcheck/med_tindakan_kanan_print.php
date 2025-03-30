<div class="card">
    <div class="card-body rounded-0">
        <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakKasir() == TRUE) { ?>
            <?php // if ($gtotal > 0 AND $sql_medc->status < 5) { ?>
            <?php if ($sql_medc->status < 5 AND $sql_medc->status_bayar == 0) { ?>
                <?php echo form_open(base_url('medcheck/set_medcheck_proses.php'), 'id="medc_posting" autocomplete="off"') ?>
                <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                <?php echo form_hidden('status', $sql_medc->status); ?>
                <?php echo form_hidden('jml_total', $gtotal); ?>
                <?php echo add_form_protection() ?>
                <button type="submit" class="btn btn-app bg-info" onclick="return confirm('Posting ?')">
                    <i class="fa-solid fa-arrows-rotate"></i><br/>
                    Posting
                </button>
                <br/>
                <?php echo add_double_submit_protection('medc_posting');?>
                <?php echo form_close(); ?>
            <?php } else { ?>
                <?php if ($sql_medc->status >= 5 AND $sql_medc->status_bayar != 1) { ?>
                    <?php echo form_open_multipart(base_url('medcheck/set_medcheck_proses_batal.php'), 'id="medc_batal_posting" autocomplete="off"') ?>
                    <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                    <?php echo form_hidden('status', $sql_medc->status); ?>
                    <?php echo form_hidden('jml_total', $gtotal); ?>
                    <?php echo add_form_protection() ?>
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
                            <?php echo form_open_multipart(base_url('medcheck/set_medcheck_bayar_batal.php'), 'autocomplete="off"') ?>
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
<!--                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf_ranap.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        Billings
                    </button>-->
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
<!--                    <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                        <i class="fa-solid fa-print"></i><br/>
                        INVOICE
                    </button>-->
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
                            <!--
                <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf_ranap.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                    <i class="fa-solid fa-print"></i><br/>
                    Billing
                </button>
                            -->
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
<!--
<div class="card">
    <div class="card-body">
<?php // echo form_open_multipart(base_url('medcheck/set_medcheck_proses.php'), 'autocomplete="off"') ?>
<?php // echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php // echo form_hidden('status', $sql_medc->status); ?>
<?php // echo form_hidden('jml_total', $gtotal); ?>

<?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakKasir() == TRUE OR akses::hakFarmasi() == TRUE) { ?>
    <?php if ($gtotal > 0 AND $sql_medc->status < 5) { ?>
                                                        <button type="submit" class="btn btn-app bg-info" onclick="return confirm('Posting ?')">
                                                            <i class="fa-solid fa-arrows-rotate"></i><br/>
                                                            Posting
                                                        </button>
    <?php } else { ?>
                                                        <button type="button" class="btn btn-app bg-success" onclick="window.location.href = '<?php echo base_url('medcheck/set_medcheck_upd_inv.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                                                            <i class="fa-solid fa-recycle"></i><br/>
                                                            Update Nota
                                                        </button>
    <?php } ?>
    <?php if ($sql_medc->status >= 5) { ?>
                                                        <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_dm.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                                                            <i class="fa-solid fa-print"></i><br/>
                                                            Dot Matrix
                                                        </button>
                                                        <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                                                            <i class="fa-solid fa-print"></i><br/>
                                                            PDF
                                                        </button>
    <?php } ?>
<?php } ?>
<?php if ($sql_medc->tipe == '3') { ?>
                                <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/' . ($sql_medc->status_bayar == '1' ? 'print_pdf_ranap2' : 'print_pdf_ranap') . '.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                                    <i class="fa-solid fa-print"></i><br/>
    <?php echo ($sql_medc->status_bayar == '1' ? 'Nota ' : 'Billing '); ?>Ranap
                                </button>
                                <button type="button" class="btn btn-app bg-warning" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/' . ($sql_medc->status_bayar == '1' ? 'print_pdf_ranap3' : 'print_pdf_ranap') . '.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                                    <i class="fa-solid fa-print"></i><br/>
                                    Kwitansi
                                </button>
<?php } ?>
<?php // echo form_close(); ?>
    </div>
</div>
-->