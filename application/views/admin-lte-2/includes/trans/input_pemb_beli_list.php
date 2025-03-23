<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Pembayaran <small>Pembelian</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Pembayaran Multiple</li>
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
                                    <th>No. Invoice</th>
                                    <!--<th>Lokasi</th>-->
                                    <th>Tgl Transaksi</th>
                                    <th>Tgl Bayar</th>
                                    <th>Supplier</th>
                                    <th>Petugas</th>
                                    <th class="text-right">Nominal</th>
                                    <th colspan="2"></th>
                                </tr>
                            </thead>
                            <?php // if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdmin() == TRUE){ ?>
                            <form method="GET">
                            <?php // echo form_open(base_url('transaksi/set_cari_penj.php'), 'autocomplete="off"') ?>
                            <?php echo form_hidden('id', $this->input->get('id')) ?>
                            <?php echo form_hidden('hal', $this->input->get('halaman')) ?>
                            <tbody>                                
                                <tr>
                                    <td></td>
                                    <td>
                                        <?php echo form_input(array('id' => 'cari_nota', 'name' => 'filter_nota', 'class' => 'form-control')) ?>
                                        <!--<input type="hidden" id="nota" name="nota">-->
                                    </td>
                                    <!--<td><?php // echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control')) ?></td>-->
                                    <td>
                                        <?php echo form_input(array('id' => 'tgl', 'name' => 'filter_tgl', 'class' => 'form-control')) ?>
                                    </td>
                                    <td>
                                        <?php // echo form_input(array('id' => 'tgl_tempo', 'name' => 'tgl_bayar', 'class' => 'form-control')) ?>
                                    </td>
                                    <td>
                                        <?php // echo form_input(array('id' => 'cari_cust', 'name' => 'nama_cust', 'class' => 'form-control')) ?>
                                        <!--<input type="hidden" id="customer" name="customer">-->
                                    </td>
                                    <td>
                                        <?php // if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdmin() == TRUE){ ?>
                                            <?php // echo form_input(array('id' => 'cari_sales', 'name' => 'nama_sales', 'class' => 'form-control')) ?>
                                            <!--<input type="hidden" id="sales" name="sales">-->
                                        <?php // }else{ ?>
                                            <?php // echo form_hidden('sales', $sales->id); ?>
                                        <?php // } ?>
                                    </td>
                                    <td></td>
                                    <td>
                                        <button class="btn btn-primary btn-flat"><i class="fa fa-search"></i> Filter</button>
                                        <?php // echo (!empty($cetak) ? $cetak : '') ?>
                                    </td>
                                </tr>
                            </tbody>
                            <?php echo form_close() ?>
                            <?php // } ?>
                            <tbody>
                                <?php
                                if (!empty($penj)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($penj as $penj) {
                                        $sales = $this->db->where('id', $penj->id_user)->get('tbl_ion_users')->row();
                                        $cust  = $this->db->where('id', $penj->id_supplier)->get('tbl_m_supplier')->row();
                                        $app   = $this->db->where('id', $penj->id_app)->get('tbl_pengaturan_cabang')->row();
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <td><?php echo anchor(base_url('transaksi/trans_beli_det.php?id='.general::enkrip($penj->id).'&route=transaksi/input_pemb_beli_list.php?id='.general::enkrip($penj->id)), $penj->kode_nota_dpn.$penj->no_nota.(!empty($penj->kode_nota_blk) ? '/'.$penj->kode_nota_blk : ''), 'class="text-default"') ?></td>
                                            <!--<td><?php echo (!empty($penj->id_app) ? $app->keterangan : '') ?></td>-->
                                            <td><?php echo $this->tanggalan->tgl_indo($penj->tgl_masuk) ?></td>
                                            <td><?php echo $this->tanggalan->tgl_indo($penj->tgl_bayar) ?></td>
                                            <td><?php echo $cust->nama ?></td>
                                            <td><?php echo $sales->first_name ?></td>
                                            <td class="text-right"><?php echo general::format_angka(($penj->jml_bayar > 0 ? $penj->jml_kurang : $penj->jml_gtotal)) ?></td>
                                            <td>
                                                <?php echo anchor(base_url('transaksi/input_pemb_beli.php?id='.general::enkrip($sess_beli['id']).'&no_nota='.general::enkrip($penj->id)), '<i class="fa fa-arrow-right"></i> Bayar', 'class="label label-success"').nbs() ?>
                                                <?php echo ($penj->status_bayar == '1' ? general::status_bayar($penj->status_bayar) : '') ?>
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

//        Autocomplete Nyari Nota
        $('#cari_nota').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('transaksi/json_nota.php') ?>",
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
                $itemrow.find('#cari_nota').val(ui.item.no_nota);
                $('#cari_nota').val(ui.item.no_nota);
                $('#nota').val(ui.item.id);

                // Give focus to the next input field to recieve input from user
                $('#cari_nota').focus();
                return false;
            }
            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.no_nota + "</a>")
                    .appendTo(ul);
        };

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
        
    <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdmin() == TRUE){ ?>    
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
    <?php } ?>
    });
</script>