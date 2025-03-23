<li class="<?php echo ($_GET['page'] == 'biblio' ? 'active' : '') ?> treeview">
    <a href="#">
        <i class="fa fa-database"></i>
        <span>Master Data</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu" style="display: none;">
        <li><a href="<?php echo site_url('page=produk&act=prod_list') ?>"><i class="fa fa-angle-right"></i> Produk</a></li>
    </ul>
</li>

<li class="<?php echo ($_GET['page'] == 'produk' ? 'active' : '') ?> treeview">
    <a href="#">
        <i class="fa fa-shopping-cart"></i>
        <span>Transaksi</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu" style="display: none;">
        <li><a href="<?php echo site_url('page=transaksi&act=trans_jual') ?>"><i class="fa fa-angle-right"></i> Penjualan</a></li>
        <li><a href="<?php echo site_url('page=transaksi&act=trans_jual_list') ?>"><i class="fa fa-angle-right"></i> Data Penjualan</a></li>
    </ul>
</li>

<li class="<?php echo ($_GET['page'] == 'akuntability' ? 'active' : '') ?> treeview">
    <a href="#">
        <i class="fa fa-balance-scale"></i>
        <span>Akuntabilitas</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu" style="display: <?php echo ($_GET['page'] == 'akuntability' ? 'all' : 'none') ?>;">
        <li>
            <a href="#"><i class="fa fa-angle-right"></i> Kas <i class="fa fa-angle-left pull-right"></i></a>
            
            <ul class="treeview-menu" style="display: <?php echo ($_GET['page'] == 'akuntability' ? 'all' : 'none') ?>;">
                <li><a href="<?php echo site_url('page=akuntability&act=akt_peng_kas_list') ?>"><i class="fa fa-chevron-circle-right"></i> Pengeluaran</a></li>
            </ul>
        </li>
    </ul>
</li>