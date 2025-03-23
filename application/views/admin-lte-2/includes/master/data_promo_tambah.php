<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Promo <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Promo</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-4">
                <?php echo form_open(base_url('master/data_promo_'.(isset($_GET['id']) ? 'update' : 'simpan').'.php'), 'autocomplete="off"') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Data Promo</h3>
                    </div>
                    <div class="box-body">
                        <?php echo $this->session->flashdata('master'); ?>
                        <?php $hasError = $this->session->flashdata('form_error'); ?>
                        <?php echo form_hidden('id', $this->input->get('id')) ?>
                        <div class="form-group <?php echo (!empty($hasError['kategori']) ? 'has-error' : '') ?>">
                            <label class="control-label">Promo</label>
                            <?php echo form_input(array('id' => 'promo', 'name' => 'promo', 'class' => 'form-control', 'value' => $promo->promo)) ?>
                        </div>

                        <div class="form-group <?php echo (!empty($hasError['keterangan']) ? 'has-error' : '') ?>">
                            <label class="control-label">Keterangan</label>
                            <?php echo form_input(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control', 'value' => $promo->keterangan)) ?>
                        </div>                       
                        <!--
                        <div class="form-group <?php echo (!empty($hasError['tipe']) ? 'has-error' : '') ?>">
                            <label class="control-label">Tipe</label>
                            <?php echo br() ?>
                            <input id="tipe_persen" type="radio" name="tipe" value="1" checked="TRUE"> Persen
                            <?php echo nbs(2) ?>
                            <input id="tipe_potongan" type="radio" name="tipe" value="2"> Potongan
                        </div>                        
                        <div id="persen" class="form-group <?php echo (!empty($hasError['persen']) ? 'has-error' : '') ?>">
                            <div class="input-group">
                                <?php echo form_input(array('id' => 'diskon', 'name' => 'disk1', 'class' => 'form-control')) ?>
                                <span class="input-group-addon no-border text-bold">+</span>
                                <?php echo form_input(array('id' => 'diskon', 'name' => 'disk2', 'class' => 'form-control')) ?>
                                <span class="input-group-addon no-border text-bold">+</span>
                                <?php echo form_input(array('id' => 'diskon', 'name' => 'disk3', 'class' => 'form-control')) ?>
                            </div>
                        </div>                         
                        <div id="potongan" class="form-group <?php echo (!empty($hasError['potongan']) ? 'has-error' : '') ?>">
                            <?php echo form_input(array('id' => 'pot', 'name' => 'potongan', 'class' => 'form-control')) ?>
                        </div>
                        -->
                    </div>
                    <div class="box-footer">                        
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" onclick="window.location.href = '<?php echo base_url('master/data_promo_list.php') ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>
                            </div>
                            <div class="col-lg-6 text-right">
                                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
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
         $('#potongan').hide();
         
        $("#pot").autoNumeric({aSep: '.', aDec: ',', aPad: false});
        $("#diskon1").autoNumeric({aSep: '.', aDec: ',', aPad: false});
        $("#diskon2").autoNumeric({aSep: '.', aDec: ',', aPad: false});
        $("#diskon3").autoNumeric({aSep: '.', aDec: ',', aPad: false});

         $('#tipe_persen').click(function () {
             $('#persen').show()
             $('#potongan').hide()
         });

         $('#tipe_potongan').click(function () {
             $('#persen').hide()
             $('#potongan').show()
         });
     });
</script>