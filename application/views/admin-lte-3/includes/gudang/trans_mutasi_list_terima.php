<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!--<h1 class="m-0">Master Data</h1>-->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('gudang/index.php') ?>">Gudang</a></li>
                        <li class="breadcrumb-item active">Data Mutasi</li>
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
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Data Permintaan (pend)</h3>
                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    <?php echo $pagination ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Tanggal</th>
                                        <th>User</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                    
                                    <?php echo form_open(base_url('gudang/set_cari_mutasi.php'), 'autocomplete="off"') ?>
                                    <?php echo form_hidden('route', 'data_mutasi_terima.php') ?>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control rounded-0', 'placeholder' => 'Isikan Tanggal ...', 'value' => (!empty($_GET['filter_nota']) ? $_GET['filter_nota'] : ''))) ?>
                                        </td>
                                        <td></td>
                                        <td colspan="2"></td>
                                        <td class="text-left">
                                            <button class="btn btn-primary btn-flat">
                                                <i class="fa fa-search-plus"></i> Filter
                                            </button>
                                        </td>
                                    </tr>
                                    <?php echo form_close() ?> 
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($sql_mut)) {
                                        $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                        foreach ($sql_mut as $mutasi) {
                                            $jml_mutasi = $this->db->select_sum('jml')->where('id_mutasi', $mutasi->id)->get('tbl_trans_mutasi_det')->row();
                                            $jml_terima = $this->db->select_sum('jml_diterima')->where('id_mutasi', $mutasi->id)->get('tbl_trans_mutasi_det')->row();
                                            $jml_kurang = $jml_mutasi->jml - $jml_terima->jml_diterima;
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td style="width: 150px;"><?php echo $this->tanggalan->tgl_indo($mutasi->tgl_simpan) ?></td>
                                                <td><?php echo anchor(base_url('gudang/trans_mutasi_det.php?id=' . general::enkrip($mutasi->id).'&route=gudang/data_mutasi_terima.php'), $this->ion_auth->user($mutasi->id_user)->row()->first_name, '') ?></td>
                                                <td><?php echo $mutasi->keterangan;  ?></td>
                                                <td>
                                                    <?php if (akses::hakFarmasi() == TRUE) { ?>
                                                        <span class="badge badge-success">Terkirim</span>
                                                    <?php } else { ?>
                                                        <?php echo general::tipe_mutasi($mutasi->tipe); ?>
                                                    <?php } ?>
                                                 </td>
                                                <td>
                                                    <?php if (akses::hakFarmasi() == FALSE) { ?>
                                                        <?php echo anchor(base_url('gudang/trans_mutasi_terima.php?id=' . general::enkrip($mutasi->id)), ($jml_kurang > 0 ? '<i class="fas fa-box-open"></i> Terima' : '<i class="fas fa-check-circle"></i> Cek &raquo;'), 'class="btn btn-'.($jml_kurang > 0 ? 'info' : 'primary').' btn-flat btn-xs" style="width: 65px;"') ?>
                                                    <?php  } ?>
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
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Page script -->
<script type="text/javascript">
    $(function () {        
        $("input[id=tgl]").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            autoclose: true
        });
    });
</script>