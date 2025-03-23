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
                            <h3 class="card-title">Data Mutasi</h3>
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
                                        <th class="text-center">Tgl Mutasi</th>
                                        <th>User</th>
                                        <th>Keterangan</th>
                                        <th>Tipe</th>
                                        <th></th>
                                    </tr>
                                    
                                    <?php echo form_open_multipart(base_url('gudang/set_cari_mutasi.php'), 'autocomplete="off"') ?> 
                                    <tr>
                                        <td></td>
                                        <td>
                                            <?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control rounded-0', 'placeholder' => 'Isikan Tanggal ...', 'value' => (!empty($_GET['filter_nota']) ? $_GET['filter_nota'] : ''))) ?>
                                        </td>
                                        <td>
                                            <?php // echo form_input(array('id' => 'supplier', 'name' => 'supplier', 'class' => 'form-control rounded-0', 'placeholder' => 'Isikan Supplier ...', 'value' => (!empty($_GET['filter_supplier']) ? $_GET['filter_supplier'] : ''))) ?>
                                        </td>
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
//                                            $sql_tipe = $this->db->where('id', $mutasi->id_grup)->get('tbl_m_pelanggan_grup')->row();
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++ ?>.</td>
                                                <td style="width: 150px;"><?php echo $this->tanggalan->tgl_indo($mutasi->tgl_simpan) ?></td>
                                                <td><?php echo anchor(base_url('gudang/trans_mutasi_det.php?id=' . general::enkrip($mutasi->id)), $this->ion_auth->user($mutasi->id_user)->row()->first_name, '') ?></td>
                                                <td><?php echo $mutasi->keterangan; // echo (!empty($mutasi->dl_file) ? anchor(base_url('gudang/data_opname_dl.php?id='.general::enkrip($mutasi->id).'&file='.$mutasi->nm_file), $mutasi->nm_file) : $mutasi->nm_file)  ?></td>
                                                <td><?php echo general::tipe_mutasi($mutasi->tipe); ?></td>
                                                <td>
                                                    <?php if($mutasi->status_nota == '0'){ ?>
                                                        <?php echo anchor(base_url('gudang/trans_mutasi_edit.php?id=' . general::enkrip($mutasi->id)), '<i class="fas fa-edit"></i> Ubah &raquo;', 'class="btn btn-'.($jml_kurang > 0 ? 'info' : 'primary').' btn-flat btn-xs" style="width: 65px;"') ?>
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