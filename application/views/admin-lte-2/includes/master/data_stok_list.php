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
                        <h3 class="box-title"></h3>
                    </div>
                    <div class="box-body">
                        <?php echo (!empty($cetak) ? $cetak : '') ?>
                        <!--<button type="button" onclick="window.location.href = '<?php echo base_url('gudang/data_stok_import.php') ?>'" class="btn btn-warning btn-flat"><i class="fa fa-upload"></i> Import</button>-->
                        <!--<button type="button" onclick="window.location.href = '<?php echo base_url('gudang/data_stok_export.php') ?>'" class="btn btn-warning btn-flat"><i class="fa fa-download"></i> Unduh Template</button>-->
                        <!--<button type="button" onclick="window.location.href = '<?php // echo site_url('page=master&act=ex_data_stok_cth') ?>'" class="btn btn-warning btn-flat"><i class="fa fa-download"></i> Eksport ke eFaktur</button>-->
                        <?php echo br(2) ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Kode</th>
                                    <th>
                                        <?php $so = $this->input->get('sort_order') ?>
                                        <?php echo anchor(base_url('gudang/data_stok_list.php?sort_type=produk&sort_order=' . ($so == 'asc' ? 'desc' : 'asc') . (!empty($jml) ? '&jml=' . $jml : '')), 'Barang ' . ($so == 'asc' ? '<i class="fa fa-sort-up"></i>' : ($so == 'desc' ? '<i class="fa fa-sort-down"></i>' : '<i class="fa fa-sort"></i>')), 'style="color: #000;"') ?>
                                    </th>
                                    <th class="text-center" colspan="2">
                                        <?php $so = $this->input->get('sort_order') ?>
                                        <?php echo anchor(base_url('gudang/data_stok_list.php?sort_type=jml&sort_order=' . ($so == 'asc' ? 'desc' : 'asc') . (!empty($jml) ? '&jml=' . $jml : '')), 'Jumlah ' . ($so == 'asc' ? '<i class="fa fa-sort-up"></i>' : ($so == 'desc' ? '<i class="fa fa-sort-down"></i>' : '<i class="fa fa-sort"></i>')), 'style="color: #000;"') ?>
                                    </th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <?php echo form_open(base_url('gudang/set_cari_stok.php')) ?>
                                        <th class="text-center"></th>
                                        <th><?php echo form_input(array('name'=>'kode', 'class'=>'form-control', 'style'=>'width:100px;')) ?></th>
                                        <th><?php echo form_input(array('name'=>'produk', 'class'=>'form-control')) ?></th>
                                        <th class="text-center"><?php echo form_input(array('name'=>'sa', 'class'=>'form-control', 'style'=>'width:50px;')) ?></th>
                                        <th class="text-center"><?php // echo form_input(array('name'=>'kode', 'class'=>'form-control', 'style'=>'width:50px;')) ?></th>
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
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td><?php echo anchor(base_url('gudang/data_stok_det.php?id='.general::enkrip($barang->id)),$barang->kode) ?></td>
                                                <td><?php echo $barang->produk ?></td>
                                                <td class="text-right"><?php echo $barang->jml.' '.$sql_satuan->satuanTerkecil ?></td>
                                                <td class="text-left"><?php echo '('.ceil($barang->jml / $sql_satuan->jml).' '.$sql_satuan->satuanBesar.')' ?></td>
                                                <td>
                                                    <?php if(akses::hakSA() == TRUE){ ?>
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