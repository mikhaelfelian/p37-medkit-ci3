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
class MedPDFdm extends FPDF {
    private $nm_dokter;
    private $no_sip;

    // Store doctor info as class properties
    public function setDoctorInfo($dokter, $no_sip) {
        $this->nm_dokter = $dokter;
        $this->no_sip = $no_sip;
    }

    public function Header() {
        $CI = & get_instance();
        $CI->load->database();

        $setting = $CI->db->get('tbl_pengaturan')->row();
        $gambar1 = FCPATH.'/assets/theme/admin-lte-3/dist/img/kop_es_bw_197x234.png';

        // Logo
        if(file_exists($gambar1)) {
            $this->Image($gambar1, 0.75, 0.25, 2, 2.5); // Adjusted size and position for the logo
        }

        // Clinic Name
        $this->SetFont('Times', 'B', 14);
        $this->SetTextColor(0, 150, 0); // Green color
        $this->Cell(2, 0.7, '', 0, 0); // Space after logo
        $this->MultiCell(8, 0.7, $setting->judul, '', 'C');

        // Address
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0, 0, 0); // Black color
        $this->Cell(2, 0.5, '', 0, 0); // Space after logo
        $this->Cell(9, 0.5, $setting->alamat, 0, 1, 'L');

        // Contact Info
        $this->Cell(2, 0.5, '', 'B', 0); // Space after logo
        $this->Cell(9, 0.5, $setting->tlp, 'B', 1, 'L');
    }

    public function Footer() {
        $gambar3 = FCPATH.'/assets/theme/admin-lte-3/dist/img/logo-footer.png';

        // Gambar Watermark Bawah
        if(file_exists($gambar3)) {
            $this->Image($gambar3, 0, 25.75, 21.5, 7, 'png');
        }
    }
}
