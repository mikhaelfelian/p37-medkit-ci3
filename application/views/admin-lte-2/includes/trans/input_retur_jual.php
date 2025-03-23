<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Input Retur <small>Penjualan</small></h1>
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
                                    <!--<th>Tgl Jatuh Tempo</th>-->
                                    <th>Pelanggan</th>
                                    <!--<th>Kasir</th>-->
                                    <th>Nominal</th>
<!--                                    <th>Stat Pemb</th>
                                    <th>Stat Nota</th>-->
                                    <th colspan="2">#</th>
                                </tr>
                            </thead>
                            <?php echo form_open('page=transaksi&act=set_cari_penj_retur_input') ?>
                            <?php echo form_hidden('hal', $this->input->get('halaman')) ?>
                            <!--<input type="hidden" id="id_sales" name="id_sales">-->
                            <tbody>                                
                                <tr>
                                    <td></td>
                                    <td>
                                        <?php echo form_input(array('id' => 'no_nota', 'name' => 'no_nota', 'class' => 'form-control')) ?>
                                    </td>
                                    <td><?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control')) ?></td>
                                    <!--<td><?php echo form_input(array('id' => 'tgl_tempo', 'name' => 'tgl_tempo', 'class' => 'form-control')) ?></td>-->
                                    <td>
                                        <?php // echo form_input(array('id' => 'cari_cust', 'name' => 'nama_kasir', 'class' => 'form-control')) ?>
                                        <!--<input type="hidden" id="kasir" name="kasir">-->
                                    </td>
<!--                                    <td>
                                        <?php echo form_input(array('id' => 'cari_kasir', 'name' => 'nama_kasir', 'class' => 'form-control')) ?>
                                        <input type="hidden" id="kasir" name="kasir">
                                    </td>-->
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
                                    <td><button class="btn btn-primary">Filter</button></td>
                                </tr>
                            </tbody>
                            <?php echo form_close() ?>
                            <tbody>
                                <?php
                                if (!empty($penj)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($penj as $penj) {
                                        $tgl       = explode('-', $penj->tgl_masuk);
                                        $tgl_t     = explode('-', $penj->tgl_keluar);
                                        $sales     = $this->ion_auth->user($penj->id_user)->row();
                                        $cust      = $this->db->where('id', $penj->id_pelanggan)->get('tbl_m_pelanggan')->row();
                                        $sql_penj  = $this->db->where('no_nota', $penj->no_nota)->get('tbl_trans_jual')->row();
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <td><?php echo anchor(base_url('transaksi/trans_jual_det.php?id='.general::enkrip($penj->id).'&act=bayar&route=transaksi/'.$this->uri->segment(2)), $sql_penj->kode_nota_dpn.$sql_penj->no_nota.'/'.$sql_penj->kode_nota_blk, 'class="text-default"') ?></td>
                                            <td><?php echo $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0] ?></td>
                                            <!--<td><?php echo $tgl_t[1] . '/' . $tgl_t[2] . '/' . $tgl_t[0] ?></td>-->
                                            <td><?php echo $cust->nama ?></td>
                                            <!--<td><?php echo $sales->first_name ?></td>-->
                                            <!--<td><?php echo general::status_bayar($penj->status_bayar) ?></td>-->
                                            <td class="text-right"><?php echo general::format_angka($penj->jml_gtotal) ?></td>
                                            <td>
                                                <?php // if($penj->status_retur == '1'){ ?>
                                                    <!--<label class="label label-default"><i class="fa fa-arrow-right"></i> Retur</label>-->
                                                <?php // }else{ ?>
                                                    <?php echo anchor(base_url('transaksi/trans_retur_jual.php?no_nota='.general::enkrip($penj->id).'&route='.$this->uri->segment(2)), '<i class="fa fa-arrow-right"></i> Retur', 'class="label '.($penj->cetak == '1' ? 'label-danger' : 'label-warning').'"') ?>
                                                <?php // } ?>
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

//        Autocomplete Nyari Kasir
        $('#cari_kasir').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo site_url('page=transaksi&act=json_kasir') ?>",
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
                $itemrow.find('#cari_kasir').val(ui.item.nama);
                $('#cari_kasir').val(ui.item.nama);
                $('#kasir').val(ui.item.id);

                // Give focus to the next input field to recieve input from user
                $('#cari_kasir').focus();
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