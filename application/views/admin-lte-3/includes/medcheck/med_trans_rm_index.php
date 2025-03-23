<div class="card">
    <div class="card-header">
        <h3 class="card-title">REKAM MEDIS RAWAT INAP - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">        
        <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakDokter() == TRUE OR akses::hakPerawat() == TRUE OR akses::hakDokter() == TRUE OR akses::hakFisioterapi() == TRUE) { ?>
            <a href="<?php echo base_url('medcheck/tambah.php?act=rm_input&id=' . general::enkrip($sql_medc->id) . '&status=' . $this->input->get('status')) ?>" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Follow Up</a>
        <?php } ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <!--<th class="text-left">Anamnesis</th>-->
                    <th class="text-left">Pemeriksaan</th>
                    <!--<th class="text-left">Diagnosa</th>-->
                    <th class="text-left">Terapi</th>
                    <!--<th class="text-left">Program</th>-->
                    <th class="text-center"></th>
                </tr>                                    
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($sql_medc_rm as $det) { ?>
                    <tr>
                        <td class="text-left" colspan="6">                            
                            <small><?php echo $this->tanggalan->tgl_indo2($det->tgl_simpan) . ' ' . $this->tanggalan->wkt_indo($det->tgl_simpan) . ' - '; ?><i><?php echo $this->ion_auth->user($det->id_user)->row()->first_name ?></i></small>                            
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left" style="width: 180px;">
                            <p><?php echo nl2br(html_entity_decode($det->pemeriksaan)); ?></p>
                            <p>
                                <small>
                                    <b>Suhu :</b> <?php echo (float)$det->ttv_st ?> &deg;C<br/>
                                    <b>TB :</b> <?php echo (float)$det->ttv_tb ?> Cm<br/>
                                    <b>BB :</b> <?php echo (float)$det->ttv_bb ?> Kg<br/>
                                    <b>Nadi :</b> <?php echo (float)$det->ttv_nadi ?> / Menit<br/>
                                    <b>Sistole :</b> <?php echo (float)$det->ttv_sistole ?> mmHg<br/>
                                    <b>Diastole :</b> <?php echo (float)$det->ttv_diastole ?> mmHg<br/>
                                    <b>Laju Nafas :</b> <?php echo (float)$det->ttv_laju ?> / Menit<br/>
                                    <b>Saturasi :</b> <?php echo (float)$det->ttv_saturasi ?> %<br/>
                                    <b>Skala Nyeri :</b> <?php echo (float)$det->ttv_skala ?><br/>
                                </small>
                            </p>
                        </td>
                        <td class="text-left" style="width: 350px;">
                            <p><?php echo nl2br(html_entity_decode($det->terapi)); ?></p>
                        </td>
                        <td class="text-left" style="width: 10px;">
                            <?php echo anchor(base_url('medcheck/tambah.php?act=rm_detail&id=' . $this->input->get('id') . '&status=' . $this->input->get('status') . '&id_item=' . general::enkrip($det->id) . '&route=medcheck/tambah.php?id=' . $this->input->get('id')), '<i class="fa fa-eye-slash"></i> Lihat', 'class="btn btn-info btn-flat btn-xs" style="width: 60px;"') ?>
                            <?php if ($det->id_user == $this->ion_auth->user()->row()->id) { ?>
                                <?php echo anchor(base_url('medcheck/tambah.php?act=rm_ubah&id=' . $this->input->get('id') . '&status=' . $this->input->get('status') . '&id_item=' . general::enkrip($det->id) . '&route=medcheck/tambah.php?id=' . $this->input->get('id')), '<i class="fa fa-edit"></i> Ubah', 'class="btn btn-warning btn-flat btn-xs" style="width: 60px;"') ?>
                                <?php echo anchor(base_url('medcheck/cart_medcheck_rm_hps.php?id=' . general::enkrip($sql_medc->id) . '&id_item=' . general::enkrip($det->id) . '&status=' . $this->input->get('status')), '<i class="fa fa-trash"></i> Hapus', 'class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Hapus ?\')" style="width: 60px;"') ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php $no++; ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat" onclick="window.location.href = '<?php echo base_url('medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id) . '&status=' . $this->input->get('status')) ?>'"><i class="fas fa-arrow-left"></i> Kembali</button>
            </div>
            <div class="col-lg-6 text-right">                                 

            </div>
        </div>                            
    </div>
</div>