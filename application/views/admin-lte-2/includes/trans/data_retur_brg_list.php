<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Barang <small>Retur</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li>Retur</li>
            <li class="active">Barang Retur</li>
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
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url('dashboard.php') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                            <li>Retur</li>
                            <li class="active">Barang Retur</li>
                        </ol>
                    </div>
                    <div class="box-body table-responsive">
                        <?php 
                            $filter_kode     = strtoupper($this->input->get('filter_kode'));
                            $filter_produk   = strtoupper($this->input->get('filter_produk'));
                            $filter_barcode  = $this->input->get('filter_barcode');
                            $filter_stok     = $this->input->get('filter_stok');
                            $filter_merk     = $this->input->get('filter_merk');
                            $filter_lokasi   = $this->input->get('filter_lokasi');                        
                            $jml             = $this->input->get('jml');                        
                        ?>
                        <?php echo br(2) ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Tgl Retur</th>
                                    <th>Kode</th>
                                    <th>Barang</th>
                                    <th class="text-right">Jml</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <?php echo form_open(base_url('transaksi/set_cari_barang_bs.php'), 'autocomplete="off"') ?>
                                        <th class="text-center"></th>
                                        <th><?php echo form_input(array('id'=>'tgl_retur','name'=>'tgl_retur', 'class'=>'form-control', 'value'=>$filter_tgl)) ?></th>
                                        <th><?php echo form_input(array('name'=>'kode', 'class'=>'form-control', 'style'=>'width:100px;', 'value'=>$filter_kode)) ?></th>
                                        <th><?php echo form_input(array('name'=>'produk', 'class'=>'form-control', 'value'=>$filter_produk)) ?></th>
                                        <th class="text-right"></th>
                                        <th class="text-right"></th>
                                        <th><button class="btn btn-primary btn-flat" type="submit"><i class="fa fa-search"></i> Filter</button></th>
                                    <?php echo form_close() ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($barang)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($barang as $barang) {
                                            $sql_satuan = $this->db->where('id', $barang->id_satuan)->get('tbl_m_satuan')->row();

                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td><?php echo $this->tanggalan->tgl_indo($barang->tgl_simpan) ?></td>
                                                <td><?php echo anchor(base_url('master/data_barang_det.php?id='.general::enkrip($barang->id)), str_ireplace($filter_kode, '<b><u>'.$filter_kode.'</u></b>', $barang->kode)) ?></td>
                                                <td><?php echo str_ireplace($filter_produk, '<b><u>'.$filter_produk.'</u></b>', $barang->produk) ?></td>
                                                <td class="text-right"><?php echo (float)$barang->jml.(!empty($barang->satuan) ? ' '.$barang->satuan : '') ?></td>
                                                <td><?php // echo $barang->keterangan ?></td>
                                                <td><?php echo anchor('page=transaksi&act=data_retur_brg_hps&id='.general::enkrip($barang->id), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $barang->produk . '] ? \')" class="label label-danger"') ?></td>
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
<!--Datepicker-->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">
<script>   
    $(function () {
        // Tanggal Retur
        $('#tgl_retur').datepicker({
            autoclose: true,
        });
    });
</script>