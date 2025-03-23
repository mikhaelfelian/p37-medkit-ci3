<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Laporan <small>Data Mutasi</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li>Laporan</li>
            <li class="active">Mutasi Gudang</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-6">
                <?php echo form_open(base_url('laporan/set_lap_mutasi.php'), 'autocomplete="off"') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Laporan</h3>
                    </div>
                    <div class="box-body">
                        <?php echo $this->session->flashdata('laporan'); ?>
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
                                <div class="form-group">
                                    <label class="control-label">Petugas</label>
                                    <select name="sales" class="form-control">
                                        <option value="">[- Pilih -]</option>
                                        <?php foreach ($sales as $kasir) { ?>
                                            <option value="<?php echo $kasir->id ?>"><?php echo strtoupper($kasir->first_name) ?></option>
                                        <?php } ?>
                                    </select>
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
                            <h3 class="box-title">Data Mutasi</h3>
                        </div>
                        <div class="box-body table-responsive">
                            <?php                            
                            $uri         = substr($this->uri->segment(2), 0, -4);
                            $case        = $this->input->get('case');
                            $query       = $this->input->get('query');
                            $kat         = $this->input->get('kategori');
                            $tg_awal     = $this->input->get('tgl_awal');
                            $tg_akhr     = $this->input->get('tgl_akhir');
                            $sales       = $this->input->get('id_sales');
                            $metode      = $this->input->get('metode');

                            switch ($case) {
                                case 'per_tanggal':
                                    $uri_pdf = base_url('laporan/' . $uri . '_pdf.php?case=' . $case . '&query=' . $query.(!empty($sales) ? "&id_sales=".$sales."" : "").'&metode='.$metode);
                                    $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . '&query=' . $query.(!empty($sales) ? "&id_sales=".$sales."" : "").'&metode='.$metode);
                                    break;

                                case 'per_rentang':
                                    $uri_pdf = base_url('laporan/' . $uri . '_pdf.php?case=' . $case . '&tgl_awal=' . $tg_awal.'&tgl_akhir='.$tg_akhr.(!empty($sales) ? "&id_sales=".$sales : "").'&metode='.$metode);
                                    $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . '&tgl_awal=' . $tg_awal.'&tgl_akhir='.$tg_akhr.(!empty($sales) ? "&id_sales=".$sales : "").'&metode='.$metode);
                                    break;
                            }
                            ?>
                            <!--<button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo $uri_pdf ?>'"><i class="fa fa-file-pdf-o"></i> Cetak</button>-->
                            <!--<button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo $uri_xls ?>'"><i class="fa fa-file-excel-o"></i> Cetak Excel</button>-->
                            <?php echo br() ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Tgl</th>
                                        <th>No. Mutasi</th>
                                        <th>Petugas</th>
                                        <th>Keterangan</th>
                                        <th>Gd. Asal</th>
                                        <th>Gd. Tujuan</th>
                                        <th class="text-right">Jml</th>
                                        <th class="text-left">Satuan</th>
                                        <th class="text-left">Tipe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($penjualan)) { ?>
                                        <?php $no = 1; ?>
                                        <?php $total = 0; ?>
                                        <?php foreach ($penjualan as $penjualan) { ?>
                                            <?php $gd_asl = $this->db->where('id', $penjualan->id_gd_asal)->get('tbl_m_gudang')->row(); ?>
                                            <?php $gd_7an = $this->db->where('id', $penjualan->id_gd_tujuan)->get('tbl_m_gudang')->row(); ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?></td>
                                                <td><?php echo $this->tanggalan->tgl_indo($penjualan->tgl_masuk) ?></td>
                                                <td><?php echo anchor(base_url('gudang/trans_mutasi_det.php?id=' . general::enkrip($penjualan->id) . '&route=laporan/data_mutasi.php'), $penjualan->kode_nota_dpn.$penjualan->no_nota) ?></td>
                                                <td><?php echo $this->ion_auth->user($penjualan->id_user)->row()->first_name; ?></td>
                                                <td><?php echo $penjualan->keterangan ?></td>
                                                <td><?php echo $gd_asl->gudang ?></td>
                                                <td><?php echo $gd_7an->gudang ?></td>
                                                <td class="text-right"><?php echo ($penjualan->jml * $penjualan->jml_satuan) ?></td>
                                                <td class="text-left"><?php echo $penjualan->satuan ?></td>
                                                <td class="text-left"><?php echo general::tipe_gd($penjualan->tipe) ?></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
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