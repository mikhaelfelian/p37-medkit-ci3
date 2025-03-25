<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'third_party/Fpdf/fpdf.php';

/**
 * Description of Pdf
 *
 * @author mike
 */
class MedPDF extends FPDF {

    private $nm_dokter;
    private $no_sip;

    /**
     * Safely adds an image to the PDF, skipping if the file doesn't exist
     * @param string $file Path to the image file
     * @param float $x Abscissa of the upper-left corner
     * @param float $y Ordinate of the upper-left corner
     * @param float $w Width of the image in the page
     * @param float $h Height of the image in the page
     * @param string $type Image format
     * @param string $link URL or identifier returned by AddLink()
     */
    public function safeImage($file, $x = null, $y = null, $w = 0, $h = 0, $type = '', $link = '') {
        if (file_exists($file)) {
            $this->Image($file, $x, $y, $w, $h, $type, $link);
        }
    }

    public function customHeader($dokter, $no_sip) {
        $CI = & get_instance();
        $CI->load->database();

        $setting = $CI->db->get('tbl_pengaturan')->row();
//        $gambar1 = base_url('assets/theme/admin-lte-3/dist/img/logo-header-es.png');
        $gambar1 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-header-es.png';

        $this->Ln(0.25);
        $this->SetFont('Arial', 'B', '12');
        $this->SetTextColor(0,146,63,255);
        $this->Cell(10.5, .5, '', '', 0, 'L', FALSE);
        $this->MultiCell(8.5, .5, $setting->judul, '0', 'L');
        $this->Ln(0.5);
        $this->SetFont('Courier', 'B', '14');
        $this->Ln(1.5);

        // Gambar Logo Atas 1
        $this->Image($gambar1, 1, 0.25, 10, 2.3);
    }

    public function customFooter($dokter, $no_sip) {
        $gambar3 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-footer.png'; // base_url('assets/theme/admin-lte-3/dist/img/logo-footer.png');

        // Gambar Watermark Bawah
        $this->Image($gambar3, 0, 25.75, 21.5, 7, 'png');
    }
}

