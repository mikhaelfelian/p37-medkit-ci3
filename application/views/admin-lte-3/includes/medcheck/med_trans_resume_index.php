<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">RESUME - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-4 col-sm-3">
                <div class="nav flex-column nav-tabs h-100" id="" role="" aria-orientation="vertical">
                    <?php $this->load->view('admin-lte-3/includes/medcheck/med_trans_resume_sidetab') ?>
                </div>
            </div>
            <div class="col-7 col-sm-9">
                <div class="tab-content" id="vert-tabs-tabContent">
                    <div class="tab-pane text-left fade show active" id="tab-pemeriksaan" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                        <a href="<?php echo base_url('medcheck/set_medcheck_resm.php?id=' . general::enkrip($sql_medc->id) . '&status=' . $this->input->get('status')) ?>" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Buat Resume</a>
                        <?php echo br(2) ?>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Tgl Masuk</th>
                                    <th class="text-left" colspan="2">No. Surat</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $grup = $this->ion_auth->get_users_groups()->row(); ?>
                                <?php $user = $this->ion_auth->user()->row(); ?>
                                <?php $no = 1; ?>
                                <?php foreach ($sql_medc_rsm->result() as $rsm) { ?>
                                    <?php $sql_res_cek = $this->db->where('id_resume', $rsm->id)->get('tbl_trans_medcheck_resume_det'); ?>
                                    <tr>
                                        <td class="text-center" style="width: 50px;">                    
                                            <?php if ($sql_res_cek->num_rows() == 0) { ?>
                                                <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE) { ?>
                                                    <?php echo anchor(base_url('medcheck/resume/hapus.php?id=' . $this->input->get('id') . '&item_id=' . general::enkrip($rsm->id) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i>', 'class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus [' . $rsm->no_surat . '] ?\')"') ?>
                                                <?php } elseif ($rsm->id_user == $user->id) { ?>
                                                    <?php echo anchor(base_url('medcheck/resume/hapus.php?id=' . $this->input->get('id') . '&item_id=' . general::enkrip($rsm->id) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i>', 'class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus [' . $rsm->no_surat . '] ?\')"') ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </td>
                                        <td class="text-center" style="width: 50px;"><?php echo $no; ?>.</td>
                                        <td class="text-left" style="width: 50px;"><?php echo $this->tanggalan->tgl_indo5($rsm->tgl_masuk); ?></td>
                                        <td class="text-left" style="width: 50px;" colspan="2">
                                            <?php echo $rsm->no_surat; ?>
                                            <?php echo br(); ?>
                                            <small><?php echo $this->ion_auth->user($rsm->id_user)->row()->first_name; ?></small>
                                        </td>
                                        <td class="text-left" style="width: 90px;">
                                            <?php echo anchor(base_url('medcheck/tambah.php?act=resm_surat&id=' . general::enkrip($sql_medc->id) . '&id_resm=' . general::enkrip($rsm->id) . '&status=' . $this->input->get('status') . '&route=' . $this->input->get('route')), 'Surat &raquo;', 'class="btn btn-success btn-flat btn-xs text-bold" style="width: 70px;"') ?>
                                            <?php echo anchor(base_url('medcheck/tambah.php?act=' . ($sql_medc->tipe == '3' ? 'resm_input_rnp' : 'resm_input') . '&id=' . general::enkrip($sql_medc->id) . '&id_resm=' . general::enkrip($rsm->id) . '&status=' . $this->input->get('status') . '&route=' . $this->input->get('route')), 'Input &raquo;', 'class="btn btn-warning btn-flat btn-xs text-bold" style="width: 70px;"') ?>
                                            <?php if ($sql_medc->tipe == '3') { ?>
                                                <?php if($rsm->status == 2): ?>
                                                    <?php echo anchor(base_url('medcheck/set_medcheck_resm_ctk.php?id=' . $this->input->get('id') . '&id_resm=' . general::enkrip($rsm->id)), 'Cetak &raquo;', 'class="btn btn-primary btn-flat btn-xs text-bold" target="_blank" style="width: 70px;"') ?>
                                                <?php endif; ?>
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
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">

            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>