<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php

require(APPPATH . '/libraries/fpdf.php');

/**
 * Description of Pdf
 *
 * @author mike
 */
class MedResepPDF extends FPDF {

    private $nm_dokter;
    private $no_sip;

    public function header($dokter, $no_sip) {
        $CI = & get_instance();
        $CI->load->database();

        $setting = $CI->db->get('tbl_pengaturan')->row();
        $gambar1 = base_url('assets/theme/admin-lte-3/dist/img/logo-header-es.png');

        $this->Ln(0.25);
        $this->SetFont('Arial', 'B', '7');
        $this->SetTextColor(0,146,63,255);
        $this->Cell(5, .5, '', '', 0, 'L', FALSE);
        $this->MultiCell(4.5, .5, $setting->judul, '0', 'L');
        $this->Ln(0.5);

        // Gambar Logo Atas 1
        $this->Image($gambar1, 1, 0.25, 5, 1.3);
    }
}
