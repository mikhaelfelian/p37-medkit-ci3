<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Riwayat <small>Radiologi</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('page=home') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="active">Instalasi Radiologi</li>
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
                                    <th>Tgl</th>
                                    <th>No. Dokumen</th>
                                    <th>No. Sampel</th>
                                    <th>Catatan</th>
                                    <th>Radiografer</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdmin() == TRUE){ ?>
                            <?php echo form_open(base_url('transaksi/set_cari_penj.php'), 'autocomplete="off"') ?>
                            <?php echo form_hidden('hal', $this->input->get('halaman')) ?>
                            <?php echo form_hidden('status', $this->input->get('status')) ?>
                            <!--<input type="hidden" id="id_customer" name="id_customer">-->
                            <tbody>                                
                                <tr>
                                    <td></td>
                                    <td>
                                        <?php echo form_input(array('id' => 'no_nota', 'name' => 'no_nota', 'class' => 'form-control')) ?>
                                    </td>
                                    <td><?php // echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control')) ?></td>
                                    <td><?php echo form_input(array('id' => 'tgl', 'name' => 'tgl', 'class' => 'form-control')) ?></td>
                                    <td><?php echo form_input(array('id' => 'tgl_tempo', 'name' => 'tgl_bayar', 'class' => 'form-control')) ?></td>
                                    <td>
                                        <?php echo form_input(array('id' => 'cari_cust', 'name' => 'nama_cust', 'class' => 'form-control')) ?>
                                        <input type="hidden" id="customer" name="customer">
                                    </td>
                                    <td>
                                        <?php echo form_input(array('id' => 'cari_sales', 'name' => 'nama_sales', 'class' => 'form-control')) ?>
                                        <input type="hidden" id="sales" name="sales">
                                    </td>
                                    <td></td>
                                    <td>
                                        <button class="btn btn-primary">Filter</button>
                                        <?php if(akses::hakSA() == TRUE || akses::hakOwner() == TRUE || akses::hakAdminM() == TRUE){ ?>
                                        <?php echo (!empty($cetak) ? $cetak : '') ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </tbody>
                            <?php echo form_close() ?>
                            <?php } ?>
                            <tbody>
                                <?php
                                if (!empty($sql)) {
                                    $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
                                    foreach ($sql as $rad) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?>.</td>
                                            <td><?php echo $this->tanggalan->tgl_indo($rad->tgl_simpan) ?></td>
                                            <td><?php echo $rad->no_rad ?></td>
                                            <td><?php echo $rad->no_sample ?></td>
                                            <td><?php echo $rad->ket ?></td>
                                            <td class="text-left"><?php echo $this->ion_auth->user($rad->id_radiografer)->row()->first_name ?></td>
                                            <td>                                                
                                                <a href="<?php echo base_url('pasien/surat/cetak_pdf_rad.php?id=' . general::enkrip($rad->id_medcheck) . '&id_rad=' . general::enkrip($rad->id) . '&status_ctk=1&type=D') ?>" target="_blank" class="label label-primary"><i class="fa fa-print"></i> Cetak</a>
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