<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Gudang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('gudang/index.php') ?>">Gudang</a></li>
                        <li class="breadcrumb-item active">Stok Opname Detail</li>
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
                <div class="col-md-5">                  
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Stok Opname Detail</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <div class="form-group">
                                <label class="control-label">User</label>
                                <?php echo form_input(array('id' => 'customer', 'name' => 'customer', 'class' => 'form-control text-middle rounded-0', 'style' => 'vertical-align: middle;', 'value' => $this->ion_auth->user($barang->id_user)->row()->first_name, 'readonly' => 'TRUE')) ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Tanggal</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                    <?php echo form_input(array('id' => '', 'name' => 'tgl_masuk', 'class' => 'form-control text-middle rounded-0', 'style' => 'vertical-align: middle;', 'value' => $barang->tgl_simpan, 'readonly' => 'TRUE')) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3">Gudang</label>
                                <select name="gudang" class="form-control rounded-0" disabled="True">
                                    <option value="">- Pilih -</option>
                                    <?php foreach ($sql_gudang as $gd) { ?>
                                        <option value="<?php echo $gd->id ?>" <?php echo ($barang->id_gudang == $gd->id ? 'selected' : '') ?>><?php echo $gd->gudang . ($gd->status == '1' ? ' [Utama]' : ''); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Keterangan</label>
                                <?php echo form_input(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control text-middle rounded-0', 'value' => $barang->keterangan, 'readonly' => 'TRUE')) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">                  
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Data Item Stok Opname</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-left">Tanggal SO</th>
                                        <th class="text-left">Kode</th>
                                        <th class="text-left">Produk</th>
                                        <th class="text-center">SO</th>
                                        <th class="text-center">Sistem</th>
                                        <th class="text-center">Selisih</th>
                                        <!--<th class="text-left">Merk</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($barang_log)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        $jml_total = 0;
                                        foreach ($barang_log as $barang) {
                                            $jml_total = $jml_total + $barang->jml;
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no ?>.</td>
                                                <td class="text-left"><?php echo $this->tanggalan->tgl_indo($barang->tgl_masuk) ?></td>
                                                <!--<td class="text-left"><?php echo $barang->kode ?></td>-->
                                                <td class="text-left"><?php echo anchor(base_url('gudang/data_stok_tambah.php?id=' . general::enkrip($barang->id_produk)), $barang->kode, 'target="_blank"') ?></td>
                                                <td class="text-left"><?php echo $barang->produk ?></td>
                                                <td class="text-center"><?php echo (float) $barang->jml ?></td>
                                                <td class="text-center"><?php echo (float) $barang->jml_sys ?></td>
                                                <td class="text-center"><?php echo (float) $barang->jml_sls ?></td>
                                                <!--<td class="text-left"><?php echo $barang->merk ?></td>-->
                                            </tr>
                                            <?php
                                            $no++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <hr/>
                            <table class="table table-stripped">
                                <tr>
                                    <th class="text-left" style="width: 250px;">Total Stok Opname</th>
                                    <th class="text-center" style="width: 10px;">:</th>
                                    <td class="text-left"><?php echo (float) $jml_total ?></td>
                                </tr>                            
                                <tr>
                                    <th class="text-left" style="width: 250px;">Total Item</th>
                                    <th class="text-center" style="width: 10px;">:</th>
                                    <td class="text-left"><?php echo (float) ($no - 1) ?></td>
                                </tr>                            
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('gudang/data_opname_list.php') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">

                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">