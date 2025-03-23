<?php $hasError = $this->session->flashdata('form_error'); ?>
<div class="row">
    <div class="col-md-10">
        <?php // echo form_open_multipart(base_url('master/set_karyawan_'.(!empty($sql_kary_kel_rw) ? 'update' : 'simpan').'_kel.php'), 'autocomplete="off"') ?>
        <?php echo form_open_multipart(base_url('master/set_karyawan_simpan_kel.php'), 'autocomplete="off"') ?>
        <?php echo form_hidden('id', general::enkrip($sql_kary->id)); ?>
        <?php echo form_hidden('id_kel', general::enkrip($sql_kary_kel_rw->id)); ?>
        <?php echo form_hidden('status', '8'); ?>
        <?php echo form_hidden('route', 'profile.php?page=profile_kel'); ?>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">DATA KELUARGA - <?php echo (!empty($sql_kary->nama_dpn) ? $sql_kary->nama_dpn . ' ' : '') . $sql_kary->nama . (!empty($sql_kary->nama_blk) ? ', ' . $sql_kary->nama_blk : ''); ?></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row <?php echo (!empty($hasError['nm_ayah']) ? 'text-danger' : '') ?>">
                            <label for="label" class="col-sm-4 col-form-label">Nama Ayah <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <?php echo form_input(array('id' => '', 'name' => 'nm_ayah', 'class' => 'form-control rounded-0' . (!empty($hasError['nm_ayah']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Nama Ayah ...', 'value' => $sql_kary_kel_rw->nm_ayah)) ?>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($hasError['tgl_lhr_ayah']) ? 'text-danger' : '') ?>">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Tgl Lahir</label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                    <?php echo form_input(array('id' => 'tgl_lhr_ayah', 'name' => 'tgl_lhr_ayah', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['tgl_lhr_ayah']) ? ' is-invalid' : ''), 'placeholder' => 'Inputkan Tgl Lahir Ayah ...', 'value' => $sql_kary_kel_rw->tgl_lhr_ayah, 'readonly' => 'TRUE')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="label" class="col-sm-4 col-form-label">Pernikahan</label>
                            <div class="col-sm-8">
                                <select id="tipe" name="status_kawin" class="form-control rounded-0">
                                    <option value="">- Pilih -</option>
                                    <option value="1" <?php echo ($sql_kary_kel_rw->status_kawin == '1' ? 'selected' : '') ?>>Belum Menikah</option>
                                    <option value="2" <?php echo ($sql_kary_kel_rw->status_kawin == '2' ? 'selected' : '') ?>>Sudah Menikah</option>
                                    <option value="3" <?php echo ($sql_kary_kel_rw->status_kawin == '3' ? 'selected' : '') ?>>Cerai</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="label" class="col-sm-4 col-form-label">Pasangan</label>
                            <div class="col-sm-8">
                                <select id="tipe" name="jns_pasangan" class="form-control rounded-0">
                                    <option value="">- Pilih -</option>
                                    <option value="1" <?php echo ($sql_kary_kel_rw->jns_pasangan == '1' ? 'selected' : '') ?>>Suami</option>
                                    <option value="2" <?php echo ($sql_kary_kel_rw->jns_pasangan == '2' ? 'selected' : '') ?>>Istri</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($hasError['fupload']) ? 'text-danger' : '') ?>" id="tp_berkas">
                            <label for="label" class="col-sm-4 col-form-label">Unggah Berkas KK*</label>
                            <div class="col-sm-8 text-left">
                                <?php echo form_upload(array('name' => 'fupload', 'class' => 'form-control rounded-0' . (!empty($hasError['fupload']) ? ' is-invalid' : ''))) ?><?php echo br() ?>
                                <i>* File yang diijinkan : jpg|png|pdf|jpeg|jfif</i><?php echo br() ?>
                                <i>* Dokumen yg diunggah : KK</i><?php echo br() ?>
                            </div>
                        </div>
                        <!--
                        <div class="form-group row <?php echo (!empty($hasError['fupload_ktp']) ? 'text-danger' : '') ?>" id="tp_berkas">
                            <label for="label" class="col-sm-4 col-form-label">Unggah Berkas KTP*</label>
                            <div class="col-sm-8 text-left">
                                <?php echo form_upload(array('name' => 'fupload_ktp', 'class' => 'form-control rounded-0' . (!empty($hasError['fupload']) ? ' is-invalid' : ''))) ?><?php echo br() ?>
                                <i>* File yang diijinkan : jpg|png|pdf|jpeg|jfif</i><?php echo br() ?>
                                <i>* Dokumen yg diunggah : KTP</i><?php echo br() ?>
                            </div>
                        </div>
                        -->
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <?php echo $this->session->flashdata('medcheck') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row <?php echo (!empty($hasError['nm_ibu']) ? 'text-danger' : '') ?>">
                            <label for="label" class="col-sm-4 col-form-label">Nama Ibu <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <?php echo form_input(array('id' => '', 'name' => 'nm_ibu', 'class' => 'form-control rounded-0' . (!empty($hasError['nm_ibu']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Nama Ibu Kandung ...', 'value' => $sql_kary_kel_rw->nm_ibu)) ?>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($hasError['tgl_lhr_ibu']) ? 'text-danger' : '') ?>">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Tgl Lahir</label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                    <?php echo form_input(array('id' => 'tgl_lhr_ibu', 'name' => 'tgl_lhr_ibu', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['tgl_lhr_ibu']) ? ' is-invalid' : ''), 'placeholder' => 'Inputkan Tgl Lahir Ibu ...', 'value' => $sql_kary_kel_rw->tgl_lhr_ibu, 'readonly' => 'TRUE')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($hasError['pasangan']) ? 'text-danger' : '') ?>">
                            <label for="label" class="col-sm-4 col-form-label">Nama Pasangan</label>
                            <div class="col-sm-8">
                                <?php echo form_input(array('id' => '', 'name' => 'nm_pasangan', 'class' => 'form-control rounded-0' . (!empty($hasError['nm_pasangan']) ? ' is-invalid' : ''), 'placeholder' => 'Isikan Nama Pasangan ...', 'value' => $sql_kary_kel_rw->nm_pasangan)) ?>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($hasError['tgl_lhr_psg']) ? 'text-danger' : '') ?>">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Tgl Lahir</label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                    <?php echo form_input(array('id' => 'tgl_lhr_psg', 'name' => 'tgl_lhr_psg', 'class' => 'form-control pull-right rounded-0' . (!empty($hasError['tgl_lhr_psg']) ? ' is-invalid' : ''), 'placeholder' => 'Inputkan Tgl Lahir Pasangan ...', 'value' => (!empty($sql_kary_kel_rw->tgl_lhr_psg) ? $sql_kary_kel_rw->tgl_lhr_psg : ''), 'readonly' => 'TRUE')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($hasError['anak']) ? 'text-danger' : '') ?>">
                            <label for="label" class="col-sm-4 col-form-label">Nama Anak <br/><small><i>* Bisa dipisah menggunakan enter</i></small></label>
                            <div class="col-sm-8">
                                <?php echo form_textarea(array('name' => 'nm_anak', 'class' => 'form-control rounded-0', 'value' => $sql_kary_kel_rw->nm_anak)) ?>
                            </div>
                        </div>
                    </div>
                </div>                        
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-6">
                        <a class="btn btn-primary btn-flat" href="<?php echo base_url('profile.php?page=profile_kel&id=' . $this->input->get('id') . '&route=' . $this->input->get('route')) ?>">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
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
                <h3 class="card-title"><i class="fas fa-boxes-stacked"></i> Data Keluarga Karyawan</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-left">Karyawan</th>
                            <th class="text-left">Anak</th>
                            <th class="text-left">Berkas</th>
                            <th class="text-center">#</th>
                        </tr>                                    
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($sql_kary_kel as $kel) { ?>
                            <?php
                            $is_image   = substr($kel->file_type, 0, 5);
                            $is_image2  = substr($kel->file_type_ktp, 0, 5);
                            $filename   = base_url('file/karyawan/' . $kel->id_karyawan . '/' . $kel->file_name);
                            $filename2  = base_url('file/karyawan/' . $kel->id_karyawan . '/' . $kel->file_name_ktp);
                            $foto       = (file_exists($filename) ? base_url('file/karyawan/' . $kel->id_karyawan . '/' . $kel->file_name) : '');
                            $foto2      = (file_exists($filename2) ? base_url('file/karyawan/' . $kel->id_karyawan . '/' . $kel->file_name_ktp) : '');
                            ?>
                            <tr>
                                <td class="text-center" style="width:30px;"><?php echo $no; ?></td>
                                <td class="text-left" style="width:250px;">
                                    <?php echo $sql_kary->nama; ?><br/>
                                    <small><b>Nama Ayah :</b> <?php echo $kel->nm_ayah; ?></small><br/>
                                    <small><b>Tgl Lahir :</b> <i><?php echo ($kel->tgl_lhr_ayah != '0000-00-00' ? $this->tanggalan->tgl_indo8($kel->tgl_lhr_ayah) : ''); ?></i></small><br/>
                                    <small><b>Nama Ibu :</b> <?php echo $kel->nm_ibu; ?></small><br/>
                                    <small><b>Tgl Lahir :</b> <i><?php echo ($kel->tgl_lhr_ibu != '0000-00-00' ? $this->tanggalan->tgl_indo8($kel->tgl_lhr_ibu) : ''); ?></i></small><br/>
                                </td>
                                <td class="text-left"><?php echo nl2br($kel->nm_anak); ?></td>
                                <td class="text-left">
                                    <?php if ($is_image == 'image') { ?>
                                        <a href="<?php echo $filename ?>" data-toggle="lightbox" data-title="<?php echo strtolower($kel->judul . ' - ' . $sql_pasien->nama_pgl) ?>">
                                            <img src="<?php echo $filename ?>" alt="<?php echo strtolower($kel->judul . ' - ' . $sql_pasien->nama_pgl) ?>" style="width: 100px; height: 100px;">
                                        </a>
                                    <?php } else { ?>
                                        <a href="<?php echo $filename ?>" target="_blank">
                                            <i class="fas fa-paperclip"></i> <?php echo $kel->file_name ?>
                                        </a>
                                    <?php } ?>
                                    <?php if ($is_image2 == 'image') { ?>
                                        <hr/>
                                        <a href="<?php echo $filename2 ?>" data-toggle="lightbox" data-title="<?php echo strtolower($kel->judul . ' - ' . $sql_pasien->nama_pgl) ?>">
                                            <img src="<?php echo $filename2 ?>" alt="<?php echo strtolower($kel->judul . ' - ' . $sql_pasien->nama_pgl) ?>" style="width: 100px; height: 100px;">
                                        </a>
                                    <?php } else { ?>
                                        <hr/>
                                        <a href="<?php echo $filename_ktp ?>" target="_blank">
                                            <i class="fas fa-paperclip"></i> <?php echo $kel->file_name_ktp ?>
                                        </a>
                                    <?php } ?>
                                </td>
                                <td class="text-left" style="width:70px;">
                                    <?php echo anchor(base_url('profile.php?page=profile_kel&id='.general::enkrip($sql_kary->id).'&route=profile.php' . '&id_kel=' . general::enkrip($kel->id)), '<i class="fa fa-edit"></i> Ubah', 'class="btn btn-primary btn-flat btn-xs" style="width: 55px;"') ?>
                                    <?php // echo anchor(base_url('profile.php?page=profile_kel_kk&id='.general::enkrip($sql_kary->id).'&route=profile.php' . '&id_kel=' . general::enkrip($kel->id)), '<i class="fa fa-upload"></i> KK', 'class="btn btn-success btn-flat btn-xs" style="width: 55px;"') ?>
                                    <?php echo anchor(base_url('profile.php?page=profile_kel_ktp&id='.general::enkrip($sql_kary->id).'&route=profile.php' . '&id_kel=' . general::enkrip($kel->id)), '<i class="fa fa-upload"></i> KTP', 'class="btn btn-success btn-flat btn-xs" style="width: 55px;"') ?>
                                    <?php // echo anchor(base_url('profile.php?page=profile_kel_kk&id='.general::enkrip($sql_kary->id).'&route=profile.php' . '&id_kel=' . general::enkrip($kel->id)), '<i class="fa fa-edit"></i>', 'class="btn btn-danger btn-flat btn-xs" style="width: 55px;" onclick="return confirm(\'Hapus Berkas [' . $kel->no_dok . '] ?\')"') ?>
                                    
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

<!-- Select2 -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

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

        // Menampilkan Tanggal
        $("[id*='tgl']").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: '1920:<?php echo date('Y') ?>',
            autoclose: true
        });

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
<?php echo $this->session->flashdata('master_toast'); ?>
    });
</script>