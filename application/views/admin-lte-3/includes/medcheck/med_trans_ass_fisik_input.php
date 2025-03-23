<?php echo form_open(base_url('medcheck/set_medcheck_ass_fisik_hsl.php'), 'autocomplete="off"') ?>
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
                            <div class="col-md-12"><h5 class="card-title text-bold">A. Riwayat Kesehatan Pribadi</h5></div>
                            <div class="col-md-6">
                                <?php foreach ($sql_ass_kiri->result() as $ass_kiri) { ?>
                                    <?php $sql_ck_kiri = $this->db->where('id_medcheck', $sql_medc->id)->where('id_medcheck_ass', general::dekrip($this->input->get('id_ass')))->where('id_item', $ass_kiri->id)->where('tipe', '1')->get('tbl_trans_medcheck_ass_fisik_hsl')->row(); ?>
                                    <?php echo form_checkbox(array('id' => '', 'name' => 'rk[' . $ass_kiri->id . ']', 'value' => '1', 'checked' => ($sql_ck_kiri->item_value == 1 ? 'true' : ''))) . nbs(2) .'<small>'. $ass_kiri->penyakit.'</small>' . br() ?>
                                <?php } ?>
                            </div>
                            <div class="col-md-6">
                                <?php foreach ($sql_ass_kanan->result() as $ass_kanan) { ?>
                                    <?php $sql_ck_kanan = $this->db->where('id_medcheck', $sql_medc->id)->where('id_medcheck_ass', general::dekrip($this->input->get('id_ass')))->where('id_item', $ass_kanan->id)->where('tipe', '1')->get('tbl_trans_medcheck_ass_fisik_hsl')->row(); ?>
                                    <?php echo form_checkbox(array('id' => '', 'name' => 'rk[' . $ass_kanan->id . ']', 'value' => '1', 'checked' => ($sql_ck_kanan->item_value == 1 ? 'true' : ''))) . nbs(2) .'<small>'. $ass_kanan->penyakit.'</small>' . br() ?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <br/>
                                <table class="table table-borderless">
                                    <?php foreach ($sql_ass_riw1->result() as $ass_riw1) { ?>
                                    <?php $sql_ck = $this->db->where('id_medcheck', $sql_medc->id)->where('id_medcheck_ass', general::dekrip($this->input->get('id_ass')))->where('id_item', $ass_riw1->id)->where('tipe', '15')->get('tbl_trans_medcheck_ass_fisik_hsl')->row(); ?>
                                        <tr>
                                            <td style="width: 175px;" class="text-left"><small><?php echo $ass_riw1->penyakit ?></small></td>
                                            <td style="width: 150px;" class="text-left"><?php echo form_input(array('id' => '', 'name' => 'riw1_jwb[' . $ass_riw1->id . ']', 'class' => 'form-control input-sm rounded-0', 'value' => $sql_ck->item_value2)) ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Kebiasaan sehari-hari</th>
                                            <th></th>
                                            <th>Jelaskan</th>
                                        </tr>
                                    </thead>
                                    <?php foreach ($sql_ass_riw2->result() as $ass_riw2) { ?>
                                    <?php $sql_ck2 = $this->db->where('id_medcheck', $sql_medc->id)->where('id_medcheck_ass', general::dekrip($this->input->get('id_ass')))->where('id_item', $ass_riw2->id)->where('tipe', '16')->get('tbl_trans_medcheck_ass_fisik_hsl')->row(); ?>
                                        <tr>
                                            <td style="width: 175px;" class="text-left"><small><?php echo $ass_riw2->penyakit ?></small></td>
                                            <td style="width: 10px;" class="text-center"><?php echo form_checkbox(array('id' => '', 'name' => 'riw2[' . $ass_riw2->id . ']', 'value' => '1', 'checked' => ($sql_ck2->item_value == 1 ? 'true' : ''))) ?></td>
                                            <td style="width: 150px;" class="text-left"><?php echo form_input(array('id' => '', 'name' => 'riw2_jwb[' . $ass_riw2->id . ']', 'class' => 'form-control input-sm rounded-0', 'value' => $sql_ck2->item_value2)) ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
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
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Lanjut &raquo;</button>
            </div>
        </div>                            
    </div>
</div>
<?php echo form_close() ?>
<!-- Page script -->
<script type="text/javascript">
    $(function () {
<?php // echo $this->session->flashdata('medcheck_toast');   ?>
    });
</script>
