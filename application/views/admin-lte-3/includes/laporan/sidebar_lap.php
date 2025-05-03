<?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE) { ?>
    <li class="nav-header text-bold">LAPORAN STOK</li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_pembelian.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Pembelian</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_stok.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Item</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_stok_telusur.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Stok Telusur</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_stok_masuk.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Stok Masuk</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_stok_keluar.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Stok Keluar</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_stok_keluar_laku.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Obat Laku</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_stok_mutasi.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Stok Mutasi</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_referensi.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
                Data Item Referensi
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_stok_pers.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Stok Persediaan</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_stok_keluar_resep.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Resep</p>
        </a>
    </li>
    <!--    <li class="nav-header text-bold">LAPORAN PEMBELIAN</li>
        <li class="nav-item">
            <a href="<?php echo base_url('laporan/data_pembelian.php') ?>" class="nav-link">
                <i class="nav-icon fa fa-file-lines"></i>
                <p>Data Pembelian</p>
            </a>
        </li>-->
    <li class="nav-header text-bold">LAPORAN KEWAJIBAN</li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_remunerasi.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Remunerasi</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_apresiasi.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Apresiasi</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_referall.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Referall Fee</p>
        </a>
    </li>
    <li class="nav-header text-bold">LAPORAN PENDAPATAN</li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_omset.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Omset Global</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_omset_poli.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Omset Per Poli</p>
        </a>
    </li>    
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_omset_detail.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Omset Detail</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_omset_jasa.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Omset Jasa</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_omset_dokter.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Omset Dokter</p>
        </a>
    </li>  
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_omset_bukti.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Bukti Bayar</p>
        </a>
    </li>  
    <li class="nav-header text-bold">DATA PASIEN</li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_pasien.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Ultah Pasien</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_pasien_st.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Pasien</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_visit_pasien.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Kunjungan Pasien</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_icd.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Rekap ICD 10</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_diagnosa.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Rekap Diagnosa</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_mcu.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data MCU</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_pemeriksaan.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Pemeriksaan Harian</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_pemeriksaan_rj.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Pemeriksaan Rajal</p>
        </a>
    </li>
    <li class="nav-header text-bold">LAPORAN SDM</li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_cuti.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Rekap Cuti</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_periksa.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Rekap Pemeriksaan</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_karyawan_ultah.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Ultah Karyawan</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_tracer.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Tracer Global</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_tracer_div.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Tracer Divisi</p>
        </a>
    </li>
<?php } elseif (akses::hakAdmin() == TRUE) { ?>
    <li class="nav-header text-bold">LAPORAN STOK</li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_stok.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Item</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_pembelian.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Pembelian</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_stok_masuk.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Stok Masuk</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_stok_keluar.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Stok Keluar</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_stok_telusur.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Stok Telusur</p>
        </a>
    </li>
    <li class="nav-header text-bold">DATA PASIEN</li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_pasien.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Pasien</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_pemeriksaan.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Pemeriksaan Harian</p>
        </a>
    </li>
<?php } elseif (akses::hakPurchasing() == TRUE) { ?>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_stok_masuk.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Stok Masuk</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_stok_telusur.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Stok Telusur</p>
        </a>
    </li>
    <!--
    <li class="nav-header text-bold">LAPORAN PEMBELIAN</li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_pembelian.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Pembelian</p>
        </a>
    </li>
    -->
<?php } elseif (akses::hakPerawat() == TRUE OR akses::hakAnalis() == TRUE) { ?>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_tracer.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Tracer</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_visit_pasien.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Kunjungan Pasien</p>
        </a>
    </li>
<?php } elseif (akses::hakFarmasi() == TRUE) { ?>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_tracer.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Tracer</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_stok_keluar.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Stok Keluar</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_stok_telusur.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Stok Telusur</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_visit_pasien.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Kunjungan Pasien</p>
        </a>
    </li>
<?php } elseif (akses::hakDokter() == TRUE) { ?>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_tracer.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Tracer</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_visit_pasien.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Kunjungan Pasien</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_pemeriksaan.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Pemeriksaan Harian</p>
        </a>
    </li>
<?php } elseif (akses::hakRad() == TRUE) { ?>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_tracer.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Tracer</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('laporan/data_visit_pasien.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Data Kunjungan Pasien</p>
        </a>
    </li>
<?php } ?>

<li class="nav-item">
    <a href="#" class="nav-link">
        <?php echo nbs(2) ?>
    </a>
</li>