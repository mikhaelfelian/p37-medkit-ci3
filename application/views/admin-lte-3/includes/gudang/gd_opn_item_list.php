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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('gudang/index.php') ?>">Gudang</a></li>
                        <li class="breadcrumb-item active">Stock Opname Item</li>
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
                            <h3 class="card-title">Form Stok Opname</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <div class="row">

                                <?php echo $this->session->flashdata('gudang') ?>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Nama Petugas</th>
                                        <th>:</th>
                                        <td><?php echo strtoupper($this->ion_auth->user($sess_jual['id_user'])->row()->first_name) ?>
                                        </td>

                                        <th>Tgl Transaksi</th>
                                        <th>:</th>
                                        <td><?php echo $this->tanggalan->tgl_indo($trans_opn['tgl_simpan']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Keterangan</th>
                                        <th>:</th>
                                        <td><?php echo strtoupper($trans_opn['keterangan']) ?></td>

                                        <th>Gudang</th>
                                        <th>:</th>
                                        <td><?php echo $this->db->where('id', $trans_opn['id_gudang'])->get('tbl_m_gudang')->row()->gudang ?>
                                        </td>
                                    </tr>
                                </table>
                                <hr />
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-right" style="width: 20px;"></th>
                                            <th class="text-center" style="width: 20px;">No</th>
                                            <th class="text-left" style="width: 650px;">Item</th>
                                            <th class="text-right" style="width: 150px;">Jml Sistem</th>
                                            <th class="text-right" style="width: 150px;">Jml SO</th>
                                            <th class="text-right" style="width: 150px;">Selisih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($trans_opn_det)) { ?>
                                            <?php
                                            $no = 1;
                                            $tot_penj = 0;
                                            ?>
                                            <?php foreach ($trans_opn_det as $penj_det) { ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <?php echo anchor(base_url('gudang/cart_opn_hapus.php?id=' . general::enkrip($penj_det->id) . '&route=gudang/data_opname_item_list.php?nota=' . $this->input->get('nota')), '<i class="fa fa-remove"></i>', 'class="text-danger" onclick="return confirm(\'Hapus [' . $penj_det->produk . '] ?\')"') ?>
                                                    </td>
                                                    <td class="text-center"><?php echo $no; ?>.</td>
                                                    <td class="text-left"><?php echo $penj_det->produk ?></td>
                                                    <td class="text-right"><?php echo (float) $penj_det->jml_sys ?></td>
                                                    <td class="text-right"><?php echo (float) $penj_det->jml . ' ' . $penj_det->satuan ?></td>
                                                    <td class="text-right">
                                                        <?php echo (float) $penj_det->jml - $penj_det->jml_sys ?>
                                                    </td>
                                                </tr>
                                                <?php $no++; ?>
                                            <?php } ?>
                                            <tr>
                                                <th class="text-right" colspan="5">
                                                    Total Item
                                                </th>
                                                <th class="text-right"><?php echo $no - 1 ?> Item</th>
                                            </tr>
                                        <?php } else { ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-bold">Data Item Kosong</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-danger btn-flat pull-left"
                                        onclick="window.location.href = '<?php echo base_url('gudang/set_opname_batal.php?id=' . $this->input->get('nota') . '&route=gudang/data_opname_tambah.php') ?>'"><i
                                            class="fa fa-remove"></i> Batal</button>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <?php if (!empty($trans_opn_det)) { ?>
                                        <?php echo form_open(base_url('gudang/set_opname_proses.php'),'id="gd_opn_proses_form"') ?>
                                        <?php echo form_hidden('sess_id', $trans_opn['uuid']) ?>
                                        <?php echo form_hidden('id', $this->input->get('nota')) ?>
                                        <?php echo add_form_protection() ?>
                                        <button type="submit" class="btn btn-primary btn-flat pull-right">Simpan
                                            &raquo;</button>
                                        <?php echo add_double_submit_protection('gd_opn_proses_form') ?>
                                        <?php echo form_close() ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Data Stock Item</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            // Get filter parameters from URL
                            $filter_kode    = strtoupper($this->input->get('filter_kode'));
                            $filter_produk  = strtoupper($this->input->get('filter_produk'));
                            $filter_barcode = $this->input->get('filter_barcode');
                            $filter_stok    = $this->input->get('filter_stok');
                            $filter_merk    = $this->input->get('filter_merk');
                            $filter_lokasi  = $this->input->get('filter_lokasi');
                            $jml            = $this->input->get('jml');
                            ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th>Item</th>
                                        <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE || akses::hakKasir() == TRUE) { ?>
                                            <th class="text-center">
                                                Stok
                                            </th>
                                        <?php } ?>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">SO</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <?php echo form_open(base_url('gudang/set_opname_cari_item.php')) ?>
                                        <?php echo form_hidden('nota', $this->input->get('nota')) ?>
                                        <?php echo form_hidden('route', $this->input->get('route')) ?>
                                        <th class="text-center"></th>
                                        <th><?php echo form_input(array('name' => 'produk', 'class' => 'form-control', 'value' => $filter_produk, 'placeholder' => 'Item ...')) ?>
                                        </th>
                                        <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE || akses::hakKasir() == TRUE) { ?>
                                            <th></th>
                                        <?php } ?>
                                        <th class="text-right"></th>
                                        <th class="text-right"></th>
                                        <th style="width: 115px;">
                                            <button class="btn btn-primary btn-flat" type="submit"><i
                                                    class="fa fa-search"></i> Filter</button>
                                        </th>
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
                                            ?>
                                            <?php echo form_open(base_url('gudang/cart_opn_simpan.php'), 'id="gd_opn_proses_form"') ?>
                                            <?php echo form_hidden('no_nota', $this->input->get('nota')); ?>
                                            <?php echo form_hidden('id_barang', general::enkrip($barang->id)); ?>
                                            <?php echo form_hidden('kode', $barang->kode); ?>
                                            <?php echo form_hidden('satuan', $barang->id_satuan); ?>
                                            <?php echo form_hidden('rute', $_GET['route']); ?>
                                            <?php echo form_hidden('filter_jml', $_GET['jml']); ?>
                                            <?php echo form_hidden('filter_produk', $_GET['filter_produk']); ?>
                                            <?php echo form_hidden('filter_hal', $_GET['halaman']); ?>
                                            
                                            <tr>
                                                <td class="text-center" style="width: 50px;"><?php echo $no++ ?>.</td>
                                                <td style="width: 450px;">
                                                    <?php echo anchor(base_url('gudang/data_stok_tambah.php?id=' . general::enkrip($barang->id)), str_ireplace($filter_produk, '<b><u>' . $filter_produk . '</u></b>', $barang->produk), 'target="_blank"') ?>
                                                    <?php if (!empty($barang->produk_kand)) { ?>
                                                        <?php echo br() ?>
                                                        <small><i>(<?php echo strtolower($barang->produk_kand) ?>)</i></small>
                                                    <?php } ?>
                                                    <?php echo br() ?>
                                                    <small><i><?php echo $barang->produk_alias ?></i></small>
                                                </td>
                                                <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE || akses::hakKasir() == TRUE) { ?>
                                                    <?php $satuan = ($sql_satuan->jml > 0) ? floor($barang->jml / $sql_satuan->jml) : 0; ?>
                                                    <td class="text-right" style="width: 80px;">
                                                        <?php echo $barang->stok . ' ' . $sql_satuan->satuanTerkecil; ?></td>
                                                <?php } ?>
                                                <td class="text-right" style="width: 150px;">
                                                    <?php echo general::format_angka($barang->harga_jual) ?></td>
                                                <td class="text-right" style="width: 75px;">
                                                    <input type="text" name="jml" value="" class="form-control">
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-success btn-flat"><i
                                                            class="fa fa-check"></i> Input</button>
                                                </td>
                                            </tr>
                                            <?php echo form_close() ?>
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