<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Akun <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Akun</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-4">
                <?php echo form_open(base_url('akuntability/data_akun_' . (isset($_GET['id']) ? 'update' : 'simpan') . '.php')) ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Akun</h3>
                    </div>
                    <div class="box-body">
                        <?php echo $this->session->flashdata('member'); ?>
                        <?php $hasError = $this->session->flashdata('form_error'); ?>
                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                        
                        <div class="form-group <?php echo (!empty($hasError['kode']) ? 'has-error' : '') ?>">
                            <label class="control-label">Kode</label>
                            <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control', 'value' => (isset($_GET['id']) ? $biaya->kode : ''))) ?>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['akun']) ? 'has-error' : '') ?>">
                            <label class="control-label">Akun</label>
                            <?php echo form_input(array('id' => 'akun', 'name' => 'akun', 'class' => 'form-control', 'value'=> $biaya->nama)) ?>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['akun']) ? 'has-error' : '') ?>">
                            <label class="control-label">Jenis Akun</label>
                            <div class="input-group date">
                                <select name="jenis" class="form-control">
                                    <option value="">- Pilih -</option>
                                    <?php $jns = $this->db->get('tbl_akt_akun_grup')->result() ?>
                                    <?php foreach ($jns as $jns){ ?>
                                        <option value="<?php echo $jns->id ?>" <?php echo ($jns->id == $biaya->id_akun_grup ? 'selected' : '') ?>><?php echo $jns->nama ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['keterangan']) ? 'has-error' : '') ?>">
                            <label class="control-label">Keterangan</label>
                            <?php echo form_input(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control', 'value' => $biaya->keterangan)) ?>
                        </div>
                    </div>
                    <div class="box-footer">                        
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" onclick="window.location.href = '<?php echo base_url('akuntability/data_akun_list.php') ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>
                            </div>
                            <div class="col-lg-6 text-right">
                                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
            <?php if(isset($_GET['case'])){ ?>
                <div class="col-lg-8">
                        <div class="box box-warning">
                            <div class="box-header with-border">
                                <h3 class="box-title">Data Jenis Biaya</h3>
                            </div>
                            <div class="box-body">
                                    <?php echo form_open(base_url('akuntability/data_peng_jns_simpan.php')) ?>
                                    <?php echo form_hidden('id', $this->input->get('id')) ?>
                                    <div class="row">
                                        <div class="col-sm-6">                                            
                                            <table class="table table-responsive">
                                                <tr>
                                                    <td class="text-right">
                                                        <?php echo form_input(array('name' => 'jenis', 'class' => 'form-control')) ?>
                                                    </td>
                                                    <td class="text-left">
                                                        <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <?php echo form_close() ?>
                                    <?php echo br(2) ?>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-left">Jenis Biaya</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($jenis)) {
                                                $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                                foreach ($jenis as $jenis) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $no++ ?>.</td>
                                                        <td><?php echo $jenis->jenis ?></td>
                                                        <td>
                                                            <?php echo anchor(base_url('akuntability/data_peng_jns_hapus.php?aid=' . general::enkrip($jenis->id).'&id='.general::enkrip($biaya->id)), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $jenis->jenis . '] ? \')" class="label label-danger"') ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                </div>
            <?php } ?>
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
      $("#harga_beli").autoNumeric({aSep: '.', aDec: ',', aPad: false});
      $("#nominal").autoNumeric({aSep: '.', aDec: ',', aPad: false});
      $('#tgl').datepicker({ autoclose: true });
      
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
  });
</script>