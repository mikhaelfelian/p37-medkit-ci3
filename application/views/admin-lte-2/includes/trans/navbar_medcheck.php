<?php $pengaturan = $this->db->get('tbl_pengaturan')->row(); ?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- search form -->
        <div class="user-panel" style="padding-bottom: 50px;">
            <?php // if($pengaturan->status_logo == '1'){ ?>
            <div class="text-center image">
                <img src="<?php echo base_url('assets/theme/admin-lte-2/dist/img/'.$pengaturan->logo) ?>" class="" alt="User Image">
            </div>
            <?php // } ?>
        </div>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MENU NAVIGASI</li>
            <li class="<?php echo ($this->uri->segment(1) == 'home.php' ? 'active' : '')  ?>"><a href="<?php echo base_url('home.php') ?>"><i class="fa fa-dashboard"></i> <span>DASHBOARD</span></i></a></li>
            <li class="treeview <?php echo ($this->uri->segment(1) == 'transaksi' ? 'active' : '')  ?>">
                <a href="<?php echo base_url('transaksi/trans_jual.php') ?>">
                    <i class="fa fa-plus"></i>
                    <span>Tambah Checkup</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>