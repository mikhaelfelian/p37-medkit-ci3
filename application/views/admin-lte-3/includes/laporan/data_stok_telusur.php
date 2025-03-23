<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!--<h1 class="m-0">Laporan</h1>-->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard2.php') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('laporan/index.php') ?>">Laporan</a></li>
                        <li class="breadcrumb-item active">Data Stok Telusur</li>
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
                <div class="col-md-8">
                    <?php echo form_open(base_url('laporan/set_data_stok_telusur.php'), 'autocomplete="off"') ?> 
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Telusur Stok</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php $hasError = $this->session->flashdata('form_error'); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Item</label>
                                        <select id="item" name="item" class="form-control select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                            <option value="">- Item -</option>
                                            <?php foreach ($sql_item as $item) { ?>
                                                <option value="<?php echo $item->id ?>" <?php echo (!empty($pasien->id_dokter) ? ($item->id == $pasien->id_dokter ? 'selected' : '') : (($item->id == $this->session->flashdata('dokter') ? 'selected' : ''))) ?>><?php echo strtoupper($item->produk) ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Gudang</label>
                                        <select id="gudang" name="gudang" class="form-control select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                            <option value="">- Gudang -</option>
                                            <?php foreach ($sql_gudang as $gudang) { ?>
                                                <option value="<?php echo $gudang->id ?>" <?php // echo (!empty($pasien->id_dokter) ? ($item->id == $pasien->id_dokter ? 'selected' : '') : (($item->id == $this->session->flashdata('dokter') ? 'selected' : ''))) ?>><?php echo strtoupper($gudang->gudang) ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tanggal</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => '02/15/2022 ...', 'value' => (isset($_GET['tgl']) ? $this->tanggalan->tgl_indo($_GET['tgl']) : ''))) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tanggal Rentang</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <?php echo form_input(array('id' => 'tgl_rentang', 'name' => 'tgl_rentang', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => '02/15/2022 - 02/15/2022 ...', 'value' => (isset($_GET['tgl_awal']) ? $this->tanggalan->tgl_indo2($_GET['tgl_awal']) : ''))) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">

                                </div>
                                <div class="col-lg-6 text-right">
                                    <!--<button type="button" class="btn btn-warning btn-flat"><i class="fa fa-undo"></i> Bersih</button>-->
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-search"></i> Cari</button>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <?php echo form_close() ?> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Riwayat Stok <?php echo $sql_stok->produk ?></h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                                <?php
                                $uri = substr($this->uri->segment(2), 0, -4);
                                $id = $this->input->get('id');
                                $case = $this->input->get('act');
                                $tg_awal = $this->input->get('tgl_awal');
                                $tg_akhr = $this->input->get('tgl_akhir');
                                $tg = $this->input->get('tgl');

                                switch ($case) {
                                    case 'per_tanggal':
                                        $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . '&query=' . $query . (!empty($sales) ? "&id_sales=" . $sales . "" : ""));
                                        break;

                                    case 'per_rentang':
                                        $uri_xls = base_url('laporan/xls_' . $uri . '.php?act=' . $case . '&id='.$id.'&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr);
                                        break;
                                }
                                ?>
                            <button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo $uri_xls ?>'"><i class="fas fa-file-excel"></i> Cetak Excel</button>
                            <?php echo $this->session->flashdata('medcheck'); ?>
                            
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tgl</th>
                                        <th>Keterangan</th>
                                        <th class="text-center">Stok Masuk</th>
                                        <th class="text-center">Stok Keluar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--
                                    <?php if (!empty($stok_so)) { ?>
                                        <tr>
                                            <td class="text-center" style="width: 10px"></td>
                                            <td class="text-left" style="width: 150px;">
                                                <?php echo anchor(base_url('/gudang/data_opname_det.php?id=' . general::enkrip($stok_so->id_so) . '&route=laporan/data_stok_telusur.php'), '#' . (!empty($stok_so->no_nota) ? $stok_so->no_nota : $stok_so->no_rm), 'class="text-default" target="_blank"') ?>
                                                <?php echo br(); ?>
                                                <span class="mailbox-read-time float-left"><?php echo $this->tanggalan->tgl_indo5($stok_so->tgl_simpan); ?></span><br/>
                                                <span class="mailbox-read-time float-left"><?php echo $sql_gudang_rw->gudang; ?></span>
                                            </td>
                                            <td class="text-left" style="width: 400px;">
                                                <b><?php echo $stok_so->keterangan; ?></b>
                                                <?php echo br(); ?>
                                                <small><?php echo $this->ion_auth->user($stok_so->id_user)->row()->first_name; ?></small>
                                            </td>
                                            <td class="text-center" style="width: 100px;"><?php echo $stok_so->jml ?></td>
                                            <td class="text-center" style="width: 100px;"></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (!empty($stok_mts)) { ?>
                                        <tr>
                                            <td class="text-center" style="width: 10px"></td>
                                            <td class="text-left" style="width: 150px;">
                                                <?php // echo '#'.$stok_mts->no_nota ?>
                                                <?php echo anchor(base_url('gudang/trans_mutasi_det.php?id=' . general::enkrip($stok_mts->id_penjualan)), '#' . (!empty($stok_mts->no_nota) ? $stok_mts->no_nota : $stok_mts->no_rm), 'class="text-default" target="_blank"') ?>
                                                <?php echo br(); ?>
                                                <span class="mailbox-read-time float-left"><?php echo $this->tanggalan->tgl_indo5($stok_mts->tgl_simpan); ?></span><br/>
                                            </td>
                                            <td class="text-left" style="width: 400px;">
                                                <b><?php echo $stok_mts->keterangan; ?></b>
                                                <?php echo br(); ?>
                                                <small><?php echo $this->ion_auth->user($stok_mts->id_user)->row()->first_name; ?></small>
                                            </td>
                                            <td class="text-center" style="width: 100px;"><?php echo ($gd_aktif->status == '1' ? $stok_mts->jml : '') ?></td>
                                            <td class="text-center" style="width: 100px;"><?php echo ($gd_aktif->status == '1' ? '' : $stok_mts->jml) ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php
                                        if (!empty($sql_stok_msk)) {
                                            $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                            $sm = 0;
                                            foreach ($sql_stok_hist as $msk) {
                                                $sql_nota_dt    = $this->db->where('id', $msk->id_pembelian_det)->get('tbl_trans_beli_det')->row();
                                                $sm             = $sm + $msk->jml;
                                                ?>
                                                <tr>
                                                    <td class="text-center" style="width: 10px">
                                                        <?php echo $no++ ?>.
                                                    </td>
                                                    <td class="text-left" style="width: 150px;">
                                                        <?php echo anchor(base_url('medcheck/tindakan.php?id=' . general::enkrip($msk->id_penjualan) . '&route=laporan/data_stok_telusur.php'), '#' . (!empty($msk->no_nota) ? $msk->no_nota : $msk->no_rm), 'class="text-default" target="_blank"') ?>
                                                        <?php echo br(); ?>
                                                        <span class="mailbox-read-time float-left"><?php echo $this->tanggalan->tgl_indo5($msk->tgl_masuk); ?></span>
                                                        <?php echo br(); ?>
                                                        <span class="mailbox-read-time float-left">Tgl Terima : <?php echo $this->tanggalan->tgl_indo2($sql_nota_dt->tgl_terima); ?></span>
                                                    </td>
                                                    <td class="text-left" style="width: 400px;">
                                                        <?php echo (!empty($sql_nota_dt->kode_batch) ? '<small><i>['.$sql_nota_dt->kode_batch.']</i></small>' : ''); ?>
                                                        <?php echo br(); ?>
                                                        <b><?php echo $msk->keterangan; ?></b>
                                                        <?php echo br(); ?>
                                                        <small><?php echo $this->ion_auth->user($msk->id_user)->row()->first_name; ?></small>
                                                    </td>
                                                    <td class="text-center" style="width: 100px;">
                                                        <?php
                                                        if ($msk->status == '1' OR $msk->status == '2' OR $msk->status == '6') {
                                                            echo (float) $msk->jml;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center" style="width: 100px;">
                                                        <?php
                                                        if ($msk->status == '4' OR $msk->status == '8') {
                                                            echo (float) $msk->jml;
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }                                            
                                        }
                                    ?>
                                                -->
                                    <?php
                                    if (!empty($sql_stok_hist)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        $sk = 0;
                                        foreach ($sql_stok_hist as $penj) {
                                            $sql_prod   = $this->db->where('id', $penj->id_produk)->get('tbl_m_produk')->row();
                                            $sql_medc   = $this->db->where('id', $penj->id_penjualan)->get('tbl_trans_medcheck')->row();
                                            $sql_poli   = $this->db->where('id', $sql_medc->id_poli)->get('tbl_m_poli')->row();
                                            $sk         = $sk + (($penj->status == '4' OR $penj->status == '8') ? $penj->jml : 0);
                                            ?>
                                            <tr>
                                                <td class="text-center" style="width: 10px">
                                                    <?php echo $no++ ?>.
                                                </td>
                                                <td class="text-left" style="width: 150px;">
                                                    <?php echo anchor(base_url('medcheck/tindakan.php?id=' . general::enkrip($penj->id_penjualan) . '&route=laporan/data_stok_telusur.php'), '#' . (!empty($penj->no_nota) ? $penj->no_nota : $penj->no_rm), 'class="text-default" target="_blank"') ?>
                                                    <?php echo br(); ?>
                                                    <span class="mailbox-read-time float-left"><?php echo $this->tanggalan->tgl_indo5($penj->tgl_masuk); ?></span>
                                                    <?php echo br(); ?>
                                                    <span class="mailbox-read-time float-left">Tgl Terima : <?php echo $this->tanggalan->tgl_indo2($sql_nota_dt->tgl_terima); ?></span>
                                                </td>
                                                <td class="text-left" style="width: 400px;">
                                                    <b><?php echo $penj->keterangan; ?></b>
                                                    <?php echo br(); ?>
                                                    <small><?php echo $this->ion_auth->user($penj->id_user)->row()->first_name; ?></small>
                                                    <?php echo br(); ?>
                                                    <small><?php echo general::status_rawat2($sql_medc->tipe); ?></small>
                                                </td>
                                                <td class="text-center" style="width: 100px;">
                                                    <?php
                                                    if ($penj->status == '1' OR $penj->status == '2' OR $penj->status == '6') {
                                                        echo (float) $penj->jml;
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center" style="width: 100px;">
                                                    <?php
                                                    if ($penj->status == '4' OR $penj->status == '8') {
                                                        echo (float) $penj->jml;
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                        <?php $tot_stok_msk = $tot_msk + $stok_so->jml + $sm ?>
                                        <?php $tot_stok_sisa= $tot_msk - $tot_klr + $sk; ?>
                                        <tr>
                                            <td colspan="3" class="text-right" style="width: 560px;">
                                                <b>TOTAL</b><br/>
                                                <!--<span class="mailbox-read-time float-right">(STOK OP TERAKHIR + STOK MASUK*)</span><br/>-->
                                                <!--<span class="mailbox-read-time float-right"><i><b>*sesuai tanggal terpilih</b></i></span>-->
                                            </td>
                                            <td class="text-center" style="width: 100px;"><?php echo $tot_stok_msk ?></td>
                                            <td class="text-center" style="width: 100px;"><?php echo $tot_stok_sisa ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right" style="width: 560px;">
                                                <b>SISA STOK</b><br/>
                                                <span class="mailbox-read-time float-right">(TOT STOK MASUK - TOT STOK KELUAR)</span>
                                            </td>
                                            <td class="text-center" style="width: 100px;"><?php echo $tot_stok_sisa ?></td>
                                            <td class="text-center" style="width: 100px;"></td>
                                        </tr>
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

<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!--Tanggal Rentang-->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<!--<script src="<?php // echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js')         ?>"></script>-->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.css'); ?>">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $("#tgl").datepicker({
            format: 'mm/dd/yyyy',
            //defaultDate: "+1w",
            SetDate: new Date(),
            changeMonth: true,
            changeYear: true,
            yearRange: '2022:<?php echo date('Y') ?>',
            autoclose: true
        });

        $('#tgl_rentang').daterangepicker({
            locale: {
                format: 'MM/DD/YYYY'
            }
        })
    });
</script>