<!-- Push Notification For Doctor -->
<?php
    $id_dokter          = $this->ion_auth->user()->row()->id;
    $sql_notif_periksa  = $this->db->where('tipe', '2')->where('id_dokter', $id_dokter)->where('status_periksa', '0')->where('status_bayar', '0')->get('v_medcheck_dokter');
?>
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge"><?php echo $sql_notif_periksa->num_rows() ?></span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header"><?php echo $sql_notif_periksa->num_rows() ?> Notifications</span>
        <div class="dropdown-divider"></div>
        <?php if($sql_notif_periksa->num_rows() > 0){ ?>
            <a href="<?php echo base_url('medcheck/index.php?tipe=1&filter_tipe=2&filter_bayar=0&filter_periksa=0') ?>" class="dropdown-item">
                <i class="fas fa-medkit mr-2"></i> <?php echo $sql_notif_periksa->num_rows() ?> Belum Periksa
                <span class="float-right text-muted text-sm">3 mins</span>
            </a>
        <?php } ?>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">Lihat Semua</a>
    </div>
</li>
