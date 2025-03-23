<table class="table table-striped">
    <thead>
        <tr>
            <th>No.</th>
            <th>ID</th>
            <th class="text-left">Pasien</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Pendaftaran</th>
            <th class="text-center">PX Dokter</th>
            <th class="text-center">Selesai</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($sql_tracer)) {
            $no = (!empty($_GET['halaman']) ? $_GET['halaman'] + 1 : 1);
            foreach ($sql_tracer as $trace) {
                ?>
                <tr>
                    <td class="text-center" style="width: 10px">
                        <?php echo $no++ ?>.
                    </td>
                    <td class="text-left" style="width: 150px;">
                        <?php echo anchor(base_url('medcheck/detail.php?id=' . general::enkrip($trace->id) . '&route=laporan/data_stok_keluar.php'), '#' . $trace->no_rm, 'class="text-default" target="_blank"') ?>
                        <?php echo br(); ?>
                        <span class="mailbox-read-time float-left"><?php echo $this->tanggalan->tgl_indo5($trace->tgl_simpan); ?></span>
                    </td>
                    <td class="text-left" style="width: 450px;">
                        <b><?php echo $trace->nama_pgl; ?></b>
                        <?php echo br(); ?>
                        <small><?php echo $trace->supplier; ?></small>
                    </td>
                    <td class="text-center">
                        <?php echo $this->tanggalan->tgl_indo($trace->tanggal); ?>
                    </td>
                    <td class="text-center">
                        <?php echo $this->tanggalan->tgl_indo5($trace->wkt_daftar); ?>
                    </td>
                    <td class="text-center">
                        <?php echo $this->tanggalan->tgl_indo5($trace->wkt_periksa); ?>
                    </td>
                    <td class="text-center">
                        <?php echo $this->tanggalan->tgl_indo5($trace->wkt_selesai); ?>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    </tbody>
</table>