<?php echo form_open_multipart(base_url('medcheck/cart_medcheck_rad_file.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_rad', general::enkrip($sql_medc_rad_rw->id)); ?>
<?php echo form_hidden('id_item', general::enkrip($sql_medc_det_rw->id)); ?>
<?php echo form_hidden('id_produk', general::enkrip($sql_produk->id)); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?> 
<?php echo form_hidden('act', $this->input->get('act')); ?> 

<!--Default box--> 
<div class="card">
    <div class="card-header">
        <h3 class="card-title">INSTALASI RADIOLOGI - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">                    
                <?php $hasError = $this->session->flashdata('form_error'); ?>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Judul</label>
                    <div class="col-sm-9">
                        <?php echo form_input(array('id' => 'item_value', 'name' => 'judul', 'class' => 'form-control pull-left', 'placeholder' => 'Isikan Judul ...')) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">File</label>
                    <div class="col-sm-9">
                        <?php echo form_upload(array('id' => 'fupload', 'name' => 'fupload', 'class' => '', 'placeholder' => 'Hasil ...')) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <?php echo $this->session->flashdata('medcheck') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/.card-body--> 
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/tambah.php?act=rad_input&id=' . $this->input->get('id') . '&id_rad=' . $this->input->get('id_rad') . '&status=' . $this->input->get('status') . '&id_item=' . $this->input->get('id_item')) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">  
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
<!--/.card -->
<?php echo form_close(); ?>

<!--Default box--> 
<div class="card">
    <div class="card-header">
        <h3 class="card-title">LAMPIRAN RADIOLOGI</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-left">Judul</th>
                            <th class="text-left">File</th>
                            <th class="text-center">#</th>
                        </tr>                                    
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($sql_medc_rad_file as $rad_hasil) { ?>
                        <?php 
                            $sql_medc       = $this->db->where('id', $rad_hasil->id_medcheck)->get('tbl_trans_medcheck')->row();
                            $sql_pasien     = $this->db->where('id', $sql_medc->id_pasien)->get('tbl_m_pasien')->row();
                            $no_rm          = strtolower($sql_pasien->kode_dpn).$sql_pasien->kode;
                            $file           = (!empty($rad_hasil->file_name) ? realpath('./file/pasien/'.$no_rm.'/'.$rad_hasil->file_name) : '');
                            $foto           = (file_exists($file) ? base_url('/file/pasien/'.$no_rm.'/'.$rad_hasil->file_name) : $sql_pasien->file_base64);
                        ?>
                            <tr>
                                <td class="text-left" style="width: 160px;">
                                    <?php echo $rad_hasil->judul; ?>
                                </td>
                                <td class="text-left" style="width: 460px;">
                                    <a href="<?php echo $foto; ?>" data-toggle="lightbox" data-title="<?php echo $rad_hasil->judul; ?>">
                                        <?php echo $rad_hasil->file_name; ?>
                                    </a>                            
                                </td>
                                <td class="text-center">
                                    <?php echo anchor(base_url('medcheck/cart_medcheck_rad_file_hapus.php?act=' . $this->input->get('act') . '&id=' . $this->input->get('id') . '&id_rad=' . $this->input->get('id_rad') . '&status=' . $this->input->get('status') . '&id_item=' . $this->input->get('id_item') . '&id_produk=' . $this->input->get('id_produk') . '&file_id=' . general::enkrip($rad_hasil->id)), '<i class="fas fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $rad_hasil->item . '] ?\')" style="width: 65px;"') ?>
                                </td>
                            </tr>
                            <?php $no++; ?>
                        <?php } ?>
                        <?php if (!empty($sql_medc_lab_rw->ket)) { ?>
                            <tr>
                                <td></td>
                                <td colspan="6"><small><?php echo $sql_medc_lab_rw->ket ?></small></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--/.card -->


<!-- Ekko Lightbox -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/ekko-lightbox/ekko-lightbox.min.js') ?>"></script>
<!-- Page script -->
<script type="text/javascript">
                    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
                        event.preventDefault();
                        $(this).ekkoLightbox({
                            alwaysShowClose: true
                        });
                    });
</script>