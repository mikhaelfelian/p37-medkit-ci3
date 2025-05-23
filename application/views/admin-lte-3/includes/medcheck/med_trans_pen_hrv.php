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
                                <a href="<?php echo base_url('medcheck/set_medcheck_pen_hrv.php?id=' . general::enkrip($sql_medc->id) . '&status=' . $this->input->get('status')) ?>" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> HRV</a><?php echo br(2) ?>
                            <?php // } ?>
                        <?php } ?>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">No.</th>
                                    <th class="text-left" colspan="2">Pemeriksaan</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $grup = $this->ion_auth->get_users_groups()->row(); ?>
                                <?php $no = 1; ?>
                                <?php foreach ($sql_medc_hrv->result() as $hrv) { ?>
                                    <tr>
                                        <td class="text-center" style="width: 50px;">
                                            <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE OR akses::hakAnalis() == TRUE OR akses::hakDokter() == TRUE) { ?>
                                                <?php echo anchor(base_url('medcheck/hrv/hapus.php?id=' . $this->input->get('id') . '&act=' . $this->input->get('act') . '&item_id=' . general::enkrip($hrv->id) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i>', 'class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus [' . $hrv->no_lab . '] ?\')"') ?>
                                            <?php } elseif ($hrv->id_analis == $this->ion_auth->user()->row()->id) { ?>
                                                <?php if ($sql_medc->status_bayar == '0') { ?>
                                                    <?php echo anchor(base_url('medcheck/hrv/hapus.php?id=' . $this->input->get('id') . '&item_id=' . general::enkrip($hrv->id) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i>', 'class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus [' . $hrv->no_lab . '] ?\')"') ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </td>
                                        <td class="text-center" style="width: 50px;"><?php echo $no; ?>.</td>
                                        <td class="text-left" style="width: 50px;" colspan="2">
                                            <?php echo $this->tanggalan->tgl_indo2($hrv->tgl_masuk); ?>
                                            <?php echo br(); ?>
                                            <?php echo $hrv->no_sample; ?>
                                            <?php echo br(); ?>
                                            <small><?php echo $this->ion_auth->user($hrv->id_analis)->row()->first_name; ?></small>
                                        </td>
                                        <td class="text-left" style="width: 90px;">
                                            <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAnalis() == TRUE OR akses::hakDokter() == TRUE OR akses::hakPerawat() == TRUE) { ?>
                                                <?php echo anchor(base_url('medcheck/tambah.php?act=pen_hrv_input&id=' . general::enkrip($sql_medc->id) . '&id_pen=' . general::enkrip($hrv->id) . '&status=' . $this->input->get('status')), 'Input &raquo;', 'class="btn btn-warning btn-flat btn-xs text-bold" style="width: 70px;"') ?>
                                                <?php if($hrv->status == 1) { ?>
                                                    <?php echo anchor(base_url('medcheck/set_medcheck_pen_hrv_cetak.php?id=' . general::enkrip($sql_medc->id) . '&id_pen=' . general::enkrip($hrv->id) . '&status=' . $this->input->get('status')), 'Cetak &raquo;', 'class="btn btn-primary btn-flat btn-xs text-bold" style="width: 70px;"') ?>
                                                <?php } ?>
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