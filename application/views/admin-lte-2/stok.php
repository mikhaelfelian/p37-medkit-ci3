<div class="content-wrapper" style="margin-left: 0px;">
    <!-- Main content -->
    <section class="content" style="margin-left: 0px;">
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">DATA STOK</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode</th>
                                    <th>Jenis</th>
                                    <th>Qty</th>
                                    <th>Harga Jual</th>
                                    <!--<th>Harga Grosir</th>-->
                                </tr>
                            </thead>
                            <?php echo form_open('page=home&act=set_cari_prod') ?>
                            <?php echo form_hidden('hal', $this->input->get('halaman')) ?>
                            <tbody>                                
                                <tr>
                                    <td></td>
                                    <td><?php echo form_input(array('name' => 'kode', 'class' => 'form-control')) ?></td>
                                    <td><?php echo form_input(array('name' => 'produk', 'class' => 'form-control')) ?></td>
                                    <td><?php // echo form_input(array('name' => 'qty', 'class' => 'form-control')) ?></td>
                                    <td><?php echo form_input(array('name' => 'hj', 'class' => 'form-control')) ?></td>
                                    <!--<td></td>-->
                                    <td><button class="btn btn-primary">Cari</button></td>
                                </tr>
                            </tbody>
                            <?php echo form_close() ?>
                            <tbody>
                                <?php
                                if (!empty($produk)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($produk as $produk) {
                                        $trans = $this->db->select('SUM(jml) as jml')->where('id_produk', $produk->id)->where('tbl_trans_jual.status_nota', '1')->join('tbl_trans_jual', 'tbl_trans_jual.no_nota=tbl_trans_jual_det.no_nota')->get('tbl_trans_jual_det')->row();
                                        $tot_jml = $this->db->select('SUM(stok) as jml')->where('id_produk', $produk->id)->get('tbl_m_produk_stok')->row();
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <td><?php echo $produk->kode ?></td>
                                            <td><?php echo $produk->produk ?></td>
                                            <td style="width: 70px; text-align: center;"><?php echo (!empty($tot_jml->jml) ? $tot_jml->jml : '0'); ?></td>
                                            <td><?php echo general::format_angka($produk->harga_jual) ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (!empty($pagination)) { ?>
                        <div class="box-footer">                        
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php echo $pagination ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>