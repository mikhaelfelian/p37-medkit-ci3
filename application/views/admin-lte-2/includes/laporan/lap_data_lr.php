<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Laporan <small>Data Laba / Rugi</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard.php') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li>Laporan</li>
            <li class="active">L / R</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-6">
                <?php echo form_open('page=laporan&act=set_lap_lr', 'autocomplete="off"') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Laporan</h3>
                    </div>
                    <div class="box-body">
<!--                        <div class="form-group">
                            <label class="control-label">Semua</label>
                            <br/>
                            <input type="checkbox" name="semua" value="1"> Semua
                        </div>-->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
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
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info btn-flat pull-right"><i class="fa fa-search"></i> Cari</button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>

        <?php if (!empty($penjualan)) { ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data Laba / Rugi</h3>
                        </div>
                        <div class="box-body">
                            <button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo base_url('laporan/ex_data_lr.php?case='.$this->input->get('case').'&query='.$this->input->get('query').'&tgl_awal='.$this->input->get('tgl_awal').'&tgl_akhir='.$this->input->get('tgl_akhir').'') ?>'"><i class="fa fa-file-pdf-o"></i> Cetak</button>
                            
                            <?php echo br(2) ?>
                            <div class="row">
                                <div class="col-lg-8">
                                    <h3 class="box-title"><?php echo $keterangan; ?></h3>
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Penjualan</th>
                                            <th>:</th>
                                            <th class="text-right"><?php echo general::format_angka($penjualan->jml_subtotal) ?></th>
                                            <th class="text-right"></th>
                                        </tr>
                                        <tr>
                                            <th>Retur Penjualan</th>
                                            <th>:</th>
                                            <th class="text-right">(<?php echo general::format_angka($jml_retur_penj) ?>)</th>
                                            <th class="text-right"></th>
                                        </tr>
<!--                                        <tr>
                                            <th>Persediaan Awal</th>
                                            <th>:</th>
                                            <th class="text-right">(<?php echo general::format_angka($persediaan->nominal) ?>)</th>
                                            <th class="text-right"></th>
                                        </tr>-->
                                        <tr>
                                            <th>Pembelian</th>
                                            <th>:</th>
                                            <th class="text-right">(<?php echo general::format_angka($jml_pembelian) ?>)</th>
                                            <th class="text-right"></th>
                                        </tr>
                                        <tr>
                                            <th>Jml Biaya</th>
                                            <th>:</th>
                                            <th class="text-right">(<?php echo general::format_angka($biaya->nominal) ?>)</th>
                                            <th class="text-right"></th>
                                        </tr>
                                        <tr>
                                            <th colspan="4"></th>
                                        </tr>
                                        <tr>
                                            <th class="text-right">L / R</th>
                                            <th>:</th>
                                            <td class="text-right text-bold"><?php echo general::format_angka($lr) ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
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