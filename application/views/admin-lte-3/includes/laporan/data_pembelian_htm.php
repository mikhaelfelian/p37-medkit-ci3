<?php
ob_get_clean();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="data_pembelian_' . date('Ymd') . '.xls"');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
?>
<table class="table table-striped">
    <thead>
        <tr>
            <th style="text-align: center;">No.</th>
            <th style="text-align: left;">Faktur</th>
            <th style="text-align: left;">Item</th>
            <th style="text-align: right;">Harga</th>
            <th style="text-align: right;">HET</th>
            <th style="text-align: right;">Diskon</th>
            <th style="text-align: center;">Jml</th>
            <th style="text-align: right;">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($sql_pembelian)) {
            $no = 1;;
            foreach ($sql_pembelian as $beli) {
                $sql_beli_det = $this->db->select('*')
                                ->where('tbl_trans_beli_det.id_pembelian', $beli->id)
                                ->get('tbl_trans_beli_det')->result();
                ?>
                <tr>
                    <td style="text-align: center; width: 50px"><?php echo $no ?></td>
                    <td class="text-left" style="width: 150px;">
                        <?php echo $beli->no_nota ?>
                        <span class="mailbox-read-time float-left"><?php echo $this->tanggalan->tgl_indo($beli->tgl_masuk); ?></span>
                    </td>
                    <td class="text-left" style="width: 450px;" colspan="5">
                        <b><?php echo $beli->nama; ?></b>
                    </td>
                    <td class="text-right" style="width: 100px;">
                        <b><?php echo general::format_angka($beli->jml_gtotal); ?></b>
                    </td>
                </tr>
                <?php $jml_subtot = 0; ?>
                <?php foreach ($sql_beli_det as $beli_det) { ?>
                    <?php $jml_subtot = $jml_subtot + $beli_det->subtotal; ?>
                    <tr>
                        <td class="text-center" colspan="2">

                        </td>
                        <td class="text-left" style="width: 350px;">
                            <!--<i class="text-left"><?php echo $beli_det->kode_batch ?></i><br/>-->
                            <i><?php echo $beli_det->produk.(!empty($beli_det->kode_batch) ? ' ('.$beli_det->kode_batch.')' : '').($beli_det->tgl_ed != '0000-00-00' ? ' / ('.$this->tanggalan->tgl_indo2($beli_det->tgl_ed).')' : '') ?></i><br/>
                            <!--<i class="text-left"><?php echo $this->tanggalan->tgl_indo2($beli_det->tgl_ed) ?></i>-->
                        </td>
                        <td class="text-right" style="width: 100px;">
                            <?php echo general::format_angka($beli_det->harga); ?>
                        </td>
                        <td class="text-right" style="width: 100px;">
                            <?php echo general::format_angka($beli_det->harga_het); ?>
                        </td>
                        <td class="text-right" style="width: 100px;">
                            <?php echo ($beli_det->diskon > 0 || $beli_det->potongan > 0 ? (float) $beli_det->diskon + $beli_det->potongan : '0') ?>
                        </td>
                        <td class="text-right" style="width: 100px;">
                            <?php echo (float) $beli_det->jml; ?>
                        </td>
                        <td class="text-right" style="width: 100px;">
                            <?php echo general::format_angka($beli_det->subtotal); ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td style="font-weight: bold; text-align: right;" colspan="7">Subtotal</td>
                    <td style="font-weight: bold; text-align: right;"><?php echo general::format_angka($jml_subtot) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; text-align: right;" colspan="7">Diskon</td>
                    <td style="font-weight: bold; text-align: right;"><?php echo general::format_angka($beli->jml_diskon) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; text-align: right;" colspan="7">PPN</td>
                    <td style="font-weight: bold; text-align: right;"><?php echo general::format_angka($beli->jml_ppn) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; text-align: right;" colspan="7">Grand Total</td>
                    <td style="font-weight: bold; text-align: right;"><?php echo general::format_angka($beli->jml_gtotal) ?></td>
                </tr>
                <tr>
                    <td colspan="8" style="background-color: #17a2b8;"></td>
                </tr>
                <?php $no++ ?>
            <?php } ?>
        <?php } ?>
    </tbody>
</table>
<?php ob_end_flush(); ?>