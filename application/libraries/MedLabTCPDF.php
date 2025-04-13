<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once 'vendor/tecnickcom/tcpdf/tcpdf.php';

class MedLabTCPDF extends TCPDF {
    public $judul;
    public $subjudul;
    // Page header
    public function Header() {
        $CI = & get_instance();
        $CI->load->database();

        $setting = $CI->db->get('tbl_pengaturan')->row();
        $gambar1 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-header-es.png';

        $this->SetY(1);
        $this->SetFont('Helvetica', 'B', '12');
        $this->SetTextColor(0,146,63); // Set font color to green (RGB: 0,146,63)
        $this->Cell(10.5, .5, '', '', 0, 'L', FALSE);
        $this->Cell(8.5, .5, 'INSTALASI LABORATORIUM', '', 0, 'L', FALSE);
        $this->Ln(1.5);

        // Gambar Logo Atas 1
        if(file_exists($gambar1)) {
            $this->Image($gambar1, 1, 0.25, 10, 2.3);
        }

        // Add title block
        $this->SetTextColor(0, 0, 0); // Set text color to black
        $this->SetFont('Helvetica', 'B', '13');
        $this->Cell(19, .5, $this->judul, (!empty($this->subjudul) ? 0 : 'B'), 1, 'C');
        $this->Ln(0);
        if(!empty($this->subjudul)) {
            $this->SetFont('Helvetica', 'BI', '13');
            $this->Cell(19, .5, $this->subjudul, 'B', 1, 'C');
        }

        // Add doctor information block
        $this->SetFont('Helvetica', 'B', '9');
        $this->Cell(9, .5, '', '0', 0, 'L', FALSE);
        $this->Cell(4, .5, 'Dokter Penanggung Jawab', '0', 0, 'L', FALSE);
        $this->Cell(.5, .5, ':', '0', 0, 'C', FALSE);
        $this->SetFont('Helvetica', 'B', '9');
        $this->Cell(5.5, .5, '1. dr. ANITA TRI HASTUTI, Sp.PK', '', 0, 'L', FALSE);
        $this->Ln();
        $this->Cell(9, .5, '', '0', 0, 'L', FALSE);
        $this->Cell(4, .5, '', '0', 0, 'L', FALSE);
        $this->Cell(.5, .5, '', '0', 0, 'C', FALSE);
        $this->Cell(5.5, .5, '2. dr. YENI JAMILAH, Sp.MK', '', 0, 'L', FALSE);
        
        // Add watermark image in center of page
        $gambar2 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-bw-bg2-1440px.png';
        
        // Check if watermark image exists
        if(file_exists($gambar2)) {
            // Get page dimensions
            $pageWidth = $this->getPageWidth();
            $pageHeight = $this->getPageHeight();
            
            // Calculate center position and use appropriate scaling
            $imageWidth = 15; // increased size in cm
            $imageHeight = 19; // increased size in cm
            $x = ($pageWidth - $imageWidth) / 2;
            $y = ($pageHeight - $imageHeight) / 2;
            
            // Add the image as watermark with appropriate transparency
            // Last parameter is opacity (0-100)
            $this->Image($gambar2, $x, $y, $imageWidth, $imageHeight, '', '', '', false, 300, '', false, false, 0);
            
            // Set image scale ratio for proper rendering
            $this->setImageScale(PDF_IMAGE_SCALE_RATIO);
        }

    }

    // Page footer
    public function Footer() {
        $gambar3 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-footer.png';

        // Position at bottom of page
        $this->SetY(-15);
        
        // Gambar Watermark Bawah
        if(file_exists($gambar3)) {
            // Calculate width of page
            $pageWidth = $this->getPageWidth();
            $pageHeight = $this->getPageHeight();
            
            // Position image at absolute bottom of page, centered
            $this->Image($gambar3, 0, $pageHeight-7, $pageWidth, 7, 'png');
        }
    }
} 