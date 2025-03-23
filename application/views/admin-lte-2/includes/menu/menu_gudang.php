<?php
$usr = $this->ion_auth->user()->row()->username;
?>
<?php if($usr == 'admingudang'){ ?>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Master <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="<?php echo base_url('master/data_barang_list.php') ?>">Data Barang</a></li>
    </ul>
</li>
<?php } ?>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Gudang <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="<?php echo base_url('gudang/data_stok_list.php') ?>">Data Stok</a></li>
        <?php if($usr != 'admingudang'){ ?>
            <li><a href="<?php echo base_url('gudang/data_po_list.php') ?>">Data Penerimaan</a></li>
            <li><hr></li>
            <li><a href="<?php echo base_url('gudang/trans_mutasi.php') ?>">Trans Mutasi</a></li>
            <li><a href="<?php echo base_url('gudang/data_mutasi.php') ?>">Data Mutasi</a></li>
        <?php } ?>
    </ul>
</li>