<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php

require(APPPATH . '/third_party/Fpdf/fpdf.php');

/**
 * Description of Pdf
 *
 * @author mike
 */
class MedLblPDF extends FPDF {

//    private $nm_dokter;
//
//    private $no_sip;
//
//    public function header($dokter, $no_sip) {
//        $CI = & get_instance();
//        $CI->load->database();
//
//        $setting = $CI->db->get('tbl_pengaturan')->row();
//        $gambar1 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-header-es1.png';
//        $gambar2 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-header-es2.png';
//        $gambar3 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-header-es3.png';
//        $gambar4 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-header-es4.png';
//
//        $this->Ln(0.75);
//        $this->SetFont('Arial', 'B', '12');
//        $this->SetTextColor(0,146,63,255);
//        $this->Cell(11.5, .5, '', '', 0, 'L', FALSE);
//        $this->Cell(4, .5, $setting->judul, '', 0, 'L', FALSE);
//        $this->Ln(0.5);
//        $this->SetFont('Courier', 'B', '14');
//        $this->Cell(2.75, .5, '', '', 0, 'L', FALSE);
//        $this->Cell(16.25, .5, '', '', 0, 'L', FALSE);
////        $this->Ln(0.25);
////        $this->SetFont('Courier', 'B', '10');
////        $this->Cell(2.75, .5, '', 'B', 0, 'L', FALSE);
////        $this->Cell(16.25, .5, '', 'B', 0, 'L', FALSE);
//        $this->Ln(2);
//
//        // Gambar Logo Atas 1
//        $this->Image($gambar1, 1, 1, 3.80, 1.80);
//        // Gambar Logo Atas 2
//        $this->Image($gambar2, 5.20, 1, 2.2, 1.80);
//        // Gambar Logo Atas 3
//        $this->Image($gambar3, 7.80, 1, 1.5, 1.80);
//        // Gambar Logo Atas 4
//        $this->Image($gambar4, 9.80, 1, 2.25, 1.80);
//    }
//    
//    public function footer($dokter, $no_sip) {
//        $gambar3 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-footer.png';
//
//        // Gambar Watermark Bawah
//        $this->Image($gambar3, 0, 26, 22, 7, 'png');
//    }
}

