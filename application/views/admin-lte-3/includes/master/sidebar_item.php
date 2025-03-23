<li class="nav-header">DATA ITEM</li>
<?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE) { ?>
<li class="nav-item">
    <a href="<?php echo base_url('master/data_barang_tambah.php') ?>" class="nav-link">
        <i class="nav-icon fas fa-plus"></i>
        <p>
            Tambah
        </p>
    </a>
</li>
<?php } ?>
<li class="nav-item">
    <a href="<?php echo base_url('master/data_barang_list.php') ?>" class="nav-link">
        <i class="nav-icon fas fa-list"></i>
        <p>
            Item List
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('master/data_barang_list_arsip.php') ?>" class="nav-link">
        <i class="nav-icon fas fa-list"></i>
        <p>
            Item Arsip (<?php echo $this->db->where('status_hps', '1')->get('tbl_m_produk')->num_rows() ?>)
        </p>
    </a>
</li>
<?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE) { ?>
<li class="nav-item">
    <a href="<?php echo base_url('master/data_barang_import.php') ?>" class="nav-link">
        <i class="nav-icon fas fa-upload"></i>
        <p>
            Import
        </p>
    </a>
</li>
<?php } ?>