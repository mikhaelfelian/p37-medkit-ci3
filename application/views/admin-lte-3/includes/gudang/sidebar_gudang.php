<?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE) { ?>
    <li class="nav-header">DATA PENERIMAAN</li>
    <li class="nav-item">
        <a href="<?php echo base_url('gudang/trans_beli_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-solid fa-file-invoice"></i>
            <p>
                Stok Masuk
            </p>
        </a>
    </li>

    <li class="nav-header">STOCK OPNAME</li>
    <li class="nav-item">
        <a href="<?php echo base_url('gudang/data_opname_tambah.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-plus"></i>
            <p>Tambah</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('gudang/data_opname_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-solid fa-boxes-stacked"></i>
            <p>
                Stok Opname
            </p>
        </a>
    </li>
    <li class="nav-header">INVENTORI</li>
    <li class="nav-item">
        <a href="<?php echo base_url('gudang/data_stok_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-box-open"></i>
            <p>
                Data Stok
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('gudang/trans_mutasi.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-truck"></i>
            <p>
                Mutasi Stok
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('gudang/data_mutasi.php?filter_status=0') ?>" class="nav-link">
            <i class="nav-icon fas fa-inbox"></i>
            <p>
                Data Mutasi draft
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('gudang/data_mutasi_terima.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-download"></i>
            <p>
                Penerimaan Mutasi Stok
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('gudang/data_mutasi.php?filter_status=2') ?>" class="nav-link">
            <i class="nav-icon fas fa-history"></i>
            <p>
                Riwayat Mutasi Stok
            </p>
        </a>
    </li>
<?php } elseif (akses::hakFarmasi() == TRUE) { ?>
    <li class="nav-header">INVENTORI</li>
    <li class="nav-item">
        <a href="<?php echo base_url('gudang/data_stok_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-box-open"></i>
            <p>
                Data Stok
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('gudang/trans_mutasi.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-truck"></i>
            <p>
                Permintaan Stok
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('gudang/data_mutasi.php?filter_status=0') ?>" class="nav-link">
            <i class="nav-icon fas fa-inbox"></i>
            <p>
                Data Permintaan (draft)
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('gudang/data_mutasi.php?filter_status=2') ?>" class="nav-link">
            <i class="nav-icon fas fa-history"></i>
            <p>
                Riwayat Permintaan
            </p>
        </a>
    </li>
<?php } ?>