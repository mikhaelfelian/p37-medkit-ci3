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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard2.php') ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('laporan/index.php') ?>">Laporan</a>
                        </li>
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
                    <?php echo form_open(base_url('laporan/set_data_omset_poli.php'), 'autocomplete="off"') ?>
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Laporan Omset Per Poli</h3>
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
                                    <div
                                        class="form-group <?php echo (!empty($hasError['poli']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Poli</label>
                                        <select name="poli"
                                            class="form-control select2bs4 <?php echo (!empty($hasError['poli']) ? ' is-invalid' : '') ?>">
                                            <option value="">- Semua Poli -</option>
                                            <?php foreach ($sql_poli as $poli) { ?>
                                                <option value="<?php echo $poli->id ?>" <?php echo ($_GET['poli'] == $poli->id ? 'selected' : '') ?>><?php echo $poli->lokasi ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div
                                        class="form-group <?php echo (!empty($hasError['tipe']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Tipe</label>
                                        <select name="tipe"
                                            class="form-control <?php echo (!empty($hasError['tipe']) ? ' is-invalid' : '') ?>">
                                            <option value="">[Tipe Perawatan]</option>
                                            <option value="1" <?php echo ($_GET['tipe'] == '1' ? 'selected' : '') ?>>
                                                Laborat</option>
                                            <option value="4" <?php echo ($_GET['tipe'] == '4' ? 'selected' : '') ?>>
                                                Radiologi</option>
                                            <option value="2" <?php echo ($_GET['tipe'] == '2' ? 'selected' : '') ?>>Rawat
                                                Jalan</option>
                                            <option value="3" <?php echo ($_GET['tipe'] == '3' ? 'selected' : '') ?>>Rawat
                                                Inap</option>
                                            <option value="5" <?php echo ($_GET['tipe'] == '5' ? 'selected' : '') ?>>MCU
                                            </option>
                                            <option value="6" <?php echo ($_GET['tipe'] == '6' ? 'selected' : '') ?>>
                                                Apotik / Farmasi</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!--
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Jenis Item</label>
                                        <select name="status" class="form-control rounded-0">
                                            <option value="">[Jenis Item]</option>
                                            <option value="2" <?php echo ($_GET['status'] == '2' ? 'selected' : '') ?>>Tindakan</option>
                                            <option value="3" <?php echo ($_GET['status'] == '3' ? 'selected' : '') ?>>Laboratorium</option>
                                            <option value="4" <?php echo ($_GET['status'] == '4' ? 'selected' : '') ?>>Farmasi</option>
                                            <option value="5" <?php echo ($_GET['status'] == '5' ? 'selected' : '') ?>>Radiologi</option>
                                            <option value="6" <?php echo ($_GET['status'] == '6' ? 'selected' : '') ?>>Bahan Habis Pakai</option>
                                        </select>
                                    </div>                                  
                                </div>
                                -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Jenis Item</label>
                                        <select name="status[]" multiple class="form-control rounded-0">
                                            <?php foreach ($sql_kat as $kat) { ?>
                                                <option value="<?php echo $kat->id; ?>" <?php // echo ($_GET['tipe'] == '1' ? 'selected' : '') ?>><?php echo $kat->keterangan ?></option>
                                            <?php } ?>
                                            <!--                                            <option value="2" <?php echo ($_GET['status'] == '2' ? 'selected' : '') ?>>Tindakan</option>
                                            <option value="3" <?php echo ($_GET['status'] == '3' ? 'selected' : '') ?>>Laboratorium</option>
                                            <option value="4" <?php echo ($_GET['status'] == '4' ? 'selected' : '') ?>>Farmasi</option>
                                            <option value="5" <?php echo ($_GET['status'] == '5' ? 'selected' : '') ?>>Radiologi</option>
                                            <option value="6" <?php echo ($_GET['status'] == '6' ? 'selected' : '') ?>>Bahan Habis Pakai</option>-->
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
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-search"></i>
                                        Cari</button>
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
                                <h3 class="card-title">Data Laporan Omset Per Poli</h3>
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
                                $tgl_awal = $this->input->get('tgl_awal');
                                $tgl_akhir = $this->input->get('tgl_akhir');
                                $tgl = $this->input->get('tgl');
                                $poli = $this->input->get('poli');
                                $tipe = $this->input->get('tipe');
                                $status = $this->input->get('status');

                                switch ($case) {
                                    case 'per_tanggal':
                                        $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . (!empty($tipe) ? '&tipe=' . $tipe : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($status) ? '&status=' . $status : '') . (!empty($tgl) ? '&tgl=' . $tgl : '') . (!empty($tgl_awal) ? '&tgl_awal=' . $tgl_awal : '') . (!empty($tgl_akhir) ? '&tgl_akhir=' . $tgl_akhir : ''));
                                        break;

                                    case 'per_rentang':
                                        $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . (!empty($tipe) ? '&tipe=' . $tipe : '') . (!empty($poli) ? '&poli=' . $poli : '') . (!empty($status) ? '&status=' . $status : '') . (!empty($tgl_awal) ? '&tgl_awal=' . $tgl_awal : '') . (!empty($tgl_akhir) ? '&tgl_akhir=' . $tgl_akhir : ''));
                                        break;
                                }
                                ?>
                                <button class="btn btn-success btn-flat"
                                    onclick="window.location.href = '<?php echo $uri_xls ?>'"><i
                                        class="fas fa-file-excel"></i> Cetak Excel</button>
                                <?php echo br(); ?>
                                <?php echo $this->session->flashdata('medcheck'); ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>ID</th>
                                            <th>Pasien</th>
                                            <th class="text-right">Omset</th>
                                            <th class="text-right">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        $total = 0;
                                        foreach ($sql_omset as $omset) {
                                            $sql_poli = $this->db->where('id', $omset->id_poli)->get('tbl_m_poli')->row();

                                            $total = $total + $omset->jml_gtotal;
                                            ?>
                                            <tr>
                                                <td class="text-center" style="width: 10px">
                                                    <?php echo $no++ ?>.
                                                </td>
                                                <td class="text-left" style="width: 150px;">
                                                    <?php echo anchor(base_url('medcheck/detail.php?id=' . general::enkrip($omset->id_medcheck) . '&route=laporan/data_omset_poli.php'), '#' . $omset->no_rm, 'class="text-default" target="_blank"') ?>
                                                    <?php echo br(); ?>
                                                    <span
                                                        class="mailbox-read-time float-left"><?php echo $this->tanggalan->tgl_indo5($omset->tgl_simpan); ?></span>
                                                </td>
                                                <td class="text-left" style="width: 450px;">
                                                    <b><?php echo $omset->pasien; ?></b>
                                                    <?php echo br(); ?>
                                                    <small><i><?php echo (!empty($omset->id_poli) ? $sql_poli->lokasi . ' / ' . general::status_rawat2($omset->tipe) : ''); ?></i></small>
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
                                            <th colspan="3" class="text-right">Total</th>
                                            <th class="text-right"><?php echo general::format_angka($total) ?></th>
                                            <th></th>
                                        </tr>
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
<!--<script src="<?php // echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js')       ?>"></script>-->
<link rel="stylesheet"
    href="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.css'); ?>">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet"
    href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

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