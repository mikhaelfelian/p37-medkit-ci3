            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php echo $trans_jml ?></h3>

                            <p>Nota Penjualan</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="<?php echo base_url('transaksi/data_penj_list.php') ?>" class="small-box-footer">Selebihnya <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?php echo general::format_angka($prod_jml) ?></h3>

                            <p>Produk Stok < 5</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?php echo base_url('gudang/data_stok_list.php') ?>" class="small-box-footer">Selebihnya <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Rekap Penjualan Bulanan</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <p class="text-center">
                                        <strong>Penjualan: <?php echo $this->tanggalan->tgl_indo3(date('Y') . '-01-01') ?> - <?php echo $this->tanggalan->tgl_indo3(date('Y-m-d')) ?></strong>
                                    </p>

                                    <div class="chart">
                                        <!-- Sales Chart Canvas -->
                                        <canvas id="salesChart" style="height: 180px;"></canvas>
                                    </div>
                                    <!-- /.chart-responsive -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4">
                                    <p class="text-center">
                                        <strong>Penjualan</strong>
                                    </p>
                                    <!-- /.progress-group -->
                                    <div class="progress-group">
                                        <span class="progress-text">Item Terjual</span>
                                        <span class="progress-number"><b>480</b></span>

                                        <div class="progress sm">
                                            <div class="progress-bar progress-bar-green" style="width: 80%"></div>
                                        </div>
                                    </div>
                                    <!-- /.progress-group -->
                                    <div class="progress-group">
                                        <span class="progress-text">Penawaran Dibuat</span>
                                        <span class="progress-number"><b>2</b></span>

                                        <div class="progress sm">
                                            <div class="progress-bar progress-bar-yellow" style="width: 80%"></div>
                                        </div>
                                    </div>
                                    <!-- /.progress-group -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./box-body -->
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-3 col-xs-6">
                                    <div class="description-block border-right">
                                        <!--<span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>-->
                                        <h5 class="description-header"><?php echo general::format_angka($pem_jml->nominal) ?></h5>
                                        <span class="description-text">TOTAL PENJUALAN</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-xs-6">
                                    <div class="description-block border-right">
                                        <!--<span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>-->
                                        <h5 class="description-header"><?php echo general::format_angka($pem_jml_thn->nominal) ?></h5>
                                        <span class="description-text">TOTAL PENJUALAN TAHUN <?php echo date('Y') ?></span>
                                    </div>
                                     <!--/.description-block--> 
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Transaksi Penjualan Terakhir</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                        <tr>
                                            <th>No. INV</th>
                                            <th>Tgl Transaksi</th>
                                            <th>Pelanggan</th>
                                            <th>Kasir</th>
                                            <th class="text-right">Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($trans_new as $trans){ ?>
                                        <?php $sql_kasir = $this->db->where('id', $trans->id_sales)->get('tbl_m_sales')->row() ?>
                                        <?php $sql_cust  = $this->db->where('id', $trans->id_pelanggan)->get('tbl_m_pelanggan')->row() ?>
                                        <tr>
                                            <td><a href="<?php echo base_url('transaksi/trans_jual_det.php?id='.general::enkrip($trans->no_nota).'&route=dashboard.php') ?>"><?php echo $trans->kode_nota_dpn.$trans->no_nota.'/'.$trans->kode_nota_blk ?></a></td>
                                            <td><?php echo $this->tanggalan->tgl_indo($trans->tgl_simpan) ?></td>
                                            <td><?php echo $sql_cust->nama ?></td>
                                            <td><?php echo $sql_kasir->nama ?></td>
                                            <td class="text-right"><?php echo general::format_angka($trans->jml_gtotal) ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <a href="<?php echo base_url('transaksi/set_nota_jual_umum.php') ?>" class="btn btn-sm btn-info btn-flat pull-left">Transaksi Baru (UMUM)</a>
                            <a href="<?php echo base_url('transaksi/data_penj_list.php') ?>" class="btn btn-sm btn-default btn-flat pull-right">Semua Transaksi</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                </div>
                <div class="col-md-4">
                    <!-- PRODUCT LIST -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Produk Terbaru</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <?php if(!empty($prod_new)){ ?>
                        <div class="box-body">
                            <ul class="products-list product-list-in-box">
                                <?php foreach($prod_new as $prod){ ?>
                                <li class="item">
                                    <div class="product-img">
                                        <img src="<?php echo base_url('assets/theme/admin-lte-2/dist/img/default-50x50.gif') ?>" alt="Product Image">
                                    </div>
                                    <div class="product-info">
                                        <a href="<?php echo base_url('master/data_barang_det.php?id='.general::enkrip($prod->id).'&route=dashboard.php') ?>" class="product-title"><?php echo $prod->kode ?>
                                            <span class="label label-warning pull-right"><?php echo general::format_angka($prod->harga_jual) ?></span></a>
                                        <span class="product-description">
                                            <?php echo $prod->produk ?>
                                        </span>
                                    </div>
                                </li>
                                <!-- /.item -->
                                <?php } ?>
                            </ul>
                        </div>
                        <?php } ?>
                        <!-- /.box-body -->
                        <div class="box-footer text-center">
                            <a href="<?php echo base_url('master/data_barang_list.php') ?>" class="uppercase">Semua Produk</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>