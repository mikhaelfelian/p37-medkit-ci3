<li class="nav-header">MEDICAL CHECK</li>
<?php foreach ($this->ion_auth->modules_menu() as $menu) { ?>
    <?php if ($menu->is_sidebar == '1') { ?>
        <li class="nav-item">
            <a href="<?php echo ($menu->modules_route == 'medcheck/data_pendaftaran.php' ? base_url($menu->modules_route) . '?filter_tgl=' . date('Y-m-d') : base_url($menu->modules_route)) ?>" class="nav-link">
                <i class="nav-icon fa <?php echo (!empty($menu->modules_icon) ? $menu->modules_icon : 'fa-arrow-right') ?>"></i>
                <p><?php echo $menu->modules_name ?></p>
            </a>
        </li>
    <?php } ?>
<?php } ?>
<li class="nav-item">
    <a href="<?php echo base_url('medcheck/data_antrian.php') ?>" class="nav-link">
        <i class="nav-icon fa fa-volume-up"></i>
        <p>Daftar Panggilan</p>
    </a>
</li>
<?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE OR akses::hakPerawat() == TRUE) { ?>
    <li class="nav-item">
        <a href="<?php echo base_url('medcheck/data_satusehat.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-history"></i>
            <p>Satu Sehat Log</p>
        </a>
    </li>
<?php } ?>
<?php if (akses::hakDokter() == TRUE) { ?>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_pasien_list.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-hospital-user"></i>
            <p>Data Pasien</p>
        </a>
    </li>
<?php } ?>
<?php if (akses::hakRad() == TRUE) { ?>
    <li class="nav-item">
        <a href="<?php echo base_url('medcheck/data_radiologi.php?status=0') ?>" class="nav-link">
            <i class="nav-icon fa fa-circle-radiation"></i>
            <p>Inst. Radiologi Baru</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('medcheck/data_radiologi.php?status=1') ?>" class="nav-link">
            <i class="nav-icon fa fa-circle-radiation"></i>
            <p>Inst. Radiologi Proses</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('medcheck/data_radiologi.php?status=4') ?>" class="nav-link">
            <i class="nav-icon fa fa-undo"></i>
            <p>Riwayat Radiologi</p>
        </a>
    </li>
<?php } ?>
<?php if (akses::hakFarmasi() == TRUE) { ?>
    <li class="nav-item">
        <a href="<?php echo base_url('medcheck/resep/data_resep.php?status=1') ?>" class="nav-link">
            <i class="nav-icon fa fa-undo"></i>
            <p>Resep Baru</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('medcheck/resep/data_resep.php?status=3') ?>" class="nav-link">
            <i class="nav-icon fa fa-undo"></i>
            <p>Resep Proses</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('medcheck/resep/data_resep.php?status=4') ?>" class="nav-link">
            <i class="nav-icon fa fa-undo"></i>
            <p>Resep Selesai</p>
        </a>
    </li>
<?php } ?>
<?php if (akses::hakAnalis() == TRUE) { ?>
    <li class="nav-item">
        <a href="<?php echo base_url('medcheck/data_laborat.php?status=0') ?>" class="nav-link">
            <i class="nav-icon fa fa-microscope"></i>
            <p>Inst. Laborat Baru</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('medcheck/data_laborat.php?status=1') ?>" class="nav-link">
            <i class="nav-icon fa fa-microscope"></i>
            <p>Inst. Laborat Proses</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('medcheck/data_laborat.php?status=2') ?>" class="nav-link">
            <i class="nav-icon fa fa-undo"></i>
            <p>Riwayat Laborat</p>
        </a>
    </li>
<?php } ?>
<?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE OR akses::hakPerawat() == TRUE OR akses::hakDokter() == TRUE) { ?>
    <li class="nav-item">
        <a href="<?php echo base_url('medcheck/data_konsul.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-comment-medical"></i>
            <p>Konsul</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('medcheck/data_tracer.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-history"></i>
            <p>Tracer</p>
        </a>
    </li>
<?php } ?>
<?php if (akses::hakDokter() == TRUE) { ?>
    <li class="nav-header text-bold">PENUNJANG</li>
    <li class="nav-item">
        <a href="<?php echo base_url('medcheck/data_pen_spiro.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Pemeriksaan Spirometri</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('medcheck/data_pen_ekg.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Pemeriksaan EKG</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('medcheck/data_pen_hrv.php') ?>" class="nav-link">
            <i class="nav-icon fa fa-file-lines"></i>
            <p>Pemeriksaan HRV</p>
        </a>
    </li>
<?php } ?>