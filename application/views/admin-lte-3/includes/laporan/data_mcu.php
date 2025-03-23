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
                        <li class="breadcrumb-item active">Data Rekap MCU</li>
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
                    <?php echo form_open(base_url('laporan/set_data_mcu.php'), 'autocomplete="off"') ?> 
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Laporan Rekap MCU</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php $hasError = $this->session->flashdata('form_error'); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <section id="pasien_baru2">
                                        <div class="form-group">
                                            <label class="control-label">Instansi / Perusahaan</label>
                                            <select name="instansi" class="form-control rounded-0 select2bs4">
                                                <option value="">- Pilih -</option>
                                                <?php foreach ($this->db->get('tbl_m_pelanggan')->result() as $instansi) { ?>
                                                    <option value="<?php echo $instansi->id ?>" <?php echo (!empty($pasien->id_pekerjaan) ? ($instansi->nama == $pasien->instansi ? 'selected' : '') : (($kerja->id == $this->session->flashdata('pekerjaan') ? 'selected' : ''))) ?>><?php echo $instansi->nama ?></option>
                                                <?php } ?>
                                            </select>
                                            <?php // echo form_input(array('id' => 'instansi', 'name' => 'instansi', 'class' => 'form-control', 'value' => (!empty($pasien->instansi) ? $pasien->instansi : $this->session->flashdata('instansi')), 'placeholder' => 'Isikan nama Instansi / Perusahaan ...')) ?>
                                        </div>
                                    </section>
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
            <?php if ($_GET['jml'] > 0) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Data Laporan Rekap MCU</h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm float-right">
                                        <?php // echo $pagination ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <?php
                                $uri = substr($this->uri->segment(2), 0, -4);
                                $case = $this->input->get('case');
                                $tg_awal = $this->input->get('tgl_awal');
                                $tg_akhr = $this->input->get('tgl_akhir');
                                $tg = $this->input->get('tgl');
                                $instansi = $this->input->get('id_instansi');
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
                                        $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . (!empty($plat) ? '&plat=' . $plat : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($tipe) ? '&tipe=' . $tipe : '') . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr);
                                        $uri_htm = base_url('laporan/htm_' . $uri . '.php?case=' . $case . (!empty($instansi) ? '&id_instansi=' . $instansi : '') . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr);
                                        $uri_csv = base_url('laporan/csv_' . $uri . '.php?case=' . $case . (!empty($pasien) ? '&id_pasien=' . $pasien_id . '&pasien=' . $pasien : '') . (!empty($plat) ? '&plat=' . $plat : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($tipe) ? '&tipe=' . $tipe : '') . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhr);
                                        break;
                                }
                                ?>
                                <button class="btn btn-success btn-flat" onclick="window.location.href = '<?php echo $uri_htm ?>'"><i class="fas fa-file-excel"></i> Excel</button>

                                <?php echo $this->session->flashdata('medcheck'); ?>
                                <table class="table table-striped  table-responsive">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th class="text-left">Pasien</th>
                                            <th class="text-left">Saran</th>
                                            <th class="text-left">Kesimpulan</th>
                                            <?php foreach ($sql_mcu_hdr->result() as $mcu_hdr) { ?>
                                                <th class="text-left"><?php echo $mcu_hdr->param ?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($sql_mcu)) {
                                            $jml_tot = 0;
                                            $jml_tot_disk = 0;
                                            $jml_tot_oms = 0;

                                            $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                            foreach ($sql_mcu as $mcu) {
                                                $sql_mcu_det = $this->db->where('id_resume', $mcu->id)->get('tbl_trans_medcheck_resume_det');
                                                ?>
                                                <tr>
                                                    <td class="text-center" style="width: 10px">
                                                        <?php echo $no++ ?>.
                                                    </td>
                                                    <td class="text-left" style="width: 300px;">
                                                        <?php echo $mcu->nama_pgl; ?>
                                                        <?php $jm_rows = $sql_mcu_hdr->num_rows() - $sql_mcu_det->num_rows(); // ?>
                                                    </td>
                                                    <td class="text-left" style="width: 300px;">
                                                        <?php echo $mcu->saran; ?>
                                                    </td>
                                                    <td class="text-left" style="width: 300px;">
                                                        <?php echo $mcu->kesimpulan; ?>
                                                    </td>
                                                    <?php foreach ($sql_mcu_det->result() as $mcu_det) { ?>
                                                        <td class="text-left" style="width: 350px;">
                                                            <?php echo $mcu_det->param_nilai; ?>
                                                        </td>
                                                    <?php } ?>
                                                    <?php if ($jm_rows > 0) { ?>
                                                        <td colspan="<?php echo $jm_rows ?>"></td>
                                                    <?php } ?>
                                                </tr>
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
<!--<script src="<?php // echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js')        ?>"></script>-->
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