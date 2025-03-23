<!--<div class="wrapper">-->
<header class="main-header">
    <a href="#" class="logo">
        <span class="logo-mini"><b>RS</b>ES</span>
        <span class="logo-lg"><b>RS</b> Esensia</span>
    </a>
    <nav class="navbar navbar-static-top">
        <?php if (akses::aksesLoginP() == TRUE) { ?>
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
        <?php } ?>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?php if (akses::aksesLoginP() == TRUE) { ?>
                    <!-- Messages: style can be found in dropdown.less-->
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!--<img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
                            <i class="fa fa-users"></i>
                            <span class="hidden-xs"><?php echo strtoupper($this->ion_auth->user()->row()->username) ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <?php $user_id = $this->ion_auth->user()->row()->id ?>
                                <?php $users = $this->ion_auth->user()->row() ?>
                                <?php $level = $this->ion_auth->get_users_groups($user_id->id)->row(); ?>
                                <?php $named = 'userid_' . sprintf('%03d', $pasien->id) . '.png'; ?>            
                                <?php $pasien = $this->db->where('id_user', $user_id)->get('tbl_m_pasien')->row() ?>
                                <?php $file = (!empty($pasien->file_name) ? realpath($pasien->file_name) : ''); ?>
                                <?php $foto = (file_exists($file) ? base_url($pasien->file_name) : $users->file_base64); ?>

                                <img src="<?php echo (!empty($foto) ? $foto : base_url('assets/theme/admin-lte-3/dist/img/user2-160x160.jpg')) ?>" class="img-circle elevation-0" alt="User Image" style="width: 80px; height: 80px;">
                                <p>
                                    <?php echo ucwords($this->ion_auth->user()->row()->first_name); ?>
                                    <small><?php echo strtoupper($this->ion_auth->user()->row()->username); ?></small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">

                                </div>
                                <div class="pull-right">
                                    <a href="<?php echo base_url('pasien/logout.php') ?>" class="btn btn-default btn-flat">Keluar</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><?php echo nbs(2) ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</header>