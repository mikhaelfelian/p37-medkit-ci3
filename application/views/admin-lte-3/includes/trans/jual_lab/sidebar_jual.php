<li class="nav-header">PENJUALAN</li>
<?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE OR akses::hakFarmasi() == TRUE) { ?>
    <li class="nav-item">
        <a href="<?php echo base_url('pos/lab/set_trans_jual.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-shopping-cart"></i>
            <p>Faktur Jual</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('pos/lab/data_pelanggan_tambah.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-plus"></i>
            <p>Data Pelanggan</p>
        </a>
    </li>
<?php } ?>
<li class="nav-item">
    <a href="<?php echo base_url('pos/lab/trans_jual_list.php') ?>" class="nav-link">
        <i class="nav-icon fas fa-list"></i>
        <p>Data Penjualan</p>
    </a>
</li>