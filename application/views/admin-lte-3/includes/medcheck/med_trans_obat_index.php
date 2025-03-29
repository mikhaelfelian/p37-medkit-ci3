<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">INSTALASI FARMASI - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakDokter() == TRUE OR akses::hakPerawat() == TRUE OR akses::hakFarmasi() == TRUE) { ?>
            <?php if ($sql_medc->status < 5) { ?>
                <a href="<?php echo base_url('medcheck/set_medcheck_resep.php?id=' . general::enkrip($sql_medc->id) . '&status=' . $this->input->get('status')) ?>" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Buat Resep</a>
            <?php } ?>
        <?php } ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">No.</th>
                    <th class="text-left">No Resep</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($sql_medc_res->result() as $resep) { ?>
                    <tr>
                        <td class="text-center" style="width: 50px;">
                            <?php if ($sql_medc->status < 5 && $resep->status != 4) { ?>
                                <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE) { ?>
                                    <?php echo anchor(base_url('medcheck/resep/hapus.php?id=' . $this->input->get('id') . '&item_id=' . general::enkrip($resep->id) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i>', 'class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus [' . $resep->no_resep . '] ?\')"') ?>
                                <?php } else { ?>
                                    <?php if ($resep->id_user == $this->ion_auth->user()->row()->id) { ?>
                                        <?php echo anchor(base_url('medcheck/resep/hapus.php?id=' . $this->input->get('id') . '&item_id=' . general::enkrip($resep->id) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i>', 'class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus [' . $resep->no_resep . '] ?\')"') ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </td>
                        <td class="text-center" style="width: 50px;"><?php echo $no; ?></td>
                        <td class="text-left" style="width: 350px;">
                            <small><i><?php echo $this->tanggalan->tgl_indo5($resep->tgl_simpan); ?></i></small><br/>
                            <?php echo anchor(base_url('medcheck/tambah.php?act=res_detail&id=' . general::enkrip($sql_medc->id) . '&id_resep=' . general::enkrip($resep->id) . '&status=' . $this->input->get('status')), $resep->no_resep); ?><br/>
                            <small><?php echo strtoupper($this->ion_auth->user($resep->id_farmasi)->row()->first_name); ?></small><br/>
                            <?php if($resep->status_plg == '1'){ ?>
                                <label class="badge badge-warning"><i class="far fa-check-circle"></i> Resep Pulang</label>
                            <?php } ?>
                        </td>
                        <td class="text-left" style="width: 100px;">
                            <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakFarmasi() == TRUE OR akses::hakDokter() == TRUE OR akses::hakPerawat() == TRUE) { ?>
                                <?php echo anchor(base_url('medcheck/tambah.php?act=res_input&id=' . general::enkrip($sql_medc->id) . '&id_resep=' . general::enkrip($resep->id) . '&status=' . $this->input->get('status')), 'Input &raquo;', 'class="btn btn-success btn-flat btn-xs text-bold" style="width: 70px;"') ?>
                                <?php echo br() ?>
                                <?php echo anchor(base_url('medcheck/resep/cetak_label_json.php?id=' . general::enkrip($sql_medc->id) . '&id_resep=' . general::enkrip($resep->id) . '&status=' . $this->input->get('status')), 'Label JS &raquo;', 'class="btn btn-primary btn-flat btn-xs text-bold" style="width: 70px;" target="_blank"') ?>
                                <?php echo br() ?>
                                <?php echo anchor(base_url('medcheck/resep/cetak_pdf.php?id=' . general::enkrip($sql_medc->id) . '&id_resep=' . general::enkrip($resep->id) . '&status=' . $this->input->get('status')), 'Resep &raquo;', 'class="btn btn-primary btn-flat btn-xs text-bold" style="width: 70px;" target="_blank"') ?>
                            <?php } ?>

                            <?php echo nbs(2) . general::status_resep($resep->status) ?>
                            
                            <!--
                            <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner() == TRUE) { ?>
                                <?php if ($resep->status == '0') { ?>
                                    <?php echo anchor(base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&id_resep=' . general::enkrip($resep->id) . '&status=' . $this->input->get('status')), '<i class="fas fa-eye"></i>', 'class="btn btn-primary btn-flat btn-xs"'); ?>
                                <?php } ?>
                            <?php } elseif (akses::hakDokter() == TRUE) { ?>
                                <?php echo anchor(base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&id_resep=' . general::enkrip($resep->id) . '&status=' . $this->input->get('status')), '<i class="fas fa-plus"></i> Input', 'class="btn btn-primary btn-flat btn-xs"'); ?>
                            <?php } elseif (akses::hakFarmasi() == TRUE) { ?>
                                <?php if ($resep->status == '1') { ?>
                                    <?php echo anchor(base_url('medcheck/set_medcheck_resep_stat.php?id=' . general::enkrip($sql_medc->id) . '&id_resep=' . general::enkrip($resep->id) . '&status=' . $this->input->get('status') . '&status_res=2'), '<i class="fas fa-solid fa-check"></i>', 'class="btn btn-success btn-flat btn-xs text-bold" style="width: 20px;"') ?>
                                    <?php echo anchor(base_url('medcheck/set_medcheck_resep_stat.php?id=' . general::enkrip($sql_medc->id) . '&id_resep=' . general::enkrip($resep->id) . '&status=' . $this->input->get('status') . '&status_res=4'), '<i class="fas fa-solid fa-xmark"></i>', 'class="btn btn-danger btn-flat btn-xs text-bold" style="width: 20px;"') ?>
                                <?php } elseif ($resep->status == '2') { ?>
                                    <?php echo anchor(base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&id_resep=' . general::enkrip($resep->id) . '&status=' . $this->input->get('status')), 'Input &raquo;', 'class="btn btn-success btn-flat btn-xs text-bold" style="width: 70px;"') ?>
                                <?php } ?>
                            <?php } ?>
                            -->
                            <?php // echo anchor(base_url('medcheck/tambah.php?id=' . general::enkrip($sql_medc->id) . '&id_resep=' . general::enkrip($resep->id) . '&status=' . $this->input->get('status')), '<i class="fas fa-eye"></i> Detail', 'class="btn btn-primary btn-flat btn-xs"'); ?>
                        </td>
                    </tr>
                    <?php $no++ ?>
                <?php } ?>
            </tbody>
        </table>
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
<!-- /.card -->