<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Riwayat Pembayaran <small>Pembelian</small></h1>
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
                                    <th style="width: 250px;">Kode Bayar</th>
                                    <th style="width: 150px;">Tgl Pembayaran</th>
                                    <th style="width: 150px;">Metode</th>
                                    <th style="width: 300px;">Keterangan</th>
                                    <th style="width: 150px; text-align: right">Nominal</th>
                                    <th style="width: 350px;">Supplier</th>
                                    <th colspan="2">#</th>
                                </tr>
                            </thead>
                            <form method="GET">
                            <?php // echo form_open(base_url('transaksi/set_cari_pemb_plat.php'), 'autocomplete="off"') ?>
                            <?php echo form_hidden('hal', $this->input->get('halaman')) ?>
                            <tbody>                                
                                <tr>
                                    <td></td>
                                    <td>
                                        <?php echo form_input(array('id' => 'no_nota', 'name' => 'filter_nota', 'class' => 'form-control')) ?>
                                    </td>
                                    <td><?php echo form_input(array('id' => 'tgl', 'name' => 'filter_tgl', 'class' => 'form-control')) ?></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <?php // echo form_input(array('id' => 'cari_cust', 'name' => 'nama_cust', 'class' => 'form-control')) ?>
                                        <!--<input type="hidden" id="customer" name="customer">-->
                                    </td>
                                    <td></td>
                                    <td colspan="3">
                                        <button class="btn btn-primary">Filter</button>
                                    </td>
                                </tr>
                            </tbody>
                            <?php echo form_close() ?>
                            <tbody>
                                <?php
                                if (!empty($penj)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($penj as $penj) {
                                        $tgl     = $this->tanggalan->tgl_indo($penj->tgl_masuk);
                                        $sql_mtd = $this->db->where('id', $penj->metode)->get('tbl_m_platform')->row();
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no ?>.</td>
                                            <td><?php echo anchor(base_url('transaksi/data_hist_beli_det.php?id='.general::enkrip($penj->id)), sprintf('%05d', $penj->id)); ?></td>
                                            <td><?php echo $tgl ?></td>
                                            <td><?php echo $sql_mtd->platform ?></td>
                                            <td><?php echo $penj->keterangan ?></td>
                                            <td class="text-right"><?php echo general::format_angka($penj->nominal) ?></td>
                                            <td><?php echo $penj->pelanggan ?></td>
                                            <td></td>
                                            <td>
                                                <a class="label <?php echo ($sql_penj->cetak == '1' ? 'label-danger' : 'label-primary') ?> btn-flat" href = "<?php echo base_url('transaksi/cetak_rekap_beli2.php?id=' . general::enkrip($penj->id)) ?>"><i class="fa fa-print"></i> Rekap Byr</a>
                                            </td>
                                        </tr>
                                        <?php
                                        $no++;
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
    });
</script>