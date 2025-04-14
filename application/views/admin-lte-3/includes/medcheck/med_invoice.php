<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Medical Checkup</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('medcheck/index.php') ?>">Medical Checkup</a></li>
                        <li class="breadcrumb-item active">Invoice</li>
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
                <div class="col-md-12">
                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <?php echo $setting->judul ?>
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-2 invoice-col">
                                <address>
                                    <strong>No. RM / Usia</strong><br/>
                                    <strong>Nama Pasien</strong><br/>
                                    <strong>Alamat</strong><br/>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-10 invoice-col">
                                <address>
                                    <strong>:</strong> <?php echo $sql_pasien->kode_dpn . '' . $sql_pasien->kode . ' / ' . (!empty($sql_pasien->tgl_lahir) ? $this->tanggalan->usia($sql_pasien->tgl_lahir) : '') ?><br>
                                    <strong>:</strong> <?php echo $sql_pasien->nama_pgl ?><br/>
                                    <strong>:</strong> <?php echo $sql_pasien->alamat ?><br/>
                                </address>
                            </div>
                            <!-- /.col -->
                        </div>
                        <div class="row invoice-info">
                            <div class="col-sm-2 invoice-col">
                                <address>
                                    <strong>Tgl Masuk</strong><br/>
                                    <strong>No. STRUK</strong><br/>
                                </address>
                            </div>
                            <div class="col-sm-2 invoice-col">
                                <address>
                                    <strong>:</strong> <?php echo $this->tanggalan->tgl_indo5($sql_medc->tgl_masuk) ?><br/>
                                    <strong>:</strong> <?php echo $sql_medc->no_nota ?><br/>
                                </address>
                            </div>
                            <div class="col-sm-2 invoice-col">
                                <address>
                                    <strong>Tgl Selesai</strong><br/>
                                    <strong>ID Transaksi</strong><br/>
                                </address>
                            </div>
                            <div class="col-sm-2 invoice-col">
                                <address>
                                    <strong>:</strong> <?php echo $this->tanggalan->tgl_indo5($sql_medc->tgl_keluar) ?><br/>
                                    <strong>:</strong> <?php echo $sql_medc->no_rm ?><br/>
                                </address>
                            </div>
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <h4 class="text-center">
                                    KUITANSI PEMBAYARAN
                                </h4>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-left">Item</th>
                                            <th class="text-center">Jml</th>
                                            <th class="text-right">Harga</th>
                                            <th class="text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($sql_medc_det as $det) { ?>
                                            <?php $sql_kat = $this->db->where('id', $det->id_item_kat)->get('tbl_m_kategori')->row(); ?>
                                            <?php $sql_det = $this->db->where('id_medcheck', $det->id_medcheck)->where('id_item_kat', $det->id_item_kat)->where('status_pkt', '0')->get('tbl_trans_medcheck_det')->result(); ?>
                                            <tr>
                                                <td class="text-center" style="width: 15px;"></td>
                                                <td class="text-left text-bold" style="width: 15px;" colspan="4"><i><?php echo $sql_kat->keterangan . ' (' . $sql_kat->kategori . ')'; ?></i></td>
                                            </tr>

                                            <?php foreach ($sql_det as $medc) { ?>
                                                <tr>
                                                    <td class="text-center" style="width: 15px;"><?php echo $no; ?>.</td>
                                                    <td class="text-left" style="width: 600px;"><?php echo $medc->item; ?></td>
                                                    <td class="text-center" style="width: 25px;"><?php echo (float) $medc->jml; ?></td>
                                                    <td class="text-right" style="width: 100px;"><?php echo general::format_angka($medc->harga); ?></td>
                                                    <td class="text-right" style="width: 150px;"><?php echo general::format_angka($medc->subtotal); ?></td>
                                                </tr>
                                                <?php $no++ ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-6">
                                <p class="lead">Metode Pembayaran:</p>
                                <?php if(!empty($sql_medc_plat)){ ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-stripped">
                                                <tbody>
                                                    <?php foreach ($sql_medc_plat as $plat) { ?>
                                                        <?php $sql_plat = $this->db->where('id', $plat->id_platform)->get('tbl_m_platform')->row() ?>
                                                        <tr>
                                                            <td style="width:50%"><b><?php echo $sql_plat->platform ?></b></td>
                                                            <td><?php echo general::format_angka($plat->nominal) ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>File</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($sql_medc_file as $file) { ?>
                                                        <?php $no_rm = strtolower($sql_pasien->kode_dpn) . $sql_pasien->kode; ?>
                                                        <?php $berkas = realpath('.' . $file->file_name); ?>
                                                        <?php $is_image = substr($file->file_type, 0, 5); ?>
                                                        <?php $filename = base_url($file->file_name); ?>
                                                        <tr>
                                                            <td><?php echo $this->tanggalan->tgl_indo5($file->tgl_simpan) ?></td>
                                                            <td>
                                                                <?php if ($is_image == 'image') { ?>
                                                                    <a href="<?php echo $filename ?>" data-toggle="lightbox" data-title="<?php echo strtolower($file->judul . ' - ' . $sql_pasien->nama_pgl) ?>">
                                                                        <i class="fas fa-paperclip"></i> <?php echo $file->judul ?>
                                                                    </a>
                                                                <?php } else { ?>
                                                                    <a href="<?php echo $filename ?>" target="_blank">
                                                                        <i class="fas fa-paperclip"></i> <?php echo $file->judul ?>
                                                                    </a>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- /.col -->
                            <div class="col-6">
                                <p class="lead">Tgl Pembayaran <?php echo ($sql_medc->tgl_bayar != '0000-00-00' ? $this->tanggalan->tgl_indo5($sql_medc->tgl_bayar) : '-') ?></p>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td><?php echo general::format_angka($sql_medc->jml_gtotal) ?></td>
                                        </tr>
                                        <tr>
                                            <th>PPn (<?php echo (float) $sql_medc->ppn ?>%)</th>
                                            <td><?php echo general::format_angka($sql_medc->jml_ppn) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Total:</th>
                                            <td><?php echo general::format_angka($sql_medc->jml_gtotal) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Jml Bayar:</th>
                                            <td><?php echo general::format_angka($sql_medc->jml_bayar) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Jml Kembali:</th>
                                            <td><?php echo general::format_angka($sql_medc->jml_kembali) ?></td>
                                        </tr>
                                    </table>
                                    <?php if ($sql_medc->tipe == '3') { ?>
                                        <button type="button" class="btn btn-success" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf_ranap2.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                                            <i class="fa fa-print"></i> PDF
                                        </button>                                    
                                        <button type="button" class="btn btn-success" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf_ranap3.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                                            <i class="fa fa-print"></i> Kwitansi
                                        </button>
                                        <button type="button" class="btn btn-success" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_dm.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                                            <i class="fa fa-print"></i> Dot Matrix
                                        </button>
                                    <?php } elseif ($sql_medc->tipe == '6') { ?>
                                        <button type="button" class="btn btn-success" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                                            <i class="fa fa-print"></i> Nota PDF
                                        </button>
                                        <button type="button" class="btn btn-success" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_dm_ranap.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                                            <i class="fa fa-print"></i> Dot Matrix
                                        </button>
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-success" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                                            <i class="fa fa-print"></i> Nota PDF
                                        </button>
                                        <button type="button" class="btn btn-success" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_pdf_ranap3.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                                            <i class="fa fa-print"></i> Kuitansi
                                        </button>
                                        <button type="button" class="btn btn-success" onclick="window.location.href = '<?php echo base_url('medcheck/invoice/print_dm_ranap.php?id=' . general::enkrip($sql_medc->id)) ?>'">
                                            <i class="fa fa-print"></i> Dot Matrix
                                        </button>
                                    <?php } ?>
                                    <button type="button" class="btn btn-success" onclick="window.location.href = '<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=12&route=medcheck/invoice/detail.php') ?>'">
                                        <i class="fa fa-print"></i> Kwitansi
                                    </button>
                                    <button type="button" class="btn btn-primary" onclick="window.location.href = '<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=8&name=Bukti Pembayaran&route=medcheck/invoice/detail.php') ?>'">
                                        <i class="fa fa-upload"></i> Unggah Bukti
                                    </button>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-12">
                                <!--<a href="<?php // echo base_url('medcheck/invoice-print.html');      ?>" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Cetak</a>-->
<!--                                <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Bayar</button>
                                <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                    <i class="fas fa-download"></i> Unduh PDF
                                </button>-->
                            </div>
                        </div>
                    </div>
                    <!-- /.invoice -->              
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
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

<!-- Ekko Lightbox -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/ekko-lightbox/ekko-lightbox.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });
    });
</script>