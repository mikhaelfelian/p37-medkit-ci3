<div class="card">
    <div class="card-header">
        <h3 class="card-title">RUANG PERAWATAN - <?php echo $sql_pasien->nama_pgl; ?> <small><i>(<?php echo $this->tanggalan->usia($sql_pasien->tgl_lahir) ?>)</i></small></h3>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center">No.</th>
                    <th class="text-left">Ruang</th>
                    <th class="text-center">Terpakai</th>
                    <th class="text-center">Kapasitas</th>
                    <th class="text-center">#</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($sql_kamar->result() as $ruang) { ?>
                    <tr>
                        <td class="text-center"><?php echo $no; ?></td>
                        <td class="text-left"><?php echo $ruang->kamar; ?></td>
                        <td class="text-center"><?php echo $ruang->jml; ?></td>
                        <td class="text-center"><?php echo $ruang->jml_max; ?></td>
                        <td class="text-left">
                            <?php echo anchor(base_url('medcheck/tambah.php?act=kmr_input&id=' . $this->input->get('id') . '&id_item=' . general::enkrip($ruang->id) . '&status=' . $this->input->get('status')), '<i class="fa fa-plus"></i> Input', 'class="btn btn-primary btn-flat btn-xs"') ?>
                        </td>
                    </tr>
                    <?php $no++; ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <a class="btn btn-primary btn-flat" href="<?php echo base_url('medcheck/tindakan.php?id=' . general::enkrip($sql_medc->id)) ?>">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="col-lg-6 text-right">

            </div>
        </div>
    </div>
</div>