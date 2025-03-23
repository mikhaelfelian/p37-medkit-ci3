<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!--<h1 class="m-0">Master Data</h1>-->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('master/index.php') ?>">Master Data</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('master/data_customer_list.php') ?>">Pasien</a></li>
                        <li class="breadcrumb-item active"><?php echo ucwords($pasien->nama); ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <?php
                                    $file = (!empty($pasien->file_name) ? realpath($pasien->file_name) : '');
                                    $foto = (file_exists($file) ? base_url($pasien->file_name) : $pasien->file_base64);
                                ?>                                
                                <img class="profile-user-img img-fluid img-circle" src="<?php echo (!empty($foto) ? $foto : base_url('assets/theme/admin-lte-3/icon_putra.png')) ?>" alt="User profile picture" style="width: 100px; height: 100px;">
                            </div>
                            <h3 class="profile-username text-center"><?php echo strtoupper($pasien->nama) ?></h3>
                            <p class="text-muted text-center"><?php echo $this->tanggalan->tgl_indo2($pasien->tgl_lahir) ?></p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <?php
                                    $kd_pasien = strtolower($pasien->kode_dpn . $pasien->kode);
                                    $sql_user = $this->db->where('username', $kd_pasien)->get('tbl_ion_users');
                                ?>

                                <li class="list-group-item">
                                    <b>No. RM</b> <a class="float-right"><?php echo strtoupper($pasien->kode_dpn . $pasien->kode) ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>No. HP</b> <a class="float-right"><?php echo strtoupper($pasien->no_hp) ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>No. Rmh</b> <a class="float-right"><?php echo strtoupper($pasien->no_telp) ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Poin</b> <a class="float-right"><?php echo general::format_angka($sql_poin->jml_poin) ?></a>
                                </li>
                            </ul>
                            
                            <?php if (akses::hakSA() == TRUE OR akses::hakOwner() == TRUE OR akses::hakPerawat() == TRUE OR akses::hakAnalis() == TRUE) { ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php if ($sql_user->num_rows() == 0) { ?>
                                            <?php echo anchor(base_url('master/data_pasien_user.php?id=' . general::enkrip($pasien->id) . '&kode=' . $kd_pasien), '<i class="fa fa-user-plus"></i> Buat User &raquo;', 'class="btn btn-primary btn-flat btn-sm" style="width: 107.14px;"'); ?>
                                        <?php } else { ?>
                                            <?php echo anchor(base_url('master/data_pasien_user_reset.php?id=' . general::enkrip($pasien->id) . '&kode=' . $kd_pasien), '<i class="fa fa-refresh"></i> Reset User &raquo;', 'class="btn btn-warning btn-flat btn-sm" style="width: 107.14px;"'); ?>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php echo anchor(base_url('master/data_pasien_foto_reset.php?id=' . general::enkrip($pasien->id) . '&kode=' . $kd_pasien), '<i class="fa fa-remove"></i> Hapus Foto &raquo;', 'class="btn btn-danger btn-flat btn-sm" style="width: 107.14px;"'); ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <?php
                                $file = (!empty($pasien->file_name_id) ? realpath($pasien->file_name_id) : '');
                                $foto = (file_exists($file) ? base_url($pasien->file_name_id) : '');
                                ?>                               
                                <img class="img-thumbnail img-fluid img-lg" src="<?php echo (!empty($foto) ? $foto : base_url('assets/theme/admin-lte-3/icon_putra.png')) ?>" alt="User profile picture" style="width: 256px; height: 192px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card card-primary card-outline">
                        <!--
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#data-pasien" data-toggle="tab"><?php echo nbs(2) ?>Profile</a></li>
                                <li class="nav-item"><a class="nav-link" href="#data-rm" data-toggle="tab"><?php echo nbs(2) ?>Riw. Medis Rajal</a></li>
                                <li class="nav-item"><a class="nav-link" href="#data-rmi" data-toggle="tab"><?php echo nbs(2) ?>Riw. Medis Ranap</a></li>
                                <li class="nav-item"><a class="nav-link" href="#data-rmlab" data-toggle="tab"><?php echo nbs(2) ?>Riw. Laborat</a></li>
                                <li class="nav-item"><a class="nav-link" href="#data-rmrad" data-toggle="tab"><?php echo nbs(2) ?>Riw. Radiologi</a></li>
                                <li class="nav-item"><a class="nav-link" href="#data-rmfile" data-toggle="tab"><?php echo nbs(2) ?>Riw. Berkas</a></li>
                            </ul>
                        </div>
                        -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="nav flex-column nav-tabs h-100" id="" role="" aria-orientation="vertical">
                                        <a class="nav-link active" href="#data-pasien" data-toggle="tab"><?php echo nbs(2) ?>Profile</a>
                                        <a class="nav-link" href="#data-rm" data-toggle="tab"><?php echo nbs(2) ?>Riw. Medis Rajal</a>
                                        <a class="nav-link" href="#data-rmi" data-toggle="tab"><?php echo nbs(2) ?>Riw. Medis Ranap</a>
                                        <a class="nav-link" href="#data-rmlab" data-toggle="tab"><?php echo nbs(2) ?>Riw. Laborat</a>
                                        <a class="nav-link" href="#data-rmrad" data-toggle="tab"><?php echo nbs(2) ?>Riw. Radiologi</a>
                                        <a class="nav-link" href="#data-rmfile" data-toggle="tab"><?php echo nbs(2) ?>Riw. Berkas</a>
                                        <a class="nav-link" href="#data-rmobat" data-toggle="tab"><?php echo nbs(2) ?>Riw. Apotik</a>
                                        <a class="nav-link" href="#data-rmpoin" data-toggle="tab"><?php echo nbs(2) ?>Riw. Poin Msk</a>
                                        <a class="nav-link" href="#data-rmpoinklr" data-toggle="tab"><?php echo nbs(2) ?>Riw. Poin Klr</a>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="tab-content" id="vert-tabs-tabContent">
                                        <div class="tab-pane active" id="data-pasien">
                                            <?php echo form_open('page=pengaturan&act=profile_update', 'id="FormSimpan" class="form-horizontal"') ?>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-3 col-form-label">NIK</label>
                                                <div class="col-sm-9">
                                                    <?php echo form_input(array('id' => 'nik', 'name' => 'nik', 'readonly' => 'TRUE', 'class' => 'form-control', 'value' => $pasien->nik)) ?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-3 col-form-label">Nama Lengkap</label>
                                                <div class="col-sm-9">
                                                    <?php echo form_input(array('id' => 'nama', 'name' => 'nama', 'readonly' => 'TRUE', 'class' => 'form-control', 'value' => $pasien->nama_pgl)) ?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                                <div class="col-sm-9">
                                                    <?php echo form_input(array('id' => 'jns_klm', 'name' => 'jns_klm', 'readonly' => 'TRUE', 'class' => 'form-control', 'value' => general::jns_klm($pasien->jns_klm))) ?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-3 col-form-label">Tempat & Tanggal Lahir</label>
                                                <div class="col-sm-3">
                                                    <?php echo form_input(array('id' => 'tmp_lahir', 'name' => 'tgl_lahir', 'readonly' => 'TRUE', 'class' => 'form-control', 'value' => $pasien->tmp_lahir)) ?>
                                                </div>
                                                <div class="col-sm-6">
                                                    <?php echo form_input(array('id' => 'tgl_lahir', 'name' => 'tgl_lahir', 'readonly' => 'TRUE', 'class' => 'form-control', 'value' => $this->tanggalan->tgl_indo2($pasien->tgl_lahir))) ?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-3 col-form-label">Instansi</label>
                                                <div class="col-sm-4">
                                                    <?php echo form_input(array('id' => 'instansi', 'name' => 'instansi', 'readonly' => 'TRUE', 'class' => 'form-control', 'value' => $pasien->instansi)) ?>
                                                </div>
                                                <div class="col-sm-5">
                                                    <?php echo form_input(array('id' => 'instansi_almt', 'name' => 'instansi_almt', 'readonly' => 'TRUE', 'class' => 'form-control', 'value' => $pasien->instansi_alamat)) ?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-3 col-form-label">Alamat KTP</label>
                                                <div class="col-sm-9">
                                                    <?php echo form_textarea(array('id' => 'alamat', 'name' => 'alamat', 'readonly' => 'TRUE', 'class' => 'form-control', 'value' => $pasien->alamat)) ?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-3 col-form-label">Alamat Domisili</label>
                                                <div class="col-sm-9">
                                                    <?php echo form_textarea(array('id' => 'alamat_dom', 'name' => 'alamat_dom', 'readonly' => 'TRUE', 'class' => 'form-control', 'value' => $pasien->alamat_dom)) ?>
                                                </div>
                                            </div>
                                            <?php echo form_close() ?>
                                        </div>
                                        <div class="tab-pane" id="data-rm">
                                            <?php if (!empty($rm)) { ?>
                                                <div class="timeline timeline-inverse">
                                                    <?php foreach ($rm as $medc) { ?>
                                                        <?php $sql_surat = $this->db->where('id_medcheck', $medc->id)->get('tbl_trans_medcheck_surat')->result(); ?>
                                                        <?php $sql_poli = $this->db->where('id', $medc->id_poli)->get('tbl_m_poli')->row(); ?>

                                                        <div class="time-label">
                                                            <span class="bg-danger">
                                                                <?php echo $this->tanggalan->tgl_indo3($medc->tgl_masuk) ?>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <i class="fas fa-stethoscope bg-primary"></i>
                                                            <div class="timeline-item">
                                                                <span class="time"><i class="far fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($medc->tgl_masuk) ?></span>
                                                                <h3 class="timeline-header"><a href="#"><?php echo $sql_poli->lokasi ?></a></h3>
                                                                <div class="timeline-body">
                                                                    <?php echo (!empty($medc->diagnosa) ? html_entity_decode($medc->diagnosa) : 'Tidak Ada Diagnosa') ?>
                                                                </div>
                                                                <div class="timeline-footer">
                                                                    <a href="<?php echo base_url('medcheck/detail.php?id=' . general::enkrip($medc->id) . '&route=master/data_pasien_det.php$id$' . general::enkrip($medc->id_pasien) . '$data-rm') ?>" class="btn btn-primary btn-sm">Detail ...</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php $sql_medc_file = $this->db->where('id_medcheck', $medc->id)->order_by('id', 'desc')->limit(3)->get('tbl_trans_medcheck_file')->result(); ?>
                                                        <?php if (!empty($sql_medc_file)) { ?>
                                                            <div>
                                                                <i class="fas fa-file-archive bg-primary"></i>
                                                                <div class="timeline-item">
                                                                    <span class="time"><i class="far fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($medc->tgl_masuk) ?></span>
                                                                    <h3 class="timeline-header"><a href="#">BERKAS</a></h3>
                                                                    <div class="timeline-body">
                                                                        <table class="table table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="text-center">No.</th>
                                                                                    <th class="text-left">Nama Berkas</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php $no = 1; ?>
                                                                                <?php foreach ($sql_medc_file as $berkas) { ?>
                                                                                    <?php
                                                                                    $sql_medc = $this->db->where('id', $rad_file->id_medcheck)->get('tbl_trans_medcheck')->row();
                                                                                    $no_rm = strtolower($pasien->kode_dpn) . $pasien->kode;
                                                                                    $is_image = substr($berkas->file_type, 0, 5);
                                                                                    $filename = base_url($berkas->file_name);
                                                                                    $foto = (file_exists($file) ? base_url('file/pasien/' . $no_rm . '/' . $berkas->file_name) : $berkas->file_base64);
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td class="text-center"><?php echo $no; ?></td>
                                                                                        <td class="text-left">                                                                                    
                                                                                            <?php if ($is_image == 'image') { ?>
                                                                                                <a href="<?php echo $filename ?>" data-toggle="lightbox" data-title="<?php echo strtolower($berkas->judul . ' - ' . $sql_pasien->nama_pgl) ?>">
                                                                                                    <i class="fas fa-paperclip"></i> <?php echo $berkas->judul ?>
                                                                                                </a>
                                                                                            <?php } else { ?>
                                                                                                <a href="<?php echo $filename ?>" target="_blank">
                                                                                                    <i class="fas fa-paperclip"></i> <?php echo $berkas->judul ?>
                                                                                                </a>
                                                                                            <?php } ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php $no++; ?>
                                                                                <?php } ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="timeline-footer">
                                                                        <a href="<?php echo base_url('medcheck/tambah.php?id=' . general::enkrip($medc->id) . '&status=8&route=master/data_pasien_det.php$id$' . general::enkrip($medc->id_pasien) . '$data-rm') ?>" class="btn btn-primary btn-sm">Detail ...</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php foreach ($sql_surat as $surat) { ?>
                                                            <div>
                                                                <i class="fas fa-envelope bg-info"></i>
                                                                <div class="timeline-item">
                                                                    <span class="time"><i class="far fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($surat->tgl_simpan) ?></span>
                                                                    <h3 class="timeline-header">
                                                                        <a href="#"><?php echo $surat->no_surat ?></a> Surat <?php echo general::tipe_surat($surat->tipe) ?>
                                                                    </h3>
                                                                    <div class="timeline-footer">
                                                                        <a href="<?php echo base_url('medcheck/surat/cetak_pdf.php?id=' . general::enkrip($surat->id) . '&no_nota=' . general::enkrip($surat->id_medcheck) . '&status=6') ?>" class="btn btn-success btn-sm rounded-0" target="_blank"><i class="fa fa-paperclip"></i> Lampiran</a>
                                                                    </div>                                                       
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <div>
                                                        <i class="far fa-circle bg-black"></i>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <p>Catatan riwayat medis rawat jalan tidak ditemukan</p>
                                            <?php } ?>
                                        </div>
                                        <div class="tab-pane" id="data-rmi">
                                            <?php if (!empty($rmi)) { ?>
                                                <div class="timeline timeline-inverse">
                                                    <?php foreach ($rmi as $rmi) { ?>
                                                        <div class="time-label">
                                                            <span class="bg-danger">
                                                                <?php echo $this->tanggalan->tgl_indo3($rmi->tgl_simpan) ?>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <i class="fas fa-user-md bg-primary"></i>
                                                            <div class="timeline-item">
                                                                <span class="time"><i class="far fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($rmi->tgl_simpan) ?></span>
                                                                <h3 class="timeline-header"><a href="#">Anamnesis</a></h3>
                                                                <div class="timeline-body">
                                                                    <?php echo (!empty($rmi->anamnesa) ? html_entity_decode($rmi->anamnesa) : 'Tidak Ada Anamnesis') ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <i class="fas fa-stethoscope bg-primary"></i>
                                                            <div class="timeline-item">
                                                                <span class="time"><i class="far fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($rmi->tgl_simpan) ?></span>
                                                                <h3 class="timeline-header"><a href="#">Pemeriksaan</a></h3>
                                                                <div class="timeline-body">
                                                                    <?php echo (!empty($rmi->pemeriksaan) ? html_entity_decode($rmi->pemeriksaan) : 'Tidak Ada Pemeriksaan') ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <i class="fas fa-solid fa-clipboard-check bg-primary"></i>
                                                            <div class="timeline-item">
                                                                <span class="time"><i class="far fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($rmi->tgl_simpan) ?></span>
                                                                <h3 class="timeline-header"><a href="#">Diagnosa</a></h3>
                                                                <div class="timeline-body">
                                                                    <?php echo (!empty($rmi->diagnosa) ? html_entity_decode($rmi->diagnosa) : 'Tidak Ada Diagnosa') ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <i class="fas fa-solid fa-bed bg-primary"></i>
                                                            <div class="timeline-item">
                                                                <span class="time"><i class="far fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($rmi->tgl_simpan) ?></span>
                                                                <h3 class="timeline-header"><a href="#">Terapi</a></h3>
                                                                <div class="timeline-body">
                                                                    <?php echo (!empty($rmi->terapi) ? html_entity_decode($rmi->terapi) : 'Tidak Ada Terapi') ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <i class="fas fa-solid fa-hospital-user bg-primary"></i>
                                                            <div class="timeline-item">
                                                                <span class="time"><i class="far fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($rmi->tgl_simpan) ?></span>
                                                                <h3 class="timeline-header"><a href="#">Program</a></h3>
                                                                <div class="timeline-body">
                                                                    <?php echo (!empty($rmi->program) ? html_entity_decode($rmi->program) : 'Tidak Ada Terapi') ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <div>
                                                        <i class="far fa-circle bg-black"></i>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <p>Catatan riwayat medis rawat inap tidak ditemukan</p>
                                            <?php } ?>
                                        </div>
                                        <div class="tab-pane" id="data-rmlab">
                                            <?php if (!empty($rmlab)) { ?>
                                                <div class="timeline timeline-inverse">
                                                    <?php foreach ($rmlab as $rmlab) { ?>
                                                        <div class="time-label">
                                                            <span class="bg-danger">
                                                                <?php echo $this->tanggalan->tgl_indo3($rmlab->tgl_simpan) ?>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <i class="fas fa-microscope bg-primary"></i>
                                                            <div class="timeline-item">
                                                                <span class="time"><i class="far fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($rmlab->tgl_simpan) ?></span>
                                                                <h3 class="timeline-header"><a href="#"><?php echo $rmlab->no_lab ?></a></h3>
                                                                <div class="timeline-body">
                                                                    No. Sampel : <?php echo $rmlab->no_sample . br() ?>
                                                                    Analis : <?php echo $this->ion_auth->user($rmlab->id_analis)->row()->first_name . br() ?>
                                                                </div>
                                                                <div class="timeline-footer">
                                                                    <a href="<?php echo base_url('medcheck/surat/cetak_pdf_lab.php?id=' . general::enkrip($rmlab->id_medcheck) . '&id_lab=' . general::enkrip($rmlab->id) . '&status_ctk=1&route=master/data_pasien_det.php$id$' . general::enkrip($medc->id_pasien) . '$data-rm') ?>" class="btn btn-success btn-sm rounded-0" target="_blank"><i class="fa fa-paperclip"></i> Lampiran</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <div>
                                                        <i class="far fa-circle bg-black"></i>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <p>Catatan riwayat laborat tidak ditemukan</p>
                                            <?php } ?>
                                        </div>
                                        <div class="tab-pane" id="data-rmrad">
                                            <?php if (!empty($rmrad)) { ?>
                                                <div class="timeline timeline-inverse">
                                                    <?php foreach ($rmrad as $rmrad) { ?>
                                                        <?php $sql_rad = $this->db->where('id_medcheck', $rmrad->id_medcheck)->where('file_rad !=', '')->get('tbl_trans_medcheck_det')->result(); ?>
                                                        <?php $sql_rad_file = $this->db->where('id_medcheck', $rmrad->id_medcheck)->where('id_rad', $rmrad->id)->get('tbl_trans_medcheck_rad_file')->result(); ?>
                                                        <div class="time-label">
                                                            <span class="bg-danger">
                                                                <?php echo $this->tanggalan->tgl_indo3($rmrad->tgl_simpan) ?>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <i class="fas fa-circle-radiation bg-primary"></i>
                                                            <div class="timeline-item">
                                                                <span class="time"><i class="far fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($rmrad->tgl_simpan) ?></span>
                                                                <h3 class="timeline-header"><a href="#"><?php echo $rmrad->no_rad ?></a></h3>
                                                                <div class="timeline-body">
                                                                    No. Sampel  : <?php echo $rmrad->no_sample . br() ?>
                                                                    Keterangan : <?php echo $rmrad->ket . br() ?>
                                                                    <p>
                                                                        <?php echo $rmrad->ket ?>
                                                                    </p>
                                                                    <?php foreach ($sql_rad as $rad) { ?>
                                                                        <a href="<?php echo $rad->file_rad ?>" data-toggle="lightbox" data-title="<?php echo $rad->item ?>">
                                                                            <i class="fas fa-paperclip"></i> <?php echo $rad->item ?>
                                                                        </a>
                                                                    <?php } ?>
                                                                </div>
                                                                <div class="timeline-footer">
                                                                    <a href="<?php echo base_url('medcheck/surat/cetak_pdf_rad.php?id=' . general::enkrip($rmrad->id_medcheck) . '&id_rad=' . general::enkrip($rmrad->id) . '&route=master/data_pasien_det.php$id$' . general::enkrip($medc->id_pasien) . '$data-rm') ?>" class="btn btn-success btn-sm rounded-0" target="_blank"><i class="fa fa-paperclip"></i> Lampiran</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php if (!empty($sql_rad_file)) { ?>
                                                            <div>
                                                                <i class="fas fa-camera bg-primary"></i>
                                                                <div class="timeline-item">
                                                                    <h3 class="timeline-header"><a href="#"><?php echo $rmrad->no_rad ?></a> - Foto Tambahan</h3>
                                                                    <div class="timeline-body">
                                                                        <?php foreach ($sql_rad_file as $rad_file) { ?>
                                                                            <?php
                                                                            $sql_medc = $this->db->where('id', $rad_file->id_medcheck)->get('tbl_trans_medcheck')->row();
                                                                            $no_rm = strtolower($pasien->kode_dpn) . $pasien->kode;
                                                                            $file = (!empty($rad_file->file_name) ? realpath('./file/pasien/' . $no_rm . '/' . $rad_file->file_name) : '');
                                                                            $foto = (file_exists($file) ? base_url('/file/pasien/' . $no_rm . '/' . $rad_file->file_name) : $sql_pasien->file_base64);
                                                                            ?>
                                                                            <a href="<?php echo $foto ?>" data-toggle="lightbox" data-title="<?php echo $rad_file->judul ?>">
                                                                                <img src="<?php echo $foto ?>" alt="<?php echo $rad_file->judul ?>" style="width: 100px; height: 100px;">
                                                                            </a>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <div>
                                                        <i class="far fa-circle bg-black"></i>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <p>Catatan riwayat radiologi tidak ditemukan</p>
                                            <?php } ?>
                                        </div>
                                        <div class="tab-pane" id="data-rmfile">
                                            <?php if (!empty($rmfile)) { ?>
                                                <div class="timeline timeline-inverse">
                                                    <?php foreach ($rmfile as $rmfile) { ?>
                                                        <div class="time-label">
                                                            <span class="bg-danger">
                                                                <?php echo $this->tanggalan->tgl_indo3($rmfile->tgl_simpan) ?>
                                                            </span>
                                                        </div>
                                                        <?php
                                                        $sql_file = $this->db->where('id_pasien', $pasien->id)->where('DATE(tgl_simpan)', $rmfile->tgl_simpan)->get('tbl_trans_medcheck_file')->result();
                                                        foreach ($sql_file as $berkas) {
                                                            $sql_medc = $this->db->where('id', $rad_file->id_medcheck)->get('tbl_trans_medcheck')->row();
                                                            $no_rm = strtolower($pasien->kode_dpn) . $pasien->kode;
                                                            $file = (!empty($berkas->file_name) ? realpath('.' . $berkas->file_name) : '');
                                                            $foto = base_url($berkas->file_name); // (file_exists($file) ? base_url('file/pasien/' . $no_rm . '/' . $berkas->file_name) : $berkas->file_base64);
                                                            ?>
                                                            <div>
                                                                <i class="fas <?php echo ($berkas->file_ext == '.jpg' || $berkas->file_ext == '.jpeg' || $berkas->file_ext == '.jfif' || $berkas->file_ext == '.png' ? 'fa-file-image' : 'fa-file-pdf') ?> bg-primary"></i>
                                                                <div class="timeline-item">
                                                                    <span class="time"><i class="far fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($berkas->tgl_simpan) ?></span>
                                                                    <h3 class="timeline-header">
                                                                        <?php if (!empty($foto)) { ?>
                                                                            <a href="<?php echo (!empty($foto) ? $foto : '#') ?>" data-toggle="<?php echo ($berkas->file_ext == '.jpg' || $berkas->file_ext == '.jpeg' || $berkas->file_ext == '.jfif' || $berkas->file_ext == '.png' ? 'lightbox' : '') ?>" data-title="<?php echo strtolower($berkas->judul) ?>" <?php echo ($berkas->file_ext == '.jpg' || $berkas->file_ext == '.jpeg' || $berkas->file_ext == '.jfif' || $berkas->file_ext == '.png' ? '' : 'target="_blank"') ?>><?php echo $berkas->judul ?></a>
                                                                        <?php } else { ?>
                                                                            <?php echo $berkas->judul . ' <small><i>* File tidak ditemukan !!!</i></small>' ?>
                                                                        <?php } ?>
                                                                    </h3>                                                        
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <div>
                                                        <i class="far fa-circle bg-black"></i>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <p>Catatan riwayat berkas tidak ditemukan</p>
                                            <?php } ?>
                                        </div>
                                        <div class="tab-pane" id="data-rmobat">
                                            <?php if (!empty($rmobat)) { ?>
                                                <div class="timeline timeline-inverse">
                                                    <?php foreach ($rmobat as $rmobat) { ?>
                                                        <div class="time-label">
                                                            <span class="bg-danger">
                                                                <?php echo $this->tanggalan->tgl_indo3($rmobat->tgl_simpan) ?>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <i class="fas fa-medkit bg-primary"></i>
                                                            <div class="timeline-item rounded-0">
                                                                <span class="time"><i class="far fa-clock"></i> <?php echo $this->tanggalan->wkt_indo($rmobat->tgl_simpan) ?></span>
                                                                <h3 class="timeline-header"><a href="<?php echo base_url('pos/trans_jual_inv.php?id='.general::enkrip($rmobat->id)) ?>" target="_blank"><?php echo $rmobat->no_nota ?></a></h3>
                                                                <div class="timeline-body">
                                                                    <table class="table table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="text-center">No.</th>
                                                                                    <th class="text-left">Item</th>
                                                                                    <th class="text-left">Jml</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $sql_obat = $this->db->where('id_pasien', $rmobat->id_pasien)->where('DATE(tgl_simpan)', $this->tanggalan->tgl_indo_sys($rmobat->tgl_simpan))->get('v_medcheck_apotik')->result();
                                                                                    $obt = 1;
                                                                                    foreach ($sql_obat as $obat){
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td class="text-center" style="width: 20px;"><?php echo $obt; ?></td>
                                                                                            <td class="text-left" style="width: 250px;"><?php echo $obat->item; ?></td>
                                                                                            <td class="text-right" style="width: 50px;"><?php echo (float)$obat->jml; ?></td>
                                                                                        </tr>
                                                                                        <?php
                                                                                        $obt++;
                                                                                    }
                                                                                ?>
                                                                            </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <div>
                                                        <i class="far fa-circle bg-black"></i>
                                                    </div>
                                                </div>
                                            <?php }else{ ?>
                                                <p>Catatan riwayat pembelian obat tidak ditemukan</p>
                                            <?php } ?>
                                        </div>
                                        <div class="tab-pane" id="data-rmpoin">
                                            <?php if (!empty($rmpoin)) { ?>
                                                <table class="table table-stripped">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th class="text-left">Tgl</th>
                                                            <th class="text-left">Trx</th>
                                                            <th class="text-center">Jml</th>
                                                            <th class="text-right">Poin</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1; ?>
                                                        <?php foreach ($rmpoin as $poin){ ?>
                                                                <tr>
                                                                    <td class="text-center" style="width: 50px;"><?php echo $no; ?></td>
                                                                    <td class="text-left" style="width: 150px;">
                                                                        <small><?php echo $this->tanggalan->tgl_indo5($poin->tgl_simpan) ?></small>
                                                                    </td>
                                                                    <td class="text-left" style="width: 100px;">
                                                                        <?php echo anchor(base_url('medcheck/tindakan.php?id='.general::enkrip($poin->id)), $poin->no_nota, 'target="_blank"'); ?>
                                                                    </td>
                                                                    <td class="text-center" style="width: 100px;"><?php echo general::format_angka($poin->jml_poin); ?></td>
                                                                    <td class="text-right" style="width: 100px;"><?php echo general::format_angka($poin->jml_poin_nom); ?></td>
                                                                </tr>
                                                            <?php $no++; ?>
                                                        <?php } ?>
                                                        <tr>
                                                            <th class="text-left" colspan="3">TOTAL</th>
                                                            <th class="text-center"><?php echo general::format_angka($sql_poin->jml_poin) ?></th>
                                                            <th class="text-right"><?php echo general::format_angka($sql_poin->jml_poin_nom) ?></th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-left" colspan="5">
                                                                <small>
                                                                    <i>
                                                                        *Setiap <b>1 (satu)</b> poin bernilai <b><?php echo ($pengaturan->jml_poin) ?></b>. 
                                                                         Poin dihitung dari kelipatan <b><?php echo general::format_angka($pengaturan->jml_poin_nom) ?></b> per transaksi.
                                                                    </i>
                                                                </small>                                                                
                                                            </th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            <?php }else{ ?>
                                                <p>Catatan riwayat transaksi tidak ditemukan</p>
                                            <?php } ?>
                                        </div>
                                        <div class="tab-pane" id="data-rmpoinklr">
                                            <?php if (!empty($rmpoinklr)) { ?>
                                                <table class="table table-stripped">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th class="text-left">Tgl</th>
                                                            <th class="text-left">Trx</th>
                                                            <th class="text-center">Jml</th>
                                                            <th class="text-right">Poin</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1; ?>
                                                        <?php foreach ($rmpoinklr as $poin){ ?>
                                                                <tr>
                                                                    <td class="text-center" style="width: 50px;"><?php echo $no; ?></td>
                                                                    <td class="text-left" style="width: 150px;">
                                                                        <small><?php echo $this->tanggalan->tgl_indo5($poin->tgl_simpan) ?></small>
                                                                    </td>
                                                                    <td class="text-left" style="width: 100px;">
                                                                        <?php echo anchor(base_url('medcheck/tindakan.php?id='.general::enkrip($poin->id)), $poin->no_nota, 'target="_blank"'); ?>
                                                                    </td>
                                                                    <td class="text-center" style="width: 100px;"><?php echo general::format_angka($poin->jml_poin); ?></td>
                                                                    <td class="text-right" style="width: 100px;"><?php echo general::format_angka($poin->jml_poin_nom); ?></td>
                                                                </tr>
                                                            <?php $no++; ?>
                                                        <?php } ?>
                                                        <tr>
                                                            <th class="text-left" colspan="3">TOTAL</th>
                                                            <th class="text-center"><?php echo general::format_angka($sql_poin->jml_poin) ?></th>
                                                            <th class="text-right"><?php echo general::format_angka($sql_poin->jml_poin_nom) ?></th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-left" colspan="5">
                                                                <small>
                                                                    <i>
                                                                        *Setiap <b>1 (satu)</b> poin bernilai <b><?php echo ($pengaturan->jml_poin) ?></b>. 
                                                                         Poin dihitung dari kelipatan <b><?php echo general::format_angka($pengaturan->jml_poin_nom) ?></b> per transaksi.
                                                                    </i>
                                                                </small>                                                                
                                                            </th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            <?php }else{ ?>
                                                <p>Catatan riwayat transaksi tidak ditemukan</p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/moment/moment.min.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-3/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet">

<!-- Ekko Lightbox -->
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/ekko-lightbox/ekko-lightbox.min.js') ?>"></script>

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function () {
        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });

<?php echo $this->session->flashdata('medcheck_toast'); ?>
<?php echo $this->session->flashdata('master_toast'); ?>
    });
</script>