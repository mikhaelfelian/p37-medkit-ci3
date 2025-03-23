<?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE) { ?>
    <li class="nav-header">DATA PASIEN</li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_pasien_tambah.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-plus"></i>
            <p>
                Tambah
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_pasien_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-list"></i>
            <p>
                Pasien List
            </p>
        </a>
    </li>
<?php } ?>