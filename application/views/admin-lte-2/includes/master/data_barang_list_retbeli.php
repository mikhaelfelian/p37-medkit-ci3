<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Barang <small><?php echo $supplier->nama ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Barang</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Master Data Barang</h3>
                    </div>
                    <div class="box-body table-responsive">
                        
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>No. Nota</th>
                                    <th>Tgl Nota</th>
                                    <th>
                                        <?php $so = $this->input->get('sort_order') ?>
                                        <?php echo anchor(base_url('master/data_barang_list.php?sort_type=produk&sort_order=' . ($so == 'asc' ? 'desc' : 'asc') . (!empty($jml) ? '&jml=' . $jml : '')), 'Barang ' . ($so == 'asc' ? '<i class="fa fa-sort-up"></i>' : ($so == 'desc' ? '<i class="fa fa-sort-down"></i>' : '<i class="fa fa-sort"></i>')), 'style="color: #000;"') ?>
                                    </th>
                                    <th class="text-center" colspan="2">Jml</th>
                                    <th class="text-right">Harga Beli</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <?php echo form_open(base_url('master/set_cari_barang_retbeli.php')) ?>
                                        <th class="text-center"></th>
                                        <th class="text-center"><?php echo form_input(array('name'=>'nota', 'class'=>'form-control', 'style'=>'width:100px;', 'value'=>$filter_kode)) ?></th>
                                        <th><?php echo form_input(array('name'=>'tgl', 'class'=>'form-control', 'style'=>'width:100px;', 'value'=>$filter_kode)) ?></th>
                                        <th><?php echo form_input(array('name'=>'produk', 'class'=>'form-control', 'value'=>$filter_produk)) ?></th>
                                        <th></th>
                                        <th></th>
                                        <th class="text-right"><?php // echo form_input(array('name'=>'harga', 'class'=>'form-control', 'value'=>$filter_harga)) ?></th>
                                        <th>
                                            <button class="btn btn-primary btn-flat" type="submit"><i class="fa fa-search"></i> Filter</button>
                                        </th>
                                    <?php echo form_close() ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($barang)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($barang as $barang) {
                                            $sql_tipe   = $this->db->where('id', $barang->id_grup)->get('tbl_m_pelanggan_grup')->row();
                                            $sql_satuan = $this->db->where('id', $barang->id_satuan)->get('tbl_m_satuan')->row();
                                            $sql_kat    = $this->db->where('id', $barang->id_kategori)->get('tbl_m_kategori')->row();
                                            $sql_mrk    = $this->db->where('id', $barang->id_merk)->get('tbl_m_merk')->row();
                                            $sql_lok    = $this->db->where('id', $barang->id_lokasi)->get('tbl_m_lokasi')->row();
                                            $sql_stok   = $this->db->select('SUM(jml * jml_satuan) AS jml')->where('id_produk', $barang->id)->get('tbl_m_produk_stok')->row();

                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td><?php echo anchor(base_url('transaksi/trans_beli_det.php?id='.general::enkrip($barang->id_pembelian).'&route='.$sess_beli['route']), $barang->no_nota, 'target=_blank') ?></td>
                                                <td><?php echo $this->tanggalan->tgl_indo($barang->tgl_masuk) ?></td>
                                                <td><?php echo str_ireplace($filter_produk, '<b><u>'.$filter_produk.'</u></b>', $barang->produk) ?></td>
                                                <td class="text-right"><?php echo (float)$barang->jml ?></td>
                                                <td class="text-left"><?php echo $barang->satuan ?></td>
                                                <td class="text-right"><?php echo general::format_angka($barang->harga) ?></td>
                                                <td>
                                                    <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE){ ?>
                                                        <?php echo anchor(base_url('transaksi/cart_retur_beli_m_simpan.php?id='.$sess_beli['sess_id'].'&id_produk='.general::enkrip($barang->id)), '<i class="fa fa-check"></i> Retur', 'class="label label-primary"') ?>
                                                        <?php echo nbs() ?>
                                                        <?php echo general::status_bayar($barang->status_bayar); ?>
                                                    <?php } ?>
                                                </td>
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
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<style>
    .clicked {
        background-color: #ffff00;
    }
</style>