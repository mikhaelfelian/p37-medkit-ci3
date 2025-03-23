<div class="card">
    <div class="card-header">
        <h3 class="card-title">PEMERIKSAAN PENUNJANG - <?php echo $sql_pasien->nama_pgl; ?>
            <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
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
                    <div class="tab-pane text-left fade show active" id="tab-pemeriksaan" role="tabpanel"
                        aria-labelledby="vert-tabs-home-tab">
                        <?php if (akses::hakSA() == TRUE or akses::hakOwner() == TRUE or akses::hakOwner2() == TRUE or akses::hakDokter() == TRUE or akses::hakPerawat() == TRUE or akses::hakAnalis() == TRUE) { ?>
                            <!-- Add Audiometri Form -->
                            <div class="card card-primary card-outline rounded-0">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Data Audiometri</h3>
                                </div>
                                <form action="<?php echo base_url('medcheck/set_medcheck_lab_adm_save.php') ?>"
                                    method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <input type="hidden" name="id_medcheck"
                                            value="<?php echo $this->input->get('id') ?>">
                                        <input type="hidden" name="id_pasien"
                                            value="<?php echo general::enkrip($sql_pasien->id) ?>">
                                        <input type="hidden" name="status"
                                            value="<?php echo $this->input->get('status') ?>">

                                            
                                        <?php $this->session->flashdata('form_error'); ?>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                                                    <label for="inputEmail3">Dokter Pengirim</label>
                                                    <select id="dokter_kirim" name="dokter_kirim"
                                                        class="form-control rounded-0 select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                                        <option value="0">- Dokter -</option>
                                                        <?php foreach ($sql_doc as $doctor) { ?>
                                                            <option value="<?php echo $doctor->id_user ?>" <?php echo ($doctor->id_user == $sql_medc_hrv_rw->id_dokter ? 'selected' : '') ?>>
                                                                <?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . $doctor->nama . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>No. Sample</label>
                                                    <?php echo form_input(array('name' => 'no_sample', 'class' => 'form-control rounded-0', 'placeholder' => 'Masukkan nomor sample', 'autocomplete' => 'off', 'required' => 'required')); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Tanggal Pemeriksaan</label>
                                                    <input type="text" class="form-control datepicker rounded-0"
                                                        name="tgl_masuk" id="tgl_masuk" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>File Hasil Audiometri</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input rounded-0"
                                                            id="file_audiometri" name="file_audiometri" required
                                                            accept=".pdf,.jpg,.jpeg,.png">
                                                        <label class="custom-file-label" for="file_audiometri">Pilih
                                                            file...</label>
                                                    </div>
                                                    <small class="text-muted"><b class="text-danger">Format yang
                                                            diizinkan:</b> JPG, JPEG, PNG, <br />(Maks File : 2 MB)</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group <?php echo (!empty($hasError['kode']) ? 'text-danger' : '') ?>">
                                                    <label for="inputEmail3">Dokter Pemeriksa / Pembaca</label>
                                                    <select id="dokter" name="dokter"
                                                        class="form-control rounded-0 select2bs4 <?php echo (!empty($hasError['dokter']) ? ' is-invalid' : '') ?>">
                                                        <option value="0">- Dokter -</option>
                                                        <?php foreach ($sql_doc as $doctor) { ?>
                                                            <option value="<?php echo $doctor->id_user ?>" <?php echo ($doctor->id_user == $sql_medc_hrv_rw->id_dokter ? 'selected' : '') ?>>
                                                                <?php echo (!empty($doctor->nama_dpn) ? $doctor->nama_dpn . ' ' : '') . $doctor->nama . (!empty($doctor->nama_blk) ? ', ' . $doctor->nama_blk : '') ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Hasil Pemeriksaan</label>
                                            <textarea class="form-control rounded-0" name="hasil" rows="3"
                                                placeholder="Masukkan hasil pemeriksaan audiometri"
                                                autocomplete="off"></textarea>
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
                                    </div>
                                </form>
                            </div>
                            <?php echo br() ?>
                        <?php } ?>

                        <!-- Display Records -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-left">File</th>
                                    <th class="text-left">Petugas</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $audiometri_records = $this->db->where('id_medcheck', general::dekrip($this->input->get('id')))
                                    ->order_by('tgl_simpan', 'DESC')
                                    ->get('tbl_trans_medcheck_lab_audiometri')
                                    ->result();
                                foreach ($audiometri_records as $record) {
                                    ?>
                                    <tr>
                                        <td class="text-center" style="width: 50px;">
                                            <?php if (akses::hakSA() == TRUE or akses::hakOwner() == TRUE or akses::hakOwner2() == TRUE or $record->id_user == $this->ion_auth->user()->row()->id) { ?>
                                                <?php
                                                echo anchor(
                                                    base_url('medcheck/set_medcheck_lab_adm_delete.php?id=' . $this->input->get('id') .
                                                        '&item_id=' . general::enkrip($record->id) .
                                                        '&status=' . $this->input->get('status')),
                                                    '<i class="fas fa-trash"></i>',
                                                    'class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus data ini?\')"'
                                                )
                                                    ?>
                                            <?php } ?>
                                        </td>
                                        <td class="text-center"><?php echo $this->tanggalan->tgl_indo($record->tgl_masuk) ?>
                                        </td>
                                        <td class="text-left">
                                            <a href="<?php echo base_url('file/pasien/' . strtolower($sql_pasien->kode_dpn . $sql_pasien->kode) . '/audiometri/' . $record->nama_file) ?>"
                                                target="_blank">
                                                <i class="fas fa-file"></i> <?php echo $record->nama_file ?>
                                            </a>
                                            <b>Hasil : </b>
                                            <p><?php echo $record->hasil ?></p>
                                        </td>
                                        <td class="text-left">
                                            <?php echo $this->ion_auth->user($record->id_user)->row()->first_name ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo anchor(
                                                base_url('medcheck/cetak_audiometri.php?id=' . general::enkrip($record->id)),
                                                '<i class="fas fa-print"></i> Cetak',
                                                'class="btn btn-info btn-sm" target="_blank"'
                                            )
                                                ?>
                                        </td>
                                    </tr>
                                        <tr>
                                            <td></td>
                                            <td colspan="4" class="text-left">
                                                <?php echo $this->ion_auth->user($record->id_dokter_kirim)->row()->first_name ?>
                                            </td>
                                        </tr>
                                    <?php $no++; ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-flat"
                    onclick="window.location.href = '<?php echo base_url('medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)) ?>'"><i
                        class="fas fa-arrow-left"></i> Kembali</button>
            </div>
        </div>
    </div>
</div>

<!-- Add this to your existing script section -->
<script>
    $(document).ready(function () {
        // Initialize datepicker
        $('#tgl_masuk').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        });

        // Update file input label
        $(".custom-file-input").on("change", function () {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    });
</script>