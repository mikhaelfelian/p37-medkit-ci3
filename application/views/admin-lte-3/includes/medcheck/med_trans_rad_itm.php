<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Medical Checkup</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('medcheck/index.php') ?>">Medical Checkup</a></li>
                        <li class="breadcrumb-item active">Radiologi</li>
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
                <div class="col-md-6">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Form Medical Checkup</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-responsive">
                                <tr>
                                    <th class="text-left">Nama Pasien</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $sql_pasien->nama_pgl; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Tipe</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo general::status_rawat2($sql_medc->tipe); ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Klinik</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $sql_poli->lokasi; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Dokter Utama</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $sql_dokter->nama; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Petugas</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $this->ion_auth->user($sql_medc->id_user)->row()->first_name; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Keluhan</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $sql_medc->keluhan; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Anamnesa</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $sql_medc->anamnesa; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Pemeriksaan</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php echo $sql_medc->pemeriksaan; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <!--<button type="button" onclick="window.location.href = '<?php echo base_url('master/data_kategori_list.php') ?>'" class="btn btn-primary btn-flat">&laquo; Kembali</button>-->
                                </div>
                                <div class="col-lg-6 text-right">
                                    <!--<button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-undo"></i> Bersih</button>-->
                                    <!--<button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>-->
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <?php $hasError = $this->session->flashdata('form_error'); ?>
                    <?php echo form_open_multipart(base_url('medcheck/cart_medcheck_simpan.php'), 'autocomplete="off"') ?>
                    <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                    <?php echo form_hidden('id_item', general::enkrip($sql_produk->id)); ?>
                    <?php echo form_hidden('status', $this->input->get('status')); ?>
                    <?php echo form_hidden('status_item', '3'); ?>
                    <input type="hidden" id="id_dokter" name="id_dokter">

                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Input Item Radiologi</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <div class="form-group row <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Kode</label>
                                <div class="col-sm-10">
                                    <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Kode Item ...', 'value' => $sql_produk->kode)) ?>
                                </div>
                            </div>
                            <?php if (!empty($sql_produk)) { ?>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Item</label>
                                    <div class="col-sm-10">
                                        <?php echo form_input(array('id' => 'item', 'name' => 'item', 'class' => 'form-control pull-right', 'placeholder' => 'Kode Item ...', 'value' => $sql_produk->produk, 'readonly' => 'true')) ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Dokter</label>
                                    <div class="col-sm-10">
                                        <?php echo form_input(array('id' => 'dokter', 'name' => 'dokter', 'class' => 'form-control pull-right', 'placeholder' => 'Dokter Terkait ...')) ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Jml</label>
                                <div class="col-sm-2">
                                    <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control pull-right text-center', 'placeholder' => 'Jml ...', 'value' => '1')) ?>
                                </div>
                                <div class="col-sm-8">

                                </div>
                            </div>
                            <div class="form-group row <?php echo (!empty($hasError['harga']) ? 'text-danger' : '') ?>">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Harga</label>
                                <div class="col-sm-10">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
                                        <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Harga ...', 'value' => (!empty($sql_produk->harga_jual) ? (float) $sql_produk->harga_jual : ''))) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Ket</label>
                                <div class="col-sm-10">
                                    <?php echo form_input(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control pull-left', 'placeholder' => 'Keterangan ...')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">

                                </div>
                                <div class="col-lg-6 text-right">
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Data Item Tindakan / Jasa</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-left">Tgl</th>
                                        <th class="text-left">Item</th>
                                        <th class="text-left">Dokter</th>
                                        <th class="text-left">Keterangan</th>
                                        <th class="text-center">Jml</th>
                                        <th class="text-right">Harga</th>
                                        <th class="text-right">Subtotal</th>
                                        <th class="text-center"></th>
                                    </tr>                                    
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($sql_medc_det as $det) { ?>
                                        <?php $sql_kat = $this->db->where('id', $det->id_item_kat)->get('tbl_m_kategori')->row(); ?>
                                        <?php $sql_det = $this->db->where('id_medcheck', $det->id_medcheck)->where('id_item_kat', $det->id_item_kat)->get('tbl_trans_medcheck_det')->result(); ?>
                                        <tr>
                                            <td class="text-left text-bold" colspan="9"><?php echo $sql_kat->keterangan . ' (' . $sql_kat->kategori . ')'; ?></td>
                                        </tr>
                                        <?php foreach ($sql_det as $medc) { ?>
                                            <?php $sql_doc = $this->db->where('id', $medc->id_dokter)->get('tbl_m_sales')->row(); ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no . '.'; ?></td>
                                                <td class="text-left"><?php echo $this->tanggalan->tgl_indo5($det->tgl_simpan); ?></td>
                                                <td class="text-left"><?php echo $medc->item; ?></td>
                                                <td class="text-left"><?php echo $sql_doc->nama; ?></td>
                                                <td class="text-left"><?php echo $medc->keterangan; ?></td>
                                                <td class="text-center"><?php echo (float) $medc->jml; ?></td>
                                                <td class="text-right"><?php echo general::format_angka($medc->harga); ?></td>
                                                <td class="text-right"><?php echo general::format_angka($medc->subtotal); ?></td>
                                                <td class="text-center">
                                                    <?php echo anchor(base_url('medcheck/cart_medcheck_rad.php?id=' . general::enkrip($medc->id) . '&no_nota=' . general::enkrip($medc->id_medcheck) . '&status=' . $this->input->get('status')), '<i class="fa fa-file"></i> Input', 'class="btn btn-success btn-flat btn-xs"') ?>
                                                    <?php echo anchor(base_url('medcheck/cart_medcheck_hapus.php?id=' . general::enkrip($medc->id) . '&no_nota=' . general::enkrip($medc->id_medcheck) . '&status=' . $this->input->get('status')), '<i class="fa fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $medc->item . '] ?\')"') ?>
                                                </td>
                                            </tr>
                                            <?php $no++ ?>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                
                                </div>
                                <div class="col-lg-6 text-right">
                                    <?php echo form_open_multipart(base_url('medcheck/set_medcheck_upd.php'), 'autocomplete="off"') ?>
                                    <?php echo form_hidden('anamnesa', $sql_medc->anamnesa); ?>
                                    <?php echo form_hidden('diagnosa', $sql_medc->diagnosa); ?>
                                    <?php echo form_hidden('pemeriksaan', $sql_medc->pemeriksaan); ?>
                                    <?php echo form_hidden('status_periksa', $sql_medc->status_periksa); ?>
                                    <?php echo form_hidden('status', ($sql_medc->status > 3 ? $sql_medc->status : '4')); ?>
                                    <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>

                                    <button type="submit" class="btn btn-primary btn-flat">Lanjut &raquo;</button>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>                            
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
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $("#harga").autoNumeric({aSep: '.', aDec: ',', aPad: false});

        // Data Item Cart
        $('#kode').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('medcheck/json_item.php?status='.$this->input->get('status')) ?>",
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
                //Populate the input fields from the returned values
                $itemrow.find('#id_item').val(ui.item.id);
                $('#id_item').val(ui.item.id);
                $('#kode').val(ui.item.kode);
                window.location.href = "<?php echo base_url('medcheck/tambah.php?id=' . $this->input->get('id') . '&status=' . $this->input->get('status')) ?>&id_produk=" + ui.item.id + "&harga=" + ui.item.harga;

                // Give focus to the next input field to recieve input from user
                $('#jml').focus();
                return false;
            }

            // Format the list menu output of the autocomplete
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.name + "</a>")
                    .appendTo(ul);
        };

<?php if (!empty($sql_produk)) { ?>
            // Cari Data Dokter
            $('#dokter').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url('medcheck/json_dokter.php') ?>",
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
                    //Populate the input fields from the returned values
                    $itemrow.find('#id_dokter').val(ui.item.id);
                    $('#id_dokter').val(ui.item.id);
                    $('#dokter').val(ui.item.nama);
                    //                window.location.href = "<?php echo base_url('medcheck/tambah.php?id=' . $this->input->get('id') . '&status=' . $this->input->get('status')) ?>";

                    // Give focus to the next input field to recieve input from user
                    $('#dokter').focus();
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