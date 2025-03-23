<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Member <small>Deposit</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Member</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-sm-9 col-md-8">
                <div class="row">
                    <div class="col-sm-12 col-md-7" id="data-profil">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="height: 100px;"></div>
                            <div class="panel-body">
                                <div class="row" style="margin-top: -65px;margin-bottom: 20px">
                                    <div class="col-xs-offset-2 col-xs-8 col-sm-offset-4 col-sm-4 text-center">
                                        <img class="img-thumbnail" src="<?php echo base_url('assets/theme/admin-lte-2/icon_putra.png') ?>">
                                    </div>
                                </div>
                                <div class="table-responsiveX">
                                    <div align="center"></div>
                                    <table class="table" style="margin-bottom: 0;">
                                        <tbody>
                                            <tr><td class="text-bold" style="width: 140px;">NIK</td><td>: <?php echo $member->nik ?></td></tr>
                                            <tr><td class="text-bold" style="width: 140px;">Nama Lengkap</td><td>: <?php echo $member->nama ?></td></tr>
                                            <tr><td class="text-bold" style="width: 140px;">Alamat</td><td>: <?php echo $member->alamat ?></td></tr>
                                            <tr><td class="text-bold" style="width: 140px;">No. HP</td><td>: <?php echo $member->no_hp ?></td></tr>
                                            <tr><td class="text-bold" style="width: 140px;">Jenis Akun</td><td>: <?php echo $member->grup ?></td></tr>
                                            <tr><td class="text-bold" style="width: 140px;">Saldo</td><td class="text-left">: <?php echo number_format($member_saldo->jml_deposit, 0, ',', '.') ?>&nbsp;&nbsp;&nbsp;</td></tr>
                                            <tr><td class="text-bold" style="width: 140px;">Total Transaksi</td><td>: -</td></tr>
                                            <tr><td class="text-bold" style="width: 140px;">Tanggal Mendaftar</td><td>: -</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>              
                    </div>
                    <div class="col-sm-12 col-md-5">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3><i class="fa fa-sticky-note-o"></i> History Transaksi</h3>
                            </div>
                            <ul class="list-group">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-6">
                <div class="box box-warning">
                    <div class="box-body">
                        <div class="well well-sm">
                            <?php echo form_open(base_url('member/member_deposit_simpan.php'), 'class="form-inline"') ?>
                            <?php echo form_hidden('id', $this->input->get('id')) ?>

                            <div class="form-group">
                                <label class="sr-only" for="amount">Jumlah Deposit</label>
                                <?php echo form_input(array('id' => 'jml_deposit', 'name' => 'jml_deposit', 'class' => 'form-control', 'placeholder' => 'Masukkan jml deposit ...')) ?>
                            </div>
                            <button class="btn btn-primary" type="submit" name="submit" value="deposit">Deposit</button>
                            <?php echo form_close() ?>
                        </div>
                        <hr/>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Tanggal</th>
                                    <th class="text-left">Keterangan</th>
                                    <th class="text-right">Debet</th>
                                    <th class="text-right">Kredit</th>
                                    <th class="text-right">Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($member_hist as $hist) { ?>
                                <?php $tgl = explode('-', $hist->tgl_simpan); ?>
                                    <tr>
                                        <td class="text-center"><?php echo $no++ ?>.</td>
                                        <td><?php echo $tgl[1].'/'.$tgl[2].'/'.$tgl[0] ?></td>
                                        <td class="text-left"><?php echo $hist->keterangan ?></td>
                                        <td class="text-right"><?php echo general::format_angka($hist->debet) ?></td>
                                        <td class="text-right"><?php echo general::format_angka($hist->kredit) ?></td>
                                        <td class="text-right"><?php echo general::format_angka($hist->jml_deposit) ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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
//      Jquery kanggo format angka
//        $("#gtotal").autoNumeric({aSep: '.', aDec: ',', aPad: false});
        $("#jml_deposit").autoNumeric({aSep: '.', aDec: ',', aPad: false});

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