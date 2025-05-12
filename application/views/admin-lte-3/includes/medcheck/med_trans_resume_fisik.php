<?php // echo form_open_multipart(base_url('medcheck/set_medcheck_resm_upd.php'), 'autocomplete="off"')    ?>
<?php echo form_hidden('id', general::enkrip($sql_medc->id)); ?>
<?php echo form_hidden('id_resume', general::enkrip($sql_medc_resm_rw->id)); ?>
<?php echo form_hidden('route', $this->input->get('route')); ?>
<?php echo form_hidden('status', $this->input->get('status')); ?>

<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">FORM PEMERIKSAAN FISIK - <?php echo $sql_pasien->nama_pgl; ?>
            <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
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
                    <div class="tab-pane text-left fade show active" id="tab-pemeriksaan" role="tabpanel"
                        aria-labelledby="vert-tabs-home-tab">
                        <?php if (akses::hakSA() == TRUE or akses::hakOwner() == TRUE or akses::hakOwner2() == TRUE or akses::hakDokter() == TRUE or akses::hakPerawat() == TRUE or akses::hakAnalis() == TRUE) { ?>
                            <?php // if ($sql_medc->status < 5) { ?>
                            <a href="<?php echo base_url('medcheck/set_medcheck_ass_fisik.php?act=' . $this->input->get('act') . '&id=' . general::enkrip($sql_medc->id) . '&status=' . $this->input->get('status')) ?>"
                                class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Assesment</a>
                            <?php // } ?>
                        <?php } ?>
                        <?php echo br(2) ?>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Tgl Masuk</th>
                                    <th class="text-left">No Sampel</th>
                                    <th class="text-left">Petugas</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($sql_medc_ass->result() as $asses) { ?>
                                    <tr>
                                        <td class="text-center" style="width: 50px;">
                                            <?php if ($sql_medc->status < 5) { ?>
                                                <?php if (akses::hakSA() == TRUE or akses::hakOwner() == TRUE or akses::hakOwner2() == TRUE or akses::hakAdminM() == TRUE) { ?>
                                                    <?php echo anchor(base_url('medcheck/ass_fisik/hapus.php?act=' . $this->input->get('act') . '&id=' . $this->input->get('id') . '&item_id=' . general::enkrip($asses->id) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i>', 'class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus [' . $asses->no_resep . '] ?\')"') ?>
                                                <?php } else { ?>
                                                    <?php if ($asses->id_user == $this->ion_auth->user()->row()->id) { ?>
                                                        <?php echo anchor(base_url('medcheck/ass_fisik/hapus.php?act=' . $this->input->get('act') . '&id=' . $this->input->get('id') . '&item_id=' . general::enkrip($asses->id) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i>', 'class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus [' . $asses->no_resep . '] ?\')"') ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </td>
                                        <td class="text-center" style="width: 50px;"><?php echo $no; ?></td>
                                        <td class="text-left" style="width: 50px;">
                                            <?php echo $this->tanggalan->tgl_indo2($asses->tgl_simpan); ?></td>
                                        <td class="text-left" style="width: 50px;">
                                            <?php echo $asses->no_sample; ?>
                                        </td>
                                        <td class="text-left" style="width: 100px;">
                                            <?php echo $this->ion_auth->user($asses->id_farmasi)->row()->first_name; ?></td>
                                        <td class="text-left" style="width: 90px;">
                                            <?php if (akses::hakSA() == TRUE or akses::hakOwner() == TRUE or akses::hakOwner2() == TRUE or akses::hakFarmasi() == TRUE or akses::hakDokter() == TRUE or akses::hakPerawat() == TRUE or akses::hakAnalis() == TRUE) { ?>
                                                <?php echo anchor(base_url('medcheck/tambah.php?act=ass_surat&id=' . general::enkrip($sql_medc->id) . '&id_ass=' . general::enkrip($asses->id) . '&status=15'), 'Sample &raquo;', 'class="btn btn-success btn-flat btn-xs text-bold" style="width: 70px;"') ?>
                                                <?php if ($asses->status == 1): ?>
                                                    <?php echo anchor(base_url('medcheck/tambah.php?act=ass_fisik&id=' . general::enkrip($sql_medc->id) . '&id_ass=' . general::enkrip($asses->id) . '&status=15'), 'Input &raquo;', 'class="btn btn-success btn-flat btn-xs text-bold" style="width: 70px;"') ?>
                                                    <?php echo anchor(base_url('medcheck/set_medcheck_ass_fisik_cetak.php?id=' . general::enkrip($sql_medc->id) . '&id_ass=' . general::enkrip($asses->id) . '&status=15'), 'Cetak &raquo;', 'class="btn btn-success btn-flat btn-xs text-bold" style="width: 70px;"') ?>
                                                <?php endif; ?>
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
                <button type="button" class="btn btn-primary btn-flat"
                    onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&status=' . $this->input->get('status')) ?>'"><i
                        class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">

            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>