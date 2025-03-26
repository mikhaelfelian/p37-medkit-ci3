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
                        <li class="breadcrumb-item active">Tindakan</li>
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
                <div class="col-lg-8">
                    <?php if ($sql_medc->status < 5) { ?>
                    <?php $hasError = $this->session->flashdata('form_error'); ?>
                    <?php $jml      = $this->session->flashdata('jml'); ?>
                    <?php echo form_open(base_url('medcheck/cart_medcheck_simpan.php'), array('autocomplete' => 'off', 'id' => 'medcheck_form')) ?>                    
                    <?php echo add_form_protection(); ?>
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">INPUT TINDAKAN & JASA - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                                    <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                                    <?php echo form_hidden('id_item', general::enkrip($sql_produk->id)); ?>
                                    <?php echo form_hidden('status', $this->input->get('status')); ?>
                                    <?php echo form_hidden('status_item', '2'); ?>
                                    <input type="hidden" id="id_dokter" name="id_dokter">
                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php if (!empty($sql_produk)) { ?>
                                                <?php if ($sql_medc->tipe == '3') { ?>
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Tanggal</label>
                                                        <div class="col-sm-9">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                                </div>
                                                                <?php echo form_input(array('id' => 'tgl_masuk', 'name' => 'tgl_masuk', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Tgl Simpan ...', 'readonly' => 'true')) ?>                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                            <div class="form-group row <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                                                <label for="inputEmail3" class="col-sm-3 col-form-label">Kode</label>
                                                <div class="col-sm-9">
                                                    <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Kode Item ...', 'value' => $sql_produk->kode)) ?>
                                                </div>
                                            </div>
                                            <?php if (!empty($sql_produk)) { ?>
                                                <div class="form-group row">
                                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Item</label>
                                                    <div class="col-sm-9">
                                                        <?php echo form_input(array('id' => 'item', 'name' => 'item', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Kode Item ...', 'value' => $sql_produk->produk, 'readonly' => 'true')) ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="form-group row <?php echo (!empty($hasError['jml']) ? 'text-danger' : '') ?>">
                                                <label for="inputEmail3" class="col-sm-3 col-form-label">Jml</label>
                                                <div class="col-sm-3">
                                                    <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control pull-right text-center rounded-0'.(!empty($hasError['jml']) ? ' is-invalid' : ''), 'placeholder' => 'Jml ...', 'value' => (!empty($jml) ? $jml : '1'))) ?>
                                                </div>
                                                <div class="col-sm-6">
                                                    
                                                </div>
                                            </div>
                                            <div class="form-group row <?php echo (!empty($hasError['harga']) ? 'text-danger' : '') ?>">
                                                <label for="inputEmail3" class="col-sm-3 col-form-label">Harga</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">Rp. </span>
                                                        </div>
                                                        <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Harga ...', 'value' => (!empty($sql_produk->harga_jual) ? (float) $sql_produk->harga_jual : '0'), 'readonly'=>'TRUE')) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <?php if (!empty($sql_produk)) { ?>
                                                <div class="form-group row">
                                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Dokter</label>
                                                    <div class="col-sm-9">
                                                        <?php echo form_input(array('id' => 'dokter', 'name' => 'dokter', 'class' => 'form-control pull-right rounded-0', 'placeholder' => 'Dokter Terkait ...')) ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="col-sm-3 col-form-label">Ket</label>
                                                <div class="col-sm-9">
                                                    <?php echo form_textarea(array('id' => 'keterangan', 'name' => 'keterangan', 'class' => 'form-control pull-left rounded-0', 'placeholder' => 'Keterangan ...', 'rows'=>'8')) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <?php echo add_double_submit_protection('medcheck_form'); ?>
                    <?php echo form_close() ?>
                    <!-- /.card -->
                    <?php } ?>
                    
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">DATA TINDAKAN & JASA</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-left">Tgl</th>
                                        <th class="text-left">Item</th>
                                        <th class="text-center">Jml</th>
                                        <th class="text-right">Harga</th>
                                        <th class="text-right">Subtotal</th>
                                        <th class="text-center">#</th>
                                    </tr>                                    
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $gtotal = 0
                                    ?>
                                    <?php foreach ($sql_medc_det as $det) { ?>
                                        <?php $sql_kat = $this->db->where('id', $det->id_item_kat)->get('tbl_m_kategori')->row(); ?>
                                        <?php $sql_det = $this->db->where('id_medcheck', $det->id_medcheck)->where('id_item_kat', $det->id_item_kat)->where('status', '2')->get('tbl_trans_medcheck_det')->result(); ?>
                                        <tr>
                                            <td class="text-left text-bold" colspan="7"><i><?php echo $sql_kat->keterangan . ' (' . $sql_kat->kategori . ')'; ?></i></td>
                                        </tr>
                                        <?php $sub = 0; ?>
                                        <?php foreach ($sql_det as $medc) { ?>
                                            <?php $sub = $sub + $medc->subtotal ?>
                                            <?php $sql_doc = $this->db->where('id_user', $medc->id_dokter)->get('tbl_m_karyawan')->row(); ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no . '.'; ?></td>
                                                <td class="text-left"><?php echo $this->tanggalan->tgl_indo5($medc->tgl_simpan); ?></td>
                                                <td class="text-left">
                                                    <?php echo $medc->item; ?>
                                                    <?php if (!empty($medc->id_dokter)) { ?>
                                                        <?php echo br(); ?>
                                                        <small><?php echo (!empty($sql_doc->nama_dpn) ? $sql_doc->nama_dpn.' ' : '').$sql_doc->nama.(!empty($sql_doc->nama_blk) ? ', '.$sql_doc->nama_blk : '') ?></small>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center"><?php echo (float) $medc->jml; ?></td>
                                                <td class="text-right"><?php echo general::format_angka($medc->harga); ?></td>
                                                <td class="text-right"><?php echo general::format_angka($medc->subtotal); ?></td>
                                                <td class="text-right">
                                                    <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakPerawat() == TRUE) { ?>
                                                        <?php if ($sql_medc->status < 5) { ?>
                                                            <?php echo anchor(base_url('medcheck/cart_medcheck_hapus.php?id=' . general::enkrip($medc->id) . '&no_nota=' . general::enkrip($medc->id_medcheck) . '&status=' . $this->input->get('status')), '<i class="fa fa-trash"></i>', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $medc->item . '] ?\')"') ?>
                                                        <?php }?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php if (!empty($medc->keterangan)) { ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td colspan="5"><small><i>* <?php echo strtolower($medc->keterangan); ?></i></small></td>
                                                </tr>
                                            <?php } ?>
                                            <?php $no++ ?>
                                        <?php } ?>             
                                        <tr>
                                            <td class="text-right text-bold" colspan="5">Subtotal</td>
                                            <td class="text-right text-bold" colspan="5"><?php echo general::format_angka($sub); ?></td>
                                        </tr>
                                        <?php $gtotal = $gtotal + $sub ?>
                                    <?php } ?>
                                    <tr>
                                        <td class="text-right text-bold" colspan="5">Grand Total</td>
                                        <td class="text-right text-bold" colspan="5"><?php echo general::format_angka($gtotal); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <?php if ($sql_medc->status >= 5) { ?>
                                        <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-6 text-right">
                                    
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-lg-4">
                    <?php $data['gtotal'] = $gtotal ?>
                    <?php $this->load->view('admin-lte-3/includes/medcheck/med_tindakan_kanan', $data) ?>
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
        $("input[id=harga]").autoNumeric({aSep: '.', aDec: ',', aPad: false});
        
        $('#tgl_masuk').datepicker({
            timepicker: true,
            dateFormat: 'dd-mm-yy',
//            formatTime: 'H:i',
            autoclose: true
        });

        // Data Item Cart
        $('#kode').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('medcheck/json_item.php?page=tindakan&status=0') ?>",
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
                    $('#id_dokter').val(ui.item.id_user);
                    $('#dokter').val(ui.item.nama);
                    // window.location.href = "<?php echo base_url('medcheck/tambah.php?id=' . $this->input->get('id') . '&status=' . $this->input->get('status')) ?>";

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
<script type="text/javascript">
    $(function () {
        <?php echo $this->session->flashdata('medcheck_toast'); ?>
    });
</script>