                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Master <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo base_url('master/data_kategori_list.php') ?>">Data Kategori</a></li>
                                <li><a href="<?php echo base_url('master/data_merk_list.php') ?>">Data Merk</a></li>
                                <li><a href="<?php echo base_url('master/data_lokasi_list.php') ?>">Data Lokasi</a></li>
                                <li><a href="<?php echo base_url('master/data_promo_list.php') ?>">Data Promo</a></li>
                                <li><a href="<?php echo base_url('master/data_satuan_list.php') ?>">Data Satuan</a></li>
                                <li><a href="<?php echo base_url('master/data_barang_list.php') ?>">Data Barang</a></li>
                                <li><a href="<?php echo base_url('master/data_customer_list.php') ?>">Data Customer</a></li>
                                <li><a href="<?php echo base_url('master/data_sales_list.php') ?>">Data Sales</a></li>
                                <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE){ ?>
                                    <li><a href="<?php echo base_url('master/data_supplier_list.php') ?>">Data Supplier</a></li>
                                    <li><a href="<?php echo base_url('master/data_platform_list.php') ?>">Data Platform Pembayaran</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Gudang <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <!--<li><a href="<?php // echo base_url('master/data_gudang_list.php') ?>">Data Gudang</a></li>-->
                                <li><a href="<?php echo base_url('gudang/data_stok_list.php') ?>">Data Stok</a></li>
                                <li><a href="<?php echo base_url('gudang/data_po_list.php') ?>">Data Penerimaan</a></li>
                                <li><a href="<?php echo base_url('gudang/data_opname_list.php') ?>">Data Stok Opname</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Transaksi <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo base_url('transaksi/set_nota_jual_umum.php') ?>">Kasir</a></li>
                                <li><a href="<?php echo base_url('transaksi/trans_jual.php') ?>">Input Penjualan [Grosir]</a></li>
                                <li><a href="<?php echo base_url('transaksi/trans_beli.php') ?>">Input Pembelian</a></li>
                                <li><a href="<?php echo base_url('transaksi/data_penj_list.php') ?>">Data Penjualan</a></li>
                                <li><a href="<?php echo base_url('transaksi/data_penj_list_draft.php') ?>">Data Penjualan [DRAFT]</a></li>
                                <li><a href="<?php echo base_url('transaksi/data_pembelian_list.php') ?>">Data Pembelian</a></li>
                                <?php if(akses::hakAdminM() == TRUE){ ?>
                                    <li><hr/></li>
                                    <li><a href="<?php echo base_url('transaksi/trans_beli_po.php') ?>">Input Purchase Order</a></li>
                                    <li><a href="<?php echo base_url('transaksi/data_po_list.php') ?>">Data Purchase Order</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pembayaran <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo base_url('transaksi/data_pemb_jual_list.php') ?>">Penjualan</a></li>
                                <!--<li><a href="<?php echo base_url('transaksi/data_pemb_beli_list.php') ?>">Pembelian</a></li>-->
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Retur <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo base_url('transaksi/input_retur_jual.php') ?>">Input Penjualan</a></li>
                                <!--<li><a href="<?php echo base_url('transaksi/input_retur_beli.php') ?>">Input Pembelian</a></li>-->
                                <li><a href="<?php echo base_url('transaksi/data_retur_jual_list.php') ?>">Penjualan</a></li>
                                <!--<li><a href="<?php echo base_url('transaksi/data_retur_beli_list.php') ?>">Pembelian</a></li>-->
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Rekap Penjualan <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo base_url('laporan/data_penjualan_kasir.php') ?>">Per Kasir</a></li>
                                <li><a href="<?php echo base_url('laporan/data_penjualan_produk.php') ?>">Per Produk</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Kas <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo base_url('akuntability/data_pems_list.php') ?>">Pemasukan</a></li>
                                <li><a href="<?php echo base_url('akuntability/data_peng_list.php') ?>">Pengeluaran</a></li>
                            </ul>
                        </li>
                        <?php if(akses::hakAdminM() == TRUE){ ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Laporan <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <!--<li><a href="<?php echo base_url('laporan/data_persediaan.php') ?>">Persediaan</a></li>-->
                                <li><a href="<?php echo base_url('laporan/data_penjualan.php') ?>">Penjualan</a></li>
                                <li><a href="<?php echo base_url('laporan/data_penjualan_prod.php') ?>">Penjualan Produk</a></li>
                                <li><a href="<?php echo base_url('laporan/data_stok2.php') ?>">Stok</a></li>
                                <li><a href="<?php echo base_url('laporan/data_stok.php') ?>">Mutasi Stok</a></li>
                                <li><a href="<?php echo base_url('laporan/data_mutasi.php') ?>">Mutasi Gudang</a></li>
                                <li><a href="<?php echo base_url('laporan/data_pengeluaran.php') ?>">Pengeluaran</a></li>
                                <li><a href="<?php echo base_url('laporan/data_retur_penjualan.php') ?>">Retur Penjualan</a></li>
                                <li><a href="<?php echo base_url('laporan/data_mutasi.php') ?>">Mutasi Gudang</a></li>
                            </ul>
                        </li>
                        <?php } ?>