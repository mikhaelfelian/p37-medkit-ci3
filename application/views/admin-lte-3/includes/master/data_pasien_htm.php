<?php
ob_get_clean();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="data_pasien_' . date('Ymd') . '.xls"');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
?>
<table style="width: 1366px; border: 1px;" border="1">
    <thead>
        <tr>
            <th style="text-align: center;">No.</th>
            <th style="text-align: left;">No. RM</th>
            <th style="text-align: left;">Pasien</th>
            <th style="text-align: center;">Tgl Lahir</th>
            <th style="text-align: left;">No. HP</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($sql_pasien)) {
            $no = 1;
            foreach ($sql_pasien as $pasien) {
                $sql_pas     = $this->db->where('status_pas', '2')->where('MONTH(tgl_lahir)', $pasien->bulan)->limit(150)->get('tbl_m_pasien')->result();
                ?>
                <tr>
                    <td style="width: 120px; text-align: left;" colspan="6"><?php echo $this->tanggalan->bulan_ke($pasien->bulan); ?></td>
                </tr>

                <?php foreach ($sql_pas as $pas) { ?>
                    <tr>
                        <td style="width: 40px; text-align: center;"></td>
                        <td style="width: 120px; text-align: left;"><?php echo $pas->kode_dpn.$pas->kode; ?></td>
                        <td style="width: 550px; text-align: left;"><?php echo $pas->nama; ?></td>
                        <td style="width: 120px; text-align: center;"><?php echo $this->tanggalan->tgl_indo2($pas->tgl_lahir); ?></td>
                        <td style="width: 30px; text-align: left;"><?php echo (!empty($pas->no_hp) ? '62'.substr($pas->no_hp, 1) : ''); ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </tbody>
</table>
<?php ob_end_flush(); ?>