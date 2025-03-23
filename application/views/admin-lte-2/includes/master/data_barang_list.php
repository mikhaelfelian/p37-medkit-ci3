<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Barang <small></small></h1>
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
                        <?php if(akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakAdmin() == TRUE OR akses::hakAdminM() == TRUE){ ?>
                            <button type="button" onclick="window.location.href = '<?php echo base_url('master/data_barang_tambah.php') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Tambah</button>
                            <?php // echo (!empty($cetak) ? $cetak : '') ?>
                            <?php echo br(2) ?>
                            <!--<button type="button" onclick="window.location.href = '<?php echo base_url('master/data_barang_import.php') ?>'" class="btn btn-warning btn-flat"><i class="fa fa-upload"></i> Import</button>-->
                            <!--<button type="button" onclick="window.location.href = '<?php echo base_url('master/data_barang_export.php') ?>'" class="btn btn-warning btn-flat"><i class="fa fa-download"></i> Unduh Template</button>-->
                            <!--<button type="button" onclick="window.location.href = '<?php // echo site_url('page=master&act=ex_data_barang_cth') ?>'" class="btn btn-warning btn-flat"><i class="fa fa-download"></i> Eksport ke eFaktur</button>-->
                        <?php // }else{ ?>
                            <?php // echo (!empty($cetak) ? $cetak : '') ?>
                        <?php } ?>
                        <?php 
                            $filter_kode     = strtoupper($this->input->get('filter_kode'));
                            $filter_produk   = strtoupper($this->input->get('filter_produk'));
                            $filter_barcode  = $this->input->get('filter_barcode');
                            $filter_stok     = $this->input->get('filter_stok');
                            $filter_merk     = $this->input->get('filter_merk');
                            $filter_lokasi   = $this->input->get('filter_lokasi');                        
                            $jml             = $this->input->get('jml');                        
                        ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Merk</th>
                                    <th>Kategori</th>
                                    <th>
                                        <?php $so = $this->input->get('sort_order') ?>
                                        <?php echo anchor(base_url('master/data_barang_list.php?sort_type=produk&sort_order=' . ($so == 'asc' ? 'desc' : 'asc') . (!empty($jml) ? '&jml=' . $jml : '')), 'Barang ' . ($so == 'asc' ? '<i class="fa fa-sort-up"></i>' : ($so == 'desc' ? '<i class="fa fa-sort-down"></i>' : '<i class="fa fa-sort"></i>')), 'style="color: #000;"') ?>
                                    </th>
                                    <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE || akses::hakKasir() == TRUE){ ?>
                                        <th class="text-center">
                                            Stok
                                        </th>
                                    <?php } ?>
                                    <th class="text-right">Harga Satuan</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <?php echo form_open(base_url('master/set_cari_barang.php')) ?>
                                        <th class="text-center"></th>
                                        <th class="text-center">
                                            <select name="merk" class="form-control">
                                                <option value="">- Merk -</option>
                                                <?php $sql_merks = $this->db->order_by('merk','asc')->get('tbl_m_merk')->result();  ?>
                                                <?php foreach ($sql_merks as $merk){  ?>
                                                <option value="<?php echo $merk->id ?>"><?php echo strtoupper($merk->merk) ?></option>
                                                <?php } ?>
                                            </select>
                                        </th>
                                        <th class="text-center">
                                            <select name="kategori" class="form-control">
                                                <option value="">- Kategori -</option>
                                                <?php $sql_loks = $this->db->order_by('kategori','asc')->get('tbl_m_kategori')->result();  ?>
                                                <?php foreach ($sql_loks as $lok){  ?>
                                                    <option value="<?php echo $lok->id ?>"><?php echo strtoupper($lok->keterangan) ?></option>
                                                <?php } ?>
                                            </select>
                                        </th>
                                        <th><?php echo form_input(array('name'=>'produk', 'class'=>'form-control', 'value'=>$filter_produk)) ?></th>
                                        <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE || akses::hakKasir() == TRUE){ ?>
                                            <th></th>
                                        <?php } ?>
                                        <th class="text-right"><?php echo form_input(array('name'=>'harga', 'class'=>'form-control', 'value'=>$filter_harga)) ?></th>
                                        <th><button class="btn btn-primary btn-flat" type="submit"><i class="fa fa-search"></i> Filter</button></th>
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
                                            $sql_stok   = $this->db->select('SUM(jml * jml_satuan) AS jml')->where('id_produk', $barang->id)->get('tbl_m_produk_stok')->row();

                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td><?php echo (!empty($sql_mrk->merk) ? strtoupper($sql_mrk->merk) : '-') ?></td>
                                                <td><?php echo (!empty($sql_kat->keterangan) ? strtoupper($sql_kat->keterangan) : '-') ?></td>
                                                <td><?php echo anchor(base_url('master/data_barang_det.php?id='.general::enkrip($barang->id)), str_ireplace($filter_produk, '<b><u>'.$filter_produk.'</u></b>', $barang->produk)) ?></td>
                                                <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE || akses::hakKasir() == TRUE){ ?>
                                                <?php $satuan = floor($barang->jml / $sql_satuan->jml); ?>
                                                    <td class="text-right"><?php echo (!empty($sql_stok->jml) ? $sql_stok->jml : '0').' '.$sql_satuan->satuanTerkecil; ?></td>
                                                <?php } ?>
                                                <td class="text-right"><?php echo general::format_angka($barang->harga_jual) ?></td>
                                                <td>
                                                    <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE){ ?>
                                                        <?php echo anchor(site_url('page=master&act=cek_satuan&id='.general::enkrip($barang->id)), '<i class="fa fa-edit"></i> Ubah', 'class="label label-success"') ?>
                                                        <?php echo nbs() ?>
                                                        <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE){ ?>
                                                            <?php echo anchor(base_url('master/data_barang_hapus.php?id=' . general::enkrip($barang->id)), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $barang->produk . '] ? \')" class="label label-danger"') ?>
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