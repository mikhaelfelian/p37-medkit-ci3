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
                        <li class="breadcrumb-item active">Pengaturan</li>
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
                <div class="col-md-12">
                    <?php echo form_open(base_url('pengaturan/set_pengaturan.php')) ?>
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Pengaturan</h3>
                            <div class="card-tools">
                                
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group <?php echo (!empty($hasError['nama']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Nama Perusahaan</label>
                                        <?php echo form_input(array('name' => 'judul', 'class' => 'form-control rounded-0', 'value' => $pengaturan->judul)) ?>
                                    </div>
                                    <div class="form-group <?php echo (!empty($hasError['user']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Alamat</label>
                                        <?php echo form_input(array('name' => 'alamat', 'class' => 'form-control rounded-0', 'value' => $pengaturan->alamat)) ?>
                                    </div>
                                    <div class="form-group <?php echo (!empty($hasError['pass1']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Kota</label>
                                        <?php echo form_input(array('name' => 'kota', 'class' => 'form-control rounded-0', 'value' => $pengaturan->kota)) ?>
                                    </div>
                                    <div class="form-group <?php echo (!empty($hasError['pass2']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Jml Item per Halaman</label>
                                        <?php echo form_input(array('id' => 'jml_item', 'name' => 'jml_item', 'class' => 'form-control rounded-0', 'value' => $pengaturan->jml_item)) ?>
                                    </div>
                                    <div class="form-group <?php echo (!empty($hasError['pass2']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Jml Minimal Stok <small><i>* Notif untuk PO dgn satuan terkecil</i></small></label>
                                        <?php echo form_input(array('id' => 'jml_item_limit', 'name' => 'jml_item_limit', 'class' => 'form-control rounded-0', 'value' => $pengaturan->jml_limit_stok)) ?>
                                    </div>
                                    <?php if (akses::hakSA() == TRUE) { ?>
                                        <div class="form-group <?php echo (!empty($hasError['cabang']) ? 'has-error' : '') ?>">
                                            <label class="control-label">Cabang / Lokasi</label>
                                            <select name="cabang" class="form-control rounded-0">
                                                <option value="">- Pilih -</option>
                                                <?php
                                                $cbg = $this->db->order_by('id', 'asc')->get('tbl_pengaturan_cabang')->result();
                                                foreach ($cbg as $cbg) {
                                                    echo '<option value="' . $cbg->id . '" ' . ($cbg->id == $pengaturan->id_app ? 'selected' : '') . '>' . strtoupper($cbg->keterangan) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group <?php echo (!empty($hasError['apt_apa']) ? 'has-error' : '') ?>">
                                        <label class="control-label">APA (Apoteker Pengelola Apotek)</label>
                                        <?php echo form_input([
                                            'name' => 'apt_apa',
                                            'class' => 'form-control rounded-0',
                                            'value' => $pengaturan->apt_apa ?? ''
                                        ]) ?>
                                    </div>
                                    <div class="form-group <?php echo (!empty($hasError['apt_sipa']) ? 'has-error' : '') ?>">
                                        <label class="control-label">SIPA (Surat Izin Praktik Apoteker)</label>
                                        <?php echo form_input([
                                            'name' => 'apt_sipa',
                                            'class' => 'form-control rounded-0',
                                            'value' => $pengaturan->apt_sipa ?? ''
                                        ]) ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group <?php echo (!empty($hasError['pass2']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Jml PPN</label>
                                        <?php echo form_input(array('id' => 'jml_ppn', 'name' => 'jml_ppn', 'class' => 'form-control rounded-0', 'value' => $pengaturan->jml_ppn)) ?>
                                    </div>
                                    <div class="form-group <?php echo (!empty($hasError['pass2']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Nilai 1 Poin <i>*</i></label>
                                        <?php echo form_input(array('id' => 'jml_poin', 'name' => 'jml_poin', 'class' => 'form-control rounded-0', 'value' => $pengaturan->jml_poin)) ?>
                                    </div>
                                    <div class="form-group <?php echo (!empty($hasError['pass2']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Nominal Kelipatan <i>*</i></label>
                                        <?php echo form_input(array('id' => 'jml_klp', 'name' => 'jml_klp', 'class' => 'form-control rounded-0', 'value' => $pengaturan->jml_poin_nom)) ?>
                                    </div>
                                    <div class="form-group <?php echo (!empty($hasError['pass2']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Tahun Cut Off <i>*</i></label>
                                        <?php echo form_input(array('id' => 'tahun', 'name' => 'tahun', 'class' => 'form-control rounded-0', 'value' => $pengaturan->tahun_poin)) ?>
                                    </div>                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group <?php echo (!empty($hasError['ss_org_id']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Satu Sehat Org. ID <i>*</i></label>
                                        <?php echo form_input(array('id' => 'ss_org_id', 'name' => 'ss_org_id', 'class' => 'form-control rounded-0', 'value' => $pengaturan->ss_org_id)) ?>
                                    </div>
                                    <div class="form-group <?php echo (!empty($hasError['ss_client_id']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Satu Sehat Klien ID <i>*</i></label>
                                        <?php echo form_input(array('id' => 'ss_client_id', 'name' => 'ss_client_id', 'class' => 'form-control rounded-0', 'value' => $pengaturan->ss_client_id)) ?>
                                    </div>
                                    <div class="form-group <?php echo (!empty($hasError['ss_client_secret']) ? 'has-error' : '') ?>">
                                        <label class="control-label">Satu Sehat Klien Secret Key <i>*</i></label>
                                        <?php echo form_input(array('id' => 'ss_client_secret', 'name' => 'ss_client_secret', 'class' => 'form-control rounded-0', 'value' => $pengaturan->ss_client_secret)) ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    
                                </div>
                                <div class="col-lg-6 text-right">
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/JAutoNumber/autonumeric.js') ?>"></script>
<script src="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI/jquery-ui.js') ?>"></script>
<link href="<?php echo base_url('assets/theme/admin-lte-2/plugins/jQueryUI') ?>/jquery-ui.min.css" rel="stylesheet">

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
<script src="<?php echo base_url('assets/theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Page script -->
<script type="text/javascript">
    $(function () {        
        $("input[id=jml_klp]").autoNumeric({aSep: '.', aDec: ',', aPad: false});
        <?php echo $this->session->flashdata('pengaturan_toast'); ?>
    });
</script>