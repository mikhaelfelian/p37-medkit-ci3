<?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE) { ?>
    <li class="nav-header">DATA DOKTER APS</li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_aps_tambah.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-plus"></i>
            <p>
                Tambah
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_aps_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-list"></i>
            <p>
                Dokter APS
            </p>
        </a>
    </li>
<?php } ?>