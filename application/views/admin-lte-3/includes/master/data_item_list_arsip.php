<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!--<h1 class="m-0">Master Data</h1>-->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('master/index.php') ?>">Master Data</a></li>
                        <li class="breadcrumb-item active">Item</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Data Item</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <?php
                                $filter_kode     = strtoupper($this->input->get('filter_kode'));
                                $filter_produk   = strtoupper($this->input->get('filter_produk'));
                                $filter_kat      = $this->input->get('filter_kategori');
                                $filter_barcode  = $this->input->get('filter_barcode');
                                $filter_stok     = $this->input->get('filter_stok');
                                $filter_merk     = $this->input->get('filter_merk');
                                $filter_lokasi   = $this->input->get('filter_lokasi');
                                $jml             = $this->input->get('jml');
                            
                                $sql_kat = $this->db->where('id', $filter_kat)->get('tbl_m_kategori')->row();
                            ?>
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <td colspan="5" class="text-left"><?php echo (!empty($sql_kat) ? '<b>'.strtoupper($sql_kat->keterangan).' : '.$jml.'</b>' : '') ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th>Kategori</th>
                                        <th>
                                            <?php $so = $this->input->get('sort_order') ?>
                                            <?php echo anchor(base_url('master/data_barang_list.php?sort_type=produk&sort_order=' . ($so == 'asc' ? 'desc' : 'asc') . (!empty($jml) ? '&jml=' . $jml : '')), 'Barang ' . ($so == 'asc' ? '<i class="fa fa-sort-up"></i>' : ($so == 'desc' ? '<i class="fa fa-sort-down"></i>' : '<i class="fa fa-sort"></i>')), 'style="color: #000;"') ?>
                                        </th>
                                        <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE || akses::hakKasir() == TRUE) { ?>
                                            <th class="text-center">
                                                Stok
                                            </th>
                                        <?php } ?>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <?php echo form_open(base_url('master/set_cari_barang.php')) ?>
                                        <?php echo form_hidden('route', 'master/data_barang_list_arsip.php') ?>
                                        
                                        <th class="text-center"></th>
                                        <th class="text-center">
                                            <select name="kategori" class="form-control">
                                                <option value="">- Kategori -</option>
                                                <?php foreach ($sql_kats as $kat) { ?>
                                                    <option value="<?php echo $kat->id ?>" <?php echo ($_GET['filter_kategori'] == $kat->id ? 'selected' : '') ?>><?php echo strtoupper($kat->keterangan) ?></option>
                                                <?php } ?>
                                            </select>
                                        </th>
                                        <th><?php echo form_input(array('name' => 'produk', 'class' => 'form-control', 'value' => $filter_produk, 'placeholder' => 'Isikan Kode / Nama Item ...')) ?></th>
                                        <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE || akses::hakKasir() == TRUE) { ?>
                                        <th>
                                            <select name="status_subt" class="form-control">
                                                <option value="">- Pilih -</option>
                                                <option value="0" <?php echo ($_GET['filter_stok'] == '0' ? 'selected' : '') ?>>Non Stockable</option>
                                                <option value="1" <?php echo ($_GET['filter_stok'] == '1' ? 'selected' : '') ?>>Stockable</option>
                                            </select>
                                        </th>
                                        <?php } ?>
                                        <th><button class="btn btn-primary btn-flat" type="submit"><i class="fa fa-search"></i> Filter</button></th>
                                        <?php echo form_close() ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($barang)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($barang as $barang) {
                                            $sql_tipe = $this->db->where('id', $barang->id_grup)->get('tbl_m_pelanggan_grup')->row();
                                            $sql_satuan = $this->db->where('id', $barang->id_satuan)->get('tbl_m_satuan')->row();
                                            $sql_kat = $this->db->where('id', $barang->id_kategori)->get('tbl_m_kategori')->row();
                                            $sql_mrk = $this->db->where('id', $barang->id_merk)->get('tbl_m_merk')->row();
//                                            $sql_stok = $this->db->select('SUM(jml * jml_satuan) AS jml')->where('id_produk', $barang->id)->get('tbl_m_produk_stok')->row();
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?></td>
                                                <!--<td><?php echo (!empty($sql_mrk->merk) ? strtoupper($sql_mrk->merk) : '-') ?></td>-->
                                                <td style="width: 200px;"><?php echo (!empty($sql_kat->keterangan) ? strtoupper($sql_kat->keterangan) : '-') ?></td>
                                                <td style="width: 450px;">
                                                    <?php echo $barang->kode; ?>
                                                    <?php echo br() ?>
                                                    <?php echo $barang->produk; // echo anchor(base_url('master/data_barang_det.php?id=' . general::enkrip($barang->id)), str_ireplace($filter_produk, '<b><u>' . $filter_produk . '</u></b>', $barang->produk)) ?>
                                                    <?php echo br() ?>
                                                    <small><b>Rp. <?php echo general::format_angka($barang->harga_jual, 2) ?></b></small>
                                                    <?php if (!empty($barang->produk_kand)) { ?>
                                                        <?php echo br() ?>
                                                        <small><i>(<?php echo strtolower($barang->produk_kand) ?>)</i></small>
                                                    <?php } ?>
                                                    <?php echo br() ?>
                                                    <small><i><?php echo $barang->produk_alias ?></i></small>
                                                </td>
                                                <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE || akses::hakKasir() == TRUE) { ?>
                                                    <?php $satuan = (!empty($sql_satuan->jml) ? floor($barang->jml / $sql_satuan->jml) : 0); ?>
                                                    <td class="text-right"><?php echo $barang->jml . ' ' . $sql_satuan->satuanTerkecil; ?></td>
                                                    <!--<td class="text-right"><?php echo (!empty($sql_stok->jml) ? $sql_stok->jml : '0') . ' ' . $sql_satuan->satuanTerkecil; ?></td>-->
                                                <?php } ?>
                                                <td>
                                                    <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE || akses::hakFarmasi() == TRUE) { ?>
                                                        <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE) { ?>
                                                            <?php echo anchor(base_url('master/data_barang_hapus_ars.php?id=' . general::enkrip($barang->id).'&restore=1'), '<i class="fas fa-history"></i> Restore', 'onclick="return confirm(\'Kembalikan [' . $barang->produk . '] ? \')" class="btn btn-secondary btn-flat btn-xs" style="width: 55px;"') ?>
                                                        <?php } ?>
                                                        <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE) { ?>
                                                            <?php echo br() ?>
                                                            <?php echo anchor(base_url('master/data_barang_hapus.php?id=' . general::enkrip($barang->id)), '<i class="fas fa-trash"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $barang->produk . '] ? \')" class="btn btn-danger btn-flat btn-xs" style="width: 55px;"') ?>
                                                        <?php } ?>
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
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->