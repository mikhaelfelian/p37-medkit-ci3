<?php $hasError = $this->session->flashdata('form_error'); ?>
<div class="row">
    <div class="col-md-10">
        <!-- Content Wrapper. Contains page content -->        
        <?php echo form_open_multipart(base_url('master/set_karyawan_simpan_pend.php'), 'autocomplete="off"') ?>
        <?php echo form_hidden('id', general::enkrip($sql_kary->id)); ?>
        <?php echo form_hidden('route', 'profile.php?page=profile_pend'); ?>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">BERKAS PENDIDIKAN - <?php echo (!empty($sql_kary->nama_dpn) ? $sql_kary->nama_dpn . ' ' : '') . $sql_kary->nama . (!empty($sql_kary->nama_blk) ? ', ' . $sql_kary->nama_blk : ''); ?></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row <?php echo (!empty($hasError['pendidikan']) ? 'text-danger' : '') ?>">
                            <label for="label" class="col-sm-4 col-form-label">Pendidikan*</label>
                            <div class="col-sm-8">
                                <?php echo form_input(array('id' => 'pendidikan', 'name' => 'pendidikan', 'class' => 'form-control rounded-0' . (!empty($hasError['pendidikan']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan S1/D3/D1/SMK - Sederajat ...')) ?>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($hasError['jurusan']) ? 'text-danger' : '') ?>">
                            <label for="label" class="col-sm-4 col-form-label">Jurusan*</label>
                            <div class="col-sm-8">
                                <?php echo form_input(array('id' => 'jurusan', 'name' => 'jurusan', 'class' => 'form-control rounded-0' . (!empty($hasError['jurusan']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Jurusan yang di tempuh ...')) ?>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($hasError['instansi']) ? 'text-danger' : '') ?>">
                            <label for="label" class="col-sm-4 col-form-label">Instansi*</label>
                            <div class="col-sm-8">
                                <?php echo form_input(array('id' => 'instansi', 'name' => 'instansi', 'class' => 'form-control rounded-0' . (!empty($hasError['instansi']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Institusi Pendidikan ...')) ?>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($hasError['keterangan']) ? 'text-danger' : '') ?>">
                            <label for="label" class="col-sm-4 col-form-label">Keterangan</label>
                            <div class="col-sm-8">
                                <?php echo form_textarea(array('id' => 'ket', 'name' => 'ket', 'class' => 'form-control rounded-0', 'style' => 'height: 183px;', 'placeholder' => 'Isikan Keterangan ...')) ?>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($hasError['fupload']) ? 'text-danger' : '') ?>" id="tp_berkas">
                            <label for="label" class="col-sm-4 col-form-label">Unggah Berkas*</label>
                            <div class="col-sm-8">
                                <?php echo form_upload(array('name' => 'fupload', 'class' => 'form-control rounded-0' . (!empty($hasError['fupload']) ? ' is-invalid' : ''))) ?>
                                <i>* File yang diijinkan : jpg|png|pdf|jpeg|jfif</i>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <?php echo $this->session->flashdata('master') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row <?php echo (!empty($hasError['no_dok']) ? 'text-danger' : '') ?>">
                            <label for="label" class="col-sm-4 col-form-label">No. Dokumen*</label>
                            <div class="col-sm-8">
                                <?php echo form_input(array('id' => '', 'name' => 'no_dok', 'class' => 'form-control rounded-0' . (!empty($hasError['no_dok']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan No. Dokumen (Ijazah/Ijin) ...')) ?>
                            </div>
                        </div>                                 
                        <div class="form-group row <?php echo (!empty($hasError['thn_masuk']) ? 'text-danger' : '') ?>">
                            <label for="label" class="col-sm-4 col-form-label">Tahun Masuk*</label>
                            <div class="col-sm-3">
                                <?php echo form_input(array('id' => 'thn', 'name' => 'thn_masuk', 'class' => 'form-control rounded-0' . (!empty($hasError['thn_masuk']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Tahun Masuk ...')) ?>
                            </div>
                        </div>                                    
                        <div class="form-group row">
                            <label for="label" class="col-sm-4 col-form-label">Tahun Lulus</label>
                            <div class="col-sm-3">
                                <?php echo form_input(array('id' => 'thn', 'name' => 'thn_keluar', 'class' => 'form-control rounded-0', 'placeholder' => 'Isikan Tahun Lulus ...')) ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="label" class="col-sm-4 col-form-label">Status Lulus</label>
                            <div class="col-sm-8">
                                <input type="radio" name="status_lulus" class="" value="0"> Belum
                                <?php echo nbs(3) ?>
                                <input type="radio" name="status_lulus" class="" value="1"> Sudah
                            </div>
                        </div>                                   
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
        <div class="card card-default rounded-0">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-graduation-cap"></i> Berkas Riwayat Pendidikan</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-left">No. Dokumen</th>
                            <th class="text-left">Pendidikan</th>
                            <th class="text-center">Thn Masuk</th>
                            <th class="text-center">Thn Lulus</th>
                            <th class="text-left">Berkas</th>
                            <th class="text-center">#</th>
                        </tr>                                    
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($sql_kary_pend as $pend) { ?>
                            <?php
                            $is_image = substr($pend->file_type, 0, 5);
                            $filename = base_url('file/karyawan/' . $pend->id_karyawan . '/' . $pend->file_name);
                            $foto = (file_exists($filename) ? base_url('file/karyawan/' . $pend->id_karyawan . '/' . $pend->file_name) : '');
                            ?>
                            <tr>
                                <td class="text-center" style="width:30px;"><?php echo $no; ?></td>
                                <td class="text-left" style="width:160px;"><?php echo $pend->no_dok; ?></td>
                                <td class="text-left" style="width:250px;">
                                    <?php echo $pend->instansi; ?><br/>
                                    <small><?php echo $pend->pendidikan; ?></small><br/>
                                    <small><i><?php echo $pend->jurusan; ?></i></small><br/>
                                </td>
                                <td class="text-center" style="width:100px;"><?php echo ($pend->thn_masuk != '0000' ? $pend->thn_masuk : ''); ?></td>
                                <td class="text-center" style="width:150px;"><?php echo ($pend->thn_keluar != '0000' ? $pend->thn_keluar : ''); ?></td>
                                <td class="text-left" style="width:400px;">
                                    <?php if ($is_image == 'image') { ?>
                                        <a href="<?php echo $filename ?>" data-toggle="lightbox" data-title="<?php echo strtolower($pend->judul . ' - ' . $sql_pasien->nama_pgl) ?>">
                                            <i class="fas fa-paperclip"></i> <?php echo $pend->file_name; ?>
                                        </a>
                                    <?php } else { ?>
                                        <a href="<?php echo $filename ?>" target="_blank">
                                            <i class="fas fa-paperclip"></i> <?php echo $pend->file_name; ?>
                                        </a>
                                    <?php } ?>
                                </td>
                                <td class="text-left" style="width:70px;">
                                    <?php echo anchor(base_url('master/set_karyawan_hapus_pend.php?id=' . general::enkrip($pend->id) . '&id_karyawan=' . general::enkrip($sql_kary->id) . (!empty($pend->file_name) ? '&file_name=' . $pend->file_name : '').'&route=profile.php?page=profile_pend'), '<i class="fa fa-trash"></i>', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus Berkas [' . $pend->no_dok . '] ?\')"') ?>
                                </td>
                            </tr>
                            <?php $no++ ?>
                        <?php } ?>
                    </tbody>
                </table>                            
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6 text-right">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Ekko Lightbox -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/ekko-lightbox/ekko-lightbox.min.js') ?>"></script>

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });

        $("input[id=thn]").keydown(function (e) {
            // kibot: backspace, delete, tab, escape, enter .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                    // kibot: Ctrl+A, Command+A
                            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // kibot: home, end, left, right, down, up
                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // Biarin wae, ga ngapa2in return false
                        return;
                    }

                    // Cuman nomor
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });

<?php echo $this->session->flashdata('master_toast'); ?>
    });
</script>