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
                        <li class="breadcrumb-item active">Data Pemeriksaan Pasien</li>
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
                    <?php echo form_open(base_url('laporan/set_data_pemeriksaan_rj.php'), 'autocomplete="off"') ?> 
                    <?php echo form_hidden('tipe', '3') ?>

                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Pemeriksaan Harian</h3>
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
                                            <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Isikan tgl. cth: 17-08-1945 ...', 'value' => (isset($_GET['tgl']) ? $_GET['tgl'] . '-' . $_GET['bln'] : ''))) ?>
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
                                <h3 class="card-title">Data Pemeriksaan Harian Perawat</h3>
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
                                $tg         = $this->input->get('tgl');
                                $tg_awal    = $this->input->get('tgl_awal');
                                $tg_akhir   = $this->input->get('tgl_akhir');
                                $idp        = $this->input->get('id_pasien');
                                $jml        = $this->input->get('jml');

                                switch ($case) {
                                    default:
                                        $uri_xls = base_url('laporan/xls_' . $uri . '.php?case=' . $case . '&tgl=' . $tg . '&bln=' . $bl . '&poli=' . $poli . '&tipe=' . $tipe);
                                        $uri_xls2 = base_url('laporan/xls_' . $uri . '2.php?');
                                        $btn_ctk = '<button class="btn btn-success btn-flat" onclick="window.location.href = \'' . $uri_xls . '\'"><i class="fas fa-file-excel"></i> Data Pasien</button>';
                                        break;

                                    case 'per_tanggal':
                                        $uri_det    = base_url('laporan/' . $uri . '_det.php?case='.$case.'&tgl='.$tg.(!empty($idp) ? '&id_pasien='.$idp : '').'&jml='.$jml);
                                        $uri_xls    = base_url('laporan/xls_' . $uri . '.php?case=' . $case . '&tgl=' . $tg);
                                        $uri_xls2   = base_url('laporan/xls_' . $uri . '2.php?');

                                        $btn_ctk    = '<button class="btn btn-success btn-flat" onclick="window.location.href = \'' . $uri_xls . '\'"><i class="fas fa-file-excel"></i> WA Birthday</button>';
                                        break;

                                    case 'per_rentang':
                                        $uri_det    = base_url('laporan/' . $uri . '_det.php?case=' . $case . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhir.(!empty($idp) ? '&id_pasien='.$idp : '') .'&jml=' . $jml);
                                        $uri_xls    = base_url('laporan/xls_' . $uri . '.php?case=' . $case . '&tgl_awal=' . $tg_awal . '&tgl_akhir=' . $tg_akhir);
                                        $uri_xls2   = base_url('laporan/xls_' . $uri . '2.php?');
                                        $btn_ctk    = '<button class="btn btn-success btn-flat" onclick="window.location.href = \'' . $uri_xls . '\'"><i class="fas fa-file-excel"></i> Data Pasien</button>';
                                        break;
                                }
                                
                                echo $btn_ctk;
                                ?>
                                <?php echo $this->session->flashdata('medcheck'); ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>No. RM</th>
                                            <th>Pasien</th>
                                            <th class="text-left">Diagnosa</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($sql_pasien)) {
                                            $kunj = 0;
                                            $oms = 0;
                                            $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                            foreach ($sql_pasien as $pasien) {
                                                ?>
                                                <tr>
                                                    <td class="text-center" style="width: 10px">
                                                        <?php echo $no++ ?>.
                                                    </td>
                                                    <td class="text-left" style="width: 150px;">
                                                        <?php echo anchor(base_url('medcheck/tambah.php?id=' . general::enkrip($pasien->id_medcheck).'&status=7'), $pasien->kode, 'target="_blank"') ?><br/>
                                                        <span class="mailbox-read-time float-left"><?php echo $this->tanggalan->tgl_indo5($pasien->tgl_masuk) ?></span>
                                                    </td>
                                                    <td class="text-left" style="width: 450px;">
                                                        <b><?php echo $pasien->pasien; ?></b>
                                                        <?php echo br(); ?>
                                                        <small><?php echo '[' . $this->tanggalan->usia($pasien->tgl_lahir) . ']'; ?></small><br/>
                                                        <small><i><?php echo $pasien->poli; ?></i></small>
                                                    </td>
                                                    <td class="text-left"><?php echo $pasien->diagnosa ?></td>
                                                    <td class="text-left">
                                                        <?php echo anchor(base_url('medcheck/tindakan.php?').'id='.general::enkrip($pasien->id), 'Detail &raquo;', 'class="btn btn-primary btn-flat btn-xs text-bold" style="width: 55px;"') ?>
                                                    </td>
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
<!--<script src="<?php // echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js')           ?>"></script>-->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/daterangepicker/daterangepicker.css'); ?>">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!-- OPTIONAL SCRIPTS -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/chart.js/Chart.min.js') ?>"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="<?php // echo base_url('assets/theme/admin-lte-3/dist/js/pages/dashboard3.js')    ?>"></script>-->
<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $("#tgl").datepicker({
            SetDate: new Date(),
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
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

                window.location.href = "<?php echo base_url('laporan/data_pemeriksaan.php?id_pasien=') ?>" + ui.item.id_pas + "&pasien=" + ui.item.nama;
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