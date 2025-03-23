<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Sub Kategori
                <small>
                    <a href="#" data-toggle="modal" data-target="#modal-form-kategori">
                        <button class="btn btn-warning"><i class="fa fa-plus"></i> Tambah</button>
                    </a>
                </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
                <li class="active">Sub Kategori</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row" id="bag-kategori">
                <?php foreach ($kategori2 as $kategori2) { ?>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3><?php echo ucwords($kategori2->kategori) ?></h3>
                                <p><?php echo ($kategori2->status_temp == 1 ? anchor(base_url('cart/cart-step-2-hapus.php?id='.general::enkrip($kategori2->id).'&id_kat1='.general::enkrip($kategori2->id_kategori)),'<i class="fa fa-remove"></i><b>Hapus</b>','class="text-danger" onclick="return confirm(\'Hapus ?\')"') : nbs()) ?></p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="<?php echo base_url('cart/cart-step-3.php?id_kat1='.$this->input->get('id_kat1').'&id_kat2='.general::enkrip($kategori2->id)) ?>" class="small-box-footer">Pilih <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
        <!-- /.content -->

        <!--Modal Form Kategori-->
        <div class="modal modal-default fade" id="modal-form-kategori">
            <div class="modal-dialog">
                <div class="modal-content">            
                    <!--Nampilin message box success-->
                    <div id="msg-success" class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="glyphicon glyphicon-ok"></i><?php echo nbs(4) ?>Kategori berhasil ditambahkan !!</h5>
                    </div>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Form Kategori</h4>
                    </div>
                    <form class="tagForm" id="form-kategori">
                        <input type="hidden" id="id_kategori" name="id_kategori" value="<?php echo $this->input->get('id_kat1') ?>">
                        <div class="modal-body">
                            <div class="form-group <?php echo (!empty($hasError['kategori']) ? 'has-error' : '') ?>">
                                <label class="control-label">Nama Kategori</label>
                                <?php echo form_input(array('id' => 'kategori', 'name' => 'kategori', 'class' => 'form-control')) ?>
                            </div>

                            <div class="form-group <?php echo (!empty($hasError['harga']) ? 'has-error' : '') ?>">
                                <label class="control-label">Harga</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        Rp.
                                    </div>
                                    <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control', 'style'=>'width: 200px;')) ?>
                                </div>
                            </div>

                            <div class="form-group <?php echo (!empty($hasError['keterangan']) ? 'has-error' : '') ?>">
                                <label class="control-label">Keterangan</label>
                                <?php echo form_input(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control')) ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-flat pull-left" data-dismiss="modal">Close</button>
                            <button type="button" id="submit-form-kategori" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    <!-- /.container -->
</div>

<style>
    .clicked {
        background-color: #ffff00;
    }
</style>
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
<script>
    $(function () {
        $('#msg-success').hide();
        
        $("#harga").autoNumeric({aSep: '.', aDec: ',', aPad: false});

        $('#submit-form-kategori').on('click', function (e) {
            var kategori    = $('#kategori').val();
            var keterangan  = $('#keterangan').val();
            var harga       = $('#harga').val();

            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('cart/cart-step-2-simpan.php') ?>",
                data: $("#form-kategori").serialize(),
                success: function (data) {
                    $('#kategori').val('');
                    $('#harga').val('');
                    $('#keterangan').val('');
                    $("#bag-kategori").load("<?php echo base_url('cart/cart-step-2.php?id_kat1='.$this->input->get('id_kat1')) ?> #bag-kategori");
                    $('#msg-success').show();
                    $("#modal-form-kategori").modal('hide');
                    setTimeout(function () {
                        $('#msg-success').hide('blind', {}, 500)
                    }, 3000);
                },
                error: function () {
                    alert('Error');
                }
            });
            return false;
        });
    });
</script>