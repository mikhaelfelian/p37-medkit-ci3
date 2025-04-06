<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
require_once APPPATH.'third_party/Fpdf/fpdf.php';

/**
 * Description of Pdf
 *
 * @author Mikhael Felian Waskito - mikhaelfelian@gmail.com
 * @modified by Mikhael Felian Waskito - mikhaelfelian@gmail.com
 * @date 2025-03-24
 */
class MedLblPDF extends FPDF {
    private $nm_dokter;
    private $no_sip;

    // Store doctor info as class properties
    public function setDoctorInfo($dokter, $no_sip) {
        $this->nm_dokter = $dokter;
        $this->no_sip = $no_sip;
    }

    // public function Header() {
    //     $CI = & get_instance();
    //     $CI->load->database();

    //     $setting = $CI->db->get('tbl_pengaturan')->row();
    //     $gambar1 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-header-es1.png';
    //     $gambar2 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-header-es2.png';
    //     $gambar3 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-header-es3.png';
    //     $gambar4 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-header-es4.png';

    //     $this->Ln(0.75);
    //     $this->SetFont('Arial', 'B', '12');
    //     $this->SetTextColor(0,146,63,255);
    //     $this->Cell(11.5, .5, '', '', 0, 'L', FALSE);
    //     $this->Cell(4, .5, $setting->judul, '', 0, 'L', FALSE);
    //     $this->Ln(0.5);
    //     $this->SetFont('Courier', 'B', '14');
    //     $this->Cell(2.75, .5, '', '', 0, 'L', FALSE);
    //     $this->Cell(16.25, .5, '', '', 0, 'L', FALSE);
    //     $this->Ln(2);

    //     // Gambar Logo Atas 1
    //     if(file_exists($gambar1)) {
    //         $this->Image($gambar1, 1, 1, 3.80, 1.80);
    //     }
    //     // Gambar Logo Atas 2
    //     if(file_exists($gambar2)) {
    //         $this->Image($gambar2, 5.20, 1, 2.2, 1.80);
    //     }
    //     // Gambar Logo Atas 3
    //     if(file_exists($gambar3)) {
    //         $this->Image($gambar3, 7.80, 1, 1.5, 1.80);
    //     }
    //     // Gambar Logo Atas 4
    //     if(file_exists($gambar4)) {
    //         $this->Image($gambar4, 9.80, 1, 2.25, 1.80);
    //     }
    // }
}
