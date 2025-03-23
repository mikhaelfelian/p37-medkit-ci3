<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Mutasi <small>Gudang</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Mutasi</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <?php echo $this->session->flashdata('transaksi') ?>
                    </div>
                    <div class="box-body table-responsive">
                        <?php echo nbs(3) ?>
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE){ ?>
                                        <th>Petugas</th>
                                    <?php } ?>
                                    <th>No. Mutasi</th>
                                    <th>Gd. Asal</th>
                                    <th>Gd. Tujuan</th>
                                    <th>Tgl Transaksi</th>
                                    <th>Keterangan</th>
                                    <th colspan="2"></th>
                                </tr>
                            </thead>
                            <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdmin() == TRUE){ ?>
                            <?php echo form_open(base_url('gudang/set_cari_mutasi.php'), 'autocomplete="off"') ?>
                            <?php echo form_hidden('hal', $this->input->get('halaman')) ?>
                            <!--<input type="hidden" id="id_customer" name="id_customer">-->
                            <tbody>                                
                                <tr>
                                    <td></td>
                                    <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE){ ?>
                                        <td></td>
                                    <?php } ?>
                                    <td>
                                        <?php echo form_input(array('id' => 'no_nota', 'name' => 'no_nota', 'class' => 'form-control')) ?>
                                    </td>
                                    <td colspan="2"></td>
                                    <td><?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control')) ?></td>
                                    <td></td>
                                    <td>
                                        <button class="btn btn-primary btn-flat">Filter</button>
                                    </td>
                                </tr>
                            </tbody>
                            <?php echo form_close() ?>
                            <?php } ?>
                            <tbody>
                                <?php
                                if (!empty($penj)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($penj as $penj) {
                                        $sales = $this->db->where('id', $penj->id_sales)->get('tbl_m_sales')->row();
                                        $cust  = $this->db->where('id', $penj->id_pelanggan)->get('tbl_m_pelanggan')->row();
                                        $app   = $this->db->where('id', $penj->id_app)->get('tbl_pengaturan_cabang')->row();
                                        $gd_asl= $this->db->where('id', $penj->id_gd_asal)->get('tbl_m_gudang')->row();
                                        $gd_7an= $this->db->where('id', $penj->id_gd_tujuan)->get('tbl_m_gudang')->row();
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE){ ?>
                                                <td class="text-left"><?php echo $this->ion_auth->user($penj->id_user)->row()->first_name ?></td>
                                            <?php } ?>
                                            <td><?php echo anchor(base_url('gudang/trans_mutasi_det.php?id='.general::enkrip($penj->id)), $penj->kode_nota_dpn.$penj->no_nota.(!empty($penj->kode_nota_blk) ? '/'.$penj->kode_nota_blk : ''), 'class="text-default"') ?></td>
                                            <td><?php echo $gd_asl->gudang ?></td>
                                            <td><?php echo $gd_7an->gudang ?></td>
                                            <td><?php echo $this->tanggalan->tgl_indo($penj->tgl_masuk) ?></td>
                                            <td><?php echo $penj->keterangan ?></td>
                                            <td>
                                                <?php if(akses::hakSA() == TRUE OR akses::hakOwner() == TRUE){ ?>
                                                    <?php // echo anchor(base_url('gudang/trans_mutasi_'.($penj->status_nota == '4' ? 'draft' : 'edit').'.php?id='.general::enkrip($penj->id)), '<i class="fa fa-edit"></i> Ubah', 'class="label label-default"').nbs() ?>
                                                    <?php // echo anchor(base_url('gudang/trans_mutasi_hapus.php?id='.general::enkrip($penj->id)), '<i class="fa fa-remove"></i> Hapus', 'class="label label-danger" onclick="return confirm(\'Hapus ['.$penj->kode_nota_dpn.$penj->no_nota.(!empty($penj->kode_nota_blk) ? '/'.$penj->kode_nota_blk : '').'] ?\')"') ?>
                                                <?php } ?>
                                                <?php if(akses::hakKasir() == TRUE){ ?>
                                                    <?php // echo anchor(base_url('gudang/trans_mutasi_edit.php?id='.general::enkrip($penj->id)), '<i class="fa fa-edit"></i> Ubah', 'class="label label-default"') ?>
                                                    <?php if($penj->status_nota == '4'){ ?>
                                                        <?php // echo anchor(base_url('gudang/trans_mutasi_hapus.php?id='.general::enkrip($penj->id)), '<i class="fa fa-remove"></i> Hapus', 'class="label label-danger" onclick="return confirm(\'Hapus ['.$penj->kode_nota_dpn.$penj->no_nota.(!empty($penj->kode_nota_blk) ? '/'.$penj->kode_nota_blk : '').'] ?\')"') ?>
                                                    <?php } ?>
                                                <?php } ?>
                                                
                                                <a href="<?php echo base_url('gudang/cetak_nota.php?id='.general::enkrip($penj->id)) ?>" class="label label-primary"><i class="fa fa-print"></i> Cetak</a>
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

<!-- Page script -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/sb-admin') ?>/ui/jquery-ui.min.css" rel="stylesheet">

<!--Datepicker-->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-2/plugins/datepicker/datepicker3.css'); ?>">
<script>   
    $(function () {
//         Tanggale Nota
        $('#tgl').datepicker({
            autoclose: true,
        });
        $('#tgl_tempo').datepicker({
            autoclose: true,
        });

//        Autocomplete Nyari Cust
        $('#cari_cust').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('transaksi/json_customer.php') ?>",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 1,
            select: function (event, ui) {
                var $itemrow = $(this).closest('tr');
                // Populate the input fields from the returned values
                $itemrow.find('#cari_cust').val(ui.item.nama_toko);
                $('#cari_cust').val(ui.item.nama_toko);
                $('#customer').val(ui.item.id);

                // Give focus to the next input field to recieve input from user
                $('#cari_cust').focus();
                return false;
            }
            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.nama_toko + "</a>")
                    .appendTo(ul);
        };
        
        // Cari Sales
        $('#cari_sales').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('transaksi/json_sales.php') ?>",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 1,
            select: function (event, ui) {
                var $itemrow = $(this).closest('tr');
                // Populate the input fields from the returned values
                $itemrow.find('#cari_sales').val(ui.item.nama);
                $('#cari_sales').val(ui.item.nama);
                $('#sales').val(ui.item.id);

                // Give focus to the next input field to recieve input from user
                $('#cari_sales').focus();
                return false;
            }
            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.nama + "</a>")
                    .appendTo(ul);
        };
    });
</script>