<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-olive elevation-1">
    <!-- Brand Logo -->
    <a href="<?php echo base_url('dashboard2.php') ?>" class="brand-link">
        <?php $pengaturan = $this->db->get('tbl_pengaturan')->row(); ?>
        <img src="<?php echo base_url('assets/theme/admin-lte-3/dist/img/'.(!empty($pengaturan->logo_header) ? $pengaturan->logo_header : 'AdminLTELogo.png')); ?>" alt="<?php echo $pengaturan->judul.' Logo'; ?>" class="brand-image img-circle elevation-0" style="width: 33px; height: 33px; background-color: #fff;">
        <span class="brand-text font-weight-light"><?php echo $pengaturan->judul_app; ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <?php $user_id  = $this->ion_auth->user()->row()->id ?>
            <?php $users    = $this->ion_auth->user()->row() ?>
            <?php $level    = $this->ion_auth->get_users_groups($user_id->id)->row(); ?>
            <?php $named    = 'userid_'.sprintf('%03d', $users->id); ?>
            <?php $file     = (!empty($users->file_name) ? realpath($users->file_name) : ''); ?>
            <?php $foto     = (!empty($users->file_name) ? base_url('file/user/'.$named.'/'.$users->file_name) : $users->file_base64); ?>
            
            <div class="image">
                <img src="<?php echo (!empty($foto) ? $foto : base_url('assets/theme/admin-lte-3/dist/img/user2-160x160.jpg')) ?>" class="img-circle elevation-0" alt="User Image" style="width: 30px; height: 30px;">
            </div>
            <div class="info">
                <?php echo anchor(base_url('profile.php'), ucwords($this->ion_auth->user()->row()->first_name), 'class="d-block"') ?>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <img src="<?php echo base_url('assets/theme/admin-lte-3/dist/img/'.(!empty($pengaturan->logo) ? $pengaturan->logo : 'AdminLTELogo.png')); ?>" alt="<?php echo $pengaturan->judul.' Logo'; ?>" class="brand-image img-rounded elevation-0" style="width: 209px; height: 85px; background-color: transparent;">
            <hr/>
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php
                if (!empty($sidebar)) {
                    $this->load->view($sidebar);
                } else {
                    ?>
                    <!--
                    <li class="nav-header">EXAMPLES</li>
                    <li class="nav-item">
                        <a href="pages/gallery.html" class="nav-link">
                            <i class="nav-icon far fa-image"></i>
                            <p>
                                TESTING
                            </p>
                        </a>
                    </li>
                    -->
                <?php } ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>