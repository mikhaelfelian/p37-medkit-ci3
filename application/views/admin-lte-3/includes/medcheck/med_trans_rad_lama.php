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
                <div class="col-md-12"><?php echo $this->session->flashdata('medcheck') ?></div>
                <div class="col-md-6">                    
                    <?php $hasError = $this->session->flashdata('form_error'); ?>
                    <?php echo form_open_multipart(base_url('medcheck/set_medcheck_rad.php'), 'autocomplete="off"') ?>
                    <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                    <?php echo form_hidden('status', $this->input->get('status')); ?>

                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Pemeriksaan Radiologi</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">Dokter Pengirim</label>
                                <div class="col-sm-8">
                                    <select id="dokter_krm" name="dokter_kirim" class="form-control select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                        <option value="">- Dokter -</option>
                                        <?php foreach ($sql_doc as $doctor) { ?>
                                            <option value="<?php echo $doctor->id_user ?>" <?php echo (!empty($sql_medc_rad->id_dokter_kirim) ? ($doctor->id_user == $sql_medc_rad->id_dokter_kirim ? 'selected' : '') : (($doctor->id == $this->session->flashdata('dokter') ? 'selected' : ''))) ?>><?php echo strtoupper($doctor->nama) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">Dokter Radiologi</label>
                                <div class="col-sm-8">
                                    <select id="dokter" name="dokter" class="form-control select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                        <option value="">- Dokter -</option>
                                        <?php foreach ($sql_doc as $doctor) { ?>
                                            <option value="<?php echo $doctor->id_user ?>" <?php echo (!empty($sql_medc_rad->id_dokter) ? ($doctor->id_user == $sql_medc_rad->id_dokter ? 'selected' : '') : (($doctor->id == $this->session->flashdata('dokter') ? 'selected' : ''))) ?>><?php echo strtoupper($doctor->nama) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">No. Sampel</label>
                                <div class="col-sm-8">
                                    <?php echo form_input(array('id' => 'no_sampel', 'name' => 'no_sampel', 'class' => 'form-control pull-right' . (!empty($hasError['no_sampel']) ? ' is-invalid' : ''), 'placeholder' => 'No Sampel Pengerjaan ...', 'value' => $sql_medc_rad->no_sample)) ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">Kesan</label>
                                <div class="col-sm-8">
                                    <?php echo form_textarea(array('id' => 'kesan', 'name' => 'kesan', 'class' => 'form-control pull-left', 'placeholder' => 'Kesan Pembacaan ...', 'value' => $sql_medc_rad->ket)) ?>
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
                <div class="col-md-6">
                    <?php
                    switch ($_GET['act']) {

                        case 'input_resep':
                            $sql_item_rad = $this->db->where('id', general::dekrip($_GET['id_item']))->get('tbl_trans_medcheck_det')->row();
                            ?>
                            <?php $hasError = $this->session->flashdata('form_error'); ?>
                            <?php echo form_open_multipart(base_url('medcheck/cart_medcheck_rad.php'), 'autocomplete="off"') ?>
                            <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                            <?php echo form_hidden('id_item', general::enkrip($sql_item_rad->id)); ?>
                            <?php echo form_hidden('status', $this->input->get('status')); ?>

                            <div class="card card-default">
                                <div class="card-header">
                                    <h3 class="card-title">Input Item Radiologi</h3>
                                </div>
                                <div class="card-body table-responsive">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Kode</label>
                                        <div class="col-sm-10">
                                            <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Kode Item ...', 'value' => $sql_item_rad->kode, 'readonly' => 'true')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Item</label>
                                        <div class="col-sm-10">
                                            <?php echo form_input(array('id' => 'item', 'name' => 'item', 'class' => 'form-control pull-right', 'placeholder' => 'Jml ...', 'value' => $sql_item_rad->item, 'readonly' => 'true')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Nilai</label>
                                        <div class="col-sm-10">
                                            <?php echo form_input(array('id' => 'item_name', 'name' => 'item_name', 'class' => 'form-control pull-right', 'placeholder' => 'Nama Pemeriksaan ...')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Hasil</label>
                                        <div class="col-sm-10">
                                            <?php echo form_textarea(array('id' => 'item_value', 'name' => 'item_value', 'class' => 'form-control pull-left', 'placeholder' => 'Hasil Pembacaan ...')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">File</label>
                                        <div class="col-sm-10">
                                            <?php echo form_upload(array('id' => 'fupload', 'name' => 'fupload', 'class' => '', 'placeholder' => 'Hasil ...')) ?>
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
                            <?php
                            break;

                        case 'input_resep_img':
                            $sql_item_rad = $this->db->where('id', general::dekrip($_GET['id_item']))->get('tbl_trans_medcheck_det')->row();
                            ?>
                            <?php $hasError = $this->session->flashdata('form_error'); ?>
                            <?php echo form_open_multipart(base_url('medcheck/cart_medcheck_rad.php'), 'autocomplete="off"') ?>
                            <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                            <?php echo form_hidden('id_item', general::enkrip($sql_item_rad->id)); ?>
                            <?php echo form_hidden('status', $this->input->get('status')); ?>

                            <div class="card card-default">
                                <div class="card-header">
                                    <h3 class="card-title">Input Item Radiologi</h3>
                                </div>
                                <div class="card-body table-responsive">
                                    <div class="form-group row <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Kode</label>
                                        <div class="col-sm-10">
                                            <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Kode Item ...', 'value' => $sql_item_rad->kode, 'readonly' => 'true')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Item</label>
                                        <div class="col-sm-10">
                                            <?php echo form_input(array('id' => 'jml', 'name' => 'jml', 'class' => 'form-control pull-right', 'placeholder' => 'Jml ...', 'value' => $sql_item_rad->item, 'readonly' => 'true')) ?>
                                        </div>
                                        <div class="col-sm-8">

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Hasil</label>
                                        <div class="col-sm-10">
                                            <?php echo form_textarea(array('id' => 'hasil', 'name' => 'hasil', 'class' => 'form-control pull-left', 'placeholder' => 'Hasil ...')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">File</label>
                                        <div class="col-sm-10">
                                            <?php echo form_upload(array('id' => 'fupload', 'name' => 'fupload', 'class' => '', 'placeholder' => 'Hasil ...')) ?>
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
                            <?php
                            break;

                        default:
                            ?>
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
                                    <div class="form-group row">
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
                                                <?php echo form_input(array('id' => 'dokter_rad', 'name' => 'dokter', 'class' => 'form-control pull-right', 'placeholder' => 'Dokter Terkait ...')) ?>
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
                                            <button type="button" onclick="window.location.href = '<?php echo base_url('medcheck/tambah.php?id='.$this->input->get('id').'&status='.$this->input->get('status')); ?>'" class="btn btn-danger btn-flat"><i class="fas fa-refresh"></i> Reset</button>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                        </div>
                                    </div>                            
                                </div>
                            </div>
                            <?php echo form_close() ?>
                            <?php
                            break;
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Data Item Radiologi</h3>
                        </div>
                        <div class="card-body table-responsive">                            
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-left">Tgl</th>
                                        <th class="text-left">Item</th>
                                        <th class="text-center">Jml</th>
                                        <th class="text-right">Harga</th>
                                        <th class="text-right">Subtotal</th>
                                        <th class="text-center"></th>
                                    </tr>                                    
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($sql_medc_det as $det) { ?>
                                        <?php $sql_kat      = $this->db->where('id', $det->id_item_kat)->get('tbl_m_kategori')->row(); ?>
                                        <?php $sql_det      = $this->db->where('id_medcheck', $det->id_medcheck)->where('id_item_kat', $det->id_item_kat)->get('tbl_trans_medcheck_det')->result(); ?>
                                        <tr>
                                            <td class="text-left text-bold" colspan="9"><?php echo $sql_kat->keterangan . ' (' . $sql_kat->kategori . ')'; ?></td>
                                        </tr>
                                        <?php foreach ($sql_det as $medc) { ?>
                                            <?php $sql_doc = $this->db->where('id', $medc->id_dokter)->get('tbl_m_karyawan')->row(); ?>
                                            <?php $sql_rad_det  = $this->db->where('id_medcheck', $det->id_medcheck)->where('id_medcheck_det', $medc->id)->get('tbl_trans_medcheck_rad_det')->result(); ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no . '.'; ?></td>
                                                <td class="text-left"><?php echo $this->tanggalan->tgl_indo5($det->tgl_simpan); ?></td>
                                                <td class="text-left">
                                                    <?php if (!empty($det->file_rad)) { ?>
                                                        <a href="<?php echo $det->file_rad ?>" data-toggle="lightbox" data-title="<?php echo $det->item ?>">
                                                            <i class="fas fa-paperclip"></i>
                                                        </a>
                                                    <?php } ?>
                                                    <b><?php echo $medc->item; ?></b>
                                                    <?php if(!empty($medc->keterangan)){ ?>
                                                        <?php echo br(); ?>
                                                        <small><i><?php echo $medc->keterangan; ?></i></small>
                                                    <?php } ?>
                                                    <?php echo br(); ?>
                                                    <small><i><?php echo $sql_doc->nama; ?></i></small>
                                                </td>
                                                <td class="text-center"><?php echo (float) $medc->jml; ?></td>
                                                <td class="text-right"><?php echo general::format_angka($medc->harga); ?></td>
                                                <td class="text-right"><?php echo general::format_angka($medc->subtotal); ?></td>
                                                <td class="text-center">
                                                    <?php echo anchor(base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&act=input_resep&status=' . $this->input->get('status') . '&id_item=' . general::enkrip($medc->id)), '<i class="fa fa-file"></i> Input', 'class="btn btn-success btn-flat btn-xs"') ?>
                                                    <?php echo anchor(base_url('medcheck/cart_medcheck_hapus.php?id=' . general::enkrip($medc->id) . '&no_nota=' . general::enkrip($medc->id_medcheck) . '&status=' . $this->input->get('status')), '<i class="fa fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $medc->item . '] ?\')"') ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="text-right text-bold">Hasil Pembacaan</td>
                                                <td colspan="6">
                                                    <?php foreach ($sql_rad_det as $rad_hasil) { ?>
                                                        <small>
                                                            <?php echo anchor(base_url('medcheck/cart_medcheck_rad_hsl_hapus.php?id='.$this->input->get('id').'&status='.$this->input->get('status').'&item_id='.general::enkrip($rad_hasil->id)), '<i class="fa fa-remove"></i>'.nbs(2), 'class="text-danger" onclick="return confirm(\'Hapus [' . (!empty($rad_hasil->item_name) ? $rad_hasil->item_name : $rad_hasil->item_value) . '] ?\')"') ?>
                                                            <?php echo $rad_hasil->item_name.(!empty($rad_hasil->item_name) ? ' : ' : '').$rad_hasil->item_value; ?>
                                                        </small>
                                                        <br/>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php $no++ ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="2" class="text-right text-bold">Kesan</td>
                                        <td colspan="6">
                                            <small>
                                                <?php echo $sql_medc_rad->ket; ?>
                                            </small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href='<?php echo base_url('medcheck/tindakan.php?id='.general::enkrip($sql_medc->id)) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <?php if(!empty($sql_medc_det)){ ?>
                                        <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href='<?php echo base_url('medcheck/surat/cetak_pdf_rad.php?id='.$this->input->get('id')) ?>'"><i class="fas fa-print"></i> Cetak</button>
                                    <?php } ?>
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

<!-- Ekko Lightbox -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/ekko-lightbox/ekko-lightbox.min.js') ?>"></script>

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        // Data Dokter  
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
                                    
        $("#harga").autoNumeric({aSep: '.', aDec: ',', aPad: false});

 <?php if (!empty($det->file_rad)) { ?>
            $(document).on('click', '[data-toggle="lightbox"]', function (event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });
<?php } ?>

        // Data Item Cart
        $('#kode').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url('medcheck/json_item.php?page=rad&status=' . $this->input->get('status')) ?>",
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
            $('#dokter_rad').autocomplete({
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
                    $('#dokter_rad').val(ui.item.nama);
                    //                window.location.href = "<?php echo base_url('medcheck/tambah.php?id=' . $this->input->get('id') . '&status=' . $this->input->get('status')) ?>";

                    // Give focus to the next input field to recieve input from user
                    $('#dokter_rad').focus();
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