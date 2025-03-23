<?php
ob_get_clean();
// Redirect output to a client’s web browser (Excel5)
//header('Content-Type: application/vnd.ms-excel');
 header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="data_omset_jasa_' . date('Ymd') . '.xls"');

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
            <th style="text-align: left;">Tgl</th>
            <th style="text-align: left;">Pasien</th>
            <th style="text-align: center;">Tipe</th>
            <th style="text-align: left;">Dokter</th>
            <th style="text-align: center;">No. Faktur</th>
            <th style="text-align: left;">Group</th>
            <th style="text-align: left;">Kode</th>
            <th style="text-align: left;">Item</th>
            <th style="text-align: center;">Qty</th>
            <th style="text-align: right;">Harga</th>
            <th style="text-align: right;">Subtotal</th>
            <th style="text-align: right;">Diskon</th>
            <th style="text-align: right;">Potongan</th>
            <th style="text-align: right;">Grand Total</th>
            <th style="text-align: right;">Jasa Dokter</th>
            <th style="text-align: right;">Total Jasa</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($sql_omset)) {
            $no = 1; $total = 0; $total_js = 0; $total_gt=0;
            foreach ($sql_omset as $penjualan) {
                $remun      = $this->db->where('id_medcheck_det', $penjualan->id_medcheck_det)->get('tbl_trans_medcheck_remun')->row();
                $produk     = $this->db->where('id', $penjualan->id_item)->get('tbl_m_produk')->row();
                $dokter     = $this->db->where('id_user', $penjualan->id_dokter)->get('tbl_m_karyawan')->row();
                $remun_nom  = ($remun->remun_tipe == '2' ? $remun->remun_nom : (($remun->remun_perc / 100) * $penjualan->harga));
                $harga      = (!empty($penjualan->resep) ? $produk->harga_jual : $penjualan->harga);
                $subtot     = $harga * $penjualan->jml;
                $disk1      = $harga - (($penjualan->disk1 / 100) * $harga);
                $disk2      = $disk1 - (($penjualan->disk2 / 100) * $disk1);
                $disk3      = $disk2 - (($penjualan->disk3 / 100) * $disk2);
                $harga_tot  = $disk3 - $penjualan->potongan;
                $harga_disk = $harga - $disk3;
                $total_gt   = $total_gt + $harga_tot;
                ?>
                <tr>
                    <td style="width: 40px; text-align: center;">
                        <?php echo $no++ ?>.
                    </td>
                    <td style="width: 120px; text-align: left;"><?php echo $this->tanggalan->tgl_indo5($penjualan->tgl_simpan); ?></td>
                    <td style="width: 350px; text-align: left;"><?php echo $penjualan->nama_pgl; ?></td>
                    <td style="width: 120px; text-align: center;"><?php echo general::status_rawat2($penjualan->tipe); ?></td>
                    <td style="width: 350px; text-align: left;"><?php echo (!empty($dokter->nama_dpn) ? $dokter->nama_dpn.' ' : '').$dokter->nama.(!empty($dokter->nama_blk) ? ', '.$dokter->nama_blk : ''); ?></td>
                    <td style="width: 100px; text-align: center;"><?php echo $penjualan->no_rm ?></td>
                    <td style="width: 150px; text-align: left;"><?php echo $penjualan->kategori ?></td>
                    <td style="width: 100px; text-align: left;"><?php echo $produk->kode ?></td>
                    <td style="width: 325px; text-align: left;"><?php echo $penjualan->item ?></td>
                    <td style="width: 60px; text-align: center;"><?php echo (float)$penjualan->jml ?></td>
                    <td style="width: 100px; text-align: right;"><?php echo (float)$harga; ?></td>
                    <td style="width: 100px; text-align: right;"><?php echo (float)$subtot; ?></td>
                    <td style="width: 100px; text-align: right;"><?php echo (float)$harga_disk; ?></td>
                    <td style="width: 100px; text-align: right;"><?php echo (float)$penjualan->potongan; ?></td>
                    <td style="width: 100px; text-align: right;"><?php echo (float)$harga_tot; ?></td>
                    <td style="width: 100px; text-align: right;"><?php echo (float)$remun_nom; ?></td>
                    <td style="width: 100px; text-align: right;"><?php echo (float)$remun->remun_subtotal; ?></td>
                </tr>

                <?php $tot_disk_rc = 0; $tot_subt_rc=0; $tot_pot_rc=0; $tot_gt_rc=0; ?>
                <?php foreach (json_decode($penjualan->resep) as $resep) { ?>
                    <?php $produk_rc     = $this->db->where('id', $resep->id_item)->get('tbl_m_produk')->row(); ?>
                    <?php
                        $subtot_rc  = $resep->harga * $resep->jml;
                        $harga_rc   = $resep->harga;
                        $disk1_rc   = $harga_rc - (($resep->disk1 / 100) * $harga_rc);
                        $disk2_rc   = $disk1_rc - (($resep->disk2 / 100) * $disk1_rc);
                        $disk3_rc   = $disk2_rc - (($resep->disk3 / 100) * $disk2_rc);
                        $harga_totrc= $disk3_rc - $resep->potongan;
                        $diskon_rc  = $resep->harga - $harga_rc;
                        $tot_subt_rc= $tot_subt_rc + $subtot_rc;
                        $tot_disk_rc= $tot_disk_rc + $diskon_rc;
                        $tot_pot_rc = $tot_pot_rc + $resep->potongan;
                        $tot_gt_rc  = $tot_gt_rc + $harga_totrc;
                    ?>
                    <tr>
                        <td style="width: 40px; text-align: center;"></td>
                        <td style="width: 120px; text-align: left;"></td>
                        <td style="width: 350px; text-align: left;"></td>
                        <td style="width: 120px; text-align: center;"></td>
                        <td style="width: 350px; text-align: left;"></td>
                        <td style="width: 100px; text-align: center;"></td>
                        <td style="width: 150px; text-align: left;"></td>
                        <td style="width: 100px; text-align: left;"><?php echo $produk_rc->kode ?></td>
                        <td style="width: 325px; text-align: left;"> - <?php echo $resep->item ?></td>
                        <td style="width: 60px; text-align: center;"><?php echo (float)$resep->jml ?></td>
                        <td style="width: 100px; text-align: right;"><?php echo (float)$resep->harga; ?></td>
                        <td style="width: 100px; text-align: right;"><?php echo (float)$resep->subtotal; ?></td>
                        <td style="width: 100px; text-align: right;"><?php echo (float)$diskon_rc;  ?></td>
                        <td style="width: 100px; text-align: right;"><?php echo (float)$resep->potongan;  ?></td>
                        <td style="width: 100px; text-align: right;"><?php echo (float)$harga_totrc;  ?></td>
                        <td style="width: 100px; text-align: right;"></td>
                        <td style="width: 100px; text-align: right;"></td>
                    </tr>
                <?php } ?>
                <?php                 
                    $total      = $total + $subtot + $tot_subt_rc;
                    $total_disk = $total_disk + $harga_disk + $tot_disk_rc;
                    $total_pot  = $total_pot + $penjualan->potongan;
                    $total_grand= $total_gt + $tot_gt_rc;
                    $total_js   = $total_js + $remun->remun_subtotal;
                ?>
            <?php } ?>
                    <tr>
                        <td style="text-align: right; font-weight: bold;" colspan="11">TOTAL</td>
                        <td style="width: 100px; text-align: right; font-weight: bold;"><?php echo (float)$total ?></td>
                        <td style="width: 100px; text-align: right; font-weight: bold;"><?php echo (float)$total_disk ?></td>
                        <td style="width: 100px; text-align: right; font-weight: bold;"><?php echo (float)$total_pot ?></td>
                        <td style="width: 100px; text-align: right; font-weight: bold;"><?php echo (float)$total_grand ?></td>
                        <td style="width: 100px; text-align: right; font-weight: bold;"><?php echo (float)$total_js ?></td>
                        <td style="width: 100px; text-align: right; font-weight: bold;"></td>
                    </tr>
        <?php } ?>
    </tbody>
</table>
<?php ob_end_flush(); ?>