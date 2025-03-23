<li class="nav-header">MASTER DATA</li>
<?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdminM() == TRUE) { ?>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_kategori_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-tree"></i>
            <p>
                Data Kategori
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_merk_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-layer-group"></i>
            <p>
                Data Merk
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_klinik_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-hospital-symbol"></i>
            <p>
                Data Klinik
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_satuan_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-list-alt"></i>
            <p>
                Data Satuan
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_barang_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-boxes"></i>
            <p>
                Data Item
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_pasien_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-hospital-user"></i>
            <p>
                Data Pasien
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_mcu_kat_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-hospital-user"></i>
            <p>
                Data MCU
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_icd_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-book-medical"></i>
            <p>
                Data ICD 10
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_kamar_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-bed"></i>
            <p>
                Data kamar
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_karyawan_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-people-arrows"></i>
            <p>
                Data Karyawan
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_aps_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-people-arrows"></i>
            <p>
                Data Dokter APS
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_supplier_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-industry"></i>
            <p>
                Data Supplier
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_platform_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-dollar-sign"></i>
            <p>
                Data Platform
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
<?php }elseif (akses::hakAdmin() == TRUE) { ?>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_kategori_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-tree"></i>
            <p>
                Data Kategori
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_merk_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-layer-group"></i>
            <p>
                Data Merk
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_klinik_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-hospital-symbol"></i>
            <p>
                Data Klinik
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_satuan_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-list-alt"></i>
            <p>
                Data Satuan
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_barang_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-boxes"></i>
            <p>
                Data Item
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_pasien_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-hospital-user"></i>
            <p>
                Data Pasien
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_sales_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-people-arrows"></i>
            <p>
                Data Karyawan
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_platform_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-dollar-sign"></i>
            <p>
                Data Platform
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_supplier_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-industry"></i>
            <p>
                Data Supplier
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
<?php }elseif (akses::hakPurchasing() == TRUE) { ?>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_kategori_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-tree"></i>
            <p>
                Data Kategori
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_merk_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-layer-group"></i>
            <p>
                Data Merk
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_satuan_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-list-alt"></i>
            <p>
                Data Satuan
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_barang_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-boxes"></i>
            <p>
                Data Item
                <i class="right fas fa-angle-right"></i>
            </p>
        </a>
    </li>
<?php } ?>