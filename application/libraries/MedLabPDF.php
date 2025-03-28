<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php

require(APPPATH . '/libraries/fpdf.php');

/**
 * Description of Pdf
 *
 * @author mike
 */
class MedLabPDF extends FPDF {

    private $nm_dokter;
    private $no_sip;

    public function header($dokter, $no_sip) {
        $CI = & get_instance();
        $CI->load->database();

        $setting = $CI->db->get('tbl_pengaturan')->row();
//        $gambar1 = base_url('assets/theme/admin-lte-3/dist/img/logo-header-es.png');
        $gambar1 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-header-es.png';

        $this->Ln(0.25);
        $this->SetFont('Arial', 'B', '12');
        $this->SetTextColor(0,146,63,255);
        $this->Cell(10.5, .5, '', '', 0, 'L', FALSE);
        $this->Cell(8.5, .5, 'INSTALASI LABORATORIUM', '', 0, 'L', FALSE);
        $this->Ln(0.5);
        $this->SetFont('Courier', 'B', '14');
        $this->Ln(1.5);

        // Gambar Logo Atas 1
        $this->Image($gambar1, 1, 0.25, 10, 2.3);
    }

    public function footer($dokter, $no_sip) {
        $gambar3 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-footer.png'; // base_url('assets/theme/admin-lte-3/dist/img/logo-footer.png');

        // Gambar Watermark Bawah
        $this->Image($gambar3, 0, 25.75, 21.5, 7, 'png');
    }
}
