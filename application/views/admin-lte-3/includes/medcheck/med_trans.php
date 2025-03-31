<?php
/**
 * Medical Transaction View
 * 
 * This view handles the medical checkup transaction form interface
 * Includes patient selection, vital signs input, and medical data entry
 * 
 * @author    Mikhael Felian Waskito <mikhaelfelian@gmail.com>
 * @date      2025-03-28
 */
defined('BASEPATH') or exit('No direct script access allowed');
?>

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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('medcheck/index.php') ?>">Medical
                                Checkup</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
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
                    <?php echo form_open_multipart(base_url('medcheck/set_medcheck.php'), 'id="medcheck_form" autocomplete="off"') ?>
                    <?php echo add_form_protection() ?>

                    <div class="card card-default rounded-0">
                        <div class="card-header">
                            <h3 class="card-title">Form Medical Checkup</h3>
                            <div class="card-tools">
                                
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <div class="row">
                                <div class="col-md-5">
                                    <?php $hasError = $this->session->flashdata('form_error'); ?>
                                    <?php echo form_hidden('timestamp', time()); ?>
                                    <?php echo form_hidden('id', $this->input->get('id')) ?>
                                    <?php echo form_hidden('dokter', $sql_dft_id->id_dokter) ?>

                                    <input type="hidden" id="id_pasien" name="id_pasien" <?php echo (!empty($sql_dft_pas->nama_pgl) ? 'value="' . $sql_dft_pas->id . '"' : '') ?>>
                                    <input type="hidden" id="id_pasien" name="dft_id" <?php echo (!empty($sql_dft_id->id) ? 'value="' . $sql_dft_id->id . '"' : '') ?>>
                                    <input type="hidden" id="id_pasien" name="ant_id" <?php echo (!empty($sql_dft_id->id_ant) ? 'value="' . $sql_dft_id->id_ant . '"' : '') ?>>

                                    <div
                                        class="form-group <?php echo (!empty($hasError['pasien']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Nama Pasien*</label>
                                        <div class="input-group mb-3">
                                            <?php echo form_input(array('id' => 'pasien', 'name' => 'pasien', 'class' => 'form-control rounded-0 text-middle' . (!empty($hasError['pasien']) ? ' is-invalid' : ''), 'style' => 'vertical-align: middle;', 'placeholder' => 'Cari berdasarkan nama lengkap, telepon atau alamat ...', 'value' => (!empty($sql_dft_pas->nama_pgl) ? $sql_dft_pas->nama_pgl : ''), 'readonly' => 'true')) ?>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-plus"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="form-group <?php echo (!empty($hasError['tipe']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Tipe*</label>

                                        <select name="tipe"
                                            class="form-control <?php echo (!empty($hasError['tipe']) ? ' is-invalid' : '') ?>">
                                            <option value="">- Tipe -</option>
                                            <option value="1" <?php echo ($sql_dft_id->tipe_rawat == '1' ? ' selected' : '') ?>>Laborat</option>
                                            <option value="4" <?php echo ($sql_dft_id->tipe_rawat == '4' ? ' selected' : '') ?>>Radiologi</option>
                                            <option value="2" <?php echo ($sql_dft_id->tipe_rawat == '2' ? ' selected' : '') ?>>Rawat Jalan</option>
                                            <option value="3" <?php echo ($sql_dft_id->tipe_rawat == '3' ? ' selected' : '') ?>>Rawat Inap</option>
                                            <option value="5" <?php echo ($sql_dft_id->tipe_rawat == '5' ? ' selected' : '') ?>>MCU</option>
                                        </select>
                                    </div>
                                    <div
                                        class="form-group <?php echo (!empty($hasError['poli']) ? 'text-danger' : '') ?>">
                                        <label class="control-label">Klinik</label>
                                        <select name="poli"
                                            class="form-control rounded-0 <?php echo (!empty($hasError['poli']) ? ' is-invalid' : '') ?>"
                                            readonly="true">
                                            <option value="">- Poli -</option>
                                            <?php foreach ($poli as $poli) { ?>
                                                <option value="<?php echo $poli->id ?>" <?php echo ($sql_dft_id->id_poli == $poli->id ? 'selected' : '') ?>>
                                                    <?php echo $poli->lokasi ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div
                                        class="form-group <?php // echo (!empty($hasError['pasien']) ? 'has-error' : '')        ?>">
                                        <label class="control-label">Dokter</label>
                                        <div class="input-group mb-3">
                                            <?php echo form_input(array('id' => '', 'name' => '', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Nama Dokter ...', 'value' => $this->ion_auth->user($sql_dft_id->id_dokter)->row()->first_name, 'disabled' => 'true')) ?>
                                        </div>
                                    </div>
                                    <div
                                        class="form-group <?php // echo (!empty($hasError['pasien']) ? 'has-error' : '')        ?>">
                                        <label class="control-label">Petugas</label>
                                        <div class="input-group mb-3">
                                            <?php echo form_input(array('id' => 'petugas', 'name' => 'petugas', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Nama Petugas ...', 'value' => $this->ion_auth->user($sql_dft_pas->id_user)->row()->first_name, 'disabled' => 'true')) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="control-label">Keluhan</label>
                                        <div class="input-group mb-3">
                                            <?php echo form_textarea(array('id' => 'keluhan', 'name' => 'keluhan', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['keluhan']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Keluhan Pasien ...', 'style' => 'height: 125px;', 'value' => $this->session->flashdata('keluhan'))) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Suhu Tubuh</label>
                                        <div class="col-sm-3">
                                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_st', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['ttv_st']) ? ' is-invalid' : ''), 'placeholder' => 'Suhu Tubuh ...', 'value' => $this->session->flashdata('ttv_st'))) ?>
                                        </div>
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Berat Badan</label>
                                        <div class="col-sm-3">
                                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_bb', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['ttv_bb']) ? ' is-invalid' : ''), 'placeholder' => 'Berat Badan ...', 'value' => $this->session->flashdata('ttv_bb'))) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Tinggi Badan</label>
                                        <div class="col-sm-3">
                                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_tb', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['ttv_tb']) ? ' is-invalid' : ''), 'placeholder' => 'Tinggi Badan ...', 'value' => $this->session->flashdata('ttv_tb'))) ?>
                                        </div>
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Nadi</label>
                                        <div class="col-sm-3">
                                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_nadi', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['ttv_nadi']) ? ' is-invalid' : ''), 'placeholder' => 'Nadi ...', 'value' => $this->session->flashdata('ttv_nadi'))) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Sistole</label>
                                        <div class="col-sm-3">
                                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_sistole', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['ttv_sistole']) ? ' is-invalid' : ''), 'placeholder' => 'Sistole ...', 'value' => $this->session->flashdata('ttv_sistole'))) ?>
                                        </div>
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Diastole</label>
                                        <div class="col-sm-3">
                                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_diastole', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['ttv_diastole']) ? ' is-invalid' : ''), 'placeholder' => 'Diastole ...', 'value' => $this->session->flashdata('ttv_diastole'))) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Laju Napas</label>
                                        <div class="col-sm-3">
                                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_laju', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['ttv_laju']) ? ' is-invalid' : ''), 'placeholder' => 'Laju Napas ...', 'value' => $this->session->flashdata('ttv_laju'))) ?>
                                        </div>
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Saturasi</label>
                                        <div class="col-sm-3">
                                            <?php echo form_input(array('id' => 'ttv', 'name' => 'ttv_saturasi', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['ttv_saturasi']) ? ' is-invalid' : ''), 'placeholder' => 'Saturasi ...', 'value' => $this->session->flashdata('ttv_saturasi'))) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Skala Nyeri</label>
                                        <div class="col-sm-3">
                                            <select name="ttv_skala"
                                                class="form-control rounded-0 <?php echo (!empty($hasError['ttv_skala']) ? ' is-invalid' : '') ?>">
                                                <option value="">- Pilih -</option>
                                                <?php for ($a = 0; $a <= 10; $a++) { ?>
                                                    <option value="<?php echo $a; ?>" <?php echo ($this->session->flashdata('ttv_skala') == $a ? 'selected' : '') ?>>
                                                        Skala <?php echo $a; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Upload Foto</label>
                                        <div class="col-sm-3">
                                            <input type="file" name="fupload">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <!--<button type="button" onclick="window.location.href = '<?php echo base_url('master/data_kategori_list.php') ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>-->
                                </div>
                                <div class="col-lg-6 text-right">
                                    <button type="button" class="btn btn-warning btn-flat"><i class="fa fa-undo"></i>
                                        Bersih</button>
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i>
                                        Set Periksa</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php echo add_double_submit_protection('medcheck_form'); ?>
                    <?php echo form_close() ?>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!--/.content-wrapper-->

<!-- Add this CDN version instead -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet"
    href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!-- Update your JavaScript code -->
<script type="text/javascript">
    $(function () {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        // Use the older autoNumeric syntax
        $("input[id=ttv]").autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            aPad: false
        });

        // Data Pasien
        $('#pasien').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('medcheck/json_pasien.php') ?>",
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