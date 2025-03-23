<?php echo form_open(base_url('medcheck/set_medcheck_ass_fisik_hsl3.php'), 'autocomplete="off"') ?>
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
                            <div class="col-md-12"><h5 class="card-title text-bold">C. Pemeriksaan Fisik</h5></div>
                            <div class="col-md-12">
                                <br/>
                                <?php foreach ($sql_ass_fisik->result() as $ass_fisik) { ?>
                                    <?php $sql_ck = $this->db->where('id_medcheck', $sql_medc->id)->where('id_medcheck_ass', general::dekrip($this->input->get('id_ass')))->where('id_item', $ass_fisik->id)->where('tipe', '3')->get('tbl_trans_medcheck_ass_fisik_hsl')->row(); ?>
                                    <?php if ($ass_fisik->id != 37) { ?>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label"><small><?php echo $ass_fisik->penyakit ?></small></label>
                                            <div class="col-sm-4">
                                                <?php echo form_input(array('id' => '', 'name' => 'fs_jwb[' . $ass_fisik->id . ']', 'class' => 'form-control pull-right text-center rounded-0', 'value' => $sql_ck->item_value2, 'placeholder' => 'Isikan Hasil ...')) ?>
                                            </div>
                                            <div class="col-sm-3">
                                                <?php echo form_input(array('id' => '', 'name' => 'fs_sat[' . $ass_fisik->id . ']', 'class' => 'form-control pull-right text-left rounded-0', 'value' => $ass_fisik->satuan, 'placeholder' => 'Isikan LLN ...', 'disabled' => 'TRUE')) ?>
                                            </div>
                                        </div>
                                    <?php } ?>
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
<!-- Page script -->
<script type="text/javascript">
    $(function () {
<?php // echo $this->session->flashdata('medcheck_toast');       ?>
    });
</script>
