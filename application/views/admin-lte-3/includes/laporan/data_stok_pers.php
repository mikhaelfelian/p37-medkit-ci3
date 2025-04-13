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
                        <li class="breadcrumb-item active">Data Persediaan</li>
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
                    <?php echo form_open(base_url('laporan/set_data_stok_pers.php'), 'autocomplete="off"') ?> 
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Persediaan</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php $hasError = $this->session->flashdata('form_error'); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group<?php echo (!empty($hasError['item']) ? ' text-danger' : '') ?>">
                                        <label class="control-label">Item</label>
                                        <select id="item" name="item" class="form-control select2bs4 <?php echo (!empty($hasError['item']) ? ' is-invalid' : '') ?>">
                                            <option value="">- Item -</option>
                                            <?php foreach ($sql_item as $item) { ?>
                                                <option value="<?php echo $item->id ?>" <?php echo (!empty($pasien->id_dokter) ? ($item->id == $pasien->id_dokter ? 'selected' : '') : (($item->id == $this->session->flashdata('dokter') ? 'selected' : ''))) ?>><?php echo strtoupper($item->produk) ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                        <div class="card-body table-responsive">
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
                                    $uri_xls = base_url('laporan/xls_' . $uri . '.php?act=' . $case . '&id=' . $id . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr);
                                    break;
                            }
                            ?>
                            <!--<button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo $uri_xls ?>'"><i class="fas fa-file-excel"></i> Cetak Excel</button>-->
                            <?php echo $this->session->flashdata('medcheck'); ?>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="vertical-align: middle;">No.</th>
                                        <th class="text-left" style="vertical-align: middle;">Tgl</th>
                                        <th class="text-left" style="vertical-align: middle;">Keterangan</th>
                                        <!--<th class="text-center">SO</th>-->
                                        <th class="text-center">Masuk</th>
                                        <th class="text-center">Keluar</th>
                                        <th class="text-center">Sisa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-left"></td>
                                        <td class="text-left"></td>
                                        <td class="text-left">
                                            <?php $st_awal = $stok_so->jml + $stok_bl->jml; ?>
                                            <b>SALDO AWAL</b><br/>
                                        </td>
                                        <!--<td class="text-left"></td>-->
                                        <td class="text-center"><?php echo $st_awal; ?></td>
                                        <td class="text-center" colspan="2"></td>
                                    </tr>
                                    <?php
                                    if (!empty($sql_stok_hist)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        $sk = 0;
                                        $sm = 0;
                                        foreach ($sql_stok_hist as $penj) {
                                            $sql_prod       = $this->db->where('id', $penj->id_produk)->get('tbl_m_produk')->row();
                                            $sql_medc       = $this->db->where('id', $penj->id_penjualan)->get('tbl_trans_medcheck')->row();
                                            $sql_beli       = $this->db->where('id', $penj->id_pembelian)->get('tbl_trans_beli')->row();
                                            $sql_poli       = $this->db->where('id', $sql_medc->id_poli)->get('tbl_m_poli')->row();
                                            $sql_hist       = $this->db->where('id_item_det', $penj->id)->get('tbl_trans_stok_tmp')->row();
                                            $sql_beli_det   = $this->db->where('id', $penj->id_pembelian_det)->get('tbl_trans_beli_det')->row();
                                            $so             = (($penj->status == '6') ? $penj->jml : 0);
                                            $sm             = $sm + (($penj->status == '1' OR $penj->status == '6') ? $penj->jml : 0);
                                            $sk             = $sk + (($penj->status == '4') ? $penj->jml : 0);
                                            
                                            $msk            = ($penj->status == '1' ? (float)$sql_beli_det->subtotal : 0);
                                            $klr            = ($penj->status == '4' ? (float)$penj->nominal : 0);
                                            
                                            $st_sisa = ($st_awal + $msk) - $klr;
                                            ?>
                                            <tr>
                                                <td class="text-center" style="width: 10px">
                                                    <?php echo $no++ ?>.
                                                </td>
                                                <td class="text-left" style="width: 150px;">
                                                    <?php
                                                    if ($penj->status == '1') {
                                                        echo anchor(base_url('transaksi/trans_beli_det.php?id=' . general::enkrip($penj->id_pembelian) . '&route=laporan/data_stok_telusur.php'), '#' . (!empty($penj->no_nota) ? $penj->no_nota : $penj->no_rm), 'class="text-default" target="_blank"');
                                                    }elseif($penj->status == '4'){
                                                        echo anchor(base_url('medcheck/tindakan.php?id=' . general::enkrip($penj->id_penjualan) . '&route=laporan/data_stok_telusur.php'), '#' . (!empty($penj->no_nota) ? $penj->no_nota : $penj->no_rm), 'class="text-default" target="_blank"');
                                                    }elseif ($penj->status == '6') {
                                                        echo anchor(base_url('gudang/data_opname_det.php?id=' . general::enkrip($penj->id_so) . '&route=laporan/data_stok_telusur.php'), '#' . (!empty($penj->no_nota) ? $penj->no_nota : $penj->no_rm), 'class="text-default" target="_blank"');
                                                    }
                                                    ?>
                                                    <?php // echo anchor(base_url('medcheck/tindakan.php?id=' . general::enkrip($penj->id_penjualan) . '&route=laporan/data_stok_telusur.php'), '#' . (!empty($penj->no_nota) ? $penj->no_nota : $penj->no_rm), 'class="text-default" target="_blank"') ?>
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
                                                    <?php
                                                            if ($penj->status == '1') {
                                                                echo '<small><i>'.$sql_beli->supplier.'</i></small>';
                                                            } elseif ($penj->status == '4') {
//                                                                echo anchor(base_url('medcheck/tindakan.php?id=' . general::enkrip($penj->id_penjualan) . '&route=laporan/data_stok_telusur.php'), '#' . (!empty($penj->no_nota) ? $penj->no_nota : $penj->no_rm), 'class="text-default" target="_blank"');
                                                            } elseif ($penj->status == '6') {
//                                                                echo anchor(base_url('gudang/data_opname_det.php?id=' . general::enkrip($penj->id_so) . '&route=laporan/data_stok_telusur.php'), '#' . (!empty($penj->no_nota) ? $penj->no_nota : $penj->no_rm), 'class="text-default" target="_blank"');
                                                            }
                                                    ?>
                                                </td>
<!--                                                <td class="text-center" style="width: 80px;">
                                                    <?php
                                                    if ($penj->status == '6') {
                                                        echo (float) $penj->jml;
                                                    }
                                                    ?>
                                                </td>-->
                                                <td class="text-center" style="width: 80px;">
                                                    <?php
                                                    if ($penj->status == '1' OR $penj->status == '6') {
                                                        echo (float) $penj->jml;
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center" style="width: 80px;">
                                                    <?php echo ($penj->status == '4' ? (float) $penj->jml : ''); ?>
                                                </td>
                                                <td class="text-center" style="width: 80px;">
                                                    <?php echo (float)$sql_hist->stok_akhir; ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php $sql_hist_glob  = $this->db->where('id_item', general::dekrip($_GET['id']))->get('tbl_trans_stok_tmp_glob')->row(); ?>
                                    <?php $tot_stok_msk     = $sql_hist_glob->jml + $sk ?>
                                    <?php $tot_stok_sisa    = (!empty($so) ? $so : ($sm + $st_awal) - $sk); ?>
                                    <tr>
                                        <td colspan="3" class="text-right" style="width: 560px;">
                                            <b>SALDO AKHIR</b><br/>
                                            <!--<span class="mailbox-read-time float-right">(STOK OP TERAKHIR + STOK MASUK*)</span><br/>-->
                                            <!--<span class="mailbox-read-time float-right"><i><b>*sesuai tanggal terpilih</b></i></span>-->
                                        </td>
                                        <td class="text-center" style="width: 80px;"><?php echo $tot_stok_msk ?></td>
                                        <td class="text-center" style="width: 80px;"><?php echo $sk ?></td>
                                        <td class="text-center" style="width: 80px;"><?php echo (float)$sql_hist_glob->jml ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right" style="width: 560px;">
                                            <b>SISA STOK</b><br/>
                                        </td>
                                        <td class="text-center" style="width: 100px;"><b><?php echo (float)$sql_hist_glob->jml ?></b></td>
                                        <td class="text-center" colspan="2">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right" style="width: 560px;">
                                            <b></b><br/>
                                        </td>
                                        <td class="text-right" colspan="3">
                                            <?php echo anchor(base_url('gudang/data_stok_tambah.php?id='.$this->input->get('id')), 'Cek &raquo;', 'class="btn btn-primary btn-flat" target="_blank"') ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right" style="width: 560px;">
                                            <b></b><br/>
                                        </td>
                                        <td class="text-right" colspan="3">
                                            <?php echo anchor(base_url('gudang/data_stok_tambah.php?id='.$this->input->get('id').'#'), 'Sinkron &raquo;', 'class="btn btn-primary btn-flat" target="_blank"') ?>
                                        </td>
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
<!--<script src="<?php // echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js')          ?>"></script>-->
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