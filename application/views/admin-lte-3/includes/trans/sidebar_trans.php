<li class="nav-header">MEDICAL CHECK</li>
<?php foreach ($this->ion_auth->modules_menu() as $menu) { ?>
    <?php if ($menu->is_sidebar == '1') { ?>
        <li class="nav-item">
            <a href="<?php echo base_url($menu->modules_route) ?>" class="nav-link">
                <i class="nav-icon fa <?php echo (!empty($menu->modules_icon) ? $menu->modules_icon : 'fa-arrow-right') ?>"></i>
                <p><?php echo $menu->modules_name ?></p>
            </a>
        </li>
    <?php } ?>
<?php } ?>
<li class="nav-item">
    <a href="<?php echo base_url('medcheck/retur.php') ?>" class="nav-link">
        <i class="nav-icon fa fa-undo"></i>
        <p>Retur</p>
    </a>
</li>
<!--
<li class="nav-item">
    <a href="<?php echo base_url('medcheck/tambah.php') ?>" class="nav-link">
        <i class="nav-icon fa fa-plus"></i>
        <p>Tambah Checkup</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('medcheck/index.php?tipe=2') ?>" class="nav-link">
        <i class="nav-icon fas fa-list"></i>
        <p>Rawat Jalan</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('medcheck/index.php?tipe=3') ?>" class="nav-link">
        <i class="nav-icon fas fa-list"></i>
        <p>Rawat Inap</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('medcheck/data_pemb.php') ?>" class="nav-link">
        <i class="nav-icon fas fa-shopping-cart"></i>
        <p>Pembayaran</p>
    </a>
</li>
<?php if (akses::hakOwner() == TRUE) { ?>
        <li class="nav-item">
            <a href="<?php echo base_url('medcheck/data_hapus.php') ?>" class="nav-link">
                <i class="nav-icon fas fa-trash-alt"></i>
                <p>Medcheck Batal</p>
            </a>
        </li>
<?php } ?>
-->