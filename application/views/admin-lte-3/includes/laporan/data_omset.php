<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!--<h1 class="m-0">Master Data</h1>-->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard2.php') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('laporan/index.php') ?>">Laporan</a></li>
                        <li class="breadcrumb-item active">Data Omset</li>
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
                    <?php echo form_open(base_url('laporan/set_data_omset.php'), 'autocomplete="off"') ?> 
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Laporan Omset</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php $hasError = $this->session->flashdata('form_error'); ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo (!empty($pasien) ? 'NIK <small><i>(* KTP / Passport / KIA)</i></small>' : 'Cari Pasien*') ?></label>
                                        <div class="input-group mb-3">
                                            <?php echo form_hidden('id_pasien', $this->input->get('id_pasien')) ?>
                                            <?php echo form_input(array('id' => 'pasien', 'name' => 'pasien', 'class' => 'form-control' . (!empty($hasError['nik']) ? ' is-invalid' : ''), 'value' => (isset($_GET['pasien']) ? $this->input->get('pasien') : ''), 'placeholder' => 'Cari data Pasien')) ?>
                                            <?php if (empty($pasien)) { ?>
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                </div>
                                            <?php } ?>
                                        </div>                                                    
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group <?php echo (!empty($hasError['poli']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Klinik</label>
                                        <select name="poli" class="form-control select2bs4 <?php echo (!empty($hasError['poli']) ? ' is-invalid' : '') ?>">
                                            <option value="">- Semua Poli -</option>
                                            <?php foreach ($sql_poli as $poli) { ?>
                                                <option value="<?php echo $poli->id ?>" <?php echo ($_GET['poli'] == $poli->id ? 'selected' : '') ?>><?php echo $poli->lokasi ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group <?php echo (!empty($hasError['poli']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Platform</label>
                                        <select name="platform" class="form-control select2bs4 <?php echo (!empty($hasError['poli']) ? ' is-invalid' : '') ?>">
                                            <option value="">- Semua Platform -</option>
                                            <?php foreach ($sql_plat as $plat) { ?>
                                                <option value="<?php echo $plat->id ?>" <?php echo ($_GET['platform'] == $plat->id ? 'selected' : '') ?>><?php echo $plat->platform ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group <?php echo (!empty($hasError['tipe']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Tipe</label>
                                        <select name="tipe" class="form-control <?php echo (!empty($hasError['tipe']) ? ' is-invalid' : '') ?>">
                                            <option value="">[Tipe Perawatan]</option>
                                                <option value="1" <?php echo ($_GET['tipe'] == '1' ? 'selected' : '') ?>>Laborat</option>
                                                <option value="4" <?php echo ($_GET['tipe'] == '4' ? 'selected' : '') ?>>Radiologi</option>
                                                <option value="2" <?php echo ($_GET['tipe'] == '2' ? 'selected' : '') ?>>Rawat Jalan</option>
                                                <option value="3" <?php echo ($_GET['tipe'] == '3' ? 'selected' : '') ?>>Rawat Inap</option>
                                                <option value="5" <?php echo ($_GET['tipe'] == '5' ? 'selected' : '') ?>>MCU</option>
                                                <option value="6" <?php echo ($_GET['tipe'] == '6' ? 'selected' : '') ?>>Apotik / Farmasi</option>
                                        </select>
                                    </div>                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group <?php echo (!empty($hasError['tipe']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Penjamin</label>
                                        <select name="penjamin" class="form-control <?php echo (!empty($hasError['tipe']) ? ' is-invalid' : '') ?>">
                                            <option value="">- PENJAMIN -</option>
                                            <?php foreach ($sql_penjamin as $penj){ ?>
                                                <option value="<?php echo $penj->id ?>" <?php echo ($sql_dft_id->tipe_bayar == $penj->id ? 'selected' : '') ?>><?php echo $penj->penjamin ?></option>
                                            <?php } ?>
                                        </select>
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
            <?php if ($sql_omset) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Data Laporan Omset</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-right">
                                        <?php echo $pagination ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
                                $uri        = substr($this->uri->segment(2), 0, -4);
                                $case       = $this->input->get('case');
                                $tg_awal    = $this->input->get('tgl_awal');
                                $tg_akhr    = $this->input->get('tgl_akhir');
                                $tg         = $this->input->get('tgl');
                                $poli       = $this->input->get('poli');
                                $tipe       = $this->input->get('tipe');
                                $plat       = $this->input->get('plat');
                                $pasien_id  = $this->input->get('id_pasien');
                                $pasien     = $this->input->get('pasien');

                                switch ($case) {
                                    case 'per_tanggal':
                                        $uri_pdf = base_url('laporan/' . $uri . '_pdf.php?case=' . $case . (!empty($pasien) ? '&id_pasien=' . $pasien_id.'&pasien=' . $pasien : '') . (!empty($plat) ? '&plat=' . $plat : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($tipe) ? '&tipe=' . $tipe : '') . '&tgl=' . $tg . (!empty($sales) ? "&id_sales=" . $sales . "" : ""));
                                        $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . (!empty($pasien) ? '&id_pasien=' . $pasien_id.'&pasien=' . $pasien : '') . (!empty($plat) ? '&plat=' . $plat : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($tipe) ? '&tipe=' . $tipe : '') . '&tgl=' . $tg . (!empty($sales) ? "&id_sales=" . $sales . "" : ""));
                                        $uri_xls2= base_url('laporan/xls_' . $uri . '_zahir.php?case=' . $case . (!empty($pasien) ? '&id_pasien=' . $pasien_id.'&pasien=' . $pasien : '') . (!empty($plat) ? '&plat=' . $plat : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($tipe) ? '&tipe=' . $tipe : '') . '&tgl=' . $tg . (!empty($sales) ? "&id_sales=" . $sales . "" : ""));
                                        $uri_htm = base_url('laporan/htm_' . $uri . '.php?case=' . $case . (!empty($pasien) ? '&id_pasien=' . $pasien_id.'&pasien=' . $pasien : '') . (!empty($plat) ? '&plat=' . $plat : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($tipe) ? '&tipe=' . $tipe : '') . '&tgl=' . $tg . (!empty($sales) ? "&id_sales=" . $sales . "" : ""));
                                        $uri_csv = base_url('laporan/csv_' . $uri . '.php?case=' . $case . (!empty($pasien) ? '&id_pasien=' . $pasien_id.'&pasien=' . $pasien : '') . (!empty($plat) ? '&plat=' . $plat : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($tipe) ? '&tipe=' . $tipe : '') . '&tgl=' . $tg);
                                        break;

                                    case 'per_rentang':
                                        $uri_pdf = base_url('laporan/' . $uri . '_pdf.php?case=' . $case . (!empty($pasien) ? '&id_pasien=' . $pasien_id.'&pasien=' . $pasien : '') . (!empty($plat) ? '&plat=' . $plat : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($tipe) ? '&tipe=' . $tipe : '') . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr . (!empty($sales) ? "&id_sales=" . $sales : "") . '&metode=' . $metode);
                                        $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . (!empty($pasien) ? '&id_pasien=' . $pasien_id.'&pasien=' . $pasien : '') . (!empty($plat) ? '&plat=' . $plat : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($tipe) ? '&tipe=' . $tipe : '') . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr);
                                        $uri_xls2= base_url('laporan/xls_' . $uri . '_zahir.php?case=' . $case . (!empty($pasien) ? '&id_pasien=' . $pasien_id.'&pasien=' . $pasien : '') . (!empty($plat) ? '&plat=' . $plat : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($tipe) ? '&tipe=' . $tipe : '') . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr);
                                        $uri_htm = base_url('laporan/htm_' . $uri . '.php?case=' . $case . (!empty($pasien) ? '&id_pasien=' . $pasien_id.'&pasien=' . $pasien : '') . (!empty($plat) ? '&plat=' . $plat : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($tipe) ? '&tipe=' . $tipe : '') . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr);
                                        $uri_csv = base_url('laporan/csv_' . $uri . '.php?case=' . $case . (!empty($pasien) ? '&id_pasien=' . $pasien_id.'&pasien=' . $pasien : '') . (!empty($plat) ? '&plat=' . $plat : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($tipe) ? '&tipe=' . $tipe : '') . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr);
                                        break;
                                }
                                ?>
                                <button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo $uri_xls ?>'"><i class="fas fa-file-excel"></i> Excel Global</button>
                                <button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo $uri_xls2 ?>'"><i class="fas fa-file-excel"></i> Excel Zahir</button>
                                <?php echo br(); ?> 
                                <?php echo $this->session->flashdata('medcheck'); ?>
                                <?php $tot          = $sql_omset_row->jml_subtotal; // + $tot_diskon + $sql_omset_row->jml_potongan_poin; ?>
                                <?php $tot_diskon   = $sql_omset_row->jml_diskon + $sql_omset_row->jml_potongan + $sql_omset_row->jml_potongan_poin; ?>
                                <?php $tot_subtotal = $tot - $tot_diskon; ?>

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>ID</th>
                                            <th>Pasien</th>
                                            <th class="text-right">Total</th>
                                            <th class="text-right">Diskon</th>
                                            <th class="text-right">Poin</th>
                                            <th class="text-right">Omset</th>
                                            <th class="text-right"></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th class="text-right"></th>
                                            <th class="text-left" colspan="2"><small>*(diskon + potongan)</small></th>
                                            <th class="text-left""><small>*(poin)</small></th>
                                            <th class="text-right"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-right text-bold" colspan="3">Total</td>
                                            <td class="text-right text-bold"><?php echo general::format_angka($tot) ?></td>
                                            <td class="text-right text-bold"><?php echo general::format_angka($tot_diskon) ?></td>
                                            <td class="text-right text-bold"><?php echo general::format_angka($sql_omset_row->jml_potongan_poin) ?></td>
                                            <td class="text-right text-bold"><?php echo general::format_angka($tot_subtotal) ?></td>
                                            <td class="text-right text-bold"></td>
                                        </tr>
                                        <?php
                                        if (!empty($sql_omset)) {
                                            $jml_tot        = 0;
                                            $jml_tot_disk   = 0;
                                            $jml_tot_oms    = 0;
                                            
                                            $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                            foreach ($sql_omset as $omset) {
                                                $sql_poli       = $this->db->where('id', $omset->id_poli)->get('tbl_m_poli')->row();
                                                $sql_pnjm       = $this->db->where('id', $omset->tipe_bayar)->get('tbl_m_penjamin')->row();
                                                
                                                $jml_tot        = $jml_tot + $omset->jml_total;
                                                $jml_tot_disk   = $jml_tot_disk + ($omset->jml_diskon + $omset->jml_potongan);
                                                $jml_tot_oms    = $jml_tot_oms + $omset->jml_gtotal;
                                                $total          = $omset->jml_gtotal + $omset->jml_diskon + $omset->jml_potongan + $omset->potongan_poin;
                                                $diskon         = $omset->jml_diskon + $omset->jml_potongan;
                                                ?>
                                                <tr>
                                                    <td class="text-center" style="width: 10px">
                                                        <?php echo $no++ ?>.
                                                    </td>
                                                    <td class="text-left" style="width: 150px;">
                                                        <?php echo anchor(base_url('medcheck/tindakan.php?id=' . general::enkrip($omset->id_medcheck)), '#' . $omset->no_rm, 'class="text-default" target="_blank"') ?>
                                                        <?php echo br(); ?>
                                                        <!--<span class="mailbox-read-time float-left"><?php echo $this->tanggalan->tgl_indo5($omset->tgl_simpan); ?></span>-->
                                                        <span class="mailbox-read-time float-left"><?php echo $this->tanggalan->tgl_indo5($omset->tgl_bayar); ?></span>
                                                    </td>
                                                    <td class="text-left" style="width: 450px;">
                                                        <b><?php echo $omset->pasien; ?></b>
                                                        <?php echo br(); ?>
                                                        <i><?php echo $sql_pnjm->penjamin; ?></i>
                                                        <?php echo br(); ?>
                                                        <small><?php echo $this->tanggalan->tgl_indo2($omset->tgl_lahir) . ' [' . $this->tanggalan->usia($omset->tgl_lahir) . ']'; ?> - <i><?php echo $sql_poli->lokasi; ?> (<b><?php echo general::status_rawat2($omset->tipe); ?></b></i>)</small>
                                                    </td>
                                                    <td class="text-right" style="width: 100px;">
                                                        <?php echo general::format_angka($total); ?> 
                                                    </td>
                                                    <td class="text-right" style="width: 100px;">
                                                        <?php echo general::format_angka($diskon); ?>
                                                    </td>
                                                    <td class="text-right" style="width: 100px;">
                                                        <?php echo general::format_angka($omset->potongan_poin); ?>
                                                    </td>
                                                    <td class="text-right" style="width: 100px;">
                                                        <?php echo general::format_angka($omset->jml_gtotal); ?>
                                                    </td>
                                                    <td class="text-left" style="width: 50px;">
                                                        <?php echo anchor(base_url('medcheck/invoice/print_dm.php?id=' . general::enkrip($omset->id_medcheck)), '<i class="fas fa-solid fa-print"></i>', 'class="btn btn-warning btn-flat btn-sm" target="_blank"') ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <tr>
                                            <td class="text-right text-bold" colspan="3">Total</td>
                                            <td class="text-right text-bold"><?php echo general::format_angka($tot) ?></td>
                                            <td class="text-right text-bold"><?php echo general::format_angka($tot_diskon) ?></td>
                                            <td class="text-right text-bold"><?php echo general::format_angka($sql_omset_row->jml_potongan_poin) ?></td>
                                            <td class="text-right text-bold"><?php echo general::format_angka($tot_subtotal) ?></td>
                                            <td class="text-right text-bold"></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!--<pre><?php print_r($sql_omset); ?></pre>-->
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
<!--<script src="<?php // echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js')     ?>"></script>-->
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
        });

        // Autocomplete untuk pasien lama
        $('#pasien').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('laporan/json_pasien.php') ?>",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 1,
            select: function (event, ui) {
                var $itemrow = $(this).closest('tr');
                //Populate the input fields from the returned values
                $itemrow.find('#id_pasien').val(ui.item.id);
                $('#id_pasien').val(ui.item.id);
                $('#pasien').val(ui.item.nama);

                // Give focus to the next input field to recieve input from user
                $('#pasien').focus();

                window.location.href = "<?php echo base_url('laporan/data_omset.php?id_pasien=') ?>" + ui.item.id_pas + "&pasien=" + ui.item.nama;
                return false;
            }

            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.nik + "</a> <a>(" + item.jns_klm + ")</a></br><a>" + item.nama + "</a></br><a>" + item.alamat + "<br/>--------------------------------------------------------------</a>")
                    .appendTo(ul);
        };
    });
</script>