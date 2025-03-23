<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">INSTALASI RADIOLOGI - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakDokter() == TRUE OR akses::hakPerawat() == TRUE OR akses::hakRad() == TRUE) { ?>
            <?php if ($sql_medc->status < 5) { ?>
                <a href="<?php echo base_url('medcheck/set_medcheck_rad.php?id=' . general::enkrip($sql_medc->id) . '&status=' . $this->input->get('status')) ?>" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Permintaan Rad</a>
            <?php } ?>
        <?php } ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">No.</th>
                    <th class="text-left" colspan="2">No. Sampel</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $grup = $this->ion_auth->get_users_groups()->row(); ?>
                <?php $no = 1; ?>
                <?php foreach ($sql_medc_rad->result() as $rad) { ?>
                    <?php $sql_rad_cek = $this->db->where('id_rad', $rad->id)->get('tbl_trans_medcheck_det'); ?>
                    <tr>
                        <td class="text-center" style="width: 50px;">                    
                            <?php if ($sql_rad_cek->num_rows() == 0) { ?>
                                <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakAdminM() == TRUE OR akses::hakAdmin() == TRUE OR akses::hakRad() == TRUE OR akses::hakDokter() == TRUE) { ?>
                                    <?php echo anchor(base_url('medcheck/rad/hapus.php?id=' . $this->input->get('id') . '&item_id=' . general::enkrip($rad->id) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i>', 'class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus [' . $rad->no_rad . '] ?\')"') ?>
                                <?php // } elseif ($rad->id_radiografer == $this->ion_auth->user()->row()->id) { ?>
                                    <?php // if ($sql_medc->status_bayar == '0') { ?>
                                        <?php // echo anchor(base_url('medcheck/rad/hapus.php?id=' . $this->input->get('id') . '&item_id=' . general::enkrip($rad->id) . '&status=' . $this->input->get('status')), '<i class="fas fa-trash"></i>', 'class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus [' . $rad->no_rad . '] ?\')"') ?>
                                    <?php // } ?>
                                <?php } ?>
                            <?php } ?>
                        </td>
                        <td class="text-center" style="width: 50px;"><?php echo $no; ?>.</td>
                        <td class="text-left" style="width: 50px;" colspan="2">
                            <small><i><?php echo $this->tanggalan->tgl_indo5($rad->tgl_masuk); ?></i></small><br/>
                            <?php echo $rad->no_sample; ?>
                            <?php echo br(); ?>
                            <small><?php echo strtoupper($this->ion_auth->user($rad->id_radiografer)->row()->first_name); ?></small>
                        </td>
                        <td class="text-left" style="width: 90px;">
                            <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakRad() == TRUE OR akses::hakDokter() == TRUE OR akses::hakPerawat() == TRUE) { ?>
                                <?php echo anchor(base_url('medcheck/tambah.php?act=rad_surat&id=' . general::enkrip($sql_medc->id) . '&id_rad=' . general::enkrip($rad->id) . '&status=' . $this->input->get('status').'&route='.$this->input->get('route')), 'Sample &raquo;', 'class="btn btn-success btn-flat btn-xs text-bold" style="width: 70px;"') ?>
                                
                                <?php if(!empty($rad->id_dokter)){ ?>
                                    <?php echo anchor(base_url('medcheck/tambah.php?act=rad_input&id=' . general::enkrip($sql_medc->id) . '&id_rad=' . general::enkrip($rad->id) . '&status=' . $this->input->get('status').'&route='.$this->input->get('route')), 'Input &raquo;', 'class="btn btn-warning btn-flat btn-xs text-bold" style="width: 70px;"') ?>
                                <?php } ?>
                            <?php } ?>
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
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url(!empty($_GET['route']) ? $this->input->get('route') : 'medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">
                
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>