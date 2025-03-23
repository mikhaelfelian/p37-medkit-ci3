<?php
$t_awl = ($sql_medc->tgl_bayar == '0000-00-00 00:00:00' ? $sql_medc->tgl_simpan : $sql_medc->tgl_bayar);
$t_akh = date('Y-m-d');
$jml_hari = $this->tanggalan->jml_hari($t_awl, $t_akh);
?>
<?php if ($sql_medc->tipe == '1') { ?>
    <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=2') ?>">
        <i class="fas fa-hand-holding-medical"></i> Tindakan
    </a>
    <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=3') ?>">
        <i class="fas fa-microscope"></i> Inst. Laborat
    </a>
    <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=17') ?>">
        <i class="fas fa-user-shield"></i> Penunjang
    </a>
    <a class="btn btn-app <?php echo ($sql_medc->status < 5 ? 'bg-info' : 'bg-secondary'); ?>" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=11') ?>">
        <i class="fas fa-user-md"></i> Dokter
    </a>
    <a class="btn btn-app bg-info <?php echo ($jml_hari < 2 ? 'bg-info' : 'bg-secondary'); ?>" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=6') ?>">
        <i class="fas fa-envelope"></i> Surat
    </a>
    <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=13') ?>">
        <i class="fas fa-file-medical"></i> Inform
    </a>
    <a class="btn btn-app <?php echo ($sql_medc->tipe == '3' ? 'bg-primary' : 'bg-info') ?>" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=9') ?>">
        <i class="fas fa-hospital-user"></i> <?php echo ($sql_medc->tipe == '5' ? 'MCU' : 'Resume') ?>
    </a>
    <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=15') ?>">
        <i class="fas fa-hand-holding-heart"></i> Assesment
    </a>
    <?php // if ($sql_medc->status < '3') { ?>
    <a class="btn btn-app bg-warning" href="<?php echo base_url('medcheck/transfer.php?id=' . general::enkrip($sql_medc->id) . '&status=7') ?>">
        <i class="fas fa-exchange-alt"></i> Transfer
    </a>
    <?php // } ?>
    <a class="btn btn-app bg-warning" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=12') ?>">
        <i class="fas fa-print"></i> Kwitansi
    </a>
<?php } elseif ($sql_medc->tipe == '4') { ?>
    <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=2') ?>">
        <i class="fas fa-hand-holding-medical"></i> Tindakan
    </a>
    <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=5') ?>">
        <i class="fas fa-circle-radiation"></i> Inst. Radiologi
    </a>
    <a class="btn btn-app <?php echo ($sql_medc->status < 5 ? 'bg-info' : 'bg-secondary'); ?>" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=11') ?>">
        <i class="fas fa-user-md"></i> Dokter
    </a>
    <a class="btn btn-app bg-info <?php echo ($jml_hari < 2 ? 'bg-info' : 'bg-secondary'); ?>" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=6') ?>">
        <i class="fas fa-envelope"></i> Surat
    </a>
    <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=13') ?>">
        <i class="fas fa-file-medical"></i> Inform
    </a>
    <a class="btn btn-app <?php echo ($sql_medc->tipe == '3' ? 'bg-primary' : 'bg-info') ?>" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=9') ?>">
        <i class="fas fa-hospital-user"></i> <?php echo ($sql_medc->tipe == '5' ? 'MCU' : 'Resume') ?>
    </a>
    <?php // if ($sql_medc->status < '3') { ?>
    <a class="btn btn-app bg-warning" href="<?php echo base_url('medcheck/transfer.php?id=' . general::enkrip($sql_medc->id) . '&status=7') ?>">
        <i class="fas fa-exchange-alt"></i> Transfer
    </a>
    <?php // } ?>
    <a class="btn btn-app bg-warning" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=12') ?>">
        <i class="fas fa-print"></i> Kwitansi
    </a>
<?php } elseif ($sql_medc->tipe == '6') { ?>
<?php } else { ?>
    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=1') ?>">
            <i class="fas fa-stethoscope"></i> Periksa
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=2') ?>">
            <i class="fas fa-hand-holding-medical"></i> Tindakan
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=3') ?>">
            <i class="fas fa-microscope"></i> Inst. Laborat
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=4') ?>">
            <i class="fas fa-kit-medical"></i> Inst. Farmasi
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=5') ?>">
            <i class="fas fa-circle-radiation"></i> Inst. Radiologi
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=17') ?>">
            <i class="fas fa-user-shield"></i> Penunjang
        </a>
        <a class="btn btn-app <?php echo ($sql_medc->status < 5 ? 'bg-info' : 'bg-secondary'); ?>" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=11') ?>">
            <i class="fas fa-user-md"></i> Dokter
        </a>
        <a class="btn btn-app <?php echo ($jml_hari < 2 ? 'bg-info' : 'bg-secondary'); ?>" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=6') ?>">
            <i class="fas fa-envelope"></i> Surat
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=13') ?>">
            <i class="fas fa-file-medical"></i> Inform
        </a>
        <a class="btn btn-app <?php echo ($sql_medc->tipe == '3' ? 'bg-primary' : 'bg-info') ?>" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=9') ?>">
            <i class="fas fa-hospital-user"></i> <?php echo ($sql_medc->tipe == '5' ? 'MCU' : 'Resume') ?>
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=8') ?>">
            <i class="fas fa-file-upload"></i> Unggah
        </a>
        <?php if ($sql_medc->tipe == '3') { ?>
            <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=7') ?>">
                <i class="fas fa-hospital"></i> Rekam Medis
            </a>
            <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=21') ?>">
                <i class="fas fa-chart-line"></i> Grafik TTV
            </a>
            <a class="btn btn-app <?php echo ($sql_medc->status < 5 ? 'bg-warning' : 'bg-secondary'); ?>" href="<?php echo base_url('medcheck/retur.php?id=' . general::enkrip($sql_medc->id)) ?>">
                <i class="fas fa-undo"></i> Retur
            </a>
        <?php } else { ?>
        <?php } ?>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=18') ?>">
            <i class="fas fa-history"></i> Tracer
        </a>
        <?php // if ($sql_medc->status < '3') { ?>
        <a class="btn btn-app bg-warning" href="<?php echo base_url('medcheck/transfer.php?id=' . general::enkrip($sql_medc->id) . '&status=7') ?>">
            <i class="fas fa-exchange-alt"></i> Transfer
        </a>
        <?php // } ?>
        <a class="btn btn-app bg-warning" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=19') ?>">
            <i class="fas fa-shopping-cart"></i> DP Bayar
        </a>
        <?php if ($sql_medc->status == '3') { ?>
            <a class="btn btn-app bg-warning" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=20') ?>">
                <i class="fas fa-dollar-sign"></i> TPP
            </a>
        <?php } ?>
        <?php // if ($sql_medc->status > '4') { ?>
        <a class="btn btn-app bg-warning" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=12') ?>">
            <i class="fas fa-print"></i> Kwitansi
        </a>
        <?php // } ?>
        <a class="btn btn-app bg-danger" href="<?php echo base_url('medcheck/hapus.php?id=' . general::enkrip($sql_medc->id)) ?>" onclick="return confirm('Hapus [<?php echo general::enkrip($sql_medc->id) ?>] ?')">
            <i class="fas fa-trash-alt"></i> Hapus
        </a>
    <?php } elseif (akses::hakFarmasi() == TRUE) { ?>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=4') ?>">
            <i class="fas fa-kit-medical"></i> Inst. Farmasi
        </a>  
        <a class="btn btn-app <?php echo ($jml_hari < 2 ? 'bg-info' : 'bg-secondary'); ?>" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=6') ?>">
            <i class="fas fa-envelope"></i> Surat
        </a>
        <?php if ($sql_medc->tipe == '3') { ?>
            <a class="btn btn-app bg-warning" href="<?php echo base_url('medcheck/retur.php?id=' . general::enkrip($sql_medc->id) . '&status=') ?>">
                <i class="fas fa-undo"></i> Retur
            </a>
        <?php } ?>                                 
    <?php } elseif (akses::hakDokter() == TRUE OR akses::hakFisioterapi() == TRUE) { ?>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=1') ?>">
            <i class="fas fa-stethoscope"></i> Periksa
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=2') ?>">
            <i class="fas fa-hand-holding-medical"></i> Tindakan
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=3') ?>">
            <i class="fas fa-microscope"></i> Laborat
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=4') ?>">
            <i class="fas fa-kit-medical"></i> Inst. Farmasi
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=5') ?>">
            <i class="fas fa-circle-radiation"></i> Radiologi
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=17') ?>">
            <i class="fas fa-user-shield"></i> Penunjang
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=15') ?>">
            <i class="fas fa-hand-holding-heart"></i> Assesment
        </a>
        <a class="btn btn-app <?php echo ($jml_hari < 2 ? 'bg-info' : 'bg-secondary'); ?>" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=6') ?>">
            <i class="fas fa-envelope"></i> Surat
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=13') ?>">
            <i class="fas fa-file-medical"></i> Inform
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=8') ?>">
            <i class="fas fa-file-upload"></i> Unggah
        </a>
        <!--        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=15') ?>">
            <i class="fas fa-comment"></i> Konsul
        </a>     -->
        <?php if ($sql_medc->tipe == '3') { ?>
            <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=7') ?>">
                <i class="fas fa-hospital"></i> Rekam Medis
            </a>
            <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=21') ?>">
                <i class="fas fa-chart-line"></i> Grafik TTV
            </a>
            <a class="btn btn-app bg-warning" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=20') ?>">
                <i class="fas fa-dollar-sign"></i> TPP
            </a>
        <?php } ?>                              
    <?php } elseif (akses::hakPerawat() == TRUE OR akses::hakGizi() == TRUE) { ?>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=1') ?>">
            <i class="fas fa-stethoscope"></i> Periksa
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=2') ?>">
            <i class="fas fa-hand-holding-medical"></i> Tindakan
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=3') ?>">
            <i class="fas fa-microscope"></i> Laborat
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=4') ?>">
            <i class="fas fa-kit-medical"></i> Inst. Farmasi
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=5') ?>">
            <i class="fas fa-circle-radiation"></i> Inst. Radiologi
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=17') ?>">
            <i class="fas fa-user-shield"></i> Penunjang
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=15') ?>">
            <i class="fas fa-hand-holding-heart"></i> Assesment
        </a>
        <a class="btn btn-app bg-info<?php // echo ($sql_medc->status < 5 ? 'bg-info' : 'bg-secondary');   ?>" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=11') ?>">
            <i class="fas fa-user-md"></i> Dokter
        </a>
        <a class="btn btn-app <?php echo ($jml_hari < 2 ? 'bg-info' : 'bg-secondary'); ?>" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=6') ?>">
            <i class="fas fa-envelope"></i> Surat
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=13') ?>">
            <i class="fas fa-file-medical"></i> Inform
        </a>
        <a class="btn btn-app <?php echo ($sql_medc->tipe == '3' ? 'bg-primary' : 'bg-info') ?>" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=9') ?>">
            <i class="fas fa-hospital-user"></i> <?php echo ($sql_medc->tipe == '5' ? 'MCU' : 'Resume') ?>
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=8') ?>">
            <i class="fas fa-file-upload"></i> Unggah
        </a>
        <?php if ($sql_medc->tipe == '3') { ?>
            <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=7') ?>">
                <i class="fas fa-hospital"></i> Rekam Medis
            </a>
            <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=21') ?>">
                <i class="fas fa-chart-line"></i> Grafik TTV
            </a>
            <a class="btn btn-app bg-warning" href="<?php echo base_url('medcheck/retur.php?id=' . general::enkrip($sql_medc->id) . '&status=') ?>">
                <i class="fas fa-undo"></i> Retur
            </a>
            <a class="btn btn-app bg-warning" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=20') ?>">
                <i class="fas fa-dollar-sign"></i> TPP
            </a>
        <?php } ?>
        <?php // if ($sql_medc->status < '3') { ?>
        <a class="btn btn-app bg-warning" href="<?php echo base_url('medcheck/transfer.php?id=' . general::enkrip($sql_medc->id) . '&status=7') ?>">
            <i class="fas fa-exchange-alt"></i> Transfer
        </a>
        <?php // } ?>
    <?php } elseif (akses::hakAnalis() == TRUE) { ?>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=3') ?>">
            <i class="fas fa-microscope"></i> Laborat
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=17') ?>">
            <i class="fas fa-user-shield"></i> Penunjang
        </a>
        <a class="btn btn-app <?php echo ($sql_medc->status < 5 ? 'bg-info' : 'bg-secondary'); ?>" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=6') ?>">
            <i class="fas fa-envelope"></i> Surat
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=9') ?>">
            <i class="fas fa-hospital-user"></i> Resume
        </a>
        <!--
        <a class="btn btn-app <?php echo ($sql_medc->tipe == '3' ? 'bg-primary' : 'bg-info') ?>" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=9') ?>">
            <i class="fas fa-hospital-user"></i> <?php echo ($sql_medc->tipe == '5' ? 'MCU' : 'Resume') ?>
        </a>
        -->
        <?php if ($sql_medc->tipe == '3') { ?>
            <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=7') ?>">
                <i class="fas fa-hospital"></i> Rekam Medis
            </a>
            <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=21') ?>">
                <i class="fas fa-chart-line"></i> Grafik TTV
            </a>
        <?php } ?>
    <?php } elseif (akses::hakRad() == TRUE) { ?>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=2') ?>">
            <i class="fas fa-hand-holding-medical"></i> Tindakan
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=5') ?>">
            <i class="fas fa-circle-radiation"></i> Radiologi
        </a>
        <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=8') ?>">
            <i class="fas fa-file-upload"></i> Unggah
        </a>
        <a class="btn btn-app <?php echo ($jml_hari < 2 ? 'bg-info' : 'bg-secondary'); ?>" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=6') ?>">
            <i class="fas fa-envelope"></i> Surat
        </a> 
        <?php if ($sql_medc->tipe == '3') { ?>
            <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=7') ?>">
                <i class="fas fa-hospital"></i> Rekam Medis
            </a>
            <a class="btn btn-app bg-info" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=21') ?>">
                <i class="fas fa-chart-line"></i> Grafik TTV
            </a>
        <?php } ?>                             
    <?php } elseif (akses::hakKasir() == TRUE) { ?>
        <a class="btn btn-app bg-warning" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=19') ?>">
            <i class="fas fa-shopping-cart"></i> DP Bayar
        </a>
        <a class="btn btn-app bg-warning" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=12') ?>">
            <i class="fas fa-print"></i> Kwitansi
        </a>               
    <?php } elseif (akses::hakAdmin() == TRUE) { ?>
        <a class="btn btn-app bg-warning" href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=12') ?>">
            <i class="fas fa-print"></i> Kwitansi
        </a>                       
    <?php } ?>
<?php } ?>
<a class="btn btn-app bg-warning" href="<?php echo $pengaturan->url_antrian.'/tr_queue?id_medcheck='.($sql_medc->id) ?>" target="_blank">
    <i class="fas fa-hand-paper"></i> Antrian
</a>