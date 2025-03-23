<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php

require(APPPATH . '/libraries/fpdf.php');

/**
 * Description of Pdf
 *
 * @author mike
 */
class MedNotaPDF extends FPDF {

    private $nm_dokter;
    private $no_sip;

    public function header($dokter, $no_sip) {
        $CI =& get_instance();
        $CI->load->database();
        
        $setting = $CI->db->get('tbl_pengaturan')->row();
        $gambar1 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-header-es1.png';

//        if ($this->header == 1) {
            $this->Ln(1);
            $this->SetFont('Courier', 'B', '14');
            $this->Cell(2.5, .5, '', '', 0, 'L', FALSE);
            $this->Cell(16.5, .5, $setting->judul, '', 0, 'C', FALSE);
            $this->Ln(0.5);
            $this->SetFont('Courier', 'B', '10');
            $this->Cell(2.5, .5, '', 'B', 0, 'L', FALSE);
            $this->Cell(16.5, .5, $setting->alamat, 'B', 0, 'C', FALSE);
            $this->Ln(1);

            // Gambar Logo Atas
            $this->Image($gambar1, 1, 0.85, 2.40, 2);
//        }
    }

    public function footer($dokter, $no_sip) {
        $gambar3 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-footer.png';

//        $this->SetY(-7);
//        $this->Cell(4, .5, 'No. SIP', 'B', 0, 'L', FALSE);
        // Gambar Watermark Bawah
        $this->Image($gambar3, 0, 22.75, 21, 7, 'png');
    }

//    public function getInstance() {
//        return new MedPDF('P', 'cm', 'a4');
//    }
}
