<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Transaksi <small>Penjualan</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Transaksi</li>
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
                    <div class="box-body table-responsive no-padding">
                        <?php echo nbs(3) ?>
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>No. Invoice</th>
                                    <th>Lokasi</th>
                                    <th>Tgl Transaksi</th>
                                    <th>Tgl Jatuh Tempo</th>
                                    <th>Pelanggan</th>
                                    <th>Sales</th>
                                    <th>Nominal</th>
<!--                                    <th>Stat Pemb</th>
                                    <th>Stat Nota</th>-->
                                    <th colspan="3">#</th>
                                </tr>
                            </thead>
                            <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE){ ?>
                            <?php echo form_open(base_url('transaksi/set_cari_penj.php')) ?>
                            <?php echo form_hidden('hal', $this->input->get('halaman')) ?>
                            <!--<input type="hidden" id="id_customer" name="id_customer">-->
                            <tbody>                                
                                <tr>
                                    <td></td>
                                    <td>
                                        <?php echo form_input(array('id' => 'no_nota', 'name' => 'no_nota', 'class' => 'form-control')) ?>
                                    </td>
                                    <td><?php // echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control')) ?></td>
                                    <td><?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control')) ?></td>
                                    <td><?php echo form_input(array('id' => 'tgl_tempo', 'name' => 'tgl_tempo', 'class' => 'form-control')) ?></td>
                                    <td>
                                        <?php echo form_input(array('id' => 'cari_cust', 'name' => 'nama_cust', 'class' => 'form-control')) ?>
                                        <input type="hidden" id="customer" name="customer">
                                    </td>
                                    <td>
                                        <?php echo form_input(array('id' => 'cari_sales', 'name' => 'nama_sales', 'class' => 'form-control')) ?>
                                        <input type="hidden" id="sales" name="sales">
                                    </td>
<!--                                    <td>
                                        <?php // if (akses::hakKasir() != TRUE) { ?>
                                        <select name="status_bayar" class="form-control">
                                            <option value="-">- [Status Bayar] -</option>
                                            <option value="0">Belum</option>
                                            <option value="1">Lunas</option>
                                        </select>
                                        <?php // } ?>
                                    </td>-->
                                    <td></td>
                                    <td colspan="3">
                                        <button class="btn btn-primary">Filter</button>
                                        <?php echo (!empty($cetak) ? $cetak : '') ?>
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
                                        $tgl   = explode('-', $penj->tgl_masuk);
                                        $tgl_t = explode('-', $penj->tgl_keluar);
                                        $sales = $this->db->where('id', $penj->id_sales)->get('tbl_m_sales')->row();
                                        $cust  = $this->db->where('id', $penj->id_pelanggan)->get('tbl_m_pelanggan')->row();
                                        $app   = $this->db->where('id', $penj->id_app)->get('tbl_pengaturan_cabang')->row();
                                        
                                        if($_GET['route'] == 'tempo'){
                                            if($penj->tgl_masuk != $penj->tgl_keluar){
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <td><?php echo anchor(base_url('transaksi/trans_jual_det.php?id='.general::enkrip($penj->id)), $penj->kode_nota_dpn.$penj->no_nota.(!empty($penj->kode_nota_blk) ? '/'.$penj->kode_nota_blk : ''), 'class="text-default"') ?></td>
                                            <td><?php echo (!empty($penj->id_app) ? $app->keterangan : '') ?></td>
                                            <td><?php echo $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0] ?></td>
                                            <td><?php echo $tgl_t[1] . '/' . $tgl_t[2] . '/' . $tgl_t[0] ?></td>
                                            <td><?php echo $cust->nama_toko ?></td>
                                            <td><?php echo $sales->nama ?></td>
                                            <!--<td><?php echo general::status_bayar($penj->status_bayar) ?></td>-->
                                            <td class="text-right"><?php echo general::format_angka($penj->jml_gtotal) ?></td>
                                            <td>
                                                <?php if(akses::hakSA() == TRUE){ ?>
                                                    <?php echo anchor(base_url('transaksi/trans_jual_edit.php?id='.general::enkrip($penj->id)), '<i class="fa fa-edit"></i> Ubah', 'class="label label-default"').nbs() ?>
                                                    <?php echo anchor(base_url('transaksi/trans_jual_hapus.php?id='.general::enkrip($penj->id)), '<i class="fa fa-remove"></i> Hapus', 'class="label label-danger" onclick="return confirm(\'Hapus ['.$penj->kode_nota_dpn.$penj->no_nota.(!empty($penj->kode_nota_blk) ? '/'.$penj->kode_nota_blk : '').'] ?\')"') ?>
                                                <?php } ?>
                                                <?php if(akses::hakOwner() == TRUE){ ?>
                                                    <?php if($penj->status_nota != 3 AND $penj->status_bayar != 2){ ?>
                                                        <?php echo anchor(base_url('transaksi/trans_jual_edit.php?id='.general::enkrip($penj->id)), '<i class="fa fa-edit"></i> Ubah', 'class="label label-default"') ?>
                                                    <?php } ?>
                                                <?php } ?>
                                                <a href="<?php echo base_url('transaksi/cetak_nota.php?id='.general::enkrip($penj->id)) ?>" class="label label-warning"><i class="fa fa-print"></i> Cetak</a>
                                                <?php echo general::status_nota($penj->status_nota) ?>
                                            </td>
<!--                                            <td>
                                                <?php echo general::status_nota($penj->status_nota) ?>
                                            </td>
                                            <td>
                                                <?php if($penj->status_grosir == 1){ ?>
                                                    <a href="<?php echo base_url('transaksi/cetak_nota.php?id='.general::enkrip($penj->id)) ?>" class="label label-warning"><i class="fa fa-print"></i> Cetak</a>
                                                <?php } ?>
                                            </td>-->
                                        </tr>
                                        <?php
                                            }
                                        }
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