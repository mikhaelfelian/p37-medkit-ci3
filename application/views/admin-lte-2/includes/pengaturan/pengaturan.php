<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Pengaturan <small>Aplikasi</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard.php') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Pengaturan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-4">
                <?php echo form_open(base_url('pengaturan/set_pengaturan.php')) ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Pengaturan</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                            <label class="control-label">Nama Perusahaan</label>
                            <?php echo form_input(array('name' => 'judul', 'class' => 'form-control', 'value' => $pengaturan->judul)) ?>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['user']) ? 'has-error' : '') ?>">
                            <label class="control-label">Alamat</label>
                            <?php echo form_input(array('name' => 'alamat', 'class' => 'form-control', 'value' => $pengaturan->alamat)) ?>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['pass1']) ? 'has-error' : '') ?>">
                            <label class="control-label">Kota</label>
                            <?php echo form_input(array('name' => 'kota', 'class' => 'form-control', 'value' => $pengaturan->kota)) ?>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['pass2']) ? 'has-error' : '') ?>">
                            <label class="control-label">Jml PPN</label>
                            <?php echo form_input(array('id' => 'jml_ppn', 'name' => 'jml_ppn', 'class' => 'form-control', 'value' => $pengaturan->jml_ppn)) ?>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['pass2']) ? 'has-error' : '') ?>">
                            <label class="control-label">Jml Item per Halaman</label>
                            <?php echo form_input(array('id' => 'jml_item', 'name' => 'jml_item', 'class' => 'form-control', 'value' => $pengaturan->jml_item)) ?>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['pass2']) ? 'has-error' : '') ?>">
                            <label class="control-label">Jml Minimal Stok <i>* Notif untuk purchase order dalam satuan terkecil</i></label>
                            <?php echo form_input(array('id' => 'jml_item_limit', 'name' => 'jml_item_limit', 'class' => 'form-control', 'value' => $pengaturan->jml_limit_stok)) ?>
                        </div>
                        <?php if (akses::hakSA() == TRUE){ ?>
                        <div class="form-group <?php echo (!empty($hasError['cabang']) ? 'has-error' : '') ?>">
                            <label class="control-label">Cabang / Lokasi</label>
                            <select name="cabang" class="form-control">
                                <option value="">- Pilih -</option>
                                <?php
                                $cbg = $this->db->order_by('id', 'asc')->get('tbl_pengaturan_cabang')->result();
                                foreach ($cbg as $cbg) {
                                   echo '<option value="' . $cbg->id . '" ' . ($cbg->id == $pengaturan->id_app ? 'selected' : '') . '>' . strtoupper($cbg->keterangan) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="box-footer">
                        <button type="reset" class="btn btn-default">Batal</button>
                        <button type="submit" class="btn btn-info pull-right">Simpan</button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<style>
    .clicked {
        background-color: #ffff00;
    }
</style>

<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/sb-admin') ?>/ui/jquery-ui.min.css" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.min.css') ?>">

<!--Datepicker-->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Page script -->
<script>
    $(function () {
        $("#jml_ppn").keydown(function (e) {
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
        $("#jml_item").keydown(function (e) {
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
        $("#jml_item_limit").keydown(function (e) {
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
    });
</script>