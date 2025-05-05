<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <?php if (akses::aksesLogin() == TRUE) { ?>
                <li class="nav-item">
                    <a class="nav-link d-lg-none" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <?php foreach ($this->ion_auth->modules_menu() as $menu) { ?>
                    <?php if ($menu->is_parent == '1') { ?>
                        <li class="nav-item d-none d-sm-inline-block">
                            <a href="<?php echo base_url($menu->modules_route) ?>" class="nav-link"><?php echo $menu->modules_name ?></a>
                        </li>
                    <?php } ?>
                <?php } ?> 

                <?php if (akses::hakPerawat() == TRUE OR akses::hakFarmasi() == TRUE OR akses::hakAnalis() == TRUE) { ?>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url('master/data_pasien_list.php') ?>" class="nav-link">Edit Pasien</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url('master/data_karyawan_list.php?filter_grup=10') ?>" class="nav-link">Jadwal Dokter</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url('laporan/data_periksa.php') ?>" class="nav-link">Follow Up Pasien</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url('gudang/index.php') ?>" class="nav-link">Gudang</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url('laporan/index.php') ?>" class="nav-link">Laporan</a>
                    </li>
                <?php } ?>


                    
                <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE) { ?>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url('pos/index.php') ?>" class="nav-link">Apotik</a>
                    </li>                    
                    <!-- <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url('pos/lab/index.php') ?>" class="nav-link">Apotik Lab</a>
                    </li> -->
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url('sdm/index.php') ?>" class="nav-link">SDM</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url('transaksi/index.php') ?>" class="nav-link">Transaksi</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url('gudang/index.php') ?>" class="nav-link">Gudang</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url('laporan/index.php') ?>" class="nav-link">Laporan</a>
                    </li>
                <?php } elseif (akses::hakPurchasing() == TRUE) { ?>
                <?php } elseif (akses::hakPurchasing() == TRUE) { ?>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url('transaksi/index.php') ?>" class="nav-link">Transaksi</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url('laporan/index.php') ?>" class="nav-link">Laporan</a>
                    </li>
                <?php } elseif (akses::hakFarmasi() == TRUE) { ?>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url('pos/index.php') ?>" class="nav-link">Apotik</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url('gudang/index.php') ?>" class="nav-link">Gudang</a>
                    </li>
<!--                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url('laporan/index.php') ?>" class="nav-link">Laporan</a>
                    </li>-->
                <?php } elseif (akses::hakDokter() == TRUE) { ?>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url('laporan/index.php') ?>" class="nav-link">Laporan</a>
                    </li>
                <?php } elseif (akses::hakRad() == TRUE) { ?>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url('laporan/index.php') ?>" class="nav-link">Laporan</a>
                    </li>
                <?php } elseif (akses::hakKasir() == TRUE) { ?>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url('pos/index.php') ?>" class="nav-link">Apotik</a>
                    </li>  
                <?php } elseif (akses::hakGudang() == TRUE) { ?>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url('gudang/index.php') ?>" class="nav-link">Gudang</a>
                    </li>                   
                <?php } ?>
                
                <!--MENU UNTUK PONSEL-->
                <li class="nav-item d-lg-none dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Menu
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a href="<?php echo base_url('dashboard2.php') ?>" class="dropdown-item">Dashboard</a>
                        
                        <?php foreach ($this->ion_auth->modules_menu() as $menu) { ?>
                            <?php if ($menu->is_parent == '1') { ?>
                                <a href="<?php echo base_url($menu->modules_route) ?>" class="dropdown-item"><?php echo $menu->modules_name ?></a>
                            <?php } ?>
                        <?php } ?>
                                
                        <?php if (akses::hakPerawat() == TRUE OR akses::hakFarmasi() == TRUE OR akses::hakAnalis() == TRUE) { ?>
                                 <!--Hak Akses Khusus Perawat dan Farmasi-->
                                 <a href="<?php echo base_url('master/data_pasien_list.php') ?>" class="dropdown-item">Edit Pasien</a>
                        <?php } ?>
                        
                        <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE) { ?>
                            <a href="<?php echo base_url('sdm/index.php') ?>" class="dropdown-item">SDM</a>
                            <a href="<?php echo base_url('transaksi/index.php') ?>" class="dropdown-item">Transaksi</a>
                            <a href="<?php echo base_url('pos/index.php') ?>" class="dropdown-item">Apotik</a>
                            <a href="<?php echo base_url('gudang/index.php') ?>" class="dropdown-item">Gudang</a>
                            <a href="<?php echo base_url('laporan/index.php') ?>" class="dropdown-item">Laporan</a>                        
                        <?php } elseif (akses::hakPurchasing() == TRUE) { ?>
                            <a href="<?php echo base_url('transaksi/index.php') ?>" class="dropdown-item">Transaksi</a>
                            <a href="<?php echo base_url('laporan/index.php') ?>" class="dropdown-item">Laporan</a>                        
                        <?php } elseif (akses::hakFarmasi() == TRUE) { ?>
                            <a href="<?php echo base_url('pos/index.php') ?>" class="dropdown-item">Apotik</a>
                            <a href="<?php echo base_url('laporan/index.php') ?>" class="dropdown-item">Laporan</a>                          
                        <?php } elseif (akses::hakDokter() == TRUE) { ?>
                            <a href="<?php echo base_url('laporan/index.php') ?>" class="dropdown-item">Laporan</a>                          
                        <?php } ?>
                    </div>
                </li>
                <!--AKHIR MODUL MENU PONSEL-->
            </ul>

            <!-- Navbar kanan -->
            <ul class="navbar-nav ml-auto">
                <!--Bagian Notifikasi-->
                <?php akses::notifAkses() ?>
                <!--Bagian Notifikasi End-->

                <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('pengaturan/index.php') ?>" role="button">
                            <i class="fas fa-tools"></i>
                        </a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('logout.php') ?>" role="button">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
            <?php } else { ?>                                
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?php echo base_url('home/tes4') ?>" class="nav-link">Pendaftaran</a>
                </li>
            <?php } ?>
        </ul>
    </nav>
    <!-- /.navbar -->