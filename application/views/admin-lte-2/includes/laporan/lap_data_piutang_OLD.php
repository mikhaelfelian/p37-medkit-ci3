<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Laporan <small>Data Piutang</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard.php') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li>Laporan</li>
            <li class="active">Piutang</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-6">
                <?php echo form_open('page=laporan&act=set_lap_piutang', '') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Laporan</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label">Semua</label>
                            <br/>
                            <input type="checkbox" name="semua" value="1"> Semua
                        </div>
                        <div class="form-group">
                            <label class="control-label">Per Hari</label>
                            <br/>
                            <input type="checkbox" name="hari_ini" value="<?php echo date('m/d/Y') ?>"> Hari Ini
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['sales']) ? 'has-error' : '') ?>">
                            <label class="control-label">Nama Sales</label>
                            <select name="sales" class="form-control select2">
                                <option value="" selected="selected">- [Pilih] -</option>
                                <?php
                                if (!empty($sales)) {
                                    foreach ($sales as $sales) {
                                        $grup = $this->ion_auth->get_users_groups($sales->id)->row();
                                        if ($grup->name == 'sales') {
                                            ?>
                                            <option value="<?php echo $sales->id ?>"><?php echo $sales->first_name ?></option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>

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
                            <h3 class="box-title">Data Piutang</h3>
                        </div>
                        <div class="box-body table-responsive">
                            <button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo site_url('page=laporan&act=piutang_pdf&route=' . $this->input->get('act') . '&case=' . $this->input->get('case') . '&query=' . $this->input->get('query') . '&tgl_awal=' . $this->input->get('tgl_awal') . '&tgl_akhir=' . $this->input->get('tgl_akhir')) ?>'"><i class="fa fa-file-pdf-o"></i> Cetak</button>
                            <?php echo br(2) ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Tgl</th>
                                        <th>No. Invoice</th>
                                        <th>Platform</th>
                                        <th>No. Platform</th>
                                        <th>Tgl Bayar</th>
                                        <th class="text-right">Harga Total</th>
                                        <th class="text-right">Ongkir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php $total = 0; ?>
                                    <?php $total_ongk = 0; ?>
                                    <?php foreach ($penjualan as $penjualan) { ?>
                                        <?php $tgl = explode('-', $penjualan->tgl_simpan) ?>
                                        <?php $tgl_byr = explode('-', $penjualan->tgl_bayar) ?>
                                        <?php $total = $total + $penjualan->jml_gtotal ?>
                                        <?php $total_ongk = $total_ongk + $penjualan->jml_ongkir ?>
                                        <?php // $penj = $this->db->where('id', $penjualan->id_penjahit)->get('tbl_m_penjahit')->row() ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?></td>
                                            <td><?php echo $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0] ?></td>
                                            <td><?php echo anchor('page=transaksi&act=trans_jual_detail&route=data_penjualan&case=' . $this->input->get('case') . '&query=' . $this->input->get('query') . '&tgl_awal=' . $this->input->get('tgl_awal') . '&tgl_akhir=' . $this->input->get('tgl_akhir') . '&id=' . general::enkrip($penjualan->no_nota), '#' . $penjualan->no_nota) ?></td>
                                            <td><?php echo $this->db->where('id', $penjualan->id_platform)->get('tbl_m_platform')->row()->platform ?></td>
                                            <td><?php echo ucwords($penjualan->platform) ?></td>
                                            <td><?php echo ($penjualan->tgl_bayar != '0000-00-00' ? $tgl_byr[1] . '/' . $tgl_byr[2] . '/' . $tgl_byr[0] : '-') ?></td>
                                            <td class="text-right"><?php echo general::format_angka($penjualan->jml_gtotal) ?></td>
                                            <td class="text-right"><?php echo general::format_angka($penjualan->jml_ongkir) ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="6" class="text-right"><label>Total Piutang</label></td>
                                        <td class="text-right"><label><?php echo general::format_angka($total) ?></label></td>
                                        <td class="text-right"><label><?php echo general::format_angka($total_ongk) ?></label></td>
                                    </tr>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?php echo base_url('assets/admin-lte-2/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<script src="<?php echo base_url('assets/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/admin-lte-2/plugins/daterangepicker/daterangepicker-bs3.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Select2 -->
<script src="<?php echo base_url('assets/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/admin-lte-2/plugins/select2/select2.min.css') ?>">


<script src="<?php echo base_url('assets/admin-lte-2/plugins') ?>/JAutoNumber/autonumeric.js"></script>
<!-- Page script -->
<script>
                                $(function () {
                                    //Date picker
                                    $('#tgl').datepicker({
                                        autoclose: true,
                                    });
                                    $('#tgl_rentang').daterangepicker();
                                    $(".select2").select2();
                                });

</script>