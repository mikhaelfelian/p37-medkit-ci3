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
                        <li class="breadcrumb-item active">Data Stok</li>
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
                <div class="col-md-4">
                    <?php echo form_open(base_url('master/data_kategori_' . (isset($_GET['id']) ? 'update' : 'simpan') . '.php'), 'autocomplete="off"') ?>
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Data Item</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php echo $this->session->flashdata('master'); ?>
                            <?php $hasError = $this->session->flashdata('form_error'); ?>
                            <?php echo form_hidden('id', $this->input->get('id')) ?>
                            <div class="form-group <?php echo (!empty($hasError['kode']) ? 'has-error' : '') ?>">
                                <label class="control-label">Kode</label>
                                <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control rounded-0', 'value' => $barang->kode, 'readonly' => 'TRUE')) ?>
                            </div>
                            <div class="form-group <?php echo (!empty($hasError['kode']) ? 'has-error' : '') ?>">
                                <label class="control-label">Item</label>
                                <?php echo form_input(array('id' => 'item', 'name' => 'item', 'class' => 'form-control rounded-0', 'value' => $barang->produk, 'readonly' => 'TRUE')) ?>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <label class="control-label">Jumlah</label>
                                    <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control text-right rounded-0', 'value' => $barang->jml, 'readonly' => 'TRUE')) ?>
                                </div>
                                <div class="col-8">
                                    <div
                                        class="form-group <?php echo (!empty($hasError['jml']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Satuan</label>
                                        <select name="satuan" class="form-control rounded-0" disabled="TRUE">
                                            <option value="">- Pilih -</option>
                                            <?php foreach ($sql_satuan as $satuan) { ?>
                                                <option value="<?php echo $satuan->id ?>" <?php echo ($barang->id_satuan == $satuan->id ? 'selected' : '') ?>>
                                                    <?php echo $satuan->satuanTerkecil; //.' ('.$satuan->satuanBesar.')('.$satuan->jml.')'                    ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button"
                                        onclick="window.location.href = '<?php echo base_url('gudang/data_stok_list.php') ?>'"
                                        class="btn btn-primary btn-flat">&laquo; Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
                <div class="col-md-6">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Data Stok Per Gudang</h3>
                            <div class="card-tools">
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php echo form_open(base_url('gudang/set_stok_update_gd.php'), 'autocomplete="off"') ?>
                            <?php echo form_hidden('id', $this->input->get('id')) ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama Gudang</th>
                                        <th class="text-center"></th>
                                        <th colspan="4" class="text-left">Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($gudang as $gd) { ?>
                                        <tr>
                                            <th><?php echo $gd->gudang; ?></th>
                                            <th>:</th>
                                            <td class="text-right" style="width: 120px;">
                                                <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE) { ?>
                                                    <?php echo form_input(array('id' => 'jml', 'name' => 'jml[' . $gd->id . ']', 'class' => 'form-control rounded-0', 'value' => $gd->jml)); ?>
                                                    <?php // echo form_input(array('name' => 'jml[' . $gd->id . ']', 'class' => 'form-control rounded-0', 'value' => $barang->jml)); ?>
                                                <?php } else { ?>
                                                    <?php echo form_input(array('id' => 'jml', 'name' => 'jml[' . $gd->id . ']', 'class' => 'form-control rounded-0', 'value' => $gd->jml, 'disabled' => 'TRUE')); ?>
                                                <?php } ?>
                                            </td>
                                            <td class="text-left"><?php echo $gd->satuan; ?></td>
                                            <td class="text-left">
                                                <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE) { ?>
                                                    <button type="submit" class="btn btn-primary btn-flat"><i
                                                            class="fa fa-save"></i></button>
                                                <?php } ?>
                                            </td>
                                            <td class="text-left"><?php echo general::status_gd($gd->status); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default rounded-0">
                        <div class="card-header">
                            <h3 class="card-title">Data Mutasi Stok</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>Gudang</th>
                                        <th class="text-right">Jml</th>
                                        <th>Satuan</th>
                                        <?php if (akses::hakSA() == TRUE) { ?>
                                            <th>Nominal</th>
                                        <?php } ?>
                                        <th>Keterangan</th>
                                        <th colspan="2"></th>
                                    </tr>
                                </thead>
                                <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE) { ?>
                                    <?php echo form_open(base_url('gudang/set_cari_stok_tambah.php'), 'autocomplete="off"') ?>
                                    <?php echo form_hidden('id_produk', general::enkrip($barang->id)) ?>

                                    <tbody>
                                        <tr>
                                            <td>
                                                <div
                                                    class="form-group <?php echo (!empty($hasError['gd']) ? 'has-error' : '') ?>">
                                                    <select name="gudang" class="form-control">
                                                        <option value="">- [Pilih] -</option>
                                                        <?php foreach ($gudang_ls as $gudang) { ?>
                                                            <option value="<?php echo $gudang->id ?>">
                                                                <?php echo $gudang->gudang ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td style="width: 100px;"></td>
                                            <td style="width: 100px;"></td>
                                            <?php if (akses::hakSA() == TRUE) { ?>
                                                <td></td>
                                            <?php } ?>
                                            <td><?php // echo form_input(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control')) ?>
                                            </td>
                                            <td colspan="2"><button type="submit" class="btn btn-primary btn-flat"><i
                                                        class="fa fa-search"></i> Cari</button></td>
                                        </tr>
                                    </tbody>
                                    <?php echo form_close() ?>
                                <?php } ?>
                                <tbody>
                                    <?php
                                    $tot_sm = 0;
                                    $tot_sk = 0;
                                    foreach ($barang_hist as $hist) {
                                        $qty = $hist->jml * $hist->jml_satuan;

                                        switch ($hist->status) {
                                            case '1': // Purchase
                                            case '3': // Sales Return
                                                $tot_sm += $qty;
                                                break;

                                            case '4': // Sales
                                            case '5': // Purchase Return
                                            case '7': // Stock Out
                                                $tot_sk += $qty;
                                                break;

                                            case '6': // Stock Opname
                                                // Stock Opname should be counted as stock in as it sets the initial/adjustment stock
                                                $tot_sm += $qty;
                                                break;

                                            case '2': // Stock Adjustment
                                                // Check if it's stock addition or reduction
                                                if (
                                                    stripos($hist->keterangan, 'masuk') !== false ||
                                                    stripos($hist->keterangan, 'tambah') !== false
                                                ) {
                                                    $tot_sm += $qty;
                                                } else if (
                                                    stripos($hist->keterangan, 'keluar') !== false ||
                                                    stripos($hist->keterangan, 'kurang') !== false
                                                ) {
                                                    $tot_sk += $qty;
                                                }
                                                break;

                                            case '8': // Stock Transfer
                                                if ($hist->id_gudang == $gd) { // If this is destination warehouse
                                                    $tot_sm += $qty;
                                                } else { // If this is source warehouse
                                                    $tot_sk += $qty;
                                                }
                                                break;
                                        }
                                    }

                                    // Calculate current stock
                                    $sisa_st = $tot_sm - $tot_sk;
                                    ?>
                                    <?php foreach ($barang_hist as $hist) { ?>
                                        <?php $sql_gudang = $this->db->where('id', $hist->id_gudang)->get('tbl_m_gudang')->row() ?>
                                        <tr>
                                            <td style="width: 350px;">
                                                <?php echo $sql_gudang->gudang ?><br />
                                                <small><i><?php echo $this->ion_auth->user($hist->id_user)->row()->first_name ?></i></small><br />
                                                <small><i><?php echo (!empty($hist->tgl_simpan) ? $this->tanggalan->tgl_indo5($hist->tgl_simpan) : $this->tanggalan->tgl_indo($hist->tgl_simpan)) ?></i></small>
                                            </td>
                                            <td style="width: 100px;" class="text-right">
                                                <?php echo $hist->jml * $hist->jml_satuan; //($hist->status == '3' ? $hist->jml * $hist->jml_satuan : $hist->jml)  ?>
                                            </td>
                                            <td style="width: 150px;">
                                                <?php echo $sql_satuan->satuanTerkecil; // $hist->satuan.' ('.$hist->jml * $hist->jml_satuan.' '.$sql_satuan->satuanTerkecil.')'  ?>
                                            </td>
                                            <?php if (akses::hakSA() == TRUE) { ?>
                                                <td class="text-right"><?php echo general::format_angka($hist->nominal) ?></td>
                                            <?php } ?>
                                            <td style="width: 600px;">
                                                <?php if (akses::hakAdmin() == TRUE || akses::hakAdminM() == TRUE || akses::hakGudang() == TRUE && $hist->status != '3' && $hist->status != '2') { ?>
                                                    <?php $nota_beli = $this->db->where('id', $hist->id_pembelian)->get('tbl_trans_beli')->row(); ?>
                                                    <?php
                                                    switch ($hist->status) {
                                                        case '1':
                                                            $sql_nota = $this->db->where('id', $hist->id_pembelian)->get('tbl_trans_beli');
                                                            $sql_nota_dt = $this->db->where('id', $hist->id_pembelian_det)->get('tbl_trans_beli_det')->row();
                                                            $nota_rw = $sql_nota->num_rows();
                                                            $nota_id = $hist->id_pembelian;
                                                            $nota = (!empty($hist->no_nota) && !empty($hist->id_pembelian) ? 'Pembelian ' . $hist->no_nota : (!empty($hist->keterangan) ? $hist->keterangan : '-')) . (!empty($sql_nota_dt->kode_batch) ? br() . '<small><i>[' . $sql_nota_dt->kode_batch . ']</i></small>' : '');
                                                            break;

                                                        case '2':
                                                            $sql_nota = '';
                                                            $nota_rw = '';
                                                            $nota_id = '';
                                                            $nota = (!empty($hist->keterangan) ? $hist->keterangan : '-');
                                                            break;

                                                        case '3':
                                                            $sql_nota = $this->db->where('id', $hist->id_penjualan)->get('tbl_trans_retur_jual');
                                                            $nota_rw = $sql_nota->num_rows();
                                                            $nota_id = $hist->id_penjualan;
                                                            $nota = (!empty($nota_rw) ? 'Retur Penjualan ' . anchor(base_url('transaksi/trans_retur_jual_det.php?id=' . general::enkrip($hist->id_penjualan)), $sql_nota->row()->no_retur . (!empty($sql_nota->row()->kode_nota_blk) ? $sql_nota->row()->kode_nota_blk : ''), 'target="_blank"') : $hist->keterangan); //.anchor(base_url('transaksi/trans_retur_jual_det.php?id='.general::enkrip($hist->id_penjualan), $sql_nota->row()->no_retur.(!empty($sql_nota->row()->kode_nota_blk) ? $sql_nota->row()->kode_nota_blk : ''), 'target="_blank"'))
                                                            break;

                                                        case '4':
                                                            $sql_nota = $this->db->where('id', $hist->id_penjualan)->get('tbl_trans_jual');
                                                            $nota_rw = $sql_nota->num_rows();
                                                            $nota_id = $hist->id_penjualan;
                                                            $nota = (akses::hakGudang() == TRUE ? 'Penjualan ' . $sql_nota->row()->no_nota . (!empty($sql_nota->row()->kode_nota_blk) ? '/' . $sql_nota->row()->kode_nota_blk : '') : 'Penjualan ' . anchor(base_url('transaksi/trans_jual_det.php?id=' . general::enkrip($hist->id_penjualan)), $sql_nota->row()->no_nota . (!empty($sql_nota->row()->kode_nota_blk) ? '/' . $sql_nota->row()->kode_nota_blk : ''), 'target="_blank"'));
                                                            break;

                                                        case '5':
                                                            $sql_nota = $this->db->where('id', $hist->id_pembelian)->get('tbl_trans_retur_beli');
                                                            $nota_rw = $sql_nota->num_rows();
                                                            $nota_id = $hist->id_pembelian;
                                                            $nota = (!empty($nota_rw) ? 'Retur Pembelian ' . anchor(base_url('transaksi/trans_retur_beli_det.php?id=' . general::enkrip($hist->id_pembelian)), '#' . sprintf('%05s', $hist->id_pembelian) . (!empty($sql_nota->row()->kode_nota_blk) ? $sql_nota->row()->kode_nota_blk : ''), 'target="_blank"') : $hist->keterangan);
                                                            break;

                                                        case '6':
                                                            $sql_nota = '';
                                                            $nota_rw = '';
                                                            $nota_id = '';
                                                            $nota = (!empty($hist->keterangan) ? $hist->keterangan : '-');
                                                            break;

                                                        case '7':
                                                            $sql_nota = '';
                                                            $nota_rw = '';
                                                            $nota_id = '';
                                                            $nota = (!empty($hist->keterangan) ? $hist->keterangan : '-');
                                                            break;

                                                        case '8':
                                                            $nota = $hist->keterangan . ' [' . anchor(base_url('gudang/trans_mutasi_det.php?id=' . general::enkrip($hist->id_penjualan)), '#' . $hist->no_nota) . ']';
                                                            break;
                                                    }

                                                    $keterangan = (!empty($nota_id) ? (!empty($nota_rw) ? $nota : $hist->keterangan) : $hist->keterangan);
                                                    echo (empty($keterangan) ? $hist->keterangan : $keterangan);
                                                    ?>
                                                <?php } else { ?>
                                                    <?php
                                                    switch ($hist->status) {
                                                        case '1':
                                                            $sql_nota = $this->db->where('id', $hist->id_pembelian)->get('tbl_trans_beli');
                                                            $sql_nota_dt = $this->db->where('id', $hist->id_pembelian_det)->get('tbl_trans_beli_det')->row();
                                                            $nota_rw = $sql_nota->num_rows();
                                                            $nota_id = $hist->id_pembelian;
                                                            $nota = (!empty($hist->no_nota) && !empty($hist->id_pembelian) ? 'Pembelian ' . anchor(base_url('transaksi/trans_beli_det.php?id=' . general::enkrip($hist->id_pembelian)), $hist->no_nota, 'target="_blank"') : (!empty($hist->keterangan) ? $hist->keterangan : '-')) . (!empty($sql_nota_dt->kode_batch) ? br() . '<small><i>[' . $sql_nota_dt->kode_batch . ']</i></small>' : '');
                                                            break;

                                                        case '2':
                                                            $sql_nota = '';
                                                            $nota_rw = '';
                                                            $nota_id = '';
                                                            $nota = (!empty($hist->keterangan) ? $hist->keterangan : '-');
                                                            break;

                                                        case '3':
                                                            $sql_nota = $this->db->where('id', $hist->id_penjualan)->get('tbl_trans_retur_jual');
                                                            $nota_rw = $sql_nota->num_rows();
                                                            $nota_id = $hist->id_penjualan;
                                                            $nota = (!empty($nota_rw) ? 'Retur Penjualan ' . anchor(base_url('transaksi/trans_retur_jual_det.php?id=' . general::enkrip($hist->id_penjualan)), $sql_nota->row()->no_retur . (!empty($sql_nota->row()->kode_nota_blk) ? $sql_nota->row()->kode_nota_blk : ''), 'target="_blank"') : $hist->keterangan); //.anchor(base_url('transaksi/trans_retur_jual_det.php?id='.general::enkrip($hist->id_penjualan), $sql_nota->row()->no_retur.(!empty($sql_nota->row()->kode_nota_blk) ? $sql_nota->row()->kode_nota_blk : ''), 'target="_blank"'))
                                                            break;

                                                        case '4':
                                                            $sql_nota = $this->db->where('id', $hist->id_penjualan)->get('tbl_trans_jual');
                                                            $nota_rw = $sql_nota->num_rows();
                                                            $nota_id = $hist->id_penjualan;
                                                            $nota = (!empty($nota_rw) ? 'Penjualan ' . anchor(base_url('transaksi/trans_jual_det.php?id=' . general::enkrip($hist->id_penjualan)), $sql_nota->row()->no_nota . (!empty($sql_nota->row()->kode_nota_blk) ? '/' . $sql_nota->row()->kode_nota_blk : ''), 'target="_blank"') : $hist->keterangan);
                                                            break;

                                                        case '5':
                                                            $sql_nota = $this->db->where('id', $hist->id_pembelian)->get('tbl_trans_retur_beli');
                                                            $nota_rw = $sql_nota->num_rows();
                                                            $nota_id = $hist->id_pembelian;
                                                            $nota = (!empty($nota_rw) ? 'Retur Pembelian ' . anchor(base_url('transaksi/trans_retur_beli_det.php?id=' . general::enkrip($hist->id_pembelian)), '#' . sprintf('%05s', $hist->id_pembelian) . (!empty($sql_nota->row()->kode_nota_blk) ? $sql_nota->row()->kode_nota_blk : ''), 'target="_blank"') : $hist->keterangan);
                                                            break;

                                                        case '6':
                                                            $sql_nota = '';
                                                            $nota_rw = '';
                                                            $nota_id = '';
                                                            $nota = (!empty($hist->keterangan) ? $hist->keterangan : '-');
                                                            break;

                                                        case '7':
                                                            $sql_nota = '';
                                                            $nota_rw = '';
                                                            $nota_id = '';
                                                            $nota = (!empty($hist->keterangan) ? $hist->keterangan : '-');
                                                            break;

                                                        case '8':
                                                            $nota = $hist->keterangan . ' [' . anchor(base_url('gudang/trans_mutasi_det.php?id=' . general::enkrip($hist->id_penjualan)), '#' . $hist->no_nota) . ']';
                                                            break;
                                                    }

                                                    $keterangan = (!empty($nota_id) ? (!empty($nota_rw) ? $nota : $hist->keterangan) : $hist->keterangan);
                                                    echo $nota; //(empty($keterangan) ? $hist->keterangan : $keterangan);
                                                    ?>
                                                <?php } ?>
                                            </td>
                                            <?php if (akses::hakOwner2() == TRUE) { ?>
                                                <td></td>
                                            <?php } else { ?>
                                                <td>
                                                    <?php echo general::status_stok($hist->status) ?>
                                                </td>
                                            <?php } ?>
                                            <td>
                                                <?php // if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakOwner2() == TRUE || akses::hakAdmin() == TRUE && $hist->status != '3'){ ?>
                                                <?php if (akses::hakSA() == TRUE) { ?>
                                                    <?php echo anchor(base_url('gudang/data_stok_hapus_hist.php?id=' . general::enkrip($hist->id)) . '&uid=' . $this->input->get('id'), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $hist->kode . '] ? \')" class="label label-danger"') ?>
                                                    <?php echo nbs() ?>
                                                <?php } elseif (akses::hakOwner() == TRUE and $hist->status == '2') { ?>
                                                    <?php echo anchor(base_url('gudang/data_stok_hapus_hist.php?id=' . general::enkrip($hist->id)) . '&uid=' . $this->input->get('id'), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $hist->kode . '] ? \')" class="label label-danger"') ?>
                                                    <?php echo nbs() ?>
                                                <?php } elseif (akses::hakAdminM() == TRUE and $hist->status == '2') { ?>
                                                    <?php echo anchor(base_url('gudang/data_stok_hapus_hist.php?id=' . general::enkrip($hist->id)) . '&uid=' . $this->input->get('id'), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $hist->kode . '] ? \')" class="label label-danger"') ?>
                                                    <?php echo nbs() ?>
                                                <?php } elseif (akses::hakAdmin() == TRUE) { ?>
                                                    <?php if ($hist->status != '1') { ?>
                                                        <?php // echo anchor(base_url('gudang/data_stok_hapus_hist.php?id=' . general::enkrip($hist->id)).'&uid='.$this->input->get('id'), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $hist->kode . '] ? \')" class="label label-danger"') ?>
                                                        <?php echo nbs() ?>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <!--<label class="label label-default" ><i class="fa fa-remove"></i> Hapus</label>-->
                                                    <?php // echo nbs() ?>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php
                                    // coun $tot_sm from tbl_m_produk_hist.jml * jml_satuan where tbl_m_produk_hist.status=1
                                    // reset count and start while found tbl_m_produk_hist.status=6 count from here :
                                    // tbl_m_produk_hist.jml * tbl_m_produk_hist.jml_satuan WHERE tbl_m_produk_hist.status=6  count all from tbl_m_produk_hist.status = 6 + count from tbl_m_produk_hist.status=4 for $tot_sm then count from tbl_m_produk_hist.status=4 below of tbl_m_produk_hist.status=6 then count globally from tbl_m_produk_stok.jml where tbl_m_produk_stok.id_produk
                                    // count $tot_sk from tbl_m_produk_hist.jml * jml_satuan where tbl_m_produk_hist.status=4
                                    // Find the latest status=6 record (stock reset)
                                    $reset_point = $this->db->select('id, tgl_simpan')
                                        ->where('id_produk', $barang->id)
                                        ->where('status', 6)
                                        ->order_by('tgl_simpan', 'DESC')
                                        ->limit(1)
                                        ->get('tbl_m_produk_hist')
                                        ->row();

                                    // Calculate stock in
                                    $tot_sm = 0;
                                    if ($reset_point) {
                                        // If reset point exists, start counting from that point
                                        $reset_value = $this->db->select('SUM(jml * jml_satuan) as total')
                                            ->where('id_produk', $barang->id)
                                            ->where('status', 6)
                                            ->where('id', $reset_point->id)
                                            ->get('tbl_m_produk_hist')
                                            ->row();

                                        // Get stock in (status=1) after reset point
                                        $stok_masuk_after_reset = $this->db->select('SUM(jml * jml_satuan) as total')
                                            ->where('id_produk', $barang->id)
                                            ->where('status', 1)
                                            ->where('tgl_simpan >', $reset_point->tgl_simpan)
                                            ->get('tbl_m_produk_hist')
                                            ->row();

                                        // Total stock in is reset value + new stock in
                                        $tot_sm = ($reset_value ? $reset_value->total : 0) +
                                            ($stok_masuk_after_reset ? $stok_masuk_after_reset->total : 0);
                                    } else {
                                        // If no reset point, count all stock in
                                        $stok_masuk = $this->db->select('SUM(jml * jml_satuan) as total')
                                            ->where('id_produk', $barang->id)
                                            ->where('status', 1)
                                            ->get('tbl_m_produk_hist')
                                            ->row();
                                        if ($stok_masuk) {
                                            $tot_sm = $stok_masuk->total;
                                        }
                                    }

                                    // Calculate stock out
                                    $tot_sk = 0;
                                    if ($reset_point) {
                                        // If reset point exists, only count stock out after reset point
                                        $stok_keluar = $this->db->select('SUM(jml * jml_satuan) as total')
                                            ->where('id_produk', $barang->id)
                                            ->where('status', 4)
                                            ->where('tgl_simpan >', $reset_point->tgl_simpan)
                                            ->get('tbl_m_produk_hist')
                                            ->row();
                                        if ($stok_keluar) {
                                            $tot_sk = $stok_keluar->total;
                                        }
                                    } else {
                                        // If no reset point, count all stock out
                                        $stok_keluar = $this->db->select('SUM(jml * jml_satuan) as total')
                                            ->where('id_produk', $barang->id)
                                            ->where('status', 4)
                                            ->get('tbl_m_produk_hist')
                                            ->row();
                                        if ($stok_keluar) {
                                            $tot_sk = $stok_keluar->total;
                                        }
                                    }

                                    // Get current global stock from product stock table
                                    $current_stock = $this->db->select('SUM(jml) as total')
                                        ->where('id_produk', $barang->id)
                                        ->get('tbl_m_produk_stok')
                                        ->row();
                                    $global_stock = $current_stock ? $current_stock->total : 0;

                                    if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakOwner2() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE) { ?>
                                        <?php
                                        // Calculate stock opname (SO)
                                        $tot_so = 0;
                                        // If no reset point, count all SO
                                        $stok_opname = $this->db->select('SUM(jml * jml_satuan) as total')
                                            ->where('id_produk', $barang->id)
                                            ->where('status', 6)
                                            ->get('tbl_m_produk_hist')
                                            ->row();
                                        if ($stok_opname) {
                                            $tot_so = $stok_opname->total;
                                        }
                                        ?>
                                        <tr>
                                            <th colspan="4" class="text-right">Total Stok Opname</th>
                                            <td class="text-right"><?php echo number_format($tot_so, 0) ?></td>
                                            <td colspan="4" class="text-left"><?php echo $prod_sat; ?></td>
                                        </tr><tr>
                                            <th colspan="4" class="text-right">Total Stok Masuk</th>
                                            <td class="text-right"><?php echo number_format($tot_sm, 0) ?></td>
                                            <td colspan="4" class="text-left"><?php echo $prod_sat; ?></td>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-right">Total Stok Keluar</th>
                                            <td class="text-right"><?php echo number_format($tot_sk, 0) ?></td>
                                            <td colspan="4" class="text-left"><?php echo $prod_sat; ?></td>
                                        </tr>
                                        <?php 
                                        if (!empty($tot_so)) {
                                            // If stock opname exists, calculate remaining stock based on SO + stock in after reset - stock out
                                            $stok_masuk_after_reset = 0;
                                            if ($reset_point) {
                                                $sm_after_reset = $this->db->select('SUM(jml * jml_satuan) as total')
                                                    ->where('id_produk', $barang->id)
                                                    ->where('status', 1)
                                                    ->where('tgl_simpan >', $reset_point->tgl_simpan)
                                                    ->get('tbl_m_produk_hist')
                                                    ->row();
                                                $stok_masuk_after_reset = $sm_after_reset ? $sm_after_reset->total : 0;
                                            }
                                            $sisa_st = $tot_so + $stok_masuk_after_reset - $tot_sk;
                                        } else {
                                            // If no stock opname, simply calculate stock in - stock out
                                            $sisa_st = $tot_sm - $tot_sk;
                                        }
                                        ?>
                                        <tr>
                                            <th colspan="4" class="text-right">Sisa Stok</th>
                                            <td class="text-right"><?php echo number_format($global_stock, 0); ?></td>
                                            <td colspan="4" class="text-left"><?php echo $prod_sat; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">

                                </div>
                                <div class="col-lg-6 text-right">

                                </div>
                            </div>
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

<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<script type="text/javascript">
    $(function () {
        $("input[id=jml]").keydown(function (e) {
            // kibot: backspace, delete, tab, escape, enter .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                // kibot: Ctrl+A, Command+A
                (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // kibot: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                // Biarin wae, ga ngapa2in return false
                return;
            }

            // Cuman nomor
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

        <?php echo $this->session->flashdata('gudang_toast'); ?>
    });
</script>

<script>
    $(function () {
        $('#date_range').daterangepicker({
            locale: {
                format: 'MM/DD/YYYY'
            },
            startDate: moment().startOf('month'),
            endDate: moment().endOf('month')
        });

        $('#date_range').on('apply.daterangepicker', function (ev, picker) {
            // Reload the page with the new date range
            window.location.href = '<?php echo base_url("gudang/data_stok_tambah.php?id=" . $this->input->get("id")); ?>&start_date=' +
                picker.startDate.format('YYYY-MM-DD') + '&end_date=' + picker.endDate.format('YYYY-MM-DD');
        });
    });
</script>