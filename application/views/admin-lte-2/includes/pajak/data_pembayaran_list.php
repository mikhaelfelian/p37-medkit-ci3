<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Pembayaran <small>Penjualan</small></h1>
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
                                    <th>Tgl Transaksi</th>
                                    <th>Tgl Jatuh Tempo</th>
                                    <th>Pelanggan</th>
                                    <th>Nominal</th>
                                    <th colspan="2">#</th>
                                </tr>
                            </thead>
                            <?php echo form_open(base_url('pajak/set_cari_penj_bayar.php')) ?>
                            <?php echo form_hidden('hal', $this->input->get('halaman')) ?>
                            <tbody>                                
                                <tr>
                                    <td></td>
                                    <td>
                                        <?php echo form_input(array('id' => 'no_nota', 'name' => 'no_nota', 'class' => 'form-control')) ?>
                                    </td>
                                    <td><?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control')) ?></td>
                                    <td><?php echo form_input(array('id' => 'tgl_tempo', 'name' => 'tgl_tempo', 'class' => 'form-control')) ?></td>
                                    <td>
                                        <?php echo form_input(array('id' => 'cari_cust', 'name' => 'nama_cust', 'class' => 'form-control')) ?>
                                        <input type="hidden" id="customer" name="customer">
                                    </td>
                                    <td></td>
                                    <td colspan="3">
                                        <button class="btn btn-primary">Filter</button>
                                        <?php echo (!empty($cetak) ? $cetak : '') ?>
                                    </td>
                                </tr>
                            </tbody>
                            <?php echo form_close() ?>
                            <tbody>
                                <?php
                                if (!empty($penj)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($penj as $penj) {
                                        $tgl   = explode('-', $penj->tgl_masuk);
                                        $tgl_t = explode('-', $penj->tgl_keluar);
                                        $sales = $this->ion_auth->user($penj->id_user)->row();
                                        $cust  = $this->db->where('id', $penj->id_pelanggan)->get('tbl_m_pelanggan')->row();
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <td><?php echo anchor(base_url('transaksi/trans_jual_det.php?id='.general::enkrip($penj->id).'&route='.$this->uri->segment(2)), $penj->kode_nota_dpn.$penj->no_nota.'/'.$penj->kode_nota_blk, 'class="text-default"') ?></td>
                                            <td><?php echo $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0] ?></td>
                                            <td><?php echo $tgl_t[1] . '/' . $tgl_t[2] . '/' . $tgl_t[0] ?></td>
                                            <td><?php echo $cust->nama_toko ?></td>
                                            <td class="text-right"><?php echo ($penj->jml_kurang == 0 ? general::format_angka($penj->jml_gtotal) : general::format_angka($penj->jml_kurang)) ?></td>
                                            <td>
                                                <?php if($penj->status_bayar == '1'){ ?>
                                                    <?php echo general::status_bayar($penj->status_bayar) ?>
                                                <?php }else{ ?>
                                                    <?php echo anchor(base_url('transaksi/trans_bayar_jual.php?id='.general::enkrip($penj->id)), '<label class="label '.($penj->status_bayar == '2' ? 'label-primary' : 'label-warning').'" style="cursor: pointer;">'.($penj->status_bayar == '2' ? 'Kurang Bayar' : 'Bayar').' &raquo;</label>', 'class="text-default"') ?>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php // echo anchor(base_url('cart/cetak_nota.php?id=' . general::enkrip($penj->id)), '<i class="fa fa-print"></i> '.($penj->cetak == '1' ? 'Cetak Ulang' : 'Cetak'), 'class="label '.($penj->cetak == '1' ? 'label-danger' : 'label-warning').'"') ?>
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