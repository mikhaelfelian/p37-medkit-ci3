<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Grup Data Pelanggan <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Grup Data Pelanggan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-4">
                <?php echo form_open('page=produk&act=prod_plgngrp_simpan', '') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Grup</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group <?php echo (!empty($hasError['grup']) ? 'has-error' : '') ?>">
                            <label class="control-label">Grup</label>
                            <?php echo form_input(array('name' => 'grup', 'class' => 'form-control')) ?>
                        </div>
                        <div class="form-group <?php echo (!empty($hasError['diskon']) ? 'has-error' : '') ?>">
                            <label class="control-label">Diskon</label>
                            <div class="input-group col-xs-12">                                
                                <div class="input-group-addon">
                                    Rp. 
                                </div>
                                <?php echo form_input(array('id' => 'diskon', 'name' => 'diskon', 'class' => 'form-control col-lg-12')) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Keterangan</label>
                            <?php echo form_input(array('name' => 'keterangan', 'class' => 'form-control')) ?>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="reset" class="btn btn-default">Batal</button>
                        <button type="submit" class="btn btn-info pull-right">Simpan</button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
            <div class="col-lg-8">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Pelanggan Grup</h3>
                        <div class="box-tools">
                            <?php echo form_open('page=produk&act=set_cari_plgn') ?>
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" name="pencarian" class="form-control pull-right" placeholder="Pencarian">

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Grup</th>
                                    <th class="text-right">Diskon</th>
                                    <th class="text-center">Jml Pelanggan</th>
                                    <th>Keterangan</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($pelanggan)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($pelanggan as $pelanggan) {
                                        $sql_jml = $this->db->where('id_pelanggan_grup', $pelanggan->id)->get('tbl_m_pelanggan_agt');
                                        ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $pelanggan->grup ?></td>
                                            <td class="text-right"><?php echo general::format_angka($pelanggan->potongan) ?></td>
                                            <td class="text-center"><?php echo $sql_jml->num_rows() ?></td>
                                            <td><?php echo $pelanggan->keterangan ?></td>
                                            <td>
                                                <?php echo anchor('page=produk&act=prod_plgngrp_list&id=' . general::enkrip($pelanggan->id), '<i class="fa fa-plus"></i> Tambah', 'class="text-primary"') ?>
                                                <?php echo nbs(2) ?>
                                                <?php echo anchor('page=produk&act=prod_plgngrp_hapus&id=' . general::enkrip($pelanggan->id), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $pelanggan->kategori . '] ? \')" class="text-danger"') ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (!empty($pagination)) { ?>
                        <div class="box-footer">                        
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <?php echo $pagination ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php if (isset($_GET['id'])) { ?>
            <?php echo form_open('page=produk&act=prod_plgngrp_simpan_agt') ?>
            <?php echo form_hidden('id', $this->input->get('id')) ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data Pelanggan</h3>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th class="text-center"><input type="checkbox" id="cekAll" name="cekAll"></th>
                                        <th class="text-center">No.</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Kota</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($pelanggan_agt)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($pelanggan_agt as $pelanggan_agt) {
                                            ?>
                                            <tr>
                                                <td class="text-center">
                                                    <input type="checkbox" name="ck[<?php echo $pelanggan_agt->id ?>]" value="<?php echo $this->input->get('id') ?>">
                                                </td>
                                                <td class="text-center"><?php echo $no++ ?></td>
                                                <td><?php echo $pelanggan_agt->nama ?></td>
                                                <td><?php echo $pelanggan_agt->lokasi ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer">                        
                            <ul class="pagination pagination-sm no-margin pull-left">
                                <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close() ?>
        <?php } ?>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<style>
    .clicked {
        background-color: #ffff00;
    }
</style>
<script src="<?php echo base_url('assets/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/sb-admin') ?>/ui/jquery-ui.min.css" rel="stylesheet">

<!-- Page script -->
<script>
    $(function () {
        // Jquery kanggo format angka
        $("#diskon").autoNumeric({aSep: '.', aDec: ',', aPad: false});
    });
</script>