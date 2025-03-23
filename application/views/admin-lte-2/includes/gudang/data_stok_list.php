<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Stok <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Stok</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Stok Barang</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <?php
                        $filter_kode = strtoupper($this->input->get('filter_kode'));
                        $filter_produk = strtoupper($this->input->get('filter_produk'));
                        $filter_barcode = $this->input->get('filter_barcode');
                        $filter_stok = $this->input->get('filter_stok');
                        $filter_merk = $this->input->get('filter_merk');
                        $filter_lokasi = $this->input->get('filter_lokasi');
                        $jml = $this->input->get('jml');
                        ?>
                        <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE) { ?>	
                            <?php echo (!empty($cetak) ? $cetak : '') ?>
                        <?php } ?>						
                        <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                            <button type="button" onclick="window.location.href = '<?php echo base_url('gudang/data_stok_import.php') ?>'" class="btn btn-warning btn-flat"><i class="fa fa-upload"></i> Impor</button>
                            <button type="button" onclick="window.location.href = '<?php echo base_url('gudang/data_stok_export_brc.php?' . (!empty($filter_kode) ? 'filter_kode=' . $filter_kode : '') . (!empty($filter_produk) ? '&filter_produk=' . $filter_produk : '') . (!empty($filter_merk) ? '&filter_merk=' . $filter_merk : '') . (!empty($filter_lokasi) ? '&filter_lokasi=' . $filter_lokasi : '') . (!empty($filter_hpp) ? '&filter_hpp=' . $filter_hpp : '') . (!empty($filter_harga) ? '&filter_harga=' . $filter_harga : '') . (!empty($filter_jml) ? '&jml=' . $filter_jml : '')) ?>'" class="btn btn-default btn-flat"><i class="fa fa-barcode"></i> Barcode<i class="fa fa-download"></i></button>
                        <?php } ?>
                        <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE) { ?>
                            <?php if (!empty($filter_stok)) { ?>
                                <button type="button" onclick="window.location.href = '<?php echo base_url('gudang/data_stok_export.php?' . (!empty($filter_stok) ? 'filter_stok=' . $filter_stok : '') . (!empty($jml) ? '&jml=' . $jml : '')) ?>'" class="btn btn-warning btn-flat"><i class="fa fa-download"></i> Ekspor</button>
                            <?php } else { ?>
                                <button type="button" onclick="window.location.href = '<?php echo base_url('gudang/data_stok_export.php?' . (!empty($filter_kode) ? 'filter_kode=' . $filter_kode : '') . (!empty($filter_produk) ? '&filter_produk=' . $filter_produk : '') . (!empty($filter_merk) ? '&filter_merk=' . $filter_merk : '') . (!empty($filter_lokasi) ? '&filter_lokasi=' . $filter_lokasi : '') . (!empty($filter_hpp) ? '&filter_hpp=' . $filter_hpp : '') . (!empty($filter_harga) ? '&filter_harga=' . $filter_harga : '') . (!empty($filter_jml) ? '&jml=' . $filter_jml : '')) ?>'" class="btn btn-warning btn-flat"><i class="fa fa-download"></i> Ekspor</button>
                            <?php } ?>
                        <?php } ?>
                        <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE) { ?>
                        <?php echo br(2) ?>
                        <?php } ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Merk</th>
                                    <th>Lokasi</th>
                                    <th>Kode</th>
                                    <th>Barcode</th>
                                    <th>
                                        <?php $so = $this->input->get('sort_order') ?>
                                        <?php echo anchor(base_url('gudang/data_stok_list.php?sort_type=produk&sort_order=' . ($so == 'asc' ? 'desc' : 'asc') . (!empty($jml) ? '&jml=' . $jml : '')), 'Barang ' . ($so == 'asc' ? '<i class="fa fa-sort-up"></i>' : ($so == 'desc' ? '<i class="fa fa-sort-down"></i>' : '<i class="fa fa-sort"></i>')), 'style="color: #000;"') ?>
                                    </th>
                                    <th class="text-center">
                                        <?php $so = $this->input->get('sort_order') ?>
                                        <?php echo anchor(base_url('gudang/data_stok_list.php?sort_type=jml&sort_order=' . ($so == 'asc' ? 'desc' : 'asc') . (!empty($jml) ? '&jml=' . $jml : '')), 'Stok ' . ($so == 'asc' ? '<i class="fa fa-sort-up"></i>' : ($so == 'desc' ? '<i class="fa fa-sort-down"></i>' : '<i class="fa fa-sort"></i>')), 'style="color: #000;"') ?>
                                    </th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <?php echo form_open(base_url('gudang/set_cari_stok.php'), 'autocomplete="off"') ?>
                                    <th class="text-center"></th>
                                    <th class="text-center">
                                        <select name="merk" class="form-control">
                                            <option value="">- Merk -</option>
                                            <?php $sql_merks = $this->db->order_by('merk', 'asc')->get('tbl_m_merk')->result(); ?>
                                            <?php foreach ($sql_merks as $merk) { ?>
                                                <option value="<?php echo $merk->id ?>" <?php echo ($merk->id == $_GET['filter_merk'] ? 'selected' : '') ?>><?php echo strtoupper($merk->merk) ?></option>
                                            <?php } ?>
                                        </select>
                                    </th>
                                    <th class="text-center">
                                        <select name="lokasi" class="form-control">
                                            <option value="">- Lokasi -</option>
                                            <?php $sql_loks = $this->db->get('tbl_m_poli')->result(); ?>
                                            <?php foreach ($sql_loks as $lok) { ?>
                                                <option value="<?php echo $lok->id ?>"><?php echo strtoupper($lok->lokasi) ?></option>
                                            <?php } ?>
                                        </select>
                                    </th>
                                    <th><?php echo form_input(array('name' => 'kode', 'class' => 'form-control', 'style' => 'width:100px;', 'value' => $filter_kode)) ?></th>
                                    <th><?php echo form_input(array('name' => 'barcode', 'class' => 'form-control', 'style' => 'width:100px;', 'value' => $filter_barcode)) ?></th>
                                    <th><?php echo form_input(array('name' => 'produk', 'class' => 'form-control', 'value' => $filter_produk)) ?></th>
                                    <th class="text-center"><?php // echo form_input(array('name'=>'sa', 'class'=>'form-control', 'style'=>'width:50px;'))  ?></th>
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
                                        $sql_lok = $this->db->where('id', $barang->id_lokasi)->get('tbl_m_poli')->row();
                                        $sql_stok = $this->db->select('SUM(jml * jml_satuan) as jml')->where('id_produk', $barang->id)->get('tbl_m_produk_stok')->row();
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <td><?php echo (!empty($sql_mrk->merk) ? strtoupper($sql_mrk->merk) : '-') ?></td>
                                            <td><?php echo (!empty($sql_lok->lokasi) ? strtoupper($sql_lok->lokasi) : '-') ?></td>
                                            <td><?php echo str_ireplace($filter_kode, '<b><u>' . $filter_kode . '</u></b>', $barang->kode) ?></td>
                                            <td><?php echo $barang->barcode ?></td>
                                            <td><?php echo str_ireplace($filter_produk, '<b><u>' . $filter_produk . '</u></b>', $barang->produk) ?></td>
                                            <td class="text-right"><?php echo general::format_angka($sql_stok->jml) . ' ' . $sql_satuan->satuanTerkecil ?></td>
                                            <td>
                                                <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakOwner2() == TRUE || akses::hakGudang() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE) { ?>
                                                    <?php echo nbs() ?>
                                                    <?php echo anchor(base_url('gudang/data_stok_tambah.php?id=' . general::enkrip($barang->id)), '<i class="fa fa-plus"></i> Stok', 'class="label label-success"') ?>
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