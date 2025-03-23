<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <div class="user-panel">
            <?php $user_id  = $this->ion_auth->user()->row()->id ?>
            <?php $users    = $this->ion_auth->user()->row() ?>
            <?php $level    = $this->ion_auth->get_users_groups($user_id->id)->row(); ?>
            <?php $named    = 'userid_'.sprintf('%03d', $pasien->id).'.png'; ?>            
            <?php $pasien   = $this->db->where('id_user', $user_id)->get('tbl_m_pasien')->row() ?>
            <?php $file     = (!empty($pasien->file_name) ? realpath($pasien->file_name) : ''); ?>
            <?php $foto     = (file_exists($file) ? base_url($pasien->file_name) : $users->file_base64); ?>
            
            <div class="pull-left image">
                <img src="<?php echo (!empty($foto) ? $foto: base_url('assets/theme/admin-lte-3/dist/img/user2-160x160.jpg')) ?>" class="img-circle elevation-0" alt="User Image" style="width: 45px; height: 45px;">
            </div>
            <div class="pull-left info">
                <p><?php echo anchor(base_url('pasien/profile.php'), ucwords($this->ion_auth->user()->row()->first_name), 'class="d-block"') ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        
        <!-- search form -->
        
        <!-- /.search form -->
        <br/>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MENU NAVIGASI</li>
            <li class="<?php echo ($_GET['page'] == 'home' ? 'active' : '') ?>"><a href="<?php echo base_url('pasien/dashboard.php') ?>"><i class="fa fa-dashboard"></i> <span>Beranda</span></i></a></li>
            <li class="<?php echo ($_GET['page'] == 'home' ? 'active' : '') ?>"><a href="<?php echo base_url('pasien/pendaftaran.php') ?>"><i class="fa fa-user-plus"></i> <span>Pendaftaran</span></i></a></li>
            <li class="<?php echo ($_GET['page'] == 'home' ? 'active' : '') ?>"><a href="<?php echo base_url('pasien/riwayat_lab.php') ?>"><i class="fa fa-microscope"></i> <span>Riwayat Lab</span></i></a></li>
            <li class="<?php echo ($_GET['page'] == 'home' ? 'active' : '') ?>"><a href="<?php echo base_url('pasien/riwayat_rad.php') ?>"><i class="fa fa-circle-radiation"></i> <span>Riwayat Rad</span></i></a></li>
            <li class="<?php echo ($_GET['page'] == 'home' ? 'active' : '') ?>"><a href="<?php echo base_url('pasien/riwayat_berkas.php') ?>"><i class="fa fa-paperclip"></i> <span>Riwayat Berkas</span></i></a></li>
            <!--<li class="<?php echo ($_GET['page'] == 'home' ? 'active' : '') ?>"><a href="<?php // echo base_url('pasien/riwayat_medis.php') ?>"><i class="fa fa-history"></i> <span>Riwayat Pemeriksaan</span></i></a></li>-->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>