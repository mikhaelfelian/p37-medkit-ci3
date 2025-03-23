<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Jurnal Transaksi <small>Penjualan</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Jurnal Penjualan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-lg-6">
                <?php $hasError = $this->session->flashdata('form_error'); ?>
                <?php echo form_open(base_url('akuntability/set_jur_jual_cari.php'), '') ?>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Pencarian</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group <?php echo (!empty($hasError['akun_deb']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Akun Debet</label>                                    
                                    <select name="akun_deb" class="form-control">
                                        <option value="">[Pilih]</option>
                                        <?php foreach ($akun as $akun) { ?>
                                            <?php if ($akun->id_akun_grup != 4 && $akun->id_akun_grup != 5) { ?>
                                                <option value="<?php echo $akun->id ?>"><?php echo $akun->nama ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group <?php echo (!empty($hasError['akun_krd']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Akun Kredit</label>                                    
                                    <select name="akun_krd" class="form-control">
                                        <option value="">[Pilih]</option>
                                        <?php foreach ($akun2 as $akun2) { ?>
                                            <?php if ($akun2->id_akun_grup == 4) { ?>
                                                <option value="<?php echo $akun2->id ?>"><?php echo $akun2->nama ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group <?php echo (!empty($hasError['bulan']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Bulan</label>                                    
                                    <select name="bulan" class="form-control">
                                        <option value="">[Pilih]</option>
                                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                                            <option value="<?php echo $i ?>"><?php echo $this->tanggalan->bulan_ke($i) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">                                
                                <div class="form-group <?php echo (!empty($hasError['tahun']) ? 'has-error' : '') ?>">
                                    <label class="control-label">Tahun</label>
                                    <?php echo form_input(array('id' => 'tahun', 'name' => 'tahun', 'class' => 'form-control pull-right', 'value' => date('Y'))) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info btn-flat pull-right"><i class="fa fa-search"></i> Cari</button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
        <?php if(isset($_GET['jml'])){ ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <?php echo $this->session->flashdata('transaksi') ?>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <?php echo nbs(3) ?>
                            <table class="table table-responsive">
                                <tr>
                                    <th class="text-right">No.</th>
                                    <th>No. Invoice</th>
                                    <th>Tgl Transaksi</th>
                                    <th class="text-right">Nominal</th>
                                    <th colspan="3"></th>
                                </tr>
                                <?php
                                if (!empty($penj)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($penj as $penj) {
                                        $tgl = explode('-', $penj->tgl_masuk);
                                        $tgl_t = explode('-', $penj->tgl_keluar);
                                        $sales = $this->db->where('id', $penj->id_sales)->get('tbl_m_sales')->row();
//                                        $sales = $this->ion_auth->user($penj->id_user)->row();
                                        $cust = $this->db->where('id', $penj->id_pelanggan)->get('tbl_m_pelanggan')->row();
                                        ?>
                                        <tr>
                                            <td class="text-right"><?php echo $no++ ?>.</td>
                                            <td><?php echo anchor(base_url('transaksi/trans_jual_det.php?id=' . general::enkrip($penj->no_nota)), $penj->kode_nota_dpn . $penj->no_nota . '/' . $penj->kode_nota_blk, 'class="text-default"') ?></td>
                                            <td><?php echo $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0] ?></td>
                                            <td class="text-right"><?php echo general::format_angka($penj->jml_gtotal) ?></td>
                                            <td>
                                                <?php echo anchor(base_url('akuntability/set_jur_jual_simpan.php?id='.general::enkrip($penj->no_nota).'&akun_deb='.$this->input->get('akun_deb').'&akun_krd='.$this->input->get('akun_krd').'&bulan='.$this->input->get('bulan').'&tahun='.$this->input->get('tahun').'&route='.$this->uri->segment(1).'/'.$this->uri->segment(2)), '<i class="fa fa-plus"></i> Jurnal', 'class="label ' . ($penj->cetak == '1' ? 'label-danger' : 'label-warning') . '"') ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }  else { ?>                                    
                                        <tr>
                                            <th colspan="5" class="text-center">Tidak ada data transaksi yang belum di jurnal</th>
                                        </tr> 
                                <?php } ?>
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
        <?php } ?>
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

//        Autocomplete Nyari Kasir
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
                $itemrow.find('#cari_cust').val(ui.item.nama);
                $('#cari_cust').val(ui.item.nama);
                $('#customer').val(ui.item.id);

                // Give focus to the next input field to recieve input from user
                $('#cari_cust').focus();
                return false;
            }
            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.nama + "</a>")
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