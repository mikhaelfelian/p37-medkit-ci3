<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Laporan <small>Data Persedian Barang</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard.php') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li>Laporan</li>
            <li class="active">Produk</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-6">
                <?php echo form_open(base_url('laporan/set_lap_persediaan.php'), 'autocomplete="off"') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Laporan</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group <?php echo (!empty($hasError['tgl']) ? 'has-error' : '') ?>">
                            <label class="control-label">Semua</label>
                            <br/>
                            <input type="checkbox" name="semua" value="1"> Tampilkan Semua
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group <?php echo (!empty($hasError['tgl']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Tgl</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control pull-right', 'value' => '')) ?>
                                    </div>
                                </div>                            
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group <?php echo (!empty($hasError['tgl']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Rentang</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <?php echo form_input(array('id' => 'tgl_rentang', 'name' => 'tgl_rentang', 'class' => 'form-control pull-right', 'value' => '')) ?>
                                    </div>
                                </div>                            
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group <?php echo (!empty($hasError['stok']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Jml Stok</label>
                                    <div class="input-group date">
                                        <!--<span class="help-block text-bold"><i>* Satuan terkecil</i></span>-->
                                        <?php echo form_input(array('id' => 'stok', 'name' => 'stok', 'class' => 'form-control pull-right', 'value' => '')) ?>
                                        <span class="help-block"> <b>Param :</b> 
                                            <?php echo form_radio(array('name'=>'param', 'value'=>'1', 'checked'=>'TRUE')).' ='. nbs(3) ?>
                                            <?php echo form_radio(array('name'=>'param', 'value'=>'2')).' >'. nbs(3) ?>
                                            <?php echo form_radio(array('name'=>'param', 'value'=>'3')).' <'. nbs() ?>
                                        </span>
                                    </div>
                                </div>                           
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info btn-flat pull-right"><i class="fa fa-search"></i> Cari</button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>

        <?php if (!empty($produk)) { ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data Produk</h3>
                        </div>
                        <div class="box-body table-responsive">
                            <?php
                            $uri   = substr($this->uri->segment(2), 0, -4);
                            $case  = $this->input->get('case');
                            $query = $this->input->get('query');
                            $param = $this->input->get('filter_stok');
                            ?>
                            <button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo base_url('laporan/'.$uri.'_pdf.php?case='.$case.(isset($_GET['query']) ? '&query='.$query : '').(isset($_GET['filter_stok']) ? '&filter_stok='.$param : '')) ?>'"><i class="fa fa-file-pdf-o"></i> Cetak</button>
                            <?php echo br(2) ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tgl</th>
                                        <th>Kode</th>
                                        <th>Produk</th>
                                        <th class="text-center">Jml</th>
                                        <!--<th class="text-right">Harga Beli</th>-->
                                        <th class="text-right">Harga Jual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($produk)) { ?>
                                        <?php $no = 1; ?>
                                        <?php $total = 0; ?>
                                        <?php foreach ($produk as $produk) { ?>
                                            <?php $total = $total + $produk->harga_jual ?>
                                            <?php $tgl = explode('-', $produk->tgl_simpan) ?>
                                            <?php // $jml = $this->db->select('SUM(stok) as jml')->where('id_produk', $produk->id)->get('tbl_m_produk_stok')->row() ?>
                                            <tr>
                                                <td><?php echo $no++ ?></td>
                                                <td><?php echo $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0] ?></td>
                                                <td><?php echo $produk->kode ?></td>
                                                <td><?php echo $produk->produk ?></td>
                                                <td class="text-center"><?php echo (!empty($jml->jml) ? $jml->jml : $produk->jml) ?></td>
                                                <!--<td class="text-right"><?php echo general::format_angka($produk->harga_beli) ?></td>-->
                                                <td class="text-right"><?php echo general::format_angka($produk->harga_jual) ?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="5" class="text-right"><label>Total</label></td>
                                            <td class="text-right"><label><?php echo general::format_angka($total) ?></label></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
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
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/moment.js/2.11.2/moment.min.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/daterangepicker/daterangepicker-bs3.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.min.css') ?>">


<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins') ?>/JAutoNumber/autonumeric.js"></script>
<!-- Page script -->
<script>
                            $(function () {
                                //Date picker
                                $('#tgl').datepicker({
                                    autoclose: true,
                                });
                                $('#tgl_rentang').daterangepicker();
                            });

</script>