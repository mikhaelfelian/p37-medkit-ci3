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
            <th width="40%"
                style="border-top: 1px solid #000; font-weight: bold; text-align: left; font-family: helvetica; font-size: 9pt;">
                PEMERIKSAAN</th>
            <th width="20%"
                style="border-top: 1px solid #000; font-weight: bold; text-align: left; font-family: helvetica; font-size: 9pt;">
                HASIL</th>
            <th width="20%"
                style="border-top: 1px solid #000; font-weight: bold; text-align: left; font-family: helvetica; font-size: 9pt;">
                NILAI RUJUKAN</th>
            <th width="20%"
                style="border-top: 1px solid #000; font-weight: bold; text-align: left; font-family: helvetica; font-size: 9pt;">
                SATUAN</th>
        </tr>
        <tr>
            <th width="40%"
                style="border-bottom: 1px solid #000; font-weight: bold; font-style: italic; text-align: left; font-family: helvetica; font-size: 9pt;">
                EXAMINATION</th>
            <th width="20%"
                style="border-bottom: 1px solid #000; font-weight: bold; font-style: italic; text-align: left; font-family: helvetica; font-size: 9pt;">
                RESULT</th>
            <th width="20%"
                style="border-bottom: 1px solid #000; font-weight: bold; font-style: italic; text-align: left; font-family: helvetica; font-size: 9pt;">
                REFERENCE VALUE</th>
            <th width="20%"
                style="border-bottom: 1px solid #000; font-weight: bold; font-style: italic; text-align: left; font-family: helvetica; font-size: 9pt;">
                MEASURE</th>
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
                    <td colspan="4" style="font-family: helvetica; font-size: 9pt;"><?php echo $sql_kat->keterangan; ?></td>
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
                        <td colspan="4" style="font-family: helvetica; font-size: 9pt;"><?php echo nbs(1) . $medc->item; ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($sql_lab)): ?>
                    <?php foreach ($sql_lab->result() as $lab): ?>
                        <?php //if ($sess_print[$i]['value'] == '1' and $sess_print[$i]['id_lab_hsl'] == $lab->id): ?>
                        <tr>
                            <td width="40%" style="font-family: helvetica; font-size: 9pt;">
                                <?php echo nbs(2) . '- ' . $lab->item_name; ?>
                            </td>
                            <td width="20%" style="font-family: helvetica; font-size: 9pt;"><?php
                            // Check if result should be highlighted in red
                            if ($lab->status_hsl_wrn == 1) {
                                echo '<span style="color: #F90B0B;">' . $lab->item_hasil . '</span>';
                            } else {
                                echo $lab->item_hasil;
                            }
                            ?></td>
                            <td width="20%" style="font-family: helvetica; font-size: 9pt;"><?php echo $lab->item_value; ?></td>
                            <td width="20%" style="font-family: helvetica; font-size: 9pt;"><?php echo $lab->item_satuan; ?></td>
                        </tr>
                        <?php // endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php $no++; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>

        <?php if (!empty($sql_medc_lab_rw->ket)): ?>
            <tr>
                <td colspan="4" style="font-family: helvetica; font-size: 9pt;">
                    <?php echo $sql_medc_lab_rw->ket; ?>
                </td>
            </tr>
        <?php endif; ?>

        <?php if (isset($sql_medc_lab) && $sql_medc_lab->status_duplo == '1'): ?>
            <tr>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td colspan="4"
                    style="font-style: italic; font-size: 0.9em; border-top: 1px solid #000; font-family: helvetica; font-size: 9pt;">
                    * Sudah dilakukan duplo
                </td>
            </tr>
        <?php else: ?>
            <tr>
                <td colspan="4" style="font-family: helvetica; font-size: 9pt; border-top: 1px solid #000;">
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php if (isset($sql_medc_lab) && $sql_medc_lab->status_cvd == '0' && !empty($sql_medc_lab->ket)): ?>
    <div style="margin-top: 10px;">
        <p style="font-weight: bold; font-size: 10pt; font-family: helvetica;">Catatan / Note</p>
        <p style="font-size: 9pt; font-family: helvetica;"><?php echo $sql_medc_lab->ket; ?></p>
    </div>
<?php elseif (isset($sql_medc_lab) && $sql_medc_lab->status_cvd != '0'): ?>
    <div style="margin-top: 10px;">
        <p style="font-weight: bold; font-size: 10pt; font-family: helvetica;">Catatan / Note</p>
        <div style="font-size: 9pt; margin-left: 10px; font-family: helvetica;">
            <p>1. Hasil positiv berlaku untuk hasil PCR SARS CoV-2 atau Antigen dari Laboratorium Klinik Utama Rawat Inap
                Esensia. Nilai tersebut tidak dapat dibandingkan dengan CT hasil PCR SARS CoV-2 atau Antigen dari
                laboratorium lain.</p>
            <p style="font-style: italic;">Positive results apply to PCR results for SARS CoV-2 or Antigens from the Esensia
                Inpatient Main
                Clinical Laboratory. This value cannot be compared with CT PCR results from SARS CoV-2 or Antigens from
                other laboratories.</p>

            <p>2. Kondisi tersebut hanya menggambarkan kondisi saat pengambilan sampel.</p>
            <p style="font-style: italic;">These conditions only describe the conditions at the time of sampling.</p>

            <p>3. Bila hasil positif dan terdapat gejala klinis, segera konsultasikan ke faskes.</p>
            <p style="font-style: italic;">These conditions only describe the conditions at the time of sampling.</p>

            <p>4. Bila hasil negatif tidak selalu berarti pasien tidak terinfeksi SARS CoV-2, dan perlu dilakukan
                pemeriksaan secara berkala.</p>
            <p style="font-style: italic;">A negative results does not necessarily mean that the patient is not infected
                with SARS-CoV-2, and
                periodic examinations need to be carried out.</p>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($sql_medc_lab) && $sql_medc_lab->status_normal == '1'): ?>
    <br /><br />
    <table border="0" cellspacing="0">
        <tr>
            <td
                style="font-weight: bold; font-size: 9pt; color: #312AEE; border: 1px solid #312AEE; text-align: center; font-family: helvetica;">
                PELAPORAN NILAI KRITIS
            </td>
            <td></td>
        </tr>
        <tr>
            <td width="25%" style="font-size: 9pt; color: #312AEE; border-left: 1px solid #312AEE; font-family: helvetica;">
                <strong>PETUGAS LABORATORIUM</strong>
            </td>
            <td width="25%"
                style="font-size: 9pt; color: #312AEE; border-left: 1px solid #312AEE; border-right: 1px solid #312AEE; font-family: helvetica;">
                <strong>DPJP</strong>
            </td>
            <td width="50%"></td>
        </tr>
        <tr>
            <td style="font-size: 9pt; color: #312AEE; border-left: 1px solid #312AEE; font-family: helvetica;">
                <strong>Tanggal</strong>
            </td>
            <td
                style="font-size: 9pt; color: #312AEE; border-left: 1px solid #312AEE; border-right: 1px solid #312AEE; font-family: helvetica;">
                <strong>Tanggal</strong>
            </td>
            <td></td>
        </tr>
        <tr>
            <td style="font-size: 9pt; color: #312AEE; border-left: 1px solid #312AEE; font-family: helvetica;">
                <strong>Jam</strong>
            </td>
            <td
                style="font-size: 9pt; color: #312AEE; border-left: 1px solid #312AEE; border-right: 1px solid #312AEE; font-family: helvetica;">
                <strong>Jam</strong>
            </td>
            <td></td>
        </tr>
        <tr>
            <td style="font-size: 9pt; color: #312AEE; border-left: 1px solid #312AEE; font-family: helvetica;">
                <strong>Nama</strong>
            </td>
            <td
                style="font-size: 9pt; color: #312AEE; border-left: 1px solid #312AEE; border-right: 1px solid #312AEE; font-family: helvetica;">
                <strong>Nama</strong>
            </td>
            <td></td>
        </tr>
        <tr>
            <td
                style="font-size: 9pt; color: #312AEE; border-left: 1px solid #312AEE; border-bottom: 1px solid #312AEE; font-family: helvetica;">
                <strong>TTD</strong>
            </td>
            <td
                style="font-size: 9pt; color: #312AEE; border-left: 1px solid #312AEE; border-right: 1px solid #312AEE; border-bottom: 1px solid #312AEE; font-family: helvetica;">
                <strong>TTD</strong>
            </td>
            <td></td>
        </tr>
    </table>
<?php endif; ?>

<div style="margin-top: 20px;">
    <table border="0" cellpadding="3" cellspacing="0">
        <tr>
            <td colspan="2" width="55%"></td>
            <td width="45%" style="text-align: center; font-family: helvetica; font-size: 9pt;">Semarang,
                <?php echo $this->tanggalan->tgl_indo3($sql_medc_lab->tgl_masuk); ?>
            </td>
        </tr>
        <tr>
            <td width="15%" style="text-align: center; font-family: helvetica; font-size: 9pt;">
                <strong>Validasi</strong>
            </td>
            <td width="40%" style="text-align: left;"></td>
            <td width="45%" style="text-align: center; font-family: helvetica; font-size: 9pt;"><strong>Dokter
                    Pemeriksa</strong></td>
        </tr>
        <tr>
            <td width="15%" style="text-align: center;">
                <?php
                // Generate QR code for validation using QRlib
                if (isset($sql_pasien) && isset($setting)):
                    // Load QR library
                    require_once APPPATH . 'third_party/phpqrcode/qrlib.php';

                    $folder_path = FCPATH . '/file/pasien/' . strtolower($sql_pasien->kode_dpn . $sql_pasien->kode);
                    if (!file_exists($folder_path)) {
                        mkdir($folder_path, 0777, true);
                    }

                    // Generate validation QR code
                    $qr_validasi = $folder_path . '/qr-validasi-' . strtolower($sql_pasien->kode_dpn . $sql_pasien->kode) . '.png';
                    $validasi_text = 'Telah diverifikasi dan ditandatangani secara elektronik oleh manajemen ' . $setting->judul . '. Pasien a/n. ' . general::bersih($sql_pasien->nama_pgl);

                    // Generate QR code using QRlib
                    \QRcode::png($validasi_text, $qr_validasi, QR_ECLEVEL_H, 2, 2);

                    // Display the QR code in the PDF
                    if (file_exists($qr_validasi)) {
                        echo '<img src="' . $qr_validasi . '" style="width: 80px; height: 80px;">';
                    }
                endif;
                ?>
            </td>
            <td width="40%" style="text-align: left;"></td>
            <td width="45%" style="text-align: center;">
                <?php
                // Generate QR code for doctor using QRlib
                if (isset($sql_pasien) && isset($sql_dokter2)):
                    // Load QR library if not already loaded
                    if (!function_exists('\QRcode::png')) {
                        require_once APPPATH . 'third_party/phpqrcode/qrlib.php';
                    }

                    $folder_path = FCPATH . '/file/pasien/' . strtolower($sql_pasien->kode_dpn . $sql_pasien->kode);
                    if (!file_exists($folder_path)) {
                        mkdir($folder_path, 0777, true);
                    }

                    // Generate doctor QR code
                    $qr_dokter = $folder_path . '/qr-dokter-' . strtolower($sql_dokter2->id) . '.png';
                    $dokter_text = 'Telah diverifikasi dan ditandatangani secara elektronik oleh dokter penanggung jawab [' . (!empty($sql_dokter2->nama_dpn) ? $sql_dokter2->nama_dpn . ' ' : '') . $sql_dokter2->nama . (!empty($sql_dokter2->nama_blk) ? ', ' . $sql_dokter2->nama_blk : '') . ']';

                    // Generate QR code using QRlib
                    \QRcode::png($dokter_text, $qr_dokter, QR_ECLEVEL_H, 2, 2);

                    // Display the QR code in the PDF
                    if (file_exists($qr_dokter)) {
                        echo '<img src="' . $qr_dokter . '" style="width: 80px; height: 80px;">';
                    }
                endif;
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td width="45%" style="text-align: center; font-family: helvetica; font-size: 9pt;">
                <?php if (isset($sql_medc_lab) && isset($sql_dokter2)): ?>
                    <?php if (!empty($sql_dokter_pem->nama_dpn)): ?>
                        <?php echo (!empty($sql_dokter_pem->nama_dpn) ? $sql_dokter_pem->nama_dpn . ' ' : '') . $sql_dokter_pem->nama . (!empty($sql_dokter_pem->nama_blk) ? ', ' . $sql_dokter_pem->nama_blk : ''); ?>
                    <?php else: ?>
                        <?php echo (!empty($sql_dokter2->nama_dpn) ? $sql_dokter2->nama_dpn . ' ' : '') . $sql_dokter2->nama . (!empty($sql_dokter2->nama_blk) ? ', ' . $sql_dokter2->nama_blk : ''); ?>
                        <br>
                        <?php echo (isset($sql_dokter2->nik) ? $sql_dokter2->nik : ''); ?>
                    <?php endif; ?>
                <?php endif; ?>
            </td>
        </tr>
    </table>
</div>