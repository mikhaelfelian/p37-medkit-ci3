<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Karyawan <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Karyawan</li>
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
                            <?php echo form_open(base_url('master/set_cari_sales.php')) ?>
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
                        <button type="button" onclick="window.location.href = '<?php echo base_url('master/data_sales_tambah.php') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Tambah</button>
                        <?php echo (!empty($cetak) ? $cetak : '') ?>
                        <!--<button type="button" onclick="window.location.href = '<?php echo base_url('master/data_sales_import.php') ?>'" class="btn btn-warning btn-flat"><i class="fa fa-upload"></i> Import</button>-->
                        <!--<button type="button" onclick="window.location.href = '<?php echo base_url('master/data_sales_export.php') ?>'" class="btn btn-warning btn-flat"><i class="fa fa-download"></i> Unduh Template</button>-->
                        <?php echo br(2) ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>NIK</th>
                                    <th>
                                        <?php $so = $this->input->get('sort_order') ?>
                                        <?php echo anchor(base_url('master/'.$this->uri->segment(2).'?sort_type=nama&sort_order=' . ($so == 'asc' ? 'desc' : 'asc') . (!empty($jml) ? '&jml=' . $jml : '')), 'Nama ' . ($so == 'asc' ? '<i class="fa fa-sort-up"></i>' : ($so == 'desc' ? '<i class="fa fa-sort-down"></i>' : '<i class="fa fa-sort"></i>')), 'style="color: #000;"') ?>
                                    </th>
                                    <!--<th>No. Hp</th>-->
                                    <!--<th>Alamat</th>-->
                                    <!--<th>Tipe Member</th>-->
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($sales)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($sales as $sales) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <td><?php echo $sales->nik ?></td>
                                            <td><?php echo $sales->nama ?></td>
                                            <!--<td><?php echo $sales->no_hp ?></td>-->
                                            <!--<td><?php echo $sales->alamat ?></td>-->
                                            <!--<td><?php echo $sql_tipe->grup ?></td>-->
                                            <td>
                                                <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE || akses::hakAdmin() == TRUE){ ?>
                                                    <?php echo anchor(base_url('master/data_sales_tambah.php?id=' . general::enkrip($sales->id)), '<i class="fa fa-edit"></i> Ubah', 'class="label label-success"') ?>
                                                    <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE){ ?>
                                                    <?php echo nbs() ?>
                                                        <?php echo anchor(base_url('master/data_sales_hapus.php?id=' . general::enkrip($sales->id)), '<i class="fa fa-remove"></i> Hapus', 'onclick="return confirm(\'Hapus [' . $sales->nama . '] ? \')" class="label label-danger"') ?>
                                                    <?php } ?>
                                                <?php } ?>
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