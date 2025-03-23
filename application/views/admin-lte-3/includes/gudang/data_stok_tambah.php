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
                                    <div class="form-group <?php echo (!empty($hasError['jml']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Satuan</label>
                                        <select name="satuan" class="form-control rounded-0" disabled="TRUE">
                                            <option value="">- Pilih -</option>
                                            <?php foreach ($sql_satuan as $satuan) { ?>
                                                <option value="<?php echo $satuan->id ?>" <?php echo ($barang->id_satuan == $satuan->id ? 'selected' : '') ?>><?php echo $satuan->satuanTerkecil; //.' ('.$satuan->satuanBesar.')('.$satuan->jml.')'                    ?></option>
                                            <?php } ?>
                                        </select>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" onclick="window.location.href = '<?php echo base_url('gudang/data_stok_list.php') ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>
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
                                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i></button>
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
                    <div class="card card-default">
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
                                        <!--<th>Tgl</th>-->
                                        <!--<th>Kode</th>-->
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
                                                <div class="form-group <?php echo (!empty($hasError['gd']) ? 'has-error' : '') ?>">
                                                    <select name="gudang" class="form-control">
                                                        <option value="">- [Pilih] -</option>
                                                        <?php foreach ($gudang_ls as $gudang) { ?>
                                                            <option value="<?php echo $gudang->id ?>"><?php echo $gudang->gudang ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td style="width: 100px;"></td>
                                            <td style="width: 100px;"></td>
                                            <?php if (akses::hakSA() == TRUE) { ?>
                                                <td></td>
                                            <?php } ?>
                                            <td><?php // echo form_input(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control')) ?></td>
                                            <td colspan="2"><button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-search"></i> Cari</button></td>
                                        </tr>
                                    </tbody>
                                    <?php echo form_close() ?>
                                <?php } ?>
                                <tbody>
                                    <?php $tot_sm = 0;
                                    $tot_sk = 0; ?>
                                    <?php foreach ($barang_hist as $hist) { ?>
                                        <?php $sql_gudang = $this->db->where('id', $hist->id_gudang)->get('tbl_m_gudang')->row() ?>
                                        <?php $tot_sm = $tot_sm + ($hist->status == '1' || $hist->status == '2' || $hist->status == '3' ? ($hist->jml * $hist->jml_satuan) : 0); ?>
                                            <?php $tot_sk = $tot_sk + ($hist->status == '4' || $hist->status == '5' || $hist->status == '7' ? ($hist->jml * $hist->jml_satuan) : 0); ?>
                                        <tr>
                                            <td style="width: 350px;">
                                                <?php echo $sql_gudang->gudang ?><br/>
                                                <small><i><?php echo $this->ion_auth->user($hist->id_user)->row()->first_name ?></i></small><br/>
                                                <small><i><?php echo (!empty($hist->tgl_simpan) ? $this->tanggalan->tgl_indo5($hist->tgl_simpan) : $this->tanggalan->tgl_indo($hist->tgl_simpan)) ?></i></small>
                                            </td>
                                            <!--<td style="width: 100px;"><?php echo (!empty($hist->tgl_masuk) ? $this->tanggalan->tgl_indo5($hist->tgl_masuk) : $this->tanggalan->tgl_indo($hist->tgl_simpan)) ?></td>-->
                                            <!--<td style="width: 100px;"><?php echo $this->tanggalan->tgl_indo($hist->tgl_masuk) ?></td>-->
                                            <!--<td style="width: 180px;"><?php echo $hist->kode ?></td>-->
                                            <td style="width: 100px;" class="text-right"><?php echo $hist->jml * $hist->jml_satuan; //($hist->status == '3' ? $hist->jml * $hist->jml_satuan : $hist->jml)  ?></td>
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
                                                            $sql_nota_dt= $this->db->where('id', $hist->id_pembelian_det)->get('tbl_trans_beli_det')->row();
                                                            $nota_rw = $sql_nota->num_rows();
                                                            $nota_id = $hist->id_pembelian;
                                                            $nota = (!empty($hist->no_nota) && !empty($hist->id_pembelian) ? 'Pembelian ' . $hist->no_nota : (!empty($hist->keterangan) ? $hist->keterangan : '-')).(!empty($sql_nota_dt->kode_batch) ? br().'<small><i>['.$sql_nota_dt->kode_batch.']</i></small>' : '');
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
                                                            $sql_nota   = $this->db->where('id', $hist->id_pembelian)->get('tbl_trans_beli');
                                                            $sql_nota_dt= $this->db->where('id', $hist->id_pembelian_det)->get('tbl_trans_beli_det')->row();
                                                            $nota_rw    = $sql_nota->num_rows();
                                                            $nota_id    = $hist->id_pembelian;
                                                            $nota       = (!empty($hist->no_nota) && !empty($hist->id_pembelian) ? 'Pembelian ' . anchor(base_url('transaksi/trans_beli_det.php?id=' . general::enkrip($hist->id_pembelian)), $hist->no_nota, 'target="_blank"') : (!empty($hist->keterangan) ? $hist->keterangan : '-')).(!empty($sql_nota_dt->kode_batch) ? br().'<small><i>['.$sql_nota_dt->kode_batch.']</i></small>' : '');
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
                                                <?php } elseif (akses::hakOwner() == TRUE AND $hist->status == '2') { ?>
                                                    <?php echo anchor(base_url('gudang/data_stok_hapus_hist.php?id=' . general::enkrip($hist->id)) . '&uid=' . $this->input->get('id'), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $hist->kode . '] ? \')" class="label label-danger"') ?>
                                                    <?php echo nbs() ?>
                                                <?php } elseif (akses::hakAdminM() == TRUE AND $hist->status == '2') { ?>
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
                                    <?php if (akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakOwner2() == TRUE || akses::hakAdmin() == TRUE){ ?>
                                        <tr>
                                            <th colspan="4" class="text-right">Total Stok Masuk</th>
                                            <td class="text-right"><?php echo $tot_sm ?></td>
                                            <td colspan="4" class="text-left"><?php echo $prod_sat; ?></td>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-right">Total Stok Keluar</th>
                                            <td class="text-right"><?php echo $tot_sk ?></td>
                                            <td colspan="4" class="text-left"><?php echo $prod_sat; ?></td>
                                        </tr>
                                        <?php $sisa_st = $tot_sm - $tot_sk ?>
                                        <tr>
                                            <th colspan="4" class="text-right">Sisa</th>
                                            <td class="text-right"><?php echo (int) $sisa_st; ?></td>
                                            <td colspan="4" class="text-left"><?php echo $prod_sat; ?></td>
                                        </tr>
                                        <tr>
                                            <th colspan="5" class="text-right">
                                                <button type="button" class="btn btn-primary btn-flat"><i class="fa fa-history"></i> Sinkron</button>
                                            </td>
                                            <td colspan="4" class="text-left"></td>
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