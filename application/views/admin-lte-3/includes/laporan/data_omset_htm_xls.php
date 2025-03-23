<?php
ob_get_clean();
// Redirect output to a client’s web browser (Excel5)
//header('Content-Type: application/vnd.ms-excel');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="sales-invoice-'.date('dmYH').'.xls"');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 15 Feb 1992 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
?>
<table style="width: 1366px; border: 1px;" border="1">
    <thead>
        <tr>
            <th style="text-align: center;">date</th>
            <th style="text-align: center;">number</th>
            <th style="text-align: center;">patient</th>
            <th style="text-align: center;">description</th>
            <th style="text-align: center;">customer.code</th>
            <th style="text-align: center;">orders[0].number</th>
            <th style="text-align: center;">currency.code</th>
            <th style="text-align: center;">exchange_rate</th>
            <th style="text-align: center;">department.code</th>
            <th style="text-align: center;">project.code</th>
            <th style="text-align: center;">warehouse.code</th>
            <th style="text-align: center;">line_items.product.code</th>
            <th style="text-align: center;">line_items.account.code</th>
            <th style="text-align: center;">line_items.unit.code</th>
            <th style="text-align: center;">line_items.quantity</th>
            <th style="text-align: center;">line_items.unit_price</th>
            <th style="text-align: center;">line_items.discount.rate</th>
            <th style="text-align: center;">line_items.discount.amount</th>
            <th style="text-align: center;">line_items.description</th>
            <th style="text-align: center;">line_items.taxes[0].code</th>
            <th style="text-align: center;">line_items.department.code</th>
            <th style="text-align: center;">line_items.project.code</th>
            <th style="text-align: center;">line_items.warehouse.code</th>
            <th style="text-align: center;">line_items.note</th>
            <th style="text-align: center;">payments[0].is_cash</th>
            <th style="text-align: center;">payments[0].account.code</th>
            <th style="text-align: center;">status</th>
            <th style="text-align: center;">term_of_payments[0].discount_days</th>
            <th style="text-align: center;">term_of_payments[0].due_date</th>
            <th style="text-align: center;">term_of_payments[0].due_days</th>
            <th style="text-align: center;">term_of_payments[0].early_discount_rate</th>
            <th style="text-align: center;">term_of_payments[0].late_charge_rate</th>
            <th style="text-align: center;">document.number</th>
            <th style="text-align: center;">document.date</th>
            <th style="text-align: center;">parent_memo.number</th>
            <th style="text-align: center;">employees[0].contact.code</th>
            <th style="text-align: center;">delivery_dates</th>
            <th style="text-align: center;">others[0].amount_origin</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($sql_omset)) {
            $no = 1;
            $total = 0;
            $total_js = 0;
            foreach ($sql_omset as $omset) {
                $sql_plat       = $this->db->select('tbl_trans_medcheck_plat.id, tbl_trans_medcheck_plat.id_platform, tbl_m_platform.platform AS metode, tbl_trans_medcheck_plat.platform, tbl_trans_medcheck_plat.keterangan, tbl_trans_medcheck_plat.nominal, tbl_m_platform.status_akt')
                                           ->where('tbl_trans_medcheck_plat.id_medcheck', $omset->id)
                                           ->join('tbl_m_platform', 'tbl_m_platform.id=tbl_trans_medcheck_plat.id_platform', 'left')
                                           ->get('tbl_trans_medcheck_plat');
                $sql_plat2      = $this->db->where('id', $omset->metode)->get('tbl_m_platform')->row();
                $id_rc          = (empty($omset->resep) ? $omset->id_item : '');
                $sql_item_rc    = $this->db->where('id', $omset->id_item)->get('tbl_m_produk')->row();
                $harga      = (!empty($omset->resep) ? $sql_item_rc->harga_jual : $omset->harga);
                $disk1      = $harga - (($omset->disk1 / 100) * $harga);
                $disk2      = $disk1 - (($omset->disk2 / 100) * $disk1);
                $disk3      = $disk2 - (($omset->disk3 / 100) * $disk2);
                $disk       = $harga - $disk3 - $omset->potongan;
                $diskon     = ($disk / $harga) * 100;
                
//                if(empty($omset->resep)){
                ?>
                <tr>
                    <td style="text-align: left;"><?php echo $this->tanggalan->tgl_indo7($omset->tgl_simpan); ?></td>
                    <td style="text-align: left;"><?php echo $omset->no_akun ?></td>
                    <td style="text-align: left;"><?php echo $omset->pasien ?></td>
                    <td style="text-align: left;">
                        <?php
                        $is_split = ($sql_plat->num_rows() > 1 ? 'SPLIT' : ($sql_plat2->status_akt == '1' ? strtoupper($sql_plat2->platform) : 'PIUTANG'));                        
                        echo $is_split;

//                            foreach ($sql_plat->result() as $plat) {
//                                $platform = ($plat->id_platform == '1' ? 'CASH' : ($plat->status_akt != '2' ? strtoupper($plat->metode) : 'PIUTANG'));
//                                echo $platform.($sql_plat->num_rows() > 1 ? '; ' : '');
//                            }
                        ?>
                    </td>
                    <td style="text-align: center;"><?php echo ($sql_plat2->status_akt == '1' ? 'UMUM' : $sql_plat2->kode) ?></td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;">IDR</td>
                    <td style="text-align: center;">1</td>
                    <td style="text-align: center;">99</td>
                    <td style="text-align: center;">N/A</td>
                    <td style="text-align: center;">99</td>
                    <td style="text-align: center;"><?php echo $omset->kode_item ?></td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: left;"><?php echo (!empty($omset->satuan) ? strtolower(ucfirst($omset->satuan)) : 'Pcs') ?></td>
                    <td style="text-align: center;"><?php echo (float) ($omset->jml > 0 ? $omset->jml : '') ?></td>
                    <td style="text-align: right;"><?php echo (float) (!empty($omset->resep) ? $sql_item_rc->harga_jual : $omset->harga) ?></td>
                    <td style="text-align: right;"><?php echo round($diskon, 2) ?></td>
                    <td style="text-align: right;"><?php echo $omset->potongan ?></td>
                    <td style="text-align: left;"><?php echo $omset->item ?></td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;">99</td>
                    <td style="text-align: center;">N/A</td>
                    <td style="text-align: center;">99</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"><?php echo ($omset->metode == '1' ? 'TRUE' : 'FALSE'); ?></td>
                    <td style="text-align: center;"><?php echo $sql_plat2->akun ?></td>
                    <td style="text-align: center;">draft</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"><?php echo $this->tanggalan->tgl_indo7($omset->tgl_masuk) ?></td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"><?php echo $this->tanggalan->tgl_indo7($omset->tgl_masuk) ?></td>
                    <td style="text-align: center;"></td>
                </tr>
                <?php // } ?>

                <?php foreach (json_decode($omset->resep) as $resep) { ?>
                    <tr>
                        <td style="text-align: left;"><?php echo $this->tanggalan->tgl_indo7($omset->tgl_simpan); ?></td>
                        <td style="text-align: left;"><?php echo $omset->no_akun ?></td>
                        <td style="text-align: left;"><?php echo $omset->pasien ?></td>
                        <td style="text-align: left;">
                        <?php
                            $is_split_rc = ($sql_plat->num_rows() > 1 ? 'SPLIT' : ($sql_plat2->status_akt == '1' ? strtoupper($sql_plat2->platform) : 'PIUTANG'));
                            echo $is_split_rc;
//                            foreach ($sql_plat->result() as $plat) {
//                                $platform = ($plat->id_platform == '1' ? 'CASH' : ($plat->status_akt != '2' ? strtoupper($plat->metode) : 'PIUTANG')) . ' ';
//                                echo $platform.($sql_plat->num_rows() > 1 ? '; ' : '');
//                            }
                        ?>
                        </td>
                        <td style="text-align: center;"><?php echo ($sql_plat2->status_akt == '1' ? 'UMUM' : $sql_plat2->kode) ?></td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;">IDR</td>
                        <td style="text-align: center;">1</td>
                        <td style="text-align: center;">99</td>
                        <td style="text-align: center;">N/A</td>
                        <td style="text-align: center;">99</td>
                        <td style="text-align: center;"><?php echo $resep->kode ?></td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: left;"><?php echo (!empty($resep->satuan) ? strtolower(ucfirst($omset->satuan)) : 'Pcs') ?></td>
                        <td style="text-align: center;"><?php echo (float) $resep->jml ?></td>
                        <td style="text-align: right;"><?php echo (float) $resep->harga ?></td>
                        <td style="text-align: right;;">0</td>
                        <td style="text-align: right;">0</td>
                        <td style="text-align: left;"><?php echo $resep->item ?></td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;">99</td>
                        <td style="text-align: center;">N/A</td>
                        <td style="text-align: center;">99</td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;"><?php echo ($omset->metode == '1' ? 'TRUE' : 'FALSE'); ?></td>
                        <td style="text-align: center;"><?php echo $sql_plat2->akun ?></td>
                        <td style="text-align: center;">draft</td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;"><?php echo $this->tanggalan->tgl_indo7($omset->tgl_masuk) ?></td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;"></td>
                        <td style="text-align: center;"><?php echo $this->tanggalan->tgl_indo7($omset->tgl_masuk) ?></td>
                        <td style="text-align: center;"></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </tbody>
</table>
<?php ob_end_flush(); ?>