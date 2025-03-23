<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Supplier <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Supplier</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                        <div class="box-tools">
                            <?php echo form_open(base_url('master/set_cari_supplier.php'), 'autocomplete="off"') ?>
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" name="pencarian" class="form-control pull-right" placeholder="Pencarian">

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <div class="box-body">
                        <button type="button" onclick="window.location.href = '<?php echo base_url('master/data_supplier_tambah.php') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Tambah</button>
                        <?php echo (!empty($cetak) ? $cetak : '') ?>
                        <!--<button type="button" onclick="window.location.href = '<?php echo base_url('master/data_supplier_import.php') ?>'" class="btn btn-warning btn-flat"><i class="fa fa-upload"></i> Import</button>-->
                        <!--<button type="button" onclick="window.location.href = '<?php echo base_url('master/data_supplier_export.php') ?>'" class="btn btn-warning btn-flat"><i class="fa fa-download"></i> Unduh Template</button>-->
                        <?php echo br(2) ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Kode</th>
                                    <th>
                                        <?php $so = $this->input->get('sort_order') ?>
                                        <?php echo anchor(base_url('master/'.$this->uri->segment(2).'?sort_type=nama&sort_order=' . ($so == 'asc' ? 'desc' : 'asc') . (!empty($jml) ? '&jml=' . $jml : '')), 'Nama ' . ($so == 'asc' ? '<i class="fa fa-sort-up"></i>' : ($so == 'desc' ? '<i class="fa fa-sort-down"></i>' : '<i class="fa fa-sort"></i>')), 'style="color: #000;"') ?>
                                    </th>
                                    <th>NPWP</th>
                                    <th>No. Tlp</th>
                                    <th>No. Hp</th>
                                    <th>Alamat</th>
                                    <th>CP</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($supplier)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($supplier as $supplier) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <td><?php echo $supplier->kode ?></td>
                                            <td><?php echo $supplier->nama ?></td>
                                            <td><?php echo $supplier->npwp ?></td>
                                            <td><?php echo $supplier->no_tlp ?></td>
                                            <td><?php echo $supplier->no_hp ?></td>
                                            <td><?php echo $supplier->alamat ?></td>
                                            <td><?php echo $supplier->cp ?></td>
                                            <td>
                                                <?php echo anchor(base_url('master/data_supplier_tambah.php?id=' . general::enkrip($supplier->id)), '<i class="fa fa-edit"></i> Ubah', 'class="label label-success"') ?>
                                                <?php echo nbs() ?>
                                                <?php echo anchor(base_url('master/data_supplier_hapus.php?id=' . general::enkrip($supplier->id)), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $supplier->nama . '] ? \')" class="label label-danger"') ?>
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
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<style>
    .clicked {
        background-color: #ffff00;
    }
</style>