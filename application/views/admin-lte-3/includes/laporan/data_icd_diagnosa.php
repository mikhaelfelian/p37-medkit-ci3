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
                        <li class="breadcrumb-item active">Data Rekap Diagnosa</li>
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
                    <?php echo form_open(base_url('laporan/set_data_diagnosa.php'), 'autocomplete="off"') ?> 
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Laporan Rekap Diagnosa</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php $hasError = $this->session->flashdata('form_error'); ?>

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
            <?php if ($_GET['jml'] > 0) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Data Laporan Rekap Diagnosa</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-right">
                                        <?php echo $pagination ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
                                $uri = substr($this->uri->segment(2), 0, -4);
                                $case = $this->input->get('case');
                                $tg_awal = $this->input->get('tgl_awal');
                                $tg_akhr = $this->input->get('tgl_akhir');
                                $tg = $this->input->get('tgl');
                                $poli = $this->input->get('poli');
                                $tipe = $this->input->get('tipe');
                                $plat = $this->input->get('plat');
                                $pasien_id = $this->input->get('id_pasien');
                                $pasien = $this->input->get('pasien');

                                switch ($case) {
                                    case 'per_tanggal':
                                        $uri_pdf = base_url('laporan/' . $uri . '_pdf.php?case=' . $case . (!empty($pasien) ? '&id_pasien=' . $pasien_id . '&pasien=' . $pasien : '') . (!empty($plat) ? '&plat=' . $plat : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($tipe) ? '&tipe=' . $tipe : '') . '&tgl=' . $tg . (!empty($sales) ? "&id_sales=" . $sales . "" : ""));
                                        $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . (!empty($pasien) ? '&id_pasien=' . $pasien_id . '&pasien=' . $pasien : '') . (!empty($plat) ? '&plat=' . $plat : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($tipe) ? '&tipe=' . $tipe : '') . '&tgl=' . $tg . (!empty($sales) ? "&id_sales=" . $sales . "" : ""));
                                        $uri_htm = base_url('laporan/htm_' . $uri . '.php?case=' . $case . (!empty($pasien) ? '&id_pasien=' . $pasien_id . '&pasien=' . $pasien : '') . (!empty($plat) ? '&plat=' . $plat : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($tipe) ? '&tipe=' . $tipe : '') . '&tgl=' . $tg . (!empty($sales) ? "&id_sales=" . $sales . "" : ""));
                                        $uri_csv = base_url('laporan/csv_' . $uri . '.php?case=' . $case . (!empty($pasien) ? '&id_pasien=' . $pasien_id . '&pasien=' . $pasien : '') . (!empty($plat) ? '&plat=' . $plat : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($tipe) ? '&tipe=' . $tipe : '') . '&tgl=' . $tg);
                                        break;

                                    case 'per_rentang':
                                        $uri_pdf = base_url('laporan/' . $uri . '_pdf.php?case=' . $case . (!empty($pasien) ? '&id_pasien=' . $pasien_id . '&pasien=' . $pasien : '') . (!empty($plat) ? '&plat=' . $plat : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($tipe) ? '&tipe=' . $tipe : '') . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr . (!empty($sales) ? "&id_sales=" . $sales : "") . '&metode=' . $metode);
                                        $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . (!empty($pasien) ? '&id_pasien=' . $pasien_id . '&pasien=' . $pasien : '') . (!empty($plat) ? '&plat=' . $plat : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($tipe) ? '&tipe=' . $tipe : '') . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr);
                                        $uri_htm = base_url('laporan/htm_' . $uri . '.php?case=' . $case . (!empty($pasien) ? '&id_pasien=' . $pasien_id . '&pasien=' . $pasien : '') . (!empty($plat) ? '&plat=' . $plat : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($tipe) ? '&tipe=' . $tipe : '') . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr);
                                        $uri_csv = base_url('laporan/csv_' . $uri . '.php?case=' . $case . (!empty($pasien) ? '&id_pasien=' . $pasien_id . '&pasien=' . $pasien : '') . (!empty($plat) ? '&plat=' . $plat : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($tipe) ? '&tipe=' . $tipe : '') . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr);
                                        break;
                                }
                                ?>
                                <!--<button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo $uri_xls ?>'"><i class="fas fa-file-excel"></i> Excel</button>-->

                                <?php echo $this->session->flashdata('medcheck'); ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th class="text-left">Diagnosa</th>
                                            <th class="text-left">Jml Diagnosa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($sql_icd)) {
                                            $jml_tot = 0;
                                            $jml_tot_disk = 0;
                                            $jml_tot_oms = 0;

                                            $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                            foreach ($sql_icd as $icd) {
                                                $sql_medc_icd   = $this->db->where('id_icd', $icd->id_icd)->get('tbl_trans_medcheck_icd')->result();
                                                $jml_tot        = $jml_tot + $icd->jml_total;
                                                $jml_tot_disk   = $jml_tot_disk + $icd->jml_diskon;
                                                $jml_tot_oms    = $jml_tot_oms + $icd->jml_gtotal;
                                                ?>
                                                <tr>
                                                    <td class="text-center" style="width: 10px">
                                                        <?php echo $no++ ?>.
                                                    </td>
                                                    <td class="text-left" style="width: 250px;">
                                                        <b><?php echo $icd->icd; ?></b> &raquo;
                                                        <?php echo br(); ?>
                                                        <small><i><?php echo $icd->diagnosa_en; ?></i></small>
                                                    </td>
                                                    <td class="text-left" style="width: 150px;">
                                                        <?php echo $icd->jml; ?>
                                                        <small><i>Diagnosa Terbanyak</i></small>
                                                    </td>
                                                </tr>
                                                <?php foreach ($sql_medc_icd as $medc_icd) { ?>
                                                    <?php 
                                                        $sql_medc   = $this->db->where('id', $medc_icd->id_medcheck)->get('tbl_trans_medcheck')->row(); 
                                                        $sql_pas    = $this->db->where('id', $sql_medc->id_pasien)->get('tbl_m_pasien')->row(); 
                                                        
                                                        ?>
                                                        <tr>
                                                            <td class="text-center" style="width: 10px">
                                                                <?php // echo $no++ ?>
                                                            </td>
                                                            <td class="text-left" style="width: 250px;">
                                                                <?php echo $sql_medc->pasien.' ('.$sql_pas->jns_klm.') / '.$sql_pas->kode_dpn.$sql_pas->kode; ?>
                                                                <?php echo br(); ?>
                                                                <small><?php echo $this->tanggalan->usia_lkp($sql_pas->tgl_lahir); ?></small>
                                                                <?php echo br(); ?>
                                                                <small><?php echo $this->tanggalan->tgl_indo5($sql_medc->tgl_simpan); ?></small>
                                                            </td>
                                                            <td class="text-left" style="width: 150px;">
                                                            </td>
                                                        </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
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
<!--<script src="<?php // echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js')      ?>"></script>-->
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