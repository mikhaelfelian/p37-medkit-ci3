<?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE) { ?>
    <li class="nav-header">DATA KARYAWAN</li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_karyawan_tambah.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-plus"></i>
            <p>
                Tambah
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('master/data_karyawan_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-list"></i>
            <p>
                Karyawan List
            </p>
        </a>
    </li>
    <?php if (!empty($sql_kary)) { ?>
        <li class="nav-header">SDM</li>
        <li class="nav-item">
            <a href="<?php echo base_url('master/data_karyawan_kel.php?id=' . $this->input->get('id')) ?>" class="nav-link">
                <i class="nav-icon fa-solid fa-house-user"></i>
                <p>Keluarga</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo base_url('master/data_karyawan_peg.php?id=' . $this->input->get('id')) ?>" class="nav-link">
                <i class="nav-icon fa-solid fa-users"></i>
                <p>
                    Kepegawaian
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo base_url('master/data_karyawan_pend.php?id=' . $this->input->get('id')) ?>" class="nav-link">
                <i class="nav-icon fas fa-solid fa-graduation-cap"></i>
                <p>
                    Riwayat Pendidikan
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo base_url('master/data_karyawan_sert.php?id=' . $this->input->get('id')) ?>" class="nav-link">
                <i class="nav-icon fas fa-file-signature"></i>
                <p>
                    Riwayat Sertifikasi
                </p>
            </a>
        </li>
        <?php if ($sql_kary->id_user_group == '10') { ?>
            <!--
            <hr/>
            <li class="nav-item">
                <a href="<?php echo base_url('master/data_karyawan_sert.php?id=' . $this->input->get('id')) ?>" class="nav-link">
                    <i class="nav-icon fas fa-file-signature"></i>
                    <p>Daftar Poli</p>
                </a>
            </li>
            -->
            <li class="nav-item">
                <a href="<?php echo base_url('master/data_karyawan_jadwal.php?id=' . $this->input->get('id')) ?>" class="nav-link">
                    <i class="nav-icon fas fa-file-signature"></i>
                    <p>Jadwal Dokter</p>
                </a>
            </li>
        <?php } ?>
    <?php } ?>
<?php } ?>