<?php
/**
 * Medical Check Lab Results View
 * 
 * View for displaying medical check lab results
 * 
 * @author Mikhael Felian Waskito - mikhaelfelian@gmail.com
 * @date 2025-04-08
 */

// Initialize $sql_lab_rws if not set
if (!isset($sql_lab_rws)) {
    $sql_lab_rws = $this->db->where('id_medcheck', $sql_medc->id)->get('tbl_trans_medcheck_lab');
}

$sess_print = $this->session->userdata('lab_print');
?>
<!-- Lab Results -->
<table>
    <thead>
        <tr>
            <th>PEMERIKSAAN</th>
            <th>HASIL</th>
            <th>NILAI RUJUKAN</th>
            <th>SATUAN</th>
        </tr>
        <tr>
            <th>EXAMINATION</th>
            <th>RESULT</th>
            <th>REFERENCE VALUE</th>
            <th>MEASURE</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        $i = 0; ?>
        <?php foreach ($sql_medc_lab_det as $det): ?>
            <?php $sql_kat = $this->db->where('id', $det->id_lab_kat)->get('tbl_m_kategori')->row(); ?>
            <?php $sql_det = $this->db->where('id_medcheck', $det->id_medcheck)
                ->where('id_lab', $det->id_lab)
                ->where('id_lab_kat', $det->id_lab_kat)
                ->where('status_ctk', '1')
                ->get('tbl_trans_medcheck_det')->result();
            ?>
            <?php if (strtoupper($sql_kat->keterangan) != strtoupper($det->item)): ?>
                <tr>
                    <td colspan="4"><?php echo $sql_kat->keterangan; ?></td>
                </tr>
            <?php endif; ?>

            <?php foreach ($sql_det as $medc): ?>
                <?php
                // Get lab results with proper null checks
                $sql_lab = null;
                if (isset($sql_lab_rws) && $sql_lab_rws->num_rows() > 1) {
                    $sql_lab = $this->db->where('id_medcheck', $medc->id_medcheck)
                        ->where('id_lab', general::dekrip($this->input->get('id_lab')))
                        ->where('id_item', $medc->id_item)
                        ->get('tbl_trans_medcheck_lab_hsl');
                } else {
                    $sql_lab = $this->db->where('id_medcheck', $medc->id_medcheck)
                        ->where('id_item', $medc->id_item)
                        ->get('tbl_trans_medcheck_lab_hsl');
                }
                ?>
                <?php if (strtoupper($sql_lab->row()->item_name) != strtoupper($medc->item)): ?>
                    <tr>
                        <td colspan="4"><?php echo nbs(1) . $medc->item; ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($sql_lab)): ?>
                    <?php foreach ($sql_lab->result() as $lab): ?>
                        <?php if (!isset($sess_print[$i]) || (isset($sess_print[$i]) && $sess_print[$i]['value'] == '1' && $sess_print[$i]['id_lab_hsl'] == $lab->id)): ?>
                        <tr>
                            <td width="40%">
                                <?php echo nbs(2) . '- ' . $lab->item_name; ?>
                            </td>
                            <td><?php echo $lab->item_hasil; ?></td>
                            <td><?php echo $lab->item_value; ?></td>
                            <td><?php echo $lab->item_satuan; ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php $no++; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>

        <?php if (!empty($sql_medc_lab_rw->ket)): ?>
            <tr>
                <td colspan="4">
                    <?php echo $sql_medc_lab_rw->ket; ?>
                </td>
            </tr>
        <?php endif; ?>

        <?php if (isset($sql_medc_lab) && $sql_medc_lab->status_duplo == '1'): ?>
            <tr>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td colspan="4">
                    * Sudah dilakukan duplo
                </td>
            </tr>
        <?php else: ?>
            <tr>
                <td colspan="4"></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>