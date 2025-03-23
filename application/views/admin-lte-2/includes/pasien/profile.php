<div class="content-wrapper" style="min-height: 956.281px;">
    <section class="content-header">
        <h1>
            Profile
            <small>Pasien</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="active">Profile</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">

                <div class="box box-primary">
                    <div class="box-body box-profile">                        
                        <?php
                        $file = (!empty($pasien->file_name) ? realpath($pasien->file_name) : '');
                        $foto = (file_exists($file) ? base_url($pasien->file_name) : $pasien->file_base64);
                        ?>
                        <img class="profile-user-img img-responsive img-circle" src="<?php echo (!empty($foto) ? $foto : base_url('assets/theme/admin-lte-3/icon_putra.png')) ?>" alt="User profile picture"  style="width: 130px; height: 130px;">
                        <h3 class="profile-username text-center"><?php echo $pasien->nama ?></h3>
                        <p class="text-muted text-center"><?php echo strtoupper($this->tanggalan->tgl_indo2($pasien->tgl_lahir)) ?></p>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>No. RM</b> <a class="pull-right"><?php echo strtoupper($this->ion_auth->user()->row()->username) ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>No. HP</b> <a class="pull-right"><?php echo $pasien->no_hp ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>No. Telp</b> <a class="pull-right"><?php echo $pasien->no_rmh ?></a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Pasien</h3>
                    </div>                        
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">NIK <small><i>(* KTP / Passport / KIA)</i></small></label>
                                    <?php echo form_input(array('id' => 'nik', 'name' => 'nik', 'class' => 'form-control', 'value' => (!empty($pasien->nik) ? $pasien->nik : $this->session->flashdata('nik')), 'placeholder' => 'John Doe ...', 'readonly' => 'TRUE')) ?>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3">
                                        <?php echo form_hidden('gelar', $pasien->id_gelar) ?>
                                        <div class="form-group">
                                            <label class="control-label">Gelar*</label>
                                            <select name="" class="form-control <?php echo (!empty($hasError['gelar']) ? 'is-invalid' : '') ?>" readonly="TRUE">
                                                <option value="">- Pilih -</option>
                                                <?php foreach ($gelar as $gelar) { ?>
                                                    <option value="<?php echo $gelar->id ?>" <?php echo ($gelar->id == $pasien->id_gelar ? 'selected' : '') ?>><?php echo $gelar->gelar ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'text-danger' : '') ?>">
                                            <label class="control-label">Nama Lengkap*</label>
                                            <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'class' => 'form-control' . (!empty($hasError['nama']) ? ' is-invalid' : ''), 'value' => (!empty($pasien->nama) ? $pasien->nama : $this->session->flashdata('nama')), 'placeholder' => 'John Doe ...', 'readonly' => 'TRUE')) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">No. Rmh</label>
                                    <?php echo form_input(array('id' => 'no_rmh', 'name' => 'no_rmh', 'class' => 'form-control', 'value' => (!empty($pasien->no_rmh) ? $pasien->no_rmh : $this->session->flashdata('no_rmh')), 'placeholder' => 'Nomor kontak pasien / keluarga pasien ...', 'readonly' => 'TRUE')) ?>
                                </div>                             
                                <div class="form-group">
                                    <label class="control-label">Alamat</label>
                                    <?php echo form_textarea(array('id' => 'no_rmh', 'name' => 'no_rmh', 'class' => 'form-control', 'value' => (!empty($pasien->alamat) ? $pasien->alamat : $this->session->flashdata('no_rmh')), 'placeholder' => 'Alamat KTP ...', 'readonly' => 'TRUE')) ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Instansi</label>
                                    <?php echo form_input(array('id' => 'no_rmh', 'name' => 'no_rmh', 'class' => 'form-control', 'value' => (!empty($pasien->no_rmh) ? $pasien->instansi : $this->session->flashdata('no_rmh')), 'placeholder' => 'Nama Instansi ...', 'readonly' => 'TRUE')) ?>
                                </div>                            
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Tempat Lahir</label>
                                    <?php echo form_input(array('id' => 'tmp_lahir', 'name' => 'tmp_lahir', 'class' => 'form-control', 'value' => (!empty($pasien->tmp_lahir) ? $pasien->tmp_lahir : $this->session->flashdata('tmp_lahir')), 'placeholder' => 'Semarang ...', 'readonly' => 'TRUE')) ?>
                                </div>                           
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <?php echo form_input(array('id' => 'tgl_lahir', 'name' => 'tgl_lahir', 'class' => 'form-control', 'value' => (!empty($pasien->tgl_lahir) ? $this->tanggalan->tgl_indo($pasien->tgl_lahir) : $this->session->flashdata('tgl_lahir')), 'placeholder' => 'Semarang ...', 'readonly' => 'TRUE')) ?>
                                    </div>
                                </div>
                                <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                    <label class="control-label">No. HP</label>
                                    <?php echo form_input(array('id' => 'no_hp', 'name' => 'no_hp', 'class' => 'form-control', 'value' => (!empty($pasien->no_hp) ? $pasien->no_hp : $this->session->flashdata('no_hp')), 'placeholder' => 'Nomor kontak pasien / keluarga pasien ...', 'readonly' => 'TRUE')) ?>
                                </div>                            
                                <div class="form-group">
                                    <label class="control-label">Alamat Domisili</label>
                                    <?php echo form_textarea(array('id' => 'no_rmh', 'name' => 'no_rmh', 'class' => 'form-control', 'value' => (!empty($pasien->alamat) ? $pasien->alamat : $this->session->flashdata('no_rmh')), 'placeholder' => 'Alamat Domisili ...', 'readonly' => 'TRUE')) ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Alamat Instansi</label>
                                    <?php echo form_input(array('id' => 'no_rmh', 'name' => 'no_rmh', 'class' => 'form-control', 'value' => (!empty($pasien->instansi_alamat) ? $pasien->instansi_alamat : $this->session->flashdata('no_rmh')), 'placeholder' => 'Nomor kontak pasien / keluarga pasien ...', 'readonly' => 'TRUE')) ?>
                                </div>                           
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.min.css') ?>">

<!--Datepicker-->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $('#msg-success').hide();
        $(".select2").select2();
        $('#tgl_masuk').datepicker({autoclose: true});

        $('#tgl_tempo').datepicker({
            autoclose: true,
        });

        $('#tgl_bayar').datepicker({
            autoclose: true,
        });

        $("#harga").autoNumeric({aSep: '.', aDec: ',', aPad: false});
        $("#disk1").autoNumeric({aSep: '.', aDec: ',', aPad: false});
        $("#disk2").autoNumeric({aSep: '.', aDec: ',', aPad: false});
        $("#disk3").autoNumeric({aSep: '.', aDec: ',', aPad: false});
        $("#jml").keydown(function (e) {
            // kibot: backspace, delete, tab, escape, enter .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // kibot: Ctrl+A, Command+A
                            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // kibot: home, end, left, right, down, up
                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // Biarin wae, ga ngapa2in return false
                        return;
                    }
                    // Cuman nomor
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });
        $("#ppn").keydown(function (e) {
            // kibot: backspace, delete, tab, escape, enter .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // kibot: Ctrl+A, Command+A
                            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // kibot: home, end, left, right, down, up
                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // Biarin wae, ga ngapa2in return false
                        return;
                    }
                    // Cuman nomor
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });

        $("input[id=diskon]").keydown(function (e) {
            // kibot: backspace, delete, tab, escape, enter .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // kibot: Ctrl+A, Command+A
                            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // kibot: home, end, left, right, down, up
                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // Biarin wae, ga ngapa2in return false
                        return;
                    }
                    // Cuman nomor
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });

        //Autocomplete buat produk
        $('#customer').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('transaksi/json_customer.php') ?>",
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
                $itemrow.find('#id_customer').val(ui.item.id);
                $('#id_customer').val(ui.item.id);
                $('#customer').val(ui.item.nama);

                //Give focus to the next input field to recieve input from user
                $('#customer').focus();
                return false;
            }

            //Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.nik + "</a> <a>(" + item.jns_klm + ")</a></br><a>" + item.nama + "</a></br><a>" + item.alamat + "</a></br>-----------------------------------------")
                    .appendTo(ul);
        };

        //Autocomplete buat sales
        $('#sales').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('transaksi/json_sales.php') ?>",
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
                $itemrow.find('#id_sales').val(ui.item.id);
                $('#id_sales').val(ui.item.id);
                $('#sales').val(ui.item.nama);

                //Give focus to the next input field to recieve input from user
                $('#sales').focus();
                return false;
            }

            //Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.nama + "</a>")
                    .appendTo(ul);
        };

<?php if (!empty($sess_jual)) { ?>
            //Autocomplete buat Barang
            $('#kode').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url('transaksi/json_barang.php?status=2&kat=') ?>",
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
                    $itemrow.find('#id_barang').val(ui.item.id);
                    $('#id_barang').val(ui.item.id);
                    $('#kode').val(ui.item.kode);
                    $('#harga').val(ui.item.harga_grosir);
                    $('#jml').val('1');
                    window.location.href = "<?php echo base_url('transaksi/trans_jual.php?id=' . $this->input->get('id')) ?>&id_produk=" + ui.item.id + "&harga=" + ui.item.harga;

                    //Give focus to the next input field to recieve input from user
                    $('#jml').focus();
                    return false;
                }

                //Format the list menu output of the autocomplete
            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<a>[" + item.kode + "] " + item.produk + "</a>")
                        .appendTo(ul);
            };
<?php } ?>

        $('#submit-pelanggan').on('click', function (e) {
            var nik = $('#nik').val();
            var nama = $('#nama').val();
            var nama_toko = $('#nama_toko').val();
            var lokasi = $('#lokasi').val();
            var no_hp = $('#no_hp').val();
            var alamat = $('#alamat').val();

            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('master/data_customer_simpan2.php') ?>",
                data: $("#form-pelanggan").serialize(),
                success: function (data) {
                    $('#nik').val('');
                    $('#nama').val('');
                    $('#nama_toko').val('');
                    $('#lokasi').val('');
                    $('#no_hp').val('');
                    $('#alamat').val('');

//                   window.location.href='<?php // echo base_url('master/data_customer_tambah.php?id=')                                 ?>' + data.trim() + '&route=transaksi/trans_jual.php';
//
//                   $("#bag-pelanggan").load("<?php // echo base_url('transaksi/trans_jual.php')                                 ?> #bag-pelanggan", function () {
//                       $(".select2").select2();
//                   });
                    $('#msg-success').show();
                    $("#modal-primary").modal('hide');
//                   setTimeout(function () {
//                       $('#msg-success').hide('blind', {}, 500)
//                   }, 3000);
//                    alert(result.id);
                },
                error: function () {
                    alert('Error');
                }
            });
            return false;
        });

        /* Data Satuan */
        $("#satuan").on('change', function () {
            var sat_jual = $('#satuan option:selected').val();
            $.ajax({
                type: "GET",
                url: "<?php echo site_url('page=transaksi&act=json_barang_sat&id=' . general::dekrip($this->input->get('id_produk'))) ?>&satuan=" + sat_jual + "",
                dataType: "json",
                success: function (data) {
                    $('#harga').val(data.harga);
                }
            });
        });


        /* HARGA DS */
        $("#harga_ds").on('change', function () {
            if (this.checked) {
                var jml_brg = $('#jml').val().replace(/[.]/g, "");
                var harga_j = $('#harga').val().replace(/[.]/g, "");
                var jml_harga = (jml_brg / 12) * harga_j;

                $('#harga').val(Math.round(jml_harga)).autoNumeric({aSep: '.', aDec: ',', aPad: false});
            }
        });

    });
</script>