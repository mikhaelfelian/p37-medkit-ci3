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
                        <li class="breadcrumb-item active">Rawat Bersama</li>
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
                    <?php // if ($sql_medc->status < 5) { ?>
                        <!--Form Input Dokter ini hanya muncul ketika transaksi belum lunas-->
                        <?php echo form_open_multipart(base_url('medcheck/dokter/set_medcheck_doc.php'), 'autocomplete="off"') ?>
                        <?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
                        <?php echo form_hidden('status', $this->input->get('status')); ?>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">RAWAT BERSAMA - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
                            </div>
                            <div class="card-body">
                                <?php echo $this->session->flashdata('medcheck'); ?>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Dokter</label>
                                    <div class="col-sm-7">
                                        <select name="dokter" class="form-control select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                            <option value="">- Dokter -</option>
                                            <?php foreach ($sql_doc as $doctor) { ?>
                                                <option value="<?php echo $doctor->id_user ?>" <?php echo ($sql_dft_id->id_dokter == $doctor->id ? 'selected' : '') ?>><?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . strtoupper($doctor->nama) . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Catatan</label>
                                    <div class="col-sm-7">
                                        <?php echo form_textarea(array('id' => 'catatan', 'name' => 'catatan', 'class' => 'form-control', 'value' => $pasien->alamat, 'style' => 'height: 210px;', 'placeholder' => 'Catatan perawat ...')) ?>
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
                    <?php // } ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">DAFTAR DOKTER</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-left">Dokter</th>
                                                <th class="text-left">Catatan</th>
                                                <th class="text-center">#</th>
                                            </tr>                                    
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            <?php foreach ($sql_raber as $det) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no; ?></td>
                                                    <td class="text-left" colspan="7"><small><?php echo $this->tanggalan->tgl_indo2($det->tgl_simpan) . ' ' . $this->tanggalan->wkt_indo($det->tgl_simpan) . ' - '; ?><i><?php echo $this->ion_auth->user($det->id_user)->row()->first_name ?></i></small></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center"></td>
                                                    <td class="text-left"><?php echo (!empty($det->nama_dpn) ? $det->nama_dpn . ' ' : '') . $det->nama . (!empty($det->nama_blk) ? ', ' . $det->nama_blk : '') . ($det->status == '1' ? ' <i>(Dokter Utama)</i>' : ''); ?></td>
                                                    <td class="text-left"><?php echo $det->keterangan; ?></td>
                                                    <td class="text-left">                                                        
                                                        <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakPerawat() == TRUE) { ?>
                                                            <?php if ($sql_medc->status < 5) { ?>
                                                                <?php if ($det->status != '1') { ?>
                                                                    <?php echo anchor(base_url('medcheck/dokter/hapus.php?id=' . general::enkrip($det->id_medcheck) . '&id_item=' . general::enkrip($det->id) . '&status=' . $this->input->get('status')), '<i class="fa fa-trash"></i>', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus ?\')"') ?>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </td>
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
                                    <?php if ($sql_medc->status >= 5) { ?>
                                        <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-6 text-right">

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

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $("#harga").autoNumeric({aSep: '.', aDec: ',', aPad: false});
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
    });
</script>