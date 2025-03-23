<li class="nav-header">PEMBELIAN</li>
<li class="nav-item">
    <a href="<?php echo base_url('transaksi/beli/trans_beli_po.php') ?>" class="nav-link">
        <i class="nav-icon fa fa-shopping-cart"></i>
        <p>PO</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('transaksi/beli/trans_beli.php') ?>" class="nav-link">
        <i class="nav-icon fa fa-shopping-cart"></i>
        <p>Faktur Beli</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('transaksi/beli/index.php') ?>" class="nav-link">
        <i class="nav-icon fas fa-list"></i>
        <p>Data Pembelian</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('transaksi/beli/trans_beli_po_list.php') ?>" class="nav-link">
        <i class="nav-icon fas fa-list"></i>
        <p>Data PO</p>
    </a>
</li>

<!--
<li class="nav-item">
    <a href="<?php echo base_url('medcheck/tambah.php') ?>" class="nav-link">
        <i class="nav-icon fa fa-plus"></i>
        <p>Tambah Checkup</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('medcheck/index.php?tipe=2') ?>" class="nav-link">
        <i class="nav-icon fas fa-list"></i>
        <p>Rawat Jalan</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('medcheck/index.php?tipe=3') ?>" class="nav-link">
        <i class="nav-icon fas fa-list"></i>
        <p>Rawat Inap</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('medcheck/data_pemb.php') ?>" class="nav-link">
        <i class="nav-icon fas fa-shopping-cart"></i>
        <p>Pembayaran</p>
    </a>
</li>
<?php if (akses::hakOwner() == TRUE) { ?>
        <li class="nav-item">
            <a href="<?php echo base_url('medcheck/data_hapus.php') ?>" class="nav-link">
                <i class="nav-icon fas fa-trash-alt"></i>
                <p>Medcheck Batal</p>
            </a>
        </li>
<?php } ?>
-->