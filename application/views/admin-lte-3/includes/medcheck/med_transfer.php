<?php $hasError = $this->session->flashdata('form_error'); ?>
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
                        <li class="breadcrumb-item active">Transfer Pasien</li>
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
                    <?php echo form_open_multipart(base_url('medcheck/set_medcheck_transfer.php'), 'autocomplete="off"') ?>
                    <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                    <?php echo form_hidden('status', $sql_medc->status); ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">TRANSFER PASIEN - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Tipe <i class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <select id="tipe" name="tipe" class="form-control rounded-0 <?php echo (!empty($hasError['tipe']) ? ' is-invalid' : '') ?>">
                                        <option value="">- Tipe -</option>
                                        <!--<option value="1">Laborat</option>-->
                                        <!--<option value="4">Radiologi</option>-->
                                        <option value="2">Rawat Jalan</option>
                                        <option value="3">Rawat Inap</option>
                                        <option value="5">MCU</option>
                                    </select>
                                </div>
                            </div>
                            <div id="2" class="divTipe">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Asal Poli</label>
                                    <div class="col-sm-7">
                                        <select name="poli_asl" class="form-control rounded-0 <?php echo (!empty($hasError['poli']) ? ' is-invalid' : '') ?>" disabled="TRUE">
                                            <option value="">- Poli -</option>
                                            <?php foreach ($poli as $poliasl) { ?>
                                                <option value="<?php echo $poliasl->id ?>" <?php echo ($poliasl->id == $sql_medc->id_poli ? 'selected' : '') ?>><?php echo $poliasl->lokasi ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Tujuan Poli</label>
                                    <div class="col-sm-7">
                                        <select id="poli_7an" name="poli_7an" class="form-control rounded-0 <?php echo (!empty($hasError['poli']) ? ' is-invalid' : '') ?>">
                                            <option value="">- Poli -</option>
                                            <?php foreach ($poli as $poli7an) { ?>
                                                <option value="<?php echo $poli7an->id ?>"><?php echo $poli7an->lokasi ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Dokter</label>
                                    <div class="col-sm-7">
                                        <select id="dokter2" name="dokter" class="form-control select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                            <option value="">- Dokter -</option>
                                            <?php // foreach ($sql_doc as $doctor) { ?>
                                                <!--<option value="<?php // echo $doctor->id_user ?>" <?php // echo ($sql_dft_id->id_dokter == $doctor->id ? 'selected' : '') ?>><?php // echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . strtoupper($doctor->nama) . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?></option>-->
                                            <?php // } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="3" class="divTipe">
                                <div id="inputKmr" class="form-group row">
                                    <label for="inputTD" class="col-sm-3 col-form-label">Ruang Perawatan</label>
                                    <div class="col-sm-7">
                                        <?php // echo form_input(array('id' => '', 'name' => 'kamar', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kamar']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Nama Kamar / Ruang Perawatan ...')) ?>
                                        <select id="kamar" name="kamar" class="form-control rounded-0<?php echo (!empty($hasError['kamar']) ? ' is-invalid' : '') ?>">
                                            <option value="">- [Ruang Perawatan] -</option>
                                            <?php foreach ($sql_kamar->result() as $ruang) { ?>
                                                <option value="<?php echo $ruang->id ?>"><?php echo $ruang->kamar.' ('.$ruang->jml.'/'.$ruang->jml_max.')' ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="inputKmr" class="form-group row">
                                    <label for="inputTD" class="col-sm-3 col-form-label">Nama Ruang</label>
                                    <div class="col-sm-7">
                                        <?php echo form_input(array('id' => '', 'name' => 'kamar_nm', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['kamar_nm']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Nama Kamar / Ruang Perawatan ...', 'value' => $sql_medc_inf_rw->ruang)) ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Dokter</label>
                                    <div class="col-sm-7">
                                        <select id="dokter3" name="dokter" class="form-control select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                            <option value="">- Dokter -</option>
                                            <?php foreach ($sql_doc as $doctor) { ?>
                                                <option value="<?php echo $doctor->id_user ?>" <?php echo ($sql_dft_id->id_dokter == $doctor->id ? 'selected' : '') ?>><?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . strtoupper($doctor->nama) . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="5" class="divTipe">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Dokter</label>
                                    <div class="col-sm-7">
                                        <select id="dokter5" name="dokter" class="form-control select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                            <option value="">- Dokter -</option>
                                            <?php foreach ($sql_doc as $doctor) { ?>
                                                <option value="<?php echo $doctor->id_user ?>" <?php echo ($sql_dft_id->id_dokter == $doctor->id ? 'selected' : '') ?>><?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . strtoupper($doctor->nama) . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Catatan</label>
                                <div class="col-sm-7">
                                    <?php echo form_textarea(array('id' => 'catatan', 'name' => 'catatan', 'class' => 'form-control rounded-0 ', 'value' => $pasien->alamat, 'style' => 'height: 210px;', 'placeholder' => 'Catatan perawat ...')) ?>
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
                    <?php echo form_close(); ?>


                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">RIWAYAT TRANSFER PASIEN</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-left">Poli Asal</th>
                                                <th class="text-left">Poli Tujuan</th>
                                                <th class="text-left">Keterangan</th>
                                                <th class="text-center">#</th>
                                            </tr>                                    
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            <?php foreach ($sql_medc_trf as $det) { ?>
                                                <?php $sql_poli_asl = $this->db->where('id', $det->id_poli_asal)->get('tbl_m_poli')->row(); ?>
                                                <?php $sql_poli_7an = $this->db->where('id', $det->id_poli_tujuan)->get('tbl_m_poli')->row(); ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no; ?></td>
                                                    <td class="text-left" colspan="7"><small><?php echo $this->tanggalan->tgl_indo2($det->tgl_simpan) . ' ' . $this->tanggalan->wkt_indo($det->tgl_simpan) . ' - '; ?><i><?php echo $this->ion_auth->user($det->id_user)->row()->first_name ?></i></small></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center"></td>
                                                    <td class="text-left"><?php echo $sql_poli_asl->lokasi; ?></td>
                                                    <td class="text-left"><?php echo $sql_poli_7an->lokasi; ?></td>
                                                    <td class="text-left"><?php echo $det->keterangan_perawat; ?></td>
                                                </tr>
                                                <?php $no++ ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">

                                </div>
                                <div class="col-lg-6 text-right">
                                    <?php if (!empty($sql_medc_lab_dt)) { ?>
                                        <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/surat/cetak_pdf_lab.php?id=' . $this->input->get('id') . '&id_lab=' . $this->input->get('id_lab')) ?>'"><i class="fas fa-print"></i> Cetak</button>
                                    <?php } ?>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <?php $data['gtotal'] = $gtotal ?>
                    <?php $this->load->view('admin-lte-3/includes/medcheck/med_tindakan_kanan', $data) ?>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $("#2").hide().find('input').prop('disabled', true);
        $("#3").hide().find('input').prop('disabled', true);
        $("#5").hide().find('input').prop('disabled', true);
        $("select[name=dokter]").prop('disabled', true);
        
        $('.select2bs4').select2({theme: 'bootstrap4'});
        $('#tipe').on('change', function () {
            var tipe = $(this).val();

            $("div.divTipe").hide();
            $("#" + tipe).show().find('input').prop('disabled', false);
            $("#dokter" + tipe).prop('disabled', false);
        });
        
        // Pilih poli
        $("#poli_7an").change(function () {
            var id_poli = $(this).val();

            $.ajax({
                type: "GET",
                dataType: "html",
                url: "<?php echo base_url('medcheck/data_dokter.php?') ?>",
                data: "id_poli=" + id_poli,
                success: function (msg) {
                    $("select#dokter2").html(msg);
                }
            });
        });

        $("#harga").autoNumeric({aSep: '.', aDec: ',', aPad: false});
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
        
        <?php echo $this->session->flashdata('medcheck_toast'); ?>
    });
</script>