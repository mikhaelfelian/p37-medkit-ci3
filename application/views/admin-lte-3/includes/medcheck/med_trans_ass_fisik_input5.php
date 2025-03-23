<?php echo form_open(base_url('medcheck/set_medcheck_ass_fisik_hsl5.php'), 'autocomplete="off"') ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_ass', $this->input->get('id_ass')); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>
<?php echo form_hidden('act', $this->input->get('act')); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">[FORM ASSESMENT] INSTALASI LABORATORIUM - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">        
        <div class="row">
            <div class="col-4 col-sm-3">
                <div class="nav flex-column nav-tabs h-100" id="" role="" aria-orientation="vertical">
                    <?php $this->load->view('admin-lte-3/includes/medcheck/med_trans_ass_sidebar') ?>
                </div>
            </div>
            <div class="col-7 col-sm-9">
                <div class="tab-content" id="vert-tabs-tabContent">
                    <div class="tab-pane text-left fade show active" id="tab-a" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                        <div class="row">
                            <div class="col-md-12"><h5 class="card-title text-bold">C. Pemeriksaan THT-KLT</h5></div>
                            <div class="col-md-6">
                                <br/>
                                <?php foreach ($sql_ass_tht_l->result() as $ass_thtl) { ?>
                                    <?php $sql_ckl = $this->db->where('id_medcheck', $sql_medc->id)->where('id_medcheck_ass', general::dekrip($this->input->get('id_ass')))->where('id_item', $ass_thtl->id)->where('tipe', '5')->get('tbl_trans_medcheck_ass_fisik_hsl')->row(); ?>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-6 col-form-label"><small><?php echo $ass_thtl->penyakit ?></small></label>
                                        <div class="col-sm-6">
                                            <?php echo form_input(array('id' => '', 'name' => 'tht_jwb[' . $ass_thtl->id . ']', 'class' => 'form-control pull-right text-center rounded-0', 'value' => $sql_ckl->item_value2, 'placeholder' => 'Isikan Hasil ...')) ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-6">
                                <br/>
                                <?php foreach ($sql_ass_tht_r->result() as $ass_thtr) { ?>
                                    <?php $sql_ckr = $this->db->where('id_medcheck', $sql_medc->id)->where('id_medcheck_ass', general::dekrip($this->input->get('id_ass')))->where('id_item', $ass_thtr->id)->where('tipe', '5')->get('tbl_trans_medcheck_ass_fisik_hsl')->row(); ?>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-6 col-form-label"><small><?php echo $ass_thtr->penyakit ?></small></label>
                                        <div class="col-sm-6">
                                            <?php echo form_input(array('id' => '', 'name' => 'tht_jwb[' . $ass_thtr->id . ']', 'class' => 'form-control pull-right text-center rounded-0', 'value' => $sql_ckr->item_value2, 'placeholder' => 'Isikan Hasil ...')) ?>
                                        </div>
                                    </div>
                                <?php } ?>
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
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tambah.php?act=resm_fisik&id=' . general::enkrip($sql_medc->id) . '&status=9') ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">                                 
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan &raquo;</button>
            </div>
        </div>                            
    </div>
</div>
<?php echo form_close() ?>

<?php if (!empty($sql_medc_lab_spr_dt)) { ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-microscope"></i> HASIL PEMBACAAN SPIROMETRI</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-center">Hasil</th>
                        <th class="text-center">Prediksi</th>
                        <th class="text-center">% Prediksi</th>
                        <th class="text-center">LLN</th>
                        <th class="text-center">#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sql_medc_lab_spr_dt as $ass_thtl) { ?>
                        <?php $sql_spiro = $this->db->where('id', $ass_thtl->id_lab_spiro_kat)->get('tbl_m_kategori_spiro')->row(); ?>

                        <tr>
                            <td style="width: 250px;" class="text-left"><?php echo $ass_thtl->item_name ?></td>
                            <td style="width: 200px;" class="text-center"><?php echo general::format_angka2($ass_thtl->item_value, 2) ?></td>
                            <td style="width: 150px;" class="text-center"><?php echo general::format_angka2($ass_thtl->item_value2, 2) ?></td>
                            <td style="width: 150px;" class="text-center"><?php echo general::format_angka2($ass_thtl->item_value3, 2) ?></td>
                            <td style="width: 150px;" class="text-center"><?php echo general::format_angka2($sql_spiro->jml_lln, 2) ?></td>
                            <td style="width: 150px;" class="text-center">
                                <?php echo anchor(base_url('medcheck/set_medcheck_lab_spr_hps_hsl.php?act=' . $this->input->get('act') . '&id=' . $this->input->get('id') . '&id_lab=' . $this->input->get('id_lab') . '&item_id=' . general::enkrip($ass_thtl->id) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus [' . $ass_thtl->item_name . '] ?\')" style="width: 65px;"') ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php echo br() ?>
            <div class="form-group">
                <label for="inputEmail3">Keterangan Hasil</label>
                <?php echo form_input(array('id' => '', 'name' => '', 'class' => 'form-control pull-left rounded-0', 'placeholder' => 'Isikan Keterangan Hasil, cth : Gangguan Restriktif  ...', 'value' => $sql_medc_lab_spr_rw->ket, 'disabled' => 'TRUE')) ?>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <div class="row">
                <div class="col-lg-6">
                </div>
                <div class="col-lg-6 text-right">                                 
                    <a href="<?php echo base_url('medcheck/surat/cetak_pdf_lab_spiro.php?id=' . $this->input->get('id') . '&status=' . $this->input->get('status') . '&id_lab=' . $this->input->get('id_lab')) ?>">
                        <button type="button" class="btn btn-primary btn-flat"><i class="fa fa-print"></i> Cetak</button>
                    </a>
                </div>
            </div>                            
        </div>
    </div>
<?php } ?>
<!-- Page script -->
<script type="text/javascript">
    $(function () {
<?php // echo $this->session->flashdata('medcheck_toast');      ?>
    });
</script>
