<?php if ($sql_medc->tipe != '6') { ?>
    <div class="card card-success card-outline rounded-0">
        <div class="card-body box-profile">
            <div class="post">
                <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE) { ?>
                    <strong><i class="far fa-file-alt mr-1"></i> KELUHAN :</strong>
                    <p><small><?php echo ($sql_medc->keluhan) ?></small></p>
                    <hr/>
                    <strong><i class="far fa-file-alt mr-1"></i> TTV :</strong>
                    <?php if(!empty($sql_medc->ttv)){ ?>
                        <p><small><?php echo $sql_medc->ttv ?></small></p>
                    <?php }else{ ?>
                        <table class="table table-sm">
                            <tr>
                                <td style="width: 75px;"><small>Suhu</small></td>
                                <td style="width: 10px;" class="text-center"><small>:</small></td>
                                <td style="width: 80px;"><small><?php echo $sql_medc->ttv_st ?> &deg;C</small></td>
                                <td style="width: 75px;"><small>BB</small></td>
                                <td style="width: 10px;" class="text-center"><small>:</small></td>
                                <td style="width: 80px;;"><small><?php echo $sql_medc->ttv_bb ?> Kg</small></td>
                            </tr>
                            <tr>
                                <td style="width: 75px;"><small>TB</small></td>
                                <td style="width: 10px;" class="text-center"><small>:</small></td>
                                <td style="width: 80px;"><small><?php echo $sql_medc->ttv_tb ?> Cm</small></td>
                                <td style="width: 75px;"><small>Nadi</small></td>
                                <td style="width: 10px;" class="text-center"><small>:</small></td>
                                <td style="width: 80px;"><small><?php echo $sql_medc->ttv_nadi ?> / Menit</small></td>
                            </tr>
                            <tr>
                                <td style="width: 75px;"><small>Sistole</small></td>
                                <td style="width: 10px;" class="text-center"><small>:</small></td>
                                <td style="width: 80px;"><small><?php echo $sql_medc->ttv_sistole ?> mmHg</small></td>
                                <td style="width: 75px;"><small>Diastole</small></td>
                                <td style="width: 10px;" class="text-center"><small>:</small></td>
                                <td style="width: 80px;;"><small><?php echo $sql_medc->ttv_diastole ?> mmHg</small></td>
                            </tr>
                            <tr>
                                <td style="width: 75px;"><small>Laju Nafas</small></td>
                                <td style="width: 10px;" class="text-center"><small>:</small></td>
                                <td style="width: 80px;"><small><?php echo $sql_medc->ttv_laju ?> / Menit</small></td>
                                <td style="width: 75px;"><small>Saturasi</small></td>
                                <td style="width: 10px;" class="text-center"><small>:</small></td>
                                <td style="width: 80px;"><small><?php echo $sql_medc->ttv_saturasi ?> %</small></td>
                            </tr>
                            <tr>
                                <td style="width: 75px;"><small>Nyeri</small></td>
                                <td style="width: 10px;" class="text-center"><small>:</small></td>
                                <td style="width: 80px;"><small><?php echo $sql_medc->ttv_skala ?></small></td>
                                <td style="width: 75px;"><small></small></td>
                                <td style="width: 10px;" class="text-center"><small></small></td>
                                <td style="width: 80px;"><small></small></td>
                            </tr>
                        </table>
                    <?php } ?>
                    <hr/>
                    <strong class="text-danger"><i class="far fa-file-alt mr-1"></i> Alergi :</strong>
                    <p class="text-danger"><small><?php echo ($sql_medc->alergi) ?></small></p>
                    <hr/>
                    <strong><i class="far fa-file-alt mr-1"></i> DIAGNOSA :</strong>
                    <p><small><?php echo ($sql_medc->diagnosa) ?></small></p>
                    <hr/>
                    <strong><i class="far fa-file-alt mr-1"></i> PROGRAM :</strong>
                    <p><small><?php echo ($sql_medc->program) ?></small></p>
                <?php } else { ?>
                    <strong><i class="far fa-file-alt mr-1"></i> KELUHAN :</strong>
                    <p><small><?php echo ($sql_medc->keluhan) ?></small></p>
                    <hr/>
                    <strong><i class="far fa-file-alt mr-1"></i> TTV :</strong>
                    <?php if(!empty($sql_medc->ttv)){ ?>
                        <p><small><?php echo $sql_medc->ttv ?></small></p>
                    <?php }else{ ?>
                        <table class="table table-sm">
                            <tr>
                                <td style="width: 75px;"><small>Suhu</small></td>
                                <td style="width: 10px;" class="text-center"><small>:</small></td>
                                <td style="width: 80px;"><small><?php echo $sql_medc->ttv_st ?> &deg;C</small></td>
                                <td style="width: 75px;"><small>BB</small></td>
                                <td style="width: 10px;" class="text-center"><small>:</small></td>
                                <td style="width: 80px;;"><small><?php echo $sql_medc->ttv_bb ?> Kg</small></td>
                            </tr>
                            <tr>
                                <td style="width: 75px;"><small>TB</small></td>
                                <td style="width: 10px;" class="text-center"><small>:</small></td>
                                <td style="width: 80px;"><small><?php echo $sql_medc->ttv_tb ?> Cm</small></td>
                                <td style="width: 75px;"><small>Nadi</small></td>
                                <td style="width: 10px;" class="text-center"><small>:</small></td>
                                <td style="width: 80px;"><small><?php echo $sql_medc->ttv_nadi ?> / Menit</small></td>
                            </tr>
                            <tr>
                                <td style="width: 75px;"><small>Sistole</small></td>
                                <td style="width: 10px;" class="text-center"><small>:</small></td>
                                <td style="width: 80px;"><small><?php echo $sql_medc->ttv_sistole ?> mmHg</small></td>
                                <td style="width: 75px;"><small>Diastole</small></td>
                                <td style="width: 10px;" class="text-center"><small>:</small></td>
                                <td style="width: 80px;;"><small><?php echo $sql_medc->ttv_diastole ?> mmHg</small></td>
                            </tr>
                            <tr>
                                <td style="width: 75px;"><small>Laju Nafas</small></td>
                                <td style="width: 10px;" class="text-center"><small>:</small></td>
                                <td style="width: 80px;"><small><?php echo $sql_medc->ttv_laju ?> / Menit</small></td>
                                <td style="width: 75px;"><small>Saturasi</small></td>
                                <td style="width: 10px;" class="text-center"><small>:</small></td>
                                <td style="width: 80px;"><small><?php echo $sql_medc->ttv_saturasi ?> %</small></td>
                            </tr>
                            <tr>
                                <td style="width: 75px;"><small>Nyeri</small></td>
                                <td style="width: 10px;" class="text-center"><small>:</small></td>
                                <td style="width: 80px;"><small><?php echo $sql_medc->ttv_skala ?></small></td>
                                <td style="width: 75px;"><small></small></td>
                                <td style="width: 10px;" class="text-center"><small></small></td>
                                <td style="width: 80px;"><small></small></td>
                            </tr>
                        </table>
                    <?php } ?>
                    <hr/>
                    <strong class="text-danger"><i class="far fa-file-alt mr-1"></i> Alergi :</strong>
                    <p class="text-danger"><small><?php echo ($sql_medc->alergi) ?></small></p>
                    <hr/>
                    <strong><i class="far fa-file-alt mr-1"></i> DIAGNOSA :</strong>
                    <p><small><?php echo ($sql_medc->diagnosa) ?></small></p>
                    <hr/>
                    <strong><i class="far fa-file-alt mr-1"></i> PROGRAM :</strong>
                    <p><small><?php echo ($sql_medc->program) ?></small></p>
                <?php } ?>
                <hr/>
                <strong><i class="far fa-file-alt mr-1"></i> DIAGNOSA ICD 10:</strong>
                <p>
                    <?php foreach ($this->db->where('id_medcheck', $sql_medc->id)->get('tbl_trans_medcheck_icd')->result() AS $icd) { ?>
                        <small>- <?php echo ($icd->diagnosa_en) ?></small><br/>
                    <?php } ?>
                </p>
                <p><a href="<?php echo base_url('medcheck/tambah.php?id='.general::enkrip($sql_medc->id).'&status=1') ?>" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-edit"></i> Ubah</a></p>
                <hr/>
                <strong><i class="far fa-file-alt mr-1"></i> ANTRIAN :</strong>
                <p>
                    <?php foreach ($sql_antrian as $antrian){ ?>
                    <?php $mpoli = $this->db->where('kode', $antrian->cnoro)->get('mpoli')->row(); ?>
                    <small>- Antrian <b><?php echo $mpoli->poli.' ['.$antrian->ncount.']' ?></b></small><br/>
                    <?php } ?>                    
                </p>
            </div>
        </div>
    </div>
<?php } ?>
<div class="card card-success card-outline rounded-0">
    <div class="card-body box-profile">
        <div class="text-center">
            <?php
            $file = (!empty($sql_pasien->file_name) ? realpath($sql_pasien->file_name) : '');
            $foto = (file_exists($file) ? base_url($sql_pasien->file_name) : $sql_pasien->file_base64);
            ?>
            <img class="profile-user-img img-fluid img-circle" src="<?php echo (!empty($foto) ? $foto : base_url('assets/theme/admin-lte-3/icon_putra.png')) ?>" alt="User profile picture" style="width: 100px; height: 100px;">
        </div>
        <h3 class="profile-username text-center">
            <small>
                <?php echo anchor(base_url('master/data_pasien_det.php?id=' . general::enkrip($sql_medc->id_pasien)), strtoupper($sql_pasien->nama_pgl), 'target="_blank"'); ?>                
            </small>
        </h3>
        <p class="text-muted text-center">
            <?php echo $this->tanggalan->tgl_indo2($sql_pasien->tgl_lahir) ?>
            <?php echo br() ?>
            <?php echo general::jns_klm($sql_pasien->jns_klm) ?>
        </p>
        <p class="text-muted text-center">
            Poin
            <?php echo br() ?>
            <?php echo (float)$sql_pasien_poin->jml_poin ?>
        </p>

        <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakOwner2() == TRUE OR akses::hakPerawat() == TRUE OR akses::hakAnalis() == TRUE) { ?>
            <p class="text-muted text-center"><?php echo anchor(base_url('master/data_pasien_tambah.php?id=' . general::enkrip($sql_medc->id_pasien) . '&route=medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)), '<i class="fa fa-edit"></i> Ubah Pasien', 'class="btn btn-warning btn-flat btn-sm rounded-0"'); ?></p>
        <?php } ?>
        <p class="text-muted text-center"><?php echo anchor(base_url('medcheck/cetak_label_json.php?id=' . general::enkrip($sql_medc->id) . '&route=medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)), '<i class="fa fa-print"></i> Cetak Label', 'class="btn btn-primary btn-flat btn-sm rounded-0" style="width: 107.14px;" target="_blank"'); ?></p>
        <p class="text-muted text-center"><?php echo anchor(base_url('master/data_pasien_pdf.php?id=' . general::enkrip($sql_medc->id_pasien) . '&route=medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)), '<i class="fa fa-file-pdf"></i> Kartu Pasien', 'class="btn btn-success btn-flat btn-sm rounded-0" style="width: 107.14px;" target="_blank"'); ?></p>

        <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item rounded-0">
                    <b>TRX ID</b><br/>
                    <span class="float-left"><small><?php echo strtoupper($sql_medc->id) ?></small></span>
                </li>
            <?php if (!empty($sql_medc->no_rm)) { ?>
                <li class="list-group-item rounded-0">
                    <b>No. Register / Kunjungan</b><br/>
                    <span class="float-left"><small><?php echo strtoupper($sql_medc->no_rm) ?></small></span>
                </li>
                <?php
                # Routing untuk edit penjamin
                switch ($_GET['act']) {
                    default:
                        ?>                        
                        <li class="list-group-item rounded-0">
                            <b>Penjamin</b><br/>
                            <span class="float-left text-danger"><small><b><u><?php echo strtoupper($sql_penjamin->penjamin) ?></u></b></small></span>
                            <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE) { ?>
                                <?php if ($sql_medc->tipe != '6') { ?>
                                    <?php echo nbs(2) . anchor(base_url('medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id) . '&act=penjamin_edit'), '<i class="fa fa-edit"></i>', 'class=""'); ?>
                                <?php } ?>
                            <?php } ?>
                        </li>
                        <?php
                        break;

                    case 'penjamin_edit':
                        ?>                        
                        <li class="list-group-item rounded-0">
                            <?php echo form_open(base_url('medcheck/set_medcheck_upd_penj.php'), 'id="penjamin_form" autocomplete="off"') ?>
                            <?php echo add_form_protection() ?>
                            <?php echo form_hidden('id', general::enkrip($sql_medc->id)) ?>
                            <b>Penjamin</b><br/>
                            <span class="float-left text-danger">

                                <select id="platform" name="platform" class="form-control rounded-0<?php echo (!empty($hasError['platform']) ? ' is-invalid' : '') ?>">
                                    <option value="">- PENJAMIN -</option>
                                    <?php foreach ($sql_penjamin2 as $penj) { ?>
                                        <option value="<?php echo $penj->id ?>" <?php echo ($penj->penjamin == $sql_penjamin->penjamin ? 'selected' : '') ?>><?php echo $penj->penjamin ?></option>
                                    <?php } ?>
                                </select> 
                            </span>
                            <?php echo nbs(2) ?>
                            <button type="submit" class="btn btn-primary btn-flat btn-sm rounded-0"><i class="fa fa-save"></i> Simpan</button>
                            <?php echo add_double_submit_protection('penjamin_form')?>
                            <?php echo form_close() ?>
                        </li>
                        <?php
                        break;
                }
                ?>
            <?php } ?>
            <li class="list-group-item rounded-0">
                <b>No. RM</b><br/>
                <span class="float-left"><small><?php echo strtoupper($sql_pasien->kode_dpn . $sql_pasien->kode) ?></small></span>
            </li>
            <li class="list-group-item rounded-0">
                <b>Tipe</b><br/>
                <span class="float-left"><small><?php echo general::status_rawat2($sql_medc->tipe); ?></small></span>
            </li>
            <?php if ($sql_medc->tipe == '3') { ?>
                <li class="list-group-item rounded-0">
                    <b>Kamar</b><br/>
                    <span class="float-left"><small><?php echo $this->db->where('id_medcheck', $sql_medc->id)->get('tbl_trans_medcheck_kamar')->row()->kamar; ?></small></span>
                </li>
            <?php } ?>
            <li class="list-group-item rounded-0">
                <b>Klinik</b><br/>
                <span class="float-left"><small><?php echo $sql_poli->lokasi; ?></small></span>
            </li>
            <li class="list-group-item rounded-0">
                <b>Petugas</b><br/>
                <span class="float-left"><small><?php echo (!empty($sql_petugas->nama_dpn) ? $sql_petugas->nama_dpn . ' ' : '') . $sql_petugas->nama . (!empty($sql_petugas->nama_blk) ? ', ' . $sql_petugas->nama_blk . ' ' : ''); ?></small></span>
            </li>
            <?php if ($sql_medc->tipe != '6') { ?>
            <li class="list-group-item rounded-0">
                <b>Dokter Utama</b><br/>
                <span class="float-left"><small><?php echo (!empty($sql_dokter->nama_dpn) ? $sql_dokter->nama_dpn . ' ' : '') . $sql_dokter->nama . (!empty($sql_dokter->nama_blk) ? ', ' . $sql_dokter->nama_blk . ' ' : ''); ?></small></span>
            </li>
            <li class="list-group-item rounded-0">
                <b>Tgl Daftar</b><br/>
                <span class="float-left"><small><?php echo $this->tanggalan->tgl_indo5($sql_dft->tgl_simpan); ?></small></span>
            </li>
            <?php } ?>
            <li class="list-group-item rounded-0">
                <b>Tgl Masuk</b><br/>
                <span class="float-left"><small><?php echo $this->tanggalan->tgl_indo5($sql_medc->tgl_masuk); ?></small></span>
            </li>
            <?php if ($sql_medc->status_bayar == '1') { ?>
                <li class="list-group-item rounded-0">
                    <b>Tgl Selesai</b><br/>
                    <span class="float-left"><small><?php echo $this->tanggalan->tgl_indo5($sql_medc->tgl_bayar); ?></small></span>
                    <?php if ($sql_medc->tipe != '3') { ?>
                        <span class="float-left"><small><?php echo nbs(2) ?>(<?php echo $this->tanggalan->usia_wkt($sql_medc->tgl_masuk, $sql_medc->tgl_bayar); ?>)</small></span>
                    <?php } else { ?>
                        <span class="float-left"><small><?php echo nbs(2) ?>(<?php echo $this->tanggalan->usia_hari($sql_medc->tgl_masuk, $sql_medc->tgl_bayar); ?>)</small></span>
                    <?php } ?>
                </li>
            <?php } ?>
            <?php if (!empty($sql_dft_gc->id)) { ?>
                <li class="list-group-item rounded-0">
                    <b>Persetujuan Umum</b><br/>
                    <span class="float-left"><small><?php echo anchor(base_url('surat/print_pdf_gc.php?dft=' . general::enkrip($sql_dft_gc->id) . '&route=medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)), '<i class="fa fa-signature"></i> Cetak', 'class="btn btn-primary btn-flat btn-sm rounded-0" style="width: 107.14px;" target="_blank"'); ?></small></span>
                </li>
            <?php } ?>
                <li class="list-group-item rounded-0">
                    <a href="https://wa.me/<?php echo $sql_pasien->no_hp ?>" target="_blank" style="display: inline-block; padding: 10px 20px; background-color: #25D366; color: white; text-decoration: none; border-radius: 0; font-size: 16px;">Chat via WhatsApp</a>
                </li>
        </ul>
    </div>
</div>
