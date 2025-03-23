<?php if (!empty($sql_kary)) { ?>
    <li class="nav-header">SDM</li>
    <li class="nav-item">
        <a href="<?php echo base_url('profile.php?page=profile_kel&id='.general::enkrip($sql_kary->id) . '&route=profile.php') ?>" class="nav-link">
            <i class="nav-icon fa-solid fa-house-user"></i>
            <p>Keluarga</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('profile.php?page=profile_pend&id=' . general::enkrip($sql_kary->id) . '&route=profile.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-solid fa-graduation-cap"></i>
            <p>Riwayat Pendidikan</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('profile.php?page=profile_sert&id='.general::enkrip($sql_kary->id).'&route=profile.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-file-signature"></i>
            <p>Riwayat Sertifikasi</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('profile.php?page=profile_peg&id='.general::enkrip($sql_kary->id).'&route=profile.php')  ?>" class="nav-link">
            <i class="nav-icon fa-solid fa-users"></i>
            <p>Riwayat Kepegawaian</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('profile.php?page=profile_cuti&id='.general::enkrip($sql_kary->id).'&route=profile.php')  ?>" class="nav-link">
            <i class="nav-icon fa-solid fa-umbrella-beach"></i>
            <p>Cuti</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('profile.php?page=profile_surat_krj&id='.general::enkrip($sql_kary->id).'&route=profile.php')  ?>" class="nav-link">
            <i class="nav-icon fa-solid fa-envelope-open"></i>
            <p>Surat Keterangan Kerja</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('profile.php?page=profile_surat_tgs&id='.general::enkrip($sql_kary->id).'&route=profile.php')  ?>" class="nav-link">
            <i class="nav-icon fa-solid fa-envelope-open"></i>
            <p>Surat Tugas</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('profile.php?page=profile_gaji&id='.general::enkrip($sql_kary->id).'&route=profile.php')  ?>" class="nav-link">
            <i class="nav-icon fa-solid fa-dollar"></i>
            <p>Gaji</p>
        </a>
    </li>
<?php } ?>