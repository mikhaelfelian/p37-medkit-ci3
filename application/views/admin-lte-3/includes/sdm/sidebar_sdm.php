<?php
    $sql_cuti = $this->db->where('status', '0')->where('id_kategori', '1')->get('tbl_sdm_cuti');
    $sql_ijin = $this->db->where('status', '0')->where('id_kategori', '2')->get('tbl_sdm_cuti');
?>
<li class="nav-header">Kepegawaian</li>
<?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE) { ?>
    <li class="nav-item">
        <a href="<?php echo base_url('sdm/data_cuti_list.php?tipe=1') ?>" class="nav-link">
            <i class="nav-icon fas fa-calendar"></i>
            <p>
                Pengajuan Cuti <b>(<?php echo $sql_cuti->num_rows() ?>)</b>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('sdm/data_cuti_list.php?tipe=2') ?>" class="nav-link">
            <i class="nav-icon fas fa-calendar"></i>
            <p>
                Pengajuan Ijin <b>(<?php echo $sql_ijin->num_rows() ?>)</b>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('sdm/data_surat_krj_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-envelope-square"></i>
            <p>
                Data Surat Keterangan
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('sdm/data_surat_tgs_list.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-tasks"></i>
            <p>
                Data Surat Penugasan
            </p>
        </a>
    </li>
    <!--
    <li class="nav-item">
        <a href="<?php // echo base_url('sdm/data_gaji.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-dollar-sign"></i>
            <p>
                Data Penggajian
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('sdm/data_absen.php') ?>" class="nav-link">
            <i class="nav-icon fas fa-fingerprint"></i>
            <p>
                Data Absensi
            </p>
        </a>
    </li>
    -->
<?php } ?>