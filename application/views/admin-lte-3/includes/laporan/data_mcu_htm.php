<?php
ob_get_clean();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="data_rekap_mcu_' . date('Ymd') . '.xls"');

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
            <th style="text-align: left;">Pasien</th>
            <th style="text-align: left;">Saran</th>
            <th style="text-align: left;">Kesimpulan</th>
            <?php foreach ($sql_mcu_hdr->result() as $mcu_hdr) { ?>
                <th class="text-left"><?php echo $mcu_hdr->param ?></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($sql_mcu)) {
            $no = 1;
            foreach ($sql_mcu as $mcu) {
                $sql_mcu_det = $this->db->where('id_resume', $mcu->id)->get('tbl_trans_medcheck_resume_det');
                ?>
                <tr>
                    <td style="width: 40px; text-align: center;">
                        <?php echo $no++ ?>.
                    </td>
                    <td style="width: 350px; text-align: left;">                       
                        <?php echo $mcu->nama_pgl; ?>
                        <?php $jm_rows = $sql_mcu_hdr->num_rows() - $sql_mcu_det->num_rows(); // ?>
                    </td>
                    <td style="width: 350px; text-align: left;">                        
                        <?php echo $mcu->saran; ?>
                    </td>
                    <td style="width: 350px; text-align: left;">                        
                        <?php echo $mcu->kesimpulan; ?>
                    </td>
                    <?php foreach ($sql_mcu_det->result() as $mcu_det) { ?>
                        <td style="width: 200px;">
                            <?php echo $mcu_det->param_nilai; ?>
                        </td>
                    <?php } ?>
                    <?php if ($jm_rows > 0) { ?>
                        <td colspan="<?php echo $jm_rows ?>"></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        <?php } ?>
    </tbody>
</table>
<?php ob_end_flush(); ?>