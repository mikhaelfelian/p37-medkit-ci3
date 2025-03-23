/<!-- Content Wrapper. Contains page content -->
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
                        <li class="breadcrumb-item active">Laborat</li>
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
                <!--
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
                                    <td class="text-left"><?php // echo $sql_pasien->nama_pgl; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Tipe</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php // echo general::status_rawat2($sql_medc->tipe); ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Klinik</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php // echo $sql_poli->lokasi; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Dokter Utama</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php // echo $sql_dokter->nama; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Petugas</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php // echo $this->ion_auth->user($sql_medc->id_user)->row()->first_name; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Keluhan</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php // echo $sql_medc->keluhan; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Anamnesa</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php // echo $sql_medc->anamnesa; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Pemeriksaan</th>
                                    <th class="text-center">:</th>
                                    <td class="text-left"><?php // echo $sql_medc->pemeriksaan; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                -->
                <div class="col-md-6">                    
                    <?php $hasError = $this->session->flashdata('form_error'); ?>
                    <?php echo form_open_multipart(base_url('medcheck/set_medcheck_rad.php'), 'autocomplete="off"') ?>
                    <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                    <?php echo form_hidden('status', $this->input->get('status')); ?>

                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Pemeriksaan Laborat</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Dokter</label>
                                <div class="col-sm-9">
                                    <select id="dokter" name="dokter" class="form-control select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                        <option value="">- Dokter -</option>
                                        <?php foreach ($sql_doc as $doctor) { ?>
                                            <option value="<?php echo $doctor->id_user ?>" <?php echo (!empty($sql_medc_rad->id_dokter) ? ($doctor->id_user == $sql_medc_rad->id_dokter ? 'selected' : '') : (($doctor->id == $this->session->flashdata('dokter') ? 'selected' : ''))) ?>><?php echo strtoupper($doctor->nama) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">No. Sampel</label>
                                <div class="col-sm-9">
                                    <?php echo form_input(array('id' => 'no_sampel', 'name' => 'no_sampel', 'class' => 'form-control pull-right' . (!empty($hasError['no_sampel']) ? ' is-invalid' : ''), 'placeholder' => 'No Sampel Pengerjaan ...', 'value' => $sql_medc_rad->no_sample)) ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Kesan</label>
                                <div class="col-sm-9">
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
                        default:
                            ?>
                            <?php $hasError = $this->session->flashdata('form_error'); ?>
                            <?php echo form_open_multipart(base_url('medcheck/cart_medcheck_simpan.php'), 'autocomplete="off"') ?>
                            <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                            <?php echo form_hidden('id_item', general::enkrip($sql_produk->id)); ?>
                            <?php echo form_hidden('status', $this->input->get('status')); ?>
                            <input type="hidden" id="id_dokter" name="id_dokter">

                            <div class="card card-default">
                                <div class="card-header">
                                    <h3 class="card-title">Input <?php echo (akses::hakAnalis() == TRUE ? 'Item' : 'Permintaan') ?> Laborat</h3>
                                </div>
                                <div class="card-body table-responsive">
                                    <div class="form-group row <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Kode</label>
                                        <div class="col-sm-10">
                                            <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Kode Lab ...', 'value' => $sql_produk->kode)) ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($sql_produk)) { ?>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">Lab Item</label>
                                            <div class="col-sm-10">
                                                <?php echo form_input(array('id' => 'item', 'name' => 'item', 'class' => 'form-control pull-right', 'placeholder' => 'Kode Item ...', 'value' => $sql_produk->produk, 'readonly' => 'true')) ?>
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
                                                <?php echo form_input(array('id' => 'harga', 'name' => 'harga', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Harga ...', 'value' => (!empty($sql_produk->harga_jual) ? (float) $sql_produk->harga_jual : ''), 'readonly' => 'true')) ?>
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
                            <?php
                            break;

                        case 'hasil_lab':
                            ?>
                            <?php $hasError = $this->session->flashdata('form_error'); ?>
                            <?php echo form_open_multipart(base_url('medcheck/cart_medcheck_lab_nilai.php'), 'autocomplete="off"') ?>
                            <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                            <?php echo form_hidden('id_item', general::enkrip($sql_produk->id)); ?>
                            <?php echo form_hidden('status', $this->input->get('status')); ?>
                            <?php echo form_hidden('id_det', $this->input->get('id_item')); ?>

                            <input type="hidden" id="id_dokter" name="id_dokter">

                            <div class="card card-default">
                                <div class="card-header">
                                    <h3 class="card-title">Input Hasil Laborat</h3>
                                </div>
                                <div class="card-body table-responsive">
                                    <div class="form-group row <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Kode</label>
                                        <div class="col-sm-10">
                                            <?php echo form_input(array('id' => 'kode', 'name' => 'kode', 'class' => 'form-control pull-right' . (!empty($hasError['kode']) ? ' is-invalid' : ''), 'placeholder' => 'Kode Lab ...', 'value' => $sql_produk->kode)) ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($sql_produk)) { ?>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">Lab Item</label>
                                            <div class="col-sm-10">
                                                <?php echo form_input(array('id' => 'item', 'name' => 'item', 'class' => 'form-control pull-right', 'placeholder' => 'Kode Item ...', 'value' => $sql_produk->produk, 'readonly' => 'true')) ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php foreach ($sql_produk_ip as $item_input) { ?>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label"><small><?php echo $item_input->item_name ?></small></label>
                                            <div class="col-sm-3">
                                                <?php echo form_input(array('id' => 'jml', 'name' => 'nilai_normal[' . general::enkrip($item_input->id) . ']', 'class' => 'form-control pull-right text-left', 'value' => htmlspecialchars($item_input->item_value))) ?>
                                            </div>
                                            <div class="col-sm-3">
                                                <?php echo form_input(array('id' => 'jml', 'name' => 'nilai_hasil[' . general::enkrip($item_input->id) . ']', 'class' => 'form-control pull-right text-left', 'placeholder'=>'Hasil Lab ...')) ?>
                                            </div>
                                            <div class="col-sm-2">
                                                <?php echo form_input(array('id' => 'jml', 'name' => 'nilai_satuan[' . general::enkrip($item_input->id) . ']', 'class' => 'form-control pull-right text-left', 'value' => htmlspecialchars($item_input->item_satuan), 'placeholder'=>'Satuan ...')) ?>
                                            </div>
                                        </div>
                                    <?php } ?>
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
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php echo form_open_multipart(base_url('medcheck/set_medcheck_lab_upd.php'), 'autocomplete="off"') ?>
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Data <?php echo (akses::hakAnalis() == TRUE ? 'Item' : 'Permintaan') ?> Laborat</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-left">Tgl</th>
                                        <th class="text-left">Lab Item</th>
                                        <th class="text-left">Keterangan</th>
                                        <th class="text-center">Jml</th>
                                        <?php if (akses::hakAnalis() == TRUE) { ?>
                                            <th class="text-left" colspan="2">Hasil Lab</th>
                                        <?php } else { ?>
                                            <th class="text-left">Hasil Lab</th>
                                            <th class="text-right">Harga</th>
                                            <th class="text-right">Subtotal</th>
                                        <?php } ?>
                                        <th class="text-center">#</th>
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
                                            <?php $sql_lab = $this->db->where('id_medcheck', $medc->id_medcheck)->where('id_item', $medc->id_item)->get('tbl_trans_medcheck_lab')->result(); ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no . '.'; ?></td>
                                                <td class="text-left"><?php echo $this->tanggalan->tgl_indo5($det->tgl_simpan); ?></td>
                                                <td class="text-left">
                                                    <?php echo $medc->item; ?><br/>
                                                    <?php foreach ($sql_lab as $lab) { ?>
                                                    <small>
                                                        <?php echo anchor(base_url('medcheck/cart_medcheck_lab_hsl_hapus.php?id='.$this->input->get('id').'&status='.$this->input->get('status').'&item_id='.general::enkrip($lab->id)), '<i class="fa fa-remove"></i>'.nbs(2), 'class="text-danger" onclick="return confirm(\'Hapus [' . $lab->item_name . '] ?\')"') ?>
                                                        <i><?php echo nbs().'-'.$lab->item_name.(!empty($lab->item_value) ? ': '.$lab->item_value : '').(!empty($lab->item_satuan) ? ' - '.$lab->item_satuan : '').(!empty($lab->item_hasil) ? ' - '.$lab->item_hasil : '') ?></i>
                                                    </small>
                                                    <br/>
                                                    <?php } ?> 
                                                </td>
                                                <td class="text-left"><?php echo $medc->keterangan; ?></td>
                                                <td class="text-center"><?php echo (float) $medc->jml; ?></td>
                                                <?php if (akses::hakAnalis() == TRUE) { ?>
                                                    <td class="text-left" colspan="2">
                                                        <?php if ($medc->status_baca == '1') { ?>
                                                            <?php echo anchor(base_url('medcheck/tambah.php?id=' . $this->input->get('id') . '&status=' . $this->input->get('status') . '&act=hasil_lab&id_produk=' . general::enkrip($medc->id_item) . '&id_item=' . general::enkrip($medc->id)), '<i class="fas fa-check"></i> Input', 'class="btn btn-success btn-flat btn-xs" style="width: 65px;"') ?>
                                                            <?php // echo form_input(array('id' => 'hasil_lab', 'name' => 'nilai_normal[' . general::enkrip($medc->id) . ']', 'class' => 'form-control', 'value' => (!empty($medc->hasil_lab) ? $medc->hasil_lab : ''), 'placeholder' => 'Hasil Lab ...')); ?>
                                                        <?php } ?>
                                                    </td>
                                                <?php } else { ?>
                                                    <td class="text-left"><?php echo $medc->hasil_lab; ?></td>
                                                    <td class="text-right"><?php echo general::format_angka($medc->harga); ?></td>
                                                    <td class="text-right"><?php echo general::format_angka($medc->subtotal); ?></td>
                                                <?php } ?>
                                                <td class="text-center">
                                                    <?php if (akses::hakAnalis() != TRUE) { ?>
                                                        <?php echo anchor(base_url('medcheck/cart_medcheck_hapus.php?id=' . general::enkrip($medc->id) . '&no_nota=' . general::enkrip($medc->id_medcheck) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $medc->item . '] ?\')" style="width: 55px;"') ?>
                                                    <?php } else { ?>
                                                        <?php if ($medc->status_baca != '1') { ?>
                                                            <?php echo anchor(base_url('medcheck/cart_medcheck_status.php?id=' . general::enkrip($medc->id) . '&no_nota=' . general::enkrip($medc->id_medcheck) . '&status=' . $this->input->get('status') . '&state=1'), '<i class="fas fa-check"></i>', 'class="btn btn-success btn-flat btn-xs" onclick="" style="width: 55px;"') ?>
                                                            <?php echo anchor(base_url('medcheck/cart_medcheck_status.php?id=' . general::enkrip($medc->id) . '&no_nota=' . general::enkrip($medc->id_medcheck) . '&status=' . $this->input->get('status') . '&state=2'), '<i class="fas fa-xmark"></i>', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Tolak [' . $medc->item . '] ?\')" style="width: 55px;"') ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php $no++; ?>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <?php if(!empty($sql_medc_det)){ ?>
                                        <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href='<?php echo base_url('medcheck/surat/cetak_pdf_lab.php?id='.$this->input->get('id')) ?>'"><i class="fas fa-print"></i> Cetak</button>
                                    <?php } ?>
                                        
                                    <?php if (akses::hakAnalis() == TRUE) { ?>
                                        <?php echo form_hidden('status', $this->input->get('status')); ?>
                                        <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>

                                        <button type="submit" class="btn btn-primary btn-flat">Simpan &raquo;</button>
                                    <?php } ?>
                                </div>
                            </div>                            
                        </div>
                    </div>                    
                    <?php echo form_close(); ?>
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
                                                        url: "<?php echo base_url('medcheck/json_item.php?status=' . $this->input->get('status')) ?>",
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
    <?php if (!isset($_GET['act'])) { ?>
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
<?php } ?>
 });
</script>