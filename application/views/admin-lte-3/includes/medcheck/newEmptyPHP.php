
        <?php // if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakDokter() == TRUE OR akses::hakPerawat() == TRUE OR akses::hakAnalis() == TRUE) { ?>
            <a href="<?php echo base_url('medcheck/set_medcheck_resm.php?id=' . general::enkrip($sql_medc->id) . '&status=' . $this->input->get('status')) ?>" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Buat Resume</a>
        <?php // } ?>

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
                <?php foreach ($sql_medc_rsm->result() as $rad) { ?>
                    <?php $sql_res_cek = $this->db->where('id_resume', $rad->id)->get('tbl_trans_medcheck_resume_det'); ?>
                    <tr>
                        <td class="text-center" style="width: 50px;">                    
                            <?php if ($sql_res_cek->num_rows() == 0) { ?>
                                <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE) { ?>
                                    <?php echo anchor(base_url('medcheck/resume/hapus.php?id=' . $this->input->get('id') . '&item_id=' . general::enkrip($rad->id) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i>', 'class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus [' . $rad->no_surat . '] ?\')"') ?>
                                <?php }elseif($rad->id_user == $user->id){ ?>
                                    <?php echo anchor(base_url('medcheck/resume/hapus.php?id=' . $this->input->get('id') . '&item_id=' . general::enkrip($rad->id) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i>', 'class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus [' . $rad->no_surat . '] ?\')"') ?>
                                <?php } ?>
                            <?php } ?>
                        </td>
                        <td class="text-center" style="width: 50px;"><?php echo $no; ?>.</td>
                        <td class="text-left" style="width: 50px;"><?php echo $this->tanggalan->tgl_indo2($rad->tgl_masuk); ?></td>
                        <td class="text-left" style="width: 50px;" colspan="2">
                            <?php echo $rad->no_surat; ?>
                            <?php echo br(); ?>
                            <small><?php echo $this->ion_auth->user($rad->id_user)->row()->first_name; ?></small>
                        </td>
                        <td class="text-left" style="width: 90px;">
                            <?php // if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakRad() == TRUE OR akses::hakDokter() == TRUE OR akses::hakPerawat() == TRUE) { ?>
                                <?php echo anchor(base_url('medcheck/tambah.php?act=resm_surat&id=' . general::enkrip($sql_medc->id) . '&id_resm=' . general::enkrip($rad->id) . '&status=' . $this->input->get('status').'&route='.$this->input->get('route')), 'Surat &raquo;', 'class="btn btn-success btn-flat btn-xs text-bold" style="width: 70px;"') ?>
                                <?php echo anchor(base_url('medcheck/tambah.php?act='.($sql_medc->tipe == '3' ? 'resm_input_rnp' : 'resm_input').'&id=' . general::enkrip($sql_medc->id) . '&id_resm=' . general::enkrip($rad->id) . '&status=' . $this->input->get('status').'&route='.$this->input->get('route')), 'Input &raquo;', 'class="btn btn-warning btn-flat btn-xs text-bold" style="width: 70px;"') ?>
                            <?php if ($sql_medc->tipe == '3') { ?>
                                <?php // echo anchor(base_url('medcheck/tambah.php?act=resm_input_trp&id=' . general::enkrip($sql_medc->id) . '&id_resm=' . general::enkrip($rad->id) . '&status=' . $this->input->get('status').'&route='.$this->input->get('route')), 'Terapi &raquo;', 'class="btn btn-warning btn-flat btn-xs text-bold" style="width: 70px;"') ?>
                                <?php echo anchor(base_url('medcheck/set_medcheck_resm_ctk.php?id='.$this->input->get('id').'&id_resm='.general::enkrip($rad->id)), 'Cetak &raquo;', 'class="btn btn-primary btn-flat btn-xs text-bold" target="_blank" style="width: 70px;"') ?>
                                <?php // echo anchor(base_url('medcheck/surat/cetak_pdf_rsm_rnp.php?id='.$this->input->get('id').'&id_resm='.general::enkrip($rad->id)), 'Cetak &raquo;', 'class="btn btn-primary btn-flat btn-xs text-bold" target="_blank" style="width: 70px;"') ?>
                            <?php } ?>
                            <?php // } ?>
                        </td>
                    </tr>
                    <?php $no++ ?>
                <?php } ?>
            </tbody>
        </table>