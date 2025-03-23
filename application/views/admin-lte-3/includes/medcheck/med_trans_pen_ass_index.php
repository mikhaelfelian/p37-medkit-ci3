<div class="card">
    <div class="card-header">
        <h3 class="card-title">PEMERIKSAAN PENUNJANG - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-4 col-sm-3">
                <div class="nav flex-column nav-tabs h-100" id="" role="" aria-orientation="vertical">
                    <?php $this->load->view('admin-lte-3/includes/medcheck/med_trans_pen_sidebar') ?>
                </div>
            </div>
            <div class="col-7 col-sm-9">
                <div class="tab-content" id="vert-tabs-tabContent">
                    <div class="tab-pane text-left fade show active" id="tab-pemeriksaan" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                        <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakDokter() == TRUE OR akses::hakPerawat() == TRUE OR akses::hakAnalis() == TRUE) { ?>
                            <?php // if ($sql_medc->status < 5) { ?>
                            <a href="<?php echo base_url('medcheck/set_medcheck_ass_fisik.php?id=' . general::enkrip($sql_medc->id) . '&status=' . $this->input->get('status')) ?>" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Assesment</a><?php echo br(2) ?>
                            <?php // } ?>
                        <?php } ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">No.</th>
                                    <th class="text-left">Keterangan</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($sql_medc_ass->result() as $asses) { ?>
                                    <tr>
                                        <td class="text-center" style="width: 50px;">
                                            <?php if ($sql_medc->status < 5) { ?>
                                                <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE) { ?>
                                                    <?php echo anchor(base_url('medcheck/ass_fisik/hapus.php?id=' . $this->input->get('id') . '&item_id=' . general::enkrip($asses->id) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i>', 'class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus [' . $asses->no_resep . '] ?\')"') ?>
                                                <?php } else { ?>
                                                    <?php if ($asses->id_user == $this->ion_auth->user()->row()->id) { ?>
                                                        <?php echo anchor(base_url('medcheck/ass_fisik/hapus.php?id=' . $this->input->get('id') . '&item_id=' . general::enkrip($asses->id) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i>', 'class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus [' . $asses->no_resep . '] ?\')"') ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </td>
                                        <td class="text-center" style="width: 50px;"><?php echo $no; ?></td>
                                        <td class="text-left" style="width: 400px;">
                                            <?php echo $this->tanggalan->tgl_indo2($asses->tgl_simpan).br(); ?>
                                            <?php echo (!empty($asses->no_sample) ? '<b>'.$asses->no_sample.'</b>'.br() : ''); ?>
                                            <?php echo (!empty($this->ion_auth->user($asses->id_farmasi)->row()->first_name) ? '<small><i>'.$this->ion_auth->user($asses->id_farmasi)->row()->first_name.'</i></small>' : ''); ?>
                                        </td>
                                        <td class="text-left" style="width: 90px;">
                                            <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakFarmasi() == TRUE OR akses::hakDokter() == TRUE OR akses::hakPerawat() == TRUE OR akses::hakAnalis() == TRUE) { ?>
                                                <?php echo anchor(base_url('medcheck/tambah.php?act=pen_ass_surat&id=' . general::enkrip($sql_medc->id) . '&id_ass=' . general::enkrip($asses->id) . '&status=' . $this->input->get('status')), 'Sample &raquo;', 'class="btn btn-success btn-flat btn-xs text-bold" style="width: 70px;"') ?>
                                                <?php echo anchor(base_url('medcheck/tambah.php?act=ass_fisik&id=' . general::enkrip($sql_medc->id) . '&id_ass=' . general::enkrip($asses->id) . '&status=15'), 'Input &raquo;', 'class="btn btn-success btn-flat btn-xs text-bold" style="width: 70px;"') ?>
                                                <?php echo anchor(base_url('medcheck/surat/cetak_pdf_ass_fisik.php?id=' . general::enkrip($sql_medc->id) . '&id_ass=' . general::enkrip($asses->id) . '&status=' . $this->input->get('status')), 'Cetak &raquo;', 'class="btn btn-success btn-flat btn-xs text-bold" style="width: 70px;"') ?>
                                                <?php echo br() ?>
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
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">

            </div>
        </div>                            
    </div>
</div>