<div class="content-wrapper">
    <div class="container">        
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Data Lokasi
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
                <li class="active">Data Lokasi</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-5">
                    <?php echo form_open(base_url('cart/set_lokasi_rak.php')) ?>
                    <?php echo form_hidden('id', general::enkrip($lokasi->id)) ?>
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Form Set Lokasi</h3>
                        </div>
                        <div class="box-body">
                            <?php echo $this->session->flashdata('produk') ?>
                            <div class="form-group <?php echo (!empty($hasError['lokasi']) ? 'has-error' : '') ?>">
                                <label class="control-label">Kode Lokasi</label>
                                <?php echo form_input(array('name' => 'kode_lokasi', 'class' => 'form-control', 'value' => $lokasi->kode, 'readonly' => 'TRUE')) ?>
                            </div>
                            <div class="form-group <?php echo (!empty($hasError['lokasi']) ? 'has-error' : '') ?>">
                                <label class="control-label">Lokasi</label>
                                <?php echo form_input(array('name' => 'lokasi', 'class' => 'form-control', 'value' => $lokasi->keterangan, 'readonly' => 'TRUE')) ?>
                            </div>
                            <div class="form-group <?php echo (!empty($hasError['no_nota']) ? 'has-error' : '') ?>">
                                <label class="control-label">No. Nota</label>                                
                                <select id="pelanggan" name="no_nota" class="form-control select2" style="border-radius: 0px;">
                                    <option value="">- [Pilih] -</option>
                                    <?php
                                    $penj = $this->db->get('tbl_trans_jual')->result();
                                    if (!empty($penj)) {
                                        foreach ($penj as $penj) {
                                            $sql_plgn = $this->db->where('id', $penj->id_pelanggan)->get('tbl_m_pelanggan')->row();
                                            ?>
                                            <option value="<?php echo $penj->no_nota ?>" <?php // echo ($penj->id == '1' ? 'selected' : '')  ?>><?php echo '[' . $penj->no_nota . '] ' . $sql_plgn->nama ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group <?php echo (!empty($hasError['keterangan']) ? 'has-error' : '') ?>">
                                <label class="control-label">Keterangan</label>
                                <?php echo form_input(array('name' => 'keterangan', 'class' => 'form-control')) ?>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" onclick="window.location.href = '<?php echo base_url('cart/trans_rak_list.php') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <button type="reset" class="btn btn-default btn-flat">Batal</button>
                                    <button type="submit" class="btn btn-info btn-flat">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data Lokasi</h3>
                        </div>
                        <div class="box-body">

                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>No. Nota</th>
                                        <th>Lokasi</th>
                                        <th>Keterangan</th>
                                        <th>Tipe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
//                                    echo $lokasi_det->num_rows();
                                    if (!empty($lokasi_det)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($lokasi_det->result() as $lokasi_det) {
                                            $sql_lokasi = $this->db->where('id', $lokasi_det->id_lokasi)->get('tbl_m_lokasi')->row()
//                                        $tot_jml = $this->db->select('SUM(stok) as jml')->where('id_produk', $produk->id)->get('tbl_m_produk_stok')->row();
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td><?php echo $lokasi_det->no_nota ?></td>
                                                <td><?php echo $sql_lokasi->keterangan ?></td>
                                                <td><?php echo $lokasi_det->keterangan ?></td>
                                                <td><?php echo general::tipe_rak($sql_lokasi->tipe) ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <!--<button type="button" onclick="window.location.href = '<?php echo site_url('page=produk&act=prod_barang_list') ?>'" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</button>-->
                                </div>
                                <div class="col-lg-6 text-right">
                                    <!--<button type="reset" class="btn btn-default btn-flat">Batal</button>-->
                                    <!--<button type="submit" class="btn btn-info btn-flat">Simpan</button>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.container -->
</div>

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
                                            // Platform
                                            $(".select2").select2();
                                        });
</script>