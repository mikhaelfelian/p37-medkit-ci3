<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-2"></div>
                <div class="col-sm-6">
                    <h1 class="m-0"> PENDAFTARAN PASIEN <small><i>Online</i></small></h1>
                </div><!-- /.col -->
                <div class="col-sm-2">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Buat Janji</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <!-- /.col-md-6 -->
                <div class="col-lg-<?php echo (isset($_GET['id']) ? '4' : '2') ?>">

                </div>
                <div class="col-lg-<?php echo (isset($_GET['id']) ? '4' : '8') ?>">
                    <?php if (isset($_GET['id'])) { ?>
                        <?php $pengaturan = $this->db->get('tbl_pengaturan')->row(); ?>
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <td class="text-center"><?php echo $pengaturan->judul ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="font-size: 12px;"><?php echo $pengaturan->alamat ?></td>
                                    </tr>
                                </table>                                
                                <div class="row">
                                    <div class="col-sm-12">                                        
                                        <p class="card-text text-center">
                                            ====================================<br/>
                                            ANTRIAN ONLINE<br/>
                                            <?php echo $sql_poli->lokasi; ?>
                                        </p>
                                    </div>
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-7">
                                        <div class="error-page">
                                            <h2 class="headline text-primary"><?php echo sprintf('%03d', $sql_dft_id->no_urut); ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>
                                </div>
                                <p class="card-text text-center">                                    
                                    <small><i><b><?php echo $sql_dft_id->nama; ?></b></i></small><br/>
                                    <?php echo $sql_dft_id->tgl_simpan ?><br/>
                                    TERIMAKASIH ATAS KUNJUNGAN ANDA
                                </p>
                            </div>
                        </div>
                    <?php } else { ?>
                        <?php echo form_open_multipart(base_url('medcheck/set_register.php'), 'autocomplete="off"') ?>
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="card-title m-0">Pelayanan Online</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">Pendaftaran melalui website bisa dilakukan untuk hari yang sama ketika Anda mendaftar pada formulir di bawah ini. Untuk membuat jadwal bertemu dengan dokter kami pada hari yang sama, silakan menghubungi rumah sakit via telepon.</p>

                                <div class="form-group <?php echo (!empty($hasError['jns_klm']) ? 'text-danger' : '') ?>">
                                    <label class="control-label">Apakah Anda*</label>
                                    <br/>
                                    <input type="radio" name="tipe_pas" value="1" id="pas_lama"> Pasien Lama
                                    <?php echo nbs(2) ?>
                                    <input type="radio" name="tipe_pas" value="2" checked="true" id="pas_baru"> Pasien Baru
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['nik']) ? 'text-danger' : '') ?>">
                                    <label class="control-label">NIK* <small><i>(* KTP / Passport / KIA)</i></small></label>
                                    <?php echo form_input(array('id' => 'nik', 'name' => 'nik', 'class' => 'form-control' . (!empty($hasError['nik']) ? ' is-invalid' : ''), 'value' => $pasien->nik, 'placeholder' => 'Nomor Identitas ...')) ?>
                                </div>
                                <div id="pasien_lama">
                                    <div class="form-group <?php // echo (!empty($hasError['no_rm']) ? 'text-danger' : '')   ?>">
                                        <label class="control-label">No RM* <small><i>(* Nomor Rekam Medis)</i></small></label>
                                        <div class="input-group mb-3">
                                            <?php echo form_input(array('id' => 'no_rm', 'name' => 'no_rm', 'class' => 'form-control' . (!empty($hasError['nik']) ? ' is-invalid' : ''), 'value' => $pasien->nik, 'placeholder' => 'Nomor Rekam Medis ...')) ?>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="pasien_baru">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group <?php echo (!empty($hasError['gelar']) ? 'text-danger' : '') ?>">
                                                <label class="control-label">Gelar*</label>
                                                <select name="gelar" class="form-control <?php echo (!empty($hasError['gelar']) ? 'is-invalid' : '') ?>">
                                                    <option value="">- Pilih -</option>
                                                    <?php foreach ($gelar as $gelar) { ?>
                                                        <option value="<?php echo $gelar->id ?>" <?php echo ($gelar->id == $pasien->id_gelar ? 'selected' : '') ?>><?php echo $gelar->gelar ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                            <div class="form-group <?php echo (!empty($hasError['nama']) ? 'text-danger' : '') ?>">
                                                <label class="control-label">Nama Lengkap*</label>
                                                <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'value' => $pasien->nama, 'placeholder' => 'John Doe ...')) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group <?php echo (!empty($hasError['jns_klm']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Jenis Kelamin*</label>
                                        <br/>
                                        <input type="radio" name="jns_klm" value="L" checked="TRUE"> Laki - Laki
                                        <?php echo nbs(2) ?>
                                        <input type="radio" name="jns_klm" value="P"> Perempuan
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group <?php echo (!empty($hasError['tmp_lahir']) ? 'has-error' : '') ?>">
                                                <label class="control-label">Tempat Lahir</label>
                                                <?php echo form_input(array('id' => 'tmp_lahir', 'name' => 'tmp_lahir', 'class' => 'form-control', 'value' => $pasien->tmp_lahir, 'placeholder' => 'Semarang ...')) ?>
                                            </div> 
                                        </div>
                                        <div class="col-md-4">                           
                                            <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                                <label class="control-label">Tgl Lahir</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                    </div>
                                                    <?php echo form_input(array('id' => 'tgl_lahir', 'name' => 'tgl_lahir', 'class' => 'form-control', 'value' => $pasien->tgl_lahir, 'placeholder' => '15/02/1992 ...')) ?>
                                                </div>                                        
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group <?php echo (!empty($hasError['nik']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Alamat <small><i>* Sesuai Domisili / Identitas Terbaru</i></small></label>
                                        <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'class' => 'form-control', 'value' => $pasien->nik, 'style' => 'height: 210px;', 'placeholder' => 'Mohon diisi alamat lengkap dan yang terbaru ...')) ?>
                                    </div>

                                    <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                        <label class="control-label">No. HP</label>
                                        <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control', 'value' => $pasien->no_hp, 'placeholder' => 'Nomor kontak pasien / keluarga pasien ...')) ?>
                                    </div>

                                    <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Pekerjaan</label>
                                        <select name="pekerjaan" class="form-control">
                                            <option value="">- Pilih -</option>
                                            <?php foreach ($kerja as $kerja) { ?>
                                                <option value="<?php echo $kerja->id ?>" <?php echo ($kerja->id == $pasien->id_pekerjaan ? 'selected' : '') ?>><?php echo $kerja->jenis ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['poli']) ? 'text-danger' : '') ?>">
                                    <label class="control-label">Poli</label>
                                    <select name="poli" class="form-control <?php echo (!empty($hasError['poli']) ? ' is-invalid' : '') ?>">
                                        <option value="">- Poli -</option>
                                        <?php foreach ($poli as $poli) { ?>
                                            <option value="<?php echo $poli->id ?>"><?php echo $poli->lokasi ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['dokter']) ? 'text-danger' : '') ?>">
                                    <label class="control-label">Dokter</label>
                                    <select name="dokter" class="form-control <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                        <option value="">- Dokter -</option>
                                        <?php foreach ($sql_doc as $doctor) { ?>
                                            <option value="<?php echo $doctor->id ?>"><?php echo strtoupper($doctor->nama) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['jns_klm']) ? 'text-danger' : '') ?>">
                                    <label class="control-label">Tgl Periksa*</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <?php echo form_input(array('id' => 'tgl_masuk', 'name' => 'tgl_masuk', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Silahkan isi tgl periksa ...')) ?>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    <?php } ?>
                </div>
                <div class="col-lg-<?php echo (isset($_GET['id']) ? '4' : '2') ?>">

                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $("#pasien_lama").hide();
        $("#pasien_baru").show();

        $("#pas_lama").click(function () {
            $("#pasien_baru").hide();
            $("#pasien_lama").show();
        });

        $("#pas_baru").click(function () {
            $("#pasien_baru").show();
            $("#pasien_lama").hide();
        });

        $("input[id=harga]").autoNumeric({aSep: '.', aDec: ',', aPad: false});

        $("#tgl_lahir").datepicker({
            format: 'dd/mm/yyyy',
            changeMonth: true,
            changeYear: true,
            yearRange: '1920:<?php echo date('Y') ?>',
            autoclose: true
        });

        var dateToday = new Date();
        $("#tgl_masuk").datepicker({
            format: 'dd/mm/yyyy',
            defaultDate: "+1w",
            changeMonth: true,
            minDate: dateToday,
            autoclose: true
        });

<?php if (!empty($sql_medc->id)) { ?>
            // Data Item Cart
            $('#kode').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url('medcheck/json_item.php?status=' . $this->input->get('status')) ?>",
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
                    $itemrow.find('#id_item').val(ui.item.id);
                    $('#id_item').val(ui.item.id);
                    $('#kode').val(ui.item.kode);
                    window.location.href = "<?php echo base_url('medcheck/resep/tambah.php?id=' . $this->input->get('id') . (isset($_GET['id_resep']) ? '&id_resep=' . $this->input->get('id_resep') : '') . '&status=' . $this->input->get('status')) ?>&id_item=" + ui.item.id + "&harga=" + ui.item.harga + "&satuan=" + ui.item.satuan;

                    // Give focus to the next input field to recieve input from user
                    $('#jml').focus();
                    return false;
                }

                // Format the list menu output of the autocomplete
            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<a>" + item.name + "</a>")
                        .appendTo(ul);
            };
<?php } ?>
    });
</script>