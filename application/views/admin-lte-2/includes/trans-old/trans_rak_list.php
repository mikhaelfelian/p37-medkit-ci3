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
                <div class="col-lg-4">
                    <?php echo form_open(base_url('cart/set_cari_lokasi.php'), '') ?>
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Form Laporan</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label class="control-label">No Nota</label>
                                <?php echo form_input(array('id' => 'no_nota', 'name' => 'no_nota', 'class' => 'form-control')) ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Lokasi Rak</label>
                                <br/>
                                <select id="lokasi" name="lokasi" class="form-control select2">
                                    <option value="">- [Pilih] -</option>
                                    <option value="semua">[SEMUA LOKASI]</option>
                                    <?php
                                    $lokasi = $this->db->get('tbl_m_lokasi')->result();
                                    if (!empty($lokasi)) {
                                        foreach ($lokasi as $lokasi) {
//                                      
                                            ?>
                                            <option value="<?php echo $lokasi->id ?>"><?php echo $lokasi->keterangan ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
							<!--
                            <div class="form-group">
                                <label class="control-label">Cabang</label>
                                <br/>
                                <select id="cabang" name="cabang" class="form-control select2">
                                    <option value="">- [Pilih] -</option>
                                    <option value="semua">[SEMUA CABANG]</option>
                                    <?php
                                    $cabang = $this->db->get('tbl_pengaturan_cabang')->result();
                                    if (!empty($cabang)) {
                                        foreach ($cabang as $cabang) {
//                                      
                                            ?>
                                            <option value="<?php echo $cabang->id ?>"><?php echo $cabang->keterangan ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
							-->
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info btn-flat pull-right"><i class="fa fa-search"></i> Cari</button>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <?php echo $this->session->flashdata('transaksi') ?>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <?php echo nbs(3) ?>
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>No. Invoice</th>
                                        <th>Tgl</th>
                                        <th>Kasir</th>
                                        <th>Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($sql_lokasi)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($sql_lokasi as $lok) {
                                            $tgl = explode('-', $lok->tgl_simpan);
                                            $sales = $this->ion_auth->user($lokasi->id_user)->row();
//                                        $gudang = $this->ion_auth->user($lokasi->id_gudang)->row();
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td><?php echo anchor(base_url('cart/trans_detail.php?id=' . general::enkrip($lok->id).'&route=trans_rak_list.php?no_nota='.$this->input->get('no_nota').'&lokasi='.$this->input->get('lokasi')), '#' . $lok->no_nota.'@'.$lok->cabang, 'class="text-default"') ?></td>
                                                <td><?php echo $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0] ?></td>
                                                <td><?php echo $sales->first_name ?></td>
                                                <td><?php echo $lok->keterangan ?></td>
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
        </section>
        <!-- /.content -->
    </div>
    <!-- /.container -->
</div>
<!--Datepicker-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/daterangepicker/daterangepicker-bs3.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/select2/select2.min.css') ?>">


<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins') ?>/JAutoNumber/autonumeric.js"></script>
<!-- Page script -->
<script>
    $(function () {
        $(".select2").select2();
    });

</script>